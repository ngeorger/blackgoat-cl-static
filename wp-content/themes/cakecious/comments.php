<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Cakecious
 */

// Prevent direct access.
if ( ! defined( 'ABSPATH' ) ) exit;

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php if ( cakecious_is_fresh_install() ) { ?>

<div id="comments" class="comments-area">
	<?php
	/**
	 * Hook: cakecious/frontend/before_comments
	 */
	do_action( 'cakecious/frontend/before_comments' );

	// You can start editing here -- including this comment!
	if ( have_comments() ) :

		/**
		 * Hook: cakecious/frontend/before_comments_list
		 *
		 * @hooked cakecious_comments_title - 10
		 * @hooked cakecious_comments_navigation - 20
		 */
		do_action( 'cakecious/frontend/before_comments_list' );
		?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 50,
				) );
			?>
		</ol>

		<?php
		/**
		 * Hook: cakecious/frontend/after_comments_list
		 *
		 * @hooked cakecious_comments_navigation - 10
		 * @hooked cakecious_comments_closed - 20
		 */
		do_action( 'cakecious/frontend/after_comments_list' );

	endif; // Check for have_comments().

	// Print comment form.
	comment_form( apply_filters( 'cakecious/frontend/comment_form_args', array() ) );

	/**
	 * Hook: cakecious/frontend/after_comments
	 */
	do_action( 'cakecious/frontend/after_comments' );
	?>
</div>

<?php } else { ?>

<div id="comments" class="s_comment_list">

    <?php // You can start editing here -- including this comment! ?>

    <?php if ( have_comments() ) { ?>
		<h3 class="cm_title_br">
            <?php
                printf( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'cakecious' ),
                    number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
            ?>
		</h3>
        <ol class="comment-list s_comment_list_inner">
            <?php
                wp_list_comments( array(
                    'callback'      => 'cakecious_fw_cust_cmnt',
                    'short_ping'    => true,
                    'avatar_size'   => 70,
                    'type'          => 'all',
                ) );
            ?>
        </ol><!-- .comment-list -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { // are there comments to navigate through ?>
        <nav id="comment-nav-below" class="comment-navigation">
            <h1 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'cakecious' ); ?></h1>
<?php if ( get_previous_comments_link() ) { ?>
            <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'cakecious' ) ); ?></div>
<?php }
                    if ( get_next_comments_link() ) { ?>
            <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'cakecious' ) ); ?></div>
 <?php } ?>
        </nav><!-- #comment-nav-below -->
        <?php } // check for comment navigation ?>

    <?php } // have_comments() ?>

    <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
        <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'cakecious' ); ?></p>
    <?php endif; ?>

    <?php comment_form(); ?>

</div><!-- #comments -->

<?php }
