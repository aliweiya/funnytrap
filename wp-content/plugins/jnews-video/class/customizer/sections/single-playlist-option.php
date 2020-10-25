<?php

use JNEWS_VIDEO\Playlist\Single_Playlist;

$options = array();

$postmeta_refresh['option'] = array(
	'selector'        => '.jeg_option_container',
	'render_callback' => function () {
		$single = Single_Playlist::getInstance();
		$single->render_post_option();
	},
);

$postmeta_refresh['meta'] = array(
	'selector'        => '.jeg_meta_container',
	'render_callback' => function () {
		$single = Single_Playlist::getInstance();
		$single->render_post_meta();
	},
);

$single_post_tag['true'] = array(
	'redirect' => 'single_playlist_tag',
	'refresh'  => true,
);

$single_post_tag['false'] = array(
	'redirect' => 'single_playlist_tag',
	'refresh'  => false,
);

$postmeta_callback['option'] = array(
	'setting'  => 'jnews_single_playlist_show_post_option',
	'operator' => '==',
	'value'    => true,
);
$postmeta_callback['meta']   = array(
	'setting'  => 'jnews_single_playlist_show_post_meta',
	'operator' => '==',
	'value'    => true,
);

$options[] = array(
	'id'    => 'jnews_single_playlist_style_header',
	'type'  => 'jnews-header',
	'label' => esc_html__( 'Single Playlist Template', 'jnews-video' ),
);

$options[] = array(
	'id'          => 'jnews_single_playlist_template',
	'transport'   => 'postMessage',
	'default'     => '1',
	'type'        => 'jnews-radio-image',
	'label'       => esc_html__( 'Single Playlist Template', 'jnews-video' ),
	'description' => esc_html__( 'Choose your single playlist template.', 'jnews-video' ),
	'choices'     => array(
		'1' => '',
		'2' => '',
	),
	'postvar'     => array(
		$single_post_tag['true'],
	),
);

$options[] = array(
	'id'              => 'jnews_single_playlist_layout',
	'transport'       => 'postMessage',
	'default'         => 'left-sidebar',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'Single Playlist Layout', 'jnews-video' ),
	'description'     => esc_html__( 'Choose your single playlist layout.', 'jnews-video' ),
	'choices'         => array(
		'left-sidebar'  => '',
		'right-sidebar' => '',
	),
	'postvar'         => array(
		$single_post_tag['true'],
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_single_playlist_template',
			'operator' => '==',
			'value'    => '1',
		),
	),
);

$options[] = array(
	'id'    => 'jnews_single_playlist_element_header',
	'type'  => 'jnews-header',
	'label' => esc_html__( 'Single Playlist Element', 'jnews-video' ),
);

$options[] = array(
	'id'          => 'jnews_single_playlist_show_featured',
	'transport'   => 'postMessage',
	'default'     => true,
	'type'        => 'jnews-toggle',
	'label'       => esc_html__( 'Show Featured Image', 'jnews-video' ),
	'description' => esc_html__( 'Show featured image single playlist.', 'jnews-video' ),
	'postvar'     => array( $single_post_tag['true'] ),
);

$options[] = array(
	'id'              => 'jnews_single_playlist_show_post_meta',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Playlist Meta', 'jnews-video' ),
	'description'     => esc_html__( 'Show playlist meta on playlist aside.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_playlist_show_post_meta' => $postmeta_refresh['meta'],
	),
	'postvar'         => array( $single_post_tag['false'] ),
);

$options[] = array(
	'id'              => 'jnews_single_playlist_show_playlist_author',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Playlist Author', 'jnews-video' ),
	'description'     => esc_html__( 'Show playlist author on playlist meta container.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_playlist_show_playlist_author' => $postmeta_refresh['meta'],
	),
	'active_callback' => array( $postmeta_callback['meta'] ),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_playlist_show_playlist_author_image',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Playlist Author Image', 'jnews-video' ),
	'description'     => esc_html__( 'Show playlist author image on playlist meta container.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_playlist_show_playlist_author_image' => $postmeta_refresh['meta'],
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_single_playlist_show_playlist_author',
			'operator' => '==',
			'value'    => true,
		),
		$postmeta_callback['meta'],
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_playlist_show_playlist_total_video',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Video Counter', 'jnews-video' ),
	'description'     => wp_kses( __( 'Show or hide video counter', 'jnews-video' ), wp_kses_allowed_html() ),
	'partial_refresh' => array(
		'jnews_single_playlist_show_playlist_total_video' => $postmeta_refresh['meta'],
	),
	'active_callback' => array( $postmeta_callback['meta'] ),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_playlist_show_post_option',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Playlist Meta Option', 'jnews-video' ),
	'description'     => esc_html__( 'Show playlist meta option on playlist aside.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_playlist_show_post_option' => $postmeta_refresh['option'],
	),
	'postvar'         => array( $single_post_tag['false'] ),
);

if ( class_exists( 'BP_Follow_Component' ) ) {
	$options[] = array(
		'id'              => 'jnews_single_playlist_show_subscribe',
		'transport'       => 'postMessage',
		'default'         => true,
		'type'            => 'jnews-toggle',
		'label'           => esc_html__( 'Show Subscribe Button', 'jnews-video' ),
		'description'     => esc_html__( 'Show subscribe button on option container.', 'jnews-video' ),
		'partial_refresh' => array(
			'jnews_single_playlist_show_subscribe' => $postmeta_refresh['option'],
		),
		'active_callback' => array(
			array(
				'setting'  => 'jnews_single_playlist_show_post_option',
				'operator' => '==',
				'value'    => true,
			),
			$postmeta_callback['option'],
		),
		'postvar'         => array( $single_post_tag['false'] ),
		'wrapper_class'   => array( 'first_child' ),
	);
	$options[] = array(
		'id'              => 'jnews_single_playlist_show_subscribe_count',
		'transport'       => 'postMessage',
		'default'         => true,
		'type'            => 'jnews-toggle',
		'label'           => esc_html__( 'Show Follower Counter', 'jnews-video' ),
		'description'     => esc_html__( 'Show follower counter on subscribe button', 'jnews-video' ),
		'partial_refresh' => array(
			'jnews_single_playlist_show_subscribe_count' => $postmeta_refresh['option'],
		),
		'active_callback' => array(
			array(
				'setting'  => 'jnews_single_playlist_show_subscribe',
				'operator' => '==',
				'value'    => true,
			),
			$postmeta_callback['option'],
		),
		'postvar'         => array( $single_post_tag['false'] ),
		'wrapper_class'   => array( 'first_child' ),
	);
}

$options[] = array(
	'id'              => 'jnews_single_playlist_show_share_button',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Share Button', 'jnews-video' ),
	'description'     => esc_html__( 'Show share button on option container', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_playlist_show_share_button' => $postmeta_refresh['option'],
	),
	'active_callback' => array( $postmeta_callback['option'] ),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_playlist_show_more_option',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show More Option', 'jnews-video' ),
	'description'     => esc_html__( 'Show more option on option container ( Logged-in user)', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_playlist_show_more_option' => $postmeta_refresh['option'],
	),
	'active_callback' => array( $postmeta_callback['option'] ),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);


return $options;
