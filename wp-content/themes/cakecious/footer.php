<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<?php if ( cakecious_is_fresh_install() ) {

				/**
				 * Content
				 */
				if ( apply_filters( 'cakecious/frontend/show_content_wrapper', true ) ) {
					/**
					 * Content section - closing tag
					 */
					cakecious_content_close();
				}

				/**
				 * Hook: cakecious/frontend/before_footer
				 */
				do_action( 'cakecious/frontend/before_footer' );

				/**
				 * Footer
				 */
				cakecious_footer();
				
				/**
				 * Hook: cakecious/frontend/after_footer
				 */
				do_action( 'cakecious/frontend/after_footer' );
				?>
				
			</div>
		</div>

<?php } else { ?>

<?php if ( cakecious_fw_get_option( 'footer_newsletter', '0' ) ) { ?>
<section class="newsletter_area <?php echo footer_newsltr_class(); ?>">
    <div class="container">
        <div class="newsletter_inner">
			<div class="row">
				<div class="col-lg-6">
					<div class="news_left_text">
						<h4><?php echo cakecious_fw_get_option( 'ft_newsletter_title' ); ?></h4>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="newsletter_form">
						<div class="input-group">
							<?php print cakecious_fw_get_option( 'footer_newsletter_code' ); ?>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</section>
<?php } ?>


<footer class="footer_area">
	<?php

		$total = cakecious_fw_get_option('footer_sidebars', '4');

		if ( ( is_active_sidebar( 'footer-1' ) ||
			   is_active_sidebar( 'footer-2' ) ||
			   is_active_sidebar( 'footer-3' ) ||
			   is_active_sidebar( 'footer-4' ) ) && $total > 0 ) {
			   $BTcols = 3;
			   if ( $total == 4) $BTcols = 3; if ( $total == 3) $BTcols = 4; if ( $total == 2) $BTcols = 6; if ( $total == 1) $BTcols = 12;

	?>
    <div class="footer_widgets">
        <div class="container">
            <div class="row footer_wd_inner">

				<?php $i = 0; while ( $i < $total ) { $i++; ?>
					<?php if ( is_active_sidebar( 'footer-' . $i ) ) { ?>
						<div class="clearfix col-lg-<?php print esc_attr($BTcols); ?>  col-6 footer-widget-<?php print esc_attr($i); ?>">
				            <?php dynamic_sidebar( 'footer-' . $i ); ?>
						</div>
			        <?php } ?>
				<?php } // End WHILE Loop ?>

            </div>
        </div>
    </div>
	<?php } // End IF Statement ?>
    <div class="footer_copyright">
        <div class="container">
            <div class="copyright_inner">
                <div class="float-left">
                    <div>
				<?php if( cakecious_fw_get_option('footer_left', 1) ) {
					echo do_shortcode( wp_kses(cakecious_fw_get_option('footer_left_text'), cakecious_tt_allowed_tags()));
					} else {
						bloginfo(); ?> &copy; <?php echo date( 'Y' ) . esc_html__( ' All Rights Reserved.', 'cakecious' );
				} ?>
	                </div>
                </div>
                <div class="float-right">
				<?php if( cakecious_fw_get_option('footer_right', 1) ) {
					echo do_shortcode( wp_kses(cakecious_fw_get_option('footer_right_text'), cakecious_tt_allowed_tags()));
					} elseif( is_front_page() || is_home() ) {
					echo sprintf( esc_html__( ' Developed by %s.', 'fitzeous' ), '<a href="'.esc_url('https://bolvo.com').'">bolvo.com</a>');
					} else {
					esc_html_e( ' Developed by bolvo.com', 'fitzeous' );
					} ?>
                </div>
            </div>
        </div>
    </div>
</footer>
<!--================End Footer Area =================-->

<?php if ( cakecious_fw_get_option('enable_hdr_search', '1') ) {
$searchCPT = cakecious_fw_get_option('hdr_searchCPT');
if( empty($searchCPT) )	$searchCPT = 'post';
?>
	<div class="search_area zoom-anim-dialog mfp-hide" id="test-search">
    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url( '/' )); ?>">

    <div class="search_box_inner">
        <h3><?php echo esc_attr_x( 'Search', 'label', 'cakecious' ) ?></h3>
        <div class="input-group">
	        <input type="hidden" name="post_type" value="<?php echo esc_html($searchCPT); ?>">
	        <input type="search" class="search-field form-control"
	            placeholder="<?php echo esc_attr_x( 'Search ...', 'placeholder', 'cakecious' ) ?>"
	            value="<?php echo get_search_query() ?>" name="s"
	            title="<?php echo esc_attr_x( 'Search for:', 'label', 'cakecious' ) ?>" />

            <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="icon icon-Search"></i></button>
            </span>
        </div>
    </div>
    </form>
</div>
<?php }?>

<a href="#" class="scrollup"></a>
<?php }?>

		<?php
		/**
		 * Hook: cakecious/frontend/after_canvas
		 */
		do_action( 'cakecious/frontend/after_canvas' );
		
		/**
		 * Hook: wp_footer
		 */
		wp_footer();
		?>
	</body>
</html>