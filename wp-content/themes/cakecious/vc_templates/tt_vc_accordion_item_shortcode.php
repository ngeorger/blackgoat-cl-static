<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);

?>
<div class="card">
	<div class="card-header" id="headingOne">
		<button class="btn btn-link <?php if( 'yes' != $active) echo ' collapsed ';?>" data-toggle="collapse" data-target="#<?php echo sanitize_title( $title );?>" aria-expanded="<?php if( 'yes' == $active) echo ' true '; else echo " false "; ?>" aria-controls="<?php echo sanitize_title( $title );?>">
		<i>+</i>
		<i>-</i>
		<?php echo esc_html($title); ?>
		</button>
	</div>
	<div id="<?php echo sanitize_title( $title );?>" class="collapse <?php if( 'yes' == $active) echo ' show ';?>" aria-labelledby="headingOne" data-parent="#accordion">
		<div class="card-body">
		<?php echo do_shortcode(wp_kses_post($content)); ?>
		</div>
	</div>
</div>

