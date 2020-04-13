<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Panda PRO
 */

/**
 * 字符串截取，支持中文和其他编码
 *
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断字符串后缀
 * @return string
 */
function pandapro_substr_ext($str, $start = 0, $length = 0, $charset = 'utf-8', $suffix = '') {
    if (function_exists("mb_substr")) {
         return mb_substr($str, $start, $length, $charset).$suffix;
    }
    elseif(function_exists('iconv_substr')){
         return iconv_substr($str,$start,$length,$charset).$suffix;
    }
    $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("",array_slice($match[0], $start, $length));
    return $slice.$suffix;
}

function pandapro_reverse_strrchr($haystack, $needle, $trail) {
	$length = (strrpos($haystack, $needle) + $trail);
    return strrpos($haystack, $needle) ? substr($haystack,0,$length) : false;
}

/**
 * 获取完整的句子
 */
function pandapro_print_excerpt($length, $post = null, $echo = true) {
	global $post;
	$text = $post->post_excerpt;

	if ( '' == $text ) {
		$text = get_the_content();
		$text = strip_shortcodes($text);
		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]>', $text);
	}

	$text = strip_shortcodes($text);
	$text = strip_tags($text);

	$text = pandapro_substr_ext($text,0,$length);
	$excerpt = pandapro_reverse_strrchr($text, '。', 3);

	if( $excerpt ) {
		$result = strip_tags(apply_filters('the_excerpt',$excerpt)).'...';
	} else {
		$result = strip_tags(apply_filters('the_excerpt',$text)).'...';
	}
	if ($echo == true) echo $result; else return $result;
}

function pandapro_post_thumbnail_src($post = null) {
    $panda_option = get_option('panda_option');

	if( $post === null ){
    	global $post;
	}
    $post_thumbnail_src = '';

   	if (has_post_thumbnail($post)) {
        $post_thumbnail_src = get_post_thumbnail_id($post->ID);
        $post_thumbnail_src = wp_get_attachment_image_src($post_thumbnail_src, 'full');
        $post_thumbnail_src = $post_thumbnail_src[0];
    } else {
        $post_thumbnail_src = '';
        $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
        if (!empty($matches[1][0])) {
            global $wpdb;
            $att = $wpdb->get_row( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid LIKE '%s'", $matches[1][0] ) );

            if ($att) {
                $post_thumbnail_src =  wp_get_attachment_image_src($att->ID, 'full');
                $post_thumbnail_src = $post_thumbnail_src[0];
            } else {
                $post_thumbnail_src = $matches[1][0];
            }
        } else {
            $site_default_img = $panda_option['default_thumbnail'];
            if (isset( $site_default_img ) && !empty( $site_default_img )) {
                $post_thumbnail_src = $site_default_img;
            } else { 
                $post_thumbnail_src = get_template_directory_uri().'/images/default.png';
            }
        }
    }
    return $post_thumbnail_src;
}


function pandapro_get_head_img( $id, $size = array('w' => 900, 'h' => 300) ) {
    $img = !empty(get_post_meta($id, 'head_img_url', true)) ? get_post_meta($id, 'head_img_url', true) : pandapro_post_thumbnail_src(get_post($id));
    return timthumb($img, $size);
}


// add @
function pandapro_comment_add_at( $comment_text, $comment = '') {
    if (!empty($comment) && $comment->comment_parent > 0) {
        $comment_text = '<a rel="nofollow" class="comment_at" href="#comment-' . $comment->comment_parent . '">@'.get_comment_author( $comment->comment_parent ) . '</a> ' . $comment_text;
    }
    return $comment_text;
}
add_filter( 'comment_text' , 'pandapro_comment_add_at', 10, 2);

/**
 * 时间定制
 */
function pandapro_timeago($ptime = null, $post = null) {
    if ($post === null) global $post;
    $ptime = $ptime ?: get_post_time('G', false, $post);
    return human_time_diff($ptime, current_time('timestamp')) . '前';
}


 /**
 * Replace permalink segment with post ID
 *
 */
function pandapro_news_post_type_permalink( $post_link, $id = 0, $leavename ) {
    global $wp_rewrite;
    $post = get_post( $id );
    if ( is_wp_error( $post ) )
        return $post;
    if (get_post_type($post) === 'news') {
        $newlink = $wp_rewrite->get_extra_permastruct( 'news' );
        $newlink = str_replace( '%news_id%', $post->ID, $newlink );
        $newlink = home_url( user_trailingslashit( $newlink ) );
        return $newlink;
    }
    return $post_link;
}
add_filter('post_type_link', 'pandapro_news_post_type_permalink', 1, 3);

add_action( 'show_user_profile', 'pandapro_extra_user_profile_fields' );
add_action( 'edit_user_profile', 'pandapro_extra_user_profile_fields' );
function pandapro_extra_user_profile_fields( $user ) { ?>
    <h3><?php _e('额外信息'); ?></h3>
    
    <table class="form-table">
        <tr>
            <th><label for="donate_image"><?php _e('赞赏二维码地址'); ?></label></th>
            <td>
                <input type="text" name="donate_image" id="donate_image" value="<?php echo esc_attr( get_the_author_meta( 'donate_image', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("请输入赞赏二维码图片地址"); ?></span>
            </td>
        </tr>
    </table>
<?php }
 
add_action( 'personal_options_update', 'pandapro_save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'pandapro_save_extra_user_profile_fields' );
 
function pandapro_save_extra_user_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
	update_usermeta( $user_id, 'donate_image', $_POST['donate_image'] );
}

function pandapro_record_visitors() {
    if (is_singular()) {
        global $post;
        $post_ID = $post->ID;
        if($post_ID)
        {
          $post_views = (int)get_post_meta($post_ID, 'views', true);
          if(!update_post_meta($post_ID, 'views', ($post_views+1)))
          {
            add_post_meta($post_ID, 'views', 1, true);
          }
        }
    }
}
add_action('wp_head', 'pandapro_record_visitors');

function pandapro_post_views($before = '(点击 ', $after = ' 次)', $echo = 1) {
    global $post;
    $post_ID = $post->ID;
    $views = (int)get_post_meta($post_ID, 'views', true);
    if ($echo) echo $before, number_format($views), $after;
    else return $views;
}

function timthumb( $src, $size = null, $set = null ){

    $panda_option = get_option('panda_option');
    $modular = $panda_option['thumbnail_handle'];

	if (is_numeric($src) && $size === null && $set === null) {
		return wp_get_attachment_image_src($src, 'full')[0];
	}

	if( is_numeric( $src ) ){
		if( $modular == 'timthumb_php' ){
			$src = image_downsize( $src, $size['w'].'-'.$size['h'] );
		}else{
			$src = image_downsize( $src, 'full' );
		}
		$src = $src[0];
	}

	if( 'qiniu' == $modular ){
		if( !empty( $size ) ){
			$sep = $panda_option['thumbnail_handle_qiniu_sep'];
			$sep = empty( $sep ) ? '!' : $sep;
			return sprintf( $src . $sep . 'imageView2/1/w/%s/h/%s/sharpen/1/interlace/1', round( $size['w'] ), round( $size['h'] ) );
		}else{
			return $src;
		}

	}

	if( 'upyun' == $modular ){
		if(!empty( $size ) ){
			$sep = $panda_option['thumbnail_handle_upyun_sep'];
			$sep = empty( $sep ) ? '!' : $sep;
			return sprintf( $src . $sep . 'upyun520/both/%sx%s/quality/100/unsharp/true/progressive/true', round( $size['w'] ), round( $size['h'] ) );
		} else {
			return $src;
		}

	}

	if( 'aliyunoss' == $modular ){

		if (!empty($size)) {

			$sep = $panda_option['thumbnail_handle_aliyunoss_sep'];
			$sep = empty( $sep ) ? '?' : $sep;

			return sprintf( $src . $sep . 'x-oss-process=image/resize,w_%s,h_%s,m_fill/sharpen,100', round( $size['w'] ), round( $size['h'] ) );

		} else {
			return $src;
		}

	}

	if (($modular == 'timthumb_php' || empty($modular)) && $size !== null ) {
		return get_stylesheet_directory_uri().'/timthumb.php?src='.$src.'&h='.$size["h"].'&w='.$size['w'].'&zc=1&a=c&q=100&s=1';
	} else {
		return $src;
	}
}


function pandapro_the_thumbnail($post = null, $size = array('w' => 450, 'h' => 300), $set = 'small') {
    echo timthumb(pandapro_post_thumbnail_src($post), $size, $set);
}

add_filter( 'get_the_archive_title', function ($title) {
    if ( is_category() ) {
        $title = single_cat_title( '', false );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '#', false );
    } elseif ( is_author() ) {
        $title = get_the_author();
    }

    return $title;
});

/**
 * ajax 随机一文
 */
add_action('wp_ajax_nopriv_ajax_refresh_random_post', 'ajax_refresh_random_post');
add_action('wp_ajax_ajax_refresh_random_post', 'ajax_refresh_random_post');
function ajax_refresh_random_post() {
    $author_id = isset($_POST['id']) ? sanitize_text_field($_POST['id']) : null;

    if (!empty($author_id)) {
        $args = array(
            'type'                => 'post',
            'posts_per_page'      => 1,
            'orderby'             => 'rand',
            'author__in'          => $author_id,
            'ignore_sticky_posts' => 1
        );
    } else {
        $args = array(
            'type'                => 'post',
            'posts_per_page'      => 1,
            'orderby'             => 'rand',
            'ignore_sticky_posts' => 1
        );
    }
    
    $queryPosts = new WP_Query( $args );

    if ( $queryPosts->have_posts() ) {
        while ( $queryPosts->have_posts() ) {
            $queryPosts->the_post();
            get_template_part_with_vars('template-parts/single-post-card', array(
                'type' => 'random_post',
                'author' => $author_id
            ));
        }
    }
    wp_reset_postdata();
	wp_die();
}

function get_translated_role_name($user_id) {
    $data  = get_userdata( $user_id );
    $roles = $data->roles;
    if ( in_array('administrator', $roles) ) {
        return __('Administrator', 'pandapro');
    } else if ( in_array('editor', $roles) ) {
        return __('Certified Editor', 'pandapro');
    } else if ( in_array('author', $roles) ) {
        return __('Special Author', 'pandapro');
    } else if ( in_array ('subscriber', $roles) ) {
        return __('Subscriber', 'pandapro');
    }

    return __('Contributor', 'pandapro');
}

function get_translated_role_level($user_id) {
    $data  = get_userdata( $user_id );
    $roles = $data->roles;

    if ( in_array('administrator', $roles) ) {
        return 'v4';
    } else if ( in_array('editor', $roles) ) {
        return 'v3';
    } else if ( in_array('author', $roles) ) {
        return 'v2';
    } else if ( in_array ('subscriber', $roles) ) {
        return 'v1';
    }

    return 'v1';
}

/**
 * Load a component into a template while supplying data.
 *
 * @param string $slug The slug name for the generic template.
 * @param array $params An associated array of data that will be extracted into the templates scope
 * @param bool $output Whether to output component or return as string.
 * @return string
 */
function get_template_part_with_vars($slug, array $params = array(), $output = true) {
	if(!$output) ob_start();
	$template_file = locate_template("{$slug}.php", false, false);
    extract(array('template_params' => $params), EXTR_SKIP);
    require($template_file);
	if(!$output) return ob_get_clean();
}


/**
 * 文章引用
 */
function insert_posts_shortcode($atts, $content = null) {
    extract( shortcode_atts( array(
        'ids' => ''
    ),$atts ) );
    global $post;
    $content = '';
    $postids =  explode(',', $ids);
    $insert_posts = get_posts(array('post__in'=>$postids));
    foreach ($insert_posts as $key => $post) {
        setup_postdata( $post );
        include( get_stylesheet_directory() . '/template-parts/shortcodes/insert-post.php' );
        $content .= $insert_post;
        wp_reset_postdata();
    }
    return $content;
}
add_shortcode('suxing_insert_post', 'insert_posts_shortcode');

/**
 * 评论引用
 */
function insert_comments_shortcode($atts, $content = null) {
	extract( shortcode_atts( array(
		'ids' => ''
	),$atts ) );
	$content = '';
	$comment_ids =  explode(',', $ids);
	$comments = get_comments( array(
		'comment__in' => $comment_ids
	) );

	foreach ($comments as $key => $value) {
		include( get_stylesheet_directory() . '/template-parts/shortcodes/insert-comments.php' );
		$content .= $comment;
	}

	return $content;
}
add_shortcode( 'suxing_insert_comments', 'insert_comments_shortcode' );

function format_big_numbers($num) {
    return $num >= 1000 ? floor($num / 1000).'K' : $num;
}

add_filter( "get_comment_author_link", "pandapro_modify_comment_author_anchor" );
function pandapro_modify_comment_author_anchor( $author_link ){
    return str_replace( "<a", "<a target='_blank'", $author_link );
}


add_filter( 'avatar_defaults', 'pandapro_default_gravatar' );
function pandapro_default_gravatar($avatar_defaults) {
    $panda_option = get_option('panda_option');
    $default = $panda_option['default_comment_avatar'];

	if (!empty($default)) {
        $avatar_defaults[$default] = "Panda PRO 默认头像";
	}
	
	return $avatar_defaults;
}

add_action( 'init', 'pandapro_default_avatar_option' );
function pandapro_default_avatar_option() {
    $panda_option = get_option('panda_option');
	if (is_admin() && isset( $_GET['page'] ) && $_GET['page'] == 'theme_options') {
        $default = $panda_option['default_comment_avatar'];
        
		if (!empty($default)) {
		    !empty($img) && update_option( 'avatar_default', $default, 'yes' );
		} else {
			update_option('avatar_default', 'mystery', 'yes');
		}
	}
}

add_filter( 'mce_buttons', 'pandapro_add_next_page_button', 1, 2 ); 
function pandapro_add_next_page_button($buttons, $id) {
    if ( 'content' != $id )
        return $buttons;

    array_splice( $buttons, 13, 0, 'wp_page' );
    return $buttons;
}
function pandapro_more_post_thumbnails($post = null) {
	if( $post === null ){
    	global $post;
    }
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    return !empty($matches[1]) ? $matches[1] : array();
}
add_filter('comment_form_field_cookies','__return_false');


add_action('wp_ajax_nopriv_ajax_comment', 'ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'ajax_comment_callback');
function ajax_comment_callback() {
    global $wpdb;
    $comment_post_ID = isset($_POST['comment_post_ID']) ? (int) $_POST['comment_post_ID'] : 0;
    $post = get_post($comment_post_ID);
    $post_author = $post->post_author;
    if ( empty($post->comment_status) ) {
        do_action('comment_id_not_found', $comment_post_ID);
        ajax_comment_err('Invalid comment status.');
    }
    $status = get_post_status($post);
    $status_obj = get_post_status_object($status);
    if ( !comments_open($comment_post_ID) ) {
        do_action('comment_closed', $comment_post_ID);
        ajax_comment_err(__( 'Sorry, comments are closed.', 'pandapro' ));
    } elseif ( 'trash' == $status ) {
        do_action('comment_on_trash', $comment_post_ID);
        ajax_comment_err(__( 'Unknown error.', 'pandapro' ));
    } elseif ( !$status_obj->public && !$status_obj->private ) {
        do_action('comment_on_draft', $comment_post_ID);
        ajax_comment_err(__( 'Unknown error.', 'pandapro' ));
    } elseif ( post_password_required($comment_post_ID) ) {
        do_action('comment_on_password_protected', $comment_post_ID);
        ajax_comment_err(__( 'Password protected.', 'pandapro' ));
    } else {
        do_action('pre_comment_on_post', $comment_post_ID);
    }

    $comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
    $comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
    $comment_author_url   = ( isset($_POST['url']) )     ? trim($_POST['url']) : null;
    $comment_content      = ( isset($_POST['comment']) ) ? trim($_POST['comment']) : null;
    $user = wp_get_current_user();
    if ( $user->exists() ) {
        if ( empty( $user->display_name ) )
            $user->display_name=$user->user_login;
        $comment_author       = esc_sql($user->display_name);
        $comment_author_email = esc_sql($user->user_email);
        $comment_author_url   = esc_sql($user->user_url);
        $user_ID              = esc_sql($user->ID);

    } else {
        if ( get_option('comment_registration') || 'private' == $status )
            ajax_comment_err('<p>'.__('Sorry, you must be logged in to leave a comment', 'pandapro').'</p>'); // 抱歉，您必须登录后才能发表评论。
    }
    $comment_type = '';
    if ( get_option('require_name_email') && !$user->exists() ) {
        if ( 6 > strlen($comment_author_email) || '' == $comment_author )
            ajax_comment_err( '<p>'.__('Please fill in the required options (Name, Email).', 'pandapro').'</p>' ); // 错误：请填写必须的选项（姓名，电子邮件）。
        elseif ( !is_email($comment_author_email))
            ajax_comment_err( '<p>'.__('Please input a valid email address.', 'pandapro').'</p>' ); // 错误：请输入有效的电子邮件地址。
    }
    if ( '' == $comment_content )
        ajax_comment_err( '<p>'.__('Say something...', 'pandapro').'</p>' ); // 说点什么吧
    $dupe = "SELECT comment_ID FROM $wpdb->comments WHERE comment_post_ID = '$comment_post_ID' AND ( comment_author = '$comment_author' ";
    if ( $comment_author_email ) $dupe .= "OR comment_author_email = '$comment_author_email' ";
    $dupe .= ") AND comment_content = '$comment_content' LIMIT 1";
    if ( $wpdb->get_var($dupe) ) {
        ajax_comment_err('<p>'.__('Please do not repeat your comments. :)', 'pandapro').'</p>'); // Do not repeat comments aha~似乎说过这句话了
    }

    if ( $lasttime = $wpdb->get_var( $wpdb->prepare("SELECT comment_date_gmt FROM $wpdb->comments WHERE comment_author = %s ORDER BY comment_date DESC LIMIT 1", $comment_author) ) ) {
        $time_lastcomment = mysql2date('U', $lasttime, false);
        $time_newcomment  = mysql2date('U', current_time('mysql', 1), false);
        $flood_die = apply_filters('comment_flood_filter', false, $time_lastcomment, $time_newcomment);
        if ( $flood_die ) {
            ajax_comment_err('<p>'.__('You reply too fast. Take it easy.', 'pandapro').'</p>'); // 你回复太快啦。慢慢来。
        }
    }
    $comment_parent = isset($_POST['comment_parent']) ? absint($_POST['comment_parent']) : 0;
    $commentdata = compact('comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_content', 'comment_type', 'comment_parent', 'user_ID');

    $comment_id = wp_new_comment( $commentdata );


    $comment = get_comment($comment_id);
    do_action('set_comment_cookies', $comment, $user, true);
    $comment_depth = 1;
    $tmp_c = $comment;
    while($tmp_c->comment_parent != 0){
        $comment_depth++;
        $tmp_c = get_comment($tmp_c->comment_parent);
    }
    $GLOBALS['comment'] = $comment;
    get_template_part('comment');
    ?>
    <?php
        die();
}
function ajax_comment_err($a) {
    header('HTTP/1.0 500 Internal Server Error');
    header('Content-Type: text/plain;charset=UTF-8');
    echo $a;
    exit;
}

add_action('wp_ajax_nopriv_ajax_load_comments', 'ajax_load_comments');
add_action('wp_ajax_ajax_load_comments', 'ajax_load_comments');
function ajax_load_comments() {

	global $wp_query;

	$type  = sanitize_text_field( $_POST['type'] );
	$paged = sanitize_text_field( $_POST['paged'] );

    $q = sanitize_text_field( $_POST['query'] );

    if( $paged < 1 || $paged > $_POST['commentcount'] ){
        wp_die();
    }

    if ($type === 'page') {
        $wp_query = new WP_Query( array( 'page_id' => $q, 'cpage' => $paged ) );
    }

    if ($type === 'post') {
        $wp_query = new WP_Query( array( 'p' => $q, 'cpage' => $paged ) );
    }

    if ( have_posts() ) {
        while ( have_posts() ) {
            the_post();
            comments_template();
        }
    }

	wp_reset_postdata();
	wp_die();
}

/**
 * 获取评论下一页页码
 */
function get_next_page_number() {
	$page_number = get_comment_pages_count();
	if( get_option('default_comments_page') == 'newest' ){
		$next_page = $page_number - 1;
	}else{
		$next_page = 2;
	}
	return $next_page;
}
function pandapro_remove_wpautop_function() {
    remove_filter('acf_the_content', 'wpautop');
}
add_action( 'after_setup_theme', 'pandapro_remove_wpautop_function' );

add_action('wp_ajax_nopriv_pandapro_like', 'pandapro_like');
add_action('wp_ajax_pandapro_like', 'pandapro_like');
function pandapro_like() {
    global $wpdb,$post;
    $id = $_POST["id"];
    $action = $_POST["like_action"];
    $pandapro_raters = get_post_meta($id,'suxing_ding',true);
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;

    $user_id = is_user_logged_in() ? wp_get_current_user()->ID : 0;

    if ($action == 'like') {
        $expire = time() + 99999999;
        if (!isset($_COOKIE['suxing_ding_'.$id])) {
            setcookie('suxing_ding_'.$id,$id,$expire,'/',$domain,false);
            if (!$pandapro_raters || !is_numeric($pandapro_raters)) {
                update_post_meta($id, 'suxing_ding', 1);
            } else {
                update_post_meta($id, 'suxing_ding', ($pandapro_raters + 1));
            }
        }
        do_action('pandapro_like', $id, $user_id);
    }
    if ($action == 'unlike') {
        $expire = time() - 1;
        if (isset($_COOKIE['suxing_ding_'.$id])) {
            setcookie('suxing_ding_'.$id,$id,$expire,'/',$domain,false);
            update_post_meta($id, 'suxing_ding', ($pandapro_raters - 1));
        }
        do_action('pandapro_unlike', $id, $user_id);
    }
    echo get_post_meta($id,'suxing_ding',true);
    die;
}


// dark mode
add_action('wp_ajax_nopriv_pandapro_toggle_dark_mode', 'pandapro_toggle_dark_mode');
add_action('wp_ajax_pandapro_toggle_dark_mode', 'pandapro_toggle_dark_mode');
function pandapro_toggle_dark_mode() {
    $action = $_POST["toggle_action"];
    $domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
    $expire = time() + 99999999;
    setcookie('Apollo_dark_mode', $action, $expire, '/', $domain, false);
    die;
}

function pandapro_get_dark_mode_status() {
    $panda_option = get_option('panda_option');
    $dark_mode = $panda_option['dark_mode_detail'];
    if ($dark_mode['frontend']) {
        return isset($_COOKIE['Apollo_dark_mode']) ? $_COOKIE['Apollo_dark_mode'] === 'on' : $dark_mode['default'];
    }
	return !empty($panda_option['dark_mode']) ? $panda_option['dark_mode'] : false;
}

/**
 * ajax
 */
add_action('wp_ajax_nopriv_ajax_load_posts', 'ajax_load_posts');
add_action('wp_ajax_ajax_load_posts', 'ajax_load_posts');
function ajax_load_posts() {

	global $wp_query;

	$page  = sanitize_text_field( $_POST['page'] );
    $paged = sanitize_text_field( $_POST['paged'] );
    

    if( $page == 'home' ){

		$tabcid = isset( $_POST['tabcid'] ) ? sanitize_text_field( $_POST['tabcid'] ) : null;

		if( $tabcid < 1 ){
			$fmt = explode('.', $tabcid);
			$tabcid = $fmt[0];
        }

		switch ($tabcid) {

			case -2: // home latest
				
                // $masking_cats = $cosy_option['masking_cats'];
				$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'ignore_sticky_posts' => 1 ) );

				// if( is_array( $masking_cats ) ){
				// 	$args['category__not_in'] = $masking_cats;
				// }

				break;

			case null:
				// $masking_cats = $cosy_option['masking_cats'];

				$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'ignore_sticky_posts' => 1 ) );

				// if( is_array( $masking_cats ) ){
				// 	$args['category__not_in'] = $masking_cats;
				// }

				break;
			
            default:
				$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'cat' => $tabcid, 'ignore_sticky_posts' => 1 ) );
				break;
		}

		$queryPosts = new WP_Query( $args );
    }
    

	if( $page == 'cat' ) {
        $q = sanitize_text_field( $_POST['query'] );
		$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'cat' => $q, 'ignore_sticky_posts' => 1 ) );
	}

	if( $page == 'tag' ) {
        $q = sanitize_text_field( $_POST['query'] );
		$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'tag' => $q, 'ignore_sticky_posts' => 1 ) );
	}

	if( $page == 'tax' ) {
        $q = sanitize_text_field( $_POST['query'] );
		$tax = array(
			array(
				'taxonomy' => 'special',
				'field'    => 'term_id',
				'terms' => $q
			),
		);
		$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'tax_query' => $tax, 'ignore_sticky_posts' => 1 ) );
    }
    
    if( $page == 'news-category' ) {
        $q = sanitize_text_field( $_POST['query'] );
		$tax = array(
            array(
                'taxonomy' => 'news-category',
                'terms'    =>  $q,
            )
		);
		$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'tax_query' => $tax, 'ignore_sticky_posts' => 1 ) );
	}

	if( $page == 'search' ){
        $q = sanitize_text_field( $_POST['query'] );
		$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_type' => 'post', 'post_status' => 'publish', 's' => $q, 'ignore_sticky_posts' => 1 ) );
    }
    
    if( $page == 'author' ) {
        $tabcid = isset($_POST['tabcid']) ? sanitize_text_field( $_POST['tabcid'] ) : 1;
        $q = sanitize_text_field( $_POST['query'] );

		switch ($tabcid) {
			case 2:
                $args = array( 'number' => 10, 'offset' => ($paged - 1) * 10, 'paged' => $paged, 'author__in' => $q );
				break;
			
            default:
				$args = array_merge( $wp_query->query_vars, array( 'paged' => $paged, 'post_status' => 'publish', 'author' => $q, 'ignore_sticky_posts' => 1 ) );
				break;
        }
        
        if ($tabcid == 2) {
            // comment
            $queryComments = new WP_Comment_Query();
            $comments = $queryComments->query($args);
            if ( !empty($comments) ) {
                foreach ( $comments as $comment ) {
                    get_template_part_with_vars("template-parts/post-cards/card-comment", array('comment' => $comment));
                }
            }
            wp_reset_postdata();
            wp_die();
            return;
        }
    }
    
    $queryPosts = new WP_Query($args);
    if ( $queryPosts->have_posts() ) {
        while ( $queryPosts->have_posts() ) {
            $queryPosts->the_post();
            if ($page == 'news-category') {
                get_template_part("template-parts/news-category-loop");
            } else {
                get_template_part("template-parts/post-cards/card", get_post_format());   
            }
        }
    }

    wp_reset_postdata();
	wp_die();
}

remove_action('pre_get_posts', 'pandapro_pre_get_posts');
add_action('pre_get_posts', 'pandapro_set_pre_get_posts');
function pandapro_set_pre_get_posts($query) {
    $panda_option = get_option('panda_option');
    if (!is_admin()) {
        if (!($query->is_main_query())) {
            $query->set('ignore_sticky_posts', true);
        }
        if ($query->is_search) {
			$query->set( 'post_type', 'post' );
		}
		if ($query->is_home() && $query->is_main_query()) {
			$masking_cats = $panda_option['masking_cats'];
			if (is_array($masking_cats)) {
				$query->set('category__not_in', $masking_cats);
			}
        }
    }
}
