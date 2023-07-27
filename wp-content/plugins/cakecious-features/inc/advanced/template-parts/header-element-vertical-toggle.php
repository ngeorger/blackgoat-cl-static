<?php
/**
 * Header vertical toggle template.
 *
 * Passed variables:
 *
 * @type string $slug Header element slug.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( 'fixed' === cakecious_get_theme_mod( 'header_vertical_bar_display' ) ) {
	return;
}

?>
<div class="<?php echo esc_attr( 'cakecious-header-' . $slug ); ?>">
	<button class="cakecious-popup-toggle cakecious-toggle" data-target="vertical-header">
		<?php cakecious_icon( 'menu', array( 'class' => 'cakecious-menu-icon' ) ); ?>
		<span class="screen-reader-text"><?php esc_html_e( 'Vertical Header', 'cakecious-features' ); ?></span>
	</button>
</div>