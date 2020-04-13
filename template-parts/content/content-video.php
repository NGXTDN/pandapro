<?php
    $category = get_the_category();
    global $post;
?>
<?php $is_liked = isset($_COOKIE['suxing_ding_'.$post->ID]); ?>
<main class="py-3 py-md-5">
    <div class="container">
        <?php pandapro_breadcrumbs() ?>
        <?php
            $video_url = get_post_meta(get_the_ID(), 'video_url', true);
            if( !empty( $video_url ) ){
                echo '<div class="post-video bg-dark mb-2 mb-md-4">';
                echo apply_filters( 'the_content', $video_url );
                echo '</div>';
            }
        ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="post card">
                    <div class="card-body">
                        <div class="post-header border-bottom border-light mb-4 pb-4">
                            <div class="d-block text-sm mt-md-1 mb-2">
                                <a href="<?php echo get_category_link($category[0]->term_id ); ?>" target="_blank"><span class="badge badge-primary"><?php echo $category[0]->cat_name; ?></span></a>
                            </div>
                            <h1 class="h3 mb-3"><?php the_title() ?><?php edit_post_link('编辑', '<small class="mx-2">[', ']</small>'); ?></h1>
                            <?php get_template_part('template-parts/post-meta') ?>
                            <div class="border-theme bg-primary"></div>
                        </div>
                        <div class="post-content">
                            <?php get_template_part('template-parts/post-content-control'); ?>
                        </div>
                    </div>
                    <div class="card-footer border-0">
                        <?php get_template_part('template-parts/post-share-section') ?>
                    </div>
                </div>
                <?php the_tags( '<div class="post-tags block d-flex text-sm p-4 "><i class="text-xl text-primary iconfont icon-price-tag--line mr-3"></i><div class="flex-fill"><span class="d-inline-block text-muted mr-2"># ', '</span><span class="d-inline-block text-muted mr-2"># ', '</span></div></div>' ); ?>
                <?php get_template_part('template-parts/ad/single-ad'); ?>
                <?php get_template_part('template-parts/related-posts') ?>
                <?php
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                ?>
            </div>
            <?php get_sidebar() ?>
        </div>
    </div>
</main>