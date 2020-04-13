<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">

 *
 * @package Panda PRO
 */
$current_user = wp_get_current_user();
$panda_option = get_option('panda_option');
$dark_mode = pandapro_get_dark_mode_status();
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<?php if (defined('NC_APOLLO_DIR')): ?>
	<meta name="apollo-enabled" content="1" />
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class($dark_mode ? 'nice-dark-mode' : ''); ?>>
	<header class="header">
		<nav class="navbar navbar-expand-lg shadow">
			<div class="container">
				<!-- / brand -->
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo navbar-brand order-2 order-lg-1">
					<img src="<?php echo pandapro_get_logo() ?>" class="<?php echo $dark_mode ? 'd-none' : 'd-inline-block' ?> logo-light nc-no-lazy" alt="<?php bloginfo( 'name' ); ?>">
					<img src="<?php echo pandapro_get_logo('dark') ?>" class="<?php echo $dark_mode ? 'd-inline-block' : 'd-none' ?> logo-dark nc-no-lazy" alt="<?php bloginfo( 'name' ); ?>">
				</a>
				<button class="navbar-toggler order-1" type="button" id="sidebarCollapse">
		          	<i class="text-xl iconfont icon-menu-line"></i>
		        </button>
		        <button class="navbar-toggler nav-search order-3 collapsed" data-target="#navbar-search" data-toggle="collapse" aria-expanded="false" aria-controls="navbar-search">
					<i class="text-xl iconfont icon-search-line"></i>
					<i class="text-xl iconfont icon-close-fill"></i>
				</button>
				<!-- brand -->
				<div class="collapse navbar-collapse order-md-2">
					<ul class="navbar-nav main-menu ml-4 mr-auto">
						<?php
							if ( function_exists( 'wp_nav_menu' ) && has_nav_menu('header-menu') ) {
								wp_nav_menu( array( 'container' => false, 'items_wrap' => '%3$s', 'theme_location' => 'header-menu' ) );
							} else {
								_e('<li><a href="/wp-admin/nav-menus.php">Please set up your first menu at [Admin -> Appearance -> Menus]</a></li>', 'pandapro');
							}
						?>
					</ul>
					<ul class="navbar-nav align-items-center order-1 order-lg-2">
					<?php if ($panda_option['dark_mode'] && $panda_option['dark_mode_detail']['frontend']): ?>
						<li class="nav-item">
							<a class="btn btn-link btn-icon nav-switch-dark-mode" href="javascript:">
								<span class=" icon-light-mode" data-toggle="tooltip" data-placement="bottom" title="<?php _e('Dark Mode', 'pandapro') ?>">
									<i class="text-lg iconfont icon-moon-line"></i>
								</span>
								<span class="icon-dark-mode" data-toggle="tooltip" data-placement="bottom" title="<?php _e('Light Mode', 'pandapro') ?>"><i class="text-lg text-warning iconfont icon-moon-fill" ></i></span>
							</a>
						</li>
					<?php endif; ?>
						<?php get_template_part('template-parts/header-user') ?>
					</ul>
				</div>
			</div>
		</nav>
		<?php get_template_part('template-parts/mobile-sidebar') ?>
		<div class="navbar-search collapse " id="navbar-search" style="">
			<div class="container">
				<form method="get" role="search" id="searchform" class="searchform shadow" action="<?php echo home_url( '/' ) ?>">
					<div class="input-group">
						<input type="text" name="s" id="s" placeholder="<?php _e('Type anything to search...', 'pandapro') ?>" class="form-control" required="">
						<div class="input-group-append">
							<button class="btn btn-nostyle" type="submit"><i class="text-lg iconfont icon-search-line"></i></button>
						</div>
					</div><!-- /input-group -->
				</form>
			</div>
		</div>
	</header>