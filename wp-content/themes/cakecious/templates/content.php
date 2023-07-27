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
		<?php the_title( sprintf( '<a class="blog_tittle" href="%s" rel="bookmark"><h4>', esc_url( get_permalink() ) ), '</h4></a>' ); ?>
		<?php
		the_excerpt();
		?>
		<a href="<?php the_permalink(); ?>" class="pink_more"><?php esc_html_e('Read more', 'cakecious'); ?></a>
	</div>
</div>
