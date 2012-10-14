<?php
/**
 * Theme Action Hooks.
 *
 * @since Leaf 1.0
 */


/**
 * Before <header id="masthead">
 *
 * @see header.php
 */
function leaf_header_before() {
    do_action('leaf_header_before');
}

/**
 * After <hgroup> or header_image().
 *
 * @see header.php
 */
function leaf_header_inside() {
    do_action('leaf_header_inside');
}

/**
 * After </div><!-- #head-container -->
 *
 * @see header.php
 */
function leaf_header_after() {
    do_action('leaf_header_after');
}

/**
 * After <div id="content" role="main">
 *
 * @see blog.php / index.php
 */
function leaf_blog_before() {
    do_action('leaf_blog_before');
}

/**
 * Before </div><!-- #content -->
 *
 * @see blog.php / index.php
 */
function leaf_blog_after() {
    do_action('leaf_blog_after');
}

/**
 * After <div id="content" role="main">
 *
 * @see single.php
 */
function leaf_post_before() {
    do_action('leaf_post_before');
}

/**
 * Before </div><!-- #content -->
 *
 * @see single.php
 */
function leaf_post_after() {
    do_action('leaf_post_after');
}

/**
 * After <div id="content" role="main">
 *
 * @see page.php
 */
function leaf_page_before() {
    do_action('leaf_page_before');
}

/**
 * Before </div><!-- #content -->
 *
 * @see page.php
 */
function leaf_page_after() {
    do_action('leaf_page_after');
}

/**
 * After <div id="secondary" class="widget-area four columns" role="complementary">
 *
 * @see sidebar.php / sidebar-home.php
 */
function leaf_sidebar_before() {
    do_action('leaf_sidebar_before');
}

/**
 * Before </div><!-- #secondary .widget-area .four .columns -->
 *
 * @see sidebar.php / sidebar-home.php
 */
function leaf_sidebar_after() {
    do_action('leaf_sidebar_after');
}

/**
 * After </div><!-- #main .row -->
 *
 * @see footer.php
 */
function leaf_footer_before() {
    do_action('leaf_footer_before');
}

?>