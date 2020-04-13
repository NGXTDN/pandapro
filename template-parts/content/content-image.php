<?php
    $category = get_the_category();
    global $post;
?>
<?php $is_liked = isset($_COOKIE['suxing_ding_'.$post->ID]); ?>
<main class="py-3 py-md-5">
    <div class="container">
        <?php pandapro_breadcrumbs() ?>
        <div class="post-cover list-rounded overlay-hover mb-3 mb-md-4">
            <div class="media media-21x9">
                <div class="media-content" style="background-image:url('<?php echo pandapro_the_thumbnail($post, array('w' => 1260, 'h' => 540)) ?>')"><span class="overlay"></span></div>
                <div class="media-overlay overlay-bottom flex-column p-3 p-md-4">
                    <div><a href="<?php echo get_category_link($category[0]->term_id ); ?>" target="_blank" class="d-inline-block"><span class="d-block badge badge-primary">#<?php echo $category[0]->cat_name; ?>#</span></a></div>
                    <h1 class="h3 text-white"><?php the_title() ?></h1>
                    <?php get_template_part('template-parts/post-meta-left') ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="post card">
                    <div class="card-body">
                        <div class="post-content">
                            <?php edit_post_link('编辑文章', '<p>[', ']</p>'); ?>
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