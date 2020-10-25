<?php
/**
 * @author : Jegtheme
 */

$options = array();

$all_sidebar = apply_filters( 'jnews_get_sidebar_widget', null );

$content_layout = apply_filters(
	'jnews_get_content_layout_customizer',
	array(
		'3'  => '',
		'4'  => '',
		'5'  => '',
		'6'  => '',
		'7'  => '',
		'9'  => '',
		'10' => '',
		'11' => '',
		'12' => '',
		'14' => '',
		'15' => '',
		'18' => '',
		'22' => '',
		'23' => '',
		'25' => '',
		'26' => '',
		'27' => '',
		'32' => '',
		'33' => '',
		'34' => '',
		'35' => '',
		'36' => '',
		'37' => '',
		'38' => '',
		'39' => '',
	)
);

// sidebar section
$options[] = array(
	'id'    => 'jnews_history_sidebar_section',
	'type'  => 'jnews-header',
	'label' => esc_html__( 'History Page Layout', 'jnews-video' ),
);

$options[] = array(
	'id'          => 'jnews_history_page_layout',
	'transport'   => 'postMessage',
	'default'     => 'right-sidebar',
	'type'        => 'jnews-radio-image',
	'label'       => esc_html__( 'Page Layout', 'jnews-video' ),
	'description' => esc_html__( 'Choose your page layout.', 'jnews-video' ),
	'choices'     => array(
		'right-sidebar'        => '',
		'left-sidebar'         => '',
		'right-sidebar-narrow' => '',
		'left-sidebar-narrow'  => '',
		'double-sidebar'       => '',
		'double-right-sidebar' => '',
		'no-sidebar'           => '',
	),
	'postvar'     => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => true,
		),
	),
);

$options[] = array(
	'id'              => 'jnews_history_sidebar',
	'transport'       => 'postMessage',
	'default'         => 'default-sidebar',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'History Sidebar', 'jnews-video' ),
	'description'     => wp_kses( __( 'Choose your history sidebar. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.', 'jnews-video' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => $all_sidebar,
	'postvar'         => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => true,
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_history_page_layout',
			'operator' => '!=',
			'value'    => 'no-sidebar',
		),
	),
);

$options[] = array(
	'id'              => 'jnews_history_second_sidebar',
	'transport'       => 'postMessage',
	'default'         => 'default-sidebar',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Second History Sidebar', 'jnews-video' ),
	'description'     => wp_kses( __( 'Choose your second sidebar for history page. If you need another sidebar, you can create from <strong>WordPress Admin</strong> &raquo; <strong>Appearance</strong> &raquo; <strong>Widget</strong>.', 'jnews-video' ), wp_kses_allowed_html() ),
	'multiple'        => 1,
	'choices'         => $all_sidebar,
	'postvar'         => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => true,
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_history_page_layout',
			'operator' => 'in',
			'value'    => array( 'double-sidebar', 'double-right-sidebar' ),
		),
	),
);

$options[] = array(
	'id'              => 'jnews_history_sticky_sidebar',
	'transport'       => 'postMessage',
	'default'         => true,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'History Sticky Sidebar', 'jnews-video' ),
	'description'     => esc_html__( 'Enable sticky sidebar on history result page.', 'jnews-video' ),
	'postvar'         => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => true,
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_history_page_layout',
			'operator' => '!=',
			'value'    => 'no-sidebar',
		),
	),
);


// content type.
$options[] = array(
	'id'    => 'jnews_history_content_section',
	'type'  => 'jnews-header',
	'label' => esc_html__( 'History Content', 'jnews-video' ),
);

$options[] = array(
	'id'              => 'jnews_history_content',
	'transport'       => 'postMessage',
	'default'         => '3',
	'type'            => 'jnews-radio-image',
	'label'           => esc_html__( 'History Content Layout', 'jnews-video' ),
	'description'     => esc_html__( 'Choose your history content layout.', 'jnews-video' ),
	'multiple'        => 1,
	'choices'         => $content_layout,
	'partial_refresh' => array(
		'jnews_history_content' => array(
			'selector'        => '.jnews_history_content_wrapper',
			'render_callback' => function () {
				$single = new \JNEWS_VIDEO\History\History_Archive();
				echo jnews_sanitize_output( $single->render_content() );
			},
		),
	),
	'postvar'         => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => false,
		),
	),
);

$options[] = array(
	'id'              => 'jnews_history_boxed',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Enable Boxed', 'jnews-video' ),
	'description'     => esc_html__( 'This option will turn the module into boxed.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_history_boxed' => array(
			'selector'        => '.jnews_history_content_wrapper',
			'render_callback' => function () {
				$single = new \JNEWS_VIDEO\History\History_Archive();
				echo jnews_sanitize_output( $single->render_content() );
			},
		),
	),
	'postvar'         => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => false,
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_history_content',
			'operator' => 'in',
			'value'    => array( '3', '4', '5', '6', '7', '9', '10', '14', '18', '22', '23', '25', '26', '27', '39' ),
		),
	),
);

$options[] = array(
	'id'              => 'jnews_history_boxed_shadow',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Enable Shadow', 'jnews-video' ),
	'description'     => esc_html__( 'Enable shadow on the module template.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_history_boxed_shadow' => array(
			'selector'        => '.jnews_history_content_wrapper',
			'render_callback' => function () {
				$single = new \JNEWS_VIDEO\History\History_Archive();
				echo jnews_sanitize_output( $single->render_content() );
			},
		),
	),
	'postvar'         => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => false,
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_history_content',
			'operator' => 'in',
			'value'    => array( '3', '4', '5', '6', '7', '9', '10', '14', '18', '22', '23', '25', '26', '27', '39' ),
		),
		array(
			'setting'  => 'jnews_history_boxed',
			'operator' => '==',
			'value'    => true,
		),
	),
);

$options[] = array(
	'id'              => 'jnews_history_box_shadow',
	'transport'       => 'postMessage',
	'default'         => false,
	'type'            => 'jnews-toggle',
	'label'           => esc_html__( 'Enable Shadow', 'jnews-video' ),
	'description'     => esc_html__( 'Enable shadow on the module template.', 'jnews-video' ),
	'partial_refresh' => array(
		'jnews_history_box_shadow' => array(
			'selector'        => '.jnews_history_content_wrapper',
			'render_callback' => function () {
				$single = new \JNEWS_VIDEO\History\History_Archive();
				echo jnews_sanitize_output( $single->render_content() );
			},
		),
	),
	'postvar'         => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => false,
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_history_content',
			'operator' => 'in',
			'value'    => array( '37', '35', '33', '36', '32', '38' ),
		),
	),
);

$options[] = array(
	'id'              => 'jnews_history_posts_per_page',
	'transport'       => 'postMessage',
	'default'         => get_option( 'posts_per_page' ),
	'type'            => 'jnews-number',
	'label'           => esc_html__( 'Posts Per Page', 'jnews-video' ),
	'description'     => esc_html__( 'Number of posts per page.', 'jnews-video' ),
	'choices'         => array(
		'min'  => '0',
		'max'  => '200',
		'step' => '1',
	),
	'partial_refresh' => array(
		'jnews_history_content_excerpt' => array(
			'selector'        => '.jnews_history_content_wrapper',
			'render_callback' => function () {
				$single = new \JNEWS_VIDEO\History\History_Archive();
				echo jnews_sanitize_output( $single->render_content() );
			},
		),
	),
	'postvar'         => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => false,
		),
	),
);

$options[] = array(
	'id'              => 'jnews_history_content_excerpt',
	'transport'       => 'postMessage',
	'default'         => 20,
	'type'            => 'jnews-number',
	'label'           => esc_html__( 'Excerpt Length', 'jnews-video' ),
	'description'     => esc_html__( 'Set the word length of excerpt on post.', 'jnews-video' ),
	'choices'         => array(
		'min'  => '0',
		'max'  => '200',
		'step' => '1',
	),
	'partial_refresh' => array(
		'jnews_history_content_excerpt' => array(
			'selector'        => '.jnews_history_content_wrapper',
			'render_callback' => function () {
				$single = new \JNEWS_VIDEO\History\History_Archive();
				echo jnews_sanitize_output( $single->render_content() );
			},
		),
	),
	'postvar'         => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => false,
		),
	),
);

$options[] = array(
	'id'              => 'jnews_history_content_date',
	'transport'       => 'postMessage',
	'default'         => 'default',
	'type'            => 'jnews-select',
	'label'           => esc_html__( 'Content Date Format', 'jnews-video' ),
	'description'     => esc_html__( 'Choose which date format you want to use for history for content.', 'jnews-video' ),
	'multiple'        => 1,
	'choices'         => array(
		'ago'     => esc_attr__( 'Relative Date/Time Format (ago)', 'jnews-video' ),
		'default' => esc_attr__( 'WordPress Default Format', 'jnews-video' ),
		'custom'  => esc_attr__( 'Custom Format', 'jnews-video' ),
	),
	'partial_refresh' => array(
		'jnews_history_content_date' => array(
			'selector'        => '.jnews_history_content_wrapper',
			'render_callback' => function () {
				$single = new \JNEWS_VIDEO\History\History_Archive();
				echo jnews_sanitize_output( $single->render_content() );
			},
		),
	),
	'postvar'         => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => false,
		),
	),
);

$options[] = array(
	'id'              => 'jnews_history_content_date_custom',
	'transport'       => 'postMessage',
	'default'         => 'Y/m/d',
	'type'            => 'jnews-text',
	'label'           => esc_html__( 'Custom Date Format for Content', 'jnews-video' ),
	'description'     => wp_kses(
		sprintf(
			__(
				"Please set custom date format for post content. For more detail about this format, please refer to
								<a href='%s' target='_blank'>Developer Codex</a>.",
				'jnews'
			),
			'https://developer.wordpress.org/reference/functions/current_time/'
		),
		wp_kses_allowed_html()
	),
	'postvar'         => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => false,
		),
	),
	'partial_refresh' => array(
		'jnews_history_content_date_custom' => array(
			'selector'        => '.jnews_history_content_wrapper',
			'render_callback' => function () {
				$single = new \JNEWS_VIDEO\History\History_Archive();
				echo jnews_sanitize_output( $single->render_content() );
			},
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'jnews_history_content_date',
			'operator' => '==',
			'value'    => 'custom',
		),
	),
);

$options[] = array(
	'id'          => 'jnews_history_content_pagination',
	'transport'   => 'postMessage',
	'default'     => 'scrollload',
	'type'        => 'jnews-select',
	'label'       => esc_html__( 'Choose Pagination Mode', 'jnews-video' ),
	'description' => esc_html__( 'Choose which pagination mode that fit with your block.', 'jnews-video' ),
	'multiple'    => 1,
	'choices'     => array(
		'loadmore'   => esc_attr__( 'Load More', 'jnews-video' ),
		'scrollload' => esc_attr__( 'Auto Load on Scroll', 'jnews-video' ),
	),
	'postvar'     => array(
		array(
			'redirect' => 'history_tag',
			'refresh'  => false,
		),
	),
);

return apply_filters( 'jnews_custom_customizer_option', $options, 'jnews_history_', null );
