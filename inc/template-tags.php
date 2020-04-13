<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Panda PRO
 */
if ( ! function_exists( 'pandapro_the_sticky_tag' ) ) :
function pandapro_the_sticky_tag() {
	if ( is_sticky() ) {
		echo '<span class="badge badge-hot">推荐</span>';
	}
}
endif;

if ( ! function_exists( 'pandapro_the_featured_tag' ) ) :
	function pandapro_the_featured_tag() {
		global $post;
		if (get_post_meta($post->ID, 'featured_tag', true)) {
			$tag = get_post_meta($post->ID, 'featured_tag_obj', true);
			if (!empty($tag)) echo '<span class="badge badge-primary">'.get_term($tag)->name.'</span>';
		}	
	}
endif;

if ( ! function_exists( 'pandapro_the_logo' ) ) :
function pandapro_get_logo($dark = '') {
	$panda_option = get_option('panda_option');
	$logo = $panda_option['logo'];
	$logo_dark = $panda_option['logo_dark'];
	if ($dark === 'dark') {
		return empty($logo_dark) ? get_template_directory_uri().'/images/logo-dark.png' : timthumb($logo_dark);
	}
	return empty($logo) ? get_template_directory_uri().'/images/logo.png' : timthumb($logo);
}
endif;

if ( ! function_exists( 'pandapro_breadcrumbs' ) ) :
function pandapro_breadcrumbs() {
	$panda_option = get_option('panda_option');
	$breadcrumbs = $panda_option['breadcrumbs'];

	if ($breadcrumbs):
		/* === OPTIONS === */
		$text['home']     = __('Home', 'pandapro'); // 首页
		$text['category'] = '%s'; // text for a category page
		$text['search']   = __('Search Result "%s"', 'pandapro'); // 搜索结果 "%s"
		$text['topic']      = __('Topic %s', 'pandapro'); // 文章标签
		$text['tag']      = __('Tag %s', 'pandapro'); // 文章标签
		$text['author']   = __('%s\'s Posts', 'pandapro'); // %s 的文章
		$text['404']      = __('404 Not Found', 'pandapro'); // 404 未找到
		$text['page']     = __('Page %s', 'pandapro'); // text 'Page N' 第 %s 页
		$text['cpage']    = __('Comment Page %s', 'pandapro'); // Comment Page %s
		$wrap_before      = '<div class="d-none d-md-block breadcrumbs text-muted mb-2">'; // the opening wrapper tag
		$wrap_after       = '</div>'; // the closing wrapper tag
		$sep              = '›'; // separator between crumbs
		$sep_before       = '<span class="sep">'; // tag before separator
		$sep_after        = '</span>'; // tag after separator
		$show_home_link   = 1; // 1 - show the 'Home' link, 0 - don't show
		$show_on_home     = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$show_current     = 1; // 1 - show current page title, 0 - don't show
		$before           = '<span class="current">'; // tag before the current crumb
		$after            = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */
		global $post;
		$home_url       = home_url('/');
		$link_before    = '<span itemprop="itemListElement">';
		$link_after     = '</span>';
		$link_attr      = ' itemprop="item"';
		$link_in_before = '<span itemprop="name">';
		$link_in_after  = '</span>';
		$link           = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
		$frontpage_id   = get_option('page_on_front');
		$parent_id      = $post->post_parent;
		$sep            = ' ' . $sep_before . $sep . $sep_after . ' ';
		$home_link      = $link_before . '<a href="' . $home_url . '"' . $link_attr . ' class="home">' . $link_in_before . $text['home'] . $link_in_after . '</a>' . $link_after;
		if (is_home() || is_front_page()) {
			if ($show_on_home) echo $wrap_before . $home_link . $wrap_after;
		} else {
			echo $wrap_before;
			if ($show_home_link) echo $home_link;
			if ( is_category() ) {
				$cat = get_category(get_query_var('cat'), false);
				if ($cat->parent != 0) {
					$cats = get_category_parents($cat->parent, TRUE, $sep);
					$cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
					$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
					if ($show_home_link) echo $sep;
					echo $cats;
				}
				if ( get_query_var('paged') ) {
					$cat = $cat->cat_ID;
					echo $sep . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
				} else {
					if ($show_current) echo $sep . $before . sprintf($text['category'], single_cat_title('', false)) . $after;
				}
			} elseif ( is_search() ) {
				if (have_posts()) {
					if ($show_home_link && $show_current) echo $sep;
					if ($show_current) echo $before . sprintf($text['search'], get_search_query()) . $after;
				} else {
					if ($show_home_link) echo $sep;
					echo $before . sprintf($text['search'], get_search_query()) . $after;
				}
			} elseif ( is_day() ) {
				if ($show_home_link) echo $sep;
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $sep;
				echo sprintf($link, get_month_link(get_the_time('Y'), get_the_time('m')), get_the_time('F'));
				if ($show_current) echo $sep . $before . get_the_time('d') . $after;
			} elseif ( is_month() ) {
				if ($show_home_link) echo $sep;
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y'));
				if ($show_current) echo $sep . $before . get_the_time('F') . $after;
			} elseif ( is_year() ) {
				if ($show_home_link && $show_current) echo $sep;
				if ($show_current) echo $before . get_the_time('Y') . $after;
			} elseif ( is_single() && !is_attachment() ) {
				if ($show_home_link) echo $sep;
				if ( get_post_type() == 'news' ) {
					$post_type = get_post_type_object(get_post_type());
					$newscat = get_the_terms(get_the_ID(), 'news-category');
					$slug = $post_type->rewrite;
					printf($link, get_term_link($newscat[0]->term_id, 'news-category'), $newscat[0]->name);
					if ($show_current) echo $sep . $before . get_the_title() . $after;
				} elseif ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf($link, $home_url . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
					if ($show_current) echo $sep . $before . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $sep);
					if (!$show_current || get_query_var('cpage')) $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
					$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
					echo $cats;
					if ( get_query_var('cpage') ) {
						echo $sep . sprintf($link, get_permalink(), get_the_title()) . $sep . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
					} else {
						if ($show_current) echo $before . get_the_title() . $after;
					}
				}
			// custom post type
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object(get_post_type());
				if ( get_query_var('paged') ) {
					echo $sep . sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
				} else {
					if ($show_current) echo $sep . $before . $post_type->label . $after;
				}
			} elseif ( is_attachment() ) {
				if ($show_home_link) echo $sep;
				$parent = get_post($parent_id);
				$cat = get_the_category($parent->ID); $cat = $cat[0];
				if ($cat) {
					$cats = get_category_parents($cat, TRUE, $sep);
					$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
					echo $cats;
				}
				printf($link, get_permalink($parent), $parent->post_title);
				if ($show_current) echo $sep . $before . get_the_title() . $after;
			} elseif ( is_page() && !$parent_id ) {
				if ($show_current) echo $sep . $before . get_the_title() . $after;
			} elseif ( is_page() && $parent_id ) {
				if ($show_home_link) echo $sep;
				if ($parent_id != $frontpage_id) {
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_page($parent_id);
						if ($parent_id != $frontpage_id) {
							$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
						}
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					for ($i = 0; $i < count($breadcrumbs); $i++) {
						echo $breadcrumbs[$i];
						if ($i != count($breadcrumbs)-1) echo $sep;
					}
				}
				if ($show_current) echo $sep . $before . get_the_title() . $after;
			} elseif ( is_tag() ) {
				if ( get_query_var('paged') ) {
					$tag_id = get_queried_object_id();
					$tag = get_tag($tag_id);
					echo $sep . sprintf($link, get_tag_link($tag_id), $tag->name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
				} else {
					if ($show_current) echo $sep . $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
				}
			} elseif ( is_tax() ) {
				if ( get_query_var('paged') ) {
					$tax_id = get_queried_object_id();
					$tax = get_term($tax_id);
					echo $sep . sprintf($link, get_term_link($tax_id), $tax->name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
				} else {
					if ($show_current) echo $sep . $before . sprintf($text['topic'], single_tag_title('', false)) . $after;
				}
			} elseif ( is_author() ) {
				global $author;
				$author = get_userdata($author);
				if ( get_query_var('paged') ) {
					if ($show_home_link) echo $sep;
					echo sprintf($link, get_author_posts_url($author->ID), $author->display_name) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
				} else {
					if ($show_home_link && $show_current) echo $sep;
					if ($show_current) echo $before . sprintf($text['author'], $author->display_name) . $after;
				}
			} elseif ( is_404() ) {
				if ($show_home_link && $show_current) echo $sep;
				if ($show_current) echo $before . $text['404'] . $after;
			} elseif ( has_post_format() && !is_singular() ) {
				if ($show_home_link) echo $sep;
				echo get_post_format_string( get_post_format() );
			}
			echo $wrap_after;
		}
	endif;
}
endif;

if ( ! function_exists( 'pandapro_comment_official' ) ) :
	function pandapro_comment_official( $user_id = null ){
		if( $user_id != null && $user_id == 1 ){
			printf( '<span class="badge badge-primary mr-2">%s</span>', __('Admin', 'pandapro'));
		}
	}
endif;

if ( ! function_exists( 'pandapro_the_time' ) ) :
	function pandapro_the_time() {
		$panda_option = get_option('panda_option');
		$type = $panda_option['timestamp_type'];
		if ($type === 'sec' && is_single()) {
			echo get_the_time('Y-m-d G:i:s');
			return;
		}
		if ($type === 'eng') {
			echo get_the_time('F j, Y');
			return;
		}
		// 默认 ago
		echo pandapro_timeago();
		return;
	}
endif;

if ( ! function_exists( 'pandapro_get_time' ) ) :
	function pandapro_get_time($post = null) {
		$panda_option = get_option('panda_option');
		if ($post === null) global $post;
		$type = $panda_option['timestamp_type'];
		if ($type === 'sec' && is_single()) {
			return get_the_time('Y-m-d G:i:s', $post);
		}
		if ($type === 'eng') {
			return get_the_time('F j, Y', $post);
		}
		// 默认 ago
		return pandapro_timeago(null, $post);
	}
endif;

if ( ! function_exists( 'pandapro_wp_link_pages' ) ) :
	function pandapro_wp_link_pages($args = '') {
		global $page, $numpages, $multipage, $more, $pagenow, $numpages;
		$defaults = array(
			'before' => '<p>' . __('Pages:') ,
			'after' => '</p>',
			'link_before' => '',
			'link_after' => '',
			'item_before' => '',
			'item_after' => '',
			'item_before_active' => '',
			'next_or_number' => 'number',
			'separator' => ' ',
			'nextpagelink' => __('Next page') ,
			'previouspagelink' => __('Previous page') ,
			'pagelink' => '%',
			'echo' => 1
		);
		$params = wp_parse_args($args, $defaults);
		$r = apply_filters('wp_link_pages_args', $params);
		$args['next_or_number'] = 'number';
		$output = '';
		if ($multipage) {

			if ($page - 1) { # there is a previous page
				$prev_link_html = str_replace('<a', '<a class="post-page-numbers prev" ', _wp_link_page($page - 1));
				$r['before'] .= $prev_link_html
					. $r['link_before']. $r['previouspagelink'] . $r['link_after'] . '</a>';
			}
			
			if ($page < $numpages) { # there is a next page
				$next_link_html = str_replace('<a', '<a class="post-page-numbers next" ', _wp_link_page($page + 1));
				$r['after'] = $next_link_html
					. $r['link_before'] . $r['nextpagelink'] . $r['link_after'] . '</a>'
					. $r['after'];
			}

			$output.= $r['before'];

			for ($i = 1; $i <= $numpages; $i++) {
				$link = $r['link_before'] . str_replace('%', $i, $r['pagelink']) . $r['link_after'];
				if ($i != $page || !$more && 1 == $page) {
					$link = $r['item_before'] . _wp_link_page($i) . $link . '</a>' . $r['item_after'];
				} else {
					$link = $r['item_before_active'] . $link . $r['item_after_active'];
				}
				/**
				 * Filters the HTML output of individual page number links.
				 *
				 * @since 3.6.0
				 *
				 * @param string $link The page number HTML output.
				 * @param int $i Page number for paginated posts page links.
				 */
				$link = apply_filters('wp_link_pages_link', $link, $i);
				// Use the custom links separator beginning with the second link.
				$output.= (1 === $i) ? ' ' : $r['separator'];
				$output.= $link;
			}
			$output.= $r['after'];
		}
		/**
		 * Filters the HTML output of page links for paginated posts.
		 *
		 * @since 3.6.0
		 *
		 * @param string $output HTML output of paginated posts' page links.
		 * @param array $args An array of arguments.
		 */
		$html = apply_filters('wp_link_pages', $output, $args);
		if ($r['echo']) {
			echo $html;
		}
		return $html;
	}
endif;

if ( ! function_exists( 'pandapro_the_category_cover' ) ) :
	function pandapro_the_category_cover($id) {
		$panda_option = get_option('panda_option');
		$cover_image_id = get_term_meta($id, 'cover', true);

		if (!empty($cover_image_id)) {
			echo timthumb(wp_get_attachment_image_src($cover_image_id, 'full')[0], array('w' => 740, 'h' => 320));
			return;
		}
		
		echo empty($panda_option['default_cat_cover']) ? get_template_directory_uri().'/images/default-cover.jpg' : timthumb($panda_option['default_cat_cover']);
		return;
	}
endif;

if ( ! function_exists( 'pandapro_the_newscat_cover' ) ) :
	function pandapro_the_newscat_cover($id) {
		$panda_option = get_option('panda_option');
		$cover_image_id = get_term_meta($id, 'cover', true);

		if (!empty($cover_image_id)) {
			echo timthumb(wp_get_attachment_image_src($cover_image_id, 'full')[0], array('w' => 740, 'h' => 320));
			return;
		}
		
		echo empty($panda_option['default_newscat_cover']) ? get_template_directory_uri().'/images/default-cover.jpg' : timthumb($panda_option['default_newscat_cover']);
		return;
	}
endif;

if ( ! function_exists( 'pandapro_the_author_cover' ) ) :
	function pandapro_the_author_cover($id = 0, $size = null) {
		$panda_option = get_option('panda_option');
		$cover_image_url = $panda_option['default_author_cover'];
		$default_cover_url = timthumb(get_template_directory_uri().'/images/default-cover.jpg', $size);
		$cover_url = '';

		if (!defined('NC_APOLLO_DIR')) {
			if (!empty($cover_image_url)) {
				echo timthumb(wp_get_attachment_image_src($cover_image_url, 'full')[0], $size);
				return;
			}
			echo $default_cover_url;
			return;
		}

		$user_cover = get_user_meta( $id, 'nice-cover', true );
		echo !empty( $user_cover ) ? $user_cover['url'] : get_field( 'apollo_user_default_image', 'options' );
		return;
	}
endif;


if ( ! function_exists( 'pandapro_the_author_like_count' ) ) :
	function pandapro_the_author_like_count($id, $echo = true) {
		$args = array(
			'post_type' => 'post',
			'author' => $id,
			'posts_per_page' => -1
		);
		$count = 0;
		$authorPosts = new WP_Query($args);

		while ($authorPosts->have_posts()) {
			$authorPosts->the_post();
			global $post;
			$count += (int) get_post_meta($post->ID, 'suxing_ding', true);
		}

		wp_reset_postdata();
		if ($echo) echo format_big_numbers($count); else return $count;
	}
endif;

if ( ! function_exists( 'pandapro_the_author_comment_count' ) ) :
	function pandapro_the_author_comment_count($id, $echo = true) {
		$args = array(
			'post_type' => 'post',
			'author' => $id,
			'posts_per_page' => -1
		);
		$count = 0;
		$authorPosts = new WP_Query($args);

		while ($authorPosts->have_posts()) {
			$authorPosts->the_post();
			global $post;
			$count += (int) get_comments_number($post->ID);
		}

		wp_reset_postdata();
		if ($echo) echo format_big_numbers($count); else return $count;
	}
endif;


if ( ! function_exists( 'pandapro_is_replied' ) ) :
    function pandapro_is_replied() {
        global $wpdb, $post;
        $email = null;
        $user_ID = (int) wp_get_current_user()->ID;
        if ($user_ID > 0) {
            $email = get_userdata($user_ID)->user_email; // 如果用户已登录,从登录信息中获取email
        } else if (isset($_COOKIE['comment_author_email_'.COOKIEHASH])) {
            $email = str_replace('%40','@',$_COOKIE['comment_author_email_'.COOKIEHASH]); // 如果用户未登录但电脑上有本站的Cookie信息，从Cookie里读取email
        } else {
            return false; //无法获取email，直接返回提示信息
        }
        if (empty($email)) {
            return false;
        }
        
        $email = sanitize_email($email);
        $query = "SELECT `comment_ID` FROM {$wpdb->comments} WHERE `comment_post_ID`={$post->ID} and `comment_approved`='1' and `comment_author_email`='{$email}' LIMIT 1";

        if ($wpdb->get_results($query)) {
            return true;
        }
        return false;
    }
endif;

if ( ! function_exists( 'pandapro_the_new_post_link' ) ) :
	function pandapro_the_new_post_link() {
		if (defined('NC_CONTRIBUTE_DIR') && defined('NC_APOLLO_DIR')) {
			$contribute_page = get_field('contri_page_template', 'option');
			echo get_page_link($contribute_page->ID);
			return;
		}
		echo admin_url('post-new.php');
	}
endif;

if ( ! function_exists( 'pandapro_the_author_role_name' ) ) :
	function pandapro_the_author_role_name($user_id) {
		echo defined('NC_APOLLO_DIR') ? get_custom_user_title( $user_id ) : get_translated_role_name(get_the_author_meta('ID'));
	}
endif;