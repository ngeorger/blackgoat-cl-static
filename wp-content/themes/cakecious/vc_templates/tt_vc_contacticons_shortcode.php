<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);

$theicon = ( $customicon == '' ) ? $icon1 : $customicon;
?>

<div class="meet">
    <i class="<?php echo esc_html( $theicon ); ?>"></i>
    <h3><?php echo esc_attr( $title ); ?></h3>
    <h6><?php echo do_shortcode(wp_kses_post($content)); ?></h6>
</div>