<?php
/**
 * Footer copyright template.
 *
 * Passed variables:
 *
 * @type string $slug Footer element slug.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$copyright = cakecious_get_theme_mod( 'footer_copyright_content' );
$copyright = str_replace( '{{year}}', date( 'Y' ), $copyright );
$copyright = str_replace( '{{sitename}}', '<a href="' . esc_url( home_url() ) . '">' . get_bloginfo( 'name' ) . '</a>', $copyright );
$copyright = str_replace( '{{theme}}', '<a href="' . cakecious_get_theme_info( 'url' ) . '">' . cakecious_get_theme_info( 'name' ) . '</a>', $copyright );
$copyright = str_replace( '{{themeauthor}}', '<a href="' . cakecious_get_theme_info( 'author_url' ) . '">' . cakecious_get_theme_info( 'author' ) . '</a>', $copyright );
$copyright = str_replace( '{{theme_author}}', '<a href="' . cakecious_get_theme_info( 'author_url' ) . '">' . cakecious_get_theme_info( 'author' ) . '</a>', $copyright );

?>
<div class="<?php echo esc_attr( 'cakecious-footer-' . $slug ); ?>">
	<div class="cakecious-footer-copyright-content"><?php echo do_shortcode( $copyright ); ?></div>
</div>