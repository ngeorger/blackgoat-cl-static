<?php
/**
 * Customizer settings: Header > Button(s)
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_button';

for ( $i = 1; $i <= 2; $i++ ) {
	$priority = $i * 10;
	
	/**
	 * ====================================================
	 * Button %d
	 * ====================================================
	 */

	// Heading: Button
	$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_button_' . $i, array(
		'section'     => $section,
		'settings'    => array(),
		/* translators: %d: number of Button element. */
		'label'       => sprintf( esc_html__( 'Button %d', 'cakecious-features' ), $i ),
		'priority'    => $priority,
	) ) );

	// Button URL
	$key = 'header_button_' . $i . '_url';
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( $key, array(
		'section'     => $section,
		'label'       => esc_html__( 'Button link URL', 'cakecious-features' ),
		'priority'    => $priority,
	) );

	// Button text
	$key = 'header_button_' . $i . '_text';
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
	) );
	$wp_customize->add_control( $key, array(
		'section'     => $section,
		'label'       => esc_html__( 'Button text', 'cakecious-features' ),
		'priority'    => $priority,
	) );

	// Button target
	$key = 'header_button_' . $i . '_target';
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Open button link in', 'cakecious-features' ),
		'choices'     => array(
			'self'  => esc_html__( 'Same tab', 'cakecious-features' ),
			'blank' => esc_html__( 'New tab', 'cakecious-features' ),
		),
		'priority'    => $priority,
	) );
	
	// Selective Refresh
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'header_button_' . $i, array(
			'settings'            => array(
				'header_button_' . $i . '_url',
				'header_button_' . $i . '_text',
				'header_button_' . $i . '_target',
			),
			'selector'            => '.cakecious-header-button-' . $i,
			'container_inclusive' => true,
			'render_callback'     => function() {
				cakecious_header_element( 'button-' . $i );
			},
			'fallback_refresh'    => false,
		) );
	}
}