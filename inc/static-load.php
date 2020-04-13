<?php

/**
 * Enqueue scripts and styles.
 */
function pandapro_scripts() {
	$panda_option = get_option('panda_option');

	wp_enqueue_style( 'nicetheme-iconfont', get_template_directory_uri() . '/fonts/iconfont.css' );
	wp_enqueue_style( 'nicetheme-nicetheme', get_template_directory_uri() . '/css/nicetheme.css' );
	wp_enqueue_style( 'nicetheme-style', get_stylesheet_uri() );
	global $post;

	wp_localize_script( 'jquery', 'globals',
		array(
			"ajax_url"             => admin_url("admin-ajax.php"),
			"url_theme"            => get_template_directory_uri(),
			"site_url"             => get_bloginfo('url'),
			"post_id"			   => is_single() ? $post->ID : 0
		)
	);



	wp_localize_script( 'jquery', '__',
		array(
			'load_more' => __('Load more...', 'pandapro'),
			'reached_the_end' => __('You\'ve reached the end.', 'pandapro'),
			'thank_you' => __('Thank you!', 'pandapro'),
			'success' => __('Success!', 'pandapro'),
			'cancelled' => __('Cancelled.', 'pandapro')
		)
	);

	wp_register_script( 'nicetheme-ajax-comments', get_template_directory_uri() . '/js/ajax-comment.js', array('jquery'), THEME_VERSION, true );
	wp_register_script( 'nicetheme-resizeseneor', get_template_directory_uri() . '/js/ResizeSensor.min.js', array('jquery'), THEME_VERSION, true );
	wp_register_script( 'nicetheme-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.min.js', array('jquery'), THEME_VERSION, true );
	wp_register_script( 'nicetheme-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), THEME_VERSION, true );
	if (!is_admin()) {
		
		wp_enqueue_script( 'nicetheme-popper', get_template_directory_uri() . '/js/popper.min.js', array('jquery'), THEME_VERSION, true );
		wp_enqueue_script( 'nicetheme-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), THEME_VERSION, true );
		wp_enqueue_script( 'nicetheme-plugins', get_template_directory_uri() . '/js/plugins.min.js', array('jquery'), THEME_VERSION, true );
		
		if ( is_home()) {
    		wp_enqueue_script( 'nicetheme-carousel' );
		}
		wp_enqueue_script( 'nicetheme-resizeseneor' );
		wp_enqueue_script( 'nicetheme-sticky-sidebar' );
		wp_enqueue_script( 'nicetheme-js', get_template_directory_uri() . '/js/nicetheme.js', array('jquery'), THEME_VERSION, true );
		if ( is_singular() && comments_open() ) {
    		wp_enqueue_script( 'nicetheme-ajax-comments' );
        }

	}
}
add_action( 'wp_enqueue_scripts', 'pandapro_scripts' );

function my_acf_input_admin_footer() {
?>
	<script type="text/javascript">
		(function($) {
			function toggleField() {
				var field = '.acf-field-5c5afa7ba7296'
				if ($(field).length) {
					var styleType = $('.acf-image-select-selected input:checked').attr('value')
					if (styleType === 'banner-style-1') {
						$('.acf-field-5ce95aff61d2d').show()
						$('.acf-field-5df1963be30b6').hide()
					} else {
						$('.acf-field-5ce95aff61d2d').hide()
						$('.acf-field-5df1963be30b6').show()
					}
				}
			}
			toggleField()
			$('.acf-field-5c5afa7ba7296 .acf-image-select').click(toggleField)
		})(jQuery);	
	</script>
<?php
}
add_action('acf/input/admin_footer', 'my_acf_input_admin_footer');