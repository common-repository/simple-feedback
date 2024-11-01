<?php
/**
 * Feature Name: Checks the topic for the status
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

// adds the schedule
if ( ! wp_next_scheduled( 'sf_check_topics' ) )
	wp_schedule_event( time(), 'twicedaily', 'sf_check_topics' );

/**
 * Checks if there is an open topic where we need
 * to change the status with the current rating in mind.
 *
 * @wp-hook	sf_check_topics
 * @return	void
 */
function sf_check_topics() {
	$topics = get_posts(
		array(
			'post_type'			=> 'topics',
			'post_status'		=> 'published',
			'meta_key'			=> 'topic-status',
			'meta_value'		=> 'open',
			'posts_per_page'	=> -1
		)
	);

	if ( ! empty( $topics ) ) {
		foreach ( $topics as $topic ) {

			$time_of_topic = mktime( get_the_time( 'h', $topic->ID ), get_the_time( 'm', $topic->ID ), get_the_time( 'i', $topic->ID ), get_the_time( 'm', $topic->ID ), get_the_time( 'd', $topic->ID ), get_the_time( 'y', $topic->ID ) );
			$expiration = get_option( 'sf_expiration' );
			if ( $expiration == '' )
				$expiration = 7;
			$time_of_exp = 60 * 60 * 24 * $expiration;
			$due_time = $time_of_topic + $time_of_exp;

			// Check if the topic ends
			if ( $due_time <= time() ) {

				// Get the ratings
				$rating_positive = get_post_meta( $topic->ID, 'topic-rating-positive', TRUE );
				$rating_negative = get_post_meta( $topic->ID, 'topic-rating-negative', TRUE );

				$status = 'open';
				if ( $rating_positive > $rating_negative )
					$status = 'accepted';
				else if ( $rating_positive < $rating_negative )
					$status = 'declined';
				else if ( $rating_positive == $rating_negative )
					$status = 'undecided';

				update_post_meta( $topic->ID, 'topic-status', $status );
			}
		}
	}
}