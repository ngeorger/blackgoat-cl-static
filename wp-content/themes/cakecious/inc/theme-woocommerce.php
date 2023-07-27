<?php
/**
 * Add WooCommerce support
 *
 * @package understrap
 */

add_action( 'after_setup_theme', 'woocommerce_support' );
if ( ! function_exists( 'woocommerce_support' ) ) {
	/**
	 * Declares WooCommerce theme support.
	 */
	function woocommerce_support() {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		// hook in and customizer form fields.
		add_filter( 'woocommerce_form_field_args', 'cakecious_wc_form_field_args', 10, 3 );
	}
}

/**
 * Filter hook function monkey patching form classes
 * Author: Adriano Monecchi http://stackoverflow.com/a/36724593/307826
 *
 * @param string $args Form attributes.
 * @param string $key Not in use.
 * @param null   $value Not in use.
 *
 * @return mixed
 */
function cakecious_wc_form_field_args( $args, $key, $value = null ) {

	// Start field type switch case.
	switch ( $args['type'] ) {

		/* Targets all select input type elements, except the country and state select input types */
		case 'select' :
			// Add a class to the field's html element wrapper - woocommerce
			// input types (fields) are often wrapped within a <p></p> tag.
			$args['class'][] = 'form-group';
			// Add a class to the form input itself.
			$args['input_class']       = array( 'form-control', 'input-lg' );
			$args['label_class']       = array( 'control-label' );
			$args['custom_attributes'] = array(
				'data-plugin'      => 'select2',
				'data-allow-clear' => 'true',
				'aria-hidden'      => 'true',
				// Add custom data attributes to the form input itself.
			);
			break;

		// By default WooCommerce will populate a select with the country names - $args
		// defined for this specific input type targets only the country select element.
		case 'country' :
			$args['class'][]     = 'form-group single-country';
			$args['label_class'] = array( 'control-label' );
			break;

		// By default WooCommerce will populate a select with state names - $args defined
		// for this specific input type targets only the country select element.
		case 'state' :
			// Add class to the field's html element wrapper.
			$args['class'][] = 'form-group';
			// add class to the form input itself.
			$args['input_class']       = array( '', 'input-lg' );
			$args['label_class']       = array( 'control-label' );
			$args['custom_attributes'] = array(
				'data-plugin'      => 'select2',
				'data-allow-clear' => 'true',
				'aria-hidden'      => 'true',
			);
			break;

		case 'password' :
		case 'text' :
		case 'email' :
		case 'tel' :
		case 'number' :
			$args['class'][]     = 'form-group';
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;

		case 'textarea' :
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;

		case 'checkbox' :
			$args['label_class'] = array( 'custom-control custom-checkbox' );
			$args['input_class'] = array( 'custom-control-input', 'input-lg' );
			break;

		case 'radio' :
			$args['label_class'] = array( 'custom-control custom-radio' );
			$args['input_class'] = array( 'custom-control-input', 'input-lg' );
			break;

		default :
			$args['class'][]     = 'form-group';
			$args['input_class'] = array( 'form-control', 'input-lg' );
			$args['label_class'] = array( 'control-label' );
			break;
	} // end switch ($args).

	return $args;
}



// Remove WC breadcrumb (we're using the Yoast SEO)
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

// remove unwanted woocommerce actions.
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
if (!class_exists('QLWCAJAX')) {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );


// Display related products?
add_action( 'wp_head','cakecious_fw_related_products' );
if ( ! function_exists( 'cakecious_fw_related_products' ) ) {
	function cakecious_fw_related_products() {

		if( ! cakecious_fw_get_option( 'wc_prod_related', true) ) {
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
		}

	} // End cakecious_fw_related_products()
}

// Display excerpt ?
add_action( 'wp_head','cakecious_fw_show_excerpt' );
if ( ! function_exists( 'cakecious_fw_show_excerpt' ) ) {
	function cakecious_fw_show_excerpt() {

		if( ! cakecious_fw_get_option( 'wc_show_excerpt', true) ) {
			add_filter( 'wc_tt_show_excerpt', '__return_false' );
		}

	} // End cakecious_fw_related_products()
}

// Hide shop title, if told so to do in page meta option.
add_filter( 'woocommerce_show_page_title' , 'cakecious_hide_page_title' );
/**
 * Removes the "shop" title on the main shop page
*/
function cakecious_hide_page_title() {
	$single_data3 = '';
	$tt_id = cakecious_get_the_id();
	$single_data3 = get_post_meta( $tt_id, '_tt_meta_page_opt', true );
	if( is_array($single_data3) ) {
		if ( $single_data3['_hide_title_display'] )
			return false;
		else
			return true;
	}
}


function cakecious_cart_icon(){
	?>
	<a class="cart-tt" href="<?php echo wc_get_cart_url(); ?>" title="<?php _e( 'View your shopping cart : ', 'cakecious' ); ?>">
		<i class="lnr lnr-cart"></i>
		<span class="tt-cart"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
	</a>

<?php
}

/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'cakecious_header_add_to_cart_fragment' );

function cakecious_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<a class="cart-tt" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'cakecious'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'cakecious'), $woocommerce->cart->cart_contents_count);?> - <?php echo esc_html($woocommerce->cart->get_cart_total()); ?></a>
	<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}

// define the woocommerce_single_product_image_gallery_classes callback
add_filter( 'woocommerce_single_product_image_gallery_classes', 'cakecious_single_product_image_gallery_classes', 10, 1 );
function cakecious_single_product_image_gallery_classes( $array ) {

	array_push($array,"col-lg-6", "float-left");
	return $array;
};

// add the filter
