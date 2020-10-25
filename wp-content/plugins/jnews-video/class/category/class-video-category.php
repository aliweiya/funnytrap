<?php
/**
 * @author Jegtheme
 */

namespace JNEWS_VIDEO\Category;

/**
 * Class Video_Category
 *
 * @package JNEWS_VIDEO\Category
 */
class Video_Category {

	/**
	 * Instance of BuddyPress.
	 *
	 * @var Video_Category
	 */
	private static $instance;

	/**
	 * Video_Category constructor.
	 */
	private function __construct() {
		$this->setup_hook();
	}

	/**
	 * Setup Video_Category hook
	 */
	public function setup_hook() {
		if ( defined( 'JNEWS_OPTION_CUSTOMIZER' ) ) {
			add_action( 'before_override_option_category', array( $this, 'option_category_load' ) );
		} else {
			add_action( 'after_setup_theme', array( $this, 'option_category_load' ) );
		}
	}

	/**
	 * Singleton page for Video_Category Class
	 *
	 * @return Video_Category
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Register new category option
	 */
	public function option_category_load() {
		Video_Option_Category::getInstance();
	}
}
