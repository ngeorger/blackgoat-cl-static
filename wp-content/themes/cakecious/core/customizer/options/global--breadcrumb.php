<?php
/**
 * Customizer settings: Global Modules > Breadcrumb
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$section = 'cakecious_section_breadcrumb';

/**
 * ====================================================
 * Breadcrumb
 * ====================================================
 */

// Breadcrumb plugin
$key = 'breadcrumb_plugin';
$wp_customize->add_setting( $key, array(
	'default'     => cakecious_array_value( $defaults, $key ),
	'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
) );
$wp_customize->add_control( $key, array(
	'type'        => 'select',
	'section'     => $section,
	'label'       => esc_html__( 'Breadcrumb module', 'cakecious' ),
	'description' => esc_html__( 'Choose whether to use theme\'s breadcrumb or other breadcrumb modules from supported 3rd party plugins. If you use 3rd party plugin, make sure you have installed and configured the plugin correctly. Otherwise, the breadcrumb might not show properly.', 'cakecious' ),
	'choices'     => array(
		''                 => esc_html__( 'Theme\'s Breadcrumb', 'cakecious' ),
		'rank-math'        => esc_html__( 'Rank Math', 'cakecious' ),
		'seopress'         => esc_html__( 'SEOPress (pro version)', 'cakecious' ),
		'yoast-seo'        => esc_html__( 'Yoast SEO', 'cakecious' ),
		'breadcrumb-navxt' => esc_html__( 'Breadcrumb NavXT', 'cakecious' ),
		'breadcrumb-trail' => esc_html__( 'Breadcrumb Trail', 'cakecious' ),
	),
	'priority'    => 10,
) );