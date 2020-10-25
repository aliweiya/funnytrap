<?php

namespace JNEWS_VIDEO\Frontend;

use JNews\AccountPage;
use JNews_Frontend_Template;

/**
 * Class Frontend_Video_Endpoint
 *
 * @package JNEWS_VIDEO\Frontend
 */
class Frontend_Video_Endpoint extends JNews_Frontend_Template {

	/**
	 * Instance of Frontend_Video_Endpoint
	 *
	 * @var Frontend_Video_Endpoint
	 */
	private static $instance;

	/**
	 * @var array
	 */
	private static $endpoint;

	/**
	 * @var string
	 */
	private $page_title;

	/**
	 * @var bool
	 */
	private $edit_page = false;

	/**
	 * Frontend_Video_Endpoint constructor.
	 */
	public function __construct() {
		$this->setup_endpoint();
		$this->setup_hook();
	}

	/**
	 * Register endpoint
	 *
	 * @return array
	 */
	public function setup_endpoint() {
		$endpoint       = array(
			'upload'   => array(
				'title' => esc_html__( 'Upload New Video', 'jnews-video' ),
				'label' => 'upload_new_video',
				'slug'  => 'upload',
			),
			'my_video' => array(
				'title' => esc_html__( 'My Video', 'jnews-video' ),
				'label' => 'my_video',
				'slug'  => 'my-video',
			),
		);
		self::$endpoint = $endpoint;

		return self::$endpoint;
	}

	/**
	 * Setup Frontend_Video_Endpoint hook
	 */
	public function setup_hook() {
		add_action( 'init', array( $this, 'setup_init' ) );
		add_filter( 'jnews_frontend_submit_add_page_template', array( $this, 'page_template' ) );
		add_action( 'jnews_account_right_content', array( $this, 'get_right_content' ) );

		add_action( 'jnews_after_account_nav', array( $this, 'after_account_nav' ) );
		add_filter( 'jnews_account_page_endpoint', array( $this, 'account_page_endpoint' ) );

		add_action( 'delete_attachment', array( $this, 'disable_delete_attachment' ) );

		add_filter( 'ajax_query_attachments_args', array( $this, 'filter_user_media' ) );
		add_filter( 'media_view_strings', array( $this, 'remove_media_tab' ) );
		add_filter( 'upload_size_limit', array( $this, 'upload_size_limit' ) );
		add_filter( 'jnews_maxsize_upload_featured_gallery', array( $this, 'maxupload_size' ) );
		add_filter( 'jnews_maxsize_upload_featured_image', array( $this, 'maxupload_size' ) );

	}

	/**
	 * Flush rewrite rules when plugin activation
	 */
	public static function pluginActivation() {
		self::flush_rewrite_rules();
	}

	/**
	 * Flush rules
	 */
	public static function flush_rewrite_rules() {
		self::add_rewrite_rule();

		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}

	/**
	 * Register new endpoint
	 */
	public static function add_rewrite_rule() {
		add_rewrite_endpoint( self::$endpoint['upload']['slug'], EP_ROOT | EP_PAGES );
		add_rewrite_rule( '^' . self::$endpoint['upload']['slug'] . '/page/?([0-9]{1,})/?$', 'index.php?&paged=$matches[1]&' . self::$endpoint['upload']['slug'], 'top' );
	}

	/**
	 * Singleton page of Frontend_Video_Endpoint class
	 *
	 * @return Frontend_Video_Endpoint
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Setup Frontend_Video_Endpoint init
	 */
	public function setup_init() {
		self::add_rewrite_rule();
	}

	/**
	 * Get endpoint
	 *
	 * @return mixed
	 */
	public function get_endpoint() {
		return self::$endpoint;
	}

	/**
	 * Get the upload slug
	 *
	 * @return string|void
	 */
	public function get_upload_slug() {
		return home_url( '/' . self::$endpoint['upload']['slug'] );
	}

	/**
	 * Add new account endpoint
	 *
	 * @param $endpoint
	 *
	 * @return array
	 */
	public function account_page_endpoint( $endpoint ) {
		if ( isset( self::$endpoint['my_video'] ) ) {
			$item['my_video'] = self::$endpoint['my_video'];
			$endpoint         = array_merge( $endpoint, $item );
		}

		return $endpoint;
	}

	/**
	 * Return page check
	 *
	 * @return bool
	 */
	public function is_edit_page() {
		return $this->edit_page;
	}

	/**
	 * Register upload template page
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function page_template( $template ) {
		global $wp;
		$file = '';
		if ( is_user_logged_in() ) {
			$uploader = self::$endpoint['upload']['slug'];
			if ( isset( $wp->query_vars[ $uploader ] ) ) {
				add_action( 'wp_print_styles', array( $this, 'load_assets' ) );
				add_filter( 'document_title_parts', array( $this, 'account_title' ) );
				add_filter(
					'jnews_upload_preview_size',
					function () {
						return 'jnews-360x180';
					}
				);

				if ( current_user_can( 'upload_files' ) ) {
					add_action(
						'wp_enqueue_scripts',
						function () {
							wp_enqueue_media();
						}
					);
				}

				if ( ! empty( $wp->query_vars['upload'] ) ) {
					if ( $this->is_user_can_edit_post( $wp->query_vars['upload'] ) ) {
						$file            = JNEWS_VIDEO_TEMPLATE . '/frontend-submit/upload-video.php';
						$this->edit_page = true;
					}
					$this->page_title = esc_html__( 'Edit Video', 'jnews-video' );
				} else {
					if ( $this->is_user_allow_access() ) {
						$file             = JNEWS_VIDEO_TEMPLATE . '/frontend-submit/upload-video.php';
						$this->page_title = esc_html__( 'Upload ', 'jnews-video' );
					}
				}

				if ( ! empty( $file ) && file_exists( $file ) ) {
					$template = $file;
				}
			}
		}

		return $template;
	}


	/**
	 * Add new account template page
	 */
	public function get_right_content() {
		global $wp;

		if ( is_user_logged_in() ) {
			$endpoint     = AccountPage::getInstance()->get_endpoint();
			$account_slug = $endpoint['account']['slug'];
			if ( isset( $wp->query_vars[ $account_slug ] ) && ! empty( $wp->query_vars[ $account_slug ] ) ) {
				foreach ( self::$endpoint as $key => $value ) {
					$query_vars = explode( '/', $wp->query_vars['account'] );

					if ( $query_vars[0] === $value['slug'] ) {
						$paged = 1;

						if ( isset( $query_vars[2] ) ) {
							$paged = (int) $query_vars[2];
						}

						$template = JNEWS_VIDEO_TEMPLATE . 'frontend-submit/list-video.php';

						if ( file_exists( $template ) ) {
							include $template;
						}
					}
				}
			}
		}
	}

	/**
	 * Add upload button to account nav
	 */
	public function after_account_nav() {
		if ( $this->is_user_allow_access() ) {
			$button =
				'<div class="frontend-submit-button">
                    <a class="button" href="' . home_url( '/' . self::$endpoint['upload']['slug'] ) . '"><i class="fa fa-file-text-o"></i> ' . esc_html__( 'Upload Video', 'jnews-video' ) . '</a>
                </div>';

			echo jnews_sanitize_output( $button );
		}
	}

	/**
	 * Load new page asset
	 */
	public function load_assets() {
		$asset_url = apply_filters( 'jnews_get_asset_uri', get_parent_theme_file_uri( 'assets/' ) );

		wp_enqueue_style( 'jnews-frontend-submit', JNEWS_FRONTEND_SUBMIT_URL . '/assets/css/plugin.css', null, JNEWS_FRONTEND_SUBMIT_VERSION );
		wp_enqueue_style( 'selectize', $asset_url . 'css/admin/selectize.default.css', null, JNEWS_FRONTEND_SUBMIT_VERSION );

		wp_enqueue_script( 'selectize', $asset_url . 'js/vendor/selectize.js', array( 'jquery' ), JNEWS_FRONTEND_SUBMIT_VERSION, true );
		wp_enqueue_script( 'jnews-frontend-submit', JNEWS_FRONTEND_SUBMIT_URL . '/assets/js/plugin.js', null, JNEWS_FRONTEND_SUBMIT_VERSION, true );
		wp_enqueue_style( 'jnews-video-frontend-submit', JNEWS_VIDEO_URL . '/assets/css/frontend-submit.css', null, JNEWS_VIDEO_VERSION );
		wp_enqueue_script( 'jnews-video-frontend-submit', JNEWS_VIDEO_URL . '/assets/js/frontend-submit.js', null, JNEWS_VIDEO_VERSION, true );
	}

}
