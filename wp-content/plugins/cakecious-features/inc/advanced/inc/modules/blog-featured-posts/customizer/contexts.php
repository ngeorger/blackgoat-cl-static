<?php
/**
 * Customizer Customizer control's conditional display.
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

/**
 * ====================================================
 * Blog > Featured Posts
 * ====================================================
 */

$add['blog_featured_posts_bottom_margin'] = array(
	array(
		'setting'  => 'blog_featured_posts_position',
		'value'    => 'before-primary-and-sidebar',
	),
);

$add['blog_featured_posts_per_page'] =
$add['hr_blog_featured_posts_autoplay'] =
$add['blog_featured_posts_autoplay'] =
$add['blog_featured_posts_autoplay_delay'] = array(
	array(
		'setting'  => 'blog_featured_posts_layout',
		'operator' => 'in',
		'value'    => array( 'slider', 'carousel' ),
	),
);

$add['blog_featured_posts_autoplay_delay'][] = array(
	'setting'  => 'blog_featured_posts_autoplay',
	'value'    => 1,
);

$add['blog_featured_posts_slider_height'] = array(
	array(
		'setting'  => 'blog_featured_posts_layout',
		'value'    => 'slider',
	),
);

$add['blog_featured_posts_carousel_columns'] =
$add['blog_featured_posts_carousel_height'] = array(
	array(
		'setting'  => 'blog_featured_posts_layout',
		'value'    => 'carousel',
	),
);

$add['blog_featured_posts_grid_height'] = array(
	array(
		'setting'  => 'blog_featured_posts_layout',
		'operator' => 'not_in',
		'value'    => array( 'slider', 'carousel' ),
	),
);

$add['blog_featured_posts_items_gutter'] = array(
	array(
		'setting'  => 'blog_featured_posts_layout',
		'operator' => '!=',
		'value'    => 'slider',
	),
);

$add['blog_featured_posts_small_title_typography'] = array(
	array(
		'setting'  => 'blog_featured_posts_layout',
		'operator' => 'not_in',
		'value'    => array( 'slider', 'carousel' ),
	),
);

$add['blog_featured_posts_content_bg_mode'] = array(
	array(
		'setting'  => 'blog_featured_posts_layout',
		'operator' => '!=',
		'value'    => 'slider',
	),
);

$add['blog_featured_posts_meta_typography'] =
$add['blog_featured_posts_meta_text_color'] =
$add['blog_featured_posts_meta_hover_text_color'] = array(
	array(
		'setting'  => 'blog_featured_posts_meta_display',
		'operator' => '!=',
		'value'    => '',
	),
);

return $add;