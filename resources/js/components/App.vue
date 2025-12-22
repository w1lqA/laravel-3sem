<template>
    <div v-if="article" 
         class="fixed bottom-4 right-4 z-50 max-w-sm w-full animate-fade-in">
        <div class="bg-white border-2 border-pink-300 shadow-lg rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                        <span class="text-pink-600 font-bold">📢</span>
                    </div>
                </div>
                <div class="ml-3 flex-1">
                    <div class="font-bold text-gray-900 mb-1">
                        Новая статья!
                    </div>
                    <div class="text-gray-700 mb-2">
                        <a :href="`/articles/${article.slug}`" 
                           class="text-pink-600 hover:text-pink-800 font-medium">
                            {{ article.title }}
                        </a>
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ article.author }} • {{ formatTime(article.created_at) }}
                    </div>
                    <button @click="closeNotification" 
                            class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                        ✕
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            article: null,
            timeoutId: null
        }
    },

    created() {
        window.Echo.channel('articles')
            .listen('.ArticleCreated', (data) => {
                console.log('Получено событие о новой статье:', data);
                this.article = data.article;
                
                this.timeoutId = setTimeout(() => {
                    this.article = null;
                }, 10000);
            });
    },

    methods: {
        closeNotification() {
            this.article = null;
            if (this.timeoutId) {
                clearTimeout(this.timeoutId);
            }
        },

        formatTime(dateString) {
            const date = new Date(dateString);
            return date.toLocaleTimeString('ru-RU', { 
                hour: '2-digit', 
                minute: '2-digit' 
            });
        }
    }
}
</script>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}
</style>