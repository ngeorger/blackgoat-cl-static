<?php
/**
 * Customizer settings: Footer > Copyright
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_footer_copyright';

/**
 * ====================================================
 * Copyright
 * ====================================================
 */

// Heading: HTML
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_footer_copyright', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Copyright', 'cakecious' ),
	'priority'    => 10,
) ) );

// Copyright
$key = 'footer_copyright_content';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'html' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'textarea',
	'section'     => $section,
	'label'       => esc_html__( 'Copyright Text', 'cakecious' ),
	'description' => esc_html__( 'Available tags: {{year}}, {{sitename}}, {{theme}}, {{theme_author}}.', 'cakecious' ),
	'priority'    => 10,
) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $key, array(
		'selector'            => '.cakecious-footer-copyright',
		'container_inclusive' => true,
		'render_callback'     => function() {
			cakecious_footer_element( 'copyright' );
		},
		'fallback_refresh'    => false,
	) );
}