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

// Quick View
$wp_customize->add_section( 'woocommerce_quick_view', array(
	'title'       => esc_html__( 'Product Quick View', 'cakecious-features' ),
	'description' => '<p>' . esc_html__( 'Quick View allows users to view summary info of a product and add to cart directly from the shop page.', 'cakecious-features' ) . '</p>',
	'panel'       => $panel,
	'priority'    => 73,
) );