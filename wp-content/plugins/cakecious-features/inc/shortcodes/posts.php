<?php
if ( ! defined( 'ABSPATH' ) ) exit;
add_shortcode( 'cakecious_posts', 'cakecious_posts_sc' );
add_shortcode( 'templatation_posts', 'cakecious_posts_sc' );

if( !function_exists( 'cakecious_posts_sc' )) {
	function cakecious_posts_sc( $atts = null, $content = null ) {
		// Prepare error var
		$error = null;
		// Parse attributes
		$atts = shortcode_atts( array(
			'template'            => 'templates/blv-posts-sc.php',
			'id'                  => false,
			'posts_per_page'      => get_option( 'posts_per_page' ),
			'post_type'           => 'post',
			'taxonomy'            => 'category',
			'tax_term'            => false,
			'tax_operator'        => 'IN',
			'author'              => '',
			'tag'                 => '',
			'meta_key'            => '',
			'offset'              => 0,
			'order'               => 'DESC',
			'orderby'             => 'date',
			'post_parent'         => false,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 'no',
			'temptt_show_filters' => 'no',
			'temptt_filter_all' => 'yes',
			'temptt_show_title'   => 'yes',
			'temptt_show_excerpt' => 'yes',
			'temptt_show_readmore'=> 'yes',
			'temptt_var1'=> '',
			'temptt_var2'=> '',
		), $atts, 'cakecious_posts' );

		$original_atts = $atts;

		$author              = sanitize_text_field( $atts['author'] );
		$id                  = $atts['id']; // Sanitized later as an array of integers
		$ignore_sticky_posts = ( bool ) ( $atts['ignore_sticky_posts'] === 'yes' ) ? true : false;
		$meta_key            = sanitize_text_field( $atts['meta_key'] );
		$offset              = intval( $atts['offset'] );
		$order               = sanitize_key( $atts['order'] );
		$orderby             = sanitize_key( $atts['orderby'] );
		$post_parent         = $atts['post_parent'];
		$post_status         = $atts['post_status'];
		$post_type           = sanitize_text_field( $atts['post_type'] );
		$posts_per_page      = intval( $atts['posts_per_page'] );
		$tag                 = sanitize_text_field( $atts['tag'] );
		$tax_operator        = $atts['tax_operator'];
		$tax_term            = sanitize_text_field( $atts['tax_term'] );
		$taxonomy            = sanitize_key( $atts['taxonomy'] );
		$temptt_show_filters     = sanitize_text_field( $atts['temptt_show_filters'] );
		$temptt_show_title     = sanitize_text_field( $atts['temptt_show_title'] );
		$temptt_show_excerpt     = sanitize_text_field( $atts['temptt_show_excerpt'] );
		$temptt_show_readmore     = sanitize_text_field( $atts['temptt_show_readmore'] );
		$temptt_filter_all     = sanitize_text_field( $atts['temptt_filter_all'] );
		$temptt_var1     = wp_kses_post( $atts['temptt_var1'] );
		$temptt_var2     = wp_kses_post( $atts['temptt_var2'] );
		// Set up initial query for post
		$args = array(
			'category_name'  => '',
			'order'          => $order,
			'orderby'        => $orderby,
			'post_type'      => explode( ',', $post_type ),
			'posts_per_page' => $posts_per_page,
			'tag'            => $tag
		);
		// Ignore Sticky Posts
		if ( $ignore_sticky_posts ) {
			$args['ignore_sticky_posts'] = true;
		}
		// Meta key (for ordering)
		if ( ! empty( $meta_key ) ) {
			$args['meta_key'] = $meta_key;
		}
		// If Post IDs
		if ( $id ) {
			$posts_in         = array_map( 'intval', explode( ',', $id ) );
			$args['post__in'] = $posts_in;
		}
		// Post Author
		if ( ! empty( $author ) ) {
			$args['author'] = $author;
		}
		// Offset
		if ( ! empty( $offset ) ) {
			$args['offset'] = $offset;
		}
		// Post Status
		$post_status = explode( ', ', $post_status );
		$validated   = array();
		$available   = array(
			'publish',
			'pending',
			'draft',
			'auto-draft',
			'future',
			'private',
			'inherit',
			'trash',
			'any'
		);
		foreach ( $post_status as $unvalidated ) {
			if ( in_array( $unvalidated, $available ) ) {
				$validated[] = $unvalidated;
			}
		}
		if ( ! empty( $validated ) ) {
			$args['post_status'] = $validated;
		}
		// If taxonomy attributes, create a taxonomy query
		if ( ! empty( $taxonomy ) && ! empty( $tax_term ) ) {
			// Term string to array
			$tax_term = explode( ',', $tax_term );
			// Validate operator
			if ( ! in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ) {
				$tax_operator = 'IN';
			}
			$tax_args = array(
				'tax_query' => array(
					array(
						'taxonomy' => $taxonomy,
						'field'    => ( is_numeric( $tax_term[0] ) ) ? 'id' : 'slug',
						'terms'    => $tax_term,
						'operator' => $tax_operator
					)
				)
			);
			// Check for multiple taxonomy queries
			$count            = 2;
			$more_tax_queries = false;
			while ( isset( $original_atts[ 'taxonomy_' . $count ] ) && ! empty( $original_atts[ 'taxonomy_' . $count ] ) &&
			        isset( $original_atts[ 'tax_' . $count . '_term' ] ) &&
			        ! empty( $original_atts[ 'tax_' . $count . '_term' ] ) ) {
				// Sanitize values
				$more_tax_queries        = true;
				$taxonomy                = sanitize_key( $original_atts[ 'taxonomy_' . $count ] );
				$terms                   = explode( ', ', sanitize_text_field( $original_atts[ 'tax_' . $count . '_term' ] ) );
				$tax_operator            = isset( $original_atts[ 'tax_' . $count . '_operator' ] ) ? $original_atts[ 'tax_' . $count . '_operator' ] : 'IN';
				$tax_operator            = in_array( $tax_operator, array(
						'IN',
						'NOT IN',
						'AND'
					) ) ? $tax_operator : 'IN';
				$tax_args['tax_query'][] = array(
					'taxonomy' => $taxonomy,
					'field'    => 'slug',
					'terms'    => $terms,
					'operator' => $tax_operator
				);
				$count ++;
			}
			if ( $more_tax_queries ):
				$tax_relation = 'AND';
				if ( isset( $original_atts['tax_relation'] ) &&
				     in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) )
				) {
					$tax_relation = $original_atts['tax_relation'];
				}
				$args['tax_query']['relation'] = $tax_relation;
			endif;
			$args = array_merge( $args, $tax_args );
		}

		// If post parent attribute, set up parent
		if ( $post_parent ) {
			if ( 'current' == $post_parent ) {
				global $post;
				$post_parent = $post->ID;
			}
			$args['post_parent'] = intval( $post_parent );
		}
		// Save original posts
		global $posts;
		$original_posts = $posts;
		$temptt_t_vars = array(
			'temptt_show_filters' => $temptt_show_filters,
			'temptt_filter_all' => $temptt_filter_all,
			'temptt_show_title'   => $temptt_show_title,
			'temptt_show_excerpt' => $temptt_show_excerpt,
			'temptt_show_readmore'=> $temptt_show_readmore,
			'temptt_var1'=> $temptt_var1,
			'temptt_var2'=> $temptt_var2,
		);
		set_query_var('temptt_t_vars', $temptt_t_vars);
		// Query posts
		$posts = new WP_Query( $args );
		// Buffer output
		ob_start(); ?>
		<div class="tt-post-wrapper ">
		<?php
		// Search for template in stylesheet directory
		if ( file_exists( STYLESHEETPATH . '/' . $atts['template'] ) ) {
			load_template( STYLESHEETPATH . '/' . $atts['template'], false );
		} // Search for template in theme directory
		elseif ( file_exists( TEMPLATEPATH . '/' . $atts['template'] ) ) {
			load_template( TEMPLATEPATH . '/' . $atts['template'], false );
		} // Search for template in plugin directory
		elseif ( path_join( dirname( __FILE__ ), 'templates/blv-posts-sc.php' ) ) {
			load_template( path_join( dirname( __FILE__ ), 'templates/blv-posts-sc.php' ), false );
		} // Template not found
		else {
			echo Su_Tools::error( __FUNCTION__, __( 'template not found', 'cakecious' ) );
		}
		?>
		</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();
		// Return original posts
		$posts = $original_posts;
		// Reset the query
		wp_reset_postdata();

		return $output;
	} //cakecious_posts_sc()
} //cakecious_posts_sc()