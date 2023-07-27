<?php
/*
 * Available vars.
 * $posts_per_page
 * $orderby
 * $order
 * $tt_template
 * $enable_filter
 * $enable_all_btn
 * $spl_field1 to $spl_field6 as applicable.
 */
?>

<?php
echo do_shortcode('[products limit="'. $posts_per_page .'" columns="'. $number_cols .'" orderby="' .$orderby. '" order="'. $order .'" class="cakecious-prod" ]');