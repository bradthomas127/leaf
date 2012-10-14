<?php
/**
 * The template for displaying search forms.
 *
 * @since Leaf 1.0
 */
?>

	<div class="search-bar">
		<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<label for="s" class="assistive-text"><?php _e( 'Search', 'leaf' ); ?></label>
			<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'leaf' ); ?>" />
			<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search...', 'leaf' ); ?>" />
		</form>
	</div><!-- .search-bar -->