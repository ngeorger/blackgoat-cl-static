<?php
/**
 * Customizer sections
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$panel = 'cakecious_panel_content';

// ------
$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_content_sidebar_advanced', array(
	'title'       => esc_html__( 'Advanced', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 30,
) ) );

// Preloader Screen
$wp_customize->add_section( 'cakecious_section_sidebar_sticky', array(
	'title'       => esc_html__( 'Sticky Sidebar', 'cakecious-features' ),
	'description' => esc_html__( 'Sticky Sidebar is only available on Desktop view.', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 31,
) );