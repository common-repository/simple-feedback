<?php
/**
 * Feature Name: Styles
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * Loads the needed styles
 *
 * @wp-hook	wp_enqueue_scripts
 * @return	void
 */
function sf_wp_enqueue_styles() {

	$stylename = 'frontend.css';
	if ( defined( 'WP_DEBUG' ) )
		$stylename = 'frontend.dev.css';

	wp_register_style(
		'sf-frontend-styles',
		plugin_dir_url( __FILE__ ) . '../css/' . $stylename
	);
	wp_enqueue_style( 'sf-frontend-styles' );
};