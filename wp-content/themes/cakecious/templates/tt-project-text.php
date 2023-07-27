<?php
/*
 * Template file for posts shortcode.
 * $temptt_t_vars is an array of custom parameters set for given post shortcode.
 */

?>
<section class="portfolio_area p_100">
    <div class="container">
	        <?php
// Posts are found
if ( $posts->have_posts() ) {
	if($temptt_t_vars['temptt_show_filters'] == 'yes' ) {
	                $sub_cat_args = array('hide_empty' => 0, 'orderby' => 'ID');
	                $sub_cat_terms = get_terms('tt_project_cats', $sub_cat_args);
	                if (!empty($sub_cat_terms) && !is_wp_error($sub_cat_terms)) { ?>


        <div class="portfolio_filter">
			<ul class="list_style">
	            <?php if($temptt_t_vars['temptt_filter_all'] == 'yes' ) { ?>
                <li class="active" data-filter="*"><a href="#"><?php esc_html_e('All', 'cakecious');?></a></li>
			    <?php } ?>
	            <?php foreach ($sub_cat_terms as $sub_cat) {
                print '<li data-filter=".' . $sub_cat->slug . '"><a href="#">' . $sub_cat->name . '</a></li>';
			    } ?>
			</ul>
		</div>
	     <?php }
	} ?>

        <div class="row grid_portfolio_area imageGallery1">
	<?php
	while ( $posts->have_posts() ) :
		$posts->the_post();
		global $post;
	            $curent_term_array = wp_get_post_terms(get_the_ID(), 'tt_project_cats');
	            $current_term_string = '';
	            foreach ($curent_term_array as $curent_term_item) {
	                $current_term_string .= ' ' . $curent_term_item->slug;

	            }
		?>

            <div class="col-md-4 col-6 <?php if($temptt_t_vars['temptt_show_filters'] == 'yes' ) echo esc_attr($current_term_string);?>">
                <div class="portfolio_item">
                    <div class="portfolio_img">
                        <a class="light" href="<?php the_post_thumbnail_url('full'); ?>">
                            <?php the_post_thumbnail(array('370','230'),  array('class' => 'img-fluid')); ?>
                        </a>
                    </div>
                    <div class="portfolio_text">
                        <?php the_title( '<h4>', '</h4>' ); ?>
                    </div>
                </div>
            </div>
	<?php
	endwhile; ?>
        </div>
    </div>
	<?php
	}
	// Posts not found
	else {
		echo '<h4>' . esc_html__( 'Posts not found', 'cakecious' ) . '</h4>';
	}
	?>
</section>