<?php
/**
 * The sidebar containing the main widget area

 *
 * @package Panda PRO
 */
?>

<div class="sidebar col-lg-4 d-none d-lg-block">
	<?php
		if (is_tax('news-category') && is_active_sidebar('sidebar-news-cat')) {
			dynamic_sidebar( 'sidebar-news-cat' );
		} elseif (is_page() && is_active_sidebar('sidebar-page')) {
			dynamic_sidebar( 'sidebar-page' );
		} elseif (is_singular('news') && is_active_sidebar('sidebar-news')) {
			dynamic_sidebar( 'sidebar-news' );
		} elseif (is_single() && is_active_sidebar('sidebar-single')) {
			dynamic_sidebar( 'sidebar-single' );
		} elseif ((is_archive() || is_search()) && is_active_sidebar('sidebar-archive')) {
			dynamic_sidebar( 'sidebar-archive' );
		} else {
			dynamic_sidebar( 'main-sidebar' );
		}
	?>
</div>