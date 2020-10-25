<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_html_css_js_replacements extends WPH_module_component
        {
            private $current_placeholder        =   '';
            public  $placeholders               =   array();
            public  $placeholders_map           =   array();
            
            public $placeholder_hash            =   '';
            
            public $buffer                      =   '';
            
            private $text_replacement_pair      =   array();
            
            
            function get_component_title()
                {
                    return "Replacements";
                }
                                        
            function get_module_component_settings()
                {
                              
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'html_css_js_replacements',
                                                                    'label'         =>  __('Code Replacements',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  '' ,
                                                                    
                                                                    'help'          =>  array(
                                                                                                'title'                     =>  '',
                                                                                                'description'               =>  '<span class="important">' . __('This require the ', 'wp-hide-security-enhancer') . '<a href="admin.php?page=wp-hide-general-css&component=css-combine">' . __('CSS Combine', 'wp-hide-security-enhancer') . '</a> ' . __('and', 'wp-hide-security-enhancer') . ' <a href="admin.php?page=wp-hide-general-js&component=javascript-combine">' . __('JavaScript Combine', 'wp-hide-security-enhancer') . '</a>' . __(' to be set to Yes.', 'wp-hide-security-enhancer') . '</span>' .
                                                                                                                                    '<br />' .  __('This option applys on front side to HTML, CSS and JavaScript assets. The replaced and replacement words are case sensitive.',  'wp-hide-security-enhancer') .
                                                                                                                                    '<br /><br />' . '<span class="important">' . __('Ensure the replacement words are not common, or might conflict with existing POST and GET values after regex replacement. At least 5 chars word ( only letters ) is required for replacement also it is recommended to use unusual char combinations to avoid conflicts.', 'wp-hide-security-enhancer') . '</span>' ,
                                                                                                'option_documentation_url'  =>  'https://www.wp-hide.com/documentation/html-css-js-replacements/'
                                                                                                ),
                                                                                                
                                                                    'interface_help_split'  =>  FALSE,
                                                                    
                                                                    'input_type'    =>  'custom',
                                                                    'default_value' =>  array(),
                                                                    
                                                                    'module_option_html_render' =>  array( $this, '_module_option_html' ),
                                                                    
                                                                    'module_option_processing'  =>  array( $this, '_module_option_processing' ),
                                                                    'processing_order'  =>  70
                                                                    );
                                                                           
                    return $this->component_settings;  
                     
                }
                
                    
                
            function _module_option_html( $module_setting )
                {
                    if(!empty($module_setting['value_description'])) 
                        { 
                            ?><p class="description"><?php echo $module_setting['value_description'] ?></p><?php 
                        }
                    
                    $class          =   'replacement_field text full_width';
                    
                    ?>
                    <!-- WPH Preserve - Start -->
                    <div id="replacer_read_root" style="display: none">
                        <div class="irow"><input name="<?php echo $module_setting['id'] ?>[replaced][]" class="<?php echo $class ?>" value="" placeholder="Replaced" type="text"> <span alt="f345" class="icon dashicons dashicons-arrow-right-alt2">&nbsp;</span> <input name="<?php echo $module_setting['id'] ?>[replace][]" class="<?php echo $class ?>" value="" placeholder="Replacement" type="text"> <a class="action" href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('.irow'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> </div>
                    </div>
                    <?php
                    
                    $values =   $this->wph->functions->get_site_module_saved_value('html_css_js_replacements',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    
                    if ( ! is_array($values))
                        $values =   array();
                    
                    if ( count ( $values )  >   0 )
                        {
                            foreach ( $values   as  $block)
                                {
                                    ?><div class="irow">
                                        <input name="<?php echo $module_setting['id'] ?>[replaced][]" class="<?php echo $class ?>" value="<?php echo htmlspecialchars(stripslashes($block[0])) ?>" placeholder="Replaced" type="text"> <span alt="f345" class="icon dashicons dashicons-arrow-right-alt2">&nbsp;</span> 
                                        <input name="<?php echo $module_setting['id'] ?>[replace][]" class="<?php echo $class ?>" value="<?php echo htmlspecialchars(stripslashes($block[1])) ?>" placeholder="Replacement" type="text"> 
                                        <a class="action" href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('.irow'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> 
                                    </div><?php
                                }
                        }
                                                                        
                    ?>
                        <div id="replacer_insert_root">&nbsp;</div>
                        
                        <p>
                            <button type="button" class="button" onClick="WPH.replace_text_add_row()"><?php _e( "Add New", 'wp-hide-security-enhancer' ) ?></button>
                        </p>
                        
                        <!-- WPH Preserve - Stop -->
                    <?php
                }
                
                
                
            function _module_option_processing( $field_name )
                {
                    
                    $results            =   array();
                    
                    $process_interface_save_errors  =   array();
                                        
                    $data       =   $_POST['html_css_js_replacements'];
                    $values     =   array();
                    
                    if  ( is_array($data )  &&  count ( $data )   >   0     &&  isset($data['replaced'])  )
                        {
                            foreach(    $data['replaced']   as  $key =>  $text )
                                {
                                    $errors =   FALSE;
                                    
                                    $replaced_text  =   stripslashes($text);
                                    $replaced_text  =   trim($replaced_text);
                                    $replaced_text  =   preg_replace("/[^A-Za-z0-9_\-]/", '', $replaced_text);
                                    
                                    $replace_text   =   stripslashes($data['replace'][$key]);
                                    $replace_text   =   trim($replace_text);
                                    $replace_text   =   preg_replace("/[^A-Za-z_\-]/", '', $replace_text);
                                    
                                    if  ( empty( $replaced_text )   ||   empty( $replace_text ) )
                                        continue;
                                    
                                    if  ( strlen( $replaced_text ) < 3 )
                                        { 
                                            $process_interface_save_errors[]    =   array(  'type'      =>  'error',
                                                                                            'message'   =>  __('Provided replaced word ', 'wp-hide-security-enhancer') . ' <b>' . $replaced_text . '</b> '  .  __('need to be at least 3 chars.', 'wp-hide-security-enhancer')
                                                                                        );
                                            $errors                                     =   TRUE;
                                        }
                                    
                                    if  ( strlen( $replace_text ) < 3 )
                                        { 
                                            $process_interface_save_errors[]    =   array(  'type'      =>  'error',
                                                                                            'message'   =>  __('Provided replacement word ', 'wp-hide-security-enhancer') . ' <b>' . $replace_text . '</b> '  .  __('need to be at least 3 chars.', 'wp-hide-security-enhancer')
                                                                                        );
                                            $errors                                     =   TRUE;
                                        }    
                                    
                                    //check if the replacements words are not unique
                                    if  ( count ( $values ) > 0 )
                                        {
                                            foreach ( $values   as  $group )
                                                {
                                                    if ( $replace_text  ==  $group[1] ) 
                                                        {
                                                            $process_interface_save_errors[]    =   array(  'type'      =>  'error',
                                                                                                            'message'   =>  __('Provided replacement word ', 'wp-hide-security-enhancer') . ' <b>' . $replace_text . '</b> '  .  __('already used.', 'wp-hide-security-enhancer')
                                                                                                        );
                                                            $errors                                     =   TRUE;    
                                                        }
                                                }
                                        }
                                    
                                    if  ( $errors )
                                        continue;
                                    
                                    if ( $replaced_text !=  $replace_text   &&  ! empty( $replaced_text ) )
                                        {
                                            $values[]  =  array($replaced_text, $replace_text);   
                                            
                                        }
                                    
                                }
                        }
                    
                    $results['value']   =   $values;
                    
                    if  (  count ( $process_interface_save_errors ) > 0 )
                        {
                            $wph_interface_save_errors  =   get_option( 'wph-interface-save-errors');
                            
                            $wph_interface_save_errors  =   array_filter ( array_merge( (array)$wph_interface_save_errors, $process_interface_save_errors) ) ;
                            
                            update_option( 'wph-interface-save-errors', $wph_interface_save_errors );  
                        }
                    
                    return $results;
                    
                }
  
        }
?>