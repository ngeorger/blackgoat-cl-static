<div class="blog_time">
	<div class="float-left">
		<a href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a>
	</div>
	<div class="float-right">
		<ul class="list_style">
			<li>
			<span class="author vcard"><a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php esc_html_e('By: ', 'cakecious'); ?><?php echo esc_html( get_the_author() ); ?></a></span>
			</li>
			<?php echo cakecious_tt_get_cats('single'); ?>
			<?php
			if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) { ?>
				<li>
			<?php comments_popup_link( esc_html__( '0 comment', 'cakecious' ), esc_html__( '1 Comment', 'cakecious' ), esc_html__( '% Comments', 'cakecious' ) ); ?>
				</li>
			<?php } ?>
		</ul>
	</div>
</div>