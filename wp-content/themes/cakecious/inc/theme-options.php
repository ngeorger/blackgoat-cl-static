<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* This file hooks the redux options panel. While Redux powered by TT FW plugin.
/*-----------------------------------------------------------------------------------*/


add_filter('redux/options/tt_temptt_opt/sections', 'cakecious_tt_redux_options');

if ( ! function_exists( 'cakecious_tt_redux_options' ) ) {
    function cakecious_tt_redux_options( $sections ) {

	//reset themeoptions array
    $sections = array();

	$shortname = 'tt';

    /*
     *
     * ---> START SECTIONS
     *
     */

/*-----------------------------------------------------------------------------------*/
/* General Settings                                                                  */
/*-----------------------------------------------------------------------------------*/

    $sections[] = array(
        'title'  => esc_html__( 'General Settings', 'cakecious' ),
        'id'     => 'general',
        'desc'   => esc_html__( 'General Settings.', 'cakecious' ),
        'customizer_width' => '400px',
    );
	// quick start.
    $sections[] = array(
        'title'            => esc_html__( 'Quick Start', 'cakecious' ),
        'id'               => 'general-quickstart',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(

            array(
                'id' => $shortname . '_welcome_info',
                'type'   => 'info',
                'notice' => false,
                'style'  => 'info',
                'desc'   =>  sprintf( esc_html__( 'Thanks for purchasing and installing this theme. From here you can customize almost everything in the theme. If you need help, please %1$s we will be more than happy to help. ', 'cakecious' ), '<a href="http://templatation.com/">' . esc_html__( 'contact support', 'cakecious' ) . '</a>' ),
            ),

            array(
                'id' => $shortname . '_use_logo',
                'type'     => 'switch',
                'default'  => true,
                'title'    => esc_html__( 'Use Logo', 'cakecious' ),
                'desc'     => esc_html__( 'If disabled, the default site title appears instead of logo. You can edit that title in Settings -> General.', 'cakecious' ),
            ),
            array(
                'id' => $shortname . '_logo',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Upload Main Logo', 'cakecious' ),
                'readonly'    => false,
                'subtitle'     => esc_html__( 'Upload a logo for your theme, or specify an image URL directly. ', 'cakecious' ),
                'desc' => esc_html__( 'If no logo uploaded, default logo appears. Default logo size is 157x68 px.', 'cakecious' ),
                'required' => array( $shortname . '_use_logo', '=', true )

            ),
            array(
                'id' => $shortname . '_logo2',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Upload Secondary Logo', 'cakecious' ),
                'readonly'    => false,
                'desc' => esc_html__( 'Some header type have different kind of logo. You can upload secondary logo if you want. It will be displayed on relevant header type. If you dont want different logo, please just reupload above logo here as well. Default logo size is 185x35 px.', 'cakecious' ),
                 'required' => array( $shortname . '_use_logo', '=', true )

            ),
           array(
                'id' => $shortname . '_enable_preloader',
                'type'     => 'switch',
                'title' => esc_html__( 'Enable Preloader', 'cakecious' ),
                'subtitle' => esc_html__( 'If enabled, website shows a preloader icon before the page loads.', 'cakecious' ),
                'default'  => true
           ),
           array(
                'id' => $shortname . '_enable_hdr_search',
                'type'     => 'switch',
                'title' => esc_html__( 'Enable Header Search', 'cakecious' ),
                'subtitle' => esc_html__( 'If enabled, search icon appears after the top menu bar.', 'cakecious' ),
                'default'  => true
           ),
           array(
                'id' => $shortname . '_hdr_searchCPT',
                'type'     => 'select',
                'title'    => esc_html__( 'Where to search', 'cakecious' ),
                'subtitle' => esc_html__( 'In header search, you can choose to search for Posts or Products.', 'cakecious' ),
                'desc'     => esc_html__( 'Default: Post.', 'cakecious' ),
				'options'  => array(
				        'post' => 'Post',
				        'product' => 'Product',
				),
				'default'  => 'post'
           ),
           array(
                'id' => $shortname . '_enable_hdr_cart',
                'type'     => 'switch',
                'title' => esc_html__( 'Enable Header Cart', 'cakecious' ),
                'subtitle' => esc_html__( 'If enabled, cart icon appears in the top menu bar.', 'cakecious' ),
                'default'  => true
           ),
           array(
                'id' => $shortname . '_enable_prod_sidebar',
                'type'     => 'switch',
                'title' => esc_html__( 'Enable Product Sidebar', 'cakecious' ),
                'subtitle' => esc_html__( 'By default, Sidebar on Single product page is disabled, check to enable. If enabled, the widgets placed in Shop sidebar will appear in single product page.', 'cakecious' ),
                'default'  => false
           ),
           array(
                'id' => $shortname . '_disable_hero_global',
                'type'     => 'switch',
                'title' => esc_html__( 'Disable Hero Title', 'cakecious' ),
                'subtitle' => esc_html__( 'The section that appear just below the header on pages, the hero section, displays page title by default. If you want image only Hero, turning on this option will remove Hero title globally.', 'cakecious' ),
                'default'  => false
           ),
         ),
);

$query['autofocus[section]'] = 'custom_css';
 $panel_link = add_query_arg( $query, admin_url( 'customize.php' ) );
    $sections[] = array(
        'title'            => esc_html__( 'Custom CSS', 'cakecious' ),
        'id'               => 'display-options',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id' => $shortname . '_cust_css2',
                'type'   => 'info',
                'notice' => false,
                'style'  => 'info',
                'title' => esc_html__( 'Custom Css', 'cakecious' ),
                'desc'   => sprintf( esc_html__( 'Now as WordPress customiser already has the feature to add Additional Css, to have things consolidated, please add css to Appearance -> Customise -> Additional CSS or go there by %s.', 'cakecious' ), '<a href="' . esc_url( $panel_link ).'">'.esc_html__( 'Clicking Here', 'cakecious' ).'</a>' ),
            ),
        )
    );


/*-----------------------------------------------------------------------------------*/
/* Style Settings                                                                  */
/*-----------------------------------------------------------------------------------*/

    $sections[] = array(
        'title'            => esc_html__( 'Styling', 'cakecious' ),
        'id'               => 'body-options',
        'customizer_width' => '450px',
        'icon'   => 'el el-icon-brush',
        'fields'           => array(

            array(
                'id' => $shortname . '_live_cust_info',
                'type'   => 'info',
                'notice' => false,
                'style'  => 'info',
                'title' => esc_html__( 'Live Customizer', 'cakecious' ),
                'desc'   =>  sprintf( esc_html__( 'Please note that theme main colors settings can also be done using Live customizer, you can see live preview if you use live customizer. %1$s.', 'cakecious' ), '<a href="' . esc_url( home_url('/') ) . 'wp-admin/customize.php">' . esc_html__( 'Go to Live Customer (Appearance-Customize) by clicking here', 'cakecious' ) . '</a>' ),
            ),
           array(
                'id' => $shortname . '_main_acnt_clr',
                'type'     => 'color',
                'title'    => esc_html__( 'Main Accent Color', 'cakecious' ),
                'subtitle' => esc_html__( 'Main accent color of the theme(The Orange tone color). Note: Some color are powered by page builder/images. Contact support if you need help.', 'cakecious' ),
                'desc'     => esc_html__( 'Default: leave blank.', 'cakecious' ),
                'default'  => ''
           ),
            array(
                'id' => $shortname . '_extreme_ft_bg',
                'type'     => 'background',
                'output'   => array( '.footer_area' ),
                'title'    => esc_html__( 'Footer Background', 'cakecious' ),
                'subtitle' => esc_html__( 'Select background image or color for footer area, where footer widget appears.', 'cakecious' ),
                //'default'   => '#FFFFFF',
            ),

            array(
                'id' => $shortname . '_body_typography',
                'output'   => array( 'body' ),
                'type'     => 'typography',
	            'font-backup' => false,
	            'line-height' => false,
	            'font-size' => false,
	            'font-weight' => false,
	            'font-style' => false,
                'title'    => esc_html__( 'Body Font', 'cakecious' ),
                'subtitle' => esc_html__( 'You can change the body font here. This is regular text font overall. Also a fallback font.', 'cakecious' ),
                //'default'   => '#FFFFFF',
            ),

            array(
                'id' => $shortname . '_h_typography',
                'type'     => 'typography',
	            'font-backup' => false,
	            'line-height' => false,
	            'font-size' => false,
	            'font-weight' => false,
	            'font-style' => false,
                'title'    => esc_html__( 'Heading Font', 'cakecious' ),
                'subtitle' => esc_html__( 'You can change the heading font here if you want to. Keep blank for default settings. The alternate demo has Playfair Display font and #3e606b color.', 'cakecious' ),
                //'default'   => '#FFFFFF',
            ),

            array(
                'id' => $shortname . '_cssi_info',
                'type'   => 'info',
                'notice' => false,
                'style'  => 'info',
                'title' => esc_html__( 'Further Styling Info', 'cakecious' ),
                'desc'   =>  sprintf( esc_html__( 'If you want to customise the theme further, eg more css edits or custom fonts. Its recommended that you use this plugin https://wordpress.org/plugins/easy-google-fonts/ for using other Google fonts and %1$s for deeper css customisation using point and click interface.', 'cakecious' ), '<a href="https://wordpress.org/plugins/so-css/">' . esc_html__( 'Site Origin CSS plugin', 'cakecious' ) . '</a>' ),
            ),

        )
        );

/*-----------------------------------------------------------------------------------*/
/* Layout Settings                                                                  */
/*-----------------------------------------------------------------------------------*/

    $sections[] = array(
        'title' => esc_html__( 'Layout (Header/Menu)', 'cakecious' ),
        'id'               => 'layout-options',
        'desc'   => esc_html__( 'Layout Settings for Sidebar and Header.', 'cakecious' ),
        'icon'   => 'el el-photo ',
        'customizer_width' => '400px',
        'fields'           => array(
            array(
                'id' => $shortname . '_header_layout',
                'type'     => 'image_select',
                'title' => esc_html__( 'Header/Menu Layout', 'cakecious' ),
                'desc' => esc_html__( 'Select header layout. ', 'cakecious' ),
                'subtitle' => esc_html__( 'Choose header layout. Note: This setting can be setup on per page basis too from page settings. For example, you can have Default header globally but can set header 2 on landing page for a new page. Demos for these headers can be seen in homepage variations of main demo, or you can just try them.', 'cakecious' ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    'default' => array(
                        'alt' => 'Default Header',
                        'img' => CAKECIOUS_THEME_DIRURI. 'inc/images/header1.png',
                        'title' => 'Default Header.'
                    ),
                    'header2' => array(
                        'alt' => 'Header Type 2',
                        'img' => CAKECIOUS_THEME_DIRURI. 'inc/images/header2.png',
                        'title' => 'Header Type 2.'
                    ),
                    'header3' => array(
                        'alt' => 'Header Type 3',
                        'img' => CAKECIOUS_THEME_DIRURI. 'inc/images/header3.png',
                        'title' => 'Header Type 3.'
                    ),
                    'header4' => array(
                        'alt' => 'Header Type 4',
                        'img' => CAKECIOUS_THEME_DIRURI. 'inc/images/header4.png',
                        'title' => 'Header Type 4.'
                    ),
                    'header5' => array(
                        'alt' => 'Header Type 5',
                        'img' => CAKECIOUS_THEME_DIRURI. 'inc/images/header5.png',
                        'title' => 'Header Type 5.'
                    ),
                ),
                'default'  => 'default'
            ),
            array(
                'id' => $shortname . '_spl_topbar',
                'type'     => 'switch',
                'title' => esc_html__( 'Special Topbar', 'cakecious' ),
                'subtitle' => esc_html__( 'Header 1, 2 and 5 has specially designed top bar, that appears above the header. If you want to use default topbar(controlled by settings found below this page) turn this off please. ( Recommended: on) .', 'cakecious' ),
                'desc' => esc_html__( 'Not applicable on header 3 and 4.', 'cakecious' ),
                'default'  => true
            ),

                array(
                    'id' => $shortname . '_header_call',
                    'type' => 'text',
                    'title' => esc_html__('Phone text', 'cakecious'),
                    'desc' => esc_html__('This text appears below the phone number in right side of header. The phone number can be put in Social / Contact Settings tab of this panel.', 'cakecious'),
                    'default' => 'Toll Free',
                    'required' => array(
                                    array( $shortname . '_header_layout', '=', 'header3' ),
                                ),
                ),
                array(
                    'id' => $shortname . '_header_btn',
                    'type' => 'text',
                    'title' => esc_html__('Button text', 'cakecious'),
                    'desc' => esc_html__('This text appears on right side button that appears in menu bar. Keep blank to disable button.', 'cakecious'),
                    'default' => 'Request Call Back',
                    'required' => array(
                                    array( $shortname . '_header_layout', '=', 'header3' ),
                                ),
                ),
                array(
                    'id' => $shortname . '_header_link',
                    'type' => 'text',
                    'title' => esc_html__('Button link', 'cakecious'),
                    'desc' => esc_html__('This link gets applied on above text/button.', 'cakecious'),
                    'default' => '#',
                    'required' => array(
                                    array( $shortname . '_header_layout', '=', 'header3' ),
                                ),
                ),
           array(
                'id' => $shortname . '_js_topbar_notice',
                'type'   => 'info',
                'notice' => false,
                'style'  => 'info',
                'title' => esc_html__( 'Toppest Bar Settings', 'cakecious' ),
                'desc'   => esc_html__( 'Below settings are for the top most navigation bar which is optional. It adds some usual user interface items. There is limited space on this bar , so be careful in choosing what part you really need. You can try it out and disable things later if bar goes out of space. Note: Top nav background color can be changed from Styling tab.', 'cakecious' )
           ),
           array(
                'id' => $shortname . '_enable_topbar',
                'type'     => 'switch',
                'title' => esc_html__( 'Enable Top Nav Bar', 'cakecious' ),
                'subtitle' => esc_html__( 'Enable/Disable the Top most nav bar globally.', 'cakecious' ),
                'default'  => true
           ),
            array(
    			'id' => $shortname . '_top_nav_left_layout',
                'type'     => 'sorter',
                'title'    => 'Top nav left content',
                'subtitle' => 'You can place content as you want, on left side of the top nav. Sort them, or disable by moving them back to Available column. Note that here you can only enable/disable/sort them, their actual content can be controlled from the options below. Note: Email/phone to be entered in Social/contact setting below. ',
                'compiler' => 'true',
                'options'  => array(
                    'enabled'  => array(
                        'email'     => 'Email',
                        'phone'   => 'Phone',
                    ),
                    'disabled' => array(
                        'teaser_text'   => 'Text',
                        'social'   => 'Social Icons',
                        'spacer'   => 'Blank Space',
                        'spacer2'   => 'Blank Space 2',
                    ),
                ),
                'required' => array( $shortname . '_enable_topbar', '=', true )
            ),
            array(
    			'id' => $shortname . '_top_nav_right_layout',
                'type'     => 'sorter',
                'title'    => 'Top nav right content',
                'subtitle' => 'You can place content as you want, on right side of the top nav. Sort them, or disable by moving them back to Available column. Note that here you can only enable/disable/sort them, their actual content can be controlled from the options below. Note: Email/phone to be entered in Social/contact setting below. ',
                'compiler' => 'true',
                'options'  => array(
                    'enabled'  => array(
                        'social'   => 'Social Icons',

                    ),
                    'disabled' => array(
                        'email'     => 'Email',
                        'phone'   => 'Phone',
                        'teaser_text'   => 'Text',
                        'wpml_lang'   => 'WPML Languages',
                        'spacer'   => 'Blank Space',
                        'spacer2'   => 'Blank Space 2',
                    ),
                ),
                'required' => array( $shortname . '_enable_topbar', '=', true )
            ),

           array(
                'id' => $shortname . '_ttext_text',
                'type'     => 'text',
                'title' => esc_html__( 'Teaser Text', 'cakecious' ),
                'subtitle' => esc_html__( 'Teaser text is short sentence that you want to highlight. eg : Our helpline number : xyz. This text appears on left most side of top bar.', 'cakecious' ),
                'required' => array( $shortname . '_enable_topbar', '=', true ),
	            'default' => 'We are serving since 1992 at Losangle'
           ),
            array(
                'id'       => $shortname . '_global_herobg',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Hero area Global background', 'cakecious' ),
                'readonly' => false,
                'subtitle' => esc_html__( 'In this theme, heading area of page shows Hero section, which has an image in background. You can set that background image on per page basis. But choose one global image here which applies by default.', 'cakecious' ),
            ),
        )
    );

/*-----------------------------------------------------------------------------------*/
/* Footer Settings                                                                  */
/*-----------------------------------------------------------------------------------*/

    $sections[] = array(
        'title' => esc_html__( 'Footer Customization', 'cakecious' ),
        'id'               => 'footer-settings1',
        'customizer_width' => '450px',
        'fields'           => array(


           array(
                'id' => $shortname . '_extreme_footer_notice',
                'type'   => 'info',
                'notice' => false,
                'style'  => 'info',
                'title' => esc_html__( 'Footer area customization', 'cakecious' ),
                'desc'   => esc_html__( 'Customize footer area here. Note: Background colors for footer areas can be changed from Styling tab.', 'cakecious' )
           ),
            array(
                'id' => $shortname . '_footer_newsletter_start',
                'type'     => 'section',
                'title'    => esc_html__( 'Footer Newsletter Section', 'cakecious' ),
                'subtitle' => esc_html__( 'If you want to have newsletter in the footer, please do required here.',  'cakecious' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
           array(
                'id' => $shortname . '_footer_newsletter',
                'type'     => 'switch',
                'title' => esc_html__( 'Enable Footer newsletter', 'cakecious' ),
                'default'  => false,
            ),
            array(
                'id' => $shortname . '_ft_newsletter_title',
                'type'     => 'text',
                'title' => esc_html__( 'Newsletter Title', 'cakecious' ),
                'default'  => '',
                'required' => array( $shortname . '_footer_newsletter', '=', true )
            ),
           array(
                'id' => $shortname . '_footer_newsletter_code',
                'type'     => 'textarea',
                'title' => esc_html__( 'Enter your mailchimp code.. ', 'cakecious' ),
                'subtitle' => esc_html__( 'You can get it from Mailchimp list > Signup forms > Embedded Forms > Naked. Please make sure to check the Only Required Fields only checkbox on left, And then copy the code provided on bottom right of page please.', 'cakecious' ),
                'default'  => '',
                'required' => array( $shortname . '_footer_newsletter', '=', true )
           ),
            array(
                'id' => $shortname . '_footer_enable_clr',
                'type'     => 'switch',
                'title' => esc_html__( 'Enable Colored Background.', 'cakecious' ),
                'subtitle' => esc_html__( 'This setting can also be overridden for particular page from the Page editor bottom section.', 'cakecious' ),
                 'default'  => false,
                'required' => array( $shortname . '_footer_newsletter', '=', true )
            ),
            array(
                'id' => $shortname . '_footer_newsletter_end',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),


           array(
                'id' => $shortname . '_footer_sidebars',
                'type'     => 'image_select',
                'title' => esc_html__( 'Footer Widget Areas', 'cakecious' ),
                'subtitle' => esc_html__( 'Select how many footer widget areas you want to display.', 'cakecious' ),
                'desc'     => esc_html__( 'Select default sidebar position for the website. Note: The last option is theme specific layout(if applicable).)', 'cakecious' ),
                //Must provide key => value(array:title|img) pairs for radio options
                'options'  => array(
                    '0' => array(
                        'img' => CAKECIOUS_THEME_DIRURI .'inc/images/footer-widgets-0.png',
                    ),
                    '1' => array(
                        'img' => CAKECIOUS_THEME_DIRURI .'inc/images/footer-widgets-1.png',
                    ),
                    '2' => array(
                        'img' => CAKECIOUS_THEME_DIRURI .'inc/images/footer-widgets-2.png',
                    ),
                    '3' => array(
                        'img' => CAKECIOUS_THEME_DIRURI .'inc/images/footer-widgets-3.png',
                    ),
                    '4' => array(
                        'img' => CAKECIOUS_THEME_DIRURI .'inc/images/footer-widgets-4.png',
                    ),
                ),
                'default'  => '4'
           ),

           array(
                'id' => $shortname . '_footer_left',
                'type'     => 'switch',
                'title' => esc_html__( 'Enable Custom Footer', 'cakecious' ),
                'subtitle' => esc_html__( 'Activate to add the custom text below to the theme footer.', 'cakecious' ),
                'desc'   => esc_html__( 'If turned off, default text will appear.', 'cakecious' ),
                'default'  => false,
            ),

           array(
                'id' => $shortname . '_footer_left_text',
                'type'     => 'textarea',
                'title' => esc_html__( 'Custom Text ', 'cakecious' ),
                'subtitle' => esc_html__( 'Custom HTML and Text that will appear in the extreme footer of your theme.', 'cakecious' ),
                'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                'default'  => '',
           ),
           array(
                'id' => $shortname . '_footer_right',
                'type'     => 'switch',
                'title' => esc_html__( 'Enable Custom Footer (Right)', 'cakecious' ),
                'subtitle' => esc_html__( 'Activate to add the custom text below to the theme footer.', 'cakecious' ),
                'desc'   => esc_html__( 'If turned off, default text will appear.', 'cakecious' ),
                'default'  => false
           ),

           array(
                'id' => $shortname . '_footer_right_text',
                'type'     => 'textarea',
                'title' => esc_html__( 'Custom Text (Right)', 'cakecious' ),
                'subtitle' => esc_html__( 'Custom HTML and Text that will appear in the lower footer of your theme.', 'cakecious' ),
                'validate' => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                'default'  => ''
           ),


        )
    );

/*-----------------------------------------------------------------------------------*/
/* Social Settings                                                                  */
/*-----------------------------------------------------------------------------------*/

    $sections[] = array(
        'title' => esc_html__( 'Social / Contact Settings', 'cakecious' ),
        'id'               => 'connect-settings',
        'customizer_width' => '450px',
        'fields'           => array(

            array(
                'id' => $shortname . '_contact_number',
                'type'     => 'text',
                'title' => esc_html__( 'Telephone', 'cakecious' ),
                'subtitle' => esc_html__( 'Enter your telephone number', 'cakecious' ),
                'default'  => '000-111-222',
            ),
            array(
                'id' => $shortname.'_contactform_email',
                'type'     => 'text',
                'title' => esc_html__( 'Contact Form E-Mail', 'cakecious' ),
                'subtitle' => esc_html__( "Enter your E-mail address to use on the 'Contact Form' page Template.", 'cakecious' ),
                'default'  => 'example@example.com',
            ),
            array(
                'id' => $shortname . '_connect_rss',
                'type'     => 'switch',
                'title' => esc_html__( 'Enable RSS', 'cakecious' ),
                'subtitle' => esc_html__( 'Enable the subscribe and RSS icon.', 'cakecious' ),
                 'default'  => false
            ),
            array(
                'id' => $shortname . '_connect_twitter',
                'type'     => 'text',
                'title' => esc_html__( 'Twitter URL', 'cakecious' ),
                'subtitle' => sprintf( esc_html__( 'Enter your %1$s URL e.g. http://www.twitter.com/templatation', 'cakecious' ), '<a href="http://www.twitter.com/">'.esc_html__( 'Twitter', 'cakecious' ).'</a>' ),
                'default'  => '#',
            ),
            array(
                'id' => $shortname . '_connect_facebook',
                'type'     => 'text',
                'title' => esc_html__( 'Facebook URL', 'cakecious' ),
                'subtitle' => sprintf( esc_html__( 'Enter your %1$s URL e.g. http://www.facebook.com/templatation', 'cakecious' ), '<a href="http://www.facebook.com/">'.esc_html__( 'Facebook', 'cakecious' ).'</a>' ),
                'default'  => '#',
            ),
            array(
                'id' => $shortname . '_connect_youtube',
                'type'     => 'text',
                'title' => esc_html__( 'YouTube URL', 'cakecious' ),
                'subtitle' => sprintf( esc_html__( 'Enter your %1$s URL e.g. http://www.youtube.com/templatation', 'cakecious' ), '<a href="http://www.youtube.com/">'.esc_html__( 'YouTube', 'cakecious' ).'</a>' ),
                'default'  => '',
            ),
            array(
                'id' => $shortname . '_connect_flickr',
                'type'     => 'text',
                'title' => esc_html__( 'Flickr URL', 'cakecious' ),
                'subtitle' => sprintf( esc_html__( 'Enter your %1$s URL e.g. http://www.flickr.com/templatation', 'cakecious' ), '<a href="http://www.flickr.com/">'.esc_html__( 'Flickr', 'cakecious' ).'</a>' ),
                'default'  => '',
            ),
            array(
                'id' => $shortname . '_connect_linkedin',
                'type'     => 'text',
                'title' => esc_html__( 'LinkedIn URL', 'cakecious' ),
                'subtitle' => sprintf( esc_html__( 'Enter your %1$s URL e.g. http://www.linkedin.com/in/templatation', 'cakecious' ), '<a href="http://www.www.linkedin.com.com/">'.esc_html__( 'LinkedIn', 'cakecious' ).'</a>' ),
                'default'  => '',
            ),
            array(
                'id' => $shortname . '_connect_pinterest',
                'type'     => 'text',
                'title' => esc_html__( 'Pinterest URL', 'cakecious' ),
                'subtitle' => sprintf( esc_html__( 'Enter your %1$s URL e.g. http://www.pinterest.com/templatation', 'cakecious' ), '<a href="http://www.pinterest.com/">'.esc_html__( 'Pinterest', 'cakecious' ).'</a>' ),
                'default'  => '#',
            ),
            array(
                'id' => $shortname . '_connect_instagram',
                'type'     => 'text',
                'title' => esc_html__( 'Instagram URL', 'cakecious' ),
                'subtitle' => sprintf( esc_html__( 'Enter your %1$s URL e.g. http://www.instagram.com/templatation', 'cakecious' ), '<a href="http://www.instagram.com/">'.esc_html__( 'Instagram', 'cakecious' ).'</a>' ),
                'default'  => '#',
            ),
            array(
                'id' => $shortname . '_connect_googleplus',
                'type'     => 'text',
                'title' => esc_html__( 'Google+ URL', 'cakecious' ),
                'subtitle' => sprintf( esc_html__( 'Enter your %1$s URL e.g. https://plus.google.com/104560124403688998123/', 'cakecious' ), '<a href="http://plus.google.com/">'.esc_html__( 'Google+', 'cakecious' ).'</a>' ),
                'default'  => '',
            ),
            array(
                'id' => $shortname . '_social_custom_start',
                'type'     => 'section',
                'title'    => esc_html__( 'Custom social icons', 'cakecious' ),
                'subtitle' => esc_html__( 'If you want to have any other icon thats not listed above, use this section please. You can add 2 custom icons as of now.',  'cakecious' ),
                'indent'   => true, // Indent all options below until the next 'section' option is set.
            ),
           array(
                'id' => $shortname . '_enable_social_custom',
                'type'     => 'switch',
                'title' => esc_html__( 'Enable custom icon', 'cakecious' ),
                'default'  => false,
            ),
            array(
                'id' => $shortname . '_connect_custom_name',
                'type'     => 'text',
                'title' => esc_html__( 'Social icon name. eg Yelp.', 'cakecious' ),
                'default'  => '',
                'required' => array( $shortname . '_enable_social_custom', '=', true )
            ),
            array(
                'id' => $shortname . '_connect_custom_link',
                'type'     => 'text',
                'title' => esc_html__( 'Social icon link. eg http://www.yelp.com/templatation.', 'cakecious' ),
                'default'  => '',
                'required' => array( $shortname . '_enable_social_custom', '=', true )
            ),
            array(
                'id' => $shortname . '_connect_custom_icon',
                'type'     => 'text',
                'title' => esc_html__( 'Social icon code for Fontawesome. eg fa-yelp. Find all icons here  https://fontawesome.com/icons ', 'cakecious' ),
                'default'  => '',
                'required' => array( $shortname . '_enable_social_custom', '=', true )
            ),
            array(
                'id' => $shortname . '_connect_custom_name2',
                'type'     => 'text',
                'title' => esc_html__( 'Social icon name 2. eg Yelp.', 'cakecious' ),
                'default'  => '',
                'required' => array( $shortname . '_enable_social_custom', '=', true )
            ),
            array(
                'id' => $shortname . '_connect_custom_link2',
                'type'     => 'text',
                'title' => esc_html__( 'Social icon link 2. eg http://www.yelp.com/templatation.', 'cakecious' ),
                'default'  => '',
                'required' => array( $shortname . '_enable_social_custom', '=', true )
            ),
            array(
                'id' => $shortname . '_connect_custom_icon2',
                'type'     => 'text',
                'title' => esc_html__( 'Social icon code for icon 2 Fontawesome. eg fa-yelp. Find all icons here  https://fontawesome.com/icons ', 'cakecious' ),
                'default'  => '',
                'required' => array( $shortname . '_enable_social_custom', '=', true )
            ),
            array(
                'id' => $shortname . '_social_custom_start',
                'type'   => 'section',
                'indent' => false, // Indent all options below until the next 'section' option is set.
            ),
            array(
                'id' => $shortname . '_open_social_newtab',
                'type'     => 'switch',
                'title' => esc_html__( 'Open in New tab', 'cakecious' ),
                'subtitle' => esc_html__( 'If this is turned on, the social icon links open in new tab instead of same window.', 'cakecious' ),
                 'default'  => false
            ),
        )
    );

/*-----------------------------------------------------------------------------------*/
/* Included Plugins / Theme updates                                                  */
/*-----------------------------------------------------------------------------------*/

   $sections[] = array(
        'title' => esc_html__( 'Included Plugins', 'cakecious' ),
        'id'               => 'included-plugins',
        'customizer_width' => '450px',
        'fields'           => array(

            array(
                'id' => $shortname . '_inc_plugins',
                'type'   => 'info',
                'notice' => false,
                'style'  => 'info',
                'title' => esc_html__( 'Included Plugins', 'cakecious' ),
                'desc'   => sprintf( esc_html__( 'The theme requires/recommends some plugin to function properly. Theme also includes some premium plugins with your purchase, to manage plugins, please go to Appearance -> Install plugins. Note: The menu only appears if all required plugins are not activated. So not to worry if you do not find that menu link.', 'cakecious' ), '<a href="' . esc_url( home_url('/') ) . 'wp-admin/themes.php?page=tgmpa-install-plugins">'.esc_html__( 'Click Here', 'cakecious' ).'</a>' ),
            ),
        )
    );

   $sections[] = array(
        'title'  => esc_html__( 'Theme Updates', 'cakecious' ),
        'id'     => 'theme-update',
        'icon'   => 'el el-refresh',
        'customizer_width' => '450px',
        'fields' => array(

            array(
                'id' => $shortname . '_theme_update',
                'type'   => 'info',
                'notice' => false,
                'style'  => 'info',
                'title' => esc_html__( 'Theme Update', 'cakecious' ),
                'desc'   => sprintf( esc_html__( 'The theme is regularly updated with new features and other bug fixes and improvement. You can activate Envato plugin for hassle free theme updates whenever update is available without having to download from Themeforest. Note if you modified any theme files, it will be overwritten with update. Again, make sure to keep regular backups. You can use awesome free plugin named %1$s  to create backups periodically(automatically) without hassles.', 'cakecious' ), '<a href="https://wordpress.org/plugins/updraftplus/">'.esc_html__( 'UpdraftPlus', 'cakecious' ).'</a>' ),
            ),
            array(
                'id' => $shortname . '_theme_update3',
                'type'   => 'info',
                'notice' => false,
                'style'  => 'info',
                'title' => esc_html__( 'Step by Step instruction to setup easy updates.', 'cakecious' ),
                'desc'   => sprintf( esc_html__( 'Please %1s for complete instruction to setup the updater plugin and update easily in future.', 'cakecious' ), '<a href="http://kb.templatation.com/article/35-how-to-update-the-theme">'.esc_html__( 'Click Here', 'cakecious' ).'</a>' ),
            )
        )
    );



    return $sections;

    }
}

