<?php
/**
 * The template for displaying Search Results pages.
 *
 * @since Leaf 1.0
 */

get_header(); ?>

	<section id="primary" class="site-content eight columns">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'leaf' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>

			<?php leaf_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php leaf_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'search' ); ?>

		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary .site-content .eight .columns -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>