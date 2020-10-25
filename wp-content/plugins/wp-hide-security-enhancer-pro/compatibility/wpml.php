<?php


    /**
    * Compatibility for Plugin Name: WPML Multilingual CMS
    * Compatibility checked on Version: 4.3.12 
    */

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_conflict_handle_wpml
        {
            
            var $wph;
            
            function __construct()
                {
                    if( !   $this->is_plugin_active() )
                        return FALSE;
                        
                    global $wph;
                    
                    $this->wph  =   $wph;
                                            
                    add_action('plugins_loaded',        array( $this, '_normalize_replacement_urls') , 0 );
                }                        
            
            function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }

                          
            
            /**
            * adjust the replacements
            *     
            */
            function _normalize_replacement_urls()
                {
                    global $sitepress;
                    
                    if (!$sitepress) 
                        return;
                    
                    $current_lang       = apply_filters( 'wpml_current_language', NULL );
                    $default_lang       = apply_filters('wpml_default_language', NULL );
                    $domain_per_lang    = $sitepress->get_setting( 'language_negotiation_type' ) == WPML_LANGUAGE_NEGOTIATION_TYPE_DOMAIN ? true : false;
                    if ($current_lang == $default_lang || $domain_per_lang)
                        return;
                    
                    if ( $sitepress->get_setting( 'language_negotiation_type' ) == WPML_LANGUAGE_NEGOTIATION_TYPE_PARAMETER )
                        {
                            $default_home_url   =   $sitepress->convert_url( $sitepress->get_wp_api()->get_home_url(), $default_lang );
                            $default_home_url   =   str_replace( array ( 'https:', 'http:' ), '', $default_home_url );
                            
                            $home_url   =    home_url();
                            $home_url   =   str_replace( array ( 'https:', 'http:' ), '', $home_url );
                            
                            if  ( $home_url ==  $default_home_url ) 
                                return;
                                
                            foreach ( $this->wph->urls_replacement  as  $priority   =>  $list )
                                {
                                    if ( count ( $list ) > 0 )
                                        {
                                            foreach ( $list as  $replaced   =>  $replacement )
                                                {
                                                    $_replacement   =   str_replace( trailingslashit ( $home_url ) , trailingslashit ( $default_home_url ) ,  $replacement );
                                                    if ( $_replacement != $replacement )
                                                        $this->wph->urls_replacement[$priority][$replaced]  =   $_replacement;
                                                }
                                        }
                                }   
                        }
                        else
                        {
                            $default_home_url   =   $sitepress->convert_url( $sitepress->get_wp_api()->get_home_url(), $default_lang );
                            $default_home_url   =   str_replace( array ( 'https:', 'http:' ), '', $default_home_url );
                            
                            foreach ( $this->wph->urls_replacement  as  $priority   =>  $list )
                                {
                                    if ( count ( $list ) > 0 )
                                        {
                                            foreach ( $list as  $replaced   =>  $replacement )
                                                {
                                                    $_replacement   =   str_replace( trailingslashit ( $default_home_url ) . $current_lang  .'/' , trailingslashit ( $default_home_url )    ,  $replacement );
                                                    if ( $_replacement != $replacement )
                                                        $this->wph->urls_replacement[$priority][$replaced]  =   $_replacement;
                                                }
                                        }
                                }
                        }
                    
                }
  
                            
        }
        
    
    new WPH_conflict_handle_wpml();    
        
?>