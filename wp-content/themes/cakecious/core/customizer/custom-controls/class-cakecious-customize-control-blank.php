<?php
/**
 * Customizer custom control: Blank
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Cakecious_Customize_Control_Blank' ) ) :
/**
 * Blank control class
 */
class Cakecious_Customize_Control_Blank extends Cakecious_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'cakecious-blank';

	/**
	 * Render control's content
	 */
	protected function render_content() {
		if ( ! empty( $this->label ) ) : ?>
			<span class="customize-control-title"><?php echo do_shortcode($this->label); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php endif;
		if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo do_shortcode($this->description); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
		<?php endif;
	}
}
endif;