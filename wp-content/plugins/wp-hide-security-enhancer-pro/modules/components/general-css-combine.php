<?php

    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    class WPH_module_general_css_combine extends WPH_module_component
        {
            private $current_placeholder            =   '';
            public  $placeholders                   =   array();
            public  $placeholders_map               =   array();
            
            public  $ie_conditionals_placeholders   =   array();
            
            public $placeholder_hash                =   '%WPH-PLACEHOLDER-REPLACEMENT';
            
            public $buffer                          =   '';
            
            private $text_replacement_pair          =   array();
            
            private $filename_css_ignore            =   FALSE;
            private $content_css_ignore             =   FALSE;
            
            private $replacement_list_relative      =   array();
            
            //Used for different variables, within callbacks functions
            private $internals                      =   array();
           
            
            function get_component_title()
                {
                    return "CSS Combine";
                }
                                        
            function get_module_component_settings()
                {
                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'css_combine_code',
                                                                    'label'         =>  __('CSS Processing type',    'wp-hide-security-enhancer'),
                                                                    'description'   =>   __('All assets and inline CSS will be post-processed, using Combine or In-place technique.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'help'          =>  array(
                                                                                                        'title'                     =>  __('Help',    'wp-hide-security-enhancer') . ' - ' . __('CSS Combine Code',    'wp-hide-security-enhancer'),
                                                                                                        'description'               =>  __('If the site use a plugin (e.g. cache plugin) to concatenate/compress CSS files, this functionality may fail.', 'wp-hide-security-enhancer') .
                                                                                                                                        "<br /><br />" . __("The module implement a post-processing engine, to provide additional functionality on Cascading Style Sheet data type as Replacements.",    'wp-hide-security-enhancer') .
                                                                                                                                        "<br />&nbsp;".
                                                                                                                                        "<br /><br />" . __("There are two types of processing options:",    'wp-hide-security-enhancer').
                                                                                                                                        "<br />" . __("<b>Combine</b>: Merge all CSS code in (usually) 2 files, one in the header and another in the footer.",    'wp-hide-security-enhancer').
                                                                                                                                        "<br />" . __("<b>In Place</b>: All CSS code will be processed and the results will be left in the same spot as an initial asset or in-line CSS. ",    'wp-hide-security-enhancer').
                                                                                                                                        "<br />&nbsp;".
                                                                                                                                        "<br />" . __("This also improves the overal site loading speed and SEO score",    'wp-hide-security-enhancer'),
                                                                                                        'option_documentation_url'  =>  'https://www.wp-hide.com/documentation/html-css-js-replacements/'
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
                                                                    'id'            =>  'combined_css_remove_comments',
                                                                    'label'         =>  __('Remove Comments',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Remove all Comments from combined css files.', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'help'          =>  array(
                                                                                                        'title'                     =>  __('Help',    'wp-hide-security-enhancer') . ' - ' . __('Remove Comments',    'wp-hide-security-enhancer'),
                                                                                                        'description'               =>  __('This option require CSS Combine Code to be active.', 'wp-hide-security-enhancer') .
                                                                                                                                        "<br /><br />" . __("Remove all Comments from combined css files, which usualy specify Theme and Plugins Name and Version.",    'wp-hide-security-enhancer'),
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
                                                                    'id'            =>  'combined_css_minify',
                                                                    'label'         =>  __('Minify',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  __('Minify the combined css files. ', 'wp-hide-security-enhancer'),
                                                                    
                                                                    'help'          =>  array(
                                                                                                        'title'                     =>  __('Help',    'wp-hide-security-enhancer') . ' - ' . __('Minify',    'wp-hide-security-enhancer'),
                                                                                                        'description'               =>  __('This option require CSS Combine Code to be active.', 'wp-hide-security-enhancer') .
                                                                                                                                        "<br /><br />" . __("Minify the Cascading Style Sheet data for smaller files. This slighlty increase the overal site speed.",    'wp-hide-security-enhancer'),
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
                                                                    'id'            =>  'css_combine_excludes',
                                                                    'label'         =>  __('Exclude style files from CSS Combine',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  '',
                                                                    
                                                                    'help'          =>  array(
                                                                                                'title'                     =>  '',
                                                                                                'description'               =>  __('Specify any style files which will be excluded when using CSS Combine.', 'wp-hide-security-enhancer') . "<br /><br />" .__('Use only style filename and relative path e.g. <code>mediaelement.css</code>, <code>plugin-slug/player.min.css</code>  one per row.', 'wp-hide-security-enhancer'),
                                                                                                'option_documentation_url'  =>  'https://www.wp-hide.com/documentation/html-css-js-replacements/'
                                                                                                ),
                                                                                                
                                                                    'interface_help_split'  =>  FALSE,
                                                                    
                                                                    'input_type'    =>  'textarea',
                                                                    'default_value' =>  '',
                                                                    
                                                                    'sanitize_type' =>  array(),
                                                                    'processing_order'  =>  70
                                                                    );
                                                                    
                    $this->component_settings[]                  =   array(
                                                                    'id'            =>  'css_combine_block_excludes',
                                                                    'label'         =>  __('Exclude CSS Block from Combine',    'wp-hide-security-enhancer'),
                                                                    'description'   =>  '',
                                                                    
                                                                    
                                                                    'help'          =>  array(
                                                                                                'title'                     =>  '',
                                                                                                'description'               =>  __('Specify partial CSS code block to be excluded from Combine.', 'wp-hide-security-enhancer')      .   "<br /><br />"  .   __('Use a full line or part of it to avoid matching other codes, avoid simple words which can match other CSS code. For inline styles, tag attributes can be used.', 'wp-hide-security-enhancer'),
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
                
                
                
            function _init_css_combine_code (   $saved_field_data   )
                {
                    if(empty($saved_field_data) ||  $saved_field_data   ==  'no')
                        return FALSE;
                    
                    if( defined('WP_ADMIN') &&  ( !defined('DOING_AJAX') ||  ( defined('DOING_AJAX') && DOING_AJAX === FALSE )) && ! apply_filters('wph/components/force_run_on_admin', FALSE, 'css_combine_code' ) )
                        return;
                    
                    if  ( defined( 'DOING_CRON' )  )
                        return;
                        
                    if( $this->wph->functions->is_theme_customize() )
                        return;
 
                    if ( ! apply_filters('wph/components/css_combine_code', TRUE ) )
                        return;
                        
                    add_filter('wp-hide/ob_start_callback/pre_replacements', array($this, '_css_process_html'));                    
                }
                
                
                
            /**
            * Extract required data from buffer
            * 
            * @param mixed $buffer
            */
            function _css_process_html( $buffer )
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
                        
                    //split yhr buffer
                    list( $header_content, $body_content )    =   preg_split('/<body/i', $modified_buffer);
                    
                    if (    empty($header_content)  ||  empty ( $body_content ) )
                        return $buffer;
                    
                    $this->current_placeholder  =   'header';
                    $this->placeholders[ $this->current_placeholder ]   =   array();
                    $this->buffer               =   $header_content;    
                    $this->buffer               =   preg_replace_callback( '/<link([^>]*(href=[\"\']((https?:)?\/\/(www\.)?[\w\-\@\:\;\%\.\/\_\+\~\#\=\?\&]{2,256}\.[a-z]{2,6}\b([\w\-\@\:\;\%\.\/\_\+\~\#\=\?\&]*))[\"\'])[^>]*>)/mi' ,array($this, 'add_css_placeholders_callback') , $this->buffer);
                    $this->buffer               =   preg_replace_callback( '/<(no)?script>.*?<\/(no)?script>(*SKIP)(*FAIL)|<style[^>]*>([^<]+)?<[\s\/]+style>/is' ,array($this, 'add_css_placeholders_callback') , $this->buffer);
                    
                    $this->placeholders_reindex();
                    
                    $css_recipient_content       =   $this->placeholders_process();
                    $status                     =   $this->write_to_cache( $css_recipient_content );
                    if  ( $status === FALSE )
                        return $buffer;
                    $this->placeholders_postprocess();
                    $this->content_replace_placeholders( );
                    $header_content             =   $this->buffer;
                    
                    
                    $this->current_placeholder  =   'footer'; 
                    $this->placeholders[ $this->current_placeholder ]   =   array();   
                    $this->buffer               =   $body_content;    
                    $this->buffer               =   preg_replace_callback( '/<link([^>]*(href=[\"\']((https?:)?\/\/(www\.)?[\w\-\@\:\;\%\.\/\_\+\~\#\=\?\&]{2,256}\.[a-z]{2,6}\b([\w\-\@\:\;\%\.\/\_\+\~\#\=\?\&]*))[\"\'])[^>]*>)/mi' ,array($this, 'add_css_placeholders_callback') , $this->buffer);
                    $this->buffer               =   preg_replace_callback( '/<(no)?script>.*?<\/(no)?script>(*SKIP)(*FAIL)|<style[^>]*>([^<]+)?<[\s\/]+style>/is' ,array($this, 'add_css_placeholders_callback') , $this->buffer);
                   
                    $this->placeholders_reindex();
                    
                    $css_recipient_content       =   $this->placeholders_process();
                    $status                     =   $this->write_to_cache( $css_recipient_content );
                    if  ( $status === FALSE )
                        return $buffer;
                    $this->placeholders_postprocess();
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
            * Extract all CSS
            *                 
            * @param mixed $match
            */
            function add_css_placeholders_callback( $match )
                {
                    
                    $match_block    =   $match[0];
                    
                    $placeholder    =   $this->placeholder_hash . '-css-' . count( $this->placeholders[ $this->current_placeholder ] ) . '%';
                    $this->placeholders[ $this->current_placeholder ][ $placeholder ] =   preg_replace('/\n(\s*\n){2,}/', "\n\n", trim($match_block) );
                    
                    return $placeholder;
                    
                }
                
            
            /**
            * Re-index the placeholders accordingly to order in the buffer
            * 
            */
            function placeholders_reindex ()
                {
                    
                    $founds =   preg_match_all( '/\%WPH-PLACEHOLDER-REPLACEMENT-css-([0-9]+)\%/', $this->buffer, $matches );
                    if  ( $founds < 1 )
                        return;
                        
                    $placeholders   =   array();
                    
                    foreach  ( $matches[0]    as  $key    =>  $tag_hash )
                        {
                            
                              $placeholders[$tag_hash]  =   $this->placeholders[ $this->current_placeholder ][$tag_hash];
                        }
                    
                    
                    $this->placeholders[ $this->current_placeholder ]   =   $placeholders;
                    
                }
            
            
            /**
            * Process the placeholders
            * 
            */
            function placeholders_process()
                {
                       
                    $css_recipient_content   =   array();
                    
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

                            $element_tag        =   $doc->getElementsByTagName('link')->length  >   0   ?   'link'   :   'style';
                            $element            =   $doc->getElementsByTagName( $element_tag );
                            $element_media      =   $element[0]->getAttribute('media');
                            
                            $element_rel        =   $element[0]->getAttribute('rel');
                            
                            if ( $element_tag   ==  'link'  &&  $element_rel !=    'stylesheet' )
                                continue;
                            
                            if  ( $element_tag  ==   'link'  &&  empty ( $element_media ) )
                                $element_media  =   'all';
                            
                            switch ( $element_tag   )
                                {
                                    
                                    case 'link' :
                                                    
                                                    if  ( empty ( $element_media ) )
                                                        {
                                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'non-css';
                                                            continue 2;
                                                        }
                                                        
                                                    if ( ! in_array( $element_media, array(  'all', 'screen' )) &&  preg_match('/(and|not|only)?\s(all|print|screen|speech)/i', $element_media )    === FALSE )
                                                        {
                                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'non-css';
                                                            continue 2;
                                                        }
                                                        
                                                    $_add_media_query   =   in_array( $element_media, array(  'all', 'screen' ))    ?   FALSE   :   TRUE;
                                                    
                                                    $element_href           =   $element[0]->getAttribute('href');
                                                    
                                                    //check if the resource is on local
                                                    $resurce_url_parsed =   parse_url( $element_href );
                                                                                        
                                                    if ( $local_url_parsed['host']  !=  $resurce_url_parsed['host'] &&  $use_cdn    !=  $resurce_url_parsed['host'] )
                                                        {
                                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'remote-file-css';
                                                            continue 2;
                                                        }
                                                        
                                                    //check for href ignore
                                                    if  ( $this->_css_file_ignore_check( $element_href )     ||  strpos( $element_href, '/cache/wph/')   !== FALSE  ||  apply_filters( 'wp-hide/module/general_css_combine/ignore_file', FALSE, $element_href ))
                                                        {
                                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'ignore-local-file-css';
                                                            continue 2;   
                                                        }
                                                    
                                                    $resurce_path   =   $resurce_url_parsed['path'];
                                                    if  ( is_multisite() &&  $this->wph->default_variables['network']['current_blog_path']  !=  '/' )
                                                        {
                                                            $resurce_path   =   preg_replace("/^". preg_quote( $this->wph->default_variables['network']['current_blog_path'], '/' ) ."/i", $this->wph->default_variables['site_relative_path'] , $resurce_url_parsed['path']);
                                                            if ( strpos($resurce_path, "/") !== 0 )
                                                                $resurce_path   =   '/' .   $resurce_path;
                                                        }
                                                        
                                                    //attempt to retrieve the file locally
                                                    $local_file_path    =   urldecode( $document_root .    $resurce_path );
                                                    if ( !  file_exists ( $local_file_path ) )
                                                        {
                                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'local-not-found-file-css';
                                                            continue 2;
                                                        }
                                                        
                                                    $resurce_url_file_info =   pathinfo( $resurce_path );
                                                    if  ( ! isset($resurce_url_file_info['extension'])  ||  $resurce_url_file_info['extension'] !=  'css')
                                                        {
                                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'local-no-css-file';
                                                            continue 2;
                                                        }
                                                    
                                                    $local_file_content =   @file_get_contents ( $local_file_path );
                                                    
                                                    if ( $local_file_content    === FALSE )
                                                        continue 2;
                                                    
                                                    $ignore =   apply_filters('wp-hide/module/general_css_variables_replace/placeholder_ignore_css', FALSE, $local_file_content, $element_href);
                                                    
                                                    //check for css content ignore
                                                    if  ( $this->_css_content_ignore_check( $local_file_content )  )
                                                        $ignore =   TRUE;
                                                        
                                                    if  ( $ignore  )
                                                        {
                                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'ignore-local-file-css';
                                                            continue 2;   
                                                        }
                                                                                  
                                                    /*
                                                    $founds =   preg_match_all('/(?:url\s?\(\s?|<(?:link|script|img)[^>]+(?:src|href)\s*=\s*)(?![\'\"]?(?:data|\/\/|http))[\'\"]?([^\'\"\)\s>]+)/im', $local_file_content, $matches );
                                                    if  ( $founds   >   0   )
                                                        {
                                                            //keep a map of replacements to avoid replacing part of urls which are similar
                                                            $replace_map    =   array();
                                                            foreach ( $matches[1]   as  $item_match )
                                                                {
                                                                    $address    =   trailingslashit($resource_url_path)  .   ltrim( $item_match, '/' );   
                                                                    $address = explode('/', $address);
                                                                    $keys = array_keys($address, '..');

                                                                    foreach($keys AS $keypos => $key)
                                                                        array_splice($address, $key - ($keypos * 2 + 1), 2);

                                                                    $address = implode('/', $address);
                                                                    $address = str_replace('./', '', $address);
                                                                    
                                                                    $hash   =   md5($item_match);
                                                                    $replace_map[ $hash ]    =   $address;
                                                                    
                                                                    //do the replaement
                                                                    $local_file_content =   str_replace( $item_match, $this->placeholder_hash . $hash , $local_file_content);
                                                                }
                                                                
                                                            //apply the replacements
                                                            foreach ($replace_map   as  $key    =>  $replacement)
                                                                {
                                                                    $local_file_content =   str_replace( $this->placeholder_hash . $key, $replacement , $local_file_content);
                                                                }
                                                        }
                                                    */
                                                        
                                                    $local_file_content =   $this->_convert_relative_urls ( $local_file_content, $element_href ); 
                                                        
                                                    $local_file_content =   apply_filters( 'wp-hide/module/general_css_combine/placeholders_process/element_content', $local_file_content, $local_file_path );
              
                                                    if  ( ! $_add_media_query )
                                                        $css_recipient_content[$placeholder]   =  "\n"  .  $local_file_content;
                                                        else
                                                        $css_recipient_content[$placeholder]   =  "\n @media " .$element_media ." {"  .  $local_file_content . " }";
                                                    
                                                    if ( !empty ( $use_cdn )    &&  $use_cdn    ==  $resurce_url_parsed['host'] )
                                                        $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'cdn-local-file-css';
                                                        else
                                                        $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'local-file-css';
                                                    
                                                    break;   
                                    
                                    case 'style' :
                                                    
                                                    if  ( !empty ( $element_media )  &&  $element_media  ==  'print')
                                                        {
                                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'ignore-inline-css';
                                                            continue 2;
                                                        }
                                                    
                                                    
                                                    $element_content    =   $element[0]->nodeValue;
                                                    
                                                    $ignore =   apply_filters('wp-hide/module/general_css_variables_replace/placeholder_ignore_css', FALSE, $code_block, 'inline' );
                                                    
                                                    if  ( $this->_css_content_ignore_check( $code_block ) )
                                                        $ignore =   TRUE;    
                                    
                                                    if ( $ignore )
                                                        {
                                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'ignore-inline-css';   
                                                        }
                                                        else
                                                        {
                                                            
                                                            //Allow pre-processing 
                                                            $element_content =    apply_filters( 'wp-hide/module/general_css_combine/placeholders_process/element_content', $element_content, FALSE );
                                                                                                                        
                                                            $css_recipient_content[$placeholder]   =  "\n"  .  $element_content;
                                                         
                                                            $this->placeholders_map[ $this->current_placeholder ][$placeholder] =   'inline-css';
                                                        }
                                                    
                                                    break;
                                    
                                }

                        }
                        
                    libxml_clear_errors();
                    
                    $css_recipient_content  =   apply_filters( 'wp-hide/module/general_css_combine/placeholders_process/css_recipient_content', $css_recipient_content );
                    
                    return $css_recipient_content;
                    
                }
            
            
            function _convert_relative_urls( $local_file_content, $resource_path    =   FALSE )
                {
                    if ( ! empty  ( $resource_path ) )
                        $this->internals['resource_url_path']   =   dirname( $resource_path );
                    $this->internals['site_url_parsed']     =   parse_url (site_url() );
                       
                    $local_file_content =   preg_replace_callback( '/(?:url\s?\(\s?)(?![\'\"]?(?:data:|\/\/|http))[\'\"]?([^\'\"\)\s]+)/im' ,array($this, '_convert_relative_urls_callback') , $local_file_content );    
                    
                    $this->internals['resource_url_path']   =   '';
                    
                    return $local_file_content;
                }
            
            
            /**
            * Convert relative urls to absolute
            * e.g. ../images/image.jpg
            * or  /wp-contnet/themes/default/image.jpg
            * 
            * @param mixed $match
            */
            function _convert_relative_urls_callback( $match )
                {
                    $match_block    =   $match[0];
                    
                    //check if relative to domain
                    if ( strpos ( $match[1], '/' ) === 0 )
                        $address    =   '//' . trailingslashit( $this->internals['site_url_parsed']['host'] )  .   ltrim( $match[1], '/' );
                        else 
                        {
                            //if there is no path specified, then return as is
                            if ( empty ( $this->internals['resource_url_path'] ) )
                                return $match_block;    
                            $address    =   trailingslashit( $this->internals['resource_url_path'] )  .   ltrim( $match[1], '/' );
                        }
                    
                    $address = explode('/', $address);
                    $keys = array_keys($address, '..');

                    foreach($keys as $keypos => $key)
                        array_splice($address, $key - ($keypos * 2 + 1), 2);

                    $address = implode('/', $address);
                    $address = str_replace('./', '', $address);
                    
                    $match_block    =   str_replace( $match[1], $address, $match_block );
                    
                    return $match_block;                    
                }
            
            
            /**
            * Write the $css_recipient_content to cache
            * 
            * @param mixed $css_recipient_content
            */
            function write_to_cache( $css_recipient_content )
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
                        
                    $inserted_css_cache   =   FALSE;
                    $css_content =   '';
                    
                    $css_combine_code   =   $this->wph->functions->get_site_module_saved_value('css_combine_code',  $this->wph->functions->get_blog_id_setting_to_use());   
                    
                    foreach ( $this->placeholders[ $this->current_placeholder ]   as  $placeholder    =>  $code_block )
                        {
                            if  ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "non-css" ) ) )
                                continue;
                            
                            if  ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "inline-css", "local-file-css", "cdn-local-file-css" ) ) )
                                {
                                    if ( $css_combine_code ==   'yes' )
                                        {
                                            $css_content .=    '#! WPH-CSS-Content-Start' . "\n";
                                            $css_content .=  $this->_debug( $placeholder );
                                            $css_content .=  $css_recipient_content[$placeholder] ."\n";
                                            $this->placeholders[ $this->current_placeholder ][$placeholder]   =   '';
                                        }
                                        else
                                        {
                                            $css_content =    '#! WPH-CSS-Content-Start' . "\n";
                                            $css_content .=  $this->_debug( $placeholder );
                                            $css_content .=  $css_recipient_content[$placeholder] ."\n";
                                            
                                            //in-place
                                            $file_url   =   $this->write_file( $css_content );
                                            if  (   $file_url   === FALSE )
                                                return FALSE;
                                                
                                            if  (   ! empty ( $CDN_url )    &&  $cdn_use_for_cache_files  ==  'yes'   )
                                                $file_url   =   str_ireplace(   $home_url_parsed['host'],   $CDN_url, $file_url );
                                            
                                            $this->placeholders[ $this->current_placeholder ][ $placeholder ]   =   "<link rel='stylesheet' href='". $file_url   ."' media='all' />";    
                                        }
                                }
                                else  if    (   $css_combine_code ==   'yes'    &&  in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "remote-file-css", "local-no-css-file", "ignore-local-file-css", "local-not-found-file-css" ) )    &&  ! empty ( $css_content ) )
                                {
                                         
                                    $file_url   =   $this->write_file( $css_content );
                                    if  (   $file_url   === FALSE )
                                        return FALSE;
                                        
                                    //check if using CDN with url replace for cached files
                                    if  (   ! empty ( $CDN_url )    &&  $cdn_use_for_cache_files  ==  'yes'   )
                                        $file_url   =   str_ireplace(   $home_url_parsed['host'],   $CDN_url, $file_url );
                                    
                                    $this->placeholders[ $this->current_placeholder ][ $placeholder ]   =   "<link rel='stylesheet' href='". $file_url   ."' media='all' />"  .   $this->placeholders[ $this->current_placeholder ][ $placeholder ];
                                    
                                    $inserted_css_cache =   TRUE;    
                                    $css_content =   '';
                                }
                        }
                        
                    if  (  $css_combine_code ==   'yes'  &&     ! empty ( $css_content ) )
                        {
                                               
                            //add insert for the last css block
                            $placeholder    =   $this->content_last_placeholder( TRUE );
                            
                            $file_url   =   $this->write_file( $css_content );
                            if  (   $file_url   === FALSE )
                                return FALSE;
                                
                            //check if using CDN with url replace for cached files
                            if  (   ! empty ( $CDN_url )    &&  $cdn_use_for_cache_files  ==  'yes'   )
                                $file_url   =   str_ireplace(   $home_url_parsed['host'],   $CDN_url, $file_url );
                            
                            $this->placeholders[ $this->current_placeholder ][ $placeholder ]   =   "<link rel='stylesheet' href='". $file_url   ."' media='all' />";
                                
                            $css_content =   '';
                        }
                    
                }
            
            
            /**
            * Write the css content and to the replacements
            * 
            * @param mixed $filename_path
            * @param mixed $content
            */
            function write_file( $css_content )
                {
                    global $wp_filesystem;
                    
                    //explode the blocks
                    $css_content_blocks  =   explode('#! WPH-CSS-Content-Start', $css_content );
                    $css_content_blocks  =   array_map("trim", $css_content_blocks);
       
                    $css_content =   '';
       
                    foreach ( $css_content_blocks    as $key =>  $css_content_block )
                        {
                            if  (  empty ( $css_content_block ) )
                                continue;
                            
                            $hash   =   md5 ( $css_content_block ); 
                            
                            $file_path  =   WPH_CACHE_PATH  .   'block_' . $this->settings_hash . '_' . $hash   .'.css';
                            
                            //if block already processed, just load it
                            if ( file_exists ( $file_path ) )
                                {
                                    $css_content .=  "\n" .  $wp_filesystem->get_contents( $file_path ) ;                                            
                                    continue;   
                                }
                                
                            $css_content_block   =   $this->css_recipient_process( $css_content_block, TRUE );
                            
                            
                            //write the file for later usage
                            $wp_filesystem->put_contents( $file_path, $css_content_block, FS_CHMOD_FILE );
                                                      
                            //do the replcaements
                            $css_content .=   "\n" . $css_content_block;  
                            
                        }
                                            
                    $hash   =   md5 ( $css_content );
                                    
                    $file_path  =   WPH_CACHE_PATH  .   $this->settings_hash . '_' .   $hash   .'.css';
                    $file_url   =   WPH_CACHE_URL   .   $this->settings_hash . '_' .   $hash   .'.css';
                    
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

                            $data_length = strlen( $css_content );

                            $bytes_written = fwrite( $fp, $css_content );

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
            * @param mixed $css_recipient_content
            */
            function css_recipient_process( $css_content, $internal =   FALSE )
                {
                    
                    $html_css_js_replacements   =   $this->wph->functions->get_site_module_saved_value('html_css_js_replacements',   $this->wph->functions->get_blog_id_setting_to_use());
                    
                    if  ( is_array( $html_css_js_replacements )   &&  count ( $html_css_js_replacements ) > 0 )
                        $css_content                =   $this->wph->regex_processor->do_replacements( $css_content, $html_css_js_replacements, 'css' );
                        
                    $css_content                =   $this->_process_url_replacements( $css_content, $internal );
                    
                    //check for stripp out comments
                    $values =   $this->wph->functions->get_site_module_saved_value('combined_css_remove_comments',  $this->wph->functions->get_blog_id_setting_to_use());
                    if  ( $values   ==  'yes'   )
                        $css_content    =   $this->strip_comments( $css_content );
                        
                    //check for minify
                    $values =   $this->wph->functions->get_site_module_saved_value('combined_css_minify',  $this->wph->functions->get_blog_id_setting_to_use());
                    if  ( $values   ==  'yes'   )
                        $css_content    =   $this->minify( $css_content );
                    
                    return $css_content;    
                }
                
            
            /**
            * Do url replacements
            *     
            * @param mixed $js_content
            */    
            function _process_url_replacements( $css_content, $internal = FALSE )
                {
                    //If internally, the conversion already occoured
                    if ( ! $internal )
                        $css_content    =   $this->_convert_relative_urls ( $css_content );    
                    
                    
                    //apply the urs replacements
                    $replacement_list       =   $this->wph->functions->get_replacement_list();
                   
                    //replace the urls
                    $css_content            =   $this->wph->functions->content_urls_replacement($css_content,  $replacement_list );
                    
                    
                    /*
                    //replace relative urls
                    $local_url_parsed   =   parse_url( home_url() );
                    foreach( $replacement_list as   $replace    =>  $replacement )
                        {
                            $replace        =   str_replace( array( "http://", "https://" ), "", $replace );
                            $replace        =   str_replace( $local_url_parsed['host'], "", $replace );
                            $replacement    =   str_replace( array( "http://", "https://" ), "", $replacement );
                            $replacement    =   str_replace( $local_url_parsed['host'], "", $replacement );
                            
                            $this->replacement_list_relative[ $replace ]  =   $replacement;       
                        }
                    //change all slugs for local urls
                    $css_content               =   preg_replace_callback( '/(?:url(?:[\s]+)?\()([^)]*)\)/i' ,array($this, '_relative_to_absolute_url') , $css_content);
                    */                                        
                                                            
                    //Custom urls map
                    $WPH_module_rewrite_map_custom_urls =   new WPH_module_rewrite_map_custom_urls();
                    $css_content                        =    $WPH_module_rewrite_map_custom_urls->_do_html_replacements( $css_content );
                    
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
                            
                            $css_content        =   str_ireplace(   'http://' . $home_url_parsed['host'],   'http://' . $CDN_url, $css_content );
                            $css_content        =   str_ireplace(   'https://' . $home_url_parsed['host'],  'https://' .  $CDN_url, $css_content );
                        }
                    
                    return $css_content;
                    
                }
                
            /*    
            function _relative_to_absolute_url( $match )
                {
                    $match_block    =   $match[0];
                    
                    $match_url      =   $match[1];
                    $match_url      =   trim( $match_url );
                    
                    if ( preg_match( "/data\:/i", $match_url ) !==   0 )
                        return $match_block;
                    
                    $quote_type     =   strpos( $match_url, '"' ) === 0 ?   '"' :   FALSE;
                    if ( $quote_type ===    FALSE  )
                        $quote_type     =   strpos( $match_url, "'" ) === 0 ?   "'" :   FALSE;
                    
                    $match_url  =   trim( $match_url, '\'"' );
                    
                    //check if local url
                    preg_match ( '/(?:https?:)?\/\/((?:www\.)?[\w\-\@\:\;\%\.\_\+]{2,256}\.[a-z]{2,6})/i', $match_url, $domain_match );
                    
                    $domain =   $domain_match[1];
                    if ( empty ( $domain ) )
                        return $match_block;
                    
                    $instance_domains   =   $this->wph->functions->get_instance_domains();
                    
                    //if not local domain don't cahnge anything
                    if  ( array_search( $domain, $instance_domains ) ===    FALSE )
                        return $match_block;
                    
                    $match_url    =   str_ireplace(    array_keys( $this->replacement_list_relative ), array_values( $this->replacement_list_relative )  , $match_url  );
                    
                    $match_block    =   str_replace( $match[1], $match_url, $match_block );
                                          
                    return $match_block;   
                }
            */
            
            /**
            * Add a placeholder for the last css code to be inserted
            * 
            * @param mixed $content
            */
            function content_last_placeholder( $inserted_css_cache )
                {
                    $insert_above_tag    =   '';
                    
                    $placeholder    =   $this->placeholder_hash . '-css-' . count( $this->placeholders[ $this->current_placeholder ] ) . '%';
                    $this->placeholders[ $this->current_placeholder ][ $placeholder ] =   '';
                    
                    switch ($this->current_placeholder)
                        {
                            case    'header'   :
                                                                $insert_above_tag   =   '';
                                                                
                                                                if ( $inserted_css_cache )
                                                                    $insert_above_tag   =   'head';
                                                                    else
                                                                    {
                                                                        //put the style file higher in html to allow styling to show early in oage
                                                                        foreach ( $this->placeholders_map[ 'header' ] as $_placeholder   =>  $block_type )
                                                                            {
                                                                                if ( in_array( $this->placeholders_map[ 'header' ][ $_placeholder ], array( "inline-css", "local-file-css", "cdn-local-file-css" ) )  )
                                                                                    {
                                                                                        $insert_above_tag   =   $_placeholder;
                                                                                        break;
                                                                                    }        
                                                                            }
                                                                        
                                                                        if  ( ! empty ( $insert_above_tag ) ) 
                                                                            {
                                                                                list( $first_part, $seccond_part )    =   preg_split('/'    .   $insert_above_tag   .'/i', $this->buffer); 
                                                                                $this->buffer    =   $first_part . $placeholder  .   $seccond_part;
                    
                                                                                return $placeholder;   
                                                                            }
                                                                            else
                                                                            $insert_above_tag   =   'body';   
                                                                    }
                                                                
                                                                break;
                                                                
                            case    'footer'   :
                                                                $insert_above_tag   =   'body';
                                                                break;
                        }
                        
                    list( $first_part, $seccond_part )    =   preg_split('/<\/'    .   $insert_above_tag   .'>/i', $this->buffer);   
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
                             $this->buffer  =   str_replace($placeholder, $code_block, $this->buffer);   
                        }
            
                }
                
                
            
            /**
            * Do HTML ID's replacements
            *     
            */
            function _do_html_id_replacements( $buffer )
                {
                    
                    $values =   $this->wph->functions->get_site_module_saved_value('css_id_replace',  $this->wph->functions->get_blog_id_setting_to_use());
                    
                    if ( ! is_array($values)    ||  count($values)  <   1   )
                        return $buffer;
                    
                    foreach( $values    as  $value_block )
                        {
                            $this->text_replacement_pair  =   $value_block;
                            $buffer   =   preg_replace('/(.*id(?:\s+)?=(?:\s+)?[\'"])('    .  $this->text_replacement_pair[0] .   ')([\'"].*)/m', '$1' . $this->text_replacement_pair[1] . '$3', $buffer);      
                        }   
                     
                    return $buffer;   
                    
                }
                
                
            /**
            * Do HTML class replacements
            *     
            */
            function _do_html_class_replacements( $buffer )
                {
                    
                    $values =   $this->wph->functions->get_site_module_saved_value('css_class_replace',  $this->wph->functions->get_blog_id_setting_to_use());
                    
                    if ( ! is_array($values)    ||  count($values)  <   1   )
                        return $buffer;
                    
                    //global
                    //  (?:class=[\'"]|(?!^)\G)\h*(?:([\w.-]*\bastra\b[\w.-]*)|[\w-]+)\b(?=[\w\h.-]*[\'"])
                    
                    $buffer   =     preg_replace_callback( '/(class(?:\s+)?=(?:\s+)?\\\?[\"|\'])([^"\'\\\]*)(\\\?[\"|\'])/im' ,array($this, '_do_html_class_replacements_callback') , $buffer);
                    //$buffer   =     preg_replace_callback( '/(class(?:\s+)?=(?:\s+)?[\"|\'])([^"\']*)([\"|\'])/im' ,array($this, '_do_html_class_replacements_callback') , $buffer);
                     
                    return $buffer;   
                    
                }
                
            
            function _do_html_class_replacements_callback( $match )
                {
                        
                    $values =   $this->wph->functions->get_site_module_saved_value('css_class_replace',  $this->wph->functions->get_blog_id_setting_to_use());  
                    
                    $classes    =   preg_split('/\s+/', $match[2]);
                    
                    foreach( $values    as  $value_block )
                        {
                            $this->text_replacement_pair  =   $value_block;
                            $find_me        =   $this->text_replacement_pair[0];
                            $replacement    =   $this->text_replacement_pair[1];
                            
                           
                            $global_match   =   FALSE;
                            $regex_data     =   '';
                            
                            if ( strpos($find_me, '*') === 0    ||  strrpos($find_me, '*') == strlen($find_me) - 1 )
                                $global_match   =   TRUE;
                                
                            if ( $global_match )
                                {
                                    $find_me    =   ltrim($find_me, '*');
                                    $find_me    =   rtrim($find_me, '*');
                                    
                                    $this->text_replacement_pair[0] =   $find_me;
                                    
                                    $regex_data =   '^(?:([a-zA-Z0-9-_]+[-_]+)?('. $find_me .')(?![^\W_])([a-zA-Z0-9-_]+)?)\w*';        
                                }
                                else
                                {
                                    $regex_data =   '^()('. $find_me .')$';
                                }    
                           
                           
                            $founds =   preg_grep ('/'. $regex_data .'/i', $classes);
                            if  ( is_array( $founds )   &&  count ( $founds )   >   0 )
                                {
                                    foreach ( $founds as  $key  =>  $found )
                                        {
                                            preg_match ('/'. $regex_data .'/i', $found, $el_match );
                                            if  ( is_array( $el_match ) &&  count ( $el_match )   >   0 )
                                                {
                                                    $return         =   isset ( $el_match[1] ) ?     $el_match[1] :   '';
                                                    $return         .=   $replacement;
                                                    $return         .=   isset ( $el_match[3] ) ?     $el_match[3] :   '';
                                                        
                                                    $classes[$key]  =   $return;
                                                }
                                        }
                                }
                        }
                        
                    $replacer    =   $match[1]  .   implode ( " " , $classes)   .   $match[3];
                    
                    return $replacer;
                    
                }

                
  
            /**
            * Strip comments 
            * 
            * @param mixed $buffer
            */
            function strip_comments( $css_content )
                {
                    if ( defined( 'WPH_DEBUG' ) &&  WPH_DEBUG   === TRUE )
                        return $css_content;
                            
                    $regex = array(
                                    "`^([\t\s]+)`ism"                       =>  "",
                                    "`\/\*(.+?)\*\/`ism"                   =>  "",
                                    "`([\n;]+)\/\*(.+?)\*\/`ism"            =>  "$1",
                                    "`(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+`ism" =>  "\n"
                                    );
                    $css_content = preg_replace(    array_keys($regex), $regex, $css_content    );   
                    
                    return $css_content;
                    
                }
                
                
            
            function minify ( $css_content )
                {
                    if ( defined( 'WPH_DEBUG' ) &&  WPH_DEBUG   === TRUE )
                        return $css_content;
                            
                    $css_content = str_replace(array("\r\n", "\r", "\n"), ' ', $css_content);

                    $css_content = str_replace('/\\t/g', ' ', $css_content);
                    
                    $css_content = str_replace('/\s\s+/g', ' ', $css_content);
                    
                    return $css_content;
                       
                }
                
                
            /**
            * Return the styles to exclude from css combine
            *     
            */
            function _get_css_combine_excludes()
                {
                    
                    $values =   $this->wph->functions->get_site_module_saved_value( 'css_combine_excludes',  $this->wph->functions->get_blog_id_setting_to_use() );
                    
                    $values =   trim( $values );
                    
                    $lines  =   preg_split ('/\r\n|\n|\r/', $values);
                    
                    $lines  =   array_filter($lines, 'trim');
                    $lines  =   array_filter($lines);
                    $lines  =   array_values($lines);
                    
                    return (array)$lines;
                    
                }
                
                
            function _css_file_ignore_check ( $element_href ) 
                {
                    if ( $this->filename_css_ignore === FALSE )
                        $this->filename_css_ignore    =   $this->_get_css_combine_excludes();
                           
                    if ( count ( $this->filename_css_ignore ) < 1 )
                        return FALSE;
                                                                
                    //check if in the ignore list
                    foreach ( $this->filename_css_ignore   as  $local_css_ignore_item )
                        {
                            if (strpos($element_href , $local_css_ignore_item ) !==   FALSE )
                                {
                                    return TRUE;
                                }   
                        }   
                    
                    return FALSE;
                    
                }
                
            
            function _css_content_ignore_check( $element_content )
                {
                    if ( $this->content_css_ignore === FALSE )
                        {
                            $this->content_css_ignore    =   (array)$this->wph->functions->get_site_module_saved_value('css_combine_block_excludes',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                            $this->content_css_ignore    =   array_filter( $this->content_css_ignore, 'trim');
                            $this->content_css_ignore    =   array_filter( $this->content_css_ignore);
                            
                            if  ( count ( $this->content_css_ignore ) < 1 )
                                return FALSE;
                            
                            //replace all new lines
                            foreach ( $this->content_css_ignore as   $key    =>  $value )
                                {
                                    $value  =   preg_quote( $value );
                                    $value  =   preg_split('/\r\n|\n|\r/', $value);
                                    $value  =   array_map('trim', $value );
                                    $value  =   implode('([\s]+)?', $value);
                                    
                                    $this->content_css_ignore[ $key ]    =   $value;
                                }   
                            
                        }
                        
                    if  ( count ( $this->content_css_ignore ) < 1 )
                        return FALSE;
                    
                    foreach ( $this->content_css_ignore as   $value )
                        {
                            if ( preg_match( '/' . $value .'/' , $element_content))
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
                        <div class="irow"><textarea name="<?php echo $module_setting['id'] ?>[ignore_block][]" class="<?php echo $class ?>" placeholder="CSS code block to ignore" type="text"></textarea>  <a href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('.irow'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> </div>
                    </div>
                    <?php
                    
                    $values =   $this->wph->functions->get_site_module_saved_value('css_combine_block_excludes',  $this->wph->functions->get_blog_id_setting_to_use(), 'display');
                    
                    if ( ! is_array($values))
                        $values =   array();
                    
                    if ( count ( $values )  >   0 )
                        {
                            foreach ( $values   as  $block)
                                {
                                    ?>
                                    <div class="irow"><textarea name="<?php echo $module_setting['id'] ?>[ignore_block][]" class="<?php echo $class ?>" placeholder="CSS code block to ignore" type="text"><?php echo htmlspecialchars(stripslashes($block)) ?></textarea>  <a href="javascript: void(0);" onClick="WPH.replace_text_remove_row( jQuery(this).closest('.irow'))"><span alt="f335" class="close dashicons dashicons-no-alt">&nbsp;</span></a> </div>
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
                                        
                    $data       =   $_POST['css_combine_block_excludes'];
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
            * Stil process the ignored inline for urls (css mode) to replace relative
            *     
            * @param mixed $placeholders
            * @param mixed $placeholders_map
            * @param mixed $current_placeholder
            */
            function placeholders_postprocess ( )
                {
                    
                    if  ( ! is_array ( $this->placeholders_map ) || ! isset ( $this->placeholders_map [ $this->current_placeholder ] )  ||  ! is_array (  $this->placeholders_map [ $this->current_placeholder ] ) )  
                        return FALSE;
                    
                    foreach  ( $this->placeholders_map [ $this->current_placeholder ]   as  $mark   =>  $type )
                        {
                            if (    in_array ( $type, array ( "ignore-inline-css" ) ) )
                                {
                                    $this->placeholders [ $this->current_placeholder ][ $mark ] =   $this->_process_url_replacements( $this->placeholders [ $this->current_placeholder ][ $mark ] );    
                                    
                                }
                            
                        }
                       
                }
                
                
            function _debug ( $placeholder )
                {
                    if ( ! defined( 'WPH_DEBUG' ) ||  WPH_DEBUG   !== TRUE )
                        return;
                    
                    $css_content =   '';
                    
                    $css_content .=  '/* ------------------------' . "\n";;
                    $css_content .=  '#WPH_DEBUG - ' . $this->placeholders_map[ $this->current_placeholder ][$placeholder];
                    
                    if  ( in_array( $this->placeholders_map[ $this->current_placeholder ][$placeholder], array( "local-file-css", "cdn-local-file-css" ) ) )
                        {
                            preg_match('/href=\'([^\'\"}]*)\'/i', $this->placeholders[ $this->current_placeholder ][$placeholder], $founds );
                            if ( isset ( $founds[1] ) )
                                $css_content .=  " " . $founds[1];
                        }
                    
                    $css_content .=  " */ \n";
                    
                    return $css_content;
                    
                }
  
  
        }
?>