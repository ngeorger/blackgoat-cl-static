<?php
/**
 * Customizer & Front-End modification rules.
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$add = array();

/**
 * ====================================================
 * Global Modules > Color Palette
 * ====================================================
 */

for ( $i = 1; $i <= 8; $i++ ) {
	$add['color_palette_' . $i ] = array(
		array(
			'type'     => 'css',
			'element'  => '.has-cakecious-color-' . $i . '-background-color', // scss: gutenberg
			'property' => 'background-color',
		),
		array(
			'type'     => 'css',
			'element'  => '.has-cakecious-color-' . $i . '-color', // scss: gutenberg
			'property' => 'color',
		),
	);
}

/**
 * ====================================================
 * Typography & Colors > Base
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = 'html'; // scss: base
	$property = str_replace( '_', '-', $prop );

	$add['body_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['body_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['body_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

// Font sizes
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => '.has-medium-text-size', // scss: gutenberg
	'property' => 'line-height',
	'pattern'  => 'calc( 0.9 * $ )',
);
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => '.has-large-text-size', // scss: gutenberg
	'property' => 'line-height',
	'pattern'  => 'calc( 0.825 * $ )',
);
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => '.has-huge-text-size',
	'property' => 'line-height',
	'pattern'  => 'calc( 0.75 * $ )', // scss: gutenberg
);

// Drop cap
$add['body_line_height'][] = array(
	'type'     => 'css',
	'element'  => 'p.has-drop-cap:not(:focus):first-letter', // scss: gutenberg
	'property' => 'font-size',
	'pattern'  => '$em',
	'function' => array(
		'name' => 'scale_dimensions',
		'args' => array( 3 ),
	),
);

$add['font_smoothing'] = array(
	array(
		'type'     => 'class',
		'element'  => 'body',
		'pattern'  => 'cakecious-font-smoothing-$', // scss: common
	),
);

$add['body_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body', // scss: base
		'property' => 'color',
	),
);

$add['subtle_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'pre, code, .tagcloud a, .navigation.pagination .current, span.select2-container .select2-selection--multiple .select2-selection__rendered li.select2-selection__choice, .wp-block-table.is-style-stripes tbody tr:nth-child(odd)', // scss: base, common, forms, gutenberg
		'property' => 'background-color',
	),
);
$add['border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '*', // scss: base
		'property' => 'border-color',
	),
);

$add['link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'a, button.cakecious-toggle, .navigation .nav-links a:hover, .navigation .nav-links a:focus, .tagcloud a:hover, .tagcloud a:focus, .comment-body .reply:hover, .comment-body .reply:focus, .comment-metadata a:hover, .comment-metadata a:focus', // scss: base, common
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.entry-meta a:hover, .entry-meta a:focus, .widget .post-date a:hover, .widget .post-date a:focus, .widget_rss .rss-date a:hover, .widget_rss .rss-date a:focus', // scss: entry, widgets
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => 'h1 a:hover, h1 a:focus, .h1 a:hover, .h1 a:focus, h2 a:hover, h2 a:focus, .h2 a:hover, .h2 a:focus, h3 a:hover, h3 a:focus, .h3 a:hover, .h3 a:focus, h4 a:hover, h4 a:focus, .h4 a:hover, .h4 a:focus, h5 a:hover, h5 a:focus, .h5 a:hover, .h5 a:focus, h6 a:hover, h6 a:focus, .h6 a:hover, .h6 a:focus, .comment-author a:hover, .comment-author a:focus, .entry-author-name a:hover, .entry-author-name a:focus', // scss: base, common
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-section a:not(.button):hover, .cakecious-header-section a:not(.button):focus, .cakecious-header-section .cakecious-toggle:hover, .cakecious-header-section .cakecious-toggle:focus, .cakecious-header-section .menu .sub-menu a:not(.button):hover, .cakecious-header-section .menu .sub-menu a:not(.button):focus, .cakecious-header-section .menu .sub-menu .cakecious-toggle:hover, .cakecious-header-section .menu .sub-menu .cakecious-toggle:focus, .cakecious-header-section-vertical a:not(.button):hover, .cakecious-header-section-vertical a:not(.button):focus, .cakecious-header-section-vertical .cakecious-toggle:hover, .cakecious-header-section-vertical .cakecious-toggle:focus, .cakecious-header-section-vertical .menu .sub-menu a:not(.button):hover, .cakecious-header-section-vertical .menu .sub-menu a:not(.button):focus, .cakecious-header-section-vertical .menu .sub-menu .cakecious-toggle:hover, .cakecious-header-section-vertical .menu .sub-menu .cakecious-toggle:focus', // scss: header
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '::selection', // scss: base
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-shopping-cart .shopping-cart-count', // scss: header
		'property' => 'background-color',
	),
);
$add['link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'a:hover, a:focus, .cakecious-toggle:hover, .cakecious-toggle:focus', // scss: base, common
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Typography & Colors > Headings
 * ====================================================
 */

for ( $i = 1; $i <= 4; $i++ ) {
	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$property = str_replace( '_', '-', $prop );

		$rules = array();

		$rules[] = array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => 'h' . $i . ', .h' . $i, // scss: base
			'property' => $property,
		);

		// Add additional rules
		switch ( $i ) {
			case 1:
				// Styles that inherit h1 by default
				$rules[] = array(
					'type'     => 'css',
					'element'  => '.title, .entry-title, .page-title', // scss: common, entry
					'property' => $property,
				);
				break;

			case 3:
				// Styles that inherit h3 by default
				$rules[] = array(
					'type'     => 'css',
					'element'  => 'legend, .small-title, .entry-small-title, .comments-title, .comment-reply-title', // scss: forms, common, entry
					'property' => $property,
				);
				break;

			case 4:
				// Styles that inherit h4 by default
				$rules[] = array(
					'type'     => 'css',
					'element'  => '.widget-title', // scss: widgets
					'property' => $property,
				);
				break;
		}

		$add['h' . $i . '_' . $prop ] = $rules;

		// Responsive
		if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
			// Tablet
			$rules__tablet = $rules;
			foreach ( $rules__tablet as &$rule ) {
				$rule[ 'media' ] = '@media screen and (max-width: 1023px)';
			}
			$add['h' . $i . '_' . $prop . '__tablet'] = $rules__tablet;


			// Mobile
			$rules__mobile = $rules;
			foreach ( $rules__mobile as &$rule ) {
				$rule[ 'media' ] = '@media screen and (max-width: 499px)';
			}
			$add['h' . $i . '_' . $prop . '__mobile'] = $rules__mobile;
		}
	}
}
$add['heading_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'h1, .h1, h2, .h2, h3, .h3, h4, .h4, h5, .h5, h6, .h6, h1 a, .h1 a, h2 a, .h2 a, h3 a, .h3 a, h4 a, .h4 a, h5 a, .h5 a, h6 a, .h6 a, table th, button.cakecious-toggle, .navigation .nav-links .current, .comment-author a, .entry-author-name, .entry-author-name a, .widget-title, p.has-drop-cap:not(:focus):first-letter', // scss: base, common, entry, widgets, gutenberg
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-section a:not(.button), .cakecious-header-section .cakecious-toggle, .cakecious-header-section .menu .sub-menu a:not(.button), .cakecious-header-section .menu .sub-menu .cakecious-toggle, .cakecious-header-section-vertical a:not(.button), .cakecious-header-section-vertical .cakecious-toggle, .cakecious-header-section-vertical .menu .sub-menu a:not(.button), .cakecious-header-section-vertical .menu .sub-menu .cakecious-toggle', // scss: header
		'property' => 'color',
	),
);
$add['heading_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'h1 a:hover, h1 a:focus, .h1 a:hover, .h1 a:focus, h2 a:hover, h2 a:focus, .h2 a:hover, .h2 a:focus, h3 a:hover, h3 a:focus, .h3 a:hover, .h3 a:focus, h4 a:hover, h4 a:focus, .h4 a:hover, .h4 a:focus, h5 a:hover, h5 a:focus, .h5 a:hover, .h5 a:focus, h6 a:hover, h6 a:focus, .h6 a:hover, .h6 a:focus, .comment-author a:hover, .comment-author a:focus, .entry-author-name a:hover, .entry-author-name a:focus',
		'property' => 'color', // scss: base, common, entry
	),
);

/**
 * ====================================================
 * Typography & Colors > Blockquote
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = 'blockquote, .wp-block-quote p, .wp-block-pullquote blockquote p'; // scss: base, gutenberg
	$property = str_replace( '_', '-', $prop );

	$add['blockquote_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['blockquote_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['blockquote_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

/**
 * ====================================================
 * Typography & Colors > Button
 * ====================================================
 */

$add['button_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link', // scss: forms
		'property' => 'padding',
	),
);
$add['button_border'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link', // scss: forms
		'property' => 'border-width',
	),
);
$add['button_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link', // scss: forms
		'property' => 'border-radius',
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$element = 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link'; // scss: forms
	$property = str_replace( '_', '-', $prop );

	$add['button_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link', // scss: forms
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['button_hover_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'button:hover, button:focus, input[type="button"]:hover, input[type="button"]:focus, input[type="reset"]:hover, input[type="reset"]:focus, input[type="submit"]:hover, input[type="submit"]:focus, .button:hover, .button:focus, a.button:hover, a.button:focus, a.wp-block-button__link:hover, a.wp-block-button__link:focus', // scss: forms
			'property' => $prop,
		),
	);
}

/**
 * ====================================================
 * Typography & Colors > Form Input
 * ====================================================
 */

$add['input_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, span.select2-container .select2-selection, span.select2-container .select2-dropdown .select2-search, span.select2-container .select2-dropdown .select2-results .select2-results__option', // scss: forms
		'property' => 'padding',
	),
);
$add['input_border'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, span.select2-container .select2-selection, span.select2-container .select2-dropdown', // scss: forms
		'property' => 'border-width',
	),
);
$add['input_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, span.select2-container .select2-selection, span.select2-container .select2-dropdown', // scss: forms
		'property' => 'border-radius',
	),
);
foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'letter_spacing' ) as $prop ) {
	$element = 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, .search-field, span.select2-container';
	$property = str_replace( '_', '-', $prop );

	$add['input_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element, // scss: forms
			'property' => $property,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'input[type="text"], input[type="password"], input[type="color"], input[type="date"], input[type="datetime-local"], input[type="email"], input[type="month"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], input[type="week"], .input, select, textarea, .search-field, span.select2-container .select2-selection, span.select2-container.select2-container--open .select2-dropdown', // scss: forms
			'property' => $prop,
		),
	);
}
foreach ( array( 'bg' => 'background-color', 'border' => 'border-color', 'text' => 'color' ) as $key => $prop ) {
	$add['input_focus_' . $key . '_color'] = array(
		array(
			'type'     => 'css',
			'element'  => 'input[type="text"]:focus, input[type="password"]:focus, input[type="color"]:focus, input[type="date"]:focus, input[type="datetime-local"]:focus, input[type="email"]:focus, input[type="month"]:focus, input[type="number"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="time"]:focus, input[type="url"]:focus, input[type="week"]:focus, .input:hover, .input:focus, select:focus, textarea:focus, .search-field:focus, span.select2-container.select2-container--open .select2-selection', // scss: forms
			'property' => $prop,
		),
	);

	if ( 'border' === $key ) {
		$add['input_focus_' . $key . '_color'][] = array(
			'type'     => 'css',
			'element'  => 'span.select2-container.select2-container--open .select2-dropdown', // scss: forms
			'property' => $prop,
		);
	}
}

/**
 * ====================================================
 * Typography & Colors > Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.title, .entry-title, .page-title';
	$property = str_replace( '_', '-', $prop );

	$add['title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}
$add['title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.title, .title a, .entry-title, .entry-title a, .page-title, .page-title a',
		'property' => 'color',
	),
);
$add['title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.title a:hover, .title a:focus, .entry-title a:hover, .entry-title a:focus, .page-title a:hover, .page-title a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Typography & Colors > Small Title
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = 'legend, .small-title, .entry-small-title, .comments-title, .comment-reply-title'; // scss: forms, common, entry
	$property = str_replace( '_', '-', $prop );

	$add['small_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['small_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['small_title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}
$add['small_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'legend, .small-title, .small-title a, .entry-small-title, .entry-small-title a, .comments-title, .comment-reply-title', // scss: forms, common, entry
		'property' => 'color',
	),
);
$add['small_title_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.small-title a:hover, .small-title a:focus, .entry-small-title a:hover, .entry-small-title a:focus', // scss: common, entry
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Typography & Colors > Meta Info
 * ====================================================
 */

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.entry-meta, .comment-metadata, .widget .post-date, .widget_rss .rss-date';
	$property = str_replace( '_', '-', $prop );

	$add['meta_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['meta_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['meta_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}
$add['meta_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-meta, .comment-metadata, .widget .post-date, .widget_rss .rss-date',
		'property' => 'color',
	),
);
$add['meta_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-meta a, .comment-metadata a, .widget .post-date a, .widget_rss .rss-date a',
		'property' => 'color',
	),
);
$add['meta_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-meta a:hover, .entry-meta a:focus, .comment-metadata a:hover, .comment-metadata a:focus, .widget .post-date a:hover, .widget .post-date a:focus, .widget_rss .rss-date a:hover, .widget_rss .rss-date a:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Page Canvas & Wrapper
 * ====================================================
 */

$add['page_layout'] = array(
	array(
		'type'    => 'class',
		'element' => 'body',
		'pattern' => 'cakecious-page-layout-$',
	),
);
$add['boxed_page_width'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body.cakecious-page-layout-boxed #page', // scss: container
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => 'body.cakecious-page-layout-boxed .cakecious-header-section.cakecious-section-full-width .menu .sub-menu', // scss: header
		'property' => 'max-width',
	),
	array(
		'type'     => 'css',
		'element'  => 'body.cakecious-page-layout-boxed .cakecious-content-layout-wide .cakecious-gutenberg-content .entry-content', // scss: gutenberg
		'property' => 'width',
		'media'    => '@media screen and (min-width: $)',
	),
	array(
		'type'     => 'css',
		'element'  => 'body.cakecious-page-layout-boxed .cakecious-content-layout-wide .cakecious-gutenberg-content .entry-content', // scss: gutenberg
		'property' => 'left',
		'pattern'  => 'calc( 50% - ( $ / 2 ) )',
		'media'    => '@media screen and (min-width: $)',
	),
);
$add['boxed_page_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body.cakecious-page-layout-boxed #page',
		'property' => 'box-shadow',
	),
);
$add['container_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-wrapper, .cakecious-section-contained > .cakecious-section-inner', // scss: container
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-section .menu .sub-menu', // scss: header
		'property' => 'max-width',
	),
	// alignwide
	array(
		'type'     => 'css',
		'element'  => '.cakecious-section-default.cakecious-content-layout-wide [class$="__inner-container"] > *', // scss: gutenberg
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-content-layout-wide .cakecious-gutenberg-content .entry-content .alignwide', // scss: gutenberg
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-content-layout-wide.cakecious-section-default .cakecious-gutenberg-content .entry-content > *:not(.alignwide):not(.alignfull)', // scss: gutenberg
		'property' => 'width',
	),
);
$add['content_narrow_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-section-narrow > .cakecious-section-inner > .cakecious-wrapper', // scss: container
		'property' => 'max-width',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-section-narrow.cakecious-content-layout-wide [class$="__inner-container"] > *', // scss: gutenberg
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-content-layout-wide.cakecious-section-narrow .cakecious-gutenberg-content .entry-content > *:not(.alignwide):not(.alignfull)', // scss: gutenberg
		'property' => 'width',
	),
);

$add['page_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body, #page, .cakecious-popup-background', // scss: base, container
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '::selection', // scss: base
		'property' => 'color',
	),
);

$add['outside_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => 'body.cakecious-page-layout-boxed',
		'property' => 'background-color',
	),
);
foreach ( array( 'image', 'position', 'size', 'repeat', 'attachment' ) as $prop ) {
	$add['outside_bg_' . $prop ] = array(
		array(
			'type'     => 'css',
			'element'  => 'body.cakecious-page-layout-boxed',
			'property' => 'background-' . $prop,
			'pattern'  => 'image' == $prop ? 'url($)' : '$',
			'media'    => '@media screen and (min-width: 1024px)',
		),
	);
}

/**
 * ====================================================
 * Header > Element: Logo
 * ====================================================
 */

$add['header_logo_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-logo .cakecious-logo-image', // scss: header
		'property' => 'width',
	),
);
$add['header_mobile_logo_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-logo .cakecious-logo-image', // scss: header
		'property' => 'width',
	),
);

/**
 * ====================================================
 * Header > Element: Search
 * ====================================================
 */

$add['header_search_bar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-search-bar .search-form', // scss: header
		'property' => 'width',
	),
);
$add['header_search_dropdown_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-search-dropdown .sub-menu', // scss: header
		'property' => 'width',
	),
);

/**
 * ====================================================
 * Header > Element: Shopping Cart
 * ====================================================
 */

$add['header_cart_count_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-shopping-cart .shopping-cart-count', // scss: header
		'property' => 'background-color',
	),
);
$add['header_cart_count_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-shopping-cart .shopping-cart-count', // scss: header
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Header > Element: Social
 * ====================================================
 */

$add['header_social_links_target'] = array(
	array(
		'type'     => 'html',
		'element'  => '.cakecious-header-social-links a',
		'property' => 'target',
		'pattern'  => '_$',
	),
);

/**
 * ====================================================
 * Header > Top Bar
 * Header > Main Bar
 * Header > Bottom Bar
 * ====================================================
 */

// Main bar is placed first because top bar and bottom bar can be merged into main bar.
foreach ( array( 'main_bar', 'top_bar', 'bottom_bar' ) as $bar ) {
	$slug = str_replace( '_', '-', $bar );

	if ( 'main_bar' !== $bar ) {
		$add['header_' . $bar . '_merged_gap'] = array(
			array(
				'type'     => 'css',
				'element'  => '.cakecious-header-main-bar.cakecious-header-main-bar-with-' . $slug . ' .cakecious-header-main-bar-row',
				'property' => 'padding-' . ( 'top_bar' === $bar ? 'top' : 'bottom' ),
			),
		);
	}

	// Layout
	$add['header_' . $bar . '_container'] = array(
		array(
			'type'     => 'class',
			'element'  => '.cakecious-header-' . $slug,
			'pattern'  => 'cakecious-section-$',
		),
	);
	$add['header_' . $bar . '_height'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug, // scss: header
			'property' => 'height',
		),
	);

	$add['header_' . $bar . '_padding'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . '-inner', // scss: header
			'property' => 'padding',
		),
	);
	$add['header_' . $bar . '_border'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . '-inner',
			'property' => 'border-width',
		),
	);
	$add['header_' . $bar . '_items_gutter'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .cakecious-header-column > *', // scss: header
			'property' => 'padding',
			'pattern'  => '0 $',
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . '-row', // scss: header
			'property' => 'margin',
			'pattern'  => '0 -$',
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .cakecious-header-menu .menu-item', // scss: header
			'property' => 'padding',
			'pattern'  => '0 $',
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . '.cakecious-header-menu-highlight-background .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link, .cakecious-header-' . $slug . '.cakecious-header-menu-highlight-border-top .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link, .cakecious-header-' . $slug . '.cakecious-header-menu-highlight-border-bottom .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link', // scss: header
			'property' => 'padding',
			'pattern'  => '0 $',
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . '.cakecious-header-menu-highlight-none .cakecious-header-menu > .menu > .menu-item > .sub-menu, .cakecious-header-' . $slug . '.cakecious-header-menu-highlight-underline .cakecious-header-menu > .menu > .menu-item > .sub-menu', // scss: header
			'property' => 'margin-left',
			'pattern'  => '-$',
		),
	);

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element = '.cakecious-header-' . $slug;
		$property = str_replace( '_', '-', $prop );

		$add['header_' . $bar . '_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element = '.cakecious-header-' . $slug . ' .menu .menu-item > .cakecious-menu-item-link';
		$property = str_replace( '_', '-', $prop );

		$add['header_' . $bar . '_menu_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
		$element = '.cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu .menu-item > .cakecious-menu-item-link';
		$property = str_replace( '_', '-', $prop );

		$add['header_' . $bar . '_submenu_' . $prop ] = array(
			array(
				'type'     => 'font_family' === $prop ? 'font' : 'css',
				'element'  => $element,
				'property' => $property,
			),
		);
	}

	$add['header_' . $bar . '_icon_size'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .cakecious-menu-icon', // scss: header
			'property' => 'font-size',
		),
	);

	$add['header_' . $bar . '_bg_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . '-inner',
			'property' => 'background-color',
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu', // scss: header
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_border_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' *',
			'property' => 'border-color',
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu',
			'property' => 'border-color',
		),
	);
	$add['header_' . $bar . '_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug,
			'property' => 'color',
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_link_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' a:not(.button), .cakecious-header-' . $slug . ' .cakecious-toggle, .cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button)', // scss: header
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_link_hover_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' a:not(.button):hover, .cakecious-header-' . $slug . ' a:not(.button):focus, .cakecious-header-' . $slug . ' .cakecious-toggle:hover, .cakecious-header-' . $slug . ' .cakecious-toggle:focus, .cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button):hover, .cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button):focus', // scss: header
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_link_active_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .current-menu-item > .cakecious-menu-item-link, .cakecious-header-' . $slug . ' .current-menu-ancestor > .cakecious-menu-item-link',
			'property' => 'color',
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu .current-menu-item > .cakecious-menu-item-link, .cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu .current-menu-ancestor > .cakecious-menu-item-link',
			'property' => 'color',
		),
	);

	$add['header_' . $bar . '_submenu_bg_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu',
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_submenu_border_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu',
			'property' => 'border-color',
		),
	);
	$add['header_' . $bar . '_submenu_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_submenu_link_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button)',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_submenu_link_hover_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button):hover, .cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu a:not(.button):focus',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_submenu_link_active_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu .current-menu-item > .cakecious-menu-item-link, .cakecious-header-' . $slug . ' .menu > .menu-item .sub-menu .current-menu-ancestor > .cakecious-menu-item-link',
			'property' => 'color',
		),
	);

	$add['header_' . $bar . '_menu_highlight'] = array(
		array(
			'type'     => 'class',
			'element'  => '.cakecious-header-' . $slug,
			'pattern'  => 'cakecious-header-menu-highlight-$',
		),
	);

	$add['header_' . $bar . '_menu_hover_highlight_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:hover:before, .cakecious-header-' . $slug . ' .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:focus:before', // scss: header
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_menu_hover_highlight_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:hover, .cakecious-header-' . $slug . ' .cakecious-header-menu > .menu > .menu-item > .cakecious-menu-item-link:focus',
			'property' => 'color',
		),
	);
	$add['header_' . $bar . '_menu_active_highlight_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .cakecious-header-menu > .menu > .current-menu-item > .cakecious-menu-item-link:before, .cakecious-header-' . $slug . ' .cakecious-header-menu > .menu > .current-menu-ancestor > .cakecious-menu-item-link:before',
			'property' => 'background-color',
		),
	);
	$add['header_' . $bar . '_menu_active_highlight_text_color'] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-' . $slug . ' .cakecious-header-menu > .menu > .current-menu-item > .cakecious-menu-item-link, .cakecious-header-' . $slug . ' .cakecious-header-menu > .menu > .current-menu-ancestor > .cakecious-menu-item-link',
			'property' => 'color',
		),
	);
}

/**
 * ====================================================
 * Header > Mobile Main Bar
 * ====================================================
 */

$add['header_mobile_main_bar_height'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-main-bar',
		'property' => 'height',
	),
);
$responsive = array(
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['header_mobile_main_bar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-header-mobile-main-bar-inner',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['header_mobile_main_bar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-main-bar-inner',
		'property' => 'border-width',
	),
);
$add['header_mobile_main_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-main-bar .cakecious-header-column > *',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-main-bar .cakecious-header-row',
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-main-bar .cakecious-header-menu .menu-item',
		'property' => 'padding',
		'pattern'  => '0 $',
	),
);

$add['header_mobile_main_bar_icon_size'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-main-bar .cakecious-menu-icon',
		'property' => 'font-size',
	),
);

$add['header_mobile_main_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-main-bar-inner',
		'property' => 'background-color',
	),
);
$add['header_mobile_main_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-main-bar *',
		'property' => 'border-color',
	),
);
$add['header_mobile_main_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-main-bar a:not(.button), .cakecious-header-mobile-main-bar .cakecious-toggle',
		'property' => 'color',
	),
);
$add['header_mobile_main_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-main-bar a:not(.button):hover, .cakecious-header-mobile-main-bar a:not(.button):focus, .cakecious-header-mobile-main-bar .cakecious-toggle:hover, .cakecious-header-mobile-main-bar .cakecious-toggle:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Header > Mobile Popup
 * ====================================================
 */

$add['header_mobile_vertical_bar_position'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-header-mobile-vertical',
		'pattern'  => 'cakecious-header-mobile-vertical-position-$',
	),
);
$add['header_mobile_vertical_bar_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-header-mobile-vertical',
		'pattern'  => 'cakecious-text-align-$',
	),
);

$add['header_mobile_vertical_bar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical-bar', // scss: header
		'property' => 'width',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical.cakecious-header-mobile-vertical-display-full-screen .cakecious-header-section-vertical-column', // scss: header
		'property' => 'width',
	),
);
$add['header_mobile_vertical_bar_padding'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical-bar', // scss: header
		'property' => 'padding',
	),
);

$add['header_mobile_vertical_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical-bar .cakecious-header-section-vertical-row > *', // scss: header
		'property' => 'padding',
		'pattern'  => '$ 0',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical-bar .cakecious-header-section-vertical-column', // scss: header
		'property' => 'margin',
		'pattern'  => '-$ 0',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['header_mobile_vertical_bar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.cakecious-header-mobile-vertical-bar',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['header_mobile_vertical_bar_menu_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.cakecious-header-mobile-vertical-bar .menu .menu-item > .cakecious-menu-item-link, .cakecious-header-mobile-vertical-bar .menu-item > .cakecious-toggle',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$add['header_mobile_vertical_bar_submenu_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => '.cakecious-header-mobile-vertical-bar .menu .sub-menu .menu-item > .cakecious-menu-item-link, .cakecious-header-mobile-vertical-bar .sub-menu .menu-item > .cakecious-toggle',
			'property' => str_replace( '_', '-', $prop),
		),
	);
}

$add['header_mobile_vertical_bar_icon_size'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical-bar .cakecious-menu-icon',
		'property' => 'font-size',
	),
);

$add['header_mobile_vertical_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical-bar',
		'property' => 'background-color',
	),
);
$add['header_mobile_vertical_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical-bar *',
		'property' => 'border-color',
	),
);
$add['header_mobile_vertical_bar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical-bar',
		'property' => 'color',
	),
);
$add['header_mobile_vertical_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical-bar a:not(.button), .cakecious-header-mobile-vertical-bar .cakecious-toggle, .cakecious-header-mobile-vertical-bar .menu .sub-menu a:not(.button), .cakecious-header-mobile-vertical-bar .menu .sub-menu .cakecious-toggle', // scss: header
		'property' => 'color',
	),
);
$add['header_mobile_vertical_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical-bar a:not(.button):hover, .cakecious-header-mobile-vertical-bar a:not(.button):focus, .cakecious-header-mobile-vertical-bar .cakecious-toggle:hover, .cakecious-header-mobile-vertical-bar .cakecious-toggle:focus, .cakecious-header-mobile-vertical-bar .menu .sub-menu a:not(.button):hover, .cakecious-header-mobile-vertical-bar .menu .sub-menu a:not(.button):focus, .cakecious-header-mobile-vertical-bar .menu .sub-menu .cakecious-toggle:hover, .cakecious-header-mobile-vertical-bar .menu .sub-menu .cakecious-toggle:focus', // scss: header
		'property' => 'color',
	),
);
$add['header_mobile_vertical_bar_link_active_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-mobile-vertical-bar .current-menu-item > .cakecious-menu-item-link, .cakecious-header-mobile-vertical-bar .current-menu-ancestor > .cakecious-menu-item-link',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Page Header
 * ====================================================
 */

$add['hero_container'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-hero',
		'pattern'  => 'cakecious-section-$',
	),
);
$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['hero_height' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-hero-inner', // scss: container
			'property' => 'min-height',
			'media'    => $media,
		),
	);
}
foreach ( $responsive as $suffix => $media ) {
	$add['hero_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-hero-inner', // scss: container
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['hero_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero-inner',
		'property' => 'border-width',
	),
);
$add['hero_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-hero',
		'pattern'  => 'cakecious-text-align-$',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.cakecious-hero .page-title, .cakecious-hero .entry-title';
	$property = str_replace( '_', '-', $prop );

	$add['hero_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['hero_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['hero_title_' . $prop . '__mobile'] = array(
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
	$element = '.cakecious-hero';
	$property = str_replace( '_', '-', $prop );

	$add['hero_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['hero_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['hero_' . $prop . '__mobile'] = array(
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
	$element = '.cakecious-hero .cakecious-breadcrumb';
	$property = str_replace( '_', '-', $prop );

	$add['hero_breadcrumb_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['hero_breadcrumb_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['hero_breadcrumb_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['hero_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero-inner', // scss: container
		'property' => 'background-color',
	),
);
$add['hero_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero *',
		'property' => 'border-color',
	),
);
$add['hero_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero',
		'property' => 'color',
	),
);
$add['hero_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero a',
		'property' => 'color',
	),
);
$add['hero_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero a:hover, .cakecious-hero a:focus',
		'property' => 'color',
	),
);
$add['hero_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero .page-title, .cakecious-hero .entry-title',
		'property' => 'color',
	),
);
$add['hero_breadcrumb_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero .cakecious-breadcrumb',
		'property' => 'color',
	),
);
$add['hero_breadcrumb_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero .cakecious-breadcrumb a',
		'property' => 'color',
	),
);
$add['hero_breadcrumb_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero .cakecious-breadcrumb a:hover, .cakecious-hero .cakecious-breadcrumb a:focus',
		'property' => 'color',
	),
);

$add['hero_bg_attachment'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero-inner', // scss: container
		'property' => 'background-attachment',
	),
);

$add['hero_bg_overlay_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-hero-inner:before', // scss: container
		'property' => 'background-color',
	),
);

/**
 * ====================================================
 * Content & Sidebar > Section
 * ====================================================
 */

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['content_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-content-inner', // scss: container
			'property' => 'padding',
			'media'    => $media,
		),

		array(
			'type'     => 'css',
			'element'  => '.cakecious-content-layout-wide .cakecious-gutenberg-content .entry-content', // scss: gutenberg
			'property' => 'padding-left',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 3 ), // 4th part = left
			),
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-content-layout-wide .cakecious-gutenberg-content .entry-content', // scss: gutenberg
			'property' => 'padding-right',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 1 ), // 2nd part = right
			),
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-content-layout-wide .cakecious-gutenberg-content .entry-content > .alignfull', // scss: gutenberg
			'property' => 'left',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 3 ), // 4th part = left
			),
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-content-layout-wide .cakecious-gutenberg-content .entry-content > .alignfull', // scss: gutenberg
			'property' => 'max-width',
			'pattern'  => 'calc( 100% + ( 2 * $ ) )',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 3 ), // 4th part = left --- assumed that right padding is same with left padding 
			),
		),
	);
}

/**
 * ====================================================
 * Content & Sidebar > Main Content Area
 * ====================================================
 */

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['content_main_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.content-area .site-main',
			'property' => 'padding',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default:first-child .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding:first-child',
			'property' => 'margin-top',
			'pattern'  => '-$ !important',
			'media'    => $media,
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 0 ), // 1st part = top
			),
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
			'property' => 'margin-right',
			'pattern'  => '-$ !important',
			'media'    => $media,
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 1 ), // 2nd part = right
			),
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
			'property' => 'margin-left',
			'pattern'  => '-$ !important',
			'media'    => $media,
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 3 ), // 4rd part = left
			),
		),
	);
}
$add['content_main_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'border-width',
	),
);

$add['content_main_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'background-color',
	),
);
$add['content_main_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.content-area .site-main',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Content & Sidebar > Sidebar Area
 * ====================================================
 */

$add['sidebar_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar', // scss: container
		'property' => 'flex-basis',
	),
);
$add['sidebar_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.ltr .cakecious-content-layout-right-sidebar .sidebar', // scss: container
		'property' => 'margin-left',
	),
	array(
		'type'     => 'css',
		'element'  => '.rtl .cakecious-content-layout-right-sidebar .sidebar', // scss: container
		'property' => 'margin-right',
	),
	array(
		'type'     => 'css',
		'element'  => '.ltr .cakecious-content-layout-left-sidebar .sidebar', // scss: container
		'property' => 'margin-right',
	),
	array(
		'type'     => 'css',
		'element'  => '.rtl .cakecious-content-layout-left-sidebar .sidebar', // scss: container
		'property' => 'margin-right',
	),
);

$add['sidebar_widgets_mode'] = array(
	array(
		'type'     => 'class',
		'element'  => '.sidebar',
		'pattern'  => 'cakecious-sidebar-widgets-mode-$',
	),
);
$add['sidebar_widgets_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar .widget', // scss: widgets
		'property' => 'margin-bottom',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['sidebar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.sidebar.cakecious-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.cakecious-sidebar-widgets-mode-separated .widget',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['sidebar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.cakecious-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.cakecious-sidebar-widgets-mode-separated .widget',
		'property' => 'border-width',
	),
);
$add['sidebar_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.cakecious-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.cakecious-sidebar-widgets-mode-separated .widget',
		'property' => 'border-radius',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.sidebar';
	$property = str_replace( '_', '-', $prop );

	$add['sidebar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['sidebar_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['sidebar_' . $prop . '__mobile'] = array(
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
	$element = '.sidebar .widget-title';
	$property = str_replace( '_', '-', $prop );

	$add['sidebar_widget_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['sidebar_widget_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['sidebar_widget_title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['sidebar_widget_title_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.sidebar',
		'pattern'  => 'cakecious-widget-title-alignment-$',
	),
);
$add['sidebar_widget_title_decoration'] = array(
	array(
		'type'     => 'class',
		'element'  => '.sidebar',
		'pattern'  => 'cakecious-widget-title-decoration-$',
	),
);

$add['sidebar_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.cakecious-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.cakecious-sidebar-widgets-mode-separated .widget',
		'property' => 'box-shadow',
	),
);

$add['sidebar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.cakecious-sidebar-widgets-mode-merged .sidebar-inner, .sidebar.cakecious-sidebar-widgets-mode-separated .widget',
		'property' => 'background-color',
	),
);
$add['sidebar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar *',
		'property' => 'border-color',
	),
);
$add['sidebar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar',
		'property' => 'color',
	),
);
$add['sidebar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar a',
		'property' => 'color',
	),
);
$add['sidebar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar a:hover, .sidebar a:focus',
		'property' => 'color',
	),
);
$add['sidebar_widget_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar .widget-title',
		'property' => 'color',
	),
);
$add['sidebar_widget_title_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar.cakecious-widget-title-decoration-box .widget-title',
		'property' => 'background-color',
	),
);
$add['sidebar_widget_title_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.sidebar .widget-title',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Footer > Widgets Bar
 * ====================================================
 */

$add['footer_widgets_bar_container'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-footer-widgets-bar',
		'pattern'  => 'cakecious-section-$',
	),
);
$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['footer_widgets_bar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-footer-widgets-bar-inner',
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['footer_widgets_bar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar-inner',
		'property' => 'border-width',
	),
);
$add['footer_widgets_bar_columns_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar-column', // scss: footer
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar-row', // scss: footer
		'property' => 'margin-left',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar-row', // scss: footer
		'property' => 'margin-right',
		'pattern'  => '-$',
	),
);
$add['footer_widgets_bar_widgets_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar .widget', // scss: footer
		'property' => 'margin-bottom',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar-row', // scss: footer
		'property' => 'margin-bottom',
		'pattern'  => '-$',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.cakecious-footer-widgets-bar';
	$property = str_replace( '_', '-', $prop );

	$add['footer_widgets_bar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['footer_widgets_bar_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['footer_widgets_bar_' . $prop . '__mobile'] = array(
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
	$element = '.cakecious-footer-widgets-bar .widget-title';
	$property = str_replace( '_', '-', $prop );

	$add['footer_widgets_bar_widget_title_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);
	
	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['footer_widgets_bar_widget_title_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['footer_widgets_bar_widget_title_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['footer_widgets_bar_widget_title_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-footer-widgets-bar',
		'pattern'  => 'cakecious-widget-title-alignment-$',
	),
);
$add['footer_widgets_bar_widget_title_decoration'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-footer-widgets-bar',
		'pattern'  => 'cakecious-widget-title-decoration-$',
	),
);

$add['footer_widgets_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar-inner',
		'property' => 'background-color',
	),
);
$add['footer_widgets_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar *',
		'property' => 'border-color',
	),
);
$add['footer_widgets_bar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar',
		'property' => 'color',
	),
);
$add['footer_widgets_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar a:not(.button)',
		'property' => 'color',
	),
);
$add['footer_widgets_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar a:not(.button):hover, .cakecious-footer-widgets-bar a:not(.button):focus',
		'property' => 'color',
	),
);
$add['footer_widgets_bar_widget_title_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar .widget-title',
		'property' => 'color',
	),
);
$add['footer_widgets_bar_widget_title_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar.cakecious-widget-title-decoration-box .widget-title',
		'property' => 'background-color',
	),
);
$add['footer_widgets_bar_widget_title_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-widgets-bar .widget-title',
		'property' => 'border-color',
	),
);

/**
 * ====================================================
 * Footer > Bottom Bar
 * ====================================================
 */

$add['footer_bottom_bar_merged_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-bottom-bar.cakecious-section-merged',
		'property' => 'margin-top',
	),
);

$add['footer_bottom_bar_container'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-footer-bottom-bar',
		'pattern'  => 'cakecious-section-$',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['footer_bottom_bar_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-footer-bottom-bar-inner', // scss: footer
			'property' => 'padding',
			'media'    => $media,
		),
	);
}
$add['footer_bottom_bar_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-bottom-bar-inner', // scss: footer
		'property' => 'border-width',
	),
);
$add['footer_bottom_bar_items_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-bottom-bar-row', // scss: footer
		'property' => 'margin',
		'pattern'  => '0 -$',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-bottom-bar .cakecious-footer-column > *', // scss: footer
		'property' => 'padding',
		'pattern'  => '0 $',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-menu ul li', // scss: footer
		'property' => 'padding',
		'pattern'  => '0 $',
	),
);

foreach ( array( 'font_family', 'font_weight', 'font_style', 'text_transform', 'font_size', 'line_height', 'letter_spacing' ) as $prop ) {
	$element = '.cakecious-footer-bottom-bar';
	$property = str_replace( '_', '-', $prop );

	$add['footer_bottom_bar_' . $prop ] = array(
		array(
			'type'     => 'font_family' === $prop ? 'font' : 'css',
			'element'  => $element,
			'property' => $property,
		),
	);

	if ( in_array( $prop, array( 'font_size', 'line_height', 'letter_spacing' ) ) ) {
		$add['footer_bottom_bar_' . $prop . '__tablet'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 1023px)',
			),
		);
		$add['footer_bottom_bar_' . $prop . '__mobile'] = array(
			array(
				'type'     => 'css',
				'element'  => $element,
				'property' => $property,
				'media'    => '@media screen and (max-width: 499px)',
			),
		);
	}
}

$add['footer_bottom_bar_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-bottom-bar-inner', // scss: footer
		'property' => 'background-color',
	),
);
$add['footer_bottom_bar_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-bottom-bar-inner',
		'property' => 'border-color',
	),
);
$add['footer_bottom_bar_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-bottom-bar',
		'property' => 'color',
	),
);
$add['footer_bottom_bar_link_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-bottom-bar a:not(.button)',
		'property' => 'color',
	),
);
$add['footer_bottom_bar_link_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-footer-bottom-bar a:not(.button):hover, .cakecious-footer-bottom-bar a:not(.button):focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Footer > Social
 * ====================================================
 */

// Social links
$add['footer_social_links_target'] = array(
	array(
		'type'     => 'html',
		'element'  => '.cakecious-footer-social-links a',
		'property' => 'target',
		'pattern'  => '_$',
	),
);

/**
 * ====================================================
 * Footer > Scroll To Top
 * ====================================================
 */

$add['scroll_to_top_display'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-scroll-to-top',
		'pattern'  => 'cakecious-scroll-to-top-display-$',
	),
);
$add['scroll_to_top_position'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-scroll-to-top',
		'pattern'  => 'cakecious-scroll-to-top-position-$',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['scroll_to_top_h_offset' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-scroll-to-top',
			'property' => 'margin-left',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.cakecious-scroll-to-top',
			'property' => 'margin-right',
			'media'    => $media,
		),
	);

	$add['scroll_to_top_v_offset' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-scroll-to-top',
			'property' => 'margin-bottom',
			'media'    => $media,
		),
	);

	$add['scroll_to_top_icon_size' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-scroll-to-top',
			'property' => 'font-size',
			'media'    => $media,
		),
	);

	$add['scroll_to_top_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-scroll-to-top',
			'property' => 'padding',
			'media'    => $media,
		),
	);

	$add['scroll_to_top_border_radius' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.cakecious-scroll-to-top',
			'property' => 'border-radius',
			'media'    => $media,
		),
	);
}

$add['scroll_to_top_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-scroll-to-top',
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-scroll-to-top:hover, .cakecious-scroll-to-top:focus',
		'property' => 'background-color',
	),
);
$add['scroll_to_top_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-scroll-to-top',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-scroll-to-top:hover, .cakecious-scroll-to-top:focus',
		'property' => 'color',
	),
);
$add['scroll_to_top_hover_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-scroll-to-top:hover, .cakecious-scroll-to-top:focus',
		'property' => 'background-color',
	),
);
$add['scroll_to_top_hover_text_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-scroll-to-top:hover, .cakecious-scroll-to-top:focus',
		'property' => 'color',
	),
);

/**
 * ====================================================
 * Blog > Posts Archive Page
 * ====================================================
 */

$add['post_archive_content_header_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => 'body.archive .content-header',
		'pattern'  => 'cakecious-text-align-$',
	),
);

/**
 * ====================================================
 * Blog > Post Layout: Default
 * ====================================================
 */

$add['blog_index_default_items_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-loop-default .entry', // scss: entry
		'property' => 'margin-bottom',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['entry_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default .entry-wrapper',
			'property' => 'padding',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding:first-child',
			'property' => 'margin-top',
			'pattern'  => '-$ !important',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 0 ), // 1st part = top
			),
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
			'property' => 'margin-right',
			'pattern'  => '-$ !important',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 1 ), // 2nd part = right
			),
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-default .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
			'property' => 'margin-left',
			'pattern'  => '-$ !important',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 3 ), // 4rd part = left
			),
			'media'    => $media,
		),
	);
}
$add['entry_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-default .entry-wrapper',
		'property' => 'border-width',
	),
);
$add['entry_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-default .entry-wrapper',
		'property' => 'border-radius',
	),
);

$add['entry_header_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-layout-default .entry-header',
		'pattern'  => 'cakecious-text-align-$',
	),
);

$add['entry_footer_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-layout-default .entry-footer',
		'pattern'  => 'cakecious-text-align-$',
	),
);

$add['entry_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-default .entry-wrapper',
		'property' => 'background-color',
	),
);

$add['entry_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-default .entry-wrapper',
		'property' => 'border-color',
	),
);

$add['entry_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-default .entry-wrapper',
		'property' => 'box-shadow',
	),
);

/**
 * ====================================================
 * Blog > Post Layout: Grid
 * ====================================================
 */

$add['blog_index_grid_columns'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-loop-grid',
		'pattern'  => 'cakecious-loop-grid-$-columns',
	),
);
$add['blog_index_grid_rows_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-loop-grid', // scss: entry
		'property' => 'margin-top',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-loop-grid', // scss: entry
		'property' => 'margin-bottom',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-loop-grid > .entry', // scss: entry
		'property' => 'padding-top',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-loop-grid > .entry', // scss: entry
		'property' => 'padding-bottom',
	),
);
$add['blog_index_grid_columns_gutter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-loop-grid', // scss: entry
		'property' => 'margin-left',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-loop-grid', // scss: entry
		'property' => 'margin-right',
		'pattern'  => '-$',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-loop-grid > .entry', // scss: entry
		'property' => 'padding-left',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-loop-grid > .entry', // scss: entry
		'property' => 'padding-right',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['entry_grid_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid .entry-wrapper',
			'property' => 'padding',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding:first-child',
			'property' => 'margin-top',
			'pattern'  => '-$ !important',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 0 ), // 1st part = top
			),
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
			'property' => 'margin-right',
			'pattern'  => '-$ !important',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 1 ), // 2nd part = right
			),
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-grid .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
			'property' => 'margin-left',
			'pattern'  => '-$ !important',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 3 ), // 4rd part = left
			),
			'media'    => $media,
		),
	);
}
$add['entry_grid_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-wrapper',
		'property' => 'border-width',
	),
);
$add['entry_grid_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-wrapper',
		'property' => 'border-radius',
	),
);

$add['entry_grid_header_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-layout-grid .entry-header',
		'pattern'  => 'cakecious-text-align-$',
	),
);

$add['entry_grid_footer_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-layout-grid .entry-footer',
		'pattern'  => 'cakecious-text-align-$',
	),
);

$add['entry_grid_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-wrapper',
		'property' => 'background-color',
	),
);

$add['entry_grid_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-wrapper',
		'property' => 'border-color',
	),
);

$add['entry_grid_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-grid .entry-wrapper',
		'property' => 'box-shadow',
	),
);

/**
 * ====================================================
 * Blog > Single Post Page
 * ====================================================
 */

$add['post_single_content_header_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-single .entry-header',
		'pattern'  => 'cakecious-text-align-$',
	),
);

$add['post_single_content_footer_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-single .entry-footer',
		'pattern'  => 'cakecious-text-align-$',
	),
);

/**
 * ====================================================
 * Other Pages > Static Page
 * ====================================================
 */

$add['page_single_content_header_alignment'] = array(
	array(
		'type'     => 'class',
		'element'  => '.entry-page .entry-header',
		'pattern'  => 'cakecious-text-align-$',
	),
);




/* Adding cakecious color customisations */
$add['cakecious_accent_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.site-content a:not(.pink_btn), .about-section .about-text .about-btn:after,.blog-page-area-section .blog-post-thumbnail-text .blog-featured-post .post-featured-link a,.comment-author a:focus,.comment-author a:hover,.comment-body .reply a:focus,.comment-body .reply a:hover,.comment-metadata a:focus,.comment-metadata a:hover,.consaltation-section .consaltation-content .consaltation-icon i,.consaltation-section .consaltation-content .consaltation-text span,.contact-page-section .contact-form-text .el-contact-info .contact-address .contact-icon,.contact-page-section .contact-form-text .el-contact-info .contact-address .contact-text p a:hover,.driven-solution-section .driven-text .about-btn a:after,.el-mobile_menu_button,.cakecious-footer-section .widget table caption,.cakecious-footer-section .widget table td,.cakecious-footer-section .widget table td a,.cakecious-footer-section .widget table td a:hover,.cakecious-footer-section .widget table th a,.cakecious-footer-section .widget table th a:hover,.cakecious-footer-section .widget table tr,.cakecious-footer-widgets-bar-inner .widget a:hover,.cakecious-footer-widgets-bar-inner .widget_archive ul li a:hover,.cakecious-footer-widgets-bar-inner .widget_calendar table caption,.cakecious-footer-widgets-bar-inner .widget_calendar table td a,.cakecious-footer-widgets-bar-inner .widget_calendar table td a:hover,.cakecious-footer-widgets-bar-inner .widget_calendar table th a,.cakecious-footer-widgets-bar-inner .widget_calendar table th a:hover,.cakecious-footer-widgets-bar-inner .widget_categories>ul>li a:hover,.cakecious-footer-widgets-bar-inner .widget_meta ul li a:hover,.cakecious-footer-widgets-bar-inner .widget_nav_menu ul li a:hover,.cakecious-footer-widgets-bar-inner .widget_pages>ul>li a:hover,.cakecious-footer-widgets-bar-inner .widget_recent_comments ul li a:hover,.cakecious-footer-widgets-bar-inner .widget_recent_entries ul li a:hover,.cakecious-footer-widgets-bar-inner ul a:hover,.cakecious-header-section .cakecious-toggle:focus,.cakecious-header-section .cakecious-toggle:hover,.cakecious-header-section .menu>.menu-item .sub-menu .cakecious-toggle:focus,.cakecious-header-section .menu>.menu-item .sub-menu .cakecious-toggle:hover,.cakecious-header-section .menu>.menu-item .sub-menu a:not(.button):focus,.cakecious-header-section .menu>.menu-item .sub-menu a:not(.button):hover,.cakecious-header-section a:not(.button):focus,.cakecious-header-section a:not(.button):hover,.cakecious-header-section-vertical .cakecious-toggle:focus,.cakecious-header-section-vertical .cakecious-toggle:hover,.cakecious-header-section-vertical a:not(.button):focus,.cakecious-header-section-vertical a:not(.button):hover,.entry-author-name a:focus,.entry-author-name a:hover,.entry-meta a:focus,.entry-meta a:hover,.feature-style-two .features-call-action .feature-call-content h3 span,.footer-contact-info .footer-icon-text-contact-info p i,.footer-widget-item .footer-menu-widget li a:hover,.h1 a:focus,.h1 a:hover,.h2 a:focus,.h2 a:hover,.h3 a:focus,.h3 a:hover,.h4 a:focus,.h4 a:hover,.h5 a:focus,.h5 a:hover,.h6 a:focus,.h6 a:hover,.has-cakecious-color-3-color,.header_style_two .header-qoute-btn i,.mobile-contact-info li i,.nav-links a:focus,.nav-links a:hover,.navigation .nav-links a,.navigation .nav-links a:focus,.navigation .nav-links a:hover,.newsletter-section .newsletter-content .newsletter-icon i,.page-links a.post-page-numbers:hover,.project-section .project-filter-btn .filter-button.is-checked,.service-details-section .service-single-content .service-details-list li:before,.sidebar .widget a:hover,.sidebar .widget_calendar table caption,.sidebar .widget_calendar table td a,.sidebar .widget_calendar table td a:hover,.sidebar .widget_calendar table th a,.sidebar .widget_calendar table th a:hover,.sidebar .widget_recent_entries ul li a:hover,.tagcloud a:focus,.tagcloud a:hover,.widget .post-date a:focus,.widget .post-date a:hover,.widget .rss-date a:focus,.widget .rss-date a:hover,.widget-area .widget table caption,.widget-area .widget table td,.widget-area .widget table td a,.widget-area .widget table td a:hover,.widget-area .widget table th a,.widget-area .widget table th a:hover,.widget-area .widget table tr,button.cakecious-toggle,h1 a:focus,h1 a:hover,h2 a:focus,h2 a:hover,h3 a:focus,h3 a:hover,h4 a:focus,h4 a:hover,h5 a:focus,h5 a:hover,h6 a:focus,h6 a:hover,table th a:focus,table th a:hover, input[type=button]:hover, input[type=submit]:hover, .comment-respond form .order_s_btn:hover, .main_menu_two .navbar.navbar-expand-lg .navbar-nav li:hover a, .main_menu_two .navbar.navbar-expand-lg .navbar-nav li.active a, .woocommerce nav.woocommerce-pagination ul li a, .cakecious-header-main-bar .cakecious-header-html-2 .media .d-flex i, .middle_menu_three .navbar.navbar-expand-lg .navbar-nav li:hover a, .middle_menu_three .navbar.navbar-expand-lg .navbar-nav li.active a, .box_menu_four .navbar.navbar-expand-lg .navbar-nav li:hover a, .box_menu_four .navbar.navbar-expand-lg .navbar-nav li.active a, .pest_w_btn:hover, .w_view_btn:hover, .pink_cake_feature .cake_feature_inner .title_view_all .float-right .pest_btn:hover, .service_m_item .service_text h4:hover, .cat-links a, .tags-links a, .tt_prev_post, .tt_next_post, .logged-in-as a, .special_item_inner .specail_item .s_item_left .list_style li:hover a, .chef_item h4:hover, .l_news_item .l_news_text h4:hover, .blog_item .blog_text .blog_time .float-left a, .blog_item .blog_text .blog_time .float-right .list_style li:hover a, .blog_item .blog_text h4:hover, .right_sidebar_area .widget ul li a:hover, .recent_widget .recent_w_inner .media .media-body h4:hover, .single_element_text p a, .s_comment_list .s_comment_list_inner .media .media-body .date_rep a:last-child, .modal-message .modal-dialog .modal-content .modal-header h2,  .portfolio_item .portfolio_text h4:hover, .coming_soon_counter .counter-item, .p_catgories_widget .list_style li:hover a, .p_sale_widget .media .media-body h4:hover, .billing_details_area .return_option h4 a, .order_box_price .payment_list .accordion_area .card .card-header h5 a, .f_about_widget .nav li:hover a, .f_widget ul li a:hover, .footer_copyright .copyright_inner .float-right a, .woocommerce .star-rating span::before, .woocommerce .star-rating::before, .woocommerce div.product p.price, .woocommerce div.product span.price, .product_meta a:hover, .site-main .stars a, .woocommerce-message::before, a.showcoupon, .woocommerce table.shop_table td.product-name a:hover, .breadcrumb-area .trail-item a span, .breadcrumb-area .trail-item:before, .input-group-btn:hover:before,
.main_menu_area .navbar.navbar-expand-lg .navbar-nav li:hover a, .main_menu_area .navbar.navbar-expand-lg .navbar-nav li.active a, .woocommerce .product_list_widget li .product-title:hover, .widget h2.widgettitle,.discover_item_inner .discover_item p span',
		'property' => 'color',
	),
	array(
		'type'     => 'css',
		'element'  => '::selection, button, input[type="button"], input[type="reset"], input[type="submit"], .button, a.button, a.wp-block-button__link, .has-cakecious-color-3-background-color, .cakecious-header-shopping-cart .shopping-cart-count, .cakecious-scroll-to-top, .widget-area .widget table th,
.cakecious-footer-section .widget table th, .sidebar .widget_tag_cloud a:hover, .cakecious-footer-widgets-bar-inner .widget_tag_cloud a:hover, .sidebar .widget_calendar table th, .cakecious-footer-widgets-bar-inner .widget_calendar table th, .cakecious-header-mobile-vertical-bar.cakecious-popup-content ul.menu ul.sub-menu ul.sub-menu li:before, .cakecious-header-main-bar .menu li .sub-menu li:hover a.cakecious-menu-item-link, input[type=button], input[type=submit], .top_header_area, .main_menu_area .navbar.navbar-expand-lg .navbar-nav li a:before,
  .pink_btn, .pest_w_btn:before, .w_view_btn:before, .pink_more, .main_slider_area .rev_slider ul li .slider_text_box .main_btn:hover, .main_slider_area .rev_slider ul li .slider_text_box .now_btn:hover, .cake_feature_slider .cake_feature_slider .owl-prev:hover, .cake_feature_slider .cake_feature_slider .owl-next:hover, .pink_cake_feature, .pink_cake_feature .cake_feature_inner .title_view_all .float-right .pest_btn:before, .faq_form_area .faq_left_form .contact_us_form .form-group .pest_btn, .service_area, .service_we_offer_area, .arivals_slider .owl-dots .owl-dot, .client_says_slider .client_says_slider .owl-prev:hover, .client_says_slider .client_says_slider .owl-next:hover, .testimonials_item_area.din_mod .testi_item_inner .media, .blog_pagination .pagination .page-numbers:hover, .blog_pagination .pagination .page-numbers.current, .comment-respond form .order_s_btn, .newsletter_area, .newsletter_area.gray_bg .newsletter_inner .newsletter_form .input-group #mc-embedded-subscribe, .newsletter_area.gray_bg .newsletter_inner .newsletter_form .input-group .input-group-append button, .contact_us_form .form-group .order_s_btn, .portfolio_filter ul li a:before, .c-search-form .input-group .input-group-addon button, .c-search-form .input-group .input-group-addon button:hover, .c-search-form .input-group .input-group-addon button:focus, .product_pagination .left_btn a:hover, .product_pagination .middle_list .pagination li:hover a, .product_pagination .middle_list .pagination li.active a, .product_pagination .right_btn a:hover, .product_tab_area .nav.nav-tabs a, .product_tab_area .nav.nav-tabs a:before, .f_title h3:before, .woocommerce.single-product span.onsale, .woocommerce div.product form.cart .button, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .woocommerce #respond input#submit, .woocommerce-message a.button, .woocommerce a.button, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled], .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce-column__title:after, .woocommerce-order-details__title:after, woocommerce-checkout h1.page-title2:after, .woocommerce-checkout .woocommerce h3:after, .woocommerce #payment #place_order, .woocommerce-page #payment #place_order, #searchform .btn-primary:hover, .woocommerce span.onsale, .scrollup, .main_menu_area .navbar.navbar-expand-lg .navbar-nav li.submenu .dropdown-menu li:hover a, .main_menu_area .navbar.navbar-expand-lg .navbar-nav li.submenu .dropdown-menu .submenu .dropdown-menu li:hover a,  .main_menu_two .navbar.navbar-expand-lg .navbar-nav li.submenu .dropdown-menu li:hover a, .main_menu_two .navbar.navbar-expand-lg .navbar-nav li.submenu .submenu .dropdown-menu li:hover a, .middle_menu_three .navbar.navbar-expand-lg .navbar-nav li.submenu .dropdown-menu li:hover a, .middle_menu_three .navbar.navbar-expand-lg .navbar-nav li.submenu .submenu .dropdown-menu li:hover a, .box_menu_four .navbar.navbar-expand-lg .navbar-nav li.submenu .dropdown-menu li:hover a, .box_menu_four .navbar.navbar-expand-lg .navbar-nav li.submenu .submenu .dropdown-menu li:hover a',
		'property' => 'background-color',
	),
	array(
		'type'     => 'css',
		'element'  => 'button, input[type="button"],input[type="reset"],input[type="submit"],.button,a.button,a.wp-block-button__link,input:not([type]):focus,input[type=""]:focus,input[type="text"]:focus, input[type="password"]:focus,input[type="color"]:focus,input[type="date"]:focus,input[type="datetime-local"]:focus,input[type="email"]:focus,
input[type="month"]:focus,input[type="number"]:focus,input[type="search"]:focus,input[type="tel"]:focus,input[type="time"]:focus,input[type="url"]:focus,input[type="week"]:focus,.input:focus,textarea:focus,select:focus, .cakecious-scroll-to-top , .page-links a.post-page-numbers:hover, .sidebar .widget_tag_cloud a:hover,
.cakecious-footer-widgets-bar-inner .widget_tag_cloud a:hover, .form-control:focus, .cakecious-header-mobile-vertical-bar.cakecious-popup-content ul.menu > li.menu-item .cakecious-icon:hover, .nav-next a, .nav-previous a, .consaltation-section .consaltation-content .consalt-btn a:hover, .blog-sidebar-widget .popular-tag-widget li a:hover, .blog-details-text-content .blog-category-tag a:hover, .mobile-search .form-item input, input[type=button], input[type=submit], .top_header_area:before, .cake_feature_slider .cake_feature_slider .owl-prev:hover, .cake_feature_slider .cake_feature_slider .owl-next:hover, .client_says_slider .client_says_slider .owl-prev:hover, .client_says_slider .client_says_slider .owl-next:hover, .blog_pagination .pagination .page-numbers:hover, .blog_pagination .pagination .page-numbers.current , .coming_soon_counter .counter-item, .product_pagination .left_btn a:hover, .product_pagination .middle_list .pagination li:hover a, .product_pagination .middle_list .pagination li.active a, .product_pagination .right_btn a:hover, .product_tab_area .nav.nav-tabs a, .f_about_widget .nav li:hover a, .woocommerce div.product .woocommerce-tabs ul.tabs li a,.woocommerce #review_form #respond textarea:focus, .woocommerce-billing-fields input.input-text:focus, .woocommerce-billing-fields .select2-selection.select2-selection--single:focus, .woocommerce form .woocommerce-additional-fields textarea:focus, #searchform .form-control:focus, #searchform .btn-primary:hover, .tt-object',
		'property' => 'border-color',
	),
	array(
		'type'     => 'css',
		'element'  => '.features-icon-text .features-icon svg, .feature-style-two .feature-slide-icon-text:hover .feature-slide-icon svg, .cakecious-info-section .cakecious-info-icon-text .cakecious-info-icon svg',
		'property' => 'fill',
	),
);


$add['cakecious_secondary_color_lighter'] = array(
	array(
		'type'     => 'css',
		'element'  => '.cakecious-header-social li, .top_info_menu li:after, .footer-copyright-text .copyright-menu a:after',
		'property' => 'background-color',
	),
);


return $add;