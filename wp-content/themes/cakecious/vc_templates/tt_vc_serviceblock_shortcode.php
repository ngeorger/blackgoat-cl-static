<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);
$img = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';
$button_link = ( '||' === $btn_link ) ? '' : $btn_link;
$button_link = vc_build_link( $button_link );
$button_target4 = ( empty( $button_link['target'] )) ? '' : 'target="'. $button_link['target'].'"';
$button_rel4 = ( empty( $button_link['rel'] )) ? '' : 'rel="'. $button_link['rel'].'"';

?>
<div class="service_m_item">
    <div class="service_img_inner">
		<div class="service_img">
			<?php if( '' != $button_link['url'] ) { ?>
			<a href="<?php echo esc_url( $button_link['url'] ); ?>"  <?php echo wp_kses_post($button_target4); ?> <?php echo wp_kses_post($button_rel4); ?> ><img class="rounded-circle" src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" /></a>
			<?php } else { ?>
			<img class="rounded-circle" src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
			<?php }  ?>

		</div>
    </div>
    <div class="service_text">
			<?php if( '' != $button_link['url'] ) { ?>
			<a href="<?php echo esc_url( $button_link['url'] ); ?>"  <?php echo wp_kses_post($button_target4); ?> <?php echo wp_kses_post($button_rel4); ?> ><?php echo esc_attr( $button_link['title'] ); ?></a>
			<?php } ?>
    </div>
</div>