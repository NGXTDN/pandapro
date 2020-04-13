<?php
/**
 * The template for displaying archive pages
 *
 * @package Panda PRO
 */

global $wp_query;

$panda_option = get_option('panda_option');

$tpage = 'search';
$query = $wp_query->query['s'];

$ajax_loading = $panda_option['archive_ajax_loading'];

get_header();
?>

<main class="py-4 py-md-5">
    <div class="container">
        <?php pandapro_breadcrumbs() ?>
        <div class="row">
			<div class="col-lg-8">
                <div class="list-header mb-3">
                    <div class="h4">
                        <?php _e( 'Search: ', 'cosy19' ); ?><span><?php echo get_search_query(); ?></span>
                    </div>
                </div>

				<?php if ( have_posts() ) : ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<div class="list-search list-grid list-grid-padding">
								<?php get_template_part("template-parts/post-cards/card", get_post_format()); ?>
							</div>
						<?php endwhile; ?>
						<?php
							get_template_part_with_vars('template-parts/post-navigation', array(
								'ajax_loading' => $ajax_loading,
								'page' => $tpage,
								'query' => $query,
								'append' => 'list-search'
							));
						?>
				<?php else : ?>
						<div class="content-error text-center h-v-75 py-5">
							<div class="d-inline-block w-sm"> <?php get_template_part('template-parts/svg/404-svg'); ?></div>
							<p class="text-lg text-muted mt-5"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'pandapro' ); ?></p>
						</div>
				<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
        </div>
    </div>
</main>

<?php
get_footer();