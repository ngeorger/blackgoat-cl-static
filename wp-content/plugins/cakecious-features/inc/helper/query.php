<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.


		global $wpdb;
		$sql = '';

		$charset_collate = $wpdb->get_charset_collate();

			$sql = "CREATE TABLE `{$wpdb->prefix}addonlibrary_addons` (
					id int(9) NOT NULL AUTO_INCREMENT,
					title varchar(255),
					name varchar(128),
					alias varchar(128),
					addontype varchar(128),
					description text,
					ordering int not NULL,
					templates text,
					config text,
					catid int,
					is_active tinyint,
					test_slot1 text,
					test_slot2 text,
					test_slot3 text,
					PRIMARY KEY (id)
		) $charset_collate;";

		$sql .= "CREATE TABLE `{$wpdb->prefix}addonlibrary_categories` (
					id int(9) NOT NULL AUTO_INCREMENT,
					title varchar(255) NOT NULL,
					alias varchar(255),
					ordering int not NULL,
					params text NOT NULL,
					type tinytext,
					parent_id int(9),
					PRIMARY KEY (id)
		) $charset_collate;";

		$sql .= "INSERT INTO `{$wpdb->prefix}addonlibrary_categories` (`id`, `title`, `alias`, `ordering`, `params`, `type`, `parent_id`) VALUES
(2,	'cakecious',	'cakecious',	1,	'',	'elementor',	NULL);
";

		if( '' != $sql ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			update_option('blv_addons_sql', 'done');
		}

