<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_js_combine extends WPH_module_component
        {
            private $current_placeholder            =   '';
            public  $placeholders                   =   array();
            public  $placeholders_map               =   array();
            
            public  $ie_conditionals_placeholders   =   array();
            
            public $placeholder_hash                =   '';
            
            public $buffer                          =   '';
            
            private $text_replacement_pair          =   array();
            private $css_class_replace_exclude      =   array();
            
            private $settings_hash                  =   '';
            private $buffer_hash                    =   '';
            
            private $filename_js_ignore             =   FALSE;
            private $filename_defer                 =   FALSE;
            private $content_js_ignore              =   FALSE;
            
            
            function get_component_title()
                {
                    return "JavaScript Combine";
                }
                                        
            function get_module_component_settings()
                {
                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'js_combine_code',
                                                                    'label'         =>  __('Combine Processing type',    'wp-hide-security-enhancer'),
                                                                    'description'   =>   __('All assets and inline JavaScript will be post-processed, using Combine or In-place technique.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'help'          =>  array(
                                                                                                        'title'                     =>  __('Help',    'wp-hide-security-enhancer') . ' - ' . __('Combine JavaScript Code',    'wp-hide-security-enhancer'),
                                                                                                        'description'               =>  __('The module implement a post-processing engine, to provide additional functionality on JavaScript as Replacements.', 'wp-hide-security-enhancer') .
                                                                                                                                        "<br /><br />" . __("If the site uses a plugin to concatenate/compress JavaScript files (e.g. cache plugin), this functionality may fail. Its recommended to turn off the other option to allow current to run correctly.",    'wp-hide-security-enhancer') .
                                                                                                                                        "<br />&nbsp;".
                                                                                                                                        "<br />" . __("There are two types of processing options:",    'wp-hide-security-enhancer').
                                                                                                                                        "<br />" . __("<b>Combine</b>: Merge all JavaScript code in (usually) 2 files, one in the header and another in the footer.",    'wp-hide-security-enhancer').
                                                                                                                                        "<br />" . __("<b>In Place</b>: All JavaScript code will be processed and the results will be left in the same spot as an initial asset or in-line CSS. ",    'wp-hide-security-enhancer').
                                                                                                                                        "&nbsp;".
                                                                                                                                        '<br /><span class="important">' . __('If the site contains JavaScript errors, <b>In Place</b> processing type should be selected instead <b>Combine</b>, or the faulty code will break the site.', 'wp-hide-security-enhancer') . '</span>'.
                                                                                                                                        "<br />&nbsp;".
                                                                                                                                        "<br />" . __("This also improves the overal site loading speed and SEO score",    'wp-hide-security-enhancer'),
                                                                                                        'option_documentation_url'  =>  'https://www.wp-hide.com/documentation/general-javascript-combine/'
                                                                                                        ),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Combine',    'wp-hide-security-enhancer'),
                                                                                                'in-place'  =>  __('In Place',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  70
                                                                    );
                                                                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'combined_js_remove_comments',
                                                                    'label'         =>  __('Remove Comments',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove all Comments from processed JavaScript files.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'help'          =>  array(
                                                                                                        'title'                     =>  __('Help',    'wp-hide-security-enhancer') . ' - ' . __('Remove Comments',    'wp-hide-security-enhancer'),
                                                                                                        'description'               =>  __('This option require JavaScript Combine/In Place Code to be active.', 'wp-hide-security-enhancer') .
                                                                                                                                        "<br /><br />" . __("Remove all Comments from processed JavaScript files, which usualy specify Plugins Names.",    'wp-hide-security-enhancer'),
                                                                                                        'option_documentation_url'  =>  'https://www.wp-hide.com/documentation/html-css-js-replacements/'
                                                                                                        ),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array('sanitize_title', 'strtolower'),
                                                                    'processing_order'  =>  80
                                                                    );
                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'js_combine_code_defer',
                                                                    'label'         =>  __('Defer processed JavaScript',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __( 'When a script is defered, the browser execute it when the page has finished parsing.',    'wp-hide-security-enhancer'), 
                                                                    
                                                                    'help'          =>  array(
                                                                                                        'title'                     =>  __('Help',    'wp-hide-security-enhancer') . ' - ' . __('Defer processed JavaScript',    'wp-hide-security-enhancer'),
                                                                                                        'description'               =>  __('This is an advanced option mainly for SEO adjustments. All combined JavaScript assets will be deferred.', 'wp-hide-security-enhancer') . ' ' . __('More detils about defer at', 'wp-hide-security-enhancer') . ' <a href="https://web.dev/render-blocking-resources/" target="_blank">Eliminate render-blocking resources</a>' .
                                                                                                                                        "<br /><br />" . __("The jQuery asset will be left as is, to provide support for any on-line JavaScript code.",    'wp-hide-security-enhancer') .
                                                                                                                                        "<br /><br />" . __("Using the Exclude script from JavaScript Combine along with this option may produce isues.",    'wp-hide-security-enhancer') .
                                                                                                                                        '<br /><span class="important">' . __('Use with caution, if any front-site feature or appearance appears to be broken, disable this option.', 'wp-hide-security-enhancer') . '</span>',
                                                                                                        'option_documentation_url'  =>  'https://www.wp-hide.com/documentation/general-javascript-combine/'
                                                                                                        ),
                                                                    
                                                                    'input_type'    =>  'radio',
                                                                    'options'       =>  array(
                                                                                                'no'        =>  __('No',     'wp-hide-security-enhancer'),
                                                                                                'yes'       =>  __('Yes',    'wp-hide-security-enhancer'),
                                                                                                ),
                                                                    'default_value' =>  'no',
                                                                    
                                                                    'sanitize_type' =>  array(),
                                                                    'processing_order'  =>  70
                                                                    );
                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'js_defer',
                                                                    'label'         =>  __('Defer a JavaScript asset',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __( 'When a script is defered, it specifies that the script is executed when the page has finished parsing.',    'wp-hide-security-enhancer'), 
                                                                    
                                                                    'help'          =>  array(
                                                                                                        'title'                     =>  __('Help',    'wp-hide-security-enhancer') . ' - ' . __('Defer a JavaScript asset',    'wp-hide-security-enhancer'),
                                                                                                        'description'               =>  __('This is an advanced option mainly for SEO adjustments, specify any script which will be excluded from JavaScript Combine, also will be deferred.', 'wp-hide-security-enhancer') . ' ' . __('More detils about defer at', 'wp-hide-security-enhancer') . ' <a href="https://web.dev/render-blocking-resources/" target="_blank">Eliminate render-blocking resources</a>' .
                                                                                                                                         "<br /><br />" . __('The JavaScript code will still be processed while using Replacements.', 'wp-hide-security-enhancer') .
                                                                                                                                         '<br />'    .   __('Use only script name e.g. <code>mediaelement-and-player.min.js</code>, one per row. If need to use async instead, specify the attribute after the file name e.g. jquery-migrate.min.js async', 'wp-hide-security-enhancer') .
                                                                                                                                        '<br /><span class="important">' . __('Use with caution, only certain scripts can be deferred, otherwise specific front-site features and appearance can break.', 'wp-hide-security-enhancer') . '</span>',
                                                                                                        'option_documentation_url'  =>  'https://www.wp-hide.com/documentation/general-javascript-combine/'
                                                                                                        ),
                                                                    
                                                                    'input_type'    =>  'textarea',
                                                                    'default_value' =>  '',
                                                                    
                                                                    'sanitize_type' =>  array(),
                                                                    'processing_order'  =>  70
                                                                    );
                    
                                                                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'js_combine_excludes',
                                                                    'label'         =>  __('Exclude script from JavaScript processing',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Specify any script which will be excluded when using JavaScript Combine.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'help'          =>  array(
                                                                                                        'title'                     =>  __('Help',    'wp-hide-security-enhancer') . ' - ' . __('Exclude script from JavaScript processing',    'wp-hide-security-enhancer'),
                                                                                                        'description'               =>   __('Use only script name e.g. mediaelement-and-player.min.js, one per row.', 'wp-hide-security-enhancer') .
                                                                                                                                        '<br /><br /><span class="important">' . __('Excluding from Combine and using Replacements, there will be no substitutions on this code which can break the layout and specific front-side functionality.', 'wp-hide-security-enhancer') . '</span>',
                                                                                                        'option_documentation_url'  =>  'https://www.wp-hide.com/documentation/general-javascript-combine/'
                                                                                                        ),
                                                                    
                                                                    'input_type'    =>  'textarea',
                                                                    'default_value' =>  '',
                                                                    
                                                                    'sanitize_type' =>  array(),
                                                                    'processing_order'  =>  70
                                                                    );
                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'js_combine_block_excludes',
                                                                    'label'         =>  __('Exclude JavaScript Block from processing',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  '',
                                                                    
                                                                    'help'          =>  array(
                                                                                                        'title'                     =>  '',
                                                                                                        'description'               =>  __('Specify partial JavaScript code block to be excluded from processing. Use a full line or part of it (not individual words) to avoid matching other JavaScript code.', 'wp-hide-security-enhancer') .
                                                                                                                                        '<br /><span class="important">' . __('Excluding from Combine and using processing, there will be no substitutions on this code which can break the layout and specific front-side functionality.', 'wp-hide-security-enhancer') . '</span>', 
                                                                                                        'option_documentation_url'  =>  'https://www.wp-hide.com/documentation/general-javascript-combine/'
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
                
                
                
            function _init_js_combine_code (   $saved_field_data   )
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                    
                    if( defined('WP_ADMIN') &&  ( !defined('DOING_AJAX') ||  ( defined('DOING_AJAX') && DOING_AJAX === FALSE )) && ! apply_filters('wph/components/force_run_on_admin', FALSE, 'js_combine_code' ) )
                        return;
                        
                        
                    if( $this->wph->functions->is_theme_customize() )
                        return;
                        
                    if ( ! apply_filters('wph/components/js_combine_code', TRUE ) )
                        return;

                    add_filter('wp-hide/ob_start_callback/pre_replacements',                                array( $this, '_js_process_html'));
                    add_filter('wp-hide/module/general_js_variables_replace/placeholder_ignore_inline_js',  array( $this, '_placeholder_ignore_inline_js'), 10, 2);
                }
              
            function _js_process_html( $buffer )
                {
                    
                    if  ( empty ( $buffer ) )
                        return $buffer;
                    
                    //if not a HTML page, return the buffer
                    if  ( stripos($buffer, '<body')    ===    FALSE )
                        return $buffer;
                    
                    global $wp_filesystem;

                    if (empty($wp_filesystem)) 
                        {
                            
                            require_once (ABSPATH . '/wp-includes/l10n.php');
                            require_once (ABSPATH . '/wp-includes/formatting.php');
                            require_once (ABSPATH . '/wp-admin/includes/file.php');
                            WP_Filesystem();
                        }    
                        
                    $access_type = get_filesystem_method();
                    if($access_type !== 'direct')
                        return FALSE;
                    
                    //crate a hash using content and current settings to prevent js_content re-proecessing
                    if  ( empty ( $this->settings_hash ) )
                        {
                            $this->settings_hash    =   $this->wph->functions->get_current_site_settings_hash();   
                        }
                        
                    $this->buffer_hash  =   md5( $buffer . $this->settings_hash ) ;
                    
                    //add placeholders for IE conditionals
                    $modified_buffer               =   preg_replace_callback( '/<!--[\s]?\[if(.|\s)+?-->/ism' ,array($this, 'add_placeholder_for_ie_conditionals') , $buffer);
                    
                    $this->placeholder_hash =   '%WPH-PLACEHOLDER-REPLACEMENT';
                       
                    //split the buffer
                    list( $header_content, $body_content )    =   preg_split('/<body/i', $modified_buffer);
                    
                    if (    empty($header_content)  ||  empty ( $body_content ) )
                        return $buffer;
                    
                    $this->current_placeholder  =   'header';
                    $this->placeholders[ $this->current_placeholder ]   =   array();
                    $this->buffer               =   $header_content;    
                    $this->buffer               =   preg_replace_callback( '/(\s*)<script(\b[^>]*?>)([\s\S]*?)<([\s\/]+)script>(\s*)/i' ,array($this, 'add_js_placeholders_callback') , $this->buffer);
                   
                    $js_recipient_content       =   $this->placeholders_process();
                    $status                     =   $this->write_to_cache( $js_recipient_content );
                    if  ( $status === FALSE )
                        return $buffer;
                    $this->content_replace_placeholders( );
                    $header_content             =   $this->buffer;
                    
                    
                    $this->current_placeholder  =   'footer'; 
                    $this->placeholders[ $this->current_placeholder ]   =   array();   
                    $this->buffer               =   $body_content;    
                    $this->buffer               =   preg_replace_callback( '/(\s*)<script(\b[^>]*?>)([\s\S]*?)<([\s\/]+)script>(\s*)/i' ,array($this, 'add_js_placeholders_callback') , $this->buffer);
                   
                    $js_recipient_content       =   $this->placeholders_process();
                    $status                     =   $this->write_to_cache( $js_recipient_content );
                    if  ( $status === FALSE )
                        return $buffer;
                    $this->content_replace_placeholders( );
                    $body_content               =   $this->buffer;
                    
                    
                    $buffer =   $header_content .   '<body'  .   $body_content;
                    
                    //restore the IE conditionals 
                    if ( count ( $this->ie_conditionals_placeholders ) >    0 )
                        {
                            foreach ( $this->ie_conditionals_placeholders   as  $placeholder    =>  $code_block )
                                {
                                     $buffer  =   str_replace($placeholder, $code_block, $buffer);   
                                }       
                        }
                                        
                    return $buffer;   
                }
                
                
                
            /**
            * Preserve any IE conditionals
            * 
            * @param mixed $match
            */
            function add_placeholder_for_ie_conditionals( $match )
                {
                    
                    $match_block    =   $match[0];
                    
                    $placeholder    =   $this->placeholder_hash . '-ie-conditional-' . count( $this->ie_conditionals_placeholders ) . '%';
                    $this->ie_conditionals_placeholders[ $placeholder ] =   $match_block;
                    
                    return $placeholder;

                }
            
            
            /**
            * Extract all JS
            *                 
            * @param mixed $match
            */
            function add_js_placeholders_callback( $match )
                {
                    
                    $pre_space      =   $match[1] === '' ? ''   :   ' ';
                    $tag_attrs      =   $match[2];
                    $tag_content    =   $match[3];
                    $post_space     =   $match[4] === '' ? ''   :   ' ';
                    
                    $match_block    =   $pre_space . '<script' . $tag_attrs . $tag_content . '</script>' . $post_space;
                    
                    $placeholder    =   $this->placeholder_hash . '-js-' . count( $this->placeholders[ $this->current_placeholder ] ) . '%';
                    $this->placeholders[ $this->current_placeholder ][ $placeholder ] =   preg_replace('/\n(\s*\n){2,}/', "\n\n", trim($match_block) );
                    
                    return $placeholder;
                    
                }
                
            
            /**
            * Process the placeholders
            * 
            */
            function placeholders_process()
                {
                    
                    $js_recipient_content   =   array();
                    
                    $local_url_parsed   =   parse_url( home_url() );
                    $CDN_urls   =   (array)$this->wph->functions->get_site_module_saved_value('cdn_url',  $this->wph->functions->get_blog_id_setting_to_use());
                    $CDN_urls    =   array_filter( array_map("trim", $CDN_urls) ) ;
                    $use_cdn     =   '';
                    if  ( count ( $CDN_urls ) > 0 )
                        $use_cdn    =   $CDN_urls[0];
                    
                    $document_root      =   isset($_SERVER['DOCUMENT_ROOT'])    &&  ! empty( $_SERVER['DOCUMENT_ROOT'] )    ?   $_SERVER['DOCUMENT_ROOT']   :   ABSPATH;
                    
                    libxml_use_internal_errors(true);
                    
                    foreach ( $this->placeholders[ $this->current_placeholder ]   as  $placeholder    =>  $code_block )
                        {
                            
                            $doc = new DOMDocument();
                            $doc->loadHTML( $code_block );

                            //$element_content    =   $doc->getElementsByTagName('script')[0]->nodeValue;
                            //use prg_math to avoid tag strip
                            preg_match('/<script[^>]*>(.*)<\/script>/is', $code_block, $matches );
                            $element_content    =   isset ( $matches[1] ) ?     $matches[1] :   '';
                            
                            $element_type       =   $doc->getElementsByTagName('script')[0]->getAttribute('type');
                            $element_src        =   $doc->getElementsByTagName('script')[0]->getAttribute('src');
                            
                            if  ( ! empty ( $element_src ) ) 
                                $resurce_url_parsed =   parse_url( $element_src );
                            
                            //check for valid script
                            if ( ! empty ( $element_type )  &&  strtolower($element_type)   !=  'text/javascript')
                                {
                                    $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'non-js';
                                    continue;
                                }
                            
                            //check if the resource is on local    
                            if ( ! empty ( $element_src )    &&  $local_url_parsed['host']  !=  $resurce_url_parsed['host']     &&  $use_cdn    !=  $resurce_url_parsed['host']) 
                                {
                                    $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'remote-file-js';
                                    continue;
                                }

                            if  (   ! empty ( $element_content ) )
                                {
                                    
                                    $ignore =   apply_filters('wp-hide/module/general_js_variables_replace/placeholder_ignore_inline_js', FALSE, $element_content);
                                    
                                    //check for content ignore
                                    if  ( $this->_js_content_ignore_check( $element_content ) )
                                        {
                                            $ignore =   TRUE;    
                                        }
                                    
                                    if ( $ignore )
                                        {
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'ignore-inline-js';   
                                        }
                                        else
                                        {
                                            
                                            //Allow pre-processing 
                                            $element_content =    apply_filters( 'wp-hide/module/general_js_combine/placeholders_process/element_content', $element_content, FALSE );
                                            
                                            $js_recipient_content[$placeholder]   =  "\n"  .  $element_content;
                                         
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'inline-js';
                                        }
                                    
                                }
                                else
                                {
                                                                            
                                    //check for filename ignore
                                    if  ( $this->_js_file_ignore_check( $element_src ) ||   strpos( $element_src, '/cache/wph/')   !== FALSE    ||  apply_filters( 'wp-hide/module/general_js_combine/ignore_file', FALSE, $element_src )    )
                                        {
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'ignore-local-file-js';
                                            continue;    
                                        }
                                    
                                    $resurce_path   =   $resurce_url_parsed['path'];
                                    if  ( is_multisite() &&  $this->wph->default_variables['network']['current_blog_path']  !=  '/' )
                                        {
                                            $resurce_path   =   preg_replace("/^". preg_quote( $this->wph->default_variables['network']['current_blog_path'], '/' ) ."/i", $this->wph->default_variables['site_relative_path'], $resurce_url_parsed['path']);
                                            if ( strpos($resurce_path, "/") !== 0 )
                                                $resurce_path   =   '/' .   $resurce_path;
                                        }
                                              
                                    //attempt to retrieve the file locally
                                    $local_file_path    =   urldecode( $document_root .    $resurce_path );
                                    if ( !  file_exists ( $local_file_path ) )
                                        {
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'local-not-found-file-js';
                                            continue;
                                        }
                                        
                                    $resurce_url_file_info =   pathinfo( $resurce_path );
                                    if  ( ! isset($resurce_url_file_info['extension'])  ||  $resurce_url_file_info['extension'] !=  'js')
                                        {
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'local-no-js-file';
                                            continue;
                                        }
                                    
                                    $local_file_content =   @file_get_contents ( $local_file_path );
                                    
                                    if ( $local_file_content    === FALSE )
                                        continue;
                                                                            
                                    //check for content ignore
                                    if  ( $this->_js_content_ignore_check( $local_file_content ) )
                                        {
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'ignore-local-file-js';
                                            continue;    
                                        }
                                    
                                    //Allow pre-processing 
                                    $local_file_content =    apply_filters( 'wp-hide/module/general_js_combine/placeholders_process/element_content', $local_file_content, $local_file_path );
                                        
                                    $js_recipient_content[$placeholder]   =  "\n"  .  $local_file_content;
                                    
                                    //check for defer
                                    $defer_file   =   $this->_js_file_defer( $element_src );
                                    if  (  ! empty ( $defer_file ) ||   strpos( $element_src, '/cache/wph/')   !== FALSE    )
                                        {
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   $defer_file . '-local-file-js';   
                                        }
                                        else if ( !empty ( $use_cdn )    &&  $use_cdn    ==  $resurce_url_parsed['host'] )
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'cdn-local-file-js';
                                            else
                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'local-file-js';
                                    
                                }

                        }
                        
                    libxml_clear_errors();
                    
                    return $js_recipient_content;
                    
                }
            
            
            
            /**
            * Write the $js_recipient_content to cache
            * 
            * @param mixed $js_recipient_content
            */
            function write_to_cache( $js_recipient_content )
                {
                    $CDN_urls   =   (array)$this->wph->functions->get_site_module_saved_value('cdn_url',  $this->wph->functions->get_blog_id_setting_to_use());
                    $CDN_urls   =   array_filter( array_map("trim", $CDN_urls) ) ;
                    $CDN_url    =   '';
                    if  ( count ( $CDN_urls ) > 0 )
                        $CDN_url    =   $CDN_urls[0];
                    if ( ! empty ( $CDN_url ) )
                        {
                            $cdn_use_for_cache_files    =   $this->wph->functions->get_site_module_saved_value('cdn_use_for_cache_files',   $this->wph->functions->get_blog_id_setting_to_use());
                            $home_url           =   home_url();
                            $home_url_parsed    =   parse_url($home_url);
                        }

                    $js_combine_code_defer      =   $this->wph->functions->get_site_module_saved_value( 'js_combine_code_defer',   $this->wph->functions->get_blog_id_setting_to_use());
                    $defer_attribute            =   '';
                    if ( $js_combine_code_defer == 'yes' )
                        $defer_attribute    =   ' defer ';
                        
                    $js_content =   '';
                    
                    $js_combine_code   =   $this->wph->functions->get_site_module_saved_value('js_combine_code',  $this->wph->functions->get_blog_id_setting_to_use());
                    
                    foreach ( $this->placeholders[ $this->current_placeholder ]   as  $placeholder    =>  $code_block )
                        {
                            if  ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "non-js" ) ) )
                                continue;
                            
                            if  ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "inline-js", "local-file-js", "cdn-local-file-js" ) ) )
                                {
                                    if ( $js_combine_code ==   'yes' )
                                        {
                                            $js_content .=   '#! WPH-JS-Content-Start' . "\n";
                                            $js_content .=  $this->_debug( $placeholder );
                                            $js_content .=  $js_recipient_content[$placeholder] ."\n";
                                            $this->placeholders[ $this->current_placeholder ][$placeholder]   =   '';
                                        }
                                        else
                                        {
                                            $js_content =    '#! WPH-JS-Content-Start' . "\n";
                                            $js_content .=  $this->_debug( $placeholder );
                                            $js_content .=  $js_recipient_content[$placeholder] ."\n";
                                            
                                            //in-place
                                            $file_url   =   $this->write_file( $js_content );
                                            if  (   $file_url   === FALSE )
                                                return FALSE;
                                                
                                            //check if using CDN with url replace for cached files
                                            if  (   ! empty ( $CDN_url )    &&  $cdn_use_for_cache_files  ==  'yes'   )
                                                $file_url   =   str_ireplace(   $home_url_parsed['host'],   $CDN_url, $file_url );
                                            
                                            $this->placeholders[ $this->current_placeholder ][ $placeholder ]   =   '<script type="text/javascript" src="'. $file_url   .'"' . $defer_attribute .'></script>';
                                        }
                                }
                                else if    ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "ignore-inline-js" ) ) )
                                {
                                    //process the ignore-inline-js
                                    $this->placeholders[ $this->current_placeholder ][$placeholder]   =  $this->js_recipient_process( $this->placeholders[ $this->current_placeholder ][$placeholder] );                                    
                                }
                                else  if    ( $js_combine_code ==   'yes'   &&  in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "remote-file-js", "local-no-js-file", "ignore-local-file-js" ) )    &&  ! empty ( $js_content ) )
                                {
                                    
                                    $file_url   =   $this->write_file( $js_content );
                                    if  (   $file_url   === FALSE )
                                        return FALSE;
                                        
                                    //check if using CDN with url replace for cached files
                                    if  (   ! empty ( $CDN_url )    &&  $cdn_use_for_cache_files  ==  'yes'   )
                                        $file_url   =   str_ireplace(   $home_url_parsed['host'],   $CDN_url, $file_url );
                                    
                                    $this->placeholders[ $this->current_placeholder ][ $placeholder ]   =   '<script type="text/javascript" src="'. $file_url   .'"' . $defer_attribute .'></script>'  .   $this->placeholders[ $this->current_placeholder ][ $placeholder ];
                                        
                                    $js_content =   '';
                                }
                                else  if    ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "defer-local-file-js", "async-local-file-js" ) ) )
                                {
                                    $tag_attribute    =   $this->placeholders_map[ $this->current_placeholder ][$placeholder];
                                    $tag_attribute      =   str_replace( "-local-file-js", "", $tag_attribute);
                                    
                                    if  ( $js_combine_code ==   'yes'  && ! empty ( $js_content ) )
                                        {
                                            $file_url   =   $this->write_file( $js_content );
                                            if  (   $file_url   === FALSE )
                                                return FALSE;
                                                
                                            //check if using CDN with url replace for cached files
                                            if  (   ! empty ( $CDN_url )    &&  $cdn_use_for_cache_files  ==  'yes'   )
                                                $file_url   =   str_ireplace(   $home_url_parsed['host'],   $CDN_url, $file_url );
                                            
                                            $this->placeholders[ $this->current_placeholder ][ $placeholder ]   =   '<script type="text/javascript" src="'. $file_url   .'"' . $defer_attribute .'></script>';
                                                
                                            $js_content =   '';
                                        }
                                        else
                                        $this->placeholders[ $this->current_placeholder ][ $placeholder ]   =   '';
                                    
                                    $js_content =   '#! WPH-JS-Content-Start' . "\n";
                                    $js_content .=  $this->_debug( $placeholder );
                                    $js_content .=   $js_recipient_content[$placeholder] ."\n";
                                        
                                    //process the defer script
                                    $file_url   =   $this->write_file( $js_content );
                                    if  (   $file_url   === FALSE )
                                        return FALSE;
                                        
                                    //check if using CDN with url replace for cached files
                                    if  (   ! empty ( $CDN_url )    &&  $cdn_use_for_cache_files  ==  'yes'   )
                                        $file_url   =   str_ireplace(   $home_url_parsed['host'],   $CDN_url, $file_url );
                                    
                                    $this->placeholders[ $this->current_placeholder ][ $placeholder ]   .=   '<script ' .$tag_attribute .'="'.$tag_attribute.'" type="text/javascript" src="'. $file_url   .'"' . $defer_attribute .'></script>';
                                    
                                    $js_content =   '';
                                }
                        }
                        
                    if  (  $js_combine_code ==   'yes'  &&  ! empty ( $js_content ) )
                        {
                            //add insert for the last js block
                            $placeholder    =   $this->content_last_placeholder();
                            
                            $file_url   =   $this->write_file( $js_content );
                            if  (   $file_url   === FALSE )
                                return FALSE;
                                
                            //check if using CDN with url replace for cached files
                            if  (   ! empty ( $CDN_url )    &&  $cdn_use_for_cache_files  ==  'yes'   )
                                $file_url   =   str_ireplace(   $home_url_parsed['host'],   $CDN_url, $file_url );
                            
                            $this->placeholders[ $this->current_placeholder ][ $placeholder ]   =   '<script type="text/javascript" src="'. $file_url   .'"' . $defer_attribute .'></script>';
                                
                            $js_content =   '';
                        }
                    
                }
            
            
            /**
            * Write the js content and to the replacements
            * 
            * @param mixed $filename_path
            * @param mixed $content
            */
            function write_file( $js_content )
                {
                    global $wp_filesystem;
                    
                    //explode the blocks
                    $js_content_blocks  =   explode('#! WPH-JS-Content-Start', $js_content );
                    $js_content_blocks  =   array_map("trim", $js_content_blocks);
       
                    $js_content =   '';
       
                    foreach ( $js_content_blocks    as $key =>  $js_content_block )
                        {
                            if  (  empty ( $js_content_block ) )
                                continue;
                            
                            $hash   =   md5 ( $js_content_block ); 
                            $file_path  =   WPH_CACHE_PATH  .   'block_' . $this->settings_hash . '_' . $hash   .'.js';
                            
                            //if block already processed, just load it
                            if ( file_exists ( $file_path ) )
                                {
                                    $js_content .=  "\n" .  $wp_filesystem->get_contents( $file_path ) ;                                            
                                    continue;   
                                }
                                
                            $js_content_block   =   $this->js_recipient_process( $js_content_block );
                   
                            
                            //write the file for later usage
                            $wp_filesystem->put_contents( $file_path, $js_content_block, FS_CHMOD_FILE );
                                                      
                            //do the replcaements
                            $js_content .=   "\n" . $js_content_block;  
                            
                        }
                    
                    
                    
                    $hash   =   md5 ( $js_content );
                                    
                    $file_path  =   WPH_CACHE_PATH  .   $this->settings_hash . '_' . $hash   .'.js';
                    $file_url   =   WPH_CACHE_URL   .   $this->settings_hash . '_' . $hash   .'.js';
                    
                    if ( file_exists ( $file_path ) )
                        return $file_url;
  
                    //check if the file alreadyexists
                    if ( ! file_exists ( $file_path ) )
                        {                                

                            $fp = @fopen( $file_path, 'wb' );
                            if ( ! $fp )
                                return false;
                                
                            if ( ! flock($fp, LOCK_EX)) 
                                return false;

                            mbstring_binary_safe_encoding();

                            $data_length = strlen( $js_content );

                            $bytes_written = fwrite( $fp, $js_content );

                            reset_mbstring_encoding();
                            
                            //flush output before releasing the lock
                            fflush($fp);
                            
                            // release the lock
                            flock($fp, LOCK_UN);

                            fclose( $fp );

                            if ( $data_length !== $bytes_written )
                                return false;

                            $wp_filesystem->chmod( $file_path, FS_CHMOD_FILE );

                            
                        }
                        
                    return $file_url;
                    
                }
                
                
            /**
            * Do the replacements
            * 
            * @param mixed $js_recipient_content
            */
            function js_recipient_process( $js_content )
                {
                    $html_css_js_replacements   =   $this->wph->functions->get_site_module_saved_value('html_css_js_replacements',   $this->wph->functions->get_blog_id_setting_to_use());
                    
                    if  ( is_array( $html_css_js_replacements )   &&  count ( $html_css_js_replacements ) > 0 )
                        $js_content                 =   $this->wph->regex_processor->do_replacements( $js_content, $html_css_js_replacements, 'js' );
                    
                    $js_content    =   $this->_process_url_replacements( $js_content );
                    
                    //check for stripp out comments
                    $values =   $this->wph->functions->get_site_module_saved_value('combined_js_remove_comments',  $this->wph->functions->get_blog_id_setting_to_use());
                    if  ( $values   ==  'yes'   )
                        $js_content    =   $this->strip_comments( $js_content );
                    
                    return $js_content;    
                }
                
            
            /**
            * Do url replacements
            *     
            * @param mixed $js_content
            */
            function _process_url_replacements( $js_content )
                {
                    //apply the urs replacements
                    $replacement_list       =   $this->wph->functions->get_replacement_list();
                   
                    //replace the urls
                    $js_content            =   $this->wph->functions->content_urls_replacement($js_content,  $replacement_list ); 
                    
                    //Custom urls map
                    $WPH_module_rewrite_map_custom_urls =   new WPH_module_rewrite_map_custom_urls();
                    $js_content            =    $WPH_module_rewrite_map_custom_urls->_do_html_replacements( $js_content );
                    
                    //CDN 
                    $CDN_urls   =   (array)$this->wph->functions->get_site_module_saved_value('cdn_url',  $this->wph->functions->get_blog_id_setting_to_use());
                    $CDN_urls   =   array_filter( array_map("trim", $CDN_urls) ) ;
                    $CDN_url    =   '';
                    if  ( count ( $CDN_urls ) > 0 )
                        $CDN_url    =   $CDN_urls[0];
                    $cdn_use_for_assets_inside_cache_files    =   $this->wph->functions->get_site_module_saved_value('cdn_use_for_assets_inside_cache_files',   $this->wph->functions->get_blog_id_setting_to_use());
                    if  (   ! empty ( $CDN_url )    &&  $cdn_use_for_assets_inside_cache_files  ==  'yes'   )
                        {
                            
                            $home_url           =   home_url();
                            $home_url_parsed    =   parse_url($home_url);
                            
                            $js_content        =   str_ireplace(   'http://' . $home_url_parsed['host'],   'http://' . $CDN_url, $js_content );
                            $js_content        =   str_ireplace(   'https://' . $home_url_parsed['host'],  'https://' .  $CDN_url, $js_content );
                        }
                    
                    return $js_content;
                    
                }
                
                
            /**
            * Strip comments 
            * 
            * @param mixed $buffer
            */
            function strip_comments( $js_content )
                {
                    if ( defined( 'WPH_DEBUG' ) &&  WPH_DEBUG   === TRUE )
                        return $js_content;
                            
                    $js_content = preg_replace_callback( '#((["\'])(?:\\[\s\S]|.)*?\2|(?:[^\w\s]|^)\s*\/(?![*\/])(?:\\.|\[(?:\\.|.)\]|.)*?\/(?=[gmiy]{0,4}\s*(?![*\/])(?:\W|$)))|\/\/.*?$|\/\*[\s\S]*?\*\/#i', array ( $this, 'strip_comments_callback' ), $js_content );
                    
                    return $js_content;
                    
                }
            
            
            function strip_comments_callback( $match )
                {
                    if  ( count ( $match ) > 1 )
                        return $match[0];
                        
                    return '';
                }
            
                
            /**
            * Callback function for replacement
            * 
            * @param mixed $matches
            */
            function replace_callback( $matches ) 
                {
                    $text   =   substr($matches[0], 0, strlen( $matches[0] ) - strlen( $matches[1] ));
                    $text   .=  $this->text_replacement_pair[1];
                          
                    return $text;    
                }
            
            
            /**
            * Add a placeholder for the last js code to be inserted
            * 
            * @param mixed $content
            */
            function content_last_placeholder( )
                {
                    $insert_above_tag    =   '';
                    switch ($this->current_placeholder)
                        {
                            case    'header'   :
                                                                $insert_above_tag   =   'head';
                                                                break;
                                                                
                            case    'footer'   :
                                                                $insert_above_tag   =   'body';
                                                                break;
                        }
                        
                    list( $first_part, $seccond_part )    =   preg_split('/<\/'    .   $insert_above_tag   .'>/i', $this->buffer);   
                    
                    $placeholder    =   $this->placeholder_hash . '-js-' . count( $this->placeholders[ $this->current_placeholder ] ) . '%';
                    $this->placeholders[ $this->current_placeholder ][ $placeholder ] =   '';
                                                                
                    $this->buffer    =   $first_part . $placeholder  .   '</'.$insert_above_tag.'>' .   $seccond_part;
                    
                    return $placeholder;    
                    
                    
                }
            
            
            /**
            * Process the content by removing processed placeholders or restore
            * 
            * @param mixed $content
            */
            function content_replace_placeholders( )
                {
                    
                    //put back the remaining placeholders content
                    foreach ( $this->placeholders[ $this->current_placeholder ]   as  $placeholder    =>  $code_block )
                        {
                             $this->buffer  =   str_replace($placeholder, $code_block . "\n", $this->buffer);   
                        }
            
                }
                
                
            
            /**
            * Return the scripts to exclude from js combine
            *     
            */
            function _get_js_combine_excludes()
                {
                    
                    $values =   $this->wph->functions->get_site_module_saved_value( 'js_combine_excludes',  $this->wph->functions->get_blog_id_setting_to_use() );
                    
                    $values =   trim( $values );
                    
                    $lines  =   preg_split ('/\r\n|\n|\r/', $values);
                    
                    $lines  =   array_filter($lines, 'trim');
                    $lines  =   array_filter($lines);
                    $lines  =   array_values($lines);
                    
                    //check if defer
                    $js_combine_code_defer      =   $this->wph->functions->get_site_module_saved_value( 'js_combine_code_defer',   $this->wph->functions->get_blog_id_setting_to_use());
                    if ( $js_combine_code_defer == 'yes' )
                        {
                            $lines[]    =   'jquery(-[0-9.]+)?(.min|.slim|.slim.min)?.js';
                        }
                    
                    return (array)$lines;
                    
                }
                
            
            
            /**
            * Check for filename ignore
            *     
            * @param mixed $element_href
            */
            function _js_file_ignore_check ( $element_href ) 
                {
                    if ( $this->filename_js_ignore === FALSE )
                        $this->filename_js_ignore    =   $this->_get_js_combine_excludes();
                
                    //check the file name ignore    
                    if ( count ( $this->filename_js_ignore ) >  0 )
                        {
                            //check if in the ignore list
                            foreach ( $this->filename_js_ignore   as  $local_js_ignore_item )
                                {
                                    if ( preg_match( '/' . $local_js_ignore_item .'/' , $element_href ) > 0 )
                                        {
                                            return TRUE;
                                        }   
                                }   
                        }
                    
                    return FALSE;
                    
                }
                
            
            
            /**
            * Return the scripts to defer
            *     
            */
            function _get_js_defer()
                {
                    
                    $values =   $this->wph->functions->get_site_module_saved_value( 'js_defer',  $this->wph->functions->get_blog_id_setting_to_use() );
                    
                    $values =   trim( $values );
                    
                    $lines  =   preg_split ('/\r\n|\n|\r/', $values);
                    
                    $lines  =   array_filter($lines, 'trim');
                    $lines  =   array_filter($lines);
                    $lines  =   array_values($lines);
                    
                    if ( empty ( $lines ) )
                        return (array)$lines;
                    
                    $processed_lines    =   array();
                    
                    foreach  ( $lines as $line)
                        {
                            $line   =   explode(" ", $line);
                            
                            //check for errors
                            if ( count  ( $line )   >   2 )
                                continue;
                                
                            if ( count  ( $line )   ==   2 )
                                {
                                    list ( $defer_file, $tag_attribute )    =   $line;
                                    $tag_attribute  =   strtolower($tag_attribute);
                                    if  ( !in_array( $tag_attribute, array( 'defer', 'async' )))
                                        $tag_attribute  =   'defer';
                                }
                                else
                                {
                                    $defer_file     =   $line[0];
                                    $tag_attribute  =   'defer';
                                }
                                
                            $processed_lines[ $defer_file ] =   $tag_attribute;
                        }
                    
                    return $processed_lines;
                    
                }
                
                
            /**
            * Check for defer
            *     
            * @param mixed $element_href
            */
            function _js_file_defer ( $element_href ) 
                {
                    if ( $this->filename_defer === FALSE )
                        $this->filename_defer    =   $this->_get_js_defer();
                
                    //check the file name ignore    
                    if ( count ( $this->filename_defer ) >  0 )
                        {
                            //check if in the ignore list
                            foreach ( $this->filename_defer   as  $local_js_defer   =>  $tag_attribute )
                                {
                                    if ( strpos( $element_href , $local_js_defer ) !==   FALSE )
                                        {
                                            return $tag_attribute;
                                        }   
                                }   
                        }
                    
                    return FALSE;
                    
                }  
            
                
            
            function _js_content_ignore_check( $element_content )
                {
                    if ( $this->content_js_ignore === FALSE )
                        {
                            $this->content_js_ignore    =   (array)$this->wph->functions->get_site_module_saved_value('js_combine_block_excludes',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                            $this->content_js_ignore    =   array_filter( $this->content_js_ignore, 'trim');
                            $this->content_js_ignore    =   array_filter( $this->content_js_ignore);
                            
                            if  ( count ( $this->content_js_ignore ) < 1 )
                                return FALSE;
                            
                            //replace all new lines
                            foreach ( $this->content_js_ignore as   $key    =>  $value )
                                {
                                    $value  =   preg_quote( $value );
                                    $value  =   preg_split('/\r\n|\n|\r/', $value);
                                    $value  =   array_map('trim', $value );
                                    $value  =   implode('([\s]+)?', $value);
                                    
                                    $this->content_js_ignore[ $key ]    =   $value;
                                }   
                            
                        }
                        
                    if  ( count ( $this->content_js_ignore ) < 1 )
                        return FALSE;
                    
                    foreach ( $this->content_js_ignore as   $value )
                        {
                            if ( preg_match( '#' . $value .'#' , $element_content))
                                return TRUE;   
                            
                        }
                                                 
                    return FALSE;   
                }
                
                
            function _module_option_html( $module_setting )
                {
                    if(!empty($module_setting['value_description'])) 
                        { 
                            ?><p class="description"><?php echo $module_setting['value_description'] ?></p><?php 
                        }
                    
                    $class          =   'ex_block';
                    
                    ?>
                    <!-- WPH Preserve - Start -->
                    <div id="replacer_read_root" style="display: none">
                        <div class="irow"><textarea name="<?php echo $module_setting['id'] ?>[ignore_block][]" class="<?php echo $class ?>" placeholder="JavaScript code block to ignore" type="text"></textarea>  <a href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('.irow'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> </div>
                    </div>
                    <?php
                    
                    $values =   $this->wph->functions->get_site_module_saved_value('js_combine_block_excludes',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    
                    if ( ! is_array($values))
                        $values =   array();
                    
                    if ( count ( $values )  >   0 )
                        {
                            foreach ( $values   as  $block)
                                {
                                    ?>
                                    <div class="irow"><textarea name="<?php echo $module_setting['id'] ?>[ignore_block][]" class="<?php echo $class ?>" placeholder="JavaScript code block to ignore" type="text"><?php echo htmlspecialchars(stripslashes($block)) ?></textarea>  <a href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('.irow'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> </div>
                                    <?php
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
                                        
                    $data       =   $_POST['js_combine_block_excludes'];
                    $values     =   array();
                    
                    if  ( is_array($data )  &&  count ( $data )   >   0     &&  isset($data['ignore_block'])  )
                        {
                            foreach(    $data['ignore_block']   as  $key =>  $text )
                                {
                                    $ignore_block   =   stripslashes($text);
                                    $ignore_block   =   trim($ignore_block);
                                         
                                    $values[]       =  $ignore_block;
                                    
                                }
                        }
                    
                    $values =   array_filter($values);
                    
                    $results['value']   =   $values;  
                    
                    return $results;
                    
                }
                
                
            
            /**
            * Ignore specific inline 
            * 
            * @param mixed $ignore
            * @param mixed $element_content
            */
            function _placeholder_ignore_inline_js( $ignore, $element_content)
                {
                    //on POST actions, ignore inline content as might create issues when returning JS data being called through POST
                    if  (   count ( $_POST ) > 0 )
                        return TRUE;                    
                    
                    //ignore the inline 'var userSettings = {.. definitiion as it always changes
                    if  ( preg_match( '/.*(var userSettings \= ).*/im', $element_content ))
                        return TRUE;
                        
                    //ignore 'document.write'
                    if  ( preg_match( '/.*document\.write.*/im', $element_content ))
                        return TRUE;
                    
                    return $ignore;
                       
                }
                
  
            function _debug ( $placeholder )
                {
                    if ( ! defined( 'WPH_DEBUG' ) ||  WPH_DEBUG   !== TRUE )
                        return;
                    
                    $js_content =   '';
                    
                    $js_content .=  '/* ------------------------' . "\n";;
                    $js_content .=  '#WPH_DEBUG - ' . $this->placeholders_map[ $this->current_placeholder ][$placeholder];
                    
                    if  ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "local-file-js", "cdn-local-file-js" ) ) )
                        {
                            preg_match('/src=\'([^\'\"}]*)\'/i', $this->placeholders[ $this->current_placeholder ][$placeholder], $founds );
                            if ( isset ( $founds[1] ) )
                                $js_content .=  " " . $founds[1];
                        }
                    
                    $js_content .=  " */ \n";
                    
                    return $js_content;
                    
                }
  
  
        }
?>