<?php
/*
 * Templatation.com
 *
 * Hero block box shortcode template file
 * $temptt_hero_vars is array of supplied SC parameters.
 *
 */

$heading = $content = $image = $color = $yoast_bdcmp = $temptt_bptop = $temptt_bpbottom = '';


// generate block padding code, if its not empty, or not -1 which disables it.
$temptt_bptop = !empty($temptt_hero_vars['temptt_block_padding_top']) ? ( ('-1' === $temptt_hero_vars['temptt_block_padding_top']) ? '' : 'padding-top:'.$temptt_hero_vars['temptt_block_padding_top'].'px;' ) : '';

$temptt_bpbottom = !empty($temptt_hero_vars['temptt_block_padding_bottom']) ? ( ('-1' === $temptt_hero_vars['temptt_block_padding_bottom']) ? '' : 'padding-bottom:'.$temptt_hero_vars['temptt_block_padding_bottom'].'px;' ) : '';

$block_padding = $temptt_bptop.$temptt_bpbottom;


?>
<section class="breadcrumb-area banner_area">
	    <div class="banner_text">
					<?php if('' != $temptt_hero_vars['temptt_heading']) { ?>
						<h3 class="tt-title"><?php echo wp_kses($temptt_hero_vars['temptt_heading'], cakecious_tt_allowed_tags()); ?></h3>
					<?php } ?>
					<?php if('' != $temptt_hero_vars['temptt_content']) { ?>
						<?php echo wpautop(do_shortcode(wp_kses($temptt_hero_vars['temptt_content'], cakecious_tt_allowed_tags()))); ?>
					<?php } ?>
					<?php
					// Breadcrumb
						 if ( $temptt_hero_vars['temptt_yoast_bdcmp'] ) {
							 if( function_exists('breadcrumb_trail') ){
								 breadcrumb_trail();
							 }
						 }
					?>
		    </div>
</section>