<?php
if ( ! defined( 'ABSPATH' ) ) exit;


/*-----------------------------------------------------------------------------------*/
/* Initiating shortcodes.
/*-----------------------------------------------------------------------------------*/


include CAKECIOUS_FW_ROOT . '/inc/shortcodes/social.php';
//Include Hero sc
if ( '1' === $cakecious_theme_components['ttnew_hero_sc'] ) {
	include CAKECIOUS_FW_ROOT . '/inc/shortcodes/ttnew-hero-sc.php';
}
if ( '1' === $cakecious_theme_components['ttnew_hero_sc'] ) {
	add_shortcode( 'cakecious_hero', 'cakecious_hero_sc' );
}
