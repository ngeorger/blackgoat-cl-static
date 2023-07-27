<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

wp_enqueue_script( 'countdown', get_template_directory_uri() . '/assets/assets/jquery.countdown.min.js', array('jquery'), null, true );

extract($atts);

?>

<div class="thm-container text-center">
	<h3><?php echo esc_html( $title ); ?></h3>
	<ul class="countdown-box clearfix" data-countdown-time="<?php print wp_kses_post($date); ?>">
        <!-- Loading content via jQuery -->
    </ul>
    <p><?php echo wp_kses($desc, cakecious_tt_allowed_tags()); ?></p>
</div><!-- /.thm-container -->

