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
<div class="single-project">
	<div class="img-box">
		<img src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
		<div class="overlay">
			<div class="box">
				<div class="content">
				<a href="<?php echo esc_url( $button_link['url'] ); ?>"  <?php echo wp_kses_post($button_target4); ?> <?php echo wp_kses_post($button_rel4); ?> ><?php echo esc_attr( $button_link['title'] ); ?></a>
				</div><!-- /.content -->
			</div><!-- /.box -->
		</div><!-- /.overlay -->
	</div><!-- /.img-box -->
	<a href="<?php echo esc_url( $button_link['url'] ); ?>"><h3><?php echo esc_attr( $title ); ?></h3></a>
	<div class="line"></div><!-- /.line -->
</div><!-- /.single-project -->