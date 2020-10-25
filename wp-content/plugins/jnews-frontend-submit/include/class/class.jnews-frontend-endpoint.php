<?php
/**
 * @author Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class JNews_Frontend_Endpoint {
	private static $instance;

	private $endpoint;

	/**
	 * @return JNews_Frontend_Endpoint
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct() {
		$this->setup_endpoint();
		$this->setup_hook();
	}

	protected function setup_hook() {
		add_action( 'init', array( $this, 'add_rewrite_rule' ) );
		add_action( 'jnews_after_account_nav', array( $this, 'after_account_nav' ) );

		add_filter( 'jnews_account_page_endpoint', array( $this, 'account_page_endpoint' ) );
	}

	public function activation_hook() {
		$this->flush_rewrite_rules();
	}

	protected function setup_endpoint() {
		$endpoint = array(
			'editor'  => array(
				'title' => esc_html__( 'Create New Post', 'jnews-frontend-submit' ),
				'label' => 'create_new_post',
				'slug'  => 'editor'
			),
			'my_post' => array(
				'title' => esc_html__( 'My Post', 'jnews-frontend-submit' ),
				'label' => 'my_post',
				'slug'  => 'my-post'
			)
		);

		$this->endpoint = apply_filters( 'jnews_frontend_submit_endpoint', $endpoint );
	}

	public function get_endpoint() {
		return $this->endpoint;
	}

	public function after_account_nav() {
		if ( $this->is_user_allow_access() ) {
			$button =
				'<div class="frontend-submit-button">
                    <a class="button" href="' . $this->get_editor_slug() . '"><i class="fa fa-file-text-o"></i> ' . esc_html__( 'Submit Post', 'jnews-frontend-submit' ) . '</a>
                </div>';

			echo jnews_sanitize_output( $button );
		}
	}

	public function get_editor_slug() {
		return home_url( '/' . $this->endpoint['editor']['slug'] );
	}

	public function add_rewrite_rule() {
		add_rewrite_endpoint( $this->endpoint['editor']['slug'], EP_ROOT | EP_PAGES );
		add_rewrite_rule( '^' . $this->endpoint['editor']['slug'] . '/page/?([0-9]{1,})/?$', 'index.php?&paged=$matches[1]&' . $this->endpoint['editor']['slug'], 'top' );
	}

	public function flush_rewrite_rules() {
		$this->add_rewrite_rule();

		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}

	protected function archive_page_url( $endpoint ) {
		return home_url( '/' . $endpoint );
	}

	public function account_page_endpoint( $endpoint ) {
		if ( isset( $this->endpoint['my_post'] ) ) {
			$item['my_post'] = $this->endpoint['my_post'];
			$endpoint        = array_merge( $endpoint, $item );
		}

		return $endpoint;
	}

	protected function is_user_allow_access( $user_id = null ) {
		$value = true;

		if ( get_theme_mod( 'jnews_frontend_submit_enable_woocommerce', false ) ) {
			if ( empty( $user_id ) ) {
				$user_id = get_current_user_id();
			}

			$post_limit = get_user_meta( $user_id, 'listing_left', true );

			if ( (int) $post_limit <= 0 ) {
				$value = false;
			}
		}

		return apply_filters( 'jnews_frontend_submit_user_subscription', $value );
	}
}