<?php
/**
 * @author : Jegtheme
 */

use JNEWS_VIDEO\Module\Block\Video_Block_Option_Abstract;

class JNews_Video_Block2_Option extends Video_Block_Option_Abstract {
	protected $default_number_post = 3;
	protected $show_excerpt        = false;
	protected $default_ajax_post   = 3;

	public function get_module_name() {
		return esc_html__( 'JNews - Video Block 2', 'jnews-video' );
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
