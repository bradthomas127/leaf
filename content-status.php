<?php
/**
 * The template for displaying posts in the Status post format
 *
 * @since Leaf 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		
		<div class="status-articles row">
								
			<div class="three columns">

				<div class="avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'leaf_status_avatar', '130' ) ); ?></div>
										
			</div><!-- .three .columns -->
							
			<div class="nine columns">
							
				<header class="entry-header">
					<h1 class="entry-title">
						<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'leaf' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
					</h1>
				</header><!-- .entry-header -->

				<div class="entry-summary">
					<?php echo '<p>' . wp_trim_words( get_the_excerpt(), 35, null ) . '</p>'; ?>
				</div><!-- .entry-summary -->

				<p class="read-more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'Full Article', 'leaf'  ); ?> &rarr;</a></p>
							
			</div><!-- .nine .columns -->
				
		</div><!-- .status-articles .row -->

		<footer class="entry-meta">
			<?php leaf_entry_meta(); ?>
			
			<?php if ( comments_open() ) : ?>
				<span class="spacer"> // </span>
				<?php comments_popup_link( __( 'Comment', 'leaf' ), __( '1 Comment', 'leaf' ), __( '% Comments', 'leaf' ) ); ?>
			<?php endif; // comments_open() ?>
			
			<?php edit_post_link( __( 'Edit', 'leaf' ), '<span class="edit-link"> <span class="spacer">//</span> ', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->