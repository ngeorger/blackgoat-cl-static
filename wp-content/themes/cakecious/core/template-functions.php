<?php
/**
 * Custom functions to modify frontend templates via hooks.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ====================================================
 * HTML Head filters
 * ====================================================
 */

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function cakecious_pingback_header() {
	if ( is_singular() && pings_open() ) {
		/* translators: %s: pingback url. */
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'cakecious_pingback_header' );

/**
 * Add preconnect for Google Fonts embed fonts.
 *
 * @param array $urls
 * @param string $relation_type
 * @return array $urls
 */
function cakecious_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'cakecious-google-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'cakecious_resource_hints', 10, 2 );

/**
 * ====================================================
 * Template hooks
 * ====================================================
 */

/**
 * Attach template functions into the proper template hooks.
 * All template functions can be found on 'inc/template-tags.php' file.
 */
function cakecious_template_hooks() {
	/**
	 * ====================================================
	 * Global hooks
	 * ====================================================
	 */

	// Add "skip to content" link before canvas.
	add_action( 'cakecious/frontend/before_canvas', 'cakecious_skip_to_content_link', 1 );
	
	// Add mobile vertical header link before canvas.
	add_action( 'cakecious/frontend/before_canvas', 'cakecious_mobile_vertical_header', 10 );

	// Add main header.
	add_action( 'cakecious/frontend/header', 'cakecious_main_header', 10 );
	
	// Add mobile header.
	add_action( 'cakecious/frontend/header', 'cakecious_mobile_header', 10 );

	// Add default logo.
	add_action( 'cakecious/frontend/logo', 'cakecious_default_logo', 10 );

	// Add default mobile logo.
	add_action( 'cakecious/frontend/mobile_logo', 'cakecious_default_mobile_logo', 10 );

	// Add main footer.
	add_action( 'cakecious/frontend/footer', 'cakecious_main_footer', 10 );

	// Add scroll to top button.
	add_action( 'cakecious/frontend/after_canvas', 'cakecious_scroll_to_top', 10 );

	// Add do_shortcode to all kind of archive description.
	add_filter( 'term_description', 'do_shortcode' );
	add_filter( 'get_the_post_type_description', 'do_shortcode' );
	add_filter( 'get_the_author_description', 'do_shortcode' );

	/**
	 * ====================================================
	 * Post Layout: Default
	 * ====================================================
	 */

	// Add thumbnail before or after content header.
	if ( 'before' === cakecious_get_theme_mod( 'entry_thumbnail' ) ) {
		add_action( 'cakecious/frontend/entry/header', 'cakecious_entry_thumbnail', 0 );
	}
	elseif ( 'after' === cakecious_get_theme_mod( 'entry_thumbnail' ) ) {
		add_action( 'cakecious/frontend/entry/header', 'cakecious_entry_thumbnail', 999 );
	}

	// Add entry header elements.
	$priority = 10;
	foreach ( cakecious_get_theme_mod( 'entry_header', array() ) as $element ) {
		$function = 'cakecious_entry_' . str_replace( '-', '_', $element );

		// If function exists, attach to hook.
		if ( function_exists( $function ) ) {
			add_action( 'cakecious/frontend/entry/header', $function, $priority );
		}

		// Increment priority number.
		$priority = $priority + 10;
	}

	// Add entry footer elements.
	$priority = 10;
	foreach ( cakecious_get_theme_mod( 'entry_footer', array() ) as $element ) {
		$function = 'cakecious_entry_' . str_replace( '-', '_', $element );

		// If function exists, attach to hook.
		if ( function_exists( $function ) ) {
			add_action( 'cakecious/frontend/entry/footer', $function, $priority );
		}

		// Increment priority number.
		$priority = $priority + 10;
	}

	/**
	 * ====================================================
	 * Post Layout: Grid
	 * ====================================================
	 */

	// Add thumbnail before or after content header.
	if ( 'before' === cakecious_get_theme_mod( 'entry_grid_thumbnail' ) ) {
		add_action( 'cakecious/frontend/entry_grid/header', 'cakecious_entry_grid_thumbnail', 0 );
	}
	elseif ( 'after' === cakecious_get_theme_mod( 'entry_grid_thumbnail' ) ) {
		add_action( 'cakecious/frontend/entry_grid/header', 'cakecious_entry_grid_thumbnail', 999 );
	}

	// Add entry grid header elements.
	$priority = 10;
	foreach ( cakecious_get_theme_mod( 'entry_grid_header', array() ) as $element ) {
		$function = 'cakecious_entry_grid_' . str_replace( '-', '_', $element );

		// If function exists, attach to hook.
		if ( function_exists( $function ) ) {
			add_action( 'cakecious/frontend/entry_grid/header', $function, $priority );
		}

		// Increment priority number.
		$priority = $priority + 10;
	}

	// Add entry grid footer elements.
	$priority = 10;
	foreach ( cakecious_get_theme_mod( 'entry_grid_footer', array() ) as $element ) {
		$function = 'cakecious_entry_grid_' . str_replace( '-', '_', $element );

		// If function exists, attach to hook.
		if ( function_exists( $function ) ) {
			add_action( 'cakecious/frontend/entry_grid/footer', $function, $priority );
		}

		// Increment priority number.
		$priority = $priority + 10;
	}

	/**
	 * ====================================================
	 * Search Results Item
	 * ====================================================
	 */

	// Add title to search result entry header.
	add_action( 'cakecious/frontend/entry_search/header', 'cakecious_entry_small_title', 10 );

	/**
	 * ====================================================
	 * All index page hooks
	 * ====================================================
	 */

	if ( is_archive() || is_home() || is_search() ) {
		/**
		 * ====================================================
		 * Archive Content Header
		 * ====================================================
		 */

		$elements = cakecious_get_current_page_setting( 'content_header' );

		// Add content header elements.
		$priority = 10;
		if( is_array($elements) ) {
			foreach ( $elements as $element ) {
				$function = 'cakecious_' . str_replace( '-', '_', $element );

				// If function exists, attach to hook.
				if ( function_exists( $function ) ) {
					add_action( 'cakecious/frontend/content_header', $function, $priority );
				}

				// Increment priority number.
				$priority = $priority + 10;
			}
		}
		// Add content header before main content.
		if ( ! intval( cakecious_get_current_page_setting( 'hero' ) ) ) {
			if ( is_home() ) {
				if ( intval( cakecious_get_theme_mod( 'post_archive_home_content_header' ) ) ) {
					add_action( 'cakecious/frontend/before_main', 'cakecious_content_header', 10 );
				}
			} else {
				add_action( 'cakecious/frontend/before_main', 'cakecious_content_header', 10 );
			}
		}

		/**
		 * ====================================================
		 * Archive Loop Navigation
		 * ====================================================
		 */

		// Add navigation after the loop.
		add_action( 'cakecious/frontend/after_main', 'cakecious_loop_navigation', 10 );
	}

	/**
	 * ====================================================
	 * All "singular" page hooks
	 * ====================================================
	 */

	if ( is_singular() ) {
		/**
		 * ====================================================
		 * Comments for all singular pages
		 * ====================================================
		 */

		// Add comments.
		add_action( 'cakecious/frontend/after_main', 'cakecious_entry_comments', 20 );
			
		// Add comments title.
		add_action( 'cakecious/frontend/before_comments_list', 'cakecious_comments_title', 10 );
		
		// Add comments navigation.
		add_action( 'cakecious/frontend/before_comments_list', 'cakecious_comments_navigation', 20 );
		add_action( 'cakecious/frontend/after_comments_list', 'cakecious_comments_navigation', 10 );

		// Add "comments closed" notice.
		add_action( 'cakecious/frontend/after_comments_list', 'cakecious_comments_closed', 20 );

		/**
		 * ====================================================
		 * Static page
		 * ====================================================
		 */

		if ( is_page() ) {
			// Add content header to content section.
			if ( ! intval( cakecious_get_current_page_setting( 'hero' ) ) ) {
				add_action( 'cakecious/frontend/page_entry/header', 'cakecious_content_header', 10 );
			}

			// Add thumbnail before or after content header.
			if ( 'before' === cakecious_get_theme_mod( 'page_single_content_thumbnail' ) ) {
				add_action( 'cakecious/frontend/page_entry/header', 'cakecious_page_entry_thumbnail', 0 );
			}
			elseif ( 'after' === cakecious_get_theme_mod( 'page_single_content_thumbnail' ) ) {
				add_action( 'cakecious/frontend/page_entry/header', 'cakecious_page_entry_thumbnail', 999 );
			}

			// Add content header elements.
			$priority = 10;
			foreach ( cakecious_get_theme_mod( 'page_single_content_header', array() ) as $element ) {
				$function = 'cakecious_' . str_replace( '-', '_', $element );

				// If function exists, attach to hook.
				if ( function_exists( $function ) ) {
					add_action( 'cakecious/frontend/content_header', $function, $priority );
				}

				// Increment priority number.
				$priority = $priority + 10;
			}
		}

		/**
		 * ====================================================
		 * Single blog post page
		 * ====================================================
		 */

		elseif ( is_single() ) {
			// Add content header to content section.
			if ( ! intval( cakecious_get_current_page_setting( 'hero' ) ) ) {
				add_action( 'cakecious/frontend/single_entry/header', 'cakecious_content_header', 10 );
			}

			// Add thumbnail before or after content header.
			if ( 'before' === cakecious_get_theme_mod( 'post_single_content_thumbnail' ) ) {
				add_action( 'cakecious/frontend/single_entry/header', 'cakecious_single_entry_thumbnail', 0 );
			}
			elseif ( 'after' === cakecious_get_theme_mod( 'post_single_content_thumbnail' ) ) {
				add_action( 'cakecious/frontend/single_entry/header', 'cakecious_single_entry_thumbnail', 999 );
			}

			// Add post header into content header.
			$priority = 10;
			foreach ( cakecious_get_theme_mod( 'post_single_content_header', array() ) as $element ) {
				$function = 'cakecious_' . str_replace( '-', '_', $element );

				// If function exists, attach to hook.
				if ( function_exists( $function ) ) {
					add_action( 'cakecious/frontend/content_header', $function, $priority );
				}

				// Increment priority number.
				$priority = $priority + 10;
			}

			// Add post footer.
			$priority = 10;
			foreach ( cakecious_get_theme_mod( 'post_single_content_footer', array() ) as $element ) {
				$function = 'cakecious_' . str_replace( '-', '_', $element );

				// If function exists, attach to hook.
				if ( function_exists( $function ) ) {
					add_action( 'cakecious/frontend/single_entry/footer', $function, $priority );
				}

				// Increment priority number.
				$priority = $priority + 10;
			}

			// Add author bio.
			if ( intval( cakecious_get_theme_mod( 'blog_single_author_bio' ) ) ) {
				add_action( 'cakecious/frontend/after_main', 'cakecious_single_post_author_bio', 10 );
			}
			
			// Add post navigation.
			if ( intval( cakecious_get_theme_mod( 'blog_single_navigation' ) ) ) {
				add_action( 'cakecious/frontend/after_main', 'cakecious_single_post_navigation', 15 );
			}
		}

		/**
		 * ====================================================
		 * Other post types
		 * ====================================================
		 */

		else {
			// Add content header to content section.
			if ( ! intval( cakecious_get_current_page_setting( 'hero' ) ) ) {
				add_action( 'cakecious/frontend/single_entry/header', 'cakecious_content_header', 10 );
			}

			// Add post header into content header.
			$priority = 10;
			foreach ( cakecious_get_theme_mod( $ps_type . '_content_header', array() ) as $element ) {
				$function = 'cakecious_' . str_replace( '-', '_', $element );

				// If function exists, attach to hook.
				if ( function_exists( $function ) ) {
					add_action( 'cakecious/frontend/content_header', $function, $priority );
				}

				// Increment priority number.
				$priority = $priority + 10;
			}
		}
	}

}
add_action( 'wp', 'cakecious_template_hooks', 20 );

/**
 * ====================================================
 * Template rendering filters
 * ====================================================
 */

/**
 * Modify archive title based as configured in the Customizer.
 *
 * @param string $title
 * @param string $original_title
 * @param string $prefix
 * @return string
 */
function cakecious_custom_archive_title( $title, $original_title, $prefix ) {
	// If it's a Blog page, change the posts archive title to "Posts" replacing the default title ("Archives").
	if ( is_home() ) {
		$post_type_obj = get_post_type_object( 'post' );

		$title = $post_type_obj->labels->name;
	}

	if ( is_post_type_archive() || is_home() ) {
		$custom_title = cakecious_get_current_page_setting( 'title_text' );

		if ( ! empty( $custom_title ) ) {
			$post_type_obj = get_post_type_object( get_post_type() );

			$custom_title = str_replace( '{{post_type}}', $post_type_obj->labels->name, $custom_title );
		}
	}
	elseif ( is_category() || is_tag() || is_tax() ) {
		$custom_title = cakecious_get_current_page_setting( 'tax_title_text' );

		if ( ! empty( $custom_title ) ) {
			$term_obj = get_queried_object();
			$taxonomy_obj = get_taxonomy( $term_obj->taxonomy );

			$custom_title = str_replace( '{{taxonomy}}', $taxonomy_obj->labels->singular_name, $custom_title );
			$custom_title = str_replace( '{{term}}', $term_obj->name, $custom_title );
		}
	}

	if ( ! empty( $custom_title ) ) {
		$title = $custom_title;
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'cakecious_custom_archive_title', 10, 3 );

/**
 * Modify archive title prefix.
 * 
 * @param string $prefix
 * @return string
 */
function cakecious_archive_title_prefix( $prefix ) {
	// Use gravatar as author archive title prefix.
	if ( is_author() ) {
		$prefix = '<div class="cakecious-author-archive-avatar">' . get_avatar( get_the_author_meta( 'ID' ), 120, '', get_the_author_meta( 'display_name' ) ) . '</div>';
	}

	// Modify title prefix for post type archive page.
	elseif ( is_post_type_archive() ) {
		$prefix = '';
	}

	return $prefix;
}
add_filter( 'get_the_archive_title_prefix', 'cakecious_archive_title_prefix' );

/**
 * Modify oembed HTML ouput.
 * 
 * @param string $html
 * @param string $url
 * @param array $attr
 * @param integer $post_id
 * @return string
 */
function cakecious_oembed_wrapper( $html, $url, $attr, $post_id ) {
	// Default attributes
	$atts = array( 'class' => 'cakecious-oembed' );

	// Check if the oembed HTML is a video.
	if ( preg_match( '/^<(?:iframe|embed|object)([^>]+)>/', $html, $video_match ) ) {
		$atts['class'] .= ' cakecious-oembed-video';

		// Extract all attributes (if any).
		if ( preg_match_all( '/(\w+)=[\'\"]?([^\'\"]*)[\'\"]?/', $video_match[1], $atts_matches ) ) {
			// Format all attributes into associative array.
			$video_atts = array();
			for ( $i = 0; $i < count( $atts_matches[1] ); $i++ ) {
				$video_atts[ $atts_matches[1][ $i ] ] = $atts_matches[2][ $i ];
			}

			// Check if there is width & height attributes found, use those values for responsive ratio.
			if ( isset( $video_atts['width'] ) && isset( $video_atts['height'] ) ) {
				$w = intval( $video_atts['width'] );
				$h = intval( $video_atts['height'] );

				$atts['style'] = 'padding-top: ' . round( ( $h / $w * 100 ), 3 ) . '%;';
			}
			// If not found, use default 16:9 ratio.
			else {
				$atts['style'] = 'padding-top: 56.25%;';
			}
		}
	}

	// Filter to modify oembed HTML attributes.
	$atts = apply_filters( 'cakecious/frontend/oembed_attributes', $atts );

	// Build the attributes HTML.
	$atts_html = '';
	foreach ( $atts as $key => $value ) {
		$atts_html .= ' ' . $key . '="' . esc_attr( $value ) . '"';
	}

	return '<div' . $atts_html . '>' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'cakecious_oembed_wrapper', 10, 4 );

/**
 * Modify "read more" HTML output.
 * 
 * @param integer $length
 * @return integer
 */
function cakecious_read_more( $link ) {
	return '<p class="read-more">' . $link . '</p>';
}
add_filter( 'the_content_more_link', 'cakecious_read_more' );

/**
 * Modify blog post's excerpt character limit.
 * 
 * @param integer $length
 * @return integer
 */
function cakecious_excerpt_length( $length ) {
	// Search page
	if ( is_search() ) {
		return 30;
	}

	// Posts page
	elseif ( ( is_home() || is_archive() ) && 'post' === get_post_type() ) {
		$layout = cakecious_get_theme_mod( 'blog_index_loop_mode' );

		if ( 'default' === $layout ) {
			$key = 'entry_excerpt_length';
		} else {
			$key = 'entry_' . $layout . '_excerpt_length';
		}

		return intval( cakecious_get_theme_mod( $key, $length ) );
	}

	// Else
	return $length;
}
add_filter( 'excerpt_length', 'cakecious_excerpt_length' );

/**
 * Modify blog post's excerpt end string.
 * 
 * @param string $more
 * @return string
 */
function cakecious_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'cakecious_excerpt_more' );

/**
 * Add dropdown caret to accordion menu item.
 *
 * @param string $item_output
 * @param WP_Post $item
 * @param integer $depth
 * @param stdClass $args
 * @return string
 */
function cakecious_walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {
	// Only add to menu item that has sub menu.
	if ( in_array( 'menu-item-has-children', $item->classes ) || in_array( 'page_item_has_children', $item->classes ) ) {
		// Only add to toggle menu.
		if ( is_integer( strpos( $args->menu_class, 'cakecious-toggle-menu' ) ) ) {
			$sign = '<button class="cakecious-sub-menu-toggle cakecious-toggle">' . cakecious_icon( 'chevron-down', array( 'class' => 'cakecious-dropdown-sign' ), false ) . '<span class="screen-reader-text">' . esc_html__( 'Expand / Collapse', 'cakecious' ) . '</span></button>';
			
			$item_output .= trim( $sign );
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'cakecious_walker_nav_menu_start_el', 99, 4 );

/**
 * Add <span> wrapping tag and dropdown caret to menu item title.
 *
 * @param string $title
 * @param WP_Post $item
 * @param stdClass $args
 * @param integer $depth
 * @return string
 */
function cakecious_nav_menu_item_title( $title, $item, $args, $depth ) {
	$sign = '';

	// Only add to menu item that has sub menu.
	if ( in_array( 'menu-item-has-children', $item->classes ) || in_array( 'page_item_has_children', $item->classes ) ) {
		// Only add to hover menu.
		if ( is_integer( strpos( $args->menu_class, 'cakecious-hover-menu' ) ) ) {
			$sign = cakecious_icon( 0 < $depth ? 'chevron-right' : 'chevron-down', array( 'class' => 'cakecious-dropdown-sign' ), false );
		}
	}

	return '<span class="cakecious-menu-item-title">' . $title . '</span>' . trim( $sign );
}
add_filter( 'nav_menu_item_title', 'cakecious_nav_menu_item_title', 99, 4 );

/**
 * Add 'cakecious-menu-item-link' class to menu item's anchor tag.
 *
 * @param array $atts
 * @param WP_Post $item
 * @param stdClass $args
 * @param int $depth
 */
function cakecious_nav_menu_link_attributes( $atts, $item, $args, $depth ) {
	if ( ! isset( $atts['class'] ) ) {
		$atts['class'] = '';
	}

	$atts['class'] = 'cakecious-menu-item-link ' . $atts['class'];

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'cakecious_nav_menu_link_attributes', 10, 4 );

/**
 * Add SVG icon to search textbox.
 *
 * @param string $from
 * @return string
 */
function cakecious_get_search_form_add_icon( $form ) {
	$form = preg_replace( '/placeholder="(.*?)"/', 'placeholder="' . esc_attr__( 'Search&hellip;', 'cakecious' ) . '"', $form );
	$form = preg_replace( '/<\/form>/', cakecious_icon( 'search', array( 'class' => 'cakecious-search-icon' ), false ) . '</form>', $form );

	return $form;
}
add_filter( 'get_search_form', 'cakecious_get_search_form_add_icon' );

/**
 * ====================================================
 * Blog elements
 * ====================================================
 */

/**
 * Modify tagcloud arguments.
 * 
 * @param array $args
 * @return array
 */
function cakecious_widget_tag_cloud_args( $args ) {
	$args['smallest'] = 0.75;
	$args['default']  = 1;
	$args['largest']  = 1.75;
	$args['unit']     = 'em';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'cakecious_widget_tag_cloud_args' );

/**
 * ====================================================
 * Element classes filters
 * ====================================================
 */

/**
 * Add LTR class to the array of body classes.
 *
 * @param array $classes.
 * @return array
 */
function cakecious_body_ltr_class( $classes ) {
	if ( ! is_rtl() ) {
		$classes[] = 'ltr';
	}

	// RTL class is automatically added by default when RTL mode is active.

	return $classes;
}
add_filter( 'body_class', 'cakecious_body_ltr_class', -1 );

/**
 * Add custom classes to the array of body classes.
 *
 * @param array $classes.
 * @return array
 */
function cakecious_body_classes( $classes ) {
	// Add a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}
	
	// Add page layout class.
	$classes['page_layout'] = esc_attr( 'cakecious-page-layout-' . cakecious_get_theme_mod( 'page_layout' ) );

	// Add theme version.
	$classes['theme_version'] = esc_attr( 'cakecious-ver-' . str_replace( '.', '-', CAKECIOUS_VERSION ) );

	// Add font smoothing class.
	if ( intval( cakecious_get_theme_mod( 'font_smoothing' ) ) ) {
		$classes['font_smoothing'] = esc_attr( 'cakecious-font-smoothing-1' );
	}

	return $classes;
}
add_filter( 'body_class', 'cakecious_body_classes' );

/**
 * Add a class to post wrapper if the content is built using Gutenberg.
 *
 * @param array $classes
 * @return array
 */
function cakecious_post_class_is_gutenberg( $classes ) {
	if ( is_singular() && has_blocks() ) {
		$classes['gutenberg'] = 'cakecious-gutenberg-content';
	}

	return $classes;
}
add_filter( 'post_class', 'cakecious_post_class_is_gutenberg' );

/**
 * Add custom classes to the array of mobile vertical header classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_header_mobile_vertical_classes( $classes ) {
	$classes['display'] = esc_attr( 'cakecious-header-mobile-vertical-display-' . cakecious_get_theme_mod( 'header_mobile_vertical_bar_display' ) );

	$classes['position'] = esc_attr( 'cakecious-header-mobile-vertical-position-' . cakecious_get_theme_mod( 'header_mobile_vertical_bar_position' ) );

	$classes['alignment'] = esc_attr( 'cakecious-text-align-' . cakecious_get_theme_mod( 'header_mobile_vertical_bar_alignment' ) );

	return $classes;
}
add_filter( 'cakecious/frontend/header_mobile_vertical_classes', 'cakecious_header_mobile_vertical_classes' );

/**
 * Add custom classes to the array of header top bar section classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_header_top_bar_classes( $classes ) {
	$classes['container'] = esc_attr( 'cakecious-section-' . cakecious_get_theme_mod( 'header_top_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'cakecious-header-menu-highlight-' . cakecious_get_theme_mod( 'header_top_bar_menu_highlight' ) );

	if ( intval( cakecious_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		$classes['merged'] = 'cakecious-section-merged';
	}

	return $classes;
}
add_filter( 'cakecious/frontend/header_top_bar_classes', 'cakecious_header_top_bar_classes' );

/**
 * Add custom classes to the array of header main bar section classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_header_main_bar_classes( $classes ) {
	$classes['container'] = esc_attr( 'cakecious-section-' . cakecious_get_theme_mod( 'header_main_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'cakecious-header-menu-highlight-' . cakecious_get_theme_mod( 'header_main_bar_menu_highlight' ) );

	if ( intval( cakecious_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		$classes['top_bar_merged'] = 'cakecious-header-main-bar-with-top-bar';
	}

	if ( intval( cakecious_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		$classes['bottom_bar_merged'] = 'cakecious-header-main-bar-with-bottom-bar';
	}

	return $classes;
}
add_filter( 'cakecious/frontend/header_main_bar_classes', 'cakecious_header_main_bar_classes' );

/**
 * Add custom classes to the array of header bottom bar section classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_header_bottom_bar_classes( $classes ) {
	$classes['container'] = esc_attr( 'cakecious-section-' . cakecious_get_theme_mod( 'header_bottom_bar_container' ) );
	$classes['menu_highlight'] = esc_attr( 'cakecious-header-menu-highlight-' . cakecious_get_theme_mod( 'header_bottom_bar_menu_highlight' ) );

	if ( intval( cakecious_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		$classes['merged'] = 'cakecious-section-merged';
	}

	return $classes;
}
add_filter( 'cakecious/frontend/header_bottom_bar_classes', 'cakecious_header_bottom_bar_classes' );

/**
 * Add custom classes to the array of hero section classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_hero_classes( $classes ) {
	$classes['container'] = esc_attr( 'cakecious-section-' . cakecious_get_current_page_setting( 'hero_container' ) );

	$classes['alignment'] = esc_attr( 'cakecious-text-align-' . cakecious_get_current_page_setting( 'hero_alignment' ) );

	return $classes;
}
add_filter( 'cakecious/frontend/hero_classes', 'cakecious_hero_classes' );

/**
 * Add custom classes to the array of content header classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_content_header_classes( $classes ) {
	$classes['alignment'] = cakecious_get_current_page_setting( 'content_header_alignment' );

	return $classes;
}
add_filter( 'cakecious/frontend/content_header_classes', 'cakecious_content_header_classes' );

/**
 * Add custom classes to the array of content section classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_content_classes( $classes ) {
	$classes['container'] = esc_attr( 'cakecious-section-' . cakecious_get_current_page_setting( 'content_container' ) );

	if ( 'narrow' === cakecious_get_current_page_setting( 'content_container' ) ) {
		$classes['content_layout'] = 'cakecious-content-layout-wide';
	} else {
		$classes['content_layout'] = esc_attr( 'cakecious-content-layout-' . cakecious_get_current_page_setting( 'content_layout' ) );
	}

	return $classes;
}
add_filter( 'cakecious/frontend/content_classes', 'cakecious_content_classes' );

/**
 * Add custom classes to the array of posts loop classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_loop_classes( $classes ) {
	$classes['mode'] = esc_attr( 'cakecious-loop-' . cakecious_get_theme_mod( 'blog_index_loop_mode' ) );

	// Grid
	if ( 'grid' == cakecious_get_theme_mod( 'blog_index_loop_mode' ) ) {
		$classes['blog_index_grid_columns'] = esc_attr( 'cakecious-loop-grid-' . cakecious_get_theme_mod( 'blog_index_grid_columns' ) . '-columns' );

		if ( intval( cakecious_get_theme_mod( 'entry_grid_same_height' ) ) ) {
			$classes['entry_grid_same_height'] = 'cakecious-loop-grid-same-height';
		}
	}

	return $classes;
}
add_filter( 'cakecious/frontend/loop_classes', 'cakecious_loop_classes' );

/**
 * Add custom classes to entry thumbnail.
 *
 * @param array $classes
 * @return array
 */
function cakecious_entry_thumbnail_classes( $classes ) {
	if ( intval( cakecious_get_theme_mod( 'entry_thumbnail_ignore_padding' ) ) ) {
		$classes['ignore_padding'] = 'cakecious-entry-thumbnail-ignore-padding';
	}

	return $classes;
}
add_filter( 'cakecious/frontend/entry/thumbnail_classes', 'cakecious_entry_thumbnail_classes' );

/**
 * Add custom classes to entry grid thumbnail.
 *
 * @param array $classes
 * @return array
 */
function cakecious_entry_grid_thumbnail_classes( $classes ) {
	if ( intval( cakecious_get_theme_mod( 'entry_grid_thumbnail_ignore_padding' ) ) ) {
		$classes['ignore_padding'] = 'cakecious-entry-thumbnail-ignore-padding';
	}

	return $classes;
}
add_filter( 'cakecious/frontend/entry_grid/thumbnail_classes', 'cakecious_entry_grid_thumbnail_classes' );

/**
 * Add custom classes to single post thumbnail.
 *
 * @param array $classes
 * @return array
 */
function cakecious_page_entry_thumbnail_classes( $classes ) {
	if ( intval( cakecious_get_theme_mod( 'page_single_content_thumbnail_wide' ) ) ) {
		$classes['alignwide'] = 'alignwide';
	}

	return $classes;
}
add_filter( 'cakecious/frontend/page_entry/thumbnail_classes', 'cakecious_page_entry_thumbnail_classes' );

/**
 * Add custom classes to single post thumbnail.
 *
 * @param array $classes
 * @return array
 */
function cakecious_single_entry_thumbnail_classes( $classes ) {
	if ( intval( cakecious_get_theme_mod( 'post_single_content_thumbnail_wide' ) ) ) {
		$classes['alignwide'] = 'alignwide';
	}

	return $classes;
}
add_filter( 'cakecious/frontend/single_entry/thumbnail_classes', 'cakecious_single_entry_thumbnail_classes' );

/**
 * Add custom classes to the array of sidebar classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_sidebar_classes( $classes ) {
	$classes['widgets_mode'] = esc_attr( 'cakecious-sidebar-widgets-mode-' . cakecious_get_theme_mod( 'sidebar_widgets_mode' ) );
	$classes['widget_title_alignment'] = esc_attr( 'cakecious-widget-title-alignment-' . cakecious_get_theme_mod( 'sidebar_widget_title_alignment' ) );
	$classes['widget_title_decoration'] = esc_attr( 'cakecious-widget-title-decoration-' . cakecious_get_theme_mod( 'sidebar_widget_title_decoration' ) );

	return $classes;
}
add_filter( 'cakecious/frontend/sidebar_classes', 'cakecious_sidebar_classes' );

/**
 * Add custom classes to the array of footer widgets classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_footer_widgets_classes( $classes ) {
	$classes['container'] = esc_attr( 'cakecious-section-' . cakecious_get_theme_mod( 'footer_widgets_bar_container' ) );
	$classes['widget_title_alignment'] = esc_attr( 'cakecious-widget-title-alignment-' . cakecious_get_theme_mod( 'footer_widgets_bar_widget_title_alignment' ) );
	$classes['widget_title_decoration'] = esc_attr( 'cakecious-widget-title-decoration-' . cakecious_get_theme_mod( 'footer_widgets_bar_widget_title_decoration' ) );

	if ( intval( cakecious_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
		$classes['bottom_bar_merged'] = 'cakecious-footer-widgets-bar-with-bottom-bar';
	}

	return $classes;
}
add_filter( 'cakecious/frontend/footer_widgets_bar_classes', 'cakecious_footer_widgets_classes' );

/**
 * Add custom classes to the array of footer bottom bar classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_footer_bottom_classes( $classes ) {
	$classes['container'] = esc_attr( 'cakecious-section-' . cakecious_get_theme_mod( 'footer_bottom_bar_container' ) );

	if ( intval( cakecious_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
		$classes['merged'] = 'cakecious-section-merged';
	}

	return $classes;
}
add_filter( 'cakecious/frontend/footer_bottom_bar_classes', 'cakecious_footer_bottom_classes' );

/**
 * Add custom classes to the array of footer bottom bar classes.
 *
 * @param array $classes
 * @return array
 */
function cakecious_scroll_to_top_classes( $classes ) {
	$classes['position'] = esc_attr( 'cakecious-scroll-to-top-position-' . cakecious_get_theme_mod( 'scroll_to_top_position' ) );
	$classes['display'] = esc_attr( 'cakecious-scroll-to-top-display-' . cakecious_get_theme_mod( 'scroll_to_top_display' ) );

	$hide_devices = array_diff( array( 'desktop', 'tablet', 'mobile' ), cakecious_get_theme_mod( 'scroll_to_top_visibility' ) );

	foreach( $hide_devices as $device ) {
		$classes['hide_on_' . $device ] = esc_attr( 'cakecious-hide-on-' . $device );
	}

	return $classes;
}
add_filter( 'cakecious/frontend/scroll_to_top_classes', 'cakecious_scroll_to_top_classes' );