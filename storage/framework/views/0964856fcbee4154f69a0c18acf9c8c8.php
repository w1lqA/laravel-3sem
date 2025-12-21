<?php $__env->startComponent('mail::message'); ?>
# Новая статья на сайте <?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>


**Заголовок:** <?php echo new \Illuminate\Support\EncodedHtmlString($article->title); ?>


**Автор:** <?php echo new \Illuminate\Support\EncodedHtmlString($article->user ? $article->user->name : 'Неизвестный автор'); ?>


**Краткое описание:**
<?php echo new \Illuminate\Support\EncodedHtmlString($article->short_desc ?? 'Без описания'); ?>


**Дата создания:** <?php echo new \Illuminate\Support\EncodedHtmlString($article->created_at->format('d.m.Y H:i')); ?>


<?php $__env->startComponent('mail::button', ['url' => route('articles.show', $article->slug)]); ?>
Перейти к статье
<?php echo $__env->renderComponent(); ?>

С уважением,<br>
<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/html/resources/views/emails/articles/new.blade.php ENDPATH**/ ?>