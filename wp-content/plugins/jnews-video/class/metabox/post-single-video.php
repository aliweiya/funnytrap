<?php
return array(
	'id'       => 'jnews_video_option',
	'types'    => array( 'post' ),
	'title'    => 'JNews : Video Option',
	'priority' => 'high',
	'template' => array(
		array(
			'type'        => 'textbox',
			'name'        => 'video_duration',
			'label'       => esc_html__( 'Duration', 'jnews-video' ),
			'description' => esc_html__( 'Human-read time value, ex. mm:ss.', 'jnews-video' ),
		),
		array(
			'type'        => 'upload',
			'name'        => 'video_preview',
			'label'       => esc_html__( '3 Second Video Preview', 'jnews-video' ),
			'description' => esc_html__( 'Upload 3 Second Video Preview. Only Support WEBP format.', 'jnews-video' ),
		),
	),
);
