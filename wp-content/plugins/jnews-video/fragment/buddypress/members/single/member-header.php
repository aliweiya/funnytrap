<?php
/**
 * BuddyPress - Users Header
 */

?>

<?php

/**
 * Fires before the display of a member's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_member_header' );
?>
<div id="item-header-wrapper" role="complementary">
	<div class="container">
		<div id="item-header">
			<div id="item-header-avatar">
				<a href="<?php bp_displayed_user_link(); ?>">

					<?php bp_displayed_user_avatar( 'type=full' ); ?>

				</a>
			</div><!-- #item-header-avatar -->

			<div id="item-header-content">
				<div class="item-header-body-content">
					<h2 class="user-fullname"><?php bp_displayed_user_fullname(); ?></h2>
				</div>
			</div><!-- #item-header-content -->
			<div id="item-buttons">

				<?php
				if ( ! is_user_logged_in() ) {
					do_action( 'bp_member_header_actions_placeholder' );
				} else {
					/**
					 * Fires in the member header actions section.
					 *
					 * @since 1.2.6
					 */
					do_action( 'bp_member_header_actions' );
				}

				?>

			</div><!-- #item-buttons -->
		</div>
	</div>

	<?php

	/**
	 * Fires after the display of a member's header.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_member_header' );
	?>

</div>
