<?php
/**
 * Leaf functions and definitions.
 *
 * @since Leaf 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Leaf 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 600;

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Leaf 1.0
 */
function leaf_setup() {

	/**
	 * Make Leaf available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Leaf, use a find and replace
	 * to change 'leaf' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'leaf', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add support for post formats.
	add_theme_support( 'post-formats', array( 'aside', 'audio', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );

	// This theme uses wp_nav_menu() in three locations.
	register_nav_menus( array(  // Register all nav menus.
		'primary' => __( 'Primary Menu', 'leaf' ),
		'header' => __('Header Menu - Top (No dropdowns)', 'leaf'),
		'footer' => __('Footer Menu (No dropdowns)', 'leaf'),
	) );

	// Add support for custom background.
	if ( function_exists('get_custom_header')) {
		// WordPress 3.4+.	
        add_theme_support('custom-background', array( 'default-color' => 'EEEEEE', 'default-image' => get_template_directory_uri() . '/images/body-BG.png' ) );
	} else {
		// Backwards Compatibility.
        add_custom_background();
	}
	
	// Enable support for Post Thumbnails.
	add_theme_support( 'post-thumbnails' );
	
	// Add custom image size.
	set_post_thumbnail_size( 300, 9999 );
	add_image_size( 'slider', 720, 9999 );
}
add_action( 'after_setup_theme', 'leaf_setup' );

/**
 * Enqueue scripts and styles for front-end.
 *
 * @since Leaf 1.0
 */
function leaf_scripts_styles() {
	global $post;
	$options = get_option('leaf_theme_options');

	// Load CSS file.
	wp_enqueue_style( 'leaf-style', get_stylesheet_uri() );
	
	// Load jQuery.
	wp_enqueue_script( 'jquery' );
	
	// Load jQuery scripts. 
	wp_enqueue_script( 'jquery-scripts', get_template_directory_uri() . '/js/scripts.js', array( 'jquery' ), '0', true );
	
	// Load jQuery plugins.
	wp_enqueue_script( 'jquery-plugins', get_template_directory_uri() . '/js/plugins.js', array( 'jquery' ), '0', true );
	
	// Load ivew slider on the front page.
	if ( is_front_page() ) {
		wp_enqueue_style( 'ivew-slider-css', get_template_directory_uri() . '/js/iView/css/iview.css', array(), '0', 'all' );
		wp_enqueue_script( 'ivew-slider-js', get_template_directory_uri() . '/js/iView/iview.min.js', array( 'jquery' ), '0', true );
		wp_enqueue_script( 'jquery-easing', get_template_directory_uri() . '/js/iView/jquery.easing.js', array( 'jquery' ), '0', true );
	}
	
	// Load Comment reply.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	// Load keyboard Image Navigation.
	if ( is_singular() && wp_attachment_is_image( $post->ID ) ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
	
	// Load Google Fonts.
	if ( empty ($options['leaf_google_fonts'])) {
		$client = is_ssl() ? 'https' : 'http';
		wp_enqueue_style( 'leaf-google-fonts', "$client://fonts.googleapis.com/css?family=Oswald:400|PT+Sans:400,700,400italic", array(), null );
	}
	
	// Load Modernizr.
	wp_enqueue_script( 'modernizr', get_template_directory_uri().'/js/modernizr-2.6.2.js', array(),'2.6.2');

}
add_action( 'wp_enqueue_scripts', 'leaf_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Leaf 1.0
 */
function leaf_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Site name.
	$title .= get_bloginfo( 'name' );

	// // Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Page number.
	if ( $paged >= 2 || $page >= 2 )
		$title =  "$title $sep " . sprintf( __( 'Page %s', 'leaf' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'leaf_wp_title', 10, 2 );

/**
 * wp_nav_menu() fallback to show a home link.
 *
 * @since Leaf 1.0
 */
function leaf_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'leaf_page_menu_args' );

/**
 * Mark post with no title as untitled.
 *
 * @since Leaf 1.0
 */
function leaf_no_title($title) {
    if ($title == '') {
        return 'Untitled';
    } else {
        return $title;
    }
}
add_filter('the_title', 'leaf_no_title');

/**
 * Add a class to the TinyMCE body based on sidebar layout.
 * Used to adjust content width in editor.css.
 *
 * @since Leaf 1.0
 */
function leaf_tinymce_before_init( $init_array ) {
	$options = get_option('leaf_theme_options');
	
	if ( isset ($options['leaf_sidebar_column']) && ($options['leaf_sidebar_column'] == 'Three') ) {
		$init_array['body_class'] = 'three-column';
	} else {
		$init_array['body_class'] = 'four-column';
	}
	return $init_array;
}
add_filter('tiny_mce_before_init', 'leaf_tinymce_before_init');


/**
 * Register our single widget area.
 *
 * @since Leaf 1.0
 */
function leaf_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'leaf' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages but not on the homepage when the homepage widget area has widgets.', 'leaf' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Homepage Sidebar', 'leaf' ),
		'id' => 'sidebar-home',
		'description' => __( 'Appears on the "default" homepage page, leave empty to use the main sidebar on the home page.', 'leaf' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Header Widget', 'leaf' ),
		'id' => 'sidebar-header',
		'description' => __( 'Appears inside the header area. Great for ads, search, or social buttons.', 'leaf' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );
	
	register_sidebar( array(
		'name' => __( 'Footer Area One', 'leaf' ),
		'id' => 'sidebar-3',
		'description' => __( 'An optional widget area for your site footer', 'leaf' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'leaf' ),
		'id' => 'sidebar-4',
		'description' => __( 'An optional widget area for your site footer', 'leaf' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'leaf' ),
		'id' => 'sidebar-5',
		'description' => __( 'An optional widget area for your site footer', 'leaf' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h3 class="widget-title"><span>',
		'after_title' => '</span></h3>',
	) );
}
add_action( 'widgets_init', 'leaf_widgets_init' );