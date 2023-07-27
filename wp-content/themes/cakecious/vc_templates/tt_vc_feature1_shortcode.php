<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);
$img = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';

?>
<div class="coach">
   <a href="<?php echo esc_url( $link ); ?>" class="coach_img">
        <img src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
   </a>
    <a href="<?php echo esc_url( $link ); ?>"><?php echo esc_html( $title ); ?></a>
</div>