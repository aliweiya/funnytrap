<?php

namespace JNEWS_VIDEO\Single;

/**
 * Class Single_Post_Video
 *
 * @package JNEWS_VIDEO\Single
 */
class Single_Post_Video {

	/**
	 * @var Single_Post_Video
	 */
	private static $instance;

	/**
	 * @var int
	 */
	private static $post_id;

	/**
	 * @var array
	 */
	private static $post_types = array( 'post' );

	private function __construct() {
		self::$post_id = get_the_ID();
		$this->hook();
	}

	private function hook() {
		add_filter( 'body_class', array( $this, 'add_body_class' ) );

		add_filter( 'template_include', array( $this, 'video_template' ) );
		add_filter( 'jnews_single_post_template', array( $this, 'get_template' ), 9 );
		add_filter( 'jnews_single_post_fullscreen', array( $this, 'get_fullscreen_mode' ), 9 );

		add_filter( 'jnews_single_post_layout', array( $this, 'get_layout' ), 9 );
		add_filter( 'jnews_single_post_sidebar', array( $this, 'get_sidebar' ), 9 );
		add_filter( 'jnews_single_post_second_sidebar', array( $this, 'get_second_sidebar' ), 9 );
		add_filter( 'jnews_single_post_sticky_sidebar', array( $this, 'sticky_sidebar' ), 9 );

		add_filter( 'theme_mod_jnews_single_show_featured', array( $this, 'render_featured_post' ), 9 );

		add_filter( 'option_jnews_option', array( $this, 'single_video_show_like' ) );
		add_filter( 'jnews_single_show_post_meta', array( $this, 'show_post_meta' ), 9 );
		add_filter( 'jnews_single_show_post_author', array( $this, 'show_author_meta' ), 9 );
		add_filter( 'jnews_single_show_post_author_image', array( $this, 'show_author_meta_image' ), 9 );
		add_filter( 'jnews_single_show_post_date', array( $this, 'show_date_meta' ), 9 );
		add_filter( 'jnews_single_post_date_format_custom', array( $this, 'get_date_format' ), 9 );
		add_filter( 'jnews_single_show_category', array( $this, 'show_category_meta' ), 9 );
		add_filter( 'jnews_single_comment', array( $this, 'show_comment_meta' ), 9 );
		add_filter( 'jnews_single_show_reading_time', array( $this, 'show_reading_time_meta' ), 9 );
		add_filter( 'jnews_single_show_zoom_button', array( $this, 'show_zoom_button_meta' ), 9 );
		add_filter( 'theme_mod_jnews_single_zoom_button_out_step', array( $this, 'zoom_out_step' ), 9 );
		add_filter( 'theme_mod_jnews_single_zoom_button_in_step', array( $this, 'zoom_in_step' ), 9 );
		add_filter( 'theme_mod_jnews_single_reading_time_wpm', array( $this, 'reading_time_meta' ), 9 );
		add_filter( 'theme_mod_jnews_single_show_tag', array( $this, 'post_tag_render' ), 9 );

		add_filter( 'jnews_single_show_prev_next_post', array( $this, 'prev_next_post' ), 9 );
		add_filter( 'jnews_single_show_popup_post', array( $this, 'popup_post' ), 9 );
		add_filter( 'theme_mod_jnews_single_number_popup_post', array( $this, 'number_popup_post' ), 9 );
		add_filter( 'jnews_single_show_author_box', array( $this, 'author_box' ), 9 );
		add_filter(
			'theme_mod_jnews_single_show_reading_progress_bar_position',
			array(
				$this,
				'reading_progress_bar_position',
			),
			9
		);
		add_filter( 'theme_mod_jnews_single_show_reading_progress_bar', array( $this, 'reading_progress_bar' ), 9 );
		add_filter( 'theme_mod_jnews_single_post_thumbnail_size', array( $this, 'get_single_thumbnail_size' ), 9 );

		add_filter( 'theme_mod_jnews_mobile_truncate', array( $this, 'avoid_truncate_conflict' ), 9 );
		add_filter( 'jnews_content_class', array( $this, 'add_class_content_truncate' ), null, 2 );
		add_filter( 'the_content', array( $this, 'add_truncate_show_more' ), 999 );

		add_action( 'jnews_source_via_single_post', array( $this, 'render_category_article' ) );
	}

	/**
	 * Singleton page of Single_Post_Video class
	 *
	 * @return Single_Post_Video
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * @return mixed|void
	 */
	public function show_view_tag() {
		$flag = get_theme_mod( 'jnews_single_video_show_view_counter', true );

		return apply_filters( 'jnews_single_video_show_view_counter', $flag, self::$post_id );
	}

	/**
	 * load asset single video
	 */
	public function load_asset() {
		if ( self::is_video_template() ) {
			wp_enqueue_style( 'jnews-video-single-video', JNEWS_VIDEO_URL . '/assets/css/single-video.css', null, JNEWS_VIDEO_VERSION );
		}
	}

	/**
	 * Check if video template
	 *
	 * @return bool
	 */
	public static function is_video_template() {
		if ( jnews_video_single_override() && is_singular( self::$post_types ) && ! vp_metabox( 'jnews_single_post.override_template', null, self::$post_id ) && get_post_format() === 'video' && ! defined( 'JNEWS_AUTOLOAD_POST' ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Avoid truncate conflict with default truncate
	 *
	 * @param $flag
	 *
	 * @return bool
	 */
	public function avoid_truncate_conflict( $flag ) {
		if ( self::enable_content_truncate() ) {
			return false;
		}

		return $flag;
	}

	/**
	 * @return bool|mixed
	 */
	private static function enable_content_truncate() {
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			return false;
		}
		if ( self::is_video_template() ) {
			return get_theme_mod( 'jnews_single_video_truncate', false );
		}

		return false;
	}

	/**
	 * @param $value
	 * @param $id
	 *
	 * @return string
	 */
	public function add_class_content_truncate( $value, $id ) {
		if ( self::enable_content_truncate() ) {
			return $value . ' content-truncate mobile-truncate';
		}

		return $value;
	}

	/**
	 * @param $content
	 *
	 * @return string
	 */
	public function add_truncate_show_more( $content ) {
		if ( self::enable_content_truncate() ) {
			$truncate = "<button type='button' class='truncate-read-more'><span>" . jnews_return_translation( 'Show More', 'jnews-video', 'show_more' ) . "</span><i class='fa fa-angle-down'></i></button>";

			return $content . $truncate;
		}

		return $content;
	}

	/**
	 * @param $value
	 *
	 * @return mixed
	 */
	public function single_video_show_like( $value ) {
		$single_show_like = get_theme_mod( 'jnews_single_video_show_like', 'both' );
		if ( isset( $value['single_show_like'] ) ) {
			$value['single_show_like'] = $single_show_like;
		}

		return $value;
	}

	/**
	 * @return mixed|void
	 */
	public function show_subscribe_counter() {
		$flag = get_theme_mod( 'jnews_single_video_show_subscribe_counter', true );

		return apply_filters( 'jnews_single_video_show_subscribe_counter', $flag, self::$post_id );
	}

	/**
	 * @param $classes
	 *
	 * @return array
	 */
	public function add_body_class( $classes ) {
		if ( self::is_video_template() ) {
			$template = $this->get_template();

			switch ( $template ) {
				case 'video-1':
					$classes[] = 'jeg_single_tpl_video_1';
					break;
				case 'video-2':
					$classes[] = 'jeg_single_tpl_video_2';
					break;
				default:
					break;
			}
		}

		return $classes;
	}

	/**
	 * @param null $template
	 *
	 * @return mixed|void
	 */
	public function get_template( $template = null ) {
		if ( self::is_video_template() ) {
			$template = get_theme_mod( 'jnews_single_video_template', 'video-1' );
		}

		return apply_filters( 'jnews_single_video_post_template', $template, self::$post_id );
	}

	/**
	 * @param $template
	 *
	 * @return string
	 */
	public function video_template( $template ) {
		if ( self::is_video_template() ) {
			$template = JNEWS_VIDEO_TEMPLATE . 'single/single.php';
		}

		return $template;
	}

	/**
	 * @param null $layout
	 *
	 * @return mixed|void
	 */
	public function get_layout( $layout = null ) {
		if ( self::is_video_template() ) {
			$layout = get_theme_mod( 'jnews_single_video_layout', 'right-sidebar' );
		}

		return apply_filters( 'jnews_single_video_post_layout', $layout, self::$post_id );
	}

	/**
	 * @param null $sidebar
	 *
	 * @return mixed|void
	 */
	public function get_sidebar( $sidebar = null ) {
		if ( self::is_video_template() ) {
			$sidebar = get_theme_mod( 'jnews_single_video_sidebar', 'default-sidebar' );
		}

		return apply_filters( 'jnews_single_video_post_sidebar', $sidebar, self::$post_id );
	}

	/**
	 * @param null $sidebar
	 *
	 * @return mixed|void
	 */
	public function get_second_sidebar( $sidebar = null ) {
		if ( self::is_video_template() ) {
			$sidebar = get_theme_mod( 'jnews_single_video_second_sidebar', 'default-sidebar' );
		}

		return apply_filters( 'jnews_single_video_post_second_sidebar', $sidebar, self::$post_id );
	}

	/**
	 * @param null $sticky_sidebar
	 *
	 * @return mixed|void
	 */
	public function sticky_sidebar( $sticky_sidebar = null ) {
		if ( self::is_video_template() ) {
			$sticky_sidebar = get_theme_mod( 'jnews_single_video_sticky_sidebar', true );
		}

		return apply_filters( 'jnews_single_video_post_sticky_sidebar', $sticky_sidebar, self::$post_id );
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function render_featured_post( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_show_featured', true );
		}

		return apply_filters( 'jnews_single_video_render_featured_post', $flag, self::$post_id );
	}

	/**
	 * @param null $enable
	 *
	 * @return mixed|void
	 */
	public function get_fullscreen_mode( $enable = null ) {
		if ( self::is_video_template() ) {
			switch ( $this->get_template() ) {
				case 'video-1':
					$enable = false;
					break;
				case 'video-2':
					$enable = true;
					break;
				default:
					break;
			}
		}

		return apply_filters( 'jnews_single_video_post_fullscreen', $enable, self::$post_id );
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function show_post_meta( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_show_post_meta', true );
		}

		return apply_filters( 'jnews_single_video_show_post_meta', $flag, self::$post_id );
	}

	/**
	 * @return mixed|void
	 */
	public function show_post_meta_header() {
		$flag = get_theme_mod( 'jnews_single_video_show_post_meta_header', true );

		return apply_filters( 'jnews_single_video_show_post_meta_header', $flag, self::$post_id );
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function show_author_meta( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_show_post_author', true );
		}

		return apply_filters( 'jnews_single_video_show_post_author', $flag, self::$post_id );
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function show_author_meta_image( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_show_post_author_image', true );
		}

		return apply_filters( 'jnews_single_video_show_post_author_image', $flag, self::$post_id );
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function show_date_meta( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_show_post_date', true );
		}

		return apply_filters( 'jnews_single_video_show_post_date', $flag, self::$post_id );
	}

	/**
	 * @param null $format
	 *
	 * @return mixed|void
	 */
	public function get_date_format( $format = null ) {
		if ( self::is_video_template() ) {
			$format = get_theme_mod( 'jnews_single_video_post_date_format', 'ago' );

			if ( 'custom' === $format ) {
				$format = get_theme_mod( 'jnews_single_video_post_date_format_custom', 'Y/m/d' );
			}
		}

		return apply_filters( 'jnews_single_video_show_post_date', $format, self::$post_id );
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function show_comment_meta( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_comment', true );
		}

		return apply_filters( 'jnews_single_video_comment', $flag, self::$post_id );
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function show_reading_time_meta( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_reading_time', false );
		}

		return apply_filters( 'jnews_single_video_show_reading_time', $flag, self::$post_id );
	}

	/**
	 * @return mixed|void
	 */
	public function show_subscribe_button() {
		$flag = get_theme_mod( 'jnews_single_video_subscribe_button', true );

		return apply_filters( 'jnews_single_video_subscribe_button', $flag, self::$post_id );
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function show_zoom_button_meta( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_zoom_button', false );
		}

		return apply_filters( 'jnews_single_video_zoom_button', $flag, self::$post_id );
	}

	/**
	 * @param null $value
	 *
	 * @return mixed|null
	 */
	public function zoom_in_step( $value = null ) {
		if ( self::is_video_template() ) {
			$value = get_theme_mod( 'jnews_single_video_zoom_button_in_step', 3 );
		}

		return $value;
	}

	/**
	 * @param null $value
	 *
	 * @return mixed|null
	 */
	public function zoom_out_step( $value = null ) {
		if ( self::is_video_template() ) {
			$value = get_theme_mod( 'jnews_single_video_zoom_button_out_step', 2 );
		}

		return $value;
	}

	/**
	 * @param null $value
	 *
	 * @return mixed|null
	 */
	public function reading_time_meta( $value = null ) {
		if ( self::is_video_template() ) {
			$value = get_theme_mod( 'jnews_single_video_reading_time_wpm', '300' );
		}

		return $value;
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|null
	 */
	public function post_tag_render( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_show_tag', true );
		}

		return $flag;
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function prev_next_post( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_show_prev_next_post', false );
		}

		return apply_filters( 'jnews_single_video_show_prev_next_post', $flag, self::$post_id );
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function popup_post( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_show_popup_post', true );
		}

		return apply_filters( 'jnews_single_video_show_popup_post', $flag, self::$post_id );
	}

	/**
	 * @param null $value
	 *
	 * @return mixed|null
	 */
	public function number_popup_post( $value = null ) {
		if ( self::is_video_template() ) {
			$value = get_theme_mod( 'jnews_single_video_number_popup_post', 1 );
		}

		return $value;
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function author_box( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_show_author_box', false );
		}

		return apply_filters( 'jnews_single_video_show_author_box', $flag, self::$post_id );
	}

	/**
	 * @param null $value
	 *
	 * @return mixed|null
	 */
	public function reading_progress_bar( $value = null ) {
		if ( self::is_video_template() ) {
			$value = get_theme_mod( 'jnews_single_video_show_reading_progress_bar', false );
		}

		return $value;
	}

	/**
	 * @param null $value
	 *
	 * @return mixed|null
	 */
	public function reading_progress_bar_position( $value = null ) {
		if ( self::is_video_template() ) {
			$value = get_theme_mod( 'jnews_single_video_show_reading_progress_bar_position', 'bottom' );
		}

		return $value;
	}

	/**
	 * @param null $value
	 *
	 * @return mixed|null
	 */
	public function get_single_thumbnail_size( $value = null ) {
		if ( self::is_video_template() && ! self::image_size_override() ) {
			$value = get_theme_mod( 'jnews_single_video_post_thumbnail_size', 'crop-500' );
		}

		return $value;
	}

	/**
	 * @return bool
	 */
	private static function image_size_override() {
		if ( vp_metabox( 'jnews_single_post.override_image_size', null, self::$post_id ) ) {
			return true;
		}

		return false;
	}

	/**
	 * render category article
	 */
	public function render_category_article() {
		if ( self::is_video_template() && $this->show_category_meta() ) {
			echo '<div class="jeg_post_category">
					<span class="meta_text">' . jnews_return_translation( 'Category:', 'jnews-video', 'category_text' ) . '</span>
					' . get_the_category_list( ' ' ) . '
            	</div>';
		}
	}

	/**
	 * @param null $flag
	 *
	 * @return mixed|void
	 */
	public function show_category_meta( $flag = null ) {
		if ( self::is_video_template() ) {
			$flag = get_theme_mod( 'jnews_single_video_show_category', true );
		}

		return apply_filters( 'jnews_single_video_show_category', $flag, self::$post_id );
	}


}
