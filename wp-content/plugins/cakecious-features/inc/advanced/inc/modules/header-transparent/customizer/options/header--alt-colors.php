<?php
/**
 * Customizer settings: Header > Alternate Header Colors
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_alt_colors';

/**
 * ====================================================
 * Desktop
 * ====================================================
 */

$priority = 15;
$bars = array(
	'top_bar'    => esc_html__( 'Top Bar', 'cakecious-features' ),
	'main_bar'   => esc_html__( 'Main Bar', 'cakecious-features' ),
	'bottom_bar' => esc_html__( 'Bottom Bar', 'cakecious-features' )
);
foreach ( $bars as $bar => $label ) {
	$priority += 10;

	// Colors
	$colors = array(
		'header_' . $bar . '_alt_transparent_bg_color'     => esc_html__( 'Transparent header: Background color', 'cakecious-features' ),
		'header_' . $bar . '_alt_transparent_border_color' => esc_html__( 'Transparent header: Border color', 'cakecious-features' ),
	);
	foreach ( $colors as $key => $label ) {
		$wp_customize->add_setting( $key, array(
			'default'     => cakecious_array_value( $defaults, $key ),
			'transport'   => 'postMessage',
			'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
		) );
		$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => $label,
			'priority'    => $priority,
		) ) );
	}
}

/**
 * ====================================================
 * Mobile
 * ====================================================
 */

// Colors
$colors = array(
	'header_mobile_main_bar_alt_transparent_bg_color'     => esc_html__( 'Transparent header: Background color', 'cakecious-features' ),
	'header_mobile_main_bar_alt_transparent_border_color' => esc_html__( 'Transparent header: Border color', 'cakecious-features' ),
);
foreach ( $colors as $key => $label ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 65,
	) ) );
}