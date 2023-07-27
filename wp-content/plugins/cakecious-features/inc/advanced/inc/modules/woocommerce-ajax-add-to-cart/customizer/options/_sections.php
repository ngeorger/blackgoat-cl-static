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

// AJAX Add To Cart
$wp_customize->add_section( 'woocommerce_ajax_add_to_cart', array(
	'title'       => esc_html__( 'AJAX Add To Cart', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 71,
) );