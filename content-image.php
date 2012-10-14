<?php
/**
 * The template for displaying posts in the Image post format.
 *
 * @since Leaf 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div class="image-articles row">
								
			<div class="four columns">

				<a href="<?php the_permalink(); ?>">
					<img src="<?php echo leaf_get_post_image( null,null,true,null, 'medium' ); ?>" alt="<?php the_title(); ?>" class="attachment-post-thumbnail wp-post-image">
					<span class="image-format"></span>
				</a>
										
			</div><!-- .four .columns -->
							
			<div class="eight columns">
							
				<header class="entry-header">
					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'leaf' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h1>
				</header><!-- .entry-header -->

				<div class="entry-summary">
					<?php echo '<p>' . wp_trim_words( get_the_excerpt(), 35, null ) . '</p>'; ?>
				</div><!-- .entry-summary -->

				<p class="read-more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'Full Article', 'leaf'  ); ?> &rarr;</a></p>
							
			</div><!-- .eight .columns -->
				
		</div><!-- .image-articles .row -->

		<footer class="entry-meta">
			<?php leaf_entry_meta(); ?>
			
			<?php if ( comments_open() ) : ?>
				<span class="spacer"> // </span>
				<?php comments_popup_link( __( 'Comment', 'leaf' ), __( '1 Comment', 'leaf' ), __( '% Comments', 'leaf' ) ); ?>
			<?php endif; // comments_open() ?>
			
			<?php edit_post_link( __( 'Edit', 'leaf' ), '<span class="edit-link"> <span class="spacer">//</span> ', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
