<?php
/**
 * Main header main bar template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$elements = array();
$count = 0;
$cols = array( 'left', 'center', 'right' );

foreach ( $cols as $col ) {
	$elements[ $col ] = cakecious_get_theme_mod( 'header_elements_main_' . $col, array() );
	$count += count( $elements[ $col ] );
}

if ( 1 > $count ) {
	return;
}
?>
<div id="cakecious-header-main-bar" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/header_main_bar_classes', array( 'cakecious-header-main-bar', 'cakecious-header-section', 'cakecious-section' ) ) ) ); ?>">
	<div class="cakecious-header-main-bar-inner cakecious-section-inner">

		<?php
		// Top Bar (if merged).
		if ( intval( cakecious_get_theme_mod( 'header_top_bar_merged' ) ) ) {
			cakecious_main_header__top_bar( true );
		}
		?>

		<div class="cakecious-wrapper">
			<div class="cakecious-header-main-bar-row cakecious-header-row <?php echo esc_attr( ( 0 < count( $elements['center'] ) ) ? 'cakecious-header-row-with-center' : '' ); ?>">
				<?php foreach ( $cols as $col ) : ?>
					<?php
					// Skip center column if it's empty
					if ( 'center' === $col && 0 === count( $elements[ $col ] ) ) {
						continue;
					}
					?>
					<div class="<?php echo esc_attr( 'cakecious-header-main-bar-' . $col ); ?> cakecious-header-column">
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

		<?php
		// Bottom Bar (if merged).
		if ( intval( cakecious_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
			cakecious_main_header__bottom_bar( true );
		}
		?>

	</div>
</div>