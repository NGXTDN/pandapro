<?php $panda_option = get_option('panda_option') ?>
<?php $social_connect = $panda_option['social_connect'] ?>
<?php if (!empty($social_connect['qq']['title'])): ?>
    <a href="javascript:"
        data-img="<?php echo timthumb($social_connect['qq']['img']) ?>"
        data-title="<?php echo $social_connect['qq']['title'] ?>"
        data-desc="<?php echo $social_connect['qq']['desc'] ?>" 
        class="single-popup btn btn-secondary btn-qq btn-icon">
        <span><i class="text-lg iconfont icon-qq-fill"></i></span>
    </a>
<?php endif; ?>
<?php if (!empty($social_connect['weixin']['title'])): ?>
    <a href="javascript:"
        data-img="<?php echo timthumb($social_connect['weixin']['img']) ?>"
        data-title="<?php echo $social_connect['weixin']['title'] ?>"
        data-desc="<?php echo $social_connect['weixin']['desc'] ?>" 
        class="single-popup btn btn-secondary btn-weixin btn-icon">
        <span><i class="text-lg iconfont icon-wechat-fill"></i></span>
    </a>
<?php endif; ?>
<?php if (!empty($social_connect['weibo'])): ?>
    <a href="<?php echo $social_connect['weibo'] ?>" rel="nofollow" target="_blank" class="btn btn-secondary btn-weibo btn-icon">
        <span><i class="text-lg iconfont icon-weibo-fill"></i></span>
    </a>
<?php endif; ?>
<?php if (!empty($social_connect['facebook'])): ?>
    <a href="<?php echo $social_connect['facebook'] ?>" rel="nofollow" target="_blank" class="btn btn-secondary btn-facebook btn-icon">
        <span><i class="text-lg iconfont icon-facebook"></i></span>
    </a>
<?php endif; ?>
<?php if (!empty($social_connect['twitter'])): ?>
    <a href="<?php echo $social_connect['twitter'] ?>" rel="nofollow" target="_blank" class="btn btn-secondary btn-twitter btn-icon">
        <span><i class="text-lg iconfont icon-twitter"></i></span>
    </a>
<?php endif; ?>
<?php if (!empty($social_connect['instagram'])): ?>
    <a href="<?php echo $social_connect['instagram'] ?>" rel="nofollow" target="_blank" class="btn btn-secondary btn-ins btn-icon">
        <span><i class="text-lg iconfont icon-instagram-fill"></i></span>
    </a>
<?php endif; ?>
<?php if (!empty($social_connect['linkedin'])): ?>
    <a href="<?php echo $social_connect['linkedin'] ?>" rel="nofollow" target="_blank" class="btn btn-secondary btn-linkedin btn-icon">
        <span><i class="text-lg iconfont icon-linkedin"></i></span>
    </a>
<?php endif; ?>
<?php if (!empty($social_connect['email'])): ?>
    <a href="mailto:<?php echo $social_connect['email'] ?>" class="btn btn-secondary btn-mail btn-icon">
        <span><i class="text-lg iconfont icon-mail-fill"></i></span>
    </a>
<?php endif; ?>