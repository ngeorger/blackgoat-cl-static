<?php
/**
 * Customizer custom control: Heading
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Cakecious_Customize_Control_Heading' ) ) :
/**
 * Heading control class
 */
class Cakecious_Customize_Control_Heading extends Cakecious_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'cakecious-heading';

	/**
	 * Render control's content
	 */
	protected function render_content() {
		if ( ! empty( $this->label ) ) : ?>
			<span class="tabindex" tabindex="0"></span>
			<h4 class="cakecious-heading"><span><?php echo do_shortcode($this->label); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span></h4>
			<?php if ( ! empty( $this->description ) ) : ?>
				<p class="description customize-control-description"><?php echo do_shortcode($this->description); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		<?php endif;
	}
}
endif;