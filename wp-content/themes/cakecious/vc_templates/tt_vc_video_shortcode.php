<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$output = $img = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$img = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';

?>
<div class="media">
    <div class="d-flex">
        <a class="popup-youtube" href="<?php echo esc_url( $videolink ); ?>"><i class="flaticon-play-button"></i></a>
    </div>
    <div class="media-body">
        <h5><?php echo esc_html( $title ); ?></h5>
    </div>
</div>