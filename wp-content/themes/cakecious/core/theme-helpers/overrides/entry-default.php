<?php
/**
 * @package cakecious
 */
?>


<div <?php post_class('single-blog-style-four clearfix'); ?>>
	<?php if( has_post_thumbnail() ) { ?>
		<div class="date-box">
			<?php echo get_the_date(); ?>
		</div><!-- /.date-box -->
	<?php } ?>
    <div class="content-box">
        <div class="img-box">
            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
        </div><!-- /.img-box -->
        <div class="text-box">
				<ul class="nav">
					<li><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>">
							<?php esc_html_e('By :', 'cakecious' );?>
							<?php the_author(); ?>
						</a>
					</li>
					<?php
					if ( comments_open() || get_comments_number() ) { ?>
						<li>
							<a href="<?php echo trailingslashit(get_the_permalink()); ?>#comments">
								<?php esc_html_e('Comments:', 'cakecious' );?>
								<?php echo get_comments_number($post->ID); ?>
							</a>
						</li>
					<?php } ?>
				</ul>
				<?php
					if ( is_single() ) {
			                the_title( '<h3>', '</h3>' );
					} else {
			                the_title( sprintf( '<a href="%s" rel="bookmark" class="blog_tittle"><h3>', esc_url( get_permalink() ) ), '</h3></a>' );
					}
				?>
		<div class="entry-content">
			<?php
			/**
			 * Hook: cakecious/frontend/entry/before_content
			 */
			do_action( 'cakecious/frontend/entry/before_content' );

			// If it's included in a single post page.
			if ( is_single() ) {
				// Print the content.
				the_content();

				// Print content pagination, if exists.
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'cakecious' ),
					'after'  => '</div>',
				) );
			}
			// If it's included in a posts archive page.
			else {
				the_content();
			}

			/**
			 * Hook: cakecious/frontend/entry/after_content
			 */
			do_action( 'cakecious/frontend/entry/after_content' );
			?>
		</div>
			<?php

			if ( ! is_single() ) {
				?>
	        		<a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('continue...', 'cakecious'); ?></a>
			<?php } ?>

        </div><!-- /.text-box -->
    </div><!-- /.content-box -->
</div>

