<?php
/**
 * absolvution template for generating comments
 *
 * @package WordPress
 * @subpackage absolvution
 * @since absolvution 1.0
 */
?>

<?php
	if ( post_password_required() ) {
		return;
	}
?>

<div id="comments" class="comments">

	<?php if ( have_comments() ) : ?>

		<h2 class="comments-title">

			<?php
				printf(
					_n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'absolvution' ),
					number_format_i18n( get_comments_number() ),
					get_the_title()
				);
			?>
		</h2>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'absolvution' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'absolvution' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'absolvution' ) ); ?></div>
		</nav>
		<?php endif; ?>

    <!--div class="comment-close">
        <a href="#comments" class="fa fa-close fa-close-lg"></a>
    </div-->

		<ol class="comment-list">
      <?php wp_list_comments( 'type=comment&callback=mytheme_comment' ); ?>
			<?php
        /*
				 *wp_list_comments(
				 *  array(
				 *    'style'       => 'ol',
				 *    'short_ping'  => true,
				 *    'avatar_size' => 34,
				 *  )
				 *);
         */
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'absolvution' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'absolvution' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'absolvution' ) ); ?></div>
		</nav>
		<?php endif; ?>

		<?php if ( ! comments_open() ) : ?>
		<p class="no-comments"><?php _e( 'Comments are closed.', 'absolvution' ); ?></p>
		<?php endif; ?>

	<?php endif; ?>

	<?php comment_form(); ?>

</div>
