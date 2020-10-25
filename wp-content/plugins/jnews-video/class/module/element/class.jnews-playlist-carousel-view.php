<?php
/**
 * @author : Jegtheme
 */

use JNews\Module\Carousel\CarouselViewAbstract;

class JNews_Video_Carouselplaylist_View extends CarouselViewAbstract {

	public function render_element( $result, $attr ) {
		if ( ! empty( $result ) ) {
			$content        = $this->content( $result );
			$heading        = $this->render_header( $attr );
			$width          = $this->manager->get_current_width();
			$autoplay_delay = isset( $attr['autoplay_delay']['size'] ) ? $attr['autoplay_delay']['size'] : $attr['autoplay_delay'];
			$number_item    = isset( $attr['number_item']['size'] ) ? $attr['number_item']['size'] : $attr['number_item'];
			$margin         = isset( $attr['margin']['size'] ) ? $attr['margin']['size'] : $attr['margin'];
			$nav_top        = ( ! empty( $attr['nav_position_top'] ) ) ? 'nav_top' : '';

			$placeholder = '';
			for ( $i = 1; $i <= $number_item; $i ++ ) {
				$space        = ( $i != $number_item ) ? "margin-right: {$margin}px;" : '';
				$space       .= $attr['show_nav'] ? 'margin-bottom: 121px;' : 'margin-bottom: 79px;';
				$placeholder .= "<div class='thumbnail-inner' style='$space'><div class='thumbnail-container size-715'></div></div>";
			}

			$output =
				"<div {$this->element_id($attr)} class=\"jnews_video jeg_playlist_wrapper {$nav_top} jeg_col_{$width} {$this->unique_id} {$this->get_vc_class_name()} {$this->color_scheme()} {$attr['el_class']} slider_4\">
					{$heading}
					<div class='jeg_carousel_placeholder'>
						<div class='thumbnail-wrapper'>
							{$placeholder}
						</div>
					</div>
                    <div class=\"jeg_playlist owl-carousel\" data-nav='{$attr['show_nav']}' data-autoplay='{$attr['enable_autoplay']}' data-delay='{$autoplay_delay}' data-items='{$number_item}' data-margin='{$margin}'>
                        {$content}
                    </div>
                </div>";

			return $output;
		} else {
			return $this->empty_content();
		}
	}

	public function content( $results ) {
		$content = '';
		foreach ( $results as $key => $post ) {
			$videos    = jnews_video_get_playlist_count( $post->ID );
			$post_meta = "<div class=\"jeg_post_meta\">
								<span class=\"jeg_video_count\">{$videos} " . jnews_return_translation( 'Videos', 'jnews-video', 'videos' ) . '</span>
			                </div>';

			$image    = $this->get_thumbnail( $post->ID, 'jnews-350x250' );
			$content .=
				'<article ' . jnews_post_class( 'jeg_post', $post->ID ) . ">
					<div class='box_wrap'>
	                    <div class=\"jeg_thumb\">
	                        " . jnews_edit_post( $post->ID ) . '
	                        <a href="' . get_the_permalink( $post ) . "\">$image</a>
	                    </div>
	                    <div class=\"jeg_postblock_content\">
	                        <h3 class=\"jeg_post_title\"><a href=\"" . get_the_permalink( $post ) . '">' . get_the_title( $post ) . "</a></h3>
	                        {$post_meta}
	                    </div>
                    </div>
                </article>";
		}

		return $content;
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

	protected function build_query( $attr ) {
		$attr['post_type']   = 'playlist';
		$attr['post_offset'] = 0;

		if ( ! empty( $attr['include_post'] ) ) {
			$attr['sort_by'] = 'post__in';
		}

		return parent::build_query( $attr );
	}
}
