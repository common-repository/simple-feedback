<?php
/**
 * Feature Name: Display the topic itself
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * Adds the feedback boxes to the topic
 *
 * @wp-hook	the_content
 * @param	string $content the content of a post
 * @return	string $content the content with the feedback boxes
 */
function sf_the_content( $content ) {

	// Return if post type is topic
	if ( get_post_type() != 'topics' )
		return $content;
	if ( ! is_single() && get_post_type() == 'topics' )
		return $content;

	// Content at first
	$rtn = $content;

	// Expiration Date
	$expiration = get_option( 'sf_expiration' );
	if ( $expiration == '' )
		$expiration = 7;
	$time_of_topic = mktime( get_the_time( 'h' ), get_the_time( 'm' ), get_the_time( 'i' ), get_the_time( 'm' ), get_the_time( 'd' ), get_the_time( 'y' ) );
	$time_of_exp = 60*60*24*$expiration;
	$due_time = $time_of_topic + $time_of_exp;
	$date_of_exp = date( 'd.m.Y', $due_time );

	// Check status
	$status = get_post_meta( get_the_ID(), 'topic-status', TRUE );
	if ( $status == 'open' )
		$class = '';
	else
		$class = 'inactive';

	// Check if user already rated this topic
	// Get list of voted users
	$voted_users = get_post_meta( get_the_ID(), 'topic-voted-users', TRUE );
	if ( ! is_array( $voted_users ) )
		$voted_users = array();

	if ( array_key_exists( get_current_user_id(), $voted_users ) )
		$class = 'inactive';
	else
		$class = '';

	if ( ! is_user_logged_in() )
		$class = 'inactive';

	// Build list of users
	$users_for_it = array();
	$users_against = array();
	$users_undecided = array();

	foreach ( $voted_users as $voted_user => $vote ) {

		if ( $vote == 'for-it' )
			$users_for_it[] = $voted_user;
		if ( $vote == 'against' )
			$users_against[] = $voted_user;
		if ( $vote == 'undecided' )
			$users_undecided[] = $voted_user;
	}

	// Lists
	ob_start();
	?>
	<div class="vote <?php echo $class; ?>" topicid="<?php the_ID(); ?>">
		<?php if ( $status == 'open' ) : ?>
			<p class="note"><?php _e( '<strong>Important:</strong> This topic ends at ', 'simple-feedback-td' ); ?> <?php echo $date_of_exp; ?></p>
		<?php else : ?>
			<p class="note <?php echo $status; ?>"><?php _e( '<strong>Important:</strong> This vote ended and is ', 'simple-feedback-td' ); ?> <strong><?php $status = ucfirst( $status ); _e( $status, 'simple-feedback-td' ); ?></strong></p>
		<?php endif; ?>
		<ul class="for-it">
			<li class="btn">
				<?php _e( 'For it', 'simple-feedback-td' ); ?>
				(<span class="cnt"><?php echo count( $users_for_it ); ?></span>)
			</li>
			<?php
			foreach ( $users_for_it as $user_for_it ) {
				$user_data = get_userdata( $user_for_it );
				?>
				<li class="usr">
					<div class="avatar"><?php
						if ( is_user_logged_in() )
							echo get_avatar( $user_for_it, 40 );
					?></div>
					<div class="name">
						<?php
							if ( is_user_logged_in() )
								echo $user_data->display_name;
							else
								_e( 'Anonym', 'simple-feedback-td' );
						?>
					</div>
					<br class="clear">
				</li>
				<?php
			}
			?>
		</ul>
		<ul class="undecided">
			<li class="btn">
				<?php _e( 'Undecided', 'simple-feedback-td' ); ?>
				(<span class="cnt"><?php echo count( $users_undecided ); ?></span>)
			</li>
			<?php
			foreach ( $users_undecided as $user_undecided ) {
				$user_data = get_userdata( $user_undecided );
				?>
				<li class="usr">
					<div class="avatar"><?php
						if ( is_user_logged_in() )
							echo get_avatar( $user_undecided, 40 );
					?></div>
					<div class="name">
						<?php
							if ( is_user_logged_in() )
								echo $user_data->display_name;
							else
								_e( 'Anonym', 'simple-feedback-td' );
						?>
					</div>
					<br class="clear">
				</li>
				<?php
			}
			?>
		</ul>
		<ul class="against">
			<li class="btn">
				<?php _e( 'Against', 'simple-feedback-td' ); ?>
				(<span class="cnt"><?php echo count( $users_against ); ?></span>)
			</li>
			<?php
			foreach ( $users_against as $user_against ) {
				$user_data = get_userdata( $user_against );
				?>
				<li class="usr">
					<div class="avatar"><?php
						if ( is_user_logged_in() )
							echo get_avatar( $user_against, 40 );
					?></div>
					<div class="name">
						<?php
							if ( is_user_logged_in() )
								echo $user_data->display_name;
							else
								_e( 'Anonym', 'simple-feedback-td' );
						?>
					</div>
					<br class="clear">
				</li>
				<?php
			}
			?>
		</ul>
		<br class="clear">
	</div>
	<?php
	$list = ob_get_contents();
	ob_end_clean();

	return $rtn . $list;
}