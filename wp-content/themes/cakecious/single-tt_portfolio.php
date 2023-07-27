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

	// Render post content using "post-entry" layout.
	cakecious_get_template_part( 'single-entry' );

endwhile;

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
?>

<?php } else { ?>

<?php do_action( 'tt_before_mainblock' ); ?>

<div class="blog_area blog_details mainblock" id="full-width-page-wrapper">

    <div  id="content" class="container">

	   <div class="row blog_inner">
		   <div id="primary" class="col-md-12 content-area">

	            <main id="main" class="site-main">

	                <?php while ( have_posts() ) : the_post(); ?>

	                    <?php get_template_part( 'templates/content', 'page' ); ?>

	                <?php endwhile; // end of the loop. ?>

	            </main><!-- #main -->

		    </div><!-- #primary -->
	    </div><!-- .row -->

    </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php }
/**
 * Footer
 */
get_footer();