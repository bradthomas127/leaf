<?php
/**
 * The template for displaying posts in the gallery post format.
 *
 * @since Leaf 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="gallery-articles row">
	
			<?php
			$images = get_children( array( 'post_parent' => $post->ID, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order', 'order' => 'ASC', 'numberposts' => 999 ) );
			if ( $images ) :
				$total_images = count( $images );
				$image = array_shift( $images );
				$image_img_tag = wp_get_attachment_image( $image->ID, 'medium', false, array( 'class'	=> 'attachment-post-thumbnail wp-post-image') );
			?>
				
								
				<div class="four columns">
							
					<a href="<?php the_permalink(); ?>"><?php echo $image_img_tag; ?>
						<span class="gallery-format"></span>
					</a>
							
					<p>
						<em>
							<?php printf( _n( 'This gallery contains <a %1$s>%2$s photo</a>.', 'This gallery contains <a %1$s>%2$s photos</a>.', $total_images, 'leaf' ),
							'href="' . esc_url( get_permalink() ) . '" title="' . sprintf( esc_attr__( 'Permalink to %s', 'leaf' ), the_title_attribute( 'echo=0' ) ) . '" rel="bookmark"',
							number_format_i18n( $total_images )
							); ?>	
						</em>
					</p>
						
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
							
			<?php else: ?>
			
				<div class="twelve columns">
							
					<header class="entry-header">
						<h1 class="entry-title">
							<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'leaf' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
						</h1>
					</header><!-- .entry-header -->

					<div class="entry-summary">
						<?php the_excerpt(); ?>
					</div><!-- .entry-summary -->

					<p class="read-more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'Full Article', 'leaf'  ); ?> &rarr;</a></p>
									
				</div><!-- .twelve .columns -->
			
			<?php endif; ?>
			
		</div><!-- .gallery-articles .row -->

		<footer class="entry-meta">
			<?php leaf_entry_meta(); ?>
			
			<?php if ( comments_open() ) : ?>
				<span class="spacer"> // </span>
				<?php comments_popup_link( __( 'Comment', 'leaf' ), __( '1 Comment', 'leaf' ), __( '% Comments', 'leaf' ) ); ?>
			<?php endif; // comments_open() ?>
			
			<?php edit_post_link( __( 'Edit', 'leaf' ), '<span class="edit-link"> <span class="spacer">//</span> ', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->