<?php
/**
 * The template for displaying archive pages
 *
 * @package Panda PRO
 */

global $wp_query;

$panda_option = get_option('panda_option');
$author = get_queried_object();

$query = $author->ID;
$tpage = 'author';

get_header();
?>
<div class="author-cover">
	<div class="media media-5x1">
		<div class="media-content" style="background-image: url('<?php pandapro_the_author_cover($author->ID) ?>');"></div>
	</div>
</div>
<main>
    <div class="container">
        <div class="row no-gutters">
        	<div class="sidebar-author col-md-4 pr-md-5 mt-n3 mt-md-n5">
        		<div class="card card-sm widget widget_author_meta">
		      	  	<div class="widget-author-avatar">
		      	    	<div class="flex-avatar mx-2 w-96 border border-3 border-white">
							<?php echo get_avatar( $author->ID, 96, '', '', array('class' => 'w-96') ); ?>
		      	    	</div>
		      	  	</div>
			      	<div class="widget-author-meta text-center p-4">
					  <div class="h6 mb-3"><?php echo $author->display_name ?><small class="d-block"><span class="badge badge-outline-primary mt-2"><?php pandapro_the_author_role_name($author->ID) ?></span></small></div>
      	  				<div class="desc text-xs h-2x mb-3"><?php echo $author->description ?></div>
				    	<div class="row no-gutters text-center">
							<a href="<?php echo get_author_posts_url($author->ID) ?>" target="_blank" class="col">
								<span class="font-theme font-weight-bold text-md"><?php echo count_user_posts($author->ID) ?></span><small class="d-block text-xs text-muted"><?php _e('Posts', 'pandapro') ?></small>
							</a>
							<a href="<?php echo get_author_posts_url($author->ID) ?>" target="_blank" class="col">
								<span class="font-theme font-weight-bold text-md"><?php pandapro_the_author_comment_count($author->ID) ?></span><small class="d-block text-xs text-muted"><?php _e('Comments', 'pandapro') ?></small>
							</a>
							<a href="<?php echo get_author_posts_url($author->ID) ?>" target="_blank" class="col">
								<span class="font-theme font-weight-bold text-md"><?php pandapro_the_author_like_count($author->ID) ?></span><small class="d-block text-xs text-muted"><?php _e('Likes', 'pandapro') ?></small>
							</a>
							<!-- <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" target="_blank" class="col">
								<span class="font-theme font-weight-bold text-md">423</span><small class="d-block text-xs text-muted">电量</small>
							</a> -->
				      	</div>
					</div>
					<?php if ($panda_option['default_donate_image']): ?>
						<div class="widget-author-power p-4">
							<!-- <div class="progress-author-power mb-3">
								<div class="progress bg-light">
									<div class="progress-bar font-theme bg-primary" role="progressbar" style="width: 30%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"> <small>30%</small></div>
								</div>
							</div> -->
						
							<div class="plus-author-power">
								<div class="row row-sm">
									<div class="col">
										<button class="btn btn-primary btn-block plus-power-popup"><i class="text-lg iconfont icon-exchange-dollar-fill mr-1"></i>给Ta赞赏</button>
									</div>
								</div>
							</div>
							<?php get_template_part_with_vars('template-parts/popup/plus-power-popup', array('id' => $author->ID)) ?>
							
						</div>
					<?php endif; ?>
				</div>
				<?php
					dynamic_sidebar( 'sidebar-author' );
				?>
        	</div>
			<div class="col-md-8 pt-4 pt-md-4 pb-4 pb-md-5">
				<div class="list-ajax-nav list-ajax-index pb-2 mb-2 mb-md-3">
					<ul>
						<li><button class="btn btn-sm btn-primary current" data-cid="1"><i class="text-md iconfont icon-archive-drawer-line"></i> <?php _e('Posts', 'pandapro') ?><small class="ml-1">(<?php echo count_user_posts($author->ID) ?>)</small></button></li>
						<li><button class="btn btn-sm btn-link" data-cid="2"><i class="text-md iconfont icon-message--line"></i> <?php _e('Comments', 'pandapro') ?><small class="ml-1">(<?php pandapro_the_author_comment_count($author->ID) ?>)</small></button></li>
					</ul>
				</div>
				<?php if ( have_posts() ) : ?>
					<div class="list-archive list-grid list-grid-padding">
					<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part("template-parts/post-cards/card", get_post_format()); ?>
					<?php endwhile; ?>
					</div>
					<?php
						get_template_part_with_vars('template-parts/post-navigation', array(
							'ajax_loading' => true,
							'page' => $tpage,
							'query' => $query,
							'append' => 'list-archive'
						));
					?>
				<?php else : ?>
					<div class="content-error text-center h-v-75 py-5">
						<div class="d-inline-block w-sm"> <?php get_template_part('template-parts/svg/404-svg'); ?></div>
						<p class="text-lg text-muted mt-5 ml-md-2"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'pandapro' ); ?></p>
					</div>
				<?php endif; ?>
			</div>
        </div>
    </div>
</main>

<?php
get_footer();