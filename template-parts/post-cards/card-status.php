<?php global $post ?>
<div class="list-item block ">
    <div class="list-content p-0">
        <div class="list-body">
            <a href="<?php the_permalink() ?>" title="<?php the_title() ?>" class="list-title text-lg h-2x"><?php pandapro_the_sticky_tag(); pandapro_the_featured_tag(); ?><?php the_title() ?></a>
            <div class="list-meta mt-2 mt-md-3"><?php get_template_part("template-parts/post-cards/card-meta"); ?></div>
            <div class="list-desc text-sm text-secondary mt-2 mt-md-3">
                <div class="h-2x "><?php pandapro_print_excerpt(120) ?></div>
            </div>
        </div>
    </div>
</div>