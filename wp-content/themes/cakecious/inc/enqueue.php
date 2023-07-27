<?php
/**
 * cakecious enqueue scripts
 *
 * @package cakecious
 */


function cakecious_scripts() {
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '0.4.7');
    wp_enqueue_style( 'linearicons', get_template_directory_uri() . '/assets/assets/linearicons/style.css', array(), '0.4.7');
    wp_enqueue_style( 'flaticon', get_template_directory_uri() . '/assets/assets/flat-icon/flaticon.css', array(), '0.4.7');
    wp_enqueue_style( 'stroke-icon', get_template_directory_uri() . '/assets/assets/stroke-icon/style.css', array(), '0.4.7');
    wp_enqueue_style( 'bootstrapp', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '0.4.7');
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/assets/owl-carousel/owl.carousel.min.css', array(), '0.4.7');
    wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/assets/magnific-popup/magnific-popup.css', array(), '0.4.7');
    wp_enqueue_style( 'lightbox', get_template_directory_uri() . '/assets/assets/lightbox/simpleLightbox.css', array(), '0.4.7');
    wp_enqueue_style( 'datetime-picker', get_template_directory_uri() . '/assets/assets/datetime-picker/css/bootstrap-datetimepicker.min.css', array(), '0.4.7');
    wp_enqueue_style( 'animate', get_template_directory_uri() . '/assets/assets/animate-css/animate.css', array(), '0.4.7');
    wp_enqueue_style( 'cakecious-styles', get_template_directory_uri() . '/assets/css/themestyles.css', array(), '0.4.7');
    wp_enqueue_style( 'cakecious-res', get_template_directory_uri() . '/assets/css/responsive.css', array(), '0.4.7');
	wp_enqueue_style( 'cakecious-style', get_stylesheet_uri(), '', null );



    wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/assets/owl-carousel/owl.carousel.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/assets/assets/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'simple-lightbox', get_template_directory_uri() . '/assets/assets/lightbox/simpleLightbox.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'moment', get_template_directory_uri() . '/assets/assets/datetime-picker/js/moment.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'datetime-picker', get_template_directory_uri() . '/assets/assets/datetime-picker/js//bootstrap-datetimepicker.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'imagesloaded' );
	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/assets/assets/isotope/isotope.pkgd.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/assets/assets/counterup/jquery.waypoints.min.js', array('jquery'), null, true );
	wp_enqueue_script( 'scrollto', get_template_directory_uri() . '/assets/assets/jquery.scrollTo.min.js', array('jquery'), null, true );


    wp_enqueue_script( 'cakecious-default', get_template_directory_uri() . '/assets/js/theme.js', array('jquery'), null, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

		wp_enqueue_style( 'cakecious-fonts', cakecious_tt_g_fonts(), array(), null );

}

add_action( 'wp_enqueue_scripts', 'cakecious_scripts' );

if ( ! function_exists( 'cakecious_tt_g_fonts' ) ) {
	/**
	 * @return string Google fonts URL for the theme.
	 */
	function cakecious_tt_g_fonts() {

		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
		if ( 'off' !== _x( 'on', 'Google font: on or off', 'cakecious' ) ) {
			$fonts[] = 'Lora:400,700';
			$fonts[] = 'Open Sans:300,400,600,700';
			$fonts[] = 'Playfair Display:400,700,900';
			$fonts[] = 'Montserrat:300,400,500,600,700';
			$fonts[] = 'Poppins:300,400,500,600';
		}

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
}
