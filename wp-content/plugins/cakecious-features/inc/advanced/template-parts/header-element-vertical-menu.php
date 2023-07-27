<?php
/**
 * Header vertical menu template.
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
<nav class="<?php echo esc_attr( 'cakecious-header-' . $slug ); ?> cakecious-header-menu site-navigation" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement" aria-label="<?php esc_attr_e( 'Vertical Header Menu', 'cakecious-features' ); ?>">
	<?php wp_nav_menu( array(
		'theme_location' => 'header-' . $slug,
		'menu_class'     => 'menu cakecious-toggle-menu',
		'container'      => false,
		'fallback_cb'    => 'cakecious_unassigned_menu',
	) ); ?>
</nav>