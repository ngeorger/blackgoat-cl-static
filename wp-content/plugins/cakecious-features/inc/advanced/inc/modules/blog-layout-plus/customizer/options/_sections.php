<?php
/**
 * Customizer sections
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$panel = 'cakecious_panel_blog';

// Post Layout: List
$wp_customize->add_section( 'cakecious_section_entry_list', array(
	'title'       => esc_html__( 'List', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 11,
) );