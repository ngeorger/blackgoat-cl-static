<?php
/**
 * @package cakecious
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract($atts);
$img = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';
$icon11 = (is_numeric($icon1) && !empty($icon1)) ? wp_get_attachment_url($icon1) : '';
$icon22 = (is_numeric($icon2) && !empty($icon2)) ? wp_get_attachment_url($icon2) : '';
$icon33 = (is_numeric($icon3) && !empty($icon3)) ? wp_get_attachment_url($icon3) : '';

?>
<section class="our-approach">
    <div class="thm-container">
        <div class="row">

            <div class="col-md-4 cleafix col-sm-12 col-xs-12">
	            <img src="<?php echo esc_url($img); ?>" class="pull-right" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
            </div><!-- /.col-md-4 -->

            <div class="col-md-8 col-sm-12 col-xs-12">
                <div class="our-approach-content">
                    <div class="title">
                        <h3><?php echo esc_attr($title); ?></h3>
                    </div><!-- /.title -->
                    <p><?php print wpautop(do_shortcode(wp_specialchars_decode($content))); ?></p>
                    <div class="feature-wrapper">
                        <div class="single-feature">
                            <div class="icon-box">
                                <img src="<?php echo esc_url($icon11); ?>" alt="<?php echo cakecious_fw_img_alt($icon1); ?>" />
                            </div><!-- /.icon-box -->
                            <div class="text-box">
                                <p><?php echo esc_attr($label1); ?> <br> <?php echo esc_attr($label11); ?></p>
                            </div><!-- /.text-box -->
                        </div><!-- /.single-feature -->
                        <div class="single-feature">
                            <div class="icon-box">
                                <img src="<?php echo esc_url($icon22); ?>" alt="<?php echo cakecious_fw_img_alt($icon2); ?>" />
                            </div><!-- /.icon-box -->
                            <div class="text-box">
                                <p><?php echo esc_attr($label2); ?> <br> <?php echo esc_attr($label22); ?></p>
                            </div><!-- /.text-box -->
                        </div><!-- /.single-feature -->
                        <div class="single-feature">
                            <div class="icon-box">
                                <img src="<?php echo esc_url($icon33); ?>" alt="<?php echo cakecious_fw_img_alt($icon3); ?>" />
                            </div><!-- /.icon-box -->
                            <div class="text-box">
                                <p><?php echo esc_attr($label3); ?> <br> <?php echo esc_attr($label133); ?></p>
                            </div><!-- /.text-box -->
                        </div><!-- /.single-feature -->
                    </div><!-- /.feature-wrapper -->
                </div><!-- /.our-approach-content -->
            </div><!-- /.col-md-8 -->
        </div><!-- /.row -->
    </div><!-- /.thm-container -->
</section>