<?php


    /**
    * Compatibility for Plugin Name: WP Rocket
    * Compatibility checked on Version: 
    */
    
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    class WPH_conflict_handle_wp_rocket
        {
            var $wph;
                            
            function __construct()
                {
                    if( !   $this->is_plugin_active() )
                        return FALSE;
                        
                    global $wph;
                    
                    $this->wph  =   $wph;
                    
                    //add_filter( 'rocket_buffer',                    array( 'WPH_conflict_handle_wp_rocket', 'rocket_buffer'), 999 );       
                    
                    add_filter( 'rocket_js_url',                        array( $this,   'rocket_js_url'), 999 );
                    
                    add_filter( 'rocket_css_content',                   array( $this,   'rocket_css_content'), 999 );
                    /**
                    * 
                    * STILL THEY ARE MISSING A FILTER FOR JS Content !!!!!!   ....
                    */
                    
                    //ignore the files which where cached through the Cache plugin, as they where already processed
                    add_filter( 'wp-hide/module/general_js_combine/ignore_file' ,   array ( $this, '__general__combine_ignore_file' ), 99, 2 );
                    add_filter( 'wp-hide/module/general_css_combine/ignore_file' ,  array ( $this, '__general__combine_ignore_file' ), 99, 2 );
                    
                    //ignore critical css
                    add_filter( 'wp-hide/module/general_css_variables_replace/placeholder_ignore_css',  array ( $this, '__general__placeholder_ignore_css' ), 99, 3 );
                }                        
            
            function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'wp-rocket/wp-rocket.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }
                
                
            function rocket_buffer( $buffer )
                {
                    
                    $buffer =   $this->wph->ob_start_callback( $buffer );
                    
                    return $buffer;
                    
                }
                
                
            /**
            * Replace js urls
            *     
            * @param mixed $url
            */
            function rocket_js_url( $buffer )
                {
                    
                    //retrieve the replacements list
                    $buffer    =   $this->wph->functions->content_urls_replacement( $buffer,  $this->wph->functions->get_replacement_list() );  
                    
                    return $buffer ;   
                }
            
            
            
            /**
            * Process the Cache CSS content
            * 
            * @param mixed $content
            */
            function rocket_css_content( $buffer )
                {
                    $WPH_module_general_css_combine =   new WPH_module_general_css_combine();
                                            
                    $option__css_combine_code    =   $this->wph->functions->get_site_module_saved_value('css_combine_code',  $this->wph->functions->get_blog_id_setting_to_use());
                    if ( in_array( $option__css_combine_code,   array( 'yes', 'in-place' ) ) )
                        $buffer =   $WPH_module_general_css_combine->css_recipient_process( $buffer );
                        else
                        $buffer =   $WPH_module_general_css_combine->_process_url_replacements( $buffer );  
                    
                    return $buffer;   
                }
                
            function __general__combine_ignore_file( $ignore, $file_src )
                {
                    
                    if ( stripos( $file_src, '/cache/min/' )    ||  stripos( $file_src, '/cache/critical-css/' ) ||  stripos( $file_src, '/cache/busting/' ) )
                        $ignore =   TRUE;    
                    
                    return $ignore;   
                }
                
                
            function __general__placeholder_ignore_css( $ignode, $code, $type )
                {
                    
                    if ( preg_match( '#<style[^>]*(critical)#i', $code ) > 0 )
                        $ignore =   TRUE;
                    
                    return $ignore;   
                }

                            
        }


        new WPH_conflict_handle_wp_rocket();
        
?>