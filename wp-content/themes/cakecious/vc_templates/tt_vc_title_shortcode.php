<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);
?>


<?php if( 'type3' == $type ) { ?>
<div class="<?php echo ( 'white' == $color ) ? 'main_w_title' : 'main_title'; ?>">
    <h2><?php echo esc_html($title); ?></h2>
    <h5><?php echo do_shortcode(wp_kses($desc, cakecious_tt_allowed_tags())); ?></h5>
</div>

<?php } elseif( 'type2' == $type ) { ?>
<div class="main_title">
    <h2><?php echo esc_html($title); ?></h2>
    <p><?php echo do_shortcode(wp_kses($desc, cakecious_tt_allowed_tags())); ?></p>
</div>

<?php } elseif( 'type1' == $type ) { ?>

<div class="single_pest_title">
    <h2><?php echo esc_html($title); ?></h2>
	<p><?php echo do_shortcode(wp_kses($desc, cakecious_tt_allowed_tags())); ?></p>
</div>

<?php } else { ?>

<div class="single_b_title">
    <h2><?php echo esc_html($title); ?></h2>
	<?php if( '' != $desc ) { ?>
	<p><?php echo do_shortcode(wp_kses($desc, cakecious_tt_allowed_tags())); ?></p>
	<?php } ?>
</div>


<?php }  ?>