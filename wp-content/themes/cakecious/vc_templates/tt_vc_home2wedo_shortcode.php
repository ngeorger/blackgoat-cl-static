<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);
?>
<?php if( 'type2' == $type ) { ?>
<section class="what_wedo_area what_we_area_two">
    <div class="container">
       <div class="left_tittle">
           <h2><?php echo esc_html($title); ?></h2>
           <p><?php echo esc_html($desc); ?></p>
       </div>
        <div class="row what_wedo_inner m-0">
            <div class="what_wedo_carousel owl-carousel">

                <?php print do_shortcode($content); ?>

            </div>
        </div>
    </div>
</section>
<?php } else { ?>
<section class="what_wedo_area">
    <div class="container">
       <div class="left_tittle">
           <h2><?php echo esc_html($title); ?></h2>
           <p><?php echo esc_html($desc); ?></p>
       </div>
        <div class="row what_wedo_inner m-0">
            <div class="what_wedo_carousel owl-carousel">

                <?php print do_shortcode($content); ?>

            </div>
        </div>
    </div>
</section>
<?php } ?>