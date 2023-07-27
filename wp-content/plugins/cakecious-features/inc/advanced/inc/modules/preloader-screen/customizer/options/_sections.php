<?php
/**
 * Customizer sections
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

// Preloader Screen
$wp_customize->add_section( 'cakecious_section_preloader_screen', array(
	'title'       => esc_html__( 'Preloader Screen', 'cakecious-features' ),
	'priority'    => 135,
) );