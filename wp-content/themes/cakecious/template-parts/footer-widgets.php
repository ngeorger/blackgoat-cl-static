<?php
/**
 * Footer widgets section template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$columns = intval( cakecious_get_theme_mod( 'footer_widgets_bar' ) );

if ( 1 > $columns ) {
	return;
}

$print_row = 0;
for ( $i = 1; $i <= $columns; $i++ ) {
	if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
		$print_row = true;
		break;
	}
}
?>


<?php if ( 'yes' == cakecious_get_theme_mod( 'footer_newsletter', 'no' ) && defined('WC_PLUGIN_FILE')  && ! is_checkout() ) { ?>
<section class="newsletter_area">
    <div class="container">
        <div class="newsletter_inner">
			<div class="row">
				<div class="col-lg-6">
					<div class="news_left_text">
						<h4><?php echo wp_kses_post(cakecious_get_theme_mod( 'newsletter_title1' )); ?></h4>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="newsletter_form">
						<div class="input-group">
							<?php echo do_shortcode(cakecious_get_theme_mod( 'newsletter_content' )); ?>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>
</section>
<?php } ?>


<div id="cakecious-footer-widgets-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/footer_widgets_bar_classes', array( 'cakecious-footer-widgets-bar', 'cakecious-footer-section', 'cakecious-section' ) ) ) ); ?>">
	<div class="cakecious-footer-widgets-bar-inner cakecious-section-inner">
		<div class="cakecious-wrapper">
			<?php if ( $print_row ) : ?>
				<div class="cakecious-footer-widgets-bar-row <?php echo esc_attr( 'cakecious-footer-widgets-bar-columns-' . cakecious_get_theme_mod( 'footer_widgets_bar' ) ); ?>">
					<?php for ( $i = 1; $i <= $columns; $i++ ) : ?>
						<div class="cakecious-footer-widgets-bar-column-<?php echo esc_attr( $i ); ?> cakecious-footer-widgets-bar-column">
							<?php if ( is_active_sidebar( 'footer-widgets-' . $i ) ) {
								dynamic_sidebar( 'footer-widgets-' . $i );
							} ?>
						</div>
					<?php endfor; ?>
				</div>
			<?php endif; ?>

			<?php
			// Bottom Bar (if merged)
			if ( intval( cakecious_get_theme_mod( 'footer_bottom_bar_merged' ) ) ) {
				cakecious_footer_bottom();
			}
			?>

		</div>
	</div>
</div>