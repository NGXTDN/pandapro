<?php
/**
 * The template for displaying archive pages
 *
 * @package Panda PRO
 */
get_header();
$tax = get_queried_object();
$args = array(
    'post_type' => 'news',
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
    'tax_query' => array(
        array(
            'taxonomy' => 'news-category',
            'terms'    =>  $tax->term_id,
        )
    )
);
$queryPosts = new WP_Query($args);
delete_option('panda_newscat_prev_date');
?>

<main class="py-4 py-md-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="list-cover">
                    <div class="list-item list-overlay-content">
                        <div class="media media-21x9">
                            <div class="media-content" 
                                style="background-image:url('<?php pandapro_the_newscat_cover($tax->term_id) ?>')"><div class="overlay"></div></div>
                        </div>
                        <div class="list-content">
                            <div class="list-body">
                                <div class="mt-auto p-md-3">
                                    <div class="h2 text-white mb-2"><?php echo $tax->name ?></div>
                                    <div class="text-sm text-light"><?php echo $tax->description ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <?php if ( $queryPosts->have_posts() ) : ?>
                    <div class="card-body">
                        <div class="list-news list-news-cat">
                                <?php while ( $queryPosts->have_posts() ): ?>
                                    <?php $queryPosts->the_post(); ?>
                                    <?php get_template_part('template-parts/news-category-loop') ?>
                                <?php endwhile; ?>
                        </div>
                        <?php
                            get_template_part_with_vars('template-parts/post-navigation', array(
                                'ajax_loading' => true,
                                'page' => 'news-category',
                                'query' => $tax->term_id,
                                'append' => 'list-news-cat'
                            ));
                        ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
			<?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php
get_footer();