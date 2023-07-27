<?php
/**
 * Scoll to top button template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<a href="#page" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/scroll_to_top_classes', array( 'cakecious-scroll-to-top' ) ) ) ); ?>">
	<?php cakecious_icon( 'chevron-up' ); ?>
	<span class="screen-reader-text"><?php esc_html_e( 'Back to Top', 'cakecious' ); ?></span>
</a>