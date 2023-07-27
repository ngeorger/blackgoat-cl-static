<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);

?>
<div class="col-12 nutrition_strategies">
   <div class="row media_row m-0">

        <?php print do_shortcode($content); ?>

   </div>
</div>