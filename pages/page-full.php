<?php
/**
 * The template for displaying all single posts#single-post
 * Template Name: Full Page
 * @package Panda PRO
 */

get_header();
?>
    <?php while ( have_posts() ) : the_post() ?>
		<main class="py-4 py-md-5">
		    <div class="container">
				<div class="post card">
					<div class="card-body">
						<div class="post-header mb-4">
							<h1 class="h3 m-0"><?php the_title() ?><?php edit_post_link(__('Edit', 'pandapro'), '<small class="mx-2">[', ']</small>'); ?></h1>
						</div>
						<div class="post-content">
							<?php the_content() ?>
							<?php get_template_part( 'template-parts/wp-link-pages' ); ?>
						</div>
					</div>
				</div>
				<?php get_template_part('template-parts/ad/single-ad'); ?>
				<?php
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>
		    </div>
		</main>
    <?php endwhile; ?>
<?php
get_footer();
