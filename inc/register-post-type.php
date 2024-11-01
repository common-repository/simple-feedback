<?php
/**
 * Feature Name: Register the post type
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * Registers the custom post type
 *
 * @wp-hook	init
 * @return	void
 */
function sf_register_post_type() {
	$labels = array(
		'name'					=> __( 'Topics', 'simple-feedback-td' ),
		'add_new'				=> __( 'Add Topic', 'simple-feedback-td' ),
		'new_item'				=> __( 'New Topics', 'simple-feedback-td' ),
		'all_items'				=> __( 'Topics', 'simple-feedback-td' ),
		'edit_item'				=> __( 'Edit Topic', 'simple-feedback-td' ),
		'view_item'				=> __( 'View Topic', 'simple-feedback-td' ),
		'not_found'				=> __( 'There are no Topics matching the search criterias', 'simple-feedback-td' ),
		'menu_name'				=> __( 'Topics', 'simple-feedback-td' ),
		'add_new_item'			=> __( 'Add Topic', 'simple-feedback-td' ),
		'search_items'			=> __( 'Search Topics', 'simple-feedback-td' ),
		'singular_name'			=> __( 'Topic', 'simple-feedback-td' ),
		'parent_item_colon'		=> __( 'Parent Topic', 'simple-feedback-td' ),
		'not_found_in_trash'	=> __( 'There are no Topics matching the search criterias', 'simple-feedback-td' ),
	);

	$supports = array(
		'title',
		'editor',
		'thumbnail',
		'comments'
	);

	$post_type_args = array(
		'public' 				=> TRUE,
		'labels'				=> $labels,
		'rewrite'				=> TRUE,
		'show_ui' 				=> TRUE,
		'supports' 				=> $supports,
		'query_var' 			=> TRUE,
		'has_archive'			=> TRUE,
		'hierarchical' 			=> FALSE,
		'menu_position' 		=> NULL,
		'capability_type' 		=> 'post',
		'publicly_queryable'	=> TRUE,
		'register_meta_box_cb'	=> 'sf_add_metaboxes',
	);

	register_post_type( 'topics', $post_type_args );

	// check if the rewrite rules have been flushed
	if ( get_option( 'simple-feedback-rewrite-rules',  FALSE ) == FALSE ) {
		flush_rewrite_rules();
		update_option( 'simple-feedback-rewrite-rules', 1 );
	}
}
