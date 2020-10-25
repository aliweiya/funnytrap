<?php
/**
 * @author : Jegtheme
 */

use JNews\Module\Carousel\CarouselOptionAbstract;

class JNews_Video_Carouselplaylist_Option extends CarouselOptionAbstract {
	public function get_module_name() {
		return esc_html__( 'JNews - Playlist Carousel', 'jnews-video' );
	}

	public function get_category() {
		return esc_html__( 'JNews - Element', 'jnews-video' );
	}

	public function set_options() {
		$this->set_carousel_option();
		$this->set_carousel_content();
		$this->set_header_option();
		$this->set_style_option();
	}

	public function set_carousel_option() {
		$this->options[] = array(
			'type'        => 'checkbox',
			'param_name'  => 'show_nav',
			'heading'     => esc_html__( 'Show Nav', 'jnews-video' ),
			'description' => esc_html__( 'Check this option to show navigation for your carousel.', 'jnews-video' ),
			'default'     => true,
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
			'param_name'  => 'number_item',
			'heading'     => esc_html__( 'Number of Item', 'jnews-video' ),
			'description' => esc_html__( 'Set number of carousel item on each slide.', 'jnews-video' ),
			'min'         => 1,
			'max'         => 6,
			'step'        => 1,
			'std'         => 5,
		);

		$this->options[] = array(
			'type'        => 'slider',
			'param_name'  => 'margin',
			'heading'     => esc_html__( 'Item Margin', 'jnews-video' ),
			'description' => esc_html__( 'Set margin width for each slider item.', 'jnews-video' ),
			'min'         => 0,
			'max'         => 100,
			'step'        => 1,
			'std'         => 20,
		);

		$this->options[] = array(
			'type'        => 'checkbox',
			'param_name'  => 'enable_autoplay',
			'heading'     => esc_html__( 'Enable Autoplay', 'jnews-video' ),
			'description' => esc_html__( 'Check this option to enable auto play.', 'jnews-video' ),
		);

		$this->options[] = array(
			'type'        => 'slider',
			'param_name'  => 'autoplay_delay',
			'heading'     => esc_html__( 'Autoplay Delay', 'jnews-video' ),
			'description' => esc_html__( 'Set your autoplay delay (in millisecond).', 'jnews-video' ),
			'min'         => 1000,
			'max'         => 10000,
			'step'        => 500,
			'std'         => 3000,
			'dependency'  => array(
				'element' => 'enable_autoplay',
				'value'   => 'true',
			),
		);
	}

	public function set_carousel_content() {
		$this->options[] = array(
			'type'        => 'select',
			'multiple'    => PHP_INT_MAX,
			'ajax'        => 'jeg_find_playlist',
			'options'     => 'jeg_get_playlist_option',
			'nonce'       => wp_create_nonce( 'jeg_find_playlist' ),
			'param_name'  => 'include_post',
			'heading'     => esc_html__( 'Choose filterable Playlist', 'jnews-review' ),
			'description' => esc_html__( 'Choose which playlist you want to show on this module.', 'jnews-review' ),
			'group'       => esc_html__( 'Content Filter', 'jnews-video' ),
			'default'     => true,
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
			'std'         => 10,
		);
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
}
