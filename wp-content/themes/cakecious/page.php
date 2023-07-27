<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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

<div class="mainblock" id="full-width-page-wrapper">

    <div  id="content" class="container">

	   <div class="row blog_inner">
		   <div id="primary" class="col-md-12 content-area">

	            <main id="main" class="site-main">

	                <?php while ( have_posts() ) : the_post(); ?>

	                    <?php get_template_part( 'templates/content', 'page' ); ?>

	                    <?php
	                        // If comments are open or we have at least one comment, load up the comment template
	                        if ( comments_open() || get_comments_number() ) :

	                            comments_template();

	                        endif;
	                    ?>

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