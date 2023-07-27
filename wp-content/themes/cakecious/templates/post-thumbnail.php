<?php if( has_post_thumbnail()) { ?>
<div class="post-image">
    <?php echo get_the_post_thumbnail( $post->ID, array('840', '360') ); ?>
</div>
<?php } ?>