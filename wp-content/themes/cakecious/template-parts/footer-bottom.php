<?php
/**
 * Footer bottom section template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$cols = array( 'left', 'center', 'right' );

$elements = array();
$count = 0;

foreach ( $cols as $col ) {
	$elements[ $col ] = cakecious_get_theme_mod( 'footer_elements_bottom_' . $col, array() );
	$count += empty( $elements[ $col ] ) ? 0 : count( $elements[ $col ] );
}

if ( 1 > $count ) {
	return;
}

?>
<div id="cakecious-footer-bottom-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/footer_bottom_bar_classes', array( 'cakecious-footer-bottom-bar', 'site-info', 'cakecious-footer-section', 'cakecious-section' ) ) ) ); ?>">
	<div class="cakecious-footer-bottom-bar-inner cakecious-section-inner">
		<div class="cakecious-wrapper">
			<div class="cakecious-footer-bottom-bar-row cakecious-footer-row <?php echo esc_attr( ( 0 < count( $elements['center'] ) ) ? 'cakecious-footer-row-with-center' : '' ); ?>">
				<?php foreach ( $cols as $col ) : ?>
					<?php
					// Skip center column if it's empty
					if ( 'center' === $col && 0 === count( $elements[ $col ] ) ) {
						continue;
					}
					?>
					<div class="cakecious-footer-bottom-bar-<?php echo esc_attr( $col ); ?> cakecious-footer-bottom-bar-column">
						<?php
						// Print all elements inside the column.
						foreach ( $elements[ $col ] as $element ) {
							cakecious_footer_element( $element );
						}
						?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</div>