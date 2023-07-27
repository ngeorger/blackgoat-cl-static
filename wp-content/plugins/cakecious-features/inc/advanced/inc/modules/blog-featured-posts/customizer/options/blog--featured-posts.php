<?php
/**
 * Customizer settings: Blog > Featured Posts
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_blog_featured_posts';

/**
 * ====================================================
 * Enable / Disable
 * ====================================================
 */

// Featured Posts
$key = 'blog_featured_posts';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable Featured Posts', 'cakecious-features' ),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Query
 * ====================================================
 */

// Heading: Query
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_blog_featured_posts_query', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Query', 'cakecious-features' ),
	'description' => esc_html__( 'Featured Posts are handpicked manually. Please go to your Posts page and then mark the posts as "Featured".', 'cakecious-features' ) . '<br><br>' . '<a href="' . esc_url( admin_url( 'edit.php' ) ) . '" class="button button-secondary" target="_blank">' . esc_html__( 'Go to Posts List', 'cakecious-features' ) . '</a>',
	'priority'    => 20,
) ) );

// Exclude featured posts in the main posts loop.
$key = 'blog_featured_posts_exclude_on_main_query';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Exclude featured posts from main feed', 'cakecious-features' ),
	'description' => esc_html__( 'Posts that have been displayed in Featured Posts will not appear again in the main blog posts feed.', 'cakecious-features' ),
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_blog_featured_posts_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'cakecious-features' ),
	'priority'    => 30,
) ) );

// Position
$key = 'blog_featured_posts_position';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Position', 'cakecious-features' ),
	'choices'     => array(
		'before-primary-and-sidebar' => esc_html__( 'Above main content and sidebar area', 'cakecious-features' ),
		'before-content'             => esc_html__( 'Full width section, above content section', 'cakecious-features' ),
	),
	'priority'    => 30,
) );

// Bottom margin
$key = 'blog_featured_posts_bottom_margin';
$settings = array(
	$key,
	$key . '__tablet',
	$key . '__mobile',
);
foreach ( $settings as $setting ) {
	$wp_customize->add_setting( $setting, array(
		'default'     => cakecious_array_value( $defaults, $setting ),
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Bottom margin', 'cakecious-features' ),
	'units'       => array(
		'px' => array(
			'min'   => 0,
			'step'  => 1,
		),
	),
	'priority'    => 30,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_blog_featured_posts_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 30,
) ) );

// Layout
$key = 'blog_featured_posts_layout';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_RadioImage( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Layout', 'cakecious-features' ),
	'choices'     => array(
		'slider'   => array(
			'label' => esc_html__( 'Slider', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/blog-featured-posts-layout--slider.svg',
		),
		'carousel' => array(
			'label' => esc_html__( 'Carousel', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/blog-featured-posts-layout--carousel.svg',
		),
		'grid-3'   => array(
			'label' => esc_html__( 'Grid 3', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/blog-featured-posts-layout--grid-3.svg',
		),
		'grid-4'   => array(
			'label' => esc_html__( 'Grid 4', 'cakecious-features' ),
			'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/blog-featured-posts-layout--grid-4.svg',
		),
	),
	'priority'    => 30,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_blog_featured_posts_layout_2', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 30,
) ) );

	/**
	 * ====================================================
	 * Layout: Slider & Carousel
	 * ====================================================
	 */

	// Autoplay
	$key = 'blog_featured_posts_autoplay';
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
	) );
	$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => esc_html__( 'Autoplay', 'cakecious-features' ),
		'priority'    => 30,
	) ) );

	// Autoplay delay
	$key = 'blog_featured_posts_autoplay_delay';
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
	) );
	$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
		'section'     => $section,
		'units'       => array(
			'' => array(
				'min'   => 3,
				'max'   => 8,
				'step'  => 0.5,
				'label' => 'sec',
			),
		),
		'priority'    => 30,
	) ) );

	// Maximum featured posts to display
	$key = 'blog_featured_posts_per_page';
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'number' ),
	) );
	$wp_customize->add_control( $key, array(
		'type'        => 'number',
		'section'     => $section,
		'label'       => esc_html__( 'Maximum featured posts to display', 'cakecious-features' ),
		'input_attrs' => array(
			'min'   => 1,
			'max'   => 20,
			'step'  => 1,
		),
		'priority'    => 30,
	) );

	/**
	 * ====================================================
	 * Layout: Slider
	 * ====================================================
	 */

	// Slider height
	$key = 'blog_featured_posts_slider_height';
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
	$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
		'settings'    => $settings,
		'section'     => $section,
		'label'       => esc_html__( 'Slider height', 'cakecious-features' ),
		'units'       => array(
			'px' => array(
				'min'   => 200,
				'step'  => 1,
			),
			'%' => array(
				'min'   => '30',
				'step'  => 0.5,
			),
		),
		'priority'    => 30,
	) ) );

	/**
	 * ====================================================
	 * Layout: Carousel
	 * ====================================================
	 */

	// Carousel height
	$key = 'blog_featured_posts_carousel_height';
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
	$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
		'settings'    => $settings,
		'section'     => $section,
		'label'       => esc_html__( 'Carousel height', 'cakecious-features' ),
		'units'       => array(
			'px' => array(
				'min'   => 200,
				'step'  => 1,
			),
			'%' => array(
				'min'   => '30',
				'step'  => 0.5,
			),
		),
		'priority'    => 30,
	) ) );

	// Carousel columns
	$key = 'blog_featured_posts_carousel_columns';
	$settings = array(
		$key,
		$key . '__tablet',
		$key . '__mobile',
	);
	foreach ( $settings as $setting ) {
		$wp_customize->add_setting( $setting, array(
			'default'     => cakecious_array_value( $defaults, $setting ),
			'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
		) );
	}
	$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
		'settings'    => $settings,
		'section'     => $section,
		'label'       => esc_html__( 'Carousel columns', 'cakecious-features' ),
		'units'       => array(
			'' => array(
				'min'   => 1,
				'max'   => 6,
				'step'  => 1,
				'label' => 'col',
			),
		),
		'priority'    => 30,
	) ) );

	/**
	 * ====================================================
	 * Layout: Grid
	 * ====================================================
	 */

	// Grid total height
	$key = 'blog_featured_posts_grid_height';
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
	$wp_customize->add_control( new Cakecious_Customize_Control_Dimension( $wp_customize, $key, array(
		'settings'    => $settings,
		'section'     => $section,
		'label'       => esc_html__( 'Grid total height', 'cakecious-features' ),
		'units'       => array(
			'px' => array(
				'min'   => 200,
				'step'  => 1,
			),
			'%' => array(
				'min'   => '30',
				'step'  => 0.5,
			),
		),
		'priority'    => 30,
	) ) );

	/**
	 * ====================================================
	 * Layout: Carousel & Grid
	 * ====================================================
	 */

	// Items gutter
	$key = 'blog_featured_posts_items_gutter';
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
		'label'       => esc_html__( 'Items gutter', 'cakecious-features' ),
		'units'       => array(
			'px' => array(
				'min'   => 0,
				'max'   => 40,
				'step'  => 1,
			),
		),
		'priority'    => 30,
	) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_blog_featured_posts_layout_3', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 30,
) ) );

// Enable link on background image
$key = 'blog_featured_posts_image_link';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable link on background image', 'cakecious-features' ),
	'priority'    => 30,
) ) );

// Meta 1 (above title)
$key = 'blog_featured_posts_meta_1';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Meta 1 (above title)', 'cakecious-features' ),
	'choices'     => array(
		''           => esc_html__( 'None', 'cakecious-features' ),
		'categories' => esc_html__( 'Categories', 'cakecious-features' ),
		'date'       => esc_html__( 'Date', 'cakecious-features' ),
	),
	'priority'    => 30,
) );

// Meta 2 (below title)
$key = 'blog_featured_posts_meta_2';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Meta 2 (below title)', 'cakecious-features' ),
	'choices'     => array(
		''           => esc_html__( 'None', 'cakecious-features' ),
		'categories' => esc_html__( 'Categories', 'cakecious-features' ),
		'date'       => esc_html__( 'Date', 'cakecious-features' ),
	),
	'priority'    => 30,
) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'blog_featured_posts', array(
		'settings'            => array(
			'blog_featured_posts_layout',
			'blog_featured_posts_per_page',
			'blog_featured_posts_carousel_columns',
			'blog_featured_posts_image_link',
			'blog_featured_posts_meta_1',
			'blog_featured_posts_meta_2',
		),
		'selector'            => '.cakecious-featured-posts',
		'container_inclusive' => true,
		'render_callback'     => array( Cakecious_Pro_Module_Blog_Featured_Posts::instance(), 'render_featured_posts' ),
		'fallback_refresh'    => false,
	) );
}

/**
 * ====================================================
 * Typography
 * ====================================================
 */

// Heading: Typography
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_blog_featured_posts_typography', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Typography', 'cakecious-features' ),
	'priority'    => 40,
) ) );

// Text alignment
$key = 'blog_featured_posts_content_alignment';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Text alignment', 'cakecious-features' ),
	'choices'     => array(
		'left'   => is_rtl() ? esc_html__( 'Right', 'cakecious-features' ) : esc_html__( 'Left', 'cakecious-features' ),
		'center' => esc_html__( 'Center', 'cakecious-features' ),
		'right'  => is_rtl() ? esc_html__( 'Left', 'cakecious-features' ) : esc_html__( 'Right', 'cakecious-features' ),
	),
	'priority'    => 40,
) );

// Title typography
$settings = array(
	'font_family'    => 'blog_featured_posts_title_font_family',
	'font_weight'    => 'blog_featured_posts_title_font_weight',
	'font_style'     => 'blog_featured_posts_title_font_style',
	'text_transform' => 'blog_featured_posts_title_text_transform',
	'font_size'      => 'blog_featured_posts_title_font_size',
	'line_height'    => 'blog_featured_posts_title_line_height',
	'letter_spacing' => 'blog_featured_posts_title_letter_spacing',

	'font_size__tablet'      => 'blog_featured_posts_title_font_size__tablet',
	'line_height__tablet'    => 'blog_featured_posts_title_line_height__tablet',
	'letter_spacing__tablet' => 'blog_featured_posts_title_letter_spacing__tablet',

	'font_size__mobile'      => 'blog_featured_posts_title_font_size__mobile',
	'line_height__mobile'    => 'blog_featured_posts_title_line_height__mobile',
	'letter_spacing__mobile' => 'blog_featured_posts_title_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'blog_featured_posts_title_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Title typography', 'cakecious-features' ),
	'responsive'  => true,
	'priority'    => 40,
) ) );

// Small title typography
$settings = array(
	'font_family'    => 'blog_featured_posts_small_title_font_family',
	'font_weight'    => 'blog_featured_posts_small_title_font_weight',
	'font_style'     => 'blog_featured_posts_small_title_font_style',
	'text_transform' => 'blog_featured_posts_small_title_text_transform',
	'font_size'      => 'blog_featured_posts_small_title_font_size',
	'line_height'    => 'blog_featured_posts_small_title_line_height',
	'letter_spacing' => 'blog_featured_posts_small_title_letter_spacing',

	'font_size__tablet'      => 'blog_featured_posts_small_title_font_size__tablet',
	'line_height__tablet'    => 'blog_featured_posts_small_title_line_height__tablet',
	'letter_spacing__tablet' => 'blog_featured_posts_small_title_letter_spacing__tablet',

	'font_size__mobile'      => 'blog_featured_posts_small_title_font_size__mobile',
	'line_height__mobile'    => 'blog_featured_posts_small_title_line_height__mobile',
	'letter_spacing__mobile' => 'blog_featured_posts_small_title_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'blog_featured_posts_small_title_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Small title typography', 'cakecious-features' ),
	'responsive'  => true,
	'priority'    => 40,
) ) );

// Meta typography
$settings = array(
	'font_family'    => 'blog_featured_posts_meta_1_font_family',
	'font_weight'    => 'blog_featured_posts_meta_1_font_weight',
	'font_style'     => 'blog_featured_posts_meta_1_font_style',
	'text_transform' => 'blog_featured_posts_meta_1_text_transform',
	'font_size'      => 'blog_featured_posts_meta_1_font_size',
	'line_height'    => 'blog_featured_posts_meta_1_line_height',
	'letter_spacing' => 'blog_featured_posts_meta_1_letter_spacing',

	'font_size__tablet'      => 'blog_featured_posts_meta_1_font_size__tablet',
	'line_height__tablet'    => 'blog_featured_posts_meta_1_line_height__tablet',
	'letter_spacing__tablet' => 'blog_featured_posts_meta_1_letter_spacing__tablet',

	'font_size__mobile'      => 'blog_featured_posts_meta_1_font_size__mobile',
	'line_height__mobile'    => 'blog_featured_posts_meta_1_line_height__mobile',
	'letter_spacing__mobile' => 'blog_featured_posts_meta_1_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'blog_featured_posts_meta_1_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Meta 1 typography', 'cakecious-features' ),
	'responsive'  => true,
	'priority'    => 40,
) ) );

// Meta typography
$settings = array(
	'font_family'    => 'blog_featured_posts_meta_2_font_family',
	'font_weight'    => 'blog_featured_posts_meta_2_font_weight',
	'font_style'     => 'blog_featured_posts_meta_2_font_style',
	'text_transform' => 'blog_featured_posts_meta_2_text_transform',
	'font_size'      => 'blog_featured_posts_meta_2_font_size',
	'line_height'    => 'blog_featured_posts_meta_2_line_height',
	'letter_spacing' => 'blog_featured_posts_meta_2_letter_spacing',

	'font_size__tablet'      => 'blog_featured_posts_meta_2_font_size__tablet',
	'line_height__tablet'    => 'blog_featured_posts_meta_2_line_height__tablet',
	'letter_spacing__tablet' => 'blog_featured_posts_meta_2_letter_spacing__tablet',

	'font_size__mobile'      => 'blog_featured_posts_meta_2_font_size__mobile',
	'line_height__mobile'    => 'blog_featured_posts_meta_2_line_height__mobile',
	'letter_spacing__mobile' => 'blog_featured_posts_meta_2_letter_spacing__mobile',
);
foreach ( $settings as $key ) {
	$wp_customize->add_setting( $key, array(
		'default'     => cakecious_array_value( $defaults, $key ),
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'typography' ),
	) );
}
$wp_customize->add_control( new Cakecious_Customize_Control_Typography( $wp_customize, 'blog_featured_posts_meta_2_typography', array(
	'settings'    => $settings,
	'section'     => $section,
	'label'       => esc_html__( 'Meta 2 typography', 'cakecious-features' ),
	'responsive'  => true,
	'priority'    => 40,
) ) );

/**
 * ====================================================
 * Colors
 * ====================================================
 */

// Heading: Colors
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_blog_featured_posts_colors', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Colors', 'cakecious-features' ),
	'priority'    => 50,
) ) );

// Post image overlay color
$key = 'blog_featured_posts_overlay_bg_color';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Post image overlay color', 'cakecious-features' ),
	'description' => esc_html__( 'Add overlay to each post background image.', 'cakecious-features' ),
	'priority'    => 50,
) ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_blog_featured_posts_colors_content', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 50,
) ) );

// Text background color
$key = 'blog_featured_posts_content_bg_color';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Text background color', 'cakecious-features' ),
	'priority'    => 50,
) ) );
// Background mode
$key = 'blog_featured_posts_content_bg_mode';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
 	'section'     => $section,
 	// 'label'       => esc_html__( 'Background mode', 'cakecious-features' ),
	'choices'     => array(
		'solid'    => esc_html__( 'Solid color', 'cakecious-features' ),
		'gradient' => esc_html__( 'Gradient to transparent', 'cakecious-features' ),
	),
 	'priority'    => 50,
 ) );

// ------
$wp_customize->add_control( new Cakecious_Customize_Control_HR( $wp_customize, 'hr_blog_featured_posts_colors_title', array(
	'section'     => $section,
	'settings'    => array(),
	'priority'    => 50,
) ) );

// Text colors
$colors = array(
	'blog_featured_posts_title_text_color'        => esc_html__( 'Title text color', 'cakecious-features' ),
	'blog_featured_posts_title_hover_text_color'  => esc_html__( 'Title text color :hover', 'cakecious-features' ),
	'blog_featured_posts_meta_1_text_color'       => esc_html__( 'Meta 1 text color', 'cakecious-features' ),
	'blog_featured_posts_meta_1_hover_text_color' => esc_html__( 'Meta 1 text color :hover', 'cakecious-features' ),
	'blog_featured_posts_meta_2_text_color'       => esc_html__( 'Meta 2 text color', 'cakecious-features' ),
	'blog_featured_posts_meta_2_hover_text_color' => esc_html__( 'Meta 2 text color :hover', 'cakecious-features' ),
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