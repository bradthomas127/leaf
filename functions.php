<?php
/**
 * Leaf add functions and definitions.
 *
 * @since Leaf 1.0
 */

/* load theme functions. */
require( get_template_directory() . '/includes/theme-functions.php' );

/* Add theme options. */
require( get_template_directory() . '/includes/admin/theme-options.php' );
 
/* Custom template tags for this theme. */
require( get_template_directory() . '/includes/template-tags.php' );

/* Add support for a custom header image. */
require( get_template_directory() . '/includes/custom-header.php' );

/* Add theme plugins. */
require( get_template_directory() . '/includes/theme-plugins.php' );

/* Custom action hooks for this theme. */
require( get_template_directory() . '/includes/hooks.php' );

/* Add contextual help. */
require( get_template_directory() . '/includes/admin/help.php' );