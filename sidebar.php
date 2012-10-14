<?php
/**
 * The Sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, show meta widget.
 *
 * @since Leaf 1.0
 */
?>

	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<div id="secondary" class="widget-area <?php echo leaf_grid_width( 'sidebar' ); ?> columns" role="complementary">
			
			<?php leaf_sidebar_before(); // Before sidebar hook. ?>
			
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
			
			<?php leaf_sidebar_after(); // After sidebar hook. ?>
			
		</div><!-- #secondary .widget-area .<?php echo leaf_grid_width( 'sidebar' ); ?> .columns -->
		
	<?php else: // If sidebar is not active display a simple Meta widget. ?>

		<div id="secondary" class="widget-area <?php echo leaf_grid_width( 'sidebar' ); ?> columns" role="complementary">			
			<aside id="meta-3" class="widget widget_meta"><h3 class="widget-title"><span><?php _e( 'Meta', 'leaf' ); ?></span></h3>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>			
		</div><!-- #secondary .widget-area .<?php echo leaf_grid_width( 'sidebar' ); ?> .columns -->
	
	<?php endif; ?>