<?php
/**
 * Customizer settings: Content & Sidebar > Main Content Area
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_main';

/**
 * ====================================================
 * Main Content Area
 * ====================================================
 */

// Padding
$key = 'content_main_padding';
$settings = array(
	$key,
	$key . '__tablet',
	$key . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => cakecious_array_value( $defaults, $setting ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimensions' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Dimensions( $wp_customize, $key, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Padding', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'step' => 0.05,
		),
		'%' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Border
$key = 'content_main_border';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimensions( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Typography
 * ====================================================
 */

// // Heading: Typography
// $wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_content_main_typography', array(
// 	'section'     => $section,
// 	'settings'    => array(),
// 	'label'       => esc_html__( 'Typography', 'cakecious' ),
// 	'description' => sprintf(
// 		/* translators: %s: link to "Base" section. */
// 		esc_html__( 'Inherit the Base typography settings.', 'cakecious' ),
// 		'<a href="' . esc_attr( add_query_arg( 'autofocus[section]', 'cakecious_section_body', remove_query_arg( 'autofocus' ) ) ) . '" class="cakecious-customize-goto-control">' . esc_html__( 'Base', 'cakecious' ) . '</a>'
// 	),
// 	'priority'    => 20,
// ) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_content_main_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'cakecious' ),
	'priority'    => 30,
) ) );

// Colors
$colors = array(
	'content_main_bg_color'     => esc_html__( 'Content Box BG color', 'cakecious' ),
	'content_main_border_color' => esc_html__( 'Content Box border color', 'cakecious' ),
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
		'priority'    => 30,
	) ) );
}