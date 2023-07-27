<?php
/**
 * Customizer settings: Footer > Builder
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_footer_builder';

/**
 * ====================================================
 * Builder
 * ====================================================
 */

ob_start(); ?>
<span class="button button-secondary cakecious-builder-hide cakecious-builder-toggle"><span class="dashicons dashicons-no"></span><?php esc_html_e( 'Hide', 'cakecious' ); ?></span>
<span class="button button-primary cakecious-builder-show cakecious-builder-toggle"><span class="dashicons dashicons-edit"></span><?php esc_html_e( 'Footer Builder', 'cakecious' ); ?></span>
<?php $switcher = ob_get_clean();

// --- Blank: Footer Builder Switcher
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'footer_builder_actions', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => $switcher,
	'priority'    => 10,
) ) );

// Widgets columns
$key = 'footer_widgets_bar';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Widgets columns', 'cakecious' ),
	'choices'     => array(
		0 => esc_html__( '-- Disabled --', 'cakecious' ),
		1 => esc_html__( '1 column', 'cakecious' ),
		2 => esc_html__( '2 columns', 'cakecious' ),
		3 => esc_html__( '3 columns', 'cakecious' ),
		4 => esc_html__( '4 columns', 'cakecious' ),
		5 => esc_html__( '5 columns', 'cakecious' ),
		6 => esc_html__( '6 columns', 'cakecious' ),
	),
	'priority'    => 10,
) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_footer_builder', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Bottom bar elements
$config = cakecious_get_footer_builder_configurations();
$key = 'footer_elements';
$settings = array();
foreach ( $config['locations'] as $slug => $label ) {
	$settings[ $slug ] = $key . '_' . $slug;
}
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => cakecious_array_value( $defaults, $setting ),
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'builder' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Builder( $wp_customize, $key, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Bottom bar elements', 'cakecious' ),
	'choices'     => $config['choices'],
	'labels'      => $config['locations'],
	'limitations' => array(),
	'priority'    => 20,
) ) );