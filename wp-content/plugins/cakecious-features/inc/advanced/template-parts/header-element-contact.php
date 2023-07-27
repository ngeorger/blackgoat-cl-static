<?php
/**
 * Header contact template.
 *
 * Passed variables:
 *
 * @type string $slug Header element slug.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$items = cakecious_get_theme_mod( 'header_contact_items', array() );

if ( empty( $items ) ) {
	return;
}

?>
<ul class="<?php echo esc_attr( 'cakecious-header-' . $slug ); ?> cakecious-header-menu menu">
	<?php foreach ( $items as $item ) : ?>
		<?php
		$title = cakecious_get_theme_mod( 'header_contact_' . $item . '_title' );
		$text = cakecious_get_theme_mod( 'header_contact_' . $item . '_text' );
		$url = cakecious_get_theme_mod( 'header_contact_' . $item . '_url' );
		?>
		<li class="menu-item">
			<<?php echo ( ! empty( $url ) ) ? 'a href="' . esc_url( $url ) . '"' : 'span'; ?>>
				<?php cakecious_icon( $item, array( 'class' => 'cakecious-menu-icon' ) ); ?>
				<?php if ( '' !== trim( $title . $text ) ) : ?>
					<span class="cakecious-header-contact-item-content">
						<?php if ( 'large' === cakecious_get_theme_mod( 'header_contact_style' ) ) : ?>
							<span class="cakecious-header-contact-item-title"><?php echo $title; // WPCS: XSS OK. ?></span>
						<?php endif; ?>
						<span class="cakecious-header-contact-item-text"><?php echo $text; // WPCS: XSS OK. ?></span>
					</span>
				<?php endif; ?>
			</<?php echo ( ! empty( $url ) ) ? 'a' : 'span'; ?>>
		</li>
	<?php endforeach; ?>
</ul>