<?php
/**
 * Customizer settings: Preloader Screen
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_preloader_screen';

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Enable Preloader Screen
$key = 'preloader_screen';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable Preloader Screen', 'cakecious-features' ) . ' <span class="cakecious-global-default-badge cakecious-tooltip" tabindex="0" data-tooltip="' . esc_attr__( 'You can enable or disable this option on each individual page.', 'cakecious-features' ) . '"><span class="dashicons dashicons-admin-site-alt3"></span> ' . esc_html__( 'Global', 'cakecious-features' ) . '</span>',
	'priority'    => 10,
) ) );

// Padding
$key = 'preloader_screen_padding';
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
		'%' => array(
			'min'  => 0,
			'step' => 0.01,
		),
	),
	'priority'    => 10,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_preloader_screen_loader', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 20,
) ) );

// Loader type
$key = 'preloader_screen_type';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Loader type', 'cakecious-features' ),
	'choices'     => array(
		'css-spinner'    => array(
			'label' => esc_html__( 'CSS Spinner', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/preloader-screen--css-spinner.svg',
		),
		'progress-bar'   => array(
			'label' => esc_html__( 'Bar', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/preloader-screen--progress-bar.svg',
		),
		'progress-image' => array(
			'label' => esc_html__( 'Image', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/preloader-screen--progress-image.svg',
		),
	),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Spinner (via CSS)
 * ====================================================
 */

// Spinner
$choices = array();
foreach ( Cakecious_Helper_CSS_Spinner::get_data() as $key => $spinner ) {
	$choices[ $key ] = array(
		'label' => cakecious_array_value( $spinner, 'label' ),
		'image' => cakecious_array_value( $spinner, 'image' )
	);
}

$key = 'preloader_screen_css_spinner';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Spinner', 'cakecious-features' ),
	'choices'     => $choices,
	'priority'    => 20,
) ) );

// Width
$key = 'preloader_screen_css_spinner_width';
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
	'label'       => esc_html__( 'Width', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 16,
			'max'  => 160,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Progress Bar
 * ====================================================
 */

// Width
$key = 'preloader_screen_progress_bar_width';
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
	'label'       => esc_html__( 'Width', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 100,
			'max'  => 1600,
			'step' => 1,
		),
		'%' => array(
			'min'  => 5,
			'max'  => 100,
			'step' => 0.1,
		),
	),
	'priority'    => 20,
) ) );

// Height
$key = 'preloader_screen_progress_bar_height';
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
	'label'       => esc_html__( 'Height', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 2,
			'max'  => 50,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

// Border radius
$key = 'preloader_screen_progress_bar_border_radius';
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
	'label'       => esc_html__( 'Border radius', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 0,
			'max'  => 25,
			'step' => 1,
		),
	),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Progress Image
 * ====================================================
 */

// Image
$key = 'preloader_screen_progress_image';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Image', 'cakecious-features' ),
	'description' => esc_html__( 'TIPS: Use an optimized image (less than 50KB).', 'cakecious-features' ),
	'mime_type'   => 'image',
	'priority'    => 20,
) ) );

// Width
$key = 'preloader_screen_progress_image_width';
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
	'label'       => esc_html__( 'Width', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'  => 100,
			'max'  => 1600,
			'step' => 1,
		),
		'%' => array(
			'min'  => 5,
			'max'  => 100,
			'step' => 0.1,
		),
	),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_preloader_screen_loader_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 30,
) ) );

// Background color
$key = 'preloader_screen_bg_color';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Background color', 'cakecious-features' ),
	'priority'    => 30,
	'alpha'       => false,
) ) );

// Loader color
$key = 'preloader_screen_main_color';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Loader color', 'cakecious-features' ),
	'priority'    => 30,
	'alpha'       => false,
) ) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'preloader_screen_preview', array(
		'settings'            => array(
			'preloader_screen_type',
			'preloader_screen_css_spinner',
			'preloader_screen_progress_image',
		),
		'selector'            => '.cakecious-preloader',
		'container_inclusive' => true,
		'render_callback'     => array( Cakecious_Pro_Module_Preloader_Screen::instance(), 'render_preloader' ),
		'fallback_refresh'    => false,
	) );
}