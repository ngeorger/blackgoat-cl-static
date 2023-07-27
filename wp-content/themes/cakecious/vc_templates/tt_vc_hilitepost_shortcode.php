<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);
$img = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';

?>

<div class="l_news_image">
    <div class="l_news_img">
        <img src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
    </div>
    <div class="l_news_hover">
        <a href="<?php echo esc_url( $link ); ?>"><h4><?php echo esc_html( $title ); ?></h4></a>
    </div>
</div>