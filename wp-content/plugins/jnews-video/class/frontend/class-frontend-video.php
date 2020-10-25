<?php

namespace JNEWS_VIDEO\Frontend;

use Exception;
use JNews\Util\VideoAttribute;
use JNews_Frontend_Submit;

/**
 * Class Frontend_Video
 *
 * @package JNEWS_VIDEO\Frontend
 */
class Frontend_Video extends JNews_Frontend_Submit {
	/**
	 * Instance of Frontend_Video
	 *
	 * @var Frontend_Video
	 */
	private static $instance;

	/**
	 * @var mixed
	 */
	private $endpoint;

	/**
	 * @var string
	 */
	private $post_flag = 'jnews_frontend_submit_post_flag';

	/**
	 * Frontend_Video constructor.
	 */
	private function __construct() {
		$this->endpoint = Frontend_Video_Endpoint::getInstance()->get_endpoint();
		$this->setup_hook();
	}

	/**
	 * Setup Frontend_Video hook
	 */
	protected function setup_hook() {
		add_action( 'wp_loaded', array( $this, 'submit_handler' ), 20 );
		add_action( 'jnews_ajax_video_handler', array( $this, 'video_handler' ) );
	}

	/**
	 * Singleton page of Frontend_Video class
	 *
	 * @return Frontend_Video
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Video action handler
	 */
	public function video_handler() {
		if ( is_user_logged_in() ) {
			$this->do_action_type();
		} else {
			wp_send_json(
				array(
					'response' => 0,
					'message'  => jnews_return_translation( 'You must login to do this thing!', 'jnews-video', 'video_must_login' ),
				)
			);
		}

		die();
	}

	/**
	 * Video action
	 */
	public function do_action_type() {
		$nonce = empty( $_POST['nonce'] ) ? false : wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'jnews-video-frontend-nonce' );
		if ( $nonce && isset( $_POST['url'] ) && isset( $_POST['type'] ) ) {
			switch ( $_POST['type'] ) {
				case 'embed-video':
					$details = VideoAttribute::getInstance()->get_video_attribute( $_POST['url'] );
					if ( ! is_wp_error( $details ) ) {
						if ( ! empty( $details ) ) {
							wp_send_json(
								array(
									'response' => 1,
									'details'  => $details,
								)
							);
						}
						wp_send_json(
							array(
								'response' => 0,
								'message'  => jnews_return_translation( 'Provider is not supported', 'jnews-video', 'provider_not_supported' ),
							)
						);
					}
					wp_send_json(
						array(
							'response' => 0,
							'message'  => jnews_return_translation( 'Internal Server Error!', 'jnews-video', 'internal_server_error' ),
						)
					);
					break;
				default:
					wp_send_json(
						array(
							'response' => 0,
							'message'  => jnews_return_translation( 'Internal Server Error!', 'jnews-video', 'internal_server_error' ),
						)
					);
					break;
			}
		}
	}

	/**
	 * Frontend_Video submit handler
	 *
	 * @return bool
	 */
	public function submit_handler() {
		if ( defined( 'JNEWS_SANDBOX_URL' ) ) {
			return false;
		}

		if ( isset( $_REQUEST['jnews-action'] ) && ! empty( $_REQUEST['jnews-editor-nonce'] ) && wp_verify_nonce( $_REQUEST['jnews-editor-nonce'], 'jnews-editor' ) ) {
			$action = $_REQUEST['jnews-action'];

			switch ( $action ) {
				case 'upload-video':
				case 'edit-video':
					$this->global_post_handler( $action );
					break;
				default:
					return false;
			}
		}

		return false;
	}


	protected function global_post_handler( $action ) {

		try {
			$post_id   = '';
			$user_id   = get_current_user_id();
			$video_url = '';

			if ( 'edit-video' === $action ) {
				if ( isset( $_POST['post-id'] ) ) {
					$post_id = $_POST['post-id'];
				}
				if ( empty( $post_id ) ) {
					throw new Exception( esc_html__( 'Post not found!', 'jnews-video' ) );
				}

				$temporary_post = get_post( $post_id );
				if ( ! $temporary_post ) {
					throw new Exception( esc_html__( 'Post not found!', 'jnews-video' ) );
				}

				if ( $user_id !== (int) $temporary_post->post_author ) {
					throw new Exception( sprintf( jnews_return_translation( 'User %s is not the owner!', 'jnews-video', 'user_is_not_the_owner' ), $user_id ) );
				}
			}

			if ( empty( $_POST['title'] ) ) {
				throw new Exception( esc_html__( 'Post title cannot be empty', 'jnews-video' ) );
			}

			if ( isset( $_POST['video-format'] ) ) {
				if ( 'video' === $_POST['video-format'] ) {
					$video_url = isset( $_POST['video'] ) ? $_POST['video'] : '';
				}
				if ( 'embed-video' === $_POST['video-format'] ) {
					$video_url  = isset( $_POST['embed-video'] ) ? $_POST['embed-video'] : '';
					$video_type = VideoAttribute::getInstance()->get_video_provider( $video_url );
					if ( 'mp4' !== $video_type && 'oembed' !== $video_type ) {
						$video_attribute = VideoAttribute::getInstance()->get_video_attribute( $video_url );
					}
				}
			}

			if ( empty( $video_url ) ) {
				throw new Exception( esc_html__( 'Video cannot be empty', 'jnews-video' ) );
			}

			if ( isset( $video_attribute ) && empty( $video_attribute ) ) {
				throw new Exception( esc_html__( 'URL or embed code is not supported', 'jnews-video' ) );
			}

			$args = array(
				'post_title'   => sanitize_text_field( $_POST['title'] ),
				'post_content' => $_POST['content'],
			);
			if ( 'edit-video' === $action ) {
				$args['ID'] = $post_id;
				$args       = apply_filters( 'jnews_frontend_submit_edit_video', $args );
				$post_id    = wp_update_post( $args );
			} else {
				$args['post_type']   = 'post';
				$args['post_status'] = 'pending';
				$args['post_author'] = $user_id;
				$args                = apply_filters( 'jnews_frontend_submit_upload_video', $args );
				$post_id             = wp_insert_post( $args );
			}

			if ( is_wp_error( $post_id ) ) {
				throw new Exception( $post_id->get_error_message() );
			} else {
				$single_post  = get_post_meta( $post_id, 'jnews_single_post', true );
				$video_option = get_post_meta( $post_id, 'jnews_video_option', true );

				if ( isset( $_POST['subtitle'] ) ) {
					update_post_meta( $post_id, 'post_subtitle', $_POST['subtitle'] );
				}

				if ( isset( $_POST['primary-category'] ) ) {
					update_post_meta( $post_id, 'jnews_primary_category', array( 'id' => $_POST['primary-category'] ) );
				}

				if ( isset( $_POST['category'] ) ) {
					wp_set_post_terms( $post_id, $_POST['category'], 'category' );
				}

				if ( isset( $_POST['tag'] ) ) {
					wp_set_post_tags( $post_id, array_map( 'intval', explode( ',', $_POST['tag'] ) ) );
				}

				if ( isset( $_POST['source_name'] ) ) {
					if ( isset( $single_post ) && is_array( $single_post ) ) {
						$single_post['source_name'] = $_POST['source_name'];
					} else {
						$single_post = array(
							'source_name' => $_POST['source_name'],
						);
					}
					if ( isset( $_POST['source_url'] ) ) {
						$single_post['source_url'] = $_POST['source_url'];
					}
				}

				if ( isset( $_POST['via_name'] ) ) {
					if ( isset( $single_post ) && is_array( $single_post ) ) {
						$single_post['via_name'] = $_POST['via_name'];
					} else {
						$single_post = array(
							'via_name' => $_POST['via_name'],
						);
					}
					if ( isset( $_POST['via_url'] ) ) {
						$single_post['via_url'] = $_POST['via_url'];
					}
				}

				if ( isset( $_POST['duration'] ) ) {
					if ( isset( $video_option ) && is_array( $video_option ) ) {
						$video_option['video_duration'] = $_POST['duration'];
					} else {
						$video_option = array(
							'video_duration' => $_POST['duration'],
						);
					}
				}

				if ( isset( $_POST['video-preview-format'] ) ) {
					if ( 'video-preview' === $_POST['video-preview-format'] && isset( $_POST['video-preview'] ) ) {
						$video_preview_url = wp_get_attachment_url( $_POST['video-preview'][0] );
						if ( isset( $video_option ) && is_array( $video_option ) ) {
							$video_option['video_preview'] = $video_preview_url;
						} else {
							$video_option = array(
								'video_preview' => $video_preview_url,
							);
						}
					}
					if ( 'video-preview-url' === $_POST['video-preview-format'] && isset( $_POST['video-preview-url'] ) ) {
						$attachment_id     = VideoAttribute::getInstance()->save_to_media_library( $post_id, isset( $_POST['video-preview-url'] ) ? $_POST['video-preview-url'] : '' );
						$video_preview_url = wp_get_attachment_url( $attachment_id );
						if ( isset( $video_option ) && is_array( $video_option ) ) {
							$video_option['video_preview'] = $video_preview_url;
						} else {
							$video_option = array(
								'video_preview' => $video_preview_url,
							);
						}
					}
				}

				if ( isset( $video_attribute ) ) {
					if ( isset( $video_attribute['thumbnail'] ) ) {
						$video_attribute['thumbnail'] = '';
					}

					if ( isset( $video_attribute['video_preview'] ) ) {
						unset( $video_attribute['video_preview'] );
					}
					VideoAttribute::getInstance()->save_attribute_to_post( $video_attribute, $post_id, $video_url );
				}

				if ( isset( $_POST['image-format'] ) ) {
					if ( 'image' === $_POST['image-format'] && isset( $_POST['image'] ) ) {
						update_post_meta( $post_id, '_thumbnail_id', isset( $_POST['image'][0] ) ? $_POST['image'][0] : '' );
					}
					if ( 'image-url' === $_POST['image-format'] && isset( $_POST['image-url'] ) ) {
						$attachment_id = VideoAttribute::getInstance()->save_to_media_library( $post_id, isset( $_POST['image-url'] ) ? $_POST['image-url'] : '' );
						if ( ! empty( $attachment_id ) ) {
							if ( 'edit-video' === $action ) {
								update_post_meta( $post_id, '_thumbnail_id', $attachment_id );
							} else {
								VideoAttribute::getInstance()->set_featured_image( $post_id, $attachment_id, $video_url );
							}
						}
					}
				}

				set_post_format( $post_id, 'video' );
				update_post_meta( $post_id, '_format_video_embed', $video_url );
				update_post_meta( $post_id, 'jnews_video_option', $video_option );
				update_post_meta( $post_id, 'jnews_single_post', $single_post );

				if ( 'edit-video' !== $action ) {
					if ( get_theme_mod( 'jnews_frontend_submit_enable_woocommerce', false ) ) {
						$this->reduce_listing_left( $post_id );
					}

					update_post_meta( $post_id, $this->post_flag, true );
				}

				if ( 'edit-video' === $action ) {
					jnews_flash_message( 'message', esc_html( __( 'Post updated successfully', 'jnews-video' ) ), 'alert-success' );
				} else {
					jnews_flash_message( 'message', esc_html( __( 'Your post has submitted for review', 'jnews-video' ) ), 'alert-success' );
				}

				wp_redirect( home_url( $this->endpoint['upload']['slug'] . '/' . $post_id ) );
				exit;
			}
		} catch ( Exception $e ) {
			jnews_flash_message( 'message', $e->getMessage(), 'alert-danger' );
		}
	}
}
