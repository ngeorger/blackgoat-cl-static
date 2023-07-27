<?php
/**
 * Customizer sections
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$panel = 'cakecious_panel_blog';

// ------
$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_blog_advanced', array(
	'title'       => esc_html__( 'Advanced', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 30,
) ) );

// Related Posts
$wp_customize->add_section( 'cakecious_section_blog_featured_posts', array(
	'title'       => esc_html__( 'Featured Posts', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 32,
) );