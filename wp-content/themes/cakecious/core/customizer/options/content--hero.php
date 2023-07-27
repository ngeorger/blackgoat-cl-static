<?php
/**
 * Customizer settings: Hero Section
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_hero';

/**
 * ====================================================
 * Enable / Disable
 * ====================================================
 */

// Enable
$key = 'hero';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable', 'cakecious' ) . ' <span class="cakecious-global-default-badge cakecious-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can enable or disable this option on each individual page.', 'cakecious' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'cakecious' ) . '</span>',
	'description' => esc_html__( 'If enabled, title, breadcrumb, and meta info are moved inside Hero Section.', 'cakecious' ),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_hero_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'cakecious' ),
	'priority'    => 20,
) ) );

// Container width
$key = 'hero_container';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Container width', 'cakecious' ),
	'choices'     => array(
		'default'    => array(
			'label' => esc_html__( 'Normal', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/hero-container--default.svg',
		),
		'full-width' => array(
			'label' => esc_html__( 'Full width', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/hero-container--full-width.svg',
		),
		'narrow'     => array(
			'label' => esc_html__( 'Narrow', 'cakecious' ),
			'image' => CAKECIOUS_IMAGES_URL . '/customizer/hero-container--narrow.svg',
		),
	),
	'priority'    => 20,
) ) );

// Minimal height
$key = 'hero_height';
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
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Minimal height', 'cakecious' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 1000,
			'step' => 1,
		),
		'vh' => array(
			'min'  => 0,
			'max'  => 100,
			'step' => 0.5,
		),
	),
	'priority'    => 20,
) ) );

// Padding
$key = 'hero_padding';
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
	'priority'    => 20,
) ) );

// Border
$key = 'hero_border';
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
	'priority'    => 20,
) ) );

// Alignment
$key = 'hero_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Alignment', 'cakecious' ),
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
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Typography
 * ====================================================
 */

// Heading: Typography
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_hero_typography', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Typography', 'cakecious' ),
	'priority'    => 40,
) ) );

// Text typography
$settings = array(
	'font_family'    => 'hero_font_family',
	'font_weight'    => 'hero_font_weight',
	'font_style'     => 'hero_font_style',
	'text_transform' => 'hero_text_transform',
	'font_size'      => 'hero_font_size',
	'line_height'    => 'hero_line_height',
	'letter_spacing' => 'hero_letter_spacing',

	'font_size__tablet'      => 'hero_font_size__tablet',
	'line_height__tablet'    => 'hero_line_height__tablet',
	'letter_spacing__tablet' => 'hero_letter_spacing__tablet',

	'font_size__mobile'      => 'hero_font_size__mobile',
	'line_height__mobile'    => 'hero_line_height__mobile',
	'letter_spacing__mobile' => 'hero_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'hero_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Text typography', 'cakecious' ),
	'priority'    => 40,
) ) );

// Title typography
$settings = array(
	'font_family'    => 'hero_title_font_family',
	'font_weight'    => 'hero_title_font_weight',
	'font_style'     => 'hero_title_font_style',
	'text_transform' => 'hero_title_text_transform',
	'font_size'      => 'hero_title_font_size',
	'line_height'    => 'hero_title_line_height',
	'letter_spacing' => 'hero_title_letter_spacing',

	'font_size__tablet'      => 'hero_title_font_size__tablet',
	'line_height__tablet'    => 'hero_title_line_height__tablet',
	'letter_spacing__tablet' => 'hero_title_letter_spacing__tablet',

	'font_size__mobile'      => 'hero_title_font_size__mobile',
	'line_height__mobile'    => 'hero_title_line_height__mobile',
	'letter_spacing__mobile' => 'hero_title_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'hero_title_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Title typography', 'cakecious' ),
	'priority'    => 40,
) ) );

// Breadcrumb typography
$settings = array(
	'font_family'    => 'hero_breadcrumb_font_family',
	'font_weight'    => 'hero_breadcrumb_font_weight',
	'font_style'     => 'hero_breadcrumb_font_style',
	'text_transform' => 'hero_breadcrumb_text_transform',
	'font_size'      => 'hero_breadcrumb_font_size',
	'line_height'    => 'hero_breadcrumb_line_height',
	'letter_spacing' => 'hero_breadcrumb_letter_spacing',

	'font_size__tablet'      => 'hero_breadcrumb_font_size__tablet',
	'line_height__tablet'    => 'hero_breadcrumb_line_height__tablet',
	'letter_spacing__tablet' => 'hero_breadcrumb_letter_spacing__tablet',

	'font_size__mobile'      => 'hero_breadcrumb_font_size__mobile',
	'line_height__mobile'    => 'hero_breadcrumb_line_height__mobile',
	'letter_spacing__mobile' => 'hero_breadcrumb_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'hero_breadcrumb_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Breadcrumb typography', 'cakecious' ),
	'priority'    => 40,
) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_hero_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'cakecious' ),
	'priority'    => 50,
) ) );

// Colors
$colors = array(
	'hero_bg_color'                         => esc_html__( 'Background color', 'cakecious' ),
	'hero_border_color'                     => esc_html__( 'Border color', 'cakecious' ),
	'hero_text_color'                       => esc_html__( 'Text color', 'cakecious' ),
	'hero_link_text_color'                  => esc_html__( 'Link text color', 'cakecious' ),
	'hero_link_hover_text_color'            => esc_html__( 'Link text color :hover', 'cakecious' ),
	'hero_title_text_color'                 => esc_html__( 'Title text color', 'cakecious' ),
	'hero_breadcrumb_text_color'            => esc_html__( 'Breadcrumb text color', 'cakecious' ),
	'hero_breadcrumb_link_text_color'       => esc_html__( 'Breadcrumb link text color', 'cakecious' ),
	'hero_breadcrumb_link_hover_text_color' => esc_html__( 'Breadcrumb link text color :hover', 'cakecious' ),
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

/**
 * ====================================================
 * Background
 * ====================================================
 */

// Heading: Background Image
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_hero_background', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Background Image', 'cakecious' ),
	'priority'    => 60,
) ) );

// Default background image
$key = 'hero_bg';
$settings = array(
	'image'      => $key . '_image',
	'attachment' => $key . '_attachment',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => cakecious_array_value( $defaults, $setting ),
		// 'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'background' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Background( $wp_customize, $key, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Default background image', 'cakecious' ) . ' <span class="cakecious-global-default-badge cakecious-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can set different background image on each individual page.', 'cakecious' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'cakecious' ) . '</span>',
	'priority'    => 60,
) ) );

// Colors
$key = 'hero_bg_overlay_color';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Background overlay color', 'cakecious' ),
	'priority'    => 60,
) ) );