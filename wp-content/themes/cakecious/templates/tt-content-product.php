<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $post;

// Fetch current WC columns.
$tt_wc_cols = esc_attr( wc_get_loop_prop( 'columns' ) );
//$tt_wc_cols = wc_get_default_products_per_row();
if ( $tt_wc_cols == 4) $WC_cols = 3; if ( $tt_wc_cols == 3) $WC_cols = 4; if ( $tt_wc_cols == 2) $WC_cols = 6; if ( $tt_wc_cols == 1) $WC_cols = 12;

//override the shop page display.
if( is_shop() && is_active_sidebar( 'shop' ) ) $WC_cols = '4';

?>
<li <?php wc_product_class('col-lg-'.$WC_cols.' col-md-4 col-6', $product); ?>>
	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>
    <div class="cake_feature_item">
	    <?php if( function_exists('woocommerce_show_product_loop_sale_flash')) woocommerce_show_product_loop_sale_flash(); ?>
		<div class="cake_img">
			<a href="<?php the_permalink(); ?>">
		     <?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( $post->ID, 'shop_single'  );
			} else {
				$html1  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html1 .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'cakecious' ) );
				$html1 .= '</div>';
			print wp_kses_post($html1); /* already sanitized. */
			}
		    ?>
			</a>
		</div>
		<div class="cake_text">
			<?php if ( $price_html = $product->get_price_html() ) : ?>
				<h4><?php echo wp_kses_post($price_html); ?></h4>
			<?php endif; ?>
			<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook.
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
			/**
			 * woocommerce_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			do_action( 'woocommerce_shop_loop_item_title' );
			?>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook.
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>
			<?php
			/**
			 * woocommerce_after_shop_loop_item hook.
			 */
			do_action( 'woocommerce_after_shop_loop_item' );
			?>
            <?php
			if (!class_exists('QLWCAJAX')) {
			            echo apply_filters( 'woocommerce_loop_add_to_cart_link',
							sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="pest_btn %s">%s</a>',
								esc_url( $product->add_to_cart_url() ),
								esc_attr( isset( $quantity ) ? $quantity : 1 ),
								esc_attr( $product->get_id() ),
								esc_attr( $product->get_sku() ),
								esc_attr( isset( $class ) ? $class : 'button' ),
								esc_html( $product->add_to_cart_text() )
							),
						$product );
			}
			?>
		</div>
	</div>
</li>