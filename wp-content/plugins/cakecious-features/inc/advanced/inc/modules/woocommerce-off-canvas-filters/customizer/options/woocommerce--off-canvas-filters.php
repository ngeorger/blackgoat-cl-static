<?php
/**
 * Customizer settings: WooCommerce > Off Canvas Filters
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'woocommerce_off_canvas_filters';

/**
 * ====================================================
 * Off Canvas Filters
 * ====================================================
 */

// Enable off canvas filters
$key = 'woocommerce_off_canvas_filters';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable off canvas filters', 'cakecious-features' ),
	'priority'    => 10,
) ) );

// Show active filters
$key = 'woocommerce_off_canvas_filters_selected_list';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Show active filters', 'cakecious-features' ),
	'priority'    => 10,
) ) );

// Button text
$key = 'woocommerce_off_canvas_filters_button_text';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Button text', 'cakecious-features' ),
	'priority'    => 10,
) );

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_off_canvas_filters_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'cakecious-features' ),
	'priority'    => 20,
) ) );

// Position
$key = 'woocommerce_off_canvas_filters_position';
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
		'left'  => is_rtl() ? esc_html__( 'Right', 'cakecious-features' ) : esc_html__( 'Left', 'cakecious-features' ),
		'right' => is_rtl() ? esc_html__( 'Left', 'cakecious-features' ) : esc_html__( 'Right', 'cakecious-features' ),
	),
	'priority'    => 20,
) );

// Width
$key = 'woocommerce_off_canvas_filters_width';
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
			'min'   => 120,
			'max'   => 400,
			'step'  => 1,
		),
	),
	'priority'    => 20,
) ) );

// Padding
$key = 'woocommerce_off_canvas_filters_padding';
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
	'priority'    => 20,
) ) );

// Gap between widgets
$key = 'woocommerce_off_canvas_filters_widgets_gap';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gap between widgets', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'   => 0,
			'max'   => 80,
			'step'  => 1,
		),
	),
	'priority'    => 20,
) ) );
/**
 * ====================================================
 * Typography
 * ====================================================
 */

// Heading: Typography
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_off_canvas_filters_typography', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Typography', 'cakecious-features' ),
	'priority'    => 30,
) ) );

// Text typography
$settings = array(
	'font_family'    => 'woocommerce_off_canvas_filters_font_family',
	'font_weight'    => 'woocommerce_off_canvas_filters_font_weight',
	'font_style'     => 'woocommerce_off_canvas_filters_font_style',
	'text_transform' => 'woocommerce_off_canvas_filters_text_transform',
	'font_size'      => 'woocommerce_off_canvas_filters_font_size',
	'line_height'    => 'woocommerce_off_canvas_filters_line_height',
	'letter_spacing' => 'woocommerce_off_canvas_filters_letter_spacing',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'woocommerce_off_canvas_filters_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Text typography', 'cakecious-features' ),
	'priority'    => 30,
) ) );

// Widget title typography
$settings = array(
	'font_family'    => 'woocommerce_off_canvas_filters_widget_title_font_family',
	'font_weight'    => 'woocommerce_off_canvas_filters_widget_title_font_weight',
	'font_style'     => 'woocommerce_off_canvas_filters_widget_title_font_style',
	'text_transform' => 'woocommerce_off_canvas_filters_widget_title_text_transform',
	'font_size'      => 'woocommerce_off_canvas_filters_widget_title_font_size',
	'line_height'    => 'woocommerce_off_canvas_filters_widget_title_line_height',
	'letter_spacing' => 'woocommerce_off_canvas_filters_widget_title_letter_spacing',

	'font_size_tablet'      => 'woocommerce_off_canvas_filters_widget_title_font_size__tablet',
	'line_height_tablet'    => 'woocommerce_off_canvas_filters_widget_title_line_height__tablet',
	'letter_spacing_tablet' => 'woocommerce_off_canvas_filters_widget_title_letter_spacing__tablet',

	'font_size_mobile'      => 'woocommerce_off_canvas_filters_widget_title_font_size__mobile',
	'line_height_mobile'    => 'woocommerce_off_canvas_filters_widget_title_line_height__mobile',
	'letter_spacing_mobile' => 'woocommerce_off_canvas_filters_widget_title_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'woocommerce_off_canvas_filters_widget_title_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Widget title typography', 'cakecious-features' ),
	'priority'    => 30,
) ) );

// Widget title alignment
$key = 'woocommerce_off_canvas_filters_widget_title_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Widget title alignment', 'cakecious-features' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'cakecious-features' ) : esc_html__( 'Left', 'cakecious-features' ),
		'center' => esc_html__( 'Center', 'cakecious-features' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'cakecious-features' ) : esc_html__( 'Right', 'cakecious-features' ),
	),
	'priority'    => 30,
) );

// Widget title decoration
$key = 'woocommerce_off_canvas_filters_widget_title_decoration';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Widget title decoration', 'cakecious-features' ),
	'choices'     => array(
		'none'          => esc_html__( 'None', 'cakecious-features' ),
		'box'           => esc_html__( 'Box', 'cakecious-features' ),
		'border-bottom' => esc_html__( 'Border bottom', 'cakecious-features' ),
	),
	'priority'    => 30,
) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_woocommerce_off_canvas_filters_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'cakecious-features' ),
	'priority'    => 40,
) ) );

// Box shadow
$key = 'woocommerce_off_canvas_filters_shadow';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'shadow' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Shadow( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Box shadow', 'cakecious-features' ),
	'exclude'     => array( 'h_offset', 'v_offset' ),
	'priority'    => 40,
) ) );

// Colors
$colors = array(
	'woocommerce_off_canvas_filters_bg_color'                  => esc_html__( 'Background color', 'cakecious-features' ),
	'woocommerce_off_canvas_filters_text_color'                => esc_html__( 'Text color', 'cakecious-features' ),
	'woocommerce_off_canvas_filters_link_text_color'           => esc_html__( 'Link text color', 'cakecious-features' ),
	'woocommerce_off_canvas_filters_link_hover_text_color'     => esc_html__( 'Link text color :hover', 'cakecious-features' ),
	'woocommerce_off_canvas_filters_widget_title_text_color'   => esc_html__( 'Widget title text color', 'cakecious-features' ),
	'woocommerce_off_canvas_filters_widget_title_bg_color'     => esc_html__( 'Widget title background color', 'cakecious-features' ),
	'woocommerce_off_canvas_filters_widget_title_border_color' => esc_html__( 'Widget title border color', 'cakecious-features' ),
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
		'priority'    => 40,
	) ) );
}