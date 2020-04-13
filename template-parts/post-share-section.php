<?php
    $s = new MiShare();
    $panda_option = get_option('panda_option');
    $share_channel = $panda_option['share_channel'];
    $likes_count = pandapro_get_hearts(get_the_ID());
    $bigger_cover = get_field('api_generation_poster', 'options');
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
<?php $is_liked = isset($_COOKIE['suxing_ding_'.$post->ID]); ?>
<div id="post-share-section" class="d-flex align-items-center justify-content-between justify-content-md-start text-center text-md-left py-2">
    <a href="javascript:;"
        class="<?php if ($is_liked) echo 'current'; ?> btn-like btn-link-like mr-md-4"
        data-action="<?php echo $is_liked ? 'unlike' : 'like' ?>" data-id="<?php the_ID(); ?>"
        >
        <i class="text-xl iconfont icon-thumb-up-line mx-1"></i><small class="font-theme like-count text-md"><?php echo $likes_count; ?></small>
    </a>
    <a href="#comments" class="mr-md-4"><i class="text-xl iconfont icon-message--line"></i> <small class="font-theme text-md"><?php echo get_comments_number(get_the_ID()) ?></small></a>
    <?php if ($panda_option['default_donate_image']): ?>
        <a href="javascript:;" class="plus-power-popup mr-md-4"><i class="text-xl iconfont icon-exchange-dollar-fill"></i></a>
        <?php get_template_part_with_vars('template-parts/popup/plus-power-popup', array('id' => get_the_author_meta('ID'))) ?>
    <?php endif; ?>
    <?php if ($bigger_cover == 1): ?>
        <a href="javascript:;" class="btn-bigger-cover" id="btn-bigger-cover" data-id="<?php the_ID(); ?>"><span><i class="text-xl iconfont icon-article-line"></i></span></a>
    <?php endif; ?>

    <?php if ($share_channel == 'all' || $share_channel == 'domestic' || $share_channel == 'abroad'): ?>
        <div class="d-none d-md-flex flex-md-fill"></div>
        <div class="content-share">
            <a href="javascript:;" role="button" class="link-post-share mx-2">
                <i class="text-xl iconfont icon-share-box-fill"></i>
                <i class="text-xl iconfont icon-close-fill"></i>
            </a>
            <div class="nice-dropdown">
                <div class="dropdown-inner">
                    <div class="row no-gutters">
                        <?php if ($share_channel == 'all' || $share_channel == 'domestic'): ?>
                            <div class="col">
                                <a href="<?php echo $s->weibo() ?>" target="_blank" class="item-share weibo ">
                                    <span><i class="text-lg iconfont icon-weibo-fill"></i></span>
                                </a>
                            </div>
                            <div class="col">
                                <a href="javascript:" class="item-share weixin single-popup" data-img="<?php echo $s->weixin() ?>" data-title="微信扫一扫 分享朋友圈" data-desc="在微信中请长按二维码">
                                    <span><i class="text-lg iconfont icon-wechat-fill"></i></span>
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?php echo $s->qq() ?>" target="_blank" class="item-share qq">
                                    <span><i class="text-lg iconfont icon-qq-fill"></i></span>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php if ($share_channel == 'all' || $share_channel == 'abroad'): ?>
                            <div class="col">
                                <a href="<?php echo $s->facebook() ?>" target="_blank" class="item-share facebook ">
                                    <span><i class="text-lg iconfont icon-facebook"></i></span>
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?php echo $s->twitter() ?>" target="_blank" class="item-share twitter">
                                    <span><i class="text-lg iconfont icon-twitter"></i></span>
                                </a>
                            </div>
                            <div class="col">
                                <a href="<?php echo $s->linkedin() ?>" target="_blank" class="item-share linkedin">
                                    <span><i class="text-lg iconfont icon-linkedin"></i></span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php get_template_part('/template-parts/apollo-postlike-section') ?>