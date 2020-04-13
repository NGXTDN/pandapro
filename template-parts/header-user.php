<?php 
    global $wp;
    $current_user = wp_get_current_user();
    if (defined('NC_APOLLO_DIR')) {
        $apollo_pages = get_field('apollo_pages', 'options');
        $apollo_member_url = get_page_link($apollo_pages['user_member_page']);
        $apollo_auth_url = get_page_link($apollo_pages['user_member_login_page']); 
    }
?>
<li class="nav-item ml-1 ml-md-2">
    <a class="btn btn-link btn-icon nav-link nav-search collapsed" href="#navbar-search" data-toggle="collapse"title="Search" aria-expanded="false" aria-controls="navbar-search">
        <span data-toggle="tooltip" data-placement="bottom" title="<?php _e('Search', 'pandapro') ?>">
            <i class="text-lg iconfont icon-search-line"></i>
            <i class="text-lg iconfont icon-close-fill"></i>
        </span>
    </a>
</li>
<?php if (defined('NC_CONTRIBUTE_DIR') || get_option('users_can_register')): ?>
    <?php $contribute_page = get_field('contri_page_template', 'option'); ?>
    <li class="nav-item ml-1 ml-md-2">
        <a class="btn btn-link btn-icon nav-link collapsed" href="<?php echo (!empty($contribute_page) && defined('NC_CONTRIBUTE_DIR')) ? get_page_link($contribute_page->ID) : admin_url('post-new.php') ?>" target="_blank">
            <span data-toggle="tooltip" data-placement="bottom" title="<?php _e('Contribute', 'pandapro') ?>">
                <i class="text-lg iconfont icon-edit-box-line"></i>
            </span>
        </a>
    </li>
<?php endif; ?>
<?php if (get_option('users_can_register')): ?>
    <?php if (is_user_logged_in()): ?>
        <li class="nav-item nav-item-signin text-sm ml-2 ml-md-3">
            <a class="d-flex align-items-center dropdown-toggle" id="link_item_signin" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="flex-avatar w-32 mx-2">
                    <?php echo get_avatar( $current_user->data->ID, 32, '', '', array('class' => '') ); ?>
                </span>
            </a>
            <?php $redirect_url = !isset($GLOBALS['NC-UC-PAGE']) ? home_url(add_query_arg(array(), $wp->request)) : home_url() ?>
            <?php if (!defined('NC_APOLLO_DIR')): ?>
                <div class="nice-dropdown" aria-labelledby="link_item_signin">
                    <ul class="text-xs p-2">
                        <li class="p-2">
                            <a href="<?php echo admin_url('edit.php') ?>" target="_blank" rel="nofollow"><i class="text-md mr-2 iconfont iconfont icon-file-list--line"></i><?php _e('My Posts', 'pandapro') ?></a>
                        </li>
                        <li class="p-2">
                            <a href="<?php echo get_edit_profile_url();?>" target="_blank" rel="nofollow"><i class="text-md mr-2 iconfont icon-settings--line"></i><?php _e('Profile', 'pandapro') ?></a>
                        </li>
                        <li class="p-2">
                            <a href="<?php echo wp_logout_url($redirect_url) ?>"><i class="text-md mr-2 iconfont icon-shut-down-line"></i><?php _e('Logout', 'pandapro') ?></a>
                        </li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="nice-dropdown" aria-labelledby="link_item_signin">
                    <ul class="text-xs p-2">
                        <li class="p-2">
                            <a href="<?php echo $apollo_member_url; ?>" rel="nofollow"><i class="text-md mr-2 iconfont icon-account-pin-circle-line"></i><?php _e('Home', 'pandapro') ?></a>
                        </li>
                        <li class="p-2">
                            <a href="<?php echo $apollo_member_url; ?>/user/posts" rel="nofollow"><i class="text-md mr-2 iconfont icon-file-list--line"></i><?php _e('My Posts', 'pandapro') ?></a>
                        </li>
                        <li class="p-2">
                            <a href="<?php echo $apollo_member_url; ?>/user/profile" rel="nofollow"><i class="text-md mr-2 iconfont icon-settings-line1"></i><?php _e('Profile', 'pandapro') ?></a>
                        </li>
                        <li class="p-2">
                            <a href="<?php echo wp_logout_url($redirect_url) ?>"><i class="text-md mr-2 iconfont icon-shut-down-line"></i><?php _e('Logout', 'pandapro') ?></a>
                        </li>
                    </ul>
                </div>
            <?php endif; ?>
        </li>
    <?php else: ?>
        <?php if (!defined('NC_APOLLO_DIR')): ?>
            <div class="btn-group ml-2 ml-md-3" role="group">
                <a class="btn btn-outline-primary btn-sm" href="<?php echo wp_registration_url(); ?>"><?php _e('Register', 'pandapro') ?></a>
                <a class="btn btn-primary btn-sm" href="<?php echo wp_login_url() ?>"><?php _e('Sign in', 'pandapro') ?></a>
            </div>
        <?php else: ?>
            <div class="btn-group ml-2 ml-md-3" role="group">
                <a class="btn btn-outline-primary btn-sm" href="<?php echo $apollo_auth_url.'/user/register' ?>"><?php _e('Register', 'pandapro') ?></a>
                <a class="btn btn-primary btn-sm" href="<?php echo $apollo_auth_url.'/user/login' ?>"><?php _e('Sign in', 'pandapro') ?></a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>