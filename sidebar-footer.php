<?php
/**
 * Footer widget area.
 *
 * @since Leaf 1.0
 */
?>

	<?php
	// If footer sidebars do not have widget let's bail.
	
	if ( ! is_active_sidebar( 'sidebar-3' ) && ! is_active_sidebar( 'sidebar-4' ) && ! is_active_sidebar( 'sidebar-5' ) )
		return;
	// If we made it this far we must have widgets.
	?>
	
	<div <?php leaf_footer_sidebar_class(); ?>>
		<?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
		<div class="widget-area first" role="complementary">
			<?php dynamic_sidebar( 'sidebar-3' ); ?>
		</div><!-- .widget-area .first -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
		<div class="widget-area second" role="complementary">
			<?php dynamic_sidebar( 'sidebar-4' ); ?>
		</div><!-- .widget-area .second -->
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
		<div class="widget-area third" role="complementary">
			<?php dynamic_sidebar( 'sidebar-5' ); ?>
		</div><!-- .widget-area .third -->
		<?php endif; ?>
	</div><!-- #supplementary -->