<?php
/**
 * Plugin Name:	Simple Feedback
 * Description:	This plugin allowes registered users to vote for several topics.
 * Version:		1.0.3
 * Author:		HerrLlama for wpcoding.de
 * Author URI:	http://wpcoding.de
 * Licence:		GPLv3
 */

// check wp
if ( ! function_exists( 'add_action' ) )
	return;

/**
 * Inits the plugins, loads all the files
 * and registers all actions and filters
 *
 * @wp-hook	plugins_loaded
 * @return	void
 */
function sf_init() {

	// helpers
	require_once dirname( __FILE__ ) . '/inc/localization.php';
	require_once dirname( __FILE__ ) . '/inc/helpers.php';

	// registers the custom post type
	require_once dirname( __FILE__ ) . '/inc/register-post-type.php';
	add_action( 'init', 'sf_register_post_type' );

	// scripts
	require_once dirname( __FILE__ ) . '/inc/scripts.php';
	add_action( 'wp_enqueue_scripts', 'sf_wp_enqueue_scripts' );

	// styles
	require_once dirname( __FILE__ ) . '/inc/styles.php';
	add_action( 'wp_enqueue_scripts', 'sf_wp_enqueue_styles' );

	// Ajax callbacks
	require_once dirname( __FILE__ ) . '/inc/ajax-rate-topic.php';
	add_action( 'wp_ajax_rate_topic', 'sf_rate_topic' );

	// registers a cron job for the topic status check
	require_once dirname( __FILE__ ) . '/inc/cron-check-topic-status.php';
	add_action( 'sf_check_topics', 'sf_check_topics' );

	// Topic display
	require_once dirname( __FILE__ ) . '/inc/the-topic.php';
	add_action( 'the_content', 'sf_the_content' );
	require_once dirname( __FILE__ ) . '/inc/open-topics.php';
	add_shortcode( 'topics-open', 'sf_table_open_topics' );
	require_once dirname( __FILE__ ) . '/inc/closed-topics.php';
	add_shortcode( 'topics-closed', 'sf_table_open_closed' );

	// everything below is just in the admin panel
	if ( ! is_admin() )
		return;

	// custom post type with its depencies
	require_once dirname( __FILE__ ) . '/inc/add-meta-box.php';
	require_once dirname( __FILE__ ) . '/inc/topic-columns.php';
	global $pagenow;
	if ( $pagenow == 'edit.php' && isset( $_GET[ 'post_type' ] ) && $_GET[ 'post_type' ] == 'topics' ) {
		add_action( 'manage_edit-topics_columns', 'sf_custom_column_head' );
		add_action( 'manage_posts_custom_column', 'sf_custom_column_content' );
	}
	require_once dirname( __FILE__ ) . '/inc/save-meta-data.php';
	add_action( 'save_post', 'sf_save_meta_data' );

	// Options Page
	require_once dirname( __FILE__ ) . '/inc/save-options.php';
	add_filter( 'admin_post_sf_save_settings', 'sf_save_settings' );
	require_once dirname( __FILE__ ) . '/inc/options-page.php';
	add_action( 'admin_menu', 'sf_admin_menu' );
} add_action( 'plugins_loaded', 'sf_init' );