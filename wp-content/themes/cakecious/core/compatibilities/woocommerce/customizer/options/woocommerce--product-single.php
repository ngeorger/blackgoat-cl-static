<?php
/**
 * Customizer settings: WooCommerce > Single Product
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_product_single'; // Assumed

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Breadcrumb
$key = 'woocommerce_single_breadcrumb';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show breadcrumb', 'cakecious' ),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Images
 * ====================================================
 */

// Heading: Gallery
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_single_gallery', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Gallery', 'cakecious' ),
	'priority'    => 20,
) ) );

// Show gallery
$key = 'woocommerce_single_gallery';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show gallery', 'cakecious' ),
	'priority'    => 20,
) ) );

// Gallery column width
$key = 'woocommerce_single_gallery_width';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	// 'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gallery column Width', 'cakecious' ),
	'units'       => array(
		'%' => array(
			'min'  => 25,
			'max'  => 75,
			'step' => 0.05,
		),
	),
	'priority'    => 20,
) ) );

// Gallery column gap
$key = 'woocommerce_single_gallery_gap';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gap with summary column', 'cakecious' ),
	'units'       => array(
		'%' => array(
			'min'  => 0,
			'max'  => 10,
			'step' => 1,
		),
		'px' => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

// Enable zoom
$key = 'woocommerce_single_gallery_zoom';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable zoom', 'cakecious' ),
	'priority'    => 20,
) ) );

// Enable lightbox
$key = 'woocommerce_single_gallery_lightbox';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable lightbox', 'cakecious' ),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Tabs
 * ====================================================
 */

// Heading: Tabs
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_single_tabs', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Tabs', 'cakecious' ),
	'priority'    => 40,
) ) );

// Show tabs
$key = 'woocommerce_single_tabs';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show tabs', 'cakecious' ),
	'priority'    => 40,
) ) );


/**
 * ====================================================
 * Up-Sells
 * ====================================================
 */

// Heading: Up-Sells
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_single_up_sells', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Up-Sells', 'cakecious' ),
	'priority'    => 50,
) ) );

// Show up-sells
$key = 'woocommerce_single_up_sells';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show up-sells', 'cakecious' ),
	'description' => esc_html__( 'Display up-sells as configured on Edit Product page > Product Data > Linked Products > Up-sells.', 'cakecious' ),
	'priority'    => 50,
) ) );

// Up-sells columns
$key = 'woocommerce_single_up_sells_grid_columns';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns', 'cakecious' ),
	'units'       => array(
		'' => array(
			'min'  => 1,
			'max'  => 6,
			'step' => 1,
			'label' => 'col',
		),
	),
	'priority'    => 50,
) ) );

/**
 * ====================================================
 * Related
 * ====================================================
 */

// Heading: Related Products
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_single_related', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Related Products', 'cakecious' ),
	'priority'    => 60,
) ) );

// Show related products
$key = 'woocommerce_single_related';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show related products', 'cakecious' ),
	'description' => esc_html__( 'Display linked products and similar products within same categories or tags. Products that have been displayed on "Up-sells" section will not be included.', 'cakecious' ),
	'priority'    => 60,
) ) );

// Related products posts per page
$key = 'woocommerce_single_related_posts_per_page';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'number' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'number',
	'section'     => $section,
	'label'       => esc_html__( 'Max products shown', 'cakecious' ),
	'description' => esc_html__( '0 = disabled; -1 = show all.', 'cakecious' ),
	'input_attrs' => array(
		'min'  => -1,
		'max'  => 12,
		'step' => 1,
	),
	'priority'    => 60,
) );

// Related products columns
$key = 'woocommerce_single_related_grid_columns';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns', 'cakecious' ),
	'units'       => array(
		'' => array(
			'min'  => 1,
			'max'  => 6,
			'step' => 1,
			'label' => 'col',
		),
	),
	'priority'    => 60,
) ) );

/**
 * ====================================================
 * Cakecious Pro Upsell
 * ====================================================
 */

if ( cakecious_show_pro_teaser() ) {
	$wp_customize->add_control( new Cakecious_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_single', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available', 'Cakecious Pro upsell', 'cakecious' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ),
		'features'    => array(
			esc_html_x( 'AJAX Add To Cart', 'Cakecious Pro upsell', 'cakecious' ),
			esc_html_x( 'More Gallery Layouts', 'Cakecious Pro upsell', 'cakecious' ),
		),
		'priority'    => 190,
	) ) );
}