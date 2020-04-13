<?php
class Single_Post_Card extends WP_Widget
{

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct()
	{
		$widget_ops = array(
			'classname' => 'Single_Post_Card',
			'description' => 'Panda PRO - 单文卡片',
		);
		parent::__construct('Single_Post_card', 'Panda PRO - 单文卡片', $widget_ops);
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance)
	{

		if (!isset($args['widget_id'])) {
			$args['widget_id'] = $this->id;
		}

		$widget_id = 'widget_' . $args['widget_id'];
		$type   = get_field('type', $widget_id);
		$days  = get_field('days', $widget_id);
		$date_query = array(
			array(
				'column' => 'post_date',
				'after' => "-$days days",
			)
		);

		$title = !empty(get_field('title', $widget_id)) ? get_field('title', $widget_id) : __('Single Post Card', 'pandapro');
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters('widget_title', $title, $instance, $this->id_base);

		echo $args['before_widget'];

		switch ($type) {
			case 'history_post':
				$time = time();
				$query_args = array(
					'type'                => 'post',
					'posts_per_page'      => 1,
					'post_status'		=> 'publish',
					'day' => date("d", $time),
					'monthnum' => date("n", $time),
					'date_query'   => $date_query
				);
				break;

			case 'random_post':
				if (is_author()) {
					$query_args = array(
						'type'                => 'post',
						'posts_per_page'      => 1,
						'orderby'             => 'rand',
						'post_status'		=> 'publish',
						'author__in'		  => get_the_author_meta('ID'),
						'ignore_sticky_posts' => 1,
						'date_query'   => $date_query
					);
				} else {
					$query_args = array(
						'type'                => 'post',
						'posts_per_page'      => 1,
						'orderby'             => 'rand',
						'post_status'		=> 'publish',
						'ignore_sticky_posts' => 1,
						'date_query'   => $date_query,
					);
				}
				break;
			default:
				$query_args = null;
				break;
		}

		$queryPosts = new WP_Query($query_args);
		// $queryPosts = pandapro_get_cached_query('widget_single_post_card_'.$this->id, $query_args, DAY_IN_SECONDS / 2);
		if ($queryPosts->have_posts()) :
			while ($queryPosts->have_posts()) : $queryPosts->the_post();
				get_template_part_with_vars('template-parts/single-post-card', array(
					'type' => $type,
					'author' => get_the_author_meta('ID')
				));
			endwhile;
		endif;
		wp_reset_postdata();
		echo $args['after_widget'];
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form($instance)
	{
		return $instance;
	}
}

function reg_single_post_card()
{
	register_widget("Single_Post_card");
}

add_action('widgets_init', 'reg_single_post_card');
