<?php
/**
 * Customizer custom control: Horizontal Line
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Cakecious_Customize_Control_HR' ) ) :
/**
 * Horizontal line control class
 */
class Cakecious_Customize_Control_HR extends Cakecious_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'cakecious-hr';

	/**
	 * Render control's content
	 */
	protected function render_content() {
		?><hr><?php
	}
}
endif;