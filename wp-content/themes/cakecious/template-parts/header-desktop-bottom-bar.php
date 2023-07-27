<?php
/**
 * Main header bottom bar template.
 *
 * Passed variables:
 *
 * @type boolean $merged whether it's a merged header bar.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$elements = array();
$count = 0;
$cols = array( 'left', 'center', 'right' );

foreach ( $cols as $col ) {
	$elements[ $col ] = cakecious_get_theme_mod( 'header_elements_bottom_' . $col, array() );
	$count += count( $elements[ $col ] );
}

if ( 1 > $count ) {
	return;
}
?>
<div id="cakecious-header-bottom-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/header_bottom_bar_classes', array( 'cakecious-header-bottom-bar', 'cakecious-header-section', 'cakecious-section' ) ) ) ); ?>">

	<?php if ( $merged ) : ?>
		<div class="cakecious-wrapper">
			<div class="cakecious-header-bottom-bar-inner cakecious-section-inner">
	<?php else: ?>
		<div class="cakecious-header-bottom-bar-inner cakecious-section-inner">
			<div class="cakecious-wrapper">
	<?php endif; ?>

			<div class="cakecious-header-bottom-bar-row cakecious-header-row <?php echo esc_attr( ( 0 < count( $elements['center'] ) ) ? 'cakecious-header-row-with-center' : '' ); ?>">
				<?php foreach ( $cols as $col ) : ?>
					<?php
					// Skip center column if it's empty
					if ( 'center' === $col && 0 === count( $elements[ $col ] ) ) {
						continue;
					}
					?>
					<div class="<?php echo esc_attr( 'cakecious-header-bottom-bar-' . $col ); ?> cakecious-header-column">
						<?php
						// Print all elements inside the column.
						foreach ( $elements[ $col ] as $element ) {
							cakecious_header_element( $element );
						}
						?>
					</div>
				<?php endforeach; ?>
			</div>

		</div>
	</div>
</div>