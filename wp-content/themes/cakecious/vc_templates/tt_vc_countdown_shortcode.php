<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);

?>

<div class="counter_col">
    <h1 class="counter"><?php echo esc_attr($number); ?></h1>
    <h4><?php echo esc_attr($label); ?></h4>
</div>