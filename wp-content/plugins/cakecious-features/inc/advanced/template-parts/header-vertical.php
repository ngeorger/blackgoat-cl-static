<?php
/**
 * Vertical header template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$elements = array();
$count = 0;
$rows = array( 'top', 'middle', 'bottom' );

foreach ( $rows as $row ) {
	$elements[ $row ] = cakecious_get_theme_mod( 'header_elements_vertical_' . $row, array() );
	$count += count( $elements[ $row ] );
}

if ( 1 > $count ) {
	return;
}

$display = cakecious_get_theme_mod( 'header_vertical_bar_display' );
?>
<div id="vertical-header" class="cakecious-header-vertical <?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/header_vertical_classes', array() ) ) ); ?> cakecious-header" itemscope itemtype="https://schema.org/WPHeader">
	<?php if ( 'fixed' !== $display ) : ?>
		<div class="cakecious-popup-background cakecious-popup-close"></div>
	<?php endif; ?>

	<div class="cakecious-header-vertical-bar cakecious-header-section-vertical <?php echo esc_attr( 'fixed' !== $display ? 'cakecious-popup-content' : '' ); ?>">
		<div class="cakecious-header-section-vertical-column <?php echo esc_attr( ( 0 < count( $elements['middle'] ) ) ? 'cakecious-header-section-vertical-column-with-middle' : '' ); ?>">
			<?php foreach ( $rows as $row ) : ?>
				<?php
				// Skip middle column if it's empty
				if ( 'middle' === $row && 0 === count( $elements[ $row ] ) ) {
					continue;
				}
				?>
				<div class="<?php echo esc_attr( 'cakecious-header-vertical-bar-' . $row ); ?> cakecious-header-section-vertical-row">
					<?php foreach ( $elements[ $row ] as $element ) cakecious_header_element( $element ); ?>
				</div>
			<?php endforeach; ?>
		</div>

		<?php if ( 'full-screen' === $display ) : ?>
			<button class="cakecious-popup-close-icon cakecious-popup-close cakecious-toggle"><?php cakecious_icon( 'close' ); ?></button>
		<?php endif; ?>
	</div>
</div>