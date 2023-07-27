<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Theme essentials! */
/*-----------------------------------------------------------------------------------*/
//setting some required settings to avoid multiple redirects caused by plugins
if(  is_admin() ) {
	update_option( 'ultimate_vc_addons_redirect', false );
	update_option( 'revslider-notices', false );
	set_transient( '_redux_activation_redirect', false, 30 );
	remove_action( 'init', 'vc_page_welcome_redirect' );
}

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
	if( ! is_array($tt_update_log) ) cakecious_tt_activate_redirect(); // only redirect if its first time activation
}

// Adding redirect
function cakecious_tt_activate_redirect() {

	header( 'Location: ' . admin_url( 'themes.php?page=tgmpa-install-plugins' ) );

} // End cakecious_tt_activate_redirect()



// Adding versions
add_action( 'current_screen', 'cakecious_tt_update_version' );
function cakecious_tt_update_version( $current_screen ) {
	if ( 'appearance_page_tgmpa-install-plugins' == $current_screen->base ) {
		if( function_exists( 'cakecious_tt_firstInst_notice' )) add_action( 'admin_notices', 'cakecious_tt_firstInst_notice' ); // add notice.
	}
	if ( 'toplevel_page__templatation' == $current_screen->base ) {

		$cakecious_fw_theme = wp_get_theme();
		$cakecious_fw_this_theme_ver = $cakecious_fw_theme->get( 'Version' );
		$theme_update_log = get_option( 'cakecious_tt_updates_log');

        if ( ! $theme_update_log ) $theme_update_log = array();

		// First update
		if ( ! in_array('1.0', $theme_update_log) ) {
			array_unshift($theme_update_log, '1.0');
			update_option( 'cakecious_tt_updates_log', $theme_update_log);
		}

		if ( ! in_array($cakecious_fw_this_theme_ver, $theme_update_log) ) {
			array_unshift($theme_update_log, $cakecious_fw_this_theme_ver);
			update_option( 'cakecious_tt_updates_log', $theme_update_log);
		}

	}
}


if ( ! function_exists( 'cakecious_fw_version' ) ) {
	function cakecious_fw_version() {
		$data = cakecious_get_theme_version_data();
		echo "\n<!-- Theme version -->\n";
		if ( isset( $data['is_child'] ) && true == $data['is_child'] ) {
			echo '<meta name="generator" content="' . esc_attr( $data['child_theme_name'] . ' ' . $data['child_theme_version'] ) . '" />' . "\n";
		}
		echo '<meta name="generator" content="' . esc_attr( $data['theme_name'] . ' ' . $data['theme_version'] ) . '" />' . "\n";
	} // End cakecious_fw_version()
}

// Add Generator meta tags
if ( ! is_admin()  ) {
	add_action( 'wp_head', 'cakecious_fw_version', 10 );
}

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

			 print '<div class="updated notice is-dismissible tt-admin1"><span class="tt-admin2"> ' .
		     esc_html__( 'Thanks for Activating Cakecious WordPress theme.', 'cakecious' ) . '</span>'
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
			'integrate_VC'              => '1',
			'tt_widget_recentpost'      => '1',
			'tt_dashboard_panel'        => '1',
			'temptt_customize_prod'     => '1', // enable prod addons.
			'temptt_themename'          => 'Cakecious', /* as in Stylesheet */
			'temptt_author'             => 'blv',  /* if blv or da */
			'temptt_tf_link'            => 'cakecious-bakery-wordpress-theme/22148433', /* format : itemslug/itemID */
			'temptt_new_importer'       => '0', /* whether to use the new importer */
			'temptt_new_importer2'      => '1', /* whether to use the new importer with multi demo select option */
			'temptt_num_demos'          => '5', /* Number of demos */
		);
		update_option('temptt_tt_components', $theme_components);
	}

	// only trigger on first install
	global $pagenow;
	if ( is_admin() && isset( $_GET['activated'] ) && $pagenow == 'themes.php' || is_admin() && isset( $_GET['theme'] ) && $pagenow == 'customize.php' ){
		add_action( 'init', 'cakecious_fw_theme_components', 1 );
		add_action( 'init', 'cakecious_fw_user_manage_cpt', 2 ); // Trigger first run of this fn.
	}
}

/**
 * Let user disable CPT as per his needs.
 */
if(!( function_exists('cakecious_fw_user_manage_cpt') )){

	function cakecious_fw_user_manage_cpt() {

		// Fetch from DB.
		$theme_components = get_option('temptt_tt_components');
		if( !$theme_components ) return;

		// Save
		update_option('temptt_tt_components_user', $theme_components);

	}

	// only trigger on permalink page
	global $pagenow;
	if ( is_admin() && $pagenow == 'options-permalink.php' ){
		add_action( 'init', 'cakecious_fw_user_manage_cpt', 2 );
	}
}

// admin styles.
if ( ! function_exists( 'cakecious_tt_admin_styles' ) ) {
	function cakecious_tt_admin_styles() {

		wp_enqueue_style( 'theme-admin-css', get_template_directory_uri() . '/assets/css/tt-admin.css' );

	} add_action('admin_enqueue_scripts', 'cakecious_tt_admin_styles', 200);
}
