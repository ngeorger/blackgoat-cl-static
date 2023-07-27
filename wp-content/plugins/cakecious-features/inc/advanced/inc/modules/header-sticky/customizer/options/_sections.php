<?php
/**
 * Customizer sections
 *
 * @package Cakecious Pro
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$panel = 'cakecious_panel_header';

// ------
$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_header_advanced', array(
	'title'       => esc_html__( 'Advanced', 'cakecious-features' ),
	'panel'       => $panel,
	'priority'    => 40,
) ) );

$switcher = '
<div class="cakecious-responsive-switcher nav-tab-wrapper wp-clearfix">
	<a href="#" class="nav-tab preview-desktop cakecious-responsive-switcher-button" data-device="desktop">
		<span class="dashicons dashicons-desktop"></span>
		<span>' . esc_html__( 'Desktop', 'cakecious-features' ) . '</span>
	</a>
	<a href="#" class="nav-tab preview-tablet preview-mobile cakecious-responsive-switcher-button" data-device="tablet">
		<span class="dashicons dashicons-smartphone"></span>
		<span>' . esc_html__( 'Tablet / Mobile', 'cakecious-features' ) . '</span>
	</a>
</div>
';

// Sticky Header
$wp_customize->add_section( 'cakecious_section_header_sticky', array(
	'title'       => esc_html__( 'Sticky Header', 'cakecious-features' ),
	'description' => $switcher,
	'panel'       => $panel,
	'priority'    => 42,
) );