<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<?php if ( cakecious_is_fresh_install() ) {

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
 *
 * @hooked cakecious_archive_header - 10
 */
do_action( 'cakecious/frontend/before_main' );

if ( have_posts() ) :

	/**
	 * Hook: cakecious/frontend/before_loop
	 */
	do_action( 'cakecious/frontend/before_loop' );
	
	?>
	<div id="loop" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/loop_classes', array( 'cakecious-loop' ) ) ) ); ?>">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Render post content using selected layout on Customizer.
			cakecious_get_template_part( 'entry', cakecious_get_theme_mod( 'blog_index_loop_mode' ) );

		endwhile;
		?>
	</div>
	<?php

	/**
	 * Hook: cakecious/frontend/after_loop
	 */
	do_action( 'cakecious/frontend/after_loop' );

else :

	// Render not-found message.
	esc_html_e( 'Nothing found.', 'cakecious' );

endif;

/**
 * Hook: cakecious/frontend/after_main
 * 
 * @hooked cakecious_loop_navigation - 10
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

?>

<?php } else {


	// Use same template as archive.php
	get_template_part( 'index' );

}

?>
