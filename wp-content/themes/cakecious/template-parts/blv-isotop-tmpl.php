<?php
/*
 * Template file for posts shortcode.
 * $temptt_t_vars is an array of custom parameters set for given post shortcode.
 */

wp_enqueue_script( 'imagesloaded' );
wp_enqueue_script( 'isotope', get_template_directory_uri() . '/assets/vendors/isotope.pkgd.min.js', array('jquery'), null, true );

//defaults.
if($temptt_t_vars['temptt_show_filters'] != 'no' ) $temptt_t_vars['temptt_show_filters'] = 'yes';
?>

<section class="grid_gallery_area tt-portfolio">
        <div class="grid_gallery_inner">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	if($temptt_t_vars['temptt_show_filters'] == 'yes' ) {
	                $sub_cat_args = array('hide_empty' => 0, 'orderby' => 'ID');
	                $sub_cat_terms = get_terms('tt_portfolio_cats', $sub_cat_args);
	                if (!empty($sub_cat_terms) && !is_wp_error($sub_cat_terms)) { ?>
			            <ul class="isotopebutton-group filters-button-group">
				            <?php if($temptt_t_vars['temptt_filter_all'] == 'yes' ) { ?>
			                <li class="isotopebutton is-checked" data-filter="*"><?php esc_html_e('All', 'cakecious');?></li>
						    <?php } ?>
				            <?php foreach ($sub_cat_terms as $sub_cat) {
			                print '<li class="isotopebutton" data-filter=".' . $sub_cat->slug . '">' . $sub_cat->name . '</li>';
						    } ?>
			            </ul>
	                <?php }
	} ?>
	<div <?php if($temptt_t_vars['temptt_show_filters'] == 'yes' ) echo ' class="isotopgrid" ';?>>
	<?php
	while ( $posts->have_posts() ) :
		$posts->the_post();
		global $post;
	            $curent_term_array = wp_get_post_terms(get_the_ID(), 'tt_portfolio_cats');
	            $current_term_string = '';
	            foreach ($curent_term_array as $curent_term_item) {
	                $current_term_string .= ' ' . $curent_term_item->slug;

	            }
		?>

		  <div class="element-item <?php if($temptt_t_vars['temptt_show_filters'] == 'yes' ) echo esc_attr($current_term_string);?> " data-category="<?php if($temptt_t_vars['temptt_show_filters'] == 'yes' ) echo esc_attr($current_term_string);?>">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="grid_gallery_item">
                        <?php the_post_thumbnail(); ?>
                        <div class="resort_g_hover">
                            <div class="resort_hover_inner">
                                <a class="light" href="<?php the_post_thumbnail_url(); ?>"><i class="fa fa-expand" aria-hidden="true"></i></a>
                                <?php the_title( sprintf( '<h5 class="title">', esc_url( get_permalink() ) ), '</h5>' ); ?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
		  </div>


	<?php
	endwhile; ?>
	</div>
	<?php
	}
	// Posts not found
	else {
		echo '<h4>' . esc_html__( 'Portfolio Posts not found', 'cakecious' ) . '</h4>';
	}
	?>
        </div>
</section>