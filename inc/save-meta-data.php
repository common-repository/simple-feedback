<?php
/**
 * Feature Name: Saves the meta data
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * Saves the meta data of the custom post type
 * columns.
 *
 * @wp-hook	save_post
 * @return	void
 */
function sf_save_meta_data() {

	// validate input
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	if ( 0 >= count( $_POST ) )
		return;
	if ( ! isset( $_POST[ 'post_type' ] ) || 'topics' != $_POST[ 'post_type' ] )
		return;
	if ( ! current_user_can( 'edit_post', $_POST[ 'ID' ] ) )
		return;

	// Save the ratings
	if ( isset( $_POST[ 'topic-rating-positive' ] ) && '' != trim( $_POST[ 'topic-rating-positive' ] ) )
		update_post_meta( $_POST[ 'ID' ], 'topic-rating-positive', $_POST[ 'topic-rating-positive' ] );
	if ( isset( $_POST[ 'topic-rating-negative' ] ) && '' != trim( $_POST[ 'topic-rating-negative' ] ) )
		update_post_meta( $_POST[ 'ID' ], 'topic-rating-negative', $_POST[ 'topic-rating-negative' ] );
	if ( isset( $_POST[ 'topic-rating-abstinence' ] ) && '' != trim( $_POST[ 'topic-rating-abstinence' ] ) )
		update_post_meta( $_POST[ 'ID' ], 'topic-rating-abstinence', $_POST[ 'topic-rating-abstinence' ] );
	if ( isset( $_POST[ 'topic-status' ] ) && '' != trim( $_POST[ 'topic-status' ] ) )
		update_post_meta( $_POST[ 'ID' ], 'topic-status', $_POST[ 'topic-status' ] );
}