<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------*/
/* This file hooks the metaboxes to Metabox system powered by TT FW plugin.
/*-----------------------------------------------------------------------------------*/

// remove metaoptions for CPT from the plugin.
remove_filter( 'cs_metabox_options', 'tt_temptt_team_metas_opt', 20 ); // remove the plugin team opts, if exists.
remove_filter( 'cs_metabox_options', 'tt_temptt_portfolio_metas_opt', 20 ); // remove the plugin team opts, if exists.

/*-----------------------------------------------------------------------------------*/
/* CS meta boxes override                                                            */
/*-----------------------------------------------------------------------------------*/
// framework options filter example
if( !function_exists( 'cakecious_fw_metas_opt' )) {
	function cakecious_fw_metas_opt( $options ) {



// Lets create options that we will use mostly, in page, product, pages
	$cakecious_fw_default_meta =  array(

				// begin: a section
				array(
					'name'   => 'section_1',
					'title'  => 'General Settings',
					'icon'   => 'fa fa-cog',
					// begin: fields
					'fields' => array(
						array(
						  'id'    => '_hide_title_display',
						  'type'  => 'switcher',
						  'title' => esc_html__( 'Hide default title display in middle content area.', 'cakecious' ),
						  'label'  => esc_html__( 'In some case, you might want to hide the default title display. Check this to hide title. If you are not sure about it  leave it unchecked. This does not apply if you enable Hero Section for this page.', 'cakecious' ),
						  'default' => false
						),
						array(
						  'id'    => '_single_no_tpad',
						  'type'  => 'switcher',
						  'title' => esc_html__( 'Disable top padding.', 'cakecious' ),
						  'label'  => esc_html__( 'By default there is padding on top before the content area starts. Disable it here if you want to.', 'cakecious' ),
						  'default' => false,
						),
						array(
						  'id'    => '_single_no_bpad',
						  'type'  => 'switcher',
						  'title' => esc_html__( 'Disable bottom padding.', 'cakecious' ),
						  'label'  => esc_html__( 'By default there is padding on bottom before the footer area starts. Disable it here if you want to. Note: The top padding applies only when you disable Hero area, so that option is in Hero Area section, seen when you disable Hero Image.', 'cakecious' ),
						  'default' => false,
						),
						array(
						  'id'       => '_single_ft_newsletter',
						  'type'     => 'select',
						  'title' => esc_html__( 'Footer newsletter type.', 'cakecious' ),
						  'desc' => esc_html__( 'This overrides the global setting done on Themeoptions for footer newsletter type. By default footer newsletter appears in transparent bg. You can select colored background version here..', 'cakecious' ),
						  'options'  => array(
						    'nochange'       => esc_html__( 'As set in Themeoptions', 'cakecious' ),
						    'gray_bg'        => esc_html__( 'Transparent', 'cakecious' ),
						    'colored'        => esc_html__( 'Colored', 'cakecious' ),
						    'none'        => esc_html__( 'Do not display', 'cakecious' ),
						  ),
						  'default'  => 'nochange',
						),
						array(
						  'id'    => '_single_hero_breadcrumbs',
						  'type'  => 'switcher',
						  'title' => esc_html__( 'Insert breadcrumbs in Hero section.', 'cakecious' ),
						  'label'  => esc_html__( 'Insert breadcrumb in this area. Note: Breadcrumb Trail plugin must be active.', 'cakecious' ),
						  'default' => true,
						),


					), // end: fields
				), // end: a section

				// begin: a section
				array(
					'name'   => 'section_2',
					'title'  => 'Header Settings',
					'icon'   => 'fa fa-cog',
					// begin: fields
					'fields' => array(

						array(
						  'id'       => '_single_hdr_type',
						  'type'     => 'select',
						  'title' => esc_html__( 'Select header type.', 'cakecious' ),
						  'desc' => esc_html__( 'This overrides the global setting done on Themeoptions for this page. Demos for these headers can be seen in homepage variations of main demo, or you can just try them.', 'cakecious' ),
						  'options'  => array(
						    'nochange'        => esc_html__( 'As set in Themeoptions', 'cakecious' ),
						    'default'         => esc_html__( 'Default header', 'cakecious' ),
						    'header2'         => esc_html__( 'Header Type 2', 'cakecious' ),
						    'header3'         => esc_html__( 'Header Type 3', 'cakecious' ),
						    'header4'         => esc_html__( 'Header Type 4', 'cakecious' ),
						    'header5'         => esc_html__( 'Header Type 5', 'cakecious' ),
						  ),
						  'default'  => 'nochange',
						),


					), // end: fields
				), // end: a section

				array(
					'name'   => 'section_3',
					'title'  => 'Hero Section',
					'icon'   => 'fa fa-cog',
					// begin: fields
					'fields' => array(

						array(
							'id'      => '_single_enable_headline',
							'type'    => 'switcher',
							'title'   => esc_html__( 'Enable Hero section on this page', 'cakecious' ),
							'label'   => esc_html__( 'Hero section appears after header and before content area. Note: Hero section is full liquid width. If you want boxed Hero section, use page composer to build it please. Note: Page builder plugin must be active for Hero section to work.', 'cakecious' ),
							'default' => true
						),
						array(
							'id'         => '_single_headline_title',
							'type'       => 'text',
							'title'      => esc_html__( 'Main Title.', 'cakecious' ),
							'desc'      => esc_html__( 'Appears as highlight text in Hero section. If left blank, displays page title as default. If you want to show nothing, check below please.', 'cakecious' ),
							'dependency' => array( '_single_enable_headline', '==', 'true' ),
						),
						array(
							'id'      => '_single_enable_notitle',
							'type'    => 'switcher',
							'title'   => esc_html__( 'Hide Title', 'cakecious' ),
							'label'   => esc_html__( 'At times, you might want just to display the image in Hero section without any title displayed on it. Enable this button to disable any title text over the Hero section image.', 'cakecious' ),
							'default' => false
						),
						array(
							'id'         => '_single_headline_desc',
							'type'       => 'textarea',
							'title'      => esc_html__( 'Description(Optional).', 'cakecious' ),
							'desc'      => esc_html__( 'Appears below highlight text in Hero section.', 'cakecious' ),
							'dependency' => array( '_single_enable_headline', '==', 'true' ),
						),
						array(
							'id'    => '_single_page_img',
							'type'  => 'upload',
							'title' => esc_html__( 'Hero area background', 'cakecious' ),
							'desc'  => esc_html__( 'This image appears in background of hero section above. Recommended image size is 1300x400 px.', 'cakecious' ),
							'dependency' => array( '_single_enable_headline', '==', 'true' ),
						),

					), // end: fields
				) // end: a section
);


// Lets create portfolio options that we will use mostly
	$cakecious_fw_event_meta =  array(

				// begin: a section
				array(
					'name'   => 'section_1',
					'title'  => 'Event Settings',
					'icon'   => 'fa fa-cog',
					// begin: fields
					'fields' => array(

						array(
							'id'      => '_ht_event_time',
							'type'    => 'textarea',
							'title'   => esc_html__( 'Date/Time for the Event.', 'cakecious' ),
							'desc'   => esc_html__( 'eg: 19 August 2017, (Saturday) 8:00 am - 10:00 am.', 'cakecious' ),
							'default'   => '9 August 2017
(Saturday) 8:00 am - 10:00 am.',
						),
						array(
							'id'         => '_ht_event_time_label',
							'type'       => 'text',
							'title'      => esc_html__( 'Label for Time of event.', 'cakecious' ),
							'desc'      => esc_html__( 'Just in case you want to change it. ', 'cakecious' ),
							'default'   => 'Time',
						),

						array(
							'id'      => '_ht_event_loc',
							'type'    => 'textarea',
							'title'   => esc_html__( 'Location for the Event.', 'cakecious' ),
							'default'   => '56, Marborne, cakecious Resort
NY 18565',
						),
						array(
							'id'         => '_ht_event_loc_label',
							'type'       => 'text',
							'title'      => esc_html__( 'Label for Location of event.', 'cakecious' ),
							'desc'      => esc_html__( 'Just in case you want to change it. ', 'cakecious' ),
							'default'   => 'Location',
						),

						array(
							'id'      => '_ht_event_schedule',
							'type'    => 'textarea',
							'title'   => esc_html__( 'Schedule for the Event.', 'cakecious' ),
							'desc'   => esc_html__( 'Use # for line break.', 'cakecious' ),
							'default'   => '9:00 am Breakfast#
11:00 am Global Meeting#
1:00 pm Introductory net#
working session',
						),
						array(
							'id'         => '_ht_event_schedule_label',
							'type'       => 'text',
							'title'      => esc_html__( 'Label for Schedule of event.', 'cakecious' ),
							'desc'      => esc_html__( 'Just in case you want to change it. ', 'cakecious' ),
							'default'   => 'Event Schedule',
						),

					), // end: fields
				), // end: a section

);

// Lets create testimonial options that we will use mostly
	$cakecious_fw_testi_meta =  array(

				// begin: a section
				array(
					'name'   => 'section_1',
					'title'  => 'Testimonial Settings',
					'icon'   => 'fa fa-cog',
					// begin: fields
					'fields' => array(
						array(
						  'type'    => 'notice',
						  'class'   => 'info',
						  'content' => 'The image for this item can be added from right side featured image block.',
						),
						array(
						  'id'      => '_single_testi_heading', // another unique id
						  'type'    => 'text',
						  'title'   => 'Heading',
						  'desc'    => 'This heading comes as highlighted in the testimonial.',
						),

					), // end: fields
				), // end: a section

);


/* Start creating meta options. */

$options = array(); // remove old options

// -----------------------------------------
// Page Metabox Options                    -
// -----------------------------------------

		$options[] = array(
			'id'        => '_tt_meta_page_opt',
			'title'     => 'Page Options',
			'post_type' => 'page',
			'context'   => 'normal',
			'priority'  => 'default',
			'sections'  => $cakecious_fw_default_meta

		);
		$options[] = array(
			'id'        => '_tt_meta_page_opt',
			'title'     => 'Page Options',
			'post_type' => 'product',
			'context'   => 'normal',
			'priority'  => 'default',
			'sections'  => $cakecious_fw_default_meta

		);
		$options[] = array(
			'id'        => '_tt_meta_page_opt',
			'title'     => 'Events Options',
			'post_type' => 'tt_portfolio',
			'context'   => 'normal',
			'priority'  => 'default',
			'sections'  => $cakecious_fw_event_meta

		);
		// Note : Meta options for CPTs are triggered from templatation-framework plugin as needed by this theme.

		return $options;

	}

	add_filter( 'cs_metabox_options', 'cakecious_fw_metas_opt', '21' );

}


