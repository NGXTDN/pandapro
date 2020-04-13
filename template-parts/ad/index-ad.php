<?php $panda_option = get_option('panda_option'); ?>
<?php $ad = $panda_option['index_ad']; ?>
<?php if (!empty($ad['type'] && $ad['type'] != 'closed')): ?>
    <section class="list-sales mt-4 d-none d-lg-block">
        <?php if ($ad['type'] == 'code'): ?>
            <?php echo $ad['code_pc'] ?>
        <?php else: ?>
            <a href="<?php echo esc_url($ad['link']); ?>" target="_blank"><img src="<?php echo wp_get_attachment_image_url($ad['image_pc'], 'full'); ?>"></a>
        <?php endif; ?>
    </section>
    <section class="list-sales mt-4 d-lg-none">
        <?php if ($ad['type'] == 'code'): ?>
            <?php echo $ad['code_mobile'] ?>
        <?php else: ?>
                <a href="<?php echo esc_url($ad['link']); ?>" target="_blank"><img src="<?php echo wp_get_attachment_image_url($ad['image_mobile'], 'full'); ?>"></a>
        <?php endif; ?>
    </section>
<?php endif; ?>