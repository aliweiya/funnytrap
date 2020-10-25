<?php
/**
 * BuddyPress - Groups Cover Image Header.
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
do_action( 'bp_before_group_header' ); ?>
<div id="cover-image-container">
	<div id="header-cover-image"></div>
	<?php
	bp_get_template_part( 'groups/single/group-header' );
	?>
</div><!-- #cover-image-container -->
