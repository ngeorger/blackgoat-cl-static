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


<div class="discover_item">
	<?php if( 'true' == $link_title ) { ?>
		<?php if( '' != $button_link['url'] ) { ?>
		<a href="<?php echo esc_url( $button_link['url'] ); ?>"  <?php echo wp_kses_post($button_target4); ?> <?php echo wp_kses_post($button_rel4); ?> ><?php echo esc_attr( $button_link['title'] ); ?></a>
		<?php } } else { ?>
	<h4><?php echo esc_html( $title ); ?></h4>
	<?php } ?>
    <p>
	    <?php echo do_shortcode(wp_kses($content, cakecious_tt_allowed_tags())); ?>
	    <?php if( '' != $price ) { ?>
	    <span><?php echo esc_html( $price ); ?></span>
		<?php } ?>
    </p>
	<?php if(  '' == $link_title && '' != $button_link['url'] ) { ?>
	<p><a href="<?php echo esc_url( $button_link['url'] ); ?>"  <?php echo wp_kses_post($button_target4); ?> <?php echo wp_kses_post($button_rel4); ?> ><?php echo esc_attr( $button_link['title'] ); ?></a></p>
	<?php } ?>
</div>