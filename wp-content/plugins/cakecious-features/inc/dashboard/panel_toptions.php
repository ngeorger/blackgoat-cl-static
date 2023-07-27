<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
global $cakecious_theme_components;
?>

<div id="kc_product_license-tab" class="group p">
	<?php
	ob_start();
	?>
	<div class="kc-license-notice"></div>
	<h4>
		<?php _e( esc_html( ucfirst(get_template()) ) . ' Theme Options', 'cakecious' ); ?>
	</h4>


	<div id="temptt-tab-activate" class="col cols panel  temptt-theme-panel">
		<div class="inner-panel">

				<p> Please use customiser for Theme related options. </p>
				<p>
				<?php echo '<a href="'.esc_url(admin_url('customize.php')).'">Click Here</a> to go to Customiser, or go to Appearance/Customize'; ?>
				</p>
		</div>
	</div>



	<?php
	$kc_license_tab = ob_get_contents();
	ob_end_clean();
	echo apply_filters( 'kc_setting_license', $kc_license_tab );
	?>
</div>