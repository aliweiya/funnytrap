<div id="jeg_playlist" class="jeg_popup create_playlist mfp-with-anim mfp-hide">
	<div class="jeg_popupform jeg_popupform_playlist">
		<form action="#" method="post" accept-charset="utf-8">
			<h3><?php jnews_print_translation( 'Add New Playlist', 'jnews-video', 'add_new_playlist' ); ?></h3>

			<!-- Form Messages -->
			<div class="form-message"></div>

			<div class="form-group">
				<p class="input_field">
					<input type="text" name="title"
						   placeholder="<?php jnews_print_translation( 'Playlist Name', 'jnews-video', 'playlist_name' ); ?>"
						   value="">
				</p>
				<p class="input_field">
					<?php echo jnews_video_select_visibility(); ?>
				</p>
				<!-- submit button -->
				<div class="submit">
					<input type="hidden" name="type" value="create_playlist">
					<input type="hidden" name="action" value="playlist_handler">
					<input type="hidden" name="post_id" value="">
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
