<?php $template_params = isset($template_params) ? $template_params : array() ?>
<?php
    $panda_option = get_option('panda_option');
    $donate_image = get_user_meta($template_params['id'], 'donate_image', true);
    $donate_image = empty($donate_image) ? $panda_option['default_donate_image'] : $donate_image;
?>
<div id="plus-power-popup-wrap">
    <div class="popup-inner">
        <div class="content p-4">
            <div class="plus-power-tabcontent">
                <div class="item-qrcode">
                    <img src="<?php echo timthumb($donate_image, array('w' => 300, 'h' => 300)) ?>" alt="<?php the_author_meta('display_name') ?>">
                </div>
            </div>
        </div>
    </div>
</div>
