<?php

use JNews\Single\SinglePost;

$options = array();

$postmeta_refresh['header'] = array(
	'selector'        => '.jeg_content > .container > .entry-header',
	'render_callback' => function () {
		jnews_video_get_template_part( 'fragment/post/single', 'post-header' );
	},
);

$postmeta_refresh['meta'] = array(
	'selector'        => '.jeg_inner_content > .jeg_meta_container',
	'render_callback' => function () {
		jnews_video_get_template_part( 'fragment/post/single', 'post-meta' );
	},
);

$single_post_tag['true'] = array(
	'redirect' => 'single_post_video_tag',
	'refresh'  => true,
);

$single_post_tag['false'] = array(
	'redirect' => 'single_post_video_tag',
	'refresh'  => false,
);

$overwrite_callback = array(
	'setting'  => 'jnews_single_video_override',
	'operator' => '==',
	'value'    => true,
);

$all_sidebar = apply_filters( 'jnews_get_sidebar_widget', null );

$postmeta_callback['header'] = array(
	'setting'  => 'jnews_single_video_show_post_meta_header',
	'operator' => '==',
	'value'    => true,
);
$postmeta_callback['meta']   = array(
	'setting'  => 'jnews_single_video_show_post_meta',
	'operator' => '==',
	'value'    => true,
);


if ( class_exists( 'JNews_Auto_Load_Post_Option' ) ) {
	$options[] = array(
		'id'          => 'jnews_autoload_single_alert',
		'type'        => 'jnews-alert',
		'default'     => 'warning',
		'label'       => esc_html__( 'Attention', 'jnews-video' ),
		'description' => wp_kses(
			__(
				'<ul>
                    <li>Single Video Post template overrided by Auto Load Post Option, Please use option on Auto Load Post Instead </li>                    
                </ul>',
				'jnews-video'
			),
			wp_kses_allowed_html()
		),
	);
}

$options[] = array(
	'id'          => 'jnews_single_video_override',
	'transport'   => 'postMessage',
	'default'     => false,
	'type'        => 'jnews-toggle',
	'label'       => esc_html__( 'Override Single Video Post Setting', 'jnews-video' ),
	'description' => esc_html__( 'Override single video post setting.', 'jnews-video' ),
	'postvar'     => array( $single_post_tag['false'] ),
);

$options[] = array(
	'id'              => 'jnews_single_video_style_header',
	'type'            => 'jnews-header',
	'label'           => esc_html__( 'Single Video Post Template', 'jnews-video' ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_template',
	'transport'       => 'postMessage',
	'default'         => 'video-1',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'Single Video Post Template', 'jnews-video' ),
	'description'     => esc_html__( 'Choose your single video post template.', 'jnews-video' ),
	'choices'         => array(
		'video-1' => '',
		'video-2' => '',
	),
	'postvar'         => array(
		$single_post_tag['true'],
	),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_layout',
	'transport'       => 'postMessage',
	'default'         => 'right-sidebar',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'Single Video Post Layout', 'jnews-video' ),
	'description'     => esc_html__( 'Choose your single video post layout.', 'jnews-video' ),
	'choices'         => array(
		'right-sidebar'        => '',
		'left-sidebar'         => '',
		'right-sidebar-narrow' => '',
		'left-sidebar-narrow'  => '',
		'double-sidebar'       => '',
		'double-right-sidebar' => '',
		'no-sidebar'           => '',
		'no-sidebar-narrow'    => '',
	),
	'postvar'         => array(
		$single_post_tag['true'],
	),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_truncate',
	'transport'       => 'refresh',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Enable Content Truncate', 'jnews-video' ),
	'description'     => esc_html__( 'Turn this option on to enable content truncate', 'jnews-video' ),
	'postvar'         => array(
		$single_post_tag['false'],
	),
	'active_callback' => array(
		$overwrite_callback,
	),
);

// $options[] = array(
// 'id'              => 'jnews_single_video_enable_fullscreen',
// 'transport'       => 'postMessage',
// 'default'         => true,
// 'type'            => 'jnews-toggle',
// 'label'           => esc_html__( 'Fullscreen Featured Image', 'jnews-video' ),
// 'description'     => esc_html__( 'Turn this option on if you want your post header to have fullscreen image featured.', 'jnews-video' ),
// 'postvar'         => array(
// $single_post_tag['true']
// ),
// 'wrapper_class'   => array( 'first_child' )
// );


$all_sidebar = apply_filters( 'jnews_get_sidebar_widget', null );

$options[] = array(
	'id'              => 'jnews_single_video_sidebar',
	'transport'       => 'postMessage',
	'default'         => 'default-sidebar',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Single Video Post Sidebar', 'jnews-video' ),
	'description'     => wp_kses( __( 'Choose your single video post sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.', 'jnews-video' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => $all_sidebar,
	'active_callback' => array(
		array(
			'setting'  => 'jnews_single_video_layout',
			'operator' => 'contains',
			'value'    => array(
				'left-sidebar',
				'right-sidebar',
				'left-sidebar-narrow',
				'right-sidebar-narrow',
				'double-sidebar',
				'double-right-sidebar',
			),
		),
		$overwrite_callback,

	),
	'postvar'         => array(
		$single_post_tag['true'],
	),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_second_sidebar',
	'transport'       => 'postMessage',
	'default'         => 'default-sidebar',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Second Single Video Post Sidebar', 'jnews-video' ),
	'description'     => wp_kses( __( 'Choose your single video post sidebar for the second sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.', 'jnews-video' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => $all_sidebar,
	'active_callback' => array(
		array(
			'setting'  => 'jnews_single_video_layout',
			'operator' => 'contains',
			'value'    => array( 'double-sidebar', 'double-right-sidebar' ),
		),
		$overwrite_callback,
	),
	'postvar'         => array(
		$single_post_tag['true'],
	),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_sticky_sidebar',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Single Video Post Sticky Sidebar', 'jnews-video' ),
	'description'     => esc_html__( 'Enable sticky sidebar on single video post page.', 'jnews-video' ),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_single_video_layout',
			'operator' => 'contains',
			'value'    => array(
				'left-sidebar',
				'right-sidebar',
				'left-sidebar-narrow',
				'right-sidebar-narrow',
				'double-sidebar',
				'double-right-sidebar',
			),
		),
		$overwrite_callback,
	),
	'postvar'         => array(
		$single_post_tag['true'],
	),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_element_header',
	'type'            => 'jnews-header',
	'label'           => esc_html__( 'Single Video Post Element', 'jnews-video' ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_featured',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Featured Image/Video', 'jnews-video' ),
	'description'     => esc_html__( 'Show featured image or video on single video post.', 'jnews-video' ),
	'postvar'         => array( $single_post_tag['true'] ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_post_meta_header',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Video Post Meta Header', 'jnews-video' ),
	'description'     => esc_html__( 'Show video post meta on post header.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_post_meta_header' => $postmeta_refresh['header'],
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_view_counter',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show View Counter', 'jnews-video' ),
	'description'     => wp_kses( __( 'Show or hide view counter', 'jnews-video' ), wp_kses_allowed_html() ),
	'partial_refresh' => array(
		'jnews_single_video_show_view_counter' => $postmeta_refresh['header'],
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'active_callback' => array( $postmeta_callback['header'], $overwrite_callback ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_post_date',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Video Post Date', 'jnews-video' ),
	'description'     => esc_html__( 'Show video post date on video post meta container.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_post_date' => $postmeta_refresh['header'],
	),
	'active_callback' => array( $postmeta_callback['header'], $overwrite_callback ),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_post_date_format',
	'transport'       => 'postMessage',
	'default'         => 'ago',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Video Post Date Format', 'jnews-video' ),
	'description'     => esc_html__( 'Choose which date format you want to use for single video post meta.', 'jnews-video' ),
	'choices'         => array(
		'ago'     => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews-video' ),
		'default' => esc_attr__( 'WordPress Default Format', 'jnews-video' ),
		'custom'  => esc_attr__( 'Custom Format', 'jnews-video' ),
	),
	'partial_refresh' => array(
		'jnews_single_video_post_date_format' => $postmeta_callback['header'],
	),
	'active_callback' => array(
		$postmeta_callback['header'],
		array(
			'setting'  => 'jnews_single_video_show_post_date',
			'operator' => '==',
			'value'    => true,
		),
		$overwrite_callback,
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_post_relative_date',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Video Post Relative Date', 'jnews-video' ),
	'description'     => esc_html__( 'Show video post relative date on video post meta header.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_post_relative_date' => $postmeta_refresh['header'],
	),
	'active_callback' => array( $postmeta_callback['header'], $overwrite_callback ),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

if ( class_exists( 'JNews_Like' ) ) {
	$options[] = array(
		'id'              => 'jnews_single_video_show_like',
		'transport'       => 'postMessage',
		'default'         => 'both',
		'type'            => 'jnews-select',
		'label'           => esc_html__( 'Show Like Button', 'jnews-video' ),
		'description'     => esc_html__( 'Adjust the post like button on post meta header.', 'jnews-video' ),
		'choices'         => array(
			'both' => esc_attr__( 'Like + Dislike', 'jnews-video' ),
			'like' => esc_attr__( 'Only Like', 'jnews-video' ),
			'hide' => esc_attr__( 'Hide All', 'jnews-video' ),
		),
		'partial_refresh' => array(
			'jnews_single_video_show_like' => array(
				'selector'        => '.jeg_meta_like_container',
				'render_callback' => function () {
					return JNews_Like::getInstance()->get_element( get_the_ID() );
				},
			),
		),
		'active_callback' => array( $postmeta_callback['header'], $overwrite_callback ),
		'postvar'         => array( $single_post_tag['false'] ),
		'wrapper_class'   => array( 'first_child' ),
	);
}


$options[] = array(
	'id'              => 'jnews_single_video_zoom_button',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Zoom Button', 'jnews-video' ),
	'description'     => esc_html__( 'Show zoom button on the video post meta container.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_post_zoom' => $postmeta_refresh['header'],
	),
	'active_callback' => array( $postmeta_callback['header'], $overwrite_callback ),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_zoom_button_out_step',
	'transport'       => 'postMessage',
	'default'         => 2,
	'type'            => 'jnews-slider',
	'label'           => esc_html__( 'Number of Zoom Out Step', 'jnews-video' ),
	'description'     => esc_html__( 'Set the number of zoom out step to limit when zoom out button clicked.', 'jnews-video' ),
	'choices'         => array(
		'min'  => '1',
		'max'  => '5',
		'step' => '1',
	),
	'partial_refresh' => array(
		'jnews_single_video_zoom_button_out_step' => $postmeta_refresh['header'],
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_single_video_zoom_button',
			'operator' => '==',
			'value'    => true,
		),
		$postmeta_callback['header'],
		$overwrite_callback,
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_zoom_button_in_step',
	'transport'       => 'postMessage',
	'default'         => 3,
	'type'            => 'jnews-slider',
	'label'           => esc_html__( 'Number of Zoom In Step', 'jnews-video' ),
	'description'     => esc_html__( 'Set the number of zoom in step to limit when zoom in button clicked.', 'jnews-video' ),
	'choices'         => array(
		'min'  => '1',
		'max'  => '5',
		'step' => '1',
	),
	'partial_refresh' => array(
		'jnews_single_video_zoom_button_in_step' => $postmeta_refresh['header'],
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_single_video_zoom_button',
			'operator' => '==',
			'value'    => true,
		),
		$postmeta_callback['header'],
		$overwrite_callback,
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_comment',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Comment Button', 'jnews-video' ),
	'description'     => esc_html__( 'Show comment button on video post meta header.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_comment' => $postmeta_refresh['header'],
	),
	'active_callback' => array( $postmeta_callback['header'], $overwrite_callback ),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_post_meta',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Video Post Meta', 'jnews-video' ),
	'description'     => esc_html__( 'Show video post meta on post content.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_post_meta' => $postmeta_refresh['meta'],
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_post_author',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Video Post Author', 'jnews-video' ),
	'description'     => esc_html__( 'Show video post author on video post meta container.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_post_author' => $postmeta_refresh['meta'],
	),
	'active_callback' => array( $postmeta_callback['meta'], $overwrite_callback ),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_post_author_image',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Video Post Author Image', 'jnews-video' ),
	'description'     => esc_html__( 'Show video post author image on video post meta container.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_post_author_image_1' => $postmeta_refresh['meta'],
	),
	'active_callback' => array(
		$postmeta_callback['meta'],
		array(
			'setting'  => 'jnews_single_video_show_post_author',
			'operator' => '==',
			'value'    => true,
		),
		$overwrite_callback,
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_subscribe_counter',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Subscribe Counter', 'jnews-video' ),
	'description'     => esc_html__( 'Show subscribe counter on video post meta container.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_subscribe_counter' => $postmeta_refresh['meta'],
	),
	'active_callback' => array( $postmeta_callback['meta'], $overwrite_callback ),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_post_date_format_custom',
	'transport'       => 'postMessage',
	'default'         => 'Y/m/d',
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'Custom Date Format', 'jnews-video' ),
	'description'     => wp_kses(
		sprintf(
			__(
				"Please set custom date format for single video post meta. For more detail about this format, please refer to
                                <a href='%s' target='_blank'>Developer Codex</a>.",
				'jnews-video'
			),
			'https://developer.wordpress.org/reference/functions/current_time/'
		),
		wp_kses_allowed_html()
	),
	'partial_refresh' => array(
		'jnews_single_video_post_date_format_custom' => $postmeta_refresh['meta'],
	),
	'active_callback' => array(
		$postmeta_callback['meta'],
		array(
			'setting'  => 'jnews_single_video_show_post_date',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'setting'  => 'jnews_single_video_post_date_format',
			'operator' => '==',
			'value'    => 'custom',
		),
		$overwrite_callback,
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_reading_time',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Reading Time', 'jnews-video' ),
	'description'     => esc_html__( 'Show estimate reading time on video post meta container.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_reading_time' => $postmeta_refresh['meta'],
	),
	'active_callback' => array( $postmeta_callback['meta'], $overwrite_callback ),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);

$options[] = array(
	'id'              => 'jnews_single_video_reading_time_wpm',
	'transport'       => 'postMessage',
	'default'         => '300',
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'Words Per Minute', 'jnews-video' ),
	'description'     => esc_html__( 'Set the average reading speed for the user.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_reading_time_wpm' => $postmeta_refresh['meta'],
	),
	'active_callback' => array(
		$postmeta_callback['meta'],
		array(
			'setting'  => 'jnews_single_video_reading_time',
			'operator' => '==',
			'value'    => true,
		),
		$overwrite_callback,
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'wrapper_class'   => array( 'first_child' ),
);
if ( class_exists( 'BP_Follow_Component' ) ) {
	$options[] = array(
		'id'              => 'jnews_single_video_subscribe_button',
		'transport'       => 'postMessage',
		'default'         => true,
		'type'            => 'jnews-toggle',
		'label'           => esc_html__( 'Show Subscribe Button', 'jnews-video' ),
		'description'     => esc_html__( 'Show subscribe button on video post meta container.', 'jnews-video' ),
		'partial_refresh' => array(
			'jnews_single_video_subscribe_button' => $postmeta_refresh['meta'],
		),
		'active_callback' => array( $postmeta_callback['meta'], $overwrite_callback ),
		'postvar'         => array( $single_post_tag['false'] ),
		'wrapper_class'   => array( 'first_child' ),
	);
}

$options[] = array(
	'id'              => 'jnews_single_video_show_category',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Category', 'jnews-video' ),
	'description'     => esc_html__( 'Show video post category ( below article ).', 'jnews-video' ),
	'active_callback' => array( $overwrite_callback ),
	'postvar'         => array(
		$single_post_tag['true'],
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_tag',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Video Post Tag', 'jnews-video' ),
	'description'     => esc_html__( 'Show single video post tag (below article).', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_tag' => array(
			'selector'        => '.jeg_post_tags',
			'render_callback' => function () {
				$single = SinglePost::getInstance();
				$single->post_tag_render();
			},
		),
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_prev_next_post',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Prev / Next Post', 'jnews-video' ),
	'description'     => esc_html__( 'Show previous or next post navigation (below article).', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_prev_next_post' => array(
			'selector'        => '.jnews_prev_next_container',
			'render_callback' => function () {
				$single = SinglePost::getInstance();
				$single->prev_next_post();
			},
		),
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_popup_post',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Popup Post', 'jnews-video' ),
	'description'     => esc_html__( 'Show bottom right popup post widget.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_popup_post' => array(
			'selector'        => '.jnews_popup_post_container',
			'render_callback' => function () {
				$single = SinglePost::getInstance();
				$single->popup_post();
			},
		),
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_number_popup_post',
	'transport'       => 'postMessage',
	'default'         => 1,
	'type'            => 'jnews-slider',
	'label'           => esc_html__( 'Number of Popup Post', 'jnews-video' ),
	'description'     => esc_html__( 'Set the number of post to show when popup post appear.', 'jnews-video' ),
	'choices'         => array(
		'min'  => '1',
		'max'  => '5',
		'step' => '1',
	),
	'partial_refresh' => array(
		'jnews_single_video_number_popup_post' => array(
			'selector'        => '.jnews_popup_post_container',
			'render_callback' => function () {
				$single = SinglePost::getInstance();
				$single->popup_post();
			},
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_single_video_show_popup_post',
			'operator' => '==',
			'value'    => true,
		),
		$overwrite_callback,
	),
	'postvar'         => array( $single_post_tag['false'] ),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_author_box',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Author Box', 'jnews-video' ),
	'description'     => esc_html__( 'Show author box (below article).', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_author_box' => array(
			'selector'        => '.jnews_author_box_container',
			'render_callback' => function () {
				$single = SinglePost::getInstance();
				$single->author_box();
			},
		),
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_reading_progress_bar',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Show Reading Progress Bar', 'jnews-video' ),
	'description'     => esc_html__( 'Show reading progress bar on single video post.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_single_video_show_reading_progress_bar' => array(
			'selector'        => '.jeg_read_progress_wrapper',
			'render_callback' => function () {
				$single = SinglePost::getInstance();
				echo jnews_sanitize_by_pass( $single->build_reading_progress_bar() );
			},
		),
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_reading_progress_bar_position',
	'transport'       => 'postMessage',
	'default'         => 'bottom',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Progress Bar Position', 'jnews-video' ),
	'description'     => esc_html__( 'Choose the position of reading progress bar on single video post.', 'jnews-video' ),
	'choices'         => array(
		'top'    => esc_attr__( 'Top', 'jnews-video' ),
		'bottom' => esc_attr__( 'Bottom', 'jnews-video' ),
	),
	'partial_refresh' => array(
		'jnews_single_video_show_reading_progress_bar_position' => array(
			'selector'        => '.jeg_read_progress_wrapper',
			'render_callback' => function () {
				$single = SinglePost::getInstance();
				echo jnews_sanitize_by_pass( $single->build_reading_progress_bar() );
			},
		),
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_single_video_show_reading_progress_bar',
			'operator' => '==',
			'value'    => true,
		),
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_show_reading_progress_bar_color',
	'transport'       => 'postMessage',
	'default'         => '#f70d28',
	'type'            => 'jnews-color',
	'disable_color'   => true,
	'label'           => esc_html__( 'Progress Bar Color', 'jnews-video' ),
	'description'     => esc_html__( 'Set color for the progress bar.', 'jnews-video' ),
	'output'          => array(
		array(
			'method'   => 'inject-style',
			'element'  => '.jeg_read_progress_wrapper .jeg_progress_container .progress-bar',
			'property' => 'background-color',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_single_video_show_reading_progress_bar',
			'operator' => '==',
			'value'    => true,
		),
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_post_thumbnail_header',
	'type'            => 'jnews-header',
	'label'           => esc_html__( 'Single Thumbnail Setting', 'jnews-video' ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

$options[] = array(
	'id'              => 'jnews_single_video_post_thumbnail_size',
	'transport'       => 'refresh',
	'default'         => 'crop-500',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Post Thumbnail Size', 'jnews-video' ),
	'description'     => esc_html__( 'Choose your post\'s single image thumbnail size. You can also override this behaviour on your single post editor.', 'jnews-video' ),
	'multiple'        => 1,
	'choices'         => array(
		'no-crop'  => esc_attr__( 'No Crop', 'jnews-video' ),
		'crop-500' => esc_attr__( 'Crop 1/2 Dimension', 'jnews-video' ),
		'crop-715' => esc_attr__( 'Crop Default Dimension', 'jnews-video' ),
	),
	'postvar'         => array( $single_post_tag['false'] ),
	'active_callback' => array(
		$overwrite_callback,
	),
);

return $options;
