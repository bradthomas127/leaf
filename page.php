<?php
/**
 * The template for displaying all pages.
 *
 * @since Leaf 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content <?php echo leaf_grid_width( 'content' ); ?> columns">
		<div id="content" role="main">
		
			<?php leaf_page_before(); // Before page hook. ?>

			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php get_template_part( 'content', 'page' ); ?>
				
				<?php comments_template( '', true ); ?>
				
			<?php endwhile; // end of the loop. ?>
			
			<?php leaf_page_after(); // After page hook. ?>

		</div><!-- #content -->
	</div><!-- #primary .site-content .<?php echo leaf_grid_width( 'content' ); ?> .columns -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>