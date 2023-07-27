<?php
/**
 * Default entry template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'cakecious/frontend/entry/classes', array( 'entry', 'entry-layout-default' ) ) ); ?> role="article">
	<div class="entry-wrapper">
		<?php
		/**
		 * Hook: cakecious/frontend/entry/before_header
		 *
		 * @hooked cakecious_entry_thumbnail - 10
		 */
		do_action( 'cakecious/frontend/entry/before_header' );

		if ( has_action( 'cakecious/frontend/entry/header' ) ) :
		?>
			<header class="entry-header <?php echo esc_attr( 'cakecious-text-align-' . cakecious_get_theme_mod( 'entry_header_alignment' ) ); ?>">
				<?php
				/**
				 * Hook: cakecious/frontend/entry/header
				 *
				 * @hooked cakecious_entry_header_meta - 10
				 * @hooked cakecious_entry_title - 20
				 */
				do_action( 'cakecious/frontend/entry/header' );
				?>
			</header>
		<?php
		endif;

		/**
		 * Hook: cakecious/frontend/entry/after_header
		 */
		do_action( 'cakecious/frontend/entry/after_header' );
		?>

		<div class="entry-content">
			<?php
			/**
			 * Hook: cakecious/frontend/entry/before_content
			 */
			do_action( 'cakecious/frontend/entry/before_content' );

			// If it's included in a single post page.
			if ( is_single() ) {
				// Print the content.
				the_content();

				// Print content pagination, if exists.
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cakecious' ),
					'after'  => '</div>',
				) );
			}
			// If it's included in a posts archive page.
			else {
				if ( 0 < intval( cakecious_get_theme_mod( 'entry_excerpt_length' ) ) ) {
					// Excerpt
					the_excerpt();

					// Read more
					if ( '' !== cakecious_get_theme_mod( 'entry_read_more_display' ) ) {
						?>
						<p>
							<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="<?php echo esc_attr( cakecious_get_theme_mod( 'entry_read_more_display' ) ); ?>">
								<?php
								$text = cakecious_get_theme_mod( 'entry_read_more_text' );
								if ( empty( $text ) ) {
									$text = esc_html__( 'Read more', 'cakecious' );
								}

								echo esc_html( $text );
								?>
							</a>
						</p>
						<?php
					}
				}
			}

			/**
			 * Hook: cakecious/frontend/entry/after_content
			 */
			do_action( 'cakecious/frontend/entry/after_content' );
			?>
		</div>

		<?php
		/**
		 * Hook: cakecious/frontend/entry/before_footer
		 */
		do_action( 'cakecious/frontend/entry/before_footer' );

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
		 * Hook: cakecious/frontend/entry/after_footer
		 */
		do_action( 'cakecious/frontend/entry/after_footer' );
		?>
	</div>
</article>
