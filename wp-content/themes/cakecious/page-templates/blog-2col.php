<?php
/**
 * Template Name: Blog 2 Column - Deprecated
 *
 * @package cakecious
 */

get_header(); ?>

<?php do_action( 'tt_before_mainblock' ); ?>

<section class="main_blog_area p_100">
    <div class="container">
        <div class="blog_area_inner">
			<div class="main_blog_column row">

			<?php
			$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
			$args  = array(
				'post_type' => 'post',
				'paged'     => $paged
			);

			global $wp_query;
			$original_query = $wp_query;

			// query
			$tt_query = new WP_Query( $args );
			$wp_query = $tt_query;

			// loop
			if ($tt_query->have_posts()) :
			while ( $tt_query->have_posts() ) : $tt_query->the_post();
				?>

				<div class="col-lg-6">

					<div <?php post_class('blog_item'); ?>>
						<div class="blog_img">
					    <?php if ( has_post_thumbnail() ) : ?>
						    <a href="<?php the_permalink(); ?>">
					        <?php the_post_thumbnail('cakecious-bloggrid', array('class' => 'img-fluid')); ?>
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

				</div>

			<?php
			endwhile; ?>

			</div>
			<div class="blog_pagination">
				<?php
				// Previous/next page navigation.
				the_posts_pagination( array(
					'prev_text'          => esc_html__( '<', 'cakecious' ),
					'next_text'          => esc_html__( '>', 'cakecious' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'cakecious' ) . ' </span>',
				) );
				?>
			</div>
			<?php endif; ?>
		<?php wp_reset_postdata(); ?>

		<?php $wp_query = $original_query; ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>


