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

// // Heading: Desktop Header
// $wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_alt', array(
// 	'section'     => $section,
// 	'settings'    => array(),
// 	'label'       => esc_html__( 'Desktop Header', 'cakecious-features' ),
// 	'priority'    => 10,
// ) ) );

// Alternate Logo
$key = 'custom_logo_alt';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Alternate logo image', 'cakecious-features' ),
	'mime_type'   => 'image',
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_alt_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

$priority = 10;
$bars = array(
	'top_bar'    => esc_html__( 'Top bar colors', 'cakecious-features' ),
	'main_bar'   => esc_html__( 'Main bar colors', 'cakecious-features' ),
	'bottom_bar' => esc_html__( 'Bottom bar colors', 'cakecious-features' ),
);
foreach ( $bars as $bar => $label ) {
	$priority += 10;

	// --- Blank: Colors
	$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'label_header_' . $bar . '_alt_colors', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => $label,
		'priority'    => $priority,
	) ) );

	// Colors
	$colors = array(
		'header_' . $bar . '_alt_bg_color'                         => esc_html__( 'Background color', 'cakecious-features' ),
		'header_' . $bar . '_alt_border_color'                     => esc_html__( 'Border color', 'cakecious-features' ),
		'header_' . $bar . '_alt_text_color'                       => esc_html__( 'Text color', 'cakecious-features' ),
		'header_' . $bar . '_alt_link_text_color'                  => esc_html__( 'Link text color', 'cakecious-features' ),
		'header_' . $bar . '_alt_link_hover_text_color'            => esc_html__( 'Link text color :hover', 'cakecious-features' ),
		'header_' . $bar . '_alt_link_active_text_color'           => esc_html__( 'Link text color :active', 'cakecious-features' ),
		'header_' . $bar . '_alt_menu_hover_highlight_color'       => esc_html__( 'Highlight color :hover', 'cakecious-features' ),
		'header_' . $bar . '_alt_menu_hover_highlight_text_color'  => esc_html__( 'Highlight text color :hover', 'cakecious-features' ),
		'header_' . $bar . '_alt_menu_active_highlight_color'      => esc_html__( 'Highlight color :active', 'cakecious-features' ),
		'header_' . $bar . '_alt_menu_active_highlight_text_color' => esc_html__( 'Highlight text color :active', 'cakecious-features' ),
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

// // Heading: Mobile Header
// $wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_alt', array(
// 	'section'     => $section,
// 	'settings'    => array(),
// 	'label'       => esc_html__( 'Mobile Header', 'cakecious-features' ),
// 	'priority'    => 50,
// ) ) );

// Alternate Mobile Logo
$key = 'custom_logo_mobile_alt';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Alternate mobile logo image', 'cakecious-features' ),
	'mime_type'   => 'image',
	'priority'    => 50,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_mobile_alt_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 60,
) ) );

// --- Blank: Colors
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'label_header_mobile_main_bar_alt_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Mobile main bar colors', 'cakecious-features' ),
	'priority'    => 60,
) ) );

// Colors
$colors = array(
	'header_mobile_main_bar_alt_bg_color'                 => esc_html__( 'Background color', 'cakecious-features' ),
	'header_mobile_main_bar_alt_border_color'             => esc_html__( 'Border color', 'cakecious-features' ),
	'header_mobile_main_bar_alt_link_text_color'          => esc_html__( 'Link text color', 'cakecious-features' ),
	'header_mobile_main_bar_alt_link_hover_text_color'    => esc_html__( 'Link text color :hover', 'cakecious-features' ),
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
		'priority'    => 60,
	) ) );
}