<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @since Leaf 1.0
 */
?>

		<article id="post-0" class="post no-results not-found">

			<?php if ( current_user_can( 'edit_posts' ) ) :
				// Show a different message to a logged-in user who can add posts. ?>
				
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'No posts to display', 'leaf' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'leaf' ), admin_url( 'post-new.php' ) ); ?></p>
				</div><!-- .entry-content -->
				
			<?php elseif ( is_search() ) : ?>

				<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'leaf' ); ?></p>
				<?php get_search_form(); ?>

			<?php else : 
				// Show the default message to everyone else. ?>
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing found', 'leaf' ); ?></h1>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'leaf' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			<?php endif; // end current_user_can() check ?>

		</article><!-- #post-0 -->