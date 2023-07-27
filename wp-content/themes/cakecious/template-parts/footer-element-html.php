<?php
/**
 * Footer free text (HTML) template.
 *
 * Passed variables:
 *
 * @type string $slug Footer element slug.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="<?php echo esc_attr( 'cakecious-footer-' . $slug ); ?>">
	<div><?php echo do_shortcode( cakecious_get_theme_mod( 'footer_' . str_replace( '-', '_', $slug ) . '_content' ) ); ?></div>
</div>