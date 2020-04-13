<?php $date = get_the_date('Y.m.d') ?>
<?php $prev_date = get_option('panda_newscat_prev_date') ?>
<?php if ($prev_date !== $date): ?>
    <?php update_option('panda_newscat_prev_date', $date) ?>
    <div class="list-news-item active">
        <div class="list-news-dot"></div>
        <div class="list-news-body">
            <div class="list-news-date font-theme text-lg text-primary"><?php the_date('Y.m.d') ?></div>
        </div>
    </div>
<?php endif; ?>
<div class="list-news-item">
    <div class="list-news-dot"></div>
    <div class="list-news-body">
        <div class="list-news-date font-theme text-primary text-sm"><?php the_time('H:i') ?></div>
        <div class="list-news-content">
            <div class="text-md my-2"><a href="<?php the_permalink() ?>" target="_blank"><?php the_title() ?></a></div>
            <div class="text-sm text-muted"><?php pandapro_print_excerpt(80) ?></div>
        </div>
    </div>
</div>