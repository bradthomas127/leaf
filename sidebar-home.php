<?php
/**
 * The Sidebar containing the homepage widget area.
 *
 * If no active widgets in this sidebar, it will be hidden completely.
 *
 * @since Leaf 1.0
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-home' ) ) : ?>
		<div id="secondary" class="widget-area <?php echo leaf_grid_width( 'sidebar' ); ?> columns" role="complementary">
			
			<?php leaf_sidebar_before(); // Before sidebar hook. ?>
			
			<?php dynamic_sidebar( 'sidebar-home' ); ?>
			
			<?php leaf_sidebar_after(); // After sidebar hook. ?>
			
		</div><!-- #secondary .widget-area .<?php echo leaf_grid_width( 'sidebar' ); ?> .columns -->
	<?php endif; ?>