<?php
/**
 * Feature Name: Adds the meta boxes
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * Adds the metabox to the topic CPT called
 * by the register_post_type() function
 *
 * @return	void
 */
function sf_add_metaboxes() {
	add_meta_box( 'topic-ratings', __( 'Rating', 'simple-feedback-td' ), 'sf_topic_metabox_rating', 'topics', 'side', 'high' );
}

/**
 * Shows the content of the registered metabox
 *
 * @param	object $post the current post
 * @return	void
 */
function sf_topic_metabox_rating( $post ) {
	$rating_positive = get_post_meta( $post->ID, 'topic-rating-positive', TRUE );
	$rating_negative = get_post_meta( $post->ID, 'topic-rating-negative', TRUE );
	$rating_abstinence = get_post_meta( $post->ID, 'topic-rating-abstinence', TRUE );
	?>
	<table class="form-table">
		<tr>
			<th class="row-title"><label for="topic-rating-positive" class="left"><?php _e( 'Positive Rating', 'simple-feedback-td' ); ?></label></th>
			<td><input type="text" name="topic-rating-positive" id="topic-rating-positive" size="12" value="<?php echo ! empty( $rating_positive ) ? esc_attr( $rating_positive ) : '0'; ?>" /><br /></td>
		</tr>
		<tr>
			<th class="row-title"><label for="topic-rating-negative" class="left"><?php _e( 'Negative Rating', 'simple-feedback-td' ); ?></label></th>
			<td><input type="text" name="topic-rating-negative" id="topic-rating-positiv" size="12" value="<?php echo ! empty( $rating_negative ) ? esc_attr( $rating_negative ) : '0'; ?>" /><br /></td>
		</tr>
		<tr>
			<th class="row-title"><label for="topic-rating-abstinence" class="left"><?php _e( 'Abstinence Rating', 'simple-feedback-td' ); ?></label></th>
			<td><input type="text" name="topic-rating-abstinence" id="topic-rating-abstinence" size="12" value="<?php echo ! empty( $rating_abstinence ) ? esc_attr( $rating_abstinence ) : '0'; ?>" /><br /></td>
		</tr>
		<tr>
			<th class="row-title"><label for="topic-status" class="left"><?php _e( 'Status', 'simple-feedback-td' ); ?></label></th>
			<td>
				<select name="topic-status" id="topic-status">
					<option <?php echo selected( 'open', get_post_meta( $post->ID, 'topic-status', TRUE ) ); ?> value="open"><?php _e( 'Open', 'simple-feedback-td' ); ?></option>
					<option <?php echo selected( 'accepted', get_post_meta( $post->ID, 'topic-status', TRUE ) ); ?> value="accepted"><?php _e( 'Accepted', 'simple-feedback-td' ); ?></option>
					<option <?php echo selected( 'declined', get_post_meta( $post->ID, 'topic-status', TRUE ) ); ?> value="declined"><?php _e( 'Declined', 'simple-feedback-td' ); ?></option>
					<option <?php echo selected( 'undecided', get_post_meta( $post->ID, 'topic-status', TRUE ) ); ?> value="undecided"><?php _e( 'Undecided', 'simple-feedback-td' ); ?></option>
				</select>
			</td>
		</tr>
	</table>
	<?php
}