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

$theicon = ( $customicon == '' ) ? $icon1 : $customicon;
?>

<div class="media  col-md-6 <?php if($gray_bg == "true") echo ' b_g ';?>">
   <i class="<?php echo esc_html( $theicon ); ?>"></i>
    <div class="media-left">
        <h4><?php echo esc_html( $title ); ?></h4>
        <p><?php echo do_shortcode(wp_kses($content, cakecious_tt_allowed_tags())); ?></p>
		<?php if( '' != $button_link['url'] ) { ?>
			<a href="<?php echo esc_url( $button_link['url'] ); ?>"  <?php echo wp_kses_post($button_target4); ?> <?php echo wp_kses_post($button_rel4); ?> ><?php echo esc_attr( $button_link['title'] ); ?></a>
		<?php } ?>
    </div>
</div>