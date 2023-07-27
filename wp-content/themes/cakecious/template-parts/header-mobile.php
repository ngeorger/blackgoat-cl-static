<?php
/**
 * Mobile header sections template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div id="mobile-header" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/header_mobile_classes', array( 'cakecious-header-mobile', 'cakecious-header' ) ) ) ); ?>">
	<?php
	$elements = array();
	$count = 0;
	$cols = array( 'left', 'center', 'right' );

	foreach ( $cols as $col ) {
		$elements[ $col ] = cakecious_get_theme_mod( 'header_mobile_elements_main_' . $col, array() );
		$count += count( $elements[ $col ] );
	}

	if ( 1 > $count ) {
		return;
	}
	?>
	<div id="cakecious-header-mobile-main-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/header_mobile_main_bar_classes', array( 'cakecious-header-mobile-main-bar', 'cakecious-header-section', 'cakecious-section', 'cakecious-section-default' ) ) ) ); ?>">
		<div class="cakecious-header-mobile-main-bar-inner cakecious-section-inner">
			<div class="cakecious-wrapper">
				<div class="cakecious-header-mobile-main-bar-row cakecious-header-row <?php echo esc_attr( ( 0 < count( $elements['center'] ) ) ? 'cakecious-header-row-with-center' : '' ); ?>">
					<?php foreach ( $cols as $col ) : ?>
						<?php
						// Skip center column if it's empty
						if ( 'center' === $col && 0 === count( $elements[ $col ] ) ) {
							continue;
						}
						?>
						<div class="<?php echo esc_attr( 'cakecious-header-mobile-main-bar-' . $col ); ?> cakecious-header-column">
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
</div>