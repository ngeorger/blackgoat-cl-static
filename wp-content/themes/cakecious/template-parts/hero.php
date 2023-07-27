<?php
/**
 * Hero section template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<section id="hero" class="<?php echo esc_attr( implode( ' ', apply_filters( 'cakecious/frontend/hero_classes', array( 'cakecious-hero' ) ) ) ); ?>" role="region" aria-label="<?php esc_attr_e( 'Hero Section', 'cakecious' ); ?>">
	<div class="cakecious-hero-inner cakecious-section-inner">
		<div class="cakecious-wrapper">
			<?php cakecious_content_header(); ?>
		</div>
	</div>
</section>