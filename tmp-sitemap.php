<?php
/**
 * Template Name: Sitemap
 * Description: Displays an HTML-based sitemap for your site.
 *
 * @since Leaf 1.0
 */

get_header(); ?>

		<section id="primary" class="site-content <?php echo leaf_grid_width( 'content' ); ?> columns">
			<div id="content" role="main">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
					
					<h3 class="divider-title">
						<span><?php _e( 'Pages', 'leaf'  ); ?></span>
					</h3><!-- .divider-title -->
					
					<div class="sitemap-body">
						<ul><?php wp_list_pages("title_li=" ); ?></ul>
					</div><!-- .sitemap-body -->
					
					<h3 class="divider-title">
						<span><?php _e( 'Feeds', 'leaf'  ); ?></span>
					</h3><!-- .divider-title -->
					
					<div class="sitemap-body">
						<ul>
							<li><a title="Full content" href="feed:<?php bloginfo('rss2_url'); ?>">Main RSS</a></li>
							<li><a title="Comment Feed" href="feed:<?php bloginfo('comments_rss2_url'); ?>">Comment Feed</a></li>
						</ul>
					</div><!-- .sitemap-body -->
					
					<h3 class="divider-title">
						<span><?php _e( 'Categories', 'leaf'  ); ?></span>
					</h3><!-- .divider-title -->
					
					<div class="sitemap-body">
						<ul><?php wp_list_categories('sort_column=name&optioncount=1&hierarchical=0&title_li='); ?></ul>
					</div><!-- .sitemap-body -->
					
					<h3 class="divider-title">
						<span><?php _e( 'Blog Posts', 'leaf'  ); ?></span>
					</h3><!-- .divider-title -->
					
					<div class="sitemap-body">
						<ul><?php $archive_query = new WP_Query('showposts=1000&cat=-8');
							while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
								<li>
									<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?> (<?php comments_number('0', '1', '%'); ?>)</a>
								</li>
							<?php endwhile; ?>
						</ul>
					</div><!-- .sitemap-body -->
					
					<h3 class="divider-title">
						<span><?php _e( 'Archives', 'leaf'  ); ?></span>
					</h3><!-- .divider-title -->
					
					<div class="sitemap-body">
						<ul>
							<?php wp_get_archives('type=monthly&show_post_count=true'); ?>
						</ul>
					</div><!-- .sitemap-body -->
					
					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'leaf' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
					
				</article><!-- #post-<?php the_ID(); ?> -->
			</div><!-- #content -->
		</section><!-- #primary .site-content .<?php echo leaf_grid_width( 'content' ); ?> .columns -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>