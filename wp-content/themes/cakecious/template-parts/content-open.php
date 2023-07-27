<?php
/**
 * Content section opening tag template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div id="content" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/content_classes', array( 'cakecious-content', 'site-content', 'cakecious-section' ) ) ) ); ?>">
	<div class="cakecious-content-inner cakecious-section-inner">
		<div class="cakecious-wrapper">

			<?php
			/**
			 * Hook: cakecious/frontend/before_primary_and_sidebar
			 */
			do_action( 'cakecious/frontend/before_primary_and_sidebar' );
			?> 

			<div class="cakecious-content-row">