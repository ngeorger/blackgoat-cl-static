<?php
/**
 * Customizer custom control: Shadow
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Cakecious_Customize_Control_Shadow' ) ) :
/**
 * Shadow control class
 */
class Cakecious_Customize_Control_Shadow extends Cakecious_Customize_Control {
	/**
	 * @var string
	 */
	public $type = 'cakecious-shadow';

	/**
	 * @var boolean
	 */
	public $has_palette = true;

	/**
	 * @var array
	 */
	public $exclude = array();

	/**
	 * Setup parameters for content rendering by Underscore JS template.
	 */
	public function to_json() {
		parent::to_json();

		$this->json['name'] = $this->id;

		$value = $this->value();
		if ( false === $value || '' === trim( $value ) ) {
			$value = '0 0 0 0 rgba(0,0,0,0)'; // default value
		}

		$chunks = explode( ' ', $value );
		if ( ! isset( $chunks[5] ) ) {
			$chunks[5] = '';
		}
		$this->json['value'] = array(
			'h_offset' => intval( $chunks[0] ),
			'v_offset' => intval( $chunks[1] ),
			'blur' => intval( $chunks[2] ),
			'spread' => intval( $chunks[3] ),
			'color' => $chunks[4],
			'position' => $chunks[5],
		);
		$this->json['raw_value'] = $value;

		$this->json['has_palette'] = $this->has_palette;

		$this->json['exclude'] = $this->exclude;

		$this->json['__link'] = $this->get_link();
	}

	/**
	 * Enqueue additional control's CSS or JS scripts.
	 */
	public function enqueue() {
		wp_enqueue_script( 'alpha-color-picker' );
		wp_enqueue_style( 'alpha-color-picker' );
	}

	/**
	 * Render Underscore JS template for this control's content.
	 */
	protected function content_template() {
		$inputs = array(
			'h_offset' => esc_html__( 'X', 'cakecious' ),
			'v_offset' => esc_html__( 'Y', 'cakecious' ),
			'blur' => esc_html__( 'Blur', 'cakecious' ),
			'spread' => esc_html__( 'Spread', 'cakecious' ),
		);

		/**
		 * Get color palette/
		 */

		$palette = array();

		for ( $i = 1; $i <= 8; $i++ ) {
			$palette[] = cakecious_get_theme_mod( 'color_palette_' . $i, '' );
		}

		$palette = implode( '|', $palette );
		?>
		<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
		<# } #>
		<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
		<# } #>
		<div class="customize-control-content">
			<div class="cakecious-row cakecious-shadow-row">
				<# var isExcluded = -1 < data.exclude.indexOf( 'position' ) ? 'style="display: none;"' : ''; #>
				<div class="cakecious-row-item cakecious-shadow-position" {{{ isExcluded }}}>
					<select class="cakecious-shadow-input">
						<option value="" {{ value === data.value.position ? 'selected' : '' }}><?php esc_html_e( 'out', 'cakecious' ); ?></option>
						<option value="inset" {{ value === data.value.position ? 'selected' : '' }}><?php esc_html_e( 'in', 'cakecious' ); ?></option>
					</select>
				</div>

				<# var inputs = <?php echo json_encode( $inputs ); ?>; #>
				<# _.each( inputs, function( label, prop ) { #>
					<# var isExcluded = -1 < data.exclude.indexOf( prop ) ? 'style="display: none;"' : ''; #>
					<div class="cakecious-row-item cakecious-shadow-{{ prop }}" {{{ isExcluded }}}>
						<input type="number" value="{{ '' !== isExcluded ? '' : data.value[ prop ] }}" class="cakecious-shadow-input" step="1">
						<span class="cakecious-small-label">{{{ label }}}</span>
					</div>
				<# }); #>
			</div>

			<div class="cakecious-shadow-color">
				<input value="{{ data.value.color }}" type="text" maxlength="30" class="cakecious-shadow-input color-picker" data-palette="{{ data.has_palette ? '<?php echo esc_attr( $palette ); ?>' : 'false' }}" placeholder="<?php esc_attr_e( 'Hex / RGBA', 'cakecious' ); ?>" data-default-color="rgba(0,0,0,0)" data-show-opacity="true">
			</div>

			<input type="hidden" {{{ data.__link }}} value="{{ data.raw_value }}" class="cakecious-shadow-value">
		</div>
		<?php
	}
}

// Register control type.
$wp_customize->register_control_type( 'Cakecious_Customize_Control_Shadow' );
endif;