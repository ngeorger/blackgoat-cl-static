<?php
if ( ! defined( 'ABSPATH' ) ) exit;

 /*
  *  template file
  * @templatation.com
  */

$settings = array(
                'connect_rss' => '',
                'connect_twitter' => '',
                'connect_facebook' => '',
                'connect_youtube' => '',
                'connect_flickr' => '',
                'connect_linkedin' => '',
                'connect_pinterest' => '',
                'connect_instagram' => '',
                'connect_googleplus' => '',
                'connect_custom_link' => '',
                'connect_custom_icon' => '',
                'connect_custom_name' => '',
                'connect_custom_link2' => '',
                'connect_custom_icon2' => '',
                'connect_custom_name2' => '',
				'open_social_newtab' => false,
				'feed_url' => false,
                );
$settings = cakecious_fw_opt_values( $settings );
$newtabopen = ''; if($settings['open_social_newtab' ]) $newtabopen = ' target="_blank" ';


?>

<ul class="h_social list_style">

                <?php if ( $settings['connect_twitter' ] != "" ) { ?>
		   		<li><a <?php echo wp_kses_post($newtabopen); ?>  href="<?php echo esc_url( $settings['connect_twitter'] ); ?>" class="twitter" title="<?php esc_attr_e('Twitter', 'cakecious');?>"><i class="fa fa-twitter"></i></a></li>

		   		<?php } if ( $settings['connect_facebook' ] != "" ) { ?>
		   		<li><a <?php echo wp_kses_post($newtabopen); ?>  href="<?php echo esc_url( $settings['connect_facebook'] ); ?>" class="facebook" title="<?php esc_attr_e('Facebook', 'cakecious');?>"><i class="fa fa-facebook"></i></a></li>

		   		<?php } if ( $settings['connect_youtube' ] != "" ) { ?>
		   		<li><a <?php echo wp_kses_post($newtabopen); ?>  href="<?php echo esc_url( $settings['connect_youtube'] ); ?>" class="youtube" title="<?php esc_attr_e('YouTube', 'cakecious');?>"><i class="fa fa-youtube"></i></a></li>

		   		<?php } if ( $settings['connect_flickr' ] != "" ) { ?>
		   		<li><a <?php echo wp_kses_post($newtabopen); ?>  href="<?php echo esc_url( $settings['connect_flickr'] ); ?>" class="flickr" title="<?php esc_attr_e('Flickr', 'cakecious');?>"><i class="fa fa-flickr"></i></a></li>

		   		<?php } if ( $settings['connect_linkedin' ] != "" ) { ?>
		   		<li><a <?php echo wp_kses_post($newtabopen); ?>  href="<?php echo esc_url( $settings['connect_linkedin'] ); ?>" class="linkedin" title="<?php esc_attr_e('LinkedIn', 'cakecious');?>"><i class="fa fa-linkedin"></i></a></li>

		   		<?php } if ( $settings['connect_pinterest' ] != "" ) { ?>
		   		<li><a <?php echo wp_kses_post($newtabopen); ?>  href="<?php echo esc_url( $settings['connect_pinterest'] ); ?>" class="pinterest" title="<?php esc_attr_e('Pinterest', 'cakecious');?>"><i class="fa fa-pinterest"></i></a></li>

		   		<?php } if ( $settings['connect_instagram' ] != "" ) { ?>
		   		<li><a <?php echo wp_kses_post($newtabopen); ?>  href="<?php echo esc_url( $settings['connect_instagram'] ); ?>" class="instagram" title="<?php esc_attr_e('Instagram', 'cakecious');?>"><i class="fa fa-instagram"></i></a></li>

		   		<?php } if ( $settings['connect_googleplus' ] != "" ) { ?>
		   		<li><a <?php echo wp_kses_post($newtabopen); ?>  href="<?php echo esc_url( $settings['connect_googleplus'] ); ?>" class="googleplus" title="<?php esc_attr_e('Google+', 'cakecious');?>"><i class="fa fa-google-plus"></i></a></li>

		   		<?php } if ( $settings['connect_custom_link' ] != "" ) { ?>
		   		<li><a <?php echo wp_kses_post($newtabopen); ?>  href="<?php echo esc_url( $settings['connect_custom_link'] ); ?>" class="googleplus" title="<?php echo esc_attr( $settings['connect_custom_name'] ); ?>"><i class="fa <?php echo esc_attr( $settings['connect_custom_icon'] ); ?>"></i></a></li>

		   		<?php } if ( $settings['connect_custom_link2' ] != "" ) { ?>
		   		<li><a <?php echo wp_kses_post($newtabopen); ?>  href="<?php echo esc_url( $settings['connect_custom_link2'] ); ?>" class="googleplus" title="<?php echo esc_attr( $settings['connect_custom_name2'] ); ?>"><i class="fa <?php echo esc_attr( $settings['connect_custom_icon2'] ); ?>"></i></a></li>

				<?php } if ( $settings['connect_rss' ] == "1" ) { ?>
		   		<li><a <?php echo wp_kses_post($newtabopen); ?>  href="<?php if ( $settings['feed_url'] ) { echo esc_url( $settings['feed_url'] ); } else { echo get_bloginfo_rss('rss2_url'); } ?>" class="subscribe" title="<?php esc_attr_e('RSS', 'cakecious');?>"><i class="fa fa-rss"></i></a></li>
		   		<?php } ?>
</ul>
