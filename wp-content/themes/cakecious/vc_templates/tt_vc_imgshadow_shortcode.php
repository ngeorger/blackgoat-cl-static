<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);
$img = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';

?>
<?php if( 'type2' == $type ) { ?>
	<div class="fitness_img">
	    <img src="<?php echo esc_url($img); ?>" class="fitness_shadow" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
	</div>
<?php } else { ?>
	<div class="nutrition_img">
	    <img src="<?php echo esc_url($img); ?>" class="img-fluid" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
	</div>
<?php }  ?>