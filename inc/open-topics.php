<?php
/**
 * Feature Name: Display open topics
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * Loads and displays the open topics in the
 * shortcode 'topics-open'
 *
 * @return	string the topic table
 */
function sf_table_open_topics() {
	$topics = new WP_Query(
		array(
			'post_type'			=> 'topics',
			'post_status'		=> 'published',
			'meta_key'			=> 'topic-status',
			'meta_value'		=> 'open',
			'posts_per_page'	=> -1
		)
	);

	ob_start();
	if ( $topics->have_posts() ) {
		?>
		<table>
			<thead>
				<tr>
					<th style="width: 70%;"><?php _e( 'Topic', 'simple-feedback-td' ); ?></th>
					<th style="width: 15%;"><?php _e( 'Author', 'simple-feedback-td' ); ?></th>
					<th style="width: 15%;"><?php _e( 'Expiration', 'simple-feedback-td' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			while ( $topics->have_posts() ) {
				$topics->the_post();

				// Expiration Date
				$time_of_topic = mktime( get_the_time( 'h' ), get_the_time( 'm' ), get_the_time( 'i' ), get_the_time( 'm' ), get_the_time( 'd' ), get_the_time( 'y' ) );
				$expiration = get_option( 'sf_expiration' );
				if ( $expiration == '' )
					$expiration = 7;
				$time_of_exp = 60*60*24*$expiration;
				$date_of_exp = date( 'd.m.Y', $time_of_topic + $time_of_exp );
				?>
				<tr>
					<td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
					<td><?php
					if ( is_user_logged_in() )
						the_author();
					else
						_e( 'Anonym', 'simple-feedback-td' );
					?></td>
					<td><?php echo $date_of_exp; ?></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php
	} else {
		?><p><?php _e( 'Currently there are no open topics.', 'simple-feedback-td' ) ?></p><?php
	}
	wp_reset_postdata();
	wp_reset_query();

	// Output
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}