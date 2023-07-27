<?php
/*
 * Templatation.com
 *
 */
?>

<div class="recent_widget">
<div class="recent_inner">
	<?php while( $posts->have_posts() ): $posts->the_post();?>
    <div class="media">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(array('70', '60')); ?></a>
        <div class="media-body">
            <?php the_title( '<a href="%s" rel="bookmark">', '</a>' ); ?>
            <h6><?php the_time( get_option( 'date_format' ) ); ?></h6>
        </div>
    </div>
	<?php endwhile; ?>
</div>
</div>