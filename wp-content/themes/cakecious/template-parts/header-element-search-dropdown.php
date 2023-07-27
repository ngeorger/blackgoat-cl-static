<?php
/**
 * Header search dropdown template.
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
<div class="<?php echo esc_attr( 'cakecious-header-' . $slug ); ?> cakecious-header-search menu cakecious-toggle-menu">
	<div class="menu-item">
		<button class="cakecious-sub-menu-toggle cakecious-toggle" aria-expanded="false">
			<?php cakecious_icon( 'search', array( 'class' => 'cakecious-menu-icon' ) ); ?>
			<span class="screen-reader-text"><?php esc_html_e( 'Search', 'cakecious' ); ?></span>
		</button>
		<div class="sub-menu"><?php get_search_form(); ?></div>
	</div>
</div>