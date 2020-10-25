<?php
$template = new JNEWS_VIDEO\Playlist\Playlist_Dashboard( get_the_ID() );
$playlist = $template->playlist_data();
?>
<div id="jeg_playlist" class="jeg_popup edit_playlist mfp-with-anim mfp-hide">
	<div class="jeg_popupform jeg_popupform_playlist">
		<form action="#" method="post" accept-charset="utf-8">
			<h3><?php jnews_print_translation( 'Edit Playlist', 'jnews-video', 'edit_playlist' ); ?></h3>

			<!-- Form Messages -->
			<div class="form-message"></div>

			<div class="form-group">
				<div class="form-input-wrapper">
					<!-- image format -->
					<?php
					jeg_locate_template(
						locate_template( 'fragment/upload/upload-form.php', false, false ),
						true,
						array(
							'id'      => 'featured_image',
							'class'   => '',
							'name'    => 'image',
							'source'  => isset( $playlist['image'] ) ? array( $playlist['image'] ) : null,
							'button'  => 'btn-single-image',
							'multi'   => false,
							'maxsize' => '2mb',
						)
					);
					?>
				</div>
			</div>
			<div class="form-group">
				<div class="form-input-wrapper">
					<label for="content"><?php esc_html_e( 'Playlist Name', 'jnews-video' ); ?></label>
					<input id="title" name="title"
						   placeholder="<?php esc_attr_e( 'Enter name here', 'jnews-video' ); ?>"
						   type="text" class="form-control"
						   value="<?php echo isset( $playlist['title'] ) ? $playlist['title'] : ''; ?>">
				</div>

				<!-- playlist content -->
				<div class="form-input-wrapper">
					<label for="content"><?php esc_html_e( 'Description', 'jnews-video' ); ?></label>
					<br>
					<textarea name="content" id="content" cols="40"
							  rows="4"><?php echo isset( $playlist['content'] ) ? $playlist['content'] : ''; ?></textarea>
				</div>

				<div class="form-input-wrapper">
					<label for="content"><?php esc_html_e( 'Visibility', 'jnews-video' ); ?></label>
					<?php echo jnews_video_select_visibility( $playlist['visibility'] ); ?>
				</div>

				<!-- submit button -->
				<div class="submit">
					<input type="hidden" name="type" value="edit_playlist">
					<input type="hidden" name="action" value="playlist_handler">
					<input type="hidden" name="playlist_id"
						   value="<?php echo esc_attr( $playlist['id'] ); ?>"/>
					<input type="hidden" name="jnews-playlist-nonce"
						   value="<?php echo esc_attr( wp_create_nonce( 'jnews-playlist-nonce' ) ); ?>">
					<input type="submit" name="jeg_save_button" class="button"
						   value="<?php jnews_print_translation( 'Save', 'jnews-video', 'save' ); ?>"
						   data-process="<?php jnews_print_translation( 'Processing . . .', 'jnews-video', 'processing' ); ?>"
						   data-string="<?php jnews_print_translation( 'Save', 'jnews-video', 'save' ); ?>">
				</div>
			</div>
		</form>
	</div>
</div>
<div id="jeg_playlist_delete" class="jeg_popup delete_playlist mfp-with-anim mfp-hide">
	<div class="jeg_popupform jeg_popupform_playlist">
		<form action="#" method="post" accept-charset="utf-8">
			<h3><?php jnews_print_translation( 'Delete Playlist ?', 'jnews-video', 'delete_playlist_confirm' ); ?></h3>

			<!-- Form Messages -->
			<div class="form-message"></div>

			<div class="form-group">

				<!-- submit button -->
				<div class="submit">
					<input type="hidden" name="type" value="delete_playlist">
					<input type="hidden" name="action" value="playlist_handler">
					<input type="hidden" name="playlist_id"
						   value="<?php echo esc_attr( $playlist['id'] ); ?>"/>
					<input type="hidden" name="jnews-playlist-nonce"
						   value="<?php echo esc_attr( wp_create_nonce( 'jnews-playlist-nonce' ) ); ?>">
					<input type="submit" name="jeg_save_button" class="button"
						   value="<?php jnews_print_translation( 'Delete', 'jnews-video', 'delete' ); ?>"
						   data-process="<?php jnews_print_translation( 'Processing . . .', 'jnews-video', 'processing' ); ?>"
						   data-string="<?php jnews_print_translation( 'Delete', 'jnews-video', 'delete' ); ?>">
				</div>
			</div>
		</form>
	</div>
</div>
