<?php global $numpages; ?>
<?php if ($numpages > 1): ?>
    <nav class="post-in-navigation navigation pagination" role="navigation">
        <div class="nav-links">
            <?php pandapro_wp_link_pages(array(
                'before' => '<div class="font-theme">',
                'after' => '</div>',
                'pagelink' =>'%',
                'nextpagelink' => '<i class="iconfont icon-arrow-right-s-fill"></i>',
                'previouspagelink' => '<i class="iconfont icon-arrow-left-s-fill"></i>',
                'item_before_active' => '<span aria-current="page" class="post-page-numbers current">',
                'item_after_active' => '</span>'
            )); ?>
        </div>
    </nav>
<?php endif; ?>