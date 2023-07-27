<?php
/**
 * Customizer & Front-End modification rules.
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

$responsive = array(
	'' => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['blog_featured_posts_bottom_margin' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.site-content .cakecious-featured-posts',
			'property' => 'margin-bottom',
			'media'    => $media,
		),
	);
}

$responsive = array(
	'' => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['blog_featured_posts_carousel_columns' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-featured-posts-carousel .cakecious-featured-post',
			'property' => 'width',
			'pattern'  => 'calc( 100% / $ )',
			'media'    => $media,
		),
	);
}

$responsive = array(
	'' => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['blog_featured_posts_slider_height' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-featured-posts-slider .cakecious-featured-posts-list',
			'property' => 'height',
			'media'    => $media,
		),
	);
}

$responsive = array(
	'' => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['blog_featured_posts_carousel_height' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-featured-posts-carousel .cakecious-featured-posts-list',
			'property' => 'height',
			'media'    => $media,
		),
	);
}

$responsive = array(
	'' => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['blog_featured_posts_items_gutter' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-featured-posts-carousel .cakecious-featured-posts-list:not(.tns-slider)',
			'property' => 'margin',
			'pattern'  => '0 -$',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-featured-posts-carousel .cakecious-featured-post',
			'property' => 'padding',
			'pattern'  => '0 $',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-featured-posts-carousel .tns-inner',
			'property' => 'margin',
			'pattern'  => '0 -$ !important',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-featured-posts-grid .cakecious-featured-posts-list',
			'property' => 'grid-gap',
			'media'    => $media,
		),
	);
}

$responsive = array(
	'__mobile' => '',
	'__tablet' => '@media screen and (min-width: 768px)',
	''         => '@media screen and (min-width: 1024px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['blog_featured_posts_grid_height' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-featured-posts-grid .cakecious-featured-posts-list',
			'property' => 'height',
			'media'    => $media,
		),
	);
}

$add['blog_featured_posts_content_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-featured-posts .cakecious-featured-post-text',
		'pattern'  => 'cakecious-text-align-$',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.cakecious-featured-posts .cakecious-featured-post-title.title';
	$property = str_replace( '_', '-', $prop );

	$add['blog_featured_posts_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['blog_featured_posts_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['blog_featured_posts_title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.cakecious-featured-posts .cakecious-featured-post-title.small-title';
	$property = str_replace( '_', '-', $prop );

	$add['blog_featured_posts_small_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['blog_featured_posts_small_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['blog_featured_posts_small_title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.cakecious-featured-posts .cakecious-featured-post-meta';
	$property = str_replace( '_', '-', $prop );

	$add['blog_featured_posts_meta_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['blog_featured_posts_meta_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['blog_featured_posts_meta_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['blog_featured_posts_overlay_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-featured-posts .cakecious-featured-post-background:before',
		'property' => 'background-color',
	),
);

$add['blog_featured_posts_content_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-featured-posts-content-bg-mode--solid .cakecious-featured-post-text',
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-featured-posts-content-bg-mode--gradient .cakecious-featured-post-background:after',
		'property' => 'background-image',
		'pattern'  => 'linear-gradient( 180deg, transparent 0%, $ 100% )',
	),
);

$add['blog_featured_posts_content_bg_mode'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-featured-posts',
		'pattern'  => 'cakecious-featured-posts-content-bg-mode--$',
	),
);

$add['blog_featured_posts_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-featured-posts .cakecious-featured-post-title',
		'property' => 'color',
	),
);

$add['blog_featured_posts_title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-featured-posts .cakecious-featured-post-title a:hover, .cakecious-featured-posts .cakecious-featured-post-title a:focus',
		'property' => 'color',
	),
);

$add['blog_featured_posts_meta_1_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-featured-posts .cakecious-featured-post-meta-1',
		'property' => 'color',
	),
);

$add['blog_featured_posts_meta_1_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-featured-posts .cakecious-featured-post-meta-1 a:hover, .cakecious-featured-posts .cakecious-featured-post-meta-1 a:focus',
		'property' => 'color',
	),
);

$add['blog_featured_posts_meta_2_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-featured-posts .cakecious-featured-post-meta-2',
		'property' => 'color',
	),
);

$add['blog_featured_posts_meta_2_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-featured-posts .cakecious-featured-post-meta-2 a:hover, .cakecious-featured-posts .cakecious-featured-post-meta-2 a:focus',
		'property' => 'color',
	),
);

return $add;