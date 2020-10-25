<?php

use JNEWS_VIDEO\Playlist\Single_Playlist;

$single = Single_Playlist::getInstance();
$author = $post->post_author;
?>
<div class="jeg_post_option">
	<?php if ( $single->show_subscribe_button() ) : ?>
		<div
			class="follow-wrapper"><?php echo jnews_video_render_subscribe_member_actions( $post->post_author, $single->show_follower_count() ); ?>
			<div class="jnews-spinner" style="display: none"><i class="fa fa-spinner fa-pulse active"></i></div></div>
	<?php endif; ?>
	<?php if ( $single->show_share_button() ) : ?>
		<?php echo jnews_video_playlist_share( $post, true ); ?>
	<?php endif; ?>
	<?php
	if ( $single->show_more_option() ) :
		?>
		<?php
		if ( is_user_logged_in() && ( (int) $post->post_author === get_current_user_id() ) && ! defined( 'JNEWS_SANDBOX_URL' ) ) :
			?>
			<div class="jeg_meta_option">
				<a href="#"><i class="fa fa-ellipsis-v"></i></a>
				<ul class="jeg_moreoption">
					<li><a href="#jeg_playlist" class="jeg_popuplink"><i
								class="fa fa-pencil-square-o"></i>
							<span><?php echo jnews_return_translation( 'Edit', 'jnews-video', 'edit' ); ?></span></a>
					</li>
					<li><a href="#jeg_playlist_delete" data-action="remove_playlist"
						   class="jeg_popuplink"><i
								class="fa fa-trash-o"></i>
							<span><?php echo jnews_return_translation( 'Delete', 'jnews-video', 'delete' ); ?></span></a>
					</li>
				</ul>
			</div>
			<?php
		endif;
		?>
		<?php
	endif;
	?>
</div>
