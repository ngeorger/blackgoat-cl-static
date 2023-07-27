<?php
/**
 * Cakecious functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'cakecious_check_version' ) ) {
   function cakecious_check_version() {

      if( get_option( 'cakecious_fresh_install') ) {
         return;
      }
      $checkprev_option = false;
     /*$checkprev_option = get_option( 'temptt_theme_components' );*/
      $checkprev_option = get_option( 'tt_temptt_opt' );
        if ( empty($checkprev_option) ) { /* Should not be array or string. */
           update_option( 'cakecious_fresh_install', '1');
        }

   } // End cakecious_check_version()
   cakecious_check_version();
}

if ( ! function_exists( 'cakecious_is_fresh_install' ) ) {
   function cakecious_is_fresh_install() {

      if( defined('CAKECIOUS_FRESH_INSTALL') && CAKECIOUS_FRESH_INSTALL ) {
         return true;
      }
      if( defined('CAKECIOUS_OLD_INSTALL') && CAKECIOUS_OLD_INSTALL ) {
         return false;
      }
      if( get_option( 'cakecious_fresh_install') ) {
         return true;
      } else {
         return false;
      }

   } // End cakecious_is_fresh_install()
}

if ( cakecious_is_fresh_install() ) {

/**
 * ====================================================
 * Theme constants
 * ====================================================
 */

define( 'CAKECIOUS_INCLUDES_DIR', get_template_directory() . '/core' );

define( 'CAKECIOUS_IMAGES_URL', get_template_directory_uri() . '/assets/images' );

define( 'CAKECIOUS_CSS_URL', get_template_directory_uri() . '/assets/css' );

define( 'CAKECIOUS_JS_URL', get_template_directory_uri() . '/assets/js' );

define( 'CAKECIOUS_VERSION', wp_get_theme( get_template() )->get( 'Version' ) );

define( 'CAKECIOUS_ASSETS_SUFFIX', SCRIPT_DEBUG ? '' : '.min' );

define( 'CAKECIOUS_URL', esc_url( 'https://bolvo.com/' ) );

/**
 * ====================================================
 * Main theme class
 * ====================================================
 */

require_once( CAKECIOUS_INCLUDES_DIR . '/class-cakecious.php' );


/**
 * VC integration
 */
if ( function_exists( 'vc_set_as_theme' ) ) {
		include_once get_template_directory(). '/inc/vc/vc-init.php';   // Theme Essentials
}

} else {

/*-----------------------------------------------------------------------------------*/
/* Start Loading Functions - Please refrain from editing this section
/*-----------------------------------------------------------------------------------*/

include_once get_template_directory(). '/inc/constants.php';   // Theme constants
include_once get_template_directory(). '/inc/init.php';        // Theme loading starts.
add_filter( 'breadcrumb_trail_inline_style', '__return_false' );
/**
 * Set WooCommerce image dimensions upon theme activation
 */
// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', 'cakecious_dequeue_styles' );

	function cakecious_dequeue_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
		return $enqueue_styles;
	}


	/*-----------------------------------------------------------------------------------*/
	/**
	 * Its recommended to use child theme instead if you want to write your own functions.
	 * Child theme is supplied inside the main download zip.
	 */

	function templatation_vc_row_and_vc_column($class_string, $tag) {
		$class_string = str_replace('wpb_row', ' wpb_row cakecious ', $class_string);
		return $class_string;
	}

	// Filter to Replace default css class for vc_row shortcode and vc_column
	add_filter('vc_shortcodes_css_class', 'templatation_vc_row_and_vc_column', 10, 2);
	
$ckc_wc_file = ( get_template_directory() . '/deprecated-woocommerce' );
$ckc_wc_file_new = ( get_template_directory() . '/woocommerce' );

if (!function_exists('stream_resolve_include_path')) {
/**
* Resolve filename against the include path.
*
* stream_resolve_include_path was introduced in PHP 5.3.2. This is kinda a PHP_Compat layer for those not using that version.
*
* @param Integer $length
* @return String
* @access public
*/
function stream_resolve_include_path($filename) {
	$paths = PATH_SEPARATOR == ':' ?
	preg_split('#(?<!phar):#', get_include_path()) :
	explode(PATH_SEPARATOR, get_include_path());
		foreach ($paths as $prefix) {
		$ds = substr($prefix, -1) == DIRECTORY_SEPARATOR ? '' : DIRECTORY_SEPARATOR;
		$file = $prefix . $ds . $filename;

			if (file_exists($file)) {
				return $file;
			}
		}
	return false;
	}
}

	if ( file_exists(stream_resolve_include_path($ckc_wc_file.'.php')) && ! file_exists(stream_resolve_include_path($ckc_wc_file_new.'.php')) ) {
	rename( $ckc_wc_file.'.php', $ckc_wc_file_new.'.php' );
	}
	/*Rename existing wc file to comply with previous version, with condition so that it only happens once.*/
	if ( file_exists(stream_resolve_include_path($ckc_wc_file_new)) && ! file_exists(stream_resolve_include_path($ckc_wc_file_new.'-new')) ) {
	rename( $ckc_wc_file_new, $ckc_wc_file_new.'-new' );
	}

	if ( file_exists(stream_resolve_include_path($ckc_wc_file)) && ! file_exists(stream_resolve_include_path($ckc_wc_file_new)) ) {
	rename( $ckc_wc_file, $ckc_wc_file_new );
	}
	/*Rename search form to comply with previous version.*/
	$ckc_search_file = ( get_template_directory() . '/deprecated-search-form.php' );
	$ckc_search_file_new = ( get_template_directory() . '/searchform.php' );
	if ( file_exists(stream_resolve_include_path($ckc_search_file)) && ! file_exists(stream_resolve_include_path($ckc_search_file_new)) ) {
	rename( $ckc_search_file, $ckc_search_file_new );
	}

}