<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<?php if ( cakecious_is_fresh_install() ) {

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">

		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php
		/**
		 * Hook: wp_body_open
		 */
		wp_body_open();

		/**
		 * Hook: cakecious/frontend/before_canvas
		 *
		 * @hooked cakecious_skip_to_content_link - 1
		 * @hooked cakecious_mobile_vertical_header - 10
		 */
		do_action( 'cakecious/frontend/before_canvas' );
		?>

		<div id="canvas" class="cakecious-canvas">
			<div id="page" class="site">

				<?php
				/**
				 * Hook: cakecious/frontend/before_header
				 */
				do_action( 'cakecious/frontend/before_header' );

				/**
				 * Header
				 */
				cakecious_header();

				/**
				 * Hook: cakecious/frontend/after_header
				 */
				do_action( 'cakecious/frontend/after_header' );

				/**
				 * Content
				 */
				if ( apply_filters( 'cakecious/frontend/show_content_wrapper', true ) ) {
					/**
					 * Hero Section
					 */
					if ( intval( cakecious_get_current_page_setting( 'hero' ) ) ) {
						cakecious_hero();
					}

					/**
					 * Content Section - opening tag
					 */
					cakecious_content_open();
				}
?>
<?php } else { ?>

<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-title" content="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if( function_exists('cakecious_tt_preloader')) echo cakecious_tt_preloader(); ?>

<?php

	$hdr_type = cakecious_get_hdr_type();
	// load appropriate header template
	if( empty($hdr_type) || $hdr_type == 'default' )      get_template_part( 'templates/header1' );
	if( $hdr_type == 'header2' )                          get_template_part( 'templates/header2' );
	if( $hdr_type == 'header3' )                          get_template_part( 'templates/header3' );
	if( $hdr_type == 'header4' )                          get_template_part( 'templates/header4' );
	if( $hdr_type == 'header5' )                          get_template_part( 'templates/header5' );


}