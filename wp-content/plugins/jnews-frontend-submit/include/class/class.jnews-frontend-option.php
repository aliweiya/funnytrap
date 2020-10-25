<?php
/**
 * @author Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

Class JNews_Frontend_Option {
	private static $instance;

	private $customizer;

	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct() {
		add_action( 'jeg_register_customizer_option', array( $this, 'customizer_option' ) );
		add_filter( 'jeg_register_lazy_section', array( $this, 'autoload_section' ) );
	}

	public function customizer_option() {
		if ( class_exists( 'Jeg\Customizer\Customizer' ) ) {
			$this->customizer = Jeg\Customizer\Customizer::get_instance();

			$this->set_panel();
			$this->set_section();
		}
	}

	public function autoload_section( $result ) {
		$result['jnews_frontend_submit_section'][] = JNEWS_FRONTEND_SUBMIT_DIR . "include/option/frontend-submit-option.php";

		return $result;
	}

	public function set_panel() {
		$this->customizer->add_panel( array(
			'id'          => 'jnews_frontend_submit_panel',
			'title'       => esc_html__( 'JNews : Frontend Submit', 'jnews-frontend-submit' ),
			'description' => esc_html__( 'Frontend Submit Article Setting', 'jnews-frontend-submit' ),
			'priority'    => 200
		) );
	}

	public function set_section() {
		$this->customizer->add_section( array(
			'id'       => 'jnews_frontend_submit_section',
			'title'    => esc_html__( 'Frontend Submit Setting', 'jnews-frontend-submit' ),
			'panel'    => 'jnews_frontend_submit_panel',
			'priority' => 262,
			'type'     => 'jnews-lazy-section',
		) );
	}
}
