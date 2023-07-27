<?php
/*
 * Template file for posts shortcode.
 * $temptt_t_vars is an array of custom parameters set for given post shortcode.
 */

?>

<div class="arivals_slider owl-carousel woocommerce">
			<?php
				// Posts are found
				if ( $posts->have_posts() ) {
					while ( $posts->have_posts() ) :
						$posts->the_post();
						global $post;global $product;


			// Fire standard shop loop hooks when paginating results so we can show result counts and so on.
				//do_action( 'woocommerce_before_shop_loop' );

// remove unwanted woocommerce actions.
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 100 );
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

?>
<div <?php wc_product_class('item'); ?>>
	<?php get_template_part( 'template-parts/blv-products-loop-inner' ); ?>
	<?php
	/**
	 * woocommerce_after_shop_loop_item hook.
	 */
	?>
</div>

	    <?php
			//woocommerce_product_loop_end();

				do_action( 'woocommerce_after_shop_loop' );

					endwhile;
				}
				// Posts not found
				else {
					echo '<h4>' . esc_html__( 'Posts not found', 'cakecious' ) . '</h4>';
				}
			?>

</div>