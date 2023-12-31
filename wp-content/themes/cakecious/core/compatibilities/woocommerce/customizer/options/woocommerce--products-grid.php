<?php
/**
 * Customizer settings: WooCommerce > Products Grid
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_products_grid';

// Rows gutter
$key = 'woocommerce_products_grid_rows_gutter';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Rows gutter', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 3,
			'step' => 0.05,
		),
	),
	'priority'    => 10,
) ) );

// Columns gutter
$key = 'woocommerce_products_grid_columns_gutter';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns gutter', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 3,
			'step' => 0.05,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Grid Item
 * ====================================================
 */

// Heading: Grid Item
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_products_grid_item', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Grid Item', 'cakecious' ),
	'priority'    => 20,
) ) );

// Alignment
$key = 'woocommerce_products_grid_text_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Alignment', 'cakecious' ),
	'choices'     => array(
		'left'   => array(
			'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'right' : 'left' ) . '"></span>',
		),
		'center' => array(
			'label' => '<span class="dashicons dashicons-editor-aligncenter"></span>',
		),
		'right'  => array(
			'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'left' : 'right' ) . '"></span>',
		),
	),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Add to Cart
 * ====================================================
 */

// Heading: Add to Cart
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_products_grid_item_add_to_cart', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Add to Cart', 'cakecious' ),
	'priority'    => 50,
) ) );

// Show "add to cart" button
$key = 'woocommerce_products_grid_item_add_to_cart';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show "add to cart" button', 'cakecious' ),
	'priority'    => 50,
) ) );

/**
 * ====================================================
 * Cakecious Pro Upsell
 * ====================================================
 */

if ( cakecious_show_pro_teaser() ) {
	$wp_customize->add_control( new Cakecious_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_products_grid', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available', 'Cakecious Pro upsell', 'cakecious' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ),
		'features'    => array(
			esc_html_x( 'Grid Item\'s Styles', 'Cakecious Pro upsell', 'cakecious' ),
			esc_html_x( 'Product Quick View Popup', 'Cakecious Pro upsell', 'cakecious' ),
			esc_html_x( 'Alternate Hover Image', 'Cakecious Pro upsell', 'cakecious' ),
		),
		'priority'    => 90,
	) ) );
}