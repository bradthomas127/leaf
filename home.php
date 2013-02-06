<?php
/**
 * The Home Page template file.
 *
 * @since Leaf 1.0
 */

global $options;
$options = get_option('leaf_theme_options');
$no_duplicates = array(); ?>
<?php get_header(); ?>

	<div id="primary" class="site-content <?php echo leaf_grid_width( 'content' ); ?> columns">
		<div id="content" role="main">
			<article class="post-home">

				<?php /********* Slider Section. *********/ ?>
				
				<div id="iview">
				
					<?php 
						if ( ! isset( $options['leaf_slider_cat']) || $options['leaf_slider_cat'] == -1 ) {
							$args = ( array( 'posts_per_page' => 5, 'post__not_in' => get_option( 'sticky_posts' ) ) );
						} else {
							$args = ( array( 'posts_per_page' => 5, 'category__in' => $options['leaf_slider_cat'], 'post__not_in' => get_option( 'sticky_posts' ) ) );
						}
					?>  

					<?php $loop = new WP_Query( $args ); ?>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<?php $no_duplicates[] = get_the_ID(); ?>
						
						<a href="<?php the_permalink(); ?>" data-iview:image="<?php echo leaf_get_post_image( null,null,true,null, 'slider' ); ?>">
							<span class="iview-caption caption3" data-x="15" data-y="212" data-transition="expandright"><h2><?php the_title(); ?></h2></span>
							<span class="iview-caption caption1" data-x="15" data-y="258" data-transition="expandleft"><?php echo '<p>' . wp_trim_words( get_the_excerpt(), 35, null ) . '</p>'; ?></span>
						</a>

					<?php endwhile; ?>
					
				</div><!-- #iview -->
				
				
				<?php /********* Featured Section. *********/ ?>

				<?php $loop = new WP_Query( array( 'posts_per_page' => 1,'post__in'  => get_option( 'sticky_posts' ),'post__not_in' => $no_duplicates, 'ignore_sticky_posts' => 1 ) ); ?>

				<?php if ( $loop->have_posts() ) : ?>
				
					<!-- Begin featured. -->
				
						<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
							<?php if (!is_sticky()) continue; ?>
					
							<?php $no_duplicates[] = get_the_ID(); ?>
							
							<h3 class="divider-title"><span><?php _e( 'Featured', 'leaf'  ); ?></span></h3>
					
							<div class="home-featured row">
							
								<div class="six columns">
								
									<a href="<?php the_permalink(); ?>">
										<img src="<?php echo leaf_get_post_image( '','',true,'', 'medium' ); ?>" alt="<?php the_title(); ?>" class="attachment-post-thumbnail wp-post-image">
									</a>
									
								</div><!-- .six .columns -->
								
								<div class="six columns">
								
									<h2 class="entry-title">
										<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'leaf' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
									</h2>
								
									<div class="entry-summary">
										<?php echo '<p>' . wp_trim_words( get_the_excerpt(), 45, null ) . '</p>'; ?>
									</div><!-- .entry-summary -->
										
									<p class="read-more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'Full Article', 'leaf'  ); ?> &rarr;</a></p>

								</div><!-- .six .columns -->
							
							</div><!-- .home-featured .row -->
							
						<?php endwhile; ?>
					
					<!-- End featured. -->
					
				<?php endif; ?>
				
				
				<?php /******* Categories Section. *******/ ?>
				
				<?php $categories = (!empty($options['leaf_home_cats'])) ? ($options['leaf_home_cats']) : ''; ?>

				<?php if ( !empty( $categories ) && is_array( $categories ) ) { ?>
						
					<!-- Begin categories. -->
			
					<?php foreach ( $categories as $category ) { ?>

						<?php $loop = new WP_Query( array( 'cat' => $category, 'posts_per_page' => 4, 'post__not_in' => $no_duplicates ) ); ?>

						<?php if ( $loop->have_posts() ) : ?>

							<?php $term = get_term( $category, 'category' ); ?>
							
							<?php $i = 0; ?>

							<h3 class="divider-title"><span><a href="<?php echo get_term_link( $term, 'category' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $term->name; ?></a></span></h3>

							<div class="home-cats row">

								<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

								<?php $no_duplicates[] = get_the_ID(); ?>
							
								<?php if ( ++$i == 1 ) { // If first post. ?>

									<div class="five columns">

										<a href="<?php the_permalink(); ?>">
											<img src="<?php echo leaf_get_post_image( null,null,true,null, 'medium' ); ?>" alt="<?php the_title(); ?>" class="attachment-post-thumbnail wp-post-image">
										</a>
								
										<h2 class="entry-title">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
										</h2>
								
										<div class="entry-summary">
											<?php echo '<p>' . wp_trim_words( get_the_excerpt(), 22, null ) . '</p>'; ?>
										</div><!-- .entry-summary -->
								
										<p class="read-more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'Full Article', 'leaf'  ); ?> &rarr;</a></p>

									</div><!-- .five .columns -->

								<?php } else { // If not the first post. ?>

									<?php if ( $i == 2 ) echo '<div class="vertical-divider seven columns">'; // If second post open columns. ?>

									<div class="horizontal-divider row">
								
										<div class="four columns">

											<a href="<?php the_permalink(); ?>">
												<img src="<?php echo leaf_get_post_image( null,null,true,null, 'medium' ); ?>" alt="<?php the_title(); ?>" class="attachment-post-thumbnail wp-post-image">
											</a>
											
										</div><!-- .four .columns -->
									
										<div class="eight columns">
										
											<h2 class="entry-title">
												<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
											</h2>
											
											<div class="entry-summary">
												<?php echo '<p>' . wp_trim_words( get_the_excerpt(), 10, null ) . '</p>';?>
											</div><!-- .entry-summary -->
											
											<p class="read-more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'Full Article', 'leaf'  ); ?> &rarr;</a></p>
											
										</div><!-- .eight .columns -->
									
									</div><!-- .horizontal-divider .row -->
								
								<?php } ?>

								<?php endwhile; ?>
						
								<?php if ( $i > 1 ) echo '</div><!-- .vertical-divider .seven .columns -->'; // If there is more than one post, close the list after the loop. ?>
						
							</div><!-- .home-cats .row -->

							<!-- End categories. -->

						<?php endif; ?>

					<?php } ?>

				<?php } ?>

				
				<?php /********* Articles Section. *********/ ?>
				
				<?php $articles = (!empty($options['leaf_more_articles_number'])) ? ($options['leaf_more_articles_number']) : 2; ?>

				<?php $loop = new WP_Query( array( 'posts_per_page' => $articles, 'post__not_in' => $no_duplicates, 'orderby' => 'date', 'order' => 'DESC' ) ); ?>

				<?php if ( $loop->have_posts() ) : ?>
				
					<!-- Begin articles. -->

					<h3 class="divider-title"><span><?php _e( 'More Articles', 'leaf' ); ?></span></h3>

					<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

						<div class="home-articles horizontal-divider row">
								
							<div class="four columns">

								<a href="<?php the_permalink(); ?>">
									<img src="<?php echo leaf_get_post_image( null,null,true,null, 'medium' ); ?>" alt="<?php the_title(); ?>" class="attachment-post-thumbnail wp-post-image">
								</a>
										
							</div><!-- .four .columns -->
							
							<div class="eight columns">
							
								<h2 class="entry-title">
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h2>

								<div class="entry-summary">
									<?php echo '<p>' . wp_trim_words( get_the_excerpt(), 45, null ) . '</p>';?>
								</div><!-- .entry-summary -->

								<p class="read-more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'Full Article', 'leaf'  ); ?> &rarr;</a></p>
							
							</div><!-- .eight .columns -->
							
						</div><!-- .home-articles .horizontal-divider .row -->

					<?php endwhile; ?>
		
					<!-- End articles. -->

				<?php endif; ?>


			</article><!-- .post-home -->
		</div><!-- #content -->
	</div><!-- #primary .site-content .<?php echo leaf_grid_width( 'content' ); ?> .columns-->

<?php // If the home sidebar has widgets display it.
if ( is_active_sidebar( 'sidebar-home' ) ) :
	get_sidebar( 'home' ); 
else:
	get_sidebar();
endif;
?>
<?php get_footer(); ?>