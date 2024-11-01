<?php
/**
 * Feature Name: Save the Options
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * Saves the options
 *
 * @wp-hook	admin_post_sf_save_settings
 * @return	void
 */
function sf_save_settings() {

	update_option( 'sf_expiration', $_POST[ 'sf_expiration' ] );
	update_option( 'sf_redirect_url', $_POST[ 'sf_redirect_url' ] );

	wp_redirect( 'edit.php?post_type=topics&page=simple-feedback-options&message=updated' );
	exit;
}