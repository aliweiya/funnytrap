<?php

namespace JNEWS_VIDEO\Frontend;

/**
 * Class Frontend_Video_Details
 *
 * @package JNEWS_VIDEO\Frontend
 */
class Frontend_Video_Details {

	/**
	 * @var int
	 */
	private $post_id;

	/**
	 * Frontend_Video_Details constructor.
	 *
	 * @param int $post_id
	 */
	public function __construct( $post_id = null ) {
		$this->post_id = $post_id;
	}

	/**
	 * Get post data for frontend
	 *
	 * @return array
	 */
	public function post_data() {
		$data = array();
		if ( ! empty( $this->post_id ) ) {
			$post = get_post( $this->post_id );

			$categories = get_the_terms( $post->ID, 'category' );
			$category   = array();

			if ( ! empty( $categories ) && is_array( $categories ) ) {
				foreach ( $categories as $term ) {
					$category[] = $term->term_id;
				}
			}

			$tags = get_the_terms( $post->ID, 'post_tag' );
			$tag  = array();

			if ( ! empty( $tags ) && is_array( $tags ) ) {
				foreach ( $tags as $term ) {
					$tag[] = $term->term_id;
				}
			}

			$primary_category = get_post_meta( $post->ID, 'jnews_primary_category', true );
			$post_video       = get_post_meta( $post->ID, '_format_video_embed', true );
			$single_post      = get_post_meta( $post->ID, 'jnews_single_post', true );
			$video_option     = get_post_meta( $post->ID, 'jnews_video_option', true );
			$video_preview    = ! empty( $video_option ) && is_array( $video_option ) && isset( $video_option['video_preview'] ) ? attachment_url_to_postid( $video_option['video_preview'] ) : '';

			$data = array(
				'id'               => $post->ID,
				'title'            => $post->post_title,
				'subtitle'         => get_post_meta( $this->post_id, 'post_subtitle', true ),
				'content'          => $post->post_content,
				'primary-category' => isset( $primary_category['id'] ) ? $primary_category['id'] : '',
				'category'         => implode( ',', $category ),
				'tag'              => implode( ',', $tag ),
				'video'            => $post_video,
				'image'            => get_post_thumbnail_id( $post ),
				'video_preview'    => ! empty( $video_preview ) ? $video_preview : '',
				'duration'         => ! empty( $video_option ) && is_array( $video_option ) && isset( $video_option['video_duration'] ) ? $video_option['video_duration'] : '',
				'source_name'      => ! empty( $single_post ) && is_array( $single_post ) && isset( $single_post['source_name'] ) ? $single_post['source_name'] : '',
				'source_url'       => ! empty( $single_post ) && is_array( $single_post ) && isset( $single_post['source_url'] ) ? $single_post['source_url'] : '',
				'via_name'         => ! empty( $single_post ) && is_array( $single_post ) && isset( $single_post['via_name'] ) ? $single_post['via_name'] : '',
				'via_url'          => ! empty( $single_post ) && is_array( $single_post ) && isset( $single_post['via_url'] ) ? $single_post['via_url'] : '',
			);

			return $data;
		}

		return $data;
	}
}
