<?php

namespace JNEWS_VIDEO\Module\Block;

use JNews\Module\Block\BlockOptionAbstract;
use JNews\Util\Cache;

/**
 * Class Video_Block_Option_Abstract
 *
 * @package JNEWS_VIDEO\Module\Block
 */
abstract class Video_Block_Option_Abstract extends BlockOptionAbstract {

	/**
	 * @var array
	 */
	private $custom_taxonomies;

	/**
	 * Set module options
	 */
	public function set_options() {
		$this->set_style_option();

		if ( ! $this->custom_taxonomies = wp_cache_get( 'enable_custom_taxonomies', 'jnews-video' ) ) {
			$taxonomies = Cache::get_enable_custom_taxonomies();
			foreach ( $taxonomies as $key => $value ) {
				$this->custom_taxonomies[] = $key;
			}
			wp_cache_set( 'enable_custom_taxonomies', $this->custom_taxonomies, 'jnews-video' );
		}

		foreach ( $this->options as $idx => $options ) {
			if ( ! empty( $this->custom_taxonomies ) && in_array( $options['param_name'], $this->custom_taxonomies ) ) {
				unset( $this->options[ $idx ] );
			}
			if ( 'post_type' === $options['param_name'] || 'content_type' === $options['param_name'] ) {
				unset( $this->options[ $idx ] );
			}
			if ( 'include_category' === $options['param_name'] || 'exclude_category' === $options['param_name'] || 'include_tag' === $options['param_name'] || 'exclude_tag' === $options['param_name'] ) {
				if ( isset( $options['dependency'] ) ) {
					unset( $this->options[ $idx ]['dependency'] );
				}
			}
		}
	}

	/**
	 * Set general option
	 */
	public function set_setting_option() {
		$group           = esc_html__( 'General', 'jnews-video' );
		$this->options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'video_duration',
			'heading'    => esc_html__( 'Show Time Duration', 'jnews-video' ),
			'value'      => array( esc_html__( 'Show time duration on your block', 'jnews-video' ) => 'yes' ),
			'group'      => $group,
			'std'        => 'yes',
		);

		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'post_meta_style',
			'heading'     => esc_html__( 'Choose Post Meta Style', 'jnews-video' ),
			'description' => esc_html__( 'Choose which post meta style that fit with your block.', 'jnews-video' ),
			'group'       => $group,
			'std'         => 'style_2',
			'value'       => array(
				esc_html__( 'Style 1', 'jnews-video' ) => 'style_1',
				esc_html__( 'Style 2', 'jnews-video' ) => 'style_2',
			),
		);
		$this->options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'author_avatar',
			'heading'    => esc_html__( 'Show Avatar', 'jnews-video' ),
			'value'      => array( esc_html__( 'Show avatar on the post meta.', 'jnews-video' ) => 'yes' ),
			'group'      => $group,
			'std'        => 'yes',
			'dependency' => array(
				'element' => 'post_meta_style',
				'value'   => array( 'style_1' ),
			),
		);

		$this->options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'more_menu',
			'heading'    => esc_html__( 'Show More Menu', 'jnews-video' ),
			'value'      => array( esc_html__( 'Show more menu on block.', 'jnews-video' ) => 'yes' ),
			'std'        => 'yes',
			'group'      => $group,
		);

		$this->options[] = array(
			'type'        => 'checkbox',
			'param_name'  => 'force_normal_image_load',
			'heading'     => esc_html__( 'Use Normal Image Load', 'jnews-video' ),
			'description' => esc_html__( 'Force to use the normal image load for this block.', 'jnews-video' ),
			'group'       => $group,
		);
	}

	/**
	 * Set header module option
	 */
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

	/**
	 * Set ajax filter module option
	 *
	 * @param int $number
	 */
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

	/**
	 * Set content filter module option
	 *
	 * @param int  $number
	 * @param bool $hide_number_post
	 */
	public function set_content_filter_option( $number = 10, $hide_number_post = false ) {
		if ( jnews_is_bp_active() ) {
			$this->options[] = array(
				'type'       => 'checkbox',
				'param_name' => 'bp_member_only',
				'heading'    => esc_html__( 'Show Base on BuddyPress Member', 'jnews-video' ),
				'value'      => array( esc_html__( 'Show post for this module base on BuddyPress member page.', 'jnews-video' ) => 'yes' ),
				'group'      => esc_html__( 'Content Filter', 'jnews-video' ),
			);
		}
		parent::set_content_filter_option( $number, $hide_number_post ); // TODO: Change the autogenerated stub.
	}

	/**
	 * Set typography module option
	 *
	 * @param $instance
	 *
	 * @return bool|void
	 */
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
