<?php
/**
 * Customizer sections
 *
 * @package Cakecious
 **/

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( cakecious_show_pro_teaser() ) {
	// Cakecious Pro link
	$wp_customize->add_section( new Cakecious_Customize_Section_Pro_Link( $wp_customize, 'cakecious_section_pro_link', array(
		'title'       => esc_html_x( 'More Options Available in Cakecious Pro', 'Cakecious Pro upsell', 'cakecious' ),
		'url'         => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ),
		'priority'    => 9999,
	) ) );
}

// ------
$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_global', array(
	'title'       => esc_html__( 'Global', 'cakecious' ),
	'priority'    => 0,
) ) );

// Typography & Colors
$panel = 'cakecious_panel_general_styles';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Typography & Colors', 'cakecious' ),
	'priority'    => 121,
) );

	// Base
	$wp_customize->add_section( 'cakecious_section_base', array(
		'title'       => esc_html__( 'Base', 'cakecious' ),
		'description' => '<p>' . esc_html__( 'The global settings of body typography and colors.', 'cakecious' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Headings (H1 - H4)
	$wp_customize->add_section( 'cakecious_section_headings', array(
		'title'       => esc_html__( 'Headings (H1 - H4)', 'cakecious' ),
		'description' => '<p>' . esc_html__( 'Used on all H1 - H4 tags globally.', 'cakecious' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Blockquote
	$wp_customize->add_section( 'cakecious_section_blockquote', array(
		'title'       => esc_html__( 'Blockquote', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Form Input
	$wp_customize->add_section( 'cakecious_section_form_input', array(
		'title'       => esc_html__( 'Form Input', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Button
	$wp_customize->add_section( 'cakecious_section_button', array(
		'title'       => esc_html__( 'Button', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Title
	$wp_customize->add_section( 'cakecious_section_title', array(
		'title'       => esc_html__( 'Title', 'cakecious' ),
		'description' => '<p>' . esc_html__( 'Used on Default Post title and Static Page title. By default, it uses H1 styles.', 'cakecious' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Small Title
	$wp_customize->add_section( 'cakecious_section_small_title', array(
		'title'       => esc_html__( 'Small Title', 'cakecious' ),
		'description' => '<p>' . esc_html__( 'Used on Grid Post title, and other subsidiary headings like "Leave a Reply", "2 Comments", etc. By default, it uses H3 styles.', 'cakecious' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Meta Info
	$wp_customize->add_section( 'cakecious_section_meta', array(
		'title'       => esc_html__( 'Meta Info', 'cakecious' ),
		'description' => '<p>' . esc_html__( 'Used on Post meta, Widget meta, Comments meta, and other small info text.', 'cakecious' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 10,
	) );

// Global Modules
$panel = 'cakecious_panel_global_settings';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Global Modules', 'cakecious' ),
	'priority'    => 122,
) );

	// Social
	$wp_customize->add_section( 'cakecious_section_social', array(
		'title'       => esc_html__( 'Social Media Links', 'cakecious' ),
		'description' => '<p>' . esc_html__( 'Please use full URL format with the protocol. For example: "https://" or "mailto:".', 'cakecious' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// Breadcrumb
	$wp_customize->add_section( 'cakecious_section_breadcrumb', array(
		'title'       => esc_html__( 'Breadcrumb', 'cakecious' ),
		'description' => '<p>' . esc_html__( 'Breadcrumb can be enabled on each page\'s Content Header.', 'cakecious' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// Google Fonts
	$wp_customize->add_section( 'cakecious_section_google_fonts', array(
		'title'       => esc_html__( 'Google Fonts', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// Color Palette
	$wp_customize->add_section( 'cakecious_section_color_palette', array(
		'title'       => esc_html__( 'Color Palette', 'cakecious' ),
		'description' => '<p>' . esc_html__( 'Save up to 8 colors that are mostly used on your design, so you easily apply these colors to your design without remembering the color hex codes.', 'cakecious' ) . '</p>',
		'panel'       => $panel,
		'priority'    => 20,
	) );

// ------
$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_layout', array(
	'title'       => esc_html__( 'Layout', 'cakecious' ),
	'priority'    => 130,
) ) );

// Page Canvas & Wrapper
$wp_customize->add_section( 'cakecious_section_page_canvas', array(
	'title'       => esc_html__( 'Page Canvas', 'cakecious' ),
	'priority'    => 131,
) );

// Header
$panel = 'cakecious_panel_header';
$switcher = '
<div class="cakecious-responsive-switcher nav-tab-wrapper wp-clearfix">
	<a href="#" class="nav-tab preview-desktop cakecious-responsive-switcher-button" data-device="desktop">
		<span class="dashicons dashicons-desktop"></span>
		<span>' . esc_html__( 'Desktop', 'cakecious' ) . '</span>
	</a>
	<a href="#" class="nav-tab preview-tablet preview-mobile cakecious-responsive-switcher-button" data-device="tablet">
		<span class="dashicons dashicons-smartphone"></span>
		<span>' . esc_html__( 'Tablet / Mobile', 'cakecious' ) . '</span>
	</a>
</div>
';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Header', 'cakecious' ),
	'description' => $switcher,
	'priority'    => 132,
) );

	// Header Builder
	$wp_customize->add_section( 'cakecious_section_header_builder', array(
		'title'       => esc_html__( 'Header Builder', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// ------
	$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_header_bars', array(
		'title'       => esc_html__( 'Areas', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) ) );

	// Top Bar
	$wp_customize->add_section( 'cakecious_section_header_top_bar', array(
		'title'       => esc_html__( 'Top Bar', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Main Bar
	$wp_customize->add_section( 'cakecious_section_header_main_bar', array(
		'title'       => esc_html__( 'Main Bar', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Bottom Bar
	$wp_customize->add_section( 'cakecious_section_header_bottom_bar', array(
		'title'       => esc_html__( 'Bottom Bar', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Mobile Main Bar
	$wp_customize->add_section( 'cakecious_section_header_mobile_main_bar', array(
		'title'       => esc_html__( 'Mobile Main Bar', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// Mobile Drawer
	$wp_customize->add_section( 'cakecious_section_header_mobile_vertical_bar', array(
		'title'       => esc_html__( 'Mobile Popup', 'cakecious' ),
		'description' => esc_html__( 'This would appear when the "Toggle" element is clicked. Please make sure you have added the "Toggle" element into the Mobile Main Bar.', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// ------
	$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_header_elements', array(
		'title'       => esc_html__( 'Elements', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 30,
	) ) );

	$switcher = '
	<div class="cakecious-responsive-switcher nav-tab-wrapper wp-clearfix">
		<a href="#" class="nav-tab preview-desktop cakecious-responsive-switcher-button" data-device="desktop">
			<span class="dashicons dashicons-desktop"></span>
			<span>' . esc_html__( 'Desktop', 'cakecious' ) . '</span>
		</a>
		<a href="#" class="nav-tab preview-tablet preview-mobile cakecious-responsive-switcher-button" data-device="tablet">
			<span class="dashicons dashicons-smartphone"></span>
			<span>' . esc_html__( 'Tablet / Mobile', 'cakecious' ) . '</span>
		</a>
	</div>
	';

	// Logo
	$wp_customize->add_section( 'cakecious_section_header_logo', array(
		'title'       => esc_html__( 'Logo', 'cakecious' ),
		'description' => $switcher,
		'panel'       => $panel,
		'priority'    => 30,
	) );

	// Menu
	$wp_customize->add_section( 'cakecious_section_header_menu', array(
		'title'       => esc_html__( 'Menu', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 30,
	) );

	// Search
	$wp_customize->add_section( 'cakecious_section_header_search', array(
		'title'       => esc_html__( 'Search', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 30,
	) );

	// HTML
	$wp_customize->add_section( 'cakecious_section_header_html', array(
		'title'       => esc_html__( 'HTML', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 30,
	) );

	// Social
	$wp_customize->add_section( 'cakecious_section_header_social', array(
		'title'       => esc_html__( 'Social', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 30,
	) );

	if ( cakecious_show_pro_teaser() ) {
		// More Options Available
		$wp_customize->add_section( new Cakecious_Customize_Section_Pro_Teaser( $wp_customize, 'cakecious_section_teaser_pro_upsell_header', array(
			'title'       => esc_html_x( 'More Options Available in Cakecious Pro', 'Cakecious Pro upsell', 'cakecious' ),
			'panel'       => $panel,
			'url'         => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ),
			'features'    => array(
				esc_html_x( 'More Header Elements: Button, Contact Info', 'Cakecious Pro upsell', 'cakecious' ),
				esc_html_x( 'Vertical Header', 'Cakecious Pro upsell', 'cakecious' ),
				esc_html_x( 'Transparent Header', 'Cakecious Pro upsell', 'cakecious' ),
				esc_html_x( 'Alternate Header Colors', 'Cakecious Pro upsell', 'cakecious' ),
				esc_html_x( 'Sticky Header', 'Cakecious Pro upsell', 'cakecious' ),
				esc_html_x( 'Mega Menu', 'Cakecious Pro upsell', 'cakecious' ),
			),
			'priority'    => 90,
		) ) );
	}

// Content & Sidebar
$panel = 'cakecious_panel_content';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Content & Sidebar', 'cakecious' ),
	'priority'    => 133,
) );

	// ------
	$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_content_areas', array(
		'title'       => esc_html__( 'Areas', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) ) );

	// Content Section
	$wp_customize->add_section( 'cakecious_section_content', array(
		'title'       => esc_html__( 'Content Section', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

		// Main Content Area
		$wp_customize->add_section( 'cakecious_section_main', array(
			'title'       => esc_html__( 'Main Content', 'cakecious' ),
			'panel'       => $panel,
			'priority'    => 10,
		) );

		// Sidebar Area
		$wp_customize->add_section( 'cakecious_section_sidebar', array(
			'title'       => esc_html__( 'Sidebar', 'cakecious' ),
			'panel'       => $panel,
			'priority'    => 10,
		) );

	// Hero Section
	$wp_customize->add_section( 'cakecious_section_hero', array(
		'title'       => esc_html__( 'Hero Section', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

// Footer
$panel = 'cakecious_panel_footer';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Footer', 'cakecious' ),
	'priority'    => 134,
) );

	// Footer Builder
	$wp_customize->add_section( 'cakecious_section_footer_builder', array(
		'title'       => esc_html__( 'Footer Builder', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// ------
	$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_footer_bars', array(
		'title'       => esc_html__( 'Areas', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) ) );

	// Widgets Bar
	$wp_customize->add_section( 'cakecious_section_footer_widgets_bar', array(
		'title'       => esc_html__( 'Widgets Bar', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// Bottom Bar
	$wp_customize->add_section( 'cakecious_section_footer_bottom_bar', array(
		'title'       => esc_html__( 'Bottom Bar', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 20,
	) );

	// ------
	$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_footer_elements', array(
		'title'       => esc_html__( 'Elements', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 30,
	) ) );

	// Copyright
	$wp_customize->add_section( 'cakecious_section_footer_copyright', array(
		'title'       => esc_html__( 'Copyright', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 30,
	) );

	// HTML
	$wp_customize->add_section( 'cakecious_section_footer_html', array(
		'title'       => esc_html__( 'HTML', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 30,
	) );

	// Social
	$wp_customize->add_section( 'cakecious_section_footer_social', array(
		'title'       => esc_html__( 'Social', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 30,
	) );

	// Scroll To Top
	$wp_customize->add_section( 'cakecious_section_scroll_to_top', array(
		'title'       => esc_html__( 'Scroll To Top', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 39,
	) );

	if ( cakecious_show_pro_teaser() ) {
		// More Options Available
		$wp_customize->add_section( new Cakecious_Customize_Section_Pro_Teaser( $wp_customize, 'cakecious_section_teaser_pro_upsell_footer', array(
			'title'       => esc_html_x( 'More Options Available in Cakecious Pro', 'Cakecious Pro upsell', 'cakecious' ),
			'panel'       => $panel,
			'url'         => esc_url( add_query_arg( array( 'utm_source' => 'cakecious-customizer', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-upsell' ), CAKECIOUS_URL ) ),
			'features'    => array(
				esc_html_x( 'Dynamic & Responsive Widgets Column Width', 'Cakecious Pro upsell', 'cakecious' ),
			),
			'priority'    => 90,
		) ) );
	}

// ------
$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_pages', array(
	'title'       => esc_html__( 'Pages', 'cakecious' ),
	'priority'    => 140,
) ) );

// Blog
$panel = 'cakecious_panel_blog';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Blog', 'cakecious' ),
	'priority'    => 141,
) );

	// ------
	$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_blog_pages', array(
		'title'       => esc_html__( 'Pages', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) ) );

	// Post Index
	$wp_customize->add_section( 'cakecious_section_blog_index', array(
		'title'       => esc_html__( 'Posts Archive Page', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Default
	$wp_customize->add_section( 'cakecious_section_entry_default', array(
		'title'       => esc_html__( 'Default', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Grid
	$wp_customize->add_section( 'cakecious_section_entry_grid', array(
		'title'       => esc_html__( 'Grid', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Single Post Page
	$wp_customize->add_section( 'cakecious_section_blog_single', array(
		'title'       => esc_html__( 'Single Post Page', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 15,
	) );

// Other Pages
$panel = 'cakecious_panel_other_pages';
$wp_customize->add_panel( $panel, array(
	'title'       => esc_html__( 'Other Pages', 'cakecious' ),
	'priority'    => 149,
) );

	// ------
	$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_page_settings_others', array(
		'title'       => esc_html__( 'Standard Pages', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) ) );

	// Static Page
	$wp_customize->add_section( 'cakecious_section_page_single', array(
		'title'       => esc_html__( 'Static Page', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Search Results Page
	$wp_customize->add_section( 'cakecious_section_search_results', array(
		'title'       => esc_html__( 'Search Results Page', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Error 404 Page
	$wp_customize->add_section( 'cakecious_section_error_404', array(
		'title'       => esc_html__( 'Error 404 Page', 'cakecious' ),
		'panel'       => $panel,
		'priority'    => 10,
	) );

	// Begin registering sections.
	$i = 10;
	foreach ( Cakecious_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
		if ( in_array( $ps_type, array( 'post_archive', 'post_single', 'product_archive', 'product_single', 'page_single', 'search', '404' ) ) ) {
			continue;
		}

		// Get post type object.
		// First check if $ps_type is not for 404 and search page.
		$post_type_slug = preg_replace( '/(_single|_archive)/', '', $ps_type );
		$post_type_obj = get_post_type_object( $post_type_slug );

		// Increment section priority.
		$i += 10;

		// Add separator 
		if ( 0 < strpos( $ps_type, '_archive' ) ) {
			$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_page_settings_' . $post_type_slug, array(
				/* translators: %s: Custom post type's plural name. */
				'title'       => $post_type_obj->labels->name,
				'panel'       => $panel,
				'priority'    => $i,
			) ) );
		}

		$description = cakecious_array_value( $ps_data, 'description' );

		$wp_customize->add_section( cakecious_array_value( $ps_data, 'section' ), array(
			'title'       => cakecious_array_value( $ps_data, 'title' ),
			'panel'       => $panel,
			'description' => ! empty( $description ) ? '<p>' . $description . '</p>' : '',
			'priority'    => $i,
		) );
	}

// ------
$wp_customize->add_section( new Cakecious_Customize_Section_Spacer( $wp_customize, 'cakecious_section_spacer_others', array(
	'title'       => esc_html__( 'Others', 'cakecious' ),
	'priority'    => 159,
) ) );

// Site Identity
$wp_customize->get_section( 'title_tagline' )->priority = 160;

// Homepage Settings
$wp_customize->get_section( 'static_front_page' )->priority = 161;