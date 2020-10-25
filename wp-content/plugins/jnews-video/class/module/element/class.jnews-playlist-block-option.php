<?php
/**
 * @author : Jegtheme
 */

use JNews\Module\Block\BlockOptionAbstract;

class JNews_Video_Blockplaylist_Option extends BlockOptionAbstract {
	protected $default_number_post = 3;
	protected $default_ajax_post   = 3;

	public function get_module_name() {
		return esc_html__( 'JNews - Playlist Block', 'jnews-video' );
	}

	public function get_category() {
		return esc_html__( 'JNews - Element', 'jnews-video' );
	}

	public function set_options() {
		$this->set_header_option();
		$this->set_playlist_content_option();
		$this->set_ajax_filter_option();
		$this->set_style_option();
	}

	public function set_header_option() {

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'data_type',
			'group'       => esc_html__( 'Header', 'jnews-video' ),
			'heading'     => esc_html__( 'Choose Data Type', 'jnews-video' ),
			'description' => esc_html__( 'Choose data for this block.', 'jnews-video' ),
			'std'         => 'custom',
			'value'       => array(
				esc_html__( 'User data', 'jnews-video' )   => 'user',
				esc_html__( 'Custom data', 'jnews-video' ) => 'custom',
			),
		);

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'user_data',
			'group'       => esc_html__( 'Header', 'jnews-video' ),
			'heading'     => esc_html__( 'Choose The User', 'jnews-video' ),
			'description' => esc_html__( 'Choose user that will be use as icon and title.', 'jnews-video' ),
			'value'       => jnews_get_all_author(),
			'dependency'  => array(
				'element' => 'data_type',
				'value'   => 'user',
			),
		);

		$this->options[] = array(
			'type'        => 'attach_image',
			'param_name'  => 'header_icon',
			'group'       => esc_html__( 'Header', 'jnews-video' ),
			'heading'     => esc_html__( 'Header Icon', 'jnews-video' ),
			'description' => esc_html__( 'Choose an image for this block icon (recommend to use a square image).', 'jnews-video' ),
			'dependency'  => array(
				'element' => 'data_type',
				'value'   => 'custom',
			),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'first_title',
			'holder'      => 'span',
			'group'       => esc_html__( 'Header', 'jnews-video' ),
			'heading'     => esc_html__( 'Title', 'jnews-video' ),
			'description' => esc_html__( 'Main title of Module Block.', 'jnews-video' ),
			'dependency'  => array(
				'element' => 'data_type',
				'value'   => 'custom',
			),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'section',
			'holder'      => 'span',
			'group'       => esc_html__( 'Header', 'jnews-video' ),
			'heading'     => esc_html__( 'Section', 'jnews-video' ),
			'description' => esc_html__( 'Main title of Module Block.', 'jnews-video' ),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'second_title',
			'holder'      => 'span',
			'group'       => esc_html__( 'Header', 'jnews-video' ),
			'heading'     => esc_html__( 'Subtitle', 'jnews-video' ),
			'description' => esc_html__( 'Subtitle of Module Block.', 'jnews-video' ),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'url',
			'group'       => esc_html__( 'Header', 'jnews-video' ),
			'heading'     => esc_html__( 'Title URL', 'jnews-video' ),
			'description' => esc_html__( 'Insert URL of heading title.', 'jnews-video' ),
			'dependency'  => array(
				'element' => 'data_type',
				'value'   => 'custom',
			),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'section_url',
			'group'       => esc_html__( 'Header', 'jnews-video' ),
			'heading'     => esc_html__( 'Section URL', 'jnews-video' ),
			'description' => esc_html__( 'Insert URL of heading section.', 'jnews-video' ),
		);
		$this->options[] = array(
			'type'        => 'checkbox',
			'param_name'  => 'follow_button',
			'group'       => esc_html__( 'Header', 'jnews-video' ),
			'heading'     => esc_html__( 'Enable Follow Button', 'jnews-video' ),
			'description' => esc_html__( 'Check this option to enable follow button.', 'jnews-video' ),
		);
		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'follow_user',
			'group'       => esc_html__( 'Header', 'jnews-video' ),
			'heading'     => esc_html__( 'Choose The User to Follow', 'jnews-video' ),
			'description' => wp_kses(
				sprintf( __( "Choose user that will be followed and make sure you already install <a href='%s' target='_blank'>BuddyPress Follow</a> plugin.", 'jnews-video' ), 'https://wordpress.org/plugins/buddypress-followers/' ),
				wp_kses_allowed_html()
			),
			'value'       => jnews_get_all_author(),
			'dependency'  => array(
				'element' => 'follow_button',
				'value'   => 'true',
			),
		);
	}

	public function set_playlist_content_option() {
		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_playlist',
			'options'     => 'jeg_get_playlist_option',
			'nonce'       => wp_create_nonce( 'jeg_find_playlist' ),
			'param_name'  => 'include_post',
			'heading'     => esc_html__( 'Choose filterable Playlist', 'jnews-video' ),
			'description' => esc_html__( 'Choose which playlist you want to show on this module.', 'jnews-video' ),
			'group'       => esc_html__( 'Content Filter', 'jnews-video' ),
			'default'     => true,
		);

		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_author',
			'options'     => 'jeg_get_author_option',
			'nonce'       => wp_create_nonce( 'jeg_find_author' ),
			'param_name'  => 'include_author',
			'heading'     => esc_html__( 'Author', 'jnews-video' ),
			'description' => esc_html__( 'Choose which author you want to show on this module.', 'jnews-video' ),
			'group'       => esc_html__( 'Content Filter', 'jnews-video' ),
			'std'         => '',
		);

		$this->options[] = array(
			'type'        => 'slider',
			'param_name'  => 'number_post',
			'heading'     => esc_html__( 'Number of Post', 'jnews-video' ),
			'description' => esc_html__( 'Show number of post on this module.', 'jnews-video' ),
			'group'       => esc_html__( 'Content Filter', 'jnews-video' ),
			'min'         => 1,
			'max'         => 30,
			'step'        => 1,
			'std'         => $this->default_number_post,
		);
	}

	public function set_ajax_filter_option( $number = 10 ) {
		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'pagination_mode',
			'heading'     => esc_html__( 'Choose Pagination Mode', 'jnews-video' ),
			'description' => esc_html__( 'Choose which pagination mode that fit with your block.', 'jnews-video' ),
			'group'       => esc_html__( 'Pagination', 'jnews-video' ),
			'std'         => 'disable',
			'value'       => array(
				esc_html__( 'No Pagination', 'jnews-video' ) => 'disable',
				esc_html__( 'Next Prev', 'jnews-video' ) => 'nextprev',
				esc_html__( 'Load More', 'jnews-video' ) => 'loadmore',
				esc_html__( 'Auto Load on Scroll', 'jnews-video' ) => 'scrollload',
			),
		);
		$this->options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'pagination_nextprev_showtext',
			'heading'    => esc_html__( 'Show Navigation Text', 'jnews-video' ),
			'value'      => array( esc_html__( 'Show Next/Prev text in the navigation controls.', 'jnews-video' ) => 'no' ),
			'group'      => esc_html__( 'Pagination', 'jnews-video' ),
			'dependency' => array(
				'element' => 'pagination_mode',
				'value'   => array( 'nextprev' ),
			),
		);

		$this->options[] = array(
			'type'        => 'checkbox',
			'param_name'  => 'nav_position_top',
			'heading'     => esc_html__( 'Move Nav on Header', 'jnews-video' ),
			'description' => esc_html__( 'Check this option to move navigation to the header and it will disable Navigation Text.', 'jnews-video' ),
			'group'       => esc_html__( 'Pagination', 'jnews-video' ),
			'default'     => false,
			'dependency'  => array(
				'element' => 'pagination_mode',
				'value'   => array( 'nextprev' ),
			),
		);

		$this->options[] = array(
			'type'        => 'slider',
			'param_name'  => 'pagination_number_post',
			'heading'     => esc_html__( 'Pagination Post', 'jnews-video' ),
			'description' => esc_html__( 'Number of Post loaded during pagination request.', 'jnews-video' ),
			'group'       => esc_html__( 'Pagination', 'jnews-video' ),
			'min'         => 1,
			'max'         => 30,
			'step'        => 1,
			'std'         => $number,
			'dependency'  => array(
				'element' => 'pagination_mode',
				'value'   => array( 'nextprev', 'loadmore', 'scrollload' ),
			),
		);
		$this->options[] = array(
			'type'        => 'number',
			'param_name'  => 'pagination_scroll_limit',
			'heading'     => esc_html__( 'Auto Load Limit', 'jnews-video' ),
			'description' => esc_html__( 'Limit of auto load when scrolling, set to zero to always load until end of content.', 'jnews-video' ),
			'group'       => esc_html__( 'Pagination', 'jnews-video' ),
			'min'         => 0,
			'max'         => 9999,
			'step'        => 1,
			'std'         => 0,
			'dependency'  => array(
				'element' => 'pagination_mode',
				'value'   => array( 'scrollload' ),
			),
		);
	}

	public function set_typography_option( $instance ) {

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'        => 'title_typography',
				'label'       => esc_html__( 'Title Typography', 'jnews-video' ),
				'description' => esc_html__( 'Set typography for post title', 'jnews-video' ),
				'selector'    => '{{WRAPPER}} .jeg_post_title > a',
			)
		);

		$instance->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'        => 'meta_typography',
				'label'       => esc_html__( 'Meta Typography', 'jnews-video' ),
				'description' => esc_html__( 'Set typography for post meta', 'jnews-video' ),
				'selector'    => '{{WRAPPER}} .jeg_post_meta, {{WRAPPER}} .jeg_post_meta .fa, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a:hover, {{WRAPPER}} .jeg_pl_md_card .jeg_post_category a, {{WRAPPER}}.jeg_postblock .jeg_subcat_list > li > a.current, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta, {{WRAPPER}} .jeg_pl_md_5 .jeg_post_meta .fa, {{WRAPPER}} .jeg_post_category a',
			)
		);
	}
}
