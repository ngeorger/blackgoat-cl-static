<?php
/**
 * Mobile header logo template.
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
<div class="<?php echo esc_attr( 'cakecious-header-' . $slug ); ?> site-branding menu">
	<div class="site-title menu-item h1">
		<a href="<?php echo esc_url( apply_filters( 'cakecious/frontend/logo_url', home_url( '/' ) ) ); ?>" rel="home" class="cakecious-menu-item-link">
			<?php
			/**
			 * Hook: cakecious/frontend/mobile_logo
			 *
			 * @hooked cakecious_default_mobile_logo - 10
			 */
			do_action( 'cakecious/frontend/mobile_logo' );
			?>
		</a>
	</div>
</div>