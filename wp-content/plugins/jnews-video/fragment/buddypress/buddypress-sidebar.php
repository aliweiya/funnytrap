<?php
$bp_template = JNEWS_VIDEO\BuddyPress\BuddyPress::get_instance();
?>

<div class="jeg_sidebar col-md-4">
	<?php
	jnews_widget_area( $bp_template->get_sidebar() )
	?>
</div>
