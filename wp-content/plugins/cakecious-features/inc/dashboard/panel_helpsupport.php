<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
global $cakecious_theme_components;
?>

<div id="kc_help_support-tab" class="group p">
	<?php
	ob_start();
	?>
	<div class="kc-license-notice"></div>
	<h3>
	<h3>
		<?php _e( 'Get support for ' . esc_attr( ucfirst(get_template()) ) . ' theme!', 'cakecious' ); ?>
	<small><a href="https://themeforest.net/page/item_support_policy" target="_blank">What does support include?</a></small>
	</h3>


	<div id="temptt-tab-activate" class="col cols panel  temptt-theme-panel">
		<div class="inner-panel">

		<h3>Premium E-mail Support</h3>
		<p>All customers of <?php echo esc_attr( ucfirst(get_template()) ); ?> have access to premium e-mail support.</p>

		<?php if( defined( 'TT_PCODE_NO' ) && TT_PCODE_NO ) { ?>

					<?php if( 'da' == $cakecious_theme_components['temptt_author'] ) { ?>
					<a target="_blank" href="<?php echo esc_url('https://bolvo.com/support/');?>" class="button button-secondary">Click here to access support.</a>
					<?php } else { ?>
					<a target="_blank" href="<?php echo esc_url('https://bolvo.com/support/');?>" class="button button-secondary">Click here to access support.</a>
					<?php }  ?>

		<?php } else { ?>

			<?php if(!temptt_is_pcode_entered())	{ ?>
				<a href="<?php echo admin_url().'admin.php?page=cakecious_dashboard';?>" class="button button-primary">Activate Theme to get support</a>
	        <?php } else if(temptt_is_support_expired(basename( get_template_directory() ))){ ?>
	            <p><strong>Support has expired :(</strong></p>
	            <a target="_blank" href="//themeforest.net/item/<?php echo $cakecious_theme_components['temptt_tf_link'] ; ?>?ref=cakecious" class="button button-warning" style="color:red;">+ Extend Support time</a>
			<?php } elseif(temptt_is_pcode_entered()) { ?>
				<p style="color: green; font-weight: bold;">You have valid access to support.  </p>
				<p>You are requested to click the button below and signup to our support system. It only takes 1 minute and you have to do it only once.</p>
					<?php if( 'da' == $cakecious_theme_components['temptt_author'] ) { ?>
					<a target="_blank" href="<?php echo esc_url('https://bolvo.com/support/');?>" class="button button-secondary">Click here to access support.</a>
					<?php } else { ?>
					<a target="_blank" href="<?php echo esc_url('https://bolvo.com/support/');?>" class="button button-secondary">Click here to access support.</a>
					<?php }  ?>
			<?php } else { ?>

				<p>Can not check for support validation at this time, if you need urgent support, please contact us from our Themeforest Profile page form.</p>

			<?php } ?>
		<?php } ?>

		</div>
	</div>



	<?php
	$kc_license_tab = ob_get_contents();
	ob_end_clean();
	echo apply_filters( 'kc_setting_license', $kc_license_tab );
	?>
</div>
