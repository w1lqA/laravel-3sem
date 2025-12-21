<?php
/** ./sail.bat php artisan app:test-cache */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Models\Article;

class TestCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Redis cache functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Testing Redis Cache ===');
        
        // 1. Очищаем старые тестовые ключи
        Cache::forget('test_cache_key');
        Cache::forget('articles.perf_test.0');
        Cache::forget('articles.perf_test.1');
        Cache::forget('articles.perf_test.2');
        
        // 2. Basic cache test
        Cache::put('test_cache_key', 'test_value', 60);
        $value = Cache::get('test_cache_key');
        $this->info('Basic cache test: ' . ($value === 'test_value' ? 'PASSED' : 'FAILED'));
        
        // 3. Articles cache performance test
        $times = [];
        for ($i = 0; $i < 3; $i++) {
            $start = microtime(true);
            $count = Cache::remember("articles.perf_test.{$i}", 30, function() {
                return Article::count();
            });
            $times[] = microtime(true) - $start;
            $this->info("Request {$i}: " . round($times[$i] * 1000, 2) . "ms, Count: {$count}");
        }
        
        $this->info("\nPerformance summary:");
        $this->info("First request:  " . round($times[0] * 1000, 2) . "ms (database query)");
        $this->info("Second request: " . round($times[1] * 1000, 2) . "ms (from cache)");
        $this->info("Third request:  " . round($times[2] * 1000, 2) . "ms (from cache)");
        
        // 4. Check if cache is working by comparing times
        if ($times[1] < $times[0] * 0.3 && $times[2] < $times[0] * 0.3) {
            $this->info("\n✅ CACHE IS WORKING PERFECTLY!");
            $this->info("Cache speedup: " . round($times[0] / $times[1], 1) . "x faster");
        } else {
            $this->error("\n❌ CACHE MIGHT NOT BE WORKING PROPERLY");
            $this->info("Check your .env: CACHE_DRIVER should be 'redis'");
        }
        
        // 5. Test your actual article caching from controller
        $this->info("\n=== Testing ArticleController Cache ===");
        
        // Clear article cache
        Cache::forget('articles.all.1');
        
        // First access (should be from DB)
        $start = microtime(true);
        $cacheKey = 'articles.all.1';
        $articles = Cache::remember($cacheKey, 60, function() {
            return Article::latest()->paginate(6);
        });
        $time1 = microtime(true) - $start;
        $this->info("First articles page load: " . round($time1 * 1000, 2) . "ms");
        
        // Second access (should be from cache)
        $start = microtime(true);
        $articles = Cache::remember($cacheKey, 60, function() {
            return Article::latest()->paginate(6);
        });
        $time2 = microtime(true) - $start;
        $this->info("Second articles page load: " . round($time2 * 1000, 2) . "ms");
        
        if ($time2 < $time1 * 0.5) {
            $this->info("✅ ArticleController cache is working!");
        }
        
        // 6. Проверка конфигурации
        $this->info("\n=== Configuration Check ===");
        $this->info("CACHE_DRIVER: " . config('cache.default'));
        $this->info("QUEUE_CONNECTION: " . config('queue.default'));
        
        $this->info('\n=== Test completed ===');
    }
}