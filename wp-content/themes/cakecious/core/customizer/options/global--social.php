<?php
/**
 * Customizer settings: Global Modules > Social Media URLs
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_social';

/**
 * ====================================================
 * Links
 * ====================================================
 */

$links = cakecious_get_social_media_types( true );
ksort( $links );
	
foreach ( $links as $slug => $label ) {
	// Social media link
	$key = 'social_' . $slug;
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( $key, array(
		'section'     => $section,
		'description' => cakecious_icon( $slug, array(), false ) . $label,
		'priority'    => 10,
	) );
}

/**
 * ====================================================
 * Cakecious Pro Upsell
 * ====================================================
 */

if ( cakecious_show_pro_teaser() ) {
	$wp_customize->add_control( new Cakecious_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_social_icons', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available in Cakecious Pro', 'Cakecious Pro upsell', 'cakecious' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ),
		'features'    => array(
			esc_html_x( 'Replace default social icons with custom icons', 'Cakecious Pro upsell', 'cakecious' ),
			esc_html_x( 'Add more (custom) social icons', 'Cakecious Pro upsell', 'cakecious' ),
		),
		'priority'    => 90,
	) ) );
}