<?php

use JNEWS_VIDEO\Objects\Playlist;

$playlist     = Playlist::get_instance();
$user_id      = bp_displayed_user_id();
$playlist_ids = $playlist->get_playlist_by_user( $user_id );
$playlist_ids = ! empty( $playlist_ids ) ? $playlist_ids : array( '-10' );
$content      = $playlist->build_list_playlist( $playlist_ids, 'public' );

?>
<div class="content-inner">
	<?php if ( get_current_user_id() === $user_id ) : ?>
		<h3 class="post-title"><?php echo jnews_return_translation( 'Public Playlist', 'jnews-video', 'public_playlist' ); ?></h3>
	<?php endif; ?>
	<?php
	do_action( 'jnews_after_playlist_loop' );
	echo $content;
	do_action( 'jnews_before_playlist_loop' );
	?>
</div>
