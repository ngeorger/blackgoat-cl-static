<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Functions this theme depends on! */
/*-----------------------------------------------------------------------------------*/

/**
 * ====================================================
 * Template hooks modified
 * ====================================================
 */

if (!function_exists( 'cakecious_template_hooks_modified')) {
	function cakecious_template_hooks_modified() {

		if ( is_singular() ) {

			// Add post navigation.
			remove_action( 'cakecious/frontend/after_main', 'cakecious_single_post_navigation', 15 );
			add_action( 'cakecious/frontend/after_main', 'cakecious_single_post_navigation_modified', 15 );

		}

	}
	add_action( 'wp', 'cakecious_template_hooks_modified', 21 );
}


/* Modifying prev next navigation */
if ( ! function_exists( 'cakecious_single_post_navigation_modified' ) ) :
/**
 * Render prev / next post navigation in single post page.
 */
function cakecious_single_post_navigation_modified() {
	if ( ! is_singular( 'post' ) ) {
		return;
	}

	if ( ! intval( cakecious_get_theme_mod( 'blog_single_navigation' ) ) ) {
		return;
	}

	the_post_navigation( array(
		/* translators: %s: title syntax. */
		'prev_text' => sprintf( esc_html__( 'Next &raquo;', 'cakecious' ), '%title' ),
		/* translators: %s: title syntax. */
		'next_text' => sprintf( esc_html__( '&laquo; Previous', 'cakecious' ), '%title' ),
	) );
}
endif;

// Add post sharing on single post.
if ( cakecious_get_theme_mod('single_blog_share', '0') ) {
	add_action( 'cakecious/frontend/entry/before_footer', 'cakecious_single_post_share', 15 );
}
if (!function_exists( 'cakecious_single_post_share')) {
	function cakecious_single_post_share() {

		cakecious_get_template_part( 'cakecious-postshare' );

	}
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

if (!function_exists( 'cakecious_css_allow ')) {
	function cakecious_css_allow( $allowed_attr ) {

		if ( ! is_array( $allowed_attr ) ) {
			$allowed_attr = array();
		}

		$allowed_attr[] = 'display';
		$allowed_attr[] = 'background-image';
		$allowed_attr[] = 'url';

		return $allowed_attr;
	}

	add_filter( 'safe_style_css', 'cakecious_css_allow' );
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
/* return excerpt with given charlent.                                               */
/*-----------------------------------------------------------------------------------*/
// source https://codex.wordpress.org/Function_Reference/get_the_excerpt
if (!function_exists( 'cakecious_blv_excerpt_charlength')) {
	function cakecious_blv_excerpt_charlength( $charlength ) {
		$excerpt = get_the_excerpt();
		$charlength ++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex   = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut   = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				echo mb_substr( $subex, 0, $excut );
			} else {
				echo esc_html($subex);
			}
			echo '...';
		} else {
			echo esc_html($excerpt);
		}
	}
}
if (!function_exists( 'cakecious_tt_excerpt_charlength')) {
	function cakecious_tt_excerpt_charlength( $charlength ) {

		cakecious_blv_excerpt_charlength( $charlength );

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
if (!function_exists('cakecious_blv_get_cats')) {
	function cakecious_blv_get_cats( $return='' ) {
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
						$output .= '<a class="tt_cats" href="' . get_term_link( $cat, $taxonomy->name ) . '"><div class="cat">' . $cat->name . '</div></a>';
					}
				}
			}
		}
		return $output;
	}
}


/* Functions for applying defaults on first install */
if( ! function_exists( 'cakecious_apply_defaults' ) ) {
	function cakecious_apply_defaults() {

		//defaults already applied, nothing left to do.
		if( get_theme_mod('blv_defaults_modified') ) {
			return;
		}
		//original defaults
		$add = (include CAKECIOUS_INCLUDES_DIR . '/customizer/defaults.php');
		//theme defaults
		$themedefaults = (include CAKECIOUS_INCLUDES_DIR . '/theme-helpers/theme-defaults.php' );
		//Merging default values to changed value array
		if( is_array($themedefaults)) {
			array_push( $themedefaults, $add );
			//removing duplicates
			foreach ( $themedefaults as $k => $na ) {
				$new[ $k ] = serialize( $na );
			}
			$uniq = array_unique( $new );
			foreach ( $uniq as $k => $ser ) {
				$final_array[ $k ] = unserialize( $ser );
			}
			if ( is_array( $final_array ) ) {
				foreach ( $final_array as $key => $value ) {
					if ( ! get_theme_mod( $key ) ) {
						set_theme_mod( $key, $value );
					}
				}
			}
			set_theme_mod( 'blv_defaults_modified', 'yes' );
		}

	}
	//cakecious_apply_defaults();
}

/* Functions for saving defaults on first install, function to be called manually and carefully. */
if( ! function_exists( 'cakecious_save_defaults' ) ) {
	function cakecious_save_defaults( $defaults = array() ) {

		global $wp_filesystem;
		$output = ''; $defaults_file = CAKECIOUS_INCLUDES_DIR . '/theme-helpers/theme-defaults.php';

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}
		/* Erase prev content from defaults file. */
		$wp_filesystem->put_contents( $defaults_file, $output, FS_CHMOD_FILE );

		/* Start preparing list of defaults */
		$default = ( include CAKECIOUS_INCLUDES_DIR . '/customizer/defaults.php' );
		ob_start();
		echo '<?php ';
		echo "\n";
		echo ' /* Defaults set by theme */ ';
		echo "\n";
		echo "$" . "themedefaults = array();";
		echo "\n";
		foreach ( $default as $key => $value ) {
			if ( get_theme_mod( $key ) ) {
				$value = get_theme_mod( $key );
			}
			if ( $value == '' ) {
				echo "$" . "themedefaults['" . $key . "'] = '';";
				echo "\n";
			} elseif ( is_array( $value ) ) {
				//if( empty($value) ) {
				//	echo "$"."themedefaults['".$key ."'] = 'array()';";echo "\n";
				//}
				// turning into simple array.
				$value1 = json_encode( $value );
				$value2 = str_replace( '[', '(', $value1 );
				$value2 = str_replace( ']', ')', $value2 );
				$value2 = str_replace( '"', '\'', $value2 );
				echo "$" . "themedefaults['" . $key . "'] = array" . $value2 . ";";
				echo "\n";
			} else {
				echo "$" . "themedefaults['" . $key . "'] = '" . $value . "';";
			}
			echo "\n";
		}
		echo 'return $themedefaults;';
		$output = ob_get_clean();

		/* Write defaults on file */
		$wp_filesystem->put_contents( $defaults_file, $output, FS_CHMOD_FILE );
	}
}



/**
 * Adding custom templates, if chosen so in customiser
 *
 * @param array $classes.
 * @return array
 */
/*
if ( cakecious_get_theme_mod( 'custom_look', 'cakecious_special' ) == 'cakecious_special' ) {

	add_filter( 'cakecious/frontend/template_dirs', 'cakecious_custom_templates' );
	add_filter( 'single_template', 'cakecious_single_page_template' );

}
*/
/* This function modifies the default templates.
* If called template not found on this overrides folder, the default from template-part will be used.
*/
if( ! function_exists( 'cakecious_custom_templates' )) {
	function cakecious_custom_templates( $templatepath = array() ) {

	$templatepath[] = CAKECIOUS_INCLUDES_DIR . '/theme-helpers/overrides';

	return $templatepath;

	}
}
if( ! function_exists( 'cakecious_single_page_template' )) {
	function cakecious_single_page_template( $single_template ) {
		global $post;

		if ( $post->post_type == 'post' ) {
			$single_template = CAKECIOUS_INCLUDES_DIR . '/theme-helpers/overrides/single.php';
		}

		return $single_template;
	}
}

/**
 * Return meta value for given key
 *
 * @param array $classes.
 * @return array
 */
if (!function_exists( 'cakecious_meta_value')) {
    function cakecious_meta_value( $key, $default = null, $postid = '' )
    {
	    $current_id = '';
		if( '' != $key ) {
			// Grab post id.
			$current_id = cakecious_get_the_id();
			if ( '' != $postid ) {
				$current_id = $postid;
			}

			$single_data2 = get_post_meta( $current_id, '_tt_meta_page_opt', true );
			if ( is_array( $single_data2 ) ) {
				if ( isset( $single_data2[ $key ] ) ) {
					$value = $single_data2[ $key ];
				}
			}
			// Fallback to default parameter
			if ( is_null( $value ) ) {
				$value = $default;
			}
			$value = apply_filters( 'cakecious/customizer/setting_value/' . $key, $value );

		}
	    return $value;
	}
}



/* Modifying comment form fields */
if(!( function_exists('cakecious_comment_form_fields') )) {
	function cakecious_comment_form_fields( $fields ) {
		$commenter = wp_get_current_commenter();
		$req       = get_option( 'require_name_email' );
		$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
		$aria_req  = ( $req ? " aria-required='true'" : '' );
		$html5     = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
		$fields    = array(
			'author'  => '<div class="form-group comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'cakecious' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
			             '<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
			'email'   => '<div class="form-group comment-form-email"><label for="email">' . esc_html__( 'Email', 'cakecious' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
			             '<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
			'url'     => '<div class="form-group comment-form-url"><label for="url">' . esc_html__( 'Website', 'cakecious' ) . '</label> ' .
			             '<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
			'cookies' => '<div class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
			             '<label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'cakecious' ) . '</label></div>',
		);

		return $fields;
	}
	add_filter( 'comment_form_default_fields', 'cakecious_comment_form_fields' );
}

/* Modifying comment form */
if( ! function_exists('cakecious_comment_form') ) {
	function cakecious_comment_form( $args ) {
		if( ! is_array($args) ) return;
		$args['comment_field'] = '<div class="form-group comment-form-comment">
	<label for="comment">' . _x( 'Comment', 'noun', 'cakecious' ) . ( ' <span class="required">*</span>' ) . '</label>
	<textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	</div>';
		$args['class_submit']  = 'btn order_s_btn'; // since WP 4.1
		return $args;
	}
	add_filter( 'comment_form_defaults', 'cakecious_comment_form' );
}



/**
 * Add color styling from theme
 */
if(!( function_exists('cakecious_inline_styles2') )) {
	function cakecious_inline_styles2() {

		$custom_ft_bg = $single_page_color = '';

		if ( cakecious_get_theme_mod( 'custom_ft_bg', 0 ) ) {
			$custom_ft_bg = wp_get_attachment_image_url( cakecious_get_theme_mod( 'custom_ft_bg', 0 ), 'full', true );

			$custom_css = "
					.cakecious-footer-widgets-bar {
					    background-image: url('" . esc_url( $custom_ft_bg ) . "') !important;
					    background-repeat: no-repeat;
						background-size: cover;
					}
					";

			wp_add_inline_style( 'cakecious', $custom_css );

		}

	}

	add_action( 'wp_enqueue_scripts', 'cakecious_inline_styles2', '100' );
}