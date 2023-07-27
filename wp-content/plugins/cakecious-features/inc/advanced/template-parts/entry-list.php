<?php
/**
 * List post entry template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( apply_filters( 'cakecious/frontend/entry_list/post_classes', array( 'entry', 'entry-layout-list', 'entry-small' ) ) ); ?> role="article">
	<div class="entry-wrapper">

		<?php if ( has_action( 'cakecious/frontend/entry_list/media' ) ) : ?>
			<div class="entry-list-media">
				<?php
				/**
				 * Hook: cakecious/frontend/entry_list/media
				 *
				 * @hooked Cakecious_Pro_Module_Blog_Layout_Plus::entry_list_thumbnail - 10
				 */
				do_action( 'cakecious/frontend/entry_list/media' );
				?>
			</div>
		<?php endif; ?>

		<div class="entry-list-text">
			<?php
			/**
			 * Hook: cakecious/frontend/entry_list/before_header
			 */
			do_action( 'cakecious/frontend/entry_list/before_header' );
			
			if ( has_action( 'cakecious/frontend/entry_list/header' ) ) :
			?>
				<header class="entry-header">
					<?php
					/**
					 * Hook: cakecious/frontend/entry_list/header
					 *
					 * @hooked Cakecious_Pro_Module_Blog_Layout_Plus::entry_list_header_meta - 10
					 * @hooked Cakecious_Pro_Module_Blog_Layout_Plus::entry_list_title - 20
					 */
					do_action( 'cakecious/frontend/entry_list/header' );
					?>
				</header>
			<?php
			endif;

			/**
			 * Hook: cakecious/frontend/entry_list/after_header
			 */
			do_action( 'cakecious/frontend/entry_list/after_header' );
			?>

			<div class="entry-content entry-excerpt">
				<?php
				/**
				 * Hook: cakecious/frontend/entry_list/before_content
				 */
				do_action( 'cakecious/frontend/entry_list/before_content' );

				/**
				 * Excerpt
				 */
				if ( 0 < intval( cakecious_get_theme_mod( 'entry_list_excerpt_length' ) ) ) {
					// Excerpt
					the_excerpt();

					// Read more
					if ( '' !== cakecious_get_theme_mod( 'entry_list_read_more_display' ) ) {
						?>
						<p>
							<a href="<?php echo esc_url( get_the_permalink() ); ?>" class="<?php echo esc_attr( cakecious_get_theme_mod( 'entry_list_read_more_display' ) ); ?>">
								<?php
								$text = cakecious_get_theme_mod( 'entry_list_read_more_text' );
								if ( empty( $text ) ) {
									$text = esc_html__( 'Read more', 'cakecious-features' );
								}

								echo esc_html( $text );
								?>
							</a>
						</p>
						<?php
					}
				}

				/**
				 * Hook: cakecious/frontend/entry_list/after_content
				 */
				do_action( 'cakecious/frontend/entry_list/after_content' );
				?>
			</div>

			<?php
			/**
			 * Hook: cakecious/frontend/entry_list/before_footer
			 */
			do_action( 'cakecious/frontend/entry_list/before_footer' );

			if ( has_action( 'cakecious/frontend/entry_list/footer' ) ) :
			?>
				<footer class="entry-footer">
					<?php
					/**
					 * Hook: cakecious/frontend/entry_list/footer
					 * 
					 * @hooked Cakecious_Pro_Module_Blog_Layout_Plus::entry_list_footer_meta - 10
					 */
					do_action( 'cakecious/frontend/entry_list/footer' );
					?>
				</footer>
			<?php
			endif;

			/**
			 * Hook: cakecious/frontend/entry_list/after_footer
			 */
			do_action( 'cakecious/frontend/entry_list/after_footer' );
			?>
		</div>
	</div>
</article>