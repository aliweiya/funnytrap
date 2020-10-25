<?php

use JNEWS_VIDEO\Objects\Playlist;

$is_current_user = get_current_user_id() === bp_displayed_user_id();
if ( $is_current_user ) {
	$playlist     = Playlist::get_instance();
	$user_id      = bp_displayed_user_id();
	$playlist_ids = $playlist->get_playlist_by_user( $user_id );
	$playlist_ids = ! empty( $playlist_ids ) ? $playlist_ids : array( '-10' );
	$content      = $playlist->build_list_playlist( $playlist_ids, 'private' );
}
?>
<div class="content-inner">
	<?php if ( $is_current_user ) : ?>
		<h3 class="post-title"><?php echo jnews_return_translation( 'Private Playlist', 'jnews-video', 'private_playlist' ); ?></h3>
		<?php
		do_action( 'jnews_after_playlist_loop' );
		echo $content;
		do_action( 'jnews_before_playlist_loop' );
		?>
	<?php else : ?>
		You cannot access this page
	<?php endif; ?>
</div>
