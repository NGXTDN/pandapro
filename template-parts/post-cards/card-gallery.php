<?php $thumbnails = pandapro_more_post_thumbnails() ?>
<div class="list-item list-item-column block">
    <div class="list-content p-0">
        <div class="list-body ">
            <a href="<?php the_permalink() ?>" title="<?php the_title() ?>" target="_blank" class="list-title text-lg h-2x mb-2 mb-md-3"><?php pandapro_the_sticky_tag(); pandapro_the_featured_tag(); ?><?php the_title() ?></a>
            <div class="mb-2 mb-md-3">
                <?php get_template_part("template-parts/post-cards/card-meta"); ?>
            </div>
        </div>
        <div class="row-xs mb-md-3">
            <?php foreach(array_slice($thumbnails, 0, 3) as $thumbnail): ?>
            <div class="col-4">
                <div class="media media-3x2">
                    <a class="media-content" title="<?php the_title() ?>" href="<?php the_permalink() ?>" target="_blank" style="background-image: url('<?php echo timthumb($thumbnail, array('w' => 300, 'h' => 200)) ?>');"></a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="list-desc d-none d-md-block text-sm text-secondary">
            <div class="h-2x"><?php pandapro_print_excerpt(80) ?></div>
        </div>
    </div>
</div>