<?php
/**
 * Footer social links template.
 *
 * Passed variables:
 *
 * @type string $slug Footer element slug.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$items = cakecious_get_theme_mod( 'footer_social_links', array() );

if ( empty( $items ) ) {
	return;
}

$target = '_' . cakecious_get_theme_mod( 'footer_social_links_target' );
$attrs = array();

foreach ( $items as $item ) {
	$url = cakecious_get_theme_mod( 'social_' . $item );
	$attrs[] = array(
		'type'   => $item,
		'url'    => ! empty( $url ) ? $url : '#',
		'target' => $target,
	);
}

?>
<ul class="<?php echo esc_attr( 'cakecious-footer-' . $slug ); ?> menu">
	<?php cakecious_social_links( $attrs, array(
		'before_link' => '<li class="menu-item">',
		'after_link'  => '</li>',
		'link_class'  => 'cakecious-menu-icon',
	) ); ?>
</ul>