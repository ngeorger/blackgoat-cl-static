<?php
/**
 * Customizer settings: Header > Search
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_search';

/**
 * ====================================================
 * Search
 * ====================================================
 */

$choices = array(
	'default' => esc_html__( 'Default search', 'cakecious-features' ),
);

if ( class_exists( 'WooCommerce' ) ) {
	$choices['products'] = esc_html__( 'Products search (WooCommerce)', 'cakecious-features' );
}

if ( 1 < count( $choices ) ) {
	// Search query mode
	$key = 'header_search_mode';
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Search query mode', 'cakecious-features' ),
		'choices'     => $choices,
		'priority'    => 1,
	) );
}