<?php
/**
 * Customizer settings: Content & Sidebar > Content Section
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_content';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Container width
$key = 'content_container';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Container width', 'cakecious' ) . ' <span class="cakecious-global-default-badge cakecious-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can override this option on each individual page.', 'cakecious' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'cakecious' ) . '</span>',
	'choices'     => array(
		'narrow'     => array(
			'label' => esc_html__( 'Narrow', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-container--narrow.svg',
		),
		'default'    => array(
			'label' => esc_html__( 'Normal', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-container--default.svg',
		),
		'full-width' => array(
			'label' => esc_html__( 'Full width', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-container--full-width.svg',
		),
	),
	'columns'     => 4,
	'priority'    => 10,
) ) );

// Info
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'notice_narrow_content_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<div class="notice notice-info notice-alt inline"><p>' . esc_html__( 'Narrow content layout doesn\'t support Sidebar.', 'cakecious' ) . '</p></div>',
	'priority'    => 10,
) ) );

// Sidebar position
$key = 'content_layout';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Sidebar position', 'cakecious' ) . ' <span class="cakecious-global-default-badge cakecious-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can override this option on each individual page.', 'cakecious' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'cakecious' ) . '</span>',
	'choices'     => array(
		'wide'          => array(
			'label' => esc_html__( 'None', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-sidebar-layout--wide.svg',
		),
		'right-sidebar' => array(
			'label' => is_rtl() ? esc_html__( 'Left', 'cakecious' ) : esc_html__( 'Right', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-sidebar-layout--right-sidebar.svg',
		),
		'left-sidebar'  => array(
			'label' => is_rtl() ? esc_html__( 'Right', 'cakecious' ) : esc_html__( 'Left', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/content-sidebar-layout--left-sidebar.svg',
		),
	),
	'columns'     => 4,
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_content_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Padding
$key = 'content_padding';
$settings = array(
	$key,
	$key . '__tablet',
	$key . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => cakecious_array_value( $defaults, $setting ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimensions' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Dimensions( $wp_customize, $key, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Padding', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'step' => 0.05,
		),
		'%' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );