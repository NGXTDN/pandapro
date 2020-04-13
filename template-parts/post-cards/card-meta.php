<?php $panda_option = get_option('panda_option'); ?>
<?php $category = get_the_category(); $meta_layout = $panda_option['meta_layout']; ?>
<div class="d-flex flex-fill align-items-center text-muted text-xs">
    <div class="d-none d-md-inline-block"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" target="_blank" class="flex-avatar w-20 "><?php echo get_avatar( $post->post_author, 20, '', '', array('class' => 'w-20') ); ?></a></div>
    <div class="d-inline-block ml-md-2"><?php the_author_posts_link(); ?></div>
    <div class="d-inline-block mx-1 mx-md-2"><i class="text-primary">&#8212;</i></div>
    <div class="d-inline-block">
        <a href="<?php echo get_category_link($category[0]); ?>" target="_blank"><?php echo $category[0]->cat_name ?></a>
    </div>
    <div class="flex-fill"></div>
    <?php if ($meta_layout !== 'closed'): ?>
    <div>
        <?php if ($meta_layout === 'time'): ?>
            <time class="mx-1"><?php pandapro_the_time() ?></time>
        <?php endif; ?>
        <?php if ($meta_layout === 'view'): ?>
            <span class="mx-1">
                <i class="text-sm iconfont icon-eye-line mx-1"></i>
                <small><?php pandapro_post_views('',''); ?></small>
            </span>
        <?php endif; ?>
        <?php if ($meta_layout === 'comment'): ?>
            <span class="mx-1">
                <i class="text-sm iconfont icon-message--line"></i> <?php echo $post->comment_count; ?>
            </span>
        <?php endif; ?>
        <?php if ($meta_layout === 'like'): ?>
            <span class="mx-1">
                <i class="text-sm iconfont icon-thumb-up-line"></i> <?php echo pandapro_get_hearts(get_the_ID()) ?>
            </span>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>