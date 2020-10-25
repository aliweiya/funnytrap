<?php
/** 
Plugin Name: Youtubomatic YouTube Automatic Post Generator
Plugin URI: //1.envato.market/coderevolution
Description: This plugin will generate content for you, even in your sleep using YouTube feeds.
Author: CodeRevolution
Version: 2.5.7.1
Author URI: //coderevolution.ro
License: Commercial. For personal use only. Not to give away or resell.
Text Domain: youtubomatic-youtube-post-generator
*/
/*  
Copyright 2016 - 2020 CodeRevolution
*/
defined('ABSPATH') or die();

function youtubomatic_load_textdomain() {
    load_plugin_textdomain( 'youtubomatic-youtube-post-generator', false, basename( dirname( __FILE__ ) ) . '/languages' ); 
}
add_action( 'init', 'youtubomatic_load_textdomain' );

function youtubomatic_get_random_user_agent() {
	$agents = array(
		"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36",
		"Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/603.3.8 (KHTML, like Gecko) Version/10.1.2 Safari/603.3.8",
		"Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36",
		"Mozilla/5.0 (Windows NT 10.0; WOW64; rv:55.0) Gecko/20100101 Firefox/55.0",
		"Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:55.0) Gecko/20100101 Firefox/55.0",
		"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36",
		"Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko",
		"Mozilla/5.0 (Windows NT 6.1; WOW64; rv:55.0) Gecko/20100101 Firefox/55.0",
		"Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:55.0) Gecko/20100101 Firefox/55.0",
		"Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:55.0) Gecko/20100101 Firefox/55.0",
		"Mozilla/5.0 (Windows NT 10.0; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
		"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.101 Safari/537.36"
	);
	$rand   = rand( 0, count( $agents ) - 1 );
	return trim( $agents[ $rand ] );
}
function youtubomatic_assign_var(&$target, $var) {
	static $cnt = 0;
    $key = key($var);
    if(is_array($var[$key])) 
        youtubomatic_assign_var($target[$key], $var[$key]);
    else {
        if($key==0)
		{
			if($cnt == 0)
			{
				$target['_youtubomaticr_nonce'] = $var[$key];
				$cnt++;
			}
			elseif($cnt == 1)
			{
				$target['_wp_http_referer'] = $var[$key];
				$cnt++;
			}
			else
			{
				$target[] = $var[$key];
			}
		}
        else
		{
            $target[$key] = $var[$key];
		}
    }   
}

function youtubomatic_replace_attachment_url($att_url, $att_id) {
    {
         $post_id = get_the_ID();
         wp_suspend_cache_addition(true);
         $metas = get_post_custom($post_id);
         wp_suspend_cache_addition(false);
         $rez_meta = youtubomatic_preg_grep_keys('#.+?_featured_img#i', $metas);
         if(count($rez_meta) > 0)
         {
             foreach($rez_meta as $rm)
             {
                 if(isset($rm[0]) && $rm[0] != '' && filter_var($rm[0], FILTER_VALIDATE_URL))
                 {
                    return $rm[0];
                 }
             }
         }
    }
    return $att_url;
}


function youtubomatic_replace_attachment_image_src($image, $att_id, $size) {
    {
        $post_id = get_the_ID();
        wp_suspend_cache_addition(true);
        $metas = get_post_custom($post_id);
        wp_suspend_cache_addition(false);
        $rez_meta = youtubomatic_preg_grep_keys('#.+?_featured_img#i', $metas);
        if(count($rez_meta) > 0)
        {
            foreach($rez_meta as $rm)
            {
                if(isset($rm[0]) && $rm[0] != '' && filter_var($rm[0], FILTER_VALIDATE_URL))
                {
                    return array($rm[0], 0, 0, false);
                }
            }
        }
     }
     return $image;
}

function youtubomatic_thumbnail_external_replace( $html, $post_id ) {
    
    wp_suspend_cache_addition(true);
    $metas = get_post_custom($post_id);
    wp_suspend_cache_addition(false);
    $rez_meta = youtubomatic_preg_grep_keys('#.+?_featured_img#i', $metas);
    if(count($rez_meta) > 0)
    {
        foreach($rez_meta as $rm)
        {
            if(isset($rm[0]) && $rm[0] != '' && filter_var($rm[0], FILTER_VALIDATE_URL))
            {
                $alt = get_post_field( 'post_title', $post_id ) . ' ' .  esc_html__( 'thumbnail', 'youtubomatic-youtube-post-generator' );
                $attr = array( 'alt' => $alt );
                $attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, NULL , 'thumbnail');
                $attr = array_map( 'esc_attr', $attr );
                $html = sprintf( '<img src="%s"', esc_url($rm[0]) );
                foreach ( $attr as $name => $value ) {
                    $html .= " " . esc_html($name) . "=" . '"' . esc_attr($value) . '"';
                }
                $html .= ' />';
                return $html;
            }
        }
    }
    return $html;
}
$plugin = plugin_basename(__FILE__);
if(is_admin())
{
    if($_SERVER["REQUEST_METHOD"]==="POST" && !empty($_POST["coderevolution_max_input_var_data"])) {
    $vars = explode("&", $_POST["coderevolution_max_input_var_data"]);
    $coderevolution_max_input_var_data = array();
    foreach($vars as $var) {
        parse_str($var, $variable);
        youtubomatic_assign_var($_POST, $variable);
    }
	unset($_POST["coderevolution_max_input_var_data"]);
}
    $plugin_slug = explode('/', $plugin);
    $plugin_slug = $plugin_slug[0];
    if(isset($_POST[$plugin_slug . '_register']) && isset($_POST[$plugin_slug. '_register_code']) && trim($_POST[$plugin_slug . '_register_code']) != '')
    {
        update_option('coderevolution_settings_changed', 1);
        if(strlen(trim($_POST[$plugin_slug . '_register_code'])) != 36 || strstr($_POST[$plugin_slug . '_register_code'], '-') == false)
        {
            youtubomatic_log_to_file('Invalid registration code submitted: ' . $_POST[$plugin_slug . '_register_code']);
        }
        else
        {
            $ch = curl_init('https://wpinitiate.com/verify-purchase/purchase.php');
            if($ch !== false)
            {
                $data           = array();
                $data['code']   = trim($_POST[$plugin_slug . '_register_code']);
                $data['siteURL']   = get_bloginfo('url');
                $data['siteName']   = get_bloginfo('name');
                $data['siteEmail']   = get_bloginfo('admin_email');
                $fdata = "";
                foreach ($data as $key => $val) {
                    $fdata .= "$key=" . urlencode(trim($val)) . "&";
                }
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                $result = curl_exec($ch);
                
                if($result === false)
                {
                    youtubomatic_log_to_file('Failed to get verification response: ' . curl_error($ch));
                }
                else
                {
                    if($result == 'error1' || $result == 'error2' || $result == 'error3' || $result == 'error4')
                    {
                        youtubomatic_log_to_file('Failed to validate plugin info: ' . $result);
                    }
                    else
                    {
                        $rj = json_decode($result, true);
                        if(isset($rj['item_name']))
                        {
                            $rj['code'] = $_POST[$plugin_slug . '_register_code'];
                            if($rj['item_id'] == '19622635' || $rj['item_id'] == '13371337' || $rj['item_id'] == '19651107' || $rj['item_id'] == '20379373' || $rj['item_id'] == '19200046')
                            {
                                update_option($plugin_slug . '_registration', $rj);
                                update_option('coderevolution_settings_changed', 2);
                            }
                            else
                            {
                                youtubomatic_log_to_file('Invalid response from purchase code verification (are you sure you inputed the right purchase code?): ' . print_r($rj, true));
                            }
                        }
                        else
                        {
                            youtubomatic_log_to_file('Invalid json from purchase code verification: ' . print_r($result, true));
                        }
                    }
                }
                curl_close($ch);
            }
            else
            {
                youtubomatic_log_to_file('Failed to init curl when trying to make purchase verification.');
            }
        }
    }
    $uoptions = get_option($plugin_slug . '_registration', array());
    if(isset($uoptions['item_id']) && isset($uoptions['item_name']) && isset($uoptions['created_at']) && isset($uoptions['buyer']) && isset($uoptions['licence']) && isset($uoptions['supported_until']))
    {
        require "update-checker/plugin-update-checker.php";
        $fwdu3dcarPUC = Puc_v4_Factory::buildUpdateChecker("https://wpinitiate.com/auto-update/?action=get_metadata&slug=youtubomatic-youtube-post-generator", __FILE__, "youtubomatic-youtube-post-generator");
    }
    else
    {
        add_action("after_plugin_row_{$plugin}", function( $plugin_file, $plugin_data, $status ) {
            $plugin_url = 'https://codecanyon.net/item/youtubomatic-automatic-post-generator-and-youtube-auto-poster-plugin-for-wordpress/19622635';
            echo '<tr class="active"><td>&nbsp;</td><td colspan="2"><p class="cr_auto_update">';
          echo sprintf( wp_kses( __( 'The plugin is not registered. Automatic updating is disabled. Please purchase a license for it from <a href="%s" target="_blank">here</a> and register  the plugin from the \'Main Settings\' menu using your purchase code. <a href="%s" target="_blank">How I find my purchase code?', 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://1.envato.market/c/1264868/275988/4415?u=' . urlencode($plugin_url)), esc_url('//www.youtube.com/watch?v=NElJ5t_Wd48') );     
          echo '</a></p> </td></tr>';
        }, 10, 3 );
        add_action('admin_enqueue_scripts', 'youtubomatic_admin_enqueue_all');
        add_filter("plugin_action_links_$plugin", 'youtubomatic_add_activation_link');
    }
    add_filter("plugin_action_links_$plugin", 'youtubomatic_add_settings_link');
    add_filter("plugin_action_links_$plugin", 'youtubomatic__add_rating_link');
    add_filter("plugin_action_links_$plugin", 'youtubomatic_add_support_link');
    add_action('admin_menu', 'youtubomatic_register_my_custom_menu_page');
    add_action('network_admin_menu', 'youtubomatic_register_my_custom_menu_page');
    add_action('add_meta_boxes', 'youtubomatic_add_meta_box');
    add_filter('autosave_interval', 'youtubomatic_filter_autosave_interval');
    add_action('admin_notices', 'youtubomatic_admin_notice_reauth' );
    add_action('admin_init', 'youtubomatic_register_mysettings');
    require(dirname(__FILE__) . "/res/youtubomatic-main.php");
    require(dirname(__FILE__) . "/res/youtubomatic-rules-list.php");
    require(dirname(__FILE__) . "/res/youtubomatic-youtube-list.php");
    require(dirname(__FILE__) . "/res/youtubomatic-logs.php");
    require(dirname(__FILE__) . "/res/youtubomatic-offer.php");
}
function youtubomatic_admin_enqueue_all()
{
    $reg_css_code = '.cr_auto_update{background-color:#fff8e5;margin:5px 20px 15px 20px;border-left:4px solid #fff;padding:12px 12px 12px 12px !important;border-left-color:#ffb900;}';
    wp_register_style( 'youtubomatic-plugin-reg-style', false );
    wp_enqueue_style( 'youtubomatic-plugin-reg-style' );
    wp_add_inline_style( 'youtubomatic-plugin-reg-style', $reg_css_code );
}
function youtubomatic_add_activation_link($links)
{
    $settings_link = '<a href="admin.php?page=youtubomatic_admin_settings">' . esc_html__('Activate Plugin License', 'youtubomatic-youtube-post-generator') . '</a>';
    array_push($links, $settings_link);
    return $links;
}
use \Eventviva\ImageResize;

function youtubomatic_register_my_custom_menu_page()
{
    add_menu_page('Youtubomatic Post Generator', 'Youtubomatic Post Generator', 'manage_options', 'youtubomatic_admin_settings', 'youtubomatic_admin_settings', plugins_url('images/icon.png', __FILE__));
    $main = add_submenu_page('youtubomatic_admin_settings', esc_html__("Main Settings", 'youtubomatic-youtube-post-generator'), esc_html__("Main Settings", 'youtubomatic-youtube-post-generator'), 'manage_options', 'youtubomatic_admin_settings');
    add_action( 'load-' . $main, 'youtubomatic_load_all_admin_js' );
    add_action( 'load-' . $main, 'youtubomatic_load_main_admin_js' );
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') {
        $yt = add_submenu_page('youtubomatic_admin_settings', esc_html__('YouTube to Posts', 'youtubomatic-youtube-post-generator'), esc_html__('YouTube to Posts', 'youtubomatic-youtube-post-generator'), 'manage_options', 'youtubomatic_items_panel', 'youtubomatic_items_panel');
        add_action( 'load-' . $yt, 'youtubomatic_load_admin_js' );
        add_action( 'load-' . $yt, 'youtubomatic_load_all_admin_js' );
        $post = add_submenu_page('youtubomatic_admin_settings', esc_html__('Posts to YouTube', 'youtubomatic-youtube-post-generator'), esc_html__('Posts to YouTube', 'youtubomatic-youtube-post-generator'), 'manage_options', 'youtubomatic_youtube_panel', 'youtubomatic_youtube_panel');
        add_action( 'load-' . $post, 'youtubomatic_load_all_admin_js' );
        add_action( 'load-' . $post, 'youtubomatic_load_post_admin_js' );
        $tips = add_submenu_page('youtubomatic_admin_settings', esc_html__('Tips & Tricks', 'youtubomatic-youtube-post-generator'), esc_html__('Tips & Tricks', 'youtubomatic-youtube-post-generator'), 'manage_options', 'youtubomatic_recommendations', 'youtubomatic_recommendations');
        add_action( 'load-' . $tips, 'youtubomatic_load_all_admin_js' );
        $logs = add_submenu_page('youtubomatic_admin_settings', esc_html__("Activity & Logging", 'youtubomatic-youtube-post-generator'), esc_html__("Activity & Logging", 'youtubomatic-youtube-post-generator'), 'manage_options', 'youtubomatic_logs', 'youtubomatic_logs');
        add_action( 'load-' . $logs, 'youtubomatic_load_all_admin_js' );
    }
}
function youtubomatic_load_post_admin_js(){
    add_action('admin_enqueue_scripts', 'youtubomatic_admin_load_post_files');
}

function youtubomatic_admin_load_post_files()
{
    wp_register_script('youtubomatic-submitter-script', plugins_url('scripts/poster.js', __FILE__), false, '1.0.0');
    wp_enqueue_script('youtubomatic-submitter-script');
}
function youtubomatic_load_admin_js(){
    add_action('admin_enqueue_scripts', 'youtubomatic_enqueue_admin_js');
}

function youtubomatic_enqueue_admin_js(){
    wp_enqueue_script('youtubomatic-footer-script', plugins_url('scripts/footer.js', __FILE__), array('jquery'), false, true);
    $cr_miv = ini_get('max_input_vars');
	if($cr_miv === null || $cr_miv === false || !is_numeric($cr_miv))
	{
        $cr_miv = '9999999';
    }
    $footer_conf_settings = array(
        'max_input_vars' => $cr_miv,
        'plugin_dir_url' => plugin_dir_url(__FILE__),
        'ajaxurl' => admin_url('admin-ajax.php')
    );
    wp_localize_script('youtubomatic-footer-script', 'mycustomsettings', $footer_conf_settings);
    wp_register_style('youtubomatic-rules-style', plugins_url('styles/youtubomatic-rules.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('youtubomatic-rules-style');
}
function youtubomatic_load_main_admin_js(){
    add_action('admin_enqueue_scripts', 'youtubomatic_enqueue_main_admin_js');
}

function youtubomatic_enqueue_main_admin_js(){
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    wp_enqueue_script('youtubomatic-main-script', plugins_url('scripts/main.js', __FILE__), array('jquery'));
    if(!isset($youtubomatic_Main_Settings['best_user']))
    {
        $best_user = '';
    }
    else
    {
        $best_user = $youtubomatic_Main_Settings['best_user'];
    }
    if(!isset($youtubomatic_Main_Settings['best_password']))
    {
        $best_password = '';
    }
    else
    {
        $best_password = $youtubomatic_Main_Settings['best_password'];
    }
    $header_main_settings = array(
        'best_user' => $best_user,
        'best_password' => $best_password
    );
    wp_localize_script('youtubomatic-main-script', 'mycustommainsettings', $header_main_settings);
}
function youtubomatic_load_all_admin_js(){
    add_action('admin_enqueue_scripts', 'youtubomatic_admin_load_files');
}
function youtubomatic__add_rating_link($links)
{
    $settings_link = '<a href="//codecanyon.net/downloads" target="_blank" title="Rate">
            <i class="wdi-rate-stars"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="#ffb900" stroke="#ffb900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></i></a>';
    array_push($links, $settings_link);
    return $links;
}

function youtubomatic_add_support_link($links)
{
    $settings_link = '<a href="//coderevolution.ro/knowledge-base/" target="_blank">' . esc_html__('Support', 'youtubomatic-youtube-post-generator') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

function youtubomatic_add_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=youtubomatic_admin_settings">' . esc_html__('Settings', 'youtubomatic-youtube-post-generator') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

function youtubomatic_add_meta_box()
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] === 'on') {
        if (isset($youtubomatic_Main_Settings['enable_metabox']) && $youtubomatic_Main_Settings['enable_metabox'] == 'on') {
            foreach ( get_post_types( '', 'names' ) as $post_type ) {
               add_meta_box('youtubomatic_meta_box_function_add', esc_html__('Youtubomatic Automatic Post Generator Information', 'youtubomatic-youtube-post-generator'), 'youtubomatic_meta_box_function', $post_type, 'advanced', 'default', array('__back_compat_meta_box' => true));
            }
        }
    }
}
function youtubomatic_add_minute($date, $minute)
{
    $date1 = new DateTime($date, youtubomatic_get_blog_timezone());
    $date1->modify("$minute minutes");
    foreach ($date1 as $key => $value) {
        if ($key == 'date') {
            return $value;
        }
    }
    return $date;
}

function youtubomatic_minute_diff($date1, $date2)
{
    $date1 = new DateTime($date1, youtubomatic_get_blog_timezone());
    $date2 = new DateTime($date2, youtubomatic_get_blog_timezone());
    
    $number1 = (int) $date1->format('U');
    $number2 = (int) $date2->format('U');
    return ($number1 - $number2);
}
function youtubomatic_get_blog_timezone() {

    $tzstring = get_option( 'timezone_string' );
    $offset   = get_option( 'gmt_offset' );

    if( empty( $tzstring ) && 0 != $offset && floor( $offset ) == $offset ){
        $offset_st = $offset > 0 ? "-$offset" : '+'.absint( $offset );
        $tzstring  = 'Etc/GMT'.$offset_st;
    }
    if( empty( $tzstring ) ){
        $tzstring = 'UTC';
    }
    $timezone = new DateTimeZone( $tzstring );
    return $timezone; 
}
add_filter('cron_schedules', 'youtubomatic_add_cron_schedule');
function youtubomatic_add_cron_schedule($schedules)
{
    $schedules['youtubomatic_cron'] = array(
        'interval' => 3600,
        'display' => esc_html__('youtubomatic Cron', 'youtubomatic-youtube-post-generator')
    );
    $schedules['minutely'] = array(
        'interval' => 60,
        'display' => esc_html__('Once A Minute', 'youtubomatic-youtube-post-generator')
    );
    $schedules['weekly']        = array(
        'interval' => 604800,
        'display' => esc_html__('Once Weekly', 'youtubomatic-youtube-post-generator')
    );
    $schedules['monthly']       = array(
        'interval' => 2592000,
        'display' => esc_html__('Once Monthly', 'youtubomatic-youtube-post-generator')
    );
    return $schedules;
}
function youtubomatic_auto_clear_log()
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
       wp_filesystem($creds);
    }
    if ($wp_filesystem->exists(WP_CONTENT_DIR . '/youtubomatic_info.log')) {
        $wp_filesystem->delete(WP_CONTENT_DIR . '/youtubomatic_info.log');
    }
}

register_deactivation_hook(__FILE__, 'youtubomatic_my_deactivation');
function youtubomatic_my_deactivation()
{
    wp_clear_scheduled_hook('youtubomaticaction');
    wp_clear_scheduled_hook('youtubomaticactionclear');
    $running = array();
    update_option('youtubomatic_running_list', $running, false);
}
add_action('youtubomaticaction', 'youtubomatic_cron');
add_action('youtubomaticactionclear', 'youtubomatic_auto_clear_log');
add_shortcode( 'youtubomatic-display-posts', 'youtubomatic_display_posts_shortcode' );
function youtubomatic_display_posts_shortcode( $atts ) {
	$original_atts = $atts;
	$atts = shortcode_atts( array(
		'author'               => '',
		'category'             => '',
		'category_display'     => '',
		'category_label'       => 'Posted in: ',
		'content_class'        => 'content',
		'date_format'          => '(n/j/Y)',
		'date'                 => '',
		'date_column'          => 'post_date',
		'date_compare'         => '=',
		'date_query_before'    => '',
		'date_query_after'     => '',
		'date_query_column'    => '',
		'date_query_compare'   => '',
		'display_posts_off'    => false,
		'excerpt_length'       => false,
		'excerpt_more'         => false,
		'excerpt_more_link'    => false,
		'exclude_current'      => false,
		'id'                   => false,
		'ignore_sticky_posts'  => false,
		'image_size'           => false,
		'include_author'       => false,
		'include_content'      => false,
		'include_date'         => false,
		'include_excerpt'      => false,
		'include_link'         => true,
		'include_title'        => true,
		'meta_key'             => '',
		'meta_value'           => '',
		'no_posts_message'     => '',
		'offset'               => 0,
		'order'                => 'DESC',
		'orderby'              => 'date',
		'post_parent'          => false,
		'post_status'          => 'publish',
		'post_type'            => 'post',
		'posts_per_page'       => '10',
		'tag'                  => '',
		'tax_operator'         => 'IN',
		'tax_include_children' => true,
		'tax_term'             => false,
		'taxonomy'             => false,
		'time'                 => '',
		'title'                => '',
        'title_color'          => '#000000',
        'excerpt_color'        => '#000000',
        'link_to_source'       => '',
        'title_font_size'      => '100%',
        'excerpt_font_size'    => '100%',
        'read_more_text'       => '',
		'wrapper'              => 'ul',
		'wrapper_class'        => 'display-posts-listing',
		'wrapper_id'           => false,
        'ruleid'               => ''
	), $atts, 'display-posts' );
	if( $atts['display_posts_off'] )
		return;
	$author               = sanitize_text_field( $atts['author'] );
    $ruleid               = sanitize_text_field( $atts['ruleid'] );
	$category             = sanitize_text_field( $atts['category'] );
	$category_display     = 'true' == $atts['category_display'] ? 'category' : sanitize_text_field( $atts['category_display'] );
	$category_label       = sanitize_text_field( $atts['category_label'] );
	$content_class        = array_map( 'sanitize_html_class', ( explode( ' ', $atts['content_class'] ) ) );
	$date_format          = sanitize_text_field( $atts['date_format'] );
	$date                 = sanitize_text_field( $atts['date'] );
	$date_column          = sanitize_text_field( $atts['date_column'] );
	$date_compare         = sanitize_text_field( $atts['date_compare'] );
	$date_query_before    = sanitize_text_field( $atts['date_query_before'] );
	$date_query_after     = sanitize_text_field( $atts['date_query_after'] );
	$date_query_column    = sanitize_text_field( $atts['date_query_column'] );
	$date_query_compare   = sanitize_text_field( $atts['date_query_compare'] );
	$excerpt_length       = intval( $atts['excerpt_length'] );
	$excerpt_more         = sanitize_text_field( $atts['excerpt_more'] );
	$excerpt_more_link    = filter_var( $atts['excerpt_more_link'], FILTER_VALIDATE_BOOLEAN );
	$exclude_current      = filter_var( $atts['exclude_current'], FILTER_VALIDATE_BOOLEAN );
	$id                   = $atts['id'];
	$ignore_sticky_posts  = filter_var( $atts['ignore_sticky_posts'], FILTER_VALIDATE_BOOLEAN );
	$image_size           = sanitize_key( $atts['image_size'] );
	$include_title        = filter_var( $atts['include_title'], FILTER_VALIDATE_BOOLEAN );
	$include_author       = filter_var( $atts['include_author'], FILTER_VALIDATE_BOOLEAN );
	$include_content      = filter_var( $atts['include_content'], FILTER_VALIDATE_BOOLEAN );
	$include_date         = filter_var( $atts['include_date'], FILTER_VALIDATE_BOOLEAN );
	$include_excerpt      = filter_var( $atts['include_excerpt'], FILTER_VALIDATE_BOOLEAN );
	$include_link         = filter_var( $atts['include_link'], FILTER_VALIDATE_BOOLEAN );
	$meta_key             = sanitize_text_field( $atts['meta_key'] );
	$meta_value           = sanitize_text_field( $atts['meta_value'] );
	$no_posts_message     = sanitize_text_field( $atts['no_posts_message'] );
	$offset               = intval( $atts['offset'] );
	$order                = sanitize_key( $atts['order'] );
	$orderby              = sanitize_key( $atts['orderby'] );
	$post_parent          = $atts['post_parent'];
	$post_status          = $atts['post_status'];
	$post_type            = sanitize_text_field( $atts['post_type'] );
	$posts_per_page       = intval( $atts['posts_per_page'] );
	$tag                  = sanitize_text_field( $atts['tag'] );
	$tax_operator         = $atts['tax_operator'];
	$tax_include_children = filter_var( $atts['tax_include_children'], FILTER_VALIDATE_BOOLEAN );
	$tax_term             = sanitize_text_field( $atts['tax_term'] );
	$taxonomy             = sanitize_key( $atts['taxonomy'] );
	$time                 = sanitize_text_field( $atts['time'] );
	$shortcode_title      = sanitize_text_field( $atts['title'] );
    $title_color          = sanitize_text_field( $atts['title_color'] );
    $excerpt_color        = sanitize_text_field( $atts['excerpt_color'] );
    $link_to_source       = sanitize_text_field( $atts['link_to_source'] );
    $excerpt_font_size    = sanitize_text_field( $atts['excerpt_font_size'] );
    $title_font_size      = sanitize_text_field( $atts['title_font_size'] );
    $read_more_text       = sanitize_text_field( $atts['read_more_text'] );
	$wrapper              = sanitize_text_field( $atts['wrapper'] );
	$wrapper_class        = array_map( 'sanitize_html_class', ( explode( ' ', $atts['wrapper_class'] ) ) );
	if( !empty( $wrapper_class ) )
		$wrapper_class = ' class="' . implode( ' ', $wrapper_class ) . '"';
	$wrapper_id = sanitize_html_class( $atts['wrapper_id'] );
	if( !empty( $wrapper_id ) )
		$wrapper_id = ' id="' . esc_html($wrapper_id) . '"';
	$args = array(
		'category_name'       => $category,
		'order'               => $order,
		'orderby'             => $orderby,
		'post_type'           => explode( ',', $post_type ),
		'posts_per_page'      => $posts_per_page,
		'tag'                 => $tag,
	);
	if ( ! empty( $date ) || ! empty( $time ) || ! empty( $date_query_after ) || ! empty( $date_query_before ) ) {
		$initial_date_query = $date_query_top_lvl = array();
		$valid_date_columns = array(
			'post_date', 'post_date_gmt', 'post_modified', 'post_modified_gmt',
			'comment_date', 'comment_date_gmt'
		);
		$valid_compare_ops = array( '=', '!=', '>', '>=', '<', '<=', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN' );
		$dates = youtubomatic_sanitize_date_time( $date );
		if ( ! empty( $dates ) ) {
			if ( is_string( $dates ) ) {
				$timestamp = strtotime( $dates );
				$dates = array(
					'year'   => date( 'Y', $timestamp ),
					'month'  => date( 'm', $timestamp ),
					'day'    => date( 'd', $timestamp ),
				);
			}
			foreach ( $dates as $arg => $segment ) {
				$initial_date_query[ $arg ] = $segment;
			}
		}
		$times = youtubomatic_sanitize_date_time( $time, 'time' );
		if ( ! empty( $times ) ) {
			foreach ( $times as $arg => $segment ) {
				$initial_date_query[ $arg ] = $segment;
			}
		}
		$before = youtubomatic_sanitize_date_time( $date_query_before, 'date', true );
		if ( ! empty( $before ) ) {
			$initial_date_query['before'] = $before;
		}
		$after = youtubomatic_sanitize_date_time( $date_query_after, 'date', true );
		if ( ! empty( $after ) ) {
			$initial_date_query['after'] = $after;
		}
		if ( ! empty( $date_query_column ) && in_array( $date_query_column, $valid_date_columns ) ) {
			$initial_date_query['column'] = $date_query_column;
		}
		if ( ! empty( $date_query_compare ) && in_array( $date_query_compare, $valid_compare_ops ) ) {
			$initial_date_query['compare'] = $date_query_compare;
		}
		if ( ! empty( $date_column ) && in_array( $date_column, $valid_date_columns ) ) {
			$date_query_top_lvl['column'] = $date_column;
		}
		if ( ! empty( $date_compare ) && in_array( $date_compare, $valid_compare_ops ) ) {
			$date_query_top_lvl['compare'] = $date_compare;
		}
		if ( ! empty( $initial_date_query ) ) {
			$date_query_top_lvl[] = $initial_date_query;
		}
		$args['date_query'] = $date_query_top_lvl;
	}
    $args['meta_key'] = 'youtubomatic_parent_rule';
    if($ruleid != '')
    {
        $args['meta_value'] = $ruleid;
    }
	if( $ignore_sticky_posts )
		$args['ignore_sticky_posts'] = true;
	 
	if( $id ) {
		$posts_in = array_map( 'intval', explode( ',', $id ) );
		$args['post__in'] = $posts_in;
	}
	if( is_singular() && $exclude_current )
		$args['post__not_in'] = array( get_the_ID() );
	if( !empty( $author ) ) {
		if( 'current' == $author && is_user_logged_in() )
			$args['author_name'] = wp_get_current_user()->user_login;
		elseif( 'current' == $author )
            $unrelevar = false;
			 
		else
			$args['author_name'] = $author;
	}
	if( !empty( $offset ) )
		$args['offset'] = $offset;
	$post_status = explode( ', ', $post_status );
	$validated = array();
	$available = array( 'publish', 'pending', 'draft', 'auto-draft', 'future', 'private', 'inherit', 'trash', 'any' );
	foreach ( $post_status as $unvalidated )
		if ( in_array( $unvalidated, $available ) )
			$validated[] = $unvalidated;
	if( !empty( $validated ) )
		$args['post_status'] = $validated;
	if ( !empty( $taxonomy ) && !empty( $tax_term ) ) {
		if( 'current' == $tax_term ) {
			global $post;
			$terms = wp_get_post_terms(get_the_ID(), $taxonomy);
			$tax_term = array();
			foreach ($terms as $term) {
				$tax_term[] = $term->slug;
			}
		}else{
			$tax_term = explode( ', ', $tax_term );
		}
		if( !in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) )
			$tax_operator = 'IN';
		$tax_args = array(
			'tax_query' => array(
				array(
					'taxonomy'         => $taxonomy,
					'field'            => 'slug',
					'terms'            => $tax_term,
					'operator'         => $tax_operator,
					'include_children' => $tax_include_children,
				)
			)
		);
		$count = 2;
		$more_tax_queries = false;
		while(
			isset( $original_atts['taxonomy_' . $count] ) && !empty( $original_atts['taxonomy_' . $count] ) &&
			isset( $original_atts['tax_' . esc_html($count) . '_term'] ) && !empty( $original_atts['tax_' . esc_html($count) . '_term'] )
		):
			$more_tax_queries = true;
			$taxonomy = sanitize_key( $original_atts['taxonomy_' . $count] );
	 		$terms = explode( ', ', sanitize_text_field( $original_atts['tax_' . esc_html($count) . '_term'] ) );
	 		$tax_operator = isset( $original_atts['tax_' . esc_html($count) . '_operator'] ) ? $original_atts['tax_' . esc_html($count) . '_operator'] : 'IN';
	 		$tax_operator = in_array( $tax_operator, array( 'IN', 'NOT IN', 'AND' ) ) ? $tax_operator : 'IN';
	 		$tax_include_children = isset( $original_atts['tax_' . esc_html($count) . '_include_children'] ) ? filter_var( $atts['tax_' . esc_html($count) . '_include_children'], FILTER_VALIDATE_BOOLEAN ) : true;
	 		$tax_args['tax_query'][] = array(
	 			'taxonomy'         => $taxonomy,
	 			'field'            => 'slug',
	 			'terms'            => $terms,
	 			'operator'         => $tax_operator,
	 			'include_children' => $tax_include_children,
	 		);
			$count++;
		endwhile;
		if( $more_tax_queries ):
			$tax_relation = 'AND';
			if( isset( $original_atts['tax_relation'] ) && in_array( $original_atts['tax_relation'], array( 'AND', 'OR' ) ) )
				$tax_relation = $original_atts['tax_relation'];
			$args['tax_query']['relation'] = $tax_relation;
		endif;
		$args = array_merge_recursive( $args, $tax_args );
	}
	if( $post_parent !== false ) {
		if( 'current' == $post_parent ) {
			global $post;
			$post_parent = get_the_ID();
		}
		$args['post_parent'] = intval( $post_parent );
	}
	$wrapper_options = array( 'ul', 'ol', 'div' );
	if( ! in_array( $wrapper, $wrapper_options ) )
		$wrapper = 'ul';
	$inner_wrapper = 'div' == $wrapper ? 'div' : 'li';
	$listing = new WP_Query( apply_filters( 'display_posts_shortcode_args', $args, $original_atts ) );
	if ( ! $listing->have_posts() ) {
		return apply_filters( 'display_posts_shortcode_no_results', wpautop( $no_posts_message ) );
	}
	$inner = '';
    wp_suspend_cache_addition(true);
	while ( $listing->have_posts() ): $listing->the_post(); global $post;
		$image = $date = $author = $excerpt = $content = '';
		if ( $include_title && $include_link ) {
            if($link_to_source == 'yes')
            {
                $source_url = get_post_meta($post->ID, 'youtubomatic_post_url', true);
                if($source_url != '')
                {
                    $title = '<a class="youtubomatic_display_title" href="' . esc_url($source_url) . '"><span class="cr_display_span" >' . get_the_title() . '</span></a>';
                }
                else
                {
                    $title = '<a class="youtubomatic_display_title" href="' . apply_filters( 'the_permalink', get_permalink() ) . '"><span class="cr_display_span" >' . get_the_title() . '</span></a>';
                }
            }
            else
            {
                $title = '<a class="youtubomatic_display_title" href="' . apply_filters( 'the_permalink', get_permalink() ) . '"><span class="cr_display_span" >' . get_the_title() . '</span></a>';
            }
		} elseif( $include_title ) {
			$title = '<span class="youtubomatic_display_title" class="cr_display_span">' . get_the_title() . '</span>';
		} else {
			$title = '';
		}
		if ( $image_size && has_post_thumbnail() && $include_link ) {
            if($link_to_source == 'yes')
            {
                $source_url = get_post_meta($post->ID, 'youtubomatic_post_url', true);
                if($source_url != '')
                {
                    $image = '<a class="youtubomatic_display_image" href="' . esc_url($source_url) . '">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a> <br/>';
                }
                else
                {
                    $image = '<a class="youtubomatic_display_image" href="' . get_permalink() . '">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a> <br/>';
                }
            }
            else
            {
                $image = '<a class="youtubomatic_display_image" href="' . get_permalink() . '">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</a> <br/>';
            }
		} elseif( $image_size && has_post_thumbnail() ) {
			$image = '<span class="youtubomatic_display_image">' . get_the_post_thumbnail( get_the_ID(), $image_size ) . '</span> <br/>';
		}
		if ( $include_date )
			$date = ' <span class="date">' . get_the_date( $date_format ) . '</span>';
		if( $include_author )
			$author = apply_filters( 'display_posts_shortcode_author', ' <span class="youtubomatic_display_author">by ' . get_the_author() . '</span>', $original_atts );
		if ( $include_excerpt ) {
			if( $excerpt_length || $excerpt_more || $excerpt_more_link ) {
				$length = $excerpt_length ? $excerpt_length : apply_filters( 'excerpt_length', 55 );
				$more   = $excerpt_more ? $excerpt_more : apply_filters( 'excerpt_more', '' );
				$more   = $excerpt_more_link ? ' <a href="' . get_permalink() . '">' . esc_html($more) . '</a>' : ' ' . esc_html($more);
				if( has_excerpt() && apply_filters( 'display_posts_shortcode_full_manual_excerpt', false ) ) {
					$excerpt = $post->post_excerpt . $more;
				} elseif( has_excerpt() ) {
					$excerpt = wp_trim_words( strip_shortcodes( $post->post_excerpt ), $length, $more );
				} else {
					$excerpt = wp_trim_words( strip_shortcodes( $post->post_content ), $length, $more );
				}
			} else {
				$excerpt = get_the_excerpt();
			}
			$excerpt = ' <br/><br/> <span class="youtubomatic_display_excerpt" class="cr_display_excerpt_adv">' . $excerpt . '</span>';
            if($read_more_text != '')
            {
                if($link_to_source == 'yes')
                {
                    $source_url = get_post_meta($post->ID, 'youtubomatic_post_url', true);
                    if($source_url != '')
                    {
                        $excerpt .= '<br/><a href="' . esc_url($source_url) . '"><span class="youtubomatic_display_excerpt" class="cr_display_excerpt_adv">' . esc_html($read_more_text) . '</span></a>';
                    }
                    else
                    {
                        $excerpt .= '<br/><a href="' . get_permalink() . '"><span class="youtubomatic_display_excerpt" class="cr_display_excerpt_adv">' . esc_html($read_more_text) . '</span></a>';
                    }
                }
                else
                {
                    $excerpt .= '<br/><a href="' . get_permalink() . '"><span class="youtubomatic_display_excerpt" class="cr_display_excerpt_adv">' . esc_html($read_more_text) . '</span></a>';
                }
            }
		}
		if( $include_content ) {
			add_filter( 'shortcode_atts_display-posts', 'youtubomatic_display_posts_off', 10, 3 );
			$content = '<div class="' . implode( ' ', $content_class ) . '">' . apply_filters( 'the_content', get_the_content() ) . '</div>';
			remove_filter( 'shortcode_atts_display-posts', 'youtubomatic_display_posts_off', 10, 3 );
		}
		$category_display_text = '';
		if( $category_display && is_object_in_taxonomy( get_post_type(), $category_display ) ) {
			$terms = get_the_terms( get_the_ID(), $category_display );
			$term_output = array();
			foreach( $terms as $term )
				$term_output[] = '<a href="' . get_term_link( $term, $category_display ) . '">' . esc_html($term->name) . '</a>';
			$category_display_text = ' <span class="category-display"><span class="category-display-label">' . esc_html($category_label) . '</span> ' . trim(implode( ', ', $term_output ), ', ') . '</span>';
			$category_display_text = apply_filters( 'display_posts_shortcode_category_display', $category_display_text );
		}
		$class = array( 'listing-item' );
		$class = array_map( 'sanitize_html_class', apply_filters( 'display_posts_shortcode_post_class', $class, $post, $listing, $original_atts ) );
		$output = '<br/><' . esc_html($inner_wrapper) . ' class="' . implode( ' ', $class ) . '">' . $image . $title . $date . $author . $category_display_text . $excerpt . $content . '</' . esc_html($inner_wrapper) . '><br/><br/><hr class="cr_hr_dot"/>';		$inner .= apply_filters( 'display_posts_shortcode_output', $output, $original_atts, $image, $title, $date, $excerpt, $inner_wrapper, $content, $class );
	endwhile; wp_reset_postdata();
    wp_suspend_cache_addition(false);
	$open = apply_filters( 'display_posts_shortcode_wrapper_open', '<' . $wrapper . $wrapper_class . $wrapper_id . '>', $original_atts );
	$close = apply_filters( 'display_posts_shortcode_wrapper_close', '</' . esc_html($wrapper) . '>', $original_atts );
	$return = $open;
	if( $shortcode_title ) {
		$title_tag = apply_filters( 'display_posts_shortcode_title_tag', 'h2', $original_atts );
		$return .= '<' . esc_html($title_tag) . ' class="display-posts-title">' . esc_html($shortcode_title) . '</' . esc_html($title_tag) . '>' . "\n";
	}
	$return .= $inner . $close;
    $reg_css_code = '.cr_hr_dot{border-top: dotted 1px;}.cr_display_span{font-size:' . esc_html($title_font_size) . ';color:' . esc_html($title_color) . ' !important;}.cr_display_excerpt_adv{font-size:' . esc_html($excerpt_font_size) . ';color:' . esc_html($excerpt_color) . ' !important;}';
    wp_register_style( 'youtubomatic-display-style', false );
    wp_enqueue_style( 'youtubomatic-display-style' );
    wp_add_inline_style( 'youtubomatic-display-style', $reg_css_code );
	return $return;
}
function youtubomatic_sanitize_date_time( $date_time, $type = 'date', $accepts_string = false ) {
	if ( empty( $date_time ) || ! in_array( $type, array( 'date', 'time' ) ) ) {
		return array();
	}
	$segments = array();
	if (
		true === $accepts_string
		&& ( false !== strpos( $date_time, ' ' ) || false === strpos( $date_time, '-' ) )
	) {
		if ( false !== $timestamp = strtotime( $date_time ) ) {
			return $date_time;
		}
	}
	$parts = array_map( 'absint', explode( 'date' == $type ? '-' : ':', $date_time ) );
	if ( 'date' == $type ) {
		$year = $month = $day = 1;
		if ( count( $parts ) >= 3 ) {
			list( $year, $month, $day ) = $parts;
			$year  = ( $year  >= 1 && $year  <= 9999 ) ? $year  : 1;
			$month = ( $month >= 1 && $month <= 12   ) ? $month : 1;
			$day   = ( $day   >= 1 && $day   <= 31   ) ? $day   : 1;
		}
		$segments = array(
			'year'  => $year,
			'month' => $month,
			'day'   => $day
		);
	} elseif ( 'time' == $type ) {
		$hour = $minute = $second = 0;
		switch( count( $parts ) ) {
			case 3 :
				list( $hour, $minute, $second ) = $parts;
				$hour   = ( $hour   >= 0 && $hour   <= 23 ) ? $hour   : 0;
				$minute = ( $minute >= 0 && $minute <= 60 ) ? $minute : 0;
				$second = ( $second >= 0 && $second <= 60 ) ? $second : 0;
				break;
			case 2 :
				list( $hour, $minute ) = $parts;
				$hour   = ( $hour   >= 0 && $hour   <= 23 ) ? $hour   : 0;
				$minute = ( $minute >= 0 && $minute <= 60 ) ? $minute : 0;
				break;
			default : break;
		}
		$segments = array(
			'hour'   => $hour,
			'minute' => $minute,
			'second' => $second
		);
	}

	return apply_filters( 'display_posts_shortcode_sanitized_segments', $segments, $date_time, $type );
}

function youtubomatic_display_posts_off( $out, $pairs, $atts ) {
	$out['display_posts_off'] = apply_filters( 'display_posts_shortcode_inception_override', true );
	return $out;
}
add_shortcode( 'youtubomatic-list-posts', 'youtubomatic_list_posts' );
function youtubomatic_list_posts( $atts ) {
    ob_start();
    extract( shortcode_atts( array (
        'type' => 'any',
        'order' => 'ASC',
        'orderby' => 'title',
        'posts' => 50,
        'posts_per_page' => 50,
        'category' => '',
        'ruleid' => ''
    ), $atts ) );
    $options = array(
        'post_type' => $type,
        'order' => $order,
        'orderby' => $orderby,
        'posts_per_page' => $posts,
        'category_name' => $category,
        'meta_key' => 'youtubomatic_parent_rule',
        'meta_value' => $ruleid
    );
    $query = new WP_Query( $options );
    if ( $query->have_posts() ) { ?>
        <ul class="clothes-listing">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php echo esc_url(get_permalink()); ?>"><?php echo esc_html(get_the_title());?></a>
            </li>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </ul>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
    return '';
}
function youtubomatic_fb_locales()
{
    return array(
        'af_ZA', // Afrikaans
        'ak_GH', // Akan
        'am_ET', // Amharic
        'ar_AR', // Arabic
        'as_IN', // Assamese
        'ay_BO', // Aymara
        'az_AZ', // Azerbaijani
        'be_BY', // Belarusian
        'bg_BG', // Bulgarian
        'bn_IN', // Bengali
        'br_FR', // Breton
        'bs_BA', // Bosnian
        'ca_ES', // Catalan
        'cb_IQ', // Sorani Kurdish
        'ck_US', // Cherokee
        'co_FR', // Corsican
        'cs_CZ', // Czech
        'cx_PH', // Cebuano
        'cy_GB', // Welsh
        'da_DK', // Danish
        'de_DE', // German
        'el_GR', // Greek
        'en_GB', // English (UK)
        'en_IN', // English (India)
        'en_PI', // English (Pirate)
        'en_UD', // English (Upside Down)
        'en_US', // English (US)
        'eo_EO', // Esperanto
        'es_CL', // Spanish (Chile)
        'es_CO', // Spanish (Colombia)
        'es_ES', // Spanish (Spain)
        'es_LA', // Spanish
        'es_MX', // Spanish (Mexico)
        'es_VE', // Spanish (Venezuela)
        'et_EE', // Estonian
        'eu_ES', // Basque
        'fa_IR', // Persian
        'fb_LT', // Leet Speak
        'ff_NG', // Fulah
        'fi_FI', // Finnish
        'fo_FO', // Faroese
        'fr_CA', // French (Canada)
        'fr_FR', // French (France)
        'fy_NL', // Frisian
        'ga_IE', // Irish
        'gl_ES', // Galician
        'gn_PY', // Guarani
        'gu_IN', // Gujarati
        'gx_GR', // Classical Greek
        'ha_NG', // Hausa
        'he_IL', // Hebrew
        'hi_IN', // Hindi
        'hr_HR', // Croatian
        'hu_HU', // Hungarian
        'hy_AM', // Armenian
        'id_ID', // Indonesian
        'ig_NG', // Igbo
        'is_IS', // Icelandic
        'it_IT', // Italian
        'ja_JP', // Japanese
        'ja_KS', // Japanese (Kansai)
        'jv_ID', // Javanese
        'ka_GE', // Georgian
        'kk_KZ', // Kazakh
        'km_KH', // Khmer
        'kn_IN', // Kannada
        'ko_KR', // Korean
        'ku_TR', // Kurdish (Kurmanji)
        'ky_KG', // Kyrgyz
        'la_VA', // Latin
        'lg_UG', // Ganda
        'li_NL', // Limburgish
        'ln_CD', // Lingala
        'lo_LA', // Lao
        'lt_LT', // Lithuanian
        'lv_LV', // Latvian
        'mg_MG', // Malagasy
        'mi_NZ', // Maori
        'mk_MK', // Macedonian
        'ml_IN', // Malayalam
        'mn_MN', // Mongolian
        'mr_IN', // Marathi
        'ms_MY', // Malay
        'mt_MT', // Maltese
        'my_MM', // Burmese
        'nb_NO', // Norwegian (bokmal)
        'nd_ZW', // Ndebele
        'ne_NP', // Nepali
        'nl_BE', // Dutch (Belgi??)
        'nl_NL', // Dutch
        'nn_NO', // Norwegian (nynorsk)
        'ny_MW', // Chewa
        'or_IN', // Oriya
        'pa_IN', // Punjabi
        'pl_PL', // Polish
        'ps_AF', // Pashto
        'pt_BR', // Portuguese (Brazil)
        'pt_PT', // Portuguese (Portugal)
        'qu_PE', // Quechua
        'rm_CH', // Romansh
        'ro_RO', // Romanian
        'ru_RU', // Russian
        'rw_RW', // Kinyarwanda
        'sa_IN', // Sanskrit
        'sc_IT', // Sardinian
        'se_NO', // Northern S??mi
        'si_LK', // Sinhala
        'sk_SK', // Slovak
        'sl_SI', // Slovenian
        'sn_ZW', // Shona
        'so_SO', // Somali
        'sq_AL', // Albanian
        'sr_RS', // Serbian
        'sv_SE', // Swedish
        'sy_SY', // Swahili
        'sw_KE', // Syriac
        'sz_PL', // Silesian
        'ta_IN', // Tamil
        'te_IN', // Telugu
        'tg_TJ', // Tajik
        'th_TH', // Thai
        'tk_TM', // Turkmen
        'tl_PH', // Filipino
        'tl_ST', // Klingon
        'tr_TR', // Turkish
        'tt_RU', // Tatar
        'tz_MA', // Tamazight
        'uk_UA', // Ukrainian
        'ur_PK', // Urdu
        'uz_UZ', // Uzbek
        'vi_VN', // Vietnamese
        'wo_SN', // Wolof
        'xh_ZA', // Xhosa
        'yi_DE', // Yiddish
        'yo_NG', // Yoruba
        'zh_CN', // Simplified Chinese (China)
        'zh_HK', // Traditional Chinese (Hong Kong)
        'zh_TW', // Traditional Chinese (Taiwan)
        'zu_ZA', // Zulu
        'zz_TR' // Zazaki
    );
}
function youtubomatic_language_keys()
{
    return array(
        'af', // Afrikaans
        'ak', // Akan
        'am', // Amharic
        'ar', // Arabic
        'as', // Assamese
        'ay', // Aymara
        'az', // Azerbaijani
        'be', // Belarusian
        'bg', // Bulgarian
        'bn', // Bengali
        'br', // Breton
        'bs', // Bosnian
        'ca', // Catalan
        'cb', // Sorani Kurdish
        'ck', // Cherokee
        'co', // Corsican
        'cs', // Czech
        'cx', // Cebuano
        'cy', // Welsh
        'da', // Danish
        'de', // German
        'el', // Greek
        'en', // English (UK)
        'en', // English (India)
        'en', // English (Pirate)
        'en', // English (Upside Down)
        'en', // English (US)
        'eo', // Esperanto
        'es', // Spanish (Chile)
        'es', // Spanish (Colombia)
        'es', // Spanish (Spain)
        'es', // Spanish
        'es', // Spanish (Mexico)
        'es', // Spanish (Venezuela)
        'et', // Estonian
        'eu', // Basque
        'fa', // Persian
        'fb', // Leet Speak
        'ff', // Fulah
        'fi', // Finnish
        'fo', // Faroese
        'fr', // French (Canada)
        'fr', // French (France)
        'fy', // Frisian
        'ga', // Irish
        'gl', // Galician
        'gn', // Guarani
        'gu', // Gujarati
        'gx', // Classical Greek
        'ha', // Hausa
        'he', // Hebrew
        'hi', // Hindi
        'hr', // Croatian
        'hu', // Hungarian
        'hy', // Armenian
        'id', // Indonesian
        'ig', // Igbo
        'is', // Icelandic
        'it', // Italian
        'ja', // Japanese
        'ja', // Japanese (Kansai)
        'jv', // Javanese
        'ka', // Georgian
        'kk', // Kazakh
        'km', // Khmer
        'kn', // Kannada
        'ko', // Korean
        'ku', // Kurdish (Kurmanji)
        'ky', // Kyrgyz
        'la', // Latin
        'lg', // Ganda
        'li', // Limburgish
        'ln', // Lingala
        'lo', // Lao
        'lt', // Lithuanian
        'lv', // Latvian
        'mg', // Malagasy
        'mi', // Maori
        'mk', // Macedonian
        'ml', // Malayalam
        'mn', // Mongolian
        'mr', // Marathi
        'ms', // Malay
        'mt', // Maltese
        'my', // Burmese
        'nb', // Norwegian (bokmal)
        'nd', // Ndebele
        'ne', // Nepali
        'nl', // Dutch (Belgi??)
        'nl', // Dutch
        'nn', // Norwegian (nynorsk)
        'ny', // Chewa
        'or', // Oriya
        'pa', // Punjabi
        'pl', // Polish
        'ps', // Pashto
        'pt', // Portuguese (Brazil)
        'pt', // Portuguese (Portugal)
        'qu', // Quechua
        'rm', // Romansh
        'ro', // Romanian
        'ru', // Russian
        'rw', // Kinyarwanda
        'sa', // Sanskrit
        'sc', // Sardinian
        'se', // Northern S??mi
        'si', // Sinhala
        'sk', // Slovak
        'sl', // Slovenian
        'sn', // Shona
        'so', // Somali
        'sq', // Albanian
        'sr', // Serbian
        'sv', // Swedish
        'sy', // Swahili
        'sw', // Syriac
        'sz', // Silesian
        'ta', // Tamil
        'te', // Telugu
        'tg', // Tajik
        'th', // Thai
        'tk', // Turkmen
        'tl', // Filipino
        'tl', // Klingon
        'tr', // Turkish
        'tt', // Tatar
        'tz', // Tamazight
        'uk', // Ukrainian
        'ur', // Urdu
        'uz', // Uzbek
        'vi', // Vietnamese
        'wo', // Wolof
        'xh', // Xhosa
        'yi', // Yiddish
        'yo', // Yoruba
        'zh', // Simplified Chinese (China)
        'zh', // Traditional Chinese (Hong Kong)
        'zh', // Traditional Chinese (Taiwan)
        'zu', // Zulu
        'zz' // Zazaki
    );
    
}
function youtubomatic_builtin_spin_text($title, $content)
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    $titleSeparator         = '[19459000]';
    $text                   = $title . $titleSeparator . $content;
    $text                   = html_entity_decode($text);
    preg_match_all("/<[^<>]+>/is", $text, $matches, PREG_PATTERN_ORDER);
    $htmlfounds         = array_filter(array_unique($matches[0]));
    $htmlfounds[]       = '&quot;';
    $imgFoundsSeparated = array();
    foreach ($htmlfounds as $key => $currentFound) {
        if (stristr($currentFound, '<img') && stristr($currentFound, 'alt')) {
            $altSeparator   = '';
            $colonSeparator = '';
            if (stristr($currentFound, 'alt="')) {
                $altSeparator   = 'alt="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt = "')) {
                $altSeparator   = 'alt = "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt ="')) {
                $altSeparator   = 'alt ="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt= "')) {
                $altSeparator   = 'alt= "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt=\'')) {
                $altSeparator   = 'alt=\'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt = \'')) {
                $altSeparator   = 'alt = \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt= \'')) {
                $altSeparator   = 'alt= \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt =\'')) {
                $altSeparator   = 'alt =\'';
                $colonSeparator = '\'';
            }
            if (trim($altSeparator) != '') {
                $currentFoundParts = explode($altSeparator, $currentFound);
                $preAlt            = $currentFoundParts[1];
                $preAltParts       = explode($colonSeparator, $preAlt);
                $altText           = $preAltParts[0];
                if (trim($altText) != '') {
                    unset($preAltParts[0]);
                    $imgFoundsSeparated[] = $currentFoundParts[0] . $altSeparator;
                    $imgFoundsSeparated[] = $colonSeparator . implode('', $preAltParts);
                    $htmlfounds[$key]     = '';
                }
            }
        }
    }
    if (count($imgFoundsSeparated) != 0) {
        $htmlfounds = array_merge($htmlfounds, $imgFoundsSeparated);
    }
    preg_match_all("/<\!--.*?-->/is", $text, $matches2, PREG_PATTERN_ORDER);
    $newhtmlfounds = $matches2[0];
    preg_match_all("/\[.*?\]/is", $text, $matches3, PREG_PATTERN_ORDER);
    $shortcodesfounds = $matches3[0];
    $htmlfounds       = array_merge($htmlfounds, $newhtmlfounds, $shortcodesfounds);
    $in               = 0;
    $cleanHtmlFounds  = array();
    foreach ($htmlfounds as $htmlfound) {
        if ($htmlfound == '[19459000]') {
        } elseif (trim($htmlfound) == '') {
        } else {
            $cleanHtmlFounds[] = $htmlfound;
        }
    }
    $htmlfounds = $cleanHtmlFounds;
    $start      = 19459001;
    foreach ($htmlfounds as $htmlfound) {
        $text = str_replace($htmlfound, '[' . $start . ']', $text);
        $start++;
    }
    try {
        $file=file(dirname(__FILE__)  .'/res/synonyms.dat');
		foreach($file as $line){
			$synonyms=explode('|',$line);
			foreach($synonyms as $word){
				if(trim($word) != ''){
                    $word=str_replace('/','\/',$word);
					if(preg_match('/\b'. $word .'\b/u', $text)) {
						$rand = array_rand($synonyms, 1);
						$text = preg_replace('/\b'.$word.'\b/u', trim($synonyms[$rand]), $text);
					}
                    $uword=ucfirst($word);
					if(preg_match('/\b'. $uword .'\b/u', $text)) {
						$rand = array_rand($synonyms, 1);
						$text = preg_replace('/\b'.$uword.'\b/u', ucfirst(trim($synonyms[$rand])), $text);
					}
				}
			}
		}
        $translated = $text;
    }
    catch (Exception $e) {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('Exception thrown in spinText ' . $e->getMessage());
        }
        return false;
    }
    preg_match_all('{\[.*?\]}', $translated, $brackets);
    $brackets = $brackets[0];
    $brackets = array_unique($brackets);
    foreach ($brackets as $bracket) {
        if (stristr($bracket, '19')) {
            $corrrect_bracket = str_replace(' ', '', $bracket);
            $corrrect_bracket = str_replace('.', '', $corrrect_bracket);
            $corrrect_bracket = str_replace(',', '', $corrrect_bracket);
            $translated       = str_replace($bracket, $corrrect_bracket, $translated);
        }
    }
    if (stristr($translated, $titleSeparator)) {
        $start = 19459001;
        foreach ($htmlfounds as $htmlfound) {
            $translated = str_replace('[' . $start . ']', $htmlfound, $translated);
            $start++;
        }
        $contents = explode($titleSeparator, $translated);
        $title    = $contents[0];
        $content  = $contents[1];
    } else {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('Failed to parse spinned content, separator not found');
        }
        return false;
    }
    return array(
        $title,
        $content
    );
}

function youtubomatic_cron_schedule()
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] === 'on') {
        if (!wp_next_scheduled('youtubomaticaction')) {
            $unlocker = get_option('youtubomatic_minute_running_unlocked', false);
            if($unlocker == '1')
            {
                $rez = wp_schedule_event(time(), 'minutely', 'youtubomaticaction');
            }
            else
            {
                $rez = wp_schedule_event(time(), 'hourly', 'youtubomaticaction');
            }
            if ($rez === FALSE) {
                youtubomatic_log_to_file('[Scheduler] Failed to schedule youtubomaticaction to youtubomatic_cron!');
            }
        }
        
        if (isset($youtubomatic_Main_Settings['enable_logging']) && $youtubomatic_Main_Settings['enable_logging'] === 'on' && isset($youtubomatic_Main_Settings['auto_clear_logs']) && $youtubomatic_Main_Settings['auto_clear_logs'] !== 'No') {
            if (!wp_next_scheduled('youtubomaticactionclear')) {
                $rez = wp_schedule_event(time(), $youtubomatic_Main_Settings['auto_clear_logs'], 'youtubomaticactionclear');
                if ($rez === FALSE) {
                    youtubomatic_log_to_file('[Scheduler] Failed to schedule youtubomaticactionclear to ' . $youtubomatic_Main_Settings['auto_clear_logs'] . '!');
                }
                add_option('youtubomatic_schedule_time', $youtubomatic_Main_Settings['auto_clear_logs']);
            } else {
                if (!get_option('youtubomatic_schedule_time')) {
                    wp_clear_scheduled_hook('youtubomaticactionclear');
                    $rez = wp_schedule_event(time(), $youtubomatic_Main_Settings['auto_clear_logs'], 'youtubomaticactionclear');
                    add_option('youtubomatic_schedule_time', $youtubomatic_Main_Settings['auto_clear_logs']);
                    if ($rez === FALSE) {
                        youtubomatic_log_to_file('[Scheduler] Failed to schedule youtubomaticactionclear to ' . $youtubomatic_Main_Settings['auto_clear_logs'] . '!');
                    }
                } else {
                    $the_time = get_option('youtubomatic_schedule_time');
                    if ($the_time != $youtubomatic_Main_Settings['auto_clear_logs']) {
                        wp_clear_scheduled_hook('youtubomaticactionclear');
                        delete_option('youtubomatic_schedule_time');
                        $rez = wp_schedule_event(time(), $youtubomatic_Main_Settings['auto_clear_logs'], 'youtubomaticactionclear');
                        add_option('youtubomatic_schedule_time', $youtubomatic_Main_Settings['auto_clear_logs']);
                        if ($rez === FALSE) {
                            youtubomatic_log_to_file('[Scheduler] Failed to schedule youtubomaticactionclear to ' . $youtubomatic_Main_Settings['auto_clear_logs'] . '!');
                        }
                    }
                }
            }
        } else {
            if (!wp_next_scheduled('youtubomaticactionclear')) {
                delete_option('youtubomatic_schedule_time');
            } else {
                wp_clear_scheduled_hook('youtubomaticactionclear');
                delete_option('youtubomatic_schedule_time');
            }
        }
    } else {
        if (wp_next_scheduled('youtubomaticaction')) {
            wp_clear_scheduled_hook('youtubomaticaction');
        }
        
        if (!wp_next_scheduled('youtubomaticactionclear')) {
            delete_option('youtubomatic_schedule_time');
        } else {
            wp_clear_scheduled_hook('youtubomaticactionclear');
            delete_option('youtubomatic_schedule_time');
        }
    }
}
function youtubomatic_cron()
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    $GLOBALS['wp_object_cache']->delete('youtubomatic_rules_list', 'options');
    if (!get_option('youtubomatic_rules_list')) {
        $rules = array();
    } else {
        $rules = get_option('youtubomatic_rules_list');
    }
    $unlocker = get_option('youtubomatic_minute_running_unlocked', false);
    $rule_run = false;
    if (!empty($rules)) {
        $cont = 0;
        foreach ($rules as $request => $bundle[]) {
            $bundle_values   = array_values($bundle);
            $myValues        = $bundle_values[$cont];
            $array_my_values = array_values($myValues);for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}}
            $schedule        = isset($array_my_values[1]) ? $array_my_values[1] : '24';
            $active          = isset($array_my_values[2]) ? $array_my_values[2] : '0';
            $last_run        = isset($array_my_values[3]) ? $array_my_values[3] : youtubomatic_get_date_now();
            if ($active == '1') {
                $now                = youtubomatic_get_date_now();
                if($unlocker == '1')
                {
                    $nextrun            = youtubomatic_add_minute($last_run, $schedule);
                    $youtubomatic_hour_diff = (int) youtubomatic_minute_diff($now, $nextrun);
                }
                else
                {
                    $nextrun            = youtubomatic_add_hour($last_run, $schedule);
                    $youtubomatic_hour_diff = (int) youtubomatic_hour_diff($now, $nextrun);
                }
                if ($youtubomatic_hour_diff >= 0) {
                    if($rule_run === false)
                    {
                        $rule_run = true;
                    }
                    else
                    {
                        if (isset($youtubomatic_Main_Settings['rule_delay']) && $youtubomatic_Main_Settings['rule_delay'] !== '')
                        {
                           sleep($youtubomatic_Main_Settings['rule_delay']);
                        }
                    }
                    youtubomatic_run_rule($cont);
                }
            }
            $cont = $cont + 1;
        }
    }
    $running = array();
    update_option('youtubomatic_running_list', $running);
}

function youtubomatic_extractKeyWords($string, $count = 10)
{
    $stopwords = array();
    $string = trim(preg_replace('/\s\s+/iu', '\s', strtolower($string)));
    $string = wp_strip_all_tags($string);
    $matchWords   = array_filter(explode(' ', $string), function($item) use ($stopwords)
    {
        return !($item == '' || in_array($item, $stopwords) || strlen($item) <= 2 || ctype_alnum(trim(str_replace(' ', '', $item))) === FALSE || is_numeric($item));
    });
    $wordCountArr = array_count_values($matchWords);
    arsort($wordCountArr);
    return array_keys(array_slice($wordCountArr, 0, $count));
}

function youtubomatic_log_to_file($str)
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['enable_logging']) && $youtubomatic_Main_Settings['enable_logging'] == 'on') {
        $d = date("j-M-Y H:i:s e", current_time( 'timestamp' ));
        error_log("[$d] " . $str . "<br/>\r\n", 3, WP_CONTENT_DIR . '/youtubomatic_info.log');
    }
}
function youtubomatic_delete_all_posts()
{
    $failed                 = false;
    $number                 = 0;
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    $post_list = array();
    $postsPerPage = 50000;
    $paged = 0;
    do
    {
        $postOffset = $paged * $postsPerPage;
        $query = array(
            'post_status' => array(
                'publish',
                'draft',
                'pending',
                'trash',
                'private',
                'future'
            ),
            'post_type' => array(
                'any'
            ),
            'numberposts' => $postsPerPage,
            'meta_key' => 'youtubomatic_parent_rule',
            'fields' => 'ids',
            'offset'  => $postOffset
        );
        $got_me = get_posts($query);
        $post_list = array_merge($post_list, $got_me);
        $paged++;
    }while(!empty($got_me));
    wp_suspend_cache_addition(true);
    foreach ($post_list as $post) {
        $index = get_post_meta($post, 'youtubomatic_parent_rule', true);
        if (isset($index) && $index !== '') {
            $args             = array(
                'post_parent' => $post
            );
            $post_attachments = get_children($args);
            if (isset($post_attachments) && !empty($post_attachments)) {
                foreach ($post_attachments as $attachment) {
                    wp_delete_attachment($attachment->ID, true);
                }
            }
            $res = wp_delete_post($post, true);
            if ($res === false) {
                $failed = true;
            } else {
                $number++;
            }
        }
    }
    wp_suspend_cache_addition(false);
    if ($failed === true) {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('[PostDelete] Failed to delete all posts!');
        }
    } else {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('[PostDelete] Successfuly deleted ' . esc_html($number) . ' posts!');
        }
    }
}
function youtubomatic_replaceContentShortcodesAgain($the_content, $item_cat, $item_tags)
{
    $the_content = str_replace('%%item_cat%%', $item_cat, $the_content);
    $the_content = str_replace('%%item_tags%%', $item_tags, $the_content);
    return $the_content;
}
function youtubomatic_replaceContentShortcodes($the_content, $just_title, $content, $video_url, $url, $item_image, $description, $author, $author_link, $id, $channelId, $video_duration, $video_views, $video_likeCount, $video_dislikeCount, $video_rating, $youtubeVideo, $video_dimension, $video_definition, $video_caption , $video_licensed_content, $video_projection, $video_favorite_count, $video_comment_count, $categoryId, $defaultAudioLanguage, $returned_caption, $img_attr, $screenimageURL = '')
{
    $matches = array();
    $i = 0;
    preg_match_all('~%regex\(\s*\"([^"]+?)\s*"\s*,\s*\"([^"]*)\"\s*(?:,\s*\"([^"]*?)\s*\")?(?:,\s*\"([^"]*?)\s*\")?\)%~si', $the_content, $matches);
    if (is_array($matches) && count($matches) && is_array($matches[0])) {
        for($i = 0; $i < count($matches[0]); $i++)
        {
            if (isset($matches[0][$i])) $fullmatch = $matches[0][$i];
            if (isset($matches[1][$i])) $search_in = youtubomatic_replaceContentShortcodes($matches[1][$i], $just_title, $content, $video_url, $url, $item_image, $description, $author, $author_link, $id, $channelId, $video_duration, $video_views, $video_likeCount, $video_dislikeCount, $video_rating, $youtubeVideo, $video_dimension, $video_definition, $video_caption , $video_licensed_content, $video_projection, $video_favorite_count, $video_comment_count, $categoryId, $defaultAudioLanguage, $returned_caption, $img_attr, $screenimageURL = '');
            if (isset($matches[2][$i])) $matchpattern = $matches[2][$i];
            if (isset($matches[3][$i])) $element = $matches[3][$i];
            if (isset($matches[4][$i])) $delimeter = $matches[4][$i];
            if (isset($matchpattern)) {
               if (preg_match('~^\/[^/]*\/$~', $matchpattern, $z)) {
                  $ret = preg_match_all($matchpattern, $search_in, $submatches, PREG_PATTERN_ORDER);
               }
               else {
                  $ret = preg_match_all('~'.$matchpattern.'~si', $search_in, $submatches, PREG_PATTERN_ORDER);
               }
            }
            if (isset($submatches)) {
               if (is_array($submatches)) {
                  $empty_elements = array_keys($submatches[0], "");
                  foreach ($empty_elements as $e) {
                     unset($submatches[0][$e]);
                  }
                  $submatches[0] = array_unique($submatches[0]);
                  if (!is_numeric($element)) {
                     $element = 0;
                  }
                  $matched = $submatches[(int)($element)];
                  $matched = array_unique((array)$matched);
                  if (empty($delimeter)) {
                     if (isset($matched[0])) $matched = $matched[0];
                  }
                  else {
                     $matched = implode($matched, $delimeter);
                  }
                  if (empty($matched)) {
                     $the_content = str_replace($fullmatch, '', $the_content);
                  } else {
                     $the_content = str_replace($fullmatch, $matched, $the_content);
                  }
               }
            }
        }
    }
    $spintax = new Youtubomatic_Spintax();
    $the_content = $spintax->process($the_content);
    $pcxxx = explode('<!- template ->', $the_content);
    $the_content = $pcxxx[array_rand($pcxxx)];
    $the_content = str_replace('%%random_sentence%%', youtubomatic_random_sentence_generator(), $the_content);
    $the_content = str_replace('%%random_sentence2%%', youtubomatic_random_sentence_generator(false), $the_content);
    $the_content = youtubomatic_replaceSynergyShortcodes($the_content);
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['custom_html'])) {
        $xspintax = $youtubomatic_Main_Settings['custom_html'];
        $spintaxx = new Youtubomatic_Spintax();
        $xspintax = $spintaxx->process($xspintax);
        $the_content = str_replace('%%custom_html%%', $xspintax, $the_content);
    }
    if (isset($youtubomatic_Main_Settings['custom_html2'])) {
        $xspintax2 = $youtubomatic_Main_Settings['custom_html2'];
        $spintaxy = new Youtubomatic_Spintax();
        $xspintax2 = $spintaxy->process($xspintax2);
        $the_content = str_replace('%%custom_html2%%', $xspintax2, $the_content);
    }
    $img_attr = str_replace('%%image_source_name%%', '', $img_attr);
    $img_attr = str_replace('%%image_source_url%%', '', $img_attr);
    $img_attr = str_replace('%%image_source_website%%', '', $img_attr);
    $the_content = str_replace('%%royalty_free_image_attribution%%', $img_attr, $the_content);
    $the_content = str_replace('%%video_title%%', $just_title, $the_content);
    $the_content = str_replace('%%video_title_encoded%%', urlencode($just_title), $the_content);
    $the_content = str_replace('%%video_id%%', $id, $the_content);
    $the_content = str_replace('%%video_description%%', $content, $the_content);
    $the_content = str_replace('%%video_url%%', $video_url, $the_content);
    $the_content = str_replace('%%video_url_unshortened%%', $url, $the_content);
    $the_content = str_replace('%%video_description_plain_text%%', youtubomatic_getPlainContent($content), $the_content);
    $the_content = str_replace('%%video_read_more_button%%', youtubomatic_getReadMoreButton($video_url), $the_content);
    $the_content = str_replace('%%video_show_image%%', youtubomatic_getItemImage($item_image, $just_title), $the_content);
    $the_content = str_replace('%%video_category_id%%', $categoryId, $the_content);
    $the_content = str_replace('%%video_audio_language%%', $defaultAudioLanguage, $the_content);
    $the_content = str_replace('%%video_image_URL%%', $item_image, $the_content);
    $the_content = str_replace('%%video_excerpt%%', $description, $the_content);
    $the_content = str_replace('%%author%%', $author, $the_content);
    $the_content = str_replace('%%channel_name%%', $author, $the_content);
    $the_content = str_replace('%%youtube_video%%', $youtubeVideo, $the_content);
    $the_content = str_replace('%%author_link%%', $author_link, $the_content);
    if($screenimageURL != '')
    {
        $the_content = str_replace('%%item_screenshot_url%%', esc_url($screenimageURL), $the_content);
        $the_content = str_replace('%%item_show_screenshot%%', youtubomatic_getItemImage(esc_url($screenimageURL), $just_title), $the_content);
    }
    else
    {
        $snap = 'http://s.wordpress.com/mshots/v1/';
        if (isset($youtubomatic_Main_Settings['screenshot_height']) && $youtubomatic_Main_Settings['screenshot_height'] != '') 
        {
            $h = esc_attr($youtubomatic_Main_Settings['screenshot_height']);
        }
        else
        {
            $h = '450';
        }
        if (isset($youtubomatic_Main_Settings['screenshot_width']) && $youtubomatic_Main_Settings['screenshot_width'] != '') 
        {
            $w = esc_attr($youtubomatic_Main_Settings['screenshot_width']);
        }
        else
        {
            $w = '600';
        }
        $the_content = str_replace('%%item_screenshot_url%%', esc_url($snap . urlencode($url) . '?w=' . $w . '&h=' . $h), $the_content);
        $the_content = str_replace('%%item_show_screenshot%%', youtubomatic_getItemImage(esc_url($snap . urlencode($url) . '?w=' . $w . '&h=' . $h), $just_title), $the_content);
    }
    $the_content = str_replace('%%video_duration%%', $video_duration, $the_content);
    $the_content = str_replace('%%author_id%%', $channelId, $the_content);
    $the_content = str_replace('%%video_views%%', $video_views, $the_content);
    $the_content = str_replace('%%video_like_count%%', $video_likeCount, $the_content);
    $the_content = str_replace('%%video_dislike_count%%', $video_dislikeCount, $the_content);
    $the_content = str_replace('%%video_rating%%', $video_rating, $the_content);
    $the_content = str_replace('%%video_dimension%%', $video_dimension, $the_content);
    $the_content = str_replace('%%video_definition%%', $video_definition, $the_content);
    $the_content = str_replace('%%video_has_caption%%', $video_caption, $the_content);
    $the_content = str_replace('%%video_licensed_content%%', $video_licensed_content, $the_content);
    $the_content = str_replace('%%video_projection%%', $video_projection, $the_content);
    $the_content = str_replace('%%video_favorite_count%%', $video_favorite_count, $the_content);
    $the_content = str_replace('%%video_comment_count%%', $video_comment_count, $the_content);
    $the_content = str_replace('%%video_caption%%', $returned_caption, $the_content);
    if (isset($youtubomatic_Main_Settings['channel_name']) && $youtubomatic_Main_Settings['channel_name'] != '') {
        if (isset($youtubomatic_Main_Settings['channel_layout'])) {
            $channel_layout = $youtubomatic_Main_Settings['channel_layout'];
        }
        else
        {
            $channel_layout = 'default';
        }
        if (isset($youtubomatic_Main_Settings['channel_theme'])) {
            $channel_theme = $youtubomatic_Main_Settings['channel_theme'];
        }
        else
        {
            $channel_theme = 'default';
        }
        $like_code = '<div class="g-ytsubscribe" data-channel="'.esc_attr($youtubomatic_Main_Settings['channel_name']).'" data-layout="'.esc_attr($channel_layout).'" ';
        if($channel_theme == 'dark')
        {
            $like_code .= 'data-theme="dark"';
        }
        $like_code .= 'data-count="default"></div>';
    }
    else
    {
        $$like_code = '';
    }
    
    $the_content = str_replace('%%youtube_subscribe_button%%', $like_code, $the_content);
    return $the_content;
}
function youtubomatic_breakLongText($text, $length = 200, $maxLength = 300){
    $textLength = strlen($text);
    $splitText = array();
    if (!($textLength > $maxLength)){
        return $text;
    }
    $needle = '.'; 
    while (strlen($text) > $length)
    {
        $end = strpos($text, $needle, $length);
        if ($end === false)
        {
            $splitText[] = substr($text,0);
            $text = '';
            break;
        }
        $end++;
        $splitText[] = substr($text,0,$end);
        $text = substr_replace($text,'',0,$end);
    }
    if ($text)
    {
        $splitText[] = substr($text,0);
    }
    $rettext = '';
    foreach($splitText as $spt)
    {
         $rettext .= '<p>' . $spt . '</p>';
    }
    return $rettext;
}
add_action('wp_ajax_youtubomatic_my_action', 'youtubomatic_my_action_callback');
function youtubomatic_my_action_callback()
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['rule_timeout']) && $youtubomatic_Main_Settings['rule_timeout'] != '') {
        $timeout = intval($youtubomatic_Main_Settings['rule_timeout']);
    } else {
        $timeout = 3600;
    }
    ini_set('safe_mode', 'Off');
    ini_set('max_execution_time', $timeout);
    ini_set('ignore_user_abort', 1);
    ini_set('user_agent', youtubomatic_get_random_user_agent());
    ignore_user_abort(true);
    set_time_limit($timeout);
    $failed                 = false;
    $del_id                 = $_POST['id'];
    $how                    = $_POST['how'];
    if($how == 'duplicate')
    {
        $GLOBALS['wp_object_cache']->delete('youtubomatic_rules_list', 'options');
        if (!get_option('youtubomatic_rules_list')) {
            $rules = array();
        } else {
            $rules = get_option('youtubomatic_rules_list');
        }
        if (!empty($rules)) {
            $found            = 0;
            $cont = 0;
            foreach ($rules as $request => $bundle[]) {
                if ($cont == $del_id) {
                    $copy_bundle = $rules[$request];
                    $rules[] = $copy_bundle;
                    $found   = 1;
                    break;
                }
                $cont = $cont + 1;
            }
            if($found == 0)
            {
                youtubomatic_log_to_file('youtubomatic_rules_list index not found: ' . $del_id);
                echo 'nochange';
                die();
            }
            else
            {
                update_option('youtubomatic_rules_list', $rules, false);
                echo 'ok';
                die();
            }
        } else {
            youtubomatic_log_to_file('youtubomatic_rules_list empty!');
            echo 'nochange';
            die();
        }
        
    }
    $force_delete           = true;
    $number                 = 0;
    if ($how == 'trash') {
        $force_delete = false;
    }
    $post_list = array();
    $postsPerPage = 50000;
    $paged = 0;
    do
    {
        $postOffset = $paged * $postsPerPage;
        $query = array(
            'post_status' => array(
                'publish',
                'draft',
                'pending',
                'trash',
                'private',
                'future'
            ),
            'post_type' => array(
                'any'
            ),
            'numberposts' => $postsPerPage,
            'meta_key' => 'youtubomatic_parent_rule',
            'fields' => 'ids',
            'offset'  => $postOffset
        );
        $got_me = get_posts($query);
        $post_list = array_merge($post_list, $got_me);
        $paged++;
    }while(!empty($got_me));
    wp_suspend_cache_addition(true);
    foreach ($post_list as $post) {
        $index = get_post_meta($post, 'youtubomatic_parent_rule', true);
        if ($index == $del_id) {
            $args             = array(
                'post_parent' => $post
            );
            $post_attachments = get_children($args);
            if (isset($post_attachments) && !empty($post_attachments)) {
                foreach ($post_attachments as $attachment) {
                    wp_delete_attachment($attachment->ID, true);
                }
            }
            $res = wp_delete_post($post, $force_delete);
            if ($res === false) {
                $failed = true;
            } else {
                $number++;
            }
        }
    }
    wp_suspend_cache_addition(false);
    if ($failed === true) {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('[PostDelete] Failed to delete all posts for rule id: ' . esc_html($del_id) . '!');
        }
        echo 'failed';
    } else {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('[PostDelete] Successfuly deleted ' . esc_html($number) . ' posts for rule id: ' . esc_html($del_id) . '!');
        }
        if ($number == 0) {
            echo 'nochange';
        } else {
            echo 'ok';
        }
    }
    die();
}
add_action('wp_ajax_youtubomatic_run_my_action', 'youtubomatic_run_my_action_callback');
function youtubomatic_run_my_action_callback()
{
    $run_id = $_POST['id'];
    echo youtubomatic_run_rule($run_id, 0);
    die();
}

function youtubomatic_clearFromList($param)
{
    $GLOBALS['wp_object_cache']->delete('youtubomatic_running_list', 'options');
    $running = get_option('youtubomatic_running_list');
    $key     = array_search($param, $running);
    if ($key !== FALSE) {
        unset($running[$key]);
        update_option('youtubomatic_running_list', $running);
    }
}
add_shortcode("youtubomatic_playlist", "youtubomatic_playlist");
function youtubomatic_playlist($atts)
{
    $id = isset( $atts['id'] )? esc_attr($atts['id']) : '';
    if($id == '')
    {
        return '';
    }
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') {
        if (isset($youtubomatic_Main_Settings['player_width']) && $youtubomatic_Main_Settings['player_width'] !== '') {
            $width = esc_attr($youtubomatic_Main_Settings['player_width']);
        }
        else
        {
            $width = 580;
        }
        if (isset($youtubomatic_Main_Settings['player_height']) && $youtubomatic_Main_Settings['player_height'] !== '') {
            $height = esc_attr($youtubomatic_Main_Settings['player_height']);
        }
        else
        {
            $height = 380;
        }
        if (isset($youtubomatic_Main_Settings['player_style']) && $youtubomatic_Main_Settings['player_style'] !== '' && $youtubomatic_Main_Settings['player_style'] !== '0') {
            if($youtubomatic_Main_Settings['player_style'] == '1')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg youtubomatic_wh"><iframe align="center" width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/videoseries?list='. $id . '&ecver=1" frameborder="0" allowfullscreen></iframe></div>';
            }
            elseif($youtubomatic_Main_Settings['player_style'] == '2')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg2 youtubomatic_wh"><iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/videoseries?list='. $id . '&ecver=1" frameborder="0" allowfullscreen></iframe></div>';
            }
            elseif($youtubomatic_Main_Settings['player_style'] == '3')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg3 youtubomatic_wh"><iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/videoseries?list='. $id . '&ecver=1" frameborder="0" allowfullscreen></iframe></div>';
            }
        }
        else
        {
            $youtubeVideo = '<div class="youtubomatic-video-container"><iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/videoseries?list='. $id . '&ecver=1" frameborder="0" allowfullscreen></iframe></div>';
        }
        return $youtubeVideo;
    }
    else
    {
        return '';
    }
}
add_shortcode("youtubomatic_grid", "youtubomatic_grid");
function youtubomatic_grid($atts)
{
    $direct_link = isset( $atts['direct_link'] )? esc_attr($atts['direct_link']) : 0;
    $max = isset( $atts['max'] )? esc_attr($atts['max']) : 9;
    $grids = isset( $atts['per_row'] )? esc_attr($atts['per_row']) : 3;
    $width = isset( $atts['width'] )? esc_attr($atts['width']) : 200;
    $height = isset( $atts['height'] )? esc_attr($atts['height']) : 200;
    $list_all = isset( $atts['list_all'] )? esc_attr($atts['list_all']) : 0;
    $titlelength = isset( $atts['title_length'] )? esc_attr($atts['title_length']) : 20;
    if(!is_numeric($direct_link) || !is_numeric($max) || !is_numeric($grids) || !is_numeric($width) || !is_numeric($height) || !is_numeric($list_all) || !is_numeric($titlelength))
    {
        return '';
    }
    else
    {
        $direct_link = intval($direct_link);
        $max = intval($max);
        $grids = intval ($grids);
        $width = intval ($width);
        $height = intval ($height);
        $list_all = intval ($list_all);
        $titlelength = intval ($titlelength);
    }
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') {
        $grid_css = '.gridcontainer h2 a{color: #333; font-size: 13px;}
.gridcontainer .griditemleft{float: left; width: '.$width.'px; margin: 0 30px 20px 0;}
.gridcontainer .griditemright{float: left; width: '.$width.'px;}
.gridcontainer .postimage{margin: 0 0 5px 0;}
.gridcontainer .postimage-title {text-align: center;}';
        $grid_css = wp_strip_all_tags($grid_css);
        wp_register_style( 'youtubomatic-grid-style', false );
        wp_enqueue_style( 'youtubomatic-grid-style' );
        wp_add_inline_style( 'youtubomatic-grid-style', $grid_css );
$grid = '<div class="gridcontainer">';
        $counter = 1; 
        $total_counter = 1;
        if($list_all == 1)
        {
            $args=array (
            'post_type' => get_post_types('', 'names'),
            'posts_per_page' => 50,
            'post_status' => 'publish'
            );
        }
        else
        {
            $args=array (
            'post_type' => get_post_types('', 'names'),
            'posts_per_page' => 50,
            'meta_key' => 'youtubomatic_parent_rule',
            'post_status' => 'publish'
            );
        }
        $the_query = new WP_Query($args);
        while ( $the_query->have_posts() )
        {
            $the_query->the_post();
            if($total_counter > $max)
            {
                break;
            }
            if($direct_link == 1)
            {
                $pt_link = get_post_meta(get_the_ID(), 'youtubomatic_post_url', true);
                if(empty($pt_link))
                {
                    $pt_link = get_permalink();
                }
            }
            else
            {
                $pt_link = get_permalink();
            }
            if($counter != $grids)
            {
                $grid .= '<div class="griditemleft">
        <div class="postimage">';
            $thumb = esc_url(get_the_post_thumbnail_url());
            if($thumb != '')
            {
                $grid .= '<a href="' . esc_url($pt_link) . '" title="grid"><img src="' . $thumb .'" alt="thumb" width="'.$width.'" height="'.$height.'"/></a>';
            }
            
            $grid .= '</div>
        <h2 class="postimage-title">
            <a href="' . esc_url($pt_link) . '" title="grid">';
            if (strlen(the_title($before = '', $after = '', FALSE)) > $titlelength)
            { 
                $grid .=  substr(the_title($before = '', $after = '', FALSE), 0, $titlelength) . ' ...'; 
            }
            else 
            { 
                $grid .= the_title($before = '', $after = '', FALSE); 
            }
            $grid .= '</a>
        </h2>
    </div>';
            }
            elseif($counter == $grids)
            {
                $grid .= '<div class="griditemright">
        <div class="postimage">';
            $thumb = esc_url(get_the_post_thumbnail_url());
            if($thumb != '')
            {
                $grid .= '<a href="' . esc_url($pt_link) . '" title="grid"><img src="' . $thumb .'" alt="thumb" width="'.$width.'" height="'.$height.'"/></a>';
            }
            
            $grid .= '</div>
        <h2 class="postimage-title">
            <a href="' . esc_url($pt_link) . '" title="grid">';
                if (strlen(the_title($before = '', $after = '', FALSE)) > $titlelength)
                { 
                    $grid .=  substr(the_title($before = '', $after = '', FALSE), 0, $titlelength) . ' ...'; 
                }
                else 
                { 
                    $grid .=  the_title($before = '', $after = '', FALSE); 
                }
                $grid .=  '</a>
            </h2>
        </div>
        <div class="crf_clear"></div>';
                $counter = 0;
            }
            $counter++;
            $total_counter++;
        }
        wp_reset_postdata();
        $grid .=  '</div>';
        return $grid;
    }
    else
    {
        return '';
    }
}
add_shortcode("youtubomatic_grid_channel", "youtubomatic_grid_channel");
function youtubomatic_grid_channel($atts)
{
    $id = isset( $atts['id'] )? esc_attr($atts['id']) : '';
    if($id == '')
    {
        return '';
    }
    $max = isset( $atts['max'] )? esc_attr($atts['max']) : 9;
    $width = isset( $atts['width'] )? esc_attr($atts['width']) : 200;
    $background_color = isset( $atts['background_color'] )? esc_attr($atts['background_color']) : 'eeeeee';
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') {
        $xml = simplexml_load_file('https://www.youtube.com/feeds/videos.xml?channel_id=' . $id);
        if($xml === false)
        {
            return '';
        }
        $return = array();
        $count = 0;
        foreach ($xml->entry as $video) {
            if($count >= $max)
            {
                break;
            }
            $vid = array();
            $vid['id'] = substr($video->id,42);
            $vid['title'] = $video->title;
            $vid['date'] = $video->published;
            $media = $video->children('http://search.yahoo.com/mrss/');
            $attrs = $media->group->thumbnail[0]->attributes();
            $vid['thumb'] = $attrs['url'];
            array_push($return, $vid);
            $count++;
        }
        $youtubeVideo_css = '.youtubeomatic-video-gallery{width:100%;margin:auto;}
.youtubeomatic-video
{
  padding:10px;
  background-color:#' . esc_html($background_color) . ';
  width:' . esc_html($width) . 'px;
  margin:10px;
  display: inline-block;
  vertical-align: middle;
}
.youtubomatic_title_vid a, a:hover, a:visited, a:link, a:active
{
  text-decoration: none !important;
}
.youtubomatic_title_vid
{
  font-weight: bold;
  height: 100px;
}';
        $youtubeVideo_css = wp_strip_all_tags($youtubeVideo_css);
        wp_register_style( 'youtubomatic-grid-channel-style', false );
        wp_enqueue_style( 'youtubomatic-grid-channel-style' );
        wp_add_inline_style( 'youtubomatic-grid-channel-style', $youtubeVideo_css );
        $youtubeVideo = '<div class="youtubeomatic-video-gallery">';
        foreach($return as $video) {
            $youtubeVideo .= '<div class="youtubeomatic-video">
            <a href="' . esc_url('//www.youtube.com/watch?v=' . $video['id']) . '" target="_blank">
              <img src="' . esc_url($video['thumb']) . '" width="' . esc_html($width) . '"/>
            </a>
            <p class="youtubomatic_title_vid">
              <a class="youtubomatic_href" href="' . esc_url('//www.youtube.com/watch?v=' . $video['id']) . '" target="_blank">' . esc_html($video['title']) . '</a>
            </p></div>';
        }
        $youtubeVideo .= '<div class="clearfix"></div></div>';
        return $youtubeVideo;
    }
    else
    {
        return '';
    }
}
add_shortcode("youtubomatic_grid_playlist", "youtubomatic_grid_playlist");
function youtubomatic_grid_playlist($atts)
{
    $id = isset( $atts['id'] )? esc_attr($atts['id']) : '';
    if($id == '')
    {
        return '';
    }
    $max = isset( $atts['max'] )? esc_attr($atts['max']) : 9;
    $width = isset( $atts['width'] )? esc_attr($atts['width']) : 200;
    $background_color = isset( $atts['background_color'] )? esc_attr($atts['background_color']) : 'eeeeee';
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') {
        $xml = simplexml_load_file('https://www.youtube.com/feeds/videos.xml?playlist_id=' . $id);
        if($xml === false)
        {
            return '';
        }
        $return = array();
        $count = 0;
        foreach ($xml->entry as $video) {
            if($count >= $max)
            {
                break;
            }
            $vid = array();
            $vid['id'] = substr($video->id,42);
            $vid['title'] = $video->title;
            $vid['date'] = $video->published;
            $media = $video->children('http://search.yahoo.com/mrss/');
            $attrs = $media->group->thumbnail[0]->attributes();
            $vid['thumb'] = $attrs['url'];
            array_push($return, $vid);
            $count++;
        }
        $youtubeVideo_css = '.youtubeomatic-video-gallery{width:100%;margin:auto;}
.youtubeomatic-video
{
  padding:10px;
  background-color:#' . esc_html($background_color) . ';
  width:' . esc_html($width) . 'px;
  margin:10px;
  display: inline-block;
  vertical-align: middle;
}
.youtubomatic_title_vid a, a:hover, a:visited, a:link, a:active
{
  text-decoration: none !important;
}
.youtubomatic_title_vid
{
  font-weight: bold;
  height: 100px;
}';
        $youtubeVideo_css = wp_strip_all_tags($youtubeVideo_css);
        wp_register_style( 'youtubomatic-grid-playlist-style', false );
        wp_enqueue_style( 'youtubomatic-grid-playlist-style' );
        wp_add_inline_style( 'youtubomatic-grid-playlist-style', $youtubeVideo_css );
        $youtubeVideo = '<div class="youtubeomatic-video-gallery">';
        foreach($return as $video) {
            $youtubeVideo .= '<div class="youtubeomatic-video">
            <a href="' . esc_url('//www.youtube.com/watch?v=' . $video['id']) . '" target="_blank">
              <img src="' . esc_url($video['thumb']) . '" width="' . esc_html($width) . '"/>
            </a>
            <p class="youtubomatic_title_vid">
              <a class="youtubomatic_href" href="' . esc_url('//www.youtube.com/watch?v=' . $video['id']) . '" target="_blank">' . esc_html($video['title']) . '</a>
            </p></div>';
        }
        $youtubeVideo .= '<div class="clearfix"></div></div>';
        return $youtubeVideo;
    }
    else
    {
        return '';
    }
}
add_shortcode("youtubomatic_channel", "youtubomatic_channel");
function youtubomatic_channel($atts)
{
    $id = isset( $atts['id'] )? esc_attr($atts['id']) : '';
    if($id == '')
    {
        return '';
    }
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') {
        if (isset($youtubomatic_Main_Settings['player_width']) && $youtubomatic_Main_Settings['player_width'] !== '') {
            $width = esc_attr($youtubomatic_Main_Settings['player_width']);
        }
        else
        {
            $width = 580;
        }
        if (isset($youtubomatic_Main_Settings['player_height']) && $youtubomatic_Main_Settings['player_height'] !== '') {
            $height = esc_attr($youtubomatic_Main_Settings['player_height']);
        }
        else
        {
            $height = 380;
        }
        if (isset($youtubomatic_Main_Settings['player_style']) && $youtubomatic_Main_Settings['player_style'] !== '' && $youtubomatic_Main_Settings['player_style'] !== '0') {
            if($youtubomatic_Main_Settings['player_style'] == '1')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg youtubomatic_wh"><iframe align="center" src="http://www.youtube.com/embed/?listType=user_uploads&list='. $id . '" width="'.$width.'" height="'.$height.'" frameBorder="0"></iframe></div>';
            }
            elseif($youtubomatic_Main_Settings['player_style'] == '2')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg2 youtubomatic_wh"><iframe src="http://www.youtube.com/embed/?listType=user_uploads&list='. $id . '" width="'.$width.'" height="'.$height.'" frameBorder="0"></iframe></div>';
            }
            elseif($youtubomatic_Main_Settings['player_style'] == '3')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg3 youtubomatic_wh"><iframe src="http://www.youtube.com/embed/?listType=user_uploads&list='. $id . '" width="'.$width.'" height="'.$height.'" frameBorder="0"></iframe></div>';
            }
        }
        else
        {
            $youtubeVideo = '<div class="youtubomatic-video-container"><iframe src="http://www.youtube.com/embed/?listType=user_uploads&list='. $id . '" width="'.$width.'" height="'.$height.'" frameBorder="0"></iframe></div>';
        }
        
        return $youtubeVideo;
    }
    else
    {
        return '';
    }
}
add_shortcode("youtubomatic_search", "youtubomatic_search");
function youtubomatic_search($atts)
{
    $id = isset( $atts['id'] )? esc_attr($atts['id']) : '';
    if($id == '')
    {
        return '';
    }
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') {
        if (isset($youtubomatic_Main_Settings['player_width']) && $youtubomatic_Main_Settings['player_width'] !== '') {
            $width = esc_attr($youtubomatic_Main_Settings['player_width']);
        }
        else
        {
            $width = 580;
        }
        if (isset($youtubomatic_Main_Settings['player_height']) && $youtubomatic_Main_Settings['player_height'] !== '') {
            $height = esc_attr($youtubomatic_Main_Settings['player_height']);
        }
        else
        {
            $height = 380;
        }
        if (isset($youtubomatic_Main_Settings['player_style']) && $youtubomatic_Main_Settings['player_style'] !== '' && $youtubomatic_Main_Settings['player_style'] !== '0') {
            if($youtubomatic_Main_Settings['player_style'] == '1')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg youtubomatic_wh"><iframe align="center" src="http://www.youtube.com/embed?listType=search&list='. $id . '" width="'.$width.'" height="'.$height.'" frameBorder="0"></iframe></div>';
            }
            elseif($youtubomatic_Main_Settings['player_style'] == '2')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg2 youtubomatic_wh"><iframe src="http://www.youtube.com/embed?listType=search&list='. $id . '" width="'.$width.'" height="'.$height.'" frameBorder="0"></iframe></div>';
            }
            elseif($youtubomatic_Main_Settings['player_style'] == '3')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg3 youtubomatic_wh"><iframe src="http://www.youtube.com/embed?listType=search&list='. $id . '" width="'.$width.'" height="'.$height.'" frameBorder="0"></iframe></div>';
            }
        }
        else
        {
            $youtubeVideo = '<div class="youtubomatic-video-container"><iframe src="http://www.youtube.com/embed?listType=search&list='. urlencode($id) . '" width="'.$width.'" height="'.$height.'" frameBorder="0"></iframe></div>';
        }
        
        return $youtubeVideo;
    }
    else
    {
        return '';
    }
}
add_shortcode("youtubomatic_video", "youtubomatic_video");
function youtubomatic_video($atts)
{
    $id = isset( $atts['id'] )? esc_attr($atts['id']) : '';
    if($id == '')
    {
        return '';
    }
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') {
        $youtubeVideo = "https://www.youtube.com/embed/" . $id;
        if (isset($youtubomatic_Main_Settings['player_width']) && $youtubomatic_Main_Settings['player_width'] !== '') {
            $width = esc_attr($youtubomatic_Main_Settings['player_width']);
        }
        else
        {
            $width = 580;
        }
                if (isset($youtubomatic_Main_Settings['player_height']) && $youtubomatic_Main_Settings['player_height'] !== '') {
                    $height = esc_attr($youtubomatic_Main_Settings['player_height']);
                }
                else
                {
                    $height = 380;
                }
                if (isset($youtubomatic_Main_Settings['show_closed_captions']) && $youtubomatic_Main_Settings['show_closed_captions'] == '1') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&cc_load_policy=1';
                    }
                    else
                    {
                        $youtubeVideo .= '?cc_load_policy=1';
                    }
                }
                if (isset($youtubomatic_Main_Settings['color_theme']) && $youtubomatic_Main_Settings['color_theme'] == 'white') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&color=white';
                    }
                    else
                    {
                        $youtubeVideo .= '?color=white';
                    }
                }
                if (isset($youtubomatic_Main_Settings['video_controls']) && $youtubomatic_Main_Settings['video_controls'] !== '2') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&controls='.esc_attr($youtubomatic_Main_Settings['video_controls']);
                    }
                    else
                    {
                        $youtubeVideo .= '?controls='.esc_attr($youtubomatic_Main_Settings['video_controls']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['keyboard_control']) && $youtubomatic_Main_Settings['keyboard_control'] !== '0') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&disablekb='.esc_attr($youtubomatic_Main_Settings['keyboard_control']);
                    }
                    else
                    {
                        $youtubeVideo .= '?disablekb='.esc_attr($youtubomatic_Main_Settings['keyboard_control']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['iframe_api']) && $youtubomatic_Main_Settings['iframe_api'] !== '0') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&enablejsapi='.esc_attr($youtubomatic_Main_Settings['iframe_api']) . '&origin=' . urlencode(get_site_url());
                    }
                    else
                    {
                        $youtubeVideo .= '?enablejsapi='.esc_attr($youtubomatic_Main_Settings['iframe_api']) . '&origin=' . urlencode(get_site_url());
                    }
                }
                if (isset($youtubomatic_Main_Settings['stop_after']) && $youtubomatic_Main_Settings['stop_after'] !== '') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&end='.esc_attr($youtubomatic_Main_Settings['stop_after']);
                    }
                    else
                    {
                        $youtubeVideo .= '?end='.esc_attr($youtubomatic_Main_Settings['stop_after']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['start_after']) && $youtubomatic_Main_Settings['start_after'] !== '') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&start='.esc_attr($youtubomatic_Main_Settings['start_after']);
                    }
                    else
                    {
                        $youtubeVideo .= '?start='.esc_attr($youtubomatic_Main_Settings['start_after']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['show_fullscreen_button']) && $youtubomatic_Main_Settings['show_fullscreen_button'] !== '1') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&fs='.esc_attr($youtubomatic_Main_Settings['show_fullscreen_button']);
                    }
                    else
                    {
                        $youtubeVideo .= '?fs='.esc_attr($youtubomatic_Main_Settings['show_fullscreen_button']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['player_language']) && $youtubomatic_Main_Settings['player_language'] !== 'default') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&hl='.esc_attr($youtubomatic_Main_Settings['player_language']);
                    }
                    else
                    {
                        $youtubeVideo .= '?hl='.esc_attr($youtubomatic_Main_Settings['player_language']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['video_annotations']) && $youtubomatic_Main_Settings['video_annotations'] !== '1') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&iv_load_policy='.esc_attr($youtubomatic_Main_Settings['video_annotations']);
                    }
                    else
                    {
                        $youtubeVideo .= '?iv_load_policy='.esc_attr($youtubomatic_Main_Settings['video_annotations']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['loop_video']) && $youtubomatic_Main_Settings['loop_video'] !== '0') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&loop='.esc_attr($youtubomatic_Main_Settings['loop_video']);
                    }
                    else
                    {
                        $youtubeVideo .= '?loop='.esc_attr($youtubomatic_Main_Settings['loop_video']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['modest_branding']) && $youtubomatic_Main_Settings['modest_branding'] !== '0') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&modestbranding='.esc_attr($youtubomatic_Main_Settings['modest_branding']);
                    }
                    else
                    {
                        $youtubeVideo .= '?modestbranding='.esc_attr($youtubomatic_Main_Settings['modest_branding']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['show_related']) && $youtubomatic_Main_Settings['show_related'] !== '1') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&rel='.esc_attr($youtubomatic_Main_Settings['show_related']);
                    }
                    else
                    {
                        $youtubeVideo .= '?rel='.esc_attr($youtubomatic_Main_Settings['show_related']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['show_info']) && $youtubomatic_Main_Settings['show_info'] !== '1') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&showinfo='.esc_attr($youtubomatic_Main_Settings['show_info']);
                    }
                    else
                    {
                        $youtubeVideo .= '?showinfo='.esc_attr($youtubomatic_Main_Settings['show_info']);
                    }
                }
        if (isset($youtubomatic_Main_Settings['player_style']) && $youtubomatic_Main_Settings['player_style'] !== '' && $youtubomatic_Main_Settings['player_style'] !== '0') {
            if($youtubomatic_Main_Settings['player_style'] == '1')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg youtubomatic_wh"><iframe align="center" width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div>';
            }
            elseif($youtubomatic_Main_Settings['player_style'] == '2')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg2 youtubomatic_wh"><iframe width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div>';
            }
            elseif($youtubomatic_Main_Settings['player_style'] == '3')
            {
                $youtubeVideo = '<div class="youtubomatic-video-container crf_marg3 youtubomatic_wh"><iframe width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div>';
            }
        }
        else
        {
            $youtubeVideo = '<div class="youtubomatic-video-container"><iframe width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div>';
        }
        
        return $youtubeVideo;
    }
    else
    {
        return '';
    }
}

function youtubomatic_isCurl(){
    return function_exists('curl_version');
}

function youtubomatic_get_web_page($url)
{
    $content = false;
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (!isset($youtubomatic_Main_Settings['proxy_url']) || $youtubomatic_Main_Settings['proxy_url'] == '') {
        $args = array(
           'timeout'     => 10,
           'redirection' => 10,
           'user-agent'  => youtubomatic_get_random_user_agent(),
           'blocking'    => true,
           'headers'     => array(),
           'cookies'     => array(),
           'body'        => null,
           'compress'    => false,
           'decompress'  => true,
           'sslverify'   => false,
           'stream'      => false,
           'filename'    => null
        );
        $ret_data            = wp_remote_get(html_entity_decode($url), $args);  
        $response_code       = wp_remote_retrieve_response_code( $ret_data );
        $response_message    = wp_remote_retrieve_response_message( $ret_data );        
        if ( 200 != $response_code ) {
        } else {
            $content = wp_remote_retrieve_body( $ret_data );
        }
    }
    if($content === false)
    {
        if(youtubomatic_isCurl() && filter_var($url, FILTER_VALIDATE_URL))
        {
            $user_agent = youtubomatic_get_random_user_agent();
            $options    = array(
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POST => false,
                CURLOPT_USERAGENT => $user_agent,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_AUTOREFERER => true,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_REFERER => get_site_url(),
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0
            );
            $ch         = curl_init($url);
            if ($ch !== FALSE) {
                if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
                    curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
                    if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
                        curl_setopt($ch, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
                    }
                }
                curl_setopt_array($ch, $options);
                $content = curl_exec($ch);
                curl_close($ch);
            }
        }
        if($content === false)
        {
            $allowUrlFopen = preg_match('/1|yes|on|true/i', ini_get('allow_url_fopen'));
            if ($allowUrlFopen) {
                global $wp_filesystem;
                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                    wp_filesystem($creds);
                }
                return $wp_filesystem->get_contents($url);
            }
        }
    }
    return $content;
}

function youtubomatic_utf8_encode($str)
{
    if(function_exists('mb_detect_encoding') && function_exists('mb_convert_encoding'))
    {
        $enc = mb_detect_encoding($str);
        if ($enc !== FALSE) {
            $str = mb_convert_encoding($str, 'UTF-8', $enc);
        } else {
            $str = mb_convert_encoding($str, 'UTF-8');
        }
    }
    return $str;
}

function youtubomatic_generate_title($content)
{
    $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
    $content        = preg_replace($regexEmoticons, '', $content);
    $regexSymbols   = '/[\x{1F300}-\x{1F5FF}]/u';
    $content        = preg_replace($regexSymbols, '', $content);
    $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
    $content        = preg_replace($regexTransport, '', $content);
    $regexMisc      = '/[\x{2600}-\x{26FF}]/u';
    $content        = preg_replace($regexMisc, '', $content);
    $regexDingbats  = '/[\x{2700}-\x{27BF}]/u';
    $content        = preg_replace($regexDingbats, '', $content);
    $pattern        = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
    $replacement    = "";
    $content        = preg_replace($pattern, $replacement, $content);
    $return         = trim(trim(trim(wp_trim_words($content, 14)), '.'), ',');
    return $return;
}
function youtubomatic_fetch_locale($match = '')
{
    if (empty($match))
        $match = get_locale();
    $match_len     = strlen($match);
    $valid_locales = (array) youtubomatic_fb_locales();
    $default       = 'en_US';
    if ($match_len > 5) {
        $match     = substr($match, 0, 5);
        $match_len = 5;
    }
    if (5 === $match_len) {
        if (in_array($match, $valid_locales))
            return $match;
        $match     = substr($match, 0, 2);
        $match_len = 2;
    }
    if (2 === $match_len) {
        $locale_keys = (array) youtubomatic_language_keys();
        if ($key = array_search($match, $locale_keys)) {
            return $valid_locales[$key];
        }
    }
    return $default;
}
function youtubomatic_async_tag( $tag, $handle, $src ) {
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['enable_og']) && $youtubomatic_Main_Settings['enable_og'] == 'on') {
        $is_divi_vb = function_exists( 'et_fb_enabled' ) ? et_fb_enabled() : false;
        if ( $handle !== 'youtubomatic-dummy-handle-json-footer' || $is_divi_vb) {
            return $tag;
        }
        $tag = str_replace("type='text/javascript'", "type='application/ld+json'", $tag);
    }
	return $tag;
}
add_action('wp_head', 'youtubomatic_custom_js');
function youtubomatic_custom_js() {
    wp_suspend_cache_addition(true);
    global $post;
    if(isset($post->ID))
    {
        $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
        if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') {
            if(is_single())
            {
                if (isset($youtubomatic_Main_Settings['link_soft']) && $youtubomatic_Main_Settings['link_soft'] == 'on') {
                    $yturl = get_post_meta($post->ID, 'youtubomatic_post_url', true);
                    if($yturl !== false && $yturl != '')
                    {
                        echo '<meta http-equiv="refresh" content="0; url=' . esc_url($yturl) . '">';
                        wp_add_inline_script( 'youtubomatic-dummy-handle-footer', 'window.location.href = "' . esc_url($yturl) . '";' );
                    }
                }
            
                if (isset($youtubomatic_Main_Settings['enable_og']) && $youtubomatic_Main_Settings['enable_og'] == 'on') {
                    $index = get_post_meta($post->ID, 'youtubomatic_parent_rule', true);
                    $name = $post->post_title;
                    $description = $post->post_excerpt;
                    if($description == '')
                    {
                        $description = $title;
                    }
                    $thumbnailUrl = get_post_meta($post->ID, 'youtubomatic_featured_img', true);
                    $uploadDate = $post->post_date;
                    $url = get_post_meta($post->ID, 'youtubomatic_post_url', true);
                    if($index != '')
                    {
                        wp_add_inline_script( 'youtubomatic-dummy-handle-json-footer', '{
        "@context": "http://schema.org",
        "@type": "VideoObject",
        "name": "'.esc_html($name).'",
        "description": "'.esc_html($description).'",
        "thumbnailUrl": "'.esc_url($thumbnailUrl).'",
        "uploadDate": "'.esc_html($uploadDate).'",
        "contentUrl": "'.esc_url($url).'",
        "embedUrl": "'.esc_url($url).'"
    }' );
                    }
                }
            }
            if (isset($youtubomatic_Main_Settings['enable_og2']) && $youtubomatic_Main_Settings['enable_og2'] == 'on') {
?>
            <meta property="og:title" content="<?php
            echo the_title();
?>" />
        <meta property="og:site_name" content="<?php
            bloginfo('name');
?>" />
        <meta property="og:url" content="<?php
        if (isset($youtubomatic_Main_Settings['link_og']) && $youtubomatic_Main_Settings['link_og'] == 'on') {
            $url = get_post_meta($post->ID, 'youtubomatic_post_url', true);
            if($url !== false && $url != '')
            {
                echo $url;
            }
            else
            {
                the_permalink();
            }
        }
        else
        {
            the_permalink();
        }
?>" />
        <meta property="og:description" content="<?php
            bloginfo('description');
?>" />
        <meta property="og:locale" content="<?php
            echo youtubomatic_fetch_locale('');
?>" />
        <meta property="og:type" content="website"/>
        <meta property="og:updated_time" content="<?php
            the_modified_date();
?>" />
<?php
if (isset($youtubomatic_Main_Settings['default_image_og']) && $youtubomatic_Main_Settings['default_image_og'] != '') {
    $default_img = $youtubomatic_Main_Settings['default_image_og'];
}
else
{
    $default_img = '';
}
            if (is_single()) {       
                $image = youtubomatic_get_open_graph_post_image($default_img);
                if ($image != '') {
?>
        <meta property="og:image" content="<?php
                    echo esc_url($image);
?>"/>  
<?php
                    $fb_width = '';
                    $fb_height = '';
                    $fb_type = '';
                    $fb_attr = '';
                    try
                    {
                        list( $fb_width, $fb_height, $fb_type, $fb_attr ) = youtubomatic_get_open_graph_image_size($image);
                    }
                    catch(Exception $e)
                    {
                        youtubomatic_log_to_file('Exception occured while trying to get featured image size: ' . $e->getMessage());
                    }
if(is_numeric($fb_width))
{
?>
        <meta property="og:image:width" content="<?php echo intval(esc_attr($fb_width));?>"/>
<?php
}
if(is_numeric($fb_height))
{
?>
        <meta property="og:image:height" content="<?php echo intval(esc_attr($fb_height));?>"/>
<?php
}
                }
            }
            else
            {
                if($default_img != '')
                {
?>
        <meta property="og:image" content="<?php
                    echo esc_url($default_img);
?>"/>
<?php
                    $fb_width = '';
                    $fb_height = '';
                    $fb_type = '';
                    $fb_attr = '';
                    try
                    {
                        list( $fb_width, $fb_height, $fb_type, $fb_attr ) = youtubomatic_get_open_graph_image_size($default_img);
                    }
                    catch(Exception $e)
                    {
                        youtubomatic_log_to_file('Exception occured while trying to get featured image size: ' . $e->getMessage());
                    }
if(is_numeric($fb_width))
{
?>
        <meta property="og:image:width" content="<?php echo intval(esc_attr($fb_width));?>"/>
<?php
}
if(is_numeric($fb_height))
{
?>
        <meta property="og:image:height" content="<?php echo intval(esc_attr($fb_height));?>"/>
<?php
}
                }
            }
            }
        }
    }
    wp_suspend_cache_addition(false);
}

function youtubomatic_get_open_graph_image_size_curl( $image, $headers ) {
	$youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    $curl = curl_init($image);
	if ( is_array($headers) ) curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
		curl_setopt($curl, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
		if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
			curl_setopt($curl, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
		}
	}
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_REFERER, ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ) ? 'https://' : 'http://' ).$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$data = curl_exec($curl);
	curl_close($curl);
	return $data;
}
function youtubomatic_get_open_graph_image_size( $image ) {
	$transient_key = 'youtubomatic_og_image_size_' . md5($image);
	$transient_val = get_transient($transient_key);
	if ($transient_val) {
		return $transient_val;
	}
    if(substr( $image, 0, 4 ) != "http")
    {
        $image = site_url() . $image;
    }
    if(!youtubomatic_url_exists($image))
    {
        return false;
    }
    $img_size = getimagesize($image);
    if ($img_size) {
		set_transient($transient_key, $img_size, DAY_IN_SECONDS);
        return $img_size;
	}
	if ( stristr($image, 'http://' ) || stristr($image, 'https://' ) || mb_substr($image, 0, 2)=='//' ) {
		if ( function_exists('curl_version' ) && function_exists('imagecreatefromstring' ) ) {
			$headers = array(
				"Range: bytes=0-32768"
			);
			$data = youtubomatic_get_open_graph_image_size_curl($image, $headers);
			if ( $data ) {
				$done_partial = false;
				$tried_full = false;
				try {
					$im = imagecreatefromstring($data);
					if ($im) $done_partial = true;
				} catch(Exception $e) {
					$tried_full = true;
					$data = youtubomatic_get_open_graph_image_size_curl($image, null);
					if ( $data )$im = imagecreatefromstring($data);
				}
				if ( !$done_partial && !$tried_full ) {
					$data = youtubomatic_get_open_graph_image_size_curl($image, null);
					if ( $data )$im = imagecreatefromstring($data);
				}
				if ( $im ) {
					if ( $x=imagesx($im) ) {
						$ext = pathinfo($image, PATHINFO_EXTENSION);
						switch(strtolower($ext)) {
							case 'gif':
								$type=1;
								break;
							case 'jpg':
							case 'jpeg':
								$type=2;
								break;
							case 'png':
								$type=3;
								break;
							default:
								$type=2;
								break;
						}
						$img_size = array($x, imagesy($im), $type, '' );
					} else {
						$img_size = false;
					}
				} else {
					$img_size = false;
				}
			} else {
				$img_size = false;
			}
		} else {
			if ( intval(ini_get('allow_url_fopen' ))==1 ) {
				$img_size = getimagesize($image);
			} else {
				$img_size = false;
			}
		}
	} else {
		$img_size = getimagesize($image);
	}
	if ($img_size) {
		set_transient($transient_key, $img_size, DAY_IN_SECONDS);
	}
	return $img_size;
}
function youtubomatic_get_open_graph_post_image($default_image = '')
{
    $post      = get_post();
    $thumbdone = false;
    $fb_image  = '';
    wp_suspend_cache_addition(true);
    $metas = get_post_custom($post->ID);
    wp_suspend_cache_addition(false);
    if(is_array($metas))
    {
        $rez_meta = youtubomatic_preg_grep_keys('#.+?_featured_ima?ge?#i', $metas);
    }
    else
    {
        $rez_meta = array();
    }
    if(count($rez_meta) > 0)
    {
        foreach($rez_meta as $rm)
        {
            if(isset($rm[0]) && filter_var($rm[0], FILTER_VALIDATE_URL))
            {
                $fb_image = $rm[0];
                $thumbdone = true;
                break;
            }
        }
    }
    if (!$thumbdone) {
        if (is_attachment()) {
            if ($temp = wp_get_attachment_image_src(null, 'full')) {
                $fb_image = trim($temp[0]);
                if (trim($fb_image) != '') {
                    $thumbdone = true;
                }
            }
        }
    }
    if (!$thumbdone) {
        if (function_exists('get_post_thumbnail_id')) {
            if ($id_attachment = get_post_thumbnail_id($post->ID)) {
                $fb_image  = wp_get_attachment_url($id_attachment, false);
                $thumbdone = true;
            }
        }
    }
    if (!$thumbdone) {
        $imgreg = '/<img .*src=["\']([^ ^"^\']*)["\']/';
        preg_match_all($imgreg, trim($post->post_content), $matches);
        if ($matches[1]) {
            $imagetemp = false;
            foreach ($matches[1] as $image) {
                $pos = strpos($image, site_url());
                if ($pos === false) {
                    if (stristr($image, 'http://') || stristr($image, 'https://') || substr($image, 0, 2) == '//') {
                        if (substr($image, 0, 2) == '//')
                            $image = ((youtubomatic_isSecure()) ? 'https:' : 'http:') . $image;
                        $imagetemp = $image;
                    } else {
                        $imagetemp = site_url() . $image;
                    }
                } else {
                    $imagetemp = $image;
                }
                if ($imagetemp) {
                    $fb_image  = $imagetemp;
                    $thumbdone = true;
                    break;
                }
            }
        }
    }
    if (!$thumbdone) {
        $images = get_posts(array(
            'post_type' => 'attachment',
            'numberposts' => 100,
            'post_status' => null,
            'order' => 'ASC',
            'orderby' => 'menu_order',
            'post_mime_type' => 'image',
            'post_parent' => $post->ID,
            'fields' => 'ids'
        ));
        if ($images) {
            foreach ($images as $image) {
                $imagetemp = wp_get_attachment_url($image, false);
                $fb_image  = $imagetemp;
                $thumbdone = true;
                break;
            }
        }
    }
    if (!$thumbdone) {
        $fb_image = $default_image;
    }
    if($fb_image != '')
    {
        if(substr( $fb_image, 0, 4 ) != "http")
        {
            $fb_image = site_url() . $fb_image;
        }
    }
    return $fb_image;
}
function youtubomatic_strip_textual_links($content)
{
    $regex = "@([^<\"\'>])(?:https?:\/\/(?:[-\w\.]+[-\w])+(?::\d+)?(?:\/(?:[\w\/_\.#-]*(?:\?\S+)?[^\"\'<\.\s])?)?)(?:[\?\&\#]?[a-zA-Z0-9\-._~:\/?#[\]\@\!\$&'\(\)\*\+,;=]*)([^<\"\'>])@i";
    $content = preg_replace($regex, '$1 $2', $content);
    return $content;
}
function youtubomatic_isSecure() {
  return
    (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || $_SERVER['SERVER_PORT'] == 443;
}

function youtubomatic_replaceSynergyShortcodes($the_content)
{
    $regex = '#%%([a-z0-9]+?)_(\d+?)_(\d+?)%%#';
    $rezz = preg_match_all($regex, $the_content, $matches);
    if ($rezz === FALSE) {
        return $the_content;
    }
    if(isset($matches[1][0]))
    {
        $two_var_functions = array('pdfomatic');
        $three_var_functions = array('bhomatic', 'crawlomatic', 'dmomatic', 'ezinomatic', 'fbomatic', 'quoramatic', 'flickomatic', 'imguromatic', 'iui', 'instamatic', 'linkedinomatic', 'mediumomatic', 'pinterestomatic', 'echo', 'spinomatic', 'tumblomatic', 'wordpressomatic', 'wpcomomatic', 'youtubomatic', 'mastermind', 'businessomatic');
        $four_var_functions = array('contentomatic', 'newsomatic', 'aliomatic', 'amazomatic', 'blogspotomatic', 'bookomatic', 'careeromatic', 'cbomatic', 'cjomatic', 'craigomatic', 'ebayomatic', 'etsyomatic', 'learnomatic', 'eventomatic', 'gameomatic', 'gearomatic', 'giphyomatic', 'gplusomatic', 'hackeromatic', 'imageomatic', 'midas', 'movieomatic', 'nasaomatic', 'ocartomatic', 'okomatic', 'playomatic', 'recipeomatic', 'redditomatic', 'soundomatic', 'mp3omatic', 'ticketomatic', 'tmomatic', 'trendomatic', 'tuneomatic', 'twitchomatic', 'twitomatic', 'vimeomatic', 'viralomatic', 'vkomatic', 'walmartomatic', 'wikiomatic', 'xlsxomatic', 'yelpomatic', 'yummomatic');
        for ($i = 0; $i < count($matches[1]); $i++)
        {
            $replace_me = false;
            if(in_array($matches[1][$i], $four_var_functions))
            {
                $za_function = $matches[1][$i] . '_run_rule';
                if(function_exists($za_function))
                {
                    $xreflection = new ReflectionFunction($za_function);
                    if($xreflection->getNumberOfParameters() >= 4)
                    {  
                        $rule_runner = $za_function($matches[3][$i], $matches[2][$i], 0, 1);
                        if($rule_runner != 'fail' && $rule_runner != 'nochange' && $rule_runner != 'ok' && $rule_runner !== false)
                        {
                            $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', $rule_runner, $the_content);
                            $replace_me = true;
                        }
                    }
                    $xreflection = null;
                    unset($xreflection);
                }
            }
            elseif(in_array($matches[1][$i], $three_var_functions))
            {
                $za_function = $matches[1][$i] . '_run_rule';
                if(function_exists($za_function))
                {
                    $xreflection = new ReflectionFunction($za_function);
                    if($xreflection->getNumberOfParameters() >= 3)
                    {
                        $rule_runner = $za_function($matches[3][$i], 0, 1);
                        if($rule_runner != 'fail' && $rule_runner != 'nochange' && $rule_runner != 'ok' && $rule_runner !== false)
                        {
                            $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', $rule_runner, $the_content);
                            $replace_me = true;
                        }
                    }
                    $xreflection = null;
                    unset($xreflection);
                }
            }
            elseif(in_array($matches[1][$i], $two_var_functions))
            {
                $za_function = $matches[1][$i] . '_run_rule';
                if(function_exists($za_function))
                {
                    $xreflection = new ReflectionFunction($za_function);
                    if($xreflection->getNumberOfParameters() >= 2)
                    {
                        $rule_runner = $za_function($matches[3][$i], 1);
                        if($rule_runner != 'fail' && $rule_runner != 'nochange' && $rule_runner != 'ok' && $rule_runner !== false)
                        {
                            $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', $rule_runner, $the_content);
                            $replace_me = true;
                        }
                    }
                    $xreflection = null;
                    unset($xreflection);
                }
            }
            if($replace_me == false)
            {
                $the_content = str_replace('%%' . $matches[1][$i] . '_' . $matches[2][$i] . '_' . $matches[3][$i] . '%%', '', $the_content);
            }
        }
    }
    return $the_content;
}

class Youtubomatic_keywords{ 
    public static $charset = 'UTF-8';
    public static $banned_words = array('adsbygoogle', 'able', 'about', 'above', 'act', 'add', 'afraid', 'after', 'again', 'against', 'age', 'ago', 'agree', 'all', 'almost', 'alone', 'along', 'already', 'also', 'although', 'always', 'am', 'amount', 'an', 'and', 'anger', 'angry', 'animal', 'another', 'answer', 'any', 'appear', 'apple', 'are', 'arrive', 'arm', 'arms', 'around', 'arrive', 'as', 'ask', 'at', 'attempt', 'aunt', 'away', 'back', 'bad', 'bag', 'bay', 'be', 'became', 'because', 'become', 'been', 'before', 'began', 'begin', 'behind', 'being', 'bell', 'belong', 'below', 'beside', 'best', 'better', 'between', 'beyond', 'big', 'body', 'bone', 'born', 'borrow', 'both', 'bottom', 'box', 'boy', 'break', 'bring', 'brought', 'bug', 'built', 'busy', 'but', 'buy', 'by', 'call', 'came', 'can', 'cause', 'choose', 'close', 'close', 'consider', 'come', 'consider', 'considerable', 'contain', 'continue', 'could', 'cry', 'cut', 'dare', 'dark', 'deal', 'dear', 'decide', 'deep', 'did', 'die', 'do', 'does', 'dog', 'done', 'doubt', 'down', 'during', 'each', 'ear', 'early', 'eat', 'effort', 'either', 'else', 'end', 'enjoy', 'enough', 'enter', 'even', 'ever', 'every', 'except', 'expect', 'explain', 'fail', 'fall', 'far', 'fat', 'favor', 'fear', 'feel', 'feet', 'fell', 'felt', 'few', 'fill', 'find', 'fit', 'fly', 'follow', 'for', 'forever', 'forget', 'from', 'front', 'gave', 'get', 'gives', 'goes', 'gone', 'good', 'got', 'gray', 'great', 'green', 'grew', 'grow', 'guess', 'had', 'half', 'hang', 'happen', 'has', 'hat', 'have', 'he', 'hear', 'heard', 'held', 'hello', 'help', 'her', 'here', 'hers', 'high', 'hill', 'him', 'his', 'hit', 'hold', 'hot', 'how', 'however', 'I', 'if', 'ill', 'in', 'indeed', 'instead', 'into', 'iron', 'is', 'it', 'its', 'just', 'keep', 'kept', 'knew', 'know', 'known', 'late', 'least', 'led', 'left', 'lend', 'less', 'let', 'like', 'likely', 'likr', 'lone', 'long', 'look', 'lot', 'make', 'many', 'may', 'me', 'mean', 'met', 'might', 'mile', 'mine', 'moon', 'more', 'most', 'move', 'much', 'must', 'my', 'near', 'nearly', 'necessary', 'neither', 'never', 'next', 'no', 'none', 'nor', 'not', 'note', 'nothing', 'now', 'number', 'of', 'off', 'often', 'oh', 'on', 'once', 'only', 'or', 'other', 'ought', 'our', 'out', 'please', 'prepare', 'probable', 'pull', 'pure', 'push', 'put', 'raise', 'ran', 'rather', 'reach', 'realize', 'reply', 'require', 'rest', 'run', 'said', 'same', 'sat', 'saw', 'say', 'see', 'seem', 'seen', 'self', 'sell', 'sent', 'separate', 'set', 'shall', 'she', 'should', 'side', 'sign', 'since', 'so', 'sold', 'some', 'soon', 'sorry', 'stay', 'step', 'stick', 'still', 'stood', 'such', 'sudden', 'suppose', 'take', 'taken', 'talk', 'tall', 'tell', 'ten', 'than', 'thank', 'that', 'the', 'their', 'them', 'then', 'there', 'therefore', 'these', 'they', 'this', 'those', 'though', 'through', 'till', 'to', 'today', 'told', 'tomorrow', 'too', 'took', 'tore', 'tought', 'toward', 'tried', 'tries', 'trust', 'try', 'turn', 'two', 'under', 'until', 'up', 'upon', 'us', 'use', 'usual', 'various', 'verb', 'very', 'visit', 'want', 'was', 'we', 'well', 'went', 'were', 'what', 'when', 'where', 'whether', 'which', 'while', 'white', 'who', 'whom', 'whose', 'why', 'will', 'with', 'within', 'without', 'would', 'yes', 'yet', 'you', 'young', 'your', 'br', 'img', 'p','lt', 'gt', 'quot', 'copy');
    public static $min_word_length = 4;
    
    public static function text($text, $length = 160)
    {
        return self::limit_chars(self::clean($text), $length,'',TRUE);
    } 

    public static function keywords($text, $max_keys = 3)
    {
        include (dirname(__FILE__) . "/res/diacritics.php");
        $wordcount = array_count_values(str_word_count(self::clean($text), 1, $diacritics));
        foreach ($wordcount as $key => $value) 
        {
            if ( (strlen($key)<= self::$min_word_length) OR in_array($key, self::$banned_words))
                unset($wordcount[$key]);
        }
        uasort($wordcount,array('self','cmp'));
        $wordcount = array_slice($wordcount,0, $max_keys);
        return implode(' ', array_keys($wordcount));
    } 

    private static function clean($text)
    { 
        $text = html_entity_decode($text,ENT_QUOTES,self::$charset);
        $text = strip_tags($text);
        $text = preg_replace('/\s\s+/', ' ', $text);
        $text = str_replace (array('\r\n', '\n', '+'), ',', $text);
        return trim($text); 
    } 

    private static function cmp($a, $b) 
    {
        if ($a == $b) return 0; 

        return ($a < $b) ? 1 : -1; 
    } 

    private static function limit_chars($str, $limit = 100, $end_char = NULL, $preserve_words = FALSE)
    {
        $end_char = ($end_char === NULL) ? '&#8230;' : $end_char;
        $limit = (int) $limit;
        if (trim($str) === '' OR strlen($str) <= $limit)
            return $str;
        if ($limit <= 0)
            return $end_char;
        if ($preserve_words === FALSE)
            return rtrim(substr($str, 0, $limit)).$end_char;
        if ( ! preg_match('/^.{0,'.$limit.'}\s/us', $str, $matches))
            return $end_char;
        return rtrim($matches[0]).((strlen($matches[0]) === strlen($str)) ? '' : $end_char);
    }
} 
function youtubomatic_run_rule($param, $auto = 1, $ret_content = 0)
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if($ret_content == 0)
    {
        $f = fopen(get_temp_dir() . 'youtubomatic_' . $param, 'w');
        if($f !== false)
        {
            $flock_disabled = explode(',', ini_get('disable_functions'));
            if(!in_array('flock', $flock_disabled))
            {
                if (!flock($f, LOCK_EX | LOCK_NB)) {
                    return 'nochange';
                }
            }
        }
        
        $GLOBALS['wp_object_cache']->delete('youtubomatic_running_list', 'options');
                if (!get_option('youtubomatic_running_list')) {
                    $running = array();
                } else {
                    $running = get_option('youtubomatic_running_list');
                }
                if (!empty($running)) {
                    if (in_array($param, $running)) {
                        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                            youtubomatic_log_to_file('Only one instance of this rule is allowed. Rule is already running!');
                        }
                        return 'nochange';
                    }
                }
        $running[] = $param;
        update_option('youtubomatic_running_list', $running, false);
        register_shutdown_function('youtubomatic_clear_flag_at_shutdown', $param);
        if (isset($youtubomatic_Main_Settings['rule_timeout']) && $youtubomatic_Main_Settings['rule_timeout'] != '') {
            $timeout = intval($youtubomatic_Main_Settings['rule_timeout']);
        } else {
            $timeout = 3600;
        }
        ini_set('safe_mode', 'Off');
        ini_set('max_execution_time', $timeout);
        ini_set('ignore_user_abort', 1);
        ini_set('user_agent', youtubomatic_get_random_user_agent());
        ignore_user_abort(true);
        set_time_limit($timeout);
    }
    $posts_inserted         = 0;
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') {
        try {
            if (!isset($youtubomatic_Main_Settings['app_id']) || trim($youtubomatic_Main_Settings['app_id']) == '') {
                youtubomatic_log_to_file('You need to insert a valid YouTube API Key for this to work!');
                if($auto == 1)
                {
                    youtubomatic_clearFromList($param);
                }
                return 'fail';
            }
            else
            {
                $za_app = explode(',', $youtubomatic_Main_Settings['app_id']);
                $za_app = trim($za_app[array_rand($za_app)]);
            }
            $item_img         = '';
            $rule_keywords    = '';
            $cont             = 0;
            $found            = 0;
            $ids              = '';
            $schedule         = '';
            $enable_comments  = '1';
            $enable_pingback  = '1';
            $author_link      = '';
            $active           = '0';
            $last_run         = '';
            $ruleType         = 'week';
            $first            = false;
            $others           = array();
            $post_title       = '';
            $post_content     = '';
            $list_item        = '';
            $default_category = '';
            $extra_categories = '';
            $posted_items    = array();
            $post_status     = 'publish';
            $post_type       = 'post';
            $accept_comments = 'closed';
            $post_user_name  = 1;
            $item_create_tag = '';
            $can_create_tag  = 'disabled';
            $item_tags       = '';
            $max             = 50;
            $auto_categories = 'disabled';
            $featured_image  = '0';
            $get_img         = '';
            $image_url       = '';
            $post_format     = 'post-format-standard';
            $post_array      = array();
            $coord           = '';
            $radius          = '';
            $lat             = '';
            $region_code     = 'any';
            $video_definition = 'any';
            $lng             = '';
            $channel_id      = '';
            $event_type      = 'uploaded';
            $auto_generate_comments = '0';
            $result_type     = 'any';
            $video_category  = '0';
            $video_caption   = 'any';
            $video_duration2 = 'any';
            $video_dimension = 'any';
            $video_embeddable = 'any';
            $video_license   = 'any';
            $video_type      = 'any';
            $video_syndication = 'any';
            $enable_autoplay = '0';
            $search_order    = 'relevance';
            $safe_search     = 'moderate';
            $detailed_info   = '1';
            $skip_old        = '0';
            $skip_day        = '';
            $skip_month      = '';
            $skip_year       = '';
            $remove_default  = '0';
            $date_from_video = '0';
            $custom_fields   = '';
            $custom_tax      = '';
            $continue_search = '0';
            $default_sep     = '';
            $default_lang    = '';
            $playlist_id     = '';
            $related_id      = '';
            $parent_category_id = '';
            $royalty_free    = '';
            $rule_translate  = '';
            $rule_description = '';
            $topic_id        = '';
            $published_before = '';
            $published_after = '';
            $attach_screen = '';
            $rule_translate_source = '';
            $GLOBALS['wp_object_cache']->delete('youtubomatic_rules_list', 'options');
            if (!get_option('youtubomatic_rules_list')) {
                $rules = array();
            } else {
                $rules = get_option('youtubomatic_rules_list');
            }
            if (!empty($rules)) {
                foreach ($rules as $request => $bundle[]) {
                    if ($cont == $param) {
                        $bundle_values    = array_values($bundle);
                        $myValues         = $bundle_values[$cont];
                        $array_my_values  = array_values($myValues);for($iji=0;$iji<count($array_my_values);++$iji){if(is_string($array_my_values[$iji])){$array_my_values[$iji]=stripslashes($array_my_values[$iji]);}}
                        $ids              = isset($array_my_values[0]) ? $array_my_values[0] : '';
                        $schedule         = isset($array_my_values[1]) ? $array_my_values[1] : '';
                        $active           = isset($array_my_values[2]) ? $array_my_values[2] : '';
                        $last_run         = isset($array_my_values[3]) ? $array_my_values[3] : '';
                        $max              = isset($array_my_values[4]) ? $array_my_values[4] : '';
                        $post_status      = isset($array_my_values[5]) ? $array_my_values[5] : '';
                        $post_type        = isset($array_my_values[6]) ? $array_my_values[6] : '';
                        $post_user_name   = isset($array_my_values[7]) ? $array_my_values[7] : '';
                        $item_create_tag  = isset($array_my_values[8]) ? $array_my_values[8] : '';
                        $default_category = isset($array_my_values[9]) ? $array_my_values[9] : '';
                        $auto_categories  = isset($array_my_values[10]) ? $array_my_values[10] : '';
                        $can_create_tag   = isset($array_my_values[11]) ? $array_my_values[11] : '';
                        $enable_comments  = isset($array_my_values[12]) ? $array_my_values[12] : '';
                        $featured_image   = isset($array_my_values[13]) ? $array_my_values[13] : '';
                        $image_url        = isset($array_my_values[14]) ? $array_my_values[14] : '';
                        $post_title       = isset($array_my_values[15]) ? htmlspecialchars_decode($array_my_values[15]) : '';
                        $post_content     = isset($array_my_values[16]) ? htmlspecialchars_decode($array_my_values[16]) : '';
                        $enable_pingback  = isset($array_my_values[17]) ? $array_my_values[17] : '';
                        $post_format      = isset($array_my_values[18]) ? $array_my_values[18] : '';
                        $rule_keywords    = isset($array_my_values[19]) ? $array_my_values[19] : '';
                        $coord            = isset($array_my_values[20]) ? $array_my_values[20] : '';
                        $radius           = isset($array_my_values[21]) ? $array_my_values[21] : '';
                        $result_type      = isset($array_my_values[22]) ? $array_my_values[22] : '';
                        $channel_id       = isset($array_my_values[23]) ? $array_my_values[23] : '';
                        $event_type       = isset($array_my_values[24]) ? $array_my_values[24] : '';
                        $auto_generate_comments = isset($array_my_values[25]) ? $array_my_values[25] : '';
                        $video_category   = isset($array_my_values[26]) ? $array_my_values[26] : '';
                        $safe_search      = isset($array_my_values[27]) ? $array_my_values[27] : '';
                        $video_caption    = isset($array_my_values[28]) ? $array_my_values[28] : '';
                        $region_code      = isset($array_my_values[29]) ? $array_my_values[29] : '';
                        $video_definition = isset($array_my_values[30]) ? $array_my_values[30] : '';
                        $video_dimension  = isset($array_my_values[31]) ? $array_my_values[31] : '';
                        $video_duration2  = isset($array_my_values[32]) ? $array_my_values[32] : '';
                        $video_license    = isset($array_my_values[33]) ? $array_my_values[33] : '';
                        $video_type       = isset($array_my_values[34]) ? $array_my_values[34] : '';
                        $video_syndication = isset($array_my_values[35]) ? $array_my_values[35] : '';
                        $video_embeddable = isset($array_my_values[36]) ? $array_my_values[36] : '';
                        $enable_autoplay  = isset($array_my_values[37]) ? $array_my_values[37] : '';
                        $search_order     = isset($array_my_values[38]) ? $array_my_values[38] : '';
                        $detailed_info    = isset($array_my_values[39]) ? $array_my_values[39] : '';
                        $skip_old         = isset($array_my_values[40]) ? $array_my_values[40] : '';
                        $skip_day         = isset($array_my_values[41]) ? $array_my_values[41] : '';
                        $skip_month       = isset($array_my_values[42]) ? $array_my_values[42] : '';
                        $skip_year        = isset($array_my_values[43]) ? $array_my_values[43] : '';
                        $remove_default   = isset($array_my_values[44]) ? $array_my_values[44] : '';
                        $custom_fields    = isset($array_my_values[45]) ? $array_my_values[45] : '';
                        $date_from_video  = isset($array_my_values[46]) ? $array_my_values[46] : '';
                        $continue_search  = isset($array_my_values[47]) ? $array_my_values[47] : '';
                        $default_lang     = isset($array_my_values[48]) ? $array_my_values[48] : '';
                        $default_sep      = isset($array_my_values[49]) ? $array_my_values[49] : '';
                        $parent_category_id= isset($array_my_values[50]) ? $array_my_values[50] : '';
                        $custom_tax       = isset($array_my_values[51]) ? $array_my_values[51] : '';
                        $playlist_id      = isset($array_my_values[52]) ? $array_my_values[52] : '';
                        $related_id       = isset($array_my_values[53]) ? $array_my_values[53] : '';
                        $royalty_free     = isset($array_my_values[54]) ? $array_my_values[54] : '';
                        $rule_translate   = isset($array_my_values[55]) ? $array_my_values[55] : '';
                        $rule_translate_source = isset($array_my_values[56]) ? $array_my_values[56] : '';
                        $rule_description = isset($array_my_values[57]) ? $array_my_values[57] : '';
                        $topic_id         = isset($array_my_values[58]) ? $array_my_values[58] : '';
                        $published_before = isset($array_my_values[59]) ? $array_my_values[59] : '';
                        $published_after  = isset($array_my_values[60]) ? $array_my_values[60] : '';
                        $attach_screen    = isset($array_my_values[61]) ? $array_my_values[61] : '';
                        $found            = 1;
                        break;
                    }
                    $cont = $cont + 1;
                }
            } else {
                youtubomatic_log_to_file('No rules found for youtubomatic_rules_list!');
                if($auto == 1)
                {
                    youtubomatic_clearFromList($param);
                }
                return 'fail';
            }
            if ($found == 0) {
                youtubomatic_log_to_file($param . ' not found in youtubomatic_rules_list!');
                if($auto == 1)
                {
                    youtubomatic_clearFromList($param);
                }
                return 'fail';
            } else {
                if($ret_content == 0)
                {
                    $GLOBALS['wp_object_cache']->delete('youtubomatic_rules_list', 'options');
                    $rules = get_option('youtubomatic_rules_list');
                    $rules[$param][3] = youtubomatic_get_date_now();
                    update_option('youtubomatic_rules_list', $rules, false);
                }
            }
            if ($enable_comments == '1') {
                $accept_comments = 'open';
            }
            $parameters = '';
            
            if(stristr($rule_keywords, 'user:') !== false)
            {
                $rule_keywordsx = explode('user:', $rule_keywords);
                if(isset($rule_keywordsx[1]) && trim($rule_keywordsx[1]) != '')
                {
                    $rule_keywordsx = trim($rule_keywordsx[1]);
                    $feed_uri = 'https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=' . $rule_keywordsx . '&key=' . $za_app;
                    $chi  = curl_init();
                    if ($chi === FALSE) {
                        if($continue_search == '1')
                        {
                            $skip_posts_temp[$param] = '';
                            update_option('youtubomatic_continue_search', $skip_posts_temp);
                        }
                        youtubomatic_log_to_file('Failed to init curl in feed_uri!');
                        if($auto == 1)
                        {
                            youtubomatic_clearFromList($param);
                        }
                        return 'fail';
                    }
                    if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
                        curl_setopt($chi, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
                        if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
                            curl_setopt($chi, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
                        }
                    }
                    curl_setopt($chi, CURLOPT_CONNECTTIMEOUT, 10);
                    curl_setopt($chi, CURLOPT_TIMEOUT, 10);
                    curl_setopt($chi, CURLOPT_HTTPGET, 1);
                    curl_setopt($chi, CURLOPT_REFERER, get_site_url());
                    curl_setopt($chi, CURLOPT_URL, $feed_uri);
                    curl_setopt($chi, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($chi, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($chi, CURLOPT_SSL_VERIFYPEER, 0);
                    $execx = curl_exec($chi);
                    if ($execx === FALSE) {
                        if($continue_search == '1')
                        {
                            $skip_posts_temp[$param] = '';
                            update_option('youtubomatic_continue_search', $skip_posts_temp);
                        }
                        youtubomatic_log_to_file('Failed to exec curl in get user id!' . curl_error($chi) . ' - ' . curl_errno($chi));
                        curl_close($chi);
                        if($auto == 1)
                        {
                            youtubomatic_clearFromList($param);
                        }
                        return 'fail';
                    }
                    curl_close($chi);
                    $json  = json_decode($execx);
                    if(isset($json->items[0]->contentDetails->relatedPlaylists->uploads))
                    {
                        $playlist_id = $json->items[0]->contentDetails->relatedPlaylists->uploads;
                        $feed_uri = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&key=' . $za_app . '&playlistId=' . $playlist_id;
                        $skip_posts = '';
                        if($continue_search == '1')
                        {
                            $GLOBALS['wp_object_cache']->delete('youtubomatic_continue_search', 'options');
                            $skip_posts_temp = get_option('youtubomatic_continue_search', false);
                            if(isset($skip_posts_temp[$param]) && $skip_posts_temp[$param] !== '')
                            {
                                $skip_posts = $skip_posts_temp[$param];
                            }
                        }
                        else
                        {
                            $GLOBALS['wp_object_cache']->delete('youtubomatic_continue_search', 'options');
                            $skip_posts_temp = get_option('youtubomatic_continue_search', false);
                            $skip_posts_temp[$param] = '';
                            update_option('youtubomatic_continue_search', $skip_posts_temp);
                        }
                        if($skip_posts !== '')
                        {
                            $feed_uri .= '&pageToken=' . $skip_posts;
                        }
                        if (isset($youtubomatic_Main_Settings['continue_search']) && $youtubomatic_Main_Settings['continue_search'] == 'on') 
                        {
                            $feed_uri .= '&maxResults=50';
                        }
                        else
                        {
                            $feed_uri .= '&maxResults='.$max;
                        }
                    }
                    else
                    {
                        youtubomatic_log_to_file('Failed to get user playlist ID from call: ' . print_r($json, true));
                        if($auto == 1)
                        {
                            youtubomatic_clearFromList($param);
                        }
                        return 'fail';
                    }
                }
                else
                {
                    youtubomatic_log_to_file('Failed to get user name from query: ' . $rule_keywords);
                    if($auto == 1)
                    {
                        youtubomatic_clearFromList($param);
                    }
                    return 'fail';
                }
            }
            elseif(trim($playlist_id) != '')
            {
                $feed_uri = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&key=' . $za_app . '&playlistId=' . trim($playlist_id);
                $skip_posts = '';
                if($continue_search == '1')
                {
                    $GLOBALS['wp_object_cache']->delete('youtubomatic_continue_search', 'options');
                    $skip_posts_temp = get_option('youtubomatic_continue_search', false);
                    if(isset($skip_posts_temp[$param]) && $skip_posts_temp[$param] !== '')
                    {
                        $skip_posts = $skip_posts_temp[$param];
                    }
                }
                else
                {
                    $GLOBALS['wp_object_cache']->delete('youtubomatic_continue_search', 'options');
                    $skip_posts_temp = get_option('youtubomatic_continue_search', false);
                    $skip_posts_temp[$param] = '';
                    update_option('youtubomatic_continue_search', $skip_posts_temp);
                }
                if($skip_posts !== '')
                {
                    $feed_uri .= '&pageToken=' . $skip_posts;
                }
                if (isset($youtubomatic_Main_Settings['continue_search']) && $youtubomatic_Main_Settings['continue_search'] == 'on') 
                {
                    $feed_uri .= '&maxResults=50';
                }
                else
                {
                    $feed_uri .= '&maxResults='.$max;
                }
            }
            else
            {
                if($related_id == '')
                {
                    if($coord != '' && $radius != '')
                    {
                        $geocode = youtubomatic_get_web_page("http://maps.google.com/maps/api/geocode/json?address=" . urlencode(trim($coord)) . "&sensor=false");
                        if($geocode === false)
                        {
                            global $wp_filesystem;
                            if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                                include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                                wp_filesystem($creds);
                            }
                            $geocode = $wp_filesystem->get_contents("http://maps.google.com/maps/api/geocode/json?address=" . urlencode(trim($coord)) . "&sensor=false");
                        }
                        if($geocode !== FALSE)
                        {
                            $output = json_decode($geocode);
                            if(isset($output->results[0]->geometry->location->lat) && isset($output->results[0]->geometry->location->lng))
                            {
                                $lat = $output->results[0]->geometry->location->lat;
                                $lng = $output->results[0]->geometry->location->lng;
                                $parameters .= '&location=' . $lat . ',' . $lng;
                                $parameters .= '&locationRadius=' . urlencode(trim($radius));
                            }
                        }
                    }
                }
                $feed_uri = 'https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&key=' . $za_app;
                $skip_posts = '';
                if($continue_search == '1')
                {
                    $GLOBALS['wp_object_cache']->delete('youtubomatic_continue_search', 'options');
                    $skip_posts_temp = get_option('youtubomatic_continue_search', false);
                    if(isset($skip_posts_temp[$param]) && $skip_posts_temp[$param] !== '')
                    {
                        $skip_posts = $skip_posts_temp[$param];
                    }
                }
                else
                {
                    $GLOBALS['wp_object_cache']->delete('youtubomatic_continue_search', 'options');
                    $skip_posts_temp = get_option('youtubomatic_continue_search', false);
                    $skip_posts_temp[$param] = '';
                    update_option('youtubomatic_continue_search', $skip_posts_temp);
                }
                if($skip_posts !== '')
                {
                    $feed_uri .= '&pageToken=' . $skip_posts;
                }
                if (isset($youtubomatic_Main_Settings['continue_search']) && $youtubomatic_Main_Settings['continue_search'] == 'on') 
                {
                    $feed_uri .= '&maxResults=50';
                }
                else
                {
                    $feed_uri .= '&maxResults='.$max;
                }
                if($region_code != 'any' && $region_code != '')
                {
                    $feed_uri .= '&regionCode=' . $region_code;
                }
                if($safe_search != 'moderate' && $safe_search != '')
                {
                    $feed_uri .= '&safeSearch=' . $safe_search;
                }
                if($ids != 'any' && $ids != '')
                {
                    $feed_uri.='&relevanceLanguage='.$ids;
                }
                if($related_id != '')
                {
                    $feed_uri .= '&relatedToVideoId='.$related_id;
                }
                else
                {
                    if($channel_id != '')
                    {
                        $feed_uri .= '&channelId=' . $channel_id;
                    }
                    if($published_before != '')
                    {
                        $published_before = strtotime($published_before);
                        if($published_before !== false)
                        {
                            $published_before = date('Y-m-d\TH:i:s\Z', $published_before);
                            if($published_before !== false)
                            {
                                $feed_uri .= '&publishedBefore=' . $published_before;
                            }
                        }
                    }
                    if($published_after != '')
                    {
                        $published_after = strtotime($published_after);
                        if($published_after !== false)
                        {
                            $published_after = date('Y-m-d\TH:i:s\Z', $published_after);
                            if($published_after !== false)
                            {
                                $feed_uri .= '&publishedAfter=' . $published_after;
                            }
                        }
                    }
                    if($topic_id != '')
                    {
                        $feed_uri .= '&topicId=' . $topic_id;
                    }
                    if($event_type != '' && $event_type != 'uploaded')
                    {
                        $feed_uri .= '&eventType=' . $event_type;
                    }
                    if($rule_keywords != '*')
                    {
                        $feed_uri .= '&q='.urlencode(trim(stripslashes(str_replace('&quot;', '"', $rule_keywords))));
                    }
                    if($result_type != 'any' && $result_type != '')
                    {
                        $feed_uri .= '&channelType=' . $result_type;
                    }
                    if($video_category != '0' && $video_category != '')
                    {
                        $feed_uri .= '&videoCategoryId=' . $video_category;
                    }
                    if($video_caption != 'any' && $video_caption != '')
                    {
                        $feed_uri .= '&videoCaption=' . $video_caption;
                    }
                    if($video_type != 'any' && $video_type != '')
                    {
                        $feed_uri .= '&videoType=' . $video_type;
                    }
                    if($video_syndication != 'any' && $video_syndication != '')
                    {
                        $feed_uri .= '&videoSyndicated=' . $video_syndication;
                    }
                    if($video_embeddable != 'any' && $video_embeddable != '')
                    {
                        $feed_uri .= '&videoEmbeddable=' . $video_embeddable;
                    }
                    if($video_definition != 'any' && $video_definition != '')
                    {
                        $feed_uri .= '&videoDefinition=' . $video_definition;
                    }
                    if($search_order != 'relevance' && $search_order != '')
                    {
                        $feed_uri .= '&order=' . $search_order;
                    }
                    if($video_duration2 != 'any' && $video_duration2 != '')
                    {
                        $feed_uri .= '&videoDuration=' . $video_duration2;
                    }
                    if($video_dimension != 'any' && $video_dimension != '')
                    {
                        $feed_uri .= '&videoDimension=' . $video_dimension;
                    }
                    if($video_license != 'any' && $video_license != '')
                    {
                        $feed_uri .= '&videoLicense=' . $video_license;
                    }
                    if($parameters != '')
                    {
                        $feed_uri.=$parameters;
                    }
                }
            }
            $ch  = curl_init();
            if ($ch === FALSE) {
                if($continue_search == '1')
                {
                    $skip_posts_temp[$param] = '';
                    update_option('youtubomatic_continue_search', $skip_posts_temp);
                }
                youtubomatic_log_to_file('Failed to init curl in feed_uri!');
                if($auto == 1)
                {
                    youtubomatic_clearFromList($param);
                }
                return 'fail';
            }
			if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
				curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
				if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
					curl_setopt($ch, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
				}
			}
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            curl_setopt($ch, CURLOPT_REFERER, get_site_url());
            curl_setopt($ch, CURLOPT_URL, $feed_uri);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $exec=curl_exec($ch);
            
            if ($exec === FALSE) {
                if($continue_search == '1')
                {
                    $skip_posts_temp[$param] = '';
                    update_option('youtubomatic_continue_search', $skip_posts_temp);
                }
                youtubomatic_log_to_file('Failed to exec curl in feed_uri!' . curl_error($ch) . ' - ' . curl_errno($ch));
                curl_close($ch);
                if($auto == 1)
                {
                    youtubomatic_clearFromList($param);
                }
                return 'fail';
            }
            curl_close($ch);
            $json  = json_decode($exec);
            if(!isset($json->items))
            {
                if($continue_search == '1')
                {
                    $skip_posts_temp[$param] = '';
                    update_option('youtubomatic_continue_search', $skip_posts_temp);
                }
                youtubomatic_log_to_file('Failed to fetch items: feed_uri: ' . $feed_uri . ' , response: ' . print_r($json, true));
                if($auto == 1)
                {
                    youtubomatic_clearFromList($param);
                }
                return 'fail';
            }
            if($continue_search == '1')
            {
                if(isset($json->nextPageToken))
                {
                    $skip_posts_temp[$param] = $json->nextPageToken;
                    update_option('youtubomatic_continue_search', $skip_posts_temp);
                }
                else
                {
                    $skip_posts_temp[$param] = '';
                    update_option('youtubomatic_continue_search', $skip_posts_temp);
                }
            }
            $items = $json->items;
            if (count($items) == 0) {
                if($continue_search == '1')
                {
                    $skip_posts_temp[$param] = '';
                    update_option('youtubomatic_continue_search', $skip_posts_temp);
                }
                youtubomatic_log_to_file('No posts inserted because no videos found.');
                if($auto == 1)
                {
                    youtubomatic_clearFromList($param);
                }
                return 'nochange';
            }
            if (isset($youtubomatic_Main_Settings['no_dup_check']) && $youtubomatic_Main_Settings['no_dup_check'] == 'on') {
            }
            else
            {
                $post_list = array();
                $postsPerPage = 50000;
                $paged = 0;
                do
                {
                    $postOffset = $paged * $postsPerPage;
                    $query = array(
                        'post_status' => array(
                            'publish',
                            'draft',
                            'pending',
                            'trash',
                            'private',
                            'future'
                        ),
                        'post_type' => array(
                            'any'
                        ),
                        'numberposts' => $postsPerPage,
                        'meta_key' => 'youtubomatic_post_id',
                        'fields' => 'ids',
                        'offset'  => $postOffset
                    );
                    $got_me = get_posts($query);
                    $post_list = array_merge($post_list, $got_me);
                    $paged++;
                }while(!empty($got_me));
                wp_suspend_cache_addition(true);
                foreach ($post_list as $post) {
                    $posted_items[] = get_post_meta($post, 'youtubomatic_post_id', true);
                }
                wp_suspend_cache_addition(false);
            }
            $count = 1;
            if($default_lang != '')
            {
                $default_lang = explode(',', $default_lang);
                $default_lang = array_map( 'trim', $default_lang );
            }
            else
            {
                $default_lang = array();
            }
            if($default_sep == '')
            {
                $default_sep = ' ';
            }
            $init_date = time();
            $skip_pcount = 0;
            $skipped_pcount = 0;
            if($ret_content == 1)
            {
                $item_xcounter = count($items);
                $skip_pcount = rand(0, $item_xcounter-1);
            }
            if(isset($youtubomatic_Main_Settings['attr_text']) && $youtubomatic_Main_Settings['attr_text'] != '')
            {
                $img_attr = $youtubomatic_Main_Settings['attr_text'];
            }
            else
            {
                $img_attr = '';
            }
            foreach ($items as $item) {
                if($ret_content == 1)
                {
                    if($skip_pcount > $skipped_pcount)
                    {
                        $skipped_pcount++;
                        continue;
                    }
                }
                $title = htmlspecialchars_decode(addslashes($item->snippet->title ), ENT_QUOTES);
                if($title == 'Private video'){
                    if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                        youtubomatic_log_to_file('Skipping post "' . $item->snippet->title . '", because it is private.');
                    }
                    continue;
                }
                $vid_found = false;
                if(trim($playlist_id) != '')
                {
                    $video_id = $item->snippet->resourceId->videoId;
                }
                else
                {
                    $video_id = $item->id->videoId;
                }
                $url = 'https://www.youtube.com/watch?v='.$video_id;
                if ($count > intval($max)) {
                    break;
                }
                if (in_array($video_id, $posted_items)) {
                    if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                        youtubomatic_log_to_file('Skipping post "' . $item->snippet->title . '", because it is already posted.');
                    }
                    continue;
                }
                if ((isset($youtubomatic_Main_Settings['shortest_api']) && $youtubomatic_Main_Settings['shortest_api'] != '') || (isset($youtubomatic_Main_Settings['links_hide']) && $youtubomatic_Main_Settings['links_hide'] == 'on' && isset($youtubomatic_Main_Settings['apiKey'])))
                {
                    $short_url = youtubomatic_url_handle($url);
                }
                else
                {
                    $short_url = $url;
                }
                if($royalty_free == '1')
                {
                    $keyword_class = new Youtubomatic_keywords();
                    $query_words = $keyword_class->keywords($title, 2);
                    $get_img = youtubomatic_get_free_image($youtubomatic_Main_Settings, $query_words, $img_attr, 10);
                    if($get_img == '' || $get_img === false)
                    {
                        if(isset($youtubomatic_Main_Settings['bimage']) && $youtubomatic_Main_Settings['bimage'] == 'on')
                        {
                            $query_words = $keyword_class->keywords($title, 1);
                            $get_img = youtubomatic_get_free_image($youtubomatic_Main_Settings, $query_words, $img_attr, 20);
                            if($get_img == '' || $get_img === false)
                            {
                                if(isset($youtubomatic_Main_Settings['no_orig']) && $youtubomatic_Main_Settings['no_orig'] == 'on')
                                {
                                    $get_img = '';
                                }
                                else
                                {
                                    if (isset($youtubomatic_Main_Settings['wide_images']) && $youtubomatic_Main_Settings['wide_images'] == '169') {
                                        $get_img = $item->snippet->thumbnails->medium->url;
                                    }
                                    elseif (isset($youtubomatic_Main_Settings['wide_images']) && $youtubomatic_Main_Settings['wide_images'] == 'full') {
                                        $get_img = $item->snippet->thumbnails->high->url;
                                        $get_img_tmp = str_replace('hqdefault.jpg', 'maxresdefault.jpg', $get_img);
                                        if (getimagesize($get_img_tmp)) {
                                            $get_img = $get_img_tmp;
                                        }
                                    }
                                    else
                                    {
                                        $get_img = $item->snippet->thumbnails->high->url;
                                    }
                                }
                            }
                        }
                        else
                        {
                            if(isset($youtubomatic_Main_Settings['no_orig']) && $youtubomatic_Main_Settings['no_orig'] == 'on')
                            {
                                $get_img = '';
                            }
                            else
                            {
                                if (isset($youtubomatic_Main_Settings['wide_images']) && $youtubomatic_Main_Settings['wide_images'] == '169') {
                                    $get_img = $item->snippet->thumbnails->medium->url;
                                }
                                elseif (isset($youtubomatic_Main_Settings['wide_images']) && $youtubomatic_Main_Settings['wide_images'] == 'full') {
                                    $get_img = $item->snippet->thumbnails->high->url;
                                    $get_img_tmp = str_replace('hqdefault.jpg', 'maxresdefault.jpg', $get_img);
                                    if (getimagesize($get_img_tmp)) {
                                        $get_img = $get_img_tmp;
                                    }
                                }
                                else
                                {
                                    $get_img = $item->snippet->thumbnails->high->url;
                                }
                            }
                        }
                    }
                }
                else
                {
                    if (isset($youtubomatic_Main_Settings['wide_images']) && $youtubomatic_Main_Settings['wide_images'] == '169') {
                        $get_img = $item->snippet->thumbnails->medium->url;
                    }
                    elseif (isset($youtubomatic_Main_Settings['wide_images']) && $youtubomatic_Main_Settings['wide_images'] == 'full') {
                        $get_img = $item->snippet->thumbnails->high->url;
                        $get_img_tmp = str_replace('hqdefault.jpg', 'maxresdefault.jpg', $get_img);
                        if (getimagesize($get_img_tmp)) {
                            $get_img = $get_img_tmp;
                        }
                    }
                    else
                    {
                        $get_img = $item->snippet->thumbnails->high->url;
                    }
                }
                $videotags = '';
                if($detailed_info == '1')
                {
                    $curl='https://www.googleapis.com/youtube/v3/videos?key=' . $za_app . '&part=statistics,contentDetails,snippet&id='.$video_id;
                    $ch  = curl_init();
                    if ($ch === FALSE) {
                        youtubomatic_log_to_file('Failed to init curl in detailed_info!');
                        continue;
                    }
					if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
						curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
						if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
							curl_setopt($ch, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
						}
					}
                    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                    curl_setopt($ch, CURLOPT_HTTPGET, 1);
                    curl_setopt($ch, CURLOPT_REFERER, get_site_url());
                    curl_setopt($ch, CURLOPT_URL, $curl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    $exec=curl_exec($ch);
                    if ($exec === FALSE) {
                        youtubomatic_log_to_file('Failed to exec curl in detailed_info!' . curl_error($ch) . ' - ' . curl_errno($ch));
                        curl_close($ch);
                        continue;
                    }
                    curl_close($ch);
                    if(stristr($exec, 'items') === FALSE){
                        youtubomatic_log_to_file('Invalid reply from API in advanced info : ' . $exec);
                        continue;
                    }
                    $adv_json = json_decode($exec);
                    if($adv_json !== false && isset($adv_json->items[0]))
                    {
                        $adv_item = $adv_json->items[0];
                        $content = htmlspecialchars_decode($adv_item->snippet->description, ENT_QUOTES);
                        $date = $adv_item->snippet->publishedAt;
                        $video_duration = $adv_item->contentDetails->duration;
                        $video_dimension = $adv_item->contentDetails->dimension;
                        $video_definition = $adv_item->contentDetails->definition;
                        $video_caption = $adv_item->contentDetails->caption;
                        $video_licensed_content = $adv_item->contentDetails->licensedContent;
                        $video_projection = $adv_item->contentDetails->projection;
                        if(isset($adv_item->statistics->favoriteCount))
                        {
                            $video_favorite_count = $adv_item->statistics->favoriteCount;
                        }
                        else
                        {
                            $video_favorite_count = '';
                        }
                        
                        if(isset($adv_item->statistics->commentCount))
                        {
                            $video_comment_count = $adv_item->statistics->commentCount;
                        }
                        else
                        {
                            $video_comment_count = '';
                        }
                        if(isset($adv_item->statistics->viewCount))
                        {
                            $video_views = $adv_item->statistics->viewCount;
                        }
                        else
                        {
                            $video_views = '';
                        }
                        
                        if(isset($adv_item->statistics->likeCount))
                        {
                            $video_likeCount = $adv_item->statistics->likeCount;
                        }
                        else
                        {
                            $video_likeCount = '';
                        }
                        if(isset($adv_item->statistics->dislikeCount))
                        {
                            $video_dislikeCount = $adv_item->statistics->dislikeCount;
                        }
                        else
                        {
                            $video_dislikeCount = '';
                        }
                        if(is_numeric($video_likeCount) && is_numeric($video_dislikeCount) && $video_likeCount + $video_dislikeCount > 0)
                        {
                            $video_rating = $video_likeCount/($video_likeCount + $video_dislikeCount) * 5;
                            $video_rating = number_format($video_rating, 2);
                        }
                        else
                        {
                            $video_rating = '';
                        }
                        if(isset($adv_item->snippet->tags))
                        {
                            foreach($adv_item->snippet->tags as $tag)
                            {
                                $videotags .= $tag . ',';
                            }
                            $videotags = trim($videotags, ',');
                        }
                        if(isset($adv_item->snippet->categoryId))
                        {
                            $categoryId = $adv_item->snippet->categoryId;
                        }
                        else
                        {
                            $categoryId = '';
                        }
                        if(isset($adv_item->snippet->defaultAudioLanguage))
                        {
                            $defaultAudioLanguage = $adv_item->snippet->defaultAudioLanguage;
                        }
                        else
                        {
                            $defaultAudioLanguage = '';
                        }
                    }
                    else
                    {
                        $content = htmlspecialchars_decode($adv_item->snippet->description, ENT_QUOTES);
                        $date = $item->snippet->publishedAt;
                        $video_duration = '';
                        $defaultAudioLanguage = '';
                        $video_views = '';
                        $categoryId = '';
                        $video_likeCount = '';
                        $video_dislikeCount = '';
                        $video_rating = '';
                        $video_dimension = '';
                        $video_definition = '';
                        $video_caption = '';
                        $video_licensed_content = '';
                        $video_projection = '';
                        $video_favorite_count = '';
                        $video_comment_count = '';
                       
                        $ch  = curl_init();
                        if ($ch !== FALSE) {
                            if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
                                curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
                                if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
                                    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
                                }
                            }
                            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                            curl_setopt($ch, CURLOPT_HTTPGET, 1);
                            curl_setopt($ch, CURLOPT_REFERER, get_site_url());
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                            $exec=curl_exec($ch);
                            if ($exec !== FALSE) {
                                if(stristr($exec, 'name="keywords"')){
                                    preg_match_all('/keywords" content="(.*?)"/', $exec,$matches);
                                    if(isset($matches[1][0]))
                                    {
                                        $videotags = $matches[1][0];
                                    }
                                }
                                if(stristr($exec, 'itemprop="duration"')){
                                    preg_match_all('/duration" content="(.*?)"/', $exec,$matches);
                                    if(isset($matches[1][0]))
                                    {
                                        $video_duration = $matches[1][0];
                                    }
                                }
                            }
                            curl_close($ch);
                        }   
                    }
                }
                else
                {
                    $content = htmlspecialchars_decode($item->snippet->description, ENT_QUOTES);
                    $date = $item->snippet->publishedAt;
                    $video_duration = '';
                    $defaultAudioLanguage = '';
                    $video_views = '';
                    $categoryId = '';
                    $video_likeCount = '';
                    $video_dislikeCount = '';
                    $video_rating = '';
                    $video_dimension = '';
                    $video_definition = '';
                    $video_caption = '';
                    $video_licensed_content = '';
                    $video_projection = '';
                    $video_favorite_count = '';
                    $video_comment_count = '';
                   
					$ch  = curl_init();
                    if ($ch !== FALSE) {
						if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
							curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
							if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
								curl_setopt($ch, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
							}
						}
                        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
                        curl_setopt($ch, CURLOPT_HTTPGET, 1);
                        curl_setopt($ch, CURLOPT_REFERER, get_site_url());
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        $exec=curl_exec($ch);
                        if ($exec !== FALSE) {
                            if(stristr($exec, 'name="keywords"')){
                                preg_match_all('/keywords" content="(.*?)"/', $exec,$matches);
                                if(isset($matches[1][0]))
                                {
                                    $videotags = $matches[1][0];
                                }
                            }
                            if(stristr($exec, 'itemprop="duration"')){
                                preg_match_all('/duration" content="(.*?)"/', $exec,$matches);
                                if(isset($matches[1][0]))
                                {
                                    $video_duration = $matches[1][0];
                                }
                            }
                        }
                        curl_close($ch);
                    }
                }
                if(isset($youtubomatic_Main_Settings['litte_translate']) && $youtubomatic_Main_Settings['litte_translate'] == 'on')
                {
                    $arr                = youtubomatic_spin_and_translate($title, $content, $rule_translate, $rule_translate_source);
                    $title              = $arr[0];
                    $content            = $arr[1];
                }
                $returned_caption = '';
                $preffered_id = '';
                $preffered_lang = '';
                if(strpos($post_content, '%%video_caption%%') !== false || strpos($custom_tax, '%%video_caption%%') !== false || strpos($custom_fields, '%%video_caption%%') !== false)
                {
                    if (!isset($youtubomatic_Main_Settings['only_auto']) || $youtubomatic_Main_Settings['only_auto'] != "on") 
                    {
                        $curl = 'http://video.google.com/timedtext?type=list&v=' . $video_id;
                        $ccdata = youtubomatic_get_web_page($curl);
                        if($ccdata == '')
                        {
                            $curl = 'https://www.youtube.com/api/timedtext?type=list&v=' . $video_id;
                            $ccdata = youtubomatic_get_web_page($curl);
                        }
                        if($ccdata !== false)
                        {
                            if(strstr($ccdata, 's all we know.</ins>') === false && strstr($ccdata, 's an error.</ins>') === false)
                            {
                                libxml_use_internal_errors(true);
                                $ccdata = str_replace(array("\n", "\r", "\t"), '', $ccdata);
                                $ccdata = trim(str_replace('"', "'", $ccdata));
                                $xml = simplexml_load_string($ccdata);
                                if($xml == false)
                                {
                                    $exc = false;
                                    try
                                    {
                                        $xml = new SimpleXMLElement($ccdata);
                                    }
                                    catch(Exception $e)
                                    {
                                        youtubomatic_log_to_file('Exception in xml parsing: ' . esc_html($e->getMessage()) . ' - url: ' . $curl . ' - data: ' . $ccdata);
                                    }
                                    $xml = (array)$xml;
                                    $xml = json_decode(json_encode($xml), FALSE);
                                    if(isset($xml->track))
                                    {
                                        if(count($xml->track) > 0)
                                        {
                                            $found_id = count($default_lang) + 1;
                                            foreach($xml->track as $child)
                                            {
                                                if(count($default_lang) > 0)
                                                {
                                                    foreach($default_lang as $key => $pl)
                                                    {
                                                        if(stristr($child->lang_code, $pl) !== false && $key < $found_id)
                                                        {
                                                            $found_id = $key;
                                                            $preffered_id = $child->id;
                                                            $preffered_lang = $child->lang_code;
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    if($child->lang_default == 'true')
                                                    {
                                                        $preffered_id = $child->id;
                                                        $preffered_lang = $child->lang_code;
                                                    }
                                                }
                                            }
                                            if($preffered_id != '')
                                            {
                                                $tcurl = 'http://video.google.com/timedtext?type=track&v=' . $video_id . '&id=' . $preffered_id . '&lang=' . $preffered_lang;
                                                $tccdata = youtubomatic_get_web_page($tcurl);
                                                if($tccdata != false)
                                                {
                                                    $txml = simplexml_load_string($tccdata);
                                                    if($txml == false)
                                                    {
                                                        try
                                                        {
                                                            $txml = new SimpleXMLElement($tccdata);
                                                        }
                                                        catch(Exception $e)
                                                        {
                                                            youtubomatic_log_to_file('Exception in xml parsing2: ' . esc_html($e->getMessage()) . ' data: ' . $tccdata);
                                                        }
                                                        $txml = (array)$txml;
                                                        $txml = json_decode(json_encode($txml), FALSE);
                                                    }
                                                    if(count($txml->text) > 0)
                                                    {
                                                        $remove_character = array("\n", "\r\n", "\r");
                                                        foreach($txml->text as $tchild)
                                                        {
                                                            if($default_sep == ' ')
                                                            {
                                                                $tchild = str_replace($remove_character , ' ', $tchild);
                                                            }
                                                            $returned_caption .= trim(html_entity_decode($tchild, ENT_QUOTES | ENT_XML1, 'UTF-8')) . $default_sep;
                                                        }
                                                        
                                                    }
                                                }
                                                else
                                                {
                                                    youtubomatic_log_to_file('Failed to get cc advanced info page: http://video.google.com/timedtext?type=track&v=' . $video_id . '&id=' . $preffered_id . '&lang=' . $preffered_lang);
                                                }
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    if(isset($xml->track))
                                    {
                                        if(count($xml->track) > 0)
                                        {
                                            $found_id = count($default_lang) + 1;
                                            foreach($xml->track as $child)
                                            {
                                                if(count($default_lang) > 0)
                                                {
                                                    foreach($default_lang as $key => $pl)
                                                    {
                                                        if(stristr($child['lang_code'], $pl) !== false && $key < $found_id)
                                                        {
                                                            $found_id = $key;
                                                            $preffered_id = $child['id'];
                                                            $preffered_lang = $child['lang_code'];
                                                        }
                                                    }
                                                }
                                                else
                                                {
                                                    if($child['lang_default'] == 'true')
                                                    {
                                                        $preffered_id = $child['id'];
                                                        $preffered_lang = $child['lang_code'];
                                                    }
                                                }
                                            }
                                            if($preffered_id != '')
                                            {
                                                $tcurl = 'http://video.google.com/timedtext?type=track&v=' . $video_id . '&id=' . $preffered_id . '&lang=' . $preffered_lang;
                                                $tccdata = youtubomatic_get_web_page($tcurl);
                                                $txml = simplexml_load_string($tccdata);
                                                if($txml == false)
                                                {
                                                    $parser = xml_parser_create();
                                                    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
                                                    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
                                                    xml_parse_into_struct($parser, $tccdata, $txml, $tags);
                                                    xml_parser_free($parser);
                                                    $txml = json_decode(json_encode($txml), FALSE);
                                                }
                                                if(count($txml->text) > 0)
                                                {
                                                    $remove_character = array("\n", "\r\n", "\r");
                                                    foreach($txml->text as $tchild)
                                                    {
                                                        if($default_sep == ' ')
                                                        {
                                                            $tchild = str_replace($remove_character , ' ', $tchild);
                                                        }
                                                        $returned_caption .= trim(html_entity_decode($tchild, ENT_QUOTES | ENT_XML1, 'UTF-8')) . $default_sep;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        else
                        {
                            youtubomatic_log_to_file("Failed to get xml page: " . 'http://video.google.com/timedtext?type=list&v=' . $video_id);
                        }
                    }
                    if($returned_caption == '')
                    {
                        $baseUrl = youtubomatic_getBaseClosedCaptionsUrl($video_id);
                        if($baseUrl !== false)
                        {
                            $availableTracks = youtubomatic_getAvailableTracks($baseUrl);
                            if($availableTracks !== false)
                            {
                                $skip_xlang = false;
                                if(count($default_lang) > 0)
                                {
                                    foreach ($availableTracks as $xkey => $track) 
                                    {
                                        foreach($default_lang as $key => $pl)
                                        {
                                            if(stristr($track['lang'], $pl) !== false)
                                            {
                                                $skip_xlang = $track['lang'];
                                                break;
                                            }
                                        }
                                    }
                                }
                                
                                foreach ($availableTracks as $key => $track) 
                                {
                                    if($skip_xlang !== false)
                                    {
                                        if($track['lang'] != $skip_xlang)
                                        {
                                            continue;
                                        }
                                    }
                                    $yttext = youtubomatic_getClosedCaptionText($baseUrl, $track);
                                    if($yttext !== false && is_array($yttext))
                                    {
                                        $remove_character = array("\n", "\r\n", "\r");
                                        foreach($yttext as $ycapt)
                                        {
                                            if($default_sep == ' ')
                                            {
                                                $ycapt = str_replace($remove_character , ' ', $ycapt);
                                            }
                                            $returned_caption .= trim($ycapt) . $default_sep;
                                        }
                                    }
                                    if($returned_caption != '')
                                    {
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
                if($returned_caption != '' && $default_sep == ' ')
                {
                    $returned_caption = youtubomatic_breakLongText($returned_caption);
                }
                $content = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$0</a>', $content);
                $channelId = $item->snippet->channelId;
                $youtubeVideo = "https://www.youtube.com/embed/" . $video_id;
                if (isset($youtubomatic_Main_Settings['player_width']) && $youtubomatic_Main_Settings['player_width'] !== '') {
                    $width = esc_attr($youtubomatic_Main_Settings['player_width']);
                }
                else
                {
                    $width = 580;
                }
                if (isset($youtubomatic_Main_Settings['player_height']) && $youtubomatic_Main_Settings['player_height'] !== '') {
                    $height = esc_attr($youtubomatic_Main_Settings['player_height']);
                }
                else
                {
                    $height = 380;
                }
                
                if($enable_autoplay == '1')
                {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&autoplay=1';
                    }
                    else
                    {
                        $youtubeVideo .= '?autoplay=1';
                    }
                    
                }
                if (isset($youtubomatic_Main_Settings['show_closed_captions']) && $youtubomatic_Main_Settings['show_closed_captions'] == '1') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&cc_load_policy=1';
                    }
                    else
                    {
                        $youtubeVideo .= '?cc_load_policy=1';
                    }
                }
                if (isset($youtubomatic_Main_Settings['color_theme']) && $youtubomatic_Main_Settings['color_theme'] == 'white') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&color=white';
                    }
                    else
                    {
                        $youtubeVideo .= '?color=white';
                    }
                }
                if (isset($youtubomatic_Main_Settings['video_controls']) && $youtubomatic_Main_Settings['video_controls'] !== '2') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&controls='.esc_attr($youtubomatic_Main_Settings['video_controls']);
                    }
                    else
                    {
                        $youtubeVideo .= '?controls='.esc_attr($youtubomatic_Main_Settings['video_controls']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['keyboard_control']) && $youtubomatic_Main_Settings['keyboard_control'] !== '0') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&disablekb='.esc_attr($youtubomatic_Main_Settings['keyboard_control']);
                    }
                    else
                    {
                        $youtubeVideo .= '?disablekb='.esc_attr($youtubomatic_Main_Settings['keyboard_control']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['iframe_api']) && $youtubomatic_Main_Settings['iframe_api'] !== '0') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&enablejsapi='.esc_attr($youtubomatic_Main_Settings['iframe_api']) . '&origin=' . urlencode(get_site_url());
                    }
                    else
                    {
                        $youtubeVideo .= '?enablejsapi='.esc_attr($youtubomatic_Main_Settings['iframe_api']) . '&origin=' . urlencode(get_site_url());
                    }
                }
                if (isset($youtubomatic_Main_Settings['stop_after']) && $youtubomatic_Main_Settings['stop_after'] !== '') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&end='.esc_attr($youtubomatic_Main_Settings['stop_after']);
                    }
                    else
                    {
                        $youtubeVideo .= '?end='.esc_attr($youtubomatic_Main_Settings['stop_after']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['start_after']) && $youtubomatic_Main_Settings['start_after'] !== '') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&start='.esc_attr($youtubomatic_Main_Settings['start_after']);
                    }
                    else
                    {
                        $youtubeVideo .= '?start='.esc_attr($youtubomatic_Main_Settings['start_after']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['show_fullscreen_button']) && $youtubomatic_Main_Settings['show_fullscreen_button'] !== '1') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&fs='.esc_attr($youtubomatic_Main_Settings['show_fullscreen_button']);
                    }
                    else
                    {
                        $youtubeVideo .= '?fs='.esc_attr($youtubomatic_Main_Settings['show_fullscreen_button']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['player_language']) && $youtubomatic_Main_Settings['player_language'] !== 'default') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&hl='.esc_attr($youtubomatic_Main_Settings['player_language']);
                    }
                    else
                    {
                        $youtubeVideo .= '?hl='.esc_attr($youtubomatic_Main_Settings['player_language']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['video_annotations']) && $youtubomatic_Main_Settings['video_annotations'] !== '1') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&iv_load_policy='.esc_attr($youtubomatic_Main_Settings['video_annotations']);
                    }
                    else
                    {
                        $youtubeVideo .= '?iv_load_policy='.esc_attr($youtubomatic_Main_Settings['video_annotations']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['loop_video']) && $youtubomatic_Main_Settings['loop_video'] !== '0') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&loop='.esc_attr($youtubomatic_Main_Settings['loop_video']) . '&playlist=' . $video_id;
                    }
                    else
                    {
                        $youtubeVideo .= '?loop='.esc_attr($youtubomatic_Main_Settings['loop_video']) . '&playlist=' . $video_id;
                    }
                }
                if (isset($youtubomatic_Main_Settings['modest_branding']) && $youtubomatic_Main_Settings['modest_branding'] !== '0') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&modestbranding='.esc_attr($youtubomatic_Main_Settings['modest_branding']);
                    }
                    else
                    {
                        $youtubeVideo .= '?modestbranding='.esc_attr($youtubomatic_Main_Settings['modest_branding']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['show_related']) && $youtubomatic_Main_Settings['show_related'] !== '1') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&rel='.esc_attr($youtubomatic_Main_Settings['show_related']);
                    }
                    else
                    {
                        $youtubeVideo .= '?rel='.esc_attr($youtubomatic_Main_Settings['show_related']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['show_info']) && $youtubomatic_Main_Settings['show_info'] !== '1') {
                    if (strpos($youtubeVideo, '?') !== false) 
                    {
                        $youtubeVideo .= '&showinfo='.esc_attr($youtubomatic_Main_Settings['show_info']);
                    }
                    else
                    {
                        $youtubeVideo .= '?showinfo='.esc_attr($youtubomatic_Main_Settings['show_info']);
                    }
                }
                if (isset($youtubomatic_Main_Settings['image_ad']) && $youtubomatic_Main_Settings['image_ad'] != "") {
                    if (isset($youtubomatic_Main_Settings['image_ad_url']) && $youtubomatic_Main_Settings['image_ad_url'] != "") {
                        $image_ad_url = explode(',', $youtubomatic_Main_Settings['image_ad_url']);
                        $image_ad_url = trim($image_ad_url[array_rand($image_ad_url)]);
                    }
                    else
                    {
                        $image_ad_url = '#';
                    }
                    $image_ad_curr = explode(',', $youtubomatic_Main_Settings['image_ad']);
                    $image_ad_curr = trim($image_ad_curr[array_rand($image_ad_curr)]);
                    $add_me_script = '<a href="' . esc_url($image_ad_url) . '" id="youtubomatic_video" class="youtubomatic_show_hide" target="_blank">
    <img src="' . esc_url($image_ad_curr) . '" width="'.$width.'" height="'.$height.'" />
</a>
<div class="youtubomatic_slidingDiv">';
                    if (isset($youtubomatic_Main_Settings['player_style']) && $youtubomatic_Main_Settings['player_style'] !== '' && $youtubomatic_Main_Settings['player_style'] !== '0') {
                        if($youtubomatic_Main_Settings['player_style'] == '1')
                        {
                            $youtubeVideo = $add_me_script . '<div class="youtubomatic-video-container crf_marg youtubomatic_wh"><iframe align="center" width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div></div>';
                        }
                        elseif($youtubomatic_Main_Settings['player_style'] == '2')
                        {
                            $youtubeVideo = $add_me_script . '<div class="youtubomatic-video-container crf_marg2 youtubomatic_wh"><iframe width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div></div>';
                        }
                        elseif($youtubomatic_Main_Settings['player_style'] == '3')
                        {
                            $youtubeVideo = $add_me_script . '<div class="youtubomatic-video-container crf_marg3 youtubomatic_wh"><iframe width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div></div>';
                        }
                    }
                    else
                    {
                        $youtubeVideo = $add_me_script . '<div class="youtubomatic-video-container"><iframe width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div></div>';
                    }
                }
                else
                {
                    if (isset($youtubomatic_Main_Settings['player_style']) && $youtubomatic_Main_Settings['player_style'] !== '' && $youtubomatic_Main_Settings['player_style'] !== '0') {
                        if($youtubomatic_Main_Settings['player_style'] == '1')
                        {
                            $youtubeVideo = '<div class="youtubomatic-video-container crf_marg youtubomatic_wh"><iframe align="center" width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div>';
                        }
                        elseif($youtubomatic_Main_Settings['player_style'] == '2')
                        {
                            $youtubeVideo = '<div class="youtubomatic-video-container crf_marg2 youtubomatic_wh"><iframe width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div>';
                        }
                        elseif($youtubomatic_Main_Settings['player_style'] == '3')
                        {
                            $youtubeVideo = '<div class="youtubomatic-video-container crf_marg3 youtubomatic_wh"><iframe width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div>';
                        }
                    }
                    else
                    {
                        $youtubeVideo = '<div class="youtubomatic-video-container"><iframe width="'.$width.'" height="'.$height.'" src="' . esc_url($youtubeVideo) . '" frameborder="0" allowfullscreen></iframe></div>';
                    }
                    
                }
                
                $description = youtubomatic_getExcerpt($content);
                
                if (isset($item->snippet->channelTitle)) {
                    $author = $item->snippet->channelTitle;
                } else {
                    $author = 'Administrator';
                }
                $author_link = 'http://www.youtube.com/channel/' . $channelId;
                if ($author_link != '' && isset($youtubomatic_Main_Settings['links_hide']) && $youtubomatic_Main_Settings['links_hide'] == 'on' && isset($youtubomatic_Main_Settings['apiKey']))
                {
                    $author_link = youtubomatic_url_handle($author_link);
                }
                if (isset($youtubomatic_Main_Settings['skip_no_img']) && $youtubomatic_Main_Settings['skip_no_img'] == 'on' && $get_img == '') {
                    if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                        youtubomatic_log_to_file('Skipping post "' . esc_html($title) . '", because it has no detected image file attached');
                    }
                    continue;
                }
                
                if (isset($youtubomatic_Main_Settings['skip_old']) && $youtubomatic_Main_Settings['skip_old'] == 'on' && isset($youtubomatic_Main_Settings['skip_year']) && $youtubomatic_Main_Settings['skip_year'] !== '' && isset($youtubomatic_Main_Settings['skip_month']) && isset($youtubomatic_Main_Settings['skip_day'])) {
                    $old_date      = $youtubomatic_Main_Settings['skip_day'] . '-' . $youtubomatic_Main_Settings['skip_month'] . '-' . $youtubomatic_Main_Settings['skip_year'];
                    $time_date     = strtotime($date);
                    $time_old_date = strtotime($old_date);
                    if ($time_date !== false && $time_old_date !== false) {
                        if ($time_date < $time_old_date) {
                            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                                youtubomatic_log_to_file('Skipping post "' . esc_html($title) . '", because it is older than general date ' . $old_date . ' - posted on ' . $date);
                            }
                            continue;
                        }
                    }
                }
                if ($skip_old == '1' && $skip_year !== '' && $skip_month !== '' && $skip_day != '') {
                    $old_date      = $skip_day . '-' . $skip_month . '-' . $skip_year;
                    $time_date     = strtotime($date);
                    $time_old_date = strtotime($old_date);
                    if ($time_date !== false && $time_old_date !== false) {
                        if ($time_date < $time_old_date) {
                            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                                youtubomatic_log_to_file('Skipping post "' . esc_html($title) . '", because it is older than ' . $old_date . ' - posted on ' . $date);
                            }
                            continue;
                        }
                    }
                }
                $my_post                              = array();
                $my_post['insert_comments']               = $auto_generate_comments;
                $my_post['youtubomatic_post_id']          = $video_id;
                $my_post['youtubomatic_enable_pingbacks'] = $enable_pingback;
                $my_post['youtubomatic_post_image']       = $get_img;
                $my_post['default_category']          = $default_category;
                $my_post['post_type']                 = $post_type;
                $my_post['comment_status']            = $accept_comments;
                $my_post['post_status']               = $post_status;
                $my_post['post_author']               = $post_user_name;
                $my_post['youtubomatic_post_url']         = $short_url;
                $postdate = strtotime($date);
                if($postdate !== FALSE)
                {
                    $postdate = gmdate("Y-m-d H:i:s", intval($postdate));
                }
                if($date_from_video == '1')
                {
                    if($postdate !== FALSE)
                    {
                        $my_post['post_date_gmt'] = $postdate;
                    }
                    else
                    {
                        $postdatex = gmdate("Y-m-d H:i:s", intval($init_date));
                        $my_post['post_date_gmt'] = $postdatex;
                        $init_date = $init_date - 1;
                    }
                }
                else
                {
                    $postdatex = gmdate("Y-m-d H:i:s", intval($init_date));
                    $my_post['post_date_gmt'] = $postdatex;
                    $init_date = $init_date - 1;
                }
                if (isset($youtubomatic_Main_Settings['strip_by_id']) && $youtubomatic_Main_Settings['strip_by_id'] != '') {
                    $mock = new DOMDocument;
                    $strip_list = explode(',', $youtubomatic_Main_Settings['strip_by_id']);
                    $doc        = new DOMDocument();
                    $internalErrors = libxml_use_internal_errors(true);
                    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $content);
                    libxml_use_internal_errors($internalErrors);
                    foreach ($strip_list as $strip_id) {
                        $element = $doc->getElementById(trim($strip_id));
                        if (isset($element)) {
                            $element->parentNode->removeChild($element);
                        }
                    }
                    $body = $doc->getElementsByTagName('body')->item(0);
                    if(isset($body->childNodes))
                    {
                        foreach ($body->childNodes as $child){
                            $mock->appendChild($mock->importNode($child, true));
                        }
                        $temp_cont = $mock->saveHTML();
                        if($temp_cont !== FALSE && $temp_cont != '')
                        {
                            $temp_cont = str_replace('<?xml encoding="utf-8" ?>', '', $temp_cont);$temp_cont = html_entity_decode($temp_cont);$temp_cont = trim($temp_cont);if(substr_compare($temp_cont, '</p>', -strlen('</p>')) === 0){$temp_cont = substr_replace($temp_cont ,"", -4);}if(substr( $temp_cont, 0, 3 ) === "<p>"){$temp_cont = substr($temp_cont, 3);}
                            $content = $temp_cont;
                        }
                    }
                }              
                if (isset($youtubomatic_Main_Settings['strip_by_class']) && $youtubomatic_Main_Settings['strip_by_class'] != '') {
                    $mock = new DOMDocument;
                    $strip_list = explode(',', $youtubomatic_Main_Settings['strip_by_class']);
                    $doc        = new DOMDocument();
                    $internalErrors = libxml_use_internal_errors(true);
                    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $content);
                    libxml_use_internal_errors($internalErrors);
                    foreach ($strip_list as $strip_class) {
                        if(trim($strip_class) == '')
                        {
                            continue;
                        }
                        $finder    = new DomXPath($doc);
                        $classname = trim($strip_class);
                        $nodes     = $finder->query("//*[contains(@class, '$classname')]");
                        if ($nodes === FALSE) {
                            break;
                        }
                        foreach ($nodes as $node) {
                            $node->parentNode->removeChild($node);
                        }
                    }
                    $body = $doc->getElementsByTagName('body')->item(0);
                    if(isset($body->childNodes))
                    {
                        foreach ($body->childNodes as $child){
                            $mock->appendChild($mock->importNode($child, true));
                        }
                        $temp_cont = $mock->saveHTML();
                        if($temp_cont !== FALSE && $temp_cont != '')
                        {
                            $temp_cont = str_replace('<?xml encoding="utf-8" ?>', '', $temp_cont);$temp_cont = html_entity_decode($temp_cont);$temp_cont = trim($temp_cont);if(substr_compare($temp_cont, '</p>', -strlen('</p>')) === 0){$temp_cont = substr_replace($temp_cont ,"", -4);}if(substr( $temp_cont, 0, 3 ) === "<p>"){$temp_cont = substr($temp_cont, 3);}
                            $content = $temp_cont;
                        }
                    }
                }
                $content = preg_replace('{href="/(\w)}', 'href="https://youtube.com/$1', $content);
                if (isset($youtubomatic_Main_Settings['strip_links']) && $youtubomatic_Main_Settings['strip_links'] == 'on') {
                    $content = youtubomatic_strip_links($content);
                }
                if (isset($youtubomatic_Main_Settings['strip_textual_links']) && $youtubomatic_Main_Settings['strip_textual_links'] == 'on') {
                    $content = youtubomatic_strip_textual_links($content);
                    $description = youtubomatic_strip_textual_links($description);
                }
                if (isset($youtubomatic_Main_Settings['limit_words']) && $youtubomatic_Main_Settings['limit_words'] != '' && is_numeric($youtubomatic_Main_Settings['limit_words'])) {
                    $content = youtubomatic_custom_wp_trim_excerpt($content, $youtubomatic_Main_Settings['limit_words'], '...');
                }
                $screenimageURL = '';
                $screens_attach_id = '';
                if (isset($youtubomatic_Main_Settings['phantom_screen']) && $youtubomatic_Main_Settings['phantom_screen'] == 'on')
                {
                    if($attach_screen == '1' || (strstr($post_content, '%%item_show_screenshot%%') !== false || strstr($post_content, '%%item_screenshot_url%%') !== false || strstr($custom_fields, '%%item_show_screenshot%%') !== false || strstr($custom_fields, '%%item_screenshot_url%%') !== false))
                    {
                        if(function_exists('shell_exec')) 
                        {
                            $disabled = explode(',', ini_get('disable_functions'));
                            if(!in_array('shell_exec', $disabled))
                            {
                                if (isset($youtubomatic_Main_Settings['phantom_path']) && $youtubomatic_Main_Settings['phantom_path'] != '') 
                                {
                                    $phantomjs_comm = $youtubomatic_Main_Settings['phantom_path'] . ' ';
                                }
                                else
                                {
                                    $phantomjs_comm = 'phantomjs ';
                                }
                                if (isset($youtubomatic_Main_Settings['screenshot_height']) && $youtubomatic_Main_Settings['screenshot_height'] != '') 
                                {
                                    $h = esc_attr($youtubomatic_Main_Settings['screenshot_height']);
                                }
                                else
                                {
                                    $h = '0';
                                }
                                if (isset($youtubomatic_Main_Settings['screenshot_width']) && $youtubomatic_Main_Settings['screenshot_width'] != '') 
                                {
                                    $w = esc_attr($youtubomatic_Main_Settings['screenshot_width']);
                                }
                                else
                                {
                                    $w = '1920';
                                }
                                $upload_dir = wp_upload_dir();
                                $dir_name   = $upload_dir['basedir'] . '/youtubomatic-files';
                                $dir_url    = $upload_dir['baseurl'] . '/youtubomatic-files';
                                global $wp_filesystem;
                                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                                    wp_filesystem($creds);
                                }
                                if (!$wp_filesystem->exists($dir_name)) {
                                    wp_mkdir_p($dir_name);
                                }
                                $screen_name = uniqid();
                                $screenimageName = $dir_name . '/' . $screen_name;
                                $screenimageURL = $dir_url . '/' . $screen_name . '.jpg';
                                if(isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') 
                                {
                                    $phantomjs_comm .= '--proxy=' . trim($youtubomatic_Main_Settings['proxy_url']) . ' ';
                                    if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') 
                                    {
                                        $phantomjs_comm .= '--proxy-auth=' . trim($youtubomatic_Main_Settings['proxy_auth']) . ' ';
                                    }
                                }
                                $cmdResult = shell_exec($phantomjs_comm . '"' . dirname(__FILE__) .'/res/phantomjs/phantom-screenshot.js"' . ' "'. dirname(__FILE__) . '" "' . $url . '" "' . $screenimageName . '" ' . $w . ' ' . $h . '  2>&1');
                                if($cmdResult === NULL || $cmdResult == '' || trim($cmdResult) === 'timeout' || stristr($cmdResult, 'sh: phantomjs: command not found') !== false)
                                {
                                    $screenimageURL = '';
                                }
                                else
                                {
                                    $wp_filetype = wp_check_filetype( $screen_name . '.jpg', null );
                                    $attachment = array(
                                      'post_mime_type' => $wp_filetype['type'],
                                      'post_title' => sanitize_file_name( $screen_name . '.jpg' ),
                                      'post_content' => '',
                                      'post_status' => 'inherit'
                                    );
                                    $screens_attach_id = wp_insert_attachment( $attachment, $screenimageName . '.jpg' );
                                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                                    $attach_data = wp_generate_attachment_metadata( $screens_attach_id, $screenimageName . '.jpg' );
                                    wp_update_attachment_metadata( $screens_attach_id, $attach_data );
                                }
                            }
                            else
                            {
                                youtubomatic_log_to_file('shell_exec in disabled functions list. Please enable to on your server');
                            }
                        }
                        else
                        {
                            youtubomatic_log_to_file('shell_exec disabled. Please enable to on your server');
                        }
                    }
                }
                elseif (isset($youtubomatic_Main_Settings['puppeteer_screen']) && $youtubomatic_Main_Settings['puppeteer_screen'] == 'on')
                {
                    if($attach_screen == '1' || (strstr($post_content, '%%item_show_screenshot%%') !== false || strstr($post_content, '%%item_screenshot_url%%') !== false || strstr($custom_fields, '%%item_show_screenshot%%') !== false || strstr($custom_fields, '%%item_screenshot_url%%') !== false))
                    {
                        if(function_exists('shell_exec')) 
                        {
                            $disabled = explode(',', ini_get('disable_functions'));
                            if(!in_array('shell_exec', $disabled))
                            {
                                $phantomjs_comm = 'node ';
                                if (isset($youtubomatic_Main_Settings['screenshot_height']) && $youtubomatic_Main_Settings['screenshot_height'] != '') 
                                {
                                    $h = esc_attr($youtubomatic_Main_Settings['screenshot_height']);
                                }
                                else
                                {
                                    $h = '0';
                                }
                                if (isset($youtubomatic_Main_Settings['screenshot_width']) && $youtubomatic_Main_Settings['screenshot_width'] != '') 
                                {
                                    $w = esc_attr($youtubomatic_Main_Settings['screenshot_width']);
                                }
                                else
                                {
                                    $w = '1920';
                                }
                                if ($w < 350) {
                                    $w = 350;
                                }
                                if ($w > 1920) {
                                    $w = 1920;
                                }
                                $upload_dir = wp_upload_dir();
                                $dir_name   = $upload_dir['basedir'] . '/youtubomatic-files';
                                $dir_url    = $upload_dir['baseurl'] . '/youtubomatic-files';
                                global $wp_filesystem;
                                if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
                                    include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
                                    wp_filesystem($creds);
                                }
                                if (!$wp_filesystem->exists($dir_name)) {
                                    wp_mkdir_p($dir_name);
                                }
                                $screen_name = uniqid();
                                $screenimageName = $dir_name . '/' . $screen_name . '.jpg';
                                $screenimageURL = $dir_url . '/' . $screen_name . '.jpg';
                                $phantomjs_proxcomm = '"null"';
                                if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') 
                                {
                                    $prx = explode(',', $youtubomatic_Main_Settings['proxy_url']);
                                    $randomness = array_rand($prx);
                                    $phantomjs_proxcomm = '"' . trim($prx[$randomness]) . ' ';
                                    if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') 
                                    {
                                        $prx_auth = explode(',', $youtubomatic_Main_Settings['proxy_auth']);
                                        if(isset($prx_auth[$randomness]) && trim($prx_auth[$randomness]) != '')
                                        {
                                            $phantomjs_proxcomm .= ':' . trim($prx_auth[$randomness]) . ' ';
                                        }
                                    }
                                    $phantomjs_proxcomm .= '"';
                                }
                                $custom_user_agent = 'default';
                                $custom_cookies = 'default';
                                $user_pass = 'default';
                                $cmdResult = shell_exec($phantomjs_comm . '"' . dirname(__FILE__) .'/res/puppeteer/screenshot.js"' . ' "' . $url . '" "' . $screenimageName . '" ' . $w . ' ' . $h . ' ' . $phantomjs_proxcomm . '  "' . esc_html($custom_user_agent) . '" "' . esc_html($custom_cookies) . '" "' . esc_html($user_pass) . '" 2>&1');
                                if(stristr($cmdResult, 'sh: node: command not found') !== false || stristr($cmdResult, 'throw err;') !== false)
                                {
                                    $screenimageURL = '';
                                    youtubomatic_log_to_file('Error in puppeteer screenshot: exec: ' . $phantomjs_comm . '"' . dirname(__FILE__) .'/res/puppeteer/screenshot.js"' . ' "' . $url . '" "' . $screenimageName . '" ' . $w . ' ' . $h . ' ' . $phantomjs_proxcomm . '  "' . esc_html($custom_user_agent) . '" "' . esc_html($custom_cookies) . '" "' . esc_html($user_pass) . '" , reterr: ' . $cmdResult);
                                }
                                else
                                {
                                    $wp_filetype = wp_check_filetype( $screen_name . '.jpg', null );
                                    $attachment = array(
                                      'post_mime_type' => $wp_filetype['type'],
                                      'post_title' => sanitize_file_name( $screen_name . '.jpg' ),
                                      'post_content' => '',
                                      'post_status' => 'inherit'
                                    );
                                    $screens_attach_id = wp_insert_attachment( $attachment, $screenimageName);
                                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                                    $attach_data = wp_generate_attachment_metadata( $screens_attach_id, $screenimageName);
                                    wp_update_attachment_metadata( $screens_attach_id, $attach_data );
                                }
                            }
                        }
                    }
                }
                if (strpos($post_content, '%%') !== false) {
                    $new_post_content = youtubomatic_replaceContentShortcodes($post_content, $title, $content, $short_url, $url, $get_img, $description, $author, $author_link, $video_id, $channelId, $video_duration, $video_views, $video_likeCount, $video_dislikeCount, $video_rating, $youtubeVideo, $video_dimension, $video_definition, $video_caption , $video_licensed_content, $video_projection, $video_favorite_count, $video_comment_count, $categoryId, $defaultAudioLanguage, $returned_caption, $img_attr, $screenimageURL);
                } else {
                    $new_post_content = $post_content;
                }
				if (strpos($post_title, '%%') !== false) {
                    $new_post_title = youtubomatic_replaceContentShortcodes($post_title, $title, $content, $short_url, $url, $get_img, $description, $author, $author_link, $video_id, $channelId, $video_duration, $video_views, $video_likeCount, $video_dislikeCount, $video_rating, $youtubeVideo, $video_dimension, $video_definition, $video_caption , $video_licensed_content, $video_projection, $video_favorite_count, $video_comment_count, $categoryId, $defaultAudioLanguage, $returned_caption, $img_attr, $screenimageURL);
                } else {
                    $new_post_title = $post_title;
                }
                
                
                $my_post['description']      = $description;
                $my_post['author']           = $author;
                $my_post['author_link']      = $author_link;
                if(isset($youtubomatic_Main_Settings['litte_translate']) && $youtubomatic_Main_Settings['litte_translate'] == 'on')
                {
                }
                else
                {
                    $arr                         = youtubomatic_spin_and_translate($new_post_title, $new_post_content, $rule_translate, $rule_translate_source);
                    $new_post_title              = $arr[0];
                    $new_post_content            = $arr[1];
                }
                
                $hashtags                    = '';
                if ( isset($item->entities->hashtags[0]->text)){
					$hashtags = $item->entities->hashtags;
					$hash_arr = array();
					foreach ($hashtags as $hashtag){
						$hash_arr[] =  $hashtag->text;
					}
					$hashtags = implode(',', $hash_arr);
				}
                if ($auto_categories == 'content') {
                    $extra_categories            = youtubomatic_extractKeyWords($title);
                    $extra_categories            = implode(',', $extra_categories);
                }
                elseif ($auto_categories == 'hashtags') {
                    $extra_categories = $hashtags;
                }
                elseif ($auto_categories == 'video') {
                    $extra_categories = $videotags;
                }
                elseif ($auto_categories == 'both') {
                    $extra_categories            = youtubomatic_extractKeyWords($title);
                    $extra_categories            = implode(',', $extra_categories);
                    if($hashtags != '')
                    {
                        $extra_categories .= ',' . $hashtags;
                    }
                    if($videotags != '')
                    {
                        $extra_categories .= ',' . $videotags;
                    }
                }
                else
                {
                    $extra_categories = '';
                }
                $my_post['extra_categories'] = $extra_categories;
                $my_post['screen_attach']    = $screens_attach_id;
                
                $item_tags                   = youtubomatic_extractKeyWords($title, 3);
                $item_tags                   = implode(',', $item_tags);
                if ($can_create_tag == 'content') {
                    $post_the_tags = ($item_create_tag != '' ? $item_create_tag . ',' : '') . $item_tags;
                    $my_post['extra_tags']       = $item_tags;
                } else if ($can_create_tag == 'hashtags') {
                    $post_the_tags = ($item_create_tag != '' ? $item_create_tag . ',' : '') . $hashtags;
                    $my_post['extra_tags']       = $hashtags;
                } else if ($can_create_tag == 'video') {
                    $post_the_tags = ($item_create_tag != '' ? $item_create_tag . ',' : '') . $videotags;
                    $my_post['extra_tags']       = $videotags;
                } else if ($can_create_tag == 'both') {
                    $post_the_tags = ($item_create_tag != '' ? $item_create_tag . ',' : '') . ($item_tags != '' ? $item_tags . ',' : '') . ($videotags != '' ? $videotags . ',' : '') . $hashtags;
                    $my_post['extra_tags']       = ($item_tags != '' ? $item_tags . ',' : '') . ($videotags != '' ? $videotags . ',' : '') . $hashtags;
                } else {
                    $post_the_tags = $item_create_tag;
                    $my_post['extra_tags']       = '';
                }
                $my_post['tags_input'] = $post_the_tags;
                $new_post_title   = youtubomatic_replaceContentShortcodesAgain($new_post_title, $extra_categories, $post_the_tags);
                $new_post_content = youtubomatic_replaceContentShortcodesAgain($new_post_content, $extra_categories, $post_the_tags);
                $title_count = -1;
                if (isset($youtubomatic_Main_Settings['min_word_title']) && $youtubomatic_Main_Settings['min_word_title'] != '') {
                    $title_count = str_word_count($new_post_title);
                    if ($title_count < intval($youtubomatic_Main_Settings['min_word_title'])) {
                        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                            youtubomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because title lenght < ' . $youtubomatic_Main_Settings['min_word_title']);
                        }
                        continue;
                    }
                }
                if (isset($youtubomatic_Main_Settings['max_word_title']) && $youtubomatic_Main_Settings['max_word_title'] != '') {
                    if ($title_count == -1) {
                        $title_count = str_word_count($new_post_title);
                    }
                    if ($title_count > intval($youtubomatic_Main_Settings['max_word_title'])) {
                        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                            youtubomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because title lenght > ' . $youtubomatic_Main_Settings['max_word_title']);
                        }
                        continue;
                    }
                }
                $content_count = -1;
                if (isset($youtubomatic_Main_Settings['min_word_content']) && $youtubomatic_Main_Settings['min_word_content'] != '') {
                    $content_count = str_word_count(youtubomatic_strip_html_tags($new_post_content));
                    if ($content_count < intval($youtubomatic_Main_Settings['min_word_content'])) {
                        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                            youtubomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because content lenght < ' . $youtubomatic_Main_Settings['min_word_content']);
                        }
                        continue;
                    }
                }
                if (isset($youtubomatic_Main_Settings['max_word_content']) && $youtubomatic_Main_Settings['max_word_content'] != '') {
                    if ($content_count == -1) {
                        $content_count = str_word_count(youtubomatic_strip_html_tags($new_post_content));
                    }
                    if ($content_count > intval($youtubomatic_Main_Settings['max_word_content'])) {
                        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                            youtubomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because content lenght > ' . $youtubomatic_Main_Settings['max_word_content']);
                        }
                        continue;
                    }
                }
                if (isset($youtubomatic_Main_Settings['banned_words']) && $youtubomatic_Main_Settings['banned_words'] != '') {
                    $continue    = false;
                    $banned_list = explode(',', $youtubomatic_Main_Settings['banned_words']);
                    foreach ($banned_list as $banned_word) {
                        if (stripos($new_post_content, trim($banned_word)) !== FALSE) {
                            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                                youtubomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because it\'s content contains banned word: ' . $banned_word);
                            }
                            $continue = true;
                            break;
                        }
                        if (stripos($new_post_title, trim($banned_word)) !== FALSE) {
                            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                                youtubomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because it\'s title contains banned word: ' . $banned_word);
                            }
                            $continue = true;
                            break;
                        }
                    }
                    if ($continue === true) {
                        continue;
                    }
                }
                if (isset($youtubomatic_Main_Settings['required_words']) && $youtubomatic_Main_Settings['required_words'] != '') {
                    $continue      = false;
                    $required_list = explode(',', $youtubomatic_Main_Settings['required_words']);
                    foreach ($required_list as $required_word) {
                        if (stripos($new_post_content, trim($required_word)) === FALSE) {
                            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                                youtubomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because it\'s content doesn\'t contain required word: ' . $required_word);
                            }
                            $continue = true;
                            break;
                        }
                        if (stripos($new_post_title, trim($required_word)) === FALSE) {
                            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                                youtubomatic_log_to_file('Skipping post "' . esc_html($new_post_title) . '", because it\'s title doesn\'t contain required word: ' . $required_word);
                            }
                            $continue = true;
                            break;
                        }
                    }
                    if ($continue === true) {
                        continue;
                    }
                }
                $new_post_content = html_entity_decode($new_post_content);
                if (isset($youtubomatic_Main_Settings['fix_html']) && $youtubomatic_Main_Settings['fix_html'] == "on") {
                    $new_post_content = youtubomatic_repairHTML($new_post_content);
                }
                $new_post_content = str_replace('</ iframe>', '</iframe>', $new_post_content);
                if (isset($youtubomatic_Main_Settings['copy_images']) && $youtubomatic_Main_Settings['copy_images'] == 'on') {
                    preg_match_all('/(http|https|ftp|ftps)?:\/\/\S+\.(?:jpg|jpeg|png|gif)/', $new_post_content, $matches);
                    if(isset($matches[0][0]))
                    {
                        foreach($matches[0] as $match)
                        {
                            $file_path = youtubomatic_copy_image_locally($match);
                            if($file_path != false)
                            {
                                $file_path = str_replace('\\', '/', $file_path);
                                $new_post_content = str_replace($match, $file_path, $new_post_content);
                            }
                        }
                    }
                }
                if($ret_content == 1)
                {
                    return $new_post_content;
                }
                $my_post['post_content'] = $new_post_content;
                if (isset($youtubomatic_Main_Settings['disable_excerpt']) && $youtubomatic_Main_Settings['disable_excerpt'] == "on") {
                    $my_post['post_excerpt'] = '';
                }
                else
                {
                    if (isset($youtubomatic_Main_Settings['translate']) && $youtubomatic_Main_Settings['translate'] != "disabled" && $youtubomatic_Main_Settings['translate'] != "en") {
                        $my_post['post_excerpt'] = youtubomatic_getExcerpt($new_post_content);
                    } else {
                        $my_post['post_excerpt'] = youtubomatic_getExcerpt($content);
                    }
                }
                if (isset($youtubomatic_Main_Settings['title_dup']) && $youtubomatic_Main_Settings['title_dup'] == 'on') {
                    if ( ! function_exists( 'get_page_by_title' ) ) {
                        include_once( ABSPATH . 'wp-includes/post.php' );
                    }
                    if(get_page_by_title($new_post_title, OBJECT, $post_type) !== NULL)
                    {
                        continue;
                    }
                }
                $my_post['post_title']           = $new_post_title;
                $my_post['original_title']       = $title;
                $my_post['original_content']     = $content;
                $my_post['youtubomatic_post_format'] = $post_format;
                $extra_categories_temp = '';
                if (isset($default_category) && ($default_category !== 'youtubomatic_no_category_12345678' && $default_category[0] !== 'youtubomatic_no_category_12345678')) {
                    if(is_array($default_category))
                    {
                        foreach($default_category as $dc)
                        {
                            $extra_categories_temp = get_cat_name($dc) . ',';
                        }
                        $extra_categories_temp .= $extra_categories;
                        $extra_categories_temp = trim($extra_categories_temp, ',');
                    }
                    else
                    {
                        $extra_categories_temp = trim(get_cat_name($default_category) . ',' . $extra_categories, ',');
                    }
                }
                else
                {
                    $extra_categories_temp = $extra_categories;
                }
                $custom_arr = array();
                if($custom_fields != '')
                {
                    if(stristr($custom_fields, '=>') != false)
                    {
                        $rule_arr = explode(',', trim($custom_fields));
                        foreach($rule_arr as $rule)
                        {
                            $my_args = explode('=>', trim($rule));
                            if(isset($my_args[1]))
                            {
                                $custom_field_content = trim($my_args[1]);
                                $custom_field_content = youtubomatic_replaceContentShortcodes($custom_field_content, $title, $content, $short_url, $url, $get_img, $description, $author, $author_link, $video_id, $channelId, $video_duration, $video_views, $video_likeCount, $video_dislikeCount, $video_rating, $youtubeVideo, $video_dimension, $video_definition, $video_caption , $video_licensed_content, $video_projection, $video_favorite_count, $video_comment_count, $categoryId, $defaultAudioLanguage, $returned_caption, $img_attr, $screenimageURL);
                                $custom_field_content = youtubomatic_replaceContentShortcodesAgain($custom_field_content, $extra_categories, $post_the_tags);
                                $custom_field_content = str_replace('\'', '"', $custom_field_content);
                                $is_json = json_decode($custom_field_content, true);
                                if($is_json !== false && is_array($is_json))
                                {
                                    $custom_arr[trim($my_args[0])] = $is_json;
                                }
                                else
                                {
                                    $custom_arr[trim($my_args[0])] = $custom_field_content;
                                }
                            }
                        }
                    }
                }
                $custom_arr = array_merge($custom_arr, array('youtubomatic_featured_image' => $get_img, 'youtubomatic_post_cats' => $extra_categories_temp, 'youtubomatic_post_tags' => $post_the_tags));
                $my_post['meta_input'] = $custom_arr;
                $custom_tax_arr = array();
                if($custom_tax != '')
                {
                    if(stristr($custom_tax, '=>') != false)
                    {
                        $rule_arr = explode(';', trim($custom_tax));
                        foreach($rule_arr as $rule)
                        {
                            $my_args = explode('=>', trim($rule));
                            if(isset($my_args[1]))
                            {
                                $custom_tax_content = trim($my_args[1]);
                                $custom_tax_content = youtubomatic_replaceContentShortcodes($custom_tax_content, $title, $content, $short_url, $url, $get_img, $description, $author, $author_link, $video_id, $channelId, $video_duration, $video_views, $video_likeCount, $video_dislikeCount, $video_rating, $youtubeVideo, $video_dimension, $video_definition, $video_caption , $video_licensed_content, $video_projection, $video_favorite_count, $video_comment_count, $categoryId, $defaultAudioLanguage, $returned_caption, $img_attr, $screenimageURL);
                                $custom_tax_content = youtubomatic_replaceContentShortcodesAgain($custom_tax_content, $extra_categories, $post_the_tags);
                                $custom_tax_arr[trim($my_args[0])] = $custom_tax_content;
                            }
                        }
                    }
                }
                if(count($custom_tax_arr) > 0)
                {
                    $my_post['taxo_input'] = $custom_tax_arr;
                }
                if ($enable_pingback == '1') {
                    $my_post['ping_status'] = 'open';
                } else {
                    $my_post['ping_status'] = 'closed';
                }
                remove_filter('content_save_pre', 'wp_filter_post_kses');
                remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');remove_filter('title_save_pre', 'wp_filter_kses');
                $post_id = wp_insert_post($my_post, true);
                add_filter('content_save_pre', 'wp_filter_post_kses');
                add_filter('content_filtered_save_pre', 'wp_filter_post_kses');add_filter('title_save_pre', 'wp_filter_kses');
                if (!is_wp_error($post_id)) {
                    $posts_inserted++;
                    if(isset($my_post['taxo_input']))
                    {
                        foreach($my_post['taxo_input'] as $taxn => $taxval)
                        {
                            $taxn = trim($taxn);
                            $taxval = trim($taxval);
                            if(is_taxonomy_hierarchical($taxn))
                            {
                                $taxval = array_map('trim', explode(',', $taxval));
                                for($ii = 0; $ii < count($taxval); $ii++)
                                {
                                    if(!is_numeric($taxval[$ii]))
                                    {
                                        $xtermid = get_term_by('name', $taxval[$ii], $taxn);
                                        if($xtermid !== false)
                                        {
                                            $taxval[$ii] = intval($xtermid->term_id);
                                        }
                                        else
                                        {
                                            wp_insert_term( $taxval[$ii], $taxn);
                                            $xtermid = get_term_by('name', $taxval[$ii], $taxn);
                                            if($xtermid !== false)
                                            {
                                                $taxval[$ii] = intval($xtermid->term_id);
                                            }
                                        }
                                    }
                                }
                                wp_set_post_terms($post_id, $taxval, $taxn);
                            }
                            else
                            {
                                wp_set_post_terms($post_id, trim($taxval), $taxn);
                            }
                        }
                    }
                    if (isset($my_post['youtubomatic_post_format']) && $my_post['youtubomatic_post_format'] != '' && $my_post['youtubomatic_post_format'] != 'post-format-standard') {
                        wp_set_post_terms($post_id, $my_post['youtubomatic_post_format'], 'post_format');
                    }
                    if($my_post['screen_attach'] != '')
                    {
                        $media_post = wp_update_post( array(
                            'ID'            => $my_post['screen_attach'],
                            'post_parent'   => $post_id,
                        ), true );

                        if( is_wp_error( $media_post ) ) {
                            youtubomatic_log_to_file( 'Failed to assign post attachment ' . $my_post['screen_attach'] . ' to post id ' . $post_id . ': ' . print_r( $media_post, 1 ) );
                        }
                    }
                    $featured_path = '';
                    $image_failed  = false;
                    if ($featured_image == '1') {
                        $get_img = $my_post['youtubomatic_post_image'];
                        if ($get_img != '') {
                            if (!youtubomatic_generate_featured_image($get_img, $post_id)) {
                                $image_failed = true;
                                if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                                    youtubomatic_log_to_file('youtubomatic_generate_featured_image failed for ' . $get_img . '!');
                                }
                            } else {
                                $featured_path = $get_img;
                            }
                        } else {
                            $image_failed = true;
                        }
                    }
                    if(strstr($my_post['post_content'], 'g-ytsubscribe') !== false)
                    {
                        add_post_meta($post_id, "youtubomatic_ytsubscribe", "1");
                    }
                    if(strstr($my_post['post_content'], 'youtubomatic_show_hide') !== false)
                    {
                        add_post_meta($post_id, "youtubomatic_show_hide", "1");
                    }
                    if ($image_failed || $featured_image !== '1') {
                        if ($image_url != '') {
                            $image_urlx = explode(',',$image_url);
                            $image_urlx = trim($image_urlx[array_rand($image_urlx)]);
                            $retim = false;
                            if(is_numeric($image_urlx) && $image_urlx > 0)
                            {
                                require_once(ABSPATH . 'wp-admin/includes/image.php');
                                require_once(ABSPATH . 'wp-admin/includes/media.php');
                                $res2 = set_post_thumbnail($post_id, $image_urlx);
                                if ($res2 === FALSE) {
                                }
                                else
                                {
                                    $retim = true;
                                }
                            }
                            if($retim == false)
                            {
                                stream_context_set_default( [
                                    'ssl' => [
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                    ],
                                ]);
                                $url_headers = get_headers($image_urlx, 1);
                                if (isset($url_headers['Content-Type'])) {
                                    if (is_array($url_headers['Content-Type'])) {
                                        $img_type = strtolower($url_headers['Content-Type'][0]);
                                    } else {
                                        $img_type = strtolower($url_headers['Content-Type']);
                                    }
                                    
                                    if (strstr($img_type, 'image/') !== false) {
                                        if (!youtubomatic_generate_featured_image($image_urlx, $post_id)) {
                                            $image_failed = true;
                                            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                                                youtubomatic_log_to_file('youtubomatic_generate_featured_image failed to default value: ' . $image_urlx . '!');
                                            }
                                        } else {
                                            $featured_path = $image_urlx;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if($featured_path == '' && isset($youtubomatic_Main_Settings['skip_no_img']) && $youtubomatic_Main_Settings['skip_no_img'] == 'on')
                    {
                        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                            youtubomatic_log_to_file('Skipping post "' . $my_post['post_title'] . '", because it failed to generate a featured image for: ' . $get_img . ' and ' . $image_url);
                        }
                        wp_delete_post($post_id, true);
                        $posts_inserted--;
                        continue;
                    }
                    if($remove_default == '1' && ($auto_categories != 'disabled' || (isset($default_category) && $default_category !== 'youtubomatic_no_category_12345678' && $default_category[0] !== 'youtubomatic_no_category_12345678')))
                    {
                        $default_categories = wp_get_post_categories($post_id);
                    }
                    if ($auto_categories != 'disabled') {
                        if ($my_post['extra_categories'] != '') {
                            $extra_cats = explode(',', $my_post['extra_categories']);
                            foreach($extra_cats as $extra_cat)
                            {
                                if($parent_category_id != '')
                                {
                                    $termid = youtubomatic_create_terms('category', $parent_category_id, trim($extra_cat));
                                }
                                else
                                {
                                    $termid = youtubomatic_create_terms('category', '0', trim($extra_cat));
                                }
                                wp_set_post_terms($post_id, $termid, 'category', true);
                            }
                        }
                    }
                    if (isset($default_category) && ($default_category !== 'youtubomatic_no_category_12345678' && $default_category[0] !== 'youtubomatic_no_category_12345678')) {
                        $cats   = array();
                        if(is_array($default_category))
                        {
                            $cats = $default_category;
                        }
                        else
                        {
                            $cats[] = $default_category;
                        }
                        wp_set_post_categories($post_id, $cats, true);
                    }
                    if($remove_default == '1' && ($auto_categories != 'disabled' || (isset($default_category) && $default_category !== 'youtubomatic_no_category_12345678' && $default_category[0] !== 'youtubomatic_no_category_12345678')))
                    {
                        $new_categories = wp_get_post_categories($post_id);
                        if(isset($default_categories) && !($default_categories == $new_categories))
                        {
                            foreach($default_categories as $dc)
                            {
                                $rem_cat = get_category( $dc );
                                wp_remove_object_terms( $post_id, $rem_cat->slug, 'category' );
                            }
                        }
                    }
                    if (isset($youtubomatic_Main_Settings['post_source_custom']) && $youtubomatic_Main_Settings['post_source_custom'] != '') {
                        $tax_rez = wp_set_object_terms( $post_id, $youtubomatic_Main_Settings['post_source_custom'], 'coderevolution_post_source');
                    }
                    else
                    {
                        $tax_rez = wp_set_object_terms( $post_id, 'Youtubomatic_' . $param, 'coderevolution_post_source');
                    }
                    if (is_wp_error($tax_rez)) {
                        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                            youtubomatic_log_to_file('wp_set_object_terms failed for: ' . $post_id . '!');
                        }
                    }
                    youtubomatic_addPostMeta($post_id, $my_post, $param, $featured_path);
                    if ($my_post['insert_comments'] && $my_post['insert_comments'] != '0') {
                        if($my_post['insert_comments'] == 'rand')
                        {
                            $my_post['insert_comments'] = rand(1,15);
                        }
                        $comment_num = intval($my_post['insert_comments']);
                        $comments_link="https://www.googleapis.com/youtube/v3/commentThreads?maxResults=".$my_post['insert_comments']."&part=snippet&videoId=".$my_post['youtubomatic_post_id']."&key=" . $za_app;
                        $comments    = youtubomatic_get_web_page($comments_link);
                        if (stristr($comments, 'items')) {
                            $comments_json = json_decode($comments);
                            $comments      = $comments_json->items;
                            $date          = current_time('mysql');
                            $comms_added   = 0;
                            if ((isset($youtubomatic_Main_Settings['spin_text']) && $youtubomatic_Main_Settings['spin_text'] !== 'disabled') || (isset($youtubomatic_Main_Settings['translate']) && $youtubomatic_Main_Settings['translate'] != 'disabled')) {
                                $title_sep = ' 07543210745321 ';
                                $comm_trans = '';
                                foreach ($comments as $comment) {
                                    $comm_trans .= youtubomatic_strip_html_tags($comment->snippet->topLevelComment->snippet->textDisplay) . $title_sep;
                                }
                                $comm_trans = trim($comm_trans, $title_sep);
                                if($comm_trans != '')
                                {
                                    $arr = youtubomatic_spin_and_translate($comm_trans, 'hello', $rule_translate, $rule_translate_source);
                                    $comm_trans = $arr[0];
                                    $comm_trans = explode(trim($title_sep), $comm_trans);
                                    if(count($comm_trans) == count($comments))
                                    {
                                        for($i = 0; $i < count($comments); $i++)
                                        {
                                            $comments[$i]->snippet->topLevelComment->snippet->textDisplay = $comm_trans[$i];
                                        }
                                    }
                                }
                            }
                            foreach ($comments as $comment) {
                                if ($comment_num > $comms_added) {
                                    $comm       = $comment->snippet->topLevelComment->snippet->textDisplay;
                                    $author     = $comment->snippet->topLevelComment->snippet->authorDisplayName;
                                    $authorLink = $comment->snippet->topLevelComment->snippet->authorChannelUrl;
                                    $date       = get_date_from_gmt(gmdate('Y-m-d H:i:s', strtotime($comment->snippet->topLevelComment->snippet->publishedAt)));
                                    if (trim($comm) != '') {
                                        $data = array(
                                            'comment_post_ID' => $post_id,
                                            'comment_author' => $author,
                                            'comment_author_email' => '',
                                            'comment_author_url' => $authorLink,
                                            'comment_content' => $comm,
                                            'comment_type' => '',
                                            'comment_parent' => 0,
                                            'user_id' => 1,
                                            'comment_author_IP' => '127.0.0.1',
                                            'comment_agent' => youtubomatic_get_random_user_agent(),
                                            'comment_date' => $date,
                                            'comment_approved' => 1
                                        );
                                        wp_insert_comment($data);
                                        $comms_added++;
                                    }
                                } else {
                                    break;
                                }
                            }
                        }
                    }
                } else {
                    youtubomatic_log_to_file('Failed to insert post into database! Title:' . $my_post['post_title'] . '! Error: ' . $post_id->get_error_message() . 'Error code: ' . $post_id->get_error_code() . 'Error data: ' . $post_id->get_error_data());
                    continue;
                }
                $count++;
            }
        }
        catch (Exception $e) {
            if($continue_search == '1')
            {
                $skip_posts_temp[$param] = '';
                update_option('youtubomatic_continue_search', $skip_posts_temp);
            }
            youtubomatic_log_to_file('Exception thrown ' . esc_html($e->getMessage()) . '!');
            if($auto == 1)
            {
                youtubomatic_clearFromList($param);
            }
            return 'fail';
        }
        
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('Rule ID ' . esc_html($param) . ' (' . $rule_description . ') succesfully run! ' . esc_html($posts_inserted) . ' posts created!');
        }
        if (isset($youtubomatic_Main_Settings['send_email']) && $youtubomatic_Main_Settings['send_email'] == 'on' && $youtubomatic_Main_Settings['email_address'] !== '') {
            try {
                $to        = $youtubomatic_Main_Settings['email_address'];
                $subject   = '[youtubomatic] Rule running report - ' . youtubomatic_get_date_now();
                $message   = 'Rule ID ' . esc_html($param) . ' (' . $rule_description . ') succesfully run! ' . esc_html($posts_inserted) . ' posts created!';
                $headers[] = 'From: youtubomatic Plugin <youtubomatic@noreply.net>';
                $headers[] = 'Reply-To: noreply@youtubomatic.com';
                $headers[] = 'X-Mailer: PHP/' . phpversion();
                $headers[] = 'Content-Type: text/html';
                $headers[] = 'Charset: ' . get_option('blog_charset', 'UTF-8');
                wp_mail($to, $subject, $message, $headers);
            }
            catch (Exception $e) {
                if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                    youtubomatic_log_to_file('Failed to send mail: Exception thrown ' . esc_html($e->getMessage()) . '!');
                }
            }
        }
    }
    if ($posts_inserted == 0) {
        if($auto == 1)
        {
            youtubomatic_clearFromList($param);
        }
        return 'nochange';
    } else {
        if($auto == 1)
        {
            youtubomatic_clearFromList($param);
        }
        return 'ok';
    }
}
add_action('wp_loaded', 'youtubomatic_run_cron', 0);
function youtubomatic_run_cron()
{
    if(isset($_GET['run_youtubomatic']))
    {
        $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
        if(isset($youtubomatic_Main_Settings['secret_word']) && $_GET['run_youtubomatic'] == $youtubomatic_Main_Settings['secret_word'])
        {
            youtubomatic_cron();
            die();
        }
    }
}
function youtubomatic_getAvailableTracks($baseUrl) {
	$tracks = [];
	$listUrl = $baseUrl.'&type=list&tlangs=1&fmts=1&vssids=1&asrs=1';
	if (!$responseText = youtubomatic_get_web_page($listUrl)) {
		return false;
	}
    libxml_use_internal_errors(true);
	if (!$responseXml = simplexml_load_string($responseText)) {
		return false;
	}
	if (!$responseXml->track) {
		return $tracks;
	}
	foreach ($responseXml->track as $track) {
		$score = 0;
		if ((string)$track['lang_default'] === 'true') {
			$score += 50;
		}
		
		$tracks[] = [
		    'score' => $score,
		    'id' => (string)$track['id'],
		    'lang' => (string)$track['lang_code'],
		    'kind' => (string)$track['kind'],
		    'name' => (string)$track['name']
		];
	}
	usort($tracks, function($a, $b) {
		if ($a['score'] == $b['score']) {
			return 0;
		}
		return ($a['score'] > $b['score']) ? -1 : 1;
	});
	return $tracks;
}

function youtubomatic_getClosedCaptionText($baseUrl, array $track) {
	$captionsUrl = $baseUrl."&type=track&lang={$track['lang']}&name=".urlencode($track['name'])."&kind={$track['kind']}&fmt=1";
	
	
	if (!$responseText = youtubomatic_get_web_page($captionsUrl)) {
		return false;
	}
    libxml_use_internal_errors(true);
	if (!$responseXml = simplexml_load_string($responseText)) {
		return false;
	}
	if (!$responseXml->text) {
		return false;
	}
	
	$videoText = [];
	foreach ($responseXml->text as $textNode) {
		if ($text = trim((string)$textNode)) {
			$videoText[] = addslashes(htmlspecialchars_decode(strip_tags((string)$textNode), ENT_QUOTES));
		}
	}

	return $videoText;
	
}

function youtubomatic_getBaseClosedCaptionsUrl($videoId) {
	$youtubeUrl = 'http://www.youtube.com/watch?v=';
	$pageUrl = $youtubeUrl.$videoId;
	if (!$responseText = youtubomatic_get_web_page($pageUrl)) {
		return false;
	}
	$matches = [];
	if (!preg_match('/TTS_URL\': "(.+?)"/is', $responseText, $matches)) {
		return false;
	}
	return str_replace(['\\u0026', '\\/'], ['&', '/'], $matches[1]);
}

function youtubomatic_copy_image_locally($image_url)
{
    $upload_dir = wp_upload_dir();
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    if(substr( $image_url, 0, 10 ) === "data:image")
    {
        $data = explode(',', $image_url);
        if(isset($data[1]))
        {
            $image_data = base64_decode($data[1]);
            if($image_data === FALSE)
            {
                return false;
            }
        }
        else
        {
            return false;
        }
        preg_match('{data:image/(.*?);}', $image_url ,$ex_matches);
        if(isset($ex_matches[1]))
        {
            $image_url = 'image.' . $ex_matches[1];
        }
        else
        {
            $image_url = 'image.jpg';
        }
    }
    else
    {
        $image_data = youtubomatic_get_web_page(html_entity_decode($image_url));
        if ($image_data === FALSE || strpos($image_data, '<Message>Access Denied</Message>') !== FALSE) {
            return false;
        }
    }
    $filename = basename($image_url);
    $filename = explode("?", $filename);
    $filename = $filename[0];
    $filename = urlencode($filename);
    $filename = str_replace('%', '-', $filename);
    $filename = str_replace('#', '-', $filename);
    $filename = str_replace('&', '-', $filename);
    $filename = str_replace('{', '-', $filename);
    $filename = str_replace('}', '-', $filename);
    $filename = str_replace('\\', '-', $filename);
    $filename = str_replace('<', '-', $filename);
    $filename = str_replace('>', '-', $filename);
    $filename = str_replace('*', '-', $filename);
    $filename = str_replace('/', '-', $filename);
    $filename = str_replace('$', '-', $filename);
    $filename = str_replace('\'', '-', $filename);
    $filename = str_replace('"', '-', $filename);
    $filename = str_replace(':', '-', $filename);
    $filename = str_replace('@', '-', $filename);
    $filename = str_replace('+', '-', $filename);
    $filename = str_replace('|', '-', $filename);
    $filename = str_replace('=', '-', $filename);
    $filename = str_replace('`', '-', $filename);
    $file_parts = pathinfo($filename);
    switch($file_parts['extension'])
    {
        case "":
        $filename .= 'jpg';
        break;
        case NULL:
        $filename .= '.jpg';
        break;
    }
    if (wp_mkdir_p($upload_dir['path'] . '/youtubomatic'))
    {
        $file = $upload_dir['path'] . '/youtubomatic/' . $filename;
        $ret_path = $upload_dir['url'] . '/youtubomatic/' . $filename;
    }
    else
    {
        $file = $upload_dir['basedir'] . '/' . $filename;
        $ret_path = $upload_dir['baseurl'] . '/' . $filename;
    }
    if($wp_filesystem->exists($file))
    {
        $unid = uniqid();
        $file .= $unid . '.jpg';
        $ret_path .= $unid . '.jpg';
    }
    
    $ret = $wp_filesystem->put_contents($file, $image_data);
    if ($ret === FALSE) {
        return false;
    }
    $wp_filetype = wp_check_filetype( $file, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name( $file ),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $screens_attach_id = wp_insert_attachment( $attachment, $file );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    $attach_data = wp_generate_attachment_metadata( $screens_attach_id, $file );
    wp_update_attachment_metadata( $screens_attach_id, $attach_data );
    return $ret_path;
}

function youtubomatic_wpse_allowedtags() {
        return '<script>,<style>,<br>,<em>,<i>,<ul>,<ol>,<li>,<a>,<p>,<img>,<video>,<audio>'; 
}
function youtubomatic_custom_wp_trim_excerpt($raw_excerpt, $excerpt_word_count, $read_more) {
    $wpse_excerpt = $raw_excerpt;
    $wpse_excerpt = strip_shortcodes( $wpse_excerpt );
    $wpse_excerpt = apply_filters('the_content', $wpse_excerpt);
    $wpse_excerpt = str_replace(']]>', ']]&gt;', $wpse_excerpt);
    $wpse_excerpt = strip_tags($wpse_excerpt, youtubomatic_wpse_allowedtags());
    $tokens = array();
    $excerptOutput = '';
    $count = 0;
    preg_match_all('/(<[^>]+>|[^<>\s]+)\s*/u', $wpse_excerpt, $tokens);
    foreach ($tokens[0] as $token) {
        if ($count >= $excerpt_word_count) { 
            $excerptOutput .= trim($token);
            break;
        }
        $count++;
        $excerptOutput .= $token;
    }
    $wpse_excerpt_custom = $excerptOutput . ' ' . $read_more;
    $wpse_excerpt_custom = trim(force_balance_tags($wpse_excerpt_custom));
    if($wpse_excerpt_custom != '')
    {
        return $wpse_excerpt_custom;
    }
    return $wpse_excerpt;
}

$youtubomatic_fatal = false;
function youtubomatic_clear_flag_at_shutdown($param)
{
    $error = error_get_last();
    if ($error['type'] === E_ERROR && $GLOBALS['youtubomatic_fatal'] === false) {
        $GLOBALS['youtubomatic_fatal'] = true;
        $running = array();
        update_option('youtubomatic_running_list', $running);
        youtubomatic_log_to_file('[FATAL] Exit error: ' . $error['message'] . ', file: ' . $error['file'] . ', line: ' . $error['line'] . ' - rule ID: ' . $param . '!');
        youtubomatic_clearFromList($param);
    }
    else
    {
        youtubomatic_clearFromList($param);
    }
}

function youtubomatic_testPhantom()
{
    if(!function_exists('shell_exec')) {
        return 0;
    }
    $disabled = explode(',', ini_get('disable_functions'));
    if(in_array('shell_exec', $disabled))
    {
        return 0;
    }
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['phantom_path']) && $youtubomatic_Main_Settings['phantom_path'] != '') 
    {
        $phantomjs_comm = $youtubomatic_Main_Settings['phantom_path'] . ' ';
    }
    else
    {
        $phantomjs_comm = 'phantomjs ';
    }
    $cmdResult = shell_exec($phantomjs_comm . '-h 2>&1');
    if(stristr($cmdResult, 'Usage') !== false)
    {
        return 1;
    }
    return 0;
}
function youtubomatic_strip_links($content)
{
    $content = preg_replace('/<a(.+?)href=\"(.*?)\"(.*?)>(.*?)<\/a>/i', "\\4", $content);
    return $content;
}

function youtubomatic_repairHTML($text)
{
    $text = htmlspecialchars_decode($text);
    $text = str_replace("< ", "<", $text);
    $text = str_replace(" >", ">", $text);
    $text = str_replace("= ", "=", $text);
    $text = str_replace(" =", "=", $text);
    $text = str_replace("\/ ", "\/", $text);
    $text = str_replace("</ iframe>", "</iframe>", $text);
    $text = str_replace("frameborder ", "frameborder=\"0\" allowfullscreen></iframe>", $text);
    $doc = new DOMDocument();
    $doc->substituteEntities = false;
    $internalErrors = libxml_use_internal_errors(true);
    $doc->loadHTML('<?xml encoding="utf-8" ?>' . $text);
    $text = $doc->saveHTML();
                    libxml_use_internal_errors($internalErrors);
	$text = preg_replace('#<!DOCTYPE html PUBLIC "-\/\/W3C\/\/DTD HTML 4\.0 Transitional\/\/EN" "http:\/\/www\.w3\.org\/TR\/REC-html40\/loose\.dtd">(?:[^<]*)<\?xml encoding="utf-8" \?><html><body>(?:<p>)?#i', '', $text);
	$text = str_replace('</p></body></html>', '', $text);
    $text = str_replace('</body></html></p>', '', $text);
    $text = str_replace('</body></html>', '', $text);
    return $text;
}
add_filter('the_title', 'youtubomatic_add_affiliate_keyword');
add_filter('the_content', 'youtubomatic_add_affiliate_keyword');
add_filter('the_excerpt', 'youtubomatic_add_affiliate_keyword');
function youtubomatic_add_affiliate_keyword($content)
{
    $rules  = get_option('youtubomatic_keyword_list');
    $output = '';
    if (!empty($rules)) {
        foreach ($rules as $request => $value) {
            if (is_array($value) && isset($value[1]) && $value[1] != '') {
                $repl = $value[1];
            } else {
                $repl = $request;
            }
            if (isset($value[0]) && $value[0] != '') {
                $content = preg_replace('\'(?!((<.*?)|(<a.*?)))(\b' . preg_quote($request, '\'') . '\b)(?!(([^<>]*?)>)|([^>]*?<\/a>))\'i', '<a href="' . esc_url($value[0]) . '" target="_blank">' . esc_html($repl) . '</a>', $content);
            } else {
                $content = preg_replace('\'(?!((<.*?)|(<a.*?)))(\b' . preg_quote($request, '\'') . '\b)(?!(([^<>]*?)>)|([^>]*?<\/a>))\'i', esc_html($repl), $content);
            }
        }
    }
    return $content;
}
add_action('wp_ajax_youtubomatic_post_now', 'youtubomatic_youtubomatic_submit_post_callback');
function youtubomatic_youtubomatic_submit_post_callback()
{
    $run_id = $_POST['id'];
    $wp_post = get_post($run_id);
    if($wp_post != null)
    {
        youtubomatic_do_post($wp_post, true);
    }
    die();
}
add_action('admin_enqueue_scripts', 'youtubomatic_admin_do_post');
function youtubomatic_admin_do_post()
{
    wp_enqueue_script('youtubomatic-poster-script', plugins_url('scripts/postnow.js', __FILE__), array('jquery'), false, true);
}
function youtubomatic_meta_box_function($post)
{
    wp_register_style('youtubomatic-browser-style', plugins_url('styles/youtubomatic-browser.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('youtubomatic-browser-style');
    wp_suspend_cache_addition(true);
    if(strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php')) 
    {
        $ech = sprintf( wp_kses( __( "<b>How do I publish videos from WordPress to YouTube?</b><br/><br/>Simple! <a href='%s' target='_blank'>Configure Youtubomatic plugin</a> including in it your YouTube OAuth key and secret, <a href='%s' target='_blank'>authorize the plugin</a> with YouTube from plugin's settings panel, hit the WordPress's 'New Post' button, include a video link pointing to a valid video file in the post content. Hit publish and watch how your linked video is published to YouTube! You can automatically publish videos to YouTube that are linked from your published post content.<br/><br/> After you inserted your OAuth key and secret and authorized the plugin on YouTube, simply include in your WordPress newly published posts a link to any video file and this plugin will automatically post it also to YouTube. You can configure the posting settings below. Note that YouTube has a set of restrictions for video uploading: <a href='%s' target='_blank'>more info about YouTube Quota</a>. <br/><br/>Allowed file type for uploading are: .mov, .mpeg4, .mps, .avi, .wmv, .mpegps, .flv, .3gpp, .webm. Also, note that you ca upload only videos of maximum 15 minutes in lenght if you do not verify your YouTube accout by goint to <a href='%s' target='_blank'> verify page</a>. After you verified your account, you can upload videos of maximum 2Gb.", 'youtubomatic-youtube-post-generator'), array(  'b' => array(), 'br' => array(), 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'admin.php?page=youtubomatic_admin_settings' ), esc_url( 'admin.php?page=youtubomatic_youtube_panel' ), esc_url( 'https://developers.google.com/youtube/v3/getting-started#quota' ), esc_url( 'https://www.youtube.com/verify' ) );
        echo $ech;
    }
    else
    {
        $index                     = get_post_meta($post->ID, 'youtubomatic_parent_rule', true);
        $img                       = get_post_meta($post->ID, 'youtubomatic_featured_img', true);
        $youtubomatic_post_url         = get_post_meta($post->ID, 'youtubomatic_post_url', true);
        $youtubomatic_post_id          = get_post_meta($post->ID, 'youtubomatic_post_id', true);
        $ech = '<div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle"><div class="bws_hidden_help_text cr_min_260px">' . esc_html__("Post will be submitted respecting the configurations you made in the \'Posts to YouTube\' plugin menu section.", 'youtubomatic-youtube-post-generator') . '</div></div>&nbsp;<span id="youtubomatic_span">' . esc_html__("Manually submit post now:", 'youtubomatic-youtube-post-generator') . ' </span><br/><br/><form id="youtubomatic_form"><input class="button button-primary button-large" type="button" name="youtubomatic_submit_post" id="youtubomatic_submit_post" value="' . esc_html__('Post To YouTube Now!', 'youtubomatic-youtube-post-generator') . '" onclick="youtubomatic_post_now(' . $post->ID . ');"/></form><br/><hr/>';
    if (isset($index) && $index != '') {
            $ech .= '<table class="crf_table"><tr><td><b>' . esc_html__('Post Parent Rule:', 'youtubomatic-youtube-post-generator') . '</b></td><td>&nbsp;' . esc_html($index) . '</td></tr>';
            if ($img != '') {
                $ech .= '<tr><td><b>' . esc_html__('Featured Image:', 'youtubomatic-youtube-post-generator') . '</b></td><td>&nbsp;' . esc_url($img) . '</td></tr>';
            }
            if ($youtubomatic_post_url != '') {
                $ech .= '<tr><td><b>' . esc_html__('Item Source URL:', 'youtubomatic-youtube-post-generator') . '</b></td><td>&nbsp;' . esc_url($youtubomatic_post_url) . '</td></tr>';
            }
            if ($youtubomatic_post_id != '') {
                $ech .= '<tr><td><b>' . esc_html__('Item Source Post ID:', 'youtubomatic-youtube-post-generator') . '</b></td><td>&nbsp;' . esc_html($youtubomatic_post_id) . '</td></tr>';
            }
            $ech .= '</table><br/>';
        } else {
            $ech .= esc_html__('This is not an automatically generated post.', 'youtubomatic-youtube-post-generator');
        }
        echo $ech;
    }
    wp_suspend_cache_addition(false);
}

function youtubomatic_addPostMeta($post_id, $post, $param, $featured_img)
{
    add_post_meta($post_id, 'youtubomatic_parent_rule', $param);
    add_post_meta($post_id, 'youtubomatic_featured_img', $featured_img);
    add_post_meta($post_id, 'youtubomatic_post_url', $post['youtubomatic_post_url']);
    add_post_meta($post_id, 'youtubomatic_post_id', $post['youtubomatic_post_id']);
}
function youtubomatic_url_is_image( $url ) {
    if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
        return FALSE;
    }
    $ext = array( 'jpeg', 'jpg', 'gif', 'png', 'jpe', 'tif', 'tiff', 'svg', 'ico' , 'webp', 'dds', 'heic', 'psd', 'pspimage', 'tga', 'thm', 'yuv', 'ai', 'eps', 'php');
    $info = (array) pathinfo( parse_url( $url, PHP_URL_PATH ) );
    return isset( $info['extension'] )
        && in_array( strtolower( $info['extension'] ), $ext, TRUE );
}
function youtubomatic_endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}
function youtubomatic_generate_featured_image($image_url, $post_id)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
	$youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    $upload_dir = wp_upload_dir();
	if (isset($youtubomatic_Main_Settings['no_local_image']) && $youtubomatic_Main_Settings['no_local_image'] == 'on') {
        
        if(!youtubomatic_url_is_image($image_url))
        {
			youtubomatic_log_to_file('URL not image: ' . $image_url);
            return false;
        }
        
        $file = $upload_dir['basedir'] . '/default_img_yt.jpg';
        if(!$wp_filesystem->exists($file))
        {
            $image_data = youtubomatic_get_web_page(html_entity_decode(dirname(__FILE__) . "/images/icon.png"));
            if ($image_data === FALSE || strpos($image_data, '<Message>Access Denied</Message>') !== FALSE || strpos($image_data, 'ERROR: The requested URL could not be retrieved') !== FALSE) {
				youtubomatic_log_to_file('Failed to get image: ' . $file . ' --- ' . html_entity_decode(dirname(__FILE__) . "/images/icon.png"));
                return false;
            }
            $ret = $wp_filesystem->put_contents($file, $image_data);
            if ($ret === FALSE) {
				youtubomatic_log_to_file('Failed to save image: ' . $file);
                return false;
            }
        }
        $need_attach = false;
        $checking_id = get_option('youtubomatic_attach_id', false);
        if($checking_id === false)
        {
            $need_attach = true;
        }
        else
        {
            $atturl = wp_get_attachment_url($checking_id);
            if($atturl === false)
            {
                $need_attach = true;
            }
        }
        if($need_attach)
        {
            $filename = basename(dirname(__FILE__) . "/images/icon.png");
            $wp_filetype = wp_check_filetype($filename, null);
            if($wp_filetype['type'] == '')
            {
                $wp_filetype['type'] = 'image/png';
            }
            $attachment  = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title' => sanitize_file_name($filename),
                'post_content' => '',
                'post_status' => 'inherit'
            );
            
            $attach_id   = wp_insert_attachment($attachment, $file, $post_id);
            if ($attach_id === 0) {
                youtubomatic_log_to_file('Failed to add attachement: ' . $filename);
                return false;
            }
            update_option('youtubomatic_attach_id', $attach_id);
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            $attach_data = wp_generate_attachment_metadata($attach_id, $file);
            wp_update_attachment_metadata($attach_id, $attach_data);
        }
        else
        {
            $attach_id = $checking_id;
        }
        $res2 = set_post_thumbnail($post_id, $attach_id);
        if ($res2 === FALSE) {
			youtubomatic_log_to_file('Failed to set_post_thumbnail: ' . $file);
            return false;
        }
        
        return true;
    }
    $image_data = youtubomatic_get_web_page($image_url);
    if ($image_data === FALSE) {
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
        $image_data = $wp_filesystem->get_contents($image_url);
        if ($image_data === FALSE || strpos($image_data, '<Message>Access Denied</Message>') !== FALSE) {
            return false;
        }
    }
    $filename = basename($image_url);
    $temp     = explode("?", $filename);
    $filename = $temp[0];
    $filename = str_replace('%', '-', $filename);
    $filename = str_replace('#', '-', $filename);
    $filename = str_replace('&', '-', $filename);
    $filename = str_replace('{', '-', $filename);
    $filename = str_replace('}', '-', $filename);
    $filename = str_replace('\\', '-', $filename);
    $filename = str_replace('<', '-', $filename);
    $filename = str_replace('>', '-', $filename);
    $filename = str_replace('*', '-', $filename);
    $filename = str_replace('/', '-', $filename);
    $filename = str_replace('$', '-', $filename);
    $filename = str_replace('\'', '-', $filename);
    $filename = str_replace('"', '-', $filename);
    $filename = str_replace(':', '-', $filename);
    $filename = str_replace('@', '-', $filename);
    $filename = str_replace('+', '-', $filename);
    $filename = str_replace('|', '-', $filename);
    $filename = str_replace('=', '-', $filename);
    $filename = str_replace('`', '-', $filename);
    $filename = stripslashes(preg_replace_callback('#(%[a-zA-Z0-9_]*)#', function($matches){ return rand(0, 9); }, preg_quote($filename)));
    $file_parts = pathinfo($filename);
    $post_title = get_the_title($post_id);
    if($post_title != '')
    {
        $post_title = remove_accents( $post_title );
        $invalid = array(
            ' '   => '-',
            '%20' => '-',
            '_'   => '-',
        );
        $post_title = str_replace( array_keys( $invalid ), array_values( $invalid ), $post_title );
        $post_title = preg_replace('/[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0077}\x{E006C}\x{E0073}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0073}\x{E0063}\x{E0074}\x{E007F})|[\x{1F3F4}](?:\x{E0067}\x{E0062}\x{E0065}\x{E006E}\x{E0067}\x{E007F})|[\x{1F3F4}](?:\x{200D}\x{2620}\x{FE0F})|[\x{1F3F3}](?:\x{FE0F}\x{200D}\x{1F308})|[\x{0023}\x{002A}\x{0030}\x{0031}\x{0032}\x{0033}\x{0034}\x{0035}\x{0036}\x{0037}\x{0038}\x{0039}](?:\x{FE0F}\x{20E3})|[\x{1F415}](?:\x{200D}\x{1F9BA})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F467})|[\x{1F468}](?:\x{200D}\x{1F468}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467}\x{200D}\x{1F466})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F467})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F469}\x{200D}\x{1F466})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F468})|[\x{1F469}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F469})|[\x{1F469}\x{1F468}](?:\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F468})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9BD})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9BC})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9AF})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2640}\x{FE0F})|[\x{1F575}\x{1F3CC}\x{26F9}\x{1F3CB}](?:\x{FE0F}\x{200D}\x{2642}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F692})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F680})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2708}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A8})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3A4})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F52C})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F4BC})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3ED})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F527})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F373})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F33E})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2696}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F3EB})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F393})|[\x{1F468}\x{1F469}](?:\x{200D}\x{2695}\x{FE0F})|[\x{1F471}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F9CF}\x{1F647}\x{1F926}\x{1F937}\x{1F46E}\x{1F482}\x{1F477}\x{1F473}\x{1F9B8}\x{1F9B9}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F486}\x{1F487}\x{1F6B6}\x{1F9CD}\x{1F9CE}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}\x{1F9D8}](?:\x{200D}\x{2640}\x{FE0F})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B2})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B3})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B1})|[\x{1F468}\x{1F469}](?:\x{200D}\x{1F9B0})|[\x{1F471}\x{1F64D}\x{1F64E}\x{1F645}\x{1F646}\x{1F481}\x{1F64B}\x{1F9CF}\x{1F647}\x{1F926}\x{1F937}\x{1F46E}\x{1F482}\x{1F477}\x{1F473}\x{1F9B8}\x{1F9B9}\x{1F9D9}\x{1F9DA}\x{1F9DB}\x{1F9DC}\x{1F9DD}\x{1F9DE}\x{1F9DF}\x{1F486}\x{1F487}\x{1F6B6}\x{1F9CD}\x{1F9CE}\x{1F3C3}\x{1F46F}\x{1F9D6}\x{1F9D7}\x{1F3C4}\x{1F6A3}\x{1F3CA}\x{1F6B4}\x{1F6B5}\x{1F938}\x{1F93C}\x{1F93D}\x{1F93E}\x{1F939}\x{1F9D8}](?:\x{200D}\x{2642}\x{FE0F})|[\x{1F441}](?:\x{FE0F}\x{200D}\x{1F5E8}\x{FE0F})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FA}](?:\x{1F1FF})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1FA}](?:\x{1F1FE})|[\x{1F1E6}\x{1F1E8}\x{1F1F2}\x{1F1F8}](?:\x{1F1FD})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F9}\x{1F1FF}](?:\x{1F1FC})|[\x{1F1E7}\x{1F1E8}\x{1F1F1}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1FB})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1FB}](?:\x{1F1FA})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FE}](?:\x{1F1F9})|[\x{1F1E6}\x{1F1E7}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FA}\x{1F1FC}](?:\x{1F1F8})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F7})|[\x{1F1E6}\x{1F1E7}\x{1F1EC}\x{1F1EE}\x{1F1F2}](?:\x{1F1F6})|[\x{1F1E8}\x{1F1EC}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}](?:\x{1F1F5})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EE}\x{1F1EF}\x{1F1F2}\x{1F1F3}\x{1F1F7}\x{1F1F8}\x{1F1F9}](?:\x{1F1F4})|[\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1F3})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1EC}\x{1F1ED}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F4}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FF}](?:\x{1F1F2})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1F1})|[\x{1F1E8}\x{1F1E9}\x{1F1EB}\x{1F1ED}\x{1F1F1}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FD}](?:\x{1F1F0})|[\x{1F1E7}\x{1F1E9}\x{1F1EB}\x{1F1F8}\x{1F1F9}](?:\x{1F1EF})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EB}\x{1F1EC}\x{1F1F0}\x{1F1F1}\x{1F1F3}\x{1F1F8}\x{1F1FB}](?:\x{1F1EE})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F5}\x{1F1F8}\x{1F1F9}](?:\x{1F1ED})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}](?:\x{1F1EC})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F9}\x{1F1FC}](?:\x{1F1EB})|[\x{1F1E6}\x{1F1E7}\x{1F1E9}\x{1F1EA}\x{1F1EC}\x{1F1EE}\x{1F1EF}\x{1F1F0}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F7}\x{1F1F8}\x{1F1FB}\x{1F1FE}](?:\x{1F1EA})|[\x{1F1E6}\x{1F1E7}\x{1F1E8}\x{1F1EC}\x{1F1EE}\x{1F1F2}\x{1F1F8}\x{1F1F9}](?:\x{1F1E9})|[\x{1F1E6}\x{1F1E8}\x{1F1EA}\x{1F1EE}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F8}\x{1F1F9}\x{1F1FB}](?:\x{1F1E8})|[\x{1F1E7}\x{1F1EC}\x{1F1F1}\x{1F1F8}](?:\x{1F1E7})|[\x{1F1E7}\x{1F1E8}\x{1F1EA}\x{1F1EC}\x{1F1F1}\x{1F1F2}\x{1F1F3}\x{1F1F5}\x{1F1F6}\x{1F1F8}\x{1F1F9}\x{1F1FA}\x{1F1FB}\x{1F1FF}](?:\x{1F1E6})|[\x{00A9}\x{00AE}\x{203C}\x{2049}\x{2122}\x{2139}\x{2194}-\x{2199}\x{21A9}-\x{21AA}\x{231A}-\x{231B}\x{2328}\x{23CF}\x{23E9}-\x{23F3}\x{23F8}-\x{23FA}\x{24C2}\x{25AA}-\x{25AB}\x{25B6}\x{25C0}\x{25FB}-\x{25FE}\x{2600}-\x{2604}\x{260E}\x{2611}\x{2614}-\x{2615}\x{2618}\x{261D}\x{2620}\x{2622}-\x{2623}\x{2626}\x{262A}\x{262E}-\x{262F}\x{2638}-\x{263A}\x{2640}\x{2642}\x{2648}-\x{2653}\x{265F}-\x{2660}\x{2663}\x{2665}-\x{2666}\x{2668}\x{267B}\x{267E}-\x{267F}\x{2692}-\x{2697}\x{2699}\x{269B}-\x{269C}\x{26A0}-\x{26A1}\x{26AA}-\x{26AB}\x{26B0}-\x{26B1}\x{26BD}-\x{26BE}\x{26C4}-\x{26C5}\x{26C8}\x{26CE}-\x{26CF}\x{26D1}\x{26D3}-\x{26D4}\x{26E9}-\x{26EA}\x{26F0}-\x{26F5}\x{26F7}-\x{26FA}\x{26FD}\x{2702}\x{2705}\x{2708}-\x{270D}\x{270F}\x{2712}\x{2714}\x{2716}\x{271D}\x{2721}\x{2728}\x{2733}-\x{2734}\x{2744}\x{2747}\x{274C}\x{274E}\x{2753}-\x{2755}\x{2757}\x{2763}-\x{2764}\x{2795}-\x{2797}\x{27A1}\x{27B0}\x{27BF}\x{2934}-\x{2935}\x{2B05}-\x{2B07}\x{2B1B}-\x{2B1C}\x{2B50}\x{2B55}\x{3030}\x{303D}\x{3297}\x{3299}\x{1F004}\x{1F0CF}\x{1F170}-\x{1F171}\x{1F17E}-\x{1F17F}\x{1F18E}\x{1F191}-\x{1F19A}\x{1F201}-\x{1F202}\x{1F21A}\x{1F22F}\x{1F232}-\x{1F23A}\x{1F250}-\x{1F251}\x{1F300}-\x{1F321}\x{1F324}-\x{1F393}\x{1F396}-\x{1F397}\x{1F399}-\x{1F39B}\x{1F39E}-\x{1F3F0}\x{1F3F3}-\x{1F3F5}\x{1F3F7}-\x{1F3FA}\x{1F400}-\x{1F4FD}\x{1F4FF}-\x{1F53D}\x{1F549}-\x{1F54E}\x{1F550}-\x{1F567}\x{1F56F}-\x{1F570}\x{1F573}-\x{1F57A}\x{1F587}\x{1F58A}-\x{1F58D}\x{1F590}\x{1F595}-\x{1F596}\x{1F5A4}-\x{1F5A5}\x{1F5A8}\x{1F5B1}-\x{1F5B2}\x{1F5BC}\x{1F5C2}-\x{1F5C4}\x{1F5D1}-\x{1F5D3}\x{1F5DC}-\x{1F5DE}\x{1F5E1}\x{1F5E3}\x{1F5E8}\x{1F5EF}\x{1F5F3}\x{1F5FA}-\x{1F64F}\x{1F680}-\x{1F6C5}\x{1F6CB}-\x{1F6D2}\x{1F6D5}\x{1F6E0}-\x{1F6E5}\x{1F6E9}\x{1F6EB}-\x{1F6EC}\x{1F6F0}\x{1F6F3}-\x{1F6FA}\x{1F7E0}-\x{1F7EB}\x{1F90D}-\x{1F93A}\x{1F93C}-\x{1F945}\x{1F947}-\x{1F971}\x{1F973}-\x{1F976}\x{1F97A}-\x{1F9A2}\x{1F9A5}-\x{1F9AA}\x{1F9AE}-\x{1F9CA}\x{1F9CD}-\x{1F9FF}\x{1FA70}-\x{1FA73}\x{1FA78}-\x{1FA7A}\x{1FA80}-\x{1FA82}\x{1FA90}-\x{1FA95}]/u', '', $post_title);
        
        $post_title = preg_replace('/\.(?=.*\.)/', '', $post_title);
        $post_title = preg_replace('/-+/', '-', $post_title);
        $post_title = str_replace('-.', '.', $post_title);
        $post_title = strtolower( $post_title );
        if($post_title == '')
        {
            $post_title = uniqid();
        }
        if(isset($file_parts['extension']))
        {
            switch($file_parts['extension'])
            {
                case "":
                $filename = sanitize_title($post_title) . '.jpg';
                break;
                case NULL:
                $filename = sanitize_title($post_title) . '.jpg';
                break;
                default:
                $filename = sanitize_title($post_title) . '.' . $file_parts['extension'];
                break;
            }
        }
        else
        {
            $filename = sanitize_title($post_title) . '.jpg';
        }
    }
    else
    {
        if(isset($file_parts['extension']))
        {
            switch($file_parts['extension'])
            {
                case "":
                if(!youtubomatic_endsWith($filename, '.jpg'))
                    $filename .= '.jpg';
                break;
                case NULL:
                if(!youtubomatic_endsWith($filename, '.jpg'))
                    $filename .= '.jpg';
                break;
                default:
                if(!youtubomatic_endsWith($filename, '.' . $file_parts['extension']))
                    $filename .= '.' . $file_parts['extension'];
                break;
            }
        }
        else
        {
            if(!youtubomatic_endsWith($filename, '.jpg'))
                $filename .= '.jpg';
        }
    }
    $filename = sanitize_file_name($filename);
    if (wp_mkdir_p($upload_dir['path'] . '/' . $post_id))
        $file = $upload_dir['path'] . '/' . $post_id . '/' . $filename;
    else
        $file = $upload_dir['basedir'] . '/' . $post_id . '/' . $filename;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $ret = $wp_filesystem->put_contents($file, $image_data);
    if ($ret === FALSE) {
        return false;
    }
    $wp_filetype = wp_check_filetype($filename, null);
    if($wp_filetype['type'] == '')
    {
        $wp_filetype['type'] = 'image/png';
    }
    $attachment  = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    
    if ((isset($youtubomatic_Main_Settings['resize_height']) && $youtubomatic_Main_Settings['resize_height'] !== '') || (isset($youtubomatic_Main_Settings['resize_width']) && $youtubomatic_Main_Settings['resize_width'] !== ''))
    {
        try
        {
            if(!class_exists('\Eventviva\ImageResize')){require_once (dirname(__FILE__) . "/res/ImageResize/ImageResize.php");}
            $imageRes = new ImageResize($file);
            $imageRes->quality_jpg = 100;
            if ((isset($youtubomatic_Main_Settings['resize_height']) && $youtubomatic_Main_Settings['resize_height'] !== '') && (isset($youtubomatic_Main_Settings['resize_width']) && $youtubomatic_Main_Settings['resize_width'] !== ''))
            {
                $imageRes->resizeToBestFit($youtubomatic_Main_Settings['resize_width'], $youtubomatic_Main_Settings['resize_height'], true);
            }
            elseif (isset($youtubomatic_Main_Settings['resize_width']) && $youtubomatic_Main_Settings['resize_width'] !== '')
            {
                $imageRes->resizeToWidth($youtubomatic_Main_Settings['resize_width'], true);
            }
            elseif (isset($youtubomatic_Main_Settings['resize_height']) && $youtubomatic_Main_Settings['resize_height'] !== '')
            {
                $imageRes->resizeToHeight($youtubomatic_Main_Settings['resize_height'], true);
            }
            $imageRes->save($file);
        }
        catch(Exception $e)
        {
            youtubomatic_log_to_file('Failed to resize featured image: ' . $image_url . ' to sizes ' . $youtubomatic_Main_Settings['resize_width'] . ' - ' . $youtubomatic_Main_Settings['resize_height'] . '. Exception thrown ' . esc_html($e->getMessage()) . '!');
        }
    }
    $attach_id   = wp_insert_attachment($attachment, $file, $post_id);
    if ($attach_id === 0) {
        return false;
    }
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    $attach_data = wp_generate_attachment_metadata($attach_id, $file);
    wp_update_attachment_metadata($attach_id, $attach_data);
    $res2 = set_post_thumbnail($post_id, $attach_id);
    if ($res2 === FALSE) {
        return false;
    }
    $post_title = get_the_title($post_id);
    if($post_title != '')
    {
        update_post_meta($attach_id, '_wp_attachment_image_alt', $post_title);
    }
    return true;
}

function youtubomatic_hour_diff($date1, $date2)
{
    $date1 = new DateTime($date1, youtubomatic_get_blog_timezone());
    $date2 = new DateTime($date2, youtubomatic_get_blog_timezone());
    
    $number1 = (int) $date1->format('U');
    $number2 = (int) $date2->format('U');
    return ($number1 - $number2) / 60;
}

function youtubomatic_add_hour($date, $hour)
{
    $date1 = new DateTime($date, youtubomatic_get_blog_timezone());
    $date1->modify("$hour hours");
    foreach ($date1 as $key => $value) {
        if ($key == 'date') {
            return $value;
        }
    }
    return $date;
}

function youtubomatic_get_date_now($param = 'now')
{
    $date = new DateTime($param, youtubomatic_get_blog_timezone());
    foreach ($date as $key => $value) {
        if ($key == 'date') {
            return $value;
        }
    }
    return '';
}

function youtubomatic_create_terms($taxonomy, $parent, $terms_str)
{
    $terms          = explode('/', $terms_str);
    $categories     = array();
    $parent_term_id = $parent;
    foreach ($terms as $term) {
        $res = term_exists($term, $taxonomy, $parent);
        if ($res != NULL && $res != 0 && count($res) > 0 && isset($res['term_id'])) {
            $parent_term_id = $res['term_id'];
            $categories[]   = $parent_term_id;
        } else {
            $new_term = wp_insert_term($term, $taxonomy, array(
                'parent' => $parent
            ));
            if (!is_wp_error( $new_term ) && $new_term != NULL && $new_term != 0 && count($new_term) > 0 && isset($new_term['term_id'])) {
                $parent_term_id = $new_term['term_id'];
                $categories[]   = $parent_term_id;
            }
        }
    }
    
    return $categories;
}
function youtubomatic_getExcerpt($the_content)
{
    $preview = youtubomatic_strip_html_tags($the_content);
    $preview = wp_trim_words($preview, 55);
    return $preview;
}

function youtubomatic_getPlainContent($the_content)
{
    $preview = youtubomatic_strip_html_tags($the_content);
    $preview = wp_trim_words($preview, 999999);
    return $preview;
}
function youtubomatic_getItemImage($img, $just_title)
{
    $preview = '<img src="' . esc_url($img) . '" alt="' . esc_html($just_title) . '" />';
    return $preview;
}

function youtubomatic_getReadMoreButton($url)
{
    $link = '';
    if (isset($url)) {
        $link = '<a rel="nofollow noopener" href="' . esc_url($url) . '" class="button purchase" target="_blank">' . esc_html__('Read More', 'youtubomatic-youtube-post-generator') . '</a>';
    }
    return $link;
}

add_action('init', 'youtubomatic_create_taxonomy', 0);
add_action( 'enqueue_block_editor_assets', 'youtubomatic_enqueue_block_editor_assets' );
function youtubomatic_enqueue_block_editor_assets() {
	wp_register_style('youtubomatic-browser-style', plugins_url('styles/youtubomatic-browser.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('youtubomatic-browser-style');
	$block_js_display   = 'scripts/display-posts.js';
	wp_enqueue_script(
		'youtubomatic-display-block-js', 
        plugins_url( $block_js_display, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/list-posts.js';
	wp_enqueue_script(
		'youtubomatic-list-block-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/playlist-block.js';
	wp_enqueue_script(
		'youtubomatic-playlist-block-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/grid-block.js';
	wp_enqueue_script(
		'youtubomatic-grid-block-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/grid-channel-block.js';
	wp_enqueue_script(
		'youtubomatic-grid-channel-block-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/grid-playlist-block.js';
	wp_enqueue_script(
		'youtubomatic-grid-playlist-block-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/channel-block.js';
	wp_enqueue_script(
		'youtubomatic-channel-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/video-search-block.js';
	wp_enqueue_script(
		'youtubomatic-video-search-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/video-block.js';
	wp_enqueue_script(
		'youtubomatic-video-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
        '1.0.0'
	);
    $block_js_list   = 'scripts/sidebar.js';
	wp_enqueue_script(
		'youtubomatic-sidebar-js', 
        plugins_url( $block_js_list, __FILE__ ), 
        array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-data' ),
        '1.0.0'
	);
}
function youtubomatic_create_taxonomy()
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] === 'on') {
        if (isset($youtubomatic_Main_Settings['no_local_image']) && $youtubomatic_Main_Settings['no_local_image'] == 'on') {
            add_filter('wp_get_attachment_url', 'youtubomatic_replace_attachment_url', 10, 2);
            add_filter('wp_get_attachment_image_src', 'youtubomatic_replace_attachment_image_src', 10, 3);
            add_filter('post_thumbnail_html', 'youtubomatic_thumbnail_external_replace', 10, 6);
        }
    }
    if ( function_exists( 'register_block_type' ) ) {
        register_block_type( 'youtubomatic-youtube-post-generator/youtubomatic-display', array(
            'render_callback' => 'youtubomatic_display_posts_shortcode',
        ) );
        register_block_type( 'youtubomatic-youtube-post-generator/youtubomatic-list', array(
            'render_callback' => 'youtubomatic_list_posts',
        ) );
        register_block_type( 'youtubomatic-youtube-post-generator/youtubomatic-playlist', array(
            'render_callback' => 'youtubomatic_playlist',
        ) );
        register_block_type( 'youtubomatic-youtube-post-generator/youtubomatic-grid', array(
            'render_callback' => 'youtubomatic_grid',
        ) );
        register_block_type( 'youtubomatic-youtube-post-generator/youtubomatic-grid-channel', array(
            'render_callback' => 'youtubomatic_grid_channel',
        ) );
        register_block_type( 'youtubomatic-youtube-post-generator/youtubomatic-grid-playlist', array(
            'render_callback' => 'youtubomatic_grid_playlist',
        ) );
        register_block_type( 'youtubomatic-youtube-post-generator/youtubomatic-channel', array(
            'render_callback' => 'youtubomatic_channel',
        ) );
        register_block_type( 'youtubomatic-youtube-post-generator/youtubomatic-search-video', array(
            'render_callback' => 'youtubomatic_search',
        ) );
        register_block_type( 'youtubomatic-youtube-post-generator/youtubomatic-video', array(
            'render_callback' => 'youtubomatic_video',
        ) );
    }
    if(!taxonomy_exists('coderevolution_post_source'))
    {
        $labels = array(
            'name' => _x('Post Source', 'taxonomy general name', 'youtubomatic-youtube-post-generator'),
            'singular_name' => _x('Post Source', 'taxonomy singular name', 'youtubomatic-youtube-post-generator'),
            'search_items' => esc_html__('Search Post Source', 'youtubomatic-youtube-post-generator'),
            'popular_items' => esc_html__('Popular Post Source', 'youtubomatic-youtube-post-generator'),
            'all_items' => esc_html__('All Post Sources', 'youtubomatic-youtube-post-generator'),
            'parent_item' => null,
            'parent_item_colon' => null,
            'edit_item' => esc_html__('Edit Post Source', 'youtubomatic-youtube-post-generator'),
            'update_item' => esc_html__('Update Post Source', 'youtubomatic-youtube-post-generator'),
            'add_new_item' => esc_html__('Add New Post Source', 'youtubomatic-youtube-post-generator'),
            'new_item_name' => esc_html__('New Post Source Name', 'youtubomatic-youtube-post-generator'),
            'separate_items_with_commas' => esc_html__('Separate Post Source with commas', 'youtubomatic-youtube-post-generator'),
            'add_or_remove_items' => esc_html__('Add or remove Post Source', 'youtubomatic-youtube-post-generator'),
            'choose_from_most_used' => esc_html__('Choose from the most used Post Source', 'youtubomatic-youtube-post-generator'),
            'not_found' => esc_html__('No Post Sources found.', 'youtubomatic-youtube-post-generator'),
            'menu_name' => esc_html__('Post Source', 'youtubomatic-youtube-post-generator')
        );
        
        $args = array(
            'hierarchical' => false,
            'public' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'description' => 'Post Source',
            'labels' => $labels,
            'show_admin_column' => true,
            'update_count_callback' => '_update_post_term_count',
            'rewrite' => false
        );
        
        register_taxonomy('coderevolution_post_source', array(
            'post',
            'page'
        ), $args);
        add_action('pre_get_posts', function($qry) {
            if (is_admin()) return;
            if (is_tax('coderevolution_post_source')){
                $qry->set_404();
            }
        });
    }
}
function youtubomatic_link_back( $url, $post) {
	$youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on')
    {
        if ((isset($youtubomatic_Main_Settings['link_back']) && $youtubomatic_Main_Settings['link_back'] == 'on'))
        {
            $yturl = get_post_meta($post->ID, 'youtubomatic_post_url', true);
            if($yturl !== false && $yturl != '')
            {
                return $yturl;
            }
            else
            {
                return $url;
            }
        }
        else
        {
            return $url;
        }
    }
    else
    {
        return $url;
    }
}
add_filter( 'post_link', 'youtubomatic_link_back', 10, 2 );
register_activation_hook(__FILE__, 'youtubomatic_activation_callback');
function youtubomatic_activation_callback($defaults = FALSE)
{
    if (!get_option('youtubomatic_posts_per_page') || $defaults === TRUE) {
        if ($defaults === FALSE) {
            add_option('youtubomatic_posts_per_page', '16');
        } else {
            update_option('youtubomatic_posts_per_page', '16');
        }
    }
    if (!get_option('youtubomatic_Main_Settings') || $defaults === TRUE) {
        $youtubomatic_Main_Settings = array(
            'youtubomatic_enabled' => 'on',
            'secret_word' => '',
            'youtubomatic_notice_enabled' => 'on',
            'enable_metabox' => 'on',
            'app_id' => '',
            'skip_no_img' => '',
            'skip_old' => '',
            'skip_year' => '',
            'skip_month' => '',
            'skip_day' => '',
            'translate' => 'disabled',
            'translate_source' => 'disabled',
            'litte_translate' => '',
            'custom_html2' => '',
            'custom_html' => '',
            'strip_by_id' => '',
            'link_back' => '',
            'link_soft' => '',
            'strip_by_class' => '',
            'sentence_list' => 'This is one %adjective %noun %sentence_ending
This is another %adjective %noun %sentence_ending
I %love_it %nouns , because they are %adjective %sentence_ending
My %family says this plugin is %adjective %sentence_ending
These %nouns are %adjective %sentence_ending',
            'sentence_list2' => 'Meet this %adjective %noun %sentence_ending
This is the %adjective %noun ever %sentence_ending
I %love_it %nouns , because they are the %adjective %sentence_ending
My %family says this plugin is very %adjective %sentence_ending
These %nouns are quite %adjective %sentence_ending',
            'variable_list' => 'adjective_very => %adjective;very %adjective;

adjective => clever;interesting;smart;huge;astonishing;unbelievable;nice;adorable;beautiful;elegant;fancy;glamorous;magnificent;helpful;awesome

noun_with_adjective => %noun;%adjective %noun

noun => plugin;WordPress plugin;item;ingredient;component;constituent;module;add-on;plug-in;addon;extension

nouns => plugins;WordPress plugins;items;ingredients;components;constituents;modules;add-ons;plug-ins;addons;extensions

love_it => love;adore;like;be mad for;be wild about;be nuts about;be crazy about

family => %adjective %family_members;%family_members

family_members => grandpa;brother;sister;mom;dad;grandma

sentence_ending => .;!;!!',
            'auto_clear_logs' => 'No',
            'enable_logging' => 'on',
            'enable_detailed_logging' => '',
            'rule_timeout' => '3600',
            'rule_delay' => '',
            'strip_links' => '',
            'strip_textual_links' => '',
            'limit_words' => '',
            'email_address' => '',
            'send_email' => '',
            'best_password' => '',
            'phantom_path' => '',
            'phantom_screen' => '',
            'puppeteer_screen' => '',
            'screenshot_height' => '',
            'screenshot_width' => '',
            'no_check' => '',
            'no_dup_check' => '',
            'title_dup' => '',
            'best_user' => '',
            'spin_text' => 'disabled',
            'required_words' => '',
            'banned_words' => '',
            'max_word_content' => '',
            'min_word_content' => '',
            'max_word_title' => '',
            'min_word_title' => '',
            'enable_og' => '',
            'disable_scripts' => '',
            'link_og' => '',
            'enable_og2' => '',
            'default_image_og' => '',
            'links_hide' => '',
            'shortest_api' => '',
            'disable_excerpt' => 'on',
            'links_hide_google2' => '',
            'apiKey' => '',
            'show_closed_captions' => '0',
            'color_theme' => 'red',
            'video_controls' => '1',
            'keyboard_control' => '0',
            'iframe_api' => '0',
            'stop_after' => '',
            'start_after' => '',
            'show_fullscreen_button' => '1',
            'player_language' => 'default',
            'video_annotations' => '1',
            'loop_video' => '0',
            'modest_branding' => '0',
            'show_related' => '1',
            'show_info' => '1',
            'player_style' => '0',
            'player_width' => '580',
            'player_height' => '380',
            'channel_name' => '',
            'channel_layout' => 'default',
            'channel_theme' => 'default',
            'oauth_key' => '',
            'oauth_secret' => '',
            'resize_height' => '',
            'resize_width' => '',
            'copy_images' => '',
			'no_local_image' => '',
            'wide_images' => '43',
            'continue_search' => '',
            'fix_html' => '',
            'only_auto' => '',
            'image_ad' => '',
            'image_ad_url' => '',
			'proxy_auth' => '',
			'proxy_url' => '',
            'post_source_custom' => '',
            
            'flickr_order' => 'date-posted-desc',
            'flickr_license' => '-1',
            'flickr_api' => '',
            'scrapeimg_height' => '',
            'attr_text' => 'Photo Credit: <a href="%%image_source_url%%" target="_blank">%%image_source_name%%</a>',
            'scrapeimg_width' => '',
            'scrapeimg_cat' => 'all',
            'scrapeimg_order' => 'any',
            'scrapeimg_orientation' => 'all',
            'imgtype' => 'all',
            'pixabay_api' => '',
            'pexels_api' => '',
            'morguefile_secret' => '',
            'morguefile_api' => '',
            'bimage' => 'on',
            'no_orig' => '',
            'img_order' => 'popular',
            'img_cat' => 'all',
            'img_width' => '',
            'img_mwidth' => '',
            'img_ss' => '',
            'img_editor' => '',
            'img_language' => 'any',
            'pixabay_scrape' => '',
            'unsplash_api' => '',
            'scrapeimgtype' => 'all'
        );
        if ($defaults === FALSE) {
            add_option('youtubomatic_Main_Settings', $youtubomatic_Main_Settings);
        } else {
            update_option('youtubomatic_Main_Settings', $youtubomatic_Main_Settings);
        }
    }
    if (!get_option('youtubomatic_Youtube_Settings') || $defaults === TRUE) {
        $youtubomatic_Youtube_Settings = array(
            'youtubomatic_posting' => 'on',
            'run_background' => '',
            'save_local' => '',
            'youtube_format' => '%%post_excerpt%% %%post_link%%',
            'post_posts' => '',
            'post_pages' => '',
            'post_custom' => '',
            'disabled_categories' => array(),
            'disable_tags' => '',
            'only_local' => '',
            'youtube_title_format' => '%%post_title%%',
            'auto_tags' => 'disabled',
            'additional_tags' => '',
            'video_category' => '22',
            'video_status' => 'public',
            'chunk_size' => '262144',
            'video_language' => 'en',
            'video_audio_language' => 'en',
            'max_at_once' => '',
            'youtube_embedded' => 'on',
            'vimeo_embedded' => 'on',
            'dm_embedded' => 'on',
            'fb_embedded' => 'on',
            'tw_embedded' => 'on',
            'replace_old' => '',
            'replace_local' => '',
            'delete_local' => '',
            'delay_post' => '',
            'alt_upload' => ''
        );
        if ($defaults === FALSE) {
            add_option('youtubomatic_Youtube_Settings', $youtubomatic_Youtube_Settings);
        } else {
            update_option('youtubomatic_Youtube_Settings', $youtubomatic_Youtube_Settings);
        }
    }
}


function youtubomatic_get_free_image($youtubomatic_Main_Settings, $query_words, &$img_attr, $res_cnt = 3)
{
    $original_url = '';
    $rand_arr = array();
    if(isset($youtubomatic_Main_Settings['pixabay_api']) && $youtubomatic_Main_Settings['pixabay_api'] != '')
    {
        $rand_arr[] = 'pixabay';
    }
    if(isset($youtubomatic_Main_Settings['morguefile_api']) && $youtubomatic_Main_Settings['morguefile_api'] !== '' && isset($youtubomatic_Main_Settings['morguefile_secret']) && $youtubomatic_Main_Settings['morguefile_secret'] !== '')
    {
        $rand_arr[] = 'morguefile';
    }
    if(isset($youtubomatic_Main_Settings['flickr_api']) && $youtubomatic_Main_Settings['flickr_api'] !== '')
    {
        $rand_arr[] = 'flickr';
    }
    if(isset($youtubomatic_Main_Settings['pexels_api']) && $youtubomatic_Main_Settings['pexels_api'] !== '')
    {
        $rand_arr[] = 'pexels';
    }
    if(isset($youtubomatic_Main_Settings['pixabay_scrape']) && $youtubomatic_Main_Settings['pixabay_scrape'] == 'on')
    {
        $rand_arr[] = 'pixabayscrape';
    }
    if(isset($youtubomatic_Main_Settings['unsplash_api']) && $youtubomatic_Main_Settings['unsplash_api'] == 'on')
    {
        $rand_arr[] = 'unsplash';
    }
    $rez = false;
    while(($rez === false || $rez === '') && count($rand_arr) > 0)
    {
        $rand = array_rand($rand_arr);
        if($rand_arr[$rand] == 'pixabay')
        {
            unset($rand_arr[$rand]);
            $rez = youtubomatic_get_pixabay_image($youtubomatic_Main_Settings['pixabay_api'], $query_words, $youtubomatic_Main_Settings['img_language'], $youtubomatic_Main_Settings['imgtype'], $youtubomatic_Main_Settings['img_orientation'], $youtubomatic_Main_Settings['img_order'], $youtubomatic_Main_Settings['img_cat'], $youtubomatic_Main_Settings['img_mwidth'], $youtubomatic_Main_Settings['img_width'], $youtubomatic_Main_Settings['img_ss'], $youtubomatic_Main_Settings['img_editor'], $original_url, $res_cnt);
            if($rez !== false && $rez !== '')
            {
                $img_attr = str_replace('%%image_source_name%%', 'Pixabay', $img_attr);
                $img_attr = str_replace('%%image_source_url%%', $original_url, $img_attr);
                $img_attr = str_replace('%%image_source_website%%', 'https://pixabay.com/', $img_attr);
            }
        }
        elseif($rand_arr[$rand] == 'morguefile')
        {
            unset($rand_arr[$rand]);
            $rez = youtubomatic_get_morguefile_image($youtubomatic_Main_Settings['morguefile_api'], $youtubomatic_Main_Settings['morguefile_secret'], $query_words, $original_url);
            if($rez !== false && $rez !== '')
            {
                $img_attr = str_replace('%%image_source_name%%', 'MorgueFile', $img_attr);
                $img_attr = str_replace('%%image_source_url%%', 'https://morguefile.com/', $img_attr);
                $img_attr = str_replace('%%image_source_website%%', 'https://morguefile.com/', $img_attr);
            }
        }
        elseif($rand_arr[$rand] == 'flickr')
        {
            unset($rand_arr[$rand]);
            $rez = youtubomatic_get_flickr_image($youtubomatic_Main_Settings, $query_words, $original_url, $res_cnt);
            if($rez !== false && $rez !== '')
            {
                $img_attr = str_replace('%%image_source_name%%', 'Flickr', $img_attr);
                $img_attr = str_replace('%%image_source_url%%', $original_url, $img_attr);
                $img_attr = str_replace('%%image_source_website%%', 'https://www.flickr.com/', $img_attr);
            }
        }
        elseif($rand_arr[$rand] == 'pexels')
        {
            unset($rand_arr[$rand]);
            $rez = youtubomatic_get_pexels_image($youtubomatic_Main_Settings, $query_words, $original_url, $res_cnt);
            if($rez !== false && $rez !== '')
            {
                $img_attr = str_replace('%%image_source_name%%', 'Pexels', $img_attr);
                $img_attr = str_replace('%%image_source_url%%', $original_url, $img_attr);
                $img_attr = str_replace('%%image_source_website%%', 'https://www.pexels.com/', $img_attr);
            }
        }
        elseif($rand_arr[$rand] == 'pixabayscrape')
        {
            unset($rand_arr[$rand]);
            $rez = youtubomatic_scrape_pixabay_image($youtubomatic_Main_Settings, $query_words, $original_url);
            if($rez !== false && $rez !== '')
            {
                $img_attr = str_replace('%%image_source_name%%', 'Pixabay', $img_attr);
                $img_attr = str_replace('%%image_source_url%%', $original_url, $img_attr);
                $img_attr = str_replace('%%image_source_website%%', 'https://pixabay.com/', $img_attr);
            }
        }
        elseif($rand_arr[$rand] == 'unsplash')
        {
            unset($rand_arr[$rand]);
            $rez = youtubomatic_scrape_unsplash_image($query_words, $original_url);
            if($rez !== false && $rez !== '')
            {
                $img_attr = str_replace('%%image_source_name%%', 'Unsplash', $img_attr);
                $img_attr = str_replace('%%image_source_url%%', $original_url, $img_attr);
                $img_attr = str_replace('%%image_source_website%%', 'https://unsplash.com/', $img_attr);
            }
        }
        else
        {
            youtubomatic_log_to_file('Unrecognized free file source: ' . $rand_arr[$rand]);
            unset($rand_arr[$rand]);
        }
    }
    $img_attr = str_replace('%%image_source_name%%', '', $img_attr);
    $img_attr = str_replace('%%image_source_url%%', '', $img_attr);
    $img_attr = str_replace('%%image_source_website%%', '', $img_attr);
    return $rez;
}
function youtubomatic_get_redirect_url($url){
    $url_parts = parse_url($url);
    if (!$url_parts) return false;
    if (!isset($url_parts['host'])) return false;
    if (!isset($url_parts['path'])) $url_parts['path'] = '/';

    $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
    if (!$sock) return false;

    $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1".PHP_EOL; 
    $request .= 'Host: ' . $url_parts['host'] . PHP_EOL; 
    $request .= "Connection: Close".PHP_EOL.PHP_EOL; 
    fwrite($sock, $request);
    $response = '';
    while(!feof($sock)) $response .= fread($sock, 8192);
    fclose($sock);

    if (preg_match('/^Location: (.+?)$/m', $response, $matches)){
        if ( substr($matches[1], 0, 1) == "/" )
            return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
        else
            return trim($matches[1]);

    } else {
        return false;
    }
}
function youtubomatic_get_all_redirects($url){
    $redirects = array();
    while ($newurl = youtubomatic_get_redirect_url($url)){
        if (in_array($newurl, $redirects)){
            break;
        }
        $redirects[] = esc_url($newurl);
        $url = esc_url($newurl);
    }
    return $redirects;
}

function youtubomatic_get_final_url($url){
    if (strpos($url, 'localhost') !== false)
    {
        return $url;
    }
    $redirects = youtubomatic_get_all_redirects($url);
    if (count($redirects)>0){
        return array_pop($redirects);
    } else {
        return $url;
    }
}
function youtubomatic_scrape_unsplash_image($query, &$original_url)
{
    $original_url = 'https://unsplash.com/';
    $feed_uri = 'https://source.unsplash.com/1600x900/';
    if($query != '')
    {
        $feed_uri .= '?' . urlencode($query);
    }
    $exec = get_headers($feed_uri);
    if ($exec === FALSE || !is_array($exec))
    {
        youtubomatic_log_to_file('Error while getting api url: ' . $feed_uri);
    }
    $nono = false;
    $locx = false;
    foreach($exec as $ex)
    {
        if(strstr($ex, 'Location:') !== false)
        {
            if(strstr($ex, 'source-404') !== false)
            {
                $nono = true;
            }
            $locx = $ex;
            $locx = preg_replace('/^Location: /', '', $locx);
            break;
        }
    }
    if($nono == true)
    {
        youtubomatic_log_to_file('NO image found on Unsplash for query: ' . $query);
        return false;
    }
    else
    {
        if($locx == false)
        {
            youtubomatic_log_to_file('Failed to parse response: ' . $feed_uri);
            return false;
        }
        $original_url = $locx;
        return $locx;
    }
}
function youtubomatic_generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function youtubomatic_get_pixabay_image($app_id, $query, $lang, $image_type, $orientation, $order, $image_category, $max_width, $min_width, $safe_search, $editors_choice, &$original_url, $get_max = 3)
{
    $original_url = 'https://pixabay.com';
    $featured_image = '';
    $feed_uri = 'https://pixabay.com/api/?key=' . $app_id;
    if($query != '')
    {
        $feed_uri .= '&q=' . urlencode($query);
    }
    $feed_uri .= '&per_page=' . $get_max;
    if($lang != '' && $lang != 'any')
    {
        $feed_uri .= '&lang=' . $lang;
    }
    if($image_type != '')
    {
        $feed_uri .= '&image_type=' . $image_type;
    }
    if($orientation != '')
    {
        $feed_uri .= '&orientation=' . $orientation;
    }
    if($order != '')
    {
        $feed_uri .= '&order=' . $order;
    }
    if($image_category != '')
    {
        $feed_uri .= '&category=' . $image_category;
    }
    if($max_width != '')
    {
        $feed_uri .= '&max_width=' . $max_width;
    }
    if($min_width != '')
    {
        $feed_uri .= '&min_width=' . $min_width;
    }
    if($safe_search == '1')
    {
        $feed_uri .= '&safesearch=true';
    }
    if($editors_choice == '1')
    {
        $feed_uri .= '&editors_choice=true';
    }
    $feed_uri .= '&callback=' . youtubomatic_generateRandomString(6);
     
    $exec = youtubomatic_get_web_page($feed_uri);
    if ($exec !== FALSE) 
    {
        if (stristr($exec, '"hits"') !== FALSE) 
        {
            $json  = json_decode($exec);
            $items = $json->hits;
            if (count($items) != 0) 
            {
                shuffle($items);
                foreach($items as $item)
                {
                    $featured_image = $item->webformatURL;
                    $original_url = $item->pageURL;
                    break;
                }
            }
        }
        else
        {
            youtubomatic_log_to_file('Unknow response from api: ' . $feed_uri . ' - resp: ' . $exec);
        }
    }
    else
    {
        youtubomatic_log_to_file('Error while getting api url: ' . $feed_uri);
        return false;
    }
    return $featured_image;
}
function youtubomatic_scrape_pixabay_image($youtubomatic_Main_Settings, $query, &$original_url)
{
    $original_url = 'https://pixabay.com';
    $featured_image = '';
    $feed_uri = 'https://pixabay.com/en/photos/';
    if($query != '')
    {
        $feed_uri .= '?q=' . urlencode($query);
    }

    if($youtubomatic_Main_Settings['scrapeimgtype'] != 'all')
    {
        $feed_uri .= '&image_type=' . $youtubomatic_Main_Settings['scrapeimgtype'];
    }
    if($youtubomatic_Main_Settings['scrapeimg_orientation'] != '')
    {
        $feed_uri .= '&orientation=' . $youtubomatic_Main_Settings['scrapeimg_orientation'];
    }
    if($youtubomatic_Main_Settings['scrapeimg_order'] != '' && $youtubomatic_Main_Settings['scrapeimg_order'] != 'any')
    {
        $feed_uri .= '&order=' . $youtubomatic_Main_Settings['scrapeimg_order'];
    }
    if($youtubomatic_Main_Settings['scrapeimg_cat'] != '')
    {
        $feed_uri .= '&category=' . $youtubomatic_Main_Settings['scrapeimg_cat'];
    }
    if($youtubomatic_Main_Settings['scrapeimg_height'] != '')
    {
        $feed_uri .= '&min_height=' . $youtubomatic_Main_Settings['scrapeimg_height'];
    }
    if($youtubomatic_Main_Settings['scrapeimg_width'] != '')
    {
        $feed_uri .= '&min_width=' . $youtubomatic_Main_Settings['scrapeimg_width'];
    }
    $exec = youtubomatic_get_web_page($feed_uri);
    if ($exec !== FALSE) 
    {
        preg_match_all('/<a href="([^"]+?)".+?(?:data-lazy|src)="([^"]+?\.jpg|png)"/i', $exec, $matches);
        if (!empty($matches[2])) {
            $p = array_combine($matches[1], $matches[2]);
            if(count($p) > 0)
            {
                shuffle($p);
                foreach ($p as $key => $val) {
                    $featured_image = $val;
                    if(!is_numeric($key))
                    {
                        if(substr($key, 0, 4) !== "http")
                        {
                            $key = 'https://pixabay.com' . $key;
                        }
                        $original_url = $key;
                    }
                    else
                    {
                        $original_url = 'https://pixabay.com';
                    }
                    break;
                }
            }
        }
    }
    else
    {
        youtubomatic_log_to_file('Error while getting api url: ' . $feed_uri);
        return false;
    }
    return $featured_image;
}
function youtubomatic_get_morguefile_image($app_id, $app_secret, $query, &$original_url)
{
    $featured_image = '';
    if(!class_exists('youtubomatic_morguefile'))
    {
        require_once (dirname(__FILE__) . "/res/morguefile/mf.api.class.php");
    }
    $query = explode(' ', $query);
    $query = $query[0];
    {
        $mf = new youtubomatic_morguefile($app_id, $app_secret);
        $rez = $mf->call('/images/search/sort/page/' . $query);
        if ($rez !== FALSE) 
        {
            $chosen_one = $rez->doc[array_rand($rez->doc)];
            if (isset($chosen_one->file_path_large)) 
            {
                return $chosen_one->file_path_large;
            }
            else
            {
                return false;
            }
        }
        else
        {
            youtubomatic_log_to_file('Error while getting api response from morguefile.');
            return false;
        }
    }
    return $featured_image;
}
function youtubomatic_get_flickr_image($youtubomatic_Main_Settings, $query, &$original_url, $max)
{
    $original_url = 'https://www.flickr.com';
    $featured_image = '';
    $feed_uri = 'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key=' . $youtubomatic_Main_Settings['flickr_api'] . '&media=photos&per_page=' . esc_html($max) . '&format=php_serial&text=' . urlencode($query);
    if(isset($youtubomatic_Main_Settings['flickr_license']) && $youtubomatic_Main_Settings['flickr_license'] != '-1')
    {
        $feed_uri .= '&license=' . $youtubomatic_Main_Settings['flickr_license'];
    }
    if(isset($youtubomatic_Main_Settings['flickr_order']) && $youtubomatic_Main_Settings['flickr_order'] != '')
    {
        $feed_uri .= '&sort=' . $youtubomatic_Main_Settings['flickr_order'];
    }
    $feed_uri .= '&extras=description,license,date_upload,date_taken,owner_name,icon_server,original_format,last_update,geo,tags,machine_tags,o_dims,views,media,path_alias,url_sq,url_t,url_s,url_q,url_m,url_n,url_z,url_c,url_l,url_o';
     
    {
        $ch               = curl_init();
        if ($ch === FALSE) {
            youtubomatic_log_to_file('Failed to init curl for flickr!');
            return false;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Referer: https://www.flickr.com/'));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $feed_uri);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $exec = curl_exec($ch);
        curl_close($ch);
        if (stristr($exec, 'photos') === FALSE) {
            youtubomatic_log_to_file('Unrecognized Flickr API response: ' . $exec . ' URI: ' . $feed_uri);
            return false;
        }
        $items = unserialize ( $exec );
        if(!isset($items['photos']['photo']))
        {
            youtubomatic_log_to_file('Failed to find photo node in response: ' . $exec . ' URI: ' . $feed_uri);
            return false;
        }
        if(count($items['photos']['photo']) == 0)
        {
            return $featured_image;
        }
        $x = 0;
        shuffle($items['photos']['photo']);
        while($featured_image == '' && isset($items['photos']['photo'][$x]))
        {
            $item = $items['photos']['photo'][$x];
            if(isset($item['url_o']))
            {
                $featured_image = $item['url_o'];
            }
            elseif(isset($item['url_l']))
            {
                $featured_image = $item['url_l'];
            }
            elseif(isset($item['url_c']))
            {
                $featured_image = $item['url_c'];
            }
            elseif(isset($item['url_z']))
            {
                $featured_image = $item['url_z'];
            }
            elseif(isset($item['url_n']))
            {
                $featured_image = $item['url_n'];
            }
            elseif(isset($item['url_m']))
            {
                $featured_image = $item['url_m'];
            }
            elseif(isset($item['url_q']))
            {
                $featured_image = $item['url_q'];
            }
            elseif(isset($item['url_s']))
            {
                $featured_image = $item['url_s'];
            }
            elseif(isset($item['url_t']))
            {
                $featured_image = $item['url_t'];
            }
            elseif(isset($item['url_sq']))
            {
                $featured_image = $item['url_sq'];
            }
            if($featured_image != '')
            {
                $original_url = esc_url('https://www.flickr.com/photos/' . $item['owner'] . '/' . $item['id']);
            }
            $x++;
        }
    }
    return $featured_image;
}
function youtubomatic_get_pexels_image($youtubomatic_Main_Settings, $query, &$original_url, $max)
{
    $original_url = 'https://pexels.com';
    $featured_image = '';
    $feed_uri = 'https://api.pexels.com/v1/search?query=' . urlencode($query) . '&per_page=' . $max;
     
    {
        $ch               = curl_init();
        if ($ch === FALSE) {
            youtubomatic_log_to_file('Failed to init curl for flickr!');
            return false;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . esc_html($youtubomatic_Main_Settings['pexels_api'])));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $feed_uri);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $exec = curl_exec($ch);
        curl_close($ch);
        if (stristr($exec, 'photos') === FALSE) {
            youtubomatic_log_to_file('Unrecognized Pexels API response: ' . $exec . ' URI: ' . $feed_uri);
            return false;
        }
        $items = json_decode ( $exec, true );
        if(!isset($items['photos']))
        {
            youtubomatic_log_to_file('Failed to find photo node in Pexels response: ' . $exec . ' URI: ' . $feed_uri);
            return false;
        }
        if(count($items['photos']) == 0)
        {
            return $featured_image;
        }
        $x = 0;
        shuffle($items['photos']);
        while($featured_image == '' && isset($items['photos'][$x]))
        {
            $item = $items['photos'][$x];
            if(isset($item['src']['large']))
            {
                $featured_image = $item['src']['large'];
            }
            elseif(isset($item['src']['medium']))
            {
                $featured_image = $item['src']['medium'];
            }
            elseif(isset($item['src']['small']))
            {
                $featured_image = $item['src']['small'];
            }
            elseif(isset($item['src']['portrait']))
            {
                $featured_image = $item['src']['portrait'];
            }
            elseif(isset($item['src']['landscape']))
            {
                $featured_image = $item['src']['landscape'];
            }
            elseif(isset($item['src']['original']))
            {
                $featured_image = $item['src']['original'];
            }
            elseif(isset($item['src']['tiny']))
            {
                $featured_image = $item['src']['tiny'];
            }
            if($featured_image != '')
            {
                $original_url = $item['url'];
            }
            $x++;
        }
    }
    return $featured_image;
}


function youtubomatic_encodeURI($url) {
    $unescaped = array(
        '%2D'=>'-','%5F'=>'_','%2E'=>'.','%21'=>'!', '%7E'=>'~',
        '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')'
    );
    $reserved = array(
        '%3B'=>';','%2C'=>',','%2F'=>'/','%3F'=>'?','%3A'=>':',
        '%40'=>'@','%26'=>'&','%3D'=>'=','%2B'=>'+','%24'=>'$'
    );
    $score = array(
        '%23'=>'#'
    );
    return strtr(rawurlencode($url), array_merge($reserved,$unescaped,$score));

}

function youtubomatic_shortest_url_handle($href, $api_key)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.shorte.st/v1/data/url");
    curl_setopt($ch, CURLOPT_POSTFIELDS, "urlToShorten=" . trim($href));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $headers = [
        'public-api-token: ' . $api_key,
        'Content-Type: application/x-www-form-urlencoded'
    ];
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $serverOutput = json_decode(curl_exec($ch), true);
    curl_close($ch);
    if (!isset($serverOutput['shortenedUrl']) || $serverOutput['shortenedUrl'] == '') {
        return $href;
    } else {
        return esc_url($serverOutput['shortenedUrl']);
    }  
}
function youtubomatic_url_handle($href)
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if(isset($youtubomatic_Main_Settings['shortest_api']) && $youtubomatic_Main_Settings['shortest_api'] != '')
    {
        $short_url = youtubomatic_shortest_url_handle($href, $youtubomatic_Main_Settings['shortest_api']);
        if($short_url != $href)
        {
            return $short_url;
        }
    }
    if (isset($youtubomatic_Main_Settings['links_hide']) && $youtubomatic_Main_Settings['links_hide'] == 'on') {
        $cloak_urls = true;
    } else {
        $cloak_urls = false;
    }
    if (isset($youtubomatic_Main_Settings['apiKey'])) {
        $apiKey = trim($youtubomatic_Main_Settings['apiKey']);
    } else {
        $apiKey = '';
    }
    if ($cloak_urls == true && $apiKey != '') {
        $youtubomatic_short_group = get_option('youtubomatic_short_group', false);
        $found = false;
        if($youtubomatic_short_group !== false)
        {
            $youtubomatic_short_group = explode('#', $youtubomatic_short_group);
            if(isset($youtubomatic_short_group[1]) && $youtubomatic_short_group[0] == $apiKey)
            {
                $youtubomatic_short_group = $youtubomatic_short_group[1];
                $found = true;
            }
        }
        if($found == false)
        {
            $url = 'https://api-ssl.Bitly.com/v4/groups';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $headers = [
                'Authorization: Bearer ' . $apiKey,
                'Accept: application/json',
                'Host: api-ssl.Bitly.com'
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            $serverOutput = json_decode(curl_exec($ch), true);
            curl_close($ch);
            if(isset($serverOutput['groups'][0]['guid']))
            {
                $youtubomatic_short_group = $serverOutput['groups'][0]['guid'];
                update_option('youtubomatic_short_group', false);
                $found = true;
            }
        }
        if($found == false)
        {
            return $href;
        }
        $url = 'https://api-ssl.Bitly.com/v4/shorten';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $headers = [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'Host: api-ssl.Bitly.com'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        $fdata = "";
        $data['long_url'] = trim($href);
        $data['group_guid'] = $youtubomatic_short_group;
        $fdata = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
        $serverOutput = json_decode(curl_exec($ch), true);
        curl_close($ch);
        if (!isset($serverOutput['link']) || $serverOutput['link'] == '') {
            return $href;
        } else {
            return esc_url($serverOutput['link']);
        }  
    } else {
        return $href;
    }
}
function youtubomatic_post_url_handle($href)
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['links_hide_google2']) && $youtubomatic_Main_Settings['links_hide_google2'] == 'on') {
        $cloak_urls = true;
    } else {
        $cloak_urls = false;
    }
    if (isset($youtubomatic_Main_Settings['apiKey'])) {
        $apiKey = trim($youtubomatic_Main_Settings['apiKey']);
    } else {
        $apiKey = '';
    }
    if ($cloak_urls == true && $apiKey != '') {
        $youtubomatic_short_group = get_option('youtubomatic_short_group', false);
        $found = false;
        if($youtubomatic_short_group !== false)
        {
            $youtubomatic_short_group = explode('#', $youtubomatic_short_group);
            if(isset($youtubomatic_short_group[1]) && $youtubomatic_short_group[0] == $apiKey)
            {
                $youtubomatic_short_group = $youtubomatic_short_group[1];
                $found = true;
            }
        }
        if($found == false)
        {
            $url = 'https://api-ssl.Bitly.com/v4/groups';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            $headers = [
                'Authorization: Bearer ' . $apiKey,
                'Accept: application/json',
                'Host: api-ssl.Bitly.com'
            ];
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $serverOutput = json_decode(curl_exec($ch), true);
            curl_close($ch);
            if(isset($serverOutput['groups'][0]['guid']))
            {
                $youtubomatic_short_group = $serverOutput['groups'][0]['guid'];
                update_option('youtubomatic_short_group', false);
                $found = true;
            }
        }
        if($found == false)
        {
            return $href;
        }
        $url = 'https://api-ssl.Bitly.com/v4/shorten';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $headers = [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'Host: api-ssl.Bitly.com'
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        $fdata = "";
        $data['long_url'] = trim($href);
        $data['group_guid'] = $youtubomatic_short_group;
        $fdata = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
        $serverOutput = json_decode(curl_exec($ch), true);
        curl_close($ch);
        if (!isset($serverOutput['link']) || $serverOutput['link'] == '') {
            return $href;
        } else {
            return esc_url($serverOutput['link']);
        }  
    } else {
        return $href;
    }
}


function youtubomatic_get_mime ($filename) {
    $mime_types = array(
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'mts' => 'video/mp2t',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'wmv' => 'video/x-ms-wmv',
        'mp4' => 'video/mp4',
        'm4p' => 'video/m4p',
        'm4v' => 'video/m4v',
        'mpg' => 'video/mpg',
        'mp2' => 'video/mp2',
        'mpe' => 'video/mpe',
        'mpv' => 'video/mpv',
        'm2v' => 'video/m2v',
        'm4v' => 'video/m4v',
        '3g2' => 'video/3g2',
        '3gpp' => 'video/3gpp',
        'f4v' => 'video/f4v',
        'f4p' => 'video/f4p',
        'f4a' => 'video/f4a',
        'f4b' => 'video/f4b',
        '3gp' => 'video/3gp',
        'avi' => 'video/x-msvideo',
        'mpeg' => 'video/mpeg',
        'mpegps' => 'video/mpeg',
        'webm' => 'video/webm',
        'mpeg4' => 'video/mp4',
        'mkv' => 'video/mkv',
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        'docx' => 'application/msword',
        'xlsx' => 'application/vnd.ms-excel',
        'pptx' => 'application/vnd.ms-powerpoint',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );
    $ext = array_values(array_slice(explode('.', $filename), -1));$ext = $ext[0];
    if(stristr($filename, 'dailymotion.com'))
    {
        return 'application/octet-stream';
    }
    if (function_exists('mime_content_type')) {
        $mimetype = mime_content_type($filename);
        if($mimetype == '')
        {
            if (array_key_exists($ext, $mime_types)) {
                return $mime_types[$ext];
            } else {
                return 'application/octet-stream';
            }
        }
        return $mimetype;
    }
    elseif (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME);
        $mimetype = finfo_file($finfo, $filename);
        finfo_close($finfo);
        if($mimetype === false)
        {
            if (array_key_exists($ext, $mime_types)) {
                return $mime_types[$ext];
            } else {
                return 'application/octet-stream';
            }
        }
        return $mimetype;

    } elseif (array_key_exists($ext, $mime_types)) {
        return $mime_types[$ext];
    } else {
        return 'application/octet-stream';
    }
}
function youtubomatic_IsResourceLocal($url){
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    if( empty( $url ) ){ return false; }
    $urlParsed = parse_url( $url );
    $host = $urlParsed['host'];
    if( empty( $host ) ){ 
        $doc_root = $_SERVER['DOCUMENT_ROOT'];
        $maybefile = $doc_root.$url;
        $fileexists = $wp_filesystem->exists ( $maybefile );
        if( $fileexists ){
            return true;        
        }
    }
    $host = str_replace('www.','',$host);
    $thishost = $_SERVER['HTTP_HOST'];
    $thishost = str_replace('www.','',$thishost);
    if( $host == $thishost ){
        return true;
    }
    return false;
}

function youtubomatic_filter_autosave_interval($interval){
	return 60 * 60 * 60;
}
function youtubomatic_getUrls($string) {
        $regex = '/https?\:\/\/[^\"\' \n\s]+/i';
        preg_match_all($regex, $string, $matches);
        return ($matches[0]);
}
function youtubomatic_upload_media_library($image_url)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $upload_dir = wp_upload_dir();
    $rand = uniqid();
    if (wp_mkdir_p($upload_dir['path']))
    {
        $file = $upload_dir['path'] . '/youtubetempupload' . $rand . '.mp4';
        $path = $upload_dir['url'] . '/youtubetempupload' . $rand . '.mp4';
    }
    else
    {
        $file = $upload_dir['basedir'] . '/youtubetempupload' . $rand . '.mp4';
        $path = $upload_dir['baseurl'] . '/youtubetempupload' . $rand . '.mp4';
    }
    $ret = $wp_filesystem->copy($image_url, $file, true);
    if($ret === false)
    {
        $errors= error_get_last();
        youtubomatic_log_to_file('Failed to copy video file locally to server: ' . $errors['type'] . ' - ' . $errors['message']);
        return false;
    }
    else
    {
        return array($path, $file);
    }
}
function youtubomatic_getDMMP4($vimeo_id) 
{
    $result = youtubomatic_get_web_page("https://www.dailymotion.com/embed/video/" . $vimeo_id);
    if($result === false)
    {
        global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
        $result = $wp_filesystem->get_contents($vimeo_id);
    }
    if($result === false)
    {
        return false;
    }
    preg_match_all('#{"type":"application\\\/x-mpegURL","url":"([^"]*?)"}]#i', $result, $matches);
    if(!isset($matches[1][0]))
    {
        return false;
    }
    $middleElem = floor(count($matches[1])/2);
    return stripslashes($matches[1][$middleElem]);
}
function youtubomatic_getFBMP4($vimeo_id) 
{
    $result = youtubomatic_get_web_page($vimeo_id);
    if($result === false)
    {
        global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
        $result = $wp_filesystem->get_contents($vimeo_id);
    }
    if($result === false)
    {
        return false;
    }
    preg_match_all('#hd_src(?:_no_ratelimit)?:"([^"]+?)"#i', $result, $matches);
    if(!isset($matches[1][0]))
    {
        return false;
    }
    return $matches[1][0];
}
function youtubomatic_getTWMP4($vimeo_id) 
{
    $result = youtubomatic_get_web_page($vimeo_id);
    if($result === false)
    {
        global $wp_filesystem;
        if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
            include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
            wp_filesystem($creds);
        }
        $result = $wp_filesystem->get_contents($vimeo_id);
    }
    if($result === false)
    {
        return false;
    }
    preg_match_all('#{"quality":"720","source":"(.+?)"#i', $result, $matches);
    if(!isset($matches[1][0]))
    {
        return false;
    }
    return $matches[1][0];
}
function youtubomatic_getVimeoMP4($vimeo_id) 
{
    require_once(dirname(__FILE__) . "/res/vimeodl.php");
    $vd = new VideoControllerDownloaderLoader();
    $vimeo_link = $vd->getVimeoDirectUrl('https://vimeo.com/' . $vimeo_id);
    return trim($vimeo_link);
}

add_action('youtubomatic_new_post_cron', 'youtubomatic_do_post', 10, 1);
add_action('transition_post_status', 'youtubomatic_new_post', 10, 3);

function youtubomatic_new_post($new_status, $old_status, $post)
{
    if ('publish' !== $new_status or 'publish' === $old_status)
    {
        return;
    }
    else
    {
        if($old_status == 'auto-draft' && $new_status == 'publish' && !has_post_thumbnail($post->ID) && ((function_exists('has_blocks') && has_blocks($post)) || ($post->post_content == '' && function_exists('has_blocks') && !class_exists('Classic_Editor'))))
        {
            $delay_it_is_gutenberg = true;
        }
        else
        {
            $delay_it_is_gutenberg = false;
        }
    }
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') 
    {
        $youtubomatic_Youtube_Settings = get_option('youtubomatic_Youtube_Settings', false);
        if (isset($youtubomatic_Youtube_Settings['youtubomatic_posting']) && $youtubomatic_Youtube_Settings['youtubomatic_posting'] == 'on') {
            if (isset($youtubomatic_Youtube_Settings['delay_post']) && $youtubomatic_Youtube_Settings['delay_post'] != '' && is_numeric($youtubomatic_Youtube_Settings['delay_post'])) {
                if(wp_next_scheduled('youtubomatic_new_post_cron', array($post)) === false)
                {
                    if($delay_it_is_gutenberg && $youtubomatic_Youtube_Settings['delay_post'] < 2)
                    {
                        $youtubomatic_Youtube_Settings['delay_post'] = 2;
                    }
                    wp_schedule_single_event( time() + $youtubomatic_Youtube_Settings['delay_post'], 'youtubomatic_new_post_cron', array($post) );
                }
            }
            else
            {
                if (isset($youtubomatic_Youtube_Settings['run_background']) && $youtubomatic_Youtube_Settings['run_background'] == 'on') {
                    if($delay_it_is_gutenberg)
                    {
                        if(wp_next_scheduled('youtubomatic_new_post_cron', array($post)) === false)
                        {
                            wp_schedule_single_event( time() + 2, 'youtubomatic_new_post_cron', array($post) );
                        }
                    }
                    else
                    {
                        $unique_id = uniqid();
                        update_option('youtubomatic_do_post_uniqid', $unique_id);
                        $xcron_url = site_url( '?youtubomatic_do_post_cronjob=1&post_id=' . $post->ID . '&youtubomatic_do_post_key=' . $unique_id);
                        wp_remote_post( $xcron_url, array( 'timeout' => 1, 'blocking' => false, 'sslverify' => false ) );
                    }
                }
                else
                {
                    if($delay_it_is_gutenberg)
                    {
                        if(wp_next_scheduled('youtubomatic_new_post_cron', array($post)) === false)
                        {
                            wp_schedule_single_event( time() + 2, 'youtubomatic_new_post_cron', array($post) );
                        }
                    }
                    else
                    {
                        youtubomatic_do_post($post);
                    }
                }
            }
        }
    }
    
}
add_action('init', 'youtubomatic_do_post_callback', 0);
function youtubomatic_do_post_callback()
{
    if (isset($_GET['youtubomatic_do_post_cronjob']) && $_GET['youtubomatic_do_post_cronjob'] == '1' && isset($_GET['post_id']) && is_numeric($_GET['post_id']))
    {
        $secretp_key = get_option('youtubomatic_do_post_uniqid', false);
        if($_GET['youtubomatic_do_post_key'] === $secretp_key)
        {
            $post = get_post($_GET['post_id']);
            if($post !== null)
            {
                youtubomatic_do_post($post);
                exit();
            }
        }
    }
}
function youtubomatic_format_wp_limit( $size ) {
	$value  = substr( $size, -1 );
	$return = substr( $size, 0, -1 );
	$return = (int)$return;
	switch ( strtoupper( $value ) ) {
		case 'P' :
			$return*= 1024;
		case 'T' :
			$return*= 1024;
		case 'G' :
			$return*= 1024;
		case 'M' :
            $return*= 1024;
		case 'K' :
			$return*= 1024;
	}
	return $return;
}
function youtubomatic_do_post($post, $manual = false)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['rule_timeout']) && $youtubomatic_Main_Settings['rule_timeout'] != '') {
        $timeout = intval($youtubomatic_Main_Settings['rule_timeout']);
    } else {
        $timeout = 3600;
    }
    ini_set('safe_mode', 'Off');
    ini_set('max_execution_time', $timeout);
    ini_set('ignore_user_abort', 1);
    ini_set('user_agent', youtubomatic_get_random_user_agent());
    ignore_user_abort(true);
    set_time_limit($timeout);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on') {
        $youtubomatic_Youtube_Settings = get_option('youtubomatic_Youtube_Settings', false);
        if ($manual || isset($youtubomatic_Youtube_Settings['youtubomatic_posting']) && $youtubomatic_Youtube_Settings['youtubomatic_posting'] == 'on') {
            if (!isset($youtubomatic_Main_Settings['oauth_key']) || trim($youtubomatic_Main_Settings['oauth_key']) == '') {
                if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                {
                    youtubomatic_log_to_file('No oAuth key set in plugin settings');
                }
                return;
            }
            if (!isset($youtubomatic_Main_Settings['oauth_secret']) || trim($youtubomatic_Main_Settings['oauth_secret']) == '') {
                youtubomatic_log_to_file('Please insert your Google OAuth2 Secret in plugin settings before we can automatically publish on YouTube.');
                return;
            }
            if (isset($youtubomatic_Youtube_Settings['post_posts'])) {
                if ($youtubomatic_Youtube_Settings['post_posts'] == 'on' && 'post' === $post->post_type) {
                    if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                    {
                        youtubomatic_log_to_file('Skipping post type.');
                    }
                    return;
                }
            }
            if (isset($youtubomatic_Youtube_Settings['post_pages'])) {
                if ($youtubomatic_Youtube_Settings['post_pages'] == 'on' && 'page' === $post->post_type) {
                    if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                    {
                        youtubomatic_log_to_file('Skipping page type.');
                    }
                    return;
                }
            }
            if (isset($youtubomatic_Youtube_Settings['post_custom'])) {
                if ($youtubomatic_Youtube_Settings['post_custom'] == 'on' && 'page' != $post->post_type && 'post' != $post->post_type) {
                    if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                    {
                        youtubomatic_log_to_file('Skipping custom post type.');
                    }
                    return;
                }
            }
            $deletes = array();
            $meta = get_post_meta($post->ID, "youtubomatic_published", true);
            if ($meta == 'pub') {
                if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                {
                    youtubomatic_log_to_file('This post is already published, skipping.');
                }
                return;
            }
            $authorized = FALSE;
            if($youtubomatic_Main_Settings['oauth_key'] == get_option('youtubomatic_access_token_auth_id', false) && $youtubomatic_Main_Settings['oauth_secret'] == get_option('youtubomatic_access_token_auth_secret', false) && get_option('youtubomatic_access_token_str', false) !== FALSE) {
                $authorized = TRUE;
            }
            if ($authorized === FALSE) {
                if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                {
                    youtubomatic_log_to_file('The plugin is not authorized to post, please reauthorize it in settings.');
                }
                return;
            }
            $reauth = get_option('youtubomatic_need_reauth', false);
            if($reauth === 'true') 
            {
                youtubomatic_log_to_file('YouTube unauthorized your App because of some recent upload errors. Please reauthorize it in plugin settings!');
                return;
            }
            $post_cats        = get_post_meta($post->ID, 'youtubomatic_post_cats', true);
            if($post_cats == '')
            {
                $cats = wp_get_post_categories($post->ID);
                $post_categories = array();
                foreach($cats as $c){
                    $cat = get_category( $c );
                    $post_categories[] = $cat->name;
                }
            }
            else
            {
                $post_categories  = explode(',', $post_cats);
            }
            if(count($post_categories) == 0)
            {
                $terms = get_the_terms( $post->ID, 'product_cat' );
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                    foreach ( $terms as $term ) {
                        $post_categories[] = $term->slug;
                    }
                    $post_cats = implode(',', $post_categories);
                }
                
            }
            foreach($post_categories as $pc)
            {
                if (isset($youtubomatic_Youtube_Settings['disabled_categories']) && !empty($youtubomatic_Youtube_Settings['disabled_categories'])) {
                    foreach($youtubomatic_Youtube_Settings['disabled_categories'] as $disabled_cat)
                    {
                        if(trim($pc) == get_cat_name($disabled_cat))
                        {
                            if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                            {
                                youtubomatic_log_to_file('Skipping post by category.');
                            }
                            return;
                        }
                    }
                }
            }
            $post_tagz = get_post_meta($post->ID, 'youtubomatic_post_tags', true);
            if($post_tagz == '')
            {
                $tags = wp_get_post_tags($post->ID);
                $post_tags = array();
                foreach($tags as $t){
                    $post_tags[] = $t->name;
                }
            }
            else
            {
                $post_tags = explode(',', $post_tagz);
            }
            if(count($post_tags) == 0)
            {
                $terms = get_the_terms( $post->ID, 'product_tag' );
                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
                    foreach ( $terms as $term ) {
                        $post_tags[] = $term->slug;
                    }
                    $post_tagz = implode(',', $post_tags);
                }
                
            }
            foreach($post_tags as $pt)
            {
                if (isset($youtubomatic_Youtube_Settings['disable_tags']) && $youtubomatic_Youtube_Settings['disable_tags'] != '') {
                    
                    $disable_tags = explode(",", $youtubomatic_Youtube_Settings['disable_tags']);
                    foreach($disable_tags as $disabled_tag)
                    {
                        if(trim($pt) == trim($disabled_tag))
                        {
                            if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                            {
                                youtubomatic_log_to_file('Skipping post by tag.');
                            }
                            return;
                        }
                    }
                }
            }
            $pm = get_post_meta($post->ID, "avc_modified", true);
            if($pm == 'y')
            {
                $mypost = get_post($post->ID);
                if($mypost !== null && isset($mypost->post_content))
                {
                    $post->post_content = $mypost->post_content;
                }
            }
            $finals = array();
            $att = youtubomatic_getUrls($post->post_content);
            $att = array_unique($att);
            if(count($att) > 0)
            {
                foreach($att as $link)
                {
                    if(isset($youtubomatic_Youtube_Settings['only_local']) && $youtubomatic_Youtube_Settings['only_local'] == 'on')
                    {
                        if(!in_array($link, $finals) && youtubomatic_IsResourceLocal($link))
                        {
                            $mime = youtubomatic_get_mime($link);
                            if(stristr($mime, "video/mp2t") !== FALSE || stristr($mime, "video/quicktime") !== FALSE || stristr($mime, "video/mpeg4") !== FALSE || stristr($mime, "video/mp4") !== FALSE || stristr($mime, "video/x-msvideo") !== FALSE || stristr($mime, "video/x-ms-wmv") !== FALSE || stristr($mime, "video/mpeg") !== FALSE || stristr($mime, "video/x-flv") !== FALSE || stristr($mime, "video/3gpp") !== FALSE || stristr($mime, "video/webm") !== FALSE){
                                $finals[] = $link;
                            }
                        }
                    }
                }
            }
            else
            {
                if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                {
                    youtubomatic_log_to_file('No links found in post ID: ' . $post->ID);
                }
                return;
            }
            {
                foreach($att as $lnk)
                {
                    if(isset($youtubomatic_Youtube_Settings['youtube_embedded']) && $youtubomatic_Youtube_Settings['youtube_embedded'] == 'on')
                    {
                        $id = '';
                        parse_str( parse_url( $lnk, PHP_URL_QUERY ), $my_array_of_vars );
                        if(stristr($lnk, 'youtu') !== false && isset($my_array_of_vars['v']))
                        {
                            if(!preg_match('/^[A-Za-z0-9-_]+$/i', $my_array_of_vars['v']))
                            {
                                continue;
                            }
                            $id = $my_array_of_vars['v'];
                            
                        }
                        else
                        {
                            preg_match_all('#http(?:s)?:\/\/(?:www\.)?youtube\.com\/embed\/([^\/\s"\'?&]*)#i', $lnk, $embeds);
                            if(isset($embeds[1][0]))
                            {
                                $id = $embeds[1][0];
                            }
                            else
                            {
                                preg_match_all('#http(?:s)?:\/\/(?:www\.)?youtube\.com\/v\/([^\/\s"\'?&]*)#i', $lnk, $embeds);
                                if(isset($embeds[1][0]))
                                {
                                    $id = $embeds[1][0];
                                }
                                else
                                {
                                    preg_match_all('#http(?:s)?:\/\/(?:www\.)?youtu\.be\/([^\/\s"\'?&]*)#i', $lnk, $embeds);
                                    if(isset($embeds[1][0]))
                                    {
                                        $id = $embeds[1][0];
                                    }
                                    else
                                    {
                                        preg_match_all('#http(?:s)?:\/\/(?:www\.)?youtube\.com\/oembed\?url=http%3A\/\/(?:www\.)?youtube\.com\/watch\?v%3D([^\/\s"\'?&]*)#i', $lnk, $embeds);
                                        if(isset($embeds[1][0]))
                                        {
                                            $id = $embeds[1][0];
                                        }
                                        else
                                        {
                                            preg_match_all('#http(?:s)?:\/\/(?:www\.)?youtube\.com\/attribution_link\?a=(?:[^&])+&u=%2Fwatch%3Fv%3D([^\/\s"\'?&%]*)#i', $lnk, $embeds);
                                            if(isset($embeds[1][0]))
                                            {
                                                $id = $embeds[1][0];
                                            }
                                            else
                                            {
                                                preg_match_all('#http(?:s)?:\/\/(?:www\.)?youtube\.com\/watch\?v=([^\/\s"\'?&]*)#i', $lnk, $embeds);
                                                if(isset($embeds[1][0]))
                                                {
                                                    $id = $embeds[1][0];
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        if($id != '' && !isset($finals['xyoutubomatic' . $id]))
                        {
                            if(!class_exists('\YouTube\YouTubeDownloader'))
                            {
                                require_once(dirname(__FILE__) . "/res/youtube-dl/src/Browser.php");
                                require_once(dirname(__FILE__) . "/res/youtube-dl/src/Parser.php");
                                require_once(dirname(__FILE__) . "/res/youtube-dl/src/SignatureDecoder.php");
                                require_once(dirname(__FILE__) . "/res/youtube-dl/src/YouTubeDownloader.php");
                            }
                            $downloader = new YouTube\YouTubeDownloader();
                            $video = $downloader->getDownloadLinks('https://www.youtube.com/watch?v=' . $id);
                            $za_vid_mp4 = '';
                            $za_vid_other = '';
                            $za_vid = '';
                            $format_mp4 = 0;
                            $format_other = 0;
                            foreach($video as $myvid)
                            {
                                if(isset($myvid['format']) && isset($myvid['url']))
                                {
                                    $vid_dets = explode(',', $myvid['format']);
                                    if(isset($vid_dets[1]) && isset($vid_dets[2]))
                                    {
                                        if(strstr($vid_dets[2], 'video') == true && strstr($vid_dets[2], 'audio') == true)
                                        {
                                            if(trim($vid_dets[0]) == 'mp4')
                                            {
                                                $vid_dets[1] = trim(trim($vid_dets[1]), 'p');
                                                if(is_numeric($vid_dets[1]) && intval($vid_dets[1]) > $format_mp4)
                                                {
                                                    $format_mp4 = intval($vid_dets[1]);
                                                    $za_vid_mp4 = $myvid['url'];
                                                }
                                            }
                                            else
                                            {
                                                $vid_dets[1] = trim(trim($vid_dets[1]), 'p');
                                                if(is_numeric($vid_dets[1]) && intval($vid_dets[1]) > $format_other)
                                                {
                                                    $format_other = intval($vid_dets[1]);
                                                    $za_vid_other = $myvid['url'];
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        if($za_vid == '')
                                        {
                                            $za_vid = $myvid['url'];
                                        }
                                    }
                                }
                            }
                            if($za_vid_mp4 == '')
                            {
                                if($za_vid_other != '')
                                {
                                    $za_vid = $za_vid_other;
                                }
                            }
                            else
                            {
                                $za_vid = $za_vid_mp4;
                            }
                            if($za_vid != '')
                            {
                                $local_path = youtubomatic_upload_media_library($za_vid);
                                if($local_path !== false)
                                {
                                    $finals['xyoutubomatic' . $id] = $local_path[0];
                                    $deletes['xyoutubomatic' . $id] = $local_path[1];
                                }
                                else
                                {
                                    if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                                    {
                                        youtubomatic_log_to_file('Failed to upload video to local library: ' . print_r($za_vid, true));
                                    }
                                }
                            }
                            else
                            {
                                if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                                {
                                    youtubomatic_log_to_file('Failed to download video from YouTube, ID: ' . $id . ' result: ' . print_r($video, true));
                                }
                            }
                        }
                    }
                    if(isset($youtubomatic_Youtube_Settings['vimeo_embedded']) && $youtubomatic_Youtube_Settings['vimeo_embedded'] == 'on')
                    {
                        preg_match_all('/https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)?/', $lnk, $vimeos);
                        if(isset($vimeos[3][0]) && is_numeric($vimeos[3][0]))
                        {
                            $vimeourl = youtubomatic_getVimeoMP4($vimeos[3][0]);
                            if($vimeourl !== false && $vimeourl !== '')
                            {
                                $local_path = youtubomatic_upload_media_library($vimeourl);
                                if($local_path !== false)
                                {
                                    $finals[] = $local_path[0];
                                    $deletes[] = $local_path[1];
                                }
                            }
                        }
                    }
                    if(isset($youtubomatic_Youtube_Settings['dm_embedded']) && $youtubomatic_Youtube_Settings['dm_embedded'] == 'on')
                    {
                        preg_match_all('#https?:\/\/www.dailymotion.com\/video\/([^\s"\']*)#i', $lnk, $dms);
                        if(isset($dms[1][0]))
                        {
                            $dmurl = youtubomatic_getDMMP4($dms[1][0]);
                            if($dmurl !== false && $dmurl !== '')
                            {
                                $local_path = youtubomatic_upload_media_library($dmurl);
                                if($local_path !== false)
                                {
                                    $finals[] = $local_path[0];
                                    $deletes[] = $local_path[1];
                                }
                            }
                        }
                        else
                        {
                            preg_match_all('#https?:\/\/www.dailymotion.com\/embed\/video\/([^\s"\']*)#i', $lnk, $dms);
                            if(isset($dms[1][0]))
                            {
                                $dmurl = youtubomatic_getDMMP4($dms[1][0]);
                                if($dmurl !== false && $dmurl !== '')
                                {
                                    $local_path = youtubomatic_upload_media_library($dmurl);
                                    if($local_path !== false)
                                    {
                                        $finals[] = $local_path[0];
                                        $deletes[] = $local_path[1];
                                    }
                                }
                            }
                        }
                    }
                    if(isset($youtubomatic_Youtube_Settings['fb_embedded']) && $youtubomatic_Youtube_Settings['fb_embedded'] == 'on')
                    {
                        preg_match_all('#https:\/\/www.facebook.com\/(.+?)\/videos\/([^\s\'"]+?)\/#i', $lnk, $dms);
                        if(isset($dms[0][0]))
                        {
                            $dmurl = youtubomatic_getFBMP4($dms[0][0]);
                            if($dmurl !== false && $dmurl !== '')
                            {
                                $local_path = youtubomatic_upload_media_library($dmurl);
                                if($local_path !== false)
                                {
                                    $finals[] = $local_path[0];
                                    $deletes[] = $local_path[1];
                                }
                            }
                        }
                        else
                        {
                            preg_match_all('#https:\/\/www\.facebook\.com\/plugins\/video\.php\?href=(.+?)&#i', $lnk, $dms);
                            if(isset($dms[1][0]))
                            {
                                $dmurl = youtubomatic_getFBMP4(urldecode($dms[1][0]));
                                if($dmurl !== false && $dmurl !== '')
                                {
                                    $local_path = youtubomatic_upload_media_library($dmurl);
                                    if($local_path !== false)
                                    {
                                        $finals[] = $local_path[0];
                                        $deletes[] = $local_path[1];
                                    }
                                }
                            }
                            else
                            {
                                preg_match_all('#https:\/\/www\.facebook\.com\/(?:video\.php|watch)\/?\?v=(\d*)#i', $lnk, $dms);
                                if(isset($dms[0][0]))
                                {
                                    $dmurl = youtubomatic_getFBMP4($dms[0][0]);
                                    if($dmurl !== false && $dmurl !== '')
                                    {
                                        $local_path = youtubomatic_upload_media_library($dmurl);
                                        if($local_path !== false)
                                        {
                                            $finals[] = $local_path[0];
                                            $deletes[] = $local_path[1];
                                        }
                                    }                                            
                                }
                            }
                        }
                    }
                    if(isset($youtubomatic_Youtube_Settings['tw_embedded']) && $youtubomatic_Youtube_Settings['tw_embedded'] == 'on')
                    {
                        preg_match_all('#https?:\/\/clips\.twitch\.tv\/([^\s\'"]*)#i', $lnk, $dms);
                        if(isset($dms[0][0]))
                        {
                            $dmurl = youtubomatic_getTWMP4($dms[0][0]);
                            if($dmurl !== false && $dmurl !== '')
                            {
                                $local_path = youtubomatic_upload_media_library($dmurl);
                                if($local_path !== false)
                                {
                                    $finals[] = $local_path[0];
                                    $deletes[] = $local_path[1];
                                }
                            }
                        }
                        else
                        {
                            preg_match_all('#<iframe src="https:\/\/clips.twitch.tv\/embed\?clip=([^"\s\']*)"#i', $lnk, $dms);
                            if(isset($dms[1][0]))
                            {
                                $dmurl = youtubomatic_getTWMP4('https://clips.twitch.tv/embed?clip=' . $dms[1][0]);
                                if($dmurl !== false && $dmurl !== '')
                                {
                                    $local_path = youtubomatic_upload_media_library($dmurl);
                                    if($local_path !== false)
                                    {
                                        $finals[] = $local_path[0];
                                        $deletes[] = $local_path[1];
                                    }
                                }
                            }
                        }
                    }
                    
                }
                if(count($finals) == 0)
                {
                    if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                    {
                        youtubomatic_log_to_file('No videos found in post ID: ' . $post->ID);
                    }
                    return;
                }
            }
            if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
            {
                youtubomatic_log_to_file('Found videos in post ID: ' . $post->ID . ': ' . print_r($finals, true));
            }
            if (isset($youtubomatic_Youtube_Settings['save_local']) && $youtubomatic_Youtube_Settings['save_local'] == 'on') 
            {
                $meta_name_cont = 1;
                foreach($finals as $fnl)
                {
                    add_post_meta($post->ID, "youtubomatic_saved_video" . $meta_name_cont, $fnl);
                    $meta_name_cont = $meta_name_cont + 1;
                }
                if (isset($youtubomatic_Main_Settings['enable_detailed_logging']) && $youtubomatic_Main_Settings['enable_detailed_logging'] == 'on') 
                {
                    youtubomatic_log_to_file('Videos saved locally for post ID: ' . $post->ID);
                }
                return;
            }
            $post_link        = youtubomatic_post_url_handle(get_permalink($post->ID));
            $post_title       = html_entity_decode($post->post_title);
            $blog_title       = html_entity_decode(get_bloginfo('title'));
            $post_excerpt     = html_entity_decode($post->post_excerpt);
            $post_content     = do_shortcode(html_entity_decode($post->post_content));
            if(function_exists('do_blocks'))
            {
                $post_content     = do_blocks($post_content);
            }
            $post_content = apply_filters( 'the_content', $post_content);
            $post_description = $post_excerpt;
            $author_obj       = get_user_by('id', $post->post_author);
            if(isset($author_obj->user_nicename))
            {
                $user_name        = $author_obj->user_nicename;
            }
            else
            {
                $user_name        = 'Administrator';
            }
            $featured_image   = '';
            wp_suspend_cache_addition(true);
            $metas = get_post_custom($post->ID);
            wp_suspend_cache_addition(false);
            $rez_meta = youtubomatic_preg_grep_keys('#.+?_featured_ima?ge?#i', $metas);
            if(count($rez_meta) > 0)
            {
                foreach($rez_meta as $rm)
                {
                    if(isset($rm[0]) && filter_var($rm[0], FILTER_VALIDATE_URL))
                    {
                        $featured_image = $rm[0];
                        break;
                    }
                }
            }
            if($featured_image == '')
            {
                $featured_image = youtubomatic_generate_thumbmail($post->ID);;
            }
            if($featured_image == '')
            {
                $dom     = new DOMDocument();
                $internalErrors = libxml_use_internal_errors(true);
                $dom->loadHTML($post_content);
                    libxml_use_internal_errors($internalErrors);
                $tags      = $dom->getElementsByTagName('img');
                foreach ($tags as $tag) {
                    $temp_get_img = $tag->getAttribute('src');
                    if ($temp_get_img != '') {
                        $temp_get_img = strtok($temp_get_img, '?');
                        $featured_image = rtrim($temp_get_img, '/');
                    }
                }
            }
            $post_added = false;
            
            try
            {
                require_once(dirname(__FILE__) . "/res/Google/vendor/autoload.php");
                $client = new Google_Client();
                $client->setClientId(get_option('youtubomatic_access_token_auth_id', false));
                $client->setClientSecret(get_option('youtubomatic_access_token_auth_secret', false));
                $client->setScopes('https://www.googleapis.com/auth/youtube');
                $client->setAccessType('offline');
                $at = get_option('youtubomatic_access_token_str', false);
                if(!is_array($at) && youtubomatic_is_json($at))
                {
                    $at = json_decode($at, true);
                }
                if(isset($at['created']) && isset($at['expires_in']))
                {
                    if($at['created'] + $at['expires_in'] < time())
                    {
                        $refreshToken = get_option('youtubomatic_refresh_token', false);
                        if($refreshToken !== false)
                        {
                            $client->refreshToken($refreshToken);
                            $newtoken = $client->getAccessToken();
                            if(!is_array($newtoken) && youtubomatic_is_json($newtoken))
                            {
                                $newtoken = json_decode($newtoken, true);
                            }
                            $newtoken = json_encode($newtoken);
                            update_option('youtubomatic_access_token_str', $newtoken);
                        }
                        else
                        {
                            youtubomatic_log_to_file('Failed to get REFRESH TOKEN from auth request. You might need to manually reauthorize the app!');
                            $at = json_encode($at);
                            $client->setAccessToken($at);
                        }
                    }
                    else
                    {
                        $at = json_encode($at);
                        $client->setAccessToken($at);
                    }
                }
                else
                {
                    throw new Exception('Invalid access token format ' . print_r($at, true));
                }
                
                $youtube = new Google_Service_YouTube($client);
                if(isset($youtubomatic_Youtube_Settings['max_at_once']) && $youtubomatic_Youtube_Settings['max_at_once'] != '' && is_numeric($youtubomatic_Youtube_Settings['max_at_once']))
                {
                    $max_at_once = $youtubomatic_Youtube_Settings['max_at_once'];
                }
                else
                {
                    $max_at_once = 9999999999;
                }
                if ($client->getAccessToken()) {
                    $video_number = 1;
                    foreach($finals as $key => $videoPath)
                    {
                        if($video_number > intval($max_at_once))
                        {
                            break;
                        }
                        $post_template    = $youtubomatic_Youtube_Settings['youtube_format'];
                        $post_template    = replaceYouTubePostShortcodes($post_template, $post_link, $post_title, $blog_title, $post_excerpt, $post_content, $user_name, $featured_image, $post_cats, $post_tagz, $video_number);
                        $post_template    = strip_tags($post_template);
                        $post_template    = str_replace('<', '', $post_template);
                        $post_template    = str_replace('>', '', $post_template);
                        $post_title_template    = $youtubomatic_Youtube_Settings['youtube_title_format'];
                        $post_title_template    = replaceYouTubePostTitleShortcodes($post_title_template, $post_title, $blog_title, $post_excerpt, $user_name, $post_cats, $post_tagz, $video_number);
                        $post_title_template    = strip_tags($post_title_template);
                        //$videoPath = str_replace('%', '%25', $videoPath);
                        $handle = fopen($videoPath, "rb");
                        if($handle === FALSE)
                        {
                            youtubomatic_log_to_file('Failed to open video file ' . $videoPath);
                            continue;
                        }
                        $snippet = new Google_Service_YouTube_VideoSnippet();
                        if(strlen($post_title_template) > 5000)
                        {
                            $post_title_template = substr($post_title_template,0,5000);
                        }
                        if($post_title_template == '')
                        {
                            $post_title_template = 'YouTube Video';
                        }
                        $snippet->setTitle($post_title_template);
                        $snippet->setDescription($post_template);
                        if(isset($youtubomatic_Youtube_Settings['video_language']))
                        {
                            $snippet->setDefaultLanguage($youtubomatic_Youtube_Settings['video_language']);
                        }
                        if(isset($youtubomatic_Youtube_Settings['video_audio_language']))
                        {
                            $snippet->setDefaultAudioLanguage($youtubomatic_Youtube_Settings['video_audio_language']);
                        }
                        $youtube_tags = array();
                        if($youtubomatic_Youtube_Settings['auto_tags'] == 'cats')
                        {
                            foreach($post_categories as $pc)
                            {
                                $youtube_tags[] = $pc;
                            }
                        }
                        elseif($youtubomatic_Youtube_Settings['auto_tags'] == 'tags')
                        {
                            foreach($post_tags as $pt)
                            {
                                $youtube_tags[] = $pt;
                            }
                        }
                        elseif($youtubomatic_Youtube_Settings['auto_tags'] == 'both')
                        {
                            foreach($post_categories as $pc)
                            {
                                $youtube_tags[] = $pc;
                            }
                            foreach($post_tags as $pt)
                            {
                                $youtube_tags[] = $pt;
                            }
                        }
                        if(isset($youtubomatic_Youtube_Settings['additional_tags']) && $youtubomatic_Youtube_Settings['additional_tags'] !== '')
                        {
                            $add_tags  = explode(',', $youtubomatic_Youtube_Settings['additional_tags']);
                            foreach($add_tags as $at)
                            {
                                $youtube_tags[] = $at;
                            }
                        }
                        $snippet->setTags($youtube_tags);
                        if(isset($youtubomatic_Youtube_Settings['video_category']))
                        {
                            $snippet->setCategoryId($youtubomatic_Youtube_Settings['video_category']);
                        }
                        else
                        {
                            $snippet->setCategoryId('22');
                        }
                        $video_status = new Google_Service_YouTube_VideoStatus();
                        if(isset($youtubomatic_Youtube_Settings['video_status']))
                        {
                            $video_status->privacyStatus = $youtubomatic_Youtube_Settings['video_status'];
                        }
                        else
                        {
                            $video_status->privacyStatus = "public";
                        }
                        $video = new Google_Service_YouTube_Video();
                        $video->setSnippet($snippet);
                        $video->setStatus($video_status);
                        if(isset($youtubomatic_Youtube_Settings['chunk_size']))
                        {
                            $chunkSizeBytes = $youtubomatic_Youtube_Settings['chunk_size'];
                        }
                        else
                        {
                            $chunkSizeBytes = 1048576;
                        }
                        $client->setDefer(true);
                        $insertRequest = $youtube->videos->insert("status,snippet", $video);
                        $filesize = youtubomatic_retrieve_remote_file_size($videoPath);             
                        if($filesize == false || $filesize == -1)
                        {
                            $filesize = youtubomatic_realFileSize($deletes[$key]);              
                            if($filesize == false || $filesize == -1)
                            {
                                $filesize = $wp_filesystem->size($deletes[$key]);
                            }
                        }
                        if($filesize == false || $filesize == -1)
                        {
                            throw new Exception('Failed to detect the file size for ' . $videoPath);
                        }
                            
                        if(isset($youtubomatic_Youtube_Settings['alt_upload']) && $youtubomatic_Youtube_Settings['alt_upload'] == 'on')
                        {
                            $mem_used = memory_get_usage(false);
                            $mem_total = youtubomatic_format_wp_limit(WP_MEMORY_LIMIT);
                            $mem_free = $mem_total - $mem_used;
                            if($filesize < $mem_free)
                            {
                                $ok_alt = true;
                            }
                            else
                            {
                                youtubomatic_log_to_file('Not enough available memory for the script to handle the file upload (please increase available memory)! Total: ' . $mem_total . ' used: ' . $mem_used . ' free: ' . $mem_free . ' file size: ' . $filesize);
                                $ok_alt = false;
                            } 
                        }
                        else
                        {
                            $ok_alt = false;
                        }
                        $file_contents = false;
                        if($ok_alt == true)
                        {
                            $file_contents = $wp_filesystem->get_contents($videoPath);
                            if($file_contents === false)
                            {
                                youtubomatic_log_to_file('Failed to read file (alt method): ' . $videoPath);
                                $ok_alt = false;
                            }
                        }
                        try
                        {
                            if($ok_alt == true)
                            {
                                $media = new Google_Http_MediaFileUpload(
                                    $client,
                                    $insertRequest,
                                    'video/*',
                                    $file_contents,
                                    true,
                                    intval($chunkSizeBytes)
                                );
                            }
                            else
                            {
                                $media = new Google_Http_MediaFileUpload(
                                    $client,
                                    $insertRequest,
                                    'video/*',
                                    null,
                                    true,
                                    intval($chunkSizeBytes)
                                );
                            }
                        }
                        catch(Exception $e)
                        {
                            youtubomatic_log_to_file('Failed to init YouTube uploader: ' . $e->getMessage());
                            continue;
                        }
                        $media->setFileSize($filesize);
                        $status = false;
                        try
                        {
                            if($ok_alt === true)
                            {
                                while (!$status) {
                                    $status = $media->nextChunk();
                                }
                            }
                            else
                            {
                                while (!$status && !feof($handle)) {
                                    $chunk = '';
                                    while(strlen($chunk) < $chunkSizeBytes && !feof($handle))
                                    {
                                        $temp = fread($handle, 8192);
                                        if($temp === FALSE)
                                        {
                                            throw new Exception('Failed to set read from file ' . $videoPath);
                                        }
                                        $chunk .= $temp;
                                    }
                                    $status = $media->nextChunk($chunk);
                                }
                            }
                            
                            if($status == false)
                            {
                                youtubomatic_log_to_file('Failed to upload file: ' . $videoPath);
                            }
                        }
                        catch(Exception $e)
                        {
                            if(feof($handle))
                            {
                                $end = 'true';
                            }
                            else
                            {
                                $end = 'false';
                            }
                            fclose($handle);
                            youtubomatic_log_to_file('Failed to read video file chunk: chunksize: ' . $chunkSizeBytes . ', read chunk size: ' . strlen($chunk) . ', file end reached: ' . $end . ', exception: ' . esc_html($e->getMessage()) . ' - for: ' . $videoPath);
                            if (stripos($e->getMessage(), 'The request is not properly authorized') !== false) {
                                update_option('youtubomatic_need_reauth', 'true');
                            }
                            continue;
                        }
                        fclose($handle);
                        $post_added = true;
                        if(isset($status['id']))
                        {
                            $youtube_new_url = "https://www.youtube.com/watch?v=" . $status['id'];
                            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                                youtubomatic_log_to_file('Successfully uploaded video. URL: ' . $youtube_new_url);
                            }
                            if(isset($youtubomatic_Youtube_Settings['replace_old']) && $youtubomatic_Youtube_Settings['replace_old'] == 'on')
                            {
                                $exp_arr = explode('youtubomatic', $key);
                                if(isset($exp_arr[1]) && $exp_arr[0] == 'x' && $exp_arr[1] != '')
                                {
                                    $args['post_content'] = str_replace($exp_arr[1], $status['id'], $post->post_content);
                                    if($args['post_content'] != $post->post_content)
                                    {
                                        $args['ID'] = $post->ID;
                                        $post_updated = wp_update_post($args);
                                        if (is_wp_error($post_updated)) {
                                            $errors = $post_updated->get_error_messages();
                                            foreach ($errors as $error) {
                                                youtubomatic_log_to_file('Error occured while updating post "' . $post->post_title . '" with new video, error: ' . $error);
                                            }
                                        }
                                    }
                                }
                            }
                            if(isset($youtubomatic_Youtube_Settings['replace_local']) && $youtubomatic_Youtube_Settings['replace_local'] == 'on')
                            {
                                if (isset($youtubomatic_Main_Settings['player_width']) && $youtubomatic_Main_Settings['player_width'] !== '') {
                                    $width = esc_html($youtubomatic_Main_Settings['player_width']);
                                }
                                else
                                {
                                    $width = 580;
                                }
                                if (isset($youtubomatic_Main_Settings['player_height']) && $youtubomatic_Main_Settings['player_height'] !== '') {
                                    $height = esc_html($youtubomatic_Main_Settings['player_height']);
                                }
                                else
                                {
                                    $height = 380;
                                }
                                $new_x_content = preg_replace('{\[video(.*?)mp4="([^"]*?)"(.*?)\/video]}', '<iframe width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed/' . $status['id'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', $post->post_content);
                                if($new_x_content != $post->post_content)
                                {
                                    $args['post_content'] = $new_x_content;
                                    $args['ID'] = $post->ID;
                                    $post_updated = wp_update_post($args);
                                    if (is_wp_error($post_updated)) {
                                        $errors = $post_updated->get_error_messages();
                                        foreach ($errors as $error) {
                                            youtubomatic_log_to_file('Error occured while updating post (local) "' . $post->post_title . '" with new video, error: ' . $error);
                                        }
                                    }
                                }
                                else
                                {
                                    $new_x_content = preg_replace('{<figure([^>]*?)><video([^>]*?)src="([^"]*?)"([^>]*?)><\/video><\/figure>}', '<iframe width="' . $width . '" height="' . $height . '" src="https://www.youtube.com/embed/' . $status['id'] . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', $post->post_content);
                                    if($new_x_content != $post->post_content)
                                    {
                                        $args['post_content'] = $new_x_content;
                                        $args['ID'] = $post->ID;
                                        $post_updated = wp_update_post($args);
                                        if (is_wp_error($post_updated)) {
                                            $errors = $post_updated->get_error_messages();
                                            foreach ($errors as $error) {
                                                youtubomatic_log_to_file('Error occured while updating post (local) "' . $post->post_title . '" with new video, error: ' . $error);
                                            }
                                        }
                                    }
                                }
                            }
                            if(isset($youtubomatic_Youtube_Settings['delete_local']) && $youtubomatic_Youtube_Settings['delete_local'] == 'on')
                            {
                                $path = parse_url($videoPath, PHP_URL_PATH);
                                if($path !== false)
                                {
                                    $xvideoPath = $_SERVER['DOCUMENT_ROOT'] . $path;
                                    $deletes[] = $xvideoPath;
                                }
                                else
                                {
                                    $deletes[] = $videoPath;
                                }
                            }
                            $video_number++;
                        }
                        else
                        {
                            youtubomatic_log_to_file('Failed to publish video to YouTube: ' . print_r($status, true));
                        }
                    }
                }
                else
                {
                    throw new Exception('Failed to set access token!');
                }
            }
            catch(Exception $e) 
            {
                youtubomatic_log_to_file('Exception thrown in YouTube posting: ' . $e->getMessage());
                foreach($deletes as $delf)
                {
                    $wp_filesystem->delete($delf);
                }
                return;
            }
            if ($post_added === TRUE) {
                add_post_meta($post->ID, "youtubomatic_published", "pub");
            }
            foreach($deletes as $delf)
            {
                $del_ret = $wp_filesystem->delete($delf);
            }
        }
    }
}
function youtubomatic_realFileSize($path)
{
    global $wp_filesystem;
    if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
        include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
        wp_filesystem($creds);
    }
    if (!$wp_filesystem->exists($path))
        return false;

    $size = $wp_filesystem->size($path);
    if($size === false)
    {
        return false;
    }
    if (!($file = fopen($path, 'rb')))
        return false;
    
    if ($size >= 0)
    {
        if (fseek($file, 0, SEEK_END) === 0)
        {
            fclose($file);
            return $size;
        }
    }
    $size = PHP_INT_MAX - 1;
    if (fseek($file, PHP_INT_MAX - 1) !== 0)
    {
        fclose($file);
        return false;
    }
    $length = 1024 * 1024;
    while (!feof($file))
    {
        $read = fread($file, $length);
        $size = bcadd($size, $length);
    }
    $size = bcsub($size, $length);
    $size = bcadd($size, strlen($read));
    fclose($file);
    return $size;
}
function youtubomatic_is_json($string) {
 json_decode($string);
 return (json_last_error() == JSON_ERROR_NONE);
}

function youtubomatic_preg_grep_keys( $pattern, $input, $flags = 0 )
{
    if(!is_array($input))
    {
        return array();
    }
    $keys = preg_grep( $pattern, array_keys( $input ), $flags );
    $vals = array();
    foreach ( $keys as $key )
    {
        $vals[$key] = $input[$key];
    }
    return $vals;
}
function youtubomatic_generate_thumbmail( $post_id )
{    
    $post = get_post($post_id);
    $post_parent_id = $post->post_parent === 0 ? $post->ID : $post->post_parent;
    if ( has_post_thumbnail($post_parent_id) )
    {
        if ($id_attachment = get_post_thumbnail_id($post_parent_id)) {
            $the_image  = wp_get_attachment_url($id_attachment, false);
            return $the_image;
        }
    }
    $attachments = array_values(get_children(array(
        'post_parent' => $post_parent_id, 
        'post_status' => 'inherit', 
        'post_type' => 'attachment', 
        'post_mime_type' => 'image', 
        'order' => 'ASC', 
        'orderby' => 'menu_order ID') 
    ));
    if( sizeof($attachments) > 0 ) {
        $the_image  = wp_get_attachment_url($attachments[0]->ID, false);
        return $the_image;
    }
    $media = get_attached_media('image', $post_id);
    if( sizeof($media) > 0 ) {
        $the_image  = wp_get_attachment_url($media[0]->ID, false);
        return $the_image;
    }
    $image_url = youtubomatic_extractThumbnail($post->post_content);
    return $image_url;
}
function youtubomatic_extractThumbnail($content) {
    $att = youtubomatic_getUrls($content);
    if(count($att) > 0)
    {
        foreach($att as $link)
        {
            $mime = youtubomatic_get_mime($link);
            if(stristr($mime, "image/") !== FALSE){
                return $link;
            }
        }
    }
    else
    {
        return '';
    }
    return '';
}

add_action( 'admin_notices', 'youtubomatic_admin_notice_success' );
function youtubomatic_admin_notice_success() {
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on')
    {
        if (isset($youtubomatic_Main_Settings['youtubomatic_notice_enabled']) && $youtubomatic_Main_Settings['youtubomatic_notice_enabled'] == 'on')
        {
            if(strstr($_SERVER['REQUEST_URI'], 'wp-admin/post-new.php')) 
            {
?>
    <div id="notVisibleID" class="notice notice-success is-dismissible cr_none">
    <br/><div id="myProgress">
  <div id="myBar"></div>
</div>
        <p><?php esc_html_e( 'Please wait while Youtubomatic plugin uploads videos to YouTube! Please do not close this page while processing! You can disable this notice from Youtubomatic plugin\'s settings panel.', 'youtubomatic-youtube-post-generator'); ?></p>
    </div>
<?php
            }
        }
    }
    
}
function youtubomatic_add_admin_scripts( $hook ) {
    global $post;
    $youtubomatic_Youtube_Settings = get_option('youtubomatic_Youtube_Settings', false);
    if (isset($youtubomatic_Youtube_Settings['youtubomatic_posting']) && $youtubomatic_Youtube_Settings['youtubomatic_posting'] == 'on') 
    {
        if ( $hook == 'post-new.php') {
            wp_enqueue_script('mlsb-new-post', plugins_url('scripts/publish.js', __FILE__), array('jquery'), false, true);
        }
    }
}
add_action( 'admin_enqueue_scripts', 'youtubomatic_add_admin_scripts', 10, 1 );
function youtubomatic_admin_notice_reauth() {
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['youtubomatic_enabled']) && $youtubomatic_Main_Settings['youtubomatic_enabled'] == 'on')
    {
        if (isset($youtubomatic_Main_Settings['youtubomatic_notice_enabled']) && $youtubomatic_Main_Settings['youtubomatic_notice_enabled'] == 'on')
        {
            $reauth = get_option('youtubomatic_need_reauth', false);
            if($reauth === 'true') 
            {
?>
    <div id="notVisibleID" class="notice notice-success is-dismissible cr_none">
    <br/><div id="myProgress">
  <div id="myBar"></div>
</div>
        <p><?php esc_html_e( 'Youtubomatic plugin was unauthorized by YouTube servers because of some recent errors at video uploading. Please go to <a href="admin.php?page=youtubomatic_youtube_panel">plugin\' "Post to YouTube" settings panel</a> and reauthorize the plugin with YouTube!', 'youtubomatic-youtube-post-generator' ); ?></p>
    </div>
<?php
            }
        }
    }
    
}

add_action( 'admin_init', 'youtubomatic_stop_heartbeat', 1 );
function youtubomatic_stop_heartbeat() {
    wp_deregister_script('heartbeat');
}

function youtubomatic_retrieve_remote_file_size($url){
	 $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
     $ch = curl_init($url);
     if($ch === false)
     {
         youtubomatic_log_to_file('Curl not enabled on your server, please enable it.');
     }
	 if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
			curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
			if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
				curl_setopt($ch, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
			}
	 }
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
     curl_setopt($ch, CURLOPT_HEADER, TRUE);
     curl_setopt($ch, CURLOPT_NOBODY, TRUE);
     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
     curl_setopt($ch, CURLOPT_TIMEOUT, 60);
     $data = curl_exec($ch);
     if($data === false)
     {
         youtubomatic_log_to_file('Failed to get data from: ' . $url . ' error: ' . curl_error($ch));
     }
     $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
     if($size === false)
     {
         youtubomatic_log_to_file('CURLINFO_CONTENT_LENGTH_DOWNLOAD failed: ' . $url . ' error: ' . curl_error($ch));
     }
     curl_close($ch);
     return $size;
}
function replaceYouTubePostShortcodes($content, $post_link, $post_title, $blog_title, $post_excerpt, $post_content, $user_name, $featured_image, $post_cats, $post_tagz, $video_number)
{
    $matches = array();
    $i = 0;
    preg_match_all('~%regex\(\s*\"([^"]+?)\s*"\s*,\s*\"([^"]*)\"\s*(?:,\s*\"([^"]*?)\s*\")?(?:,\s*\"([^"]*?)\s*\")?\)%~si', $content, $matches);
    if (is_array($matches) && count($matches) && is_array($matches[0])) {
        for($i = 0; $i < count($matches[0]); $i++)
        {
            if (isset($matches[0][$i])) $fullmatch = $matches[0][$i];
            if (isset($matches[1][$i])) $search_in = replaceYouTubePostShortcodes($matches[1][$i], $post_link, $post_title, $blog_title, $post_excerpt, $post_content, $user_name, $featured_image, $post_cats, $post_tagz, $video_number);
            if (isset($matches[2][$i])) $matchpattern = $matches[2][$i];
            if (isset($matches[3][$i])) $element = $matches[3][$i];
            if (isset($matches[4][$i])) $delimeter = $matches[4][$i];
            if (isset($matchpattern)) {
               if (preg_match('~^\/[^/]*\/$~', $matchpattern, $z)) {
                  $ret = preg_match_all($matchpattern, $search_in, $submatches, PREG_PATTERN_ORDER);
               }
               else {
                  $ret = preg_match_all('~'.$matchpattern.'~si', $search_in, $submatches, PREG_PATTERN_ORDER);
               }
            }
            if (isset($submatches)) {
               if (is_array($submatches)) {
                  $empty_elements = array_keys($submatches[0], "");
                  foreach ($empty_elements as $e) {
                     unset($submatches[0][$e]);
                  }
                  $submatches[0] = array_unique($submatches[0]);
                  if (!is_numeric($element)) {
                     $element = 0;
                  }
                  $matched = $submatches[(int)($element)];
                  $matched = array_unique((array)$matched);
                  if (empty($delimeter)) {
                     if (isset($matched[0])) $matched = $matched[0];
                  }
                  else {
                     $matched = implode($matched, $delimeter);
                  }
                  if (empty($matched)) {
                     $content = str_replace($fullmatch, '', $content);
                  } else {
                     $content = str_replace($fullmatch, $matched, $content);
                  }
               }
            }
        }
    }
    $spintax = new Youtubomatic_Spintax();
    $content = $spintax->process($content);
    $pcxxx = explode('<!??? template ???>', $content);
    $content = $pcxxx[array_rand($pcxxx)];
    $content = str_replace('%%random_sentence%%', youtubomatic_random_sentence_generator(), $content);
    $content = str_replace('%%random_sentence2%%', youtubomatic_random_sentence_generator(false), $content);
    $content = youtubomatic_replaceSynergyShortcodes($content);
    $content = str_replace('%%post_link%%', $post_link, $content);
    $content = str_replace('%%post_title%%', $post_title, $content);
    $content = str_replace('%%blog_title%%', $blog_title, $content);
    $content = str_replace('%%post_excerpt%%', $post_excerpt, $content);
    $content = str_replace('%%post_content%%', $post_content, $content);
    $content = str_replace('%%author_name%%', $user_name, $content);
    $content = str_replace('%%featured_image%%', $featured_image, $content);
    $content = str_replace('%%post_cats%%', $post_cats, $content);
    $content = str_replace('%%post_tags%%', $post_tagz, $content);
    $content = str_replace('%%video_number%%', $video_number, $content);
    $item_hash = youtubomatic_extractKeyWords($post_title, 3);
    $smart_hash = '';
    foreach ($item_hash as $ih)
    {
        $smart_hash .= '#' . esc_html($ih) . ' ';
    }
    $smart_hash = trim($smart_hash);
    $content = str_replace('%%smart_hashtags%%', $smart_hash, $content);
    return $content;
}
function replaceYouTubePostTitleShortcodes($content, $post_title, $blog_title, $post_excerpt, $user_name, $post_cats, $post_tagz, $video_number)
{
    $content = str_replace('%%random_sentence%%', youtubomatic_random_sentence_generator(), $content);
    $content = str_replace('%%random_sentence2%%', youtubomatic_random_sentence_generator(false), $content);
    $content = youtubomatic_replaceSynergyShortcodes($content);
    $content = str_replace('%%post_title%%', $post_title, $content);
    $content = str_replace('%%blog_title%%', $blog_title, $content);
    $content = str_replace('%%post_excerpt%%', $post_excerpt, $content);
    $content = str_replace('%%author_name%%', $user_name, $content);
    $content = str_replace('%%post_cats%%', $post_cats, $content);
    $content = str_replace('%%post_tags%%', $post_tagz, $content);
    $content = str_replace('%%video_number%%', $video_number, $content);
    $item_hash = youtubomatic_extractKeyWords($post_title, 3);
    $smart_hash = '';
    foreach ($item_hash as $ih)
    {
        $smart_hash .= '#' . esc_html($ih) . ' ';
    }
    $smart_hash = trim($smart_hash);
    $content = str_replace('%%smart_hashtags%%', $smart_hash, $content);
    return $content;
}

function youtubomatic_spin_text($title, $content, $alt = false)
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    $titleSeparator         = '[19459000]';
    $text                   = $title . $titleSeparator . $content;
    $text                   = html_entity_decode($text);
    preg_match_all("/<[^<>]+>/is", $text, $matches, PREG_PATTERN_ORDER);
    $htmlfounds         = array_filter(array_unique($matches[0]));
    $htmlfounds[]       = '&quot;';
    $imgFoundsSeparated = array();
    foreach ($htmlfounds as $key => $currentFound) {
        if (stristr($currentFound, '<img') && stristr($currentFound, 'alt')) {
            $altSeparator   = '';
            $colonSeparator = '';
            if (stristr($currentFound, 'alt="')) {
                $altSeparator   = 'alt="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt = "')) {
                $altSeparator   = 'alt = "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt ="')) {
                $altSeparator   = 'alt ="';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt= "')) {
                $altSeparator   = 'alt= "';
                $colonSeparator = '"';
            } elseif (stristr($currentFound, 'alt=\'')) {
                $altSeparator   = 'alt=\'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt = \'')) {
                $altSeparator   = 'alt = \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt= \'')) {
                $altSeparator   = 'alt= \'';
                $colonSeparator = '\'';
            } elseif (stristr($currentFound, 'alt =\'')) {
                $altSeparator   = 'alt =\'';
                $colonSeparator = '\'';
            }
            if (trim($altSeparator) != '') {
                $currentFoundParts = explode($altSeparator, $currentFound);
                $preAlt            = $currentFoundParts[1];
                $preAltParts       = explode($colonSeparator, $preAlt);
                $altText           = $preAltParts[0];
                if (trim($altText) != '') {
                    unset($preAltParts[0]);
                    $imgFoundsSeparated[] = $currentFoundParts[0] . $altSeparator;
                    $imgFoundsSeparated[] = $colonSeparator . implode('', $preAltParts);
                    $htmlfounds[$key]     = '';
                }
            }
        }
    }
    if (count($imgFoundsSeparated) != 0) {
        $htmlfounds = array_merge($htmlfounds, $imgFoundsSeparated);
    }
    preg_match_all("/<\!--.*?-->/is", $text, $matches2, PREG_PATTERN_ORDER);
    $newhtmlfounds = $matches2[0];
    preg_match_all("/\[.*?\]/is", $text, $matches3, PREG_PATTERN_ORDER);
    $shortcodesfounds = $matches3[0];
    $htmlfounds       = array_merge($htmlfounds, $newhtmlfounds, $shortcodesfounds);
    $in               = 0;
    $cleanHtmlFounds  = array();
    foreach ($htmlfounds as $htmlfound) {
        if ($htmlfound == '[19459000]') {
        } elseif (trim($htmlfound) == '') {
        } else {
            $cleanHtmlFounds[] = $htmlfound;
        }
    }
    $htmlfounds = $cleanHtmlFounds;
    $start      = 19459001;
    foreach ($htmlfounds as $htmlfound) {
        $text = str_replace($htmlfound, '[' . $start . ']', $text);
        $start++;
    }
    try {
        require_once(dirname(__FILE__) . "/res/youtubomatic-text-spinner.php");
        $phpTextSpinner = new PhpTextSpinner();
        if ($alt === FALSE) {
            $spinContent = $phpTextSpinner->spinContent($text);
        } else {
            $spinContent = $phpTextSpinner->spinContentAlt($text);
        }
        $translated = $phpTextSpinner->runTextSpinner($spinContent);
    }
    catch (Exception $e) {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('Exception thrown in spinText ' . $e->getMessage());
        }
        return false;
    }
    preg_match_all('{\[.*?\]}', $translated, $brackets);
    $brackets = $brackets[0];
    $brackets = array_unique($brackets);
    foreach ($brackets as $bracket) {
        if (stristr($bracket, '19')) {
            $corrrect_bracket = str_replace(' ', '', $bracket);
            $corrrect_bracket = str_replace('.', '', $corrrect_bracket);
            $corrrect_bracket = str_replace(',', '', $corrrect_bracket);
            $translated       = str_replace($bracket, $corrrect_bracket, $translated);
        }
    }
    if (stristr($translated, $titleSeparator)) {
        $start = 19459001;
        foreach ($htmlfounds as $htmlfound) {
            $translated = str_replace('[' . $start . ']', $htmlfound, $translated);
            $start++;
        }
        $contents = explode($titleSeparator, $translated);
        $title    = $contents[0];
        $content  = $contents[1];
    } else {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('Failed to parse spinned content, separator not found');
        }
        return false;
    }
    return array(
        $title,
        $content
    );
}


function youtubomatic_best_spin_text($title, $content)
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (!isset($youtubomatic_Main_Settings['best_user']) || $youtubomatic_Main_Settings['best_user'] == '' || !isset($youtubomatic_Main_Settings['best_password']) || $youtubomatic_Main_Settings['best_password'] == '') {
        youtubomatic_log_to_file('Please insert a valid "The Best Spinner" user name and password.');
        return FALSE;
    }
    $titleSeparator   = '[19459000]';
    $newhtml             = $title . $titleSeparator . $content;
    $url              = 'http://thebestspinner.com/api.php';
    $data             = array();
    $data['action']   = 'authenticate';
    $data['format']   = 'php';
    $data['username'] = $youtubomatic_Main_Settings['best_user'];
    $data['password'] = $youtubomatic_Main_Settings['best_password'];
    $ch               = curl_init();
    if ($ch === FALSE) {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('Failed to init curl!');
        }
        return FALSE;
    }
	if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
		curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
		if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
		}
	}
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    $fdata = "";
    foreach ($data as $key => $val) {
        $fdata .= "$key=" . urlencode($val) . "&";
    }
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $html = curl_exec($ch);
    curl_close($ch);
    if ($html === FALSE) {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('"The Best Spinner" failed to exec curl.');
        }
        return FALSE;
    }
    $output = unserialize($html);
    if ($output['success'] == 'true') {
        $session                = $output['session'];
        $data                   = array();
        $data['session']        = $session;
        $data['format']         = 'php';
        $data['protectedterms'] = '';
        $data['text']           = (html_entity_decode($newhtml));
        $data['action']         = 'replaceEveryonesFavorites';
        $data['maxsyns']        = '50';
        $data['quality']        = '1';
        
        $ch = curl_init();
        if ($ch === FALSE) {
            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                youtubomatic_log_to_file('Failed to init curl');
            }
            return FALSE;
        }
		if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
			curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
			if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
				curl_setopt($ch, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
			}
		}
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        $fdata = "";
        foreach ($data as $key => $val) {
            $fdata .= "$key=" . urlencode($val) . "&";
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fdata);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        if ($output === FALSE) {
            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                youtubomatic_log_to_file('"The Best Spinner" failed to exec curl after auth.');
            }
            return FALSE;
        }
        curl_close($ch);
        $output = unserialize($output);
        if ($output['success'] == 'true') {
            $result = explode($titleSeparator, $output['output']);
            if (count($result) < 2) {
                if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                    youtubomatic_log_to_file('"The Best Spinner" failed to spin article - titleseparator not found.');
                }
                return FALSE;
            }
            $spintax = new Youtubomatic_Spintax();
            $result[0] = $spintax->process($result[0]);
            $result[1] = $spintax->process($result[1]);
            return $result;
        } else {
            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                youtubomatic_log_to_file('"The Best Spinner" failed to spin article.');
            }
            return FALSE;
        }
    } else {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('"The Best Spinner" authentification failed.');
        }
        return FALSE;
    }
}
class Youtubomatic_Spintax
{
    public function process($text)
    {
        return stripslashes(preg_replace_callback(
            '/\{(((?>[^\{\}]+)|(?R))*)\}/x',
            array($this, 'replace'),
            preg_quote($text)
        ));
    }
    public function replace($text)
    {
        $text = $this->process($text[1]);
        $parts = explode('|', $text);
        return $parts[array_rand($parts)];
    }
}

function youtubomatic_wordai_spin_text($title, $content)
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (!isset($youtubomatic_Main_Settings['best_user']) || $youtubomatic_Main_Settings['best_user'] == '' || !isset($youtubomatic_Main_Settings['best_password']) || $youtubomatic_Main_Settings['best_password'] == '') {
        youtubomatic_log_to_file('Please insert a valid "Wordai" user name and password.');
        return FALSE;
    }
    $titleSeparator   = '[19459000]';
    $quality = 'Very Readable';
    $html             = $title . $titleSeparator . $content;
    $email = $youtubomatic_Main_Settings['best_user'];
    $pass = $youtubomatic_Main_Settings['best_password'];
    $html = urlencode($html);
    $ch = curl_init('http://wordai.com/users/turing-api.php');
    if($ch === false)
    {
        youtubomatic_log_to_file('Failed to init curl in wordai spinning.');
        return FALSE;
    }
	if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
		curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
		if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
		}
	}
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, "s=$html&quality=$quality&email=$email&pass=$pass&nonested=on&title=on&output=json");
    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $result = curl_exec($ch);
    
    if ($result === FALSE) {
        youtubomatic_log_to_file('"Wordai" failed to exec curl after auth. ' . curl_error($ch));
        curl_close ($ch);
        return FALSE;
    }
    curl_close ($ch);
    $result = json_decode($result);
    if(!isset($result->text))
    {
        youtubomatic_log_to_file('"Wordai" unrecognized response: ' . print_r($result, true));
        return FALSE;
    }
    $result = explode($titleSeparator, $result->text);
    if (count($result) < 2) {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('"Wordai" failed to spin article - titleseparator not found.');
        }
        return FALSE;
    }
    $spintax = new Youtubomatic_Spintax();
    $result[0] = $spintax->process($result[0]);
    $result[1] = $spintax->process($result[1]);
    youtubomatic_log_to_file('WordAI - spinned title: ' . $result[0]);
    youtubomatic_log_to_file('WordAI - spinned content: ' . $result[1]);
    return $result;
}

function youtubomatic_spinrewriter_spin_text($title, $content)
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (!isset($youtubomatic_Main_Settings['best_user']) || $youtubomatic_Main_Settings['best_user'] == '' || !isset($youtubomatic_Main_Settings['best_password']) || $youtubomatic_Main_Settings['best_password'] == '') {
        youtubomatic_log_to_file('Please insert a valid "SpinRewriter" user name and password.');
        return FALSE;
    }
    $titleSeparator   = '[19459000]';
    $quality = '50';
    $html             = $title . $titleSeparator . $content;
    //$html             = $content;
    if(str_word_count($html) > 4000)
    {
        return FALSE;
    }
	$data = array();
	$data['email_address'] = $youtubomatic_Main_Settings['best_user'];
	$data['api_key'] = $youtubomatic_Main_Settings['best_password'];
	$data['action'] = "unique_variation";
	$data['text'] = $html;
	 
	$data['auto_protected_terms'] = "false";					
	$data['confidence_level'] = "high";							
	$data['auto_sentences'] = "true";							
	$data['auto_paragraphs'] = "true";							
	$data['auto_new_paragraphs'] = "false";						
	$data['auto_sentence_trees'] = "false";						
	$data['use_only_synonyms'] = "false";						
	$data['reorder_paragraphs'] = "false";						
	$data['nested_spintax'] = "false";							
    $api_responsec = youtubomatic_spinrewriter_api_post($data);
    if ($api_responsec === FALSE) {
        youtubomatic_log_to_file('"SpinRewriter" failed to exec curl after auth.');
        return FALSE;
    }
    $api_response = json_decode($api_responsec);
    if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
    {
        if(isset($api_response->status) && $api_response->status == 'ERROR')
        {
            if(isset($api_response->response) && $api_response->response == 'You can only submit entirely new text for analysis once every 7 seconds.')
            {
                $api_response = youtubomatic_spinrewriter_api_post($data);
                if ($api_response === FALSE) {
                    youtubomatic_log_to_file('"SpinRewriter" failed to exec curl after auth (after resubmit).');
                    return FALSE;
                }
                $api_response = json_decode($api_response);
                if(!isset($api_response->response) || !isset($api_response->status) || $api_response->status != 'OK')
                {
                    youtubomatic_log_to_file('"SpinRewriter" failed to wait and resubmit spinning: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                    return FALSE;
                }
            }
            else
            {
                youtubomatic_log_to_file('"SpinRewriter" error response: ' . print_r($api_response, true) . ' params: ' . print_r($data, true));
                return FALSE;
            }
        }
        else
        {
            youtubomatic_log_to_file('"SpinRewriter" error response (no status): ' . print_r($api_responsec, true) . ' params: ' . print_r($data, true));
            return FALSE;
        }
    }
    $api_response->response = urldecode($api_response->response);
    $result = explode($titleSeparator, $api_response->response);
    if (count($result) < 2) {
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('"SpinRewriter" failed to spin article - titleseparator not found: ' . $api_response->response);
        }
        return FALSE;
    }
    //$result = array($title, $api_response->response);
    return $result;
}
function youtubomatic_spinrewriter_api_post($data){
	$youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    
    $GLOBALS['wp_object_cache']->delete('crspinrewriter_spin_time', 'options');
    $spin_time = get_option('crspinrewriter_spin_time', false);
    if($spin_time !== false && is_numeric($spin_time))
    {
        $c_time = time();
        $spassed = $c_time - $spin_time;
        if($spassed < 10 && $spassed >= 0)
        {
            sleep(10 - $spassed);
        }
    }
    update_option('crspinrewriter_spin_time', time());
    
	$data_raw = "";
	foreach ($data as $key => $value){
		$data_raw = $data_raw . $key . "=" . urlencode($value) . "&";
	}
	$ch = curl_init();
    if($ch === false)
    {
        return false;
    }
	if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
		curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
		if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
		}
	}
	curl_setopt($ch, CURLOPT_URL, "http://www.spinrewriter.com/action/api");
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data_raw);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	$response = trim(curl_exec($ch));
	curl_close($ch);
	return $response;
}
function youtubomatic_replaceExecludes($article, &$htmlfounds, $opt = false)
{
    $htmlurls = array();$article = preg_replace('{data-image-description="(?:[^\"]*?)"}i', '', $article);
	if($opt === true){
		preg_match_all( "/<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*?)<\/a>/s" ,$article,$matches,PREG_PATTERN_ORDER);
		$htmlurls=$matches[0];
	}
	$urls_txt = array();
	if($opt === true){
		preg_match_all('/https?:\/\/[^<\s]+/', $article,$matches_urls_txt);
		$urls_txt = $matches_urls_txt[0];
	}
	preg_match_all("/<[^<>]+>/is",$article,$matches,PREG_PATTERN_ORDER);
	$htmlfounds=$matches[0];
	preg_match_all('{\[nospin\].*?\[/nospin\]}s', $article,$matches_ns);
	$nospin = $matches_ns[0];
	$pattern="\[.*?\]";
	preg_match_all("/".$pattern."/s",$article,$matches2,PREG_PATTERN_ORDER);
	$shortcodes=$matches2[0];
	preg_match_all("/<script.*?<\/script>/is",$article,$matches3,PREG_PATTERN_ORDER);
	$js=$matches3[0];
	preg_match_all('/\d{2,}/s', $article,$matches_nums);
	$nospin_nums = $matches_nums[0];
	sort($nospin_nums);
	$nospin_nums = array_reverse($nospin_nums);
	$capped = array();
	if($opt === true){
		preg_match_all("{\b[A-Z][a-z']+\b[,]?}", $article,$matches_cap);
		$capped = $matches_cap[0];
		sort($capped);
		$capped=array_reverse($capped);
	}
	$curly_quote = array();
	if($opt === true){
		preg_match_all('{???.*????}', $article, $matches_curly_txt);
		$curly_quote = $matches_curly_txt[0];
		preg_match_all('{???.*????}', $article, $matches_curly_txt_s);
		$single_curly_quote = $matches_curly_txt_s[0];
		preg_match_all('{&quot;.*?&quot;}', $article, $matches_curly_txt_s_and);
		$single_curly_quote_and = $matches_curly_txt_s_and[0];
		preg_match_all('{&#8220;.*?&#8221}', $article, $matches_curly_txt_s_and_num);
		$single_curly_quote_and_num = $matches_curly_txt_s_and_num[0];
		$curly_quote_regular = array();
		preg_match_all('{".*?"}', $article, $matches_curly_txt_regular);
        $curly_quote_regular = $matches_curly_txt_regular[0];
		$curly_quote = array_merge($curly_quote , $single_curly_quote ,$single_curly_quote_and,$single_curly_quote_and_num,$curly_quote_regular);
	}
	$htmlfounds = array_merge($nospin, $shortcodes, $js, $htmlurls, $htmlfounds, $curly_quote, $urls_txt, $nospin_nums, $capped);
	$htmlfounds = array_filter(array_unique($htmlfounds));
	$i=1;
	foreach($htmlfounds as $htmlfound){
		$article=str_replace($htmlfound,'('.str_repeat('*', $i).')',$article);	
		$i++;
	}
    $article = str_replace(':(*', ': (*', $article);
	return $article;
}
function youtubomatic_restoreExecludes($article, $htmlfounds){
	$i=1;
	foreach($htmlfounds as $htmlfound){
		$article=str_replace( '('.str_repeat('*', $i).')', $htmlfound, $article);
		$i++;
	}
	$article = str_replace(array('[nospin]','[/nospin]'), '', $article);
    $article = preg_replace('{\(?\*[\s*]+\)?}', '', $article);
	return $article;
}
function youtubomatic_fix_spinned_content($final_content, $spinner)
{
    if ($spinner == 'wordai') {
        $final_content = str_replace('-LRB-', '(', $final_content);
        $final_content = preg_replace("/{\*\|.*?}/", '*', $final_content);
        preg_match_all('/{\)[^}]*\|\)[^}]*}/', $final_content, $matches_brackets);
        $matches_brackets = $matches_brackets[0];
        foreach ($matches_brackets as $matches_bracket) {
            $matches_bracket_clean = str_replace( array('{','}') , '', $matches_bracket);
            $matches_bracket_parts = explode('|',$matches_bracket_clean);
            $final_content = str_replace($matches_bracket, $matches_bracket_parts[0], $final_content);
        }
    }
    elseif ($spinner == 'spinrewriter' || $spinner == 'translate') {
        $final_content = preg_replace('{\(\s(\**?\))\.}', '($1', $final_content);
        $final_content = preg_replace('{\(\s(\**?\))\s\(}', '($1(', $final_content);
        $final_content = preg_replace('{\s(\(\**?\))\.(\s)}', "$1$2", $final_content);
        $final_content = str_replace('( *', '(*', $final_content);
        $final_content = str_replace('* )', '*)', $final_content);
        $final_content = str_replace('& #', '&#', $final_content);
        $final_content = str_replace('& ldquo;', '"', $final_content);
        $final_content = str_replace('& rdquo;', '"', $final_content);
    }
    return $final_content;
}
function youtubomatic_spin_and_translate($post_title, $final_content, $rule_translate, $rule_translate_source)
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['spin_text']) && $youtubomatic_Main_Settings['spin_text'] !== 'disabled') {
        
        $htmlfounds = array();
        $final_content = youtubomatic_replaceExecludes($final_content, $htmlfounds, false);
        
        
        if ($youtubomatic_Main_Settings['spin_text'] == 'builtin') {
            $translation = youtubomatic_builtin_spin_text($post_title, $final_content);
        } elseif ($youtubomatic_Main_Settings['spin_text'] == 'wikisynonyms') {
            $translation = youtubomatic_spin_text($post_title, $final_content, false);
        } elseif ($youtubomatic_Main_Settings['spin_text'] == 'freethesaurus') {
            $translation = youtubomatic_spin_text($post_title, $final_content, true);
        } elseif ($youtubomatic_Main_Settings['spin_text'] == 'best') {
            $translation = youtubomatic_best_spin_text($post_title, $final_content);
        } elseif ($youtubomatic_Main_Settings['spin_text'] == 'wordai') {
            $translation = youtubomatic_wordai_spin_text($post_title, $final_content);
        } elseif ($youtubomatic_Main_Settings['spin_text'] == 'spinrewriter') {
            $translation = youtubomatic_spinrewriter_spin_text($post_title, $final_content);
        }
        if ($translation !== FALSE) {
            if (is_array($translation) && isset($translation[0]) && isset($translation[1])) {
                $post_title    = $translation[0];
                $final_content = $translation[1];
                
                $final_content = youtubomatic_fix_spinned_content($final_content, $youtubomatic_Main_Settings['spin_text']);
                $final_content = youtubomatic_restoreExecludes($final_content, $htmlfounds);
                
            } else {
                $final_content = youtubomatic_restoreExecludes($final_content, $htmlfounds);
                if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                    youtubomatic_log_to_file('Text Spinning failed - malformed data ' . $youtubomatic_Main_Settings['spin_text']);
                }
            }
        } else {
            $final_content = youtubomatic_restoreExecludes($final_content, $htmlfounds);
            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                youtubomatic_log_to_file('Text Spinning Failed - returned false ' . $youtubomatic_Main_Settings['spin_text']);
            }
        }
    }
    if($rule_translate != '' && $rule_translate != 'disabled')
    {
        if (isset($rule_translate_source) && $rule_translate_source != 'disabled' && $rule_translate_source != '') {
            $tr = $rule_translate_source;
        }
        else
        {
            $tr = 'auto';
        }
        $htmlfounds = array();
        $final_content = youtubomatic_replaceExecludes($final_content, $htmlfounds, false);
        
        $translation = youtubomatic_translate($post_title, $final_content, $tr, $rule_translate);
        if (is_array($translation) && isset($translation[1]))
        {
            $translation[1] = preg_replace('#(?<=[\*(])\s+(?=[\*)])#', '', $translation[1]);
            $translation[1] = preg_replace('#([^(*\s]\s)\*+\)#', '$1', $translation[1]);
            $translation[1] = preg_replace('#\(\*+([\s][^)*\s])#', '$1', $translation[1]);
            $translation[1] = youtubomatic_restoreExecludes($translation[1], $htmlfounds);
        }
        else
        {
            $final_content = youtubomatic_restoreExecludes($final_content, $htmlfounds);
        }
        if ($translation !== FALSE) {
            if (is_array($translation) && isset($translation[0]) && isset($translation[1])) {
                $post_title    = $translation[0];
                $final_content = $translation[1];
                $final_content = str_replace('</ iframe>', '</iframe>', $final_content);
                if(stristr($final_content, '<head>') !== false)
                {
                    $d = new DOMDocument;
                    $mock = new DOMDocument;
                    $internalErrors = libxml_use_internal_errors(true);
                    $d->loadHTML('<?xml encoding="utf-8" ?>' . $final_content);
                    libxml_use_internal_errors($internalErrors);
                    $body = $d->getElementsByTagName('body')->item(0);
                    foreach ($body->childNodes as $child)
                    {
                        $mock->appendChild($mock->importNode($child, true));
                    }
                    $new_post_content_temp = $mock->saveHTML();
                    if($new_post_content_temp !== '' && $new_post_content_temp !== false)
                    {
						$new_post_content_temp = str_replace('<?xml encoding="utf-8" ?>', '', $new_post_content_temp);
                        $final_content = preg_replace("/_addload\(function\(\){([^<]*)/i", "", $new_post_content_temp); 
                    }
                }
                $final_content = htmlspecialchars_decode($final_content);
                $final_content = str_replace('</ ', '</', $final_content);
                $final_content = str_replace(' />', '/>', $final_content);
                $final_content = str_replace('< br/>', '<br/>', $final_content);
                $final_content = str_replace('< / ', '</', $final_content);
                $final_content = str_replace(' / >', '/>', $final_content);
                $final_content = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $final_content);
                $post_title = htmlspecialchars_decode($post_title);
                $post_title = str_replace('</ ', '</', $post_title);
                $post_title = str_replace(' />', '/>', $post_title);
                $post_title = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $post_title);
            } else {
                if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                    youtubomatic_log_to_file('Translation failed - malformed data!');
                }
            }
        } else {
            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                youtubomatic_log_to_file('Translation Failed - returned false!');
            }
        }
    }
    else
    {
        if (isset($youtubomatic_Main_Settings['translate']) && $youtubomatic_Main_Settings['translate'] != 'disabled') {
            if(isset($youtubomatic_Main_Settings['translate_source']) && $youtubomatic_Main_Settings['translate_source'] != '')
            {
                $tr = $youtubomatic_Main_Settings['translate_source'];
            }
            else
            {
                $tr = 'auto';
            }
            $htmlfounds = array();
            $final_content = youtubomatic_replaceExecludes($final_content, $htmlfounds, false);
        
            $translation = youtubomatic_translate($post_title, $final_content, $tr, $youtubomatic_Main_Settings['translate']);
            if (is_array($translation) && isset($translation[1]))
            {
                $translation[1] = preg_replace('#(?<=[\*(])\s+(?=[\*)])#', '', $translation[1]);
                $translation[1] = preg_replace('#([^(*\s]\s)\*+\)#', '$1', $translation[1]);
                $translation[1] = preg_replace('#\(\*+([\s][^)*\s])#', '$1', $translation[1]);
                $translation[1] = youtubomatic_restoreExecludes($translation[1], $htmlfounds);
            }
            else
            {
                $final_content = youtubomatic_restoreExecludes($final_content, $htmlfounds);
            }
            if ($translation !== FALSE) {
                if (is_array($translation) && isset($translation[0]) && isset($translation[1])) {
                    $post_title    = $translation[0];
                    $final_content = $translation[1];
                    $final_content = str_replace('</ iframe>', '</iframe>', $final_content);
                    if(stristr($final_content, '<head>') !== false)
                    {
                        $d = new DOMDocument;
                        $mock = new DOMDocument;
                        $internalErrors = libxml_use_internal_errors(true);
                        $d->loadHTML('<?xml encoding="utf-8" ?>' . $final_content);
                    libxml_use_internal_errors($internalErrors);
                        $body = $d->getElementsByTagName('body')->item(0);
                        foreach ($body->childNodes as $child)
                        {
                            $mock->appendChild($mock->importNode($child, true));
                        }
                        $new_post_content_temp = $mock->saveHTML();
                        if($new_post_content_temp !== '' && $new_post_content_temp !== false)
                        {
                            $new_post_content_temp = str_replace('<?xml encoding="utf-8" ?>', '', $new_post_content_temp);
                            $final_content = preg_replace("/_addload\(function\(\){([^<]*)/i", "", $new_post_content_temp); 
                        }
                    }
                    $final_content = htmlspecialchars_decode($final_content);
                    $final_content = str_replace('</ ', '</', $final_content);
                    $final_content = str_replace(' />', '/>', $final_content);
                    $final_content = str_replace('< br/>', '<br/>', $final_content);
                    $final_content = str_replace('< / ', '</', $final_content);
                    $final_content = str_replace(' / >', '/>', $final_content);
                    $final_content = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $final_content);
                    $post_title = htmlspecialchars_decode($post_title);
                    $post_title = str_replace('</ ', '</', $post_title);
                    $post_title = str_replace(' />', '/>', $post_title);
                    $post_title = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $post_title);
                } else {
                    if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                        youtubomatic_log_to_file('Translation failed - malformed data!');
                    }
                }
            } else {
                if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                    youtubomatic_log_to_file('Translation Failed - returned false!');
                }
            }
        }
    }
    return array(
        $post_title,
        $final_content
    );
}

function youtubomatic_translate($title, $content, $from, $to)
{
    $ch                     = FALSE;
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    try {
        if($from == 'disabled')
        {
            $from = 'auto';
        }
        if($from != 'en' && $from == $to)
        {
            $from = 'en';
        }
        elseif($from == 'en' && $from == $to)
        {
            return false;
        }
        require_once(dirname(__FILE__) . "/res/youtubomatic-translator.php");
        $ch = curl_init();
        if ($ch === FALSE) {
            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                youtubomatic_log_to_file('Failed to init cURL in translator!');
            }
            return false;
        }
		if (isset($youtubomatic_Main_Settings['proxy_url']) && $youtubomatic_Main_Settings['proxy_url'] != '') {
			curl_setopt($ch, CURLOPT_PROXY, $youtubomatic_Main_Settings['proxy_url']);
			if (isset($youtubomatic_Main_Settings['proxy_auth']) && $youtubomatic_Main_Settings['proxy_auth'] != '') {
				curl_setopt($ch, CURLOPT_PROXYUSERPWD, $youtubomatic_Main_Settings['proxy_auth']);
			}
		}
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, youtubomatic_get_random_user_agent());
        $GoogleTranslator = new GoogleTranslator($ch);
        $translated = '';
        $translated_title = '';
        if($content != '')
        {
            if(strlen($content) > 30000)
            {
                while($content != '')
                {
                    $first30k = substr($content, 0, 30000);
                    $content = substr($content, 30000);
                    $translated_temp       = $GoogleTranslator->translateText($first30k, $from, $to);
                    if (strpos($translated, '<h2>The page you have attempted to translate is already in ') !== false) {
                        throw new Exception('Page content already in ' . $to);
                    }
                    if (strpos($translated, 'Error 400 (Bad Request)!!1') !== false) {
                        throw new Exception('Unexpected error while translating page!');
                    }
                    if(substr_compare($translated_temp, '</pre>', -strlen('</pre>')) === 0){$translated_temp = substr_replace($translated_temp ,"", -6);}if(substr( $translated_temp, 0, 5 ) === "<pre>"){$translated_temp = substr($translated_temp, 5);}
                    $translated .= ' ' . $translated_temp;
                }
            }
            else
            {
                $translated       = $GoogleTranslator->translateText($content, $from, $to);
                if (strpos($translated, '<h2>The page you have attempted to translate is already in ') !== false) {
                    throw new Exception('Page content already in ' . $to);
                }
                if (strpos($translated, 'Error 400 (Bad Request)!!1') !== false) {
                    throw new Exception('Unexpected error while translating page!');
                }
            }
        }
        if($title != '')
        {
            $translated_title = $GoogleTranslator->translateText($title, $from, $to);
        }
        if (strpos($translated_title, '<h2>The page you have attempted to translate is already in ') !== false) {
            throw new Exception('Page title already in ' . $to);
        }
        if (strpos($translated_title, 'Error 400 (Bad Request)!!1') !== false) {
            throw new Exception('Unexpected error while translating page title!');
        }
        curl_close($ch);
    }
    catch (Exception $e) {
        curl_close($ch);
        if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
            youtubomatic_log_to_file('Exception thrown in GoogleTranslator ' . $e->getMessage());
        }
        return false;
    }
    if(substr_compare($translated_title, '</pre>', -strlen('</pre>')) === 0){$title = substr_replace($translated_title ,"", -6);}else{$title = $translated_title;}if(substr( $title, 0, 5 ) === "<pre>"){$title = substr($title, 5);}
    if(substr_compare($translated, '</pre>', -strlen('</pre>')) === 0){$text = substr_replace($translated ,"", -6);}else{$text = $translated;}if(substr( $text, 0, 5 ) === "<pre>"){$text = substr($text, 5);}
    $text  = preg_replace('/' . preg_quote('html lang=') . '.*?' . preg_quote('>') . '/', '', $text);
    $text  = preg_replace('/' . preg_quote('!DOCTYPE') . '.*?' . preg_quote('<') . '/', '', $text);
    $text  = preg_replace('#https:\/\/translate\.google\.com\/translate\?hl=en&amp;prev=_t&amp;sl=en&amp;tl=pl&amp;u=([^><"\'\s\n]*)#i', urldecode('$1'), $text);
    $text  = preg_replace('#%3Fenablejsapi%3D\d#i', '', $text);
    $text  = preg_replace('#%26origin%3D[^<&?>\'\s\n"]*#i', '', $text);
    $text  = preg_replace('#%26hl%3D(disabled|[a-z][a-z])#i', '', $text);
    $text  = preg_replace('#%3Fcontrols%3D\d#i', '', $text);
    return array(
        $title,
        $text
    );
}

function youtubomatic_strip_html_tags($str)
{
    $str = html_entity_decode($str);
    $str = preg_replace('/(<|>)\1{2}/is', '', $str);
    $str = preg_replace(array(
        '@<head[^>]*?>.*?</head>@siu',
        '@<style[^>]*?>.*?</style>@siu',
        '@<script[^>]*?.*?</script>@siu',
        '@<noscript[^>]*?.*?</noscript>@siu'
    ), "", $str);
    $str = strip_tags($str);
    return $str;
}

function youtubomatic_DOMinnerHTML(DOMNode $element)
{
    $innerHTML = "";
    $children  = $element->childNodes;
    
    foreach ($children as $child) {
        $innerHTML .= $element->ownerDocument->saveHTML($child);
    }
    
    return $innerHTML;
}

function youtubomatic_url_exists($url)
{
    stream_context_set_default( [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]);
    $headers = get_headers($url);
    if (!isset($headers[0]) || strpos($headers[0], '200') === false)
        return false;
    return true;
}

register_activation_hook(__FILE__, 'youtubomatic_check_version');
function youtubomatic_check_version()
{
    if (!function_exists('curl_init')) {
        echo '<h3>'.esc_html__('Please enable curl PHP extension. Please contact your hosting provider\'s support to help you in this matter.', 'youtubomatic-youtube-post-generator').'</h3>';
        die;
    }
    global $wp_version;
    if (!current_user_can('activate_plugins')) {
        echo '<p>' . esc_html__('You are not allowed to activate plugins!', 'youtubomatic-youtube-post-generator') . '</p>';
        die;
    }
    $php_version_required = '5.4';
    $wp_version_required  = '2.7';
    
    if (version_compare(PHP_VERSION, $php_version_required, '<')) {
        deactivate_plugins(basename(__FILE__));
        echo '<p>' . sprintf(esc_html__('This plugin can not be activated because it requires a PHP version greater than %1$s. Please update your PHP version before you activate it.', 'youtubomatic-youtube-post-generator'), $php_version_required) . '</p>';
        die;
    }
    
    if (version_compare($wp_version, $wp_version_required, '<')) {
        deactivate_plugins(basename(__FILE__));
        echo '<p>' . sprintf(esc_html__('This plugin can not be activated because it requires a WordPress version greater than %1$s. Please go to Dashboard -> Updates to get the latest version of WordPress.', 'youtubomatic-youtube-post-generator'), $wp_version_required) . '</p>';
        die;
    }
}

function youtubomatic_register_mysettings()
{
    youtubomatic_cron_schedule();
    if(array_key_exists('youtubomatic_page', $_GET))
    {
        $curent_page = $_GET["youtubomatic_page"];
    }
    else
    {
        $curent_page = '';
    }
    $GLOBALS['wp_object_cache']->delete('youtubomatic_rules_list', 'options');
    $all_rules = get_option('youtubomatic_rules_list', array());
    $rules_count = count($all_rules);
    $rules_per_page = get_option('youtubomatic_posts_per_page', 16);
    $max_pages = ceil($rules_count/$rules_per_page);
    if($max_pages == 0)
    {
        $max_pages = 1;
    }
    $last_url = (youtubomatic_isSecure() ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(stristr($last_url, 'youtubomatic_items_panel') !== false && (!is_numeric($curent_page) || $curent_page > $max_pages || $curent_page <= 0))
    {
        if(stristr($last_url, 'youtubomatic_page=') === false)
        {
            if(stristr($last_url, '?') === false)
            {
                $last_url .= '?youtubomatic_page=' . $max_pages;
            }
            else
            {
                $last_url .= '&youtubomatic_page=' . $max_pages;
            }
        }
        else
        {
            if(array_key_exists('youtubomatic_page', $_GET))
            {
                $curent_page = $_GET["youtubomatic_page"];
            }
            else
            {
                $curent_page = '';
            }
            if(is_numeric($curent_page))
            {
                $last_url = str_replace('youtubomatic_page=' . $curent_page, 'youtubomatic_page=' . $max_pages, $last_url);
            }
            else
            {
                if(stristr($last_url, '?') === false)
                {
                    $last_url .= '?youtubomatic_page=' . $max_pages;
                }
                else
                {
                    $last_url .= '&youtubomatic_page=' . $max_pages;
                }
            }
        }
        youtubomatic_redirect($last_url);
    }
    register_setting('youtubomatic_option_group', 'youtubomatic_Main_Settings');
    register_setting('youtubomatic_option_group2', 'youtubomatic_Youtube_Settings');
    if (is_multisite()) {
        if (!get_option('youtubomatic_Main_Settings')) {
            youtubomatic_activation_callback(TRUE);
        }
    }
}
function youtubomatic_redirect($url, $statusCode = 301)
{
   if(!function_exists('wp_redirect'))
   {
       include_once( ABSPATH . 'wp-includes/pluggable.php' );
   }
   wp_redirect($url, $statusCode);
   die();
}
function youtubomatic_get_plugin_url()
{
    return plugins_url('', __FILE__);
}

function youtubomatic_get_file_url($url)
{
    return esc_url(youtubomatic_get_plugin_url() . '/' . $url);
}

function youtubomatic_admin_load_files()
{
    wp_register_style('youtubomatic-browser-style', plugins_url('styles/youtubomatic-browser.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('youtubomatic-browser-style');
    wp_register_style('youtubomatic-custom-style', plugins_url('styles/coderevolution-style.css', __FILE__), false, '1.0.0');
    wp_enqueue_style('youtubomatic-custom-style');
    wp_enqueue_script('jquery');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');
}
add_filter( 'script_loader_tag', 'youtubomatic_async_tag', 10, 3 );
add_action('wp_enqueue_scripts', 'youtubomatic_wp_load_files');
function youtubomatic_wp_load_files()
{
    wp_enqueue_style('coderevolution-front-css', plugins_url('styles/coderevolution-front.css', __FILE__));
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if (isset($youtubomatic_Main_Settings['player_width']) && $youtubomatic_Main_Settings['player_width'] !== '') {
        $width = esc_html($youtubomatic_Main_Settings['player_width']);
    }
    else
    {
        $width = 580;
    }
    if (isset($youtubomatic_Main_Settings['player_height']) && $youtubomatic_Main_Settings['player_height'] !== '') {
        $height = esc_html($youtubomatic_Main_Settings['player_height']);
    }
    else
    {
        $height = 380;
    }
    wp_add_inline_style('youtubomatic-front-css', '.youtubomatic_wh{width:'.$width.'px;height:'.$height.'px;}');
    wp_register_script( 'youtubomatic-dummy-handle-footer', '', [], '', true );
    wp_enqueue_script( 'youtubomatic-dummy-handle-footer'  );
    if (isset($youtubomatic_Main_Settings['enable_og']) && $youtubomatic_Main_Settings['enable_og'] == 'on') {
        wp_register_script( 'youtubomatic-dummy-handle-json-footer', plugins_url('scripts/loader.js', __FILE__), [], '', true );
        wp_enqueue_script( 'youtubomatic-dummy-handle-json-footer'  );
    }
    
    global $post;
    if(is_single())
    {
        if (!isset($youtubomatic_Main_Settings['disable_scripts']) || $youtubomatic_Main_Settings['disable_scripts'] !== 'on') {
            $is_url = get_post_meta($post->ID, 'youtubomatic_ytsubscribe', true);
            if($is_url == '1')
            {
                wp_enqueue_script('youtubomatic-post-js', 'https://apis.google.com/js/platform.js', false, true);
            }
            $youtubomatic_show_hide = get_post_meta($post->ID, 'youtubomatic_show_hide', true);
            if($youtubomatic_show_hide == '1')
            {
                wp_enqueue_script('youtubomatic-showhide-js', plugins_url('scripts/showhide.js', __FILE__), array('jquery'), true);
            }
        }
    }
    wp_enqueue_style('youtubomatic-thumbnail-css', plugins_url('styles/youtubomatic-thumbnail.css', __FILE__));
}

function youtubomatic_random_sentence_generator($first = true)
{
    $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
    if ($first == false) {
        $r_sentences = $youtubomatic_Main_Settings['sentence_list2'];
    } else {
        $r_sentences = $youtubomatic_Main_Settings['sentence_list'];
    }
    $r_variables = $youtubomatic_Main_Settings['variable_list'];
    $r_sentences = trim($r_sentences);
    $r_variables = trim($r_variables, ';');
    $r_variables = trim($r_variables);
    $r_sentences = str_replace("\r\n", "\n", $r_sentences);
    $r_sentences = str_replace("\r", "\n", $r_sentences);
    $r_sentences = explode("\n", $r_sentences);
    $r_variables = str_replace("\r\n", "\n", $r_variables);
    $r_variables = str_replace("\r", "\n", $r_variables);
    $r_variables = explode("\n", $r_variables);
    $r_vars      = array();
    for ($x = 0; $x < count($r_variables); $x++) {
        $var = explode("=>", trim($r_variables[$x]));
        if (isset($var[1])) {
            $key          = strtolower(trim($var[0]));
            $words        = explode(";", trim($var[1]));
            $r_vars[$key] = $words;
        }
    }
    $max_s    = count($r_sentences) - 1;
    $rand_s   = rand(0, $max_s);
    $sentence = $r_sentences[$rand_s];
    $sentence = str_replace(' ,', ',', ucfirst(youtubomatic_replace_words($sentence, $r_vars)));
    $sentence = str_replace(' .', '.', $sentence);
    $sentence = str_replace(' !', '!', $sentence);
    $sentence = str_replace(' ?', '?', $sentence);
    $sentence = trim($sentence);
    return $sentence;
}

function youtubomatic_get_word($key, $r_vars)
{
    if (isset($r_vars[$key])) {
        
        $words  = $r_vars[$key];
        $w_max  = count($words) - 1;
        $w_rand = rand(0, $w_max);
        return youtubomatic_replace_words(trim($words[$w_rand]), $r_vars);
    } else {
        return "";
    }
    
}

function youtubomatic_replace_words($sentence, $r_vars)
{
    
    if (str_replace('%', '', $sentence) == $sentence)
        return $sentence;
    
    $words = explode(" ", $sentence);
    
    $new_sentence = array();
    for ($w = 0; $w < count($words); $w++) {
        
        $word = trim($words[$w]);
        
        if ($word != '') {
            if (preg_match('/^%([^%\n]*)$/', $word, $m)) {
                $varkey         = trim($m[1]);
                $new_sentence[] = youtubomatic_get_word($varkey, $r_vars);
            } else {
                $new_sentence[] = $word;
            }
        }
    }
    return implode(" ", $new_sentence);
}
?>