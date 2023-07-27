<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);

?>
<section class="welcome_bakery_area cake_feature_main p_100">
    <div class="container">
		<div class="main_title">
			<h2>Our Featured Cakes</h2>
			<h5> Seldolor sit amet consect etur</h5>
		</div>
		<div class="cake_feature_row row">
	<?php print do_shortcode($content); ?>
		</div>
    </div>
</section>
