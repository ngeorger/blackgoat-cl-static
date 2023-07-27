<?php
/**
 * Customizer settings: Blog > Single Post
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_blog_single';

/**
 * ====================================================
 * Content Header
 * ====================================================
 */

// Heading: Content Header
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_post_single_content_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Header', 'cakecious' ),
	'priority'    => 10,
) ) );

// Elements
$key = 'post_single_content_header';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'cakecious' ),
	'choices'     => array(
		'single-entry-header-meta' => esc_html__( 'Header Meta', 'cakecious' ),
		'entry-title'       => esc_html__( 'Title', 'cakecious' ),
		'breadcrumb'        => esc_html__( 'Breadcrumb', 'cakecious' ),
	),
	'priority'    => 10,
) ) );

// Alignment
$key = 'post_single_content_header_alignment';
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

// Header meta text
$key = 'post_single_content_header_meta';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Header meta text', 'cakecious' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}.', 'cakecious' ),
	'priority'    => 10,
) );

/**
 * ====================================================
 * Featured Image
 * ====================================================
 */

// Heading: Featured Image
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_post_single_content_thumbnail', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Featured Image', 'cakecious' ),
	'priority'    => 20,
) ) );

// Display
$key = 'post_single_content_thumbnail';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	// 'label'       => esc_html__( 'Display', 'cakecious' ),
	'choices'     => array(
		''       => esc_html__( 'Disabled', 'cakecious' ),
		'before' => esc_html__( 'Before Content Header', 'cakecious' ),
		'after'  => esc_html__( 'After Content Header', 'cakecious' ),
	),
	'priority'    => 20,
) );

// Wide alignment
$key = 'post_single_content_thumbnail_wide';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Wide alignment', 'cakecious' ) . ' <span class="cakecious-tooltip cakecious-tooltip-bottom" tabindex="0" data-tooltip="' . esc_attr__( 'Only works on Narrow content container.', 'cakecious' ) . '"><span class="dashicons dashicons-info"></span></span>',
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Content Footer
 * ====================================================
 */

// Heading: Content Footer
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_post_single_content_footer', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Footer', 'cakecious' ),
	'priority'    => 30,
) ) );

// Elements
$key = 'post_single_content_footer';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'cakecious' ),
	'choices'     => array(
		'single-entry-footer-meta' => esc_html__( 'Footer Meta', 'cakecious' ),
		'entry-tags'        => esc_html__( 'Tags', 'cakecious' ),
	),
	'priority'    => 30,
) ) );

// Alignment
$key = 'post_single_content_footer_alignment';
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
	'priority'    => 30,
) ) );

// Footer meta text
$key = 'post_single_content_footer_meta';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Footer meta text', 'cakecious' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}', 'cakecious' ),
	'priority'    => 30,
) );

/**
 * ====================================================
 * Additional Elements
 * ====================================================
 */

// Heading: After Content
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_blog_single_others', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'After Content', 'cakecious' ),
	'priority'    => 40,
) ) );

// Author bio
$key = 'blog_single_author_bio';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show author bio', 'cakecious' ),
	'priority'    => 40,
) ) );

// Prev / next posts navigation
$key = 'blog_single_navigation';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show prev / next posts navigation', 'cakecious' ),
	'priority'    => 40,
) ) );