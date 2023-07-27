<?php
/**
 * The sidebar containing Shop (WooCommerce) widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<?php if ( cakecious_is_fresh_install() ) {

// Check current page's content container. Skip sidebar if it's a "narrow" layout.
if ( 'narrow' === cakecious_get_current_page_setting( 'content_container' ) ) return;

// Check current page's content layout. Skip sidebar if not needed in the layout.
if ( ! in_array( cakecious_get_current_page_setting( 'content_layout' ), array( 'left-sidebar', 'right-sidebar' ) ) ) return;
?>
<aside id="secondary" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/sidebar_classes', array( 'widget-area', 'sidebar' ) ) ) ); ?>" role="complementary" itemscope itemtype="https://schema.org/WPSideBar">
	<?php
	/**
	 * Hook: cakecious/frontend/before_sidebar
	 */
	do_action( 'cakecious/frontend/before_sidebar' );
	
	if ( is_active_sidebar( 'sidebar-shop' ) ) :
	?>
		<div class="sidebar-inner">
			<?php dynamic_sidebar( 'sidebar-shop' ); ?>
		</div>
	<?php
	endif;

	/**
	 * Hook: cakecious/frontend/after_sidebar
	 */
	do_action( 'cakecious/frontend/after_sidebar' );
	?>
</aside>

<?php } else { ?>

<div id="secondary" class="col-lg-3" role="complementary">
	<div class="right_sidebar_area">
		<?php dynamic_sidebar( 'shop' ); ?>
	</div>
</div><!-- #secondary -->

<?php }