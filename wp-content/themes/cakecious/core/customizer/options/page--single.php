<?php
/**
 * Customizer settings: Other Pages > Static Page
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_page_single';

/**
 * ====================================================
 * Content Header
 * ====================================================
 */

// Heading: Content Header
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_page_single_content_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Header', 'cakecious' ),
	'priority'    => 10,
) ) );

// Elements
$key = 'page_single_content_header';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'cakecious' ),
	'choices'     => array(
		'entry-title'   => esc_html__( 'Title', 'cakecious' ),
		'entry-excerpt' => esc_html__( 'Excerpt', 'cakecious' ),
		'breadcrumb'    => esc_html__( 'Breadcrumb', 'cakecious' ),
	),
	'priority'    => 10,
) ) );

// Alignment
$key = 'page_single_content_header_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Alignment', 'cakecious' ),
	'choices'     => array(
		'left'   => array(
			'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'right' : 'left' ) . '"></span>',
		),
		'center' => array(
			'label' => '<span class="dashicons dashicons-editor-aligncenter"></span>',
		),
		'right'  => array(
			'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'left' : 'right' ) . '"></span>',
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Featured Image
 * ====================================================
 */

// Heading: Featured Image
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_page_single_content_thumbnail', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Featured Image', 'cakecious' ),
	'priority'    => 20,
) ) );

// Featured image
$key = 'page_single_content_thumbnail';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	// 'label'       => esc_html__( 'Featured image', 'cakecious' ),
	'choices'     => array(
		''       => esc_html__( 'Disabled', 'cakecious' ),
		'before' => esc_html__( 'Before Content Header', 'cakecious' ),
		'after'  => esc_html__( 'After Content Header', 'cakecious' ),
	),
	'priority'    => 20,
) );

// Wide alignment
$key = 'page_single_content_thumbnail_wide';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Wide alignment', 'cakecious' ) . ' <span class="cakecious-tooltip cakecious-tooltip-bottom" tabindex="0" data-tooltip="' . esc_attr__( 'Only works on Narrow content container.', 'cakecious' ) . '"><span class="dashicons dashicons-info"></span></span>',
	'priority'    => 20,
) ) );