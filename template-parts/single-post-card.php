<?php $template_params = isset($template_params) ? $template_params : array() ?>
<?php $category = get_the_category(); ?>
<?php $type_text = $template_params['type'] === 'history_post' ? __('That day', 'pandapro') : __('Random Post', 'pandapro') ?>
<div class="list-rounded">
    <div class="list-item list-overlay-content">
        <div class="media">
            <a class="media-content" href="<?php the_permalink() ?>" target="_blank" style="background-image:url('<?php echo pandapro_the_thumbnail(null, array('w' => 400, 'h' => 400)) ?>')"><span class="overlay"></span></a>
            <div class="media-overlay overlay-top p-4">
                    <div class="d-flex flex-column font-theme text-center">
                        <span class="d-block display-4 text-white font-height-xs"><?php the_time('d') ?></span>
                        <time class="d-block text-xs"><?php the_time('M, Y') ?> </time>
                    </div>
            </div>
        </div>
        <div class="list-content p-4">
            <div class="list-body">
                <a href="<?php the_permalink() ?>" target="_blank" class="list-title text-md h-2x"><?php the_title() ?></a>
            </div>
            <div class="list-footer mt-3">
                <div class="d-flex flex-fill align-items-center text-muted text-xs">
                    <div><span class="badge badge-primary"><?php echo $type_text ?></span></div>
                    <div class="flex-fill"></div>
                    <?php if ($template_params['type'] === 'random_post'): ?>
                    <div><a href="javascript:" <?php echo isset($template_params['author']) && is_numeric($template_params['author']) ? 'data-id="'.$template_params['author'].'"' : '' ?> class="refresh-random-post text-white"><i class="text-lg iconfont icon-refresh-line"></i></a></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>