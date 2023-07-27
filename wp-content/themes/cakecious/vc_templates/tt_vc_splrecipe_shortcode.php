<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);

?>

<div class="special_recipe_slider owl-carousel">
	    <?php print do_shortcode($content); ?>
</div>
