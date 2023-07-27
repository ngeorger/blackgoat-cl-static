<?php
/**
 * Customizer settings: Other Pages > Search Page
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_search_results';

/**
 * ====================================================
 * Content Header
 * ====================================================
 */

// Heading: Content Header
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_search_results_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Header', 'cakecious' ),
	'priority'    => 10,
) ) );

// Elements
$key = 'search_results_content_header';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Elements', 'cakecious' ),
	'choices'     => array(
		'search-title' => esc_html__( 'Title', 'cakecious' ),
		'search-form'  => esc_html__( 'Search Form', 'cakecious' ),
		'breadcrumb'   => esc_html__( 'Breadcrumb', 'cakecious' ),
	),
	'priority'    => 10,
) ) );

// Title text
$key = 'search_results_title_text';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Title text', 'cakecious' ),
	'description' => esc_html__( 'Use {{keyword}} to display search keyword.', 'cakecious' ),
	'priority'    => 10,
	'input_attrs' => array(
		'placeholder' => esc_html__( 'Search results for: "{{keyword}}"', 'cakecious' ),
	),
) );

/**
 * ====================================================
 * Posts Layout
 * ====================================================
 */

// Heading: Results List
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_search_results_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Results List', 'cakecious' ),
	'priority'    => 20,
) ) );

// No results found text
$key = 'search_results_not_found_text';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'textarea' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'textarea',
	'section'     => $section,
	'label'       => esc_html__( 'No results found text', 'cakecious' ),
	'priority'    => 20,
	'input_attrs' => array(
		'placeholder' => esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'cakecious' ),
	),
) );