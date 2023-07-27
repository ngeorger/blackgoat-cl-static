<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Theme additional functions! */
/*-----------------------------------------------------------------------------------*/


/**
 * Add custom classes to the array of body classes.
 *
 * @param array $classes.
 * @return array
 */
if( ! function_exists( 'cakecious_theme_body_classes' )) {
	function cakecious_theme_body_classes( $classes ) {

		if ( cakecious_get_theme_mod( 'wave_pattern', '0' ) ) {
			$classes[] = 'enable-wave';
		}

		return $classes;
	}
}
add_filter( 'body_class', 'cakecious_theme_body_classes' );


/**
 * Add breadcrumb to custom location, if needed.
 *
 * @param array $classes.
 * @return array
 */
if( ! function_exists( 'cakecious_blv_custom_breadcrumb' )) {
	function cakecious_blv_custom_breadcrumb() {

			ob_start();
			// Breadcrumb
				 if( function_exists('breadcrumb_trail') && !(is_home() || is_front_page()) ){ ?>
	            <div class="breadcrumb_bottom">
	                <div class="container">
						<?php breadcrumb_trail(array('show_browse' => false)); ?>
					</div>
	            </div>
			<?php
				 }
			$cust_breadcrumb = ob_get_clean();

		return $cust_breadcrumb;
	}
}
