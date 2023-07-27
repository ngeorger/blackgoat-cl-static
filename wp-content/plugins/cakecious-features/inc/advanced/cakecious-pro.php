<?php

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CAKECIOUS_PRO_VERSION', '1.2.0-beta2' );

define( 'CAKECIOUS_VERSION_REQUIRED', '1.0' );

define( 'CAKECIOUS_PRO_DIR', plugin_dir_path( __FILE__ ) );

define( 'CAKECIOUS_PRO_URI', plugins_url( '/', __FILE__ ) );

define( 'CAKECIOUS_PRO_FILE', plugin_basename( __FILE__ ) );

define( 'CAKECIOUS_PRO_URL', plugins_url( '/', __FILE__ ) );

define( 'CAKECIOUS_PRO_CSS_URL', trailingslashit( CAKECIOUS_PRO_URL ) . 'assets/css' );

define( 'CAKECIOUS_PRO_JS_URL', trailingslashit( CAKECIOUS_PRO_URL ) . 'assets/js' );


/**
 * Plugin initiation
 */

// Load the plugin if current template is "cakecious".
if ( 'cakecious' === get_template() ) {
	require_once( CAKECIOUS_PRO_DIR . 'inc/class-cakecious-pro.php' );
}

// Otherwise, show notice and abort.
else {
	add_action( 'admin_notices', function() {
		?>
		<div class="notice notice-error is-dismissible">
			<p>
				<?php
				esc_html_e( 'Cakecious Pro plugin requires Cakecious theme to be installed and activated. The plugin is currently NOT RUNNING.', 'cakecious-features' );

				$theme = wp_get_theme( 'cakecious' );
				if ( $theme->exists() ) {
					$url = esc_url( add_query_arg( 'theme', 'cakecious', admin_url( 'themes.php' ) ) );
					$label = esc_html__( 'Activate Now', 'cakecious-features' );

					echo '&nbsp;&nbsp;<a class="button button-secondary" href="' . $url . '" style="margin: -0.5em 0;">' . $label . '</a>'; // WPCS: XSS OK.

				} else {
				}

				?>
			</p>
		</div>
	<?php
	});
}


/* Adding metaboxes -- tt */

// Only include metabox on post add/edit page and term add/edit page.
global $pagenow;
if ( in_array( $pagenow, array( 'post.php', 'post-new.php', 'edit-tags.php', 'term.php' ) ) ) {
	require_once( CAKECIOUS_PRO_DIR . '/inc/class-cakecious-admin-metabox-page-settings.php' );
}

function blvframework_page_boxes( $slug='', $post_type, $post ) {

	if( $slug != '') $slug = get_template();
	if( $slug != '') {
		$post_types = array_merge( array( 'post', 'page' ), get_post_types( array(
			'public'             => true,
			'publicly_queryable' => true,
			'rewrite'            => true,
			'_builtin'           => false,
		), 'names' ) );
		$ignored_post_types = apply_filters( $slug .'/admin/metabox/page_settings/ignored_post_types', array() );
		$post_types = array_diff( $post_types, $ignored_post_types );
		add_meta_box(
			$slug .'_page_settings',
			/* translators: %s: theme name. */
			sprintf( esc_html__( 'Page Settings (%s)', 'cakecious-features' ), ucfirst(get_template()) ),
			array( $this, 'render_meta_box__post' ),
			$post_types,
			'normal',
			'high'
		);
	}

}

function blvframework_page_boxes_add() {

	// Post meta box
	add_action(
		'add_meta_boxes',
		'blvframework_page_boxes',
		10,
		2
	);


}

add_filter( 'script_loader_tag', 'blvframework_add_defer_attribute_to_scripts', 10, 2 );
/**
 * Add 'defer' attribute to some scripts.
 *
 * @param string $tag
 * @param string $handle
 * @return string
 */
function blvframework_add_defer_attribute_to_scripts( $tag, $handle ) {

	$slug = get_template();

	$scripts_to_defer = apply_filters( $slug .'/frontend/defer_scripts', array() );

	foreach ( $scripts_to_defer as $script ) {
		if ( $script === $handle ) {
			return str_replace( ' src', ' defer src', $tag );
		}
	}

	return $tag;
}