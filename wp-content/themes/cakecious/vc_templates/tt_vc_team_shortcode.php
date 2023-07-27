<?php


$list_type = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$img = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';

?>

<div class="chef_item">
	<div class="chef_img">
		<img class="img-fluid" src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
		<ul class="list_style">
			<?php if( '' != $link1 ) { ?>
				<li><a href="<?php echo esc_url( $link1 ); ?>" class="<?php echo esc_attr( $icon1 ); ?>"></a></li>
			<?php } if( '' != $link2 ) { ?>
				<li><a href="<?php echo esc_url( $link2 ); ?>" class="<?php echo esc_attr( $icon2 ); ?>"></a></li>
			<?php } if( '' != $link3 ) { ?>
				<li><a href="<?php echo esc_url( $link3 ); ?>" class="<?php echo esc_attr( $icon3 ); ?>"></a></li>
			<?php } if( '' != $link4 ) { ?>
				<li><a href="<?php echo esc_url( $link4 ); ?>" class="<?php echo esc_attr( $icon4 ); ?>"></a></li>
			<?php } if( '' != $link5 ) { ?>
				<li><a href="<?php echo esc_url( $link5 ); ?>" class="<?php echo esc_attr( $icon5 ); ?>"></a></li>
			<?php } ?>
		</ul>
	</div>
	<h4><?php echo esc_html( $name ); ?></h4>
	<h5><?php echo esc_html( $post ); ?></h5>
</div>