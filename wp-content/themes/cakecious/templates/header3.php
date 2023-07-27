<header class="main_header_three">
	<div class="top_logo_header">
		<div class="container">
			<div class="header_logo_inner">
				<div class="h_left_text">
					<div class="media">
						<div class="d-flex">
							<i class="flaticon-auricular-phone-symbol-in-a-circle"></i>
						</div>
						<div class="media-body">
							<?php if ( '' != cakecious_fw_get_option( 'contact_number' ) ) { ?>
								<a href="tel:<?php echo preg_replace( '/(\W*)/', '', cakecious_fw_get_option( 'contact_number' ) ); ?>"><?php echo esc_attr( cakecious_fw_get_option( 'contact_number' ) ); ?>
								</a>
							<?php } ?>
							<p><?php echo esc_attr(cakecious_fw_get_option('header_call')); ?></p>
						</div>
					</div>
				</div>
				<div class="h_middle_text">
		        <!-- Logo -->
		        <?php if(cakecious_fw_get_option('use_logo', '1')) {
					echo cakecious_fw_logo();
		        } ?>
				</div>
	            <?php if(cakecious_fw_get_option('header_btn') != '') { ?>
	                <div class="h_right_text">
				        <a class="pink_btn" href="<?php echo esc_url(cakecious_fw_get_option('header_link')); ?>"><?php echo esc_attr(cakecious_fw_get_option('header_btn')); ?></a>
	                </div>
		        <?php } ?>
			</div>
		</div>
	</div>
	<div class="middle_menu_three">
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
		                    'menu_class'        => 'navbar-nav navigation-box',
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