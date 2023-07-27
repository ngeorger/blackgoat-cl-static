<?php
/**
 * Customizer settings: Header > Header Builder
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_builder';

/**
 * ====================================================
 * Builder
 * ====================================================
 */

ob_start(); ?>
<div class="cakecious-responsive-switcher nav-tab-wrapper wp-clearfix">
	<a href="#" class="nav-tab preview-desktop cakecious-responsive-switcher-button" data-device="desktop">
		<span class="dashicons dashicons-desktop"></span>
		<span><?php esc_html_e( 'Desktop', 'cakecious' ); ?></span>
	</a>
	<a href="#" class="nav-tab preview-tablet preview-mobile cakecious-responsive-switcher-button" data-device="tablet">
		<span class="dashicons dashicons-smartphone"></span>
		<span><?php esc_html_e( 'Tablet / Mobile', 'cakecious' ); ?></span>
	</a>
</div>
<span class="button button-secondary cakecious-builder-hide cakecious-builder-toggle"><span class="dashicons dashicons-no"></span><?php esc_html_e( 'Hide', 'cakecious' ); ?></span>
<span class="button button-primary cakecious-builder-show cakecious-builder-toggle"><span class="dashicons dashicons-edit"></span><?php esc_html_e( 'Header Builder', 'cakecious' ); ?></span>
<?php $switcher = ob_get_clean();

// --- Blank: Header Builder Switcher
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'header_builder_actions', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => $switcher,
	'priority'    => 10,
) ) );

// Desktop Header
$config = cakecious_get_header_builder_configurations();
$key = 'header_elements';
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
	'label'       => esc_html__( 'Desktop Header', 'cakecious' ),
	'choices'     => $config['choices'],
	'labels'      => $config['locations'],
	'priority'    => 10,
) ) );

// Mobile Header
$config = cakecious_get_mobile_header_builder_configurations();
$key = 'header_mobile_elements';
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
	'label'       => esc_html__( 'Mobile Header', 'cakecious' ),
	'choices'     => $config['choices'],
	'labels'      => $config['locations'],
	'limitations' => $config['limitations'],
	'priority'    => 10,
) ) );