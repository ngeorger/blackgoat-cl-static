<?php
/**
 * Set the content width based on the theme's design and stylesheet.
 * @package cakecious
 */
if ( ! isset( $content_width ) ) {
	$content_width = 1140; /* pixels */
}

if ( ! function_exists( 'cakecious_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function cakecious_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on cakecious, use a find and replace
	 * to change 'cakecious' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'cakecious', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary-menu' => esc_html__( 'Primary Menu', 'cakecious' ),
	) );
	register_nav_menus( array(
		'left-menu' => esc_html__( 'Left Menu', 'cakecious' ),
	) );
	register_nav_menus( array(
		'right-menu' => esc_html__( 'Right Menu', 'cakecious' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );
    
	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_theme_support('editor-styles');
	add_editor_style( array( 'assets/css/editor-style.css', cakecious_tt_g_fonts() ) );
	add_theme_support( 'wp-block-styles' );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'cakecious_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
    add_image_size( 'cakecious-postsmall', 370, 200, true );
    add_image_size( 'cakecious-bloggrid', 570, 360, true );


}
endif; // cakecious_setup

add_action( 'after_setup_theme', 'cakecious_setup' );

