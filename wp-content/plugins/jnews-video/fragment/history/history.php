<?php
/**
 * @author : Jegtheme
 */

get_header();
$history = new \JNEWS_VIDEO\History\History_Archive();
?>

<div class="jeg_main <?php $history->main_class(); ?>">
	<div class="jeg_container">
		<div class="jeg_content">

			<div class="jeg_section">
				<div class="container">

					<?php do_action( 'jnews_archive_above_content' ); ?>

					<div class="jeg_cat_content row">
						<div
							class="jeg_main_content col-sm-<?php echo esc_attr( $history->get_content_width() ); ?>">

							<div class="jeg_inner_content">

								<div class="jeg_archive_header">

									<h1 class="jeg_archive_title"><?php do_action( 'jnews_video_get_right_title' ); ?></h1>

								</div>

								<div class="jnews_history_content_wrapper">
									<?php
									do_action( 'jnews_video_get_right_content' );
									?>
								</div>
							</div>
						</div>
						<?php $history->render_sidebar(); ?>
					</div>
				</div>
			</div>
		</div>
		<?php do_action( 'jnews_after_main' ); ?>
	</div>
</div>

<?php get_footer(); ?>
