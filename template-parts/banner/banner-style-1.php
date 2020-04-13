<?php $panda_option = get_option('panda_option'); ?>
<?php $queryPosts = new WP_Query(array('post__in' => array_column($panda_option['index_featured_posts'], 'post'))); ?>
<?php if ( $queryPosts->have_posts() ) : ?>
    <div class="list-banner banner-style-1 pt-3 pt-md-5">
        <div class="container">
            <div class="owl-carousel owl-theme">
                <?php while ( $queryPosts->have_posts() ): ?>
                    <?php $queryPosts->the_post(); ?>
                    <?php global $post ?>
                    <?php $category = get_the_category(); ?>
                    <div class="card item list-item flex-fill m-0">
                        <div class="row no-gutters">
                            <div class="col-12 col-md-8">
                                <div class="media media-3x2">
                                    <a class="media-content" target="_blank" href="<?php the_permalink() ?>" style="background-image: url(<?php echo pandapro_get_head_img(get_the_ID(), array('w' => 900, 'h' => 600)) ?>)"></a>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 d-flex bg-dark">
                                <div class="list-content flex-fill p-3 p-lg-5 ">
                                    <div class="list-body ">
                                        <div class="d-none d-md-block mt-3 mb-3 mt-md-4 mb-xl-5"><div class="flex-avatar w-36"><?php echo get_avatar( $post->post_author, 36, '', '', array('class' => 'w-36') ); ?></div></div>
                                        <div class="h5 h-2x mb-2 mb-md-3 mb-xl-4">
                                            <a href="<?php the_permalink() ?>" class="list-title text-lg text-white" target="_blank"><?php the_title() ?></a>
                                        </div>
                                        <div class="list-desc  d-none d-lg-block text-sm text-light my-md-2"><p class="text-light"><?php pandapro_print_excerpt(60) ?></p></div>
                                    </div>
                                    <div class="list-footer mt-1">
                                        <div class="text-light text-xs">
                                            <span class="d-inline-block"><a href="<?php echo get_category_link($category[0]); ?>" class="text-light" target="_blank"><?php echo $category[0]->cat_name ?></a></span>
                                            <i class="text-primary mx-1 mx-md-2">&#8212;</i>
                                            <time class="d-inline-block"><?php pandapro_the_time() ?></time>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php wp_reset_postdata() ?>