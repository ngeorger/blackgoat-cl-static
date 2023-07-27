<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*-----------------------------------------------------------------------------------*/
/*	TWITTER WIDGET                                                                   */
/*-----------------------------------------------------------------------------------*/
if(!( class_exists('TT_Temptt_Twitter_Widget') )){
	class TT_Temptt_Twitter_Widget extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct(){
			parent::__construct(
				'temptt-twitter-widget', // Base ID
				__('Theme: Twitter Widget', 'cakecious'), // Name
				array( 'description' => __( 'Add a Twitter feed widget', 'cakecious' ), ) // Args
			);
		}

		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
			echo $args['before_widget'];

			if ( ! empty( $instance['title'] ) )
				echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];

			if ( isset( $instance['username'] ) )
				echo '<div class="tt-tw-feed"><div id="tt-show-tweets" class="tt-tweets" data-widget-num="'. $instance['numoftweet'] .'" data-widget-user="'. $instance['username'] .'"></div></div>';

			echo $args['after_widget'];
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {

			$defaults = array(
				'title' => 'Twitter Feed',
				'username' => '',
				'numoftweet' => '2'
			);
			$instance = wp_parse_args((array) $instance, $defaults);
			extract($instance);
		?>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php _e( 'Widget Title:' ); ?></label>
				<input class="widgettitle" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr(esc_attr( $title )); ?>">
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'username' )); ?>"><?php _e( 'Twitter Widget Username', 'cakecious' ); ?>
				<p class="description">
				<?php _e( 'e.g: themeforest', 'cakecious' ); ?></p></label>
				<input class="widgettitle" id="<?php echo esc_attr($this->get_field_id( 'username' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'username' )); ?>" type="text" value="<?php echo esc_attr( $username ); ?>">
			</p>

			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'numoftweet' )); ?>"><?php _e( 'Number of tweets', 'cakecious' ); ?>
				<p class="description">
				<?php _e( 'e.g: 2', 'cakecious' ); ?></p></label>
				<input class="widgettitle" id="<?php echo esc_attr($this->get_field_id( 'numoftweet' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'numoftweet' )); ?>" type="text" value="<?php echo esc_attr( $numoftweet ); ?>">
			</p>

		<?php
		}

		/**
		 * Processing widget options on save
		 */
		public function update( $new_instance, $old_instance ) {
			return $new_instance;
		}
	}
	function tt_temptt_register_twitter_widget(){
	     register_widget( 'TT_Temptt_Twitter_Widget' );
	}
	add_action( 'widgets_init', 'tt_temptt_register_twitter_widget');
}
