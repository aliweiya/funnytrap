<?php

    
    /**
    * Compatibility for Plugin Name: Fusion Builder
    * Compatibility checked on Version: 1.4.2
    */
    
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

    class WPH_conflict_fusion_builder
        {
                        
            var $wph;
                           
            function __construct()
                {
                    if( !   $this->is_plugin_active())
                        return FALSE;
                    
                    global $wph;
                    
                    $this->wph  =   $wph;
                                        
                    add_action('wph/settings_changed',  array( $this,    'settings_changed'));
                    
                }                        
            
            function is_plugin_active()
                {
                    
                    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    
                    if(is_plugin_active( 'fusion-builder/fusion-builder.php' ))
                        return TRUE;
                        else
                        return FALSE;
                }
                
                
            function settings_changed()
                {
                    $fusion_cache = new Fusion_Cache();
                    $fusion_cache->reset_all_caches();
                }
      
                            
        }
        
    
    new WPH_conflict_fusion_builder();


?>