<?php
/*
            /$$
    /$$    /$$$$
   | $$   |_  $$    /$$$$$$$
 /$$$$$$$$  | $$   /$$_____/
|__  $$__/  | $$  |  $$$$$$
   | $$     | $$   \____  $$
   |__/    /$$$$$$ /$$$$$$$/
          |______/|_______/
================================
        Keep calm and get rich.
                    Is the best.

  	@Author: Dami
  	@Date:   2017-09-11 15:45:50
  	@Last Modified by:   Dami
  	@Last Modified time: 2018-09-25 14:38:50

*/

class Daily_News extends WP_Widget {

	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		$widget_ops = array(
			'classname' => 'Daily_News',
			'description' => __('Panda PRO - Daily News', 'pandapro'),
		);
		parent::__construct( 'Daily_News', __('Panda PRO - Daily News', 'pandapro'), $widget_ops );
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
		$num = get_field('num', $widget_id);
		$title = get_field('title', $widget_id);
		$term = get_field('cat', $widget_id);

        echo $args['before_widget'];
        
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
        }
        
        $query_args = array(
            'post_type' => 'news',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
			'posts_per_page' => $num,
			'tax_query'         => array(
				array(
					'taxonomy'  => 'news-category',
					'terms'     => $term
				)
			)
        );

		$queryPosts = new WP_Query($query_args);
?>
    <?php if ($queryPosts->have_posts()) : ?>
        <div class="card-body">
            <div class="list-news my-n2" id="<?php echo "news_{$this->id}_collapse" ?>">
            <?php
                    $index = 0;
                    while ($queryPosts->have_posts()) : $queryPosts->the_post();
                    $post_id = get_the_ID();
                    $index++;
            ?>
                    <div class="list-news-item <?php echo $index == 1 ? 'active' : '' ?>">
                        <div class="list-news-dot"></div>
                        <div class="list-news-body">
                            <div class="list-news-content mt-2 pb-1">
                                <div class="text-sm"  id="<?php echo "news_title_$post_id" ?>"><a href="<?php echo "#news_link_$post_id" ?>" data-toggle="collapse" aria-expanded="false" aria-controls="<?php echo "news_link_$post_id" ?>"><?php the_title() ?></a></div>
                                <div class="text-xs text-muted my-1"><?php pandapro_the_time(); ?></div>
                                <div class="list-news-desc text-xs text-secondary collapse" id="<?php echo "news_link_$post_id" ?>" aria-labelledby="<?php echo "news_title_$post_id" ?>" data-parent="<?php echo "#news_{$this->id}_collapse" ?>"><?php pandapro_print_excerpt(76) ?><a href="<?php the_permalink() ?>" target="_blank" title="<?php the_title() ?>">[阅读全文]</a></div>
                            </div>
                        </div>
                    </div>
            <?php
                    endwhile;
            ?>
            </div>
            <div class="mt-3"><a href="<?php echo get_term_link($term) ?>" target="_blank" class="btn btn-outline-primary btn-block"><?php _e('More', 'pandapro') ?></a></div>
        </div>
    <?php
        else:
            echo '<div class="card-body"><div class="py-2"><div class="text-sm text-muted text-center bg-light py-4">' . __('Not found any posts...', 'pandapro') . '</div></div></div>';
        endif;
        wp_reset_postdata();
    ?>
<?php
        echo $args['after_widget'];
	}
}

function reg_daily_news() {
	register_widget("Daily_News");
}
add_action( 'widgets_init', 'reg_daily_news');