<?php
/**
 * Template Name: Blog
 * Description: The blog template file.
 *
 * @since Leaf 1.0
 */

get_header(); ?>

	<?php if ( get_query_var('paged') ) $paged = get_query_var('paged'); elseif ( get_query_var('page') ) $paged = get_query_var('page'); else $paged = 1; ?>
	<?php query_posts("post_type=post&paged=$paged"); ?>

	<div id="primary" class="site-content <?php echo leaf_grid_width( 'content' ); ?> columns">
		<div id="content" role="main">
		
		<?php leaf_blog_before(); // Before blog hook. ?>
		
		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>
					
				<div class="post-divider"></div>	
					
			<?php endwhile; ?>

			<?php leaf_pagination(); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; // end have_posts() check ?>
		
		<?php leaf_blog_after(); // After blog hook. ?>

		</div><!-- #content -->
	</div><!-- #primary .site-content .<?php echo leaf_grid_width( 'content' ); ?> .columns -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>