<?php
/**
 * CSS Spinner helper class.
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

final class Cakecious_Helper_CSS_Spinner {
	/**
	 * Retrieve all or selected CSS spinner data.
	 *
	 * References:
	 * - https://github.danielcardoso.net/load-awesome/animations.html
	 *
	 * @param string $key
	 * @return array
	 */
	static public function get_data( $key = null ) {
		$spinners = apply_filters( 'cakecious/dataset/css_spinners', array(
			'ball-clip-rotate' => array(
				'label' => esc_html__( 'Circle clip', 'cakecious-features' ),
				'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/preloader-screen--css-spinner--ball-clip-rotate.svg',
				'divs'  => 1,
				'css'   => cakecious_minify_css_string( '
					.cakecious-css-spinner--ball-clip-rotate > div {
						display: inline-block;
						width: 1em;
						height: 1em;
						background-color: transparent;
						border: 0.0625em solid currentColor;
						border-bottom-color: transparent;
						border-radius: 100%;
						-webkit-animation: ball-clip-rotate 0.75s linear infinite;
						animation: ball-clip-rotate 0.75s linear infinite;
					}
					@-webkit-keyframes ball-clip-rotate {
						0% {
							-webkit-transform: rotate(0deg);
							transform: rotate(0deg);
						}
						50% {
							-webkit-transform: rotate(180deg);
							transform: rotate(180deg);
						}
						100% {
							-webkit-transform: rotate(360deg);
							transform: rotate(360deg);
						}
					}
					@keyframes ball-clip-rotate {
						0% {
							-webkit-transform: rotate(0deg);
							transform: rotate(0deg);
						}
						50% {
							-webkit-transform: rotate(180deg);
							transform: rotate(180deg);
						}
						100% {
							-webkit-transform: rotate(360deg);
							transform: rotate(360deg);
						}
					}
				' ),
			),
			'ball-grid-beat' => array(
				'label' => esc_html__( 'Grid beat', 'cakecious-features' ),
				'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/preloader-screen--css-spinner--ball-grid-beat.svg',
				'divs'  => 9,
				'css'   => cakecious_minify_css_string( '
					.cakecious-css-spinner--ball-grid-beat > div {
						display: inline-block;
						width: 0.2222em;
						height: 0.2222em;
						margin: 0.0556em;
						background-color: currentColor;
						border-radius: 100%;
						-webkit-animation: ball-grid-beat linear infinite;
						animation: ball-grid-beat linear infinite;
					}
					.cakecious-css-spinner--ball-grid-beat > div:nth-child(1) {
						-webkit-animation-duration: 0.65s;
						animation-duration: 0.65s;
						-webkit-animation-delay: 0.03s;
						animation-delay: 0.03s;
					}
					.cakecious-css-spinner--ball-grid-beat > div:nth-child(2) {
						-webkit-animation-duration: 1.02s;
						animation-duration: 1.02s;
						-webkit-animation-delay: 0.09s;
						animation-delay: 0.09s;
					}
					.cakecious-css-spinner--ball-grid-beat > div:nth-child(3) {
						-webkit-animation-duration: 1.06s;
						animation-duration: 1.06s;
						-webkit-animation-delay: -0.69s;
						animation-delay: -0.69s;
					}
					.cakecious-css-spinner--ball-grid-beat > div:nth-child(4) {
						-webkit-animation-duration: 1.5s;
						animation-duration: 1.5s;
						-webkit-animation-delay: -0.41s;
						animation-delay: -0.41s;
					}
					.cakecious-css-spinner--ball-grid-beat > div:nth-child(5) {
						-webkit-animation-duration: 1.6s;
						animation-duration: 1.6s;
						-webkit-animation-delay: 0.04s;
						animation-delay: 0.04s;
					}
					.cakecious-css-spinner--ball-grid-beat > div:nth-child(6) {
						-webkit-animation-duration: 0.84s;
						animation-duration: 0.84s;
						-webkit-animation-delay: 0.07s;
						animation-delay: 0.07s;
					}
					.cakecious-css-spinner--ball-grid-beat > div:nth-child(7) {
						-webkit-animation-duration: 0.68s;
						animation-duration: 0.68s;
						-webkit-animation-delay: -0.66s;
						animation-delay: -0.66s;
					}
					.cakecious-css-spinner--ball-grid-beat > div:nth-child(8) {
						-webkit-animation-duration: 0.93s;
						animation-duration: 0.93s;
						-webkit-animation-delay: -0.76s;
						animation-delay: -0.76s;
					}
					.cakecious-css-spinner--ball-grid-beat > div:nth-child(9) {
						-webkit-animation-duration: 1.24s;
						animation-duration: 1.24s;
						-webkit-animation-delay: -0.76s;
						animation-delay: -0.76s;
					}
					@-webkit-keyframes ball-grid-beat {
						0% {
							opacity: 1;
						}
						50% {
							opacity: .35;
						}
						100% {
							opacity: 1;
						}
					}
					@keyframes ball-grid-beat {
						0% {
							opacity: 1;
						}
						50% {
							opacity: .35;
						}
						100% {
							opacity: 1;
						}
					}
				' ),
			),
			'ball-spin-clockwise-fade' => array(
				'label' => esc_html__( 'Circle spin', 'cakecious-features' ),
				'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/preloader-screen--css-spinner--ball-spin-clockwise-fade.svg',
				'divs'  => 8,
				'css'   => cakecious_minify_css_string( '
					.cakecious-css-spinner--ball-spin-clockwise-fade > div {
						position: absolute;
						top: 50%;
						left: 50%;
						display: inline-block;
						width: 0.25em;
						height: 0.25em;
						margin-top: -0.125em;
						margin-left: -0.125em;
						background-color: currentColor;
						border-radius: 100%;
						-webkit-animation: ball-spin-clockwise-fade 1s infinite ease-in-out;
						animation: ball-spin-clockwise-fade 1s infinite ease-in-out;
					}
					.cakecious-css-spinner--ball-spin-clockwise-fade > div:nth-child(1) {
						top: 5%;
						left: 50%;
						-webkit-animation-delay: -0.875s;
						animation-delay: -0.875s;
					}
					.cakecious-css-spinner--ball-spin-clockwise-fade > div:nth-child(2) {
						top: 18.1801948466%;
						left: 81.8198051534%;
						-webkit-animation-delay: -0.75s;
						animation-delay: -0.75s;
					}
					.cakecious-css-spinner--ball-spin-clockwise-fade > div:nth-child(3) {
						top: 50%;
						left: 95%;
						-webkit-animation-delay: -0.625s;
						animation-delay: -0.625s;
					}
					.cakecious-css-spinner--ball-spin-clockwise-fade > div:nth-child(4) {
						top: 81.8198051534%;
						left: 81.8198051534%;
						-webkit-animation-delay: -0.5s;
						animation-delay: -0.5s;
					}
					.cakecious-css-spinner--ball-spin-clockwise-fade > div:nth-child(5) {
						top: 94.9999999966%;
						left: 50.0000000005%;
						-webkit-animation-delay: -0.375s;
						animation-delay: -0.375s;
					}
					.cakecious-css-spinner--ball-spin-clockwise-fade > div:nth-child(6) {
						top: 81.8198046966%;
						left: 18.1801949248%;
						-webkit-animation-delay: -0.25s;
						animation-delay: -0.25s;
					}
					.cakecious-css-spinner--ball-spin-clockwise-fade > div:nth-child(7) {
						top: 49.9999750815%;
						left: 5.0000051215%;
						-webkit-animation-delay: -0.125s;
						animation-delay: -0.125s;
					}
					.cakecious-css-spinner--ball-spin-clockwise-fade > div:nth-child(8) {
						top: 18.179464974%;
						left: 18.1803700518%;
						-webkit-animation-delay: 0s;
						animation-delay: 0s;
					}
					@-webkit-keyframes ball-spin-clockwise-fade {
						50% {
							opacity: .25;
							-webkit-transform: scale(0.5);
							transform: scale(0.5);
						}
						100% {
							opacity: 1;
							-webkit-transform: scale(1);
							transform: scale(1);
						}
					}
					@keyframes ball-spin-clockwise-fade {
						50% {
							opacity: .25;
							-webkit-transform: scale(0.5);
							transform: scale(0.5);
						}
						100% {
							opacity: 1;
							-webkit-transform: scale(1);
							transform: scale(1);
						}
					}
				' ),
			),
			'line-scale' => array(
				'label' => esc_html__( 'Line scale', 'cakecious-features' ),
				'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/preloader-screen--css-spinner--line-scale.svg',
				'divs'  => 5,
				'css'   => cakecious_minify_css_string( '
					.cakecious-css-spinner--line-scale > div {
						display: inline-block;
						width: 0.1em;
						height: 0.8em;
						margin: 0 0.05em;
						margin-top: 0.1em;
						background-color: currentColor;
						-webkit-animation: line-scale 1.2s infinite ease;
						animation: line-scale 1.2s infinite ease;
					}
					.cakecious-css-spinner--line-scale > div:nth-child(1) {
						-webkit-animation-delay: -1.2s;
						animation-delay: -1.2s;
					}
					.cakecious-css-spinner--line-scale > div:nth-child(2) {
						-webkit-animation-delay: -1.1s;
						animation-delay: -1.1s;
					}
					.cakecious-css-spinner--line-scale > div:nth-child(3) {
						-webkit-animation-delay: -1s;
						animation-delay: -1s;
					}
					.cakecious-css-spinner--line-scale > div:nth-child(4) {
						-webkit-animation-delay: -0.9s;
						animation-delay: -0.9s;
					}
					.cakecious-css-spinner--line-scale > div:nth-child(5) {
						-webkit-animation-delay: -0.8s;
						animation-delay: -0.8s;
					}
					@keyframes line-scale {
						0%,
						40%,
						100% {
							-webkit-transform: scaleY(0.4);
							transform: scaleY(0.4);
						}
						20% {
							-webkit-transform: scaleY(1);
							transform: scaleY(1);
						}
					}
				' ),
			),
			'line-spin-clockwise-fade' => array(
				'label' => esc_html__( 'Line spin', 'cakecious-features' ),
				'image' => CAKECIOUS_PRO_URI . 'assets/images/customizer/preloader-screen--css-spinner--line-spin-clockwise-fade.svg',
				'divs'  => 8,
				'css'   => cakecious_minify_css_string( '
					.cakecious-css-spinner--line-spin-clockwise-fade > div {
						position: absolute;
						width: 0.0625em;
						height: 0.3125em;
						margin: 0.0625em;
						margin-top: -0.15625em;
						margin-left: -0.03125em;
						background-color: currentColor;
						border-radius: 0.03125em;
						-webkit-animation: line-spin-clockwise-fade 1s infinite ease-in-out;
						animation: line-spin-clockwise-fade 1s infinite ease-in-out;
					}
					.cakecious-css-spinner--line-spin-clockwise-fade > div:nth-child(1) {
						top: 15%;
						left: 50%;
						-webkit-transform: rotate(0deg);
						transform: rotate(0deg);
						-webkit-animation-delay: -0.875s;
						animation-delay: -0.875s;
					}
					.cakecious-css-spinner--line-spin-clockwise-fade > div:nth-child(2) {
						top: 25.2512626585%;
						left: 74.7487373415%;
						-webkit-transform: rotate(45deg);
						transform: rotate(45deg);
						-webkit-animation-delay: -0.75s;
						animation-delay: -0.75s;
					}
					.cakecious-css-spinner--line-spin-clockwise-fade > div:nth-child(3) {
						top: 50%;
						left: 85%;
						-webkit-transform: rotate(90deg);
						transform: rotate(90deg);
						-webkit-animation-delay: -0.625s;
						animation-delay: -0.625s;
					}
					.cakecious-css-spinner--line-spin-clockwise-fade > div:nth-child(4) {
						top: 74.7487373415%;
						left: 74.7487373415%;
						-webkit-transform: rotate(135deg);
						transform: rotate(135deg);
						-webkit-animation-delay: -0.5s;
						animation-delay: -0.5s;
					}
					.cakecious-css-spinner--line-spin-clockwise-fade > div:nth-child(5) {
						top: 84.9999999974%;
						left: 50.0000000004%;
						-webkit-transform: rotate(180deg);
						transform: rotate(180deg);
						-webkit-animation-delay: -0.375s;
						animation-delay: -0.375s;
					}
					.cakecious-css-spinner--line-spin-clockwise-fade > div:nth-child(6) {
						top: 74.7487369862%;
						left: 25.2512627193%;
						-webkit-transform: rotate(225deg);
						transform: rotate(225deg);
						-webkit-animation-delay: -0.25s;
						animation-delay: -0.25s;
					}
					.cakecious-css-spinner--line-spin-clockwise-fade > div:nth-child(7) {
						top: 49.9999806189%;
						left: 15.0000039834%;
						-webkit-transform: rotate(270deg);
						transform: rotate(270deg);
						-webkit-animation-delay: -0.125s;
						animation-delay: -0.125s;
					}
					.cakecious-css-spinner--line-spin-clockwise-fade > div:nth-child(8) {
						top: 25.2506949798%;
						left: 25.2513989292%;
						-webkit-transform: rotate(315deg);
						transform: rotate(315deg);
						-webkit-animation-delay: 0s;
						animation-delay: 0s;
					}
					@-webkit-keyframes line-spin-clockwise-fade {
						50% {
							opacity: .2;
						}
						100% {
							opacity: 1;
						}
					}
					@keyframes line-spin-clockwise-fade {
						50% {
							opacity: .2;
						}
						100% {
							opacity: 1;
						}
					}
				' ),
			),
		) );

		if ( empty( $key ) ) {
			return $spinners;
		} else {
			return cakecious_array_value( $spinners, $key, array() );
		}
	}

	/**
	 * Print / return CSS spinner.
	 *
	 * @param string $key
	 */
	static public function render( $key ) {
		if ( empty( $key ) ) {
			return;
		}

		$spinner = self::get_data( $key );
		?>
		<div class="cakecious-css-spinner <?php echo esc_attr( 'cakecious-css-spinner--' . $key ); ?>">
			<?php for ( $i = 1; $i <= $spinner['divs']; $i++ ) : ?><div></div><?php endfor; ?>
			<style type="text/css"><?php echo ( cakecious_array_value( $spinner, 'css' ) ); // WPCS: XSS OK. ?></style>
		</div>
		<?php
	}
}	