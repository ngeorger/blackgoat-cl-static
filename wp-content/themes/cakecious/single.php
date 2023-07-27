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

<?php cakecious_hero_bg(); ?>

<!--================Blog Details Area =================-->
<div class="main_blog_area p_100 mainblock">
    <div class="container">
        <div class="row blog_inner">
            <div class="blog_lift_sidebar <?php if ( is_active_sidebar( 'default-sidebar' ) ) : ?> col-md-9 <?php else : ?>col-md-12<?php endif; ?>">
	                <main id="main" class="site-main main_blog_inner single_blog_inner">

	                    <?php while ( have_posts() ) : the_post(); ?>

	                        <?php get_template_part( 'templates/content', 'single' ); ?>

							<!-- Post nav -->
							<div class="clearfix mbottom20"></div>
							<?php if( function_exists('cakecious_tt_prev_post') ) echo cakecious_tt_prev_post(); ?>
							<?php if( function_exists('cakecious_tt_next_post') ) echo cakecious_tt_next_post(); ?>
							<div class="clearfix"></div>


	                        <?php
	                        // If comments are open or we have at least one comment, load up the comment template
	                        if ( comments_open() || get_comments_number() ) :
	                            comments_template();
	                        endif;
	                        ?>

	                    <?php endwhile; // end of the loop. ?>

	                </main><!-- #main -->
            </div>
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>

<?php }
/**
 * Footer
 */
get_footer();