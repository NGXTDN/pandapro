<?php
/**
 * The template for displaying archive pages
 *
 * @package Panda PRO
 */

global $wp_query;

$panda_option = get_option('panda_option');

if (is_category() || is_archive() && !is_author()) {
	$tpage = 'cat';
	$query = $cat;
}


if (is_tax('special')) {
	$tpage = 'tax';
	$query = $wp_query->queried_object->term_id;
}
if (is_tag()) {
	$tpage = 'tag';
	$query = $wp_query->queried_object->name;
}
$ajax_loading = $panda_option['archive_ajax_loading'];

get_header();
?>
<main class="py-4 py-md-5">
    <div class="container">
        <?php pandapro_breadcrumbs() ?>
        <div class="row">
			<div class="col-lg-8">
				<?php if ( have_posts() ) : ?>
					<?php if (is_category() || is_tax()) : ?>
						<?php $category = get_queried_object() ?>
						<div class="list-cover list-rounded mb-3 mb-md-4">
							<div class="list-item list-overlay-content overlay-hover bg-dark">
								<div class="media media-21x9">
									<div class="media-content" style="background-image:url('<?php pandapro_the_category_cover($category->term_id) ?>')"><div class="overlay"></div></div>
								</div>
								<div class="list-content p-3 p-md-4">
									<div class="list-body">
										<div class="d-flex align-items-center">
											<div class="text-xl"><?php echo $category->name; ?></div>
											<div class="flex-fill"></div>
											<div class="text-light"> <i class="text-xl iconfont icon-file-text-line mr-1"></i><span class="text-xs "><?php echo $category->count ?> <?php _e('posts', 'pandapro') ?></span></div>
										</div>
										<?php  if ( $category->description ) :?><div class="border-top border-white mt-2 mt-md-3 pt-2 pt-md-3"><div class="text-sm h-2x"><?php echo $category->description ?></div> <div class="border-theme bg-primary"></div></div><?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php else: ?>
						<div class="list-header mb-3">
							<?php the_archive_title( '<div class="h4">', '</div>' ); ?>
						</div>
					<?php endif; ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<div class="list-archive list-grid list-grid-padding">
								<?php get_template_part("template-parts/post-cards/card", get_post_format()); ?>
							</div>
						<?php endwhile; ?>
						<?php
							get_template_part_with_vars('template-parts/post-navigation', array(
								'ajax_loading' => $ajax_loading,
								'page' => $tpage,
								'query' => $query,
								'append' => 'list-archive'
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