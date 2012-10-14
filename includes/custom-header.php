<?php
/**
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @uses leaf_header_style()
 * @uses leaf_admin_header_style()
 * @uses leaf_admin_header_image()
 *
 * @since Leaf 1.0
 */
function leaf_custom_header_setup() {
	$args = array(
		'default-image'          => get_template_directory_uri() . '/images/leaf-header.png',
		'default-text-color'     => '555',
		'width'                  => 300,
		'height'                 => 90,
		'max-width'              => 460,
		'header-text'			 => false,
		'flex-height'            => true,
		'flex-width'             => true,
		'random-default'         => false,
		'wp-head-callback'       => 'leaf_header_style',
		'admin-head-callback'    => 'leaf_admin_header_style',
		'admin-preview-callback' => 'leaf_admin_header_image',
	);

	$args = apply_filters( 'leaf_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}
}
add_action( 'after_setup_theme', 'leaf_custom_header_setup' );

/**
 * Shiv for get_custom_header().
 *
 * get_custom_header() was introduced to WordPress
 * in version 3.4. To provide backward compatibility
 * with previous versions, we will define our own version
 * of this function.
 *
 * @return stdClass All properties represent attributes of the curent header image.
 *
 * @since Leaf 1.0
 */

if ( ! function_exists( 'get_custom_header' ) ) :

function get_custom_header() {
	return (object) array(
		'url'           => get_header_image(),
		'thumbnail_url' => get_header_image(),
		'width'         => HEADER_IMAGE_WIDTH,
		'height'        => HEADER_IMAGE_HEIGHT,
	);
}
endif; // get_custom_header 

/**
 * Styles the header image and text displayed on the blog
 *
 * @see leaf_custom_header_setup().
 *
 * @since Leaf 1.0
 */
if ( ! function_exists( 'leaf_header_style' ) ) : 

function leaf_header_style() {

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == get_header_textcolor() )
		return;
	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == get_header_textcolor() ) :
	?>
		.site-title,
		.site-description {
			position: absolute !important;
			clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo get_header_textcolor(); ?> !important;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // leaf_header_style

/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @since Leaf 1.0
 */
if ( ! function_exists( 'leaf_admin_header_style' ) ) :

function leaf_admin_header_style() {
?>
	<style type="text/css">
	.appearance_page_custom-header #headimg {
		border: none;
	}
	#headimg h1,
	#desc {
		line-height: 1.6;
		margin: 0;
		padding: 0;
	}
	#headimg h1 {
		font-size: 26px;
	}
	#headimg h1 a {
		color: #555;
		text-decoration: none;
	}
	#desc {
		color: #666;
		font-family: Helvetica, Arial, sans-serif;
		font-size: 13px;
		margin-bottom: 20px;
	}
	#headimg img {
		max-width: <?php echo get_theme_support( 'custom-header', 'max-width' ); ?>px;
	}

	</style>
<?php
}
endif; // leaf_admin_header_style

/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see leaf_custom_header_setup().
 *
 * @since Leaf 1.0
 */
if ( ! function_exists( 'leaf_admin_header_image' ) ) :
 
function leaf_admin_header_image() { ?>
	<div id="headimg">
		<?php $header_image = get_header_image();
		if ( ! empty( $header_image ) || 'blank' == get_header_textcolor() || '' == get_header_textcolor() )
			$style = ' style="display:none;"';
		else
			$style = ' style="color:#' . get_header_textcolor() . ';"';
		?>
		<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php
		if ( ! empty( $header_image ) ) : ?>
			<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
		<?php endif; ?>
	</div>
<?php }
endif; // leaf_admin_header_image