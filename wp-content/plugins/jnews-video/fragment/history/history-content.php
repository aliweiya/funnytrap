<?php
/**
 * @author : Jegtheme
 */

$history_archive = new JNEWS_VIDEO\History\History_Archive();

echo jnews_sanitize_output( $history_archive->render_content() );
