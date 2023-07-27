<?php
/**
 * Migrate to 1.3.0
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

class Cakecious_Migrate_1_3_0 {

	/**
	 * Singleton instance
	 *
	 * @var Cakecious_Migrate_1_3_0
	 */
	private static $instance;

	/**
	 * ====================================================
	 * Singleton & constructor functions
	 * ====================================================
	 */

	/**
	 * Get singleton instance.
	 *
	 * @return Cakecious_Migrate_1_3_0
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Class constructor
	 */
	protected function __construct() {
		$this->migrate_page_template_slug();
		$this->migrate_page_header_title_text();
		$this->migrate_content_layout_narrow();
		$this->migrate_page_header_to_hero_section();
		$this->migrate_featured_media_to_thumbnail();

		$this->migrate_page_settings_keys();
	}

	/**
	 * ====================================================
	 * Private functions
	 * ====================================================
	 */

	/**
	 * Migrate all pages with "page-builder" page template to "page_builder".
	 *
	 * Why:
	 * "page-" is a reserved page template format (ref: https://developer.wordpress.org/themes/template-files-section/page-template-files/#creating-custom-page-templates-for-global-use).
	 * The possible bad case: If user created a page with "builder" as its slug, WordPress will mistakenly use "page-builder" page template for that page even if user didn't set the page template to "page-builder".
	 */
	private function migrate_page_template_slug() {
		$posts = get_posts( array(
			'posts_per_page' => -1,
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/page-builder.php',
		) );

		foreach ( $posts as $post ) {
			update_post_meta( $post, '_wp_page_template', 'page-templates/page_builder.php' );
		}
	}

	/**
	 * Migrate all page header title text option keys.
	 *
	 * Why:
	 * The title text should affect the content header title as well not just the page header title.
	 */
	private function migrate_page_header_title_text() {
		foreach ( Cakecious_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
			// Define the option key.
			$option_key = 'page_settings_' . $ps_type;

			// Get the values.
			$mod = get_theme_mod( $option_key, array() );

			// Process title text for 404 and search page.
			if ( in_array( $ps_type, array( 'search', 'error_404' ) ) ) {
				// Check if user ever filled the custom title text options.
				if ( isset( $mod['page_header_title_text__' . $ps_type ] ) ) {
					// Move the value to a new key.
					set_theme_mod( $ps_type . '_title', $mod['page_header_title_text__' . $ps_type ] );

					// Remove the old key.
					unset( $mod['page_header_title_text__' . $ps_type ] );
				}
			}
			
			// Process title text for archive pages.
			elseif ( 0 < strpos( $ps_type, '_archive' ) ) {
				// Check if user ever filled the custom title text options.
				if ( isset( $mod['page_header_title_text__post_type_archive'] ) ) {
					// Move the value to a new key.
					$mod['title_text'] = $mod['page_header_title_text__post_type_archive'];

					// Remove the old key.
					unset( $mod['page_header_title_text__post_type_archive'] );
				}

				// Check if user ever filled the custom title text options.
				if ( isset( $mod['page_header_title_text__taxonomy_archive'] ) ) {
					// Move the value to a new key.
					$mod['tax_title_text'] = $mod['page_header_title_text__taxonomy_archive'];

					// Remove the old key.
					unset( $mod['page_header_title_text__taxonomy_archive'] );
				}
			}

			// Save the new values.
			set_theme_mod( $option_key, $mod );
		}
	}

	/**
	 * Migrate content narrow to custom container width.
	 *
	 * Why:
	 * It doesn't make sense when user chooses "Full width" in "Content container" option and chooses "Narrow" in the "Content and sidebar layout" option.
	 *
	 * The previous implementation:
	 * - User choose between "Wrapped" and "Full width" in the "Content container" option.
	 * - User choose "Narrow" in the "Content and sidebar layout" option.
	 *
	 * The new implementation:
	 * - User choose between "Wrapped", "Full width", and the new "Custom" option in the "Content container" option.
	 * - Custom means user can manually input the container width.
	 * - There is no longer "Narrow" option in the "Content and sidebar layout" option (because user can set the container width).
	 */
	private function migrate_content_layout_narrow() {
		/**
		 * Global settings
		 */

		// If the selected value of "content_layout" is "narrow".
		if ( 'narrow' === get_theme_mod( 'content_layout' ) ) {
			// Change it to "wide".
			set_theme_mod( 'content_layout', 'wide' );

			// And then change the "content_container" value to "custom".
			set_theme_mod( 'content_container', 'narrow' );
		}

		/**
		 * Page settings
		 */

		foreach ( Cakecious_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
			// Define the option key.
			$option_key = 'page_settings_' . $ps_type;

			// Get the values.
			$mod = get_theme_mod( $option_key, array() );

			// If the selected value of "content_layout" is "narrow".
			if ( isset( $mod['content_layout'] ) && 'narrow' === $mod['content_layout'] ) {
				// Change it to "wide".
				$mod['content_layout'] = 'wide';

				// And then change the "content_container" value to "custom".
				$mod['content_container'] = 'narrow';
			}

			// Set the new values.
			set_theme_mod( $option_key, $mod );
		}
	}

	/**
	 * Migrate page header settings to hero section.
	 *
	 * The previous implementation:
	 * - Use "page_header_" prefix.
	 *
	 * The new implementation:
	 * - Use "hero_" prefix.
	 */
	private function migrate_page_header_to_hero_section() {
		/**
		 * Global settings
		 */

		$mods = get_theme_mods();

		foreach ( $mods as $key => $value ) {
			if ( false !== strpos( $key, 'page_header_' ) ) {
				$new_key = str_replace( 'page_header_', 'hero_', $key );

				remove_theme_mod( $key );

				set_theme_mod( $new_key, $value );
			}
		}

		/**
		 * Page settings
		 */

		foreach ( Cakecious_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
			// Define the option key.
			$option_key = 'page_settings_' . $ps_type;

			// Get the values.
			$mod = get_theme_mod( $option_key, array() );

			foreach ( $mod as $key => $value ) {
				if ( false !== strpos( $key, 'page_header_' ) ) {
					$new_key = str_replace( 'page_header_', 'hero_', $key );

					unset( $mod[ $key ] );

					$mod[ $new_key ] = $value;
				}
			}

			// Set the new values.
			set_theme_mod( $option_key, $mod );
		}
	}

	/**
	 * Migrate customizer option keys "featured_media" to "thumbnail".
	 *
	 * The previous implementation:
	 * - Use "featured_media" as slug.
	 *
	 * The new implementation:
	 * - Use "thumbnail" as slug.
	 */
	private function migrate_featured_media_to_thumbnail() {
		/**
		 * Global settings
		 */

		$mods = get_theme_mods();

		foreach ( $mods as $key => $value ) {
			if ( false !== strpos( $key, '_featured_media' ) ) {
				if ( strpos( $key, '_featured_media_position' ) ) {
					$key = str_replace( '_position', '', $key );
				}

				$new_key = str_replace( '_featured_media', '_thumbnail', $key );

				remove_theme_mod( $key );

				set_theme_mod( $new_key, $value );
			}
		}
	}

	/**
	 * Migrate page settings keys from array to non array.
	 *
	 * The previous implementation:
	 * - Page settings on each type is saved in an array with "page_settings_{type}[ {key} ]" key. For example: page_settings_post_single['content_layout'].
	 *
	 * The new implementation:
	 * - Page settings on each type is saved in non array with "{type}_{key}". For example: post_single_content_layout.
	 */
	private function migrate_page_settings_keys() {
		foreach ( Cakecious_Customizer::instance()->get_all_page_settings_types() as $ps_type => $ps_data ) {
			// Define the option key.
			$option_key = 'page_settings_' . $ps_type;

			// Get the values.
			$mod = get_theme_mod( $option_key, array() );

			foreach ( $mod as $key => $value ) {
				set_theme_mod( $ps_type . '_' . $option_key );
			}

			remove_theme_mod( $option_key );
		}
	}

}

Cakecious_Migrate_1_3_0::instance();