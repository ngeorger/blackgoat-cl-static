<?php
/**
 * Blog Related Posts template.
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

$thumbnail_display = cakecious_get_theme_mod( 'blog_related_posts_thumbnail_display' );
$meta_display = cakecious_get_theme_mod( 'blog_related_posts_meta_display' );
$columns = cakecious_get_theme_mod( 'blog_related_posts_columns' );
?>
<div class="cakecious-related-posts">
	<?php if ( '' !== $heading = trim( cakecious_get_theme_mod( 'blog_related_posts_heading_text' ) ) ) : ?>
		<h2 class="cakecious-related-posts-heading small-title"><?php echo $heading; // WPCS: XSS OK ?></h2>
	<?php endif; ?>
	<ul class="cakecious-related-posts-list <?php echo esc_attr( 'cakecious-related-posts-thumbnail-display-' . $thumbnail_display ); ?> <?php echo esc_attr( 'cakecious-related-posts-columns-' . $columns ); ?>">
		<?php while ( have_posts() ) : the_post(); ?>
			<li class="cakecious-related-post">
				<?php if ( '' !== $thumbnail_display && has_post_thumbnail() ) : ?>
					<a href="<?php the_permalink(); ?>" class="cakecious-related-post-thumbnail">
						<?php echo get_the_post_thumbnail( null, cakecious_get_theme_mod( 'blog_related_posts_thumbnail_size' ) ); ?>
					</a>
				<?php endif; ?>
				<div class="cakecious-related-post-text">
					<h3 class="cakecious-related-post-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h3>
					<?php if ( '' !== $meta_display ) : ?>
						<div class="cakecious-related-post-meta entry-meta">
							<?php switch ( $meta_display ) {
								case 'date':
									echo esc_html( get_the_date( '') );
									break;
								
								case 'categories':
									$cat_objects = get_the_category();
									$cat_names = wp_list_pluck( $cat_objects, 'name' );

									echo esc_html( implode( esc_html_x( ', ', 'terms list separator', 'cakecious-features' ), $cat_names ) );
									break;
							}
							?>
						</div>
					<?php endif; ?>
				</div>
			</li>
		<?php endwhile; ?>
	</ul>
</div>