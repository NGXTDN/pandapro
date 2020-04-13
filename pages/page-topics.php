<?php
/**
 * The template for displaying all single posts#single-post
 * Template Name: Topics Page
 * @package Panda PRO
 */

get_header();
?>
	<?php
		$topic_ids = get_field('topics', get_the_ID());
	?>
    <?php while ( have_posts() ) : the_post() ?>
		<main class="py-4 py-md-5 h-v-75">
		    <div class="container">
		    	<h1 class="h3 mx-2 mx-md-0 mb-3"><?php the_title() ?><?php edit_post_link('编辑', '<small class="mx-2">[', ']</small>'); ?></h1>
				<?php if(is_array($topic_ids) && count($topic_ids) > 0): ?>
		    	<div class="row list-grouped my-n2 my-md-n3">
					<?php foreach($topic_ids as $topic_id): ?>
						<?php $topic = get_term($topic_id['topic']); ?>
						<?php if ($topic->count > 0): ?>
							<?php $cover = get_term_meta($topic->term_id, 'cover', true) ?>
							<div class="col-md-6 py-2 py-md-3">
								<div class="list-item block mb-0">
									<div class="media media-21x9">
										<a class="media-content" href="<?php echo get_term_link($topic->term_id) ?>" target="_blank" style="background-image:url(<?php echo timthumb($cover) ?>)"></a>
										<div class="media-overlay overlay-top p-3">
											<small><i class="text-xl iconfont icon-file-text-line"></i></small><span class="h1 font-theme"><?php echo $topic->count ?></span>
										</div>
									</div>
									<div class="list-content">
										<div class="list-body ">
											<a href="<?php echo get_term_link($topic->term_id) ?>" target="_blank" class="list-title text-md"><?php echo $topic->name ?></a>
											<div class="list-desc text-xs text-muted h-2x mt-2"><?php echo $topic->description ?></div>
										</div>
									</div>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>
		</main>
    <?php endwhile; ?>
<?php
get_footer();
