<?php
/**
 * BuddyPress - Members Home
 */
$bp_template = JNEWS_VIDEO\BuddyPress\BuddyPress::get_instance();
?>

<div id="buddypress" class="<?php $bp_template->main_class(); ?>">

	<div id="template-notices" role="alert" aria-atomic="true">
		<?php

		/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
		do_action( 'template_notices' );
		?>

	</div>
	<?php

	/**
	 * Fires before the display of member home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_before_member_home_content' );
	?>
	<?php
	/**
	 * If the cover image feature is enabled, use a specific header
	 */
	if ( bp_displayed_user_use_cover_image_header() ) :
		bp_get_template_part( 'members/single/cover-image-header' );
	else :
		bp_get_template_part( 'members/single/member-header' );
	endif;
	bp_get_template_part( 'members/single/after-header' );
	?>


	<div class="container">
		<div id="item-nav">
			<div class="item-list-tabs no-ajax" id="object-nav"
				 aria-label="<?php esc_attr_e( 'Member primary navigation', 'buddypress' ); ?>" role="navigation">
				<ul>

					<?php bp_get_displayed_user_nav(); ?>

					<?php

					/**
					 * Fires after the display of member options navigation.
					 *
					 * @since 1.2.4
					 */
					do_action( 'bp_member_options_nav' );
					?>

				</ul>
			</div>
			<div class="clearfix"></div>
		</div><!-- #item-nav -->

		<div class="row">
			<div id="item-body"
				 class="jeg_main_content col-md-<?php echo esc_attr( $bp_template->main_content_width() ); ?>">

				<?php

				/**
				 * Fires before the display of member body content.
				 *
				 * @since 1.2.0
				 */


				if ( bp_is_user_front() ) :
					bp_displayed_user_front_template_part();

				elseif ( bp_is_user_activity() ) :
					bp_get_template_part( 'members/single/activity' );

				elseif ( bp_is_user_blogs() ) :
					bp_get_template_part( 'members/single/blogs' );

				elseif ( bp_is_user_friends() ) :
					bp_get_template_part( 'members/single/friends' );

				elseif ( bp_is_user_groups() ) :
					bp_get_template_part( 'members/single/groups' );

				elseif ( bp_is_user_messages() ) :
					bp_get_template_part( 'members/single/messages' );

				elseif ( bp_is_user_profile() ) :
					bp_get_template_part( 'members/single/profile' );

				elseif ( bp_is_user_notifications() ) :
					bp_get_template_part( 'members/single/notifications' );

				elseif ( bp_is_user_settings() ) :
					bp_get_template_part( 'members/single/settings' );

					// If nothing sticks, load a generic template
				else :
					bp_get_template_part( 'members/single/plugins' );

				endif;

				/**
				 * Fires after the display of member body content.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_after_member_body' );
				?>

			</div><!-- #item-body -->
			<?php
			$bp_template->render_sidebar();
			?>
		</div>
	</div>

	<?php

	/**
	 * Fires after the display of member home content.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_member_home_content' );
	?>

</div><!-- #buddypress -->
