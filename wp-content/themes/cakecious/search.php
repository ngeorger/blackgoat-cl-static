<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Header
 */
get_header();

?>
<?php if ( cakecious_is_fresh_install() ) {

/**
 * Primary - opening tag
 */
cakecious_primary_open();

/**
 * Hook: cakecious/frontend/before_main
 *
 * @hooked cakecious_content_header - 10
 */
do_action( 'cakecious/frontend/before_main' );

if ( have_posts() ) :
	
	?>
	<div id="loop" class="cakecious-loop cakecious-loop-search">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Render post content using "content-search" layout on Customizer.
			cakecious_get_template_part( 'entry', 'search' );

		endwhile;
		?>
	</div>
	<?php

else :

	// Render not-found message.
	$not_found_message = cakecious_get_theme_mod( 'search_results_not_found_text' );
	if ( empty( $not_found_message ) ) {
		$not_found_message = esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'cakecious' );
	}
	echo wp_kses_post( wpautop( $not_found_message ) );

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

?>

<?php } else { ?>


<?php cakecious_hero_bg(); ?>

	<div class="main_blog_area p_100 mainblock" id="wrapper-index">
		<div class="container">
			<div class="row blog_area_inner">


				<div id="primary" class="<?php if ( is_active_sidebar( 'default-sidebar' ) ) : ?>col-md-9<?php else : ?>col-md-12<?php endif; ?>  blog_lift_sidebar content-area">

					<main id="main" class="site-main">

						<?php if ( is_archive() ) {
							the_archive_description( '<div class="taxonomy-description">', '</div>' );
							?>
						<?php } ?>

						<?php if ( is_search() ) { ?>
							<header class="page-header">
								<h1 class="page-title ml-title">
									<?php printf( esc_html__( 'Search Results for: %s', 'cakecious' ), '<span>' . get_search_query() . '</span>' ); ?>
								</h1>
							</header><!-- .page-header -->
						<?php } ?>

						<?php if ( have_posts() ) : ?>
							<div class="main_blog_inner">
								<?php /* Start the Loop */ ?>

								<?php while ( have_posts() ) : the_post(); ?>

									<?php
									/* Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									get_template_part( 'templates/content', get_post_format() );
									?>

								<?php endwhile; ?>
								<div class="blog_pagination">
									<?php
									// Previous/next page navigation.
									the_posts_pagination( array(
										'prev_text'          => esc_html__( '<', 'cakecious' ),
										'next_text'          => esc_html__( '>', 'cakecious' ),
										'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'cakecious' ) . ' </span>',
									) );
									?>
								</div>
							</div>
						<?php else : ?>

							<?php get_template_part( 'templates/content', 'none' ); ?>

						<?php endif; ?>

					</main>
					<!-- #main -->

				</div>
				<!-- #primary -->

				<?php get_sidebar(); ?>

			</div>
			<!-- .row -->

		</div>
		<!-- Container end -->

	</div><!-- Wrapper end -->

<?php }

/**
 * Footer
 */
get_footer();