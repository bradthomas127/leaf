<?php
/**
 * Template Name: One Column Template
 *
 * @since Leaf 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content twelve columns">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary .site-content .twelve .columns -->

<?php get_footer(); ?>