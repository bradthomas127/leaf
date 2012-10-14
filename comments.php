<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to leaf_comment() which is
 * located in the functions.php file.
 *
 * @since Leaf 1.0
 */
?>
<?php
	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if ( post_password_required() )
			return;
?>
	<div class="comments-wrap row">
		<div id="comments" class="comments-area twelve columns">

			<?php // You can start editing here -- including this comment! ?>

			<?php if ( have_comments() ) : ?>
				<h3 class="comments-title">
					<?php
						printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'leaf' ),
							number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
					?>
				</h3>

				<ol class="commentlist">
					<?php wp_list_comments( array( 'callback' => 'leaf_comment', 'style' => 'ol' ) ); ?>
				</ol><!-- .commentlist -->

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
				<nav id="comment-nav-below" class="navigation" role="navigation">
					<h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', 'leaf' ); ?></h1>
					<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'leaf' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'leaf' ) ); ?></div>
				</nav>
				<?php endif; // check for comment navigation ?>

			<?php // If comments are closed and there are comments, let's leave a little note.
				elseif ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>
				<p class="nocomments"><?php _e( 'Comments are closed.', 'leaf' ); ?></p>
			<?php endif; ?>

			<?php // X-Autocomplete Fields and placeholder to Comment Form.
			$args = array(
				'fields' => array(
					'author' => '<p class="comment-form-author"><input x-autocompletetype="name-full" id="author" name="author" type="text" required size="30" placeholder="' . __( 'Name:', 'leaf' ) . ' *" aria-required="true" /></p>',
					'email' => '<p class="comment-form-email"><input x-autocompletetype="email" id="email" name="email" type="text" required size="30" placeholder="' . __( 'Email:', 'leaf' ) . ' *" aria-required="true" /></p>',
					'url' => '<p class="comment-form-url"><input id="url" name="url" type="text" size="30" placeholder="' . __( 'Website:', 'leaf' ) . '" /></p>'
				 ),
				'comment_notes_after' => '',
				'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" required cols="45" rows="8" placeholder="' . _x( 'Comment:', 'noun' , 'leaf' ) . '" aria-required="true"></textarea></p>'
			);
			comment_form($args);
			?>

		</div><!-- #comments .comments-area .twelve .columns -->
	</div><!-- .comments-wrap .row -->