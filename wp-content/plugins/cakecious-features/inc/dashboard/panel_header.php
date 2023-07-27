<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.


$temptt_thmname = temptt_get_theme_version_data();

ob_start();
?>
<h1><?php esc_html_e( 'Welcome to ' . esc_attr( ucfirst(get_template()) ) . ' Theme Dashboard!', 'cakecious' ); ?></h1>

<div class="about-text">
	<?php _e( 'Thank you for purchasing  ' . esc_attr( ucfirst(get_template()) ) . ' theme. You are awesome.', 'cakecious' ); ?>
</div>
<?php
$about = ob_get_contents();
ob_end_clean();
echo apply_filters( 'kc_setting_about', $about );
ob_start();
?>
<div class="wp-badge kc-badge">
	<?php _e( 'Version', 'cakecious' ); ?> <?php echo esc_attr( $temptt_thmname['parent_theme_version'] ); ?>
</div>
<?php
$version = ob_get_contents();
ob_end_clean();
echo apply_filters( 'kc_setting_version', $version );
ob_start();
?>
<h2 class="nav-tab-wrapper">
	<a href="<?php echo esc_url( admin_url() ) . 'admin.php?page=cakecious_dashboard' ?>"
	   class="nav-tab <?php if ( $_GET['page'] == 'cakecious_dashboard' ) {
		   echo 'nav-tab-active';
	   } ?>" id="kc_product_license-tab">
		<?php _e( 'General', 'cakecious' ); ?>
	</a>
	<a href="<?php echo esc_url( admin_url() ) . 'admin.php?page=cakecious_demosetup' ?>"
	   class="nav-tab <?php if ( $_GET['page'] == 'cakecious_demosetup' ) {
		   echo 'nav-tab-active';
	   } ?>" id="kc_demo_setup-tab">
		<?php _e( 'Demo Setup', 'cakecious' ); ?>
	</a>
	<a href="<?php echo esc_url( admin_url() ) . 'admin.php?page=cakecious_help' ?>"
	   class="nav-tab <?php if ( $_GET['page'] == 'cakecious_help' ) {
		   echo 'nav-tab-active';
	   } ?>" id="kc_help_support-tab">
		<?php _e( 'Help & Support', 'cakecious' ); ?>
	</a>
	<a href="<?php echo esc_url( admin_url() ) . 'admin.php?page=cakecious_options' ?>"
	   class="nav-tab <?php if ( $_GET['page'] == 'cakecious_options' ) {
		   echo 'nav-tab-active';
	   } ?>" id="kc_help_support-tab">
		<?php _e( 'Theme Options', 'cakecious' ); ?>
	</a>
<!--	<a href="<?php /*echo esc_url( admin_url() ) . 'admin.php?page=_cakecious' */?>" class="nav-tab"
	   id="kc_themeoptions-tab">
		<?php /*_e( 'Theme Options', 'cakecious' ); */?>
	</a>
--></h2>
<?php
$tab_nav = ob_get_contents();
ob_end_clean();
echo apply_filters( 'kc_setting_tab_nav', $tab_nav );

?>
<!-- If there is theme update, show it to user -->
<?php
$update_themes = get_site_transient( 'update_themes' );
if ( isset( $update_themes->response[ $temptt_thmname['parent_theme_slug'] ] ) ) {
	ob_start();
	?>
	<div class="temptt-updated">
		<p>
			<i class="dashicons dashicons-update"></i>
			<?php echo sprintf( esc_html__( 'There is a new version of ' . $temptt_thmname['parent_theme_name'] . ' theme available. Please update by going to %s.', 'cakecious' ), '<a href="' . esc_url( admin_url( 'themes.php' ) ) . '">' . esc_html__( 'Appearance -> Themes', 'cakecious' ) . '</a>' )
			?>
		</p>
	</div>
	<?php
	$kc_update = ob_get_contents();
	ob_end_clean();
	echo apply_filters( 'kc_setting_update', $kc_update );
}