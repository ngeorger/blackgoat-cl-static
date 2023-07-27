<?php
/**
 * Blog Featured Posts template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$layout = cakecious_get_theme_mod( 'blog_featured_posts_layout' );
$meta_1 = cakecious_get_theme_mod( 'blog_featured_posts_meta_1' );
$meta_2 = cakecious_get_theme_mod( 'blog_featured_posts_meta_2' );

$classes = array( 'cakecious-featured-posts', 'cakecious-featured-posts-' . $layout );

// Grid
if ( 0 === strpos( $layout, 'grid-' ) ) {
	$classes[] = 'cakecious-featured-posts-grid';
}

// Slider & Carousel
if ( in_array( $layout, array( 'slider', 'carousel' ) ) ) {
	$classes[] = 'cakecious-featured-posts-tiny-slider';
}

// Backround
if ( 'slider' !== $layout ) {
	$bg = cakecious_get_theme_mod( 'blog_featured_posts_content_bg_mode' );
} else {
	$bg = 'solid';
}
$classes[] = 'cakecious-featured-posts-content-bg-mode--' . $bg;

?>
<div id="cakecious-featured-posts" class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<ul class="cakecious-featured-posts-list">
		<?php $i = 0; while ( have_posts() ) : the_post(); ?>
			<li class="cakecious-featured-post <?php echo esc_attr( 'cakecious-featured-post-' . ( $i + 1 ) ); ?>">
				<div class="cakecious-featured-post-inner">
					<?php printf(
						/* translators: %1$s: HTML tag (a or div), %2$s: href attribute (if it's a link), %3$s: image URL. */
						'<%1$s %2$s class="cakecious-featured-post-background" style="background-image: url(%3$s)"></%1$s>',
						intval( cakecious_get_theme_mod( 'blog_featured_posts_image_link' ) ) ? 'a' : 'div',
						intval( cakecious_get_theme_mod( 'blog_featured_posts_image_link' ) ) ? 'href="' . esc_url( get_permalink() ) . '"' : '',
						esc_attr( get_the_post_thumbnail_url( null, 'full' ) )
					); ?>

					<div class="cakecious-featured-post-text <?php echo esc_attr( 'cakecious-text-align-' . cakecious_get_theme_mod( 'blog_featured_posts_content_alignment' ) ); ?>">
						<?php if ( '' !== $meta_1 ) : ?>
							<div class="cakecious-featured-post-meta-1 cakecious-featured-post-meta entry-meta"><?php cakecious_entry_meta_element( $meta_1 ); ?></div>
						<?php endif; ?>

						<?php
						$title_class = 'title';
						if ( 'slider' !== $layout ) {
							$title_class = 'small-title';
						}
						?>
						<h2 class="cakecious-featured-post-title <?php echo esc_attr( $title_class ); ?>"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

						<?php if ( '' !== $meta_2 ) : ?>
							<div class="cakecious-featured-post-meta-2 cakecious-featured-post-meta entry-meta"><?php cakecious_entry_meta_element( $meta_2 ); ?></div>
						<?php endif; ?>
					</div>
				</div>
			</li>
		<?php $i++; endwhile; ?>
	</ul>

	<?php if ( in_array( $layout, array( 'slider', 'carousel' ) ) ) : ?>
		<div class="cakecious-featured-posts-navigation">
			<button class="cakecious-featured-posts-navigation-button cakecious-featured-posts-navigation-button-prev"><?php echo cakecious_icon( 'chevron-left' ); ?></button>
			<button class="cakecious-featured-posts-navigation-button cakecious-featured-posts-navigation-button-next"><?php echo cakecious_icon( 'chevron-right' ); ?></button>
		</div>
	<?php endif; ?>
</div>