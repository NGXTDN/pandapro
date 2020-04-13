<?php 
    global $post, $more;
    $hide = get_post_meta($post->ID, 'hide_content', true);
    if (defined('NC_APOLLO_DIR')) {
        $apollo_pages = get_field('apollo_pages', 'options');
        $apollo_member_url = get_page_link($apollo_pages['user_member_page']);
        $apollo_auth_url = get_page_link($apollo_pages['user_member_login_page']); 
    }
?>
<?php if (empty($hide) || $hide == 'close'): ?>
    <?php the_content(); ?>
    <?php get_template_part('template-parts/wp-link-pages'); ?>
<?php endif; ?>

<?php if ($hide == 'login'): ?>
    <?php 
        $more = 0;
        the_content(); 
    ?>
    <?php if (is_user_logged_in()): ?>
    <?php 
        $more = 1;
        the_content();
    ?>
    <?php get_template_part('template-parts/wp-link-pages'); ?>
    <?php else: ?>
        <div class="post-restrict-area border border-light border-2 rounded text-center py-4 py-md-5 mb-3">
            <div class="restrict-text text-sm text-secondary"><?php _e('Restricted content', 'pandapro') ?></div>
            <div class="restrict-action mt-3"><a href="<?php echo !defined('NC_APOLLO_DIR') ? wp_login_url(get_the_permalink()) : $apollo_auth_url.'/user/login' ?>" class="btn btn-primary"><?php _e('Login to read more...', 'pandapro') ?></a></div>
        </div>
    <?php endif; ?>
<?php endif; ?>

<?php if ($hide == 'comment'): ?>
    <?php 
        $more = 0;
        the_content(); 
    ?>

    <?php if (pandapro_is_replied() || current_user_can('administrator')): ?>
    <?php 
        $more = 1;
        the_content();
    ?>
    <?php get_template_part('template-parts/wp-link-pages'); ?>
    <?php else: ?>
        <div class="post-restrict-area border border-light border-2 rounded text-center py-4 py-md-5 mb-3">
            <div class="restrict-text text-sm text-secondary"><?php _e('Hidden content', 'pandapro') ?></div>
            <div class="restrict-action mt-3"><a href="#comments" class="btn btn-primary"><?php _e('Comment to read more...', 'pandapro') ?></a></div>
        </div>
    <?php endif; ?>
<?php endif; ?>
