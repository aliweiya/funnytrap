<?php
   function youtubomatic_admin_settings()
   {
       $language_names = array(
           esc_html__("Disabled", 'youtubomatic-youtube-post-generator'),
           esc_html__("Afrikaans (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Albanian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Arabic (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Amharic (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Armenian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Belarusian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Bulgarian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Catalan (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Chinese Simplified (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Croatian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Czech (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Danish (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Dutch (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("English (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Estonian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Filipino (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Finnish (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("French (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Galician (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("German (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Greek (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Hebrew (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Hindi (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Hungarian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Icelandic (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Indonesian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Irish (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Italian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Japanese (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Korean (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Latvian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Lithuanian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Norwegian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Macedonian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Malay (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Maltese (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Persian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Polish (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Portuguese (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Romanian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Russian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Serbian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Slovak (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Slovenian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Spanish (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Swahili (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Swedish (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Thai (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Turkish (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Ukrainian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Vietnamese (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Welsh (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Yiddish (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Tamil (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Azerbaijani (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Kannada (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Basque (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Bengali (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Latin (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Chinese Traditional (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Esperanto (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Georgian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Telugu (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Gujarati (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Haitian Creole (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Urdu (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Burmese (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Bosnian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Cebuano (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Chichewa (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Corsican (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Frisian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Scottish Gaelic (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Hausa (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Hawaian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Hmong (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Igbo (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Javanese (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Kazakh (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Khmer (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Kurdish (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Kyrgyz (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Lao (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Luxembourgish (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Malagasy (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Malayalam (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Maori (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Marathi (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Mongolian (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Nepali (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Pashto (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Punjabi (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Samoan (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Sesotho (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Shona (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Sindhi (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Sinhala (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Somali (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Sundanese (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Swahili (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Tajik (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Uzbek (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Xhosa (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Yoruba (Google Translate)", 'youtubomatic-youtube-post-generator'),
           esc_html__("Zulu (Google Translate)", 'youtubomatic-youtube-post-generator')
       );
       $language_codes = array(
           "disabled",
           "af",
           "sq",
           "ar",
           "am",
           "hy",
           "be",
           "bg",
           "ca",
           "zh-CN",
           "hr",
           "cs",
           "da",
           "nl",
           "en",
           "et",
           "tl",
           "fi",
           "fr",
           "gl",
           "de",
           "el",
           "iw",
           "hi",
           "hu",
           "is",
           "id",
           "ga",
           "it",
           "ja",
           "ko",
           "lv",
           "lt",
           "no",
           "mk",
           "ms",
           "mt",
           "fa",
           "pl",
           "pt",
           "ro",
           "ru",
           "sr",
           "sk",
           "sl",
           "es",
           "sw",
           "sv",   
           "th",
           "tr",
           "uk",
           "vi",
           "cy",
           "yi",
           "ta",
           "az",
           "kn",
           "eu",
           "bn",
           "la",
           "zh-TW",
           "eo",
           "ka",
           "te",
           "gu",
           "ht",
           "ur",
           "my",
           "bs",
           "ceb",
           "ny",
           "co",
           "fy",
           "gd",
           "ha",
           "haw",
           "hmn",
           "ig",
           "jw",
           "kk",
           "km",
           "ku",
           "ky",
           "lo",
           "lb",
           "mg",
           "ml",
           "mi",
           "mr",
           "mn",
           "ne",
           "ps",
           "pa",
           "sm",
           "st",
           "sn",
           "sd",
           "si",
           "so",
           "su",
           "sw",
           "tg",
           "uz",
           "xh",
           "yo",
           "zu"
       );
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
   <div>
      <form id="myForm" method="post" action="<?php if(is_multisite() && is_network_admin()){echo '../options.php';}else{echo 'options.php';}?>">
         <div class="cr_autocomplete">
            <input type="password" id="PreventChromeAutocomplete" 
               name="PreventChromeAutocomplete" autocomplete="address-level4" />
         </div>
         <?php
            settings_fields('youtubomatic_option_group');
            do_settings_sections('youtubomatic_option_group');
            $youtubomatic_Main_Settings = get_option('youtubomatic_Main_Settings', false);
            if (isset($youtubomatic_Main_Settings['youtubomatic_enabled'])) {
                $youtubomatic_enabled = $youtubomatic_Main_Settings['youtubomatic_enabled'];
            } else {
                $youtubomatic_enabled = '';
            }
            if (isset($youtubomatic_Main_Settings['enable_metabox'])) {
                $enable_metabox = $youtubomatic_Main_Settings['enable_metabox'];
            } else {
                $enable_metabox = '';
            }
            if (isset($youtubomatic_Main_Settings['sentence_list'])) {
                $sentence_list = $youtubomatic_Main_Settings['sentence_list'];
            } else {
                $sentence_list = '';
            }
            if (isset($youtubomatic_Main_Settings['sentence_list2'])) {
                $sentence_list2 = $youtubomatic_Main_Settings['sentence_list2'];
            } else {
                $sentence_list2 = '';
            }
            if (isset($youtubomatic_Main_Settings['variable_list'])) {
                $variable_list = $youtubomatic_Main_Settings['variable_list'];
            } else {
                $variable_list = '';
            }
            if (isset($youtubomatic_Main_Settings['enable_detailed_logging'])) {
                $enable_detailed_logging = $youtubomatic_Main_Settings['enable_detailed_logging'];
            } else {
                $enable_detailed_logging = '';
            }
            if (isset($youtubomatic_Main_Settings['secret_word'])) {
                $secret_word = $youtubomatic_Main_Settings['secret_word'];
            } else {
                $secret_word = '';
            }
            if (isset($youtubomatic_Main_Settings['enable_logging'])) {
                $enable_logging = $youtubomatic_Main_Settings['enable_logging'];
            } else {
                $enable_logging = '';
            }
            if (isset($youtubomatic_Main_Settings['auto_clear_logs'])) {
                $auto_clear_logs = $youtubomatic_Main_Settings['auto_clear_logs'];
            } else {
                $auto_clear_logs = '';
            }
            if (isset($youtubomatic_Main_Settings['rule_timeout'])) {
                $rule_timeout = $youtubomatic_Main_Settings['rule_timeout'];
            } else {
                $rule_timeout = '';
            }
            if (isset($youtubomatic_Main_Settings['disable_scripts'])) {
                $disable_scripts = $youtubomatic_Main_Settings['disable_scripts'];
            } else {
                $disable_scripts = '';
            }
            if (isset($youtubomatic_Main_Settings['rule_delay'])) {
                $rule_delay = $youtubomatic_Main_Settings['rule_delay'];
            } else {
                $rule_delay = '';
            }
            if (isset($youtubomatic_Main_Settings['strip_links'])) {
                $strip_links = $youtubomatic_Main_Settings['strip_links'];
            } else {
                $strip_links = '';
            }
            if (isset($youtubomatic_Main_Settings['strip_textual_links'])) {
                $strip_textual_links = $youtubomatic_Main_Settings['strip_textual_links'];
            } else {
                $strip_textual_links = '';
            }
            if (isset($youtubomatic_Main_Settings['limit_words'])) {
                $limit_words = $youtubomatic_Main_Settings['limit_words'];
            } else {
                $limit_words = '';
            }
            if (isset($youtubomatic_Main_Settings['send_email'])) {
                $send_email = $youtubomatic_Main_Settings['send_email'];
            } else {
                $send_email = '';
            }
            if (isset($youtubomatic_Main_Settings['email_address'])) {
                $email_address = $youtubomatic_Main_Settings['email_address'];
            } else {
                $email_address = '';
            }
            if (isset($youtubomatic_Main_Settings['translate'])) {
                $translate = $youtubomatic_Main_Settings['translate'];
            } else {
                $translate = '';
            }
            if (isset($youtubomatic_Main_Settings['translate_source'])) {
                $translate_source = $youtubomatic_Main_Settings['translate_source'];
            } else {
                $translate_source = '';
            }
            if (isset($youtubomatic_Main_Settings['litte_translate'])) {
                $litte_translate = $youtubomatic_Main_Settings['litte_translate'];
            } else {
                $litte_translate = '';
            }
            if (isset($youtubomatic_Main_Settings['spin_text'])) {
                $spin_text = $youtubomatic_Main_Settings['spin_text'];
            } else {
                $spin_text = '';
            }
            if (isset($youtubomatic_Main_Settings['no_check'])) {
                $no_check = $youtubomatic_Main_Settings['no_check'];
            } else {
                $no_check = '';
            }
            if (isset($youtubomatic_Main_Settings['no_dup_check'])) {
                $no_dup_check = $youtubomatic_Main_Settings['no_dup_check'];
            } else {
                $no_dup_check = '';
            }
            if (isset($youtubomatic_Main_Settings['title_dup'])) {
                $title_dup = $youtubomatic_Main_Settings['title_dup'];
            } else {
                $title_dup = '';
            }
            if (isset($youtubomatic_Main_Settings['best_user'])) {
                $best_user = $youtubomatic_Main_Settings['best_user'];
            } else {
                $best_user = '';
            }
            if (isset($youtubomatic_Main_Settings['best_password'])) {
                $best_password = $youtubomatic_Main_Settings['best_password'];
            } else {
                $best_password = '';
            }
            if (isset($youtubomatic_Main_Settings['phantom_path'])) {
                $phantom_path = $youtubomatic_Main_Settings['phantom_path'];
            } else {
                $phantom_path = '';
            }
            if (isset($youtubomatic_Main_Settings['screenshot_width'])) {
                $screenshot_width = $youtubomatic_Main_Settings['screenshot_width'];
            } else {
                $screenshot_width = '';
            }
            if (isset($youtubomatic_Main_Settings['screenshot_height'])) {
                $screenshot_height = $youtubomatic_Main_Settings['screenshot_height'];
            } else {
                $screenshot_height = '';
            }
            if (isset($youtubomatic_Main_Settings['phantom_screen'])) {
                $phantom_screen = $youtubomatic_Main_Settings['phantom_screen'];
            } else {
                $phantom_screen = '';
            }
            if (isset($youtubomatic_Main_Settings['puppeteer_screen'])) {
                $puppeteer_screen = $youtubomatic_Main_Settings['puppeteer_screen'];
            } else {
                $puppeteer_screen = '';
            }
            if (isset($youtubomatic_Main_Settings['min_word_title'])) {
                $min_word_title = $youtubomatic_Main_Settings['min_word_title'];
            } else {
                $min_word_title = '';
            }
            if (isset($youtubomatic_Main_Settings['max_word_title'])) {
                $max_word_title = $youtubomatic_Main_Settings['max_word_title'];
            } else {
                $max_word_title = '';
            }
            if (isset($youtubomatic_Main_Settings['min_word_content'])) {
                $min_word_content = $youtubomatic_Main_Settings['min_word_content'];
            } else {
                $min_word_content = '';
            }
            if (isset($youtubomatic_Main_Settings['max_word_content'])) {
                $max_word_content = $youtubomatic_Main_Settings['max_word_content'];
            } else {
                $max_word_content = '';
            }
            if (isset($youtubomatic_Main_Settings['required_words'])) {
                $required_words = $youtubomatic_Main_Settings['required_words'];
            } else {
                $required_words = '';
            }
            if (isset($youtubomatic_Main_Settings['banned_words'])) {
                $banned_words = $youtubomatic_Main_Settings['banned_words'];
            } else {
                $banned_words = '';
            }
            if (isset($youtubomatic_Main_Settings['skip_old'])) {
                $skip_old = $youtubomatic_Main_Settings['skip_old'];
            } else {
                $skip_old = '';
            }
            if (isset($youtubomatic_Main_Settings['skip_day'])) {
                $skip_day = $youtubomatic_Main_Settings['skip_day'];
            } else {
                $skip_day = '';
            }
            if (isset($youtubomatic_Main_Settings['skip_month'])) {
                $skip_month = $youtubomatic_Main_Settings['skip_month'];
            } else {
                $skip_month = '';
            }
            if (isset($youtubomatic_Main_Settings['skip_year'])) {
                $skip_year = $youtubomatic_Main_Settings['skip_year'];
            } else {
                $skip_year = '';
            }
            if (isset($youtubomatic_Main_Settings['custom_html2'])) {
                $custom_html2 = $youtubomatic_Main_Settings['custom_html2'];
            } else {
                $custom_html2 = '';
            }
            if (isset($youtubomatic_Main_Settings['custom_html'])) {
                $custom_html = $youtubomatic_Main_Settings['custom_html'];
            } else {
                $custom_html = '';
            }
            if (isset($youtubomatic_Main_Settings['skip_no_img'])) {
                $skip_no_img = $youtubomatic_Main_Settings['skip_no_img'];
            } else {
                $skip_no_img = '';
            }
            if (isset($youtubomatic_Main_Settings['strip_by_id'])) {
                $strip_by_id = $youtubomatic_Main_Settings['strip_by_id'];
            } else {
                $strip_by_id = '';
            }
            if (isset($youtubomatic_Main_Settings['link_back'])) {
                $link_back = $youtubomatic_Main_Settings['link_back'];
            } else {
                $link_back = '';
            }
            if (isset($youtubomatic_Main_Settings['link_soft'])) {
                $link_soft = $youtubomatic_Main_Settings['link_soft'];
            } else {
                $link_soft = '';
            }
            if (isset($youtubomatic_Main_Settings['strip_by_class'])) {
                $strip_by_class = $youtubomatic_Main_Settings['strip_by_class'];
            } else {
                $strip_by_class = '';
            }
            if (isset($youtubomatic_Main_Settings['app_id'])) {
                $app_id = $youtubomatic_Main_Settings['app_id'];
            } else {
                $app_id = '';
            }
            if (isset($youtubomatic_Main_Settings['enable_og'])) {
                $enable_og = $youtubomatic_Main_Settings['enable_og'];
            } else {
                $enable_og = '';
            }
            if (isset($youtubomatic_Main_Settings['enable_og2'])) {
                $enable_og2 = $youtubomatic_Main_Settings['enable_og2'];
            } else {
                $enable_og2 = '';
            }
            if (isset($youtubomatic_Main_Settings['link_og'])) {
                $link_og = $youtubomatic_Main_Settings['link_og'];
            } else {
                $link_og = '';
            }
            if (isset($youtubomatic_Main_Settings['default_image_og'])) {
                $default_image_og = $youtubomatic_Main_Settings['default_image_og'];
            } else {
                $default_image_og = '';
            }
            if (isset($youtubomatic_Main_Settings['links_hide'])) {
                $links_hide = $youtubomatic_Main_Settings['links_hide'];
            } else {
                $links_hide = '';
            }
            if (isset($youtubomatic_Main_Settings['shortest_api'])) {
                $shortest_api = $youtubomatic_Main_Settings['shortest_api'];
            } else {
                $shortest_api = '';
            }
            if (isset($youtubomatic_Main_Settings['disable_excerpt'])) {
                $disable_excerpt = $youtubomatic_Main_Settings['disable_excerpt'];
            } else {
                $disable_excerpt = '';
            }
            if (isset($youtubomatic_Main_Settings['links_hide_google2'])) {
                $links_hide_google2 = $youtubomatic_Main_Settings['links_hide_google2'];
            } else {
                $links_hide_google2 = '';
            }
            if (isset($youtubomatic_Main_Settings['apiKey'])) {
                $apiKey = $youtubomatic_Main_Settings['apiKey'];
            } else {
                $apiKey = '';
            }
            if (isset($youtubomatic_Main_Settings['show_closed_captions'])) {
                $show_closed_captions = $youtubomatic_Main_Settings['show_closed_captions'];
            } else {
                $show_closed_captions = '';
            }
            if (isset($youtubomatic_Main_Settings['color_theme'])) {
                $color_theme = $youtubomatic_Main_Settings['color_theme'];
            } else {
                $color_theme = '';
            }
            if (isset($youtubomatic_Main_Settings['video_controls'])) {
                $video_controls = $youtubomatic_Main_Settings['video_controls'];
            } else {
                $video_controls = '';
            }
            if (isset($youtubomatic_Main_Settings['keyboard_control'])) {
                $keyboard_control = $youtubomatic_Main_Settings['keyboard_control'];
            } else {
                $keyboard_control = '';
            }
            if (isset($youtubomatic_Main_Settings['iframe_api'])) {
                $iframe_api = $youtubomatic_Main_Settings['iframe_api'];
            } else {
                $iframe_api = '';
            }
            if (isset($youtubomatic_Main_Settings['stop_after'])) {
                $stop_after = $youtubomatic_Main_Settings['stop_after'];
            } else {
                $stop_after = '';
            }
            if (isset($youtubomatic_Main_Settings['show_fullscreen_button'])) {
                $show_fullscreen_button = $youtubomatic_Main_Settings['show_fullscreen_button'];
            } else {
                $show_fullscreen_button = '';
            }
            if (isset($youtubomatic_Main_Settings['player_language'])) {
                $player_language = $youtubomatic_Main_Settings['player_language'];
            } else {
                $player_language = '';
            }
            if (isset($youtubomatic_Main_Settings['video_annotations'])) {
                $video_annotations = $youtubomatic_Main_Settings['video_annotations'];
            } else {
                $video_annotations = '';
            }
            if (isset($youtubomatic_Main_Settings['loop_video'])) {
                $loop_video = $youtubomatic_Main_Settings['loop_video'];
            } else {
                $loop_video = '';
            }
            if (isset($youtubomatic_Main_Settings['modest_branding'])) {
                $modest_branding = $youtubomatic_Main_Settings['modest_branding'];
            } else {
                $modest_branding = '';
            }
            if (isset($youtubomatic_Main_Settings['show_related'])) {
                $show_related = $youtubomatic_Main_Settings['show_related'];
            } else {
                $show_related = '';
            }
            if (isset($youtubomatic_Main_Settings['show_info'])) {
                $show_info = $youtubomatic_Main_Settings['show_info'];
            } else {
                $show_info = '';
            }
            if (isset($youtubomatic_Main_Settings['start_after'])) {
                $start_after = $youtubomatic_Main_Settings['start_after'];
            } else {
                $start_after = '';
            }
            if (isset($youtubomatic_Main_Settings['player_height'])) {
                $player_height = $youtubomatic_Main_Settings['player_height'];
            } else {
                $player_height = '';
            }
            if (isset($youtubomatic_Main_Settings['player_width'])) {
                $player_width = $youtubomatic_Main_Settings['player_width'];
            } else {
                $player_width = '';
            }
            if (isset($youtubomatic_Main_Settings['player_style'])) {
                $player_style = $youtubomatic_Main_Settings['player_style'];
            } else {
                $player_style = '0';
            }
            if (isset($youtubomatic_Main_Settings['channel_layout'])) {
                $channel_layout = $youtubomatic_Main_Settings['channel_layout'];
            } else {
                $channel_layout = '';
            }
            if (isset($youtubomatic_Main_Settings['channel_name'])) {
                $channel_name = $youtubomatic_Main_Settings['channel_name'];
            } else {
                $channel_name = '';
            }
            if (isset($youtubomatic_Main_Settings['channel_theme'])) {
                $channel_theme = $youtubomatic_Main_Settings['channel_theme'];
            } else {
                $channel_theme = '';
            }
            if (isset($youtubomatic_Main_Settings['oauth_secret'])) {
                $oauth_secret = $youtubomatic_Main_Settings['oauth_secret'];
            } else {
                $oauth_secret = '';
            }
            if (isset($youtubomatic_Main_Settings['oauth_key'])) {
                $oauth_key = $youtubomatic_Main_Settings['oauth_key'];
            } else {
                $oauth_key = '';
            }
            if (isset($youtubomatic_Main_Settings['youtubomatic_notice_enabled'])) {
                $youtubomatic_notice_enabled = $youtubomatic_Main_Settings['youtubomatic_notice_enabled'];
            } else {
                $youtubomatic_notice_enabled = '';
            }
            if (isset($youtubomatic_Main_Settings['continue_search'])) {
                $continue_search = $youtubomatic_Main_Settings['continue_search'];
            } else {
                $continue_search = '';
            }
            if (isset($youtubomatic_Main_Settings['copy_images'])) {
                $copy_images = $youtubomatic_Main_Settings['copy_images'];
            } else {
                $copy_images = '';
            }
            if (isset($youtubomatic_Main_Settings['no_local_image'])) {
                $no_local_image = $youtubomatic_Main_Settings['no_local_image'];
            } else {
                $no_local_image = '';
            }
            if (isset($youtubomatic_Main_Settings['wide_images'])) {
                $wide_images = $youtubomatic_Main_Settings['wide_images'];
            } else {
                $wide_images = '';
            }
            if (isset($youtubomatic_Main_Settings['resize_width'])) {
                $resize_width = $youtubomatic_Main_Settings['resize_width'];
            } else {
                $resize_width = '';
            }
            if (isset($youtubomatic_Main_Settings['resize_height'])) {
                $resize_height = $youtubomatic_Main_Settings['resize_height'];
            } else {
                $resize_height = '';
            }
            if (isset($youtubomatic_Main_Settings['fix_html'])) {
                $fix_html = $youtubomatic_Main_Settings['fix_html'];
            } else {
                $fix_html = '';
            }
            if (isset($youtubomatic_Main_Settings['only_auto'])) {
                $only_auto = $youtubomatic_Main_Settings['only_auto'];
            } else {
                $only_auto = '';
            }
            if (isset($youtubomatic_Main_Settings['image_ad'])) {
                $image_ad = $youtubomatic_Main_Settings['image_ad'];
            } else {
                $image_ad = '';
            }
            if (isset($youtubomatic_Main_Settings['image_ad_url'])) {
                $image_ad_url = $youtubomatic_Main_Settings['image_ad_url'];
            } else {
                $image_ad_url = '';
            }
            if (isset($youtubomatic_Main_Settings['proxy_url'])) {
                $proxy_url = $youtubomatic_Main_Settings['proxy_url'];
            } else {
                $proxy_url = '';
            }
            if (isset($youtubomatic_Main_Settings['proxy_auth'])) {
                $proxy_auth = $youtubomatic_Main_Settings['proxy_auth'];
            } else {
                $proxy_auth = '';
            }
            if (isset($youtubomatic_Main_Settings['post_source_custom'])) {
                $post_source_custom = $youtubomatic_Main_Settings['post_source_custom'];
            } else {
                $post_source_custom = '';
            }
            if (isset($youtubomatic_Main_Settings['scrapeimg_height'])) {
                $scrapeimg_height = $youtubomatic_Main_Settings['scrapeimg_height'];
            } else {
                $scrapeimg_height = '';
            }
            if (isset($youtubomatic_Main_Settings['attr_text'])) {
                $attr_text = $youtubomatic_Main_Settings['attr_text'];
            } else {
                $attr_text = '';
            }
            if (isset($youtubomatic_Main_Settings['scrapeimg_width'])) {
                $scrapeimg_width = $youtubomatic_Main_Settings['scrapeimg_width'];
            } else {
                $scrapeimg_width = '';
            }
            if (isset($youtubomatic_Main_Settings['scrapeimg_cat'])) {
                $scrapeimg_cat = $youtubomatic_Main_Settings['scrapeimg_cat'];
            } else {
                $scrapeimg_cat = '';
            }
            if (isset($youtubomatic_Main_Settings['scrapeimg_order'])) {
                $scrapeimg_order = $youtubomatic_Main_Settings['scrapeimg_order'];
            } else {
                $scrapeimg_order = '';
            }
            if (isset($youtubomatic_Main_Settings['scrapeimg_orientation'])) {
                $scrapeimg_orientation = $youtubomatic_Main_Settings['scrapeimg_orientation'];
            } else {
                $scrapeimg_orientation = '';
            }
            if (isset($youtubomatic_Main_Settings['imgtype'])) {
                $imgtype = $youtubomatic_Main_Settings['imgtype'];
            } else {
                $imgtype = '';
            }
            if (isset($youtubomatic_Main_Settings['img_order'])) {
                $img_order = $youtubomatic_Main_Settings['img_order'];
            } else {
                $img_order = '';
            }
            if (isset($youtubomatic_Main_Settings['scrapeimgtype'])) {
                $scrapeimgtype = $youtubomatic_Main_Settings['scrapeimgtype'];
            } else {
                $scrapeimgtype = '';
            }
            if (isset($youtubomatic_Main_Settings['pixabay_scrape'])) {
                $pixabay_scrape = $youtubomatic_Main_Settings['pixabay_scrape'];
            } else {
                $pixabay_scrape = '';
            }
            if (isset($youtubomatic_Main_Settings['unsplash_api'])) {
                $unsplash_api = $youtubomatic_Main_Settings['unsplash_api'];
            } else {
                $unsplash_api = '';
            }
            if (isset($youtubomatic_Main_Settings['img_editor'])) {
                $img_editor = $youtubomatic_Main_Settings['img_editor'];
            } else {
                $img_editor = '';
            }
            if (isset($youtubomatic_Main_Settings['img_language'])) {
                $img_language = $youtubomatic_Main_Settings['img_language'];
            } else {
                $img_language = '';
            }
            if (isset($youtubomatic_Main_Settings['img_ss'])) {
                $img_ss = $youtubomatic_Main_Settings['img_ss'];
            } else {
                $img_ss = '';
            }
            if (isset($youtubomatic_Main_Settings['img_mwidth'])) {
                $img_mwidth = $youtubomatic_Main_Settings['img_mwidth'];
            } else {
                $img_mwidth = '';
            }
            if (isset($youtubomatic_Main_Settings['img_width'])) {
                $img_width = $youtubomatic_Main_Settings['img_width'];
            } else {
                $img_width = '';
            }
            if (isset($youtubomatic_Main_Settings['img_cat'])) {
                $img_cat = $youtubomatic_Main_Settings['img_cat'];
            } else {
                $img_cat = '';
            }
            if (isset($youtubomatic_Main_Settings['pixabay_api'])) {
                $pixabay_api = $youtubomatic_Main_Settings['pixabay_api'];
            } else {
                $pixabay_api = '';
            }
            if (isset($youtubomatic_Main_Settings['pexels_api'])) {
                $pexels_api = $youtubomatic_Main_Settings['pexels_api'];
            } else {
                $pexels_api = '';
            }
            if (isset($youtubomatic_Main_Settings['morguefile_secret'])) {
                $morguefile_secret = $youtubomatic_Main_Settings['morguefile_secret'];
            } else {
                $morguefile_secret = '';
            }
            if (isset($youtubomatic_Main_Settings['morguefile_api'])) {
                $morguefile_api = $youtubomatic_Main_Settings['morguefile_api'];
            } else {
                $morguefile_api = '';
            }
            if (isset($youtubomatic_Main_Settings['bimage'])) {
                $bimage = $youtubomatic_Main_Settings['bimage'];
            } else {
                $bimage = '';
            }
            if (isset($youtubomatic_Main_Settings['no_orig'])) {
                $no_orig = $youtubomatic_Main_Settings['no_orig'];
            } else {
                $no_orig = '';
            }
            if (isset($youtubomatic_Main_Settings['flickr_order'])) {
                $flickr_order = $youtubomatic_Main_Settings['flickr_order'];
            } else {
                $flickr_order = '';
            }
            if (isset($youtubomatic_Main_Settings['flickr_license'])) {
                $flickr_license = $youtubomatic_Main_Settings['flickr_license'];
            } else {
                $flickr_license = '';
            }
            if (isset($youtubomatic_Main_Settings['flickr_api'])) {
                $flickr_api = $youtubomatic_Main_Settings['flickr_api'];
            } else {
                $flickr_api = '';
            }
            $get_option_viewed = get_option('coderevolution_settings_viewed', 0);
            if ($get_option_viewed == 0) {
            ?>
         <div id="message" class="updated">
            <p class="cr_saved_notif"><strong>&nbsp;<?php echo sprintf( wp_kses( __( 'Did you see our new <a href="%s" target="_blank">recommendations page</a>? It will help you increase your passive earnings!', 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'admin.php?page=youtubomatic_recommendations' ) );?></strong></p>
         </div>
         <?php
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
                           <span class="gs-sub-heading"><b>Youtubomatic Automatic Post Generator Plugin - <?php echo esc_html__('Main Switch:', 'youtubomatic-youtube-post-generator');?></b>&nbsp;</span>
                           <span class="cr_07_font">v2.5&nbsp;</span>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Enable or disable this plugin. This acts like a main switch.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                        </h1>
                     </td>
                     <td>
                        <div class="slideThree">	
                           <input class="input-checkbox" type="checkbox" id="youtubomatic_enabled" name="youtubomatic_Main_Settings[youtubomatic_enabled]"<?php
                              if ($youtubomatic_enabled == 'on')
                                  echo ' checked ';
                              ?>>
                           <label for="youtubomatic_enabled"></label>
                        </div>
                     </td>
                  </tr>
               </table>
            </div>
            <div><?php if($youtubomatic_enabled != 'on'){echo '<div class="crf_bord cr_color_red cr_auto_update">' . esc_html__('This feature of the plugin is disabled! Please enable it from the above switch.', 'youtubomatic-youtube-post-generator') . '</div>';}?>
               <table>
                  <tr>
                     <td colspan="2">
                        <?php
                           $plugin = plugin_basename(__FILE__);
                           $plugin_slug = explode('/', $plugin);
                           $plugin_slug = $plugin_slug[0]; 
                           $uoptions = get_option($plugin_slug . '_registration', array());
                           if(isset($uoptions['item_id']) && isset($uoptions['item_name']) && isset($uoptions['created_at']) && isset($uoptions['buyer']) && isset($uoptions['licence']) && isset($uoptions['supported_until']))
                           {
                           ?>
                        <h3><b><?php echo esc_html__("Plugin Registration Info - Automatic Updates Enabled:", 'youtubomatic-youtube-post-generator');?></b> </h3>
                        <ul>
                           <li><b><?php echo esc_html__("Item Name:", 'youtubomatic-youtube-post-generator');?></b> <?php echo esc_html($uoptions['item_name']);?></li>
                           <li>
                              <b><?php echo esc_html__("Item ID:", 'youtubomatic-youtube-post-generator');?></b> <?php echo esc_html($uoptions['item_id']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Created At:", 'youtubomatic-youtube-post-generator');?></b> <?php echo esc_html($uoptions['created_at']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Buyer Name:", 'youtubomatic-youtube-post-generator');?></b> <?php echo esc_html($uoptions['buyer']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("License Type:", 'youtubomatic-youtube-post-generator');?></b> <?php echo esc_html($uoptions['licence']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Supported Until:", 'youtubomatic-youtube-post-generator');?></b> <?php echo esc_html($uoptions['supported_until']);?>
                           </li>
                        </ul>
                        <?php
                           }
                           else
                           {
                           ?>
                        <div class="notice notice-error is-dismissible"><p><?php echo esc_html__("Automatic updates for this plugin are disabled. Please activate the plugin from below, so you can benefit of automatic updates for it!", 'youtubomatic-youtube-post-generator');?></p></div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo sprintf( wp_kses( __( 'Please input your Envato purchase code, to enable automatic updates in the plugin. To get your purchase code, please follow <a href="%s" target="_blank">this tutorial</a>. Info submitted to the registration server consists of: purchase code, site URL, site name, admin email. All these data will be used strictly for registration purposes.', 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//coderevolution.ro/knowledge-base/faq/how-do-i-find-my-items-purchase-code-for-plugin-license-activation/' ) );
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Register Envato Purchase Code To Enable Automatic Updates:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td><input type="text" name="<?php echo esc_html($plugin_slug);?>_register_code" value="" placeholder="<?php echo esc_html__("Envato Purchase Code", 'youtubomatic-youtube-post-generator');?>"></td>
                  </tr>
                  <tr>
                     <td></td>
                     <td><input type="submit" name="<?php echo esc_html($plugin_slug);?>_register" id="<?php echo esc_html($plugin_slug);?>_register" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Register Purchase Code", 'youtubomatic-youtube-post-generator');?>"/>
                        <?php
                           }
                           ?>
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
               <tr><td colspan="2">
               <h3>
                  <ul>
                     <li><?php echo sprintf( wp_kses( __( 'Need help configuring this plugin? Please check out it\'s <a href="%s" target="_blank">video tutorial</a>.', 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.youtube.com/watch?v=3RF3hNvdO90&list=PLEiGTaa0iBIhzwV5VhpV7kgUuClLNpP9i' ) );?>
                     </li>
                     <li><?php echo sprintf( wp_kses( __( 'Having issues with the plugin? Please be sure to check out our <a href="%s" target="_blank">knowledge-base</a> before you contact <a href="%s" target="_blank">our support</a>!', 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//coderevolution.ro/knowledge-base' ), esc_url('//coderevolution.ro/support' ) );?></li>
                     <li><?php echo sprintf( wp_kses( __( 'Do you enjoy our plugin? Please give it a <a href="%s" target="_blank">rating</a>  on CodeCanyon, or check <a href="%s" target="_blank">our website</a>  for other cool plugins.', 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//codecanyon.net/downloads' ), esc_url( 'https://coderevolution.ro' ) );?></a></li>
                     <li><br/><br/><span class="cr_color_red"><?php echo esc_html__("Are you looking for a cool new theme that best fits this plugin?", 'youtubomatic-youtube-post-generator');?></span> <a onclick="revealRec()" class="cr_cursor_pointer"><?php echo esc_html__("Click here for our theme related recommendation", 'youtubomatic-youtube-post-generator');?></a>.
                        <br/><span id="diviIdrec"></span>
                     </li>
                  </ul>
               </h3>
</td>
               </tr>
                  <tr>
                     <td colspan="2">
                        <div class="hideInfo">
                           <h3><?php echo esc_html__("If you want to post from YouTube to WordPress you need to get a YouTube API Key:", 'youtubomatic-youtube-post-generator');?></h3>
                           <h4><b><span class="cr_color_red"><?php echo esc_html__("Info: You have to create a YouTube App before filling the following details (if you do not have one). Please click", 'youtubomatic-youtube-post-generator');?> <a href="https://console.developers.google.com/iam-admin/projects" target="_blank"><?php echo esc_html__("here", 'youtubomatic-youtube-post-generator');?></a> <?php echo esc_html__("to get a new YouTube API Key. Go to -> Create Project -> 'YouTube Data API' -> Enable API -> Create Credentials to create new YouTube API Key", 'youtubomatic-youtube-post-generator');?>.</span></b></h4>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your YouTube API Key. Learn how to get one <a href='%s' target='_blank'>here</a>. This is used when posting from YouTube to WordPress. You can also enter a comma separated list of multiple API keys.", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://console.developers.google.com/iam-admin/projects' ) );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("YouTube API Key List:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="app_id" name="youtubomatic_Main_Settings[app_id]" value="<?php
                              echo esc_html($app_id);
                              ?>" placeholder="<?php echo esc_html__("Please insert your YouTube API Key. You can also insert a list of comma separated API keys. The plugin will select one to user, each time when it runs, at random.", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td></td>
                     <td><br/><input type="submit" name="btnSubmitApp" id="btnSubmitApp" class="button button-primary" onclick="unsaved = false;" value="Save API Key Info"/>
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
                     <td colspan="2">
                        <div class="hideInfo2">
                           <h3><?php echo esc_html__("If you want to post from WordPress to YouTube you need to get a YouTube OAuth Key and Secret:", 'youtubomatic-youtube-post-generator');?></h3>
                           <h4><b><span class="cr_color_red"><?php echo esc_html__("Info: You have to create a YouTube OAuth Key and Secret before filling the following details (if you do not have one). Please click", 'youtubomatic-youtube-post-generator');?> <a href="https://console.developers.google.com/iam-admin/projects" target="_blank"><?php echo esc_html__("to get a new YouTube OAuth Key. Go to -> Create Project -> 'YouTube Data API' -> Enable API -> Create Credentials to create new YouTube API Key. Set the 'Authorized redirect URIs' of your OAuth key to the following URL (otherwise authorization will not work!)", 'youtubomatic-youtube-post-generator');?></a> <?php echo esc_html__("here", 'youtubomatic-youtube-post-generator');?>:<br/><span class="cr_red"><?php echo site_url() . '/wp-admin/admin.php?page=youtubomatic_youtube_panel&yt_auth_done=true';?></span></span></b></h4>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your YouTube OAuth2 Key. Learn how to get one <a href='%s' target='_blank'>here</a>. This is used when posting from WordPress to YouTube. Please set the <b>'Authorized redirect URIs'</b> of your OAuth key to the following URL (otherwise authorization will not work!): <span class='cr_red'>%s</span>", 'youtubomatic-youtube-post-generator'), array(  'span' => array('class' => array()), 'b' => array(), 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://console.developers.google.com/iam-admin/projects' ), esc_url(site_url() . '/wp-admin/admin.php?page=youtubomatic_youtube_panel&yt_auth_done=true') );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("YouTube OAuth2 Key:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="oauth_key" name="youtubomatic_Main_Settings[oauth_key]" value="<?php
                              echo esc_html($oauth_key);
                              ?>" placeholder="<?php echo esc_html__("Please insert your YouTube OAuth2 Key", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your YouTube OAuth2 Secret. Learn how to get one <a href='%s' target='_blank'>here</a>. This is used when posting from WordPress to YouTube. Please set the <b>'Authorized redirect URIs'</b> of your OAuth key to the following URL (otherwise authorization will not work!): <span class='cr_red'>%s</span>", 'youtubomatic-youtube-post-generator'), array(  'span' => array('class' => array()), 'b' => array(), 'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://console.developers.google.com/iam-admin/projects' ), esc_url(site_url() . '/wp-admin/admin.php?page=youtubomatic_youtube_panel&yt_auth_done=true') );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("YouTube OAuth2 Secret:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="password" autocomplete="off" id="oauth_secret" name="youtubomatic_Main_Settings[oauth_secret]" value="<?php
                              echo esc_html($oauth_secret);
                              ?>" placeholder="<?php echo esc_html__("Please insert your YouTube OAuth2 Secret", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td></td>
                     <td><br/><input type="submit" name="btnSubmitApp" id="btnSubmitApp" class="button button-primary" onclick="unsaved = false;" value="Save OAuth Info"/>
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
                        <h3><?php echo esc_html__("After you entered the API Key, you can start creating rules:", 'youtubomatic-youtube-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td><a name="newest" href="admin.php?page=youtubomatic_items_panel">- YouTube -> <?php echo esc_html__("Blog Posts", 'youtubomatic-youtube-post-generator');?> -</a></td>
                     <td>
                        (<?php echo esc_html__("using feeds from YouTube search queries", 'youtubomatic-youtube-post-generator');?>)
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Posts will be generated from the latest entries in YouTube search queries.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td><a name="user" href="admin.php?page=youtubomatic_youtube_panel">- <?php echo esc_html__("Blog Posts", 'youtubomatic-youtube-post-generator');?> -> YouTube -</a></td>
                     <td>
                        (<?php echo esc_html__("using latest published posts from your blog", 'youtubomatic-youtube-post-generator');?>)
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("YouTube posts will be generated from the latest published blog posts. Posts will be posted by the YouTube user associated with the API Key entered.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
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
                        <h3><?php echo esc_html__("Plugin Options:", 'youtubomatic-youtube-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Check this to force the plugin not check generated posts in rule settings. Improves performance if you have 100k posts generated using this plugin.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Do Not Check Generated Posts In Rule Settings:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="no_check" name="youtubomatic_Main_Settings[no_check]"<?php
                           if ($no_check == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Check this to disable duplicate post checking while importing. This checks posts by imported video ID.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Do Not Check For Duplicate Posts (by video ID):", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="no_dup_check" name="youtubomatic_Main_Settings[no_dup_check]"<?php
                           if ($no_dup_check == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Check also post titles for duplicates.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Enable Checking Post Titles For Duplicates:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="title_dup" name="youtubomatic_Main_Settings[title_dup]"<?php
                           if ($title_dup == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to enable or disable the 'Please wait while Youtubomatic plugin uploads videos to YouTube!' notice in the publish page interface in WordPress.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Warning Notice And Progress Bar at Post Publish:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="youtubomatic_notice_enabled" name="youtubomatic_Main_Settings[youtubomatic_notice_enabled]" onchange="mainChanged();"<?php
                        if ($youtubomatic_notice_enabled == 'on')
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
                                    echo esc_html__("Choose if you want to get as many posts as possible each time from the YouTube API, and filter the video results afterwards. If you uncheck this, the plugin will get from the API, the number of videos that you set in the 'Max' parameter for importing rules.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Get As Many Videos As Possible From The YouTube API:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="continue_search" name="youtubomatic_Main_Settings[continue_search]" onchange="mainChanged();"<?php
                        if ($continue_search == 'on')
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
                                    echo esc_html__("Choose if you want to show an extended information metabox under every plugin generated post.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Show Extended Item Information Metabox in Post:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="enable_metabox" name="youtubomatic_Main_Settings[enable_metabox]"<?php
                        if ($enable_metabox == 'on')
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
                                    echo esc_html__("Do you want to enable logging for rules?", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Logging for Rules:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="enable_logging" name="youtubomatic_Main_Settings[enable_logging]" onclick="mainChanged()"<?php
                        if ($enable_logging == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideLog">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to enable detailed logging for rules? Note that this will dramatically increase the size of the log this plugin generates.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Detailed Logging for Rules:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideLog">
                           <input type="checkbox" id="enable_detailed_logging" name="youtubomatic_Main_Settings[enable_detailed_logging]"<?php
                              if ($enable_detailed_logging == 'on')
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
                                    echo esc_html__("Select a secret word that will be used when you run the plugin manually/by cron. See details about this below.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Secret Word Used For Manual/Cron Running:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="text" id="secret_word" name="youtubomatic_Main_Settings[secret_word]" value="<?php echo esc_html($secret_word);?>" placeholder="<?php echo esc_html__("Input a secret word", 'youtubomatic-youtube-post-generator');?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div>
                           <br/><b><?php echo esc_html__("When replacing wp-cron with Linux cron, you should schedule this address in cron:", 'youtubomatic-youtube-post-generator');?> <span class="cr_red"><?php if($secret_word != '') { echo get_site_url() . '/?run_youtubomatic=' . $secret_word;} else { echo esc_html__('You must enter a secret word above, to use this feature.', 'youtubomatic-youtube-post-generator'); }?></span><br/>Example: <span class="cr_red"><?php if($secret_word != '') { echo '15,45****wget -q -O /dev/null ' . get_site_url() . '/?run_youtubomatic=' . $secret_word;} else { echo esc_html__('You must enter a secret word above, to use this feature.', 'youtubomatic-youtube-post-generator'); }?></span></b>
                        </div>
                        <br/><br/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideLog">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to automatically clear logs after a period of time.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Automatically Clear Logs After:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideLog">
                           <select id="auto_clear_logs" name="youtubomatic_Main_Settings[auto_clear_logs]" >
                              <option value="No"<?php
                                 if ($auto_clear_logs == "No") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Disabled", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="monthly"<?php
                                 if ($auto_clear_logs == "monthly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a month", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="weekly"<?php
                                 if ($auto_clear_logs == "weekly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a week", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="daily"<?php
                                 if ($auto_clear_logs == "daily") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a day", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="twicedaily"<?php
                                 if ($auto_clear_logs == "twicedaily") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Twice a day", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="hourly"<?php
                                 if ($auto_clear_logs == "hourly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once an hour", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("Choose if you want to disable automatic loading of YouTube related scripts in your pages. If you are using this plugin to just automatically publish your posts, you can check this checkbox.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Disabled Loading of YouTube Related Scripts:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="disable_scripts" name="youtubomatic_Main_Settings[disable_scripts]"<?php
                        if ($disable_scripts == 'on')
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
                                    echo esc_html__("Set the timeout (in seconds) for every rule running. I recommend that you leave this field at it's default value (3600).", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Timeout for Rule Running (seconds):", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="rule_timeout" step="1" min="0" placeholder="<?php echo esc_html__("Input rule timeout in seconds", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[rule_timeout]" value="<?php
                              echo esc_html($rule_timeout);
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
                                    echo esc_html__("Define a number of seconds the plugin should wait between the rule running. Use this to not decrease the use of your server's resources. Leave blank to disable.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Delay Between Rule Running:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="rule_delay" min="0" step="1" name="youtubomatic_Main_Settings[rule_delay]" value="<?php echo esc_html($rule_delay);?>" placeholder="<?php echo esc_html__("delay (s)", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to receive a summary of the rule running in an email.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Send Rule Running Summary in Email:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="send_email" name="youtubomatic_Main_Settings[send_email]" onchange="mainChanged()"<?php
                        if ($send_email == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideMail">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input the email adress where you want to send the report. You can input more email addresses, separated by commas.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Email Address:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideMail">
                           <input type="email" id="email_address" placeholder="<?php echo esc_html__("Input a valid email adress", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[email_address]" value="<?php
                              echo esc_html($email_address);
                              ?>">
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
                        <h3><?php echo esc_html__("Image Options:", 'youtubomatic-youtube-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Click this option if your want to save images found in post content locally. Note that this option may be heavy on your hosting free space.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Copy Images From Content Locally:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="copy_images" name="youtubomatic_Main_Settings[copy_images]"<?php
                        if ($copy_images == 'on')
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
                                    echo esc_html__("Click this option if your want to set the featured image from the remote image location. This settings can save disk space, but beware that if the remote image gets deleted, your featured image will also be broken.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Do Not Copy Featured Image Locally:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="no_local_image" name="youtubomatic_Main_Settings[no_local_image]"<?php
                        if ($no_local_image == 'on')
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
                                    echo esc_html__("Click this option if your want to use medium resolution images as featured images, instead of high res ones.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Type To Import:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <select id="wide_images" name="youtubomatic_Main_Settings[wide_images]">
                     <option value="43"
                        <?php
                           if ($wide_images == '43') {
                               echo ' selected';
                           }
                           ?>
                        >4:3</option>
                     <option value="169"
                        <?php
                           if ($wide_images == '169') {
                               echo ' selected';
                           }
                           ?>
                        >16:9</option>
                     <option value="full"
                        <?php
                           if ($wide_images == 'full') {
                               echo ' selected';
                           }
                           ?>
                        ><?php echo esc_html__("Maximum Resolution", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("Resize the image that was assigned to be the featured image to the width specified in this text field (in pixels). If you want to disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Resize Width:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" name="youtubomatic_Main_Settings[resize_width]" value="<?php echo esc_html($resize_width);?>" placeholder="<?php echo esc_html__("Please insert the desired width for featured images", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Resize the image that was assigned to be the featured image to the height specified in this text field (in pixels). If you want to disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Resize Height:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" name="youtubomatic_Main_Settings[resize_height]" value="<?php echo esc_html($resize_height);?>" placeholder="<?php echo esc_html__("Please insert the desired height for featured images", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("Royalty Free Featured Image Importing Options:", 'youtubomatic-youtube-post-generator');?></h3>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your MorgueFile App ID. Register <a href='%s' target='_blank'>here</a>. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the MorgueFile API.", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://morguefile.com/?mfr18=37077f5764c83cc98123ef1166ce2aa6" ),  esc_url( "https://morguefile.com/developer" ) );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("MorgueFile App ID:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="youtubomatic_Main_Settings[morguefile_api]" value="<?php
                              echo esc_html($morguefile_api);
                              ?>" placeholder="<?php echo esc_html__("Please insert your MorgueFile API key", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your MorgueFile App Secret. Register <a href='%s' target='_blank'>here</a>. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the MorgueFile API.", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://morguefile.com/?mfr18=37077f5764c83cc98123ef1166ce2aa6" ),  esc_url( "https://morguefile.com/developer" ) );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("MorgueFile App Secret:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="youtubomatic_Main_Settings[morguefile_secret]" value="<?php
                              echo esc_html($morguefile_secret);
                              ?>" placeholder="<?php echo esc_html__("Please insert your MorgueFile API Secret", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                  <tr>
                     <td colspan="2">
                        <hr class="cr_dotted"/>
                     </td>
                  </tr>
                  </td></tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your Pexels App ID. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the Pexels API.", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://www.pexels.com/api/" ));
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Pexels App ID:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="youtubomatic_Main_Settings[pexels_api]" value="<?php
                              echo esc_html($pexels_api);
                              ?>" placeholder="<?php echo esc_html__("Please insert your Pexels API key", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <hr class="cr_dotted"/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo sprintf( wp_kses( __( "Insert your Flickr App ID. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the Flickr API.", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://www.flickr.com/services/apps/create/apply" ));
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Flickr App ID: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <input type="text" name="youtubomatic_Main_Settings[flickr_api]" placeholder="<?php echo esc_html__("Please insert your Flickr APP ID", 'youtubomatic-youtube-post-generator');?>" value="<?php if(isset($flickr_api)){echo esc_html($flickr_api);}?>" class="cr_width_full" />
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("The license id for photos to be searched.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Photo License: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <select name="youtubomatic_Main_Settings[flickr_license]" class="cr_width_full">
                           <option value="-1" 
                              <?php
                                 if($flickr_license == '-1')
                                 {
                                     echo ' selected';
                                 }
                                 ?>
                              ><?php echo esc_html__("Do Not Search By Photo Licenses", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="0"
                              <?php
                                 if($flickr_license == '0')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("All Rights Reserved", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="1"
                              <?php
                                 if($flickr_license == '1')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NonCommercial-ShareAlike License", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="2"
                              <?php
                                 if($flickr_license == '2')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NonCommercial License", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="3"
                              <?php
                                 if($flickr_license == '3')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NonCommercial-NoDerivs License", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="4"
                              <?php
                                 if($flickr_license == '4')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution License", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="5"
                              <?php
                                 if($flickr_license == '5')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-ShareAlike License", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="6"
                              <?php
                                 if($flickr_license == '6')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NoDerivs License", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="7"
                              <?php
                                 if($flickr_license == '7')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("No known copyright restrictions", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="8"
                              <?php
                                 if($flickr_license == '8')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("United States Government Work", 'youtubomatic-youtube-post-generator');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("The order in which to sort returned photos. Deafults to date-posted-desc (unless you are doing a radial geo query, in which case the default sorting is by ascending distance from the point specified).", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Search Results Order: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <select name="youtubomatic_Main_Settings[flickr_order]" class="cr_width_full">
                           <option value="date-posted-desc"
                              <?php
                                 if($flickr_order == 'date-posted-desc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Posted Descendant", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="date-posted-asc"
                              <?php
                                 if($flickr_order == 'date-posted-asc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Posted Ascendent", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="date-taken-asc"
                              <?php
                                 if($flickr_order == 'date-taken-asc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Taken Ascendent", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="date-taken-desc"
                              <?php
                                 if($flickr_order == 'date-taken-desc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Taken Descendant", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="interestingness-desc"
                              <?php
                                 if($flickr_order == 'interestingness-desc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Interestingness Descendant", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="interestingness-asc"
                              <?php
                                 if($flickr_order == 'interestingness-asc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Interestingness Ascendant", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="relevance"
                              <?php
                                 if($flickr_order == 'relevance')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Relevance", 'youtubomatic-youtube-post-generator');?></option>
                        </select>
                  <tr>
                     <td colspan="2">
                        <hr class="cr_dotted"/>
                     </td>
                  </tr>
                  </td></tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your Pixabay App ID. Learn how to get one <a href='%s' target='_blank'>here</a>. If you enter an API Key here, you will enable search for images using the Pixabay API.", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://pixabay.com/api/docs/" ) );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Pixabay App ID:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="youtubomatic_Main_Settings[pixabay_api]" value="<?php
                              echo esc_html($pixabay_api);
                              ?>" placeholder="<?php echo esc_html__("Please insert your Pixabay API key", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Filter results by image type.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Image Types To Search:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select class="cr_width_full" name="youtubomatic_Main_Settings[imgtype]" >
                              <option value='all'<?php
                                 if ($imgtype == 'all')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("All", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='photo'<?php
                                 if ($imgtype == 'photo')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("Photo", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='illustration'<?php
                                 if ($imgtype == 'illustration')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("Illustration", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='vector'<?php
                                 if ($imgtype == 'vector')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("Vector", 'youtubomatic-youtube-post-generator');?></option>
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Order results by a predefined rule.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Results Order: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <select name="youtubomatic_Main_Settings[img_order]" class="cr_width_full">
                           <option value="popular"<?php
                              if ($img_order == "popular") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Popular", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="latest"<?php
                              if ($img_order == "latest") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Latest", 'youtubomatic-youtube-post-generator');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Filter results by image category.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Category: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <select name="youtubomatic_Main_Settings[img_cat]" class="cr_width_full">
                           <option value="all"<?php
                              if ($img_cat == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="fashion"<?php
                              if ($img_cat == "fashion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Fashion", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="nature"<?php
                              if ($img_cat == "nature") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Nature", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="backgrounds"<?php
                              if ($img_cat == "backgrounds") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Backgrounds", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="science"<?php
                              if ($img_cat == "science") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Science", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="education"<?php
                              if ($img_cat == "education") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Education", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="people"<?php
                              if ($img_cat == "people") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("People", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="feelings"<?php
                              if ($img_cat == "feelings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Feelings", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="religion"<?php
                              if ($img_cat == "religion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Religion", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="health"<?php
                              if ($img_cat == "health") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Health", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="places"<?php
                              if ($img_cat == "places") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Places", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="animals"<?php
                              if ($img_cat == "animals") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Animals", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="industry"<?php
                              if ($img_cat == "industry") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Industry", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="food"<?php
                              if ($img_cat == "food") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Food", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="computer"<?php
                              if ($img_cat == "computer") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Computer", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="sports"<?php
                              if ($img_cat == "sports") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Sports", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="transportation"<?php
                              if ($img_cat == "transportation") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Transportation", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="travel"<?php
                              if ($img_cat == "travel") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Travel", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="buildings"<?php
                              if ($img_cat == "buildings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Buildings", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="business"<?php
                              if ($img_cat == "business") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Business", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="music"<?php
                              if ($img_cat == "music") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Music", 'youtubomatic-youtube-post-generator');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Minimum image width.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Min Width: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <input type="number" min="1" step="1" name="youtubomatic_Main_Settings[img_width]" value="<?php echo esc_html($img_width);?>" placeholder="<?php echo esc_html__("Please insert image min width", 'youtubomatic-youtube-post-generator');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Maximum image width.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Max Width: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <input type="number" min="1" step="1" name="youtubomatic_Main_Settings[img_mwidth]" value="<?php echo esc_html($img_mwidth);?>" placeholder="<?php echo esc_html__("Please insert image max width", 'youtubomatic-youtube-post-generator');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("A flag indicating that only images suitable for all ages should be returned.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Safe Search: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <input type="checkbox" name="youtubomatic_Main_Settings[img_ss]"<?php
                           if ($img_ss == 'on') {
                               echo ' checked="checked"';
                           }
                           ?> >
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select images that have received an Editor's Choice award.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Editor\'s Choice: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <input type="checkbox" name="youtubomatic_Main_Settings[img_editor]"<?php
                           if ($img_editor == 'on') {
                               echo ' checked="checked"';
                           }
                           ?> >
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Specify default language for regional content.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Filter Language: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <select name="youtubomatic_Main_Settings[img_language]" class="cr_width_full">
                           <option value="any"<?php
                              if ($img_language == "any") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Any", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="en"<?php
                              if ($img_language == "en") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("English", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="cs"<?php
                              if ($img_language == "cs") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Czech", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="da"<?php
                              if ($img_language == "da") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Danish", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="de"<?php
                              if ($img_language == "de") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("German", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="es"<?php
                              if ($img_language == "es") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Spanish", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="fr"<?php
                              if ($img_language == "fr") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("French", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="id"<?php
                              if ($img_language == "id") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Indonesian", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="it"<?php
                              if ($img_language == "it") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Italian", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="hu"<?php
                              if ($img_language == "hu") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Hungarian", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="nl"<?php
                              if ($img_language == "nl") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Dutch", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="no"<?php
                              if ($img_language == "no") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Norvegian", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="pl"<?php
                              if ($img_language == "pl") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Polish", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="pt"<?php
                              if ($img_language == "pt") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Portuguese", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="ro"<?php
                              if ($img_language == "ro") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Romanian", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="sk"<?php
                              if ($img_language == "sk") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Slovak", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="fi"<?php
                              if ($img_language == "fi") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Finish", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="sv"<?php
                              if ($img_language == "sv") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Swedish", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="tr"<?php
                              if ($img_language == "tr") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Turkish", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="vi"<?php
                              if ($img_language == "vi") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Vietnamese", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="th"<?php
                              if ($img_language == "th") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Thai", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="bg"<?php
                              if ($img_language == "bg") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Bulgarian", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="ru"<?php
                              if ($img_language == "ru") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Russian", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="el"<?php
                              if ($img_language == "el") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Greek", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="ja"<?php
                              if ($img_language == "ja") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Japanese", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="ko"<?php
                              if ($img_language == "ko") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Korean", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="zh"<?php
                              if ($img_language == "zh") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Chinese", 'youtubomatic-youtube-post-generator');?></option>
                        </select>
                     </td>
                  </tr>
                 <tr>
                    <td colspan="2">
                       <hr class="cr_dotted"/>
                    </td>
                 </tr>
                 <tr>
                    <td>
                       <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                          <div class="bws_hidden_help_text cr_min_260px">
                             <?php
                                echo esc_html__("Select if you want to enable usage of the Unsplash API for getting images.", 'youtubomatic-youtube-post-generator');
                                ?>
                          </div>
                       </div>
                       <b><?php esc_html_e('Enable Unsplash API Usage: ', 'youtubomatic-youtube-post-generator'); ?></b>
                    </td>
                    <td>
                       <input type="checkbox" name="youtubomatic_Main_Settings[unsplash_api]"<?php
                          if ($unsplash_api == 'on') {
                              echo ' checked="checked"';
                          }
                          ?> >
                    </td>
                 </tr>
                  <tr>
                     <td colspan="2">
                        <hr class="cr_dotted"/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select if you want to enable direct scraping of Pixabay website. This will generate different results from the API.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Enable Pixabay Direct Website Scraping: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <input type="checkbox" name="youtubomatic_Main_Settings[pixabay_scrape]"<?php
                           if ($pixabay_scrape == 'on') {
                               echo ' checked="checked"';
                           }
                           ?> >
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Filter results by image type.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Types To Search: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <select name="youtubomatic_Main_Settings[scrapeimgtype]" class="cr_width_full">
                           <option value="all"<?php
                              if ($scrapeimgtype == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="photo"<?php
                              if ($scrapeimgtype == "photo") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Photo", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="illustration"<?php
                              if ($scrapeimgtype == "illustration") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Illustration", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="vector"<?php
                              if ($scrapeimgtype == "vector") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Vector", 'youtubomatic-youtube-post-generator');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Filter results by image orientation.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Orientation: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <select name="youtubomatic_Main_Settings[scrapeimg_orientation]" class="cr_width_full">
                           <option value="all"<?php
                              if ($scrapeimg_orientation == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="horizontal"<?php
                              if ($scrapeimg_orientation == "horizontal") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Horizontal", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="vertical"<?php
                              if ($scrapeimg_orientation == "vertical") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Vertical", 'youtubomatic-youtube-post-generator');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Order results by a predefined rule.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Results Order: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <select name="youtubomatic_Main_Settings[scrapeimg_order]" class="cr_width_full">
                           <option value="any"<?php
                              if ($scrapeimg_order == "any") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Any", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="popular"<?php
                              if ($scrapeimg_order == "popular") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Popular", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="latest"<?php
                              if ($scrapeimg_order == "latest") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Latest", 'youtubomatic-youtube-post-generator');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Filter results by image category.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Category: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <select name="youtubomatic_Main_Settings[scrapeimg_cat]" class="cr_width_full">
                           <option value="all"<?php
                              if ($scrapeimg_cat == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="fashion"<?php
                              if ($scrapeimg_cat == "fashion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Fashion", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="nature"<?php
                              if ($scrapeimg_cat == "nature") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Nature", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="backgrounds"<?php
                              if ($scrapeimg_cat == "backgrounds") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Backgrounds", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="science"<?php
                              if ($scrapeimg_cat == "science") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Science", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="education"<?php
                              if ($scrapeimg_cat == "education") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Education", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="people"<?php
                              if ($scrapeimg_cat == "people") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("People", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="feelings"<?php
                              if ($scrapeimg_cat == "feelings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Feelings", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="religion"<?php
                              if ($scrapeimg_cat == "religion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Religion", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="health"<?php
                              if ($scrapeimg_cat == "health") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Health", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="places"<?php
                              if ($scrapeimg_cat == "places") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Places", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="animals"<?php
                              if ($scrapeimg_cat == "animals") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Animals", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="industry"<?php
                              if ($scrapeimg_cat == "industry") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Industry", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="food"<?php
                              if ($scrapeimg_cat == "food") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Food", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="computer"<?php
                              if ($scrapeimg_cat == "computer") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Computer", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="sports"<?php
                              if ($scrapeimg_cat == "sports") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Sports", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="transportation"<?php
                              if ($scrapeimg_cat == "transportation") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Transportation", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="travel"<?php
                              if ($scrapeimg_cat == "travel") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Travel", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="buildings"<?php
                              if ($scrapeimg_cat == "buildings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Buildings", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="business"<?php
                              if ($scrapeimg_cat == "business") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Business", 'youtubomatic-youtube-post-generator');?></option>
                           <option value="music"<?php
                              if ($scrapeimg_cat == "music") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Music", 'youtubomatic-youtube-post-generator');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Minimum image width.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Min Width: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <input type="number" min="1" step="1" name="youtubomatic_Main_Settings[scrapeimg_width]" value="<?php echo esc_html($scrapeimg_width);?>" placeholder="<?php echo esc_html__("Please insert image min width", 'youtubomatic-youtube-post-generator');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Maximum image height.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Min Height: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <input type="number" min="1" step="1" name="youtubomatic_Main_Settings[scrapeimg_height]" value="<?php echo esc_html($scrapeimg_height);?>" placeholder="<?php echo esc_html__("Please insert image min height", 'youtubomatic-youtube-post-generator');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <hr class="cr_dotted"/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Please set a the image attribution shortcode value. You can use this value, using the %%image_attribution%% shortcode, in 'Prepend Content With' and 'Append Content With' settings fields. You can use the following shortcodes, in this settings field: %%image_source_name%%, %%image_source_website%%, %%image_source_url%%. These will be updated automatically for the respective image source, from where the imported image is from. This will replace the %%royalty_free_image_attribution%% shortcode, in 'Generated Post Content' settings field.", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Royalty Free Image Attribution Text (%%royalty_free_image_attribution%%): ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <input type="text" name="youtubomatic_Main_Settings[attr_text]" value="<?php echo esc_html(stripslashes($attr_text));?>" placeholder="<?php echo esc_html__("Please insert image attribution text pattern", 'youtubomatic-youtube-post-generator');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to enable broad search for royalty free images?", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Enable broad image search: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <input type="checkbox" name="youtubomatic_Main_Settings[bimage]" <?php
                           if ($bimage == 'on') {
                               echo 'checked="checked"';
                           }
                           ?> />
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to not use article's original image if no royalty free image found for the post?", 'youtubomatic-youtube-post-generator');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Do Not Use Original Image If No Free Image Found: ', 'youtubomatic-youtube-post-generator'); ?></b>
                     </td>
                     <td>
                        <input type="checkbox" name="youtubomatic_Main_Settings[no_orig]" <?php
                           if ($no_orig == 'on') {
                               echo 'checked="checked"';
                           }
                           ?> />
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
                        <h3><?php echo esc_html__("Post Content Options:", 'youtubomatic-youtube-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <?php
                        if($shortest_api == '')
                        {
                            echo '<td colspan="2"><span><b>To enable outgoing link monetization, <a href="http://join-shortest.com/ref/ff421f2b06?user-type=new" target="_blank">sign up for a Shorte.st account here</a></b>. To get your API token after you have signed up, click <a href="https://shorte.st/tools/api?user-type=new" target="_blank">here</a>.</span><br/></td></tr><tr>';
                        }
                        ?>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "If you wish to shorten outgoing links using shorte.st, please enter your API token here. To sign up for a new account, click <a href='%s' target='_blank'>here</a>. To get your API token after you have signed up, click <a href='%s' target='_blank'>here</a>. To disable URL shortening, leave this field blank.", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "http://join-shortest.com/ref/ff421f2b06?user-type=new" ), esc_url( 'https://shorte.st/tools/api?user-type=new'));
                                    ?>
                              </div>
                           </div>
                           <b><a href="http://join-shortest.com/ref/ff421f2b06?user-type=new" target="_blank"><?php echo esc_html__("Shorte.st API Token", 'youtubomatic-youtube-post-generator');?></a>:</b>
                     </td>
                     <td>
                     <input type="text" name="youtubomatic_Main_Settings[shortest_api]" value="<?php
                        echo esc_html($shortest_api);
                        ?>" placeholder="<?php echo esc_html__("Shorte.st API token", 'youtubomatic-youtube-post-generator');?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Disable excerpt automatic generation for resulting blog posts.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Disable Automatic Excerpt Generation:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="disable_excerpt" name="youtubomatic_Main_Settings[disable_excerpt]"<?php
                        if ($disable_excerpt == 'on')
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
                                    echo esc_html__("Strip HTML elements from final content that have this IDs. You can insert more IDs, separeted by comma. To disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Strip HTML Elements from Final Content by ID:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="3" cols="70" name="youtubomatic_Main_Settings[strip_by_id]" placeholder="<?php echo esc_html__("Ids list", 'youtubomatic-youtube-post-generator');?>"><?php
                        echo esc_textarea($strip_by_id);
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
                                    echo esc_html__("Choose if you want to automatically link generated post titles back to the original YouTube video.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Link Generated Post's Title To YouTube Videos:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="link_back" name="youtubomatic_Main_Settings[link_back]"<?php
                        if ($link_back == 'on')
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
                                    echo esc_html__("Choose if you want to automatically redirect posts back to the original YouTube video.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Soft Redirect Posts To YouTube Videos:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="link_soft" name="youtubomatic_Main_Settings[link_soft]"<?php
                        if ($link_soft == 'on')
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
                                    echo sprintf( wp_kses( __( "Insert your Bitly API generic access token. To register at Bitly, please visit <a href='%s' target='_blank'>this link</a>. To get a generic access token, please click the menu icon on the top right of the web (after you log in) -> click the '>' sign next to your account name -> click the 'Generic Access Token' menu entry -> enter your password in the 'Password' field and click 'Generate Token'. Copy the resulting token here. To lean more about this, please check <a href='%s' target='_blank'>this video</a>.", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://bitly.com/a/sign_up?utm_content=site-free-button&utm_source=organic&utm_medium=website&utm_campaign=null&utm_cta=site-free-button' ), esc_url('//www.youtube.com/watch?v=vBfaNbS4xbs') );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Shorten Imported URLs To WordPress Using Bitly:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="links_hide" name="youtubomatic_Main_Settings[links_hide]" onchange="mainChanged();"<?php
                        if ($links_hide == 'on')
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
                                    echo sprintf( wp_kses( __( "Insert your Bitly API generic access token. To register at Bitly, please visit <a href='%s' target='_blank'>this link</a>. To get a generic access token, please click the menu icon on the top right of the web (after you log in) -> click the '>' sign next to your account name -> click the 'Generic Access Token' menu entry -> enter your password in the 'Password' field and click 'Generate Token'. Copy the resulting token here. To lean more about this, please check <a href='%s' target='_blank'>this video</a>.", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://bitly.com/a/sign_up?utm_content=site-free-button&utm_source=organic&utm_medium=website&utm_campaign=null&utm_cta=site-free-button' ), esc_url('//www.youtube.com/watch?v=vBfaNbS4xbs') );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Shorten Exported URLs To YouTube Using Bitly:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="links_hide_google2" name="youtubomatic_Main_Settings[links_hide_google2]" onclick="mainChanged()"<?php
                        if ($links_hide_google2 == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideGoo">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your Bitly API generic access token. To register at Bitly, please visit <a href='%s' target='_blank'>this link</a>. To get a generic access token, please click the menu icon on the top right of the web (after you log in) -> click the '>' sign next to your account name -> click the 'Generic Access Token' menu entry -> enter your password in the 'Password' field and click 'Generate Token'. Copy the resulting token here. To lean more about this, please check <a href='%s' target='_blank'>this video</a>.", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://bitly.com/a/sign_up?utm_content=site-free-button&utm_source=organic&utm_medium=website&utm_campaign=null&utm_cta=site-free-button' ), esc_url('//www.youtube.com/watch?v=vBfaNbS4xbs') );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Bitly API Generic Access Token:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideGoo">
                           <input type="text" name="youtubomatic_Main_Settings[apiKey]" value="<?php echo esc_html($apiKey);?>" placeholder="<?php echo esc_html__("Please insert your Bitly API Generic Access Token", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to strip links from the generated post content.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Strip Links From Generated Post Content:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="strip_links" name="youtubomatic_Main_Settings[strip_links]"<?php
                        if ($strip_links == 'on')
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
                                    echo esc_html__("Choose if you want to strip textual links from the generated post content.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Strip Textual Links From Post Content:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="strip_textual_links" name="youtubomatic_Main_Settings[strip_textual_links]"<?php
                        if ($strip_textual_links == 'on')
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
                                    echo esc_html__("Set the maximum word count for the article. To disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Limit Content Word Count:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="number" min="1" step="1" id="limit_words" name="youtubomatic_Main_Settings[limit_words]" value="<?php echo esc_html($limit_words);?>" placeholder="<?php echo esc_html__("Description word limit count", 'youtubomatic-youtube-post-generator');?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Strip HTML elements from final content that have this class. You can insert more classes, separeted by comma. To disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Strip HTML Elements from Final Content by Class:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="3" cols="70" name="youtubomatic_Main_Settings[strip_by_class]" placeholder="<?php echo esc_html__("Class list", 'youtubomatic-youtube-post-generator');?>"><?php
                        echo esc_textarea($strip_by_class);
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
                                    echo esc_html__("If you want to use a custom string for the 'Post Source' meta data assigned to posts, please input it here. If you will leave this blank, the default 'Post Source' value will be assigned to posts.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Custom 'Post Source' Post Meta Data:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="post_source_custom" placeholder="<?php echo esc_html__("Input a custom post source string", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[post_source_custom]" value="<?php echo esc_html($post_source_custom);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("If you want to use a proxy to crawl webpages, input it's address here. Required format: IP Address/URL:port", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Web Proxy Address:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="proxy_url" placeholder="<?php echo esc_html__("Input web proxy url", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[proxy_url]" value="<?php echo esc_html($proxy_url);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("If you want to use a proxy to crawl webpages, and it requires authentication, input it's authentication details here. Required format: username:password", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Web Proxy Authentication:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="proxy_auth" placeholder="<?php echo esc_html__("Input web proxy auth", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[proxy_auth]" value="<?php echo esc_html($proxy_auth);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to try to fix html tags that were incorrectly grabbed from source?", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Try To Fix Html Tags:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="fix_html" name="youtubomatic_Main_Settings[fix_html]"<?php
                        if ($fix_html == 'on')
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
                                    echo esc_html__("Do you want to try to import only auto generated closed captions for videos? This could speed up video importing if you need only auto captions.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Try To Import Only Auto Generated Closed Captions:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="only_auto" name="youtubomatic_Main_Settings[only_auto]"<?php
                        if ($only_auto == 'on')
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
                                    echo esc_html__("Do you want to show an image ad before playing imported videos from post content? Users will have to click on the image to see the imported video and to view it. To disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Show This Image Ad Before Playing Imported Videos:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="text" name="youtubomatic_Main_Settings[image_ad]" placeholder="<?php echo esc_html__("Comma separated image ad URL list", 'youtubomatic-youtube-post-generator');?>" value="<?php echo esc_html($image_ad);?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("If you use the image ad feature from above, you can enter a comma separated list of URLs where the image ads should link.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Image Ad URL List:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="text" name="youtubomatic_Main_Settings[image_ad_url]" placeholder="<?php echo esc_html__("Comma separated list of URLs where the image ads should link", 'youtubomatic-youtube-post-generator');?>" value="<?php echo esc_html($image_ad_url);?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to automatically translate generated content using Google Translate?", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Automatically Translate Content To:", 'youtubomatic-youtube-post-generator');?></b><br/><b><?php echo esc_html__("Info:", 'youtubomatic-youtube-post-generator');?></b> <?php echo esc_html__("for translation, the plugin also supports WPML.", 'youtubomatic-youtube-post-generator');?> <b><a href="https://wpml.org/?aid=238195&affiliate_key=ix3LsFyq0xKz" target="_blank"><?php echo esc_html__("Get WPML now!", 'youtubomatic-youtube-post-generator');?></a></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="translate" name="youtubomatic_Main_Settings[translate]" >
                           <?php
                              $i = 0;
                              foreach ($language_names as $lang) {
                                  echo '<option value="' . esc_html($language_codes[$i]) . '"';
                                  if ($translate == $language_codes[$i]) {
                                      echo ' selected';
                                  }
                                  echo '>' . esc_html($language_names[$i]) . '</option>';
                                  $i++;
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
                                    echo esc_html__("Select the source language for the translation.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Translation Source Language:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="translate_source" name="youtubomatic_Main_Settings[translate_source]" >
                           <?php
                              $i = 0;
                              foreach ($language_names as $lang) {
                                  echo '<option value="' . esc_html($language_codes[$i]) . '"';
                                  if ($translate_source == $language_codes[$i]) {
                                      echo ' selected';
                                  }
                                  echo '>' . esc_html($language_names[$i]) . '</option>';
                                  $i++;
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
                                    echo esc_html__("Do you want to spin/translate only the video's description (not the whole post content)?", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Spin/Translate Only Video Title/Description:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="litte_translate" name="youtubomatic_Main_Settings[litte_translate]"<?php
                        if ($litte_translate == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div id="bestspin">
                           <p><?php echo esc_html__("Don't have an 'The Best Spinner' account yet? Click here to get one:", 'youtubomatic-youtube-post-generator');?> <b><a href="https://paykstrt.com/10313/38910" target="_blank"><?php echo esc_html__("get a new account now!", 'youtubomatic-youtube-post-generator');?></a></b></p>
                        </div>
                        <div id="wordai">
                           <p><?php echo esc_html__("Don't have an 'WordAI' account yet? Click here to get one:", 'youtubomatic-youtube-post-generator');?> <b><a href="https://wordai.com/?ref=h17f4" target="_blank"><?php echo esc_html__("get a new account now!", 'youtubomatic-youtube-post-generator');?></a></b></p>
                        </div>
                        <div id="spinrewriter">
                           <p><?php echo esc_html__("Don't have an 'SpinRewriter' account yet? Click here to get one:", 'youtubomatic-youtube-post-generator');?> <b><a href="https://www.spinrewriter.com/?ref=24b18" target="_blank"><?php echo esc_html__("get a new account now!", 'youtubomatic-youtube-post-generator');?></a></b></p>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to randomize text by changing words of a text with synonyms using one of the listed methods? Note that this is an experimental feature and can in some instances drastically increase the rule running time!", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Spin Text Using Word Synonyms (for automatically generated posts only):", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <select id="spin_text" name="youtubomatic_Main_Settings[spin_text]" onchange="mainChanged()">
                     <option value="disabled"
                        <?php
                           if ($spin_text == 'disabled') {
                               echo ' selected';
                           }
                           ?>
                        ><?php echo esc_html__("Disabled", 'youtubomatic-youtube-post-generator');?></option>
                     <option value="best"
                        <?php
                           if ($spin_text == 'best') {
                               echo ' selected';
                           }
                           ?>
                        >The Best Spinner - <?php echo esc_html__("High Quality - Paid", 'youtubomatic-youtube-post-generator');?></option>
                     <option value="wordai"
                        <?php
                           if($spin_text == 'wordai')
                                   {
                                       echo ' selected';
                                   }
                           ?>
                        >Wordai - <?php echo esc_html__("High Quality - Paid", 'youtubomatic-youtube-post-generator');?></option>
                     <option value="spinrewriter"
                        <?php
                           if($spin_text == 'spinrewriter')
                                   {
                                       echo ' selected';
                                   }
                           ?>
                        >SpinRewriter - <?php echo esc_html__("High Quality - Paid", 'youtubomatic-youtube-post-generator');?></option>
                     <option value="builtin"
                        <?php
                           if ($spin_text == 'builtin') {
                               echo ' selected';
                           }
                           ?>
                        ><?php echo esc_html__("Built-in - Medium Quality - Free", 'youtubomatic-youtube-post-generator');?></option>
                     <option value="wikisynonyms"
                        <?php
                           if ($spin_text == 'wikisynonyms') {
                               echo ' selected';
                           }
                           ?>
                        >WikiSynonyms - <?php echo esc_html__("Low Quality - Free", 'youtubomatic-youtube-post-generator');?></option>
                     <option value="freethesaurus"
                        <?php
                           if ($spin_text == 'freethesaurus') {
                               echo ' selected';
                           }
                           ?>
                        >FreeThesaurus - <?php echo esc_html__("Low Quality - Free", 'youtubomatic-youtube-post-generator');?></option>
                     </select>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideBest">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert your user name on premium spinner service.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Premium Spinner Service User Name/Email:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideBest">
                           <input type="text" name="youtubomatic_Main_Settings[best_user]" value="<?php
                              echo esc_html($best_user);
                              ?>" placeholder="<?php echo esc_html__("Please insert your premium text spinner service user name", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideBest">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert your password for the selected premium spinner service.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Premium Spinner Service Password/API Key:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideBest">
                           <input type="password" autocomplete="off" name="youtubomatic_Main_Settings[best_password]" value="<?php
                              echo esc_html($best_password);
                              ?>" placeholder="<?php echo esc_html__("Please insert your premium text spinner service password", 'youtubomatic-youtube-post-generator');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("PhantomJS Settings:", 'youtubomatic-youtube-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to use phantomjs to generate the screenshot for the page, using the %%item_show_screenshot%% and %%item_screenshot_url%% shortcodes.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Use PhantomJs to Generate Screenshots (%%item_show_screenshot%%):", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="phantom_screen" name="youtubomatic_Main_Settings[phantom_screen]"<?php
                        if ($phantom_screen == 'on')
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
                                    echo esc_html__("Choose if you want to use Puppeteer to generate the screenshot for the page, using the %%item_show_screenshot%% and %%item_screenshot_url%% shortcodes.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Use Puppeteer to Generate Screenshots (%%item_show_screenshot%%):", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="puppeteer_screen" name="youtubomatic_Main_Settings[puppeteer_screen]"<?php
                        if ($puppeteer_screen == 'on')
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
                                    echo sprintf( wp_kses( __( "Set the path on your local server of the phantomjs executable. If you leave this field blank, the default 'phantomjs' call will be used. <a href='%s' target='_blank'>How to install PhantomJs?</a>", 'youtubomatic-youtube-post-generator'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "//coderevolution.ro/knowledge-base/faq/how-to-install-phantomjs/" ));
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("PhantomJS Path On Server:", 'youtubomatic-youtube-post-generator');?></b>
<?php
                       if($phantom_path != '')
                       {
                           $phantom = youtubomatic_testPhantom();
                           if($phantom === 0)
                           {
                               echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS not found - please install it on your server or configure the path to it in plugin\'s \'Main Settings\'!', 'youtubomatic-youtube-post-generator') . '</b> <a href=\'//coderevolution.ro/knowledge-base/faq/how-to-install-phantomjs/\' target=\'_blank\'>' . esc_html__('How to install PhantomJs?', 'youtubomatic-youtube-post-generator') . '</a></span>';
                           }
                           elseif($phantom === -1)
                           {
                               echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS cannot run - shell_exec is not enabled on your server. Please enable it and retry using this feature of the plugin.', 'youtubomatic-youtube-post-generator') . '</b></span>';
                           }
                           elseif($phantom === -2)
                           {
                               echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS cannot run - shell_exec is not allowed to run on your server (in disable_functions list in php.ini). Please enable it and retry using this feature of the plugin.', 'youtubomatic-youtube-post-generator') . '</b></span>';
                           }
                           elseif($phantom === 1)
                           {
                               echo '<br/><span class="cr_green12"><b>' . esc_html__('INFO: PhantomJS OK', 'youtubomatic-youtube-post-generator') . '</b></span>';
                           }
                       }
?>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="phantom_path" placeholder="<?php echo esc_html__("Path to phantomjs", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[phantom_path]" value="<?php echo esc_html($phantom_path);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input the width of the screenshot that will be generated for crawled pages. This will affect the content generated by the %%item_show_screenshot%% shortcode. The default is 600.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Page Screenshot Width:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="text" id="screenshot_width" name="youtubomatic_Main_Settings[screenshot_width]" value="<?php echo esc_html($screenshot_width);?>" placeholder="<?php echo esc_html__("600", 'youtubomatic-youtube-post-generator');?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input the height of the screenshot that will be generated for crawled pages. This will affect the content generated by the %%item_show_screenshot%% shortcode. The default is 450.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Page Screenshot Height:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="text" id="screenshot_height" name="youtubomatic_Main_Settings[screenshot_height]" value="<?php echo esc_html($screenshot_height);?>" placeholder="<?php echo esc_html__("450", 'youtubomatic-youtube-post-generator');?>">
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
                        <h3><?php echo esc_html__("Posting Restrictions Options:", 'youtubomatic-youtube-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the minimum word count for post titles. Items that have less than this count will not be published. To disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Minimum Title Word Count (Skip Post Otherwise):", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="min_word_title" step="1" placeholder="<?php echo esc_html__("Input the minimum word count for the title", 'youtubomatic-youtube-post-generator');?>" min="0" name="youtubomatic_Main_Settings[min_word_title]" value="<?php
                              echo esc_html($min_word_title);
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
                                    echo esc_html__("Set the maximum word count for post titles. Items that have more than this count will not be published. To disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Maximum Title Word Count (Skip Post Otherwise):", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="max_word_title" step="1" min="0" placeholder="<?php echo esc_html__("Input the maximum word count for the title", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[max_word_title]" value="<?php
                              echo esc_html($max_word_title);
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
                                    echo esc_html__("Set the minimum word count for post content. Items that have less than this count will not be published. To disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Minimum Content Word Count (Skip Post Otherwise):", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="min_word_content" step="1" min="0" placeholder="<?php echo esc_html__("Input the minimum word count for the content", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[min_word_content]" value="<?php
                              echo esc_html($min_word_content);
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
                                    echo esc_html__("Set the maximum word count for post content. Items that have more than this count will not be published. To disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Maximum Content Word Count (Skip Post Otherwise):", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="max_word_content" step="1" min="0" placeholder="<?php echo esc_html__("Input the maximum word count for the content", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[max_word_content]" value="<?php
                              echo esc_html($max_word_content);
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
                                    echo esc_html__("Do not include posts that's title or content contains at least one of these words. Separate words by comma. To disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Banned Words List:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="1" name="youtubomatic_Main_Settings[banned_words]" placeholder="<?php echo esc_html__("Do not generate posts that contain at least one of these words", 'youtubomatic-youtube-post-generator');?>"><?php
                        echo esc_textarea($banned_words);
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
                                    echo esc_html__("Do not include posts that's title or content does not contain at least one of these words. Separate words by comma. To disable this feature, leave this field blank.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Required Words List:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="1" name="youtubomatic_Main_Settings[required_words]" placeholder="<?php echo esc_html__("Do not generate posts unless they contain all of these words", 'youtubomatic-youtube-post-generator');?>"><?php
                        echo esc_textarea($required_words);
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
                                    echo esc_html__("Choose if you want to skip posts that do not have images.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Skip Posts That Do Not Have Images:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="skip_no_img" name="youtubomatic_Main_Settings[skip_no_img]"<?php
                        if ($skip_no_img == 'on')
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
                                    echo esc_html__("Choose if you want to skip posts that are older than a selected date. This is a general settings rule (applies to all posts). You can find this settings also in every rule configuration panel.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Skip Posts Older Than a Selected Date:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="skip_old" name="youtubomatic_Main_Settings[skip_old]" onchange="mainChanged()"<?php
                        if ($skip_old == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class='hideOld'>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the date prior which you want to skip posts.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Select the Date for Old Posts:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div class='hideOld'>
                           <?php echo esc_html__("Day:", 'youtubomatic-youtube-post-generator');?>
                           <select class="cr_width_80" name="youtubomatic_Main_Settings[skip_day]" >
                              <option value='01'<?php
                                 if ($skip_day == '01')
                                     echo ' selected';
                                 ?>>01</option>
                              <option value='02'<?php
                                 if ($skip_day == '02')
                                     echo ' selected';
                                 ?>>02</option>
                              <option value='03'<?php
                                 if ($skip_day == '03')
                                     echo ' selected';
                                 ?>>03</option>
                              <option value='04'<?php
                                 if ($skip_day == '04')
                                     echo ' selected';
                                 ?>>04</option>
                              <option value='05'<?php
                                 if ($skip_day == '05')
                                     echo ' selected';
                                 ?>>05</option>
                              <option value='06'<?php
                                 if ($skip_day == '06')
                                     echo ' selected';
                                 ?>>06</option>
                              <option value='07'<?php
                                 if ($skip_day == '07')
                                     echo ' selected';
                                 ?>>07</option>
                              <option value='08'<?php
                                 if ($skip_day == '08')
                                     echo ' selected';
                                 ?>>08</option>
                              <option value='09'<?php
                                 if ($skip_day == '09')
                                     echo ' selected';
                                 ?>>09</option>
                              <option value='10'<?php
                                 if ($skip_day == '10')
                                     echo ' selected';
                                 ?>>10</option>
                              <option value='11'<?php
                                 if ($skip_day == '11')
                                     echo ' selected';
                                 ?>>11</option>
                              <option value='12'<?php
                                 if ($skip_day == '12')
                                     echo ' selected';
                                 ?>>12</option>
                              <option value='13'<?php
                                 if ($skip_day == '13')
                                     echo ' selected';
                                 ?>>13</option>
                              <option value='14'<?php
                                 if ($skip_day == '14')
                                     echo ' selected';
                                 ?>>14</option>
                              <option value='15'<?php
                                 if ($skip_day == '15')
                                     echo ' selected';
                                 ?>>15</option>
                              <option value='16'<?php
                                 if ($skip_day == '16')
                                     echo ' selected';
                                 ?>>16</option>
                              <option value='17'<?php
                                 if ($skip_day == '17')
                                     echo ' selected';
                                 ?>>17</option>
                              <option value='18'<?php
                                 if ($skip_day == '18')
                                     echo ' selected';
                                 ?>>18</option>
                              <option value='19'<?php
                                 if ($skip_day == '19')
                                     echo ' selected';
                                 ?>>19</option>
                              <option value='20'<?php
                                 if ($skip_day == '20')
                                     echo ' selected';
                                 ?>>20</option>
                              <option value='21'<?php
                                 if ($skip_day == '21')
                                     echo ' selected';
                                 ?>>21</option>
                              <option value='22'<?php
                                 if ($skip_day == '22')
                                     echo ' selected';
                                 ?>>22</option>
                              <option value='23'<?php
                                 if ($skip_day == '23')
                                     echo ' selected';
                                 ?>>23</option>
                              <option value='24'<?php
                                 if ($skip_day == '24')
                                     echo ' selected';
                                 ?>>24</option>
                              <option value='25'<?php
                                 if ($skip_day == '25')
                                     echo ' selected';
                                 ?>>25</option>
                              <option value='26'<?php
                                 if ($skip_day == '26')
                                     echo ' selected';
                                 ?>>26</option>
                              <option value='27'<?php
                                 if ($skip_day == '27')
                                     echo ' selected';
                                 ?>>27</option>
                              <option value='28'<?php
                                 if ($skip_day == '28')
                                     echo ' selected';
                                 ?>>28</option>
                              <option value='29'<?php
                                 if ($skip_day == '29')
                                     echo ' selected';
                                 ?>>29</option>
                              <option value='30'<?php
                                 if ($skip_day == '30')
                                     echo ' selected';
                                 ?>>30</option>
                              <option value='31'<?php
                                 if ($skip_day == '31')
                                     echo ' selected';
                                 ?>>31</option>
                           </select>
                           <?php echo esc_html__("Month:", 'youtubomatic-youtube-post-generator');?>
                           <select class="cr_width_80" name="youtubomatic_Main_Settings[skip_month]" >
                              <option value='01'<?php
                                 if ($skip_month == '01')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("January", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='02'<?php
                                 if ($skip_month == '02')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("February", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='03'<?php
                                 if ($skip_month == '03')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("March", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='04'<?php
                                 if ($skip_month == '04')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("April", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='05'<?php
                                 if ($skip_month == '05')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("May", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='06'<?php
                                 if ($skip_month == '06')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("June", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='07'<?php
                                 if ($skip_month == '07')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("July", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='08'<?php
                                 if ($skip_month == '08')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("August", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='09'<?php
                                 if ($skip_month == '09')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("September", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='10'<?php
                                 if ($skip_month == '10')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("October", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='11'<?php
                                 if ($skip_month == '11')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("November", 'youtubomatic-youtube-post-generator');?></option>
                              <option value='12'<?php
                                 if ($skip_month == '12')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("December", 'youtubomatic-youtube-post-generator');?></option>
                           </select>
                           <?php echo esc_html__("Year:", 'youtubomatic-youtube-post-generator');?><input class="cr_width_70" value="<?php
                              echo esc_html($skip_year);
                              ?>" placeholder="<?php echo esc_html__("year", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[skip_year]" type="text" pattern="^\d{4}$">
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
                        <h3><?php echo esc_html__("Meta Tags Options:", 'youtubomatic-youtube-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to add YouTube meta tags to your generated pages.Add rich snippets for videos. This provide structured data for search engines about your content, and thus get you more traffic from search engines. Skip duplicate videos to have a unique content on your site. This is useful for SEO optimization.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable YouTube Meta Tags in Generated Pages:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="enable_og" name="youtubomatic_Main_Settings[enable_og]"<?php
                        if ($enable_og == 'on')
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
                                    echo esc_html__("Choose if you want to add OG meta tags to your generated pages. This will add sharing helping features for Facebook and Twitter.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable OG Meta Tags in Generated Pages:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="enable_og2" name="youtubomatic_Main_Settings[enable_og2]"<?php
                        if ($enable_og2 == 'on')
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
                                    echo esc_html__("Choose a default image URL when no image detected for the post.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Default OG Image When No Image Detected:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="url" validator="url" placeholder="<?php echo esc_html__("Valid image url", 'youtubomatic-youtube-post-generator');?>" id="default_image_og" name="youtubomatic_Main_Settings[default_image_og]"<?php
                        if ($default_image_og == 'on')
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
                                    echo esc_html__("Choose if you want to link directly to the YouTube video in the OG meta tags. If you uncheck this, the generated post will be linked.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Link Directly to YouTube Video In OG Meta Tags:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="link_og" name="youtubomatic_Main_Settings[link_og]"<?php
                        if ($link_og == 'on')
                            echo ' checked ';
                        ?>>
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
                        <h3><?php echo esc_html__("Subscribe Button Configurator:", 'youtubomatic-youtube-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the channel name for which the subscribe button will point to.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Channel Name:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="channel_name" placeholder="<?php echo esc_html__("Your Channel Name", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[channel_name]" value="<?php
                              echo esc_html($channel_name);
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
                                    echo esc_html__("Set the subscribe button layout.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Button Layout:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="channel_layout" name="youtubomatic_Main_Settings[channel_layout]" >
                              <option value="default"<?php
                                 if ($channel_layout == "default") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Default", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="full"<?php
                                 if ($channel_layout == "full") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Full", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("Set the subscribe button theme.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Button Theme:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="channel_theme" name="youtubomatic_Main_Settings[channel_theme]" >
                              <option value="default"<?php
                                 if ($channel_theme == "default") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Default", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="dark"<?php
                                 if ($channel_theme == "dark") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Dark", 'youtubomatic-youtube-post-generator');?></option>
                           </select>
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
                        <h3><?php echo esc_html__("Embedded Player Options:", 'youtubomatic-youtube-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the style of the embedded player. If you set 'fullscreen', the below player size settings will have no effect.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Player Style:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="player_style" name="youtubomatic_Main_Settings[player_style]" >
                              <option value="0"<?php
                                 if ($player_style == "0") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Full Width", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="1"<?php
                                 if ($player_style == "1") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Align Center", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="2"<?php
                                 if ($player_style == "2") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Align Left", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="3"<?php
                                 if ($player_style == "3") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Align Right", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("Set the maximum width of the player in pixels. Default value is 580.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Player Max Width (Pixels):", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="player_width" step="1" min="0" placeholder="<?php echo esc_html__("580", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[player_width]" value="<?php
                              echo esc_html($player_width);
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
                                    echo esc_html__("Set the maximum height of the player in pixels. Default value is 380.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Player Max Height (Pixels):", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="player_height" step="1" min="0" placeholder="<?php echo esc_html__("380", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[player_height]" value="<?php
                              echo esc_html($player_height);
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
                                    echo esc_html__("Setting the parameter's value to 'Force' causes closed captions to be shown by default, even if the user has turned captions off. The default behavior is based on user preference.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Show Closed Captions:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="show_closed_captions" name="youtubomatic_Main_Settings[show_closed_captions]" >
                              <option value="0"<?php
                                 if ($show_closed_captions == "0") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Default", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="1"<?php
                                 if ($show_closed_captions == "1") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Force", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("This parameter specifies the color that will be used in the player's video progress bar to highlight the amount of the video that the viewer has already seen. Valid parameter values are red and white, and, by default, the player uses the color red in the video progress bar. See the YouTube API blog for more information about color options.Note: Setting the color parameter to white will disable the 'Modest Branding' option.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Player Color Theme:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="color_theme" name="youtubomatic_Main_Settings[color_theme]" >
                              <option value="red"<?php
                                 if ($color_theme == "red") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Default", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="white"<?php
                                 if ($color_theme == "white") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("White", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("This parameter indicates whether the video player controls are displayed. For IFrame embeds that load a Flash player, it also defines when the controls display in the player as well as when the player will load. Supported values are: Hide Player controls do not display in the player. For IFrame embeds, the Flash player loads immediately. Default (default) Player controls display in the player. For IFrame embeds, the controls display immediately and the Flash player also loads immediately. Show Player controls display in the player. For IFrame embeds, the controls display and the Flash player loads after the user initiates the video playback.Note: The parameter values Default and Show are intended to provide an identical user experience, but Show provides a performance improvement over Default for IFrame embeds. Currently, the two values still produce some visual differences in the player, such as the video title's font size. However, when the difference between the two values becomes completely transparent to the user, the default parameter value may change from Default to Show.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Show Video Controls:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="video_controls" name="youtubomatic_Main_Settings[video_controls]" >
                              <option value="0"<?php
                                 if ($video_controls == "0") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Hide", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="1"<?php
                                 if ($video_controls == "1") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Show", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="2"<?php
                                 if ($video_controls == "2") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Default", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("Setting the parameter's value to Disable causes the player to not respond to keyboard controls. The default value is Enable, which means that keyboard controls are enabled.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Keyboard Control:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="keyboard_control" name="youtubomatic_Main_Settings[keyboard_control]" >
                              <option value="0"<?php
                                 if ($keyboard_control == "0") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Enable", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="1"<?php
                                 if ($keyboard_control == "1") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Disable", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("Setting the parameter's value to Enable enables the player to be controlled via IFrame or JavaScript Player API calls. The default value is Disable, which means that the player cannot be controlled using those APIs.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Iframe API:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="iframe_api" name="youtubomatic_Main_Settings[iframe_api]" >
                              <option value="0"<?php
                                 if ($iframe_api == "0") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Disable", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="1"<?php
                                 if ($iframe_api == "1") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Enable", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("This parameter specifies the time, measured in seconds from the start of the video, when the player should stop playing the video. The parameter value is a positive integer.Note that the time is measured from the beginning of the video and not from either the value of the start player parameter or the startSeconds parameter, which is used in YouTube Player API functions for loading or queueing a video.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Stop Playing the Video After (Seconds):", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="stop_after" step="1" min="0" placeholder="<?php echo esc_html__("Stop video after x seconds", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[stop_after]" value="<?php
                              echo esc_html($stop_after);
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
                                    echo esc_html__("This parameter causes the player to begin playing the video at the given number of seconds from the start of the video. The parameter value is a positive integer. Note that similar to the seekTo function, the player will look for the closest keyframe to the time you specify. This means that sometimes the play head may seek to just before the requested time, usually no more than around two seconds.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Start Playing the Video After (Seconds):", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="start_after" step="1" min="0" placeholder="<?php echo esc_html__("Start video after x seconds", 'youtubomatic-youtube-post-generator');?>" name="youtubomatic_Main_Settings[start_after]" value="<?php
                              echo esc_html($start_after);
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
                                    echo esc_html__("Setting this parameter to Hide prevents the fullscreen button from displaying in the player. The default value is Show, which causes the fullscreen button to display.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Show Fulscreen Button:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="show_fullscreen_button" name="youtubomatic_Main_Settings[show_fullscreen_button]" >
                              <option value="0"<?php
                                 if ($show_fullscreen_button == "0") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Hide", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="1"<?php
                                 if ($show_fullscreen_button == "1") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Show", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("Setting the parameter's value to Show causes video annotations to be shown by default, whereas setting to Hide causes video annotations to not be shown by default. The default value is Show.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Show Video Annotations:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="video_annotations" name="youtubomatic_Main_Settings[video_annotations]" >
                              <option value="1"<?php
                                 if ($video_annotations == "1") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Show", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="3"<?php
                                 if ($video_annotations == "3") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Hide", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("Setting to the value of On causes the player to play the initial video again and again. Supported values are Off and On, and the default value is Off. Note: This parameter has limited support in the AS3 player and in IFrame embeds, which could load either the AS3 or HTML5 player. Currently, the loop parameter only works in the AS3 player when used in conjunction with the playlist parameter. To loop a single video, set the loop parameter value to 1 and set the playlist parameter value to the same video ID already specified in the Player API URL", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Loop Video:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="loop_video" name="youtubomatic_Main_Settings[loop_video]" >
                              <option value="0"<?php
                                 if ($loop_video == "0") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Off", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="1"<?php
                                 if ($loop_video == "1") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("On", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("This parameter lets you use a YouTube player that does not show a YouTube logo. Set the parameter value to On to prevent the YouTube logo from displaying in the control bar. Note that a small YouTube text label will still display in the upper-right corner of a paused video when the user's mouse pointer hovers over the player.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Modest Branding:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="modest_branding" name="youtubomatic_Main_Settings[modest_branding]" >
                              <option value="0"<?php
                                 if ($modest_branding == "0") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Off", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="1"<?php
                                 if ($modest_branding == "1") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("On", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("This parameter indicates whether the player should show related videos when playback of the initial video ends. The default value is From Everywhere.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Show Related Videos After Playback:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="show_related" name="youtubomatic_Main_Settings[show_related]" >
                              <option value="0"<?php
                                 if ($show_related == "0") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Same Channel", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="1"<?php
                                 if ($show_related == "1") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("From Everywhere", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("Supported values are Hide and Show.Setting the parameter's value to Hide causes the player to not display information like the video title and uploader before the video starts playing.Note that this functionality is only supported for the AS3 player.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Show Info:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="show_info" name="youtubomatic_Main_Settings[show_info]" >
                              <option value="0"<?php
                                 if ($show_info == "0") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Hide", 'youtubomatic-youtube-post-generator');?></option>
                              <option value="1"<?php
                                 if ($show_info == "1") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Show", 'youtubomatic-youtube-post-generator');?></option>
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
                                    echo esc_html__("Sets the player's interface language. The interface language is used for tooltips in the player and also affects the default caption track. Note that YouTube might select a different caption track language for a particular user based on the user's individual language preferences and the availability of caption tracks.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Player Language:", 'youtubomatic-youtube-post-generator');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select id="player_language" name="youtubomatic_Main_Settings[player_language]" >
                              <option value="default"<?php
                                 if ($player_language == "default") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Default", 'youtubomatic-youtube-post-generator');?></option>
                              <?php
                                 $i = 0;
                                 foreach ($language_names as $lang) {
                                     echo '<option value="' . esc_html($language_codes[$i]) . '"';
                                     if ($player_language == $language_codes[$i]) {
                                         echo ' selected';
                                     }
                                     echo '>' . esc_html($language_names[$i]) . '</option>';
                                     $i++;
                                 }
                                 ?>
                           </select>
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
                        <h3><?php echo esc_html__("Random Sentence Generator Settings:", 'youtubomatic-youtube-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("First List of Possible Sentences (%%random_sentence%%):", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="8" cols="70" name="youtubomatic_Main_Settings[sentence_list]" placeholder="<?php echo esc_html__("Please insert the first list of sentences", 'youtubomatic-youtube-post-generator');?>"><?php
                        echo esc_textarea($sentence_list);
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
                                    echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Second List of Possible Sentences (%%random_sentence2%%):", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="8" cols="70" name="youtubomatic_Main_Settings[sentence_list2]" placeholder="<?php echo esc_html__("Please insert the second list of sentences", 'youtubomatic-youtube-post-generator');?>"><?php
                        echo esc_textarea($sentence_list2);
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
                                    echo esc_html__("Insert some variables you wish to be exchanged for different instances of one sentence. Please format this list as follows:<br/>
                                    Variablename => Variables (seperated by semicolon)<br/>Example:<br/>adjective => clever;interesting;smart;huge;astonishing;unbelievable;nice;adorable;beautiful;elegant;fancy;glamorous;magnificent;helpful;awesome<br/>", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("List of Possible Variables:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="8" cols="70" name="youtubomatic_Main_Settings[variable_list]" placeholder="<?php echo esc_html__("Please insert the list of variables", 'youtubomatic-youtube-post-generator');?>"><?php
                        echo esc_textarea($variable_list);
                        ?></textarea>
                     </div></td>
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
                        <h3><?php echo esc_html__("Custom HTML Code/ Ad Code:", 'youtubomatic-youtube-post-generator');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert a custom HTML code that will replace the %%custom_html%% variable. This can be anything, even an Ad code.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Custom HTML Code #1:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="3" cols="70" name="youtubomatic_Main_Settings[custom_html]" placeholder="<?php echo esc_html__("Custom HTML #1", 'youtubomatic-youtube-post-generator');?>"><?php
                        echo esc_textarea($custom_html);
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
                                    echo esc_html__("Insert a custom HTML code that will replace the %%custom_html2%% variable. This can be anything, even an Ad code.", 'youtubomatic-youtube-post-generator');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Custom HTML Code #2:", 'youtubomatic-youtube-post-generator');?></b>
                     </td>
                     <td>
                     <textarea rows="3" cols="70" name="youtubomatic_Main_Settings[custom_html2]" placeholder="<?php echo esc_html__("Custom HTML #2", 'youtubomatic-youtube-post-generator');?>"><?php
                        echo esc_textarea($custom_html2);
                        ?></textarea>
                     </div>
                     </td>
                  </tr>
               </table>
               <hr/>
               <h3><?php echo esc_html__("Affiliate Keyword Replacer Tool Settings:", 'youtubomatic-youtube-post-generator');?></h3>
               <div class="table-responsive">
                  <table class="responsive table cr_main_table">
                     <thead>
                        <tr>
                           <th>
                              <?php echo esc_html__("ID", 'youtubomatic-youtube-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This is the ID of the rule.", 'youtubomatic-youtube-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th class="cr_max_width_40">
                              <?php echo esc_html__("Del", 'youtubomatic-youtube-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Do you want to delete this rule?", 'youtubomatic-youtube-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Search Keyword", 'youtubomatic-youtube-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This keyword will be replaced with a link you define.", 'youtubomatic-youtube-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Replacement Keyword", 'youtubomatic-youtube-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("This keyword will replace the search keyword you define. Leave this field blank if you only want to add an URL to the specified keyword.", 'youtubomatic-youtube-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                           <th>
                              <?php echo esc_html__("Link to Add", 'youtubomatic-youtube-post-generator');?>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Define the link you want to appear the defined keyword. Leave this field blank if you only want to replace the specified keyword without linking from it.", 'youtubomatic-youtube-post-generator');
                                       ?>
                                 </div>
                              </div>
                           </th>
                        </tr>
                        <tr>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           echo youtubomatic_expand_keyword_rules();
                           ?>
                        <tr>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                           <td>
                              <hr/>
                           </td>
                        </tr>
                        <tr>
                           <td class="cr_short_td">-</td>
                           <td class="cr_shrt_td2"><span class="cr_gray20">X</span></td>
                           <td class="cr_rule_line"><input type="text" name="youtubomatic_keyword_list[keyword][]"  placeholder="<?php echo esc_html__("Please insert the keyword to be replaced", 'youtubomatic-youtube-post-generator');?>" value="" class="cr_width_100" /></td>
                           <td class="cr_rule_line"><input type="text" name="youtubomatic_keyword_list[replace][]"  placeholder="<?php echo esc_html__("Please insert the keyword to replace the search keyword", 'youtubomatic-youtube-post-generator');?>" value="" class="cr_width_100" /></td>
                           <td class="cr_rule_line"><input type="url" validator="url" name="youtubomatic_keyword_list[link][]" placeholder="<?php echo esc_html__("Please insert the link to be added to the keyword", 'youtubomatic-youtube-post-generator');?>" value="" class="cr_width_100" />
                        </tr>
                     </tbody>
                  </table>
               </div>
               </td></tr>
               </table>
            </div>
         </div>
   </div>
   <hr/>
   <div><?php echo esc_html__("You can also use the following shortcode in your content (also Gutenberg blocks):", 'youtubomatic-youtube-post-generator');?> <b>[youtubomatic_grid]</b>, <b>[youtubomatic_grid_channel]</b>, <b>[youtubomatic_grid_playlist]</b>, <b>[youtubomatic_video]</b>, <b>[youtubomatic_search]</b>, <b>[youtubomatic_channel]</b> or <b>[youtubomatic_playlist]</b>. <br/><?php echo esc_html__("Use the [youtubomatic_grid] shortcode to display a YouTube style grid with published posts. Use the [youtubomatic_grid_channel] shortcode to display a grid of videos imported from a YouTube channel. Use the [youtubomatic_grid_playlist] shortcode to display a grid of videos imported from a YouTube playlist. Use the [youtubomatic_video] shortcode to display a single video, by it's ID. Use the [youtubomatic_search] shortcode to display a list for searched videos, by a search term. Use the [youtubomatic_channel] shortcode to display videos from a specific channel, by it's ID. Use the [youtubomatic_playlist] shortcode to display videos from a playlist, by it's ID.", 'youtubomatic-youtube-post-generator');?><br/><?php echo esc_html__("Example shortcode usage:", 'youtubomatic-youtube-post-generator');?> <b>[youtubomatic_grid max=9 per_row=3 width=200 height=200 list_all=0 title_length=20 direct_link=1]</b>, <b>[youtubomatic_video id=eFp90-dPke0]</b>, <b>[youtubomatic_search id=audi]</b>, <b>[youtubomatic_channel id=AudiofAmerica]</b>, <b>[youtubomatic_grid_channel id=UCxiaIKXjo25U1AMCBAcplRQ max=9 width=200 background_color=eeeeee]</b>, <b>[youtubomatic_grid_playlist id=PLEiGTaa0iBIgcqNzVBaoTCS4ws47vNMuQ max=9 width=200 background_color=eeeeee]</b>, <b>[youtubomatic_playlist id=PL4BC045240D2FB11B]</b>. <?php echo esc_html__("For details about the shortcodes, please see the plugin help file.", 'youtubomatic-youtube-post-generator');?></div>
   <p>
   <?php echo esc_html__("Available shortcodes:", 'youtubomatic-youtube-post-generator');?> <strong>[youtubomatic-list-posts]</strong> <?php echo esc_html__("to include a list that contains only posts imported by this plugin, and", 'youtubomatic-youtube-post-generator');?> <strong>[youtubomatic-display-posts]</strong> <?php echo esc_html__("to include a WordPress like post listing. Usage:", 'youtubomatic-youtube-post-generator');?> [youtubomatic-display-posts type='any/post/page/...' title_color='#ffffff' excerpt_color='#ffffff' read_more_text="Read More" link_to_source='yes' order='ASC/DESC' orderby='title/ID/author/name/date/rand/comment_count' title_font_size='19px', excerpt_font_size='19px' posts_per_page=number_of_posts_to_show category='posts_category' ruleid='ID_of_youtubomatic_rule'].
   <br/><?php echo esc_html__("Example:", 'youtubomatic-youtube-post-generator');?> <b>[youtubomatic-list-posts type='any' order='ASC' orderby='date' posts_per_page=50 category= '' ruleid='0']</b>
   <br/><?php echo esc_html__("Example 2:", 'youtubomatic-youtube-post-generator');?> <b>[youtubomatic-display-posts include_excerpt='true' image_size='thumbnail' wrapper='div']</b>.
   </p><div><p class="submit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'youtubomatic-youtube-post-generator');?>"/></p></div>
   </form>
</div>
<?php
   }
   if (isset($_POST['youtubomatic_keyword_list'])) {
       add_action('admin_init', 'youtubomatic_save_keyword_rules');
   }
   function youtubomatic_save_keyword_rules($data2)
   {
       $data2 = $_POST['youtubomatic_keyword_list'];
       $rules = array();
       if (isset($data2['keyword'][0])) {
           for ($i = 0; $i < sizeof($data2['keyword']); ++$i) {
               if (isset($data2['keyword'][$i]) && $data2['keyword'][$i] != '') {
                   $index         = $data2['keyword'][$i];
                   $rules[$index] = array(
                       trim(sanitize_text_field($data2['link'][$i])),
                       $data2['replace'][$i]
                   );
               }
           }
       }
       update_option('youtubomatic_keyword_list', $rules);
   }
   function youtubomatic_expand_keyword_rules()
   {
       $rules  = get_option('youtubomatic_keyword_list');
       $output = '';
       $cont   = 0;
       if (!empty($rules)) {
           foreach ($rules as $request => $value) {
               $output .= '<tr>
                           <td class="cr_short_td">' . esc_html($cont) . '</td>
                           <td class="cr_shrt_td2"><span class="wpyoutubomatic-delete">X</span></td>
                           <td class="cr_rule_line"><input type="text" placeholder="' . esc_html__('Input the keyword to be replaced. This field is required', 'youtubomatic-youtube-post-generator') . '" name="youtubomatic_keyword_list[keyword][]" value="' . esc_html($request) . '" required class="cr_width_100"></td>
                           <td class="cr_rule_line"><input type="text" placeholder="' . esc_html__('Input the replacement word', 'youtubomatic-youtube-post-generator') . '" name="youtubomatic_keyword_list[replace][]" value="' . esc_html($value[1]) . '" class="cr_width_100"></td>
                           <td class="cr_rule_line"><input type="url" validator="url" placeholder="' . esc_html__('Input the URL to be added', 'youtubomatic-youtube-post-generator') . '" name="youtubomatic_keyword_list[link][]" value="' . esc_html($value[0]) . '" class="cr_width_100"></td>
   					</tr>';
               $cont++;
           }
       }
       return $output;
   }
   ?>