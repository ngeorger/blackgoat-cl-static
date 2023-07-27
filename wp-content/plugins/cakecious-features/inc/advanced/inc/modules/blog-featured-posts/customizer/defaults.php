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
 * Blog > Featured Posts
 * ====================================================
 */

$add['blog_featured_posts_exclude_on_main_query'] = 1;

$add['blog_featured_posts_layout'] = 'slider';
$add['blog_featured_posts_position'] = 'before-primary-and-sidebar';
$add['blog_featured_posts_bottom_margin'] = '80px';

$add['blog_featured_posts_per_page'] = '6';

$add['blog_featured_posts_autoplay_delay'] = '3';

$add['blog_featured_posts_slider_height'] = '500px';

$add['blog_featured_posts_carousel_columns'] = 3;
$add['blog_featured_posts_carousel_columns__tablet'] = 2;
$add['blog_featured_posts_carousel_columns__mobile'] = 1;
$add['blog_featured_posts_carousel_height'] = '300px';

$add['blog_featured_posts_grid_height'] = '500px';
$add['blog_featured_posts_grid_height__tablet'] = '600px';
$add['blog_featured_posts_grid_height__mobile'] = '700px';

$add['blog_featured_posts_items_gutter'] = '5px';

$add['blog_featured_posts_image_link'] = 0;
$add['blog_featured_posts_meta_1'] = 'categories';
$add['blog_featured_posts_meta_2'] = 'date';

$add['blog_featured_posts_content_alignment'] = 'center';

$add['blog_featured_posts_overlay_bg_color'] = 'rgba(0,0,0,0)';
$add['blog_featured_posts_content_bg_mode'] = 'gradient';
$add['blog_featured_posts_content_bg_color'] = 'rgba(0,0,0,0.4)';

$add['blog_featured_posts_title_text_color'] = '';
$add['blog_featured_posts_title_hover_text_color'] = '';

$add['blog_featured_posts_meta_1_text_color'] = '';
$add['blog_featured_posts_meta_1_hover_text_color'] = '';
$add['blog_featured_posts_meta_2_text_color'] = '';
$add['blog_featured_posts_meta_2_hover_text_color'] = '';

$add['blog_featured_posts_nav_bg_color'] = '';
$add['blog_featured_posts_nav_icon_color'] = '';

return $add;