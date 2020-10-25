<?php

/*
 * This class should be used to work with the public side of wordpress.
 */

class Daam_Public
{

    //general class properties
    protected static $instance = null;
    private $shared = null;

    private function __construct()
    {

        //assign an instance of the plugin info
        $this->shared = Daam_Shared::get_instance();

        //Load public js
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));

        //write in front-end head
        add_action('wp_head', array($this, 'wr_public_head'));

        /*
         * Add the autolink on the content if the test mode option is not activated or if the the current user has the
         * Autolinks Menu capability.
         */
        if (
            intval(get_option($this->shared->get('slug') . '_advanced_enable_test_mode'), 10) === 0 or
            current_user_can(get_option($this->shared->get('slug') . "_capabilities_autolinks_menu"))
        ) {
            add_filter('the_content', array($this->shared, 'add_autolinks'),
                intval(get_option($this->shared->get('slug') . '_advanced_filter_priority'), 10));
            add_filter('the_content', array($this->shared, 'add_hidden_input'), 2147483647);
        }

	    /**
	     * Register specific meta fields to the Rest API
	     */
	    add_action( 'init', array($this, 'rest_api_register_meta'));

	    /*
	     * Add custom routes to the Rest API
	     */
	    add_action( 'rest_api_init', array($this, 'rest_api_register_route'));

    }

    /*
     * Creates an instance of this class.
     */
    public static function get_instance()
    {

        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;

    }

    public function wr_public_head()
    {

        //javascript variables
        echo '<script type="text/javascript">';
        echo 'var daamAjaxUrl = "' . admin_url('admin-ajax.php') . '";';
        echo 'var daamNonce = "' . wp_create_nonce("daam") . '";';
        echo '</script>';

    }

    /*
     * Enqueue the script used to track the interlinks if the tracking is enabled.
     */
    public function enqueue_scripts()
    {

        if (intval(get_option($this->shared->get('slug') . '_tracking_enable_click_tracking'), 10) === 1) {
            wp_enqueue_script($this->shared->get('slug') . '-tracking',
                $this->shared->get('url') . 'public/assets/js/tracking.js', 'jquery', $this->shared->get('ver'), true);
        }

    }

	/*
	 * Register specific meta fields to the Rest API
	 */
	function rest_api_register_meta() {

		register_meta( 'post', '_daam_enable_autolinks', array(
			'show_in_rest' => true,
			'single' => true,
			'type' => 'string',
			'auth_callback' => function(){return true;}
		) );

	}

	/*
	 * Add custom routes to the Rest API
	 */
	function rest_api_register_route(){

		//Add the GET 'daext-autolinks-manager/v1/options' endpoint to the Rest API
		register_rest_route(
			'daext-autolinks-manager/v1', '/options', array(
				'methods'  => 'GET',
				'callback' => array($this, 'rest_api_daext_autolinks_manager_read_options_callback'),
			)
		);

	}

	/*
	 * Callback for the GET 'daext-autolinks-manager/v1/options' endpoint of the Rest API
	 */
	function rest_api_daext_autolinks_manager_read_options_callback( $data ) {

		//Check the capability
		if (!current_user_can(get_option($this->shared->get('slug') . "_capabilities_editor_sidebar"))) {
			return new WP_Error(
				'rest_read_error',
				'Sorry, you are not allowed to view the Autolinks Manager options.',
				array('status' => 403)
			);
		}

		//Generate the response
		$response = [];
		foreach($this->shared->get('options') as $key => $value){
			$response[$key] = get_option($key);
		}

		//Prepare the response
		$response = new WP_REST_Response($response);

		return $response;

	}

}