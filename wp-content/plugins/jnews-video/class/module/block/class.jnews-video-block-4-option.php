<?php
/**
 * @author : Jegtheme
 */

use JNEWS_VIDEO\Module\Block\Video_Block_Option_Abstract;

class JNews_Video_Block4_Option extends Video_Block_Option_Abstract {
	protected $default_number_post = 4;
	protected $show_excerpt        = false;
	protected $default_ajax_post   = 4;

	public function get_module_name() {
		return esc_html__( 'JNews - Video Block 4', 'jnews-video' );
	}

	public function get_category() {
		return esc_html__( 'JNews - Module', 'jnews-video' );
	}

	public function set_options() {
		$this->set_setting_option();
		$this->set_header_option();
		$this->set_content_filter_option( $this->default_number_post );
		$this->set_ajax_filter_option( $this->default_ajax_post );
		parent::set_options();
	}
}
