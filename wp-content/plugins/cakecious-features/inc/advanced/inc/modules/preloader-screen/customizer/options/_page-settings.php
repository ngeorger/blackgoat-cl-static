<?php
/**
 * Customizer settings: Page Settings
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( Cakecious_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
	$section = $ps_data['section'];
	$option_key = 'page_settings_' . $ps_type;

	// Get default value (array) of the option key.
	$default = cakecious_array_value( $defaults, $option_key, array() );
	if ( ! is_array( $default ) ) {
		$default = array();
	}

	if ( 'error_404' === $ps_type ) {
		continue;
	}

	/**
	 * ====================================================
	 * Preloader Screen
	 * ====================================================
	 */

	// // Heading: Preloader Screen
	// $wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $ps_type . '_preloader_screen', array(
	// 	'section'     => $section,
	// 	'settings'    => array(),
	// 	'label'       => esc_html__( 'Preloader Screen', 'cakecious-features' ),
	// 	'priority'    => 50,
	// ) ) );

	// ------
	$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_preloader_screen', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 160,
	) ) );

	// Preloader screen
	$subkey = 'preloader_screen';
	$key = $option_key . '[' . $subkey . ']';
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $default, $subkey ),
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Preloader screen', 'cakecious-features' ),
		'choices'     => array(
			''  => esc_html__( '-- Global --', 'cakecious-features' ),
			'0' => esc_html__( '&#x2718; Disabled', 'cakecious-features' ),
			'1' => esc_html__( '&#x2714; Enabled', 'cakecious-features' ),
		),
		'priority'    => 160,
	) );
}