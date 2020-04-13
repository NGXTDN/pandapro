<div class="list-item list-item-column block card-featured ">
    <div class="list-content p-0">
        <div class="list-body ">
            <a class="list-title text-lg h-2x mb-2 mb-md-3" title="<?php the_title() ?>" href="<?php the_permalink() ?>" target="_blank"><?php pandapro_the_sticky_tag(); pandapro_the_featured_tag(); ?><?php the_title() ?></a>
            <div class="mb-2 mb-md-3">
                <?php get_template_part("template-parts/post-cards/card-meta"); ?>
            </div>
        </div>
        <div class="media media-21x9 mb-md-3">
            <a class="media-content" title="<?php the_title() ?>" href="<?php the_permalink() ?>" target="_blank" style="background-image:url('<?php pandapro_the_thumbnail() ?>')"></a>
        </div>
        <div class="list-desc d-none d-md-block text-sm text-secondary">
            <div class="h-2x "><?php pandapro_print_excerpt(80) ?></div>
        </div>
    </div>
</div>