<?php

use JNEWS_VIDEO\Playlist\Single_Playlist;

$single = Single_Playlist::getInstance();
$author = $post->post_author;
?>
<div class="jeg_post_meta jeg_post_meta_1">

	<div class="meta_left">
		<?php if ( $single->show_author_meta() ) : ?>
			<div class="jeg_meta_author">
				<?php
				if ( $single->show_author_meta_image() ) {
					echo get_avatar( get_the_author_meta( 'ID', $author ), 80, null, get_the_author_meta( 'display_name', $author ) );
				}
				?>
				<span
					class="meta_text"><?php jnews_print_translation( 'Created by', 'jnews-video', 'created_by' ); ?></span>
				<?php jnews_the_author_link( $author ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $single->show_total_video_meta() ) : ?>
			<div class="jeg_meta_total_video">
				<a href="<?php the_permalink(); ?>"><?php echo jnews_video_get_playlist_count( $post->ID ); ?><?php echo jnews_return_translation( 'Videos', 'jnews-video', 'videos' ); ?></a>
			</div>
		<?php endif; ?>

	</div>
</div>
