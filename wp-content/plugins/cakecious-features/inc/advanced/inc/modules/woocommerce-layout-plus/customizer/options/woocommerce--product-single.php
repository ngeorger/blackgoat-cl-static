<?php
/**
 * Customizer settings: WooCommerce > Single Product Page
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_product_single';

/**
 * ====================================================
 * Gallery
 * ====================================================
 */

// Gallery layout
$key = 'woocommerce_single_gallery_layout';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gallery layout', 'cakecious-features' ),
	'choices'     => array(
		'bottom' => array(
			'label' => esc_html__( 'Bottom', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/woocommerce-gallery-layout--bottom.svg',
		),
		'left'   => array(
			'label' => is_rtl() ? esc_html__( 'Right', 'cakecious-features' ) : esc_html__( 'Left', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/woocommerce-gallery-layout--left.svg',
		),
		'right'  => array(
			'label' => is_rtl() ? esc_html__( 'Left', 'cakecious-features' ) : esc_html__( 'Right', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/woocommerce-gallery-layout--right.svg',
		),
	),
	'priority'    => 25,
) ) );