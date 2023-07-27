<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/*-----------------------------------------------------------------------------------*/
/*	TWITTER WIDGET                                                                   */
/*-----------------------------------------------------------------------------------*/
if(!( class_exists('TT_Temptt_GetinTouch') )){
	class TT_Temptt_GetinTouch extends WP_Widget {

		/**
		 * Sets up the widgets name etc
		 */
		public function __construct(){
			parent::__construct(
				'temptt_widget_getintouch',
				esc_html__('Theme: Get In Touch', 'cakecious'),
				array( 'description' => esc_html__( 'Get In Touch widget added by theme', 'cakecious' ), )
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



		$output = $args['before_widget'].$args['before_title']. $title .$args['after_title'].'<ul class="blv-contact-info">';
		$output .= '
		<li><i class="fa fa-map-marker"></i><span>'.esc_textarea($instance['address'],'cakecious').'</span></li>
		<li>'. cakecious_icon( 'phone', array( 'class' => 'blv-contact-info-icon' ), false ) .esc_attr($instance['phone']).'</li>
		<li><i class="fa fa-envelope-o"></i><a href="mailto:'.sanitize_email($instance['email']).'">'.sanitize_email($instance['email']).'</a></li>
		<li><i class="fa fa-globe"></i><a href="'.esc_url($instance['website']).'">'.esc_url($instance['website']).'</a></li>';

		$output .= '</ul>'.$args['after_widget'];

		print $output;

		}

		/**
		 * Outputs the options form on admin
		 *
		 * @param array $instance The widget options
		 */
		public function form( $instance ) {

		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = esc_html__( 'Get In Touch', 'cakecious' );
		}
		
		if ( isset( $instance[ 'address' ] ) ) {
			$address = $instance[ 'address' ];
		}
		else {
			$address = esc_html__( "123, Some building, Street 1, Some City, Some State, Country", 'cakecious' );
		}
		if ( isset( $instance[ 'phone' ] ) ) {
			$phone = $instance[ 'phone' ];
		}
		else {
			$phone = esc_html__( "000 111 222", 'cakecious' );
		}
		if ( isset( $instance[ 'email' ] ) ) {
			$email = $instance[ 'email' ];
		}
		else {
			$email = esc_html__( "dummy@dummy.com", 'cakecious' );
		}
		if ( isset( $instance[ 'website' ] ) ) {
			$website = $instance[ 'website' ];
		}
		else {
			$website = esc_html__( "http://dummy_url.com", 'cakecious' );
		}
		
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','cakecious' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			
			<label style="margin-top: 20px; display: block;" for="<?php echo esc_textarea($this->get_field_id( 'address' )); ?>"><?php esc_html_e( 'Address:','cakecious' ); ?></label>
			<input class="widefat" id="<?php echo esc_textarea($this->get_field_id( 'address' )); ?>" name="<?php echo esc_textarea($this->get_field_name( 'address' )); ?>" type="text" value="<?php echo esc_textarea( $address ); ?>" />
		
			<label style="margin-top: 20px; display: block;" for="<?php echo esc_attr($this->get_field_id( 'phone' )); ?>"><?php esc_html_e( 'Phone:','cakecious' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'phone' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'phone' )); ?>" type="text" value="<?php echo esc_attr( $phone ); ?>" />
		
			<label style="margin-top: 20px; display: block;" for="<?php echo esc_html($this->get_field_id( 'email' )); ?>"><?php esc_html_e( 'Email:','cakecious' ); ?></label>
			<input class="widefat" id="<?php echo esc_html($this->get_field_id( 'email' )); ?>" name="<?php echo esc_html($this->get_field_name( 'email' )); ?>" type="text" value="<?php echo esc_html( $email ); ?>" />
		
			<label style="margin-top: 20px; display: block;" for="<?php echo esc_html( $this->get_field_id( 'website' )); ?>"><?php esc_html_e( 'Website:','cakecious' ); ?></label>
			<input class="widefat" id="<?php echo esc_html( $this->get_field_id( 'website' )); ?>" name="<?php echo esc_html( $this->get_field_name( 'website')); ?>" type="text" value="<?php echo esc_html( $website ); ?>" />
		
		</p>
		<?php 
		}

		/**
		 * Processing widget options on save
		 */
		public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['address'] = ( ! empty( $new_instance['address'] ) ) ? strip_tags( $new_instance['address'] ) : '';
		$instance['phone'] = ( ! empty( $new_instance['phone'] ) ) ? strip_tags( $new_instance['phone'] ) : '';
		$instance['email'] = ( ! empty( $new_instance['email'] ) ) ? strip_tags( $new_instance['email'] ) : '';
		$instance['website'] = ( ! empty( $new_instance['website'] ) ) ? strip_tags( $new_instance['website'] ) : '';


		return $instance;
		}
	}
	function tt_temptt_register_getintouch_widget(){
	     register_widget( 'TT_Temptt_GetinTouch' );
	}
	add_action( 'widgets_init', 'tt_temptt_register_getintouch_widget');
}
