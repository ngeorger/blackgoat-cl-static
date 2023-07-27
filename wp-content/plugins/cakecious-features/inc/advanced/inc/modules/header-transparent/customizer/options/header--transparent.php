<?php
/**
 * Customizer settings: Header > Transparent Header
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_transparent';

/**
 * ====================================================
 * Desktop
 * ====================================================
 */

// // Heading: Desktop Header
// $wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_transparent', array(
// 	'section'     => $section,
// 	'settings'    => array(),
// 	'label'       => esc_html__( 'Desktop Header', 'cakecious-features' ),
// 	'priority'    => 10,
// ) ) );

// Enable transparent mode
$key = 'header_transparent';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable transparent mode', 'cakecious-features' ) . ' <span class="cakecious-global-default-badge cakecious-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can enable or disable this option on each individual page.', 'cakecious-features' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'cakecious-features' ) . '</span>',
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_transparent_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

$priority = 10;
$bars = array(
	'top_bar'    => esc_html__( 'Top bar colors', 'cakecious-features' ),
	'main_bar'   => esc_html__( 'Main bar colors', 'cakecious-features' ),
	'bottom_bar' => esc_html__( 'Bottom bar colors', 'cakecious-features' )
);
foreach ( $bars as $bar => $label ) {
	$priority += 10;

	// --- Blank: Colors
	$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'label_header_' . $bar . '_transparent_colors', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => $label,
		'priority'    => $priority,
	) ) );

	// Colors
	$colors = array(
		'header_' . $bar . '_transparent_bg_color'     => esc_html__( 'Background color', 'cakecious-features' ),
		'header_' . $bar . '_transparent_border_color' => esc_html__( 'Border color', 'cakecious-features' ),
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
 * Colors
 * ====================================================
 */

// // Heading: Mobile Header
// $wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_transparent', array(
// 	'section'     => $section,
// 	'settings'    => array(),
// 	'label'       => esc_html__( 'Mobile Header', 'cakecious-features' ),
// 	'priority'    => 50,
// ) ) );

// Enable transparent mode
$key = 'header_mobile_transparent';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable transparent mode', 'cakecious-features' ) . ' <span class="cakecious-global-default-badge cakecious-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can enable or disable this option on each individual page.', 'cakecious-features' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'cakecious-features' ) . '</span>',
	'priority'    => 50,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_mobile_transparent_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 50,
) ) );

// --- Blank: Label colors
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'label_header_mobile_transparent_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Mobile main bar colors', 'cakecious-features' ),
	'priority'    => 50,
) ) );

// Colors
$colors = array(
	'header_mobile_main_bar_transparent_bg_color'     => esc_html__( 'Background color', 'cakecious-features' ),
	'header_mobile_main_bar_transparent_border_color' => esc_html__( 'Border color', 'cakecious-features' ),
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
		'priority'    => 50,
	) ) );
}