<?php
/**
 * Template Name: Page with Sidebar - Deprecated
 *
 * @package cakecious
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
 */
do_action( 'cakecious/frontend/before_main' );

while ( have_posts() ) : the_post();

	// Render post content using "entry-page" layout.
	cakecious_get_template_part( 'page-entry' );

endwhile;

/**
 * Hook: cakecious/frontend/after_main
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

<?php do_action( 'tt_before_mainblock' ); ?>

	<?php cakecious_hero_bg(); ?>

	<div class="blog_area mainblock" id="wrapper-index">
		<div class="container">
			<div class="row blog_inner">


				<div id="primary" class="<?php if ( is_active_sidebar( 'default-sidebar' ) ) : ?>col-md-9<?php else : ?>col-md-12<?php endif; ?>  blog_lift_sidebar content-area">

					<main id="main" class="site-main has-right-sidebar">

							<div class="main_blog_inner">
								<?php /* Start the Loop */ ?>

								<?php while ( have_posts() ) : the_post(); ?>

									<?php
									/* Include the Post-Format-specific template for the content.
									 * If you want to override this in a child theme, then include a file
									 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
									 */
									get_template_part( 'templates/content', 'page' );
									?>
			                        <?php
			                            // If comments are open or we have at least one comment, load up the comment template
			                            if ( comments_open() || get_comments_number() ) :
			                                comments_template();
			                            endif;
			                        ?>

								<?php endwhile; ?>
							</div>

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