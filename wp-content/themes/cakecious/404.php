<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
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
 * Error 404 content
 */
cakecious_get_template_part( 'error-404' );

} else {

?>
<section class="error_area">
    <div class="container">
		<div class="error_inner">
			<div class="error_inner_text">
				<h3><?php esc_html_e('404', 'cakecious'); ?></h3>
				<h4><?php esc_html_e('Oops! That page can not be found', 'cakecious'); ?></h4>
				<h5><?php esc_html_e('Sorry, but the page you are looking for does not exist.', 'cakecious'); ?></h5>
				<a class="pink_btn" href="<?php echo esc_url(home_url( '/' )); ?>"><?php esc_html_e('Go to home page', 'cakecious'); ?></a>
			</div>
		</div>
    </div>
</section>
<?php } ?>
<?php
/**
 * Footer
 */
get_footer();