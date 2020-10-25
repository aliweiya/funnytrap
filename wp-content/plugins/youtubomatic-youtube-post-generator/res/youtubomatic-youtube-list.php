<?php
   $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
   $redirect = admin_url('admin.php?page=youtubomatic_youtube_panel&yt_auth_done=true');
   if(isset($_POST['youtubomatic_auth']) && isset($_REQUEST['page']) && $_REQUEST['page'] == 'youtubomatic_youtube_panel')
   {
       if(!isset($_SESSION)) 
       { 
           session_start();
       }
       try
       {
           require_once(dirname(__FILE__) . "/Google/vendor/autoload.php");
           $client = new Google_Client();
           $client->setClientId($youtubomatic_Main_Settings['oauth_key']);
           $client->setClientSecret($youtubomatic_Main_Settings['oauth_secret']);
           $client->setScopes('https://www.googleapis.com/auth/youtube');
           $client->setRedirectUri($redirect);
           $client->setAccessType('offline');
           $client->setApprovalPrompt('force');
           $state = mt_rand();
           $client->setState($state);
           $_SESSION['state'] = $state;
           $authUrl = $client->createAuthUrl();
           if(!function_exists('wp_redirect'))
           {
               include_once( ABSPATH . 'wp-includes/pluggable.php' );
           }
           wp_redirect($authUrl);
           die();
       }
       catch(Exception $e)
       {
           youtubomatic_log_to_file('Exception thrown in YouTube Auth auth stage 1: ' . $e->getMessage());
       }
   }  
   else
   {
       if (isset($_GET['code']) && isset($_REQUEST['page']) && $_REQUEST['page'] == 'youtubomatic_youtube_panel') 
       {
           if(!isset($_SESSION)) 
           { 
               session_start();
           }
           try
           {
               require_once(dirname(__FILE__) . "/Google/vendor/autoload.php");
               $client = new Google_Client();
               $client->setClientId($youtubomatic_Main_Settings['oauth_key']);
               $client->setClientSecret($youtubomatic_Main_Settings['oauth_secret']);
               $client->setScopes('https://www.googleapis.com/auth/youtube');
               $client->setRedirectUri($redirect);
               $client->setAccessType('offline');
               $client->setApprovalPrompt('force');
               {
                 if(!isset($_SESSION['state']) || !isset($_GET['state']))
                 {
                     throw new Exception('State variables not set.');
                 }
                 if (strval($_SESSION['state']) !== strval($_GET['state'])) {
                   throw new Exception('The session state did not match.');
                 }
                 $client->authenticate($_GET['code']);
                 $at = $client->getAccessToken();
                 if(!is_array($at) && youtubomatic_is_json($at))
                 {
                     $at = json_decode($at, true);
                 }
                 if(isset($at['refresh_token']))
                 {
                     update_option('youtubomatic_refresh_token', $at['refresh_token']);
                 }
                 if(isset($at['access_token']))
                 {
                     update_option('youtubomatic_access_token_auth_id', $youtubomatic_Main_Settings['oauth_key']);
                     update_option('youtubomatic_access_token_auth_secret', $youtubomatic_Main_Settings['oauth_secret']);
                     $at = json_encode($at);
                     update_option('youtubomatic_access_token_str', $at);
                     update_option('youtubomatic_need_reauth', 'false');
                 }
                 else
                 {
                     youtubomatic_log_to_file('No valid access token found: ' . print_r($at, true));
                     throw new Exception('No access token found.');
                 }
                 if(!function_exists('wp_redirect'))
                 {
                     include_once( ABSPATH . 'wp-includes/pluggable.php' );
                 }
                 wp_redirect($redirect);
                 die();
               }
           }
           catch(Exception $e)
           {
               youtubomatic_log_to_file('Exception thrown in YouTube Auth auth stage 2: ' . $e->getMessage());
           }
       }
   }
   function youtubomatic_youtube_panel()
   {
   $language_codes = array(
           'en' => 'English' , 
           'aa' => 'Afar' , 
           'ab' => 'Abkhazian' , 
           'af' => 'Afrikaans' , 
           'am' => 'Amharic' , 
           'ar' => 'Arabic' , 
           'as' => 'Assamese' , 
           'ay' => 'Aymara' , 
           'az' => 'Azerbaijani' , 
           'ba' => 'Bashkir' , 
           'be' => 'Byelorussian' , 
           'bg' => 'Bulgarian' , 
           'bh' => 'Bihari' , 
           'bi' => 'Bislama' , 
           'bn' => 'Bengali/Bangla' , 
           'bo' => 'Tibetan' , 
           'br' => 'Breton' , 
           'ca' => 'Catalan' , 
           'co' => 'Corsican' , 
           'cs' => 'Czech' , 
           'cy' => 'Welsh' , 
           'da' => 'Danish' , 
           'de' => 'German' , 
           'dz' => 'Bhutani' , 
           'el' => 'Greek' , 
           'eo' => 'Esperanto' , 
           'es' => 'Spanish' , 
           'et' => 'Estonian' , 
           'eu' => 'Basque' , 
           'fa' => 'Persian' , 
           'fi' => 'Finnish' , 
           'fj' => 'Fiji' , 
           'fo' => 'Faeroese' , 
           'fr' => 'French' , 
           'fy' => 'Frisian' , 
           'ga' => 'Irish' , 
           'gd' => 'Scots/Gaelic' , 
           'gl' => 'Galician' , 
           'gn' => 'Guarani' , 
           'gu' => 'Gujarati' , 
           'ha' => 'Hausa' , 
           'hi' => 'Hindi' , 
           'hr' => 'Croatian' , 
           'hu' => 'Hungarian' , 
           'hy' => 'Armenian' , 
           'ia' => 'Interlingua' , 
           'ie' => 'Interlingue' , 
           'ik' => 'Inupiak' , 
           'in' => 'Indonesian' , 
           'is' => 'Icelandic' , 
           'it' => 'Italian' , 
           'iw' => 'Hebrew' , 
           'ja' => 'Japanese' , 
           'ji' => 'Yiddish' , 
           'jw' => 'Javanese' , 
           'ka' => 'Georgian' , 
           'kk' => 'Kazakh' , 
           'kl' => 'Greenlandic' , 
           'km' => 'Cambodian' , 
           'kn' => 'Kannada' , 
           'ko' => 'Korean' , 
           'ks' => 'Kashmiri' , 
           'ku' => 'Kurdish' , 
           'ky' => 'Kirghiz' , 
           'la' => 'Latin' , 
           'ln' => 'Lingala' , 
           'lo' => 'Laothian' , 
           'lt' => 'Lithuanian' , 
           'lv' => 'Latvian/Lettish' , 
           'mg' => 'Malagasy' , 
           'mi' => 'Maori' , 
           'mk' => 'Macedonian' , 
           'ml' => 'Malayalam' , 
           'mn' => 'Mongolian' , 
           'mo' => 'Moldavian' , 
           'mr' => 'Marathi' , 
           'ms' => 'Malay' , 
           'mt' => 'Maltese' , 
           'my' => 'Burmese' , 
           'na' => 'Nauru' , 
           'ne' => 'Nepali' , 
           'nl' => 'Dutch' , 
           'no' => 'Norwegian' , 
           'oc' => 'Occitan' , 
           'om' => '(Afan)/Oromoor/Oriya' , 
           'pa' => 'Punjabi' , 
           'pl' => 'Polish' , 
           'ps' => 'Pashto/Pushto' , 
           'pt' => 'Portuguese' , 
           'qu' => 'Quechua' , 
           'rm' => 'Rhaeto-Romance' , 
           'rn' => 'Kirundi' , 
           'ro' => 'Romanian' , 
           'ru' => 'Russian' , 
           'rw' => 'Kinyarwanda' , 
           'sa' => 'Sanskrit' , 
           'sd' => 'Sindhi' , 
           'sg' => 'Sangro' , 
           'sh' => 'Serbo-Croatian' , 
           'si' => 'Singhalese' , 
           'sk' => 'Slovak' , 
           'sl' => 'Slovenian' , 
           'sm' => 'Samoan' , 
           'sn' => 'Shona' , 
           'so' => 'Somali' , 
           'sq' => 'Albanian' , 
           'sr' => 'Serbian' , 
           'ss' => 'Siswati' , 
           'st' => 'Sesotho' , 
           'su' => 'Sundanese' , 
           'sv' => 'Swedish' , 
           'sw' => 'Swahili' , 
           'ta' => 'Tamil' , 
           'te' => 'Tegulu' , 
           'tg' => 'Tajik' , 
           'th' => 'Thai' , 
           'ti' => 'Tigrinya' , 
           'tk' => 'Turkmen' , 
           'tl' => 'Tagalog' , 
           'tn' => 'Setswana' , 
           'to' => 'Tonga' , 
           'tr' => 'Turkish' , 
           'ts' => 'Tsonga' , 
           'tt' => 'Tatar' , 
           'tw' => 'Twi' , 
           'uk' => 'Ukrainian' , 
           'ur' => 'Urdu' , 
           'uz' => 'Uzbek' , 
           'vi' => 'Vietnamese' , 
           'vo' => 'Volapuk' , 
           'wo' => 'Wolof' , 
           'xh' => 'Xhosa' , 
           'yo' => 'Yoruba' , 
           'zh' => 'Chinese' , 
           'zu' => 'Zulu' , 
           );
   $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
   $authorized = false;
   if(isset($youtubomatic_Main_Settings['oauth_key']) && $youtubomatic_Main_Settings['oauth_key'] != '')
   {
       if(isset($youtubomatic_Main_Settings['oauth_secret']) && $youtubomatic_Main_Settings['oauth_secret'] != '')
       {
           if(get_option('youtubomatic_access_token_auth_id', false) !== FALSE)
           {
               if(get_option('youtubomatic_access_token_auth_secret', false) !== FALSE)
               {
                   if($youtubomatic_Main_Settings['oauth_key'] == get_option('youtubomatic_access_token_auth_id', false) && $youtubomatic_Main_Settings['oauth_secret'] == get_option('youtubomatic_access_token_auth_secret', false) && get_option('youtubomatic_access_token_str', false) !== FALSE)
                   {
                       $authorized = true;
                   }
               }
           }
       }
       else
       {
   ?>
<h1><?php echo esc_html__("You must add a YouTube OAuth2 Secret before you can use this feature!", 'youtubomatic-youtube-post-generator');?></h1>
<?php
   update_option('youtubomatic_access_token_auth_id', 'null');
   update_option('youtubomatic_access_token_auth_secret', 'null');
   return;
       }
   }
   else
   {
   ?>
<h1><?php echo esc_html__("You must add a YouTube OAuth2 Key before you can use this feature!", 'youtubomatic-youtube-post-generator');?></h1>
<?php
   update_option('youtubomatic_access_token_auth_id', 'null');
   update_option('youtubomatic_access_token_auth_secret', 'null');
   return;
   }
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
   <div>
      <?php
         if($authorized === FALSE)
         {
         ?>
      <div class="hideThis">
         <h1><?php echo esc_html__("Some Required Steps Before You Can Use This Feature:", 'youtubomatic-youtube-post-generator');?></h1>
         <br><b>1)</b> <?php echo esc_html__('In the', 'youtubomatic-youtube-post-generator');?> <a href='https://console.developers.google.com/apis/credentials' target='_blank'><?php echo esc_html__('API Manager', 'youtubomatic-youtube-post-generator');?></a> <?php echo esc_html__('settings page in YouTube (\'Credentials\' subsection), set the \'Authorized redirect URIs\' of your OAuth key to the following URL (otherwise authorization will not work!):', 'youtubomatic-youtube-post-generator');?><br/>
         <span class="cr_red"><?php echo site_url() . '/wp-admin/admin.php?page=youtubomatic_youtube_panel&yt_auth_done=true';?></span>
         <br/><b>2)</b> <strong><?php echo esc_html__('Authorize Your App to Post on YouTube with the button below:', 'youtubomatic-youtube-post-generator');?></strong>
      </div>
      <br/>
      <form id="myForm2" method="post" action=""><input type="submit" name="youtubomatic_auth" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php if($authorized === TRUE){echo esc_html__('Reauthorize the App', 'youtubomatic-youtube-post-generator');}else{echo esc_html__('Authorize the App', 'youtubomatic-youtube-post-generator');}?>"/></form>
      <?php
         update_option('youtubomatic_access_token_auth_id', 'null');
         update_option('youtubomatic_access_token_auth_secret', 'null');
         ?>
      <h1><?php echo esc_html__("You must authorize your App before using this plugin feature!", 'youtubomatic-youtube-post-generator');?></h1>
      <?php
         }
         else
         {
         if(isset($_REQUEST['yt_auth_done']))
         {
         ?>
      <div id="message" class="updated">
         <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__("YouTube authorization successful!", 'youtubomatic-youtube-post-generator');?></strong></p>
      </div>
      <?php
         }
         ?>
      <br/>
      <form id="myForm2" method="post" action=""><input type="submit" name="youtubomatic_auth" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php if($authorized === TRUE){echo esc_html__('Reauthorize the App', 'youtubomatic-youtube-post-generator');}else{echo esc_html__('Authorize the App', 'youtubomatic-youtube-post-generator');}?>"/></form>
      <form id="myForm" method="post" action="<?php if(is_multisite() && is_network_admin()){echo '../options.php';}else{echo 'options.php';}?>">
      <?php
         settings_fields('youtubomatic_option_group2');
         do_settings_sections('youtubomatic_option_group2');
         $youtubomatic_Youtube_Settings = get_option('youtubomatic_Youtube_Settings', false);
         if (isset($youtubomatic_Youtube_Settings['youtubomatic_posting'])) {
             $youtubomatic_posting = $youtubomatic_Youtube_Settings['youtubomatic_posting'];
         } else {
             $youtubomatic_posting = '';
         }
         if (isset($youtubomatic_Youtube_Settings['youtube_format'])) {
             $youtube_format = $youtubomatic_Youtube_Settings['youtube_format'];
         } else {
             $youtube_format = '';
         }
         if (isset($youtubomatic_Youtube_Settings['post_posts'])) {
             $post_posts = $youtubomatic_Youtube_Settings['post_posts'];
         } else {
             $post_posts = '';
         }
         if (isset($youtubomatic_Youtube_Settings['post_pages'])) {
             $post_pages = $youtubomatic_Youtube_Settings['post_pages'];
         } else {
             $post_pages = '';
         }
         if (isset($youtubomatic_Youtube_Settings['disabled_categories'])) {
             $disabled_categories = $youtubomatic_Youtube_Settings['disabled_categories'];
         } else {
             $disabled_categories = '';
         }
         if (isset($youtubomatic_Youtube_Settings['disable_tags'])) {
             $disable_tags = $youtubomatic_Youtube_Settings['disable_tags'];
         } else {
             $disable_tags = '';
         }
         if (isset($youtubomatic_Youtube_Settings['only_local'])) {
             $only_local = $youtubomatic_Youtube_Settings['only_local'];
         } else {
             $only_local = '';
         }
         if (isset($youtubomatic_Youtube_Settings['youtube_title_format'])) {
             $youtube_title_format = $youtubomatic_Youtube_Settings['youtube_title_format'];
         } else {
             $youtube_title_format = '';
         }
         if (isset($youtubomatic_Youtube_Settings['auto_tags'])) {
             $auto_tags = $youtubomatic_Youtube_Settings['auto_tags'];
         } else {
             $auto_tags = '';
         }
         if (isset($youtubomatic_Youtube_Settings['additional_tags'])) {
             $additional_tags = $youtubomatic_Youtube_Settings['additional_tags'];
         } else {
             $additional_tags = '';
         }
         if (isset($youtubomatic_Youtube_Settings['video_category'])) {
             $video_category = $youtubomatic_Youtube_Settings['video_category'];
         } else {
             $video_category = '';
         }
         if (isset($youtubomatic_Youtube_Settings['video_status'])) {
             $video_status = $youtubomatic_Youtube_Settings['video_status'];
         } else {
             $video_status = '';
         }
         if (isset($youtubomatic_Youtube_Settings['chunk_size'])) {
             $chunk_size = $youtubomatic_Youtube_Settings['chunk_size'];
         } else {
             $chunk_size = '';
         }
         if (isset($youtubomatic_Youtube_Settings['video_language'])) {
             $video_language = $youtubomatic_Youtube_Settings['video_language'];
         } else {
             $video_language = '';
         }
         if (isset($youtubomatic_Youtube_Settings['video_audio_language'])) {
             $video_audio_language = $youtubomatic_Youtube_Settings['video_audio_language'];
         } else {
             $video_audio_language = '';
         }
         if (isset($youtubomatic_Youtube_Settings['max_at_once'])) {
             $max_at_once = $youtubomatic_Youtube_Settings['max_at_once'];
         } else {
             $max_at_once = '';
         }
         if (isset($youtubomatic_Youtube_Settings['vimeo_embedded'])) {
             $vimeo_embedded = $youtubomatic_Youtube_Settings['vimeo_embedded'];
         } else {
             $vimeo_embedded = '';
         }
         if (isset($youtubomatic_Youtube_Settings['dm_embedded'])) {
             $dm_embedded = $youtubomatic_Youtube_Settings['dm_embedded'];
         } else {
             $dm_embedded = '';
         }
         if (isset($youtubomatic_Youtube_Settings['fb_embedded'])) {
             $fb_embedded = $youtubomatic_Youtube_Settings['fb_embedded'];
         } else {
             $fb_embedded = '';
         }
         if (isset($youtubomatic_Youtube_Settings['tw_embedded'])) {
             $tw_embedded = $youtubomatic_Youtube_Settings['tw_embedded'];
         } else {
             $tw_embedded = '';
         }
         if (isset($youtubomatic_Youtube_Settings['replace_old'])) {
             $replace_old = $youtubomatic_Youtube_Settings['replace_old'];
         } else {
             $replace_old = '';
         }
         if (isset($youtubomatic_Youtube_Settings['replace_local'])) {
             $replace_local = $youtubomatic_Youtube_Settings['replace_local'];
         } else {
             $replace_local = '';
         }
         if (isset($youtubomatic_Youtube_Settings['delete_local'])) {
             $delete_local = $youtubomatic_Youtube_Settings['delete_local'];
         } else {
             $delete_local = '';
         }
         if (isset($youtubomatic_Youtube_Settings['youtube_embedded'])) {
             $youtube_embedded = $youtubomatic_Youtube_Settings['youtube_embedded'];
         } else {
             $youtube_embedded = '';
         }
         if (isset($youtubomatic_Youtube_Settings['delay_post'])) {
             $delay_post = $youtubomatic_Youtube_Settings['delay_post'];
         } else {
             $delay_post = '';
         }
         if (isset($youtubomatic_Youtube_Settings['run_background'])) {
             $run_background = $youtubomatic_Youtube_Settings['run_background'];
         } else {
             $run_background = '';
         }
         if (isset($youtubomatic_Youtube_Settings['save_local'])) {
             $save_local = $youtubomatic_Youtube_Settings['save_local'];
         } else {
             $save_local = '';
         }
         if (isset($youtubomatic_Youtube_Settings['alt_upload'])) {
             $alt_upload = $youtubomatic_Youtube_Settings['alt_upload'];
         } else {
             $alt_upload = '';
         }
         if (isset($youtubomatic_Youtube_Settings['post_custom'])) {
             $post_custom = $youtubomatic_Youtube_Settings['post_custom'];
         } else {
             $post_custom = '';
         }
         if (isset($_GET['settings-updated'])) {
         ?>
      <div id="message" class="updated">
         <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Settings saved.', 'youtubomatic-youtube-post-generator');?></strong></p>
      </div>
      <?php
         $get = get_option('coderevolution_settings_changed', 0);
         if($get == 1)
         {
             delete_option('coderevolution_settings_changed');
         ?>
      <div id="message" class="updated">
         <p class="cr_failed_notif"><strong>&nbsp;<?php echo esc_html__('Plugin registration failed!', 'youtubomatic-youtube-post-generator');?></strong></p>
      </div>
      <?php 
         }
         elseif($get == 2)
         {
                 delete_option('coderevolution_settings_changed');
         ?>
      <div id="message" class="updated">
         <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Plugin registration successful!', 'youtubomatic-youtube-post-generator');?></strong></p>
      </div>
      <?php 
         }
             }
         ?>
      <div>
         <div class="youtubomatic_class">
            <table>
               <tr>
                  <td>
                     <h1>
                        <span class="gs-sub-heading"><b>Youtubomatic Automatic Post to YouTube - <?php echo esc_html__('Main Switch:', 'youtubomatic-youtube-post-generator');?></b>&nbsp;</span>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Enable or disable automatic posting to YouTube every time you publish a new post (manually or automatically).", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                     </h1>
                  </td>
                  <td>
                     <div class="slideThree">	
                        <input class="input-checkbox" type="checkbox" id="youtubomatic_posting" name="youtubomatic_Youtube_Settings[youtubomatic_posting]"<?php
                           if ($youtubomatic_posting == 'on')
                               echo ' checked ';
                           ?>>
                        <label for="youtubomatic_posting"></label>
                     </div>
                  </td>
               </tr>
            </table>
         </div>
         <div><?php if($youtubomatic_posting != 'on'){echo '<div class="crf_bord cr_color_red cr_auto_update">' . esc_html__('This feature of the plugin is disabled! Please enable it from the above switch.', 'youtubomatic-youtube-post-generator') . '</div>';}?>
            <hr/>
            <table>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo sprintf( wp_kses( __( "Simple! Hit the WordPress's 'New Post' button, include a video link pointing to a valid video file in the post content. Hit publish and watch how your linked video is published to YouTube! You can automatically publish videos to YouTube that are linked from your published post content. After you inserted your OAuth key and secret and authorized the plugin on YouTube, simply include in your WordPress newly published posts a link to any video file and this plugin will automatically post it also to YouTube. You can configure the posting settings below. Note that YouTube has a set of restrictions for video uploading: <a href='%s' target='_blank'>more info about YouTube Quota</a>. Allowed file type for uploading are: .mov, .mpeg4, .mps, .avi, .wmv, .mpegps, .flv, .3gpp, .webm. Also, note that you ca upload only videos of maximum 15 minutes in lenght if you do not verify your YouTube accout by goint to <a href='%s' target='_blank'> verify page</a>. After you verified your account, you can upload videos of maximum 2Gb.", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://developers.google.com/youtube/v3/getting-started#quota' ), esc_url( 'https://www.youtube.com/verify' ) );
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Help! How do I use this feature?", 'youtubomatic-youtube-post-generator');?></b>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <hr/>
                  </td>
                  <td>
                     <hr/>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("This option will make the plugin save videos locally on your server and not post them any more on YouTube. The plugin will save post metas with them path of the local videos that it created. Meta name for save video path: youtubomatic_saved_video1. If the plugin saves multiple videos to one post, it will create multiple post metas, with the number from the end of the meta name incremented: youtubomatic_saved_video2, youtubomatic_saved_video3, youtubomatic_saved_video4, ...", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Download Videos Only Locally To Server (Do Not Publish To YouTube):", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="save_local" name="youtubomatic_Youtube_Settings[save_local]"<?php
                     if ($save_local == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want delay posting with this amount of seconds from post publish? This will create a single cron job for each post (cron is a requirement for this to function). If you leave this field blank, posts will be automatically published on post creation.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Delay Posting By (Seconds):", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="number" min="0" step="1" id="delay_post" name="youtubomatic_Youtube_Settings[delay_post]" class="cr_450" value="<?php echo esc_html($delay_post);?>" placeholder="Delay posting by X seconds">
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("This option will allow you to select if you want to run posting in async mode. This means that each time you publish a post, the plugin will try to execute it's task in the background - it will no longer block new post posting, while it finishes it's job.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Use Async Posting Method:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="run_background" name="youtubomatic_Youtube_Settings[run_background]"<?php
                     if ($run_background == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Choose the template of your YouTube posts title. You can use the following shortcodes: %%video_number%%, %%blog_title%%, %%author_name%%, %%smart_hashtags%%, %%post_cats%%, %%post_tags%%, %%post_title%%, %%post_excerpt%%, %%random_sentence%%, %%random_sentence2%%.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("YouTube Post Title Template:", 'youtubomatic-youtube-post-generator');?></b>
                     </div>
                  </td>
                  <td>
                     <div>
                        <textarea rows="1" name="youtubomatic_Youtube_Settings[youtube_title_format]" placeholder="Please insert your YouTube post title template"><?php
                           echo esc_textarea($youtube_title_format);
                           ?></textarea>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Choose the template of your YouTube posts description. You can use the following shortcodes: %%video_number%%, %%featured_image%%, %%smart_hashtags%%, %%blog_title%%, %%author_name%%, %%post_link%%, %%random_sentence%%, %%random_sentence2%%, %%post_cats%%, %%post_tags%%, %%post_title%%, %%post_content%%, %%post_excerpt%%.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("YouTube Post Description Template:", 'youtubomatic-youtube-post-generator');?></b>
                     </div>
                  </td>
                  <td>
                     <div>
                        <textarea rows="4" name="youtubomatic_Youtube_Settings[youtube_format]" placeholder="Please insert your YouTube post template"><?php
                           echo esc_textarea($youtube_format);
                           ?></textarea>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to disable automatically posting of WordPress 'posts' to YouTube?", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Disable Autoposting of 'Posts':", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="post_posts" name="youtubomatic_Youtube_Settings[post_posts]"<?php
                     if ($post_posts == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to disable automatically posting of WordPress 'pages' to YouTube?", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Disable Autoposting of 'Pages':", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="post_pages" name="youtubomatic_Youtube_Settings[post_pages]"<?php
                     if ($post_pages == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to disable automatically posting of WordPress 'custom post types' to YouTube?", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Disable Autoposting of 'Custom Post Types':", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="post_custom" name="youtubomatic_Youtube_Settings[post_custom]"<?php
                     if ($post_custom == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to disable automatically posting of WordPress 'posts' to YouTube?", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Disable Autoposting of Selected Categories:", 'youtubomatic-youtube-post-generator');?></b><br/>
                        <a onclick="toggleCats()" class="cr_pointer"><?php echo esc_html__("Show/Hide Categories List", 'youtubomatic-youtube-post-generator');?></a>
                  </td>
                  <td>
                  <br/>
                  <div id="hideCats" class="hideCats">
                  <?php
                     $cat_args   = array(
                         'orderby' => 'name',
                         'hide_empty' => 0,
                         'order' => 'ASC'
                     );
                     $categories = get_categories($cat_args);
                     foreach ($categories as $category) {
                     ?>
                  <div>
                  <label>
                  <input
                     <?php
                        if (isset($youtubomatic_Youtube_Settings['disabled_categories']) && !empty($youtubomatic_Youtube_Settings['disabled_categories'])) {
                            checked(true, in_array($category->term_id, $youtubomatic_Youtube_Settings['disabled_categories']));
                        }
                        ?>
                     type="checkbox" name="youtubomatic_Youtube_Settings[disabled_categories][]" value="<?php
                        echo esc_html($category->term_id);
                        ?>" /> 
                  <span><?php
                     echo esc_html(sanitize_text_field($category->name));
                     ?></span>
                  </label>
                  </div>
                  <?php
                     }
                     ?>
                  </div>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Input the tags for which you want to disable posting. You can enter more tags, separated by comma. Ex: cars, vehicles, red, luxury. To disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Disable Autoposting of Selected Tags:", 'youtubomatic-youtube-post-generator');?></b>
                     </div>
                  </td>
                  <td>
                     <div>
                        <textarea rows="1" name="youtubomatic_Youtube_Settings[disable_tags]" placeholder="Please insert the tags for which you want to disable posting"><?php
                           echo esc_textarea($disable_tags);
                           ?></textarea>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to allow to post to YouTube links from content that are on your local hosting (including media library)?", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Try to Upload Linked Local Videos From Content:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="only_local" name="youtubomatic_Youtube_Settings[only_local]"<?php
                     if ($only_local == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to try to upload YouTube videos that are embedded from your content? Warning! This will upload to your channel any YouTube video that you link in your post content. This is an experimental feature, use it on your own risk.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Try to Upload Linked YouTube Videos From Content:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="youtube_embedded" name="youtubomatic_Youtube_Settings[youtube_embedded]"<?php
                     if ($youtube_embedded == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to try to upload Vimeo videos that are embedded from your content? Warning! This will upload to your channel any YouTube video that you link in your post content. This is an experimental feature, use it on your own risk.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Try to Upload Linked Vimeo Videos From Content:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="vimeo_embedded" name="youtubomatic_Youtube_Settings[vimeo_embedded]"<?php
                     if ($vimeo_embedded == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to try to upload DailyMotion videos that are embedded from your content? Warning! This will upload to your channel any YouTube video that you link in your post content. This is an experimental feature, use it on your own risk.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Try to Upload Linked DailyMotion Videos From Content:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="dm_embedded" name="youtubomatic_Youtube_Settings[dm_embedded]"<?php
                     if ($dm_embedded == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to try to upload Facebook videos that are embedded from your content? Warning! This will upload to your channel any YouTube video that you link in your post content. This is an experimental feature, use it on your own risk.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Try to Upload Linked Facebook Videos From Content:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="fb_embedded" name="youtubomatic_Youtube_Settings[fb_embedded]"<?php
                     if ($fb_embedded == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to try to upload Twitch clips that are embedded from your content? Warning! This will upload to your channel any YouTube video that you link in your post content. This is an experimental feature, use it on your own risk.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Try to Upload Linked Twitch Clips From Content:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="tw_embedded" name="youtubomatic_Youtube_Settings[tw_embedded]"<?php
                     if ($tw_embedded == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to automatically set tags for generated video?", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Auto Generate Video Tags:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <select id="auto_tags" name="youtubomatic_Youtube_Settings[auto_tags]">
                  <option value="disabled"<?php if($auto_tags == 'disabled')echo ' selected'?>><?php echo esc_html__("Disabled", 'youtubomatic-youtube-post-generator');?></option>
                  <option value="tags"<?php if($auto_tags == 'tags')echo ' selected'?>><?php echo esc_html__("From Post Tags", 'youtubomatic-youtube-post-generator');?></option>
                  <option value="cats"<?php if($auto_tags == 'cats')echo ' selected'?>><?php echo esc_html__("From Post Categories", 'youtubomatic-youtube-post-generator');?></option>
                  <option value="both"<?php if($auto_tags == 'both')echo ' selected'?>><?php echo esc_html__("From Post Tags and Categories", 'youtubomatic-youtube-post-generator');?></option>
                  </select>  
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Input additional YouTube tags. You can enter more tags, separated by comma. Ex: cars, luxury, driver", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Additional Video Tags:", 'youtubomatic-youtube-post-generator');?></b>
                     </div>
                  </td>
                  <td>
                     <div>
                        <textarea rows="1" name="youtubomatic_Youtube_Settings[additional_tags]" placeholder="Please insert additinal video tags"><?php
                           echo esc_textarea($additional_tags);
                           ?></textarea>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select the category for the posted video on YouTube.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Video Category:", 'youtubomatic-youtube-post-generator');?></b>
                     </div>
                  </td>
                  <td>
                     <div>
                        <select id="video_category" name="youtubomatic_Youtube_Settings[video_category]">
                           <option value="1"<?php if($video_category == '1')echo ' selected'?>><?php echo esc_html__("Film & Animation", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="2"<?php if($video_category == '2')echo ' selected'?>><?php echo esc_html__("Autos & Vehicles", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="10"<?php if($video_category == '10')echo ' selected'?>><?php echo esc_html__("Music", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="15"<?php if($video_category == '15')echo ' selected'?>><?php echo esc_html__("Pets & Animals", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="17"<?php if($video_category == '17')echo ' selected'?>><?php echo esc_html__("Sports", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="18"<?php if($video_category == '18')echo ' selected'?>><?php echo esc_html__("Short Movies", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="19"<?php if($video_category == '19')echo ' selected'?>><?php echo esc_html__("Travel & Events", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="20"<?php if($video_category == '20')echo ' selected'?>><?php echo esc_html__("Gaming", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="21"<?php if($video_category == '21')echo ' selected'?>><?php echo esc_html__("Videoblogging", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="22"<?php if($video_category == '22')echo ' selected'?>><?php echo esc_html__("People & Blogs", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="23"<?php if($video_category == '23')echo ' selected'?>><?php echo esc_html__("Comedy", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="24"<?php if($video_category == '24')echo ' selected'?>><?php echo esc_html__("Entertainment", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="25"<?php if($video_category == '25')echo ' selected'?>><?php echo esc_html__("News & Politics", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="26"<?php if($video_category == '26')echo ' selected'?>><?php echo esc_html__("Howto & Style", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="27"<?php if($video_category == '27')echo ' selected'?>><?php echo esc_html__("Education", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="28"<?php if($video_category == '28')echo ' selected'?>><?php echo esc_html__("Science & Technology", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="29"<?php if($video_category == '29')echo ' selected'?>><?php echo esc_html__("Nonprofits & Activism", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="30"<?php if($video_category == '30')echo ' selected'?>><?php echo esc_html__("Movies", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="31"<?php if($video_category == '31')echo ' selected'?>><?php echo esc_html__("Anime/Animation", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="32"<?php if($video_category == '32')echo ' selected'?>><?php echo esc_html__("Action/Adventure", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="33"<?php if($video_category == '33')echo ' selected'?>><?php echo esc_html__("Classics", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="35"<?php if($video_category == '35')echo ' selected'?>><?php echo esc_html__("Documentary", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="36"<?php if($video_category == '36')echo ' selected'?>><?php echo esc_html__("Drama", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="37"<?php if($video_category == '37')echo ' selected'?>><?php echo esc_html__("Family", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="38"<?php if($video_category == '38')echo ' selected'?>><?php echo esc_html__("Foreign", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="39"<?php if($video_category == '39')echo ' selected'?>><?php echo esc_html__("Horror", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="40"<?php if($video_category == '40')echo ' selected'?>><?php echo esc_html__("Sci-Fi/Fantasy", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="41"<?php if($video_category == '41')echo ' selected'?>><?php echo esc_html__("Thriller", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="42"<?php if($video_category == '42')echo ' selected'?>><?php echo esc_html__("Shorts", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="43"<?php if($video_category == '43')echo ' selected'?>><?php echo esc_html__("Shows", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="44"<?php if($video_category == '44')echo ' selected'?>><?php echo esc_html__("Trailers", 'youtubomatic-youtube-post-generator');?></option>
                        </select>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select the status of the posted videos on YouTube.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Video Status:", 'youtubomatic-youtube-post-generator');?></b>
                     </div>
                  </td>
                  <td>
                     <div>
                        <select id="video_status" name="youtubomatic_Youtube_Settings[video_status]">
                           <option value="public"<?php if($video_status == 'public')echo ' selected'?>><?php echo esc_html__("Public", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="private"<?php if($video_status == 'private')echo ' selected'?>><?php echo esc_html__("Private", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="unlisted"<?php if($video_status == 'unlisted')echo ' selected'?>><?php echo esc_html__("Unlisted", 'youtubomatic-youtube-post-generator');?></option>
                        </select>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select the main language of your video.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Video Language:", 'youtubomatic-youtube-post-generator');?></b>
                     </div>
                  </td>
                  <td>
                     <div>
                        <select id="video_language" name="youtubomatic_Youtube_Settings[video_language]" >
                        <?php
                           foreach ($language_codes as $key => $value) {
                               echo '<option value="' . esc_attr($key) . '"';
                               if($key == $video_language)
                               {
                                   echo ' selected';
                               }
                               echo '>' . esc_html($value) . '</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select the main language of the audio of your video.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Video Audio Language:", 'youtubomatic-youtube-post-generator');?></b>
                     </div>
                  </td>
                  <td>
                     <div>
                        <select id="video_audio_language" name="youtubomatic_Youtube_Settings[video_audio_language]" >
                        <?php
                           foreach ($language_codes as $key => $value) {
                               echo '<option value="' . esc_attr($key) . '"';
                               if($key == $video_audio_language)
                               {
                                   echo ' selected';
                               }
                               echo '>' . esc_html($value) . '</option>';
                           }
                           ?>
                        </select>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("This option is intended for advaced users only! Select the chunk size of the video uploads (this much bytes will be transfered in one transfer to Youtube, if video size is larger than this number, mutiple transfers will be executed). Minimum is 1024 bytes. The default value is 1048576 (1 Mb). Specify the size of each chunk of data, in bytes. Set a higher value for reliable connection as fewer chunks lead to faster uploads. Set a lower value for better recovery on less reliable connections.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Transfer Chunk Size:", 'youtubomatic-youtube-post-generator');?></b>
                     </div>
                  </td>
                  <td>
                     <div>
                        <input type="number" step="262144" min="262144" placeholder="# bytes" name="youtubomatic_Youtube_Settings[chunk_size]" value="<?php echo esc_html($chunk_size);?>"> 
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to use an alternative video upload method? You can try to enable this, if you exceprience errors at video uploading. Please note that this feature requires a lot more memory to be available for the plugin, so please increase the WP_MEMORY_LIMIT so it can handle even large video files. Example: change this in the wp_config.ini - define( 'WP_MEMORY_LIMIT', '256M' );", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Use Alternative Video Upload Method:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="alt_upload" name="youtubomatic_Youtube_Settings[alt_upload]"<?php
                     if ($alt_upload == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select the maximum number of videos to be uploaded at once.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Maximum Number of Videos At Once:", 'youtubomatic-youtube-post-generator');?></b>
                     </div>
                  </td>
                  <td>
                     <div>
                        <input type="number" id="max_at_once" step="1" min="0" placeholder="Input the maximum number of videos to upload at once" name="youtubomatic_Youtube_Settings[max_at_once]" value="<?php
                           echo esc_html($max_at_once);
                           ?>"/>
                     </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to replace published YouTube videos embedded in posts with the newly uploaded videos to YouTube?", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Replace Old YouTube Video URL With Uploaded Video URL In Content:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="replace_old" name="youtubomatic_Youtube_Settings[replace_old]"<?php
                     if ($replace_old == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to replace local video URL from content (video must be in a [video] shortcode), with the newly uploaded YouTube video?", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Replace Local Video URL With Uploaded Video URL In Content:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="replace_local" name="youtubomatic_Youtube_Settings[replace_local]"<?php
                     if ($replace_local == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
               <tr>
                  <td>
                     <div>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to delete local video file from server, after it was successfully uploaded to YouTube?", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Delete Local Video After Successful Upload:", 'youtubomatic-youtube-post-generator');?></b>
                  </td>
                  <td>
                  <input type="checkbox" id="delete_local" name="youtubomatic_Youtube_Settings[delete_local]"<?php
                     if ($delete_local == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td>
               </tr>
            </table>
            <br/><br/>
            <div>
               <b><?php echo esc_html__("Help! App is authorized and still no new videos are appearing on YouTube?", 'youtubomatic-youtube-post-generator');?></b>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("In this case you can try the following: 1) Reauthorize the App. Simply click the 'Reauthorize' button and follow the steps given. 2) Create a new App OAuth Key and Secret and try linking the new one in the plugin.", 'youtubomatic-youtube-post-generator');
                        ?>
                  </div>
               </div>
            </div>
            <a href="https://www.youtube.com/watch?v=5rbnu_uis7Y" target="_blank"><?php echo esc_html__("Nested Shortcodes also supported!", 'youtubomatic-youtube-post-generator');?></a>
         </div>
         <div>
            <p class="submit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'youtubomatic-youtube-post-generator');?>"/></p>
         </div>
         </form
         <?php
            }
            ?>
      </div>
   </div>
</div>
<?php
   }
   ?>