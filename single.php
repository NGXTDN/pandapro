<?php
/**
 * The template for displaying all single posts#single-post
 *
 * @package Panda PRO
 */

get_header();
?>
    <?php while ( have_posts() ) : the_post() ?>
        <?php if ('post' == get_post_type()): ?>
            <?php get_template_part('template-parts/content/content', get_post_format()) ?>
        <?php else: ?>
            <?php get_template_part('template-parts/content/content-news') ?>
        <?php endif; ?>
    <?php endwhile; ?>
<?php
get_footer();
