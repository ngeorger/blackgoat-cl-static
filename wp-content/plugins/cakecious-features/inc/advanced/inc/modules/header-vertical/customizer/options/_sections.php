<?php
/**
 * Customizer sections
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$panel = 'cakecious_panel_header';

// Vertical Bar
$wp_customize->add_section( 'cakecious_section_header_vertical_bar', array(
	'title'       => esc_html__( 'Vertical Bar', 'cakecious-features' ),
	'description' => esc_html__( 'Please make sure you have put at least 1 header element in the Vertical Bar (via Header Builder), otherwise no Vertical Header would be displayed.', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 15,
) );