<?php
/**
 * Customizer sections
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

// Brizy Integration
$wp_customize->add_section( 'cakecious_section_brizy', array(
	'title'       => esc_html__( 'Brizy Integration', 'cakecious' ),
	'priority'    => 199,
) );