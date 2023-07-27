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
 * Blog > Post Layout: List
 * ====================================================
 */

$add['blog_index_list_items_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-list',
		'property' => 'margin-bottom',
	),
);

$responsive = array(
	''         => '',
	'__tablet' => '@media screen and (max-width: 1023px)',
	'__mobile' => '@media screen and (max-width: 499px)',
);
foreach ( $responsive as $suffix => $media ) {
	$add['entry_list_padding' . $suffix ] = array(
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-list .entry-wrapper',
			'property' => 'padding',
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-list .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
			'property' => 'margin-top',
			'pattern'  => '-$',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 0 ), // 1st part = top
			),
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-list .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
			'property' => 'margin-right',
			'pattern'  => '-$',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 1 ), // 2nd part = right
			),
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-list .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
			'property' => 'margin-bottom',
			'pattern'  => '-$',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 2 ), // 3rd part = bottom
			),
			'media'    => $media,
		),
		array(
			'type'     => 'css',
			'element'  => '.entry-layout-list .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
			'property' => 'margin-left',
			'pattern'  => '-$',
			'function' => array(
				'name' => 'explode_value',
				'args' => array( 3 ), // 4th part = left
			),
			'media'    => $media,
		),
	);

	// if ( '__mobile' === $suffix ) {
	// 	$add['entry_list_padding' . $suffix ][] = array(
	// 		'type'     => 'css',
	// 		'element'  => '.entry-layout-list .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
	// 		'property' => 'margin-left',
	// 		'pattern'  => '-$',
	// 		'function' => array(
	// 			'name' => 'explode_value',
	// 			'args' => array( 3 ), // 4th part = left
	// 		),
	// 		'media'    => $media,
	// 	);
	// 	$add['entry_list_padding' . $suffix ][] = array(
	// 		'type'     => 'css',
	// 		'element'  => '.entry-layout-list .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
	// 		'property' => 'margin-right',
	// 		'pattern'  => '-$',
	// 		'function' => array(
	// 			'name' => 'explode_value',
	// 			'args' => array( 1 ), // 2nd part = right
	// 		),
	// 		'media'    => $media,
	// 	);
	// }
	// else {
	// 	$add['entry_list_padding' . $suffix ][] = array(
	// 		'type'     => 'css',
	// 		'element'  => '.entry-layout-list .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
	// 		'property' => 'margin-bottom',
	// 		'pattern'  => '-$',
	// 		'function' => array(
	// 			'name' => 'explode_value',
	// 			'args' => array( 2 ), // 3rd part = bottom
	// 		),
	// 		'media'    => empty( $media ) ? '' : $media . ' and (min-width: 500px)',
	// 	);
	// 	$add['entry_list_padding' . $suffix ][] = array(
	// 		'type'     => 'css',
	// 		'element'  => '.cakecious-loop-list-thumbnail-position--left .entry-layout-list .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding, .cakecious-loop-list-thumbnail-position--left-alt .entry-layout-list:nth-child(odd) .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding, .cakecious-loop-list-thumbnail-position--right-alt .entry-layout-list:nth-child(even) .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
	// 		'property' => 'margin-left',
	// 		'pattern'  => '-$',
	// 		'function' => array(
	// 			'name' => 'explode_value',
	// 			'args' => array( 3 ), // 4th part = left
	// 		),
	// 		'media'    => empty( $media ) ? '' : $media . ' and (min-width: 500px)',
	// 	);
	// 	$add['entry_list_padding' . $suffix ][] = array(
	// 		'type'     => 'css',
	// 		'element'  => '.cakecious-loop-list-thumbnail-position--right .entry-layout-list .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding, .cakecious-loop-list-thumbnail-position--right-alt .entry-layout-list:nth-child(odd) .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding, .cakecious-loop-list-thumbnail-position--left-alt .entry-layout-list:nth-child(even) .entry-thumbnail.cakecious-entry-thumbnail-ignore-padding',
	// 		'property' => 'margin-right',
	// 		'pattern'  => '-$',
	// 		'function' => array(
	// 			'name' => 'explode_value',
	// 			'args' => array( 1 ), // 2nd part = right
	// 		),
	// 		'media'    => empty( $media ) ? '' : $media . ' and (min-width: 500px)',
	// 	);
	// }
}
$add['entry_list_border'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-list .entry-wrapper',
		'property' => 'border-width',
	),
);
$add['entry_list_border_radius'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-list .entry-wrapper',
		'property' => 'border-radius',
	),
);

$add['entry_list_thumbnail'] = array(
	array(
		'type'     => 'class',
		'element'  => '.cakecious-loop-list',
		'pattern'  => 'cakecious-loop-list-thumbnail-position--$',
	),
);

$add['entry_list_thumbnail_width'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-list .entry-list-media',
		'property' => 'flex-basis',
	),
);
$add['entry_list_thumbnail_gap'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-list .entry-list-media',
		'property' => 'margin-bottom',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-loop-list-thumbnail-position--left .entry-layout-list .entry-list-media, .cakecious-loop-list-thumbnail-position--left-alt .entry-layout-list:nth-child(odd) .entry-list-media, .cakecious-loop-list-thumbnail-position--right-alt .entry-layout-list:nth-child(even) .entry-list-media',
		'property' => 'margin-right',
		'media'    => '@media screen and (min-width: 500px)',
	),
	array(
		'type'     => 'css',
		'element'  => '.cakecious-loop-list-thumbnail-position--right .entry-layout-list .entry-list-media, .cakecious-loop-list-thumbnail-position--right-alt .entry-layout-list:nth-child(odd) .entry-list-media, .cakecious-loop-list-thumbnail-position--left-alt .entry-layout-list:nth-child(even) .entry-list-media',
		'property' => 'margin-left',
		'media'    => '@media screen and (min-width: 500px)',
	),
);

$add['entry_list_bg_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-list .entry-wrapper',
		'property' => 'background-color',
	),
);

$add['entry_list_border_color'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-list .entry-wrapper',
		'property' => 'border-color',
	),
);

$add['entry_list_shadow'] = array(
	array(
		'type'     => 'css',
		'element'  => '.entry-layout-list .entry-wrapper',
		'property' => 'box-shadow',
	),
);

return $add;