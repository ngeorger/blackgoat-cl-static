<?php
/**
 * cakecious Custom css
 *
 * @package cakecious
 */

if(!( function_exists('cakecious_inline_custom_css') )) {
	function cakecious_inline_custom_css( $force = false ) {

		global $tt_temptt_opt;
		$output = $body_image = '';
		// Get options
		$settings = array(
						'top_nav_color' => '',
						'main_acnt_clr' => '',
						'secondary_acnt_clr' => '',
						'h_typography' => '',
						'custom_css' => ''
						);
		$settings = cakecious_fw_opt_values( $settings );


		if($force) { // we have been forced to show specific colors.
			$settings['main_acnt_clr'] = $tt_temptt_opt['tt_main_acnt_clr'];
		}


		// Type Check for Array
		if ( is_array($settings) ) {

		if ( ! ( $settings['main_acnt_clr'] == '' )) { // if usr changed!
			$output .= '


.bac{} /*its here for inconsistency fix. */



input[type=button], input[type=submit], .top_header_area:before, .cake_feature_slider .cake_feature_slider .owl-prev:hover, .cake_feature_slider .cake_feature_slider .owl-next:hover, .client_says_slider .client_says_slider .owl-prev:hover, .client_says_slider .client_says_slider .owl-next:hover, .blog_pagination .pagination .page-numbers:hover, .blog_pagination .pagination .page-numbers.current , .coming_soon_counter .counter-item, .product_pagination .left_btn a:hover, .product_pagination .middle_list .pagination li:hover a, .product_pagination .middle_list .pagination li.active a, .product_pagination .right_btn a:hover, .product_tab_area .nav.nav-tabs a, .f_about_widget .nav li:hover a, .woocommerce div.product .woocommerce-tabs ul.tabs li a,.woocommerce #review_form #respond textarea:focus, .woocommerce-billing-fields input.input-text:focus, .woocommerce-billing-fields .select2-selection.select2-selection--single:focus, .woocommerce form .woocommerce-additional-fields textarea:focus, #searchform .form-control:focus, #searchform .btn-primary:hover, .tt-object
{ border-color: '.$settings['main_acnt_clr'].'; }



input[type=button], input[type=submit], .top_header_area, .main_menu_area .navbar.navbar-expand-lg .navbar-nav li a:before,
  .pink_btn, .pest_w_btn:before, .w_view_btn:before, .pink_more, .main_slider_area .rev_slider ul li .slider_text_box .main_btn:hover, .main_slider_area .rev_slider ul li .slider_text_box .now_btn:hover, .cake_feature_slider .cake_feature_slider .owl-prev:hover, .cake_feature_slider .cake_feature_slider .owl-next:hover, .pink_cake_feature, .pink_cake_feature .cake_feature_inner .title_view_all .float-right .pest_btn:before, .faq_form_area .faq_left_form .contact_us_form .form-group .pest_btn, .service_area, .service_we_offer_area, .arivals_slider .owl-dots .owl-dot, .client_says_slider .client_says_slider .owl-prev:hover, .client_says_slider .client_says_slider .owl-next:hover, .testimonials_item_area.din_mod .testi_item_inner .media, .blog_pagination .pagination .page-numbers:hover, .blog_pagination .pagination .page-numbers.current, .comment-respond form .order_s_btn, .newsletter_area, .newsletter_area.gray_bg .newsletter_inner .newsletter_form .input-group #mc-embedded-subscribe, .newsletter_area.gray_bg .newsletter_inner .newsletter_form .input-group .input-group-append button, .contact_us_form .form-group .order_s_btn, .portfolio_filter ul li a:before, .c-search-form .input-group .input-group-addon button, .c-search-form .input-group .input-group-addon button:hover, .c-search-form .input-group .input-group-addon button:focus, .product_pagination .left_btn a:hover, .product_pagination .middle_list .pagination li:hover a, .product_pagination .middle_list .pagination li.active a, .product_pagination .right_btn a:hover, .product_tab_area .nav.nav-tabs a, .product_tab_area .nav.nav-tabs a:before, .f_title h3:before, .woocommerce.single-product span.onsale, .woocommerce div.product form.cart .button, .woocommerce div.product .woocommerce-tabs ul.tabs li a, .woocommerce #respond input#submit, .woocommerce-message a.button, .woocommerce a.button, .woocommerce input.button:disabled, .woocommerce input.button:disabled[disabled], .woocommerce-cart .wc-proceed-to-checkout a.checkout-button, .woocommerce-column__title:after, .woocommerce-order-details__title:after, woocommerce-checkout h1.page-title2:after, .woocommerce-checkout .woocommerce h3:after, .woocommerce #payment #place_order, .woocommerce-page #payment #place_order, #searchform .btn-primary:hover, .woocommerce span.onsale, .scrollup, .main_menu_area .navbar.navbar-expand-lg .navbar-nav li.submenu .dropdown-menu li:hover a, .main_menu_area .navbar.navbar-expand-lg .navbar-nav li.submenu .dropdown-menu .submenu .dropdown-menu li:hover a,  .main_menu_two .navbar.navbar-expand-lg .navbar-nav li.submenu .dropdown-menu li:hover a, .main_menu_two .navbar.navbar-expand-lg .navbar-nav li.submenu .submenu .dropdown-menu li:hover a, .middle_menu_three .navbar.navbar-expand-lg .navbar-nav li.submenu .dropdown-menu li:hover a, .middle_menu_three .navbar.navbar-expand-lg .navbar-nav li.submenu .submenu .dropdown-menu li:hover a, .box_menu_four .navbar.navbar-expand-lg .navbar-nav li.submenu .dropdown-menu li:hover a, .box_menu_four .navbar.navbar-expand-lg .navbar-nav li.submenu .submenu .dropdown-menu li:hover a
{ background-color:'.$settings['main_acnt_clr'].'; }



a, input[type=button]:hover, input[type=submit]:hover, .comment-respond form .order_s_btn:hover, .main_menu_two .navbar.navbar-expand-lg .navbar-nav li:hover a, .main_menu_two .navbar.navbar-expand-lg .navbar-nav li.active a, .woocommerce nav.woocommerce-pagination ul li a, .cakecious-header-main-bar .cakecious-header-html-2 .media .d-flex i, .middle_menu_three .navbar.navbar-expand-lg .navbar-nav li:hover a, .middle_menu_three .navbar.navbar-expand-lg .navbar-nav li.active a, .box_menu_four .navbar.navbar-expand-lg .navbar-nav li:hover a, .box_menu_four .navbar.navbar-expand-lg .navbar-nav li.active a, .pest_w_btn:hover, .w_view_btn:hover, .pink_cake_feature .cake_feature_inner .title_view_all .float-right .pest_btn:hover, .service_m_item .service_text h4:hover, .cat-links a, .tags-links a, .tt_prev_post, .tt_next_post, .logged-in-as a, .special_item_inner .specail_item .s_item_left .list_style li:hover a, .chef_item h4:hover, .l_news_item .l_news_text h4:hover, .blog_item .blog_text .blog_time .float-left a, .blog_item .blog_text .blog_time .float-right .list_style li:hover a, .blog_item .blog_text h4:hover, .right_sidebar_area .widget ul li a:hover, .recent_widget .recent_w_inner .media .media-body h4:hover, .single_element_text p a, .s_comment_list .s_comment_list_inner .media .media-body .date_rep a:last-child, .modal-message .modal-dialog .modal-content .modal-header h2,  .portfolio_item .portfolio_text h4:hover, .coming_soon_counter .counter-item, .p_catgories_widget .list_style li:hover a, .p_sale_widget .media .media-body h4:hover, .billing_details_area .return_option h4 a, .order_box_price .payment_list .accordion_area .card .card-header h5 a, .f_about_widget .nav li:hover a, .f_widget ul li a:hover, .footer_copyright .copyright_inner .float-right a, .woocommerce .star-rating span::before, .woocommerce .star-rating::before, .woocommerce div.product p.price, .woocommerce div.product span.price, .product_meta a:hover, .site-main .stars a, .woocommerce-message::before, a.showcoupon, .woocommerce table.shop_table td.product-name a:hover, .breadcrumb-area .trail-item a span, .breadcrumb-area .trail-item:before, .input-group-btn:hover:before,
.main_menu_area .navbar.navbar-expand-lg .navbar-nav li:hover a, .main_menu_area .navbar.navbar-expand-lg .navbar-nav li.active a, .woocommerce .product_list_widget li .product-title:hover, .widget h2.widgettitle,.discover_item_inner .discover_item p span
{ color: '.$settings['main_acnt_clr'].'; }





.woocommerce div.product .woocommerce-tabs ul.tabs li.active a, .woocommerce-error, .woocommerce-info, .woocommerce-message {
    border-top: 3px solid '.$settings['main_acnt_clr'].';
}
.woocommerce a.remove:hover {
    color: '.$settings['main_acnt_clr'].'!important;
}

@media(max-width: 991px){
	.my_toggle_menu span{
		background: '.$settings['main_acnt_clr'].';
	}
}



						';
		}

		if ( ! ( $settings['secondary_acnt_clr'] == '' )) { // if usr changed!
			$output .= '

						';
		}

		if ( isset($settings['h_typography']['font-family']) && ! ( $settings['h_typography']['font-family'] == '' )) { // if usr changed!
			$output .= '
.bac{}
.main_title h2, .service_item h4, .discover_item_inner .discover_item h4, .special_recipe_slider .item .media .media-body h4, .single_w_title h2,
.c_says_title h2, .single_pest_title h2, .single_pest_title h2, .page-title2, .entry-title2, .our_bakery_area .our_bakery_text h2, .main_w_title h2,
.single_b_title h2, .s_we_item .media .media-body h4, .bakery_video_area .video_inner h3, .single_m_title h2, .banner_text h3, .portfolio_item .portfolio_text h4,
.faq_collaps .left_side_collaps .card .card-header button, .special_item_inner .specail_item .special_item_text h4, .blog_item .blog_text h4,
.l_news_item .l_news_text h4, .f_title h3, .service_m_item .service_text a, .faq_form_area .faq_left_form .faq_title h3, .widget h2.widgettitle, .cake_feature_item .cake_text h3 a, .cake_feature_item .cake_text h3
{ font-family: "'.$settings['h_typography']['font-family'].'"; }


.main_title h2, .single_pest_title h2, .our_bakery_area .our_bakery_text h2, .service_m_item .service_text a, .faq_collaps .left_side_collaps .card .card-header button, .faq_form_area .faq_left_form .faq_title h3, .special_item_inner .specail_item .special_item_text h4, .blog_item .blog_text h4
{ color: '.$settings['h_typography']['color'].'; }

.main_title h2, .service_item h4, .discover_item_inner .discover_item h4, .special_recipe_slider .item .media .media-body h4, .single_w_title h2,
.c_says_title h2, .single_pest_title h2, .single_pest_title h2, .page-title2, .entry-title2, .our_bakery_area .our_bakery_text h2, .main_w_title h2,
.single_b_title h2, .s_we_item .media .media-body h4, .bakery_video_area .video_inner h3, .single_m_title h2, .banner_text h3, .portfolio_item .portfolio_text h4,
.faq_collaps .left_side_collaps .card .card-header button, .special_item_inner .specail_item .special_item_text h4, .blog_item .blog_text h4, .discover_menu_inner .main_title h2, .cake_feature_inner .main_title h2
{ margin-bottom: 15px; }

.r_title h3, .p_w_title h3 { font-family: "'.$settings['h_typography']['font-family'].'"; color: '.$settings['h_typography']['color'].'; font-size: 23px; }
.woocommerce .product_list_widget li span {
  font-weight: 500;
  font-size: 20px;
  font-family: "'.$settings['h_typography']['font-family'].'";
}


						';
		}


			if ( $settings['top_nav_color'] != '' ) {
				$output .= 'header.sticky { background: ' . $settings['top_nav_color'] . ' }' . "\n";
			}
		} // End If Statement


		// Output styles
		if ( isset( $output ) && $output != '' ) {
			$output = strip_tags( $output );
			// Remove space after colons
			$output = str_replace(': ', ':', $output);
			// Remove whitespace
			$output = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '   ', '    '), '', $output);

			//$output = "\n" . "<!-- Theme Custom Styling -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
			$output = "\n" . "<!-- Theme Custom Styling -->\n\n" . $output . "\n";
			wp_add_inline_style( 'cakecious-style', $output );
		}

	}

	add_action( 'wp_enqueue_scripts', 'cakecious_inline_custom_css', 100 );
}
