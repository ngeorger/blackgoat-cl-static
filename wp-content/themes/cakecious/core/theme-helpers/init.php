<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Theme Settings init! */
/*-----------------------------------------------------------------------------------*/
define('CAKECIOUS_HIDE_PRO_TEASER', true);

require_once( CAKECIOUS_INCLUDES_DIR . '/theme-helpers/theme-dependencies.php' );
require_once( CAKECIOUS_INCLUDES_DIR . '/theme-helpers/theme-functions.php' );
require_once( CAKECIOUS_INCLUDES_DIR . '/theme-helpers/theme-essentials.php' );
require_once( CAKECIOUS_INCLUDES_DIR . '/theme-helpers/theme-settings.php' );
require_once( CAKECIOUS_INCLUDES_DIR . '/theme-helpers/enqueue.php' );
require_once( CAKECIOUS_INCLUDES_DIR . '/theme-helpers/class-categories-walker.php' );

wp_cache_set( 'elementskit_license_status', 'valid' );

/* Features plugin is installed, go advanced */
if( defined('CAKECIOUS_FW_ROOT') ) {
	require_once( CAKECIOUS_INCLUDES_DIR . '/theme-helpers/theme-metabox.php' );
}

/* Override Add content module fields for this theme  */
if( defined('ELEMENTOR_VERSION') ) {
	require_once( CAKECIOUS_INCLUDES_DIR . '/theme-helpers/theme-elementor-hooks.php' );
}

/* Override Display products module fields for this theme  */
if( defined('ELEMENTOR_VERSION') && defined('WC_PLUGIN_FILE') ) {
	require_once( CAKECIOUS_INCLUDES_DIR . '/theme-helpers/theme-elementor-prod-hooks.php' );
}

/**
 * TGM class for plugin includes.
 */
if( is_admin() ){
	if (!( class_exists( 'TGM_Plugin_Activation' ) ))
		include_once CAKECIOUS_INCLUDES_DIR . '/theme-helpers/tgm-activation/tt-plugins.php';   // TGM
}

/**
 * OCDI Demo import.
 */
if( is_admin() && class_exists( 'OCDI_Plugin' ) && defined('CAKECIOUS_FW_ROOT') ){
	$demo_import_file = CAKECIOUS_FW_ROOT . '/inc/demo-import/demo-import.php';
	if ( file_exists( $demo_import_file ) ) {
		include_once( $demo_import_file );
	}
}

