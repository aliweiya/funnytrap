<?php
// we create class instance outside loop, so we need to take wp query instance directly
use JNEWS_VIDEO\Objects\Playlist;
use JNEWS_VIDEO\Playlist\Single_Playlist;

$single   = Single_Playlist::getInstance();
$playlist = Playlist::get_instance();
if ( $playlist->is_default_content() ) {
	$user_id = get_current_user_id();
	$post    = $playlist->get_playlist_by_user( $user_id, $playlist->current_page );
	$single->set_playlist_id( $post->ID );
} else {
	if ( is_singular( 'playlist' ) ) {
		$single->set_playlist_id( $wp_query->post->ID );
	}
}
?>

<div class="jeg_sidebar col-md-<?php echo $single->get_template() === '1' ? '4' : '12'; ?>">
	<div class="jeg_inner_content">
		<?php echo $single->featured_image( 'jnews-1140x815' ); ?>
		<div class="entry-header">
			<?php do_action( 'jnews_single_playlist_before_title', $playlist->is_default_content() ? $post->ID : get_the_ID() ); ?>

			<h1 class="jeg_post_title">
				<?php
				if ( $playlist->is_default_content() ) :
					do_action( 'jnews_video_get_right_title' );
				else :
					the_title();
				endif;
				?>
			</h1>

			<?php if ( ! $playlist->is_default_content() ) : ?>
				<?php the_content(); ?>

				<div class="jeg_meta_container"><?php $single->render_post_meta(); ?></div>
				<div class="jeg_option_container"><?php $single->render_post_option(); ?></div>
			<?php endif; ?>

		</div>
	</div>
</div>
<div class="jeg_main_content col-md-<?php echo $single->get_template() === '1' ? '8' : '12'; ?>">
	<?php do_action( 'jnews_single_playlist_before_content' ); ?>

	<div class="jeg_playlist_contents">
		<h3 class="post-title"><?php echo jnews_return_translation( 'List Videos', 'jnews-video', 'list_videos' ); ?></h3>
		<?php
		$playlist->render_playlist_content_loop();
		?>
		<?php do_action( 'jnews_push_notification_single_playlist' ); ?>
	</div>

	<?php do_action( 'jnews_single_playlist_after_content' ); ?>
</div>
