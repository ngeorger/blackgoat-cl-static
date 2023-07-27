<?php
/************* COMMENT LAYOUT *********************/

// Comment Form
add_filter( 'comment_form_default_fields', 'cakecious_comment_form_fields' );
function cakecious_comment_form_fields( $fields ) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$consent  = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html5 = current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;
	$fields = array(
	'author' => '<div class="form-group comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'cakecious' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
	'<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div>',
	'email' => '<div class="form-group comment-form-email"><label for="email">' . esc_html__( 'Email', 'cakecious' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
	'<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div>',
	'url' => '<div class="form-group comment-form-url"><label for="url">' . esc_html__( 'Website', 'cakecious' ) . '</label> ' .
	'<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>',
	'cookies' => '<div class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
					 '<label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'cakecious' ) . '</label></div>',
	);
	return $fields;
}

add_filter( 'comment_form_defaults', 'cakecious_comment_form' );
function cakecious_comment_form( $args ) {
	$args['comment_field'] = '<div class="form-group comment-form-comment">
	<label for="comment">' . _x( 'Comment', 'noun', 'cakecious' ) . ( ' <span class="required">*</span>' ) . '</label>
	<textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
	</div>';
	$args['class_submit'] = 'btn order_s_btn form-control'; // since WP 4.1
	return $args;
}


function cakecious_fw_cust_cmnt($comment, $args, $depth) {
    ?>


    <li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
<div class="single-comment media ">
	<div class="comment-author vcard">
		<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	</div>
	<div class="media-body">
		<h4 class="author"><?php comment_author_link(); ?></h4>
		<?php comment_text(); ?>
		<div class="date_rep">
		<a class="tt-linkcomment" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>">#</a>
		<span>
	        <?php
	        /* translators: 1: date, 2: time */
	        printf( esc_html__('%1$s at %2$s', 'cakecious'), get_comment_date(),  get_comment_time() ); ?><?php edit_comment_link( esc_html__( '(Edit)', 'cakecious' ), '  ', '' );?>
		</span>
            <?php $tt_reply_text = ''; $tt_reply_text = esc_html__( ' Reply', 'cakecious' ); ?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => $tt_reply_text,  'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div>
	</div>
</div>
 <?php
}
?>
