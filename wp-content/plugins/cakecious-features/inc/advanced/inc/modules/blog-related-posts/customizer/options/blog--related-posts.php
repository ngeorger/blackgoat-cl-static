<?php
/**
 * Customizer settings: Blog > Related Posts
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_blog_related_posts';

/**
 * ====================================================
 * Enable / Disable
 * ====================================================
 */

// Related Posts
$key = 'blog_related_posts';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Enable Related Posts', 'cakecious-features' ),
	'priority'    => 10,
) ) );

/**
 * ====================================================
 * Query
 * ====================================================
 */

// Heading: Query
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_blog_related_posts_query', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Query', 'cakecious-features' ),
	'priority'    => 20,
) ) );

// Show posts that are ...
$key = 'blog_related_posts_query';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Show posts that are ...', 'cakecious-features' ),
	'choices'     => array(
		'category'          => esc_html__( 'In same categories', 'cakecious-features' ),
		'tag'               => esc_html__( 'In same tags', 'cakecious-features' ),
		'category|tag__OR'  => esc_html__( 'In same categories or tags', 'cakecious-features' ),
		'category|tag__AND' => esc_html__( 'In same both categories and tags', 'cakecious-features' ),
	),
	'priority'    => 20,
) );

// Only posts within ... days
$key = 'blog_related_posts_max_days';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'number' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'number',
	'section'     => $section,
	'label'       => esc_html__( 'Only posts within ... days', 'cakecious-features' ),
	'description' => esc_html__( 'Leave blank to query all posts from the beginning.', 'cakecious-features' ),
	'input_attrs' => array(
		'min'   => 1,
		'step'  => 1,
	),
	'priority'    => 20,
) );

// Order by
$key = 'blog_related_posts_order';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Order by', 'cakecious-features' ),
	'choices'     => array(
		'date|ASC'  => esc_html__( 'Older posts first', 'cakecious-features' ),
		'date|DESC' => esc_html__( 'Newer posts first', 'cakecious-features' ),
		'rand'      => esc_html__( 'Random', 'cakecious-features' ),
	),
	'priority'    => 20,
) );

// Cache duration
$key = 'blog_related_posts_cache_duration';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'number' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Cache duration', 'cakecious-features' ),
	'units'       => array(
		'' => array(
			'min'   => 0,
			'max'   => 12,
			'step'  => 0.5,
			'label' => 'hrs',
		),
	),
	'priority'    => 20,
) ) );

// Info: no results
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, 'notice_blog_related_posts_no_results', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<div class="notice notice-info notice-alt inline"><p>' . esc_html__( 'If no related posts found, nothing is displayed.', 'cakecious-features' ) . '</p></div>',
	'priority'    => 20,
) ) );

/**
 * ====================================================
 * Layout
 * ====================================================
 */

// Heading: Layout
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, 'heading_blog_related_posts_layout', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Layout', 'cakecious-features' ),
	'priority'    => 30,
) ) );

// Position
$key = 'blog_related_posts_position';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Position', 'cakecious-features' ),
	'choices'     => array(
		'after-content'   => esc_html__( 'After post content', 'cakecious-features' ),
		'before-comments' => esc_html__( 'Before comments', 'cakecious-features' ),
	),
	'priority'    => 30,
) );

// Maximum related posts to display
$key = 'blog_related_posts_per_page';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'number' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Maximum related posts to display', 'cakecious-features' ),
	'units'       => array(
		'' => array(
			'min'   => 1,
			'max'   => 12,
			'step'  => 1,
			'label' => 'post',
		),
	),
	'priority'    => 30,
) ) );

// Columns
$key = 'blog_related_posts_columns';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'dimension' ),
) );
$wp_customize->add_control( new Cakecious_Customize_Control_Slider( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Columns', 'cakecious-features' ),
	'units'       => array(
		'' => array(
			'min'   => 1,
			'max'   => 4,
			'step'  => 1,
			'label' => 'col',
		),
	),
	'priority'    => 30,
) ) );

// Heading text
$key = 'blog_related_posts_heading_text';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
) );
$wp_customize->add_control( $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Heading text', 'cakecious-features' ),
	'priority'    => 30,
) );

// Thumbnail display
$key = 'blog_related_posts_thumbnail_display';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Thumbnail display', 'cakecious-features' ),
	'choices'     => array(
		''     => esc_html__( 'None', 'cakecious-features' ),
		'side' => esc_html__( 'Side', 'cakecious-features' ),
		'top'  => esc_html__( 'Top', 'cakecious-features' ),
	),
	'priority'    => 30,
) );

// Thumbnail size
$key = 'blog_related_posts_thumbnail_size';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Thumbnail size', 'cakecious-features' ),
	'choices'     => array(
		'thumbnail'    => esc_html__( 'Thumbnail', 'cakecious-features' ),
		'medium'       => esc_html__( 'Medium', 'cakecious-features' ),
		'medium_large' => esc_html__( 'Medium Large', 'cakecious-features' ),
	),
	'priority'    => 30,
) );

// Meta display
$key = 'blog_related_posts_meta_display';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'transport'   => 'postMessage',
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Meta display', 'cakecious-features' ),
	'choices'     => array(
		''           => esc_html__( 'None', 'cakecious-features' ),
		'categories' => esc_html__( 'Categories', 'cakecious-features' ),
		'date'       => esc_html__( 'Date', 'cakecious-features' ),
	),
	'priority'    => 30,
) );

// Selective Refresh
if ( isset( $wp_customize->selective_refresh ) ) {
	$wp_customize->selective_refresh->add_partial( 'blog_related_posts', array(
		'settings'            => array(
			'blog_related_posts_per_page',
			'blog_related_posts_columns',
			'blog_related_posts_heading_text',
			'blog_related_posts_thumbnail_display',
			'blog_related_posts_thumbnail_size',
			'blog_related_posts_meta_display',
		),
		'selector'            => '.cakecious-related-posts',
		'container_inclusive' => true,
		'render_callback'     => array( Cakecious_Pro_Module_Blog_Related_Posts::instance(), 'render_related_posts' ),
		'fallback_refresh'    => false,
	) );
}