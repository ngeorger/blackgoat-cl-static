<?php
/**
 * Single post entry template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'cakecious/frontend/single_entry/classes', array( 'entry', 'entry-single' ) ) ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: cakecious/frontend/single_entry/before_header
		 *
		 * @hooked cakecious_entry_thumbnail - 10
		 */
		do_action( 'cakecious/frontend/single_entry/before_header' );
		
		if ( has_action( 'cakecious/frontend/single_entry/header' ) ) :
		?>
			<header class="entry-header <?php echo esc_attr( 'cakecious-text-align-' . cakecious_get_theme_mod( 'post_single_content_header_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: cakecious/frontend/single_entry/header
				 *
				 * @hooked cakecious_content_header - 10
				 */
				do_action( 'cakecious/frontend/single_entry/header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: cakecious/frontend/single_entry/after_header
		 *
		 * @hooked cakecious_entry_thumbnail - 10
		 */
		do_action( 'cakecious/frontend/single_entry/after_header' );
		?>

		<div class="entry-content">
			<?php
			/**
			 * Hook: cakecious/frontend/single_entry/before_content
			 */
			do_action( 'cakecious/frontend/single_entry/before_content' );

			// Print the content.
			the_content();

			// Print content pagination, if exists.
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cakecious' ),
				'after'  => '</div>',
			) );
			
			/**
			 * Hook: cakecious/frontend/single_entry/after_content
			 */
			do_action( 'cakecious/frontend/single_entry/after_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: cakecious/frontend/single_entry/before_footer
		 */
		do_action( 'cakecious/frontend/single_entry/before_footer' );
		
		if ( has_action( 'cakecious/frontend/single_entry/footer' ) ) :
		?>
			<footer class="entry-footer <?php echo esc_attr( 'cakecious-text-align-' . cakecious_get_theme_mod( 'post_single_content_footer_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: cakecious/frontend/single_entry/footer
				 * 
				 * @hooked cakecious_entry_tags - 10
				 * @hooked cakecious_entry_footer_meta - 20
				 */
				do_action( 'cakecious/frontend/single_entry/footer' );
				?>
			</footer>
		<?php
		endif;

		/**
		 * Hook: cakecious/frontend/single_entry/after_footer
		 */
		do_action( 'cakecious/frontend/single_entry/after_footer' );
		?>
	</div>
</div>
