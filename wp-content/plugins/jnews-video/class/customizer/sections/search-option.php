<?php

use JNews\Archive\SearchArchive;

$options = array();

$options[] = array(
	'id'              => 'jnews_search_only_video',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Only Video Post', 'jnews-video' ),
	'description'     => esc_html__( 'Enable this feature to only search video post.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_search_only_post' => array(
			'selector'        => '.jnews_search_content_wrapper',
			'render_callback' => function () {
				$single = new SearchArchive();
				echo jnews_sanitize_output( $single->render_content() );
			},
		),
	),
	'postvar'         => array(
		array(
			'redirect' => 'search_tag',
			'refresh'  => false,
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_search_only_post',
			'operator' => '==',
			'value'    => true,
		),
	),
);

return $options;
