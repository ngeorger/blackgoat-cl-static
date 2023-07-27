<?php
/**
 * Customizer sections
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$panel = 'cakecious_panel_header';

// ------
$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_header_advanced', array(
	'title'       => esc_html__( 'Advanced', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 40,
) ) );

// Mega Menu
$wp_customize->add_section( 'cakecious_section_header_mega_menu', array(
	'title'       => esc_html__( 'Mega Menu', 'cakecious-features' ),
	'description' => esc_html__( 'Mega Menu is only available for Desktop Header. You can build mega menu from the Menus editor.', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 44,
) );