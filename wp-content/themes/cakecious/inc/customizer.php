<?php
/**
 * cakecious Theme Customizer
 *
 * @package cakecious
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function cakecious_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

}
add_action( 'customize_register', 'cakecious_customize_register' );

function cakecious_theme_customize_register( $wp_customize ) {

    $wp_customize->add_section( 'cakecious_theme_slider_options', array(
        'title'          => esc_html__( 'Slider Settings', 'cakecious' )
    ) );

    $wp_customize->add_setting( 'cakecious_theme_slider_count_setting', array(
        'default'        => '1',
        'sanitize_callback' => 'absint'
    ) );

    $wp_customize->add_control( 'cakecious_theme_slider_count', array(
        'label'      => esc_html__( 'Number of slides displaying at once', 'cakecious' ),
        'section'    => 'cakecious_theme_slider_options',
        'type'       => 'text',
        'settings'   => 'cakecious_theme_slider_count_setting'
    ) );

    $wp_customize->add_setting( 'cakecious_theme_slider_time_setting', array(
        'default'        => '5000',
        'sanitize_callback' => 'absint'
    ) );

    $wp_customize->add_control( 'cakecious_theme_slider_time', array(
        'label'      => esc_html__( 'Slider Time (in ms)', 'cakecious' ),
        'section'    => 'cakecious_theme_slider_options',
        'type'       => 'text',
        'settings'   => 'cakecious_theme_slider_time_setting'
    ) );

    $wp_customize->add_setting( 'cakecious_theme_slider_loop_setting', array(
        'default'        => 'true',
        'sanitize_callback' => 'esc_textarea'
    ) );

    $wp_customize->add_control( 'cakecious_theme_loop', array(
        'label'      => esc_html__( 'Loop Slider Content', 'cakecious' ),
        'section'    => 'cakecious_theme_slider_options',
        'type'     => 'radio',
        'choices'  => array(
            'true'  => 'yes',
            'false' => 'no',
        ),
        'settings'   => 'cakecious_theme_slider_loop_setting'
    ) );

}
add_action( 'customize_register', 'cakecious_theme_customize_register' );



/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function cakecious_customize_preview_js() {
	wp_enqueue_script( 'cakecious_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'cakecious_customize_preview_js' );
