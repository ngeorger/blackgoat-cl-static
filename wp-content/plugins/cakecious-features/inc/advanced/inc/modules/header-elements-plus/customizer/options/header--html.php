<?php
/**
 * Customizer settings: Header > HTML
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_html';

for ( $i = 2; $i <= 3; $i++ ) {
	/**
	 * ====================================================
	 * HTML %d
	 * ====================================================
	 */

	// Heading: HTML
	$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_html_' . $i, array(
		'section'     => $section,
		'settings'    => array(),
		/* translators: %d: number of HTML element. */
		'label'       => sprintf( esc_html__( 'HTML %d', 'cakecious-features' ), $i ),
		'priority'    => 10,
	) ) );

	// Content
	$key = 'header_html_' . $i . '_content';
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => false,
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'textarea',
		'section'     => $section,
		'description' => esc_html__( 'Plain text, HTML tags, and shortcode are allowed.', 'cakecious-features' ),
		'priority'    => 10,
	) );

	// Selective Refresh
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( $key, array(
			'selector'            => '.cakecious-header-html-' . $i,
			'container_inclusive' => true,
			'render_callback'     => function() {
				cakecious_header_element( 'html-' . $i );
			},
			'fallback_refresh'    => false,
		) );
	}
}