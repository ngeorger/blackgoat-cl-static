<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------
 *
 * This file contains required functions for the theme.
 * @templatation.com
 *
-----------------------------------------------------------------------------------*/

add_action( 'wp_head', 'cakecious_tt_wp_head', 9 );
if ( ! function_exists( 'cakecious_tt_wp_head' ) ) {
/**
 * Output the default ttFramework "head" markup in the "head" section.
 * @since  2.0.0
 * @return void
 */
function cakecious_tt_wp_head() {
	do_action( 'cakecious_tt_wp_head_before' );

	// Output custom favicon icons
	if ( function_exists( 'cakecious_tt_custom_favicon' ) && ! function_exists( 'wp_site_icon' ) )
		cakecious_tt_custom_favicon();

	do_action( 'cakecious_tt_wp_head_after' );
} // End cakecious_tt_wp_head()
}

/*-----------------------------------------------------------------------------------*/
/* tt_get_dynamic_value() */
/* Replace values in a provided array with theme options, if available. */
/*
/* $settings array should resemble: $settings = array( 'theme_option_without_tt' => 'default_value' );
/*
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'cakecious_fw_opt_values' )) {
	function cakecious_fw_opt_values( $settings ) {
		global $tt_temptt_opt;

		if ( is_array( $tt_temptt_opt ) ) {
			foreach ( $settings as $k => $v ) {

				if ( is_array( $v ) ) {
					foreach ( $v as $k1 => $v1 ) {
						if ( isset( $tt_temptt_opt[ 'tt_' . $k ][ $k1 ] ) && ( $tt_temptt_opt[ 'tt_' . $k ][ $k1 ] != '' ) ) {
							$settings[ $k ][ $k1 ] = $tt_temptt_opt[ 'tt_' . $k ][ $k1 ];
						}
					}
				} else {
					if ( isset( $tt_temptt_opt[ 'tt_' . $k ] ) && ( $tt_temptt_opt[ 'tt_' . $k ] != '' ) ) {
						$settings[ $k ] = $tt_temptt_opt[ 'tt_' . $k ];
					}
				}
			}
		}

		return $settings;
	} // End cakecious_fw_opt_values()
}


/*-----------------------------------------------------------------------------------*/
/* cakecious_fw_get_option() */
/* Replace values in a provided variable with theme options, if available. */
/*
 * field id should be without tt_
 */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'cakecious_fw_get_option' ) ) {
	function cakecious_fw_get_option( $var, $default = false ) {
		global $tt_temptt_opt;

		if ( isset( $tt_temptt_opt[ 'tt_' . $var ] ) ) {
			$var = $tt_temptt_opt[ 'tt_' . $var ];
		} else {
			$var = $default;
		}

		return $var;
	} // End cakecious_fw_get_option()
}

/*-----------------------------------------------------------------------------------*/
/* Adds custom classes to the array of body classes.
/*-----------------------------------------------------------------------------------*/
/**
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function cakecious_body_classes( $classes ) {

	global $tt_temptt_opt, $wp_query;
	$current_page_template = $single_trans_hdr = $single_data2 = $tt_post_id = $single_enable_headline = $single_no_tpad = $single_no_bpad = '';

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( !is_404() && !is_search() ) {
		if ( ! empty( $wp_query->post->ID ) ) {
			$tt_post_id = $wp_query->post->ID;
		}
	}
	if(is_home()) $tt_post_id = get_option( 'page_for_posts' );

	$single_data2 = get_post_meta( $tt_post_id, '_tt_meta_page_opt', true );
	if( is_array($single_data2) ) {
		if ( isset( $single_data2['_single_enable_headline'] ) ) $single_enable_headline = $single_data2['_single_enable_headline'];
		if ( isset( $single_data2['_single_enable_bpadding'] ) ) $single_enable_bpadding = $single_data2['_single_enable_bpadding'];
		if ( isset( $single_data2['_single_enable_tpadding'] ) ) $single_enable_tpadding = $single_data2['_single_enable_tpadding'];
		if ( isset( $single_data2['_single_no_tpad'] ) ) $single_no_tpad = $single_data2['_single_no_tpad'];
		if ( isset( $single_data2['_single_no_bpad'] ) ) $single_no_bpad = $single_data2['_single_no_bpad'];
		if ( isset( $single_data2['_single_trans_hdr'] ) ) $single_trans_hdr = $single_data2['_single_trans_hdr'];
	}
	// setting defaults
	if ( !is_page() && (!isset($single_enable_headline) || empty($single_enable_headline)) ) $single_enable_headline = false;
	if ( !isset($single_enable_bpadding) ) $single_enable_bpadding = true;
	if ( !isset($single_enable_tpadding) ) $single_enable_tpadding = true;
	( $single_enable_headline ) ?  $classes[] = 'hdline_set' : $classes[] = 'no_hdline';
	if ( ! $single_enable_bpadding ) { $classes[] = 'no-bpadd'; }
	if( !defined('TT_FW_ROOT')) { $classes[] = 'no-ttfmrk'; }
	if ( $single_no_tpad == '1' ) { $classes[] = 'no-tpadd'; }
	if ( $single_no_bpad == '1' ) { $classes[] = 'no-bpadd'; }

	/* adding identifier in body tag for legacy version */
	$classes[] = 'ckc-legacy';
	if( cakecious_fw_get_option('enable_topbar', 1) ) { $classes[] = 'yes-topbar'; }
	$hdr_type = cakecious_get_hdr_type();
	$classes[] = 'hdr-'.$hdr_type;
	// Removes tag class from the body_class array to avoid Bootstrap markup styling issues.
    foreach ( $classes as $key => $value ) {
        if ( $value == 'tag' ) unset( $classes[ $key ] );
    }

	return $classes;
}
add_filter( 'body_class', 'cakecious_body_classes' );




/*-----------------------------------------------------------------------------------*/
/* Post/page title
/*-----------------------------------------------------------------------------------*/
// returns title based on the requirement.

if (!function_exists( 'cakecious_fw_post_title')) {
function cakecious_fw_post_title( $tag='' ){

	global $wp_query;
	$tt_post_id = $single_item_layout = $tt_lay_content = $tt_lay_sidebar = $single_data2 = '';
	if( empty($tag)) $tag = 'h3';

		if ( ! is_404() && ! is_search() ) {
			if ( ! empty( $wp_query->post->ID ) ) {
				$tt_post_id = $wp_query->post->ID;
			}
		}
		if ( ! empty( $tt_post_id ) ) {
			$single_data2 = get_post_meta( $tt_post_id, '_tt_meta_page_opt', true );
		}

		/* if its fresh install and tt framework is enabled. dont show title as it appears in hero */
		if ( !is_array( $single_data2 ) && defined('TT_FW_ROOT') ) {
				return '<div class="pt_100"></div>';
		}

		/* if hero area is enabled(or if its not set), we do not need title display */
		if ( is_array( $single_data2 ) ) {
			if ( $single_data2['_single_enable_headline'] && is_page() ) {
				return '';
			}
		}

		if ( is_array( $single_data2 ) ) {
			if ( $single_data2['_hide_title_display'] ) {
				return '';
			}
		}
	return the_title( '<header class="entry-header"><'.$tag.' class="entry-title2 ">', '</'.$tag.'></header>' );
}
}

/*-----------------------------------------------------------------------------------*/
/* Header Type
/*-----------------------------------------------------------------------------------*/

if (!function_exists( 'cakecious_get_hdr_type')) {
	function cakecious_get_hdr_type() {

		$single_data2 = $tt_post_id = $hdr_type = $single_hdr_type = '';
		// grab value from themeoptions
		$hdr_type = cakecious_fw_get_option( 'header_layout', 'default' );
		// override if set on particular page.
		$tt_post_id = cakecious_get_the_id();
		if ( isset( $tt_post_id ) ) {
			$single_data2 = get_post_meta( $tt_post_id, '_tt_meta_page_opt', true );
		}
		if ( is_array( $single_data2 ) ) {
			if ( isset( $single_data2['_single_hdr_type'] ) ) {
				$single_hdr_type = $single_data2['_single_hdr_type'];
			}
		}
		if ( $single_hdr_type == 'default' || $single_hdr_type == 'header2' || $single_hdr_type == 'header3' || $single_hdr_type == 'header4' || $single_hdr_type == 'header5' ) {
			$hdr_type = $single_hdr_type;
		}

		return $hdr_type;
	}
}

/*-----------------------------------------------------------------------------------*/
/* Load custom logo. */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'cakecious_fw_logo' ) ) {
function cakecious_fw_logo ( $type='' ) {
	global $tt_temptt_opt, $wp_query;
	$tt_post_id = $single_data2 = $width = $height = $style = $logo = $single_logo_setting = '';
	if ( !is_404() && !is_search() ) {
		if ( ! empty( $wp_query->post->ID ) ) {
			$tt_post_id = $wp_query->post->ID;
		}
	}

	$settingsl = array(
					'retina_favicon' => '0',
					'retina_favicon2' => '0',
					'logo' => '',
					'logo2' => '',
					'retina_logo_wh' => '',
					'retina_logo_wh2' => '',
				);
	$settingsl = cakecious_fw_opt_values( $settingsl );

	$logo = esc_url( CAKECIOUS_THEME_DIRURI . 'assets/img/logo.png' ); // default logo from theme image folder.
	$logo2 = esc_url( CAKECIOUS_THEME_DIRURI . 'assets/img/logo-2.png' ); // default logo from theme image folder.
	if ( !empty( $settingsl['logo']['url'] ) ) { $logo = $settingsl['logo']['url'] ; }
	if ( !empty( $settingsl['logo2']['url'] ) ) { $logo2 = $settingsl['logo2']['url'] ; }
	if ( is_ssl() ) { $logo = str_replace( 'http://', 'https://', $logo ); }
	ob_start();
?>

	<a class="logo navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>">
	 <?php if ( '0' == $settingsl['retina_favicon'] ) { ?>
		<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
		<img src="<?php echo esc_url( $logo2 ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
	 <?php } else {
		 if( $settingsl['retina_logo_wh']['width'] != '0' ) {
			 if ( ! empty( $settingsl['retina_logo_wh']['width'] ) ) {
				 if ( strpos( $settingsl['retina_logo_wh']['width'], 'px' ) !== false ) {
					 $width = 'width:' . $settingsl['retina_logo_wh']['width'] . ';';
				 } else {
					 $width = 'width:' . $settingsl['retina_logo_wh']['width'] . 'px;';
				 }
			 }
		 }
		if ($settingsl['retina_logo_wh']['height'] != '0') {
			if ( ! empty( $settingsl['retina_logo_wh']['height'] ) ) {
				if ( strpos( $settingsl['retina_logo_wh']['height'], 'px' ) !== false ) {
					$height = 'height:' . $settingsl['retina_logo_wh']['height'] . ';';
				} else {
					$height = 'height:' . $settingsl['retina_logo_wh']['height'] . 'px;';
				}
			}
		}
		?>
		<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
		<img src="<?php echo esc_url( $logo2 ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
	 <?php } ?>
	</a>
<?php
	return ob_get_clean();
} // End cakecious_fw_logo()
}

/*-----------------------------------------------------------------------------------*/
/* Fetch ALT tags for images
/*-----------------------------------------------------------------------------------*/
// returns title based on the requirement.

if (!function_exists( 'cakecious_fw_img_alt')) {
function cakecious_fw_img_alt( $imgid = '', $postid = '' ){
$alt = '';
if( '' == $imgid && '' != $postid ) // if only post id is given, fetch imgid from it.
$imgid = get_post_thumbnail_id( $postid );

if($imgid) $alt = get_post_meta( $imgid, '_wp_attachment_image_alt', true);

return htmlspecialchars($alt);

}
}

/*-----------------------------------------------------------------------------------*/
/* Topnav function */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'cakecious_topnav_content' ) ) {
function cakecious_topnav_content ($class='') {

	if ( cakecious_fw_get_option( 'enable_topbar', 0 ) == '0' ) return; // do nothing if top nav bar is disabled in themeoptions.

	$spl_topbar = cakecious_fw_get_option( 'spl_topbar', '1');
	if( $spl_topbar ) {
		$hdr_type = cakecious_get_hdr_type();

		if ( $hdr_type == 'default' || $hdr_type == 'header1' || $hdr_type == 'header2' || $hdr_type == 'header5' ) {
			ob_start(); ?>
			<div class="top_header_area row m0">
				<div class="container">
					<div class="float-left">
						<?php if ( '' != cakecious_fw_get_option( 'contact_number' ) ) { ?>
							<a href="tel:<?php echo preg_replace( '/(\W*)/', '', cakecious_fw_get_option( 'contact_number' ) ); ?>"><i
									class="fa fa-phone"
									aria-hidden="true"></i><?php echo esc_attr( cakecious_fw_get_option( 'contact_number' ) ); ?>
							</a>
						<?php } ?>
						<?php if ( '' != cakecious_fw_get_option( 'contactform_email' ) ) { ?>
							<a href="mailto:<?php echo sanitize_email( cakecious_fw_get_option( 'contactform_email' ) ); ?>"><i
									class="fa fa-envelope-o"
									aria-hidden="true"></i><?php echo sanitize_email( cakecious_fw_get_option( 'contactform_email' ) ); ?>
							</a>
						<?php } ?>
					</div>
					<div class="float-right">
						<?php get_template_part( 'templates/tt-social' ); ?>
						<ul class="h_search list_style">
							<?php if ( class_exists( 'woocommerce' ) && cakecious_fw_get_option( 'enable_hdr_cart', '1' ) ) {
								echo '<li class="shop_cart">'; cakecious_cart_icon(); echo '</li>'; ?>
							<?php } ?>
							<?php if ( cakecious_fw_get_option( 'enable_hdr_search', '1' ) ) { ?>
								<li><a class="popup-with-zoom-anim" href="#test-search"><i class="fa fa-search"></i></a>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>

			<?php $output = ob_get_clean();

			return $output;
		}
	}
	if($class == '') $class = ' top_header_area row m0 ';
	// Fetch left side content
	$top_nav_left_layout = cakecious_fw_get_option('top_nav_left_layout', '');
	$nav_left_layout = $top_nav_left_layout['enabled'];

	// Fetch right side content
	$top_nav_right_layout = cakecious_fw_get_option('top_nav_right_layout', '');
	$nav_right_layout = $top_nav_right_layout['enabled'];

	$hdr_type = cakecious_get_hdr_type();
	if( $hdr_type == 'header3' || $hdr_type == 'header4' || $hdr_type == 'header5' ) $tt_contain = 'container'; else $tt_contain = 'container-fluid';
$output = '
	<div class="hdr_top_bar ' .$class. '">
		<div class="'. $tt_contain .' clearfix">
		<div class="container">';

$output .= '
	<!-- Start left side content -->
	<div class="left-content pull-left">';
	$output .= '<div class="float-left">';
	$output .= cakecious_topnav_content_render( $nav_left_layout );
	$output .= '</div>';
	$output .= '</div><!-- .left-content -->';

$output .= '
	<!-- Start right side content -->
	<div class="right-content pull-right">';
	$output .= '<div class="float-right">';
	$output .= cakecious_topnav_content_render( $nav_right_layout );
	$output .= '</div>';
	$output .=
	'</div><!-- .right-content -->';

$output .= '
	</div>
	</div>
</div>';

	return  $output;
} // End cakecious_topnav_content()
}



/*-----------------------------------------------------------------------------------*/
/* Topnav render function */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'cakecious_topnav_content_render' ) ) {
function cakecious_topnav_content_render ( $nav_layout = null ) {
	$output =  "";
	$topsettings = array(
					'enable_topbar'         => '1',
					'ttext_icon'            => '',
					'ttext_text'            => '',
					'contact_number'        => '',
					'contactform_email'     => '',
					'top_nav_menu'          => '',
					'top_nav_email_icon'    => '1',
					'top_nav_phone_icon'    => '1',
					);

	$topsettings = cakecious_fw_opt_values( $topsettings );

ob_start();

// available content blocks.
// email, text_icon, text, phone_icon, phone, wpml_lang, search, social

if ($nav_layout): foreach ($nav_layout as $key=>$value) {

    switch($key) {

        case 'email':

			if ( !empty( $topsettings['contactform_email'] )) { ?>
			<span>
				<a href="mailto:<?php echo sanitize_email($topsettings['contactform_email']); ?>"><i class="fa fa-envelope-o" aria-hidden="true"></i><?php echo sanitize_email($topsettings['contactform_email']); ?></a>
			</span>
			<?php }


        break;

        case 'teaser_text':

			if ( $topsettings['ttext_text'] != '' ) { echo '<span class="tt-top-teaser">'. stripslashes( esc_attr( $topsettings['ttext_text'] )) .'</span>';  }

        break;

        case 'phone':

			if ( !empty( $topsettings['contact_number'] )) { ?>
			<span class="topphone">
				<a href="tel:<?php echo preg_replace('/(\W*)/', '', $topsettings['contact_number']); ?>"><i class="fa fa-phone" aria-hidden="true"></i><?php echo esc_attr($topsettings['contact_number']); ?></a>
			</span>
			<?php }

        break;

        case 'spacer':

		            ?>
	                <div class="topnav-spacer"></div>
	        <?php

        break;

        case 'spacer2':

		            ?>
	                <div class="topnav-spacer"></div>
	        <?php

        break;

        case 'wpml_lang':

						do_action('wpml_add_language_selector');

        break;

        case 'custommenu':

		            if ( !empty( $topsettings['top_nav_menu'] ) ) {
		                wp_nav_menu( array( 'depth'          => 1,
		                                    'sort_column'    => 'menu_order',
		                                    'container'      => 'ul',
		                                    'menu_class'     => 'top-nav sup-nav',
		                                    'menu'        => $topsettings['top_nav_menu'],
		                ) );
		            }

        break;

        case 'social':
					?>
					<div class="social-icons">
						<?php get_template_part( 'templates/tt-social' ); ?>
					</div>
					<?php
        break;

    }

}

endif;

	$output = ob_get_clean();
	return $output;

} //cakecious_topnav_content_render
}

/*-----------------------------------------------------------------------------------*/
/* return excerpt with given charlent.                                               */
/*-----------------------------------------------------------------------------------*/
// source https://codex.wordpress.org/Function_Reference/get_the_excerpt
if (!function_exists( 'cakecious_tt_excerpt_charlength')) {
	function cakecious_tt_excerpt_charlength( $charlength ) {
		$excerpt = get_the_excerpt();
		$charlength ++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex   = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut   = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				echo mb_substr( $subex, 0, $excut );
			} else {
				echo esc_attr($subex);
			}
			echo '...';
		} else {
			echo esc_attr($excerpt);
		}
	}
}

/*-----------------------------------------------------------------------------------*/
/* Misc small functions for visuals.                                                 */
/*-----------------------------------------------------------------------------------*/
// Adding span tag in category widgets for styling purpose
add_filter('wp_list_categories', 'cakecious_tt_cat_count');
function cakecious_tt_cat_count($links) {
  $links = str_replace('</a> (', ' <span>(', $links);
  $links = str_replace(')', ')</span></a>', $links);
  return $links;
}


// adding filter to add class in previous/next post button.
add_filter('next_post_link', 'cakecious_tt_post_link_attr');
add_filter('previous_post_link', 'cakecious_tt_post_link_attr');
function cakecious_tt_post_link_attr($output) {
    $injection = 'class="button"';
    return str_replace('<a href=', '<a '.$injection.' href=', $output);
}


/*-----------------------------------------------------------------------------------*/
/* Getting the ID of the page                                                     */
/*-----------------------------------------------------------------------------------*/

if( !function_exists('cakecious_get_the_id') ) {
	function cakecious_get_the_id() {
		global $wp_query;
		$tt_post_id = '';
		if ( is_404() || is_search() ) {
			return '';
		}
		if ( isset( $wp_query->post->ID ) ) {
			$tt_post_id = $wp_query->post->ID;
		}
		if ( is_home() ) {
			$tt_post_id = get_option( 'page_for_posts' );
		}
		if ( class_exists( 'woocommerce' ) ) {
			if ( is_shop() ) {
				$tt_post_id = get_option( 'woocommerce_shop_page_id' );
			}
			if ( is_account_page() ) {
				$tt_post_id = get_option( 'woocommerce_myaccount_page_id' );
			}
			if ( is_checkout() ) {
				$tt_post_id = get_option( 'woocommerce_checkout_page_id' );
			}
			if ( is_cart() ) {
				$tt_post_id = get_option( 'woocommerce_cart_page_id' );
			}
		}

		return $tt_post_id;

	}
}

/*-----------------------------------------------------------------------------------*/
/* Footer classes. */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'footer_newsltr_class' ) ) {
function footer_newsltr_class () {
	$single_data2 = $ftr_newsltr_clr = $single_ftr_newsltr_clr = $newsltr_clr = '';
	$class = '';

	// grab value from themeoptions
	$ftr_newsltr_clr = cakecious_fw_get_option( 'footer_enable_clr', '0' );

	if( ! $ftr_newsltr_clr ) $class = 'gray_bg';

	$tt_post_id = cakecious_get_the_id();

	if( isset($tt_post_id) ) $single_data2 = get_post_meta( $tt_post_id, '_tt_meta_page_opt', true );
	if( is_array($single_data2) ) {
		if ( isset( $single_data2['_single_ft_newsletter'] ) ) $single_ftr_newsltr_clr = $single_data2['_single_ft_newsletter'];
	}

	if( $single_ftr_newsltr_clr == 'colored' || $single_ftr_newsltr_clr == 'gray_bg' || $single_ftr_newsltr_clr == 'none' ) $newsltr_clr = $single_ftr_newsltr_clr;
	if( $newsltr_clr == 'gray_bg' ) $class = 'gray_bg'; elseif($newsltr_clr == 'colored' ) $class = '';  elseif($newsltr_clr == 'none' ) $class = 'none'; else {}

	return $class;

} // End footer_newsltr_class()
}

/*-----------------------------------------------------------------------------------*/
/* Header classes. */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'cakecious_fw_hdr_class' ) ) {
function cakecious_fw_hdr_class () {
	global $wp_query; $tt_post_id = $single_data2 = $hdr_type ='';
	$class = 'no-Olap inner-header';
	$single_hdr_type = '';

	// grab value from themeoptions
	$hdr_type = cakecious_fw_get_option( 'header_layout', 'default' );

	// grab values from page meta
	if ( !is_404() && !is_search() ) {
		if ( ! empty( $wp_query->post->ID ) ) {
			$tt_post_id = $wp_query->post->ID;
		}
	}
	if( isset($tt_post_id) ) $single_data2 = get_post_meta( $tt_post_id, '_tt_meta_page_opt', true );
	if( is_array($single_data2) ) {
		if ( isset( $single_data2['_single_hdr_type'] ) ) $single_hdr_type = $single_data2['_single_hdr_type'];
	}

	if( $single_hdr_type == 'default' || $single_hdr_type == 'naked' ) $hdr_type = $single_hdr_type;


	if ( ($hdr_type === 'naked') && is_page() ) $class = ' absolute '; // overlapping only on pages.

	return $class;

} // End cakecious_fw_hdr_class()
}

/*-----------------------------------------------------------------------------------*/
/* Truncate */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'cakecious_tt_truncate' ) ) {
	function cakecious_tt_truncate($text, $limit, $sep='...') {
		if (str_word_count($text, 0) > $limit) {
			$words = str_word_count($text, 2);
			$pos = array_keys($words);
			$text = strip_tags( $text );
			$text = substr($text, 0, $pos[$limit]) . $sep;
		}
		return $text;
	}
}


/*-----------------------------------------------------------------------------------*/
/* Fixing the font size for the tag cloud widget.                                    */
/*-----------------------------------------------------------------------------------*/
add_filter( 'widget_tag_cloud_args', 'cakecious_tt_tag_cloud_args' );
if (!function_exists( 'cakecious_tt_tag_cloud_args')) {
	function cakecious_tt_tag_cloud_args($args) {
	$args['number'] = 10; //adding a 0 will display all tags
	$args['largest'] = 15; //largest tag
	$args['smallest'] = 15; //smallest tag
	$args['unit'] = 'px'; //tag font unit
	$args['format'] = 'list'; //ul with a class of wp-tag-cloud
	return $args;
	}
}

/*-----------------------------------------------------------------------------------*/
/* cakecious_tt_prev_post function */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'cakecious_tt_prev_post' ) ) {
	function cakecious_tt_prev_post() {
		$output    = '';
		$prev_post = get_adjacent_post( true, '', true );
		if ( is_a( $prev_post, 'WP_Post' ) ) {
			$output = '<div class="fl button3"><a class="tt_prev_post tt-button" title="'. get_the_title( $prev_post->ID ) .'" href="' . get_permalink( $prev_post->ID ) . '"><i class="fa fa-long-arrow-left"></i>' . esc_html__( 'Previous', 'cakecious' ) . '</a></div>';
		}

		return $output;
	} // End cakecious_tt_prev_post()
}
/*-----------------------------------------------------------------------------------*/
/* cakecious_tt_next_post function */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'cakecious_tt_next_post' ) ) {
	function cakecious_tt_next_post() {
		$output    = '';
		$prev_post = get_adjacent_post( true, '', false );
		if ( is_a( $prev_post, 'WP_Post' ) ) {
			$output = '<div class="fr button3"><a class="tt_next_post tt-button" title="'. get_the_title( $prev_post->ID ) .'" href="' . get_permalink( $prev_post->ID ) . '">' . esc_html__( 'Next', 'cakecious' ) . '<i class="fa fa-long-arrow-right"></i></a></div>';
		}

		return $output;
	} // End cakecious_tt_next_post()
}

/*-----------------------------------------------------------------------------------*/
/* cakecious_tt_post_title function */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'cakecious_tt_post_title' ) ) {
function cakecious_tt_post_title ( ) {

	$hide_title_display = $tt_page_title = $titlesettings = ''; $id = get_the_ID();
	$hide_title_display = get_post_meta( $id, '_tt_meta_page_opt', true );
	if( isset($hide_title_display['_hide_title_display'])) $titlesettings = $hide_title_display['_hide_title_display'];

	ob_start(); ?>
		<header class="post-header lc_tt_title">
			<ul>
				<li><?php the_time( 'M j, Y' ); ?></li>
				<li><?php if(!comments_open($id)) echo 'Comments Off'; else comments_popup_link( esc_html__( 'Zero comments', 'cakecious' ), esc_html__( '1 Comment', 'cakecious' ), esc_html__( '% Comments', 'cakecious' ) ); ?></li>
			</ul>
			<h1><?php if( strlen( get_the_title()) > 1 ) { ?> <a href="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'Continue Reading &rarr;', 'cakecious' ); ?>"><?php the_title(); ?></a> <?php } ?></h1>
		</header>
		<?php

	$tt_post_title = ob_get_clean();
	if( is_singular() ){
		if( empty($titlesettings) || $titlesettings == '0' ) {
			echo esc_attr($tt_post_title);
		} // display title if not being hidden in single post.
	}
	else { echo esc_attr($tt_post_title); }
	} // End cakecious_tt_post_title()
}

/*-----------------------------------------------------------------------------------*/
/* cakecious_tt_page_title function */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'cakecious_tt_page_title' ) ) {
function cakecious_tt_page_title ( ) {

	$hide_title_display = $tt_page_title = $titlesettings = '';
	$hide_title_display = get_post_meta( get_the_ID(), '_tt_meta_page_opt', true );
	if( isset($hide_title_display['_hide_title_display'])) $titlesettings = $hide_title_display['_hide_title_display'];

	ob_start();
	if ( empty($titlesettings) || $titlesettings == '0' ) { ?>
		<header class="post-header">
			<h1><?php if( strlen( get_the_title()) > 1 ) the_title(); ?></h1>
		</header>
		<?php
	} // display title if not being hidden in single page/post.

	$tt_page_title = ob_get_clean();
	echo esc_attr($tt_page_title);

	} // End cakecious_tt_page_title()
}



/*-----------------------------------------------------------------------------------*/
/* Function to retrieve tags. */
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'cakecious_tt_get_tags' )) {
	function cakecious_tt_get_tags(){
		$tags = get_the_tags();
		$tags_count = 0;
	    $html = '<p class=tagtitle>'. esc_html__('tags ', 'cakecious') .'&nbsp;</p>';
		if( !is_array($tags) ) return;
	    foreach ($tags as $tag){
		    $tags_count ++;
	        $tag_link = get_tag_link($tag->term_id);
						if ( $tags_count > 1 ) {
							$html .= ' '; // tag separator here
						}

	        $html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='tag {$tag->slug}'>";
	        $html .= "{$tag->name}</a>";
	    }
	    echo '<div class="detail-tags">'. $html .'</div>';
	}
}

/*-----------------------------------------------------------------------------------*/
/* Function to retrieve categories. */
/*-----------------------------------------------------------------------------------*/
/*
 * it can either return single category or all categories separated by comma.
 * by default it returns all category separated by comma but if single category is required, just pass 'single' into the fn.
 *
 */
if (!function_exists('cakecious_tt_get_cats')) {
	function cakecious_tt_get_cats( $return='' ) {
		global $post, $wp_query;
		$output = '';
		$post_type_taxonomies = get_object_taxonomies( get_post_type(), 'objects' );
		foreach ( $post_type_taxonomies as $taxonomy ) {
			if ( $taxonomy->hierarchical == true ) {

				$cats       = get_the_terms( get_the_ID(), $taxonomy->name );
				$cats_count = 0;
				if ( $cats ) {
					foreach ( $cats as $cat ) {
						$cats_count ++;
						if ( $cats_count > 1 && $return == 'single' ) {
							break;
						}
						if ( $cats_count > 1 ) {
							$output .= ', ';
						}
						$output .= '<li><a class="tt_cats" href="' . get_term_link( $cat, $taxonomy->name ) . '">' . $cat->name . '</a></li>';
					}
				}
			}
		}
		return $output;
	}
}


/*-----------------------------------------------------------------------------------*/
/* Preloader. */
/*-----------------------------------------------------------------------------------*/
if ( ! function_exists( 'cakecious_tt_preloader' ) ) {
function cakecious_tt_preloader () {

	if ( cakecious_fw_get_option( 'enable_preloader', '0' ) == '1') {
		return '
		<div id="loader-wrapper">
		 <div class="tt-loading-center">
		  <div class="tt-loading-center-absolute">
		   <div class="tt-object object_four"></div>
		   <div class="tt-object object_three"></div>
		   <div class="tt-object object_two"></div>
		   <div class="tt-object object_one"></div>
		  </div>
		 </div>
		</div>
		';
	}

} // End cakecious_tt_preloader()
}

/*-----------------------------------------------------------------------------------*/
/* Adding hero images for pages                                                      */
/*-----------------------------------------------------------------------------------*/

if( !function_exists('cakecious_tt_hero_section') ) {
	function cakecious_tt_hero_section() {
	global $tt_temptt_opt, $wp_query;
	$tt_post_id = $single_enable_headline = $single_headline_title = $single_text_align = $single_page_color = $single_page_img = $single_text_apprnce = $single_hero_breadcrumbs = $hide_title_display = $single_display_breadcrumbs = $single_headline_desc = '';
	if ( is_404() || is_search() ) return;
	if( isset($wp_query->post->ID)) $tt_post_id = $wp_query->post->ID;
	if(is_home()) $tt_post_id = get_option( 'page_for_posts' );
	if ( !(shortcode_exists('tt_hero_shortcode')  || shortcode_exists('templatation_hero')) ) return; // nothing left to do!
	if ( class_exists( 'woocommerce' ) ) {
		if ( is_shop() ) {
			$tt_post_id = get_option( 'woocommerce_shop_page_id' );
		}
		if ( is_account_page() ) {
			$tt_post_id = get_option( 'woocommerce_myaccount_page_id' );
		}
		if ( is_checkout() ) {
			$tt_post_id = get_option( 'woocommerce_checkout_page_id' );
		}
		if ( is_cart() ) {
			$tt_post_id = get_option( 'woocommerce_cart_page_id' );
		}
	}
	if( empty($tt_post_id) ) return; // nothing left to do!
	// fetching value from single posts .
	$single_enable_headline = '1';
	$single_data2 = get_post_meta( $tt_post_id, '_tt_meta_page_opt', true );
	if( is_array($single_data2) ) {
		if ( isset( $single_data2['_single_enable_headline'] ) ) $single_enable_headline = $single_data2['_single_enable_headline'];
		if ( isset( $single_data2['_single_headline_title'] ) ) $single_headline_title = esc_textarea($single_data2['_single_headline_title']);
		if ( isset( $single_data2['_single_headline_desc'] ) ) $single_headline_desc = esc_textarea($single_data2['_single_headline_desc']);
		if ( isset( $single_data2['_single_text_align'] ) ) $single_text_align = esc_attr($single_data2['_single_text_align']);
		if ( isset( $single_data2['_single_page_img'] ) ) $single_page_img = esc_textarea($single_data2['_single_page_img']);
		if ( isset( $single_data2['_single_page_color'] ) ) $single_page_color = esc_attr($single_data2['_single_page_color']);
		if ( isset( $single_data2['_single_text_apprnce'] ) ) $single_text_apprnce = esc_attr($single_data2['_single_text_apprnce']);
		if ( isset( $single_data2['_single_hero_breadcrumbs'] ) ) $single_hero_breadcrumbs = esc_attr($single_data2['_single_hero_breadcrumbs']);
		if ( isset( $single_data2['_single_enable_notitle'] ) ) $single_enable_notitle = esc_attr($single_data2['_single_enable_notitle']);
	}

	if ( !$single_enable_headline ) return ; // user dont want it!

	// assign global hero bg if not put in meta.
	// grab the hero bg image
	$global_herobg = cakecious_fw_get_option('global_herobg');
	if( !is_array($global_herobg) ) $global_herobg['url'] = '' ;

	$single_page_img = $single_page_img ? $single_page_img : $global_herobg['url'];

	// if title is not entered , grab the default page title.
	if( '' == $single_headline_title ) $single_headline_title = get_the_title($tt_post_id);

	// if this is post, show Blog as title. we dont want double entry for title.
	if( is_singular('post') ) $single_headline_title = esc_html__( 'Blog', 'cakecious' );

	// user wants hero section without title.
	if( $single_enable_notitle ) $single_headline_title = '';

	// user wants hero section disable globally.
	$disable_hero_global = cakecious_fw_get_option('disable_hero_global', '0');
	if( $disable_hero_global ) $single_headline_title = '';

	echo do_shortcode('[templatation_hero
	heading="'. $single_headline_title .'"
	image="'. $single_page_img .'"
	color="'. $single_page_color .'"
	content="'. $single_headline_desc .'"
	text_appear="'. $single_text_apprnce .'"
	yoast_bdcmp="'. $single_hero_breadcrumbs .'"
	block_padding_top="-1"
	block_padding_bottom="-1"
	]') ; // all variables in html block are already escaped. we can output directly.
		// Note that setting -1 for block padding top and bottom disables it.
	}
}
add_action( 'tt_before_mainblock', 'cakecious_hero_section_trigger', 1 );

if( !function_exists('cakecious_hero_section_trigger')) {
	function cakecious_hero_section_trigger( ) {

		if ( is_archive() || !(shortcode_exists('tt_hero_shortcode')  || shortcode_exists('templatation_hero')) ) {
			add_action( 'tt_before_mainblock', 'cakecious_hero_bg', 2 );
		}
		else {
			add_action( 'tt_before_mainblock', 'cakecious_tt_hero_section', 2 );
		}

	}
}



// source: https://pippinsplugins.com/retrieve-attachment-id-from-image-url/
if( !function_exists('cakecious_fw_get_image_id')) {
	function cakecious_fw_get_image_id( $image_url ) {
		global $wpdb;
		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );
		if( is_array($attachment) && isset($attachment[0]) )
		return $attachment[0];
		else return $image_url;
	}
}

if( !function_exists('cakecious_hero_bg')) {
	function cakecious_hero_bg() {
		$single_headline_title = $single_headline_title_cust = '';
		$tt_post_id = cakecious_get_the_id();
		if ( isset( $tt_post_id ) ) {
			$single_data2 = get_post_meta( $tt_post_id, '_tt_meta_page_opt', true );
		}
		if ( is_array( $single_data2 ) ) {
			if ( isset( $single_data2['_single_enable_notitle'] ) ) {
				if ( isset( $single_data2['_single_enable_headline'] ) ) $single_enable_headline = $single_data2['_single_enable_headline'];
				if ( isset( $single_data2['_single_headline_title'] ) ) $single_headline_title_cust = esc_textarea($single_data2['_single_headline_title']);
				if ( isset( $single_data2['_single_headline_desc'] ) ) $single_headline_desc = esc_textarea($single_data2['_single_headline_desc']);
				if ( isset( $single_data2['_single_text_align'] ) ) $single_text_align = esc_attr($single_data2['_single_text_align']);
				if ( isset( $single_data2['_single_page_img'] ) ) $single_page_img = esc_textarea($single_data2['_single_page_img']);
				if ( isset( $single_data2['_single_page_color'] ) ) $single_page_color = esc_attr($single_data2['_single_page_color']);
				if ( isset( $single_data2['_single_text_apprnce'] ) ) $single_text_apprnce = esc_attr($single_data2['_single_text_apprnce']);
				if ( isset( $single_data2['_single_hero_breadcrumbs'] ) ) $single_hero_breadcrumbs = esc_attr($single_data2['_single_hero_breadcrumbs']);
				$single_enable_notitle = $single_data2['_single_enable_notitle'];
			}
		}
		// if this is post, show Blog as title. we dont want double entry for title.
		if( is_singular('post') || (is_home() && ! is_front_page()) ) $single_headline_title = esc_html__( 'Blog', 'cakecious' );
        if( is_archive()) $single_headline_title = get_the_archive_title();
		if ( is_category() || (class_exists( 'woocommerce' ) && is_product_category()) ) {
			/* customers dont want Category: */
			 $single_headline_title = single_cat_title( '', false );
		}
		if ( is_search() ) {
			$single_headline_title =  esc_html__( 'Search Results for: ', 'cakecious' ). '<span>' . get_search_query() . '</span>';
		}
		// user wants hero section disable globally.
		$disable_hero_global = cakecious_fw_get_option('disable_hero_global', '0');
		if( $disable_hero_global ) $single_headline_title = '';

		// User wants to force custom text as hero title.
		if( $single_headline_title_cust != '' ) {
			$single_headline_title = $single_headline_title_cust;
		}

			ob_start(); ?>
			<?php if( !empty($single_headline_title)) { ?>
			<div class="breadcrumb-area banner_area herobg ">
			<div class="banner_text">
				<?php if( $single_enable_notitle ) { ?>
				<h3 class="tt-title"></h3>
				<?php } else { ?>
				<h3 class="tt-title"><?php echo wp_kses($single_headline_title, cakecious_tt_allowed_tags()); ?></h3>
				<?php  } ?>
				<?php
				// Breadcrumb
					 if( function_exists('breadcrumb_trail') && !(is_home() || is_front_page()) ){
						 breadcrumb_trail();
					 }
				?>
			</div>
			</div>
			<?php } ?>
			<?php $generic_hero = ob_get_clean();
			print wp_kses_post($generic_hero);
	}
}

/**
 * Add color styling from theme
 */
if(!( function_exists('cakecious_inline_styles1') )) {
	function cakecious_inline_styles1() {

		if( is_home() && ! is_front_page() ) return; /* because hero function handles it */

		// grab the hero bg image
		$global_herobg = cakecious_fw_get_option( 'global_herobg' );
		if ( ! is_array( $global_herobg ) ) {
			$global_herobg['url'] = '';
		}

		$custom_css = "
                .breadcrumb-area{
                        background-image:  url('" . esc_url( $global_herobg['url'] ) . "');
                }";
		wp_add_inline_style( 'cakecious-style', $custom_css );
	}

	add_action( 'wp_enqueue_scripts', 'cakecious_inline_styles1' );
}

/**
 * Add color styling from theme
 */
if(!( function_exists('cakecious_inline_styles2') )) {
	function cakecious_inline_styles2() {

		$single_page_img = $single_page_color = '';

		// grab the hero bg image
		$global_herobg = cakecious_fw_get_option( 'global_herobg' );
		if ( ! is_array( $global_herobg ) ) {
			$global_herobg['url'] = '';
		}
		if( '' != $global_herobg['url'] ) $single_page_img = $global_herobg['url'];

		$tt_id = cakecious_get_the_id();

		if ( empty( $tt_id ) ) {
			return;
		}

		$single_data2 = get_post_meta( $tt_id, '_tt_meta_page_opt', true );
		if ( is_array( $single_data2 ) ) {
			if ( '' != $single_data2['_single_page_img'] ) {
				$single_page_img = esc_textarea( $single_data2['_single_page_img'] );
			}
		}

		$custom_css = "
                .breadcrumb-area{
                        background-image:  url('" . esc_url( $single_page_img ) . "');
                }
				.overlay-clr{
                        background-color:  " . $single_page_color . ";
                }";
		wp_add_inline_style( 'cakecious-style', $custom_css );

	}

	add_action( 'wp_enqueue_scripts', 'cakecious_inline_styles2' );
}


/**
 * Add image from theme
 */
if(!( function_exists('cakecious_inline_videocss') )) {
	function cakecious_inline_videocss($img='') {
		if( $img == '' ) return;
		$custom_css = "
						.about_us_area.aboutus_row .about_video .video_inner {
							    background-image:  url('" . esc_url( $img ) . "');

			            }";
		wp_add_inline_style( 'cakecious-style', $custom_css );
	}

	add_action( 'wp_enqueue_scripts', 'cakecious_inline_videocss',  '1000' );
}


/*-----------------------------------------------------------------------------------*/
/* Allowed tags                                                                      */
/*-----------------------------------------------------------------------------------*/

if(!( function_exists('cakecious_tt_allowed_tags') )){
	function cakecious_tt_allowed_tags(){
		return array(
		    'img' => array(
		        'src' => array(),
		        'alt' => array(),
		        'class' => array(),
		        'style' => array(),
		    ),
		    'a' => array(
		        'href' => array(),
		        'title' => array(),
		        'class' => array(),
		        'target' => array()
		    ),
		    'br' => array(),
		    'div' => array(
		        'class' => array(),
		        'style' => array(),
		    ),
		    'span' => array(
		        'class' => array(),
		        'style' => array(),
		    ),
		    'h1' => array(
		        'class' => array(),
		        'style' => array(),
		    ),
		    'h2' => array(
		        'class' => array(),
		        'style' => array(),
		    ),
		    'h3' => array(
		        'class' => array(),
		        'style' => array(),
		    ),
		    'h4' => array(
		        'class' => array(),
		        'style' => array(),
		    ),
		    'h5' => array(
		        'class' => array(),
		        'style' => array(),
		    ),
		    'h6' => array(
		        'class' => array(),
		        'style' => array(),
		    ),
		    'style' => array(),
		    'em' => array(),
		    'strong' => array(),
		    'p' => array(
		    	'class' => array(),
		        'style' => array(),
		    ),
		);
	}
}

function cakecious_tt_css_allow($allowed_attr) {

    if (!is_array($allowed_attr)) {
        $allowed_attr = array();
    }

    $allowed_attr[] = 'display';
    $allowed_attr[] = 'background-image';
    $allowed_attr[] = 'url';

    return $allowed_attr;
} add_filter('safe_style_css','cakecious_tt_css_allow');

add_filter( 'wp_nav_menu_items', 'cakecious_add_search_to_nav', 10, 2 );
function cakecious_add_search_to_nav( $items, $args ) {

	$single_data2 = $hdr_type = $hdr_type = $single_hdr_type = '';

	if ( ! cakecious_fw_get_option('enable_hdr_search', '1') ) return $items;

	$hdr_type1 = cakecious_get_hdr_type();

	if ( $hdr_type1 == 'header3' || $hdr_type1 == 'header4' ) {

	$items .= '<li class="search_icon"><a class="popup-with-zoom-anim" href="#test-search"><i class="icon icon-Search"></i></a></li>
';
	}

    return $items;
}

add_filter('tt_project_cpt_args','cakecious_project_to_gallery', 100) ;
function cakecious_project_to_gallery($prj_args) {
	$prj_args['labels']['name']                 = esc_attr__( 'Gallery', 'cakecious' );
	$prj_args['labels']['singular_name']        = esc_attr__( 'Gallery', 'cakecious' );
	$prj_args['labels']['add_new']              = esc_attr__( 'Add Gallery', 'cakecious' );
	$prj_args['labels']['add_new_item']         = esc_attr__( 'Add Gallery', 'cakecious' );
	$prj_args['labels']['edit']                 = esc_attr__( 'Edit', 'cakecious' );
	$prj_args['labels']['edit_item']            = esc_attr__( 'Edit Gallery', 'cakecious' );
	$prj_args['labels']['new_item']             = esc_attr__( 'New Gallery', 'cakecious' );
	$prj_args['labels']['view']                 = esc_attr__( 'View Gallery', 'cakecious' );
	$prj_args['labels']['view_item']            = esc_attr__( 'View Gallery', 'cakecious' );
	$prj_args['labels']['search_items']         = esc_attr__( 'Search Gallery', 'cakecious' );
	$prj_args['labels']['not_found']            = esc_attr__( 'No Gallery found', 'cakecious' );
	$prj_args['labels']['not_found_in_trash']   = esc_attr__( 'No Gallery found in Trash', 'cakecious' );
	$prj_args['labels']['parent']               = esc_attr__( 'Parent Gallery', 'cakecious' );

	$prj_args['rewrite']['slug'] = 'gallery' ;
	return $prj_args;
}

add_filter('tt_portfolio_cpt_args','cakecious_prj_to_events', 100) ;
function cakecious_prj_to_events($prj_args) {
	$prj_args['labels']['name']                 = esc_attr__( 'Event', 'cakecious' );
	$prj_args['labels']['singular_name']        = esc_attr__( 'Event', 'cakecious' );
	$prj_args['labels']['add_new']              = esc_attr__( 'Add Event', 'cakecious' );
	$prj_args['labels']['add_new_item']         = esc_attr__( 'Add Event', 'cakecious' );
	$prj_args['labels']['edit']                 = esc_attr__( 'Edit', 'cakecious' );
	$prj_args['labels']['edit_item']            = esc_attr__( 'Edit Event', 'cakecious' );
	$prj_args['labels']['new_item']             = esc_attr__( 'New Event', 'cakecious' );
	$prj_args['labels']['view']                 = esc_attr__( 'View Event', 'cakecious' );
	$prj_args['labels']['view_item']            = esc_attr__( 'View Event', 'cakecious' );
	$prj_args['labels']['search_items']         = esc_attr__( 'Search Event', 'cakecious' );
	$prj_args['labels']['not_found']            = esc_attr__( 'No Event found', 'cakecious' );
	$prj_args['labels']['not_found_in_trash']   = esc_attr__( 'No Event found in Trash', 'cakecious' );
	$prj_args['labels']['parent']               = esc_attr__( 'Parent Event', 'cakecious' );

	$prj_args['rewrite']['slug'] = 'event' ;
	unset($prj_args['exclude_from_search']);
	unset($prj_args['show_in_admin_bar']);
	unset($prj_args['show_in_nav_menus']);
	unset($prj_args['publicly_queryable']);
	unset($prj_args['query_var']);
	$prj_args['show_ui'] = true;
	return $prj_args;
}


/*-----------------------------------------------------------------------------------*/
/* END */
/*-----------------------------------------------------------------------------------*/

