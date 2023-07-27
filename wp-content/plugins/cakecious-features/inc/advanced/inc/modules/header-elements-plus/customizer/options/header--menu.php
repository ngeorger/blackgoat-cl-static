<?php
/**
 * Customizer settings: Header > Menu
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_menu';

for ( $i = 2; $i <= 3; $i++ ) {
	/**
	 * ====================================================
	 * HTML %d
	 * ====================================================
	 */

	// Heading: Menu
	$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_menu_' . $i, array(
		'section'     => $section,
		'settings'    => array(),
		/* translators: %s: Menu element number. */
		'label'       => sprintf( esc_html__( 'Menu %s', 'cakecious-features' ), 1 ),
		'description' => '<a href="' . esc_url( add_query_arg( 'autofocus[control]', 'nav_menu_locations[header-menu-' . $i . ']', remove_query_arg( 'autofocus' ) ) ) . '" class="cakecious-customize-goto-control button button-secondary">' .
			/* translators: %s: Menu element number. */
			sprintf( esc_html__( 'Setup Menu', 'cakecious-features' ), 1 ) . '</a>',
		'priority'    => 15,
	) ) );
}