<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.


/**
 * Register Post Type and Taxonomies
 *
 * @since 1.0
 */
function tt_testimonial_module_cpt() {

	$with_front = $testimonial_cpt_slug = $testimonial_cpt_cat_slug = $testimonial_cpt_single = $single_args = '';

	if( function_exists( 'tt_temptt_get_option' ) ) {
		$with_front = tt_temptt_get_option( 'cpt_with_front', '0' );
		$testimonial_cpt_slug = tt_temptt_get_option( 'testimonial_cpt_slug', 'testimonial-item' );
		$testimonial_cpt_cat_slug = tt_temptt_get_option( 'testimonial_cpt_cat_slug', 'testimonial-cats' );
		$testimonial_cpt_single = tt_temptt_get_option( 'testimonial_cpt_single', '0' );
	}
	// With Front
	if ( ! empty ( $with_front )  ) $with_front = true; else $with_front = false;

	// Single page
	if ( ! empty ( $testimonial_cpt_single )  ) { // single item true
		$single_args =  array('show_ui' => true) ;
	} else {
		$single_args =  array(
						'exclude_from_search' => true,
						'show_in_admin_bar'   => false,
						'show_in_nav_menus'   => false,
						'publicly_queryable'  => false,
						'query_var'           => false,
		) ;
	}


	/**
	 * Register Post Type
	 */

	// Arguments
	$cpt_args = array(
		'labels' => array(
			'name' => esc_attr__( 'Testimonial', 'cakecious' ),
			'singular_name' => esc_attr__( 'Testimonial', 'cakecious' ),
			'add_new' => esc_attr__( 'Add Testimonial', 'cakecious' ),
			'add_new_item' => esc_attr__( 'Add Testimonial', 'cakecious' ),
			'edit' => esc_attr__( 'Edit', 'cakecious' ),
			'edit_item' => esc_attr__( 'Edit Testimonial', 'cakecious' ),
			'new_item' => esc_attr__( 'New Testimonial', 'cakecious' ),
			'view' => esc_attr__( 'View Testimonial', 'cakecious' ),
			'view_item' => esc_attr__( 'View Testimonial', 'cakecious' ),
			'search_items' => esc_attr__( 'Search Testimonial', 'cakecious' ),
			'not_found' => esc_attr__( 'No Testimonial found', 'cakecious' ),
			'not_found_in_trash' => esc_attr__( 'No Testimonial found in Trash', 'cakecious' ),
			'parent' => esc_attr__( 'Parent Testimonial', 'cakecious' ),
		),
		'public' => true,
		'rewrite' => array( 'slug' => $testimonial_cpt_slug, 'with_front' => $with_front ),
		'supports' => array( 'title', 'editor', 'thumbnail' ),
	);

	// Single pages to be shown or not.
	$cpt_args = array_merge( $cpt_args, $single_args );

	// Apply filters
	$cpt_args = apply_filters( 'tt_testimonial_cpt_args', $cpt_args );

	// Register Post Type
	register_post_type( 'tt_testimonial', $cpt_args );

	/**
	 * Register Taxonomy ( Category )
	 */

	// Arguments
	$tax_args = array(
		'labels' => array(
			'name' => esc_attr__( 'Testimonial Categories', 'cakecious' ),
			'singular_name' => esc_attr__( 'Category', 'cakecious' ),
			'search_items'  => esc_attr__( 'Search Categories', 'cakecious' ),
			'all_items' => esc_attr__( 'All Categories', 'cakecious' ),
			'parent_item' => esc_attr__( 'Parent Category', 'cakecious' ),
			'parent_item_colon' => esc_attr__( 'Parent Category:', 'cakecious' ),
			'edit_item' => esc_attr__( 'Edit Category', 'cakecious' ),
			'update_item' => esc_attr__( 'Update Category', 'cakecious' ),
			'add_new_item' => esc_attr__( 'Add New Category', 'cakecious' ),
			'new_item_name' => esc_attr__( 'New Category Name', 'cakecious' ),
			'menu_name' => esc_attr__( 'Categories', 'cakecious' ),
		),
		'hierarchical' => true,
		'public' => true,
		'rewrite' => array(
			'slug' => $testimonial_cpt_cat_slug,
			'with_front' => $with_front
		),
	);

	// Apply filters
	$tax_args = apply_filters( 'tt_testimonial_cats_args', $tax_args );

	// Register Taxonomy
	register_taxonomy( 'tt_testimonial_cats', 'tt_testimonial', $tax_args );

} add_action( 'init', 'tt_testimonial_module_cpt' );



// Creating meta boxes for this CPT

/*-----------------------------------------------------------------------------------*/
/* CS meta boxes override                                                            */
/*-----------------------------------------------------------------------------------*/
// framework options filter example
if( !function_exists( 'tt_temptt_testimonial_metas_opt' )) {
	function tt_temptt_testimonial_metas_opt( $options ) {

// Lets create options that we will use mostly, in page, product, pages
	$tt_temptt_testimonial_meta =  array(
				// begin: a section
				array(
					'name'   => 'section_1',
					'title'  => 'General Settings',
					'icon'   => 'fa fa-cog',
					// begin: fields
					'fields' => array(
						array(
						  'type'    => 'notice',
						  'class'   => 'info',
						  'content' => 'The image for this item can be added from right side featured image block.',
						),
						array(
						  'id'      => '_single_testi_pos', // another unique id
						  'type'    => 'text',
						  'title'   => 'Position',
						  'desc'    => 'Designation/Position of the person.',
						 //'help'    => 'Write something',
						 //'default' => 'do stuff',
						),
						array(
						  'id'      => '_single_testi_company', // another unique id
						  'type'    => 'text',
						  'title'   => 'Company/Website Name',
						),
/*						array(
						  'id'        => '_single_item_layout',
						  'type'      => 'image_select',
						  'title'     => 'Item layout.',
						  'desc'      => 'Control the sidebar on this item single page. If you leave the first one selected, it will grab default setting for sidebar from Themeoptions/Layout.',
						  'options'   => array(
						    'layout-off'             => esc_url( trailingslashit( get_template_directory_uri() ) ) .'inc/images/layout-off.png',
						    'layout-right-content'   => esc_url( trailingslashit( get_template_directory_uri() ) ) .'inc/images/2cl.png',
						    'layout-left-content'    => esc_url( trailingslashit( get_template_directory_uri() ) ) .'inc/images/2cr.png',
						    'layout-full-content'    => esc_url( trailingslashit( get_template_directory_uri() ) ) .'inc/images/1col.png',
						  ),
						  'default'   => 'layout-off',
						),*/
						), // end: fields
				) // end: a section
	);

/* Start creating meta options. */

// -----------------------------------------
// Metabox Options                    -
// -----------------------------------------

		$options[] = array(
			'id'        => '_tt_meta_page_opt',
			'title'     => 'Testimonials Options',
			'post_type' => 'tt_testimonial',
			'context'   => 'normal',
			'priority'  => 'default',
			'sections'  => $tt_temptt_testimonial_meta

		);

		return $options;

	}

	add_filter( 'cs_metabox_options', 'tt_temptt_testimonial_metas_opt', 20 );

}


