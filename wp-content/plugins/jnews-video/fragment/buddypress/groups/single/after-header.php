<?php
/**
 * BuddyPress - Members Home
 */
?>
<div id="item-header-after-wrapper">
	<div class="container">
		<div id="item-header-after">
			<span class="activity"
				  data-livestamp="<?php bp_core_iso8601_date( bp_get_group_last_active( 0, array( 'relative' => false ) ) ); ?>"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span>
			<div id="item-meta">

				<?php
				bp_group_description();
				bp_group_type_list();

				/**
				 * Fires after the group header actions section.
				 *
				 * @since 1.2.0
				 */
				do_action( 'bp_group_header_meta' );
				?>

			</div><!-- #item-meta -->
		</div>
	</div>
</div>
