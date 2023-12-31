<?php
/**
 * Customizer custom section: Spacer
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Section' ) && ! class_exists( 'Cakecious_Customize_Section_Spacer' ) ) :
/**
 * Spacer section class.
 */
class Cakecious_Customize_Section_Spacer extends WP_Customize_Section {
	/**
	 * @var string
	 */
	public $type = 'cakecious-section-spacer';

	/**
	 * Render Underscore JS template for this section.
	 */
	protected function render_template() {
		?>
		<li id="accordion-section-{{ data.id }}" class="accordion-section control-section control-section-{{ data.type }}">
			<# if ( 0 < data.title.length ) { #>
				<h2>{{{ data.title }}}</h2>
			<# } #>
		</li>
		<?php
	}
}

// Register section type.
$wp_customize->register_section_type( 'Cakecious_Customize_Section_Spacer' );
endif;