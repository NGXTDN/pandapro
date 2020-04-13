<?php
/**
 * The template for displaying all single posts#single-post
 * Template Name: Links Page
 * @package Panda PRO
 */

get_header();
$link_cats = get_field('link_cats', get_the_ID());
?>
    <?php while ( have_posts() ) : the_post() ?>
		<main class="py-4 py-md-5 h-v-75">
		    <div class="container">
				<div class="post">
					<div class="post-header mb-4">
						<h1 class="h3 m-0"><?php the_title() ?><?php edit_post_link(__('Edit', 'pandapro'), '<small class="mx-2">[', ']</small>'); ?></h1>
					</div>
					<div class="post-content">
						<?php the_content() ?>
					</div>
				</div>
				<?php if (is_array($link_cats) && count($link_cats) > 0): ?>
					<?php foreach ($link_cats as $link_cat): ?>
                    <?php
                        $cat = get_term($link_cat['cat'], 'link_category');
                        $links = get_bookmarks(array(
							'category' => $link_cat['cat'],
							'orderby' => 'rating'
                        ));
                    ?>
					<div class="list-links-item">
						<h2 class="text-lg mt-4 mb-3"><?php echo $cat->name ?></h2>
						<div class="row-sm list-grouped my-n2">
							<?php foreach($links as $link): ?>
							<div class="col-md-3 d-flex py-2">
								<div class="block p-3 d-flex flex-fill align-items-center m-0">
									
									<a href="<?php echo $link->link_url; ?>" target="<?php echo $link->link_target; ?>" class="flex-avatar w-64 mr-3">
										<img src="<?php echo !empty($link->link_image) ? $link->link_image : get_template_directory_uri() . '/images/default-avatar.png'; ?>" alt=".">
									</a>
								
									<div class="flex-fill">
										<a href="<?php echo $link->link_url; ?>" target="<?php echo $link->link_target; ?>" class="h6 h-1x m-0"><?php echo $link->link_name; ?></a>
										<?php if($link->link_description) : ?><div class="text-xs text-muted h-2x mt-1"><?php echo $link->link_description ?></div> <?php endif; ?>
									</div>
									
								</div>
							</div>
                            <?php endforeach; ?>
						</div>
					</div>
                    <?php endforeach; ?>
                <?php endif; ?>
		    </div>
		</main>
    <?php endwhile; ?>
<?php
get_footer();
