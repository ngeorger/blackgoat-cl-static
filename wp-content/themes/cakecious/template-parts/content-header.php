<?php
/**
 * Content header template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/content_header_classes', array( 'content-header' ) ) ) ); ?>">
	<?php
	/**
	 * Hook: cakecious/frontend/content_header
	 */
	do_action( 'cakecious/frontend/content_header' );
	?>
</div>