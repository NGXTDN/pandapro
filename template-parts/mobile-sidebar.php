<?php $panda_option = get_option('panda_option'); ?>
<div class="mobile-sidebar">

    <?php if (defined('NC_APOLLO_DIR') || get_option('users_can_register')): ?>
        <?php 
            $current_user = wp_get_current_user();
            if (defined('NC_APOLLO_DIR')) {
                $apollo_pages = get_field('apollo_pages', 'options');
                $apollo_member_url = get_page_link($apollo_pages['user_member_page']);
                $apollo_auth_url = get_page_link($apollo_pages['user_member_login_page']); 
            }
        ?>
        <?php if (is_user_logged_in()): ?>
            <?php $is_uc_page = get_query_var( 'user' ) && !empty( get_query_var( 'user' ) ) ? get_query_var( 'user' ) : ''; ?>
            <?php $redirect_url = (empty($is_uc_page) || !defined('NC_APOLLO_DIR')) ? get_permalink() : home_url() ?>
            <div class="mobile-sidebar-header">
                <div class="mobile-sidebar-author-cover">
                    <div class="media media-2x1">
                        <div class="media-content" style="background-image:url('<?php pandapro_the_author_cover($current_user->ID, array('w' => 750, 'h' => 375)) ?>')"></div>
                        <div class="media-overlay overlay-top align-items-center p-3">
                            <!--退出登录按钮-->
                            <a class="text-white btn btn-icon btn-nostyle" href="<?php echo wp_logout_url($redirect_url) ?>"><span><i class="text-xl iconfont icon-login-box-line"></i></span></a>
                            <div class="flex-fill"></div>
                            <div>
                                <?php if ($panda_option['dark_mode'] && $panda_option['dark_mode_detail']['frontend']): ?>
                                    <button class="btn btn-icon nav-switch-dark-mode text-white mr-2">
                                        <span class="icon-light-mode"><i class="text-xl iconfont icon-moon-line "></i></span>
                                        <span class="icon-dark-mode"><i class="text-xl text-warning iconfont icon-moon-fill "></i></span>
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-icon text-white sidebar-close"><span><i class="text-xl iconfont icon-radio-button-line"></i></span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobile-sidebar-author-body">
                    <div class="mobile-sidebar-author-avatar">
                        <a  class="flex-avatar mx-2 w-64 border border-2 border-white" href="<?php echo !defined('NC_APOLLO_DIR') ? get_edit_profile_url() : $apollo_member_url.'/user/profile' ?>" target="_blank">
                            <?php echo get_avatar( $current_user->ID, 64, '', '' ); ?>
                        </a>
                      
                    </div>
                    <div class="mobile-sidebar-author-meta">
                        <div class="h6 mb-2">
                            <a target="_blank" href="<?php echo !defined('NC_APOLLO_DIR') ? get_edit_profile_url() : $apollo_member_url.'/user/profile' ?>">
                                <?php echo get_userdata($current_user->ID)->display_name ?>
                                <small class="d-block"><span class="badge badge-outline-primary mt-2"></span></small>
                            </a>
                            </div>
                        <div class="desc text-xs mb-3"><span class="badge badge-outline-primary"><?php pandapro_the_author_role_name($current_user->ID) ?></span></div>
                        <div class="row no-gutters text-center">
                            <a href="<?php echo !defined('NC_APOLLO_DIR') ? get_author_posts_url($current_user->ID) : $apollo_member_url.'/user/posts'  ?>" target="_blank" class="col">
                                <span class="font-theme font-weight-bold text-md"><?php echo count_user_posts($current_user->ID) ?></span><small class="d-block text-xs text-muted"><?php _e('Posts', 'pandapro') ?></small>
                            </a>
                            <a href="<?php echo !defined('NC_APOLLO_DIR') ? get_author_posts_url($current_user->ID) : $apollo_member_url.'/user/comments' ?>" target="_blank" class="col">
                                <span class="font-theme font-weight-bold text-md"><?php pandapro_the_author_comment_count($current_user->ID); ?></span><small class="d-block text-xs text-muted"><?php _e('Comments', 'pandapro') ?></small>
                            </a>
                            <a href="<?php echo get_author_posts_url($current_user->ID) ?>" target="_blank" class="col">
                                <span class="font-theme font-weight-bold text-md"><?php pandapro_the_author_like_count($current_user->ID); ?></span><small class="d-block text-xs text-muted"><?php _e('Likes', 'pandapro') ?></small>
                            </a>
                        </div>
                    </div>
                    <div class="mobile-sidebar-author-action">
                        <div class="row no-gutters text-center">
                            <a href="<?php pandapro_the_new_post_link(); ?>" target="_blank" class="col">
                                <span>
                                    <i class="h3 iconfont icon-edit-box-line"></i>
                                </span>
                                <small class="d-block text-xs text-muted"><?php _e('New Post', 'pandapro') ?></small>
                            </a>
                            <a href="<?php echo !defined('NC_APOLLO_DIR') ? admin_url('edit.php') : $apollo_member_url.'/user/posts' ?>" target="_blank" rel="nofollow" class="col">
                                <span>
                                    <i class="h3 iconfont icon-file-list--line"></i>
                                </span>
                                <small class="d-block text-xs text-muted"><?php _e('Posts', 'pandapro') ?></small>
                            </a>
                            <a href="<?php echo !defined('NC_APOLLO_DIR') ? get_edit_profile_url() : $apollo_member_url.'/user/profile' ?>" target="_blank" rel="nofollow" class="col">
                                <span>
                                    <i class="h3 iconfont icon-settings-line"></i>
                                </span>
                                <small class="d-block text-xs text-muted"><?php _e('Profile', 'pandapro') ?></small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="mobile-sidebar-header">
                <div class="mobile-sidebar-author-cover">
                    <div class="media media-2x1">
                        <div class="media-content" style="background-image:url('<?php pandapro_the_author_cover(0, array('w' => 750, 'h' => 375)) ?>')"></div>
                        <div class="media-overlay overlay-top align-items-center p-3">
                            <div class="flex-fill"></div>
                            <div>
                                <?php if ($panda_option['dark_mode'] && $panda_option['dark_mode_detail']['frontend']): ?>
                                    <button class="btn btn-icon nav-switch-dark-mode text-white mr-2">
                                        <span class="icon-light-mode"><i class="text-xl iconfont icon-moon-line "></i></span>
                                        <span class="icon-dark-mode"><i class="text-xl text-warning iconfont icon-moon-fill "></i></span>
                                    </button>
                                <?php endif; ?>
                                <button class="btn btn-icon text-white sidebar-close"><span><i class="text-xl iconfont icon-radio-button-line"></i></span></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mobile-sidebar-author-body">
                    <div class="mobile-sidebar-author-avatar">
                        <a class="flex-avatar mx-2 w-64 bg-light border border-2 border-white">
                            <?php $default_avatar = get_option('nice-default-avatar', get_template_directory_uri().'/images/default-avatar.png') ?>
                            <img src="<?php echo is_array($default_avatar) ? $default_avatar['url'] : $default_avatar ?>" />
                        </a>
                    </div>
                    <div class="mobile-sidebar-author-meta">
                        <div class="h6 mt-2 mb-3"><a href="<?php echo defined('NC_APOLLO_DIR') ? $apollo_auth_url.'/user/login' : wp_login_url() ?>" class="btn btn-outline-primary btn-sm btn-rounded"><?php _e( 'Login now.', 'pandapro' ) ?></a></div>
                        <div class="row no-gutters text-center">
                            <div class="col">
                                <span class="font-theme font-weight-bold text-md">0</span><small class="d-block text-xs text-muted"><?php _e('Posts', 'pandapro') ?></small>
                            </div>
                            <div class="col">
                                <span class="font-theme font-weight-bold text-md">0</span><small class="d-block text-xs text-muted"><?php _e('Comments', 'pandapro') ?></small>
                            </div>
                            <div class="col">
                                <span class="font-theme font-weight-bold text-md">0</span><small class="d-block text-xs text-muted"><?php _e('Likes', 'pandapro') ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ?>
    <?php else: ?>
        <!--没开启注册登录或者没有开启 apollo 时用下面的-->
        <div class="mobile-sidebar-header text-right p-3">
            <?php if ($panda_option['dark_mode'] && $panda_option['dark_mode_detail']['frontend']): ?>
                <button class="btn btn-icon nav-switch-dark-mode mr-2">
                    <span class="icon-light-mode"><i class="text-xl iconfont icon-moon-line "></i></span>
                    <span class="icon-dark-mode"><i class="text-xl text-warning iconfont icon-moon-fill "></i></span>
                </button>
            <?php endif; ?>
            <button class="btn btn-icon sidebar-close"><span><i class="text-xl iconfont icon-radio-button-line"></i></span></button>
        </div>
    <?php endif; ?>
    <ul class="mobile-sidebar-menu nav flex-column">
        <?php
            if ( function_exists( 'wp_nav_menu' ) && has_nav_menu('mobile-menu') ) {
                wp_nav_menu( array( 'container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'mobile-menu' ) );
            } else {
                _e('<li><a href="/wp-admin/nav-menus.php">Please set up your first menu at [Admin -> Appearance -> Menus]</a></li>', 'pandapro');
            }
        ?>
    </ul>
</div>