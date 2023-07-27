<?php
/**
 * Customizer sections
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$panel = 'woocommerce';

// ------
$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_woocommerce_advanced', array(
	'title'       => esc_html__( 'Advanced', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 40,
) ) );

// Off Canvas Filters
$wp_customize->add_section( 'woocommerce_off_canvas_filters', array(
	'title'       => esc_html__( 'Off Canvas Filters', 'cakecious-features' ),
	'description' => '<p>' . esc_html__( 'Off Canvas Filters is an additional widgets area that contains products filtering widgets.', 'cakecious-features' ) . '</p>',
	'panel'       => $panel,
	'priority'    => 72,
) );