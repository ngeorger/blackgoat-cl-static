<?php
/**
 * Customizer settings: Blog > Post Layout: List
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_entry_list';

// Items gap
$key = 'blog_index_list_items_gap';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Items gap', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 120,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 8,
			'step' => 0.05,
		),
	),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Entry Wrapper
 * ====================================================
 */

// Heading: Entry Wrapper
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_entry_list_item', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Wrapper', 'cakecious-features' ),
	'priority'    => 20,
) ) );

// Padding
$key = 'entry_list_padding';
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
	),
	'priority'    => 20,
) ) );

// Border
$key = 'entry_list_border';
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
	'priority'    => 20,
) ) );

// Border radius
$key = 'entry_list_border_radius';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Border radius', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 40,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

// Colors
$colors = array(
	'entry_list_bg_color'     => esc_html__( 'Background color', 'cakecious-features' ),
	'entry_list_border_color' => esc_html__( 'Border color', 'cakecious-features' ),
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

// Shadow
$key = 'entry_list_shadow';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'shadow' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Shadow( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Shadow', 'cakecious-features' ),
	'exclude'     => array( 'position' ),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Entry Header
 * ====================================================
 */

// Heading: Entry Header
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_entry_list_header', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Header', 'cakecious-features' ),
	'priority'    => 30,
) ) );

// Elements
$key = 'entry_list_header';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'cakecious-features' ),
	'choices'     => array(
		'header-meta' => esc_html__( 'Header Meta', 'cakecious-features' ),
		'title'       => esc_html__( 'Title', 'cakecious-features' ),
	),
	'priority'    => 30,
) ) );

// Header meta text
$key = 'entry_list_header_meta';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Header meta text', 'cakecious-features' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}.', 'cakecious-features' ),
	'priority'    => 30,
) );

/**
 * ====================================================
 * Entry Thumbnail
 * ====================================================
 */

// Heading: Entry Thumbnail
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_entry_list_thumbnail', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Thumbnail', 'cakecious-features' ),
	'priority'    => 40,
) ) );

// Position
$key = 'entry_list_thumbnail';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Position', 'cakecious-features' ),
	'choices'     => array(
		'disabled' => array(
			'label' => esc_html__( 'Disabled', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/entry-list-featured-media--disabled.svg',
		),
		'left' => array(
			'label' => is_rtl() ? esc_html__( 'Right', 'cakecious-features' ) : esc_html__( 'Left', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/entry-list-featured-media--left.svg',
		),
		'right' => array(
			'label' => is_rtl() ? esc_html__( 'Left', 'cakecious-features' ) : esc_html__( 'Right', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/entry-list-featured-media--right.svg',
		),
		'left-alt' => array(
			'label' => is_rtl() ? esc_html__( 'Right Alt', 'cakecious-features' ) : esc_html__( 'Left Alt', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/entry-list-featured-media--left-alt.svg',
		),
		'right-alt' => array(
			'label' => is_rtl() ? esc_html__( 'Left Alt', 'cakecious-features' ) : esc_html__( 'Right Alt', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/entry-list-featured-media--right-alt.svg',
		),
	),
	'columns'     => 3,
	'priority'    => 40,
) ) );

// Image size
$key = 'entry_list_thumbnail_size';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Image size', 'cakecious-features' ),
	'choices'     => cakecious_get_all_image_sizes(),
	'priority'    => 40,
) );

// Ignore padding
$key = 'entry_list_thumbnail_ignore_padding';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Ignore padding', 'cakecious-features' ),
	'priority'    => 40,
) ) );

// Full height (cover mode)
$key = 'entry_list_thumbnail_full_height';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Full height (cover mode)', 'cakecious-features' ) . ' <span class="cakecious-tooltip cakecious-tooltip-bottom" tabindex="0" data-tooltip="' . esc_attr__( 'Doesn\'t work on IE browser', 'cakecious-features' ) . '"><span class="dashicons dashicons-info"></span></span>',
	'priority'    => 40,
) ) );

// Width
$key = 'entry_list_thumbnail_width';
$settings = array(
	$key,
	$key . '__tablet',
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
	'label'       => esc_html__( 'Width', 'cakecious-features' ),
	'units'       => array(
		'%' => array(
			'min'  => 20,
			'max'  => 50,
			'step' => 0.5,
		),
	),
	'priority'    => 40,
) ) );

// Gap with text column
$key = 'entry_list_thumbnail_gap';
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
	'label'       => esc_html__( 'Gap with text column', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 150,
			'step' => 1,
		),
		'em' => array(
			'min'  => 0,
			'max'  => 8,
			'step' => 0.5,
		),
	),
	'priority'    => 40,
) ) );

/**
 * ====================================================
 * Entry Content
 * ====================================================
 */

// Heading: Entry Content
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_entry_list_content', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Content', 'cakecious-features' ),
	'priority'    => 50,
) ) );

// Entry list excerpt length
$key = 'entry_list_excerpt_length';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Excerpt words limit', 'cakecious-features' ),
	'description' => esc_html__( 'Fill with 0 to disable excerpt.', 'cakecious-features' ),
	'units'       => array(
		'' => array(
			'min'  => 0,
			'max'  => 200,
			'step' => 1,
			'label' => 'wrd',
		),
	),
	'priority'    => 50,
) ) );

// Read more display
$key = 'entry_list_read_more_display';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Read more display', 'cakecious-features' ),
	'choices'     => array(
		''       => esc_html__( 'None', 'cakecious-features' ),
		'text'   => esc_html__( 'Text', 'cakecious-features' ),
		'button' => esc_html__( 'Button', 'cakecious-features' ),
	),
	'priority'    => 50,
) );

// Read more text
$key = 'entry_list_read_more_text';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Read more text', 'cakecious-features' ),
	'description' => esc_html__( 'Leave empty to disable read more link.', 'cakecious-features' ),
	'priority'    => 50,
) );

/**
 * ====================================================
 * Entry Footer
 * ====================================================
 */

// Heading: Entry Footer
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_entry_list_footer', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Entry Footer', 'cakecious-features' ),
	'priority'    => 60,
) ) );

// Elements
$key = 'entry_list_footer';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'multiselect' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Sortable( $wp_customize, $key, array(
	'section'     => $section,
	// 'label'       => esc_html__( 'Elements', 'cakecious-features' ),
	'choices'     => array(
		'footer-meta' => esc_html__( 'Footer Meta', 'cakecious-features' ),
	),
	'priority'    => 60,
) ) );

// Footer meta text
$key = 'entry_list_footer_meta';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Footer meta text', 'cakecious-features' ),
	'description' => esc_html__( 'Available tags: {{date}}, {{categories}}, {{tags}}, {{author}}, {{avatar}}, {{comments}}.', 'cakecious-features' ),
	'priority'    => 60,
) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_entry_list_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'cakecious-features' ),
	'priority'    => 80,
) ) );

// Colors
$colors = array(
	'entry_list_bg_color'     => esc_html__( 'Background color', 'cakecious-features' ),
	'entry_list_border_color' => esc_html__( 'Border color', 'cakecious-features' ),
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
		'priority'    => 80,
	) ) );
}

// Shadow
$key = 'entry_list_shadow';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'shadow' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Shadow( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Shadow', 'cakecious-features' ),
	'exclude'     => array( 'position' ),
	'priority'    => 80,
) ) );