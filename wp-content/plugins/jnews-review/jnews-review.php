<?php
/*
	Plugin Name: JNews - Review
	Plugin URI: http://jegtheme.com/
	Description: Review Plugin for JNews
	Version: 7.0.0
	Author: Jegtheme
	Author URI: http://jegtheme.com
	License: GPL2
*/

defined( 'JNEWS_REVIEW' )               or define( 'JNEWS_REVIEW', 'jnews-review');
defined( 'JNEWS_REVIEW_URL' )           or define( 'JNEWS_REVIEW_URL', plugins_url(JNEWS_REVIEW));
defined( 'JNEWS_REVIEW_FILE' )          or define( 'JNEWS_REVIEW_FILE',  __FILE__ );
defined( 'JNEWS_REVIEW_DIR' )           or define( 'JNEWS_REVIEW_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Get jnews option
 *
 * @param $setting
 * @param $default
 * @return mixed
 */
if(!function_exists('jnews_get_option'))
{
    function jnews_get_option($setting, $default = null)
    {
        $options = get_option( 'jnews_option', array() );
        $value = $default;
        if ( isset( $options[ $setting ] ) ) {
            $value = $options[ $setting ];
        }
        return $value;
    }
}

/**
 * New Element
 */
add_filter('jnews_module_list', 'jnews_review_module_element');

if ( !function_exists('jnews_review_module_element') )
{
    function jnews_review_module_element($module)
    {
        array_push($module, array(
            'name'      => 'JNews_Element_Review',
            'type'      => 'review',
            'widget'    => false
        ));
        return $module;
    }
}

add_filter('jnews_get_option_class_from_shortcode', 'jnews_get_option_class_from_shortcode_review', null, 2);

if ( !function_exists('jnews_get_option_class_from_shortcode_review') )
{
    function jnews_get_option_class_from_shortcode_review($class, $module)
    {
        if($module === 'JNews_Element_Review')
        {
            return 'JNews_Element_Review_Option';
        }

        return $class;
    }
}

add_filter('jnews_get_view_class_from_shortcode', 'jnews_get_view_class_from_shortcode_review', null, 2);

if ( !function_exists('jnews_get_view_class_from_shortcode_review') )
{
    function jnews_get_view_class_from_shortcode_review($class, $module)
    {
        if($module === 'JNews_Element_Review')
        {
            return 'JNews_Element_Review_View';
        }

        return $class;
    }
}


add_action( 'jnews_build_shortcode_jnews_element_review_view', 'jnews_review_load_module_view');

if(!function_exists('jnews_review_load_module_view'))
{
    function jnews_review_load_module_view()
    {
    	jnews_review_load_module_option();
        require_once 'class.jnews-review-module-view.php';
    }
}

add_action( 'jnews_load_all_module_option', 'jnews_review_load_module_option' );

if(!function_exists('jnews_review_load_module_option'))
{
    function jnews_review_load_module_option()
    {
        require_once 'class.jnews-review-module-option.php';
    }
}

add_action( 'jnews_ajax_review_search_handler', 'jnews_ajax_review_search' );

if(!function_exists('jnews_ajax_review_search'))
{
    function jnews_ajax_review_search()
    {
        jnews_review_load_module_option();
        require_once 'class.jnews-review-module-view.php';
        $module_manager = \JNews\Module\ModuleManager::getInstance();
        echo JNews_Element_Review_View::getInstance($module_manager)->build_result($_REQUEST);
        exit;
    }
}

add_filter('jnews_get_shortcode_name_from_option', 'jnews_get_shortcode_name_from_option_review', null, 2);

function jnews_get_shortcode_name_from_option_review($module, $class)
{
    if($class === 'JNews_Element_Review_Option')
    {
        return 'jnews_element_review';
    }

    return $module;
}


if ( ! function_exists('jnews_module_elementor_get_option_class_review') )
{
	add_filter( 'jnews_module_elementor_get_option_class', 'jnews_module_elementor_get_option_class_review' );

	function jnews_module_elementor_get_option_class_review( $option_class )
	{
		if ( $option_class === '\JNews\Module\Element\Element_Review_Option' )
		{
			require_once 'class.jnews-review-module-option.php';
			return 'JNews_Element_Review_Option';
		}

		return $option_class;
	}
}


if ( ! function_exists('jnews_module_elementor_get_view_class_review') )
{
	add_filter( 'jnews_module_elementor_get_view_class', 'jnews_module_elementor_get_view_class_review' );

	function jnews_module_elementor_get_view_class_review( $view_class )
	{
		if ( $view_class === '\JNews\Module\Element\Element_Review_View' )
		{
			require_once 'class.jnews-review-module-view.php';
			return 'JNews_Element_Review_View';
		}

		return $view_class;
	}
}

/**
 * New Element 2
 */
add_filter('jnews_module_list', 'jnews_review_shortcode_element');

if ( !function_exists('jnews_review_shortcode_element') )
{
    function jnews_review_shortcode_element($module)
    {
        array_push($module, array(
            'name'      => 'JNews_Review_Shortcode',
            'type'      => 'review',
            'widget'    => false
        ));
        return $module;
    }
}

add_filter('jnews_get_option_class_from_shortcode', 'jnews_get_option_class_from_review_shortcode', null, 2);

if ( !function_exists('jnews_get_option_class_from_review_shortcode') )
{
    function jnews_get_option_class_from_review_shortcode($class, $module)
    {
        if($module === 'JNews_Review_Shortcode')
        {
            return 'JNews_Review_Shortcode_Option';
        }

        return $class;
    }
}

add_filter('jnews_get_view_class_from_shortcode', 'jnews_get_view_class_from_review_shortcode', null, 2);

if ( !function_exists('jnews_get_view_class_from_review_shortcode') )
{
    function jnews_get_view_class_from_review_shortcode($class, $module)
    {
        if($module === 'JNews_Review_Shortcode')
        {
            return 'JNews_Review_Shortcode_View';
        }

        return $class;
    }
}


add_action( 'jnews_build_shortcode_jnews_review_shortcode_view', 'jnews_review_load_shortcode_view');

if(!function_exists('jnews_review_load_shortcode_view'))
{
    function jnews_review_load_shortcode_view()
    {
        jnews_review_load_shortcode_option();
        require_once 'class.jnews-review-shortcode-view.php';
    }
}

add_action( 'jnews_load_all_module_option', 'jnews_review_load_shortcode_option' );

if(!function_exists('jnews_review_load_shortcode_option'))
{
    function jnews_review_load_shortcode_option()
    {
        require_once 'class.jnews-review-shortcode-option.php';
    }
}

add_action( 'jnews_ajax_review_search_handler', 'jnews_ajax_review_shortcode' );

if(!function_exists('jnews_ajax_review_shortcode'))
{
    function jnews_ajax_review_shortcode()
    {
        jnews_review_load_shortcode_option();
        require_once 'class.jnews-review-shortcode-view.php';
        $module_manager = \JNews\Module\ModuleManager::getInstance();
        echo JNews_Review_Shortcode_View::getInstance($module_manager)->build_result($_REQUEST);
        exit;
    }
}

add_filter('jnews_get_shortcode_name_from_option', 'jnews_get_shortcode_name_from_option_review_2', null, 2);

function jnews_get_shortcode_name_from_option_review_2($module, $class)
{
    if($class === 'JNews_Review_Shortcode_Option')
    {
        return 'jnews_review_shortcode';
    }

    return $module;
}


if ( ! function_exists('jnews_shortcode_elementor_get_option_class_review') )
{
    add_filter( 'jnews_module_elementor_get_option_class', 'jnews_shortcode_elementor_get_option_class_review' );

    function jnews_shortcode_elementor_get_option_class_review( $option_class )
    {
        /*var_dump($option_class);*/
        if ( $option_class === '\JNews\Module\Review\Review_Shortcode_Option' )
        {
            require_once 'class.jnews-review-shortcode-option.php';
            return 'JNews_Review_Shortcode_Option';
        }

        return $option_class;
    }
}


if ( ! function_exists('jnews_shortcode_elementor_get_view_class_review') )
{
    add_filter( 'jnews_module_elementor_get_view_class', 'jnews_shortcode_elementor_get_view_class_review' );

    function jnews_shortcode_elementor_get_view_class_review( $view_class )
    {
        /*var_dump($view_class);*/
        if ( $view_class === '\JNews\Module\Review\Review_Shortcode_View' )
        {
            require_once 'class.jnews-review-shortcode-view.php';
            return 'JNews_Review_Shortcode_View';
        }

        return $view_class;
    }
}

/**
 * Register Review Widget
 */

add_action( 'widgets_init', 'jnews_register_review_widget' );

if ( !function_exists('jnews_register_review_widget') )
{
    function jnews_register_review_widget()
    {
        if ( ! defined( 'JNEWS_THEME_URL' ) ) return;

        require_once 'class.jnews-review-widget.php';
        require_once 'class.jnews-review-list-widget.php';

        register_widget("JNews_Review_Widget");
        register_widget("JNews_Review_List_Widget");
    }
}



add_filter('jnews_review_generate_rating', 'jnews_review_generate_rating', null, 3);

if(!function_exists('jnews_review_generate_rating'))
{
    function jnews_review_generate_rating($review, $post_id, $class)
    {
        $rating_number = (int) get_post_meta($post_id, 'jnew_rating_mean', true);
        $rating_star = '';

        for ($i = 1; $i <= 5; $i++) {
            if ($rating_number >= 1.5) {
                $rating_star .= "<i class=\"fa fa-star\"></i>";
            }

            if ($rating_number >= 0.5 && $rating_number < 1.5) {
                $rating_star .= "<i class=\"fa fa-star-half-o\"></i>";
            }

            if ($rating_number < 0.5) {
                $rating_star .= "<i class=\"fa fa-star-o\"></i>";
            }

            $rating_number = (int) $rating_number - 2;
        }

        return "<div class=\"jeg_post_review jeg_review_stars {$class}\">{$rating_star}</div>";
    }
}

/** check if review enabled */
add_filter('jnews_review_enable_review', 'jnews_review_enable_review', null, 2);

if(!function_exists('jnews_review_enable_review'))
{
    function jnews_review_enable_review($review, $post_id)
    {
        return vp_metabox('jnews_review.enable_review', false, $post_id) ? true : false;
    }
}

/** Load Review Option */
add_action( 'jeg_register_customizer_option', 'jnews_review_customizer_option');

if(!function_exists('jnews_review_customizer_option'))
{
    function jnews_review_customizer_option()
    {
        require_once 'class.jnews-review-option.php';
        JNews_Review_Option::getInstance();
    }
}


add_filter('jeg_register_lazy_section', 'jnews_review_lazy_section');

if(!function_exists('jnews_review_lazy_section'))
{
    function jnews_review_lazy_section($result)
    {
        $result['jnews_review_section'][] = JNEWS_REVIEW_DIR . "review-option.php";
        return $result;
    }
}

/** Load Review Metabox */
add_action('after_setup_theme', 'jnews_review_metabox_load');

if(!function_exists('jnews_review_metabox_load'))
{
    function jnews_review_metabox_load()
    {
        if(class_exists('VP_Metabox'))
        {
            new VP_Metabox( JNEWS_REVIEW_DIR . 'metabox/post-review-setting.php' );
        }
    }
}

/** Load Review Metabox */
add_action('after_setup_theme', 'jnews_review_load');

if(!function_exists('jnews_review_load'))
{
    function jnews_review_load()
    {
        if(class_exists('VP_Metabox'))
        {
            if (is_admin()) {
                require_once 'class.jnews-review-backend.php';
                JNews_Review_Backend::getInstance();
            } else {
                require_once 'class.jnews-review-frontend.php';
                JNews_Review_Frontend::getInstance();
            }
        }
    }
}

/**
 * Integration with split content
 */
add_filter('jnews_split_content_description', 'jnews_review_split_content_description', null, 3);

if(!function_exists('jnews_review_split_content_description'))
{
    function jnews_review_split_content_description($content, $index, $max_page)
    {
        require_once 'class.jnews-review-frontend.php';
        $review = JNews_Review_Frontend::getInstance();
        return $review->split_review($content, $index, $max_page);
    }
}

if(!function_exists('jnews_review_get_price'))
{
    function jnews_review_get_price($price)
    {
        $before_price = jnews_get_option('price_front', '$');
        $after_price = jnews_get_option('price_behind', '');

        return $before_price . jnews_review_print_price($price) . $after_price;
    }
}

if(!function_exists('jnews_review_print_price'))
{
    function jnews_review_print_price($price)
    {
        return $price;
    }
}

/** Print Translation */

if(!function_exists('jnews_print_translation'))
{
    function jnews_print_translation($string, $domain, $name)
    {
        do_action('jnews_print_translation', $string, $domain, $name);
    }
}


if(!function_exists('jnews_print_main_translation'))
{
    add_action('jnews_print_translation', 'jnews_print_main_translation', 10, 2);

    function jnews_print_main_translation($string, $domain)
    {
        call_user_func_array('esc_html_e', array($string, $domain));
    }
}

/** Return Translation */

if(!function_exists('jnews_return_translation'))
{
    function jnews_return_translation($string, $domain, $name, $escape = true)
    {
        return apply_filters('jnews_return_translation', $string, $domain, $name, $escape);
    }
}

if(!function_exists('jnews_return_main_translation'))
{
    add_filter('jnews_return_translation', 'jnews_return_main_translation', 10, 4);

    function jnews_return_main_translation($string, $domain, $name, $escape = true)
    {
        if($escape)
        {
            return call_user_func_array('esc_html__', array($string, $domain));
        } else {
            return call_user_func_array('__', array($string, $domain));
        }

    }
}

/**
 * Load Text Domain
 */

function jnews_review_load_textdomain()
{
    load_plugin_textdomain( JNEWS_REVIEW, false, basename(__DIR__) . '/languages/' );
}

jnews_review_load_textdomain();
