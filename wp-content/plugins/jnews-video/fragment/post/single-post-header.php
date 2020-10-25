<?php

use JNEWS_VIDEO\Single\Single_Post_Video;

$single       = JNews\Single\SinglePost::getInstance();
$single_video = Single_Post_Video::get_instance();
?>

<div class="jeg_post_primary_info">
	<?php do_action( 'jnews_single_post_before_title', get_the_ID() ); ?>
	<h1 class="jeg_post_title"><?php the_title(); ?></h1>

	<?php if ( ! $single->is_subtitle_empty() ) : ?>
		<h2 class="jeg_post_subtitle"><?php echo esc_html( $single->render_subtitle() ); ?></h2>
	<?php endif; ?>

	<?php if ( $single_video->show_post_meta_header() ) : ?>
		<div class="jeg_post_meta meta_left">
			<?php
			if ( $single_video->show_view_tag() && class_exists( 'JNews_Initial_Counter' ) ) :
				$total = apply_filters( 'jnews_get_total_view', 0, get_the_ID(), 'all' );
				$total = JNews_Initial_Counter::getInstance()->get_total_fake_view( $total, get_the_ID() );
				?>
				<div class="jeg_views_count">
					<div class="counts"><?php echo number_format( $total, 0, ',', '.' ); ?> <span
							class="sharetext"><?php jnews_print_translation( 'Views', 'jnews-video', 'views_post_header' ); ?></span>
					</div>
				</div>
			<?php endif; ?>
			<?php if ( $single->show_date_meta() ) : ?>
				<div class="jeg_meta_date">
					<a href="<?php the_permalink(); ?>"><?php echo esc_html( $single->post_date_format( $post ) ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>

<?php if ( $single_video->show_post_meta_header() ) : ?>
	<div class="jeg_post_meta meta_right">
		<?php do_action( 'jnews_render_before_meta_right', get_the_ID() ); ?>
		<?php if ( $single->show_comment_meta() ) : ?>
			<div class="jeg_meta_comment"><a href="<?php echo jnews_get_respond_link(); ?>"><i
						class="fa fa-comment-o"></i> <?php echo esc_html( jnews_get_comments_number() ); ?>
				</a></div>
		<?php endif; ?>
		<?php echo jnews_video_playlist_share( $post, true ); ?>
		<?php echo jnews_video_add_playlist_menu( $post ); ?>
	</div>
<?php endif; ?>
