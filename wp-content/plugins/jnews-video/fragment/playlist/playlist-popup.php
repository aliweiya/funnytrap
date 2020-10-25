<?php
if ( is_singular( 'playlist' ) ) :
	jnews_video_get_template_part( '/fragment/playlist/playlist', 'edit' );
else :
	jnews_video_get_template_part( '/fragment/playlist/playlist', 'create' );
endif;
?>

<div id="notification_action_renderer" class="jeg_popup_container">
	<div id="paper_toast">
		<span id="label"></span>
	</div>
</div>
