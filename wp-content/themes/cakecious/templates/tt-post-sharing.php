<?php
if ( ! defined( 'ABSPATH' ) ) exit;

 /*
  *  template file
  * @templatation.com
  */
?>


<?php
global $post;

$url[] = '';
$url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
?>

<div class="tag-social-box clearfix">

    <?php if ( cakecious_fw_get_option( 'post_sharing', 1 ) ) { ?>

    <div class="header_social social-box pull-right">
        <ul >
            <li>
                <a  target="_blank" href="http://www.facebook.com/share.php?u=<?php the_permalink(); ?>" onClick="return cakecious_fb_like_<?php echo the_ID(); ?>()">
                    <i class="fa fa-facebook"></i>
                </a>
            </li>
            <li>
                <a  target="_blank" href="https://twitter.com/share?url=<?php the_permalink(); ?>" onClick="return cakecious_tweet_<?php echo the_ID(); ?>()">
                    <i class="fa fa-twitter"></i>
                </a>
            </li>
            <li>
                <a  target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onClick="return cakecious_goog_<?php echo the_ID(); ?>()">
                    <i class="fa fa-google-plus"></i>
                </a>
            </li>
            <li>
                <a  target="_blank" href="'https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>" onClick="return cakecious_ln_<?php echo the_ID(); ?>()">
                    <i class="fa fa-linkedin"></i>
                </a>
            </li>
            <li>
                <a  target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" onClick="return cakecious_pin_<?php echo the_ID(); ?>()">
                    <i class="fa fa-pinterest"></i>
                </a>
            </li>
        </ul>
    </div>
</div>



<script type="text/javascript">
    function cakecious_fb_like_<?php echo the_ID(); ?>() {
        window.open('http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
        return false;
    }
    function cakecious_tweet_<?php echo the_ID(); ?>() {
        window.open('https://twitter.com/share?url=<?php the_permalink(); ?>&t=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
        return false;
    }
    function cakecious_ln_<?php echo the_ID(); ?>() {
        window.open('https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
        return false;
    }
    function cakecious_goog_<?php echo the_ID(); ?>() {
        window.open('https://plus.google.com/share?url=<?php the_permalink(); ?>','sharer','toolbar=0,status=0,width=626,height=436');
        return false;
    }
    function cakecious_pin_<?php echo the_ID(); ?>() {
        window.open('http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo esc_url($url[0]); ?>&description=<?php echo sanitize_title(get_the_title()); ?>','sharer','toolbar=0,status=0,width=626,height=436');
        return false;
    }
</script>

<?php } else
    echo '</div>';
?>