<?php

     if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
     
     class WPH_Compatibility
        {
            
            var $wph                            =   '';
            var $functions                      =   '';
         
            function __construct()
                {
                    global $wph;

                    $this->wph          =   $wph;
                    $this->functions    =   new WPH_functions();
                    
                    $this->init();
                    
                }
                
                
                
            function init()
                {
                    
                    $CompatibilityFiles  =  scandir( WPH_PATH . 'compatibility' );
                    foreach( $CompatibilityFiles as $CompatibilityFile ) 
                        {
                            if  ( is_file( WPH_PATH . 'compatibility/' . $CompatibilityFile ) )
                                include_once( WPH_PATH . 'compatibility/' . $CompatibilityFile );
                        }
                  
                    
                    /**
                    * Servers             
                    */
                    include_once(WPH_PATH . 'compatibility/host/kinsta.php');
                    
                    /**
                    * Themes
                    */
                    
                    $theme  =   wp_get_theme();
                    
                    if( ! $theme instanceof WP_Theme )
                        return FALSE;
                        
                    $compatibility_themes   =   array(
                                                        'avada'             =>  'avada.php',
                                                        'divi'              =>  'divi.php',
                                                        'woodmart'          =>  'woodmart.php',
                                                        'buddyboss-theme'   =>  'buddyboss-theme.php',
                                                        );
                    
                    if (isset( $theme->template ) )
                        {
                            
                            foreach ( $compatibility_themes as  $theme_slug     =>  $compatibility_file )
                                {
                                    if ( strtolower( $theme->template ) == $theme_slug  ||   strtolower( $theme->name ) == $theme_slug )
                                        {
                                            include_once(WPH_PATH . 'compatibility/themes/' .   $compatibility_file );    
                                        }
                                }
                              
                        }
      
                          
                    do_action('wph/compatibility/init');
                    
                }
            
    
                
        }   
            



?>