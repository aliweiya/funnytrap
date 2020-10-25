<?php

use JNEWS_VIDEO\Playlist\Playlist_Archive;

$playlist = new Playlist_Archive();
get_header();
?>
<div class="jeg_main <?php $playlist->main_class(); ?>">
	<div class="jeg_container">
		<div class="jeg_content">

			<div class="jeg_section">
				<div class="container">

					<?php do_action( 'jnews_archive_above_content' ); ?>

					<div class="jeg_cat_content row">
						<div class="jeg_main_content col-sm-<?php echo esc_attr( $playlist->get_content_width() ); ?>">

							<div class="jeg_inner_content">
								<div class="jeg_archive_header">

									<?php if ( jnews_can_render_breadcrumb() ) : ?>
										<div class="jeg_breadcrumbs jeg_breadcrumb_container">
											<?php echo jnews_sanitize_output( $playlist->render_breadcrumb() ); ?>
										</div>
									<?php endif; ?>

									<?php the_archive_title( '<h1 class="jeg_archive_title">', '</h1>' ); ?>
								</div>
								<!-- search end -->

								<div class="jnews_playlist_content_wrapper">
									<?php echo jnews_sanitize_output( $playlist->render_content() ); ?>
								</div>
							</div>

							<?php echo jnews_sanitize_output( $playlist->render_navigation() ); ?>
						</div>
						<?php $playlist->render_sidebar(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php do_action( 'jnews_after_main' ); ?>
	</div>
</div>

<?php get_footer(); ?>
