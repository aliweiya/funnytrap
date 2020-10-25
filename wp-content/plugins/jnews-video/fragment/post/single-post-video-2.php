<?php
$single       = JNews\Single\SinglePost::getInstance();
$single_video = JNEWS_VIDEO\Single\Single_Post_Video::get_instance();
?>

<div class="jeg_featured_big">
	<div class="jeg_fs_content">
		<div class="container">
			<?php $single->render_featured_post(); ?>
		</div>
	</div>

	<div class="jeg_ad jeg_article_top jnews_article_top_ads">
		<?php do_action( 'jnews_article_top_ads' ); ?>
	</div>
</div>

<div class="jeg_content jeg_singlepage">
	<div class="container">

		<?php
		if ( have_posts() ) :
			the_post();
			?>
			<?php if ( jnews_can_render_breadcrumb() ) : ?>
			<div class="jeg_breadcrumbs jeg_breadcrumb_container">
				<?php $single->render_breadcrumb(); ?>
			</div>
		<?php endif; ?>
			<div class="entry-header">
				<?php jnews_video_get_template_part( 'fragment/post/single', 'post-header' ); ?>
			</div>
			<div class="row">
				<div class="jeg_main_content col-md-<?php echo esc_attr( $single->main_content_width() ); ?>">
					<div class="jeg_inner_content">
						<div class="jeg_meta_container">
							<?php if ( $single->show_post_meta() ) : ?>
								<?php jnews_video_get_template_part( 'fragment/post/single', 'post-meta' ); ?>
							<?php endif; ?>
						</div>

						<?php do_action( 'jnews_single_post_before_content' ); ?>
						<div class="entry-content <?php echo esc_attr( $single->share_float_additional_class() ); ?>">
							<div
								class="jeg_share_button share-float jeg_sticky_share clearfix <?php $single->share_float_style_class(); ?>">
								<?php do_action( 'jnews_share_float_bar', get_the_ID() ); ?>
							</div>

							<div
								class="content-inner <?php echo apply_filters( 'jnews_content_class', '', get_the_ID() ); ?>">
								<?php the_content(); ?>

								<?php wp_link_pages(); ?>

								<?php do_action( 'jnews_source_via_single_post' ); ?>

								<?php if ( has_tag() ) : ?>
									<div class="jeg_post_tags">
										<?php $single->post_tag_render(); ?>
									</div>
								<?php endif; ?>
							</div>
							<?php do_action( 'jnews_share_bottom_bar', get_the_ID() ); ?>

							<?php do_action( 'jnews_push_notification_single_post' ); ?>
						</div>

						<?php do_action( 'jnews_single_post_after_content' ); ?>
					</div>

				</div>
				<?php $single->render_sidebar(); ?>
			</div>

		<?php endif; ?>

		<div class="jeg_ad jeg_article jnews_article_bottom_ads">
			<?php do_action( 'jnews_article_bottom_ads' ); ?>
		</div>

	</div>
</div>
