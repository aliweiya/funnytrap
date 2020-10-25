<?php
/**
 * BuddyPress - Users Cover Image Header
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
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

<div id="cover-image-container">
	<div id="header-cover-image"></div>
	<?php
	bp_get_template_part( 'members/single/member-header' );
	?>
</div><!-- #cover-image-container -->
