<?php
/**
 * BuddyPress - Members Home
 */
$follow_count = function_exists( 'bp_follow_total_follow_counts' ) ? bp_follow_total_follow_counts( array( 'user_id' => bp_displayed_user_id() ) ) : 0;
?>
<div id="item-header-after-wrapper">
	<div class="container">
		<div id="item-header-after">
			<?php if ( bp_is_active( 'activity' ) && bp_activity_do_mentions() ) : ?>
				<span class="user-nicename">@<?php bp_displayed_user_mentionname(); ?></span>
			<?php endif; ?>
			<span class="user-subscriber"><?php echo $follow_count['followers']; ?> Subscribers</span>
			<span class="user-activity-status"
				  data-livestamp="<?php bp_core_iso8601_date( bp_get_user_last_activity( bp_displayed_user_id() ) ); ?>"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>

			<?php

			/**
			 * Fires before the display of the member's header meta.
			 *
			 * @since 1.2.0
			 */
			do_action( 'bp_before_member_header_meta' );
			?>

			<div id="item-meta">

				<?php

				/**
				 * Fires after the group header actions section.
				 *
				 * If you'd like to show specific profile fields here use:
				 * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_profile_header_meta' );

				?>

			</div><!-- #item-meta -->
		</div>
	</div>
</div>
