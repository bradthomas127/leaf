<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @since Leaf 1.0
 */

get_header(); ?>

	<section id="primary" class="site-content <?php echo leaf_grid_width( 'content' ); ?> columns">
		<div id="content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php
					if ( is_day() ) {
						printf( __( 'Daily Archives: %s', 'leaf' ), '<span>' . get_the_date() . '</span>' );
					} elseif ( is_month() ) {
						printf( __( 'Monthly Archives: %s', 'leaf' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'leaf' ) ) . '</span>' );
					} elseif ( is_year() ) {
						printf( __( 'Yearly Archives: %s', 'leaf' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'leaf' ) ) . '</span>' );
					} elseif ( is_tag() ) {
						printf( __( 'Tag Archives: %s', 'leaf' ), '<span>' . single_tag_title( '', false ) . '</span>' );
					} elseif ( is_category() ) {
						printf( __( 'Category Archives: %s', 'leaf' ), '<span>' . single_cat_title( '', false ) . '</span>' );
					} else {
						_e( 'Archives', 'leaf' );
					}
				?></h1>

				<?php
					// Show an optional tag description.
					if ( is_tag() ) {
						$tag_description = tag_description();
						if ( $tag_description )
							echo '<div class="archive-meta">' . $tag_description . '</div>';
					}
					// Show an optional category description.
					if ( is_category() ) {
						$category_description = category_description();
						if ( $category_description )
							echo '<div class="archive-meta">' . $category_description . '</div>';
					}
				?>
			</header><!-- /. archive-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				get_template_part( 'content', get_post_format() );
			?>
			
			<div class="post-divider"></div>
					
			<?php endwhile; ?>

			<?php leaf_pagination(); ?>

		<?php else : ?>
			<?php get_template_part( 'no-results', 'archive' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</section><!-- #primary .site-content .<?php echo leaf_grid_width( 'content' ); ?> .columns -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>