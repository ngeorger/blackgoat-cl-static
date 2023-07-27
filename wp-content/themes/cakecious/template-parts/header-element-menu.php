<?php
/**
 * Header menu template.
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
<nav class="<?php echo esc_attr( 'cakecious-header-' . $slug ); ?> cakecious-header-menu site-navigation" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="<?php /* translators: %s: menu number. */ echo esc_attr( sprintf( esc_html__( 'Header Menu %s', 'cakecious' ), str_replace( 'menu-', '', $slug ) ) ); ?>">
	<?php wp_nav_menu( array(
		'theme_location' => 'header-' . $slug,
		'menu_class'     => 'menu cakecious-hover-menu',
		'container'      => false,
		'fallback_cb'    => 'cakecious_unassigned_menu',
	) ); ?>
</nav>