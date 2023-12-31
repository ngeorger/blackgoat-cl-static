<?php
/**
 * Search results entry template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'cakecious/frontend/entry_search/classes', array( 'entry', 'entry-layout-search', 'entry-small' ) ) ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: cakecious/frontend/entry_search/before_header
		 */
		do_action( 'cakecious/frontend/entry_search/before_header' );
		
		if ( has_action( 'cakecious/frontend/entry_search/header' ) ) :
		?>
			<header class="entry-header">
				<?php
				/**
				 * Hook: cakecious/frontend/entry_search/header
				 *
				 * @hooked cakecious_entry_search_title - 10
				 */
				do_action( 'cakecious/frontend/entry_search/header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: cakecious/frontend/entry_search/after_header
		 */
		do_action( 'cakecious/frontend/entry_search/after_header' );
		?>

		<div class="entry-content entry-excerpt">
			<?php
			/**
			 * Hook: cakecious/frontend/entry_search/before_content
			 */
			do_action( 'cakecious/frontend/entry_search/before_content' );

			/**
			 * Excerpt
			 */

			the_excerpt();

			// Content pagination (if exists)
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cakecious' ),
				'after'  => '</div>',
			) );
			
			/**
			 * Hook: cakecious/frontend/entry_search/after_content
			 */
			do_action( 'cakecious/frontend/entry_search/after_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: cakecious/frontend/entry_search/before_footer
		 */
		do_action( 'cakecious/frontend/entry_search/before_footer' );
		
		if ( has_action( 'cakecious/frontend/entry_search/footer' ) ) :
		?>
			<footer class="entry-footer">
				<?php
				/**
				 * Hook: cakecious/frontend/entry_search/footer
				 */
				do_action( 'cakecious/frontend/entry_search/footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: cakecious/frontend/entry_search/after_footer
		 */
		do_action( 'cakecious/frontend/entry_search/after_footer' );
		?>
	</div>
</article>
