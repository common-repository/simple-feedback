<?php
/**
 * Feature Name: Template Redirect
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * Regirects the user to a specific page if the
 * user visites the topics archive
 *
 * @wp-hook	template_include
 * @param	string $template the current template
 * @return	string $template still the current template
 */
function sf_redirect( $template ) {

	if ( get_post_type() == 'topics' && is_archive() ) {

		$redirect_page_id = get_option( 'sf_redirect_url' );
		if ( $redirect_page_id == '' )
			return $template;

		wp_redirect( get_permalink( $redirect_page_id ) );
		exit;
	}

	return $template;
}