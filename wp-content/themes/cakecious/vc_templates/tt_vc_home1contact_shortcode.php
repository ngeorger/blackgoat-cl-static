<?php


$list_type = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$img = (is_numeric($image) && !empty($image)) ? wp_get_attachment_url($image) : '';

?>
<?php if( 'type2' == $type ) { ?>
<section class="contact_area contact_area_2">
    <div class="left_contact">
        <div class="contact_from_area">
	        <?php echo do_shortcode(wp_kses_post($cf7code)); ?>
        </div>
    </div>
    <div class="right_contact">
        <div class="request_area">
           <div class="request">
                <img src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
                <div class="request_content">
                    <h2><?php echo wp_kses( $title, cakecious_tt_allowed_tags() ); ?></h2>
                </div>
           </div>
        </div>
    </div>
</section>
<?php } else { ?>
<section class="contact_area">
    <div class="left_contact">
        <div class="contact_from_area">
            <?php echo do_shortcode(wp_kses_post($cf7code)); ?>
        </div>
    </div>
    <div class="right_contact">
        <div class="request_area">
           <div class="request">
                <img src="<?php echo esc_url($img); ?>" alt="<?php echo cakecious_fw_img_alt($image); ?>" />
                <div class="request_content">
                    <h2><?php echo wp_kses( $title, cakecious_tt_allowed_tags() ); ?></h2>
                    <p><?php echo esc_html( $description ); ?></p>
                </div>
           </div>
        </div>
    </div>
</section>
<?php }  ?>