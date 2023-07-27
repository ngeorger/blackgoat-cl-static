<?php
/**
 * Customizer settings: Footer > Social Links
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_footer_social';

/**
 * ====================================================
 * Social Links
 * ====================================================
 */

// Heading: Social Links
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_footer_social', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Social Links', 'cakecious' ),
	'description' => sprintf(
		/* translators: %s: link to "Global Modules" section. */
		esc_html__( 'You can edit Social Media URLs via %s.', 'cakecious' ),
		'<a href="' . esc_attr( add_query_arg( 'autofocus[panel]', 'cakecious_panel_global_settings', remove_query_arg( 'autofocus' ) ) ) . '" class="cakecious-customize-goto-control">' . esc_html__( 'Global Modules', 'cakecious' ) . '</a>'
	),
	'priority'    => 10,
) ) );

// Social links
$key = 'footer_social_links';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Builder( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Active links', 'cakecious' ),
	'choices'     => cakecious_get_social_media_types( true ),
	'priority'    => 10,
) ) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'footer_social_links', array(
		'selector'            => '.cakecious-footer-social',
		'container_inclusive' => true,
		'render_callback'     => function() {
			cakecious_footer_element( 'social' );
		},
		'fallback_refresh'    => false,
	) );
}

// Social links target
$key = 'footer_social_links_target';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Open links in', 'cakecious' ),
	'choices'     => array(
		'self'  => esc_html__( 'Same tab', 'cakecious' ),
		'blank' => esc_html__( 'New tab', 'cakecious' ),
	),
	'priority'    => 10,
) );