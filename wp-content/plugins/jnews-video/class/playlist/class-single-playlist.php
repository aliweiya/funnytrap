<?php

namespace JNEWS_VIDEO\Playlist;

use WP_Post;

/**
 * Class Single_Playlist
 *
 * @package JNEWS_VIDEO\Playlist
 */
class Single_Playlist {
	/**
	 * Instance for Single_Playlist
	 *
	 * @var Single_Playlist
	 */
	private static $instance;

	/**
	 * @var WP_Post
	 */
	private $playlist_id;

	/**
	 * Single_Playlist constructor.
	 */
	private function __construct() {
		$this->playlist_id = get_the_ID();
		$this->hook();
	}

	/**
	 * Setup Single_Playlist hook
	 */
	private function hook() {
		add_action( 'jnews_single_playlist_before_title', array( $this, 'label_playlist' ) );
	}

	/**
	 * Singleton page of Single_Playlist class
	 *
	 * @return Single_Playlist
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Set playlist id
	 *
	 * @param $playlist_id
	 *
	 * @return $this
	 */
	public function set_playlist_id( $playlist_id ) {
		$this->playlist_id = $playlist_id;

		return $this;
	}

	/**
	 * Set Template class
	 */
	public function template_class() {
		if ( get_post_type( $this->playlist_id ) === 'playlist' ) {
			$classes = 'jeg_single_playlist_' . $this->get_template();
			echo $classes;
		}
	}

	/**
	 * @return mixed|void
	 */
	public function get_template() {
		$layout = get_theme_mod( 'jnews_single_playlist_template', '1' );

		return apply_filters( 'jnews_single_playlist_template', $layout, $this->playlist_id );
	}

	/**
	 * Set main class
	 */
	public function main_class() {
		$layout = $this->get_layout();

		switch ( $layout ) {
			case 'right-sidebar':
				echo 'jeg_sidebar_right';
				break;
			case 'left-sidebar':
				echo 'jeg_sidebar_left';
				break;
			default:
				break;
		}
	}

	/**
	 * @return mixed|void
	 */
	public function get_layout() {
		$layout = get_theme_mod( 'jnews_single_playlist_layout', 'left-sidebar' );

		return apply_filters( 'jnews_single_playlist_layout', $layout, $this->playlist_id );
	}

	/**
	 * get label playlist
	 */
	public function label_playlist() {

		$output = '<span class="jeg_post_label">' . jnews_return_translation( 'Playlist', 'jnews-video', 'playlist' ) . '</span>';
		echo jnews_sanitize_by_pass( $output );
	}

	/**
	 * Post Meta
	 */
	public function render_post_meta() {
		if ( $this->show_post_meta() ) {
			jnews_video_get_template_part( '/fragment/playlist/meta-playlist' );
		}
	}

	/**
	 * @return mixed|void
	 */
	public function show_post_meta() {
		$flag = get_theme_mod( 'jnews_single_playlist_show_post_meta', true );

		return apply_filters( 'jnews_single_playlist_show_post_meta', $flag, $this->playlist_id );
	}

	/**
	 * render playlist option
	 */
	public function render_post_option() {
		if ( $this->show_post_option() ) {
			jnews_video_get_template_part( '/fragment/playlist/option-playlist' );
		}
	}

	/**
	 * @return mixed|void
	 */
	public function show_post_option() {
		$flag = get_theme_mod( 'jnews_single_playlist_show_post_option', true );

		return apply_filters( 'jnews_single_playlist_show_post_option', $flag, $this->playlist_id );
	}

	/**
	 * @return mixed|void
	 */
	public function show_author_meta_image() {
		$flag = get_theme_mod( 'jnews_single_playlist_show_playlist_author_image', false );

		return apply_filters( 'jnews_single_playlist_show_playlist_author_image', $flag, $this->playlist_id );
	}

	/**
	 * @return mixed|void
	 */
	public function show_author_meta() {
		$flag = get_theme_mod( 'jnews_single_playlist_show_playlist_author', true );

		return apply_filters( 'jnews_single_playlist_show_playlist_author', $flag, $this->playlist_id );
	}

	/**
	 * @return mixed|void
	 */
	public function show_total_video_meta() {
		$flag = get_theme_mod( 'jnews_single_playlist_show_playlist_total_video', true );

		return apply_filters( 'jnews_single_playlist_show_playlist_total_video', $flag, $this->playlist_id );
	}

	/**
	 * @return mixed|void
	 */
	public function show_subscribe_button() {
		$flag = false;
		if ( function_exists( 'bp_follow_get_add_follow_button' ) && function_exists( 'bp_loggedin_user_id' ) ) {
			$flag = get_theme_mod( 'jnews_single_playlist_show_subscribe', true );
		}

		return apply_filters( 'jnews_single_playlist_show_subscribe', $flag, $this->playlist_id );
	}

	/**
	 * @return mixed|void
	 */
	public function show_follower_count() {
		$flag = get_theme_mod( 'jnews_single_playlist_show_subscribe_count', true );

		return apply_filters( 'jnews_single_playlist_show_subscribe_count', $flag, $this->playlist_id );
	}

	/**
	 * @return mixed|void
	 */
	public function show_share_button() {
		$flag = get_theme_mod( 'jnews_single_playlist_show_share_button', true );

		return apply_filters( 'jnews_single_playlist_show_share_button', $flag, $this->playlist_id );
	}

	/**
	 * @return mixed|void
	 */
	public function show_more_option() {
		$flag = get_theme_mod( 'jnews_single_playlist_show_more_option', true );

		return apply_filters( 'jnews_single_playlist_show_more_option', $flag, $this->playlist_id );
	}

	/**
	 * @param $size
	 *
	 * @return mixed|string|void
	 */
	public function featured_image( $size ) {
		if ( $this->show_featured_image() ) {
			if ( has_post_thumbnail() ) {
				$output = '<div class="jeg_featured featured_image">';

				$popup     = get_theme_mod( 'jnews_single_popup_script', 'magnific' );
				$image_src = $this->get_featured_image_src( 'full' );

				$output .= ( 'disable' !== $popup ) ? "<a href=\"{$image_src}\">" : '';
				$output .= apply_filters( 'jnews_image_thumbnail_unwrap', $this->playlist_id, $size );
				$output .= ( 'disable' !== $popup ) ? '</a>' : '';

				$output .= '</div>';

				return apply_filters( 'jnews_featured_image', $output, $this->playlist_id );
			}
		}

		return '';
	}

	/**
	 * @return mixed|void
	 */
	public function show_featured_image() {
		$flag = get_theme_mod( 'jnews_single_playlist_show_featured', true );

		return apply_filters( 'jnews_single_playlist_show_featured', $flag, $this->playlist_id );
	}

	/**
	 * @param $size
	 *
	 * @return mixed
	 */
	public function get_featured_image_src( $size ) {
		$post_thumbnail_id = get_post_thumbnail_id( $this->playlist_id );
		$image             = wp_get_attachment_image_src( $post_thumbnail_id, $size );

		return $image[0];
	}

}
