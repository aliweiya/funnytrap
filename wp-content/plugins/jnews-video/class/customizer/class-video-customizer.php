<?php
/**
 * @author Jegtheme
 */

namespace JNEWS_VIDEO\Customizer;

/**
 * Class Video_Customizer
 *
 * @package JNEWS_VIDEO\Customizer
 */
class Video_Customizer {

	/**
	 * Instance of Video_Customizer
	 *
	 * @var Video_Customizer
	 */
	private static $instance;

	/**
	 * @var \Jeg\Customizer\Customizer
	 */
	private $customizer;

	/**
	 * Video_Customizer constructor.
	 */
	private function __construct() {
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_control_css' ) );
		add_action( 'jeg_register_customizer_option', array( $this, 'customizer_option' ) );
		add_filter( 'jeg_register_lazy_section', array( $this, 'jnews_video_lazy_section' ), 99 );
		add_filter( 'jnews_setup_redirect_tag', array( $this, 'setup_redirect_tag' ) );
	}

	/**
	 * Singleton page for Video_Customizer class
	 *
	 * @return Video_Customizer
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Load additional customizer style
	 */
	public function customize_control_css() {
		wp_enqueue_style( 'jnews-video-additional-customizer', JNEWS_VIDEO_URL . '/assets/css/admin/additional-customizer.css' );
	}

	/**
	 * Setup redirect tag for customizer
	 *
	 * @param $redirect_tag
	 *
	 * @return mixed
	 */
	public function setup_redirect_tag( $redirect_tag ) {

		if ( jnews_is_bp_active() && function_exists( 'bp_is_user' ) ) {
			$redirect_tag['buddypress_member'] = array(
				'url'  => home_url( '/members/me/' ),
				'flag' => bp_is_user(),
				'text' => esc_html__( 'BuddyPress Member', 'jnews-video' ),
			);
			$redirect_tag['buddypress']        = array(
				'url'  => home_url( '/members/' ),
				'flag' => jnews_is_bp_directory_or_single(),
				'text' => esc_html__( 'BuddyPresss', 'jnews-video' ),
			);
		}

		$redirect_tag['single_post_video_tag'] = array(
			'url'  => $this->get_random_url(
				array(
					'meta_query' => array(
						array(
							'key'     => 'jnews_single_post',
							'value'   => sprintf( ':"%s";', 'video' ),
							'compare' => 'LIKE',
						),
					),
				)
			),
			'flag' => $this->is_single( 'video' ),
			'text' => esc_html__( 'Single Post Video', 'jnews-video' ),
		);

		$redirect_tag['history_tag'] = array(
			'url'  => home_url( '/history/' ),
			'flag' => $this->is_single( 'video' ),
			'text' => esc_html__( 'Single Post Video', 'jnews-video' ),
		);

		$redirect_tag['single_playlist_tag'] = array(
			'url'  => $this->get_random_url(
				array(
					'post_type' => 'playlist',
				)
			),
			'flag' => $this->is_single( 'playlist' ),
			'text' => esc_html__( 'Single Playlist', 'jnews-video' ),
		);

		return $redirect_tag;
	}

	/**
	 * Get random URL of post_type
	 *
	 * @param $args
	 *
	 * @return false|string|null
	 */
	public function get_random_url( $args ) {
		$defaults = array(
			'orderby'     => 'rand',
			'numberposts' => 1,
		);
		$args     = wp_parse_args( $args, $defaults );

		$posts = get_posts( $args );

		if ( $posts ) {
			return get_permalink( $posts[0]->ID );
		} else {
			return null;
		}
	}

	/**
	 * Check if the right single page
	 *
	 * @param $type
	 *
	 * @return bool
	 */
	public function is_single( $type ) {
		switch ( $type ) {
			case 'video':
				$result = ( is_single() && has_post_format( 'video' ) );
				break;
			case 'playlist':
				$result = ( is_singular( 'playlist' ) );
				break;
			default:
				$result = false;
				break;
		}

		return $result;
	}

	/**
	 * Register new customizer option
	 */
	public function customizer_option() {
		if ( class_exists( '\Jeg\Customizer\Customizer' ) ) {
			$this->customizer = \Jeg\Customizer\Customizer::get_instance();

			$this->set_panel();
			$this->set_section();
		}
	}

	/**
	 * Set new panel customizer
	 */
	public function set_panel() {
		$this->customizer->add_panel(
			array(
				'id'          => 'jnews_video',
				'title'       => esc_html__( 'JNews : Video Setting', 'jnews-video' ),
				'description' => esc_html__( 'JNews video setting.', 'jnews-video' ),
				'priority'    => 192,
			)
		);
	}

	/**
	 * Set new section panel
	 */
	public function set_section() {
		$this->customizer->add_section(
			array(
				'id'       => 'jnews_video_buddypress',
				'title'    => esc_html__( 'BuddyPress Setting', 'jnews-video' ),
				'panel'    => 'jnews_video',
				'priority' => 250,
				'type'     => 'jnews-lazy-section',
			)
		);

		$this->customizer->add_section(
			array(
				'id'       => 'jnews_video_single_post',
				'title'    => esc_html__( 'Single Post Video Setting', 'jnews-video' ),
				'panel'    => 'jnews_video',
				'priority' => 250,
				'type'     => 'jnews-lazy-section',
			)
		);

		$this->customizer->add_section(
			array(
				'id'       => 'jnews_video_single_playlist',
				'title'    => esc_html__( 'Single Playlist Setting', 'jnews-video' ),
				'panel'    => 'jnews_video',
				'priority' => 250,
				'type'     => 'jnews-lazy-section',
			)
		);

		$this->customizer->add_section(
			array(
				'id'       => 'jnews_video_single_playlist',
				'title'    => esc_html__( 'Single Playlist Setting', 'jnews-video' ),
				'panel'    => 'jnews_video',
				'priority' => 250,
				'type'     => 'jnews-lazy-section',
			)
		);

		$this->customizer->add_section(
			array(
				'id'       => 'jnews_video_archive_history',
				'title'    => esc_html__( 'History Template Setting', 'jnews-video' ),
				'panel'    => 'jnews_video',
				'priority' => 250,
				'type'     => 'jnews-lazy-section',
			)
		);
	}

	/**
	 * Register new section and their respective file
	 *
	 * @param $result
	 *
	 * @return mixed
	 */
	public function jnews_video_lazy_section( $result ) {
		$result['jnews_video_buddypress'][]      = JNEWS_VIDEO_DIR . 'class/customizer/sections/buddypress-option.php';
		$result['jnews_search_option_section'][] = JNEWS_VIDEO_DIR . 'class/customizer/sections/search-option.php';
		$result['jnews_video_single_post'][]     = JNEWS_VIDEO_DIR . 'class/customizer/sections/single-post-video-option.php';
		$result['jnews_video_single_playlist'][] = JNEWS_VIDEO_DIR . 'class/customizer/sections/single-playlist-option.php';
		$result['jnews_video_archive_history'][] = JNEWS_VIDEO_DIR . 'class/customizer/sections/archive-history-option.php';

		return $result;
	}
}
