<?php
/*
 * Template file for projects shortcode.
 * $temptt_t_vars is an array of custom parameters set for given post shortcode.
 */

?>

<section>
	<div class="container">
		<div class="title">
			<h3><?php echo esc_attr($temptt_t_vars['temptt_var2']); ?></h3>
			<p class="tt-indesc"><?php echo wp_kses_post($temptt_t_vars['temptt_var1']); ?></p>
		</div><!-- /.title -->
		<div class="service-home-carousel owl-theme owl-carousel">
	<?php
		// Posts are found
		if ( $posts->have_posts() ) {
			while ( $posts->have_posts() ) :
				$posts->the_post();
				global $post;
				?>

			<div class="item">
				<div class="single-service-box">
					<div class="img-box">
						<?php the_post_thumbnail(); ?>
						<a href="<?php the_permalink(); ?>"><?php esc_html_e( 'view details', 'cakecious' ); ?></a>
					</div>
					<?php the_title( '<h3 class="entry-title2">', '</h3>' ); ?>
				</div>
			</div>
				<?php
			endwhile;
		}
		// Posts not found
		else {
			echo '<h4>' . esc_html__( 'Posts not found', 'cakecious' ) . '</h4>';
		}
	?>

		</div><!-- /.row -->
	</div><!-- /.container -->
</section><!-- /.service-area sec-pad dark-bg -->