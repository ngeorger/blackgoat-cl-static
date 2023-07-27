<?php
/**
 * Declaring widgets
 *
 *
 * @package cakecious
 */
function cakecious_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar ( Default )', 'cakecious' ),
		'id'            => 'default-sidebar',
		'description'   => esc_html__( 'Sidebar widget area.', 'cakecious' ),
		'before_widget' => '<aside id="%1$s" class="r_widget widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="r_title"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'cakecious' ),
		'id'            => 'shop',
		'description'   => esc_html__( 'This sidebar appears on Shop page.', 'cakecious' ),
		'before_widget' => '<aside id="%1$s" class="r_widget widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="r_title"><h3 class="widget-title">',
		'after_title'   => '</h3></div>',
	) );


    // Footer widgetized areas
	$total = cakecious_fw_get_option( 'footer_sidebars', 4 );
	if ( ! $total ) $total = 4;
	for ( $i = 1; $i <= intval( $total ); $i++ ) {
			register_sidebar( array(
				 'name'          => sprintf( esc_html__( 'Footer %d', 'cakecious' ), $i ),
                 'id'            => sprintf( 'footer-%d', $i ),
                 'description'   => sprintf( esc_html__( 'Widgetized Footer Region %d.', 'cakecious' ), $i ),
                 'before_widget' => '<div id="%1$s" class="quick f_widget widget %2$s">',
                 'after_widget'  => '</div>',
                 'before_title'  => '<div class="f_title"><h3>',
                 'after_title'   => '</h3></div>'
			) );
		}

}
add_action( 'widgets_init', 'cakecious_widgets_init' );