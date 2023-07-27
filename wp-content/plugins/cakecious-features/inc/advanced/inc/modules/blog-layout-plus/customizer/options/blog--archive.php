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

/**
 * Posts Layout (replacing the default one)
 */

$key = 'blog_index_loop_mode';

// Get default control.
$control = $wp_customize->get_control( $key );

$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $control->section,
	'label'       => $control->label,
	'choices'     => array_merge( $control->choices, array(
		'list'         => array(
			'label' => esc_html__( 'List', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/blog-layout--list.svg',
		),
	) ),
	'priority'    => $control->priority,
) ) );

// Edit entry list
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'edit_entry_list', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[section]', 'cakecious_section_entry_list', remove_query_arg( 'autofocus' ) ) ) . '" class="cakecious-customize-goto-control button button-secondary">' . esc_html__( 'Edit Post Layout: List', 'cakecious-features' ) . '</a>',
	'priority'    => $control->priority + 1,
) ) );