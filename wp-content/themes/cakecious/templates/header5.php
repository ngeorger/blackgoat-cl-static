<header class="main_header_area five_header">
	<?php if( function_exists('cakecious_topnav_content')) echo cakecious_topnav_content(); ?>
	<div class="main_menu_two">
		<div class="container">
			<nav class="navbar navbar-expand-lg navbar-light bg-light">
		        <!-- Logo -->
		        <?php if(cakecious_fw_get_option('use_logo', '1')) {
					echo cakecious_fw_logo();
		        } else { ?>
		        <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
				<?php } ?>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="<?php esc_html_e( 'Toggle navigation', 'cakecious' ); ?>">
					<span class="my_toggle_menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
		        <!-- The WordPress Menu goes here -->
		        <?php wp_nav_menu(
		                array(
		                    'depth'             => 3,
		                    'theme_location'    => 'primary-menu',
		                    'container'         => false,
		                    'menu_class'        => 'navbar-nav justify-content-end navigation-box',
		                    'fallback_cb'       => '',
		                    'menu_id'           => '',
							'walker'          => new Cakecious_WP_Bootstrap_Navwalker(),
		                )
		        ); ?>
				</div>
			</nav>
		</div>
	</div>
</header>