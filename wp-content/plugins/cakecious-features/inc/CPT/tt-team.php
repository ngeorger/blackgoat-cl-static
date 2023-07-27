<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.


/**
 * Register Post Type and Taxonomies
 *
 * @since 1.0
 */
function tt_team_module_cpt() {

	$with_front = $team_cpt_slug = $team_cpt_cat_slug = $team_cpt_single = $single_args = '';

	if( function_exists( 'tt_temptt_get_option' ) ) {
		$with_front = tt_temptt_get_option( 'cpt_with_front', '0' );
		$team_cpt_slug = tt_temptt_get_option( 'team_cpt_slug', 'team-item' );
		$team_cpt_cat_slug = tt_temptt_get_option( 'team_cpt_cat_slug', 'team-cats' );
		$team_cpt_single = tt_temptt_get_option( 'team_cpt_single', true );
	}
	// With Front
	if ( ! empty ( $with_front )  ) $with_front = true; else $with_front = false;

	// Single page
	if ( ! empty ( $team_cpt_single )  ) { // single item true
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
			'name' => esc_attr__( 'Team', 'cakecious' ),
			'singular_name' => esc_attr__( 'Team', 'cakecious' ),
			'add_new' => esc_attr__( 'Add Team', 'cakecious' ),
			'add_new_item' => esc_attr__( 'Add Team', 'cakecious' ),
			'edit' => esc_attr__( 'Edit', 'cakecious' ),
			'edit_item' => esc_attr__( 'Edit Team', 'cakecious' ),
			'new_item' => esc_attr__( 'New Team', 'cakecious' ),
			'view' => esc_attr__( 'View Team', 'cakecious' ),
			'view_item' => esc_attr__( 'View Team', 'cakecious' ),
			'search_items' => esc_attr__( 'Search Team', 'cakecious' ),
			'not_found' => esc_attr__( 'No Team found', 'cakecious' ),
			'not_found_in_trash' => esc_attr__( 'No Team found in Trash', 'cakecious' ),
			'parent' => esc_attr__( 'Parent Team', 'cakecious' ),
		),
		'public' => true,
		'rewrite' => array( 'slug' => $team_cpt_slug, 'with_front' => $with_front ),
		'supports' => array( 'title', 'custom-fields', 'excerpt', 'editor', 'author', 'thumbnail', 'comments'  ),
	);

	// Single pages to be shown or not.
	$cpt_args = array_merge( $cpt_args, $single_args );

	// Apply filters
	$cpt_args = apply_filters( 'tt_team_cpt_args', $cpt_args );

	// Register Post Type
	register_post_type( 'tt_team', $cpt_args );

	/**
	 * Register Taxonomy ( Category )
	 */

	// Arguments
	$tax_args = array(
		'labels' => array(
			'name' => esc_attr__( 'Team Categories', 'cakecious' ),
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
			'slug' => $team_cpt_cat_slug,
			'with_front' => $with_front
		),
	);

	// Apply filters
	$tax_args = apply_filters( 'tt_team_cats_args', $tax_args );

	// Register Taxonomy
	register_taxonomy( 'tt_team_cats', 'tt_team', $tax_args );

} add_action( 'init', 'tt_team_module_cpt' );