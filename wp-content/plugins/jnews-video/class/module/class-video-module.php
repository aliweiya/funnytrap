<?php
/**
 * @author Jegtheme
 */

namespace JNEWS_VIDEO\Module;

/**
 * Class Video_Module
 *
 * @package JNEWS_VIDEO\Module
 */
class Video_Module {

	/**
	 * Instance of Video_Module
	 *
	 * @var Video_Module
	 */
	private static $instance;

	/**
	 * @var array
	 */
	private $module_array = array();

	/**
	 * Video_Module constructor.
	 */
	public function __construct() {
		$this->populate_module();
		add_filter( 'jnews_module_list', array( $this, 'video_module_element' ) );
		$this->video_load_module();
		$this->video_do_shortcode();
	}

	/**
	 * Get list module
	 *
	 * @return array|mixed
	 */
	public function populate_module() {
		if ( empty( $this->module_array ) ) {
			$this->module_array = include JNEWS_VIDEO_DIR . 'class/module/modules.php';
		}

		return $this->module_array;
	}

	/**
	 * Load module video
	 */
	public function video_load_module() {
		$elements = $this->populate_module();
		foreach ( $elements as $element ) {
			// Content Layout.
			add_filter(
				'jnews_get_content_layout_block_option',
				function ( $value ) use ( $element ) {
					if ( 'block' === $element['type'] && isset( $element['alias'] ) ) {
						$new[ $element['alias'] ]   = '';
						$value[ $element['image'] ] = $element['alias'];
					}

					return $value;
				}
			);
			add_filter(
				'jnews_get_content_layout_option',
				function ( $value ) use ( $element ) {
					if ( 'block' === $element['type'] && isset( $element['alias'] ) ) {
						$new[ $element['alias'] ]   = '';
						$value[ $element['alias'] ] = $element['image'];
					}

					return $value;
				}
			);
			add_filter(
				'jnews_get_content_layout_customizer',
				function ( $value ) use ( $element ) {
					if ( 'block' === $element['type'] && isset( $element['alias'] ) ) {
						$new[ $element['alias'] ]   = '';
						$value[ $element['alias'] ] = '';
					}

					return $value;
				}
			);
			add_filter(
				'jnews_get_content_layout',
				function ( $value ) use ( $element ) {
					$mod_element = explode( '_', $value );
					if ( ! empty( $mod_element[3] ) ) {
						$alias = implode( '_', array( $mod_element[2], $mod_element[3] ) );
						if ( isset( $element['alias'] ) && $element['alias'] === $alias ) {
							$value = $element['name'];
						}
					}

					return $value;
				}
			);

			add_action(
				'jnews_load_all_module_option',
				function () use ( $element ) {
					require_once JNEWS_VIDEO_DIR . $element['view'];
					require_once JNEWS_VIDEO_DIR . $element['option'];
				}
			);
			add_filter(
				'jnews_module_elementor_get_option_class',
				function ( $option_class ) use ( $element ) {
					if ( $this->check_class( $option_class, $element['name'] ) ) {
						require_once JNEWS_VIDEO_DIR . $element['option'];

						return $element['name'] . '_Option';
					}

					return $option_class;
				}
			);
			add_filter(
				'jnews_module_elementor_get_view_class',
				function ( $view_class ) use ( $element ) {
					if ( $this->check_class( $view_class, $element['name'] ) ) {
						require_once JNEWS_VIDEO_DIR . $element['view'];

						return $element['name'] . '_View';
					}

					return $view_class;
				}
			);
		}
	}

	/**
	 * Check Module class
	 *
	 * @param $class
	 * @param $element_name
	 *
	 * @return bool
	 */
	private function check_class( $class, $element_name ) {
		$mod_class = explode( '\\', $class );
		if ( ! empty( $mod_class[4] ) ) {
			$mod         = explode( '_', $mod_class[4] );
			$mod_element = explode( '_', $element_name );
			if ( $mod[0] . '_' . $mod[1] === $mod_element[1] . '_' . $mod_element[2] ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Register module video shortcode
	 */
	public function video_do_shortcode() {
		$elements = $this->populate_module();
		foreach ( $elements as $element ) {
			add_filter(
				'jnews_get_option_class_from_shortcode',
				function ( $class, $module ) use ( $element ) {
					if ( $module === $element['name'] ) {
						return $element['name'] . '_Option';
					}

					return $class;
				},
				null,
				2
			);
			add_filter(
				'jnews_get_view_class_from_shortcode',
				function ( $class, $module ) use ( $element ) {
					if ( $module === $element['name'] ) {
						return $element['name'] . '_View';
					}

					if ( str_replace( '_view', '', $module ) === strtolower( $element['name'] ) ) {
						require_once JNEWS_VIDEO_DIR . $element['view'];

						return $element['name'] . '_View';
					}

					return $class;
				},
				null,
				2
			);
			add_filter(
				'jnews_get_shortcode_name_from_option',
				function ( $module, $class ) use ( $element ) {
					if ( $class === $element['name'] . '_Option' ) {
						return strtolower( $element['name'] );
					}

					return $module;
				},
				null,
				2
			);
			add_action(
				'jnews_build_shortcode_' . strtolower( $element['name'] ) . '_view',
				function () use ( $element ) {
					require_once JNEWS_VIDEO_DIR . $element['view'];
					require_once JNEWS_VIDEO_DIR . $element['option'];
				}
			);
			add_filter(
				'jnews_get_shortcode_name_from_view',
				function ( $module ) use ( $element ) {
					if ( str_replace( '_view', '', $module ) === strtolower( $element['name'] ) ) {
						require_once JNEWS_VIDEO_DIR . $element['option'];
					}

					return $module;
				}
			);
		}
	}

	/**
	 * Singleton page of Video_Module class
	 *
	 * @return Video_Module
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * List module element
	 *
	 * @param $module
	 *
	 * @return mixed
	 */
	public function video_module_element( $module ) {
		$elements = $this->populate_module();
		foreach ( $elements as $element ) {
			array_push( $module, $element );
		}

		return $module;
	}

}

















