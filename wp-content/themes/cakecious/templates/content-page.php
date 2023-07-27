<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package cakecious
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	 <?php echo cakecious_fw_post_title('h1'); ?>

     <?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?> 
    
	<div class="entry-content clearfix">

		<?php the_content(); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links clearfix">' . esc_html__( 'Pages:', 'cakecious' ),
				'after'  => '</div>',
			) );
		?>

	</div><!-- .entry-content -->

</div><!-- #post-## -->
