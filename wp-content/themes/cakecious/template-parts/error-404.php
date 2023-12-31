<?php
/**
 * Error 404 content template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div class="error-404 not-found page-content">
	<?php
	// Image
	$image = cakecious_get_theme_mod( 'error_404_image' );
	if ( intval( $image ) ) {
		echo '<span class="error-404-image" style="max-width: ' . esc_attr( cakecious_get_theme_mod( 'error_404_image_width', 'none' ) ) . ';">';
		echo wp_get_attachment_image( $image, 'full' );
		echo '</span>';
	}
	?>

	<h1 class="error-404-title page-title">
		<?php
		// Title
		$title_text = cakecious_get_theme_mod( 'error_404_title' );
		if ( empty( $title_text ) ) {
			$title_text = esc_html__( 'Oops! That page can not be found', 'cakecious' );
		}

		echo wp_kses_post( $title_text );
		?>
	</h1>

	<?php
	// Description
	$description_text = cakecious_get_theme_mod( 'error_404_description' );
	if ( empty( $description_text ) ) {
		$description_text = esc_html__( 'It looks like nothing was found at this location. Maybe try searching?', 'cakecious' );
	}

	echo wp_kses_post( wpautop( $description_text ) );
	?>

	<?php
	// Search form
	if ( intval( cakecious_get_theme_mod( 'error_404_search_bar' ) ) ) {
		get_search_form();
	}
	?>

	<?php
	// Home button
	if ( intval( cakecious_get_theme_mod( 'error_404_home_button' ) ) ) {
		// Button text
		$button_text = cakecious_get_theme_mod( 'error_404_home_button_text' );
		if ( empty( $button_text ) ) {
			$button_text = esc_html__( 'Back to Home', 'cakecious' );
		}
		?><a href="<?php echo esc_url( home_url() ); ?>" class="error-404-home-button button"><?php echo wp_kses_post( $button_text ); ?></a><?php
	}
	?>
</div>