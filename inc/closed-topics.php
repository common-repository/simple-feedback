<?php
/**
 * Feature Name: Display closed topics
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * Loads and displays the closed topics in the
 * shortcode 'topics-closed'
 *
 * @return	string the topic table
 */
function sf_table_open_closed() {
	$topics = new WP_Query(
		array(
			'post_type'			=> 'topics',
			'post_status'		=> 'published',
			'meta_query'		=> array(
				array(
					'key'		=> 'topic-status',
					'value'		=> 'open',
					'compare'	=> '!=',
				)
			),
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
					<th style="width: 15%;"><?php _e( 'Conclusion', 'simple-feedback-td' ); ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			while ( $topics->have_posts() ) {
				$topics->the_post();

				// Check status
				$status = get_post_meta( get_the_ID(), 'topic-status', TRUE );
				?>
				<tr class="<?php echo $status; ?>">
					<td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></td>
					<td><?php
					if ( is_user_logged_in() )
						the_author();
					else
						_e( 'Anonym', 'simple-feedback-td' );
					?></td>
					<td><strong><?php $status = ucfirst( $status ); _e( $status, 'simple-feedback-td' ); ?></strong></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<?php
	} else {
		?><p><?php _e( 'Currently there are no closed topics.', 'simple-feedback-td' ) ?></p><?php
	}
	wp_reset_postdata();
	wp_reset_query();

	// Output
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}