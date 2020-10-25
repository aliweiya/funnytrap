<?php

$options = array();

if ( ! jnews_is_bp_active() ) {
	$options[] = array(
		'id'          => 'jnews_video_buddypress_blog_alert',
		'type'        => 'jnews-alert',
		'default'     => 'warning',
		'label'       => esc_html__( 'Attention', 'jnews-video' ),
		'description' => wp_kses(
			__(
				'<ul>
                    <li>Please activate BuddyPress to see the option</li>
                </ul>',
				'jnews-video'
			),
			wp_kses_allowed_html()
		),
	);
} else {

	$options[] = array(
		'id'    => 'jnews_video_buddypress_style_header',
		'type'  => 'jnews-header',
		'label' => esc_html__( 'BuddyPress Template & Layout', 'jnews-video' ),
	);

	$options[] = array(
		'id'          => 'jnews_video_buddypress_template',
		'transport'   => 'postMessage',
		'default'     => '1',
		'type'        => 'jnews-radio-image',
		'label'       => esc_html__( 'BuddyPress User & Group Page Template', 'jnews-video' ),
		'description' => esc_html__( 'Choose your BuddyPress user and group page template.', 'jnews-video' ),
		'choices'     => array(
			'1' => '',
			'2' => '',
		),
		'postvar'     => array(
			array(
				'redirect' => 'buddypress_member',
				'refresh'  => true,
			),
		),
	);

	$options[] = array(
		'id'          => 'jnews_video_buddypress_layout',
		'transport'   => 'postMessage',
		'default'     => 'right-sidebar',
		'type'        => 'jnews-radio-image',
		'label'       => esc_html__( 'BuddyPress Page Layout', 'jnews-video' ),
		'description' => esc_html__( 'Choose your BuddyPress page layout.', 'jnews-video' ),
		'choices'     => array(
			'right-sidebar' => '',
			'left-sidebar'  => '',
			'no-sidebar'    => '',
		),
		'postvar'     => array(
			array(
				'redirect' => 'buddypress',
				'refresh'  => true,
			),
		),
	);

	$all_sidebar = apply_filters( 'jnews_get_sidebar_widget', null );
	$options[]   = array(
		'id'              => 'jnews_video_buddypress_sidebar',
		'transport'       => 'postMessage',
		'default'         => 'default-sidebar',
		'type'            => 'jnews-select',
		'label'           => esc_html__( 'BuddyPress Sidebar', 'jnews-video' ),
		'description'     => wp_kses( __( 'Choose your BuddyPress sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.', 'jnews-video' ), wp_kses_allowed_html() ),
		'multiple'        => 1,
		'choices'         => $all_sidebar,
		'active_callback' => array(
			array(
				'setting'  => 'jnews_video_buddypress_layout',
				'operator' => 'contains',
				'value'    => array(
					'left-sidebar',
					'right-sidebar',
				),
			),
		),
		'postvar'         => array(
			array(
				'redirect' => 'buddypress',
				'refresh'  => true,
			),
		),
	);

	$all_user_nav = apply_filters( 'jnews_get_user_nav', null );
	$options[]    = array(
		'id'          => 'jnews_video_buddypress_members_nav',
		'transport'   => 'postMessage',
		'type'        => 'jnews-select',
		'label'       => esc_html__( 'BuddyPress Members Navigation', 'jnews-video' ),
		'description' => wp_kses( __( 'Choose BuddyPress menu for members navigation', 'jnews-video' ), wp_kses_allowed_html() ),
		'multiple'    => PHP_INT_MAX,
		'choices'     => $all_user_nav,
		'postvar'     => array(
			array(
				'redirect' => 'buddypress_member',
				'refresh'  => true,
			),
		),
	);
}

return $options;
