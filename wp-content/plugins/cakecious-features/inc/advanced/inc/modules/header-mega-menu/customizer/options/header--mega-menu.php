<?php
/**
 * Customizer settings:
 * - Header > Top Bar
 * - Header > Main Bar
 * - Header > Bottom Bar
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;
	
$section = 'cakecious_section_header_mega_menu';

$priority = 10;
$bars = array(
	'top_bar'    => esc_html__( 'Top Bar', 'cakecious-features' ),
	'main_bar'   => esc_html__( 'Main Bar', 'cakecious-features' ),
	'bottom_bar' => esc_html__( 'Bottom Bar', 'cakecious-features' ),
);
foreach ( $bars as $bar => $label ) {
	$priority += 10;

	// Heading
	$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_' . $bar . '_mega_menu', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => $label,
		'priority'    => $priority,
	) ) );

	// Menu link typography
	$settings = array(
		'font_family'    => 'header_' . $bar . '_mega_menu_heading_font_family',
		'font_weight'    => 'header_' . $bar . '_mega_menu_heading_font_weight',
		'font_style'     => 'header_' . $bar . '_mega_menu_heading_font_style',
		'text_transform' => 'header_' . $bar . '_mega_menu_heading_text_transform',
		'font_size'      => 'header_' . $bar . '_mega_menu_heading_font_size',
		'line_height'    => 'header_' . $bar . '_mega_menu_heading_line_height',
		'letter_spacing' => 'header_' . $bar . '_mega_menu_heading_letter_spacing',
	);
	foreach ( $settings as $key ) {
		$wp_customize->add_setting( $key, array(
			'default'     => cakecious_array_value( $defaults, $key ),
			'transport'   => 'postMessage',
			'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
		) );
	}
	$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'header_' . $bar . '_mega_menu_heading_typography', array(
		'settings'    => $settings,
		'section'     => $section,
		'label'       => esc_html__( 'Mega menu heading typography', 'cakecious-features' ),
		'priority'    => $priority,
	) ) );

	// Colors
	$colors = array(
		'header_' . $bar . '_mega_menu_heading_text_color'       => esc_html__( 'Mega menu heading text color', 'cakecious-features' ),
		'header_' . $bar . '_mega_menu_heading_hover_text_color' => esc_html__( 'Mega menu heading text color :hover', 'cakecious-features' ),
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