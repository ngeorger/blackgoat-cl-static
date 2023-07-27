<?php
/*
 * Templatation.com
 *
 * Hero block box shortcode template file
 * $temptt_hero_vars is array of supplied SC parameters.
 *  $temptt_hero_vars['temptt_heading']
	$temptt_hero_vars['temptt_content']
	$temptt_hero_vars['temptt_image']
	$temptt_hero_vars['temptt_color']
	$temptt_hero_vars['temptt_yoast_bdcmp']
	$temptt_hero_vars['temptt_block_padding_top']
	$temptt_hero_vars['temptt_block_padding_bottom']

 */

$heading = $content = $image = $color = $yoast_bdcmp = $temptt_bptop = $temptt_bpbottom = '';


// generate block padding code, if its not empty, or not -1 which disables it.
$temptt_bptop = !empty($temptt_hero_vars['temptt_block_padding_top']) ? ( ('-1' === $temptt_hero_vars['temptt_block_padding_top']) ? '' : 'padding-top:'.$temptt_hero_vars['temptt_block_padding_top'].'px;' ) : '';

$temptt_bpbottom = !empty($temptt_hero_vars['temptt_block_padding_bottom']) ? ( ('-1' === $temptt_hero_vars['temptt_block_padding_bottom']) ? '' : 'padding-bottom:'.$temptt_hero_vars['temptt_block_padding_bottom'].'px;' ) : '';

$block_padding = $temptt_bptop.$temptt_bpbottom;


?>

<section class="breadcrumb-area " style="
	<?php if(isset($temptt_hero_vars['temptt_image']) ) echo 'background-image: url('. $temptt_hero_vars['temptt_image']. ');'; ?>
	 <?php echo esc_attr($block_padding); ?>
	">
    <div class="overlay-clr" style="<?php echo 'background-color: '. $temptt_hero_vars['temptt_color'].';'; ?>"></div>
	<div class="breadcrumb-text-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="breadcrumb-text text-center">
					<?php if(!empty($temptt_hero_vars['temptt_heading']) ) { ?>
					<h1 class="tt-title"><?php echo esc_textarea($temptt_hero_vars['temptt_heading']); ?></h1>
						<?php } ?>
						<?php if(!empty($temptt_hero_vars['temptt_content']) ) { ?>
					<p class="description">
						<?php echo wpautop(do_shortcode($temptt_hero_vars['temptt_content'])); ?>
					</p>
						<?php }
					// Breadcrumb
					 if ( $temptt_hero_vars['temptt_yoast_bdcmp'] && function_exists('yoast_breadcrumb') ) {
						 yoast_breadcrumb('<div class="yt-breadcrumbs">','</div>');
					 }
					?>
                    <div class="line displayinblock"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>