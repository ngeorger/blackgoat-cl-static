<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Theme essentials! */
/*-----------------------------------------------------------------------------------*/

/**
 * Add default options and show Options Panel after activate
 * @since  4.0.0
 */
global $pagenow;
if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' ) {
	// Flush rewrite rules.
	flush_rewrite_rules();
	// redirect
	$tt_update_log = get_option( 'tt_temptt_opt');
	//if( ! is_array($tt_update_log) ) cakecious_tt_activate_redirect(); // only redirect if its first time activation
}

// Adding redirect
function cakecious_tt_activate_redirect() {

	header( 'Location: ' . admin_url( 'themes.php?page=tgmpa-install-plugins' ) );

} // End cakecious_tt_activate_redirect()



/**
 * Get the version data for the currently active theme.
 */
if ( ! function_exists( 'cakecious_get_theme_version_data' ) ) {
function cakecious_get_theme_version_data () {
	$response = array(
					'theme_version' => '',
					'theme_name' => '',
					'is_child' => is_child_theme(),
					'child_theme_version' => '',
					'child_theme_name' => ''
					);

	if ( function_exists( 'wp_get_theme' ) ) {
		$theme_data = wp_get_theme();
		if ( true == $response['is_child'] ) {
			$response['theme_version'] = $theme_data->parent()->Version;
			$response['theme_name'] = $theme_data->parent()->Name;

			$response['child_theme_version'] = $theme_data->Version;
			$response['child_theme_name'] = $theme_data->Name;
		} else {
			$response['theme_version'] = $theme_data->Version;
			$response['theme_name'] = $theme_data->Name;
		}
	}

	return $response;
} // End cakecious_get_theme_version_data()
}


if( !function_exists( 'cakecious_tt_firstInst_notice' )) {
	function cakecious_tt_firstInst_notice() {

			 print '<div class="updated notice is-dismissible tt-admin1" ><span class="tt-admin2"> ' .
		     esc_html__( 'Thanks for Activating CakeryShop WordPress theme.', 'cakecious' ) . '</span>'
			 . '<br /> <br />' .

		     esc_html__( 'Theme requires few bundled plugins to function on its full power. Please Install and Activate plugins below.', 'cakecious' )

			 . '<br />' .

		     esc_html__( 'You can choose not to install any particular plugin if you do not need it. eg woocommerce ', 'cakecious' )

			 . '<br /> <br />' .

			 '<span class="tt-admin2"> ' .
		     esc_html__( 'After plugins are activated, Click Dashboard on left top, then go to Theme Options menu for further setup.', 'cakecious' ) . '</span>'

		     . '</div>';
	}
}


/**
 * Initialize theme required features & components.
 * This is the base setting for required CPTs, based on these settings customer sees options to disable/rename rewrite for cpts in themeoptions.
 */
if(!( function_exists('cakecious_fw_theme_components') )){

	function cakecious_fw_theme_components() {

		$theme_components = array(
			'addon_cpt'                 => '0',
			'service_cpt'               => '0',
			'portfolio_cpt'             => '0',
			'team_cpt'                  => '0',
			'client_cpt'                => '0',
			'testimonial_cpt'           => '1',
			'project_cpt'               => '1',
			'metaboxes'                 => '1',
			'theme_options'             => '1',
			'common_shortcodes'         => '1',
			'post_shortcodes'           => '1',
			'ttnew_hero_sc'             => '1',
			'integrate_VC'              => '0',
			'tt_widget_getintouch'      => '0',
			'blv_widget_recentpost'     => '0',
			'tt_dashboard_panel'        => '1',
			'cakecious_advanced_cust'       => '1', /* cakecious advanced customiser settings */
			'temptt_metabox'            => '0', /* metabox plugin */
			'temptt_add_content'        => '1', /* Add content elementor */
			'temptt_customize_prod'     => '1',
			'temptt_addons_builder'     => '0',
			'temptt_pcode_check_no'     => '0', /* whether to implement purchase code verification. put 0 to enable pcode verification */
			'temptt_theme_remote'       => '0', /* If purchase code verification system to enable or not. */
			'temptt_themename'          => 'Cakecious', /* as in Stylesheet */
			'temptt_author'             => 'blv',  /* if blv or da */
			'temptt_tf_link'            => 'cakecious-cake-wordpress-theme/19515132', /* format : itemslug/itemID */
			'temptt_new_importer'       => '1', /* whether to use the new importer */
		);
		// Let filter modify it
		$theme_components = apply_filters( 'cakecious_theme_components_user', $theme_components );
		update_option('cakecious_theme_components_user', $theme_components);
	}

	// only trigger on first install
	global $pagenow;
	if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' || is_admin() && isset( $_GET['theme'] ) && $pagenow == 'customize.php' ){
		add_action( 'init', 'cakecious_fw_theme_components', 1 );
	}
}
