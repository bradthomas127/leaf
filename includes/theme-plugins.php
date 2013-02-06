<?php
/**
 * Custom plugins for this theme.
 *
 * @since Leaf 1.0
 */

/**
 * Post thumbnail slider plugin.
 *
 * @Author: Hemn Chawroka
 * @Link: http://iprodev.com/2012/07/iview/
 * @License: MIT License
 *
 * @since Leaf 1.0
 */
function leaf_ivew_slider_plugin() {
	$options = get_option('leaf_theme_options');
	$effects = (!empty($options['leaf_slider_transition'])) ? ($options['leaf_slider_transition']) : 'random';
	$speed = (!empty($options['leaf_slider_speed'])) ? ($options['leaf_slider_speed']) : '7000';
	$timer = (!empty($options['leaf_highlight_color'])) ? ($options['leaf_highlight_color']) : '#C4302B';
	
	if ( is_home() || is_front_page() ) { ?>
	
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('#iview').iView({
					fx: '<?php echo $effects; ?>', // Slider transition.
					captionSpeed: 700, // Caption transition speed.
					captionEasing: 'easeInExpo',
					pauseTime: <?php echo $speed; ?>, // Slider speed.
					pauseOnHover: true,
					directionNavHoverOpacity: 0,
					timer: "Bar",
					timerDiameter: "100%",
					timerX: 1,
					timerY: 0,
					timerPadding: 0,
					timerOpacity: 0.6,
					timerStroke: 7,
					timerBarStroke: 0,
					timerColor: '<?php echo $timer; ?>',
					timerPosition: "bottom-right"
				});
			});
		</script>
		
	<?php
	}
}
add_action('wp_footer','leaf_ivew_slider_plugin',30);

/**
 * Display pagination when applicable
 *
 * @Author: kriesi
 * @Link: http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin
 *
 * @uses get_pagenum_link
 *
 * @since Leaf 1.0
 */
if (!function_exists('leaf_pagination')):

	function leaf_pagination($pages = '', $range = 5) {   /* handle pagination for post pages*/
		$showitems = ($range * 2)+1;  
		 
		global $paged;
		if(empty($paged)) $paged = 1;
		 
			if($pages == '') {
				global $wp_query;
				$pages = $wp_query->max_num_pages;
				if(!$pages) {
					$pages = 1;
				}
			}   
		 
			if(1 != $pages)
			{
				echo "<div class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
				if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
				if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
		 
				for ($i=1; $i <= $pages; $i++)
				{
					if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
					{
						 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
					}
				}
		 
				if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a>";
				if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
				echo "</div>\n";
			}
	} //  leaf_pagination
endif;

/**
 * Set Featured Image automaticly on publish.
 *
 * @Author: Frank Bültge
 * @Link: https://gist.github.com/2930032
 *
 * @uses has_post_thumbnail
 * @uses set_post_thumbnail
 *
 * @since Leaf 1.0
 */

function leaf_automatic_featured_image() {

	if ( ! isset( $GLOBALS['post']->ID ) )
		return NULL;
				
	if ( has_post_thumbnail( get_the_ID() ) )
		return NULL;
	
	$args = array(
		'numberposts'    => 1,
		'order'          => 'DESC', // DESC for the last image
		'post_mime_type' => 'image',
		'post_parent'    => get_the_ID(),
		'post_status'    => NULL,
		'post_type'      => 'attachment'
	);
			
	$attached_image = get_children( $args );
	if ( $attached_image ) {
		foreach ( $attached_image as $attachment_id => $attachment )
			set_post_thumbnail( get_the_ID(), $attachment_id );
	}
			
}
add_action( 'save_post', 'leaf_automatic_featured_image' );

/**
 * Return URL of an image based on Post ID
 *
 * First checks for featured image, then checks for any attached image, finally defaults to IMAGES_URL/nophoto.jpg
 *
 * @Author: Brian Richards
 * @Link: http://wpstartbox.com/
 *
 * @uses has_post_thumbnail
 * @uses get_post_thumbnail_id
 * @uses wp_get_attachment_image_src
 *
 * @since Leaf 1.0
 *
 */
if (!function_exists('leaf_get_post_image')):
 
	function leaf_get_post_image($image_id = null, $post_id = null, $use_attachments = false, $url = null, $size = 'large') {
		global $id,$blog_id;
		$thumbnail_id = get_post_thumbnail_id();
		$post_id = ( $post_id == null ) ? $id : $post_id;
		$attachment = array();

		// If a URL is specified, use that.
		if ($url)
			return $url;

		// If image_id is specified, use that.
		elseif ($image_id)
			$attachment = wp_get_attachment_image_src( $image_id, $size );
			
		// Check to see if NextGen Gallery is present.
		elseif(stripos($thumbnail_id,'ngg-') !== false && class_exists('nggdb')){
			$nggImage = nggdb::find_image(str_replace('ngg-','',$thumbnail_id));
			$attachment = array(
				$nggImage->imageURL,
				$nggImage->width,
				$nggImage->height
			);
		}
		
		// If not, let's use the post's featured image.
		elseif ( has_post_thumbnail( $post_id) )
			$attachment = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), $size );

		// Otherwise, and only if we want to, just use the last image attached to the post.
		elseif ( $use_attachments == true ) {
			$images = get_children(array(
				'post_parent' => $post_id,
				'post_type' => 'attachment',
				'numberposts' => 1,
				'post_mime_type' => 'image'));
			foreach($images as $image) { $attachment = wp_get_attachment_image_src( $image->ID, $size ); }
		}

		// If there is no image, use the default image (available filter: leaf_post_image_none).
		
		if (isset($attachment[0])) {
			$post_image_uri = $attachment[0];
		} elseif ( 'slider' == $size ) {
			$post_image_uri = apply_filters( 'leaf_slider_image_none', get_template_directory_uri() . '/images/no-image.jpg' );
		} else {
			$post_image_uri = apply_filters( 'leaf_post_image_none', get_template_directory_uri() . '/images/no-image-small.jpg' );
		}
		
		// If no image, return now
		if ( $post_image_uri == apply_filters( 'leaf_slider_image_none', get_template_directory_uri() . '/images/no-image.jpg' ) || apply_filters( 'leaf_post_image_none', get_template_directory_uri() . '/images/no-image-small.jpg' ) )
			return $post_image_uri;

		// If MU/MS install, we need to dig a little deeper and link through the blogs.dir.
		if ('IS_MU') {
			$imageParts = explode('/files/', $post_image_uri);
			if (isset($imageParts[1])) {
				$post_image_uri = '/blogs.dir/' . $blog_id . '/files/' . $imageParts[1];
			}
		}

		return $post_image_uri;
	}
endif;

/*
 * Add Widgets inside header if active.
 *
 * @since Leaf 1.0
 */

function leaf_header_widgets() {

	 if ( is_active_sidebar( 'sidebar-header' ) ) : ?>
		<div class="widget-area six columns" role="complementary">
			
			<?php dynamic_sidebar( 'sidebar-header' ); ?>
			
		</div><!-- .widget-area .six .columns -->
	<?php endif;

}
add_filter('leaf_header_inside','leaf_header_widgets');

/*
 * Add Scroll-to-Top to Footer.
 *
 * @since Leaf 1.0
 */
 
function leaf_scroll_top() { ?>

	<script type="text/javascript">
		jQuery(document).ready(function($){
			if ($(window).scrollTop() != "0")
				$(".scroll-to-top").fadeIn(1200)
			var scrollDiv = $(".scroll-to-top");
			$(window).scroll(function()
			{
				if ($(window).scrollTop() == "0")
					$(scrollDiv).fadeOut(350)
				else
					$(scrollDiv).fadeIn(1200)
			});
			$(".scroll-to-top").click(function(){
				$("html, body").animate({
					scrollTop: 0
				}, 600)
			})
		});
	</script>
<?php
}
add_action('wp_footer','leaf_scroll_top',30);

/* 
 * Add new HTML container element around video embeds 
 * to allow for CSS scaling of videos.
 *
 * @Author: Kevin Leary
 *
 * @since Leaf 1.0 
 */ 
function leaf_modify_embed_output( $html, $url ) { 
	$resize = false; 
	$accepted_providers = array( 
		'dailymotion', 
		'hulu.com', 
		'slideshare',		
		'vimeo', 
		'youtube',
		'youtu.be',
	); 
	 
	// Check each provider. 
	foreach ( $accepted_providers as $provider ) { 
		if ( strstr( $url, $provider ) ) { 
			$resize = true; 
			break; 
		} 
	} 

	// Not an accepted provider. 
	if ( ! $resize ) 
		return $html; 

		$embed = trim( $html ); 

		// Add container around the video, use a <p> to avoid conflicts with wpautop() 
		$html = "<p class=\"flex-video\">$embed</p>\n"; 
 
	return $html; 
} 
add_filter( 'embed_oembed_html', 'leaf_modify_embed_output', 10, 2 );