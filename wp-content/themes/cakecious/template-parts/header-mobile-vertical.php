<?php
/**
 * Mobile header vertical template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$elements = cakecious_get_theme_mod( 'header_mobile_elements_vertical_top', array() );
$display = cakecious_get_theme_mod( 'header_mobile_vertical_bar_display' );
?>
<div id="mobile-vertical-header" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/header_mobile_vertical_classes', array( 'cakecious-header-mobile-vertical', 'cakecious-header', 'cakecious-popup' ) ) ) ); ?>" itemscope itemtype="https://schema.org/WPHeader">
	<?php if ( 'drawer' === $display ) : ?>
		<div class="cakecious-popup-background cakecious-popup-close"></div>
	<?php endif; ?>

	<div class="cakecious-header-mobile-vertical-bar cakecious-header-section-vertical cakecious-popup-content">
		<div class="cakecious-header-section-vertical-column">
			<div class="cakecious-header-mobile-vertical-bar-top cakecious-header-section-vertical-row">
				<?php foreach ( $elements as $element ) cakecious_header_element( $element ); ?>
			</div>
		</div>

		<?php if ( 'full-screen' === $display ) : ?>
			<button class="cakecious-popup-close-icon cakecious-popup-close cakecious-toggle"><?php cakecious_icon( 'close' ); ?></button>
		<?php endif; ?>
	</div>
</div>