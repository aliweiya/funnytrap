<?php

use JNEWS_VIDEO\Objects\Playlist;

$author        = $post->post_author;
$author_url    = get_author_posts_url( $author );
$author_name   = get_the_author_meta( 'display_name', $author );
$playlist_date = Playlist::get_post_detail(
	array(
		'date',
		'date_gmt',
	),
	$playlist_id,
	get_the_ID()
);
?>
<li class="jnews-playlist-item" data-id="<?php echo esc_attr( get_the_ID() ); ?>">
	<article class="jeg_post jnews_video">
		<div class="jeg_block_container">
			<div class="jeg_thumb">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
			</div>
			<div class="jeg_post_info">
				<h3 class="jeg_post_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h3>
				<div class="jeg_post_meta">
					<div class="jeg_meta_author">
						<a href="<?php echo esc_url( $author_url ); ?>">
							<?php echo esc_html( $author_name ); ?>
						</a>
					</div>
					<div class="jeg_meta_date">
						<a href="<?php echo esc_url( get_the_permalink( $post ) ); ?> ">
							<?php echo jnews_return_translation( 'Added', 'jnews-video', 'added' ); ?>
							<?php echo jnews_ago_time( human_time_diff( mysql2date( 'U', $playlist_date['date'], false ), current_time( 'timestamp' ) ) ); ?>
						</a>
					</div>
				</div>
			</div>
			<?php
			if ( is_user_logged_in() && ( (int) get_post_field( 'post_author', $playlist_id ) === get_current_user_id() ) && ! defined( 'JNEWS_SANDBOX_URL' ) ) :
				?>
				<div class="jeg_post_action">
					<a href="#" class="jeg_remove_post" data-action="jeg_remove_post" data-post-id="<?php the_ID(); ?>">
						<i class="fa fa-trash-o"></i>
						<span><?php jnews_print_translation( 'Remove', 'jnews-video', 'remove' ); ?></span>
					</a>
				</div>
				<?php
			endif;
			?>
			<?php echo jnews_video_get_video_length( get_the_ID() ); ?>
		</div>
	</article>
	<div class="jnews-playlist-overlay">
		<div class="fa fa-cog fa-spin"></div>
	</div>
</li>
