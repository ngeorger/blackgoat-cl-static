<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$title = $onclick = $custom_links = $custom_links_target =
$img_size = $images = $el_class = $el_id = $mode = $slides_per_view =
$wrap = $autoplay = $hide_pagination_control =
$hide_prev_next_buttons = $speed = $partial_view = $css = $css_animation = '';

$output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$button_link = ( '||' === $btn_link ) ? '' : $btn_link;
$button_link = vc_build_link( $button_link );
$button_target4 = ( empty( $button_link['target'] )) ? '' : 'target="'. $button_link['target'].'"';
$button_rel4 = ( empty( $button_link['rel'] )) ? '' : 'rel="'. $button_link['rel'].'"';

?>
<div class="fitness_course_row">
	<h2><?php echo esc_html( $title ); ?></h2>

	<p><?php echo esc_html( $subtitle ); ?></p>
	<?php if ( '' != $button_link['url'] ) { ?>
		<a class="get_btn"
		   href="<?php echo esc_url( $button_link['url'] ); ?>" <?php echo wp_kses_post($button_target4); ?> <?php echo wp_kses_post($button_rel4); ?> ><?php echo esc_html( $button_link['title'] ); ?></a>
	<?php } ?>
</div>
