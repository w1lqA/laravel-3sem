<?php $__env->startComponent('mail::message'); ?>
# 📊 Статистика сайта за <?php echo new \Illuminate\Support\EncodedHtmlString($stats['date']); ?>


Привет! Вот как сегодня жил наш блог:

## 📈 Что интересного произошло

<?php $__env->startComponent('mail::panel'); ?>
**🔥 Самые горячие цифры дня:**

• **Просмотры статей:** <?php echo new \Illuminate\Support\EncodedHtmlString($stats['views_today']); ?> раз сегодня
• **Новые комментарии:** <?php echo new \Illuminate\Support\EncodedHtmlString($stats['new_comments_today']); ?> (<?php echo new \Illuminate\Support\EncodedHtmlString($stats['new_comments_approved']); ?> уже одобрено)
• **Ждут проверки:** <?php echo new \Illuminate\Support\EncodedHtmlString($stats['pending_comments']); ?> комментариев
• **Всего на сайте:** <?php echo new \Illuminate\Support\EncodedHtmlString($stats['total_articles']); ?> статей и <?php echo new \Illuminate\Support\EncodedHtmlString($stats['total_comments']); ?> комментариев
<?php echo $__env->renderComponent(); ?>

## 🏆 Топ-5 статей сегодня

<?php $__env->startComponent('mail::table'); ?>
| Статья | Просмотров |
|--------|------------|
<?php $__empty_1 = true; $__currentLoopData = $stats['top_articles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
| <?php echo new \Illuminate\Support\EncodedHtmlString($item->title ?? 'Статья удалена'); ?> | <?php echo new \Illuminate\Support\EncodedHtmlString($item->views); ?> |
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
| Сегодня пока никто ничего не читал 😴 |
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('mail::button', ['url' => route('comments.index', ['filter' => 'pending']), 'color' => 'primary']); ?>
👀 Проверить комментарии в очереди
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('mail::button', ['url' => route('articles.index'), 'color' => 'success']); ?>
📚 Все статьи блога
<?php echo $__env->renderComponent(); ?>

---

**P.S.** Спасибо, что следишь за порядком! Без тебя этот блог бы давно захлестнули спамеры и тролли 😅

С уважением,  
Робот-статистик вашего блога 🤖

<?php echo $__env->renderComponent(); ?><?php /**PATH /var/www/html/resources/views/emails/stats/daily.blade.php ENDPATH**/ ?>