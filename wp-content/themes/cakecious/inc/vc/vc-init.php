<?php
if ( ! defined( 'ABSPATH' ) ) { die( '-1' ); }
/*
 * Templatation.com
 *
 * VC integration
 *
 */

// Set VC as theme.
if( function_exists('vc_set_as_theme') ){
	function cakecious_fw_vcAsTheme() {
		vc_set_as_theme(true);
	}
	add_action( 'vc_before_init', 'cakecious_fw_vcAsTheme' );
}
vc_set_default_editor_post_types( array(
									    'page',
									    'tt_project',
										'tt_portfolio',
										'tt_team'
									) );

// Initialize VC modules.
include( get_template_directory() . '/inc/vc/tt_vc_add_content.php');
include( get_template_directory() . '/inc/vc/tt_vc_feature2.php');
include( get_template_directory() . '/inc/vc/tt_vc_item_list.php');
include( get_template_directory() . '/inc/vc/tt_vc_team.php');
include( get_template_directory() . '/inc/vc/tt_vc_splrecipe.php');
include( get_template_directory() . '/inc/vc/tt_vc_title.php');
include( get_template_directory() . '/inc/vc/tt_vc_video.php');
include( get_template_directory() . '/inc/vc/tt_vc_serviceblock.php');
include( get_template_directory() . '/inc/vc/tt_vc_accordion.php');
include( get_template_directory() . '/inc/vc/tt_vc_comingsoon.php');
include( get_template_directory() . '/inc/vc/tt_vc_hilitepost.php');
include( get_template_directory() . '/inc/vc/tt_vc_newarrival.php');
//include( get_template_directory() . '/inc/vc/tt_vc_wc_sc.php');

//include( get_template_directory() . '/inc/vc/tt_vc_feature1.php');
//include( get_template_directory() . '/inc/vc/tt_vc_cta.php');
//include( get_template_directory() . '/inc/vc/tt_vc_countdown.php');
//include( get_template_directory() . '/inc/vc/tt_vc_home1contact.php');
//include( get_template_directory() . '/inc/vc/tt_vc_home3wedo.php');
//include( get_template_directory() . '/inc/vc/tt_vc_beforeafter.php');
//include( get_template_directory() . '/inc/vc/tt_vc_aboutme.php');
//include( get_template_directory() . '/inc/vc/tt_vc_imgshadow.php');
//include( get_template_directory() . '/inc/vc/tt_vc_servicefeature.php');
//include( get_template_directory() . '/inc/vc/tt_vc_contacticons.php');
//include( get_template_directory() . '/inc/vc/tt_vc_logo_carousel.php');
//include( get_template_directory() . '/inc/vc/tt_vc_feature.php');
//include( get_template_directory() . '/inc/vc/tt_vc_service.php');
//include( get_template_directory() . '/inc/vc/tt_our_approach.php');
