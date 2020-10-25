<?php
/**
 * @author : Jegtheme
 */

use JNEWS_VIDEO\Module\Carousel\Video_Carousel_View_Abstract;

class JNews_Video_Carousel4_View extends Video_Carousel_View_Abstract {
	public function render_element( $result, $attr ) {
		if ( ! empty( $result ) ) {
			$content        = $this->content( $result, $attr );
			$heading        = $this->render_header( $attr );
			$width          = $this->manager->get_current_width();
			$name           = 'video_carousel_4';
			$autoplay_delay = isset( $attr['autoplay_delay']['size'] ) ? $attr['autoplay_delay']['size'] : $attr['autoplay_delay'];
			$number_item    = isset( $attr['number_item']['size'] ) ? $attr['number_item']['size'] : $attr['number_item'];
			$margin         = isset( $attr['margin']['size'] ) ? $attr['margin']['size'] : $attr['margin'];
			$slider_style   = 'slider_4';
			$center         = 'false';
			$mergeFit       = 'false';
			$stagePadding   = 0;
			$placeholder    = '';
			for ( $i = 1; $i <= $number_item; $i ++ ) {
				$space        = ( $i != $number_item ) ? "margin-right: {$margin}px;" : '';
				$space       .= 'margin-bottom: 79px;';
				$placeholder .= "<div class='thumbnail-inner' style='$space'><div class='thumbnail-container size-500'></div></div>";
			}

			$output =
				"<div {$this->element_id($attr)} class=\"jnews_video jeg_postblock_{$name} jeg_postblock_video_carousel jeg_postblock jeg_col_{$width} {$this->unique_id} {$this->get_vc_class_name()} {$this->color_scheme()} {$attr['el_class']} {$slider_style}\">
					{$heading}
					<div class='jeg_carousel_placeholder'>
						<div class='thumbnail-wrapper'>
							{$placeholder}
						</div>
					</div>			
                    <div class=\"jeg_carousel_post\" style=\"display: none;\" data-nav='{$attr['show_nav']}' data-autoplay='{$attr['enable_autoplay']}' data-delay='{$autoplay_delay}' data-items='{$number_item}' data-margin='{$margin}' data-center='{$center}' data-stagepadding='$stagePadding' data-mergefit='{$mergeFit}' data-sliderstyle='{$slider_style}'>
                        {$content}
                    </div>
                </div>";

			return $output;
		} else {
			return $this->empty_content();
		}
	}

	public function render_header( $attr ) {

		if ( defined( 'POLYLANG_VERSION' ) ) {
			$attr['first_title']  = jnews_return_polylang( $attr['first_title'] );
			$attr['second_title'] = jnews_return_polylang( $attr['second_title'] );
		}
		$heading = '';
		if ( $attr['data_type'] === 'user' ) {
			$author      = $attr['user_data'];
			$author_url  = get_author_posts_url( $author );
			$author_name = get_the_author_meta( 'display_name', $author );
			$title       = $author_name;
			$url         = $author_url;
			$avatar_args = array(
				'size' => 75,
			);
			$image       = get_avatar_url( $author, $avatar_args );
		} else {
			$title = $attr['first_title'];
			$url   = $attr['url'];
			$image = ( isset( $attr['header_icon']['id'] ) && ! empty( $attr['header_icon']['id'] ) ) ? wp_get_attachment_image_src( $attr['header_icon']['id'], 'jnews-75x75' )[0] : wp_get_attachment_image_src( $attr['header_icon'], 'jnews-75x75' )[0];
		}
		if ( ! empty( $title ) ) {
			// Heading
			$subtitle      = ! empty( $attr['second_title'] ) ? "<span class=\"subtitle\">{$attr['second_title']}</span>" : '';
			$heading_image = $image;
			$heading_icon  = ! empty( $heading_image ) ? "<img src='{$heading_image}' alt='{$attr['first_title']}' data-pin-no-hover=\"true\">" : '';
			$heading_icon  = ! empty( $attr['url'] ) ? "<a href='{$attr['url']}'>{$heading_icon}</a>" : $heading_icon;
			$section       = ! empty( $attr['section'] ) ? '<span ' . ( empty( $attr['section_url'] ) ? "class='tag_content'" : '' ) . " >{$attr['section']}</span>" : '';
			$section       = ! empty( $attr['section_url'] ) ? "<a href='{$attr['section_url']}' class='tag_content' >{$section}</a>" : $section;
			$heading_title = "<span>{$title}</span>";
			$heading_title = ! empty( $url ) ? "<a href='{$url}'>{$heading_title}</a>" : $heading_title;
			$heading_title = "<h3 class=\"jeg_block_title\">{$heading_title}</h3>";
			$follow_button = ! empty( $attr['follow_button'] ) ? ( ! empty( $attr['follow_user'] ) ? jnews_video_render_subscribe_member_actions( $attr['follow_user'] ) : '' ) : '';
			$follow_button = ! empty( $follow_button ) ? '<div class="follow-wrapper">' . $follow_button . '<div class="jnews-spinner" style="display: none"><i class="fa fa-spinner fa-pulse active"></i></div></div>' : '';
			$heading       = "<div class='jeg_video_block_heading'>{$heading_icon}{$heading_title}{$section}{$subtitle}{$follow_button}</div>";
		}

		// Now Render Output
		if ( empty( $heading_title ) ) {
			$output = '';
		} else {
			// Now Render Output
			$output =
				"<div class=\"jeg_video_block_heading_wrapper\">
                    {$heading}
                </div>";
		}

		return $output;
	}
}
