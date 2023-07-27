<?php
/**
 * Customizer settings: Global Modules > Color Palette
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_color_palette';

/**
 * ====================================================
 * Color Palette
 * ====================================================
 */

// Warning
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'notice_color_palette_1', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<div class="notice notice-warning notice-alt inline"><p>' . esc_html__( 'This is not "Global Colors", if you want to set colors for body text, heading, link, etc., please go to Global > Typography & Colors section.', 'cakecious' ) . '</p></div>',
	'priority'    => 10,
) ) );

for ( $i = 1; $i <= 8; $i++ ) {
	// Colors
	$key = 'color_palette_' . $i;
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
		'section'     => $section,
		/* translators: %s: color number. */
		'label'       => sprintf( esc_html__( 'Color %s', 'cakecious' ), $i ),
		'has_palette' => false,
		'priority'    => 10,
	) ) );
}

// Info
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'notice_color_palette_2', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<div class="notice notice-info notice-alt inline"><p>' . esc_html__( 'After changing colors, publish the changes and then reload this Customizer page.', 'cakecious' ) . '</p></div>',
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Gutenberg Integration
 * ====================================================
 */

// Heading: Gutenberg Integration
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_color_palette_gutenberg', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Gutenberg Integration', 'cakecious' ),
	'priority'    => 20,
) ) );

// Use as Gutenberg color palette
$key = 'color_palette_in_gutenberg';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Use as Gutenberg color palette', 'cakecious' ),
	'description' => esc_html__( 'Enabling this would replace the original Gutenberg\'s color palette with the colors you defined above.', 'cakecious' ),
	'priority'    => 20,
) ) );