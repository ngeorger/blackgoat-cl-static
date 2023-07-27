<?php
/**
 * Header button template.
 *
 * Passed variables:
 *
 * @type string $slug Header element slug.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$key = str_replace( '-', '_', $slug );
?>
<div class="<?php echo esc_attr( 'cakecious-header-' . $slug ); ?> cakecious-header-button">
	<a href="<?php echo esc_url( cakecious_get_theme_mod( 'header_' . $key . '_url' ) ); ?>" class="button" target="<?php echo esc_attr( '_' . cakecious_get_theme_mod( 'header_' . $key . '_target' ) ); ?>">
		<?php echo ( cakecious_get_theme_mod( 'header_' . $key . '_text' ) ); // WPCS: XSS OK ?>
	</a>
</div>