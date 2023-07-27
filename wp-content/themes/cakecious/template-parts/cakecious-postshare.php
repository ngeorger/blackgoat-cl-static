<?php
if ( ! defined( 'ABSPATH' ) ) exit;

 /*
  *  template file
  */
?>

<?php
global $post;

$url[] = '';
$url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
?>

<div class="tag-social-box clearfix">

    <div class="cakecious-social-box">
        <ul class="social-box">
            <li>
                <a  target="_blank" href="https://www.facebook.com/share.php?u=<?php the_permalink(); ?>" onClick="return cakecious_fb_like_<?php echo get_the_ID(); ?>()">
                    <?php cakecious_icon( 'facebook', array( 'class' => 'cakecious-share-icon' ) ); ?>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://twitter.com/share?url=<?php the_permalink(); ?>" onClick="return cakecious_tweet_<?php echo get_the_ID(); ?>()">
                    <?php cakecious_icon( 'twitter', array( 'class' => 'cakecious-share-icon' ) ); ?>
                </a>
            </li>
            <li>
                <a target="_blank" href="'https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>" onClick="return cakecious_ln_<?php echo get_the_ID(); ?>()">
                    <?php cakecious_icon( 'linkedin', array( 'class' => 'cakecious-share-icon' ) ); ?>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" onClick="return cakecious_pin_<?php echo get_the_ID(); ?>()">
                    <?php cakecious_icon( 'pinterest', array( 'class' => 'cakecious-share-icon' ) ); ?>
                </a>
            </li>
        </ul>
    </div>
</div>



<script type="text/javascript">
    function cakecious_fb_like_<?php echo get_the_ID(); ?>() {
        window.open('https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
        return false;
    }
    function cakecious_tweet_<?php echo get_the_ID(); ?>() {
        window.open('https://twitter.com/share?url=<?php the_permalink(); ?>&t=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
        return false;
    }
    function cakecious_ln_<?php echo get_the_ID(); ?>() {
        window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
        return false;
    }
    function cakecious_pin_<?php echo get_the_ID(); ?>() {
        window.open('https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo esc_url($url[0]); ?>&description=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
        return false;
    }
</script>