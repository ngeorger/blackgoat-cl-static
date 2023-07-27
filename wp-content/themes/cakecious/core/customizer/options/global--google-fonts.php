<?php
/**
 * Customizer settings: Global Modules > Google Fonts
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_google_fonts';

/**
 * ====================================================
 * Google Fonts
 * ====================================================
 */

// Language font subsets
$key = 'google_fonts_subsets';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_MultiCheck( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Language font subsets', 'cakecious' ),
	'description' => esc_html__( '"Latin" subset is included by default.', 'cakecious' ),
	'choices'     => cakecious_get_google_fonts_subsets(),
	'priority'    => 10,
) ) );