<?php 
    $panda_option = get_option('panda_option');
    $bigger_cover = get_field('api_generation_poster', 'options');
?>
<?php if ($bigger_cover == 1): ?>
    <a href="javascript:;" class="btn-bigger-cover mx-1 " id="btn-bigger-cover" data-id="<?php the_ID(); ?>"><span><i class="text-xl iconfont icon-article-fill"></i></span></a>
<?php endif; ?>