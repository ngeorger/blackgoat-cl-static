<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);
$img = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';

?>

<div class="item">
    <img src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
    <h5><?php echo esc_html( $title ); ?></h5>
</div>