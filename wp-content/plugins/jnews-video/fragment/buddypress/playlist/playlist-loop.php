<?php

use JNEWS_VIDEO\Objects\Playlist;

$playlist     = Playlist::get_instance();
$user_id      = bp_displayed_user_id();
$playlist_ids = $playlist->get_playlist_by_user( $user_id );
$playlist_ids = ! empty( $playlist_ids ) ? $playlist_ids : array( '-10' );
$content      = $playlist->build_list_playlist( $playlist_ids, isset( $visibility ) ? $visibility : null );

do_action( 'jnews_after_playlist_loop' );
echo $content;
do_action( 'jnews_before_playlist_loop' );
