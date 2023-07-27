<?php
/**
 * cakecious functions and definitions
 *
 * @package cakecious
 */

/**
 * Theme setup and custom theme supports.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/enqueue.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions for smooth running of theme.
 */
require get_template_directory() . '/inc/theme-essentials.php';

/**
 * Theme Options
 */
require get_template_directory() . '/inc/theme-options.php';

/**
 * Theme specific functions
 */
require get_template_directory() . '/inc/theme-functions.php';

/**
 * Metaboxes
 */
require get_template_directory() . '/inc/theme-metabox.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/custom-comments.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load custom WordPress nav walker.
 */
require get_template_directory() . '/inc/bootstrap-wp-navwalker.php';

/**
 * Load custom css.
 */
require get_template_directory() . '/inc/custom-css.php';

/**
 * VC integration
 */
if ( function_exists( 'vc_set_as_theme' ) ) {
		include_once get_template_directory(). '/inc/vc/vc-init.php';   // Theme Essentials
}

/**
* Load WooCommerce functions.
*/
if ( class_exists( 'woocommerce' ) ) {
	require get_template_directory() . '/inc/theme-woocommerce.php';
}


/**
 * TGM class for plugin includes.
 */
if( is_admin() ){
	if (!( class_exists( 'TGM_Plugin_Activation' ) ))
		include_once get_template_directory(). '/inc/tgm-activation/tt-plugins.php';   // Theme Essentials
}
