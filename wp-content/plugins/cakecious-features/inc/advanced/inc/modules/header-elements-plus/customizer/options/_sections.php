<?php
/**
 * Customizer sections
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$panel = 'cakecious_panel_header';

// Button
$wp_customize->add_section( 'cakecious_section_header_button', array(
	'title'       => esc_html__( 'Button', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 35,
) );

// Contact Info
$wp_customize->add_section( 'cakecious_section_header_contact', array(
	'title'       => esc_html__( 'Contact Info', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 35,
) );