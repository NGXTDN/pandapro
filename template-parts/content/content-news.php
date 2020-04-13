<?php
    global $post;
    $tax = get_the_terms($post->ID, 'news-category')[0];
?>
<?php $is_liked = isset($_COOKIE['suxing_ding_'.$post->ID]); ?>
<main class="py-3 py-md-5">
    <div class="container">
        <?php pandapro_breadcrumbs() ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="post card">
                    <div class="card-body">
                        <div class="post-header border-bottom border-light mb-4 pb-4">
                            <h1 class="h3 mb-3"><?php the_title() ?><?php edit_post_link(__('Edit', 'pandapro'), '<small class="mx-2">[', ']</small>'); ?></h1>
                            <?php get_template_part('template-parts/post-meta') ?>
                            <div class="border-theme bg-primary"></div>
                        </div>
                        <div class="post-content">
                            <?php the_content() ?>
                            
                        </div>
                        <?php get_template_part('template-parts/post-share-text-section') ?>
                    </div>
                </div>
                <?php get_template_part('template-parts/ad/single-ad'); ?>
                <?php get_template_part('template-parts/related-news') ?>
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