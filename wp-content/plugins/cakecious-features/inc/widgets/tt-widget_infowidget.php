<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*-----------------------------------------------------------------------------------*/
/*	TWITTER WIDGET                                                                   */
/*-----------------------------------------------------------------------------------*/
if(!( class_exists('TT_Temptt_InfoWidget') )){
	class TT_Temptt_InfoWidget extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct(){
		parent::__construct(
			'temptt_widget_infowidget',
			'Theme: Info & Social',
			array( 'description' => 'Displays information and social links.' )
		);
		}

		/**
		 * Outputs the content of the widget
		 *
		 * @param array $args
		 * @param array $instance
		 */
		public function widget( $args, $instance ) {
	        extract( $args );
	        $simple_title = strip_tags($instance['simple_title']);
	        $simple_link = $instance['simple_link'];
	        $link_text = strip_tags($instance['link_text']);
	        $simple_text = $instance['simple_text'];
	        $show_social = trim($instance['show_social']);

	        ?>
			<?php
			$title = '';
			if (!empty($simple_title)) {
				$title = $args['before_title']. $simple_title .$args['after_title'];
			} ?>

			<?php echo $args['before_widget']. $title ; ?>

			<div class="widget-lpinfo">
				<?php echo wp_kses_post($simple_text) ?>
			</div>
			<?php if (!empty($link_text)) { ?>
			<div class="footer-read-more">
				<a href="<?php echo esc_url($simple_link); ?>"><?php echo esc_attr($link_text); ?> <i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i></a>
			</div>
			<?php }
			if($show_social == 'yes') {
				// social icons
				echo '<div class="footer-social">';
				get_template_part( 'templates/tt-social' );
				echo '</div>';
			}
			echo $args['after_widget'];
		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {
        //widgetform in backend
        $simple_title = isset($instance['simple_title'])?  strip_tags($instance['simple_title']) : '';
        $simple_link = isset($instance['simple_link'])?  $instance['simple_link'] : '';
        $link_text = isset($instance['link_text'])?  strip_tags($instance['link_text']) : '';
        $simple_text = isset($instance['simple_text'])?  $instance['simple_text'] : '';
        $show_social = isset($instance['show_social'])? $instance['show_social'] : 'yes' ;
        ?>
            <p>
                <label for="<?php echo esc_attr($this->get_field_id('simple_title')); ?>"><?php esc_html_e( 'Note: Social icons values will be fetched from themeoptions.', 'cakecious'); ?> <br /><?php esc_html_e('Widget title:', 'cakecious');?> </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('simple_title')); ?>" name="<?php echo esc_attr($this->get_field_name('simple_title')); ?>" type="text" value="<?php echo esc_attr($simple_title); ?>" />
            </p>
            <p>
                <label for="<?php echo esc_textarea($this->get_field_id('simple_text')); ?>"><?php esc_html_e('Text:', 'cakecious');?> </label>
                <textarea class="widefat" id="<?php echo esc_textarea($this->get_field_id('simple_text')); ?>" name="<?php echo esc_textarea($this->get_field_name('simple_text')); ?>"><?php echo esc_textarea($simple_text); ?></textarea>
            </p>
            <p>
                <label for="<?php echo esc_html($this->get_field_id('simple_link')); ?>"><?php esc_html_e('Link:', 'cakecious');?> </label>
                <input class="widefat" id="<?php echo esc_html($this->get_field_id('simple_link')); ?>" name="<?php echo esc_html($this->get_field_name('simple_link')); ?>" type="text" value="<?php echo esc_html($simple_link); ?>" />
            </p>
            <p>
                <label for="<?php echo  esc_attr($this->get_field_id('link_text')); ?>"><?php esc_html_e('Link text:', 'cakecious');?> </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('link_text')); ?>" name="<?php echo esc_attr($this->get_field_name('link_text')); ?>" type="text" value="<?php echo esc_attr($link_text); ?>" />
            </p>
            <p>
                <label for="<?php echo  esc_attr($this->get_field_id('show_social')); ?>"><?php esc_html_e('Show Social icon : yes/no', 'cakecious');?> </label>
                <input class="widefat" id="<?php echo esc_attr($this->get_field_id('show_social')); ?>" name="<?php echo esc_attr($this->get_field_name('show_social')); ?>" type="text" value="<?php echo esc_attr($show_social); ?>" />
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
	function tt_temptt_register_infowidget_widget(){
	     register_widget( 'TT_Temptt_InfoWidget' );
	}
	add_action( 'widgets_init', 'tt_temptt_register_infowidget_widget');
}
