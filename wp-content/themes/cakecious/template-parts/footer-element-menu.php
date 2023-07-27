<?php
/**
 * Footer menu template.
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
<nav class="<?php echo esc_attr( 'cakecious-footer-' . $slug ); ?> cakecious-footer-menu site-navigation" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="<?php /* translators: %s: menu number. */ echo esc_attr( sprintf( esc_html__( 'Footer Menu %s', 'cakecious' ), str_replace( 'menu-', '', $slug ) ) ); ?>">
	<?php wp_nav_menu( array(
		'theme_location' => 'footer-' . $slug,
		'menu_class'     => 'menu',
		'container'      => false,
		'depth'          => -1,
		'fallback_cb'    => 'cakecious_unassigned_menu',
	) ); ?>
</nav>