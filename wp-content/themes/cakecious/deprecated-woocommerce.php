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


<?php do_action( 'tt_before_mainblock' ); ?>

<?php
$enable_prod_sidebar = '0';
if(is_active_sidebar( 'shop' ) ) $show_sidebar = '1';
if ( is_product() && $show_sidebar ) {
	$enable_prod_sidebar = cakecious_fw_get_option('enable_prod_sidebar', '0');
	if( ! $enable_prod_sidebar ) $show_sidebar = '0';
}
?>
<div class="mainblock product_area" id="full-width-page-wrapper">

    <div id="content" class="container">

	   <div class="row product_inner_row">

		   <div id="primary" class="<?php if ( $show_sidebar ) : ?>col-lg-9<?php else : ?>col-lg-12<?php endif; ?> content-area">

	            <main id="main" class="site-main">

	            <!-- The WooCommerce loop -->
                <?php woocommerce_content(); ?>

	            </main><!-- #main -->

		   </div><!-- #primary -->

			<?php if ( $show_sidebar ) get_sidebar('shop'); ?>

	    </div><!-- .row -->

    </div><!-- Container end -->

</div><!-- Wrapper end -->

<?php }
/**
 * Footer
 */
get_footer();