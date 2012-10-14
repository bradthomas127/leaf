<?php
/**
 * Incorporating Contextual Help and Support.
 *
 * @Author: Chip Bennett
 * @Link: http://upthemes.com/blog/2012/05/incorporating-contextual-help-and-support-into-wordpress-themes/
 *		  https://github.com/chipbennett/oenology/blob/master/functions/contextual-help.php
 *
 * @since Leaf 1.0
*/ 

function leaf_add_help_tab () {
    global $leaf_page;
    $screen = get_current_screen();

    /*
     * Check if current screen is My Admin Page
     * Don't add help tab if it's not
     */
    if ( $screen->id != $leaf_page )
        return;

	// Add Settings - General help screen tab.
    $screen->add_help_tab( array(
        'id'	=> 'leaf-settings-general',
        'title'	=> __('General', 'leaf'),
        'content'	=> implode( '', file( get_template_directory() . '/includes/admin/help/general.htm' )),
    ) );
	// Add Settings - FAQ.
	$screen->add_help_tab( array(
		'id'      => 'leaf-settings-faq',
		'title'   => __( 'FAQ', 'leaf' ),
		'content' => implode( '', file( get_template_directory() . '/includes/admin/help/faq.htm' )),
	) );
	// Add Settings - License.
	$screen->add_help_tab( array(
		'id'      => 'leaf-settings-License',
		'title'   => __( 'License', 'leaf' ),
		'content' => implode( '', file( get_template_directory() . '/includes/admin/help/license.htm' )),
	) );
	// Add Settings - Donate.
	$screen->add_help_tab( array(
		'id'      => 'leaf-settings-donate',
		'title'   => __( 'Donate', 'leaf' ),
		'content' => implode( '', file( get_template_directory() . '/includes/admin/help/donate.htm' )),
	) );
}
?>