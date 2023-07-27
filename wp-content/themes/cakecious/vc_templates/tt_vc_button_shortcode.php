<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);

$button_link = ( '||' === $btn_link ) ? '' : $btn_link;
$button_link = vc_build_link( $button_link );
$button_target4 = ( empty( $button_link['target'] )) ? '' : 'target="'. $button_link['target'].'"';
$button_rel4 = ( empty( $button_link['rel'] )) ? '' : 'rel="'. $button_link['rel'].'"';

?>



<a class="more-btn" href="<?php echo esc_url( $button_link['url'] ); ?>" <?php echo wp_kses_post($button_target4); ?> <?php echo wp_kses_post($button_rel4); ?> ><?php echo wp_kses($button_link['title'], cakecious_tt_allowed_tags()); ?></a>

