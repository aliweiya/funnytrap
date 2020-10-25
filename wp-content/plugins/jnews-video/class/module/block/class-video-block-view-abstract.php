<?php

namespace JNEWS_VIDEO\Module\Block;

use JNews\Module\Block\BlockViewAbstract;
use JNews\Util\VideoAttribute;

/**
 * Class Video_Block_View_Abstract
 *
 * @package JNEWS_VIDEO\Module\Block
 */
abstract class Video_Block_View_Abstract extends BlockViewAbstract {
	/**
	 * Additional video attribute
	 *
	 * @param $post
	 * @param $attr
	 *
	 * @return string
	 */
	public function additional_attribute( $post, $attr ) {
		$attr          = is_null( $attr ) ? $this->attribute : $attr;
		$time_duration = vp_metabox( VideoAttribute::$meta_option . '.' . VideoAttribute::$meta_duration, null, $post->ID );
		$duration      = ! empty( $attr['video_duration'] ) ? $time_duration : '';
		$previewer     = vp_metabox( VideoAttribute::$meta_option . '.' . VideoAttribute::$meta_preview, null, $post->ID );
		$output        = '';

		if ( $duration ) {
			$output .= '<div class="jeg_video_length">';
			$output .= '<span>' . normalize_duration( $duration ) . '</span>';
			$output .= '</div>';
		}

		if ( $previewer ) {
			$output .= "<div class=\"jeg_post_video_preview\" data-preview='$previewer'></div>";
		}

		return $output;
	}

	/**
	 * Get post meta style
	 *
	 * @param $post
	 * @param $attr
	 *
	 * @return mixed|string|void
	 */
	public function get_post_meta_style( $post, $attr ) {
		$attr            = is_null( $attr ) ? $this->attribute : $attr;
		$post_meta_style = isset( $attr['post_meta_style'] ) ? $attr['post_meta_style'] : '';
		$avatar          = isset( $attr['author_avatar'] ) ? $attr['author_avatar'] : false;

		/** Style 2 same as default so no need declaration */
		switch ( $post_meta_style ) {
			case 'style_1':
				$post_meta_style = $this->post_meta_1( $post, $avatar, $attr );
				break;
			default:
				$post_meta_style = $this->post_meta_2( $post, $attr );
				break;
		}

		return $post_meta_style;
	}

	/**
	 * Post meta 1
	 *
	 * @param object $post
	 * @param bool   $avatar
	 * @param null   $attr
	 *
	 * @return mixed|string|void
	 */
	public function post_meta_1( $post, $avatar = false, $attr = null ) {
		$output = '';
		$attr   = is_null( $attr ) ? $this->attribute : $attr;

		if ( get_theme_mod( 'jnews_show_block_meta', true ) ) {
			$trending   = ( vp_metabox( 'jnews_single_post.trending_post', null, $post->ID ) ) ? '<div class="jeg_meta_trending"><a href="' . get_the_permalink( $post ) . '"><i class="fa fa-bolt"></i></a></div>' : '';
			$view_count = jnews_meta_views( $post->ID );
			$more_menu  = ! empty( $attr['more_menu'] ) ? jnews_video_add_playlist_menu( $post ) : '';

			/** Author detail */
			$author        = $post->post_author;
			$author_url    = get_author_posts_url( $author );
			$author_name   = get_the_author_meta( 'display_name', $author );
			$author_avatar = $avatar ?
				'<div class="jeg_author_avatar">
                    ' . get_avatar( get_the_author_meta( 'ID', $post->post_author ), 80, null, get_the_author_meta( 'display_name', $post->post_author ) ) . '
                </div>' : '';

			if ( jnews_is_review( $post->ID ) ) {
				$output .= '<div class="jeg_post_meta style_1">';
				$output .= $trending;
				$output .= get_theme_mod( 'jnews_show_block_meta_rating', true ) ? jnews_generate_rating( $post->ID, 'jeg_landing_review' ) : '';
				$output .= $more_menu;
				$output .= '</div>';
			} else {
				$output .= '<div class="jeg_post_meta style_1">';
				$output .= $trending;
				$output .= get_theme_mod( 'jnews_show_block_meta_author', true ) ? '<div class="jeg_meta_author">' . $author_avatar . "<a href=\"{$author_url}\">{$author_name}</a></div>" : '';
				$output .= get_theme_mod( 'jnews_show_block_meta_views', false ) ? '<div class="jeg_meta_views"><a href="' . get_the_permalink( $post->ID ) . "\" > {$view_count} " . jnews_return_translation( 'Views', 'jnews-video', 'views' ) . '</a></div>' : '';
				$output .= get_theme_mod( 'jnews_show_block_meta_date', true ) ? '<div class="jeg_meta_date"><a href="' . get_the_permalink( $post ) . '" > ' . $this->format_date( $post ) . '</a></div>' : '';
				$output .= $more_menu;
				$output .= '</div>';
			}
		}

		return apply_filters( 'jnews_module_post_meta_2', $output, $post, self::getInstance() );
	}

	/**
	 * Post meta 2
	 *
	 * @param $post
	 * @param null $attr
	 *
	 * @return mixed|string|void
	 */
	public function post_meta_2( $post, $attr = null ) {
		$output = '';
		$attr   = is_null( $attr ) ? $this->attribute : $attr;

		if ( get_theme_mod( 'jnews_show_block_meta', true ) ) {
			$trending   = ( vp_metabox( 'jnews_single_post.trending_post', null, $post->ID ) ) ? '<div class="jeg_meta_trending"><a href="' . get_the_permalink( $post ) . '"><i class="fa fa-bolt"></i></a></div>' : '';
			$view_count = jnews_meta_views( $post->ID );
			$more_menu  = ! empty( $attr['more_menu'] ) ? jnews_video_add_playlist_menu( $post ) : '';

			if ( jnews_is_review( $post->ID ) ) {
				$output .= '<div class="jeg_post_meta style_2">';
				$output .= $trending;
				$output .= get_theme_mod( 'jnews_show_block_meta_rating', true ) ? jnews_generate_rating( $post->ID, 'jeg_landing_review' ) : '';
				$output .= $more_menu;
				$output .= '</div>';
			} else {
				$output .= '<div class="jeg_post_meta style_2">';
				$output .= $trending;
				$output .= get_theme_mod( 'jnews_show_block_meta_views', false ) ? '<div class="jeg_meta_views"><a href="' . get_the_permalink( $post->ID ) . "\" > {$view_count} " . jnews_return_translation( 'Views', 'jnews-video', 'views' ) . '</a></div>' : '';
				$output .= get_theme_mod( 'jnews_show_block_meta_date', true ) ? '<div class="jeg_meta_date"><a href="' . get_the_permalink( $post ) . '" > ' . $this->format_date( $post ) . '</a></div>' : '';
				$output .= $more_menu;
				$output .= '</div>';
			}
		}

		return apply_filters( 'jnews_module_post_meta_2', $output, $post, self::getInstance() );
	}

	/**
	 * Render header module
	 *
	 * @param $attr
	 *
	 * @return string
	 */
	public function render_header( $attr ) {

		if ( defined( 'POLYLANG_VERSION' ) ) {
			$attr['first_title']  = jnews_return_polylang( $attr['first_title'] );
			$attr['second_title'] = jnews_return_polylang( $attr['second_title'] );
		}
		$heading = '';
		if ( 'user' === $attr['data_type'] ) {
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
			/** Heading */
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

		/** Now Render Output */
		if ( empty( $heading_title ) ) {
			$output = '';
		} else {
			/** Now Render Output */
			$output =
				"<div class=\"jeg_video_block_heading_wrapper\">
                    {$heading}
                </div>";
		}

		return $output;
	}

	/**
	 * Render module navigation
	 *
	 * @param $attr
	 * @param bool $next
	 * @param bool $prev
	 * @param int  $total_page
	 *
	 * @return mixed|string|void
	 */
	public function render_navigation( $attr, $next = false, $prev = false, $total_page = 1 ) {
		$output           = '';
		$additional_class = $next || $prev ? '' : 'inactive';

		if ( 'nextprev' === $attr['pagination_mode'] ) {
			$next = $next ? '' : 'disabled';
			$prev = $prev ? '' : 'disabled';

			$prev_text = '<i class="fa fa-angle-left"></i>';
			$next_text = '<i class="fa fa-angle-right"></i>';

			if ( $attr['pagination_nextprev_showtext'] && empty( $attr['nav_position_top'] ) ) {
				$additional_class .= ' showtext';
				$prev_text         = '<i class="fa fa-angle-left"></i> ' . jnews_return_translation( 'Prev', 'jnews-video', 'prev_block_video' );
				$next_text         = jnews_return_translation( 'Next', 'jnews-video', 'next_block_video' ) . '  <i class="fa fa-angle-right"></i>';
			}

			$output =
				"<div class=\"jeg_block_nav {$additional_class}\">
                    <a href=\"#\" class=\"prev {$prev}\" title=\"" . jnews_return_translation( 'Previous', 'jnews-video', 'previous_block_video' ) . "\">{$prev_text}</a>
                    <a href=\"#\" class=\"next {$next}\" title=\"" . jnews_return_translation( 'Next', 'jnews-video', 'next_block_video' ) . "\">{$next_text}</a>
                </div>";
		}

		if ( 'loadmore' === $attr['pagination_mode'] || 'scrollload' === $attr['pagination_mode'] ) {
			$next   = $next ? '' : 'disabled';
			$output =
				"<div class=\"jeg_block_loadmore {$additional_class}\">
                    <a href=\"#\" class='{$next}' data-icon='fa-angle-down' data-load='" . jnews_return_translation( 'Show More', 'jnews-video', 'show_more' ) . "' data-loading='" . jnews_return_translation( 'Loading...', 'jnews-video', 'loading' ) . "'> " . jnews_return_translation( 'Show More', 'jnews-video', 'show_more' ) . ' <i class="fa fa-angle-down"></i></a>
                </div>';
		}

		/** This is only for default link method */
		if ( 'nav_1' === $attr['pagination_mode'] || 'nav_2' === $attr['pagination_mode'] || 'nav_3' === $attr['pagination_mode'] ) {
			if ( $total_page > 1 ) {
				$page   = $this->get_current_page();
				$output = $this->render_normal_navigation( $attr, $total_page, $page );
			}
		}

		$output = apply_filters( 'jnews_module_block_search_navigation', $output, $attr, $next, $prev, $total_page );

		return $output;
	}

	/**
	 * Build query
	 *
	 * @param $attr
	 *
	 * @return array
	 */
	protected function build_query( $attr ) {
		$attr['video_only'] = true;
		$attr['post_type']  = 'post';
		if ( jnews_is_bp_active() ) {
			if ( $attr['bp_member_only'] ) {
				$attr['include_author_bp'] = isset( $attr['include_author_bp'] ) && $attr['include_author_bp'] > 0 ? $attr['include_author_bp'] : implode( ',', array( bp_displayed_user_id() ) );
				$attr['include_author']    = $attr['include_author_bp'];
				$this->set_attribute( $attr );
			}
		}

		return parent::build_query( $attr );
	}

}
