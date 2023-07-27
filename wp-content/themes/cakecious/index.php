<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
 */
do_action( 'cakecious/frontend/before_main' );

while ( have_posts() ) : the_post();

	// Render post content using "content" layout.
	cakecious_get_template_part( 'entry' );

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
								<h1 class="page-title2 ml-title">
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