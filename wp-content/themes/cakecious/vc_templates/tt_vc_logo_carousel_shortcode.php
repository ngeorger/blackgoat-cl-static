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

$gal_images = '';
$link_start = '';
$link_end = '';
$el_start = '';
$el_end = '';
$slides_wrap_start = '';
$slides_wrap_end = '';
$pretty_rand = 'link_image' === $onclick ? ' data-rel="prettyPhoto[rel-' . get_the_ID() . '-' . rand() . ']"' : '';

//wp_enqueue_script( 'vc_carousel_js' );
//wp_enqueue_style( 'vc_carousel_css' );
if ( 'link_image' === $onclick ) {
	wp_enqueue_script( 'prettyphoto' );
	wp_enqueue_style( 'prettyphoto' );
}

if ( '' === $images ) {
	$images = '-1,-2,-3';
}

if ( 'custom_link' === $onclick ) {
	$custom_links = vc_value_from_safe( $custom_links );
	$custom_links = explode( ',', $custom_links );
}

$images = explode( ',', $images );
$i = - 1;

$class_to_filter = 'wpb_images_carousel wpb_content_element vc_clearfix';
$class_to_filter .= vc_shortcode_custom_css_class( $css, ' ' ) . $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class_to_filter, $this->settings['base'], $atts );

$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
?>
<div <?php echo implode( ' ', $wrapper_attributes ); ?> class="<?php echo esc_attr( apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $css_class, $this->settings['base'], $atts ) ); ?>">
		<div class="client-carousel-home-three owl-carousel owl-theme">
						<?php foreach ( $images as $attach_id ) :  ?>
							<?php
							$i ++;
							if ( $attach_id > 0 ) {
								$post_thumbnail = wpb_getImageBySize( array(
									'attach_id' => $attach_id,
									'thumb_size' => $img_size,
								) );
							} else {
								$post_thumbnail = array();
								$post_thumbnail['thumbnail'] = '<img src="' . vc_asset_url( 'vc/no_image.png' ) . '" />';
								$post_thumbnail['p_img_large'][0] = vc_asset_url( 'vc/no_image.png' );
							}
							$thumbnail = $post_thumbnail['thumbnail'];
							?>
			<div class="item">
									<?php if ( 'link_image' === $onclick ) :  ?>
										<?php $p_img_large = $post_thumbnail['p_img_large']; ?>
										<a class="prettyphoto" href="<?php echo esc_url($p_img_large[0]); ?>" <?php print wp_kses_post($pretty_rand); ?>>
										<?php print wp_kses_post($thumbnail); ?>
										</a>
									<?php elseif ( 'custom_link' === $onclick && isset( $custom_links[ $i ] ) && '' !== $custom_links[ $i ] ) :  ?>
										<a href="<?php echo esc_url($custom_links[ $i ]); ?>"<?php echo( ! empty( $custom_links_target ) ? ' target="' . $custom_links_target . '"' : '' ) ?>>
										<?php print wp_kses_post($thumbnail); ?>
										</a>
									<?php else : ?>
										<?php print wp_kses_post($thumbnail); ?>
									<?php endif ?>
			</div><!-- /.item -->
						<?php endforeach ?>
		</div><!-- /.client-carousel owl-carousel owl-theme -->

</div>
