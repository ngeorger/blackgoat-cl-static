<?php
/**
 * Customizer settings: WooCommerce > Checkout
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_checkout'; // Assumed

/**
 * ====================================================
 * Content Layout
 * ====================================================
 */

// Heading: Content Layout
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_checkout_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Content Layout', 'cakecious' ),
	'priority'    => 20,
) ) );

// Checkout layout
$key = 'woocommerce_checkout_layout';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Checkout layout', 'cakecious' ),
	'choices'     => array(
		'default' => array(
			'label' => esc_html__( 'Default', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/woocommerce-checkout-layout--default.svg',
		),
		'2-columns' => array(
			'label' => esc_html__( '2 Columns', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/woocommerce-checkout-layout--2-columns.svg',
		),
	),
	'priority'    => 20,
) ) );

// 2 columns notice
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'notice_checkout_2_columns', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<div class="notice notice-info notice-alt inline"><p>' . esc_html__( 'When using 2 Columns layout, it\'s recommended to set the container width to "Normal" or "Full width" and also hide the sidebar via the "Individual Page Settings" meta box available on the page editor.', 'cakecious' ) . '</p></div>',
	'priority'    => 21,
) ) );

// Heading: Individual Page Settings
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_page_settings_woocommerce_checkout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Individual Page Settings', 'cakecious' ),
	'description' => esc_html__( 'The Individual Page Settings settings of this page is available in the page editor.', 'cakecious' ) . '<br><br><a href="' . esc_url( get_edit_post_link( wc_get_page_id( 'checkout' ) ) ) . '" class="button button-secondary">' . esc_html__( 'Go to Page Editor', 'cakecious' ) . '</a>',
	'priority'    => 100,
) ) );

if ( cakecious_show_pro_teaser() ) {
	$wp_customize->add_control( new Cakecious_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_woocommerce_checkout', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available in Cakecious Pro', 'Cakecious Pro upsell', 'cakecious' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ),
		'features'    => array(
			esc_html_x( 'Distraction Free Mode', 'Cakecious Pro upsell', 'cakecious' ),
		),
		'priority'    => 190,
	) ) );
}