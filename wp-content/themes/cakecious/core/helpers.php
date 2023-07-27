<?php
/**
 * Custom helper functions that can be used globally.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ====================================================
 * Helper functions
 * ====================================================
 */

/**
 * Check if specified key exists on an array, then return the value.
 * Otherwise return the specified fallback value, or null if no fallback is specified.
 *
 * @param array $item
 * @param mixed $index
 * @param mixed $fallback
 * @return mixed
 */
function cakecious_array_value( $array, $index, $fallback = null ) {
	if ( ! is_array( $array ) ) {
		return null;
	}

	return isset( $array[ $index ] ) ? $array[ $index ] : $fallback;
}

/**
 * Recursively flatten a multi-dimensional array into a one-dimensional array.
 *
 * @param array @array
 * @return array
 */
function cakecious_flatten_array( $array ) {
	$flattened = array();

	foreach ( $array as $key => $value ) {
		if ( is_array( $value ) ) {
			$flattened = array_merge( $flattened, cakecious_flatten_array( $value ) );
		} else {
			$flattened[ strval( $key ) ] = $value;
		}
	}

	return $flattened;
}

/**
 * Return boolean whether Cakecious Pro is activated.
 *
 * @return boolean
 */
function cakecious_is_pro() {
	return class_exists( 'Cakecious_Pro' );
}

/**
 * Return boolean whether theme should render any kind of Cakecious Pro modules teaser.
 *
 * @return boolean
 */
function cakecious_show_pro_teaser() {
	$show = true;

	// Automatically hide teaser when Cakecious Pro is installed or CAKECIOUS_HIDE_PRO_TEASER constant is set to true.
	if ( ( defined( 'CAKECIOUS_HIDE_PRO_TEASER' ) && CAKECIOUS_HIDE_PRO_TEASER ) || cakecious_is_pro() ) {
		$show = false;
	}

	return apply_filters( 'cakecious/pro/show_teaser', $show );
}

/**
 * Modified version of the original `get_template_part` function.
 * Add filters to allow 3rd party plugins to override the template files.
 *
 * @param string $slug
 * @param string $name
 * @param array $variables
 * @param boolean $echo
 */
function cakecious_get_template_part( $slug, $name = null, $variables = array(), $echo = true ) {
	/**
	 * Get fallback template file name.
	 */

	// Native WordPress action.
	do_action( 'get_template_part_' . $slug, $slug, $name );

	$templates = array();
	if ( isset( $name ) ) {
		$templates[] = $slug . '-' . $name . '.php';
	}

	$templates[] = $slug . '.php';

	// Native WordPress action.
	do_action( 'get_template_part', $slug, $name, $templates );

	/**
	 * Get the final template file path.
	 */

	$template_file_path = false;

	// Iterate through the templates.
	foreach ( $templates as $template ) {
		/**
		 * Child Theme
		 */

		// Check the template file in Child Theme.
		if ( file_exists( get_stylesheet_directory() . '/template-parts/' . $template ) ) {
			$template_file_path = get_stylesheet_directory() . '/template-parts/' . $template;
			break;
		}

		/**
		 * Custom paths
		 */

		// Allow themes or plugins to add their own paths.
		$custom_paths = apply_filters( 'cakecious/frontend/template_dirs', array() );

		// Sort the custom paths by key number.
		// Lower key number = higher priority.
		ksort( $custom_paths );

		// Iterate through the custom paths and use the path if it exists.
		foreach ( $custom_paths as $custom_path ) {
			$temp = trailingslashit( $custom_path ) . $template;

			if ( file_exists( $temp ) ) {
				$template_file_path = $temp;
				break 2; // break from 2 iteration levels, which are the $custom path and $templates.
			}
		}

		/**
		 * Parent Theme
		 */

		// Check the template file in Parent Theme.
		if ( file_exists( get_template_directory() . '/template-parts/' . $template ) ) {
			$template_file_path = get_template_directory() . '/template-parts/' . $template;
			break;
		}

		// Last resort, check the template file in WordPress theme compatibility files (very unlikely to reach here).
		elseif ( file_exists( ABSPATH . WPINC . '/theme-compat/' . $template ) ) {
			$template_file_path = ABSPATH . WPINC . '/theme-compat/' . $template;
			break;
		}
	}

	// Abort if no valid template file found.
	if ( empty( $template_file_path ) ) {
		return;
	}

	/**
	 * Pass custom variables to the template file.
	 */

	foreach ( (array) $variables as $key => $value ) {
		set_query_var( $key, $value );
	}

	/**
	 * Get the template part.
	 */

	ob_start();
	load_template( $template_file_path, false );
	$html = ob_get_clean();

	// Allow filters to modify the HTML markup.
	$html = apply_filters( 'cakecious/template_part/' . $slug . ( ! empty( $name ) ? '-' . $name : '' ), $html );

	/**
	 * Return or print the template part.
	 */

	if ( $echo ) {
		echo do_shortcode($html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return $html;
	}
}

/**
 * Wrapper function to get page setting of specified key.
 *
 * @param string $key
 * @param mixed $default
 * @return array
 */
function cakecious_get_current_page_setting( $key, $default = null ) {
	// Return null if no key specified.
	if ( empty( $key ) ) {
		return null;
	}

	$settings = array();

	// Search page
	if ( is_search() ) {
		$value = cakecious_get_theme_mod( 'search_results_' . $key );
	}

	// Error 404 page
	elseif ( is_404() ) {
		// Set content container and content layout to a fixed value.
		$fixed_settings = array(
			'hero'              => 0,
			'content_container' => 'narrow', // Error 404 page always uses Narrow layout.
			'content_layout'    => 'wide', // Error 404 page always has no sidebar.
		);

		// Use fixed settings if specified key is either "content_container" or "content_layout.
		if ( isset( $fixed_settings[ $key ] ) ) {
			$value = $fixed_settings[ $key ];
		}
		// Otherwise, use the Customizer value.
		else {
			$value = cakecious_get_theme_mod( 'error_404_' . $key );
		}
	}

	// All kind of posts archive pages
	elseif ( is_home() || is_category() || is_tag() || is_date() || is_author() ) {
		$value = cakecious_get_theme_mod( 'post_archive_' . $key );
	}

	// Other post types index page
	elseif ( is_post_type_archive() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			$value = cakecious_get_theme_mod( $obj->name . '_archive_' . $key );
		} else {
			$value = null;
		}
	}
		
	// Custom taxonomy archive pages
	elseif ( is_tax() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			global $wp_taxonomies;

			// Get post type.
			$post_types = $wp_taxonomies[ $obj->taxonomy ]->object_type;
			$post_type = $post_types[0];

			// Get settings on the individual term.
			$individual_settings = wp_parse_args( get_term_meta( $obj->term_id, 'cakecious_page_settings', true ), array() );

			// Use individual settings if option is specified.
			if ( isset( $individual_settings[ $key ] ) ) {
				$value = $individual_settings[ $key ];
			}
			// Otherwise, use the Customizer value.
			else {
				$value = cakecious_get_theme_mod( $post_type . '_archive_' . $key );
			}
		} else {
			$value = null;
		}
	}

	// Single post page (any post type)
	elseif ( is_singular() ) {
		$obj = get_queried_object();

		if ( $obj ) {
			// Get settings on the individual post.
			$individual_settings = wp_parse_args( get_post_meta( $obj->ID, '_cakecious_page_settings', true ), array() );

			// Use individual settings if option is specified.
			if ( isset( $individual_settings[ $key ] ) ) {
				$value = $individual_settings[ $key ];
			}
			// Otherwise, use the Customizer value.
			else {
				$value = cakecious_get_theme_mod( $obj->post_type . '_single_' . $key );
			}
		} else {
			$value = null;
		}
	}

	// If the value is empty, try to use the global value.
	if ( '' === $value || is_null( $value ) ) {
		$value = cakecious_get_theme_mod( $key, $default );
	}

	// Allow developers to modify the value via filters.
	$value = apply_filters( 'cakecious/page_settings/setting_value', $value, $key );
	$value = apply_filters( 'cakecious/page_settings/setting_value/' . $key, $value );

	// Return the final value.
	return $value;
}

/**
 * Wrapper function to get theme info.
 *
 * @param string $key
 * @return string
 */
function cakecious_get_theme_info( $key ) {
	return Cakecious::instance()->get_info( $key );
}

/**
 * Wrapper function to get theme_mod value.
 *
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function cakecious_get_theme_mod( $key, $default = null ) {
	return Cakecious_Customizer::instance()->get_setting_value( $key, $default );
}

/**
 * Minify CSS string.
 * ref: https://github.com/GaryJones/Simple-PHP-CSS-Minification
 * modified:
 * - add: rem to units
 * - add: remove space after (
 * - remove: remove space before (
 *
 * @param array $css
 * @return string
 */
function cakecious_minify_css_string( $css ) {
	// Normalize whitespace
	$css = preg_replace( '/\s+/', ' ', $css );

	// Remove spaces before and after comment
	$css = preg_replace( '/(\s+)(\/\*(.*?)\*\/)(\s+)/', '$2', $css );

	// Remove comment blocks, everything between /* and */, unless
	// preserved with /*! ... */ or /** ... */
	$css = preg_replace( '~/\*(?![\!|\*])(.*?)\*/~', '', $css );

	// Remove ; before }
	$css = preg_replace( '/;(?=\s*})/', '', $css );

	// Remove space after , : ; { } ( */ >
	$css = preg_replace( '/(,|:|;|\{|}|\(|\*\/|>) /', '$1', $css );

	// Remove space before , ; { } ) >
	$css = preg_replace( '/ (,|;|\{|}|\)|>)/', '$1', $css );

	// Strips leading 0 on decimal values (converts 0.5px into .5px)
	$css = preg_replace( '/(:| )0\.([0-9]+)(%|rem|em|ex|px|in|cm|mm|pt|pc)/i', '${1}.${2}${3}', $css );

	// Strips units if value is 0 (converts 0px to 0)
	$css = preg_replace( '/(:| )(\.?)0(%|rem|em|ex|px|in|cm|mm|pt|pc)/i', '${1}0', $css );

	// Converts all zeros value into short-hand
	$css = preg_replace( '/0 0 0 0/', '0', $css );

	// Shortern 6-character hex color codes to 3-character where possible
	$css = preg_replace( '/#([a-f0-9])\\1([a-f0-9])\\2([a-f0-9])\\3/i', '#\1\2\3', $css );

	return trim( $css );
}

/**
 * Build CSS string from array structure.
 *
 * @param array $css_array
 * @param boolean $minify
 * @return string
 */
function cakecious_convert_css_array_to_string( $css_array, $minify = true ) {
	$final_css = '';

	foreach ( $css_array as $media => $selectors ) {
		if ( empty( $selectors ) ) {
			continue;
		}

		// Add media query open tag.
		if ( 'global' !== $media ) {
			$final_css .= $media. '{';
		}

		// Iterate properties.
		foreach ( $selectors as $selector => $properties ) {
			$final_css .= $selector . '{';

			$i = 1;
			foreach ( $properties as $property => $value ) {
				if ( '' === $value ) {
					continue;
				}

				$final_css .= $property . ':' . $value;

				if ( $i !== count( $properties ) ) {
					$final_css .= ';';
				}

				$i++;
			}

			$final_css .= '}';
		}

		// Add media query closing tag.
		if ( 'global' !== $media ) {
			$final_css .= '}';
		}
	}

	if ( $minify ) {
		$final_css = cakecious_minify_css_string( $final_css );
	}

	return $final_css;
}

/**
 * Build Google Fonts embed URL from specified fonts
 *
 * @param array $google_fonts
 * @return string
 */
function cakecious_build_google_fonts_embed_url( $google_fonts = array() ) {
	if ( empty( $google_fonts ) ) {
		return '';
	}

	// Basic embed link.
	$link = ( is_ssl() ? 'https:' : 'http:' ) . '//fonts.googleapis.com/css';
	$args = array();

	// Add font families.
	$families = array();
	foreach ( $google_fonts as $name ) {
		// Add font family and all variants.
		$families[] = str_replace( ' ', '+', $name ) . ':100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i';
	}
	$args['family'] = implode( '|', $families );

	// Add font subsets.
	$subsets = array_merge( array( 'latin' ), cakecious_get_theme_mod( 'google_fonts_subsets', array() ) );
	$args['subset'] = implode( ',', $subsets );

	return esc_attr( add_query_arg( $args, $link ) );
}

/**
 * ====================================================
 * Data set functions
 * ====================================================
 */

/**
 * Return array of module categories.
 * 
 * @return array
 */
function cakecious_get_module_categories() {
	return apply_filters( 'cakecious/module_categories', array(
		'layout'      => esc_html__( 'Layout Modules', 'cakecious' ),
		'assets'      => esc_html__( 'Assets & Branding Modules', 'cakecious' ),
		'blog'        => esc_html__( 'Blog Modules', 'cakecious' ),
		'woocommerce' => esc_html__( 'WooCommerce Integration Modules', 'cakecious' ),
	) );
}

/**
 * Return array of default Cakecious theme modules.
 * 
 * @return array
 */
function cakecious_get_theme_modules() {
	return array(
		'page-container' => array(
			'label'    => esc_html__( 'Page Canvas Layout', 'cakecious' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'cakecious_section_page_container' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'header' => array(
			'label'    => esc_html__( 'Header Layout', 'cakecious' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'cakecious_panel_header' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'hero' => array(
			'label'    => esc_html__( 'Hero Section Layout', 'cakecious' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'cakecious_section_hero' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'content-sidebar' => array(
			'label'    => esc_html__( 'Content & Sidebar Layout', 'cakecious' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'cakecious_panel_content' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'footer' => array(
			'label'    => esc_html__( 'Footer Builder', 'cakecious' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'cakecious_panel_footer' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'page-settings' => array(
			'label'    => esc_html__( 'Dynamic Page Layout', 'cakecious' ),
			'category' => 'layout',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'cakecious_panel_page_settings' ), admin_url( 'customize.php' ) ),
				),
			),
		),

		'color-palette' => array(
			'label'    => esc_html__( 'Color Palette', 'cakecious' ),
			'category' => 'assets',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'cakecious_section_color_palette' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'general-styles' => array(
			'label'    => esc_html__( 'General Typography & Colors', 'cakecious' ),
			'category' => 'assets',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'cakecious_panel_general_styles' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'google-fonts' => array(
			'label'    => esc_html__( 'Google Fonts', 'cakecious' ),
			'category' => 'assets',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'cakecious_section_google_fonts' ), admin_url( 'customize.php' ) ),
				),
			),
		),
		'social-links' => array(
			'label'    => esc_html__( 'Social Links', 'cakecious' ),
			'category' => 'assets',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[section]' => 'cakecious_section_social' ), admin_url( 'customize.php' ) ),
				),
			),
		),

		'blog' => array(
			'label'    => esc_html__( 'Blog Layout Basic', 'cakecious' ),
			'category' => 'blog',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'cakecious_panel_blog' ), admin_url( 'customize.php' ) ),
				),
			),
		),

		'woocommerce' => array(
			'label'    => esc_html__( 'WC Layout Basic', 'cakecious' ),
			'category' => 'woocommerce',
			'actions'  => array(
				'settings' => array(
					'label' => esc_html__( 'Customize', 'cakecious' ),
					'url'   => add_query_arg( array( 'autofocus[panel]' => 'woocommerce' ), admin_url( 'customize.php' ) ),
				),
			),
		),
	);
}

/**
 * Return array of supported Cakecious Pro modules.
 * 
 * @return array
 */
function cakecious_get_pro_modules() {
	$url = add_query_arg( array( 'utm_source' => 'cakecious-dashboard', 'utm_medium' => 'learn-more', 'utm_campaign' => 'theme-pro-modules-list' ), trailingslashit( CAKECIOUS_URL ) );

	return apply_filters( 'cakecious/pro/modules', array(
		'header-elements-plus' => array(
			'label'    => esc_html__( 'Header Elements Plus', 'cakecious' ),
			'category' => 'layout',
		),
		'header-vertical' => array(
			'label'    => esc_html__( 'Vertical Header', 'cakecious' ),
			'category' => 'layout',
		),
		'header-transparent' => array(
			'label'    => esc_html__( 'Transparent Header', 'cakecious' ),
			'category' => 'layout',
		),
		'header-sticky' => array(
			'label'    => esc_html__( 'Sticky Header', 'cakecious' ),
			'category' => 'layout',
		),
		'header-alt-colors' => array(
			'label'    => esc_html__( 'Alternate Header Colors', 'cakecious' ),
			'category' => 'layout',
		),
		'header-mega-menu' => array(
			'label'    => esc_html__( 'Header Mega Menu', 'cakecious' ),
			'category' => 'layout',
		),
		'sidebar-sticky' => array(
			'label'    => esc_html__( 'Sticky Sidebar', 'cakecious' ),
			'category' => 'layout',
		),
		'footer-widgets-columns-width' => array(
			'label'    => esc_html__( 'Footer Widgets Columns Width', 'cakecious' ),
			'category' => 'layout',
		),
		'preloader-screen' => array(
			'label'    => esc_html__( 'Preloader Screen', 'cakecious' ),
			'category' => 'layout',
		),
		'custom-blocks' => array(
			'label'    => esc_html__( 'Custom Blocks (Hooks)', 'cakecious' ),
			'category' => 'layout',
		),

		'custom-fonts' => array(
			'label'    => esc_html__( 'Custom Fonts', 'cakecious' ),
			'category' => 'assets',
		),
		'custom-icons' => array(
			'label'    => esc_html__( 'Custom Icons', 'cakecious' ),
			'category' => 'assets',
		),
		'white-label' => array(
			'label'    => esc_html__( 'White Label', 'cakecious' ),
			'category' => 'assets',
		),

		'woocommerce-layout-plus' => array(
			'label'    => esc_html__( 'WC Layout Plus', 'cakecious' ),
			'category' => 'woocommerce',
		),
		'woocommerce-ajax-add-to-cart' => array(
			'label'    => esc_html__( 'WC AJAX Add To Cart', 'cakecious' ),
			'category' => 'woocommerce',
		),
		'woocommerce-quick-view' => array(
			'label'    => esc_html__( 'WC Quick View', 'cakecious' ),
			'category' => 'woocommerce',
		),
		'woocommerce-off-canvas-filters' => array(
			'label'    => esc_html__( 'WC Off-Canvas Filters', 'cakecious' ),
			'category' => 'woocommerce',
		),
		'woocommerce-checkout-optimization' => array(
			'label'    => esc_html__( 'WC Checkout Optimization', 'cakecious' ),
			'category' => 'woocommerce',
		),

		'blog-layout-plus' => array(
			'label'    => esc_html__( 'Blog Layout Plus', 'cakecious' ),
			'category' => 'blog',
		),
		'blog-featured-posts' => array(
			'label'    => esc_html__( 'Blog Featured Posts', 'cakecious' ),
			'category' => 'blog',
		),
		'blog-related-posts' => array(
			'label'    => esc_html__( 'Blog Related Posts', 'cakecious' ),
			'category' => 'blog',
		),
	) );
}

/**
 * Return list of post types that support Page Settings.
 * 
 * @return array
 */
function cakecious_get_post_types_for_page_settings() {
	$all_supported_post_types = array_merge( array( 'post', 'page' ), cakecious_get_public_custom_post_types() );

	// Allow user to deactivate page settings on some specific post types through filter.
	$ignored_post_types = apply_filters( 'cakecious/dataset/page_settings/ignored_post_types', array() );

	// Intersect the supported post types.
	return array_diff( $all_supported_post_types, $ignored_post_types );
}

/**
 * Return all "public" custom post types.
 * 
 * @return array
 */
function cakecious_get_public_custom_post_types() {
	$public_post_types = get_post_types( array(
		'public'             => true,
		'publicly_queryable' => true,
		'rewrite'            => true,
		'_builtin'           => false,
	), 'names' );

	$public_post_types = array_values( $public_post_types );

	return $public_post_types;
}

/**
 * Return fallback values of page settings.
 * 
 * @return array
 */
function cakecious_get_fallback_page_settings() {
	$array = apply_filters( 'cakecious/dataset/page_settings/fallback_values', array(
		'content_container'        => cakecious_get_theme_mod( 'content_container', 'default' ),
		'content_layout'           => cakecious_get_theme_mod( 'content_layout', 'right-sidebar' ),
		'content_header'           => array( 'title' ),
		'content_header_alignment' => array( 'left' ),
		'hero'                     => cakecious_get_theme_mod( 'hero', 0 ),
		'hero_container'           => cakecious_get_theme_mod( 'hero_container', 'default' ),
		'hero_alignment'           => cakecious_get_theme_mod( 'hero_alignment', 'center' ),
		'hero_bg'                  => cakecious_get_theme_mod( 'hero_bg', '' ),
		'hero_bg_image'            => cakecious_get_theme_mod( 'hero_bg_image', '' ),
	) );

	// Compatibility filter
	// SOON WILL BE DEPRECATED
	return apply_filters( 'cakecious/dataset/fallback_page_settings', $array );
}

/**
 * Return array of configuration for header builder interface in Customizer.
 *
 * @return array
 */
function cakecious_get_header_builder_configurations() {
	$array = apply_filters( 'cakecious/dataset/header_builder_configurations', array(
		'locations' => array(
			'top_left'      => is_rtl() ? esc_html__( 'Top - Right', 'cakecious' ) : esc_html__( 'Top - Left', 'cakecious' ),
			'top_center'    => esc_html__( 'Top - Center', 'cakecious' ),
			'top_right'     => is_rtl() ? esc_html__( 'Top - Left', 'cakecious' ) : esc_html__( 'Top - Right', 'cakecious' ),
			'main_left'     => is_rtl() ? esc_html__( 'Main - Right', 'cakecious' ) : esc_html__( 'Main - Left', 'cakecious' ),
			'main_center'   => esc_html__( 'Main - Center', 'cakecious' ),
			'main_right'    => is_rtl() ? esc_html__( 'Main - Left', 'cakecious' ) : esc_html__( 'Main - Right', 'cakecious' ),
			'bottom_left'   => is_rtl() ? esc_html__( 'Bottom - Right', 'cakecious' ) : esc_html__( 'Bottom - Left', 'cakecious' ),
			'bottom_center' => esc_html__( 'Bottom - Center', 'cakecious' ),
			'bottom_right'  => is_rtl() ? esc_html__( 'Bottom - Left', 'cakecious' ) : esc_html__( 'Bottom - Right', 'cakecious' ),
		),
		'choices' => array(
			'logo'                   => '<span class="dashicons dashicons-admin-home"></span>' . esc_html__( 'Logo', 'cakecious' ),
			/* translators: %s: instance number. */
			'menu-1'                 => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Menu %s', 'cakecious' ), 1 ),
			/* translators: %s: instance number. */
			'html-1'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'cakecious' ), 1 ),
			'search-bar'             => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Bar', 'cakecious' ),
			'search-dropdown'        => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Dropdown', 'cakecious' ),
			'social'                 => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'cakecious' ),
		),
		'limitations' => array(),
	) );

	ksort( $array['choices'] );

	return $array;
}

/**
 * Return array of configuration for mobile header builder interface in Customizer.
 *
 * @return array
 */
function cakecious_get_mobile_header_builder_configurations() {
	$array = apply_filters( 'cakecious/dataset/mobile_header_builder_configurations', array(
		'locations' => array(
			'main_left'    => is_rtl() ? esc_html__( 'Mobile - Right', 'cakecious' ) : esc_html__( 'Mobile - Left', 'cakecious' ),
			'main_center'  => esc_html__( 'Mobile - Center', 'cakecious' ),
			'main_right'   => is_rtl() ? esc_html__( 'Mobile - Left', 'cakecious' ) : esc_html__( 'Mobile - Right', 'cakecious' ),
			'vertical_top' => esc_html__( 'Mobile - Popup', 'cakecious' ),
		),
		'choices' => array(
			'mobile-logo'            => '<span class="dashicons dashicons-admin-home"></span>' . esc_html__( 'Mobile Logo', 'cakecious' ),
			'mobile-menu'            => '<span class="dashicons dashicons-admin-links"></span>' . esc_html__( 'Mobile Menu', 'cakecious' ),
			/* translators: %s: instance number. */
			'html-1'                 => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'cakecious' ), 1 ),
			'search-bar'             => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Bar', 'cakecious' ),
			'search-dropdown'        => '<span class="dashicons dashicons-search"></span>' . esc_html__( 'Search Icon', 'cakecious' ),
			'social'                 => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'cakecious' ),
			'mobile-vertical-toggle' => '<span class="dashicons dashicons-menu"></span>' . esc_html__( 'Toggle', 'cakecious' ),
		),
		'limitations' => array(
			'mobile-logo'            => array( 'vertical_top' ),
			'mobile-menu'            => array( 'main_left', 'main_center', 'main_right' ),
			'search-bar'             => array( 'main_left', 'main_center', 'main_right' ),
			'search-dropdown'        => array( 'vertical_top' ),
			'mobile-vertical-toggle' => array( 'vertical_top' ),
		),
	) );

	ksort( $array['choices'] );

	return $array;
}

/**
 * Return array of configuration for footer builder interface in Customizer.
 *
 * @return array
 */
function cakecious_get_footer_builder_configurations() {
	$array = apply_filters( 'cakecious/dataset/footer_builder_configurations', array(
		'locations' => array(
			'bottom_left'   => is_rtl() ? esc_html__( 'Right', 'cakecious' ) : esc_html__( 'Left', 'cakecious' ),
			'bottom_center' => esc_html__( 'Center', 'cakecious' ),
			'bottom_right'  => is_rtl() ? esc_html__( 'Left', 'cakecious' ) : esc_html__( 'Right', 'cakecious' ),
		),
		'choices' => array(
			'copyright' => '<span class="dashicons dashicons-editor-code"></span>' . esc_html__( 'Copyright', 'cakecious' ),
			/* translators: %s: instance number. */
			'menu-1'    => '<span class="dashicons dashicons-admin-links"></span>' . sprintf( esc_html__( 'Footer Menu %s', 'cakecious' ), 1 ),
			/* translators: %s: instance number. */
			'html-1'    => '<span class="dashicons dashicons-editor-code"></span>' . sprintf( esc_html__( 'HTML %s', 'cakecious' ), 1 ),
			'social'    => '<span class="dashicons dashicons-twitter"></span>' . esc_html__( 'Social', 'cakecious' ),
		),
	) );

	ksort( $array['choices'] );

	return $array;
}

/**
 * Return default theme colors.
 *
 * @return array
 */
function cakecious_get_default_colors() {
	return apply_filters( 'cakecious/dataset/default_colors', array(
		'transparent'       => 'rgba(0,0,0,0)',
		'white'             => '#ffffff',
		'black'             => '#000000',
		'accent'            => '#F295B2',
		'accent2'           => '#1F7A92',
		'bg'                => '#ffffff',
		'text'              => '#666666',
		'heading'           => '#333333',
		'subtle'            => 'rgba(0,0,0,0.05)',
		'border'            => 'rgba(0,0,0,0.1)',
	) );
}

/**
 * Return all available fonts.
 * 
 * @return array
 */
function cakecious_get_all_fonts() {
	return apply_filters( 'cakecious/dataset/all_fonts', array(
		'web_safe_fonts' => cakecious_get_web_safe_fonts(),
		'custom_fonts'   => array(),
		'google_fonts'   => cakecious_get_google_fonts(),
	) );
}

/**
 * Return array of selected Google Fonts list.
 * Selected fonts are configurable from Appearance > Cakecious > Settings > Fonts page.
 * 
 * @return array
 */
function cakecious_get_google_fonts() {
	global $wp_filesystem;
	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	$json = $wp_filesystem->get_contents( CAKECIOUS_INCLUDES_DIR . '/lists/google-fonts.json' );
	
	return json_decode( $json, true );
}

/**
 * Return array of Google Fonts subsets.
 * 
 * @return array
 */
function cakecious_get_google_fonts_subsets() {
	return array(
		// 'latin' always chosen by default
		'latin-ext' => 'Latin Extended',
		'arabic' => 'Arabic',
		'bengali' => 'Bengali',
		'cyrillic' => 'Cyrillic',
		'cyrillic-ext' => 'Cyrillic Extended',
		'devaganari' => 'Devaganari',
		'greek' => 'Greek',
		'greek-ext' => 'Greek Extended',
		'gujarati' => 'Gujarati',
		'gurmukhi' => 'Gurmukhi',
		'hebrew' => 'Hebrew',
		'kannada' => 'Kannada',
		'khmer' => 'Khmer',
		'malayalam' => 'Malayalam',
		'myanmar' => 'Myanmar',
		'oriya' => 'Oriya',
		'sinhala' => 'Sinhala',
		'tamil' => 'Tamil',
		'telugu' => 'Telugu',
		'thai' => 'Thai',
		'vietnamese' => 'Vietnamese',
	);
}

/**
 * Return array of Web Safe Fonts choices.
 * 
 * @return array
 */
function cakecious_get_web_safe_fonts() {
	return apply_filters( 'cakecious/dataset/web_safe_fonts', array(
		// System
		'Default System Font' => "-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif",

		// Sans Serif
		'Arial' => "Arial, 'Helvetica Neue', Helvetica, sans-serif",
		'Helvetica' => "'Helvetica Neue', Helvetica, Arial, sans-serif",
		'Tahoma' => "Tahoma, Geneva, sans-serif",
		'Trebuchet MS' => "'Trebuchet MS', Helvetica, sans-serif",
		'Verdana' => "Verdana, Geneva, sans-serif",

		// Serif
		'Georgia' => "Georgia, serif",
		'Times New Roman' => "'Times New Roman', Times, serif",

		// Monospace
		'Courier New' => "'Courier New', Courier, monospace",
		'Lucida Console' => "'Lucida Console', Monaco, monospace",
	) );
}

/**
 * Return array of social media types (based on Simple Icons).
 * 
 * @param boolean $sort
 * @return array
 */
function cakecious_get_social_media_types( $sort = false ) {
	$types = apply_filters( 'cakecious/dataset/social_media_types', array(
		// Social network
		'facebook' => 'Facebook',
		'instagram' => 'Instagram',
		// 'google-plus' => 'Google+',
		'linkedin' => 'LinkedIn',
		'twitter' => 'Twitter',
		'pinterest' => 'Pinterest',
		'vk' => 'VK',

		// Portfolio
		'behance' => 'Behance',
		'dribbble' => 'Dribbble',

		// Publishing
		'medium' => 'Medium',
		'wordpress' => 'WordPress',

		// Messenger
		'messenger' => 'Messenger',
		'skype' => 'Skype',
		'slack' => 'Slack',
		'telegram' => 'Telegram',
		'whatsapp' => 'WhatsApp',

		// Programming
		'github' => 'GitHub',
		'gitlab' => 'GitLab',
		'bitbucket' => 'Bitbucket',

		// Audio & Video
		'vimeo' => 'Vimeo',
		'youtube' => 'Youtube',

		// Others
		'rss' => 'RSS',
	) );

	if ( $sort ) {
		ksort( $types );
	}

	return $types;
}

/**
 * Return array of icons choices.
 * 
 * @return array
 */
function cakecious_get_all_icons() {
	return apply_filters( 'cakecious/dataset/all_icons', array(
		'theme_icons' => array(
			'search' => esc_html_x( 'Search', 'icon label', 'cakecious' ),
			'close' => esc_html_x( 'Close', 'icon label', 'cakecious' ),
			'menu' => esc_html_x( 'Menu', 'icon label', 'cakecious' ),
			'chevron-down' => esc_html_x( 'Dropdown Arrow -- Down', 'icon label', 'cakecious' ),
			'chevron-right' => esc_html_x( 'Dropdown Arrow -- Right', 'icon label', 'cakecious' ),
			'shopping-cart' => esc_html_x( 'Shopping Cart', 'icon label', 'cakecious' ),
		),
		'social_icons' => cakecious_get_social_media_types( true ),
	) );
}

/**
 * Return array of image sizes.
 * 
 * @return array
 */
function cakecious_get_all_image_sizes() {
	$labels = array(
		'thumbnail' => esc_html__( 'Thumbnail', 'cakecious' ),
		'medium' => esc_html__( 'Medium', 'cakecious' ),
		'medium_large' => esc_html__( 'Medium Large', 'cakecious' ),
		'large' => esc_html__( 'Large', 'cakecious' ),
	);

	$sizes = array(
		'full' => esc_html__( 'Full', 'cakecious' ),
	);

	foreach ( get_intermediate_image_sizes() as $slug ) {
		if ( isset( $labels[ $slug ] ) ) {
			$sizes[ $slug ] = $labels[ $slug ];
		} else {
			$sizes[ $slug ] = $slug;
		}
	}

	return $sizes;
}