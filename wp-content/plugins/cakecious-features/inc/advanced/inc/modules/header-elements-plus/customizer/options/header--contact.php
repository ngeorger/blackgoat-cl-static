<?php
/**
 * Customizer settings: Header > Contact Info
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_contact';

/**
 * ====================================================
 * Contact Info
 * ====================================================
 */

// Heading: Contact Info
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_contact', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Contact Info', 'cakecious-features' ),
	'priority'    => 10,
) ) );

/*
$items = array(
	'email'   => esc_html__( 'Email', 'cakecious-features' ),
	'phone'   => esc_html__( 'Phone', 'cakecious-features' ),
	'address' => esc_html__( 'Address', 'cakecious-features' ),
	'time'    => esc_html__( 'Business Hours', 'cakecious-features' ),
);
*/
$items = array(
	'email'   => array(
		'label'            => esc_html__( 'Email', 'cakecious-features' ),
		'url_description'  => esc_html__( 'Leave it blank to display Email as a plain text. Use this format: "mailto:your.email@address.com"', 'cakecious-features' ),
		'url_placeholder'  => esc_html__( 'mailto:your.email@address.com', 'cakecious-features' ),
	),
	'phone'   => array(
		'label'            => esc_html__( 'Phone', 'cakecious-features' ),
		'url_description'  => esc_html__( 'Leave it blank to display Phone as a plain text. Use this format: "tel:1234567890"', 'cakecious-features' ),
		'url_placeholder'  => esc_html__( 'tel:1234567890', 'cakecious-features' ),
	),
	'address' => array(
		'label'            => esc_html__( 'Address', 'cakecious-features' ),
		'url_description'  => esc_html__( 'Leave it blank to display Address as a plain text.', 'cakecious-features' ),
		'url_placeholder'  => '',
	),
	'time'    => array(
		'label'            => esc_html__( 'Business Hours', 'cakecious-features' ),
		'url_description'  => esc_html__( 'Leave it blank to display Business Hours as a plain text.', 'cakecious-features' ),
		'url_placeholder'  => '',
	),
);

$labels = array();
foreach ( $items as $slug => $item ) {
	$labels[ $slug ] = $item['label'];
}

// Info items
$key = 'header_contact_items';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Builder( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Active items', 'cakecious-features' ),
	'choices'     => $labels, //$items,
	'priority'    => 10,
) ) );

foreach ( $items as $slug => $item ) {
	// ------
	$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_contact_' . $slug, array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 10,
	) ) );

	// Text
	$key = 'header_contact_' . $slug . '_text';
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
	) );
	$wp_customize->add_control( $key, array(
		'section'     => $section,
		/* translators: %s: contact item name. */
		'label'       => sprintf( esc_html__( '%s text', 'cakecious-features' ), $item['label'] ),
		'priority'    => 10,
	) );

	// Link
	$key = 'header_contact_' . $slug . '_url';
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wp_customize->add_control( $key, array(
		'section'     => $section,
		/* translators: %s: contact item name. */
		'label'       => sprintf( esc_html__( '%s URL', 'cakecious-features' ), $item['label'] ),
		/* translators: %1$s: contact item name. */
		'description' => $item['url_description'],
		'input_attrs' => array(
			'placeholder' => $item['url_placeholder'],
		),
		'priority'    => 10,
	) );
}

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$settings = array( 'header_contact_items' );
	foreach ( $items as $slug => $label ) {
		$settings[] = 'header_contact_' . $slug . '_text';
		$settings[] = 'header_contact_' . $slug . '_url';
	}

	$wp_customize->selective_refresh->add_partial( 'header_contact', array(
		'settings'            => $settings,
		'selector'            => '.cakecious-header-contact',
		'container_inclusive' => true,
		'render_callback'     => array( Cakecious_Pro_Module_Header_Elements_Plus::instance(), 'render_header_element__contact' ),
		'fallback_refresh'    => false,
	) );
}