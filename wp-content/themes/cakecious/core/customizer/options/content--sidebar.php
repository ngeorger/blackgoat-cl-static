<?php
/**
 * Customizer settings: Content & Sidebar > Sidebar Area
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_sidebar';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_sidebar_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'cakecious' ),
	'priority'    => 10,
) ) );

// Sidebar width
$key = 'sidebar_width';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Width', 'cakecious' ),
	'units'       => array(
		'%' => array(
			'min'  => 15,
			'max'  => 40,
			'step' => 1,
		),
		'px' => array(
			'min'  => 150,
			'max'  => 400,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

// Sidebar gap
$key = 'sidebar_gap';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gap with main content', 'cakecious' ),
	'units'       => array(
		'%' => array(
			'min'  => 0,
			'max'  => 10,
			'step' => 1,
		),
		'px' => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 1,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Widgets
 * ====================================================
 */

// Heading: Widgets
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_sidebar_widgets', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Widgets', 'cakecious' ),
	'priority'    => 30,
) ) );

// Widgets style
$key = 'sidebar_widgets_mode';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Widgets style', 'cakecious' ),
	'choices'     => array(
		'merged'    => esc_html__( 'Merged in one box', 'cakecious' ),
		'separated' => esc_html__( 'Separate boxes', 'cakecious' ),
	),
	'priority'    => 30,
) );

// Gap between widgets
$key = 'sidebar_widgets_gap';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Gap between widgets', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 80,
			'step' => 1,
		),
	),
	'priority'    => 30,
) ) );

// Padding
$key = 'sidebar_padding';
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
	'priority'    => 30,
) ) );

// Border
$key = 'sidebar_border';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimensions' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Dimensions( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'step' => 1,
		),
	),
	'priority'    => 30,
) ) );

// Border radius
$key = 'sidebar_border_radius';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border radius', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	),
	'priority'    => 30,
) ) );

/**
 * ====================================================
 * Typography
 * ====================================================
 */

// Heading: Typography
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_sidebar_typography', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Typography', 'cakecious' ),
	'priority'    => 40,
) ) );

// Text typography
$settings = array(
	'font_family'    => 'sidebar_font_family',
	'font_weight'    => 'sidebar_font_weight',
	'font_style'     => 'sidebar_font_style',
	'text_transform' => 'sidebar_text_transform',
	'font_size'      => 'sidebar_font_size',
	'line_height'    => 'sidebar_line_height',
	'letter_spacing' => 'sidebar_letter_spacing',

	'font_size__tablet'      => 'sidebar_font_size__tablet',
	'line_height__tablet'    => 'sidebar_line_height__tablet',
	'letter_spacing__tablet' => 'sidebar_letter_spacing__tablet',

	'font_size__mobile'      => 'sidebar_font_size__mobile',
	'line_height__mobile'    => 'sidebar_line_height__mobile',
	'letter_spacing__mobile' => 'sidebar_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'sidebar_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Text typography', 'cakecious' ),
	'priority'    => 40,
) ) );

// Widget title typography
$settings = array(
	'font_family'    => 'sidebar_widget_title_font_family',
	'font_weight'    => 'sidebar_widget_title_font_weight',
	'font_style'     => 'sidebar_widget_title_font_style',
	'text_transform' => 'sidebar_widget_title_text_transform',
	'font_size'      => 'sidebar_widget_title_font_size',
	'line_height'    => 'sidebar_widget_title_line_height',
	'letter_spacing' => 'sidebar_widget_title_letter_spacing',

	'font_size_tablet'      => 'sidebar_widget_title_font_size__tablet',
	'line_height_tablet'    => 'sidebar_widget_title_line_height__tablet',
	'letter_spacing_tablet' => 'sidebar_widget_title_letter_spacing__tablet',

	'font_size_mobile'      => 'sidebar_widget_title_font_size__mobile',
	'line_height_mobile'    => 'sidebar_widget_title_line_height__mobile',
	'letter_spacing_mobile' => 'sidebar_widget_title_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'sidebar_widget_title_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Widget title typography', 'cakecious' ),
	'priority'    => 40,
) ) );

// Widget title tag
$key = 'sidebar_widget_title_tag';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Widget title tag', 'cakecious' ),
	'choices'     => array(
		'h2'  => 'h2',
		'h3'  => 'h3',
		'h4'  => 'h4',
		'div' => 'div',
	),
	'priority'    => 40,
) );

// Widget title alignment
$key = 'sidebar_widget_title_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Widget title alignment', 'cakecious' ),
	'choices'     => array(
		'left'   => array(
			'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'right' : 'left' ) . '"></span>',
		),
		'center' => array(
			'label' => '<span class="dashicons dashicons-editor-aligncenter"></span>',
		),
		'right'  => array(
			'label' => '<span class="dashicons dashicons-editor-align' . ( is_rtl() ? 'left' : 'right' ) . '"></span>',
		),
	),
	'priority'    => 40,
) ) );

// Widget title decoration
$key = 'sidebar_widget_title_decoration';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Widget title decoration', 'cakecious' ),
	'choices'     => array(
		'none'          => esc_html__( 'None', 'cakecious' ),
		'box'           => esc_html__( 'Box', 'cakecious' ),
		'border-bottom' => esc_html__( 'Border bottom', 'cakecious' ),
	),
	'priority'    => 40,
) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_sidebar_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'cakecious' ),
	'priority'    => 50,
) ) );

// Shadow
$key = 'sidebar_shadow';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'shadow' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Shadow( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Shadow', 'cakecious' ),
	'exclude'     => array( 'position' ),
	'priority'    => 50,
) ) );

// Colors
$colors = array(
	'sidebar_bg_color'                  => esc_html__( 'Background color', 'cakecious' ),
	'sidebar_border_color'              => esc_html__( 'Border color', 'cakecious' ),
	'sidebar_text_color'                => esc_html__( 'Text color', 'cakecious' ),
	'sidebar_link_text_color'           => esc_html__( 'Link text color', 'cakecious' ),
	'sidebar_link_hover_text_color'     => esc_html__( 'Link text color :hover', 'cakecious' ),
	'sidebar_widget_title_text_color'   => esc_html__( 'Widget title text color', 'cakecious' ),
	'sidebar_widget_title_bg_color'     => esc_html__( 'Widget title background color', 'cakecious' ),
	'sidebar_widget_title_border_color' => esc_html__( 'Widget title border color', 'cakecious' ),
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
		'priority'    => 50,
	) ) );
}