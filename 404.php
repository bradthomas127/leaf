<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @since Leaf 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content row eight centered">
		<div id="content" role="main">

			<article id="post-0" class="post error404 not-found">
				<header class="entry-header">
					<hgroup>
						<h1 class="entry-404"><?php _e( '404', 'leaf' ); ?></h1>
						<h2 class="entry-heading"><?php _e( 'Oops!', 'leaf' ); ?></h2>
						<h3 class="entry-title"><?php _e( 'We are really sorry but the page you requested can not be found.', 'leaf' ); ?></h3>
					</hgroup>
				</header>

				<div class="entry-content">
					<p><?php _e( 'It seems that the page you were trying to reach does not exist anymore, or maybe it has moved, we think the best thing to do is to start again from the home page or try searching for the page.', 'leaf' ); ?></p>
					
					<div class="home-search404 row">
						
						<div class="home-button404 six columns">
							<a href="<?php echo home_url('/') ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>"><?php bloginfo('name'); ?></a>
						</div><!-- .home-button404 .six .columns -->
						
						
						<div class="search404 six columns">
							<?php get_search_form(); ?>
						</div><!-- .search404 -->
					
					</div><!-- .home-search404 .row -->

				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary .site-content .row .eight .centered -->

<?php get_footer(); ?>