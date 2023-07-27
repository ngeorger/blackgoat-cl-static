<?php
/**
 *
 * The demo folders name should be the slug of their demo.
 * Screenshot should be named as screenshot.png ( if jpg, edit below var )
 * Edit variables as needed on top of the function.
 * Set homepage for each demo below.
 * Default Homepage page title should be Home, and menu name should be Primary Menu.
 *
 */
function cakecious_import_files() {

  $cakecious_url        = 'https://cakeciouswp.bolvosites.com/';  /* root of multisite install*/
  $cakecious_img_extn   = '.jpg'; /* Only need to edit if jpg is used for screenshot. */

  // Note: query import file path is set inside function.
  $cakecious_local_import_path = trailingslashit( CAKECIOUS_FW_ROOT ) . 'inc/demo-import/';
  $cakecious_local_import_url = trailingslashit( plugins_url( '/', __FILE__ ) );
  $cakecious_xml_file         = 'data.xml';
  $cakecious_widget_file      = 'widgets.wie';
  $cakecious_customizer_file  = 'settings.dat';

  // prepare the array with all folders inside.
  $demo_folders = array();
  $sub_directories = array_map('basename', glob($cakecious_local_import_path . '*', GLOB_ONLYDIR));
  foreach ( $sub_directories as $dirname ) { // get all folders
  	$demotitle    = preg_replace('/(\d+)/', ' ${1} ', $dirname); // separating the number
  	$demotitle    = preg_replace('/(?<!\ )[A-Z]/', ' $0', $demotitle); // adding space before capital letters.
  	$demotitle    = str_replace('-', ' ', $demotitle); // add space instead of -.
  	$demotitle    = str_replace('  ', ' ', $demotitle); // add space instead of -.
  	$demotitle    = trim($demotitle);
  	$demotitle    = ucwords($demotitle);
  	$demo_folders[$dirname] = $demotitle;
  }

  // prepare array to initiate import.
  $demos = array();
  foreach( $demo_folders as $demo_folder => $demoname ) {
	  $demos[] = array(
	      'import_file_name'             => $demoname,
	      'import_slug'                  => $demo_folder,
	      'categories'                   => array( esc_html__('Main','cakecious') ),
	      'local_import_dir'                => $cakecious_local_import_path . trailingslashit( $demo_folder ),
	      'local_import_file'            => $cakecious_local_import_path . trailingslashit( $demo_folder ) . $cakecious_xml_file,
	      'local_import_widget_file'     => $cakecious_local_import_path . trailingslashit( $demo_folder ) . $cakecious_widget_file,
	      'local_import_customizer_file' => $cakecious_local_import_path . trailingslashit( $demo_folder ) . $cakecious_customizer_file,
	      'import_preview_image_url'     => $cakecious_local_import_url . trailingslashit( $demo_folder ) . 'screenshot' . $cakecious_img_extn,
	      'import_notice'                => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'cakecious' ),
	      'preview_url'                  => $cakecious_url . $demo_folder,
	  );
  }

	return $demos;

}
add_filter( 'pt-ocdi/import_files', 'cakecious_import_files' );

function cakecious_after_import_setup( $selected_import ) {

    function set_elementor_config() {
      add_option( 'elementor_disable_color_schemes', 'yes' ,'yes' );
      add_option( 'elementor_disable_typography_schemes', 'yes' ,'yes' );
    }

    function set_reading_options( $settings ) {
      $reading_settings = $settings['reading_settings'];
      if ( ! empty( $reading_settings ) ) {
        $homepage   = get_page_by_title( html_entity_decode( $reading_settings['homepage'] ) );
        $blog     = get_page_by_title( html_entity_decode( $reading_settings['blog'] ) );
        if ( ( isset( $homepage ) && $homepage->ID ) && ( isset( $blog ) && $blog->ID) ) {
            update_option( 'show_on_front',   'page' );
            update_option( 'page_on_front',   $homepage->ID );
            update_option( 'page_for_posts',  $blog->ID );
          return true;
        }
      }
      return false;
    }

    function set_woocommerce_pages( $settings ) {
      if ( class_exists( 'Woocommerce' ) && ! empty( $settings['woocommerce_pages'] ) ) {
        foreach ( $settings['woocommerce_pages'] as $woo_name => $woo_title ) {
          $woopage = get_page_by_title( $woo_title );
          if ( isset( $woopage ) && property_exists( $woopage, 'ID' ) ) {
            update_option( $woo_name, $woopage->ID );
          }
        }
        return true;
      }
      return false;
    }

    function set_nav_menus( $settings ) {

      if ( is_array( $settings['navigation'] ) ) {
        $locations = get_theme_mod( 'nav_menu_locations' );
        $menus = wp_get_nav_menus();

        foreach ( (array) $menus as $theme_menu ) {
          foreach ( (array) $settings['navigation'] as $import_menu ) {
            if ( $theme_menu->name == $import_menu['name'] ) {
              $locations[ $import_menu['location'] ] = $theme_menu->term_id;
            }
          }
        }

        set_theme_mod( 'nav_menu_locations', $locations );
        return true;
      }
      return false;
    }

    function cakecious_get_demo_path() {
  		$upload_dir = wp_upload_dir();
  		$dir = path_join( $upload_dir['basedir'], 'demo_files' );

  		return $dir;
  	}


	function set_rev_sliders( $selected_import ) {
		$rev_files = array();
		if ( class_exists( 'UniteFunctionsRev' ) ) { // if revslider is activated

			$rev_directory = $selected_import['local_import_dir']; // revsliders data dir
			foreach ( glob( $rev_directory . '/revslider/*.zip' ) as $filename ) { // get all files from revsliders data dir
				$filename    = basename( $filename );
				$rev_files[] = $selected_import['local_import_dir'] . 'revslider/' . $filename;
			}

		}

		if ( class_exists( 'RevSlider' ) && ! empty( $rev_files ) ) {
			$slider = new RevSlider();
			foreach ( $rev_files as $filepath ) {
				$slider->importSliderFromPost( true, true, $filepath );
			}
		}
	}

    $json = null;
    $homepage = 'Homepage';

	// Set specific data based on the import user wants to import.
    if( 'demo2' === $selected_import['import_slug'] ) {
	    $homepage = 'Homepage 2';
    }
    if( 'demo3' === $selected_import['import_slug'] ) {
	    $homepage = 'Homepage 3';
    }
    if( 'demo4' === $selected_import['import_slug'] ) {
	    $homepage = 'Homepage 4';
    }
    if( 'demo5' === $selected_import['import_slug'] ) {
	    $homepage = 'Homepage 5';
    }

	function cakecious_import_data( $file='', $addon_cat=false ) {

		require_once(ABSPATH . 'wp-admin/includes/file.php');

	    WP_Filesystem();
	    global $wp_filesystem;
	    global $wpdb;

	    if(!is_readable($file)) {
	        echo 'File not found or not readable '.$file;
	    }

		$query_ins = $wp_filesystem->get_contents( $file );

		// we need to add table name dynamically, so make sure its removed from sql file.
		global $wpdb;
		if( $addon_cat ) {

			$query_ins = "INSERT INTO ".$wpdb->prefix."addonlibrary_categories " . $query_ins;
		    $rows_affected = $wpdb->query( $query_ins );
			if( $rows_affected ) {
				update_option('blv_addons_cat_import', 'done');
			}

		} else {

			$query_ins = "INSERT INTO ".$wpdb->prefix."addonlibrary_addons " . $query_ins;
		    $rows_affected = $wpdb->query( $query_ins );
			if( $rows_affected ) {
				update_option('blv_addons_import', 'done');
			}

		}
	}

    function cakecious_import_addons(){

	  $cakecious_local_import_addon = trailingslashit( get_template_directory_uri() ) . 'inc/demo-import/cakecious-addons.txt';
	  $cakecious_local_import_cat = trailingslashit( get_template_directory_uri() ) . 'inc/demo-import/cakecious-addons-cat.txt';
		if( class_exists( 'OCDI_Plugin' ) ) {
			$cakecious_downloader         = new \OCDI\Downloader;
			$cakecious_local_import_addon = $cakecious_downloader->download_file( $cakecious_local_import_addon, 'cakecious-addons.txt' );
			$cakecious_local_import_cat   = $cakecious_downloader->download_file( $cakecious_local_import_cat, 'cakecious-addons-cat.txt' );
			if ( ! get_option( 'blv_addons_import' ) && ! is_object( $cakecious_local_import_addon ) ) {
				cakecious_import_data( $cakecious_local_import_addon );
			}

			if ( ! get_option( 'blv_addons_cat_import' ) && ! is_object( $cakecious_local_import_cat ) ) {
				cakecious_import_data( $cakecious_local_import_cat, true );
			}
		}
    }

	$settings = array (
      'reading_settings' =>
        array (
          'homepage' => $homepage,
          'blog' => 'Blog',
        ),
      'woocommerce_pages' =>
        array (
          'woocommerce_shop_page_id' => 'Shop',
          'woocommerce_cart_page_id' => 'Cart',
          'woocommerce_checkout_page_id' => 'Checkout',
          'woocommerce_myaccount_page_id' => 'My Account',
        ),
      'navigation' =>
        array (
          0 =>
          array (
            'name' => 'Primary Menu',
            'location' => 'header-menu-1',
          ),
          1 =>
          array (
            'name' => 'Primary Menu',
            'location' => 'header-mobile-menu',
          ),
          2 =>
          array (
            'name' => 'Left Menu',
            'location' => 'header-menu-2',
          ),
          3 =>
          array (
            'name' => 'Right Menu',
            'location' => 'header-menu-3',
          ),
        ),
    );
    set_elementor_config();
    set_reading_options( $settings );
    set_woocommerce_pages( $settings );
    set_nav_menus( $settings );
	set_rev_sliders( $selected_import );
    //cakecious_import_addons( $settings );


    flush_rewrite_rules();
}
add_action( 'pt-ocdi/after_import', 'cakecious_after_import_setup' );

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );