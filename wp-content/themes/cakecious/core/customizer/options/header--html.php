<?php
/**
 * Customizer settings: Header > HTML
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_html';

/**
 * ====================================================
 * HTML 1
 * ====================================================
 */

// Heading: HTML
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_html_1', array(
	'section'     => $section,
	'settings'    => array(),
	/* translators: %s: HTML element number. */
	'label'       => sprintf( esc_html__( 'HTML %s', 'cakecious' ), 1 ),
	'priority'    => 10,
) ) );

// Content
$key = 'header_html_1_content';
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
		'selector'            => '.cakecious-header-html-1',
		'container_inclusive' => true,
		'render_callback'     => function() {
			cakecious_header_element( 'html-1' );
		},
		'fallback_refresh'    => false,
	) );
}

/**
 * ====================================================
 * Cakecious Pro Upsell
 * ====================================================
 */

$features = array();
for ( $i = 2; $i <=3; $i++ ) {
	/* translators: %s: HTML element number. */
	$features[] = sprintf( esc_html_x( 'HTML %s', 'Cakecious Pro upsell', 'cakecious' ), $i );
}

if ( cakecious_show_pro_teaser() ) {
	$wp_customize->add_control( new Cakecious_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_header_html', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available in Cakecious Pro', 'Cakecious Pro upsell', 'cakecious' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ),
		'features'    => $features,
		'priority'    => 90,
	) ) );
}