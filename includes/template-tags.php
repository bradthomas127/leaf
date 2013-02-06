<?php
/**
 * Custom template tags for this theme.
 *
 * @since Leaf 1.0
 */

/**
 * Extends the default WordPress body class.
 *
 * @since Leaf 1.0
 */
function leaf_body_class( $classes ) {

	if ( is_page_template( 'tmp-one-column.php' ) )
		$classes[] = 'one-column';

	if ( is_page_template( 'blog.php' ) )
		$classes[] = 'main-blog';
		
	if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
		$classes[] = 'single-author';

	return $classes;
}
add_filter( 'body_class', 'leaf_body_class' );

/**
 * Display navigation to next/previous pages when applicable.
 *
 * @uses next_posts_link
 * @uses previous_posts_link
 *
 * @since Leaf 1.0
 */
if ( ! function_exists( 'leaf_content_nav' ) ) :

function leaf_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'leaf' ); ?></h3>
			<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'leaf' ) ); ?></div>
			<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'leaf' ) ); ?></div>
		</nav><!-- #nav-above -->
	<?php endif;
}
endif; // leaf_content_nav

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own leaf_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Leaf 1.0
 */
if ( ! function_exists( 'leaf_comment' ) ) :

function leaf_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	switch ( $comment->comment_type ) :
		case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
			<div id="comment-<?php comment_ID(); ?>" class="comment-body">
				<div class="comment-avatar">
					<?php echo get_avatar( $comment, 50 ); ?>
				</div>     
				<div class="comment-content">
					<div class="comment-author">
						<?php echo get_comment_author_link() . ' '; ?>
					</div>
					<div class="comment-meta">
						<?php
						printf( __( '%1$s at %2$s', 'leaf' ), get_comment_date(), get_comment_time() ); 
						edit_comment_link( __( '(edit)', 'leaf' ), '  ', '' );
						?>
					</div>
					<div class="comment-text">
						<?php if ( '0' == $comment->comment_approved ) { echo '<em>' . __( 'Your comment is awaiting moderation.', 'leaf' ) . '</em>'; } ?>
						<?php comment_text() ?>
					</div>
					<?php if ( $args['max_depth'] != $depth && comments_open() && 'pingback' != $comment->comment_type ) { ?>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php
			break;

		case 'pingback'  :
		case 'trackback' :
		?>
		<li class="pingback">
			<div class="comment-body">
				<?php _e( 'Pingback:', 'leaf' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(edit)', 'leaf' ), ' ' ); ?>
			</div>
			<?php
			break;
	endswitch;
}
endif;  // ends check for leaf_comment()

/**
* Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
*
* Create your own leaf_entry_meta() to override in a child theme.
*
* @since Leaf 1.0
*/
if ( ! function_exists( 'leaf_entry_meta' ) ) :

function leaf_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'leaf' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'leaf' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date updated" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date('F j, Y') )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'leaf' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 author's name, 2 category, 3 tag's, and 4 is the date.
	if ( '' != $tag_list ) {
		$utility_text = __( '<span class="posted-by">Posted by: %1$s </span><span class="spacer">//</span> %2$s <span class="spacer">//</span> %3$s <span class="spacer">//</span> %4$s', 'leaf' );
	} elseif ( ! empty( $categories_list ) && leaf_is_categorized_site() ) {
		$utility_text = __( '<span class="posted-by">Posted by: %1$s </span><span class="spacer">//</span> %2$s <span class="spacer">//</span> %4$s', 'leaf' );
	} else {
		$utility_text = __( '<span class="posted-by">Posted by: %1$s </span> //  %4$s', 'leaf' );
	}

	printf(
		$utility_text,
		$author,
		$categories_list,
		$tag_list,
		$date
	);
}
endif;

/**
 * Returns true if a blog has more than one category.
 *
 * @uses get_categories
 *
 * @since Leaf 1.0
 */
if ( ! function_exists( 'leaf_is_categorized_site' ) ) :

function leaf_is_categorized_site() {
	$non_empty_categories = get_categories( array(
		'hide_empty' => 1,
	) );

	if ( is_wp_error( $non_empty_categories ) || empty( $non_empty_categories ) || count( $non_empty_categories ) < 1 )
		return false;

	return true;
}
endif;

/**
 * Get our wp_nav_menu() to have a ul class for superfish and mobile menu.
 *
 * @since Leaf 1.0
 */
function leaf_menu_ul_class($ulclass) {
	return preg_replace('/<ul>/', '<ul class="sf-menu">', $ulclass, 1);
}
add_filter('wp_page_menu','leaf_menu_ul_class');

/**
 * Adjust content and sidebar grid width.
 *
 * @uses get_option('leaf_theme_options');
 *
 * @since Leaf 1.0
 */
if ( ! function_exists( 'leaf_grid_width' ) ) :
 
function leaf_grid_width( $grid_type ) {
	$options = get_option('leaf_theme_options');
	
	if ( 'sidebar' == $grid_type ) :
		
		if ( isset ($options['leaf_sidebar_column']) && ($options['leaf_sidebar_column'] == 'Three') ) {
			$columns = 'three';
		} else {
			$columns = 'four';
		}
		return $columns;
		
	else :
	
		if ( isset ($options['leaf_sidebar_column']) && ($options['leaf_sidebar_column'] == 'Three') ) {
			$columns = 'nine';
		} else {
			$columns = 'eight';
		}
		return $columns;
	
	endif; // if 'sidebar' == $grid_type
}
endif;

/**
 * Enable dynamic classes for the sidebars in the footer.
 *
 * @uses is_active_sidebar();
 *
 * @since Leaf 1.0
 */
if ( ! function_exists( 'leaf_footer_sidebar_class' ) ) :
 
function leaf_footer_sidebar_class() {
	$count = 0;
	if ( is_active_sidebar( 'sidebar-3' ) ) $count++;
	if ( is_active_sidebar( 'sidebar-4' ) ) $count++;
	if ( is_active_sidebar( 'sidebar-5' ) ) $count++;

	$class = '';
	switch ( $count ) {
		case '1':
			$class = 'footer-sidebar one';
			break;
		case '2':
			$class = 'footer-sidebar two';
			break;
		case '3':
			$class = 'footer-sidebar three';
			break;
	}
	if ( $class )
		echo 'class="' . $class . '"';
}
endif;

/**
 * Adjust content width for the one column template and sidebar adjustments.
 *
 * @uses get_option('leaf_theme_options');
 *
 * @since Leaf 1.0
 */
function leaf_adjust_content_width() {
	global $content_width;
	$options = get_option('leaf_theme_options');
	
	if ( isset ($options['leaf_sidebar_column']) && ($options['leaf_sidebar_column'] == 'Three') ) {
		$content_width = 680;
	}
	
	if ( is_page_template( 'tmp-one-column.php' ) ) {
		$content_width = 960;
	}
}
add_action( 'template_redirect', 'leaf_adjust_content_width' );