<?php
/**
 * Mobile header vertical toggle template.
 *
 * Passed variables:
 *
 * @type string $slug Header element slug.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="<?php echo esc_attr( 'cakecious-header-' . $slug ); ?>">
	<button class="cakecious-popup-toggle cakecious-toggle" data-target="mobile-vertical-header" aria-expanded="false">
		<?php cakecious_icon( 'menu', array( 'class' => 'cakecious-menu-icon' ) ); ?>
		<span class="screen-reader-text"><?php esc_html_e( 'Mobile Menu', 'cakecious' ); ?></span>
	</button>
</div>