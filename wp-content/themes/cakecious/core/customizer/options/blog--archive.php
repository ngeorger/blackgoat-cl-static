<?php
/**
 * Customizer settings: Blog > Posts Index
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_blog_index';

/**
 * ====================================================
 * Posts Layout
 * ====================================================
 */

// Heading: Posts Layout
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_blog_index_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Posts Layout', 'cakecious' ),
	'priority'    => 10,
) ) );

// Posts layout
$key = 'blog_index_loop_mode';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'choices'     => array(
		'default' => array(
			'label' => esc_html__( 'Default', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/blog-layout--default.svg',
		),
		'grid'    => array(
			'label' => esc_html__( 'Grid', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/blog-layout--grid.svg',
		),
	),
	'priority'    => 10,
) ) );

// Edit entry default
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'blank_edit_entry_default', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[section]', 'cakecious_section_entry_default', remove_query_arg( 'autofocus' ) ) ) . '" class="cakecious-customize-goto-control button button-secondary">' . esc_html__( 'Edit Post Layout: Default', 'cakecious' ) . '</a>',
	'priority'    => 11,
) ) );

// Edit entry grid
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'blank_edit_entry_grid', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[section]', 'cakecious_section_entry_grid', remove_query_arg( 'autofocus' ) ) ) . '" class="cakecious-customize-goto-control button button-secondary">' . esc_html__( 'Edit Post Layout: Grid', 'cakecious' ) . '</a>',
	'priority'    => 11,
) ) );

// Navigation mode
$key = 'blog_index_navigation_mode';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Navigation mode', 'cakecious' ),
	'choices'     => array(
		'prev-next'  => esc_html__( 'Prev / Next buttons', 'cakecious' ),
		'pagination' => esc_html__( 'Page numbers', 'cakecious' ),
	),
	'priority'    => 15,
) );

/**
 * ====================================================
 * Content Header
 * ====================================================
 */

// Heading: Content Header
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_post_archive_content_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Header', 'cakecious' ),
	'priority'    => 20,
) ) );

// Elements
$key = 'post_archive_content_header';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'cakecious' ),
	'choices'     => array(
		'archive-title'       => esc_html__( 'Title', 'cakecious' ),
		'archive-description' => esc_html__( 'Description', 'cakecious' ),
		'breadcrumb'          => esc_html__( 'Breadcrumb', 'cakecious' ),
	),
	'priority'    => 20,
) ) );

// Alignment
$key = 'post_archive_content_header_alignment';
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
	'priority'    => 20,
) ) );

// Show on main posts archive page
$key = 'post_archive_home_content_header';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show on main posts archive page', 'cakecious' ),
	'priority'    => 20,
) ) );