<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        // Читаем JSON файл из public
        $jsonPath = public_path('data/articles.json');
        $articles = json_decode(file_get_contents($jsonPath), true);
        
        // Проверяем на ошибки чтения
        if ($articles === null) {
            $articles = [];
        }
        
        return view('home', ['articles' => $articles]);
    }
    
    public function gallery($imageName)
    {
        // Проверяем существование файла
        $imagePath = public_path('data/' . $imageName);
        
        if (!file_exists($imagePath)) {
            abort(404, 'Изображение не найдено');
        }
        
        return view('gallery', ['imageName' => $imageName]);
    }
}