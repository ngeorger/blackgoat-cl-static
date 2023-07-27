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
$wp_customize->add_section( 'cakecious_section_blog_related_posts', array(
	'title'       => esc_html__( 'Related Posts', 'cakecious-features' ),
	'description' => esc_html__( 'Show list of posts that are similar or related to the current loaded blog post.', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 31,
) );