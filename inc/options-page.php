<?php
/**
 * Feature Name:v Options Page
 * Author:		 HerrLlama for wpcoding.de
 * Author URI:	 http://wpcoding.de
 * Licence:      GPLv3
 */

/**
 * Adds the options menu page to the custom post type topics
 *
 * @wp-hook	admin_menu
 * @return	void
 */
function sf_admin_menu() {
	add_submenu_page( 'edit.php?post_type=topics', __( 'Settings' ), __( 'Settings' ), 'manage_options', 'simple-feedback-options', 'sf_options_page' );
}

/**
 * Displays the options page called in
 * 'sf_admin_menu'
 *
 * @return	void
 */
function sf_options_page() {

	$redirect_page_id = get_option( 'sf_redirect_url' );
	$expiration = get_option( 'sf_expiration' );
	if ( $expiration == '' )
		$expiration = 7;
	$pages = get_posts( array(
		'post_type'			=> 'page',
		'post_status'		=> 'publish',
		'posts_per_page'	=> -1
	) );
	?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32"><br></div>
		<h2><?php _e( 'Settings' ); ?></h2>

		<?php
		if ( isset( $_GET[ 'message' ] ) ) {
			switch( $_GET[ 'message' ] ) {
				case 'updated':
					echo '<div class="updated"><p>' . __( 'Settings saved.' ) . '</p></div>';
					break;
			}
		}
		?>

		<div id="poststuff" class="metabox-holder has-right-sidebar">

			<div id="side-info-column" class="inner-sidebar">
				<div id="side-sortables" class="meta-box-sortables ui-sortable">
					<div id="help" class="postbox">
						<h3 class="hndle"><span><?php _e( 'Help', 'simple-feedback-td' ); ?></span></h3>
						<div class="inside">
							<ol>
								<li><?php _e( 'Create two pages where the topics should be shown.', 'simple-feedback-td' ); ?></li>
								<li><?php _e( 'Add the shortcode [topics-open] to the page where the topics appear which are currently in vote.', 'simple-feedback-td' ); ?></li>
								<li><?php _e( 'Add the shortcode [topics-closed] to the page where the topics appear which have been voted.', 'simple-feedback-td' ); ?></li>
								<li><?php _e( 'Head back here to set the options.', 'simple-feedback-td' ); ?></li>
							</ol>
						</div>
					</div>
					<div id="wpcodingde" class="postbox">
						<h3 class="hndle"><span><?php _e( 'Powered by', 'simple-feedback-td' ); ?></span></h3>
						<div class="inside">
							<p>
								<a href="http://wpcoding.de"><img src="<?php echo plugin_dir_url( __FILE__ ) . '../img/logo.png'; ?>" style="float:left;padding:0 10px 0 0;" /></a>
								<?php _e( 'This plugin is powered by wpcoding.de - WordPress Development.', 'simple-feedback-td' ); ?>
							</p>
						</div>
					</div>
				</div>
			</div>

			<div id="post-body">
				<div id="post-body-content">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">

						<form method="post" action="<?php echo admin_url( 'admin-post.php?action=sf_save_settings' ); ?>">
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">
											<label for="sf_redirect_url"><?php _e( 'Redirection', 'simple-feedback-td' ); ?></label>
										</th>
										<td>
											<select name="sf_redirect_url" id="sf_redirect_url">
												<?php foreach ( $pages as $page ) : ?>
													<option <?php echo selected( $page->ID, $redirect_page_id ); ?> value="<?php echo $page->ID ?>"><?php echo $page->post_title; ?></option>
												<?php endforeach; ?>
											</select><br />
											<span class="description"><?php _e( 'Choose the page to where the user will be redirected if he head to the custom post type archive page. You should redirect him to the page, where the open topics are displayed.', 'simple-feedback-td' ); ?></span>
										</td>
									</tr>
									<tr valign="top">
										<th scope="row">
											<label for="sf_expiration"><?php _e( 'Expiration Base', 'simple-feedback-td' ); ?></label>
										</th>
										<td>
											<input type="number" step="1" min="1" name="sf_expiration" id="sf_expiration" value="<?php echo $expiration; ?>" class="small-text" /><br />
											<span class="description"><?php _e( 'Set the main expiration time of the topics in days.', 'simple-feedback-td' ); ?></span>
										</td>
									</tr>
								</tbody>
							</table>
							<p class="submit">
								<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes' ); ?>">
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}