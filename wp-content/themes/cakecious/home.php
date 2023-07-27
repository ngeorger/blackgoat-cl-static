<?php
/**
 * The template for displaying blog posts (home) page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Cakecious
 */

?>
<?php if ( cakecious_is_fresh_install() ) {

	// Use same template as archive.php
	get_template_part( 'archive' );

?>

<?php } else {

	// Use same template as archive.php
	get_template_part( 'index' );

}

?>
