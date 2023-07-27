<?php
/**
 * WooCommerce off-canvas selected filters template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

ob_start();
the_widget( 'WC_Widget_Layered_Nav_Filters', array(
	'title' => '',
) );
$widget = ob_get_clean();

if ( empty( $widget ) ) {
	return;
}
?>
<div class="cakecious-products-selected-filters">
	<?php echo $widget; // WPCS: XSS Ok. ?>
</div>