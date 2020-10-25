<?php

    
    /**
    * Compatibility for Plugin Name: LiteSpeed Cache
    * Compatibility checked on Version: 3.2.3.2
    */
    
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_conflict_handle_litespeed_cache
        {
            
            var $wph;
            
            function __construct()
                {
                    if( !   $this->is_plugin_active() )
                        return FALSE;
                        
                    global $wph;
                    
                    $this->wph  =   $wph;
                    
                    add_action('litespeed_optm_cssjs',                              array( $this, 'litespeed_optm_cssjs') , 999, 3 );
                    add_action('litespeed_ccss',                                    array( $this, 'litespeed_optm_cssjs') , 999, 2 );

                    
                    //ignore the files which where cached through the Cache plugin, as they where already processed through the filer wpfc_buffer_callback_filter
                    add_filter( 'wp-hide/module/general_js_combine/ignore_file' ,   array ( $this, '__general__combine_ignore_file' ), 99, 2 );
                    add_filter( 'wp-hide/module/general_css_combine/ignore_file' ,  array ( $this, '__general__combine_ignore_file' ), 99, 2 ); 
                                        
                }                        
            
            function is_plugin_active()
                {
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'litespeed-cache/litespeed-cache.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }
            
                  
            function litespeed_optm_cssjs( $buffer, $file_type, $src_list = array()  )
                {
                    switch ( $file_type ) 
                        {
                            case                        'css' :
                            case                    'text/css':
                                                                $WPH_module_general_css_combine =   new WPH_module_general_css_combine();
                                                                
                                                                $option__css_combine_code    =   $this->wph->functions->get_site_module_saved_value('css_combine_code',  $this->wph->functions->get_blog_id_setting_to_use());
                                                                if ( in_array( $option__css_combine_code,   array( 'yes', 'in-place' ) ) )
                                                                    $buffer =   $WPH_module_general_css_combine->css_recipient_process( $buffer );
                                                                    else
                                                                    $buffer =   $WPH_module_general_css_combine->_process_url_replacements( $buffer );  

                                                                break;
                            
                            case    'application/x-javascript':                
                            case                         'js' :
                                                                $WPH_module_general_js_combine =   new WPH_module_general_js_combine();
                                                                
                                                                $option__js_combine_code    =   $this->wph->functions->get_site_module_saved_value('js_combine_code',  $this->wph->functions->get_blog_id_setting_to_use());
                                                                if ( in_array( $option__js_combine_code,   array( 'yes', 'in-place' ) ) )
                                                                    $buffer =   $WPH_module_general_js_combine->js_recipient_process( $buffer );
                                                                    else
                                                                    $buffer =   $WPH_module_general_js_combine->_process_url_replacements( $buffer );  
                                                                
                                                                
                                                                break;   
                            
                            default:
                                            
                                                                $buffer =   $this->wph->proces_html_buffer( $buffer );
                                                                                    
                                                                break;        
                        }
                                
                    return $buffer;   
                }
                
                
            
            function __general__combine_ignore_file( $ignore, $file_src )
                {
                    
                    if ( stripos( $file_src, '/litespeed/cssjs/' ) )
                        $ignore =   TRUE;    
                    
                    return $ignore;   
                }
            
                
        }

        
    new WPH_conflict_handle_litespeed_cache();

?>