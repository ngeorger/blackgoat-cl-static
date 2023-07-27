<?php
/**
 * Customizer settings: Header > Menu
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_menu';

// Heading: Vertical Menu
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_vertical_menu', array(
	'section'     => $section,
	'settings'    => array(),
	/* translators: %s: Menu element number. */
	'label'       => esc_html__( 'Vertical Menu', 'cakecious-features' ),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[control]', 'nav_menu_locations[header-vertical-menu]', remove_query_arg( 'autofocus' ) ) ) . '" class="cakecious-customize-goto-control button button-secondary">' . esc_html__( 'Setup Menu', 'cakecious-features' ) . '</a>',
	'priority'    => 15,
) ) );