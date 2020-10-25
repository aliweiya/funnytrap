<?php
/*
	Plugin Name: JNews - Frontend Submit
	Plugin URI: http://jegtheme.com/
	Description: Frontend submit article for JNews Theme
	Version: 7.0.0
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
*/

defined( 'JNEWS_FRONTEND_SUBMIT' )          or define( 'JNEWS_FRONTEND_SUBMIT', 'jnews-frontend-submit');
defined( 'JNEWS_FRONTEND_SUBMIT_VERSION' )  or define( 'JNEWS_FRONTEND_SUBMIT_VERSION', '7.0.0' );
defined( 'JNEWS_FRONTEND_SUBMIT_URL' )      or define( 'JNEWS_FRONTEND_SUBMIT_URL', plugins_url('jnews-frontend-submit'));
defined( 'JNEWS_FRONTEND_SUBMIT_FILE' )     or define( 'JNEWS_FRONTEND_SUBMIT_FILE',  __FILE__ );
defined( 'JNEWS_FRONTEND_SUBMIT_DIR' )      or define( 'JNEWS_FRONTEND_SUBMIT_DIR', plugin_dir_path( __FILE__ ) );

require_once 'include/class/class.jnews-frontend-endpoint.php';
require_once 'include/class/class.jnews-frontend-template.php';
require_once 'include/class/class.jnews-frontend-package.php';
require_once 'include/class/class.jnews-frontend-option.php';
require_once 'include/class/class.jnews-frontend-session.php';
require_once 'include/class/class.jnews-frontend-submit.php';
require_once 'include/class/class.jnews-frontend-post.php';

add_action('after_setup_theme', 'jnews_frontend_submit');

if ( ! function_exists('jnews_frontend_submit') )
{
    function jnews_frontend_submit()
    {
    	JNews_Frontend_Session::getInstance();
    	JNews_Frontend_Option::getInstance();
        JNews_Frontend_Submit::getInstance();
        JNews_Frontend_Package::getInstance();
    }
}

add_action( 'plugins_loaded', function()
{
	require_once 'include/woocommerce/class.wc-product.php';
});

register_activation_hook( __FILE__, array( JNews_Frontend_Endpoint::getInstance(), 'activation_hook' ) );

if ( ! function_exists('jnews_flash_message') )
{
	function jnews_flash_message($name = '', $message = '', $class = 'success')
	{
	    $session = JNews_Frontend_Session::getInstance();
	    return $session->flash_message($name, $message, $class);
	}
}

/**
 * Register Post Package Shortcode
 */
if ( ! function_exists('jnews_post_package_module_element') )
{
	add_filter( 'jnews_module_list', 'jnews_post_package_module_element' );

	function jnews_post_package_module_element( $module )
	{
		array_push($module, array(
			'name'      => 'JNews_Element_Post_Package',
			'type'      => 'element',
			'widget'    => false
		));

		return $module;
	}
}

if ( ! function_exists('jnews_get_option_class_from_shortcode_post_package') )
{
	add_filter( 'jnews_get_option_class_from_shortcode', 'jnews_get_option_class_from_shortcode_post_package', null, 2 );

	function jnews_get_option_class_from_shortcode_post_package( $class, $module )
	{
		if ( $module === 'JNews_Element_Post_Package' )
		{
			return 'JNews_Element_Post_Package_Option';
		}

		return $class;
	}
}

if ( ! function_exists('jnews_get_view_class_from_shortcode_post_package') )
{
	add_filter( 'jnews_get_view_class_from_shortcode', 'jnews_get_view_class_from_shortcode_post_package', null, 2 );

	function jnews_get_view_class_from_shortcode_post_package( $class, $module )
	{
		if ( $module === 'JNews_Element_Post_Package' )
		{
			return 'JNews_Element_Post_Package_View';
		}

		return $class;
	}
}

if ( ! function_exists('jnews_get_shortcode_name_from_option_post_package') )
{
	add_filter( 'jnews_get_shortcode_name_from_option', 'jnews_get_shortcode_name_from_option_post_package', null, 2 );

	function jnews_get_shortcode_name_from_option_post_package( $module, $class )
	{
		if ( $class === 'JNews_Element_Post_Package_Option' )
		{
			return 'jnews_element_post_package';
		}

		return $module;
	}
}

if ( ! function_exists('jnews_post_package_load_module_view') )
{
	add_action( 'jnews_build_shortcode_jnews_element_post_package_view', 'jnews_post_package_load_module_view');

	function jnews_post_package_load_module_view()
	{
		jnews_post_package_load_module_option();
		require_once 'include/class/class.jnews-frontend-module-view.php';
	}
}

if ( ! function_exists('jnews_post_package_load_module_option') )
{
	add_action( 'jnews_load_all_module_option', 'jnews_post_package_load_module_option' );

	function jnews_post_package_load_module_option()
	{
		require_once 'include/class/class.jnews-frontend-module-option.php';
	}
}

if ( ! function_exists('jnews_module_elementor_get_option_class_post_package') )
{
	add_filter( 'jnews_module_elementor_get_option_class', 'jnews_module_elementor_get_option_class_post_package' );

	function jnews_module_elementor_get_option_class_post_package( $option_class )
	{
		if ( $option_class === '\JNews\Module\Element\Element_Post_Option' )
		{
			require_once 'include/class/class.jnews-frontend-module-option.php';
			return 'JNews_Element_Post_Package_Option';
		}

		return $option_class;
	}
}

if ( ! function_exists('jnews_module_elementor_get_view_class_post_package') )
{
	add_filter( 'jnews_module_elementor_get_view_class', 'jnews_module_elementor_get_view_class_post_package' );

	function jnews_module_elementor_get_view_class_post_package( $view_class )
	{
		if ( $view_class === '\JNews\Module\Element\Element_Post_View' )
		{
			require_once 'include/class/class.jnews-frontend-module-view.php';
			return 'JNews_Element_Post_Package_View';
		}

		return $view_class;
	}
}

/**
 * Print Translation
 */
if ( !function_exists('jnews_print_translation') )
{
	function jnews_print_translation( $string, $domain, $name )
	{
		do_action( 'jnews_print_translation', $string, $domain, $name );
	}
}

if ( !function_exists('jnews_print_main_translation') )
{
	add_action( 'jnews_print_translation', 'jnews_print_main_translation', 10, 2 );

	function jnews_print_main_translation( $string, $domain )
	{
		call_user_func_array( 'esc_html_e', array( $string, $domain ) );
	}
}

/**
 * Return Translation
 */
if ( !function_exists('jnews_return_translation') )
{
	function jnews_return_translation( $string, $domain, $name, $escape = true )
	{
		return apply_filters( 'jnews_return_translation', $string, $domain, $name, $escape );
	}
}

if ( !function_exists('jnews_return_main_translation') )
{
	add_filter( 'jnews_return_translation', 'jnews_return_main_translation', 10, 4 );

	function jnews_return_main_translation( $string, $domain, $name, $escape = true )
	{
		if ( $escape )
		{
			return call_user_func_array( 'esc_html__', array( $string, $domain ) );
		} else {
			return call_user_func_array( '__', array( $string, $domain ) );
		}

	}
}

/**
 * Load Text Domain
 */
function jnews_frontend_submit_load_textdomain()
{
	load_plugin_textdomain( JNEWS_FRONTEND_SUBMIT, false, basename(__DIR__) . '/languages/' );
}

jnews_frontend_submit_load_textdomain();
