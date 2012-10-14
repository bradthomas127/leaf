<?php
/**
 * The template for displaying the footer.
 *
 * @since Leaf 1.0
 */
?>
	</div><!-- #main .row -->

	<?php leaf_footer_before(); // Before footer hook ?>
	
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="row footer-row">
			<?php
				/* Display the footer sidebars if active and not the 404 page.
				 */
				if ( ! is_404() )
					get_sidebar( 'footer' );
			?>

			<?php if (has_nav_menu('footer')) { ?>
				<div class="row footer-nav">
					<div class="twelve columns">
					
						<nav role="navigation" class="site-navigation footer-navigation">
							<h1 class="assistive-text"><?php _e( 'Footer Menu', 'leaf' ); ?></h1>
							<?php wp_nav_menu( array( 'theme_location' => 'footer', 'fallback_cb' => false, 'depth' => 1, 'menu_class' => 'footer-menu' ) ); ?>
						</nav><!-- .site-navigation .footer-navigation -->
						
					</div><!-- .twelve .columns -->
				</div><!-- .row .footer-nav -->
			<?php } ?>
		</div><!-- .row .footer-row -->
		
		
		<div class="footer-info">
			<div class="row info-wrap">
			
				<div class="copyright six columns">
					<?php esc_attr_e('&copy;', 'leaf'); ?> <?php _e(date('Y')); ?> <a href="<?php echo home_url('/') ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"><?php bloginfo('name'); ?></a>
				</div><!-- .copyright .six .columns -->

				<div class="site-info six columns">

					<a href="<?php echo esc_url( __( 'http://fatboythemes.com/themes/leaf/', 'leaf' ) ); ?>" title="<?php esc_attr_e( 'Leaf Theme', 'leaf' ); ?>"><?php printf( __('Leaf Theme', 'leaf')); ?></a> 
					<?php printf( __( 'powered by', 'leaf' )); ?> 
					<a href="<?php echo esc_url( __('http://wordpress.org/', 'leaf')); ?>" title="<?php esc_attr_e('WordPress', 'leaf'); ?>"><?php printf( __('WordPress', 'leaf')); ?></a>

				</div><!-- .site-info .six .columns -->
				
			</div><!-- .row info-wrap-->
		</div><!-- .footer-info -->
		
		<div class="scroll-to-top"></div><!-- .scroll-to-top -->
		
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<!-- Begin wp_footer() -->
<?php wp_footer(); ?>
<!-- End wp_footer() -->

</body>
</html>