<?php
/*
Plugin Name: Cakecious Features
Plugin URI: https://bolvo.com
Author: Bolvo
Author URI: https://bolvo.com
Version: 1.8
Description: Framework plugin needed for Cakecious theme to work smoothly.
Text Domain: cakecious-features
*/

// Define Constants
define('CAKECIOUS_FW_ROOT', dirname(__FILE__));
global $cakecious_theme_components;

add_action( 'init', 'cakecious_load_plugin_textdomain' );

/**
 * Load plugin textdomain.
 */
function cakecious_load_plugin_textdomain() {
	load_plugin_textdomain( 'cakeciousfm-features', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}


// Fetch the options set from theme, which we use to decide which features to turn on from this plugin.
$cakecious_theme_components = array(
	'addon_cpt'                 => '0',
	'service_cpt'               => '0',
	'portfolio_cpt'             => '0',
	'team_cpt'                  => '0',
	'client_cpt'                => '0',
	'testimonial_cpt'           => '0',
	'project_cpt'               => '0',
	'metaboxes'                 => '1',
	'theme_options'             => '1',
	'common_shortcodes'         => '1',
	'post_shortcodes'           => '0',
	'ttnew_hero_sc'             => '0',
	'tt_dashboard_panel'        => '0',
	'cakecious_advanced_cust'  => '0', /* cakecious advanced customiser settings */
	'tt_widget_getintouch'      => '0',
	'tt_widget_infowidget'      => '0',
	'blv_widget_recentpost'     => '0',
	'temptt_metabox'            => '0', /* metabox plugin */
	'temptt_add_content'        => '0', /* Add content elementor */
	'temptt_customize_prod'     => '0',
	'temptt_addons_builder'     => '0', /* included elementor addons */
	'temptt_bt_ep'              => '0', /* EP plugin */
	'temptt_themename'          => '', /* as in Stylesheet */
	'temptt_author'             => 'blv', /* if blv or da */
	'temptt_tf_link'            => '', /* format : itemslug/itemID */
	'temptt_pcode_check_no'     => '0', /* whether to implement purchase code verification. put 0 to enable pcode verification */
	'temptt_theme_remote'       => '0', /* If purchase code verification system to enable or not. */
);

// old version compatibility
if(get_option('temptt_theme_components_user')) {
	$cakecious_theme_components = wp_parse_args( get_option( 'temptt_theme_components_user' ), $cakecious_theme_components ); // Replace defaults with values set in Theme.
}

if(get_option('cakecious_theme_components_user')) {
	$cakecious_theme_components = wp_parse_args( get_option( 'cakecious_theme_components_user' ), $cakecious_theme_components ); // Replace defaults with values set in Theme.
}

// If purchase code verification system to enable or not.
if ( ! empty( $cakecious_theme_components['temptt_pcode_check_no'] ) ) {
	define('TT_PCODE_NO', '1');
}

// If purchase code verification system to enable or not.
if ( ! empty( $cakecious_theme_components['temptt_theme_remote'] ) ) {
	define('TT_REMOTE_T_DIR', $cakecious_theme_components['temptt_theme_remote']);
}

//Include Addons CPT
if ( ! empty( $cakecious_theme_components['addon_cpt'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/CPT/tt-addon.php';
}

//Include Service CPT
if ( ! empty( $cakecious_theme_components['service_cpt'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/CPT/tt-service.php';
}

//Include Portfolio CPT
if ( ! empty( $cakecious_theme_components['portfolio_cpt'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/CPT/tt-portfolio.php';
}

//Include Clients CPT
if ( ! empty( $cakecious_theme_components['client_cpt'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/CPT/tt-client.php';
}

//Include Projects CPT
if ( ! empty( $cakecious_theme_components['project_cpt'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/CPT/tt-project.php';
}

//Include Team CPT
if ( ! empty( $cakecious_theme_components['team_cpt'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/CPT/tt-team.php';
}

//Include Testimonial CPT
if ( ! empty( $cakecious_theme_components['testimonial_cpt'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/CPT/tt-testimonial.php';
}

//Include CS framework
if ( ! class_exists( 'CSFramework' && ! empty( $tt_temptt_components['metaboxes'] ) ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/cs-framework/cs-framework.php';
}


//Include Metabox
if ( ! empty( $cakecious_theme_components['temptt_metabox'] ) && ! defined( 'RWMB_VER' ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/plugins/meta-box/meta-box.php';
}

//Include getintouch widget
if ( ! empty( $cakecious_theme_components['tt_widget_getintouch'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/widgets/tt-widget_getintouch.php';
}

/* Load Elementor related stuff */
cakecious_elementor_stuff();
function cakecious_elementor_stuff() {

	global $cakecious_theme_components;

	//Include Elementor add_content
	if ( ( ! empty( $cakecious_theme_components['temptt_add_content'] ) ) ) {
		include CAKECIOUS_FW_ROOT . '/inc/elementor/elementor-init.php';
	}

	//Include HFE
	if ( ( ! empty( $cakecious_theme_components['temptt_hfe'] ) && ! defined( 'HFE_VER' ) ) ) {
		include CAKECIOUS_FW_ROOT . '/inc/plugins/header-footer-elementor/header-footer-elementor.php';
	}

	//Include Kirki
	if ( ! empty( $cakecious_theme_components['temptt_kirki'] ) && ! class_exists( 'Kirki' ) ) {
		include CAKECIOUS_FW_ROOT . '/inc/plugins/kirki/kirki.php';
	}

	//Include BT EP
	if ( ! empty( $cakecious_theme_components['temptt_bt_ep'] ) && ! defined( 'BDTEP_VER' ) ) {
		include CAKECIOUS_FW_ROOT . '/inc/plugins/bdthemes-element-pack/bdthemes-element-pack.php';
	}

	//Include BT Testimony
	if ( ! empty( $cakecious_theme_components['temptt_bt_t'] ) && ! defined( 'BDTTM_PATH' ) ) {
		include CAKECIOUS_FW_ROOT . '/inc/plugins/bdthemes-testimonials/bdthemes-testimonials.php';
	}

	//Include BT portfolio
	if ( ! empty( $cakecious_theme_components['temptt_bt_p'] ) && ! function_exists( 'bdthemes_portfolio_register' ) ) {
		include CAKECIOUS_FW_ROOT . '/inc/plugins/bdthemes-portfolio/bdthemes-portfolio.php';
	}

	//Include Ultimate addons
	if ( ! empty( $cakecious_theme_components['temptt_addons_builder'] ) && ! defined( 'UNLIMITED_ELEMENTS_INC' ) ) {
		if ( ! get_option( 'blv_addons_sql' ) ) {
			include CAKECIOUS_FW_ROOT . '/inc/helper/query.php';
		}
		if ( 'done' === get_option( 'blv_addons_sql', '0' ) ) {
			//include CAKECIOUS_FW_ROOT . '/inc/plugins/unlimited-elements-for-elementor/unlimited_elements.php';
		}
	}

}

//Include Shortcodes
/*if ( ! empty( $cakecious_theme_components['common_shortcodes'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/shortcodes/init.php';
}
*/
//Include Post sc
if ( ! empty( $cakecious_theme_components['post_shortcodes'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/shortcodes/posts.php';
}

//Include Recentpost widget
if ( ! empty( $cakecious_theme_components['blv_widget_recentpost'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/widgets/tt-widget_recentpost.php';
}

add_action( 'woocommerce_loaded','cakecious_prod_addon' );
if ( ! function_exists( 'cakecious_prod_addon' ) ) {
	function cakecious_prod_addon() {

		global $cakecious_theme_components;

		//Include Customize product feature
		if ( ! empty( $cakecious_theme_components['temptt_customize_prod'] ) && ! class_exists( 'WC_Product_Addons' ) ) {
			$prod_addons_file = CAKECIOUS_FW_ROOT . '/inc/plugins/bolvo-product-addons/woocommerce-product-addons.php';
			if ( file_exists( $prod_addons_file ) ) {
				include_once( $prod_addons_file );
			}
		}

	}
}

/*-----------------------------------------------------------------------------------*/
/* Remove no-ttfmwrk class from body, when this plugin is active. */
/*-----------------------------------------------------------------------------------*/
add_filter( 'body_class','tt_temptt_ttfmwrk_yes', 11 );
if ( ! function_exists( 'tt_temptt_ttfmwrk_yes' ) ) {
	function tt_temptt_ttfmwrk_yes( $classes ) {

		if (($key = array_search('no-ttfmwrk', $classes)) !== false) {
			unset($classes[$key]);
		}
		return $classes;
	}
}

/*-----------------------------------------------------------------------------------*/
/* The Dashboard */
/*-----------------------------------------------------------------------------------*/
/**
 * Get the version data for the currently active theme.
 */
if ( ! function_exists( 'temptt_get_theme_version_data' ) ) {
	function temptt_get_theme_version_data () {
		$response = array(
			'parent_theme_name'     => '',
			'parent_theme_version'  => '',
			'parent_theme_slug'     => '',
		);

		if ( function_exists( 'wp_get_theme' ) ) {
			$theme_data = wp_get_theme();
			$response['parent_theme_name']      = $theme_data->get( 'Name' );
			$response['parent_theme_version']   = $theme_data->get( 'Version' );
			$response['parent_theme_slug']      = get_template();
		}

		return $response;
	} // End temptt_get_theme_version_data()
}


//Include Dashboard
if ( is_admin() && ucfirst(get_template()) === $cakecious_theme_components['temptt_themename'] && ! empty( $cakecious_theme_components['tt_dashboard_panel'] ) ) {
	/* WE need to show panel now, so set redux menu under panel menu. */
	include CAKECIOUS_FW_ROOT . '/inc/dashboard/dashboard.php';
}

//Include advanced customizer
if ( ucfirst(get_template()) === $cakecious_theme_components['temptt_themename'] && ! empty( $cakecious_theme_components['cakecious_advanced_cust'] ) ) {
	include CAKECIOUS_FW_ROOT . '/inc/advanced/cakecious-pro.php';
}


// admin styles.
if ( ! function_exists( 'temptt__tt_admin_styles' ) ) {
	function temptt__tt_admin_styles() {

		wp_enqueue_style( 'temptt-admin-css', plugin_dir_url( __FILE__ ) . '/inc/assets/css/admin-tt.css' );

	} add_action('admin_enqueue_scripts', 'temptt__tt_admin_styles', 200);
}

// Adding shortcode from function call.
if ( ! function_exists( 'cakecious_add_sc' ) ) {
	function cakecious_add_sc( $sc = '', $fn = '' ) {

		if ( function_exists( $fn ) ) {
			add_shortcode( $sc, $fn );
		}

	}
}

// Add class to admin body if its not a local dev.
add_filter( 'admin_body_class', 'cakecious_admin_body_class' );
function cakecious_admin_body_class( $classes ) {

	$url = $_SERVER['SERVER_NAME'];

	if (preg_match('/\b.test\b/', $url)) {
		return $classes;
	} else {
		return "$classes blv_notlocal";
	}
}

/* Download file to local */
if( !function_exists('cakecious_download_file_to_local')) {
	function cakecious_download_file_to_local( $file_url, $path ) {
		$filename = basename( $file_url );
		$file = $path . '/' . $filename;

		wp_mkdir_p( $path );

		$ifp = @fopen( $file, 'wb' );

		if ( ! $ifp ) {
			return new WP_Error( 'import_file_error', sprintf( __( 'Could not write file %s' ,'cakecious-features'), $file ) );
		}

		@fwrite( $ifp, 0 );
		fclose( $ifp );
		clearstatcache();

		// Set correct file permissions
		$stat = @stat( dirname( $file ) );
		$perms = $stat['mode'] & 0007777;
		$perms = $perms & 0000666;
		@chmod( $file, $perms );
		clearstatcache();

		$response = wp_remote_get( $file_url, array(
			'stream' => true,
			'filename' => $file,
			'timeout' => 500,
		) );

		// request failed
		if ( is_wp_error( $response ) ) {
			@unlink( $file );
			return $response;
		}

		$code = (int) wp_remote_retrieve_response_code( $response );

		// make sure the fetch was successful
		if ( $code !== 200 ) {
			@unlink( $file );

			return new WP_Error(
				'import_file_error',
				sprintf(
					esc_html__( 'Remote server returned %1$d %2$s for %3$s', 'cakecious-features' ),
					$code,
					get_status_header_desc( $code ),
					$url
				)
			);
		}

		if ( 0 == filesize( $file ) ) {
			@unlink( $file );
			return new WP_Error( 'import_file_error', esc_html__( 'Zero size file downloaded', 'cakecious-features' ) );
		}


		return $file;
	}
}