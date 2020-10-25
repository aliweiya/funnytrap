<?php
/**
 * @author : Jegtheme
 */

use JNews\Module\ModuleOptionAbstract;

class JNews_Video_Videoheader_Option extends ModuleOptionAbstract {
	public function compatible_column() {
		return array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12 );
	}

	public function get_module_name() {
		return esc_html__( 'JNews - Header Video', 'jnews-video' );
	}

	public function get_category() {
		return esc_html__( 'JNews - Element', 'jnews-video' );

	}

	public function set_options() {
		$this->set_header_option();
		$this->set_style_option();
	}

	public function set_header_option() {
		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'data_type',
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
			'heading'     => esc_html__( 'Section', 'jnews-video' ),
			'description' => esc_html__( 'Main title of Module Block.', 'jnews-video' ),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'second_title',
			'holder'      => 'span',
			'heading'     => esc_html__( 'Subtitle', 'jnews-video' ),
			'description' => esc_html__( 'Subtitle of Module Block.', 'jnews-video' ),
		);
		$this->options[] = array(
			'type'        => 'textfield',
			'param_name'  => 'url',
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
			'heading'     => esc_html__( 'Section URL', 'jnews-video' ),
			'description' => esc_html__( 'Insert URL of heading section.', 'jnews-video' ),
		);
		$this->options[] = array(
			'type'        => 'checkbox',
			'param_name'  => 'follow_button',
			'heading'     => esc_html__( 'Enable Follow Button', 'jnews-video' ),
			'description' => esc_html__( 'Check this option to enable follow button.', 'jnews-video' ),
		);
		$this->options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'follow_user',
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
