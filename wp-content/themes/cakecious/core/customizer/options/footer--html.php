<?php
/**
 * Customizer settings: Footer > HTML
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_footer_html';

/**
 * ====================================================
 * HTML 1
 * ====================================================
 */

// Heading: HTML
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_footer_html_1', array(
	'section'     => $section,
	'settings'    => array(),
	/* translators: %s: HTML element number. */
	'label'       => sprintf( esc_html__( 'HTML %s', 'cakecious' ), 1 ),
	'priority'    => 10,
) ) );

// Content
$key = 'footer_html_1_content';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => false,
) );
$wp_customize->add_control( $key, array(
	'type'        => 'textarea',
	'section'     => $section,
	'description' => esc_html__( 'Plain text, HTML tags, and shortcode are allowed.', 'cakecious' ),
	'priority'    => 10,
) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( $key, array(
		'selector'            => '.cakecious-footer-html-1',
		'container_inclusive' => true,
		'render_callback'     => function() {
			cakecious_footer_element( 'html-1' );
		},
		'fallback_refresh'    => false,
	) );
}