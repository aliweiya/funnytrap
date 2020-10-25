<?php
/**
 * @author : Jegtheme
 */

namespace JNEWS_VIDEO\History;

use JNews\Archive\ArchiveAbstract;
use JNews\Module\ModuleManager;
use JNEWS_VIDEO\Objects\History;

/**
 * Class History_Archive
 *
 * @package JNEWS_VIDEO\History
 */
class History_Archive extends ArchiveAbstract {
	/** @var array */
	private $result;

	/** @var string */
	private $tag = 'jnews_history_';

	/**
	 * History_Archive constructor.
	 */
	public function __construct() {

		$history      = History::get_instance();
		$post_ids     = $history->get_history_video( get_current_user_id() );
		$this->result = ! empty( $post_ids ) ? $post_ids : array();

		if ( $this->can_render_top_content() ) {
			add_filter( 'jnews_vc_force_load_style', '__return_true' );
		}
	}

	/**
	 * Check if can render top content
	 *
	 * @return bool
	 */
	public function can_render_top_content() {
		return get_theme_mod( $this->tag . 'top_content' ) && jnews_get_post_current_page() === 1;
	}

	/**
	 * @param array $post_ids
	 *
	 * @return string
	 */
	public function render_content( $post_ids = array() ) {
		ModuleManager::getInstance()->set_width( array( $this->get_content_width() ) );
		$include_post = empty( $post_ids ) ? ( ! empty( $this->result ) ? implode( ',', $this->result ) : '-10' ) : implode( ',', $post_ids );

		$attr = array(
			'date_format'            => $this->get_content_date(),
			'date_format_custom'     => $this->get_content_date_custom(),
			'excerpt_length'         => $this->get_content_excerpt(),
			'pagination_mode'        => $this->get_content_pagination(),
			'boxed'                  => $this->get_boxed(),
			'boxed_shadow'           => $this->get_boxed_shadow(),
			'box_shadow'             => $this->get_box_shadow(),
			'pagination_number_post' => $this->get_posts_per_page(),
			'number_post'            => $this->get_posts_per_page(),
			'sort_by'                => 'index',
			'paged'                  => 1,
		);
		if ( ! empty( $include_post ) ) {
			$attr['include_post'] = $include_post;
		}

		$attr = apply_filters( 'jnews_get_content_attr', $attr, $this->tag, null );
		$name = apply_filters( 'jnews_get_content_layout', 'JNews_Block_' . $this->get_content_type(), $this->tag );
		$name = jnews_get_view_class_from_shortcode( $name );

		/** Create the module @var $content_instance BlockViewAbstract */
		$this->content_instance = jnews_get_module_instance( $name );
		$result                 = $this->content_instance->build_module( $attr );

		$output = "<div class='jnews_history_post'>
						{$result}
					</div>";

		return $output;
	}

	/**
	 * @return int
	 */
	public function get_content_width() {
		$width = parent::get_content_width();

		if ( in_array( $this->get_page_layout(), array( 'right-sidebar', 'left-sidebar' ), true ) ) {
			$sidebar = $this->get_content_sidebar();
			if ( ! is_active_sidebar( $sidebar ) ) {
				return 12;
			}
		}

		return $width;
	}

	/**
	 * @return mixed|void
	 */
	public function get_page_layout() {
		return apply_filters( $this->tag . 'page_layout', get_theme_mod( $this->tag . 'page_layout', 'right-sidebar' ) );
	}

	/**
	 * @return mixed|void
	 */
	public function get_content_sidebar() {
		return apply_filters( $this->tag . 'sidebar', get_theme_mod( $this->tag . 'sidebar', 'default-sidebar' ) );
	}

	/**
	 * @return mixed|void
	 */
	public function get_content_date() {
		return apply_filters( $this->tag . 'content_date', get_theme_mod( $this->tag . 'content_date', 'default' ) );
	}

	/**
	 * @return mixed|void
	 */
	public function get_content_date_custom() {
		return apply_filters( $this->tag . 'content_date_custom', get_theme_mod( $this->tag . 'content_date_custom', 'Y/m/d' ) );
	}

	/**
	 * @return mixed|void
	 */
	public function get_content_excerpt() {
		return apply_filters( $this->tag . 'content_excerpt', get_theme_mod( $this->tag . 'content_excerpt', 20 ) );
	}

	/**
	 * @return mixed|void
	 */
	public function get_content_pagination() {
		return apply_filters( $this->tag . 'content_pagination', get_theme_mod( $this->tag . 'content_pagination', 'scrollload' ) );
	}

	/**
	 * @return bool|mixed|void
	 */
	public function get_boxed() {
		if ( ! in_array(
			$this->get_content_type(),
			array(
				'3',
				'4',
				'5',
				'6',
				'7',
				'9',
				'10',
				'14',
				'18',
				'22',
				'23',
				'25',
				'26',
				'27',
				'39',
			),
			true
		) ) {
			return false;
		}

		return apply_filters( $this->tag . 'boxed', get_theme_mod( $this->tag . 'boxed', false ) );
	}

	/**
	 * @return mixed|void
	 */
	public function get_content_type() {
		return apply_filters( $this->tag . 'content', get_theme_mod( $this->tag . 'content', '3' ) );
	}

	/**
	 * @return bool|mixed|void
	 */
	public function get_boxed_shadow() {
		if ( ! $this->get_boxed() ) {
			return false;
		}

		return apply_filters( $this->tag . 'boxed_shadow', get_theme_mod( $this->tag . 'boxed_shadow', false ) );
	}

	/**
	 * @return bool|mixed|void
	 */
	public function get_box_shadow() {
		if ( ! in_array( $this->get_content_type(), array( '37', '35', '33', '36', '32', '38' ), true ) ) {
			return false;
		}

		return apply_filters( $this->tag . 'box_shadow', get_theme_mod( $this->tag . 'box_shadow', false ) );
	}

	/**
	 * @return mixed|void
	 */
	public function get_posts_per_page() {
		$posts_per_page = apply_filters( $this->tag . 'posts_per_page', get_theme_mod( $this->tag . 'posts_per_page', false ) );

		return $posts_per_page ? $posts_per_page : get_option( 'posts_per_page' );
	}

	/**
	 * @return mixed|void
	 */
	public function get_second_sidebar() {
		return apply_filters( $this->tag . 'second_sidebar', get_theme_mod( $this->tag . 'second_sidebar', 'default-sidebar' ) );
	}

	/**
	 * @return mixed|void
	 */
	public function sticky_sidebar() {
		return apply_filters( $this->tag . 'sticky_sidebar', get_theme_mod( $this->tag . 'sticky_sidebar', true ) );
	}


	/**
	 * TODO: Implement get_content_pagination_limit() method.
	 */
	public function get_content_pagination_limit() {
		// TODO: Implement get_content_pagination_limit() method.
	}

	/**
	 * TODO: Implement get_content_pagination_align() method.
	 */
	public function get_content_pagination_align() {
		// TODO: Implement get_content_pagination_align() method.
	}

	/**
	 * TODO: Implement get_content_pagination_navtext() method.
	 */
	public function get_content_pagination_navtext() {
		// TODO: Implement get_content_pagination_navtext() method.
	}

	/**
	 * TODO: Implement get_content_pagination_pageinfo() method.
	 */
	public function get_content_pagination_pageinfo() {
		// TODO: Implement get_content_pagination_pageinfo() method.
	}
}
