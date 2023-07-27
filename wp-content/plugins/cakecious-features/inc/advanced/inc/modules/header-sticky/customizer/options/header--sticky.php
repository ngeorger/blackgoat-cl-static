<?php
/**
 * Customizer settings: Header > Sticky Header
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_sticky';

/**
 * ====================================================
 * Desktop
 * ====================================================
 */

// // Heading: Desktop Header
// $wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_sticky', array(
// 	'section'     => $section,
// 	'settings'    => array(),
// 	'label'       => esc_html__( 'Desktop Header', 'cakecious-features' ),
// 	'priority'    => 10,
// ) ) );

// Enable sticky mode
$key = 'header_sticky';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable sticky mode', 'cakecious-features' ) . ' <span class="cakecious-global-default-badge cakecious-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can enable or disable this option on each individual page.', 'cakecious-features' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'cakecious-features' ) . '</span>',
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_sticky', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Sticky bar
$key = 'header_sticky_bar';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Sticky bar', 'cakecious-features' ),
	'choices'     => array(
		'top'      => esc_html__( 'Top bar', 'cakecious-features' ),
		'main'     => esc_html__( 'Main bar', 'cakecious-features' ),
		'bottom'   => esc_html__( 'Bottom bar', 'cakecious-features' ),
	),
	'priority'    => 10,
) );

// Sticky display
$key = 'header_sticky_display';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Display', 'cakecious-features' ),
	'choices'     => array(
		'fixed'        => esc_html__( 'Always stick', 'cakecious-features' ),
		'on-scroll-up' => esc_html__( 'Hide on scroll down, show on scroll up', 'cakecious-features' ),
	),
	'priority'    => 10,
) );

// Sticky height
$key = 'header_sticky_height';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Height', 'cakecious-features' ),
	'description' => esc_html__( 'Should be less than or equal to normal height of the selected bar.', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'   => 20,
			'max'   => 120,
			'step'  => 1,
		),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_sticky_logo', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Sticky Logo
$key = 'custom_logo_sticky';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Sticky logo image', 'cakecious-features' ),
	'mime_type'   => 'image',
	'priority'    => 10,
) ) );

// Max width
$key = 'header_sticky_logo_width';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Max width', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_sticky_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 10,
) ) );

// Colors
$colors = array(
	'header_sticky_bar_bg_color'                         => esc_html__( 'Background color', 'cakecious-features' ),
	'header_sticky_bar_border_color'                     => esc_html__( 'Border color', 'cakecious-features' ),
	'header_sticky_bar_text_color'                       => esc_html__( 'Text color', 'cakecious-features' ),
	'header_sticky_bar_link_text_color'                  => esc_html__( 'Link text color', 'cakecious-features' ),
	'header_sticky_bar_link_hover_text_color'            => esc_html__( 'Link text color :hover', 'cakecious-features' ),
	'header_sticky_bar_menu_hover_highlight_color'       => esc_html__( 'Highlight color :hover', 'cakecious-features' ),
	'header_sticky_bar_menu_hover_highlight_text_color'  => esc_html__( 'Highlight text color :hover', 'cakecious-features' ),
	'header_sticky_bar_menu_active_highlight_color'      => esc_html__( 'Highlight color :active', 'cakecious-features' ),
	'header_sticky_bar_menu_active_highlight_text_color' => esc_html__( 'Highlight text color :active', 'cakecious-features' ),
);
foreach ( $colors as $key => $label ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 10,
	) ) );
}

// Sticky bar shadow
$key = 'header_sticky_bar_shadow';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'shadow' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Shadow( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Sticky bar shadow', 'cakecious-features' ),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Mobile
 * ====================================================
 */

// // Heading: Mobile Header
// $wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_mobile_sticky', array(
// 	'section'     => $section,
// 	'settings'    => array(),
// 	'label'       => esc_html__( 'Mobile Header', 'cakecious-features' ),
// 	'priority'    => 20,
// ) ) );

// Enable sticky mode
$key = 'header_mobile_sticky';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable sticky mode', 'cakecious-features' ) . ' <span class="cakecious-global-default-badge cakecious-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can enable or disable this option on each individual page.', 'cakecious-features' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'cakecious-features' ) . '</span>',
	'priority'    => 20,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_mobile_sticky', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Sticky mobile display
$key = 'header_mobile_sticky_display';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Display', 'cakecious-features' ),
	'choices'     => array(
		'fixed'        => esc_html__( 'Always stick', 'cakecious-features' ),
		'on-scroll-up' => esc_html__( 'Hide on scroll down, show on scroll up', 'cakecious-features' ),
	),
	'priority'    => 20,
) );

// Sticky height
$key = 'header_mobile_sticky_height';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Height', 'cakecious-features' ),
	'description' => esc_html__( 'Should be less than or equal to normal height of the selected bar.', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'   => 20,
			'max'   => 120,
			'step'  => 1,
		),
	),
	'priority'    => 20,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_mobile_sticky_logo', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Sticky Logo
$key = 'custom_logo_mobile_sticky';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Sticky logo image', 'cakecious-features' ),
	'mime_type'   => 'image',
	'priority'    => 20,
) ) );

// Max width
$key = 'header_mobile_sticky_logo_width';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Max width', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_header_mobile_sticky_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Colors
$colors = array(
	'header_mobile_sticky_bar_bg_color'              => esc_html__( 'Background color', 'cakecious-features' ),
	'header_mobile_sticky_bar_border_color'          => esc_html__( 'Border color', 'cakecious-features' ),
	'header_mobile_sticky_bar_link_text_color'       => esc_html__( 'Link text color', 'cakecious-features' ),
	'header_mobile_sticky_bar_link_hover_text_color' => esc_html__( 'Link text color :hover', 'cakecious-features' ),
);
foreach ( $colors as $key => $label ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => $label,
		'priority'    => 20,
	) ) );
}

// Sticky bar shadow
$key = 'header_mobile_sticky_bar_shadow';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'shadow' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Shadow( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Sticky bar shadow', 'cakecious-features' ),
	'priority'    => 20,
) ) );