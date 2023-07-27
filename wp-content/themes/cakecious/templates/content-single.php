<?php
/**
 * @package cakecious
 */
?>
<div <?php post_class('blog_item'); ?>>
	<div class="blog_img">
    <?php if ( has_post_thumbnail() ) : ?>
	    <a href="<?php the_permalink(); ?>">
        <?php the_post_thumbnail(array('840', '360'), array('class' => 'img-fluid')); ?>
		</a>
    <?php endif; ?>
	</div>
	<div class="blog_text">
		<?php get_template_part( 'templates/entry-meta' ); ?>
		<?php the_title( '<h4 class="blog-ttitle">', '</h4>' ); ?>
		<?php
		the_content();
		?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cakecious' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<footer class="entry-footer">

		<?php cakecious_entry_footer(); ?>

	</footer><!-- .entry-footer -->
</div>