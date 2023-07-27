<?php
/**
 * Customizer default values.
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$colors = cakecious_get_default_colors();

$add = array();

/**
 * ====================================================
 * Blog > Related Posts
 * ====================================================
 */

$add['blog_related_posts_query'] = 'category';
$add['blog_related_posts_order'] = 'date|DESC';
$add['blog_related_posts_per_page'] = 3;
$add['blog_related_posts_cache_duration'] = 6;

$add['blog_related_posts_position'] = 'after-content';
$add['blog_related_posts_columns'] = 3;

$add['blog_related_posts_heading_text'] = esc_html__( 'Related Posts', 'cakecious-features' );

$add['blog_related_posts_thumbnail_display'] = 'top';
$add['blog_related_posts_thumbnail_size'] = 'medium';

$add['blog_related_posts_meta_display'] = 'date';

return $add;