<?php
class Author_Card extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'Author_Card',
			'description' => __('Panda PRO - Author Card', 'pandapro'),
		);
		parent::__construct( 'Author_Card', __('Panda PRO - Author Card', 'pandapro'), $widget_ops );
	}

	public function form($instance) { 
		return $instance;
	}



	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$widget_id = 'widget_' . $args['widget_id'];

		echo $args['before_widget'];
        if (get_the_author_meta('ID') > 0): 
?>
		<div class="widget-author-cover">
			<div class="media media-2x1">
		        <div class="media-content" style="background-image:url('<?php pandapro_the_author_cover(get_the_author_meta('ID'), array('w' => 400, 'h' => 200)) ?>')"></div>
		    </div>
		    <div class="widget-author-avatar">
	  	    	<div class="flex-avatar mx-2 w-80 border border-white border-2">
                    <?php echo get_avatar( get_the_author_meta('ID'), 80, '', '', array('class' => '80') ); ?>
	  	    	</div>
	  	  	</div>
  	  	</div>
      	<div class="widget-author-meta text-center p-4">
      	  	<div class="h6 mb-3"><?php the_author_meta('display_name') ?><small class="d-block"><span class="badge badge-outline-primary mt-2"><?php pandapro_the_author_role_name(get_the_author_meta('ID')) ?></span></small></div>
      	  	<div class="desc text-xs mb-3 h-2x"><?php the_author_meta('description') ?></div>
	    	<div class="row no-gutters text-center">
	      	  	<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" target="_blank" class="col">
	      	    	<span class="font-theme font-weight-bold text-md"><?php echo count_user_posts(get_the_author_meta('ID')) ?></span><small class="d-block text-xs text-muted"><?php _e('Posts', 'pandapro') ?></small>
	      	  	</a>
	      	  	<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" target="_blank" class="col">
	      	    	<span class="font-theme font-weight-bold text-md"><?php pandapro_the_author_comment_count(get_the_author_meta('ID')) ?></span><small class="d-block text-xs text-muted"><?php _e('Comments', 'pandapro') ?></small>
	      	  	</a>
	      	  	<a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>" target="_blank" class="col">
	      	    	<span class="font-theme font-weight-bold text-md"><?php pandapro_the_author_like_count(get_the_author_meta('ID')) ?></span><small class="d-block text-xs text-muted"><?php _e('Likes', 'pandapro') ?></small>
	      	  	</a>
	      	</div>
	    </div>
<?php
        endif;
        echo $args['after_widget'];
	}
}

function reg_author_card() {
	register_widget("Author_Card");
}
add_action( 'widgets_init', 'reg_author_card');