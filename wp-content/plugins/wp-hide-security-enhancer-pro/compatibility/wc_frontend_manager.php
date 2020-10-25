<?php

    
    /**
    * Compatibility for Plugin Name: WCFM - WooCommerce Frontend Manager
    * Compatibility checked on Version: 6.5.1
    */
    
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    class WPH_conflict_handle_wc_frontend_manager
        {
                        
            var $wph;
                           
            function __construct()
                {
                    if( !   $this->is_plugin_active())
                        return FALSE;
                    
                    global $wph;
                    
                    $this->wph  =   $wph;
                    
                    add_filter( 'wcfm_attachment_url',                    array( $this, 'wcfm_attachment_url'), 1 );
                    
                }                        
            
            function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if( is_plugin_active( 'wc-frontend-manager/wc_frontend_manager.php' ) )
                        return TRUE;
                        else
                        return FALSE;
                }
                       
            function wcfm_attachment_url( $attachment_url )
                {
                    
                    $replacement_list   =   $this->wph->functions->get_replacement_list();
                    
                    //reverse the list
                    $replacement_list   =   array_flip($replacement_list);
                    
                    $attachment_url         =   $this->wph->functions->content_urls_replacement( $attachment_url,  $replacement_list );
                    
                    return $attachment_url;
                    
                }

           
        }
        
        
    new WPH_conflict_handle_wc_frontend_manager();


?>