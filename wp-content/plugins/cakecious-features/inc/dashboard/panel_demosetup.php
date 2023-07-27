<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
global $cakecious_theme_components;
?>

<div id="kc_product_license-tab" class="group p">
	<?php
	ob_start();
	?>
	<div class="kc-license-notice"></div>
	<h4>
		<?php _e( 'Here you can import the demo data. Please make sure everything is green below for smooth import process. If its not, please contact host with below info and they will increase server limits.', 'cakecious' ); ?>
	</h4>


	<div id="temptt-tab-activate" class="col cols panel  temptt-theme-panel">
		<div class="inner-panel">
			<?php
				$server_data 	= array(
					'memory_limit' 		=> wp_convert_hr_to_bytes( @ini_get( 'memory_limit' ) ),
					'time_limit' 		=> ini_get( 'max_execution_time' ),
					'max_input_vars' 	=> ini_get( 'max_input_vars' ),
				);
			?>
				<p> Please note that it is recommended that you run demo setup wizard on fresh installation to avoid conflicts. If its not a fresh install you can reset the install using this plugin <a href="https://wordpress.org/plugins/wordpress-reset/">WordPress Reset Plugin</a>. Please note this reset plugin will delete all data that you have on the website, so its not recommended if you have some data(eg posts, pages or images) you want to preserve.  </p>

				<table class="serverchk-table">
					<tbody>
					<tr><td><br><!--Spacing fix--></td>
					</tr>
					<tr>
						<td><strong>PHP Memory Limit</strong></td>
						<?php if( $server_data['memory_limit'] < 134217728 ) { ?>
						<td class="fail">
						<span class="status no dashicons dashicons-no"></span>
						<span class="msg"><?php echo size_format( $server_data['memory_limit'] ); ?> Minimum <strong>128 MB</strong> is required, <strong>256 MB</strong> is recommended.</span>
						</td>
						<?php } else { ?>
						<td class="success">
						<span class="status no dashicons dashicons-yes"></span>
						<span class="msg"><?php echo size_format( $server_data['memory_limit'] ); ?></span>
						</td>
						<?php }?>
					</tr>
					<tr>
						<td><strong>PHP Time Limit</strong></td>
						<?php if( ( $server_data['time_limit'] >= 180 ) || ( $server_data['time_limit'] == 0 ) ) { ?>
						<td class="success">
						<span class="status no dashicons dashicons-yes"></span>
						<span class="msg"><?php echo $server_data['time_limit']; ?></span>
						</td>
						<?php } elseif( $data['time_limit'] < 120 ) { ?>
						<td class="fail">
						<span class="status no dashicons dashicons-no"></span>
						<span class="msg"><?php echo $server_data['time_limit']; ?> Minimum <strong>120</strong> is required, <strong>180</strong> is recommended. </span>
						</td>
						<?php } else { ?>
						<td class="info">
						<span class="status no dashicons dashicons-info"></span>
						<span class="msg"><?php echo $server_data['time_limit']; ?></span>
						<p class="status-notice status-error">Current time limit is OK, however <strong>180</strong> is recommended. </p>
						</td>
						<?php }?>
					</tr>
					</tbody>
				</table>
				<p> If the above values are not in green, you can still run the demo setup wizard, because it sometimes work. You can try below trouble shooting steps if you encounter problems.</p>
			<ul>
				<li>
					Step 1) Please try to run the setup again and skip the steps that worked fine in earlier run.<br>
					Step 2) Go to wp-admin/plugins and deactivate Revolution Slider plugin( If its active) and/or other plugins that theme did not trigger installing. Then run the demo setup, after that reactivate the plugin(s) and skip till Theme Setup step and run from there.<br>
					Step 3) If you are still facing problems, <a href="<?php echo esc_url( admin_url() ) . 'admin.php?page=cakecious_help' ?>">Contact Support</a>.<br>
				</li>
			</ul>
			<?php
			// make sure Sites plugin is installed.
			$bolv_constant = strtoupper($cakecious_theme_components['temptt_themename']) .'_SITES_URL';
			if ( class_exists( 'OCDI_Plugin' ) ) { /* OCDI import plugin should be installed */ ?>
				<a href="<?php echo esc_url(admin_url('themes.php').'?page=pt-one-click-demo-import');?>" class="button button-primary">Run Demo Importer</a>
			<?php
			} else { ?>
				<a style="pointer-events: none;cursor: disabled;" href="<?php echo esc_url(admin_url('themes.php').'?page=pt-one-click-demo-import');?>" class="button button-primary">Run Demo Importer</a>
				<br />
				<span class="status no dashicons dashicons-info"></span>
				<span class="msg" style="font-style: italic;color: red;">Please install One Click Demo Import plugin by going to Appearance -> Install plugins to activate above button. </span>
			<?php
			}
			?>
			</div>
	</div>



	<?php
	$kc_license_tab = ob_get_contents();
	ob_end_clean();
	echo apply_filters( 'kc_setting_license', $kc_license_tab );
	?>
</div>