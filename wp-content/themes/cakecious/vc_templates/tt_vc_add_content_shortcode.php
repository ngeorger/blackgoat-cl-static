<?php


$list_type = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


isset($atts['posts_per_page']) ? $posts_per_page = $atts['posts_per_page'] : $posts_per_page = '5';
isset($atts['post_type']) ? $post_type = $atts['post_type'] : $post_type = '5';
isset($atts['orderby']) ? $orderby = $atts['orderby'] : $orderby = 'date';
isset($atts['tt_order']) ? $order = $atts['tt_order'] : $order = 'DESC';
isset($atts['enable_filter']) ? $enable_filter = $atts['enable_filter'] : $enable_filter = 'no';
isset($atts['enable_all_btn']) ? $enable_all_btn = $atts['enable_all_btn'] : $enable_all_btn = 'no';
isset($atts['tt_id']) ? $id = $atts['tt_id'] : $id = false;
if (!isset($atts['num_columns'])) $atts['num_columns'] = '4';

if(!empty($atts['spl_title'])) $spl_title = 'temptt_var1="'.$atts['spl_title'].'"';
if(!empty($atts['spl_desc'])) $spl_desc = 'temptt_var2="'.$atts['spl_desc'].'"';
if(!empty($atts['spl_button'])) $spl_button = 'temptt_var3="'.$atts['spl_button'].'"';
if(!empty($atts['spl_btn_link'])) $spl_btn_link = 'temptt_var4="'.$atts['spl_btn_link'].'"';

(!isset($atts['tt_template']) || $atts['tt_template'] == 'default') ? $template = 'templates/tt-posts-sc.php' : $template = $atts['tt_template'] ;

if ($atts['tt_template'] != 'default') $template = 'templates/tt-'.$template.'.php';

if(!empty($id)) $id = 'id='.$id;
if('true' == $enable_filter) $enable_filter = 'temptt_show_filters=yes';
('true' == $enable_all_btn) ? $enable_all_btn = 'temptt_filter_all=yes' : $enable_all_btn = 'temptt_filter_all=no';


echo do_shortcode('[templatation_posts posts_per_page='.$posts_per_page.' post_type='.$post_type.' orderby='.$orderby.' order='.$order.' '.$id.'  '.$enable_filter.'  '.$enable_all_btn.' template='.$template.' '.$spl_desc.' '.$spl_title.' '.$spl_button.' '.$spl_btn_link.']' );

?>