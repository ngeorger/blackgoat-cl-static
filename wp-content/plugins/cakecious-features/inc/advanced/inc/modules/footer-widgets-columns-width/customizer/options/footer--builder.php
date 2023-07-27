<?php
/**
 * Customizer settings: Footer > Builder
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_footer_builder';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

for ( $i = 1; $i <= 6; $i++ ) {
	// Column $i width.
	$key = 'footer_widgets_bar_column_' . $i . '_width';
	$settings = array(
		$key,
		$key . '__tablet',
		$key . '__mobile',
	);
	foreach ( $settings as $setting ) {
		$wp_customize->add_setting( $setting, array(
			'default'     => cakecious_array_value( $defaults, $setting ),
			'transport'   => 'postMessage',
			'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
		) );
	}
	$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
		'settings'    => $settings,
		'section'     => $section,
		/* translators: %d: column number. */
		'label'       => sprintf( esc_html__( '#%d width', 'cakecious-features' ), $i ),
		'units'       => array(
			'%' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 0.01,
			),
		),
		'priority'    => 15,
	) ) );
}