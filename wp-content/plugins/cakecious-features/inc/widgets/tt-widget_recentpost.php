<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*-----------------------------------------------------------------------------------*/
/*	Recent post widget                                                                   */
/*-----------------------------------------------------------------------------------*/
if(!( class_exists('TT_Temptt_Recentpost') )){
	class TT_Temptt_Recentpost extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct(){
		parent::__construct(
			'temptt_widget_recentpost',
			'Theme: Recent Post',
			array( 'description' => 'Displays recent posts with theme style.' )
		);
		}

		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		$posts_per_page = $instance['posts_per_page'];
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		// Save original posts
		global $posts;
		$original_posts = $posts;
		$posts = new WP_Query("posts_per_page=$posts_per_page");
		if( $posts->have_posts() ):
			
		// Buffer output
		ob_start();
		// Search for template in stylesheet directory
		$tt_rp_template = 'template-parts/cakecious-recentpost.php';
		if ( file_exists( STYLESHEETPATH . '/' . $tt_rp_template ) ) {
			load_template( STYLESHEETPATH . '/' . $tt_rp_template, false );
		} // Search for template in theme directory
		elseif ( file_exists( TEMPLATEPATH . '/' . $tt_rp_template ) ) {
			load_template( TEMPLATEPATH . '/' . $tt_rp_template, false );
		} // Search for template in plugin directory
		else { // no template found, load default template.

			?><div class="tt-recentpost-list"> <?php
			while( $posts->have_posts() ): $posts->the_post();?>

			<div class="item-popular-post clearfix">
				<?php if ( has_post_thumbnail()) { ?>
				<div class="img-box">
					<?php the_post_thumbnail(array(110, 85)); ?>
				</div>
				<?php } ?>
			    <?php the_title( sprintf( '<h5 class="news-link"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h5>' ); ?>
			    <div class="author">
			        <span><?php the_time( get_option( 'date_format' ) ); ?></span>
			    </div>
			</div>
				
				<?php
			endwhile;
			?></div><?php

		}

		endif;
		$output = ob_get_contents();
		ob_end_clean();
		// Return original posts
		$posts = $original_posts;
		// Reset the query
		wp_reset_postdata();
		print $output;
		print $args['after_widget'];
	}


		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
	public function form( $instance ) {
        //widgetform in backend
        $title = (isset($instance['title'])) ? strip_tags($instance['title']) : '';
        $posts_per_page = (isset($instance['posts_per_page'])) ? $instance['posts_per_page'] : '';

		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php  esc_html_e('Title ', 'setupfolio'); ?> </label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'posts_per_page' )); ?>"><?php  esc_html_e('Posts per page:', 'setupfolio'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'posts_per_page' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'posts_per_page' )); ?>" type="text" value="<?php echo ($posts_per_page) ? esc_attr( $posts_per_page ) : '3'; ?>" size="3" />
		</p>
		<?php
	}

		/**
		 * Processing widget options on save
		 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['posts_per_page'] = ( is_numeric( $new_instance['posts_per_page'] ) ) ? $new_instance['posts_per_page'] : '3';
		return $instance;
	}
	}
	function tt_temptt_register_recentpost_widget(){
	     register_widget( 'TT_Temptt_Recentpost' );
	}
	add_action( 'widgets_init', 'tt_temptt_register_recentpost_widget');
}
