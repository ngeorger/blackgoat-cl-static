<?php
/**
 * Main header sections template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div id="header" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/header_classes', array( 'cakecious-header-main', 'cakecious-header' ) ) ) ); ?>">
	<?php
	// Top Bar (if not merged)
	if ( ! intval( cakecious_get_theme_mod( 'header_top_bar_merged' ) ) ) {
		cakecious_main_header__top_bar();
	}

	// Main Bar
	cakecious_main_header__main_bar();

	// Bottom Bar (if not merged)
	if ( ! intval( cakecious_get_theme_mod( 'header_bottom_bar_merged' ) ) ) {
		cakecious_main_header__bottom_bar();
	}
	?>
</div> 