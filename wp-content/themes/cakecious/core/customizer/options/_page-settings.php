<?php
/**
 * Customizer settings: Page Settings
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

foreach ( Cakecious_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
	$section = cakecious_array_value( $ps_data, 'section' );
	$option_prefix = $ps_type;

	// Extract the post type slug from $ps_type.
	$post_type_slug = preg_replace( '/(_single|_archive)/', '', $ps_type );
	$post_type_obj = get_post_type_object( $post_type_slug );

	// Heading: Page Settings
	$title = esc_html__( 'Page Settings', 'cakecious' );
	if ( false !== strpos( $ps_type, '_single' ) ) {
		$title .= ' <span class="cakecious-global-default-badge cakecious-tooltip" tabindex="0" data-tooltip="' . sprintf( esc_attr__( 'You can override these options on each individual %s.', 'cakecious' ), $post_type_obj->labels->singular_name ) . '"><span class="dashicons dashicons-admin-site-alt3"></span></span>';
	}
	$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_page_settings_' . $ps_type, array(
		'section'     => $section,
		'settings'    => array(),
		'label'       => $title,
		'description' => cakecious_array_value( $ps_data, 'description' ),
		'priority'    => 100,
	) ) );

	/**
	 * ====================================================
	 * Content
	 * ====================================================
	 */

	if ( 'error_404' !== $ps_type ) {
		// Content container
		$subkey = 'content_container';
		$key = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting( $key, array(
			'default'     => cakecious_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Content container', 'cakecious' ),
			'choices'     => array(
				''           => array(
					'label' => esc_html__( '-- Global --', 'cakecious' ),
					'image' => CAKECIOUS_IMAGES_URL . '/customizer/default.svg',
				),
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
			'priority'    => 110,
		) ) );

		// Sidebar
		$subkey = 'content_layout';
		$key = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting( $key, array(
			'default'     => cakecious_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
			'section'     => $section,
			'label'       => esc_html__( 'Sidebar', 'cakecious' ) . ' <span class="cakecious-tooltip cakecious-tooltip-right" tabindex="0" data-tooltip="' . esc_attr__( 'Not available on "Narrow" content layout', 'cakecious' ) . '"><span class="dashicons dashicons-info"></span></span>',
			'choices'     => array(
				''              => array(
					'label' => esc_html__( '-- Global --', 'cakecious' ),
					'image' => CAKECIOUS_IMAGES_URL . '/customizer/default.svg',
				),
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
			'priority'    => 110,
		) ) );
	}

	/**
	 * ====================================================
	 * Content Header
	 * ====================================================
	 */

	if ( 'error_404' !== $ps_type ) {
		// Title text format on archive pages
		if ( false !== strpos( $ps_type, '_archive' ) ) {
			// ------
			$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_content_header_title', array(
				'section'     => $section,
				'settings'    => array(),
				'priority'    => 120,
			) ) );

			// Title text format on post type archive pages
			$subkey = 'title_text';
			$key = $option_prefix . '_' . $subkey;
			$wp_customize->add_setting( $key, array(
				'default'     => cakecious_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
			) );
			$wp_customize->add_control( $key, array(
				'section'     => $section,
				'label'       => esc_html__( 'Main archive page\'s title', 'cakecious' ),
				'description' => esc_html__( 'Available tags: {{post_type}}.', 'cakecious' ),
				'input_attrs' => array(
					'placeholder' => '{{post_type}}',
				),
				'priority'    => 120,
			) );

			// Title text format on taxonomy archive pages
			$subkey = 'tax_title_text';
			$key = $option_prefix . '_' . $subkey;
			$wp_customize->add_setting( $key, array(
				'default'     => cakecious_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
			) );
			$wp_customize->add_control( $key, array(
				'section'     => $section,
				'label'       => esc_html__( 'Taxonomy archive page\'s title', 'cakecious' ),
				'description' => esc_html__( 'Available tags: {{taxonomy}}, {{term}}.', 'cakecious' ),
				'input_attrs' => array(
					'placeholder' => '{{taxonomy}}: {{term}}',
				),
				'priority'    => 120,
			) );
		}

		// ------
		$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_hero', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 120,
		) ) );

		// Hero 
		$subkey = 'hero';
		$key = $option_prefix . '_' . $subkey;
		$wp_customize->add_setting( $key, array(
			'default'     => cakecious_array_value( $defaults, $key ),
			'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
		) );
		$wp_customize->add_control( $key, array(
			'type'        => 'select',
			'section'     => $section,
			'label'       => esc_html__( 'Hero section', 'cakecious' ),
			'choices'     => array(
				''  => esc_html__( '-- Global --', 'cakecious' ),
				'1' => esc_html__( '&#x2714; Enabled', 'cakecious' ),
				'0' => esc_html__( '&#x2718; Disabled', 'cakecious' ),
			),
			'priority'    => 120,
		) );

			// Container width
			$subkey = 'hero_container';
			$key = $option_prefix . '_' . $subkey;
			$wp_customize->add_setting( $key, array(
				'default'     => cakecious_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
			) );
			$wp_customize->add_control( $key, array(
				'type'        => 'select',
				'section'     => $section,
				'label'       => esc_html__( 'Container width', 'cakecious' ),
				'choices'     => array(
					''           => esc_html__( '-- Global --', 'cakecious' ),
					'default'    => esc_html__( 'Normal', 'cakecious' ),
					'full-width' => esc_html__( 'Full width', 'cakecious' ),
					'narrow'     => esc_html__( 'Narrow', 'cakecious' ),
				),
				'priority'    => 120,
			) );

			// Alignment
			$subkey = 'hero_alignment';
			$key = $option_prefix . '_' . $subkey;
			$wp_customize->add_setting( $key, array(
				'default'     => cakecious_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
			) );
			$wp_customize->add_control( $key, array(
				'type'        => 'select',
				'section'     => $section,
				'label'       => esc_html__( 'Alignment', 'cakecious' ),
				'choices'     => array(
					''       => esc_html__( '-- Global --', 'cakecious' ),
					'left'   => is_rtl() ? esc_html__( 'Right', 'cakecious' ) : esc_html__( 'Left', 'cakecious' ),
					'center' => esc_html__( 'Center', 'cakecious' ),
					'right'  => is_rtl() ? esc_html__( 'Left', 'cakecious' ) : esc_html__( 'Right', 'cakecious' ),
				),
				'priority'    => 120,
			) );

			// Background image
			$subkey = 'hero_bg';
			$key = $option_prefix . '_' . $subkey;
			$choices = array(
				''          => esc_html__( '-- Global --', 'cakecious' ),
				'thumbnail' => esc_html__( 'Featured Image', 'cakecious' ),
				'custom'    => esc_html__( 'Custom Image', 'cakecious' ),
			);
			if ( false === strpos( $ps_type, '_single' ) || post_type_supports( $post_type_slug, 'post-thumbnails' ) ) {
				unset( $choices['thumbnail'] );
			}
			$wp_customize->add_setting( $key, array(
				'default'     => cakecious_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
			) );
			$wp_customize->add_control( $key, array(
				'type'        => 'select',
				'section'     => $section,
				'label'       => esc_html__( 'Background image', 'cakecious' ),
				'choices'     => $choices,
				'priority'    => 120,
			) );

			// Custom background image
			$subkey = 'hero_bg_image';
			$key = $option_prefix . '_' . $subkey;
			$wp_customize->add_setting( $key, array(
				'default'     => cakecious_array_value( $defaults, $key ),
				'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'image' ),
			) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $key, array(
				'section'     => $section,
				// 'label'       => esc_html__( 'Custom background image', 'cakecious' ),
				'priority'    => 120,
			) ) );
	}

	/**
	 * ====================================================
	 * Header
	 * ====================================================
	 */

	if ( 'error_404' !== $ps_type ) {
		// ------
		$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_header', array(
			'section'     => $section,
			'settings'    => array(),
			'priority'    => 130,
		) ) );
	}

	// Desktop header
	$subkey = 'disable_header';
	$key = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Desktop header', 'cakecious' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'cakecious' ),
			'1' => esc_html__( '&#x2718; Disabled', 'cakecious' ),
		),
		'priority'    => 130,
	) );

	// Mobile header
	$subkey = 'disable_mobile_header';
	$key = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Mobile header', 'cakecious' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'cakecious' ),
			'1' => esc_html__( '&#x2718; Disabled', 'cakecious' ),
		),
		'priority'    => 135,
	) );

	/**
	 * ====================================================
	 * Footer
	 * ====================================================
	 */

	// ------
	$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_page_settings_' . $ps_type . '_footer', array(
		'section'     => $section,
		'settings'    => array(),
		'priority'    => 150,
	) ) );

	// Footer widgets
	$subkey = 'disable_footer_widgets';
	$key = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Footer widgets', 'cakecious' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'cakecious' ),
			'1' => esc_html__( '&#x2718; Disabled', 'cakecious' ),
		),
		'priority'    => 150,
	) );

	// Footer bottom
	$subkey = 'disable_footer_bottom';
	$key = $option_prefix . '_' . $subkey;
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'select',
		'section'     => $section,
		'label'       => esc_html__( 'Footer bottom', 'cakecious' ),
		'choices'     => array(
			''  => esc_html__( '&#x2714; Enabled', 'cakecious' ),
			'1' => esc_html__( '&#x2718; Disabled', 'cakecious' ),
		),
		'priority'    => 150,
	) );
}