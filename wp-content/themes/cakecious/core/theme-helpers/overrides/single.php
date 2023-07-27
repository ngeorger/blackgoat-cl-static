<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Header
 */
get_header();

/**
 * Primary - opening tag
 */
cakecious_primary_open();

/**
 * Hook: cakecious/frontend/before_main
 */
do_action( 'cakecious/frontend/before_main' );

while ( have_posts() ) : the_post();

	// Render post content using "content" layout.
	get_template_part( 'inc/theme-helpers/overrides/entry-default' );

endwhile;

		if ( has_action( 'cakecious/frontend/entry/footer' ) ) :
		?>
			<footer class="entry-footer <?php echo esc_attr( 'cakecious-text-align-' . cakecious_get_theme_mod( 'entry_footer_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: cakecious/frontend/entry/footer
				 *
				 * @hooked cakecious_entry_footer_meta - 10
				 */
				do_action( 'cakecious/frontend/entry/footer' );
				?>
			</footer>
		<?php
		endif;

/**
 * Hook: cakecious/frontend/after_main
 * 
 * @hooked cakecious_single_post_author_bio - 10
 * @hooked cakecious_single_post_navigation - 15
 * @hooked cakecious_entry_comments - 20
 */
do_action( 'cakecious/frontend/after_main' );

/**
 * Primary - closing tag
 */
cakecious_primary_close();

/**
 * Sidebar
 */
get_sidebar();

/**
 * Footer
 */
get_footer();