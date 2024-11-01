<?php
/**
 * Feature Name: Rates the topic
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * AJAX function to set the rate of the user
 *
 * @wp-hook	wp_ajax_rate_topic
 * @return	void
 */
function sf_rate_topic() {
	$topic_id = (int) $_REQUEST[ 'topic' ];
	$rate_type = $_REQUEST[ 'rate_type' ];
	$user_id = get_current_user_id();

	$voted_users = get_post_meta( $topic_id, 'topic-voted-users', TRUE );
	if ( ! is_array( $voted_users ) )
		$voted_users = array();

	// Check if the user already voted
	if ( array_key_exists( $user_id, $voted_users ) ) {
		echo 0;
		exit;
	} else if ( get_post_meta( $topic_id, 'topic-status', TRUE ) != 'open' ) {
		echo 1;
		exit;
	} else {
		// get userdata
		$user_data = get_userdata( $user_id );

		// Update Vote list
		$voted_users[ $user_id ] = $rate_type;
		update_post_meta( $topic_id, 'topic-voted-users', $voted_users );

		// Update ratings
		if ( $rate_type == 'for-it' ) {
			$rating_positive = get_post_meta( $topic_id, 'topic-rating-positive', TRUE );
			$rating_positive = $rating_positive + 1;
			update_post_meta( $topic_id, 'topic-rating-positive', $rating_positive );
		}

		if ( $rate_type == 'against' ) {
			$rating_negative = get_post_meta( $topic_id, 'topic-rating-negative', TRUE );
			$rating_negative = $rating_negative + 1;
			update_post_meta( $topic_id, 'topic-rating-negative', $rating_negative );
		}

		if ( $rate_type == 'undecided' ) {
			$rating_abstinence = get_post_meta( $topic_id, 'topic-rating-abstinence', TRUE );
			$rating_abstinence = $rating_abstinence + 1;
			update_post_meta( $topic_id, 'topic-rating-abstinence', $rating_abstinence );
		}

		?>
		<li class="usr">
			<div class="avatar"><?php echo get_avatar( $user_id, 40 ); ?></div>
			<div class="name"><?php echo $user_data->display_name; ?></div>
			<br class="clear">
		</li>
		<?php
	}

	exit;
}