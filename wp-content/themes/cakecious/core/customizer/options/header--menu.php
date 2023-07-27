<?php
/**
 * Customizer settings: Header > Menu
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_menu';

/**
 * ====================================================
 * Menu 1
 * ====================================================
 */

// Heading: Menu
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_menu_1', array(
	'section'     => $section,
	'settings'    => array(),
	/* translators: %s: Menu element number. */
	'label'       => sprintf( esc_html__( 'Menu %s', 'cakecious' ), 1 ),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[control]', 'nav_menu_locations[header-menu-1]', remove_query_arg( 'autofocus' ) ) ) . '" class="cakecious-customize-goto-control button button-secondary">' .
		/* translators: %s: Menu element number. */
		sprintf( esc_html__( 'Setup Menu', 'cakecious' ), 1 ) . '</a>',
	'priority'    => 10,
) ) );

// Heading: Mobile Menu
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_menu', array(
	'section'     => $section,
	'settings'    => array(),
	/* translators: %s: Menu element number. */
	'label'       => esc_html__( 'Mobile Menu', 'cakecious' ),
	'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[control]', 'nav_menu_locations[header-mobile-menu]', remove_query_arg( 'autofocus' ) ) ) . '" class="cakecious-customize-goto-control button button-secondary">' . esc_html__( 'Setup Menu', 'cakecious' ) . '</a>',
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Cakecious Pro Upsell
 * ====================================================
 */

$features = array();
for ( $i = 2; $i <=3; $i++ ) {
	/* translators: %s: Menu element number. */
	$features[] = sprintf( esc_html_x( 'Menu %s', 'Cakecious Pro upsell', 'cakecious' ), $i );
}

$features[] = esc_html__( 'Vertical Menu', 'cakecious' );

if ( cakecious_show_pro_teaser() ) {
	$wp_customize->add_control( new Cakecious_Customize_Control_Pro_Teaser( $wp_customize, 'pro_teaser_header_menu', array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => esc_html_x( 'More Options Available in Cakecious Pro', 'Cakecious Pro upsell', 'cakecious' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ),
		'features'    => $features,
		'priority'    => 90,
	) ) );
}