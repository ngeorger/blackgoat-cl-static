<?php
/**
 * Customizer sections: WooComerce
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

// Header Builder -- Cart
$wp_customize->add_section( 'cakecious_section_header_cart', array(
	'title'       => esc_html__( 'Shopping Cart', 'cakecious' ),
	'panel'       => 'cakecious_panel_header',
	'priority'    => 30,
) );

// Panel
$panel = 'woocommerce';
$wp_customize->get_panel( $panel )->priority = 142;

// ------
$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_woocommerce_pages', array(
	'title'       => esc_html__( 'Pages', 'cakecious' ),
	'panel'       => $panel,
	'priority'    => 10,
) ) );

// Products Catalog
$wp_customize->get_section( 'woocommerce_product_catalog' )->title = esc_html__( 'Products Catalog Page', 'cakecious' );
$wp_customize->get_section( 'woocommerce_product_catalog' )->priority = 11;

// Single Product
$wp_customize->add_section( 'woocommerce_product_single', array(
	'title'       => esc_html__( 'Single Product Page', 'cakecious' ),
	'panel'       => $panel,
	'priority'    => 11, // Place it under the 'Shop (Products Catalog) Page' section
) );

// Cart
$wp_customize->add_section( 'woocommerce_cart', array(
	'title'       => esc_html__( 'Cart Page', 'cakecious' ),
	'panel'       => $panel,
	'priority'    => 11, // Place it under the 'Shop (Products Catalog) Page' section
) );

// Checkout
$wp_customize->get_section( 'woocommerce_checkout' )->title = esc_html__( 'Checkout Page', 'cakecious' );
$wp_customize->get_section( 'woocommerce_checkout' )->priority = 12;

// ------
$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_woocommerce_general', array(
	'title'       => esc_html__( 'General', 'cakecious' ),
	'panel'       => $panel,
	'priority'    => 20,
) ) );

// General Elements
$wp_customize->add_section( 'cakecious_section_woocommerce_elements', array(
	'title'       => esc_html__( 'General Elements', 'cakecious' ),
	'panel'       => $panel,
	'priority'    => 21,
) );

// Products Grid
$wp_customize->add_section( 'woocommerce_products_grid', array(
	'title'       => esc_html__( 'Products Grid', 'cakecious' ),
	'description' => esc_html__( 'Global styles for products grid as used in main product catalog page, related products, up-sells, cross-sells, and products shortcodes.', 'cakecious' ),
	'panel'       => $panel,
	'priority'    => 21,
) );

// Product Images
$wp_customize->get_section( 'woocommerce_product_images' )->priority = 28;

// Store Notice
$wp_customize->get_section( 'woocommerce_store_notice' )->priority = 29;

if ( cakecious_show_pro_teaser() ) {
	// More Options Available
	$wp_customize->add_section( new Cakecious_Customize_Section_Pro_Teaser( $wp_customize, 'cakecious_section_teaser_pro_upsell_woocommerce', array(
		'title'       => esc_html_x( 'More Options Available', 'Cakecious Pro upsell', 'cakecious' ),
		'panel'       => $panel,
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ),
		'features'    => array(
			esc_html_x( 'AJAX Add to Cart', 'Cakecious Pro upsell', 'cakecious' ),
			esc_html_x( 'Product Alternate Hover Image', 'Cakecious Pro upsell', 'cakecious' ),
			esc_html_x( 'Product Quick View Popup', 'Cakecious Pro upsell', 'cakecious' ),
			esc_html_x( 'Off-Canvas Filters', 'Cakecious Pro upsell', 'cakecious' ),
			esc_html_x( 'Checkout Optimization', 'Cakecious Pro upsell', 'cakecious' ),
		),
		'priority'    => 90,
	) ) );
}