<?php
/**
 * BuddyPress - Groups Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

/**
 * Fires before the display of a group's header.
 *
 * @since 1.2.0
 */
do_action( 'bp_before_group_header' );

?>

<div id="item-header-wrapper" role="complementary">
	<div class="container">
		<div id="item-header">
			<div id="item-header-avatar">
				<a href="<?php echo esc_url( bp_get_group_permalink() ); ?>" class="bp-tooltip"
				   data-bp-tooltip="<?php echo esc_attr( bp_get_group_name() ); ?>">

					<?php bp_group_avatar(); ?>

				</a>
			</div><!-- #item-header-avatar -->
			<div id="item-header-content">
				<div class="item-header-body-content">
					<h2 class="user-nicename"><?php bp_current_group_name(); ?></h2>
					<span class="highlight"><?php bp_group_type(); ?></span>
				</div>
			</div><!-- #item-header-content -->
			<div id="item-buttons">

				<?php
				do_action( 'bp_before_member_header_meta' );
				/**
				 * Fires in the group header actions section.
				 *
				 * @since 1.2.6
				 */
				do_action( 'bp_group_header_actions' );
				?>
			</div><!-- #item-buttons -->
			<div id="item-actions">

				<?php if ( bp_group_is_visible() ) : ?>

					<h2><?php _e( 'Group Admins', 'buddypress' ); ?></h2>

					<?php
					bp_group_list_admins();

					/**
					 * Fires after the display of the group's administrators.
					 *
					 * @since 1.1.0
					 */
					do_action( 'bp_after_group_menu_admins' );

					if ( bp_group_has_moderators() ) :

						/**
						 * Fires before the display of the group's moderators, if there are any.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_before_group_menu_mods' );
						?>

						<h2><?php _e( 'Group Mods', 'buddypress' ); ?></h2>

						<?php
						bp_group_list_mods();

						/**
						 * Fires after the display of the group's moderators, if there are any.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_after_group_menu_mods' );

					endif;

				endif;
				?>
			</div><!-- #item-actions -->
		</div>
	</div>
	<?php

	/**
	 * Fires after the display of a group's header.
	 *
	 * @since 1.2.0
	 */
	do_action( 'bp_after_group_header' );
	?>
</div>


