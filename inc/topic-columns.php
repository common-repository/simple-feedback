<?php
/**
 * Feature Name: Shows the columns for the topics
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * Registers the custom column to the topics overview
 *
 * @wp-hook	sf_custom_column_head
 * @param	array $defaults the default columns
 * @return	array the columns
 */
function sf_custom_column_head( $defaults ) {

	$new_fields = array(
		'topic-author'		=> __( 'Author' ),
	);
	$defaults = array_insert( $defaults, 'title', $new_fields );

	return $defaults;
}

/**
 * Loads the content of the custom column
 *
 * @wp-hook	sf_custom_column_content
 * @param 	string $column_name the name of the current column
 * @return	void
 */
function sf_custom_column_content( $column_name ) {
	global $post;

	$post_id = $post->ID;
	if ( $column_name == 'topic-author' )
		echo get_the_author();
}