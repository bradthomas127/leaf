<?php
/* Leaf theme options.
 *
 * @since Leaf 1.0
 */
$leaf_themename = "Leaf";
$leaf_shortname = "leaf";
$leaf_option_group = $leaf_shortname.'_theme_option_group';
$leaf_option_name = $leaf_shortname.'_theme_options';

/* Enqueue styles and scripts for the colorpicker.
 * @see function leaf_create_menu() below for action hook.
 *
 * @since Leaf 1.0
 */
function leaf_add_init() {

    $file_dir = get_template_directory_uri() . "/includes/admin/js/";
	wp_enqueue_style( 'farbtastic' );
	wp_enqueue_script("options-plugin", $file_dir . "options.js", array( 'farbtastic' ), '2012-09-22' );
}

/* Add theme options page to the admin menu.
 *
 * @since Leaf 1.0
 */
 
function leaf_create_menu() {
	global $leaf_themename, $leaf_page;
	
	//create new top-level menu.
	$leaf_page = add_theme_page( __( ' Leaf Options', 'leaf' ), __( 'Leaf Options','leaf' ), 'edit_theme_options', basename(__FILE__), 'leaf_settings_page' );
	
	// Adds leaf_add_help_tab when my_admin_page loads.
    add_action('load-'.$leaf_page, 'leaf_add_help_tab');
	// Using registered $leaf_page handle to hook script load.
	add_action('admin_print_styles-' . $leaf_page, 'leaf_add_init');
}
add_action('admin_menu', 'leaf_create_menu');

/* Register settings.
 *
 * @since Leaf 1.0
 */

function register_settings() {
	global $leaf_themename, $leaf_shortname, $version, $leaf_settings, $leaf_option_group, $leaf_option_name;
	//register our settings.
	register_setting( $leaf_option_group, $leaf_option_name, 'leaf_theme_options_validate');
}
add_action( 'admin_init', 'register_settings' );

/* Create theme options.
 *
 * @since Leaf 1.0
 */
global $leaf_settings;
	
$leaf_settings = array (

	array( "type" => "section" ),
			
	array("type" => "open"),

	array(  "name" => __( 'Theme Layout','leaf'), 'id' => $leaf_shortname.'_theme_layout', 'type' => 'select',
			"desc" => __( 'Choose Your theme layout.','leaf'),
			'std' => 'boxed',
			'value' => array( 'boxed', 'wide')),		
			
	array(  'name' => __('Theme Accent Color','leaf'), 'id' => $leaf_shortname.'_highlight_color', 'type' => 'ctext',
			"desc" => __( 'Changes the theme accent color (Default #C4302B)','leaf'),
			'std' => '#C4302B'),
			
	array(  "name" => __( "Google Fonts",'leaf'), "id" => $leaf_shortname."_google_fonts", "type" => "checkbox",
			"desc" => __( "Check to remove Google Fonts. (Oswald and PT Sans)",'leaf')),

	array(  "name" => __( 'Slider Category','leaf'), 'id' => $leaf_shortname.'_slider_cat', 'type' => 'select-cat',
			"desc" => __( 'Select a single category or all categories for the slider.','leaf'),
			'std' => ''),
	
	array(  "name" => __( 'Slider transition effects','leaf'), 'id' => $leaf_shortname.'_slider_transition', 'type' => 'select',
			"desc" => __( 'Slider transition effects.','leaf'),
			'std' => 'random',
			'value' => array( 'random', 'slide-in-left', 'block-expand', 'block-random', 'left-curtain' )),

	array(  "name" => __( 'Slider speed','leaf'), 'id' => $leaf_shortname.'_slider_speed', 'type' => 'select',
			"desc" => __( 'Slider speed in milliseconds.','leaf'),
			'std' => '7000',
			'value' => array( '7000', '5000', '9000',)),
	 		
	array(  "name" => __( 'Sidebar Column','leaf'), 'id' => $leaf_shortname.'_sidebar_column', 'type' => 'select',
			"desc" => __( 'Sidebar column width.','leaf'),
			'std' => 'Four',
			'value' => array( 'Four', 'Three')),

	array(  "name" => __( 'Home Page Categories','leaf'), 'id' => $leaf_shortname.'_home_cats', 'type' => 'multi-select',
			"desc" => __( 'You can choose multiple categories by holding the <code>Ctrl</code> key while selecting.','leaf'),
			'std' => ''),
			
	array(  "name" => __( 'Number of More Articles','leaf'), 'id' => $leaf_shortname.'_more_articles_number', 'type' => 'select',
			"desc" => __( 'Number of post to display in the more articles section on the "default" home page.','leaf'),
			'std' => '2',
			'value' => array( '2', '3', '4', '5', '6', '7', '8', '9', '10')),

	array( "name" => __( 'Custom CSS ','leaf'),
			"desc" => __( 'The most important use for this area is to enter custom CSS rules to control the look of your site.','leaf'),
			'id' => $leaf_shortname.'_header_css',
			'type' => 'textarea'),
			
	array( "type" => "save-opts"),
	
	array("type" => "close"),
	
);

function leaf_settings_page() {
	global $leaf_themename, $leaf_shortname, $version, $leaf_settings, $leaf_option_group, $leaf_option_name;
?>
	<?php screen_icon('options-general'); ?><h2><?php echo $leaf_themename; ?> <?php _e('Theme Options','leaf'); ?></h2>
	<p class="top-notice"><u><?php _e('Refer to the contextual help screen in the top right hand corner for help with the theme. ','leaf'); ?></u></p>
	
	<?php if ( isset ( $_POST['reset'] ) ):
		// Delete Settings
		global $wpdb, $leaf_themename, $leaf_shortname, $version, $leaf_settings, $leaf_option_group, $leaf_option_name;

		delete_option('leaf_theme_options');
		wp_cache_flush();
		?>

		<div class="updated fade"><p><strong><?php _e( 'Leaf options reset.','leaf' ); ?></strong></p></div>
	<?php elseif ( isset ( $_REQUEST['updated'] ) ): ?>
		<div class="updated fade"><p><strong><?php _e( 'Leaf options saved.','leaf' ); ?></strong></p></div>
	<?php endif; ?>

	<form method="post" action="options.php">
		<?php settings_fields( $leaf_option_group ); ?>
		<?php $options = get_option( $leaf_option_name ); ?>
		<?php foreach ($leaf_settings as $value) {
			if ( isset($value['id']) ) { $valueid = $value['id'];}
			switch ( $value['type'] ) {

				case "section": ?>

					<div class="wrap">
						<table class="form-table">
							<div class="section_body">
								<?php
								break;
	
								case 'text': // Text Box. ?>
									<tr valign="top">
										<th scope="row"><label for="<?php echo $leaf_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></th>
										<td><input name="<?php echo $leaf_option_name.'['.$valueid.']'; ?>" type="<?php echo $value['type']; ?>" id="<?php echo $leaf_option_name.'['.$valueid.']'; ?>" value="<?php if ( isset( $options[$valueid]) ){ esc_attr_e( stripslashes($options[$valueid])); } else { esc_attr_e( stripslashes($value['std'])); } ?>" />
										<p class="description"><?php echo $value['desc']; ?></p></td>
									</tr>

								<?php
								break;

								case 'ctext':    // Color Picker. ?>

									<tr valign="top">
										<th scope="row"><label for="<?php echo $leaf_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></th>
										<td>
											<input type="text" name="<?php echo $leaf_option_name.'['.$valueid.']'; ?>" id="link-color" value="<?php if ( isset( $options[$valueid]) ){ esc_attr_e( stripslashes($options[$valueid])); } else { esc_attr_e( stripslashes($value['std'])); } ?>" />
											<a href="#" class="pickcolor hide-if-no-js" id="link-color-example" style="border: 1px solid #dfdfdf; margin: 0 7px 0 3px; padding: 3px 12px; border-radius: 5px;"></a>
											<input type="button" class="pickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'leaf' ); ?>" />
											<div id="colorPickerDiv" style="z-index: 100; background:#eee; border:1px solid #ccc; position:absolute; display:none;"></div>
											<p class="description"><?php echo $value['desc']; ?></p>
										</td>
									</tr>

								<?php
								break;

								case 'textarea':	// Textarea. ?>
									<tr valign="top">
										<th scope="row"><?php echo $value['name']; ?></th>
										<td>
											<fieldset>
												<p class="description"><label for="<?php echo $leaf_option_name.'['.$valueid.']'; ?>"><?php echo $value['desc']; ?></label></p>
													
												<p>
													<textarea name="<?php echo $leaf_option_name.'['.$valueid.']'; ?>" id="<?php echo $leaf_option_name.'['.$valueid.']'; ?>" rows="10" cols="50" class="large-text code" type="<?php echo $leaf_option_name.'['.$valueid.']'; ?>"><?php if ( isset( $options[$valueid]) ){ esc_attr_e( stripslashes($options[$valueid])); }?></textarea>
												</p>
											</fieldset>
										</td>
									</tr>
										
								<?php
								break;

								case 'select':		// Select Drop downs. ?>

									<tr valign="top">
										<th scope="row"><label for="<?php echo $leaf_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></th>
										<td>
											
											<select name="<?php echo $leaf_option_name.'['.$valueid.']'; ?>" id="<?php echo $leaf_option_name.'['.$valueid.']'; ?>">
										
												<?php foreach ($value['value'] as $option) { ?>
													<option<?php selected($options[$valueid] == $option ) ?>><?php echo $option; ?></option>
												<?php } ?>
											</select>
											<p class="description"><?php echo $value['desc']; ?></p>
										</td>
									</tr>

								<?php
								break;
								
								case 'select-cat':		// Category Select Drop downs. ?>

									<tr valign="top">
										<th scope="row"><label for="<?php echo $leaf_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></th>
										<td>
											<?php wp_dropdown_categories(array('name' => 'leaf_theme_options[leaf_slider_cat]', 'selected' => $options['leaf_slider_cat'], 'orderby' => 'Name' ,'show_option_none' => 'All Categories', 'hide_empty' => 1 )); ?>
											<p class="description"><?php echo $value['desc']; ?></p>
										</td>
									</tr>

								<?php
								break;

								case 'multi-select':	// Multi-Select Drop downs. ?>

									<tr valign="top">
										<th scope="row"><label for="<?php echo $leaf_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></th>
										<td>
											
											<select name="leaf_theme_options[leaf_home_cats][]" id="multi-categories" multiple="multiple" size="8" style="min-width:200px;">
										
												<?php /* Get the list of categories */
												$select_cats = (!empty($options[$valueid])) ? ($options[$valueid]) : '';
												$categories = get_categories();
													
												foreach ( $categories as $category) :
												?>
													<option value="<?php echo $category->cat_ID; ?>" <?php if ( selected( $select_cats && in_array( $category->cat_ID, $select_cats ) ) ) ?>><?php echo $category->cat_name; ?></option>
													
												<?php endforeach; ?>
													
											</select>
											<p class="description"><?php echo $value['desc']; ?></p>
										</td>
									</tr>
										
								<?php
								break;

								case "checkbox":	// Check Boxes. ?>
								
									<tr valign="top">
										<th scope="row"><?php echo $value['name']; ?></th>
										<td>
											<fieldset>
												<label for="<?php echo $leaf_option_name.'['.$valueid.']'; ?>">
													<input type="checkbox" name="<?php echo $leaf_option_name.'['.$valueid.']'; ?>" id="<?php echo $leaf_option_name.'['.$valueid.']'; ?>" value="1" <?php if( isset( $options[$valueid] ) ){checked($options[$valueid]);} ?> />
													<?php echo $value['desc']; ?>
												</label>
											</fieldset>
										</td>
									</tr>
										
								<?php
								break;
										
								case "save-opts": ?>
									
									<tr valign="top">
										<td>
											<input class="button button-primary" type="submit" name="save" value="<?php _e('Save All Changes', 'leaf') ?>" />
										</td>
									</tr>	
									
								<?php break;

								case "close":	?>
								
							</div><!--#section_body-->
						</table>
					</div><!--.wrap-->
					
				<?php
				break;
			}
		} ?>
	</form>
				
	<table class="form-table">
		<tr valign="top">

			<td>
				<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
					<input type="hidden" name="cmd" value="_s-xclick">
					<input type="hidden" name="hosted_button_id" value="FJA4KZTFMXQG8">
					<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
				</form>
				<p style="color: #777; margin-top: -5px;"><?php _e('Like the Theme? Help it stay up to date.','leaf'); ?><p>
			</td>
											
			<td>
				<form method="post" action="" onSubmit="return confirm('Are you sure you want to reset all Leaf settings?');">
					<span style="float: right; padding: 0px;" class="submit">
						<input class="button" style="background:#C4302B; border-color:#7c1612; color:#FFF; font-weight: bold;text-shadow: rgba(0, 0, 0, 0.3) 0 -1px 0;
						"type="submit" name="reset" value="<?php _e('Reset / Delete Settings', 'leaf') ?>" />
						<input type="hidden" name="action" value="reset" />
						<p class="description"><?php _e('<font color#222><b>Caution:</b></font> All entries will be deleted from database.','leaf') ?></p>
					</span>
				</form>
			</td>
											
		</tr>
	</table>
				
<?php
} // <= leaf_settings_page. 

/**
 * Validates the theme's options upon submission.
 *
 * @since Leaf 1.0
 */

function leaf_theme_options_validate( $input ) {
	global $leaf_settings;
	foreach ( $leaf_settings as $value ) {
		switch ( $value['type'] ) {
			case 'select':
				$input[$value['id']] = wp_filter_nohtml_kses( $input[$value['id']] );
				break;
			case 'select-cat':
				$input[$value['id']] = wp_filter_nohtml_kses( $input[$value['id']] );
				break;
			case 'ctext':
				if ( isset($input[$value['id']]) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input[$value['id']] )) {  
					$input[$value['id']] = $input[$value['id']];  
				} else {
					$input[$value['id']] = $input[$value['std']];
				}
				break;
			case 'text':
				$input[$value['id']] = wp_filter_post_kses( $input[$value['id']] );
				break;
			case 'textarea':
				$input[$value['id']] = wp_filter_post_kses( $input[$value['id']] );
				break;
			case 'checkbox':
				if (!isset($input[$value['id']])) {  
                        $input[$value['id']] = 0;  
                    }  
                    // Our checkbox value is either 0 or 1  
                    $input[$value['id']] = ( $input[$value['id']] == 1 ? 1 : 0 );
				break;
		}
	}
	return $input;
}

/**
 * Add a custom style block to the header.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since Leaf 1.0
 */
function leaf_print_custom_style() {
	$options = get_option('leaf_theme_options');

	if ( isset ($options['leaf_theme_layout']) && ($options['leaf_theme_layout'] != 'boxed') ) {
		$layoutOpts = '#page { max-width: 100%; margin-top: 0px; margin-bottom: 0px; box-shadow: none;}';
	} else { $layoutOpts = ''; }
	
	$optColor = ($options['leaf_highlight_color']);
	if ( isset ($options['leaf_highlight_color']) &&  ($options['leaf_highlight_color'] != '#C4302B') ) {
		$accent = "a:hover, .site-header h1 a:hover, .site-header h2 a:hover, .comments-link a:hover, .entry-meta a:hover, .widget-area .widget a:hover, .footer-navigation li a:hover, .copyright a:hover, .site-info a:hover, .comment-content .reply a:hover, #respond #submit:hover { color: $optColor;}" . "\n";
		$accent .= ".image-tag, .aside-format, .audio-format, .gallery-format, .image-format, .link-format, .video-format, .search-bar .submit, .iview-caption.caption3, .pagination .current, .pagination a:hover { background-color: $optColor;}" . "\n";
		$accent .= ".search-bar:after {border-right-color: $optColor;}" . "\n";
	} else { $accent = ''; }

	if ( isset ($options['leaf_header_css']) &&  ($options['leaf_header_css'] != '') ) {
		$customCss = $options['leaf_header_css'];
	} else { $customCss = ''; }

	/* If options are empty return */
	if ( $layoutOpts == '' && $accent == '' && $customCss == '' )
		return;

	$output = '<!-- Begin Leaf css -->' . "\n";
	$output .= '<style type="text/css">' . "\n";
	$output .= $layoutOpts . "\n";
	$output .= $accent . "\n";
	$output .= "\n";
	$output .= $customCss . "\n";
	$output .= '</style>' . "\n";
	$output .= '<!-- End Leaf css -->' . "\n";
	echo stripslashes($output);

}
add_action( 'wp_head', 'leaf_print_custom_style' );
?>