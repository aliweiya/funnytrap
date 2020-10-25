<?php
/**
 * @author Jegtheme
 */

namespace JNEWS_VIDEO;

use JNEWS_VIDEO\BuddyPress\BuddyPress;
use JNEWS_VIDEO\Category\Video_Category;
use JNEWS_VIDEO\Customizer\Video_Customizer;
use JNEWS_VIDEO\Frontend\Frontend_Video;
use JNEWS_VIDEO\Frontend\Frontend_Video_Endpoint;
use JNEWS_VIDEO\Module\Video_Module;
use JNEWS_VIDEO\Objects\History;
use JNEWS_VIDEO\Objects\Playlist;
use JNEWS_VIDEO\Single\Single_Post_Video;

/**
 * Class Init
 *
 * @package JNEWS_VIDEO
 */
class Init {

	/**
	 * Instance of Init
	 *
	 * @var Init
	 */
	private static $instance;

	/**
	 * Init constructor.
	 */
	private function __construct() {
		$this->load_helper();
		$this->setup_init();
		$this->setup_hook();
	}

	/**
	 * Load helper file
	 */
	public function load_helper() {
		require_once JNEWS_VIDEO_DIR . 'class/helper.php';
	}

	/**
	 * Setup Init
	 */
	public function setup_init() {
		Video_Customizer::get_instance();
		Video_Category::get_instance();
		Video_Module::get_instance();
		BuddyPress::get_instance();
		Playlist::get_instance();
		History::get_instance();
		Single_Post_Video::get_instance();
		if ( class_exists( 'JNews_Frontend_Submit' ) ) {
			Frontend_Video::getInstance();
		}

		jnews_video_activation_hook( JNEWS_VIDEO_FILE );
		$this->header_button_login();
	}

	/**
	 * Add login required class
	 */
	public function header_button_login() {
		for ( $i = 1; $i <= 3; $i ++ ) {
			add_filter( 'jnews_header_button_' . $i . '_class', 'jnews_video_custom_header_button', 10, 2 );
		}
	}

	/**
	 * Setup Init hook
	 */
	public function setup_hook() {

		// load script & style editor.
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_style' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'editor_style' ), 99 );
		add_action( 'admin_enqueue_scripts', array( $this, 'editor_script' ), 100 );

		add_action( 'after_setup_theme', array( $this, 'blog_metabox' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_asset' ) );

		// Search.
		add_filter( 'jnews_live_search_args', array( $this, 'search_only_video' ) );
		add_filter( 'pre_get_posts', array( $this, 'search_filter' ) );

		// ajax filter.
		add_action( 'jnews_ajax_get_video_menu', array( $this, 'get_video_menu' ) );

		// menu.
		add_filter( 'jnews_dropdown_link', array( $this, 'dropdown_link' ) );

		// support webp.
		add_filter( 'upload_mimes', array( $this, 'filter_mimes_type' ) );

		// force login form.
		add_filter( 'jnews_can_render_account_popup', '__return_true' );

		// add video module option in normal option, block option.
		add_filter( 'jnews_custom_option', array( $this, 'custom_option' ) );
		add_filter( 'jnews_custom_block_option', array( $this, 'custom_block_option' ) );
		add_filter( 'jnews_custom_customizer_option', array( $this, 'custom_customizer_option' ), 10, 3 );
		add_filter( 'jnews_get_content_attr', array( $this, 'custom_content_attr' ), 10, 3 );
	}

	/**
	 * Activation plugin hook
	 */
	public static function activation_hook() {
		History::plugin_activation();
		Playlist::plugin_activation();
		if ( class_exists( 'JNews_Frontend_Submit' ) ) {
			Frontend_Video_Endpoint::getInstance();
		}
	}

	/**
	 * Singleton page of Init class
	 *
	 * @return Init
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Enable webp mimes type
	 *
	 * @param $mime_types
	 *
	 * @return mixed
	 */
	public function filter_mimes_type( $mime_types ) {
		$mime_types['webp'] = 'image/webp';

		return $mime_types;
	}

	/**
	 * Add more dropdown link
	 *
	 * @param $dropdown
	 *
	 * @return array
	 */
	public function dropdown_link( $dropdown ) {
		$video_dropdown = array();

		$video_dropdown['my_channel'] = array(
			'text' => jnews_return_translation( 'My Channel', 'jnews-video', 'my_channel' ),
			'url'  => jnews_is_bp_active() ? esc_url( bp_core_get_user_domain( get_current_user_id() ) ) : esc_url( get_author_posts_url( get_the_author_meta( 'ID', get_current_user_id() ) ) ),
		);

		$video_dropdown['video_favorite'] = array(
			'text' => jnews_return_translation( 'Favorite Video', 'jnews-video', 'video_favorite' ),
			'url'  => esc_url( home_url( Playlist::FAVORITE ) ),
		);

		$video_dropdown['video_watch_later'] = array(
			'text' => jnews_return_translation( 'Watch Later', 'jnews-video', 'video_watch_later' ),
			'url'  => esc_url( home_url( Playlist::WATCH_LATER ) ),
		);

		$video_dropdown['video_watch_history'] = array(
			'text' => jnews_return_translation( 'Watch History', 'jnews-video', 'video_watch_history' ),
			'url'  => esc_url( home_url( History::get_instance()->get_slug( 'history' ) ) ),
		);

		return array_merge( $video_dropdown, $dropdown );
	}

	/**
	 * Ajax get video menu
	 */
	public function get_video_menu() {
		if ( isset( $_REQUEST['post_id'] ) ) {
			if ( is_user_logged_in() ) {
				wp_send_json_success(
					jnews_video_menu_detail( $_REQUEST['post_id'] )
				);
			} else {
				wp_send_json_error(
					array(
						'response' => 0,
						'message'  => jnews_return_translation( 'You must login to do this thing!', 'jnews-video', 'video_must_login' ),
					)
				);
			}
		}
		wp_send_json_error();
	}

	/**
	 * Search filter query
	 *
	 * @param $query
	 *
	 * @return mixed
	 */
	public function search_filter( $query ) {
		if ( is_search() && ! is_admin() ) {
			if ( isset( $query->query['s'] ) && get_theme_mod( 'jnews_search_only_video', false ) ) {
				$query->set(
					'tax_query',
					array(
						array(
							'taxonomy' => 'post_format',
							'field'    => 'slug',
							'terms'    => array(
								'post-format-video',
							),
							'operator' => 'IN',
						),
					)
				);
			}
		}

		return $query;
	}

	/**
	 * Add video search only
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	public function search_only_video( $args ) {
		if ( get_theme_mod( 'jnews_search_only_video', false ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'post_format',
					'field'    => 'slug',
					'terms'    => array(
						'post-format-video',
					),
					'operator' => 'IN',
				),
			);
		}

		return $args;
	}

	/**
	 * Load Init asset
	 */
	public function load_asset() {
		if ( ! is_admin() ) {
			wp_enqueue_style( 'jnews-video', JNEWS_VIDEO_URL . '/assets/css/plugin.css', null, JNEWS_VIDEO_VERSION );
			Single_Post_Video::get_instance()->load_asset();
			wp_enqueue_style( 'jnews-video-darkmode', JNEWS_VIDEO_URL . '/assets/css/darkmode.css', null, JNEWS_VIDEO_VERSION );

			wp_enqueue_script( 'supposition', JNEWS_VIDEO_URL . '/assets/js/supposition.js', null, JNEWS_VIDEO_VERSION, true );
			wp_enqueue_script(
				'jnews-video',
				JNEWS_VIDEO_URL . '/assets/js/plugin.js',
				array(
					'jquery',
					'jquery-ui-core',
					'jquery-ui-sortable',
				),
				JNEWS_VIDEO_VERSION,
				true
			);
			if ( is_user_logged_in() && is_singular( 'playlist' ) ) {
				wp_enqueue_media();
			}
			wp_localize_script( 'jnews-video', 'jnewsvideo', $this->localize_script() );
		}
	}

	/**
	 * @return mixed|void
	 */
	public function localize_script() {
		$option = array();

		return apply_filters( 'jnews_video_asset_localize_script', $option );
	}

	/**
	 * Load editor style
	 */
	public function editor_style() {
		wp_enqueue_style( 'jnews-video-admin', JNEWS_VIDEO_URL . '/assets/css/admin/admin-style.css', null, JNEWS_VIDEO_VERSION );
		wp_enqueue_style( 'jnews-video-elementor-css', JNEWS_VIDEO_URL . '/assets/css/admin/elementor-backend.css', null, JNEWS_VIDEO_VERSION );
	}

	/**
	 * Load editor script
	 */
	public function editor_script() {
		wp_enqueue_script( 'jnews-video-admin', JNEWS_VIDEO_URL . '/assets/js/admin/jnews-video.admin.js', array( 'jquery' ), JNEWS_VIDEO_VERSION, true );
	}

	/**
	 * Add video option metabox
	 */
	public function blog_metabox() {
		if ( class_exists( 'VP_Metabox' ) ) {
			new \VP_Metabox( JNEWS_VIDEO_DIR . 'class/metabox/post-single-video.php' );
		}
	}

	/**
	 * Custom module content attribute
	 *
	 * @param $attr
	 * @param $prefix
	 * @param $id
	 *
	 * @return array
	 */
	public function custom_content_attr( $attr, $prefix, $id ) {

		$new_attr = array();
		$suffix   = $id ? $id : '';
		$id       = ! empty( $suffix ) ? str_replace( '_', '', $suffix ) : 0;
		$override = false;

		if ( is_category() ) {
			$override = apply_filters( $prefix . 'override', false, $id );
		}

		if ( $id > 0 && $override ) {
			$new_attr['video_duration']  = apply_filters( $prefix . 'video_duration' . $suffix, get_theme_mod( $prefix . 'video_duration' . $suffix, true ), $id );
			$new_attr['post_meta_style'] = apply_filters( $prefix . 'post_meta_style' . $suffix, get_theme_mod( $prefix . 'post_meta_style' . $suffix, 'style_2' ), $id );
			$new_attr['author_avatar']   = apply_filters( $prefix . 'author_avatar' . $suffix, get_theme_mod( $prefix . 'author_avatar' . $suffix, true ), $id );
			$new_attr['more_menu']       = apply_filters( $prefix . 'more_menu' . $suffix, get_theme_mod( $prefix . 'more_menu' . $suffix, true ), $id );
		} else {
			$new_attr['video_duration']  = apply_filters( $prefix . 'video_duration' . $suffix, get_theme_mod( $prefix . 'video_duration', true ) );
			$new_attr['post_meta_style'] = apply_filters( $prefix . 'post_meta_style' . $suffix, get_theme_mod( $prefix . 'post_meta_style', 'style_2' ) );
			$new_attr['author_avatar']   = apply_filters( $prefix . 'author_avatar' . $suffix, get_theme_mod( $prefix . 'author_avatar', true ) );
			$new_attr['more_menu']       = apply_filters( $prefix . 'more_menu' . $suffix, get_theme_mod( $prefix . 'more_menu', true ) );
		}

		$attr = array_merge( $attr, $new_attr );

		return $attr;
	}

	/**
	 * Custom module customizer option
	 *
	 * @param $options
	 * @param $prefix
	 * @param $id
	 *
	 * @return array
	 */
	public function custom_customizer_option( $options, $prefix, $id ) {
		$new_options = array();
		$suffix      = $id ? $id : '';

		$new_options[] = array(
			'id'              => $prefix . 'video_duration' . $suffix,
			'transport'       => 'postMessage',
			'default'         => true,
			'type'            => 'jnews-toggle',
			'label'           => esc_html__( 'Show Time Duration', 'jnews-video' ),
			'description'     => esc_html__( 'Show time duration on your block', 'jnews-video' ),
			'active_callback' => array(
				array(
					'setting'  => $prefix . 'content' . $suffix,
					'operator' => 'in',
					'value'    => array( 'video_1', 'video_2', 'video_3', 'video_4' ),
				),
				array(
					'setting'  => $prefix . 'page_layout' . $suffix,
					'operator' => '!=',
					'value'    => 'custom-template',
				),
			),
		);
		$new_options[] = array(
			'id'              => $prefix . 'post_meta_style' . $suffix,
			'transport'       => 'postMessage',
			'default'         => 'style_2',
			'type'            => 'jnews-select',
			'label'           => esc_html__( 'Choose Post Meta Style', 'jnews-video' ),
			'description'     => esc_html__( 'Choose which post meta style that fit with your block.', 'jnews-video' ),
			'choices'         => array(
				'style_1' => esc_html__( 'Style 1', 'jnews-video' ),
				'style_2' => esc_html__( 'Style 2', 'jnews-video' ),
			),
			'active_callback' => array(
				array(
					'setting'  => $prefix . 'content' . $suffix,
					'operator' => 'in',
					'value'    => array( 'video_1', 'video_2', 'video_3', 'video_4' ),
				),
				array(
					'setting'  => $prefix . 'page_layout' . $suffix,
					'operator' => '!=',
					'value'    => 'custom-template',
				),
			),
		);
		$new_options[] = array(
			'id'              => $prefix . 'author_avatar' . $suffix,
			'transport'       => 'postMessage',
			'type'            => 'jnews-toggle',
			'label'           => esc_html__( 'Show Avatar', 'jnews-video' ),
			'description'     => esc_html__( 'Show avatar on the post meta. (Video Block)', 'jnews-video' ),
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => $prefix . 'content' . $suffix,
					'operator' => 'in',
					'value'    => array( 'video_1', 'video_2', 'video_3', 'video_4' ),
				),
				array(
					'setting'  => $prefix . 'page_layout' . $suffix,
					'operator' => '!=',
					'value'    => 'custom-template',
				),
				array(
					'setting'  => $prefix . 'post_meta_style' . $suffix,
					'operator' => '==',
					'value'    => 'style_1',
				),
			),
		);
		$new_options[] = array(
			'id'              => $prefix . 'more_menu' . $suffix,
			'transport'       => 'postMessage',
			'type'            => 'jnews-toggle',
			'label'           => esc_html__( 'Show More Menu', 'jnews-video' ),
			'description'     => esc_html__( 'Show more menu on block.', 'jnews-video' ),
			'default'         => true,
			'active_callback' => array(
				array(
					'setting'  => $prefix . 'content' . $suffix,
					'operator' => 'in',
					'value'    => array( 'video_1', 'video_2', 'video_3', 'video_4' ),
				),
				array(
					'setting'  => $prefix . 'page_layout' . $suffix,
					'operator' => '!=',
					'value'    => 'custom-template',
				),
			),
		);
		$options       = array_merge( $options, $new_options );

		return $options;
	}

	/**
	 * Custom block option
	 *
	 * @param $options
	 *
	 * @return array
	 */
	public function custom_block_option( $options ) {
		$new_options = array();

		$new_options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'video_duration',
			'heading'    => esc_html__( 'Show Time Duration', 'jnews-video' ),
			'value'      => array( esc_html__( 'Show time duration on your block', 'jnews-video' ) => 'yes' ),
			'std'        => 'yes',
			'dependency' => array(
				'element' => 'block_type',
				'value'   => array( 'video_1', 'video_2', 'video_3', 'video_4' ),
			),
		);
		$new_options[] = array(
			'type'        => 'dropdown',
			'param_name'  => 'post_meta_style',
			'heading'     => esc_html__( 'Choose Post Meta Style', 'jnews-video' ),
			'description' => esc_html__( 'Choose which post meta style that fit with your block.', 'jnews-video' ),
			'std'         => 'style_2',
			'value'       => array(
				esc_html__( 'Style 1', 'jnews-video' ) => 'style_1',
				esc_html__( 'Style 2', 'jnews-video' ) => 'style_2',
			),
			'dependency'  => array(
				'element' => 'block_type',
				'value'   => array( 'video_1', 'video_2', 'video_3', 'video_4' ),
			),
		);
		$new_options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'author_avatar',
			'heading'    => esc_html__( 'Show Avatar', 'jnews-video' ),
			'value'      => array( esc_html__( 'Show avatar on the post meta. (Video Block)', 'jnews-video' ) => 'yes' ),
			'std'        => 'yes',
			'dependency' => array(
				'element' => 'post_meta_style',
				'value'   => array( 'style_1' ),
			),
		);
		$new_options[] = array(
			'type'       => 'checkbox',
			'param_name' => 'more_menu',
			'heading'    => esc_html__( 'Show More Menu', 'jnews-video' ),
			'value'      => array( esc_html__( 'Show more menu on block.', 'jnews-video' ) => 'yes' ),
			'std'        => 'yes',
			'dependency' => array(
				'element' => 'block_type',
				'value'   => array( 'video_1', 'video_2', 'video_3', 'video_4' ),
			),
		);
		$options       = array_merge( $options, $new_options );

		return $options;
	}

	/**
	 * Custom module option
	 *
	 * @param $options
	 *
	 * @return array
	 */
	public function custom_option( $options ) {
		$new_options     = array();
		$option_override = $options['content_layout']['dependency'][0];
		$segment         = $options['content_layout']['segment'];

		$new_options['video_duration']  = array(
			'segment'    => $segment,
			'type'       => 'checkbox',
			'title'      => esc_html__( 'Show Time Duration', 'jnews-video' ),
			'desc'       => esc_html__( 'Show time duration on your block', 'jnews-video' ),
			'default'    => true,
			'dependency' => array(
				$option_override,
				array(
					'field'    => 'content_layout',
					'operator' => 'in',
					'value'    => array( 'video_1', 'video_2', 'video_3', 'video_4' ),
				),
			),
		);
		$new_options['post_meta_style'] = array(
			'segment'     => $segment,
			'type'        => 'select',
			'title'       => esc_html__( 'Choose Post Meta Style', 'jnews-video' ),
			'description' => esc_html__( 'Choose which post meta style that fit with your block.', 'jnews-video' ),
			'default'     => 'style_2',
			'options'     => array(
				'style_1' => esc_html__( 'Style 1', 'jnews-video' ),
				'style_2' => esc_html__( 'Style 2', 'jnews-video' ),
			),
			'dependency'  => array(
				$option_override,
				array(
					'field'    => 'content_layout',
					'operator' => 'in',
					'value'    => array( 'video_1', 'video_2', 'video_3', 'video_4' ),
				),
			),
		);
		$new_options['author_avatar']   = array(
			'segment'     => $segment,
			'type'        => 'checkbox',
			'title'       => esc_html__( 'Show Avatar', 'jnews-video' ),
			'description' => esc_html__( 'Show avatar on the post meta. (Video Block)', 'jnews-video' ),
			'default'     => true,
			'dependency'  => array(
				$option_override,
				array(
					'field'    => 'post_meta_style',
					'operator' => 'in',
					'value'    => array( 'style_1' ),
				),
			),
		);
		$new_options['more_menu']       = array(
			'segment'     => $segment,
			'type'        => 'checkbox',
			'title'       => esc_html__( 'Show More Menu', 'jnews-video' ),
			'description' => esc_html__( 'Show more menu on block.', 'jnews-video' ),
			'default'     => true,
			'dependency'  => array(
				$option_override,
				array(
					'field'    => 'content_layout',
					'operator' => 'in',
					'value'    => array( 'video_1', 'video_2', 'video_3', 'video_4' ),
				),
			),
		);

		$options = array_merge( $options, $new_options );

		return $options;
	}

}
