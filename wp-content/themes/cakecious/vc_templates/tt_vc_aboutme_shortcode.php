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

<section class="about_me_area">
    <div class="about_me_left">
        <div class="about_content">
            <h2><?php echo esc_attr( $title ); ?></h2>
            <p class="bold"><?php echo esc_textarea( $bold_desc ); ?></p>
            <p><?php echo esc_textarea( $desc ); ?></p>
			<?php if( '' != $button_link['url'] ) { ?>
			<a class="get_btn" href="<?php echo esc_url( $button_link['url'] ); ?>" <?php echo wp_kses_post($button_target4); ?> <?php echo wp_kses_post($button_rel4); ?> ><?php echo esc_attr( $button_link['title'] ); ?></a>
			<?php } ?>
        </div>
    </div>
    <div class="about_me_right">
        <img src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
    </div>
</section>