<?php
/**
 * @author Jegtheme
 */

namespace JNEWS_VIDEO\Playlist;

/**
 * Class Playlist_Dashboard
 *
 * @package JNEWS_VIDEO\Playlist
 */
class Playlist_Dashboard {

	private $current_page;

	private $playlist_id;

	/**
	 * Playlist_Dashboard constructor.
	 *
	 * @param null $playlist_id
	 */
	public function __construct( $playlist_id = null ) {
		$this->playlist_id = $playlist_id;
		$this->setup_hook();
	}

	/**
	 * Setup Playlist_Dashboard hook
	 */
	protected function setup_hook() {
		add_action( 'delete_attachment', array( $this, 'disable_delete_attachment' ) );
		add_action( 'pre_get_posts', array( $this, 'users_own_attachments' ) );
		add_filter( 'upload_size_limit', array( $this, 'upload_size_limit' ) );
		add_filter( 'ajax_query_attachments_args', array( $this, 'filter_user_media' ) );
		add_filter( 'upload_mimes', array( $this, 'filter_mime_types' ) );
	}

	/**
	 * Get post id
	 *
	 * @return mixed
	 */
	public function get_post_id() {
		return $this->playlist_id;
	}

	/**
	 * Get playlist data
	 *
	 * @return array
	 */
	public function playlist_data() {
		$data = array();
		if ( ! empty( $this->playlist_id ) ) {
			$playlist = get_post( $this->playlist_id );

			$visibility = get_post_meta( $playlist->ID, '_playlist_visibility', true );

			$data = array(
				'id'         => $playlist->ID,
				'title'      => $playlist->post_title,
				'content'    => $playlist->post_content,
				'image'      => get_post_thumbnail_id( $playlist ),
				'visibility' => $visibility,
			);

			return $data;
		}

		return $data;
	}

	/**
	 * Filter mime types
	 *
	 * @param $mime_types
	 *
	 * @return array
	 */
	public function filter_mime_types( $mime_types ) {
		if ( 'edit_account' === $this->current_page ) {
			return array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png',
			);
		}

		return $mime_types;
	}

	/**
	 * Set upload size limit
	 *
	 * @param $size
	 *
	 * @return mixed|void
	 */
	public function upload_size_limit( $size ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			$size = apply_filters( 'jnews_frontend_max_upload_size', ( 2 * 1000 * 1024 ) );
		}

		return $size;
	}

	/**
	 * user own attachments
	 *
	 * @param $wp_query
	 */
	public function users_own_attachments( $wp_query ) {
		if ( is_admin() && $wp_query->is_main_query() ) {
			global $pagenow;

			if ( 'upload.php' === $pagenow || 'media-upload.php' === $pagenow ) {
				if ( ! current_user_can( 'manage_options' ) ) {
					$wp_query->set( 'author', get_current_user_id() );
				}
			}
		}
	}

	/**
	 * filter user media
	 *
	 * @param $query
	 *
	 * @return mixed
	 */
	public function filter_user_media( $query ) {
		if ( ! current_user_can( 'manage_options' ) ) {
			$query['author'] = get_current_user_id();
		}

		return $query;
	}

	/**
	 * Disable delete attachment
	 */
	public function disable_delete_attachment() {
		if ( ! current_user_can( 'manage_options' ) ) {
			exit();
		}
	}

}
