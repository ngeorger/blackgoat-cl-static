<?php
/**
 * Customizer settings: Content & Sidebar > Sticky Sidebar 
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_sidebar_sticky';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Enable sticky sidebar
$key = 'sidebar_sticky';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable sticky sidebar', 'cakecious-features' ) . ' <span class="cakecious-global-default-badge cakecious-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can enable or disable this option on each individual page.', 'cakecious-features' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'cakecious-features' ) . '</span>',
	'priority'    => 10,
) ) );

// Top spacing
$key = 'sidebar_sticky_spacing_top';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Top spacing', 'cakecious-features' ),	
	'description' => esc_html__( 'If sticky header is enabled on the page, theme will automatically add the sticky header height to the top spacing value.', 'cakecious-features' ),
	'units'       => array(
		'' => array(
			'min'   => 0,
			'step'  => 1,
			'label' => 'px',
		),
	),
	'priority'    => 10,
) ) );

// Bottom spacing
$key = 'sidebar_sticky_spacing_bottom';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Bottom spacing', 'cakecious-features' ),
	'units'       => array(
		'' => array(
			'min'   => 0,
			'step'  => 1,
			'label' => 'px',
		),
	),
	'priority'    => 10,
) ) );

// Anchor
$key = 'sidebar_sticky_anchor';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Anchor', 'cakecious-features' ),
	'description' => esc_html__( 'If sidebar exceeds the screen viewport, choose which part of the sidebar that you prioritize to appear on the screen when scrolling down.', 'cakecious-features' ),
	'choices'     => array(
		'top'    => esc_html__( 'Top', 'cakecious-features' ),
		'bottom' => esc_html__( 'Bottom', 'cakecious-features' ),
	),
	'priority'    => 10,
) );