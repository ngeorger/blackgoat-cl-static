<?php
/**
 * Customizer settings: Other Pages > 404 Page
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_error_404';

// Image
$key = 'error_404_image';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Image', 'cakecious' ),
	'mime_type'   => 'image',
	'priority'    => 10,
) ) );

// Max width
$key = 'error_404_image_width';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	// 'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Max width', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_error_404_text', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Title text
$key = 'error_404_title';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Title text', 'cakecious' ),
	'priority'    => 10,
	'input_attrs' => array(
		'placeholder' => esc_html__( 'Oops! That page can not be found', 'cakecious' ),
	),
) );

// Description
$key = 'error_404_description';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'textarea' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'textarea',
	'section'     => $section,
	'label'       => esc_html__( 'Description', 'cakecious' ),
	'priority'    => 10,
	'input_attrs' => array(
		'placeholder' => esc_html__( 'It looks like nothing was found at this location. Maybe try searching?', 'cakecious' ),
	),
) );

// Show search bar
$key = 'error_404_search_bar';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show search bar', 'cakecious' ),
	'priority'    => 10,
) ) );

// Show home button
$key = 'error_404_home_button';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show home button', 'cakecious' ),
	'priority'    => 10,
) ) );

// Button text
$key = 'error_404_home_button_text';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Button text', 'cakecious' ),
	'priority'    => 10,
	'input_attrs' => array(
		'placeholder' => esc_html__( 'Back to Home', 'cakecious' ),
	),
) );