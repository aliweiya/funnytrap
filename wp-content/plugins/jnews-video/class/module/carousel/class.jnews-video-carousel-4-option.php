<?php
/**
 * @author : Jegtheme
 */

use JNEWS_VIDEO\Module\Carousel\Video_Carousel_Option_Abstract;

class JNews_Video_Carousel4_Option extends Video_Carousel_Option_Abstract {
	public function get_module_name() {
		return esc_html__( 'JNews - Video Carousel 4', 'jnews-video' );
	}

	public function get_category() {
		return esc_html__( 'JNews - Carousel', 'jnews-video' );
	}
}
