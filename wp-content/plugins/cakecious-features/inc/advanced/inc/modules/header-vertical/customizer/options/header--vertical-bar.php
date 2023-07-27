<?php
/**
 * Customizer settings: Header > Vertical Bar
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_header_vertical_bar';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Display
$key = 'header_vertical_bar_display';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Display', 'cakecious-features' ),
	'choices'     => array(
		'fixed'       => esc_html__( 'Fixed (always visible)', 'cakecious-features' ),
		'drawer'      => esc_html__( 'Drawer (triggered via "Vertical Toggle")', 'cakecious-features' ),
		'off-canvas'  => esc_html__( 'Off canvas (triggered via "Vertical Toggle")', 'cakecious-features' ),
		'full-screen' => esc_html__( 'Full screen (triggered via "Vertical Toggle")', 'cakecious-features' ),
	),
	'priority'    => 10,
) );

// Position
$key = 'header_vertical_bar_position';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Position', 'cakecious-features' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'cakecious-features' ) : esc_html__( 'Left', 'cakecious-features' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'cakecious-features' ) : esc_html__( 'Right', 'cakecious-features' ),
		'center' => esc_html__( 'Center (only for Full Screen)', 'cakecious-features' ),
	),
	'priority'    => 10,
) );

// Alignment
$key = 'header_vertical_bar_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Alignment', 'cakecious-features' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'cakecious-features' ) : esc_html__( 'Left', 'cakecious-features' ),
		'center' => esc_html__( 'Center', 'cakecious-features' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'cakecious-features' ) : esc_html__( 'Right', 'cakecious-features' ),
	),
	'priority'    => 10,
) );

// Width
$key = 'header_vertical_bar_width';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Width', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 120,
			'max'  => 600,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Padding
$key = 'header_vertical_bar_padding';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimensions( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Padding', 'cakecious-features' ),
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
			'step' => 0.01,
		),
	),
	'priority'    => 10,
) ) );

// Border
$key = 'header_vertical_bar_border';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimensions( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Items gutter
$key = 'header_vertical_bar_items_gutter';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Spacing between elements', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'   => 0,
			'max'   => 40,
			'step'  => 1,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Typography
 * ====================================================
 */

// Heading: Typography
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_vertical_bar_typography', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Typography', 'cakecious-features' ),
	'priority'    => 20,
) ) );

// Text typography
$settings = array(
	'font_family'    => 'header_vertical_bar_font_family',
	'font_weight'    => 'header_vertical_bar_font_weight',
	'font_style'     => 'header_vertical_bar_font_style',
	'text_transform' => 'header_vertical_bar_text_transform',
	'font_size'      => 'header_vertical_bar_font_size',
	'line_height'    => 'header_vertical_bar_line_height',
	'letter_spacing' => 'header_vertical_bar_letter_spacing',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'header_vertical_bar_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Text typography', 'cakecious-features' ),
	'priority'    => 20,
) ) );

// Menu link typography
$settings = array(
	'font_family'    => 'header_vertical_bar_menu_font_family',
	'font_weight'    => 'header_vertical_bar_menu_font_weight',
	'font_style'     => 'header_vertical_bar_menu_font_style',
	'text_transform' => 'header_vertical_bar_menu_text_transform',
	'font_size'      => 'header_vertical_bar_menu_font_size',
	'line_height'    => 'header_vertical_bar_menu_line_height',
	'letter_spacing' => 'header_vertical_bar_menu_letter_spacing',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'header_vertical_bar_menu_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Menu link typography', 'cakecious-features' ),
	'priority'    => 20,
) ) );

// Submenu link typography
$settings = array(
	'font_family'    => 'header_vertical_bar_submenu_font_family',
	'font_weight'    => 'header_vertical_bar_submenu_font_weight',
	'font_style'     => 'header_vertical_bar_submenu_font_style',
	'text_transform' => 'header_vertical_bar_submenu_text_transform',
	'font_size'      => 'header_vertical_bar_submenu_font_size',
	'line_height'    => 'header_vertical_bar_submenu_line_height',
	'letter_spacing' => 'header_vertical_bar_submenu_letter_spacing',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'header_vertical_bar_submenu_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Submenu link typography', 'cakecious-features' ),
	'priority'    => 20,
) ) );

// Icon size
$key = 'header_vertical_bar_icon_size';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Icon size', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 60,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_header_vertical_bar_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'cakecious-features' ),
	'priority'    => 30,
) ) );

// Box shadow
$key = 'header_vertical_bar_shadow';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'shadow' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Shadow( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Box shadow', 'cakecious-features' ),
	'exclude'     => array( 'h_offset', 'v_offset' ),
	'priority'    => 30,
) ) );

// Colors
$colors = array(
	'header_vertical_bar_bg_color'              => esc_html__( 'Background color', 'cakecious-features' ),
	'header_vertical_bar_border_color'          => esc_html__( 'Border color', 'cakecious-features' ),
	'header_vertical_bar_text_color'            => esc_html__( 'Text color', 'cakecious-features' ),
	'header_vertical_bar_link_text_color'       => esc_html__( 'Link text color', 'cakecious-features' ),
	'header_vertical_bar_link_hover_text_color' => esc_html__( 'Link text color :hover', 'cakecious-features' ),
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
		'priority'    => 30,
	) ) );
}