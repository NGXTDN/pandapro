<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Panda PRO
 */
$panda_option = get_option('panda_option');
$ajax_loading = $panda_option['index_ajax_loading'];
$banner_switch = $panda_option['index_featured_switch'];
$banner = $panda_option['index_featured'];
get_header();
?>

	<?php if (!empty($banner_switch) && $banner_switch && $banner !== 'banner-style-3') get_template_part('template-parts/banner-section'); ?>

	<main class="py-3 <?php if ( empty($banner_switch) || $banner == 'banner-style-3' ): ?> py-md-5 <?php else: ?> pt-md-4 pb-md-5<?php endif; ?>">
        <div class="container">
			<div class="row" style="transform: none;">
				<?php if ( have_posts() ): ?>
					<div class="col-lg-8">
						<?php if (!empty($banner_switch) && $banner_switch && $banner === 'banner-style-3') get_template_part('template-parts/banner-section'); ?>
						<?php get_template_part('template-parts/list-ajax-nav'); ?>
						<div class="list-home list-grid list-grid-padding">
							<?php while ( have_posts() ) : the_post(); ?>
								<?php get_template_part('/template-parts/post-cards/card', get_post_format()) ?>
							<?php endwhile; ?>
						</div>
						<?php
							get_template_part_with_vars('template-parts/post-navigation', array(
								'ajax_loading' => $ajax_loading,
								'page' => 'home',
								'query' => '',
								'append' => 'list-home'
							));
						?>
						<?php get_template_part('template-parts/ad/index-ad'); ?>
					</div>
					<?php get_sidebar(); ?>
				<?php else: ?>
					<div class="col-12 h-v-75">
						<div class="content-error text-center py-5 ">
							<div class="d-inline-block w"> <?php get_template_part('template-parts/svg/404-svg'); ?></div>
							<h4 class="py-4"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'pandapro' ); ?></h4>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</main>

<?php
get_footer();
