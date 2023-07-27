<?php
/**
 * Customizer settings: Header > Search
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_search';

/**
 * ====================================================
 * Search Bar
 * ====================================================
 */

// Heading: Search Bar
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_search_bar', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Search Bar', 'cakecious' ),
	'priority'    => 10,
) ) );

// Search bar width
$key = 'header_search_bar_width';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Bar width', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'   => 100,
			'step'  => 1,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Search Dropdown
 * ====================================================
 */

// Heading: Search Dropdown
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_search_dropdown', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Search Dropdown', 'cakecious' ),
	'priority'    => 20,
) ) );

// Search bar width
$key = 'header_search_dropdown_width';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Dropdown width', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'   => 100,
			'step'  => 1,
		),
	),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Cakecious Pro Upsell
 * ====================================================
 */

if ( cakecious_show_pro_teaser() ) {
	$wp_customize->add_control( new Cakecious_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_header_search', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available in Cakecious Pro', 'Cakecious Pro upsell', 'cakecious' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ),
		'features'    => array(
			esc_html_x( 'WooCommerce Products Search', 'Cakecious Pro upsell', 'cakecious' ),
		),
		'priority'    => 90,
	) ) );
}