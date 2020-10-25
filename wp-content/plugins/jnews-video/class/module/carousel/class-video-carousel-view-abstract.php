<?php

namespace JNEWS_VIDEO\Module\Carousel;

use JNews\Module\Carousel\CarouselViewAbstract;

/**
 * Class Video_Carousel_View_Abstract
 *
 * @package JNEWS_VIDEO\Module\Carousel
 */
abstract class Video_Carousel_View_Abstract extends CarouselViewAbstract {

	/**
	 * List Content
	 *
	 * @param $results
	 * @param $attr
	 *
	 * @return string
	 */
	public function content( $results, $attr ) {
		$content = '';
		foreach ( $results as $key => $post ) {
			$image            = $this->get_thumbnail( $post->ID, 'jnews-750x375' );
			$additional_class = ( ! has_post_thumbnail( $post->ID ) ) ? ' no_thumbnail' : '';
			$post_meta_style  = $this->get_post_meta_style( $post, $attr );

			$content .=
				'<article ' . jnews_post_class( 'jeg_post' . $additional_class, $post->ID ) . ">
					<div class='box_wrap'>
	                    <div class=\"jeg_thumb\">
	                        " . jnews_edit_post( $post->ID ) . '
	                        <a href="' . get_the_permalink( $post ) . "\" >{$image}</a>
	                    </div>
	                    <div class=\"overlay_content\">
	                        <div class=\"jeg_postblock_content\">
	                            <h3 class=\"jeg_post_title\"><a href=\"" . get_the_permalink( $post ) . '">' . get_the_title( $post ) . '</a></h3>
	                            ' . $post_meta_style . '
	                        </div>
	                    </div>
                    </div>
                </article>';
		}

		return $content;
	}

	/**
	 * Get Post meta style
	 *
	 * @param $post
	 * @param $attr
	 *
	 * @return mixed|string|void
	 */
	public function get_post_meta_style( $post, $attr ) {
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

		if ( get_theme_mod( 'jnews_show_block_meta', true ) ) {
			$trending   = ( vp_metabox( 'jnews_single_post.trending_post', null, $post->ID ) ) ? '<div class="jeg_meta_trending"><a href="' . get_the_permalink( $post ) . '"><i class="fa fa-bolt"></i></a></div>' : '';
			$view_count = jnews_meta_views( $post->ID );

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
				$output .= '</div>';
			} else {
				$output .= '<div class="jeg_post_meta">';
				$output .= $trending;
				$output .= get_theme_mod( 'jnews_show_block_meta_author', true ) ? '<div class="jeg_meta_author">' . $author_avatar . "<a href=\"{$author_url}\">{$author_name}</a></div>" : '';
				$output .= get_theme_mod( 'jnews_show_block_meta_views', false ) ? '<div class="jeg_meta_views"><a href="' . get_the_permalink( $post->ID ) . "\" > {$view_count} " . jnews_return_translation( 'Views', 'jnews-video', 'views' ) . '</a></div>' : '';
				$output .= get_theme_mod( 'jnews_show_block_meta_date', true ) ? '<div class="jeg_meta_date"><a href="' . get_the_permalink( $post ) . '" > ' . $this->format_date( $post ) . '</a></div>' : '';
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

		if ( get_theme_mod( 'jnews_show_block_meta', true ) ) {
			$trending   = ( vp_metabox( 'jnews_single_post.trending_post', null, $post->ID ) ) ? '<div class="jeg_meta_trending"><a href="' . get_the_permalink( $post ) . '"><i class="fa fa-bolt"></i></a></div>' : '';
			$view_count = jnews_meta_views( $post->ID );

			if ( jnews_is_review( $post->ID ) ) {
				$output .= '<div class="jeg_post_meta style_2">';
				$output .= $trending;
				$output .= get_theme_mod( 'jnews_show_block_meta_rating', true ) ? jnews_generate_rating( $post->ID, 'jeg_landing_review' ) : '';
				$output .= '</div>';
			} else {
				$output .= '<div class="jeg_post_meta">';
				$output .= $trending;
				$output .= get_theme_mod( 'jnews_show_block_meta_views', false ) ? '<div class="jeg_meta_views"><a href="' . get_the_permalink( $post->ID ) . "\" > {$view_count} " . jnews_return_translation( 'Views', 'jnews-video', 'views' ) . '</a></div>' : '';
				$output .= get_theme_mod( 'jnews_show_block_meta_date', true ) ? '<div class="jeg_meta_date"><a href="' . get_the_permalink( $post ) . '" > ' . $this->format_date( $post ) . '</a></div>' : '';
				$output .= '</div>';
			}
		}

		return apply_filters( 'jnews_module_post_meta_2', $output, $post, self::getInstance() );
	}

	/**
	 * Render Module
	 *
	 * @param $attr
	 * @param $column_class
	 *
	 * @return mixed
	 */
	public function render_module( $attr, $column_class ) {
		$attr['pagination_number_post'] = 1;
		$results                        = $this->build_query( $attr );

		return $this->render_element( $results['result'], $attr );
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
