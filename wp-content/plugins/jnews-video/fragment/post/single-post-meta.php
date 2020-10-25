<?php

use JNEWS_VIDEO\Single\Single_Post_Video;

$single       = JNews\Single\SinglePost::getInstance();
$single_video = Single_Post_Video::get_instance();
$author       = $post->post_author;
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
				<?php jnews_the_author_link( $author ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $single_video->show_subscribe_counter() ) : ?>
			<?php
			/** @var  $follow_count */
			$follow_count = function_exists( 'bp_follow_total_follow_counts' ) ? bp_follow_total_follow_counts( array( 'user_id' => get_the_author_meta( 'ID', $author ) ) ) : 0;

			/** @var  $subscribe_wrapper */
			$subscriber = '<span class="jeg_subscribe_count">' . $follow_count['followers'] . ' ' . jnews_return_translation( 'Subscriber', 'jnews-video', 'subscriber_video' ) . '</span>';
			?>
			<div class="jeg_meta_subscribe no-follow">
				<?php echo $subscriber; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php do_action( 'jnews_render_after_meta_left' ); ?>

	<div class="meta_right">
		<?php if ( $single_video->show_subscribe_button() ) : ?>
			<div class="follow-wrapper"><?php echo jnews_video_render_subscribe_member_actions( (int) $author ); ?><div class="jnews-spinner" style="display: none"><i
						class="fa fa-spinner fa-pulse active"></i></div></div>
		<?php endif; ?>
	</div>
</div>
