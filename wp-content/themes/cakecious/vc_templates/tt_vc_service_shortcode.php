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
<?php if( $type == 'type2') { ?>
<div class="service-style-two">
	<div class="single-service-style-two <?php echo esc_attr( $bgtype ); ?>">
		<?php
		if( ! (strpos($insert_graphic, 'image') === false) ) { ?>
			<img src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
		<?php } ?>

		<?php if( ! (strpos($insert_graphic, 'icon' ) === false) ) { ?>
			<i class="<?php echo esc_attr( $icon1 ); ?>"></i>
		<?php } ?>
		    <h3><?php echo esc_html( $title ); ?></h3>
			<p><?php echo do_shortcode(wp_kses($content, cakecious_tt_allowed_tags())); ?></p>
			<?php if( '' != $button_link['url'] ) { ?>
			<a class="read-more" href="<?php echo esc_url( $button_link['url'] ); ?>"  <?php echo wp_kses_post($button_target4); ?> <?php echo wp_kses_post($button_rel4); ?> ><?php echo esc_attr( $button_link['title'] ); ?></a>
			<?php } ?>
	</div>
</div>
<?php } else { ?>
<div class="service-style-one">
	<div class="single-service-style-one">
	    <div class="icon-box">
		<?php
		if( ! (strpos($insert_graphic, 'image') === false) ) { ?>
			<img src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
		<?php } ?>

		<?php if( ! (strpos($insert_graphic, 'icon' ) === false) ) { ?>
			<i class="<?php echo esc_attr( $icon1 ); ?>"></i>
		<?php } ?>
	    </div><!-- /.icon-box -->
	    <div class="text-box">
			<h3><?php echo esc_html( $title ); ?></h3>
			<p><?php echo do_shortcode(wp_kses($content, cakecious_tt_allowed_tags())); ?></p>
			<?php if( '' != $button_link['url'] ) { ?>
			<a class="read-more" href="<?php echo esc_url( $button_link['url'] ); ?>"  <?php echo wp_kses_post($button_target4); ?> <?php echo wp_kses_post($button_rel4); ?> ><?php echo esc_attr( $button_link['title'] ); ?></a>
			<?php } ?>
	    </div><!-- /.text-box -->
	</div>
</div>
<?php } ?>