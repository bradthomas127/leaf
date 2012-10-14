<?php
/**
 * The Header for our theme.
 *
 * @since Leaf 1.0
 */
?><!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<!-- Begin wp_head() -->
<?php wp_head(); ?>
<!-- End wp_head() -->
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">

	<div id="head-container">
	
		<?php leaf_header_before(); // Before Header hook. ?>
		
		<?php if (has_nav_menu('header')) { ?>
				
			<div class="top-nav row">
				
				<nav role="navigation" class="site-navigation header-navigation twelve columns">
					<h1 class="assistive-text"><?php _e( 'Header Menu', 'leaf' ); ?></h1>
					<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'leaf' ); ?>"><?php _e( 'Skip to content', 'leaf' ); ?></a></div>
					<?php wp_nav_menu( array( 'theme_location' => 'header', 'fallback_cb' => false, 'depth' => 1, 'menu_class' => 'header-menu' ) ); ?>
				</nav><!-- .site-navigation .header-navigation -->
					
			</div><!-- .top-nav .row -->
					
		<?php } ?>

		<div class="row">
			<header id="masthead" class="site-header row twelve columns" role="banner">

				<div class="row">
					<div class="header-group six columns">
					
						<?php $header_image = get_header_image();
						if ( ! empty( $header_image ) ) { ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
								<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
							</a>
						<?php } else { ?>
					
						<hgroup>
							<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						</hgroup>
						
						<?php } ?>
					</div><!-- .header-group .six .columns -->
					
						<?php leaf_header_inside(); // Inside Header hook. ?>
						
				</div><!-- .row -->
				
				<nav role="navigation" class="site-navigation main-navigation">
					<h1 class="assistive-text"><?php _e( 'Menu', 'leaf' ); ?></h1>
					<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'leaf' ); ?>"><?php _e( 'Skip to content', 'leaf' ); ?></a></div>

					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'sf-menu' ) ); ?>
				</nav><!-- .site-navigation .main-navigation -->
				
			</header><!-- #masthead .site-header .twelve .columns -->
		</div><!-- .row -->
	</div><!-- #head-container -->
	
	<?php leaf_header_after(); // After Header hook. ?>
	
	<div id="main" class="row">