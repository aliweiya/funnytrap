<?php


    /**
    * Compatibility for Plugin Name: WP Speed of Light
    * Compatibility checked on Version: 2.6.4
    */

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_conflict_handle_wp_speed_of_light
        {
                        
            var $wph;
                           
            function __construct()
                {
                    if( !   $this->is_plugin_active())
                        return FALSE;
                    
                    global $wph;
                    
                    $this->wph  =   $wph;
  
                    add_filter('wpsol_before_cache', array( $this, 'wpsol_before_cache' ), 999);
                    
                    //need filters to change the urls in the minified content!!!
                    
                    //ignore the files which where cached through the Cache plugin, as they where already processed through the filer wpfc_buffer_callback_filter
                    add_filter( 'wp-hide/module/general_js_combine/ignore_file' ,   array ( $this, '__general__combine_ignore_file' ), 99, 2 );
                    add_filter( 'wp-hide/module/general_css_combine/ignore_file' ,  array ( $this, '__general__combine_ignore_file' ), 99, 2 ); 
                        
                        
                }                        
            
            function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'wp-speed-of-light/wp-speed-of-light.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }
   
                
            function wpsol_before_cache( $buffer )
                {
                    
                    if  ( $this->wph->ob_callback_late )
                        return $buffer;
                        
                    //do replacements for this url
                    $buffer =   $this->wph->proces_html_buffer( $buffer );
                    
                    $this->wph->ob_callback_late =   TRUE;
                       
                    return $buffer;   
                    
                }
                
            
            function __general__combine_ignore_file( $ignore, $file_src )
                {
                    
                    if ( stripos( $file_src, '/cache/wpsol-minification/' ) )
                        $ignore =   TRUE;    
                    
                    return $ignore;   
                }
            
                            
        }


    new WPH_conflict_handle_wp_speed_of_light();
        
?>