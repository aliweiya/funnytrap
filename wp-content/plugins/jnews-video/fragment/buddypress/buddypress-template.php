<?php
/**
 * Template Name: BuddyPress Template
 */
$bp_template = JNEWS_VIDEO\BuddyPress\BuddyPress::get_instance();
get_header();
?>
<div
	class="jeg_main <?php $bp_template->main_class(); ?><?php echo $bp_template->get_template() == '1' ? '' : ' container'; ?> <?php echo esc_attr( apply_filters( 'jnews_video_buddypress_class', '' ) ); ?>">
	<div class="jeg_container">
		<div class="jeg_content">
			<div class="jeg_vc_content">
				<?php
				if ( bp_is_user() || bp_is_group() ) {
					echo bp_is_single_activity() || bp_is_group_create() ? '<div class="container">' : '';
					?>
					<?php
					the_post();
					the_content();
					?>
					<?php
					echo bp_is_single_activity() || bp_is_group_create() ? '</div>' : '';
				} else {
					?>
					<div class="container">
						<div class="entry-header">
							<h1 class="jeg_post_title"><?php the_title(); ?></h1>
						</div>
						<div class="row">
							<div
								class="jeg_main_content col-md-<?php echo esc_attr( $bp_template->main_content_width() ); ?>">
								<?php
								the_post();
								the_content();
								?>
							</div>
							<?php
							$bp_template->render_sidebar();
							?>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>
