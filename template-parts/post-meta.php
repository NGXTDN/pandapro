<?php 
    $panda_option = get_option('panda_option');
    $category = get_the_category();
    $meta_layout = $panda_option['meta_layout'];
?>

<div class="meta d-flex align-items-center text-xs text-muted">
    <div>
        <time class="d-inline-block"><?php pandapro_the_time(); ?></time>
    </div>
    <div class="ml-auto text-sm">
        <span class="mx-1"><i class="text-md iconfont icon-eye-line mx-1"></i><small><?php pandapro_post_views('',''); ?></small></span>
        <?php if (comments_open()): ?>
            <a class="mx-1" href="#comments"><i class="text-md iconfont icon-chat--line mx-1"></i><small><?php echo $post->comment_count; ?></small></a>
        <?php endif; ?>
        <?php $is_liked = isset($_COOKIE['suxing_ding_'.$post->ID]); ?>
        <a class="btn-like btn-link-like <?php if ($is_liked) echo 'current'; ?> mx-1"
            href="javascript:;"
            data-action="<?php echo $is_liked ? 'unlike' : 'like' ?>" data-id="<?php the_ID(); ?>"
        ><i class="text-md iconfont icon-thumb-up-line mx-1"></i><small class="like-count"><?php echo pandapro_get_hearts(get_the_ID()) ?></small></a>
    </div>
</div>