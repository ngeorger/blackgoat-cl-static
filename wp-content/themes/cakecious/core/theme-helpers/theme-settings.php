<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* Theme Settings! */
/*-----------------------------------------------------------------------------------*/

add_action( 'customize_register', 'cakecious_general_settings' );

if( ! function_exists( 'cakecious_general_settings' ) ) {

function cakecious_general_settings( $wp_customize ) {

		if( class_exists( 'Cakecious_Customizer' ) ) {

			/* Section General Settings */
			$wp_customize->add_section( 'cakecious_section_general_settings', array(
			    'title'       => esc_html__( 'General Cakecious Settings', 'cakecious' ),
			    'description' => '<p>' . esc_html__( 'Some additional header options.', 'cakecious' ) . '</p>',
			    'priority'    => 1,
			) );
			$section = 'cakecious_section_general_settings';


// Accent Colors
$key = 'custom_color';
// Heading
$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, $key.'cakecious_title', array(
	'section'     => $section,
	'settings'    => array(),
	'label'       => esc_html__( 'Cakecious Color settings', 'cakecious' ),
) ) );
// Notice Dynamic Page Settings
$wp_customize->add_control( new Cakecious_Customize_Control_Blank( $wp_customize, $section.'_notice', array(
	'section'     => $section,
	'settings'    => array(),
	'description' => '<div class="notice notice-info notice-alt inline"><p>' . sprintf(
		/* translators: %1$s: section name, %2$s: link to Dynamic Page Settings. */
			esc_html__( 'Please note most colors are powered by Images, Elementor or Other settings in this customizer, and can be changed from there respective places.', 'cakecious' )
		) . '</p></div>',
) ) );
$cakecious_colors = array(
	'cakecious_accent_color'    => array (
									esc_html__( 'Cakecious Main color', 'cakecious' ),
									esc_html__( 'Main color, used on most of the places.', 'cakecious' )
								),
	'cakecious_secondary_color_lighter'    => array (
									esc_html__( 'Cakecious Icon hover color', 'cakecious' ),
									esc_html__( 'A bit dark ton of Secondary color recommended.', 'cakecious' )
								)
);
foreach ( $cakecious_colors as $key => $label ) {
	$wp_customize->add_setting( $key, array(
		'default'     => '',
		'transport'   => 'postMessage',
		'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'color' ),
	) );
	$wp_customize->add_control( new Cakecious_Customize_Control_Color( $wp_customize, $key, array(
		'section'     => $section,
		'label'       => $label['0'],
		'description' => $label['1']
	) ) );
}


			// Custom products look settings
			$key = 'custom_prod_loop';
			// Heading
			$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, $key.'cakecious_title', array(
				'section'     => $section,
				'settings'    => array(),
				'label'       => esc_html__( 'Cakecious Product settings', 'cakecious' ),
			) ) );
			$wp_customize->add_setting( $key, array(
				'default'     => '',
				'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
			) );
			$wp_customize->add_control( $key, array(
				'type'        => 'select',
				'section'     => $section,
				'label'       => esc_html__( 'Cakecious Product Layout.', 'cakecious' ),
				'description'       => esc_html__( 'Please note that all other WC product settings, found in other setting panels will not work if you choose Cakecious special layout here. Cakecious has some special Product layout. In case you want flexibility to change the product block details from Woocommerce panel in this customzer, switch to Default here. Recommended: Cakecious Special', 'cakecious' ),
				'default'       => 'cakecious_special',
				'choices'     => array(
					'cakecious_special'    => esc_html__( 'Cakecious Special', 'cakecious' ),
					'default'           => esc_html__( 'Default', 'cakecious' ),
				),
			) );

			// Single blog social share.
			$key = 'single_blog_share';
			$wp_customize->add_control( new Cakecious_Customize_Control_Heading( $wp_customize, $key.'cakecious_title', array(
				'section'     => $section,
				'settings'    => array(),
				'label'       => esc_html__( 'Single Post Share', 'cakecious' ),
			) ) );
			$wp_customize->add_setting( $key, array(
				'default'     => false,
				'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'toggle' ),
			) );
			$wp_customize->add_control( new Cakecious_Customize_Control_Toggle( $wp_customize, $key, array(
				'section'     => $section,
				'label'       => esc_html__( 'Single Post Share', 'cakecious' ),
				'description' => esc_html__( 'Enable post sharing on Single post.', 'cakecious' ),
			) ) );

			
/* Footer settings */
/* Footer image BG */
$panel = 'cakecious_panel_footer';
$section = 'cakecious_section_footer_widgets_bar';
$key = 'custom_ft_bg';
$wp_customize->add_setting( $key, array(
	'default'     => '',
	'sanitize_callback' => 'absint',
) );
$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $key, array(
	'section'     => $section,
	'label'       => esc_html__( 'Custom BG image', 'cakecious' ),
	'description' => esc_html__( 'Upload footer BG image, if you want to.', 'cakecious' ),
	'mime_type'   => 'image',
) ) );
/* Footer newsletter */
$section    = '';
$section    = 'cakecious_section_footer_top';
// Footer Builder
$wp_customize->add_section( $section, array(
    'title'    => esc_html__( 'Footer Top', 'cakecious' ),
    'panel'    => $panel,
    'priority' => 10,
) );

			// Select footer newsletter
			$key = 'footer_newsletter';
			$wp_customize->add_setting( $key, array(
				'default'     => '',
				'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'select' ),
			) );
			$wp_customize->add_control( $key, array(
				'type'        => 'select',
				'section'     => $section,
				'label'       => esc_html__( 'Enable footer newseletter', 'cakecious' ),
				'description' => esc_html__( 'If you want to have newsletter in the footer, please do required here.', 'cakecious' ),
				'choices'     => array(
					'no'  => esc_html__( 'No', 'cakecious' ),
					'yes' => esc_html__( 'Yes', 'cakecious' ),
				),
			) );
			// Newsletter title
			$key = 'newsletter_title1';
			$wp_customize->add_setting( $key, array(
				'default'     => '',
				'sanitize_callback' => array( 'Cakecious_Customizer_Sanitization', 'text' ),
			) );
			$wp_customize->add_control( $key, array(
				'section'     => $section,
				'label'       => esc_html__( 'Newsletter Title', 'cakecious' ),
				'input_attrs' => array(
					'placeholder' => esc_html__( 'Signup to our', 'cakecious' ),
				),
			) );
			// Newsletter content
			$key = 'newsletter_content';
			$wp_customize->add_setting( $key, array(
				'default'     => '',
				'transport'   => 'postMessage',
				'sanitize_callback' => false,
			) );
			$wp_customize->add_control( $key, array(
				'type'        => 'textarea',
				'section'     => $section,
				'label' => esc_html__( 'Enter your mailchimp code.', 'cakecious' ),
				'description' => esc_html__( 'You can get it from Mailchimp list > Signup forms > Embedded Forms > Naked. Please make sure to check the Only Required Fields only checkbox on left, And then copy the code provided on bottom right of page please.', 'cakecious' ),
				'priority'    => 10,
			) );

		}

	}

}