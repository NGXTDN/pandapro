<?php $panda_option = get_option('panda_option'); ?>
<?php $banner = $panda_option['index_featured']; ?>
<?php global $paged ?>
<?php if (!empty($banner) && $banner !== 'close' && $paged < 2): ?>
    <?php get_template_part('template-parts/banner/'.$banner); ?>
<?php endif; ?>