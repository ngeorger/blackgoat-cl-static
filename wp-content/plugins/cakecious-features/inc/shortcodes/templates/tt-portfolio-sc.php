<?php
/*
 * Template file for posts shortcode.
 * $temptt_t_vars is an array of custom parameters set for given post shortcode.
 */
?>
<div class="span3 transition metal tt-portfolio <?php if($temptt_t_vars['temptt_show_filters'] == 'yes' ) echo 'isotope-filter'; ?>">
<?php
// Posts are found
if ( $posts->have_posts() ) {
	if($temptt_t_vars['temptt_show_filters'] == 'yes' ) {
	                $sub_cat_args = array('hide_empty' => 0, 'orderby' => 'ID');
	                $sub_cat_terms = get_terms('tt_portfolio_cats', $sub_cat_args);
	                if (!empty($sub_cat_terms) && !is_wp_error($sub_cat_terms)) { ?>
	                    <ul class="isotope-nav">
		                    <?php if($temptt_t_vars['temptt_filter_all'] == 'yes' ) { ?>
			                <li class="selected"><a class="filter" href="#all" data-filter="*"><?php esc_html_e('All', 'fitnesspro');?></a></li>
			                <?php } ?>
	                        <?php foreach ($sub_cat_terms as $sub_cat) {
	                            print '<li><a class="filter" href="#' . $sub_cat->slug . '" data-filter=".' . $sub_cat->slug . '">' . $sub_cat->name . '</a></li>';
	                        } ?>
	                    </ul>
	                <?php }
	}
	if($temptt_t_vars['temptt_show_filters'] == 'yes' ) echo '<div class="isotope-content">'; ?>
        <div class="grid-sizer"></div>
	<?php
	while ( $posts->have_posts() ) :
		$posts->the_post();
		global $post;
	            $curent_term_array = wp_get_post_terms(get_the_ID(), 'tt_portfolio_cats');
	            $curent_term_string = '';
	            foreach ($curent_term_array as $curent_term_item) {
	                $curent_term_string .= ' ' . $curent_term_item->slug;

	            }
		?>
        <div class="<?php if($temptt_t_vars['temptt_show_filters'] == 'yes' ) echo ' isotope-item ' . $curent_term_string;?>">
	        <div class="img-container">
		     <?php if ( has_post_thumbnail() ) : ?>
		      <figure class="recent-work-img">
				<?php the_post_thumbnail(); ?>
		        <figcaption class="rollover v2">
		          <ul class="unstyle inline gallery clearfix">
		            <li class="enlarge"><a href="<?php the_post_thumbnail_url(); ?>" rel="prettyPhoto" title=""><i class="fa fa-search icon-large"></i></a></li>
		            <li class="link"><a href="<?php the_permalink(); ?>"><i class="fa fa-link icon-large"></i></a></li>
		          </ul>

		          <div class="content-container">
		              <?php the_title( sprintf( '<h5 class="title">', esc_url( get_permalink() ) ), '</h5>' ); ?>
		              <?php the_excerpt(); ?>
		          </div> <!-- end content-container -->
		        </figcaption> <!-- end rollover -->
		      </figure>  <!-- end recent-work-img -->
			<?php endif; ?>
		    </div> <!-- end img-container -->
        </div>
	<?php
	endwhile;
	if($temptt_t_vars['temptt_show_filters'] == 'yes' ) echo '</div>';
	}
	// Posts not found
	else {
		echo '<h4>' . __( 'Portfolio Posts not found', 'setupfolio' ) . '</h4>';
	}
	?>
</div>
