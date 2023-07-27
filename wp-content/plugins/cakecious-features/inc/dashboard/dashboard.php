<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
global $cakecious_theme_components;

$file_theme_wupdates =  ( get_template_directory() . '/inc/helper/theme-wupdates.php' );
$file_theme_wupdates_new =  ( get_template_directory() . '/inc/theme-helper/theme-updater.php' );

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
    function stream_resolve_include_path($filename)
    {
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

if ( file_exists(stream_resolve_include_path($file_theme_wupdates_new)) ) {
	include( $file_theme_wupdates_new );
} elseif ( file_exists(stream_resolve_include_path($file_theme_wupdates)) ) {
	include( $file_theme_wupdates );
}

/**
 * top level menu
 */
if ( ! function_exists( 'temptt_thm_dashboard_page' ) ) {
	function temptt_thm_dashboard_page() {

		$icon = ''; // supply img icon here later.

		// add top level menu page
		add_menu_page(
			'Welcome To Theme Dashboard',
			'Theme Options',
			'manage_options',
			'cakecious_dashboard',
			'tt_dashboard_main_page',
			'dashicons-laptop',
			'45.51'
		);
		remove_submenu_page( 'cakecious_dashboard', 'cakecious_dashboard' );
		add_submenu_page(
			'cakecious_dashboard',
			esc_html__( 'Welcome', 'cakecious' ),
			esc_html__( 'Welcome', 'cakecious' ),
			'manage_options',
			'cakecious_dashboard',
			'tt_dashboard_main_page'
		);
		add_submenu_page(
			'cakecious_dashboard',
			esc_html__( 'Demo Setup', 'cakecious' ),
			esc_html__( 'Demo Setup', 'cakecious' ),
			'manage_options',
			'cakecious_demosetup',
			'tt_dashboard_demo_setup'
		);
		add_submenu_page(
			'cakecious_dashboard',
			esc_html__( 'Help & Support', 'cakecious' ),
			esc_html__( 'Help & Support', 'cakecious' ),
			'manage_options',
			'cakecious_help',
			'tt_dashboard_help_support'
		);
		add_submenu_page(
			'cakecious_dashboard',
			esc_html__( 'Theme Options', 'cakecious' ),
			esc_html__( 'Theme Options', 'cakecious' ),
			'manage_options',
			'cakecious_options',
			'tt_dashboard_theme_options'
		);

	}
}
/**
 * register our temptt_thm_demo_page to the admin_menu action hook
 */
add_action( 'admin_menu', 'temptt_thm_dashboard_page' );



/* Check if support is expired */
if ( ! function_exists( 'temptt_is_support_expired' ) ) {
	function temptt_is_support_expired( $slug ) {

		$date = date( 'm/d/Y h:i:s a', time() );

		if ( strtotime( $date ) > strtotime( get_option( $slug . '_wup_supported_until', '' ) ) ) {
			return true;
		}
	}
}

/* Check if theme is enabled */
if ( ! function_exists( 'temptt_is_pcode_entered' ) ) {
	function temptt_is_pcode_entered() {
		$slug          = basename( get_template_directory() );
		$purchase_code = sanitize_text_field( get_option( $slug . '_wup_purchase_code', '' ) );
		if ( $purchase_code ) {
			return true;
		}
	}
}

if ( ! function_exists( 'tt_dashboard_main_page' ) ) {
	function tt_dashboard_main_page() {


		?>
		<div id="kc-settings" class="wrap about-wrap">
			<?php include_once( CAKECIOUS_FW_ROOT . '/inc/dashboard/panel_header.php' ); ?>
			<?php include_once( CAKECIOUS_FW_ROOT . '/inc/dashboard/panel_general.php' ); ?>
		</div>
	<?php
	}
}

if ( ! function_exists( 'tt_dashboard_demo_setup' ) ) {
	function tt_dashboard_demo_setup() {

		?>
		<div id="kc-settings" class="wrap about-wrap">
			<?php include_once( CAKECIOUS_FW_ROOT . '/inc/dashboard/panel_header.php' ); ?>
			<?php include_once( CAKECIOUS_FW_ROOT . '/inc/dashboard/panel_demosetup.php' ); ?>
		</div>
	<?php
	}
}

if ( ! function_exists( 'tt_dashboard_help_support' ) ) {
	function tt_dashboard_help_support() {

		?>
		<div id="kc-settings" class="wrap about-wrap">
			<?php include_once( CAKECIOUS_FW_ROOT . '/inc/dashboard/panel_header.php' ); ?>
			<?php include_once( CAKECIOUS_FW_ROOT . '/inc/dashboard/panel_helpsupport.php' ); ?>
		</div>
	<?php
	}
}

if ( ! function_exists( 'tt_dashboard_theme_options' ) ) {
	function tt_dashboard_theme_options() {

		?>
		<div id="kc-settings" class="wrap about-wrap">
			<?php include_once( CAKECIOUS_FW_ROOT . '/inc/dashboard/panel_header.php' ); ?>
			<?php include_once( CAKECIOUS_FW_ROOT . '/inc/dashboard/panel_toptions.php' ); ?>
		</div>
	<?php
	}
}

