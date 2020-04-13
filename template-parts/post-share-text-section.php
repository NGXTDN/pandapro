<?php 
    $s = new MiShare();
    $panda_option = get_option('panda_option');
    $share_channel = $panda_option['share_channel'];

    global $post;

    $url = get_the_permalink(get_the_ID());
    $title = get_the_title();
    $image = pandapro_post_thumbnail_src();
    $description = pandapro_print_excerpt(150, $post, false);

    $s->config = array(
        'url' => $url,
        'title' => $title,
        'des'   => $description
    );
?>

<div class="content-share mt-4">
    <span class="badge badge-primary mr-2"><?php _e('Share', 'pandapro') ?></span>
    <?php if ($share_channel == 'all' || $share_channel == 'domestic'): ?>
        <a href="<?php echo $s->weibo() ?>" target="_blank" class="weibo mx-1 mx-md-2">
            <span><i class="text-md iconfont icon-weibo-fill"></i></span>
        </a>
        <a href="javascript:" class="weixin single-popup mx-1 mx-md-2" data-img="<?php echo $s->weixin() ?>" data-title="<?php _e('Scan QR code', 'pandapro') ?>" data-desc="<?php _e('Long press the QR code to share something on moments', 'pandapro') ?>">
            <span><i class="text-md iconfont icon-wechat-fill"></i></span>
        </a>
        <a href="<?php echo $s->qq() ?>" target="_blank" class="qq mx-1 mx-md-2">
            <span><i class="text-md iconfont icon-qq-fill"></i></span>
        </a>
    <?php endif; ?>
    <?php if ($share_channel == 'all' || $share_channel == 'abroad'): ?>
        <a href="<?php echo $s->facebook() ?>" target="_blank" class="facebook mx-1 mx-md-2"><span><i class="text-md iconfont icon-facebook"></span></i></a>
        <a href="<?php echo $s->twitter() ?>" target="_blank" class="twitter mx-1 mx-md-2"><span><i class="text-md iconfont icon-twitter"></span></i></a>
        <a href="<?php echo $s->linkedin() ?>" target="_blank" class="linkedin mx-1 mx-md-2"><span><i class="text-md iconfont icon-linkedin"></span></i></a>
    <?php endif; ?>
</div>