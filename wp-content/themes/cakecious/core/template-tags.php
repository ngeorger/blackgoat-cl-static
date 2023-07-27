<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ====================================================
 * Compatibility hooks
 * ====================================================
 */

if ( ! function_exists( 'wp_body_open' ) ) :
/**
 * Backward compatibility function for `wp_body_open` action hook.
 * `wp_body_open` action hook is available since WordPress 5.2
 */
function wp_body_open() {
	do_action( 'wp_body_open' );
}
endif;

/**
 * ====================================================
 * Global template functions
 * ====================================================
 */

if ( ! function_exists( 'cakecious_unassigned_menu' ) ) :
/**
 * Fallback HTML if there is no nav menu assigned to a navigation location.
 */
function cakecious_unassigned_menu() {
	$labels = get_registered_nav_menus();

	if ( ! is_user_logged_in() || ! current_user_can( 'edit_theme_options' ) ) {
		return;
	}
	?>
	<ul class="menu">
		<li class="menu-item">
			<a href="<?php echo esc_attr( add_query_arg( 'action', 'locations', admin_url( 'nav-menus.php' ) ) ); ?>" class="cakecious-menu-item-link">
				<?php esc_html_e( 'Assign menu to this location', 'cakecious' ); ?>
			</a>
		</li>
	</ul>
	<?php
}
endif;

if ( ! function_exists( 'cakecious_inline_svg' ) ) :
/**
 * Print / return inline SVG HTML tags.
 * 
 * @param string $svg_file
 * @param boolean $echo
 * @return string
 */
function cakecious_inline_svg( $svg_file, $echo = true ) {
	// Return empty if no SVG file path is provided.
	if ( empty( $svg_file ) ) {
		return;
	}

	// Get SVG markup.
	global $wp_filesystem;
	if ( empty( $wp_filesystem ) ) {
		require_once ABSPATH . '/wp-admin/includes/file.php';
		WP_Filesystem();
	}

	$html = $wp_filesystem->get_contents( $svg_file );

	// Remove XML encoding tag.
	// This should not be printed on inline SVG.
	$html = preg_replace( '/<\?xml(?:.*?)\?>/', '', $html );

	// Add width attribute if not found in the SVG markup.
	// Width value is extracted from viewBox attribute.
	if ( ! preg_match( '/<svg.*?width.*?>/', $html ) ) {
		if ( preg_match( '/<svg.*?viewBox="0 0 ([0-9.]+) ([0-9.]+)".*?>/', $html, $matches ) ) {
			$html = preg_replace( '/<svg (.*?)>/', '<svg $1 width="' . $matches[1] . '" height="' . $matches[2] . '">', $html );
		}
	}

	// Remove <title> from SVG markup.
	// Site name would be added as a screen reader text to represent the logo.
	$html = preg_replace( '/<title>.*?<\/title>/', '', $html );

	if ( $echo ) {
		echo do_shortcode($html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return $html;
	}
}
endif;

if ( ! function_exists( 'cakecious_logo' ) ) :
/**
 * Print HTML markup for specified site logo.
 *
 * @param integer $logo_image_id
 */
function cakecious_logo( $logo_image_id = null ) {
	// Default to site name.
	$html = get_bloginfo( 'name', 'display' );

	// Try to get logo image.
	if ( ! empty( $logo_image_id ) ) {
		$mime = get_post_mime_type( $logo_image_id );

		if ( 'image/svg+xml' === $mime && apply_filters( 'cakecious/frontend/logo/use_inline_svg', false ) ) {
			$svg_file = get_attached_file( $logo_image_id );

			$logo_image = cakecious_inline_svg( $svg_file, false );
		} else {
			$logo_image = wp_get_attachment_image( $logo_image_id , 'full', 0, array() );
		}

		// Replace logo HTML if logo image is found.
		if ( ! empty( $logo_image ) ) {
			$html = '<span class="cakecious-logo-image">' . $logo_image . '</span><span class="screen-reader-text">' . get_bloginfo( 'name', 'display' ) . '</span>';
		}
	}

	echo do_shortcode($html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
endif;

if ( ! function_exists( 'cakecious_default_logo' ) ) :
/**
 * Print / return HTML markup for default logo.
 */
function cakecious_default_logo() {
	?>
	<span class="cakecious-default-logo cakecious-logo"><?php cakecious_logo( cakecious_get_theme_mod( 'custom_logo' ) ); ?></span>
	<?php
}
endif;

if ( ! function_exists( 'cakecious_default_mobile_logo' ) ) :
/**
 * Print / return HTML markup for default mobile logo.
 */
function cakecious_default_mobile_logo() {
	?>
	<span class="cakecious-default-logo cakecious-logo"><?php cakecious_logo( cakecious_get_theme_mod( 'custom_logo_mobile' ) ); ?></span>
	<?php
}
endif;

if ( ! function_exists( 'cakecious_icon' ) ) :
/**
 * Print / return HTML markup for specified icon type in SVG format.
 *
 * @param string $key
 * @param array $args
 * @param boolean $echo
 * @return string
 */
function cakecious_icon( $key, $args = array(), $echo = true ) {
	$args = wp_parse_args( $args, array(
		'title' => '',
		'class' => '',
	) );

	$classes = implode( ' ', array( 'cakecious-icon', $args['class'] ) );

	// Get SVG path.
	$path = get_template_directory() . '/assets/icons/' . $key . '.svg';

	// Allow modification via filter.
	$path = apply_filters( 'cakecious/frontend/svg_icon_path', $path, $key );
	$path = apply_filters( 'cakecious/frontend/svg_icon_path/' . $key, $path );

	// Get SVG markup.
	if ( file_exists( $path ) ) {
		$svg = cakecious_inline_svg( $path, false );
	} else {
		$svg = cakecious_inline_svg( get_template_directory() . '/assets/icons/_fallback.svg', false ); // fallback
	}

	// Allow modification via filter.
	$svg = apply_filters( 'cakecious/frontend/svg_icon', $svg, $key );
	$svg = apply_filters( 'cakecious/frontend/svg_icon/' . $key, $svg );

	// Wrap the icon with "cakecious-icon" span tag.
	$html = '<span class="' . esc_attr( $classes ) . '" title="' . esc_attr( $args['title'] ) . '" aria-hidden="true">' . $svg . '</span>';

	if ( $echo ) {
		echo do_shortcode($html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return $html;
	}
}
endif;

if ( ! function_exists( 'cakecious_social_links' ) ) :
/**
 * Print / return HTML markup for specified set of social media links.
 *
 * @param array $links
 * @param array $args
 * @param boolean $echo
 * @return string
 */
function cakecious_social_links( $links = array(), $args = array(), $echo = true ) {
	$labels = cakecious_get_social_media_types( true );

	$args = wp_parse_args( $args, array(
		'before_link' => '',
		'after_link'  => '',
		'link_class'  => '',
	) );

	ob_start();
	foreach ( $links as $link ) :
		echo do_shortcode($args['before_link']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

		?><a href="<?php echo esc_url( $link['url'] ); ?>" class="cakecious-social-link <?php echo esc_attr( 'cakecious-social-link--' . $link['type'] ); ?>" <?php echo '_blank' === cakecious_array_value( $link, 'target', '_self' ) ? ' target="_blank" rel="noopener"' : ''; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<?php cakecious_icon( $link['type'], array( 'title' => $labels[ $link['type'] ], 'class' => $args['link_class'] ) ); ?> 
			<span class="screen-reader-text"><?php echo esc_html( $labels[ $link['type'] ] ); ?></span>
		</a><?php

		echo do_shortcode($args['after_link']); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	endforeach;
	$html = ob_get_clean();

	if ( $echo ) {
		echo do_shortcode($html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	} else {
		return $html;
	}
}
endif;

if ( ! function_exists( 'cakecious_breadcrumb' ) ) :
/**
 * Print / return HTML markup for breadcrumb.
 */
function cakecious_breadcrumb() {
	$html = '';

	switch ( cakecious_get_theme_mod( 'breadcrumb_plugin', '' ) ) {
		case 'breadcrumb-trail':
			if ( function_exists( 'breadcrumb_trail' ) ) {
				$html = breadcrumb_trail( array(
					'show_browse' => false,
					'echo' => false,
				) );
			}
			break;

		case 'breadcrumb-navxt':
			if ( function_exists( 'bcn_display' ) ) {
				$html = bcn_display( true );
			}
			break;

		case 'yoast-seo':
			if ( function_exists( 'yoast_breadcrumb' ) ) {
				$html = yoast_breadcrumb( '', '', false );
			}
			break;

		case 'rank-math':
			if ( function_exists( 'rank_math_get_breadcrumbs' ) ) {
				$html = rank_math_get_breadcrumbs();
			}
			break;

		case 'seopress':
			if ( function_exists( 'seopress_display_breadcrumbs' ) ) {
				$html = seopress_display_breadcrumbs( false );
			}
			break;

		default:
			$items = array();

			/**
			 * Build breadcrumb trails.
			 */

			// Other kind of archives: taxonomy archive.
			if ( is_archive() || is_home() ) {
				$post_type = get_post_type();

				if ( ! empty( $post_type ) && get_post_type_archive_link( $post_type ) !== home_url( '/' ) ) {
					$post_type_obj = get_post_type_object( $post_type );

					$items['post_type_archive'] = array(
						'label' => 'post' === $post_type ? get_the_title( get_option( 'page_for_posts' ) ) : $post_type_obj->labels->name,
						'url'   => is_post_type_archive() || is_home() ? '' : get_post_type_archive_link( $post_type ),
					);
				}

				// Date archive
				if ( is_date() ) {
					// Add published year info for year archive, month archive, and day archive.
					if ( is_year() || is_month() || is_day() ) {
						$items['year'] = array(
							'label' => get_the_time( 'Y' ),
							'url'   => is_year() ? '' : get_year_link( get_the_time( 'Y' ) ),
						);
					}
					// Add published month info for month archive, and day archive.
					if ( is_month() || is_day() ) {
						$items['month'] = array(
							'label' => get_the_time( 'F' ),
							'url'   => is_month() ? '' : get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ),
						);
					}
					// Add published day info for day archive.
					if ( is_day() ) {
						$items['day'] = array(
							'label' => get_the_time( 'd' ),
						);
					}
				}

				// Author archive
				elseif ( is_author() ) {
					$author = get_userdata( get_query_var( 'author' ) );

					$items['author_archive'] = array(
						/* translators: %s: author display name. */
						'label' => $author->display_name,
					);
				}

				// Taxonomy archive
				elseif ( is_category() || is_tag() || is_tax() ) {
					$term = get_queried_object();
					$tax = get_taxonomy( $term->taxonomy );
					$parents = get_ancestors( $term->term_id, $term->taxonomy );

					$i = count( $parents );

					while ( $i > 0 ) {
						$parent_term = get_term( $parents[ $i - 1 ], $term->taxonomy );

						$items['term_parent__' . $i ] = array(
							'label' => $parent_term->name,
							'url'   => get_term_link( $parent_term, $parent_term->taxonomy ),
						);

						$i--;
					}

					$items['term'] = array(
						'label' => $term->name,
					);
				}
			}

			// Search results page
			elseif ( is_search() ) {
				$items['search'] = array(
					/* translators: %s: search keyword. */
					'label' => sprintf( esc_html__( 'Search: %s', 'cakecious' ), get_search_query() ),
				);
			}

			// 404 page
			elseif ( is_404() ) {
				$items['404'] = array(
					'label' => esc_html__( 'Page Not Found', 'cakecious' ),
				);
			}

			// All singular types
			elseif ( is_singular() && ! is_front_page() ) {

				// All singular types except attachments
				if ( ! is_attachment() ) {
					$post_type = get_post_type();

					// Post type archive link for Post and other CPT.
					if ( is_single() ) {
						if ( get_post_type_archive_link( $post_type ) !== home_url( '/' ) ) {
							$post_type_obj = get_post_type_object( $post_type );

							$items['post_type_archive'] = array(
								'label' => 'post' === $post_type ? get_the_title( get_option( 'page_for_posts' ) ) : $post_type_obj->labels->name,
								'url'   => get_post_type_archive_link( $post_type ),
							);
						}
					}

					// Category trails for Post.
					if ( 'post' === $post_type ) {
						$cats = get_the_category();
						$cat_id = $cats[0]->term_id;
						$parents = get_ancestors( $cat_id, 'category' );

						$i = count( $parents );

						while ( $i > 0 ) {
							$items['term_parent__' . $i ] = array(
								'label' => get_cat_name( $parents[ $i - 1 ] ),
								'url'   => get_category_link( $parents[ $i - 1 ] ),
							);

							$i--;
						}

						$items['term'] = array(
							'label' => get_cat_name( $cat_id ),
							'url'   => get_category_link( $cat_id ),
						);
					}

					// Ancestors Trails for Page and other CPT.
					else {
						$ancestors = get_post_ancestors( get_post() );
						$i = count( $ancestors );

						while ( $i > 0 ) {
							$items['post_parent__' . $i ] = array(
								'label' => get_the_title( $ancestors[ $i - 1 ] ),
								'url'   => get_permalink( $ancestors[ $i - 1 ] ),
							);

							$i--;
						}
					}
				}

				// Current singular page.
				$items['post'] = array(
					'label' => get_the_title(),
				);
			}

			// Paginated
			$paged = get_query_var( 'page' ) || get_query_var( 'paged' );
			$keys = array_keys( $items );
			$last_key = end( $keys );

			if ( $paged ) {
				/* translators: %s: page number. */
				$items[ $last_key ]['label'] .= sprintf( esc_html__( ' (Page %d)', 'cakecious' ), get_query_var( 'paged' ), $paged );
			}

			// Allow develoeprs to modify the breadcrumb trail.
			$items = apply_filters( 'cakecious/frontend/breadcrumb_trail', $items );

			// Abort if no breadcrumb trail found.
			if ( empty( $items ) ) {
				return;
			}

			/**
			 * Render breadcrumb markup.
			 */

			$i = 1;

			// Opening tag.
			$html = '<ol class="cakecious-breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">';

			// Always add "Home" as the first trail.
			$html .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . esc_url( home_url( '/' ) ) . '"><span itemprop="name">' . esc_html__( 'Home', 'cakecious' ) . '</span></a><meta itemprop="position" content="' . esc_attr( $i ) . '" /></li>';

			// Add other trails.
			foreach ( $items as $index => $item ) {
				$html .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';

					if ( isset( $item['url'] ) && ! empty( $item['url'] ) ) {
						$html .= '<a itemprop="item" href="' . esc_url( $item['url'] ) . '"><span itemprop="name">' . esc_html( $item['label'] ) . '</span></a>';
					} else {
						$html .= '<span itemprop="name">' . esc_html( $item['label'] ) . '</span>';
					}
					$html .= '<meta itemprop="position" content="' . esc_attr( ++$i ) . '" />';

				$html .= '</li>';
			}

			// Closing tag.
			$html .= '</ol>';

			break;
	}

	echo do_shortcode($html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
endif;

if ( ! function_exists( 'cakecious_title' ) ) :
/**
 * Render current page title.
 */
function cakecious_title() {
	if ( is_search() ) {
		cakecious_search_title();
	}

	elseif ( is_singular() ) {

	}
}
endif;

/**
 * ====================================================
 * Header template functions
 * ====================================================
 */

if ( ! function_exists( 'cakecious_skip_to_content_link' ) ) :
/**
 * Render skip to content link.
 */
function cakecious_skip_to_content_link() {
	?>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'cakecious' ); ?></a>
	<?php
}
endif;

if ( ! function_exists( 'cakecious_header' ) ) :
/**
 * Render header wrapper.
 */
function cakecious_header() {
	?>
	<header id="masthead" class="cakecious-header site-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">
		<?php
		/**
		 * Hook: cakecious/frontend/header
		 *
		 * @hooked cakecious_main_header - 10
		 * @hooked cakecious_mobile_header - 10
		 */
		do_action( 'cakecious/frontend/header' );
		?>
	</header>
	<?php
}
endif;

if ( ! function_exists( 'cakecious_mobile_vertical_header' ) ) :
/**
 * Render mobile vertical header.
 */
function cakecious_mobile_vertical_header() {
	if ( intval( cakecious_get_current_page_setting( 'disable_mobile_header' ) ) ) {
		return;
	}

	cakecious_get_template_part( 'header-mobile-vertical' );
}
endif;

if ( ! function_exists( 'cakecious_main_header' ) ) :
/**
 * Render main header.
 */
function cakecious_main_header() {
	if ( intval( cakecious_get_current_page_setting( 'disable_header' ) ) ) {
		return;
	}

	cakecious_get_template_part( 'header-desktop' );
}
endif;

if ( ! function_exists( 'cakecious_main_header__top_bar' ) ) :
/**
 * Render main header bar.
 *
 * @param boolean $merged
 */
function cakecious_main_header__top_bar( $merged = false ) {
	cakecious_get_template_part( 'header-desktop-top-bar', null, array( 'merged' => $merged ) );
}
endif;

if ( ! function_exists( 'cakecious_main_header__main_bar' ) ) :
/**
 * Render main header bar.
 */
function cakecious_main_header__main_bar() {
	cakecious_get_template_part( 'header-desktop-main-bar' );
}
endif;

if ( ! function_exists( 'cakecious_main_header__bottom_bar' ) ) :
/**
 * Render main header bar.
 *
 * @param boolean $merged
 */
function cakecious_main_header__bottom_bar( $merged = false ) {
	cakecious_get_template_part( 'header-desktop-bottom-bar', null, array( 'merged' => $merged ) );
}
endif;

if ( ! function_exists( 'cakecious_mobile_header' ) ) :
/**
 * Render mobile header.
 */
function cakecious_mobile_header() {
	if ( intval( cakecious_get_current_page_setting( 'disable_mobile_header' ) ) ) {
		return;
	}

	cakecious_get_template_part( 'header-mobile' );
}
endif;

if ( ! function_exists( 'cakecious_header_element' ) ) :
/**
 * Wrapper function to print HTML markup for all header element.
 * 
 * @param string $slug
 */
function cakecious_header_element( $slug ) {
	// Abort if element slug is empty.
	if ( empty( $slug ) ) {
		return;
	}

	// Classify element into its type.
	$type = preg_replace( '/-\d$/', '', $slug );

	// Add passing variables.
	$variables = array( 'slug' => $slug );

	// Get header element template.
	$html = cakecious_get_template_part( 'header-element-' . $type, null, $variables, false );

	// Filters to modify the final HTML tag.
	$html = apply_filters( 'cakecious/frontend/header_element', $html, $slug );
	$html = apply_filters( 'cakecious/frontend/header_element/' . $slug, $html );

	echo do_shortcode($html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
endif;

/**
 * ====================================================
 * Content section template functions
 * ====================================================
 */

if ( ! function_exists( 'cakecious_hero' ) ) :
/**
 * Render page header section.
 */
function cakecious_hero() {
	cakecious_get_template_part( 'hero' );
}
endif;

if ( ! function_exists( 'cakecious_content_header' ) ) :
/**
 * Render content header.
 */
function cakecious_content_header() {
	// Render content header inside Content section if only it hasn't been rendered in Hero Section.
	if ( ! did_action( 'cakecious/frontend/content_header' ) ) {
		cakecious_get_template_part( 'content-header' );
	}
}
endif;

if ( ! function_exists( 'cakecious_content_open' ) ) :
/**
 * Render content section opening tags.
 */
function cakecious_content_open() {
	cakecious_get_template_part( 'content-open' );
}
endif;

if ( ! function_exists( 'cakecious_content_close' ) ) :
/**
 * Render content section closing tags.
 */
function cakecious_content_close() {
	cakecious_get_template_part( 'content-close' );
}
endif;

if ( ! function_exists( 'cakecious_primary_open' ) ) :
/**
 * Render main content opening tags.
 */
function cakecious_primary_open() {
	cakecious_get_template_part( 'content-primary-open' );
}
endif;

if ( ! function_exists( 'cakecious_primary_close' ) ) :
/**
 * Render main content closing tags.
 */
function cakecious_primary_close() {
	cakecious_get_template_part( 'content-primary-close' );
}
endif;

/**
 * ====================================================
 * Footer template functions
 * ====================================================
 */

if ( ! function_exists( 'cakecious_footer' ) ) :
/**
 * Render footer wrapper.
 */
function cakecious_footer() {
	?>
	<footer id="colophon" class="site-footer cakecious-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
		<?php
		/**
		 * Hook: cakecious/frontend/footer
		 *
		 * @hooked cakecious_main_footer - 10
		 */
		do_action( 'cakecious/frontend/footer' );
		?>
	</footer>
	<?php
}
endif;

if ( ! function_exists( 'cakecious_main_footer' ) ) :
/**
 * Render footer sections.
 */
function cakecious_main_footer() {
	// Widgets Bar
	cakecious_footer_widgets();
	
	// Bottom Bar (if not merged)
	if ( ! intval( cakecious_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
		cakecious_footer_bottom();
	}
}
endif;

if ( ! function_exists( 'cakecious_footer_widgets' ) ) :
/**
 * Render footer widgets area.
 */
function cakecious_footer_widgets() {
	if ( intval( cakecious_get_current_page_setting( 'disable_footer_widgets' ) ) ) {
		return;
	}

	cakecious_get_template_part( 'footer-widgets' );
}
endif;

if ( ! function_exists( 'cakecious_footer_bottom' ) ) :
/**
 * Render footer bottom bar.
 */
function cakecious_footer_bottom() {
	if ( intval( cakecious_get_current_page_setting( 'disable_footer_bottom' ) ) ) {
		return;
	}

	cakecious_get_template_part( 'footer-bottom' );
}
endif;

if ( ! function_exists( 'cakecious_footer_element' ) ) :
/**
 * Render each footer element.
 * 
 * @param string $slug
 */
function cakecious_footer_element( $slug ) {
	// Abort if element slug is empty.
	if ( empty( $slug ) ) {
		return;
	}

	// Classify element into its type.
	$type = preg_replace( '/-\d$/', '', $slug );

	// Add passing variables.
	$variables = array( 'slug' => $slug );

	// Get footer element template.
	$html = cakecious_get_template_part( 'footer-element-' . $type, null, $variables, false );

	// Filters to modify the final HTML tag.
	$html = apply_filters( 'cakecious/frontend/footer_element', $html, $slug );
	$html = apply_filters( 'cakecious/frontend/footer_element/' . $slug, $html );

	echo do_shortcode($html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
endif;

if ( ! function_exists( 'cakecious_scroll_to_top' ) ) :
/**
 * Print scroll to top button.
 */
function cakecious_scroll_to_top() {
	if ( ! intval( cakecious_get_theme_mod( 'scroll_to_top' ) ) ) {
		return;
	}
	
	cakecious_get_template_part( 'scroll-to-top' );
}
endif;

/**
 * ====================================================
 * Entry template functions
 * ====================================================
 */

if ( ! function_exists( 'cakecious_entry_meta_element' ) ) :
/**
 * Print entry meta element.
 */
function cakecious_entry_meta_element( $element ) {
	switch ( $element ) {
		case 'date':
			$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
			if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
				$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated screen-reader-text" datetime="%3$s">%4$s</time>';
			}
			$time_string = sprintf( $time_string,
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() ),
				esc_attr( get_the_modified_date( 'c' ) ),
				esc_html( get_the_modified_date() )
			);

			echo '<span class="entry-meta-date"><a href="' . esc_url( get_permalink() ) . '" class="posted-on">' . $time_string . '</a></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			break;

		case 'author':
			echo '<span class="entry-meta-author author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author_meta( 'display_name' ) ) . '</a></span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			break;

		case 'avatar':
			echo '<span class="entry-meta-author-avatar">' . get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'cakecious/frontend/meta_avatar_size', 24 ) ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			break;

		case 'categories':
			echo '<span class="entry-meta-categories cat-links">' . get_the_category_list( esc_html_x( ', ', 'terms list separator', 'cakecious' ) ) . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			break;

		case 'tags':
			echo ( '<span class="entry-meta-tags tags-links">' . get_the_tag_list( '', esc_html_x( ', ', 'terms list separator', 'cakecious' ) ) . '</span>' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			break;

		case 'comments':
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
				echo '<span class="entry-meta-comments comments-link">';
				comments_popup_link();
				echo '</span>';
			}
			break;
	}
}
endif;

if ( ! function_exists( 'cakecious_entry_tags' ) ) :
/**
 * Print tags links.
 */
function cakecious_entry_tags() {
	$tags_list = get_the_tag_list( '', '' );

	if ( $tags_list ) {
		echo '<div class="entry-tags tagcloud cakecious-float-container">' . $tags_list . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}
}
endif;

if ( ! function_exists( 'cakecious_entry_comments' ) ) :
/**
 * Print comments block in single post page.
 */
function cakecious_entry_comments() {
	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}
endif;

if ( ! function_exists( 'cakecious_entry_title' ) ) :
/**
 * Print entry title on each post.
 *
 * @param boolean $size
 */
function cakecious_entry_title( $size = '' ) {
	if ( is_singular() ) {
		the_title( '<h1 class="entry-title">', '</h1>' );
	} else {
		the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
	}
}
endif;

if ( ! function_exists( 'cakecious_entry_excerpt' ) ) :
/**
 * Render entry excerpt.
 */
function cakecious_entry_excerpt() {
	// Abort if there is no excerpt found in the page / post.
	if ( ! has_excerpt() ) {
		return;
	}

	ob_start();
	the_excerpt();
	$excerpt = ob_get_clean();

	?><div class="entry-excerpt excerpt"><?php the_excerpt(); ?></div><?php
}
endif;

if ( ! function_exists( 'cakecious_entry_thumbnail' ) ) :
/**
 * Print post thumbnail.
 */
function cakecious_entry_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	printf(
		'<%s class="%s">%s</%s>',
		is_singular() ? 'div' : 'a href="' . esc_url( get_the_permalink() ) . '"',
		esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/entry/thumbnail_classes', array( 'entry-thumbnail' ) ) ) ),
		get_the_post_thumbnail(
			get_the_ID(),
			cakecious_get_theme_mod( 'entry_thumbnail_size' )
		),
		is_singular() ? 'div' : 'a' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}
endif;

if ( ! function_exists( 'cakecious_entry_meta' ) ) :
/**
 * Print entry meta.
 *
 * @param string $format
 */
function cakecious_entry_meta( $format ) {
	if ( 'post' !== get_post_type() ) {
		return;
	}

	$format = trim( $format );
	$html = $format;

	if ( ! empty( $format ) ) {
		preg_match_all( '/{{(.*?)}}/', $format, $matches, PREG_SET_ORDER );

		foreach ( $matches as $match ) {
			ob_start();
			cakecious_entry_meta_element( $match[1] );
			$meta = ob_get_clean();

			$html = str_replace( $match[0], $meta, $html );
		}

		if ( '' !== trim( $html ) ) {
			echo '<div class="entry-meta">' . $html . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
}
endif;

if ( ! function_exists( 'cakecious_single_entry_header_meta' ) ) :
/**
 * Print single entry header meta.
 */
function cakecious_single_entry_header_meta() {
	cakecious_entry_meta( cakecious_get_theme_mod( 'post_single_content_header_meta' ) );
}
endif;

if ( ! function_exists( 'cakecious_single_entry_footer_meta' ) ) :
/**
 * Print single entry footer meta.
 */
function cakecious_single_entry_footer_meta() {
	cakecious_entry_meta( cakecious_get_theme_mod( 'post_single_content_footer_meta' ) );
}
endif;

if ( ! function_exists( 'cakecious_single_entry_thumbnail' ) ) :
/**
 * Print post thumbnail.
 */
function cakecious_single_entry_thumbnail() {
	if ( intval( cakecious_get_current_page_setting( 'content_hide_thumbnail' ) ) ) {
		return;
	}

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	printf(
		'<%s class="%s">%s</%s>',
		is_singular() ? 'div' : 'a href="' . esc_url( get_the_permalink() ) . '"',
		esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/single_entry/thumbnail_classes', array( 'entry-thumbnail' ) ) ) ),
		get_the_post_thumbnail(
			get_the_ID(),
			'full'
		),
		is_singular() ? 'div' : 'a' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}
endif;

if ( ! function_exists( 'cakecious_page_entry_thumbnail' ) ) :
/**
 * Print post thumbnail.
 */
function cakecious_page_entry_thumbnail() {
	if ( intval( cakecious_get_current_page_setting( 'content_hide_thumbnail' ) ) ) {
		return;
	}

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	printf(
		'<%s class="%s">%s</%s>',
		is_singular() ? 'div' : 'a href="' . esc_url( get_the_permalink() ) . '"',
		esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/page_entry/thumbnail_classes', array( 'entry-thumbnail' ) ) ) ),
		get_the_post_thumbnail(
			get_the_ID(),
			'full'
		),
		is_singular() ? 'div' : 'a' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}
endif;

if ( ! function_exists( 'cakecious_entry_header_meta' ) ) :
/**
 * Print entry header meta.
 */
function cakecious_entry_header_meta() {
	cakecious_entry_meta( cakecious_get_theme_mod( 'entry_header_meta' ) );
}
endif;

if ( ! function_exists( 'cakecious_entry_footer_meta' ) ) :
/**
 * Print entry footer meta.
 */
function cakecious_entry_footer_meta() {
	cakecious_entry_meta( cakecious_get_theme_mod( 'entry_footer_meta' ) );
}
endif;

if ( ! function_exists( 'cakecious_entry_grid_title' ) ) :
/**
 * Print entry grid title.
 */
function cakecious_entry_grid_title() {
	cakecious_entry_small_title();
}
endif;

if ( ! function_exists( 'cakecious_entry_grid_thumbnail' ) ) :
/**
 * Print entry grid post thumbnail.
 */
function cakecious_entry_grid_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	printf(
		'<%s class="%s">%s</%s>',
		is_singular() ? 'div' : 'a href="' . esc_url( get_the_permalink() ) . '"',
		esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/entry_grid/thumbnail_classes', array( 'entry-thumbnail', 'entry-grid-thumbnail' ) ) ) ),
		get_the_post_thumbnail(
			get_the_ID(),
			cakecious_get_theme_mod( 'entry_grid_thumbnail_size' )
		),
		is_singular() ? 'div' : 'a' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
}
endif;

if ( ! function_exists( 'cakecious_entry_grid_header_meta' ) ) :
/**
 * Print entry grid header meta.
 */
function cakecious_entry_grid_header_meta() {
	cakecious_entry_meta( cakecious_get_theme_mod( 'entry_grid_header_meta' ) );
}
endif;

if ( ! function_exists( 'cakecious_entry_grid_footer_meta' ) ) :
/**
 * Print entry grid footer meta.
 */
function cakecious_entry_grid_footer_meta() {
	cakecious_entry_meta( cakecious_get_theme_mod( 'entry_grid_footer_meta' ) );
}
endif;

if ( ! function_exists( 'cakecious_entry_small_title' ) ) :
/**
 * Print entry small title.
 */
function cakecious_entry_small_title() {
	if ( is_singular() ) {
		the_title( '<h1 class="entry-small-title small-title">', '</h1>' );
	} else {
		the_title( sprintf( '<h2 class="entry-small-title small-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
	}
}
endif;

/**
 * ====================================================
 * All index pages template functions
 * ====================================================
 */

if ( ! function_exists( 'cakecious_archive_title' ) ) :
/**
 * Render archive title.
 */
function cakecious_archive_title() {
	the_archive_title( '<h1 class="page-title">', '</h1>' );
}
endif;

if ( ! function_exists( 'cakecious_archive_description' ) ) :
/**
 * Render archive description.
 */
function cakecious_archive_description() {
	if ( ! is_post_type_archive() ) {
		the_archive_description( '<div class="archive-description">', '</div>' );
	}
}
endif;

if ( ! function_exists( 'cakecious_search_title' ) ) :
/**
 * Render search title.
 */
function cakecious_search_title() {
	?>
	<h1 class="page-title">
		<?php
		// Title
		$title = cakecious_get_theme_mod( 'search_results_title_text' );
		if ( empty( $title ) ) {
			$title = esc_html__( 'Search results for: "{{keyword}}"', 'cakecious' );
		}

		// Parse syntax.
		$title = preg_replace( '/\{\{keyword\}\}/', '<span>' . get_search_query() . '</span>', $title );

		echo wp_kses_post( $title );
		?>
	</h1>
	<?php
}
endif;

if ( ! function_exists( 'cakecious_search_form' ) ) :
/**
 * Render search form.
 */
function cakecious_search_form() {
	// Print WordPress's default search form.
	get_search_form();
}
endif;

if ( ! function_exists( 'cakecious_loop_navigation' ) ) :
/**
 * Render posts loop navigation.
 */
function cakecious_loop_navigation() {
	if ( ! is_archive() && ! is_home() && ! is_search() ) {
		return;
	}
	
	// Render posts navigation.
	switch ( cakecious_get_theme_mod( 'blog_index_navigation_mode' ) ) {
		case 'pagination':
			the_posts_pagination( array(
				'mid_size'  => 3,
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;',
			) );
			break;
		
		default:
			the_posts_navigation( array(
				'prev_text' => esc_html__( 'Older Posts', 'cakecious' ) . ' &raquo;',
				'next_text' => '&laquo; ' . esc_html__( 'Newer Posts', 'cakecious' ),
			) );
			break;
	}
}
endif;

/**
 * ====================================================
 * Single post template functions
 * ====================================================
 */

if ( ! function_exists( 'cakecious_singular_title' ) ) :
/**
 * Render singular title.
 */
function cakecious_singular_title() {
	the_title( '<h1 class="page-title">', '</h1>' );
}
endif;

if ( ! function_exists( 'cakecious_single_post_author_bio' ) ) :
/**
 * Render author bio block in single post page.
 */
function cakecious_single_post_author_bio() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	cakecious_get_template_part( 'blog-author-bio' );
}
endif;

if ( ! function_exists( 'cakecious_single_post_navigation' ) ) :
/**
 * Render prev / next post navigation in single post page.
 */
function cakecious_single_post_navigation() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	the_post_navigation( array(
		/* translators: %s: title syntax. */
		'prev_text' => sprintf( esc_html__( '%s &raquo;', 'cakecious' ), '%title' ),
		/* translators: %s: title syntax. */
		'next_text' => sprintf( esc_html__( '&laquo; %s', 'cakecious' ), '%title' ),
	) );
}
endif;

if ( ! function_exists( 'cakecious_comments_title' ) ) :
/**
 * Render comments title.
 */
function cakecious_comments_title() {
	?>
	<h2 class="comments-title">
		<?php
			$comments_count = get_comments_number();
			if ( '1' === $comments_count ) {
				printf(
					/* translators: %1$s: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'cakecious' ),
					'<span>' . get_the_title() . '</span>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			} else {
				printf(
					/* translators: %1$s: comment count number, %2$s: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comments_count, 'comments title', 'cakecious' ) ),
					number_format_i18n( $comments_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . get_the_title() . '</span>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
			?>
	</h2>
	<?php
}
endif;

if ( ! function_exists( 'cakecious_comments_navigation' ) ) :
/**
 * Render comments navigation.
 */
function cakecious_comments_navigation() {
	the_comments_navigation();
}
endif;

if ( ! function_exists( 'cakecious_comments_closed' ) ) :
/**
 * Render comments closed message.
 */
function cakecious_comments_closed() {
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'cakecious' ); ?></p>
	<?php endif;
}
endif;