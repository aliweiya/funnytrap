<?php
   function echo_admin_settings()
   {
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
            settings_fields('echo_option_group');
            do_settings_sections('echo_option_group');
            $echo_Main_Settings = get_option('echo_Main_Settings', false);
            if (isset($echo_Main_Settings['echo_enabled'])) {
                $echo_enabled = $echo_Main_Settings['echo_enabled'];
            } else {
                $echo_enabled = '';
            }
            if (isset($echo_Main_Settings['enable_metabox'])) {
                $enable_metabox = $echo_Main_Settings['enable_metabox'];
            } else {
                $enable_metabox = '';
            }
            if (isset($echo_Main_Settings['sentence_list'])) {
                $sentence_list = $echo_Main_Settings['sentence_list'];
            } else {
                $sentence_list = '';
            }
            if (isset($echo_Main_Settings['search_google'])) {
                $search_google = $echo_Main_Settings['search_google'];
            } else {
                $search_google = '';
            }
            if (isset($echo_Main_Settings['screenshot_width'])) {
                $screenshot_width = $echo_Main_Settings['screenshot_width'];
            } else {
                $screenshot_width = '';
            }
            if (isset($echo_Main_Settings['screenshot_height'])) {
                $screenshot_height = $echo_Main_Settings['screenshot_height'];
            } else {
                $screenshot_height = '';
            }
            if (isset($echo_Main_Settings['sentence_list2'])) {
                $sentence_list2 = $echo_Main_Settings['sentence_list2'];
            } else {
                $sentence_list2 = '';
            }
            if (isset($echo_Main_Settings['clear_user_agent'])) {
                $clear_user_agent = $echo_Main_Settings['clear_user_agent'];
            } else {
                $clear_user_agent = '';
            }
            if (isset($echo_Main_Settings['variable_list'])) {
                $variable_list = $echo_Main_Settings['variable_list'];
            } else {
                $variable_list = '';
            }
            if (isset($echo_Main_Settings['enable_detailed_logging'])) {
                $enable_detailed_logging = $echo_Main_Settings['enable_detailed_logging'];
            } else {
                $enable_detailed_logging = '';
            }
            if (isset($echo_Main_Settings['enable_logging'])) {
                $enable_logging = $echo_Main_Settings['enable_logging'];
            } else {
                $enable_logging = '';
            }
            if (isset($echo_Main_Settings['auto_clear_logs'])) {
                $auto_clear_logs = $echo_Main_Settings['auto_clear_logs'];
            } else {
                $auto_clear_logs = '';
            }
            if (isset($echo_Main_Settings['rule_timeout'])) {
                $rule_timeout = $echo_Main_Settings['rule_timeout'];
            } else {
                $rule_timeout = '';
            }
            if (isset($echo_Main_Settings['strip_links'])) {
                $strip_links = $echo_Main_Settings['strip_links'];
            } else {
                $strip_links = '';
            }
            if (isset($echo_Main_Settings['strip_content_links'])) {
                $strip_content_links = $echo_Main_Settings['strip_content_links'];
            } else {
                $strip_content_links = '';
            }
            if (isset($echo_Main_Settings['link_new_tab'])) {
                $link_new_tab = $echo_Main_Settings['link_new_tab'];
            } else {
                $link_new_tab = '';
            }
            if (isset($echo_Main_Settings['link_nofollow'])) {
                $link_nofollow = $echo_Main_Settings['link_nofollow'];
            } else {
                $link_nofollow = '';
            }
            if (isset($echo_Main_Settings['strip_featured_image'])) {
                $strip_featured_image = $echo_Main_Settings['strip_featured_image'];
            } else {
                $strip_featured_image = '';
            }
            if (isset($echo_Main_Settings['strip_scripts'])) {
                $strip_scripts = $echo_Main_Settings['strip_scripts'];
            } else {
                $strip_scripts = '';
            }
            if (isset($echo_Main_Settings['send_email'])) {
                $send_email = $echo_Main_Settings['send_email'];
            } else {
                $send_email = '';
            }
            if (isset($echo_Main_Settings['send_post_email'])) {
                $send_post_email = $echo_Main_Settings['send_post_email'];
            } else {
                $send_post_email = '';
            }
            if (isset($echo_Main_Settings['email_address'])) {
                $email_address = $echo_Main_Settings['email_address'];
            } else {
                $email_address = '';
            }
            if (isset($echo_Main_Settings['email_summary'])) {
                $email_summary = $echo_Main_Settings['email_summary'];
            } else {
                $email_summary = '';
            }
            if (isset($echo_Main_Settings['spin_text'])) {
                $spin_text = $echo_Main_Settings['spin_text'];
            } else {
                $spin_text = '';
            }
            if (isset($echo_Main_Settings['enable_robots'])) {
                $enable_robots = $echo_Main_Settings['enable_robots'];
            } else {
                $enable_robots = '';
            }
            if (isset($echo_Main_Settings['xmlrpc_enabled'])) {
                $xmlrpc_enabled = $echo_Main_Settings['xmlrpc_enabled'];
            } else {
                $xmlrpc_enabled = '';
            }
            if (isset($echo_Main_Settings['best_user'])) {
                $best_user = $echo_Main_Settings['best_user'];
            } else {
                $best_user = '';
            }
            if (isset($echo_Main_Settings['copy_images'])) {
                $copy_images = $echo_Main_Settings['copy_images'];
            } else {
                $copy_images = '';
            }
            if (isset($echo_Main_Settings['best_password'])) {
                $best_password = $echo_Main_Settings['best_password'];
            } else {
                $best_password = '';
            }
            if (isset($echo_Main_Settings['protected_terms'])) {
                $protected_terms = $echo_Main_Settings['protected_terms'];
            } else {
                $protected_terms = '';
            }
            if (isset($echo_Main_Settings['phantom_path'])) {
                $phantom_path = $echo_Main_Settings['phantom_path'];
            } else {
                $phantom_path = '';
            }
            if (isset($echo_Main_Settings['phantom_timeout'])) {
                $phantom_timeout = $echo_Main_Settings['phantom_timeout'];
            } else {
                $phantom_timeout = '';
            }
            if (isset($echo_Main_Settings['phantom_screen'])) {
                $phantom_screen = $echo_Main_Settings['phantom_screen'];
            } else {
                $phantom_screen = '';
            }
            if (isset($echo_Main_Settings['puppeteer_screen'])) {
                $puppeteer_screen = $echo_Main_Settings['puppeteer_screen'];
            } else {
                $puppeteer_screen = '';
            }
            if (isset($echo_Main_Settings['min_word_title'])) {
                $min_word_title = $echo_Main_Settings['min_word_title'];
            } else {
                $min_word_title = '';
            }
            if (isset($echo_Main_Settings['max_word_title'])) {
                $max_word_title = $echo_Main_Settings['max_word_title'];
            } else {
                $max_word_title = '';
            }
            if (isset($echo_Main_Settings['min_word_content'])) {
                $min_word_content = $echo_Main_Settings['min_word_content'];
            } else {
                $min_word_content = '';
            }
            if (isset($echo_Main_Settings['max_word_content'])) {
                $max_word_content = $echo_Main_Settings['max_word_content'];
            } else {
                $max_word_content = '';
            }
            if (isset($echo_Main_Settings['required_words'])) {
                $required_words = $echo_Main_Settings['required_words'];
            } else {
                $required_words = '';
            }
            if (isset($echo_Main_Settings['banned_words'])) {
                $banned_words = $echo_Main_Settings['banned_words'];
            } else {
                $banned_words = '';
            }
            if (isset($echo_Main_Settings['skip_old'])) {
                $skip_old = $echo_Main_Settings['skip_old'];
            } else {
                $skip_old = '';
            }
            if (isset($echo_Main_Settings['skip_day'])) {
                $skip_day = $echo_Main_Settings['skip_day'];
            } else {
                $skip_day = '';
            }
            if (isset($echo_Main_Settings['skip_month'])) {
                $skip_month = $echo_Main_Settings['skip_month'];
            } else {
                $skip_month = '';
            }
            if (isset($echo_Main_Settings['skip_year'])) {
                $skip_year = $echo_Main_Settings['skip_year'];
            } else {
                $skip_year = '';
            }
            if (isset($echo_Main_Settings['skip_new'])) {
                $skip_new = $echo_Main_Settings['skip_new'];
            } else {
                $skip_new = '';
            }
            if (isset($echo_Main_Settings['skip_day_new'])) {
                $skip_day_new = $echo_Main_Settings['skip_day_new'];
            } else {
                $skip_day_new = '';
            }
            if (isset($echo_Main_Settings['skip_month_new'])) {
                $skip_month_new = $echo_Main_Settings['skip_month_new'];
            } else {
                $skip_month_new = '';
            }
            if (isset($echo_Main_Settings['skip_year_new'])) {
                $skip_year_new = $echo_Main_Settings['skip_year_new'];
            } else {
                $skip_year_new = '';
            }
            if (isset($echo_Main_Settings['custom_html2'])) {
                $custom_html2 = $echo_Main_Settings['custom_html2'];
            } else {
                $custom_html2 = '';
            }
            if (isset($echo_Main_Settings['custom_html'])) {
                $custom_html = $echo_Main_Settings['custom_html'];
            } else {
                $custom_html = '';
            }
            if (isset($echo_Main_Settings['skip_no_img'])) {
                $skip_no_img = $echo_Main_Settings['skip_no_img'];
            } else {
                $skip_no_img = '';
            }
            if (isset($echo_Main_Settings['require_only_one'])) {
                $require_only_one = $echo_Main_Settings['require_only_one'];
            } else {
                $require_only_one = '';
            }
            if (isset($echo_Main_Settings['strip_by_id'])) {
                $strip_by_id = $echo_Main_Settings['strip_by_id'];
            } else {
                $strip_by_id = '';
            }
            if (isset($echo_Main_Settings['strip_by_class'])) {
                $strip_by_class = $echo_Main_Settings['strip_by_class'];
            } else {
                $strip_by_class = '';
            }
            if (isset($echo_Main_Settings['echo_custom_simplepie'])) {
                $echo_custom_simplepie = $echo_Main_Settings['echo_custom_simplepie'];
            } else {
                $echo_custom_simplepie = '';
            }
            if (isset($echo_Main_Settings['echo_force_feeds'])) {
                $echo_force_feeds = $echo_Main_Settings['echo_force_feeds'];
            } else {
                $echo_force_feeds = '';
            }
            if (isset($echo_Main_Settings['echo_enable_caching'])) {
                $echo_enable_caching = $echo_Main_Settings['echo_enable_caching'];
            } else {
                $echo_enable_caching = '';
            }
            if (isset($echo_Main_Settings['echo_no_strip'])) {
                $echo_no_strip = $echo_Main_Settings['echo_no_strip'];
            } else {
                $echo_no_strip = '';
            }
            if (isset($echo_Main_Settings['echo_featured_image_checking'])) {
                $echo_featured_image_checking = $echo_Main_Settings['echo_featured_image_checking'];
            } else {
                $echo_featured_image_checking = '';
            }
            if (isset($echo_Main_Settings['fix_greek'])) {
                $fix_greek = $echo_Main_Settings['fix_greek'];
            } else {
                $fix_greek = '';
            }
            if (isset($echo_Main_Settings['echo_clear_curl_charset'])) {
                $echo_clear_curl_charset = $echo_Main_Settings['echo_clear_curl_charset'];
            } else {
                $echo_clear_curl_charset = '';
            }
            if (isset($echo_Main_Settings['custom_tag_list'])) {
                $custom_tag_list = $echo_Main_Settings['custom_tag_list'];
            } else {
                $custom_tag_list = '';
            }
            if (isset($echo_Main_Settings['custom_tag_separator'])) {
                $custom_tag_separator = $echo_Main_Settings['custom_tag_separator'];
            } else {
                $custom_tag_separator = '';
            }
            if (isset($echo_Main_Settings['custom_attr_separator'])) {
                $custom_attr_separator = $echo_Main_Settings['custom_attr_separator'];
            } else {
                $custom_attr_separator = '';
            }
            if (isset($echo_Main_Settings['custom_feed_tag_list'])) {
                $custom_feed_tag_list = $echo_Main_Settings['custom_feed_tag_list'];
            } else {
                $custom_feed_tag_list = '';
            }
            if (isset($echo_Main_Settings['disable_excerpt'])) {
                $disable_excerpt = $echo_Main_Settings['disable_excerpt'];
            } else {
                $disable_excerpt = '';
            }
            if (isset($echo_Main_Settings['excerpt_length'])) {
                $excerpt_length = $echo_Main_Settings['excerpt_length'];
            } else {
                $excerpt_length = '';
            }
            if (isset($echo_Main_Settings['def_user'])) {
                $def_user = $echo_Main_Settings['def_user'];
            } else {
                $def_user = '';
            }
            if (isset($echo_Main_Settings['echo_get_image_from_content'])) {
                $echo_get_image_from_content = $echo_Main_Settings['echo_get_image_from_content'];
            } else {
                $echo_get_image_from_content = '';
            }
            if (isset($echo_Main_Settings['resize_height'])) {
                $resize_height = $echo_Main_Settings['resize_height'];
            } else {
                $resize_height = '';
            }
            if (isset($echo_Main_Settings['resize_width'])) {
                $resize_width = $echo_Main_Settings['resize_width'];
            } else {
                $resize_width = '';
            }
            if (isset($echo_Main_Settings['resize_quality'])) {
                $resize_quality = $echo_Main_Settings['resize_quality'];
            } else {
                $resize_quality = '';
            }
            if (isset($echo_Main_Settings['read_more_text'])) {
                $read_more_text = $echo_Main_Settings['read_more_text'];
            } else {
                $read_more_text = '';
            }
            if (isset($echo_Main_Settings['conditional_words'])) {
                $conditional_words = $echo_Main_Settings['conditional_words'];
            } else {
                $conditional_words = '';
            }
            if (isset($echo_Main_Settings['no_local_image'])) {
                $no_local_image = $echo_Main_Settings['no_local_image'];
            } else {
                $no_local_image = '';
            }
            if (isset($echo_Main_Settings['auto_delete_enabled'])) {
                $auto_delete_enabled = $echo_Main_Settings['auto_delete_enabled'];
            } else {
                $auto_delete_enabled = '';
            }
            if (isset($echo_Main_Settings['no_title_spin'])) {
                $no_title_spin = $echo_Main_Settings['no_title_spin'];
            } else {
                $no_title_spin = '';
            }
            if (isset($echo_Main_Settings['confidence_level'])) {
                $confidence_level = $echo_Main_Settings['confidence_level'];
            } else {
                $confidence_level = '';
            }
            if (isset($echo_Main_Settings['rule_delay'])) {
                $rule_delay = $echo_Main_Settings['rule_delay'];
            } else {
                $rule_delay = '';
            }
            if (isset($echo_Main_Settings['no_spin'])) {
                $no_spin = $echo_Main_Settings['no_spin'];
            } else {
                $no_spin = '';
            }
            if (isset($echo_Main_Settings['replace_url'])) {
                $replace_url = $echo_Main_Settings['replace_url'];
            } else {
                $replace_url = '';
            }
            if (isset($echo_Main_Settings['link_attributes_internal'])) {
                $link_attributes_internal = $echo_Main_Settings['link_attributes_internal'];
            } else {
                $link_attributes_internal = '';
            }
            if (isset($echo_Main_Settings['link_attributes_external'])) {
                $link_attributes_external = $echo_Main_Settings['link_attributes_external'];
            } else {
                $link_attributes_external = '';
            }
            if (isset($echo_Main_Settings['link_append'])) {
                $link_append = $echo_Main_Settings['link_append'];
            } else {
                $link_append = '';
            }
            if (isset($echo_Main_Settings['date_format'])) {
                $date_format = $echo_Main_Settings['date_format'];
            } else {
                $date_format = '';
            }
            if (isset($echo_Main_Settings['do_not_check_duplicates'])) {
                $do_not_check_duplicates = $echo_Main_Settings['do_not_check_duplicates'];
            } else {
                $do_not_check_duplicates = '';
            }
            if (isset($echo_Main_Settings['check_title'])) {
                $check_title = $echo_Main_Settings['check_title'];
            } else {
                $check_title = '';
            }
            if (isset($echo_Main_Settings['append_enclosure'])) {
                $append_enclosure = $echo_Main_Settings['append_enclosure'];
            } else {
                $append_enclosure = '';
            }
            if (isset($echo_Main_Settings['add_attachments'])) {
                $add_attachments = $echo_Main_Settings['add_attachments'];
            } else {
                $add_attachments = '';
            }
            if (isset($echo_Main_Settings['add_gallery'])) {
                $add_gallery = $echo_Main_Settings['add_gallery'];
            } else {
                $add_gallery = '';
            }
            if (isset($echo_Main_Settings['link_source'])) {
                $link_source = $echo_Main_Settings['link_source'];
            } else {
                $link_source = '';
            }
            if (isset($echo_Main_Settings['rel_canonical'])) {
                $rel_canonical = $echo_Main_Settings['rel_canonical'];
            } else {
                $rel_canonical = '';
            }
            if (isset($echo_Main_Settings['no_link_translate'])) {
                $no_link_translate = $echo_Main_Settings['no_link_translate'];
            } else {
                $no_link_translate = '';
            }
            if (isset($echo_Main_Settings['no_failed_trans'])) {
                $no_failed_trans = $echo_Main_Settings['no_failed_trans'];
            } else {
                $no_failed_trans = '';
            }
            if (isset($echo_Main_Settings['shortest_api'])) {
                $shortest_api = $echo_Main_Settings['shortest_api'];
            } else {
                $shortest_api = '';
            }
            if (isset($echo_Main_Settings['iframe_resize_width'])) {
                $iframe_resize_width = $echo_Main_Settings['iframe_resize_width'];
            } else {
                $iframe_resize_width = '';
            }
            if (isset($echo_Main_Settings['iframe_resize_height'])) {
                $iframe_resize_height = $echo_Main_Settings['iframe_resize_height'];
            } else {
                $iframe_resize_height = '';
            }
            if (isset($echo_Main_Settings['skip_image_names'])) {
                $skip_image_names = $echo_Main_Settings['skip_image_names'];
            } else {
                $skip_image_names = '';
            }
            if (isset($echo_Main_Settings['no_check'])) {
                $no_check = $echo_Main_Settings['no_check'];
            } else {
                $no_check = '';
            }
            if (isset($echo_Main_Settings['link_feed_source'])) {
                $link_feed_source = $echo_Main_Settings['link_feed_source'];
            } else {
                $link_feed_source = '';
            }
            if (isset($echo_Main_Settings['draft_first'])) {
                $draft_first = $echo_Main_Settings['draft_first'];
            } else {
                $draft_first = '';
            }
            if (isset($echo_Main_Settings['go_utf'])) {
                $go_utf = $echo_Main_Settings['go_utf'];
            } else {
                $go_utf = '';
            }
            if (isset($echo_Main_Settings['full_descri'])) {
                $full_descri = $echo_Main_Settings['full_descri'];
            } else {
                $full_descri = '';
            }
            if (isset($echo_Main_Settings['global_ban_words'])) {
                $global_ban_words = $echo_Main_Settings['global_ban_words'];
            } else {
                $global_ban_words = '';
            }
            if (isset($echo_Main_Settings['global_req_words'])) {
                $global_req_words = $echo_Main_Settings['global_req_words'];
            } else {
                $global_req_words = '';
            }
            if (isset($echo_Main_Settings['new_category'])) {
                $new_category = $echo_Main_Settings['new_category'];
            } else {
                $new_category = '';
            }
            if (isset($echo_Main_Settings['no_existing_img'])) {
                $no_existing_img = $echo_Main_Settings['no_existing_img'];
            } else {
                $no_existing_img = '';
            }
            if (isset($echo_Main_Settings['proxy_url'])) {
                $proxy_url = $echo_Main_Settings['proxy_url'];
            } else {
                $proxy_url = '';
            }
            if (isset($echo_Main_Settings['proxy_auth'])) {
                $proxy_auth = $echo_Main_Settings['proxy_auth'];
            } else {
                $proxy_auth = '';
            }
            if (isset($echo_Main_Settings['secret_word'])) {
                $secret_word = $echo_Main_Settings['secret_word'];
            } else {
                $secret_word = '';
            }
            if (isset($echo_Main_Settings['post_source_custom'])) {
                $post_source_custom = $echo_Main_Settings['post_source_custom'];
            } else {
                $post_source_custom = '';
            }
            
            if (isset($echo_Main_Settings['scrapeimg_height'])) {
                $scrapeimg_height = $echo_Main_Settings['scrapeimg_height'];
            } else {
                $scrapeimg_height = '';
            }
            if (isset($echo_Main_Settings['attr_text'])) {
                $attr_text = $echo_Main_Settings['attr_text'];
            } else {
                $attr_text = '';
            }
            if (isset($echo_Main_Settings['scrapeimg_width'])) {
                $scrapeimg_width = $echo_Main_Settings['scrapeimg_width'];
            } else {
                $scrapeimg_width = '';
            }
            if (isset($echo_Main_Settings['scrapeimg_cat'])) {
                $scrapeimg_cat = $echo_Main_Settings['scrapeimg_cat'];
            } else {
                $scrapeimg_cat = '';
            }
            if (isset($echo_Main_Settings['scrapeimg_order'])) {
                $scrapeimg_order = $echo_Main_Settings['scrapeimg_order'];
            } else {
                $scrapeimg_order = '';
            }
            if (isset($echo_Main_Settings['scrapeimg_orientation'])) {
                $scrapeimg_orientation = $echo_Main_Settings['scrapeimg_orientation'];
            } else {
                $scrapeimg_orientation = '';
            }
            if (isset($echo_Main_Settings['imgtype'])) {
                $imgtype = $echo_Main_Settings['imgtype'];
            } else {
                $imgtype = '';
            }
            if (isset($echo_Main_Settings['img_order'])) {
                $img_order = $echo_Main_Settings['img_order'];
            } else {
                $img_order = '';
            }
            if (isset($echo_Main_Settings['scrapeimgtype'])) {
                $scrapeimgtype = $echo_Main_Settings['scrapeimgtype'];
            } else {
                $scrapeimgtype = '';
            }
            if (isset($echo_Main_Settings['pixabay_scrape'])) {
                $pixabay_scrape = $echo_Main_Settings['pixabay_scrape'];
            } else {
                $pixabay_scrape = '';
            }
            if (isset($echo_Main_Settings['img_editor'])) {
                $img_editor = $echo_Main_Settings['img_editor'];
            } else {
                $img_editor = '';
            }
            if (isset($echo_Main_Settings['img_language'])) {
                $img_language = $echo_Main_Settings['img_language'];
            } else {
                $img_language = '';
            }
            if (isset($echo_Main_Settings['img_ss'])) {
                $img_ss = $echo_Main_Settings['img_ss'];
            } else {
                $img_ss = '';
            }
            if (isset($echo_Main_Settings['img_mwidth'])) {
                $img_mwidth = $echo_Main_Settings['img_mwidth'];
            } else {
                $img_mwidth = '';
            }
            if (isset($echo_Main_Settings['img_width'])) {
                $img_width = $echo_Main_Settings['img_width'];
            } else {
                $img_width = '';
            }
            if (isset($echo_Main_Settings['img_cat'])) {
                $img_cat = $echo_Main_Settings['img_cat'];
            } else {
                $img_cat = '';
            }
            if (isset($echo_Main_Settings['pixabay_api'])) {
                $pixabay_api = $echo_Main_Settings['pixabay_api'];
            } else {
                $pixabay_api = '';
            }
            if (isset($echo_Main_Settings['pexels_api'])) {
                $pexels_api = $echo_Main_Settings['pexels_api'];
            } else {
                $pexels_api = '';
            }
            if (isset($echo_Main_Settings['morguefile_secret'])) {
                $morguefile_secret = $echo_Main_Settings['morguefile_secret'];
            } else {
                $morguefile_secret = '';
            }
            if (isset($echo_Main_Settings['morguefile_api'])) {
                $morguefile_api = $echo_Main_Settings['morguefile_api'];
            } else {
                $morguefile_api = '';
            }
            if (isset($echo_Main_Settings['bimage'])) {
                $bimage = $echo_Main_Settings['bimage'];
            } else {
                $bimage = '';
            }
            if (isset($echo_Main_Settings['no_orig'])) {
                $no_orig = $echo_Main_Settings['no_orig'];
            } else {
                $no_orig = '';
            }
            if (isset($echo_Main_Settings['no_royalty_skip'])) {
                $no_royalty_skip = $echo_Main_Settings['no_royalty_skip'];
            } else {
                $no_royalty_skip = '';
            }
            if (isset($echo_Main_Settings['flickr_order'])) {
                $flickr_order = $echo_Main_Settings['flickr_order'];
            } else {
                $flickr_order = '';
            }
            if (isset($echo_Main_Settings['flickr_license'])) {
                $flickr_license = $echo_Main_Settings['flickr_license'];
            } else {
                $flickr_license = '';
            }
            if (isset($echo_Main_Settings['flickr_api'])) {
                $flickr_api = $echo_Main_Settings['flickr_api'];
            } else {
                $flickr_api = '';
            }
            if (isset($echo_Main_Settings['echo_author_email'])) {
                $echo_author_email = $echo_Main_Settings['echo_author_email'];
            } else {
                $echo_author_email = '';
            }
            if (isset($echo_Main_Settings['echo_author_link'])) {
                $echo_author_link = $echo_Main_Settings['echo_author_link'];
            } else {
                $echo_author_link = '';
            }
            if (isset($echo_Main_Settings['echo_author'])) {
                $echo_author = $echo_Main_Settings['echo_author'];
            } else {
                $echo_author = '';
            }
            if (isset($echo_Main_Settings['feed_logo'])) {
                $feed_logo = $echo_Main_Settings['feed_logo'];
            } else {
                $feed_logo = '';
            }
            if (isset($echo_Main_Settings['echo_feed_description'])) {
                $echo_feed_description = $echo_Main_Settings['echo_feed_description'];
            } else {
                $echo_feed_description = '';
            }
            if (isset($echo_Main_Settings['echo_feed_title'])) {
                $echo_feed_title = $echo_Main_Settings['echo_feed_title'];
            } else {
                $echo_feed_title = '';
            }
            if (isset($echo_Main_Settings['echo_post_date'])) {
                $echo_post_date = $echo_Main_Settings['echo_post_date'];
            } else {
                $echo_post_date = '';
            }
            if (isset($echo_Main_Settings['echo_timestamp'])) {
                $echo_timestamp = $echo_Main_Settings['echo_timestamp'];
            } else {
                $echo_timestamp = '';
            }
            if (isset($echo_Main_Settings['echo_source_feed'])) {
                $echo_source_feed = $echo_Main_Settings['echo_source_feed'];
            } else {
                $echo_source_feed = '';
            }
            if (isset($echo_Main_Settings['echo_extra_tags'])) {
                $echo_extra_tags = $echo_Main_Settings['echo_extra_tags'];
            } else {
                $echo_extra_tags = '';
            }
            if (isset($echo_Main_Settings['echo_extra_categories'])) {
                $echo_extra_categories = $echo_Main_Settings['echo_extra_categories'];
            } else {
                $echo_extra_categories = '';
            }
            if (isset($echo_Main_Settings['echo_comment_status'])) {
                $echo_comment_status = $echo_Main_Settings['echo_comment_status'];
            } else {
                $echo_comment_status = '';
            }
            if (isset($echo_Main_Settings['echo_enable_pingbacks'])) {
                $echo_enable_pingbacks = $echo_Main_Settings['echo_enable_pingbacks'];
            } else {
                $echo_enable_pingbacks = '';
            }
            
            $get_option_viewed = get_option('coderevolution_settings_viewed', 0);
            if ($get_option_viewed == 0) {
            ?>
         <div id="message" class="updated">
            <p class="cr_saved_notif"><strong>&nbsp;<?php echo sprintf( wp_kses( __( 'Did you see our new <a href="%s" target="_blank">recommendations page</a>? It will help you increase your passive earnings!', 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'admin.php?page=echo_recommendations' ) );?></strong></p>
         </div>
         <?php
            }
            if( isset($_GET['settings-updated']) ) 
            {
            ?>
         <div id="message" class="updated">
            <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Settings saved.', 'rss-feed-post-generator-echo');?></strong></p>
         </div>
         <?php
            $get = get_option('coderevolution_settings_changed', 0);
            if($get == 1)
            {
                delete_option('coderevolution_settings_changed');
            ?>
         <div id="message" class="updated">
            <p class="cr_failed_notif"><strong>&nbsp;<?php echo esc_html__('Plugin registration failed!', 'rss-feed-post-generator-echo');?></strong></p>
         </div>
         <?php 
            }
            elseif($get == 2)
            {
                    delete_option('coderevolution_settings_changed');
            ?>
         <div id="message" class="updated">
            <p class="cr_saved_notif"><strong>&nbsp;<?php echo esc_html__('Plugin registration successful!', 'rss-feed-post-generator-echo');?></strong></p>
         </div>
         <?php 
            }
            }
            ?>
         <div>
            <div class="echo_class">
               <table>
                  <tr>
                     <td>
                        <h1>
                           <span class="gs-sub-heading"><b>Echo RSS Feed Post Generator Plugin - <?php echo esc_html__('Main Switch:', 'rss-feed-post-generator-echo');?></b>&nbsp;</span>
                           <span class="cr_07_font">v4.9&nbsp;</span>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Enable or disable this plugin. This acts like a main switch.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                        </h1>
                     </td>
                     <td>
                        <div class="slideThree">	
                           <input class="input-checkbox" type="checkbox" id="echo_enabled" name="echo_Main_Settings[echo_enabled]"<?php
                              if ($echo_enabled == 'on')
                                  echo ' checked ';
                              ?>>
                           <label for="echo_enabled"></label>
                        </div>
                     </td>
                  </tr>
               <tr><td colspan="2">
            </div>
            <div><?php if($echo_enabled != 'on'){echo '<div class="crf_bord cr_color_red cr_auto_update">' . esc_html__('This feature of the plugin is disabled! Please enable it from the above switch.', 'rss-feed-post-generator-echo') . '</div>';}?>
               <h3>
                  <ul>
                     <li><?php echo sprintf( wp_kses( __( 'Need help configuring this plugin? Please check out it\'s <a href="%s" target="_blank">video tutorial</a>.', 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'https://www.youtube.com/watch?v=09GlWkXl1ao&list=PLEiGTaa0iBIhKwBdxZMUdHHY4XuXLvctE' ) );?>
                     </li>
                     <li><?php echo sprintf( wp_kses( __( 'Having issues with the plugin? Please be sure to check out our <a href="%s" target="_blank">knowledge-base</a> before you contact <a href="%s" target="_blank">our support</a>!', 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//coderevolution.ro/knowledge-base' ), esc_url('//coderevolution.ro/support' ) );?></li>
                     <li><?php echo sprintf( wp_kses( __( 'Do you enjoy our plugin? Please give it a <a href="%s" target="_blank">rating</a>  on CodeCanyon, or check <a href="%s" target="_blank">our website</a>  for other cool plugins.', 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//codecanyon.net/downloads' ), esc_url( 'https://coderevolution.ro' ) );?></a></li>
                     <li><br/><br/><span class="cr_color_red"><?php echo esc_html__("Are you looking for a cool new theme that best fits this plugin?", 'rss-feed-post-generator-echo');?></span> <a onclick="revealRec()" class="cr_cursor_pointer"><?php echo esc_html__("Click here for our theme related recommendation", 'rss-feed-post-generator-echo');?></a>.
                        <br/><span id="diviIdrec"></span>
                     </li>
                  </ul>
               </h3>
</td>
               </tr>
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
                        <h3><b><?php echo esc_html__("Plugin Registration Info - Automatic Updates Enabled:", 'rss-feed-post-generator-echo');?></b> </h3>
                        <ul>
                           <li><b><?php echo esc_html__("Item Name:", 'rss-feed-post-generator-echo');?></b> <?php echo esc_html($uoptions['item_name']);?></li>
                           <li>
                              <b><?php echo esc_html__("Item ID:", 'rss-feed-post-generator-echo');?></b> <?php echo esc_html($uoptions['item_id']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Created At:", 'rss-feed-post-generator-echo');?></b> <?php echo esc_html($uoptions['created_at']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Buyer Name:", 'rss-feed-post-generator-echo');?></b> <?php echo esc_html($uoptions['buyer']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("License Type:", 'rss-feed-post-generator-echo');?></b> <?php echo esc_html($uoptions['licence']);?>
                           </li>
                           <li>
                              <b><?php echo esc_html__("Supported Until:", 'rss-feed-post-generator-echo');?></b> <?php echo esc_html($uoptions['supported_until']);?>
                           </li>
                        </ul>
                        <?php
                           }
                           else
                           {
                           ?>
                        <div class="notice notice-error is-dismissible"><p><?php echo esc_html__("Automatic updates for this plugin are disabled. Please activate the plugin from below, so you can benefit of automatic updates for it!", 'rss-feed-post-generator-echo');?></p></div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo sprintf( wp_kses( __( 'Please input your Envato purchase code, to enable automatic updates in the plugin. To get your purchase code, please follow <a href="%s" target="_blank">this tutorial</a>. Info submitted to the registration server consists of: purchase code, site URL, site name, admin email. All these data will be used strictly for registration purposes.', 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( '//coderevolution.ro/knowledge-base/faq/how-do-i-find-my-items-purchase-code-for-plugin-license-activation/' ) );
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Register Envato Purchase Code To Enable Automatic Updates:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td><input type="text" name="<?php echo esc_html($plugin_slug);?>_register_code" value="" placeholder="<?php echo esc_html__("Envato Purchase Code", 'rss-feed-post-generator-echo');?>"></td>
                  </tr>
                  <tr>
                     <td></td>
                     <td><input type="submit" name="<?php echo esc_html($plugin_slug);?>_register" id="<?php echo esc_html($plugin_slug);?>_register" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Register Purchase Code", 'rss-feed-post-generator-echo');?>"/>
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
                  <tr>
                     <td>
                        <h3><?php echo esc_html__("Getting started creating your rules:", 'rss-feed-post-generator-echo');?> </h3>
                     </td>
                  </tr>
                  <tr>
                     <td><a name="newest" href="admin.php?page=echo_items_panel"><?php echo esc_html__("Blog Posts Generator Using RSS Feed Source", 'rss-feed-post-generator-echo');?></a></td>
                     <td>
                        (<?php echo esc_html__("RSS to Post", 'rss-feed-post-generator-echo');?>)
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("You can start creating your rules which will automatically create posts from RSS feed sources.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td><a name="user" href="admin.php?page=echo_rss_generator"><?php echo esc_html__("RSS Feed Generator Using Blog Posts Source", 'rss-feed-post-generator-echo');?></a></td>
                     <td>
                        (<?php echo esc_html__("Post to RSS", 'rss-feed-post-generator-echo');?>)
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("You can start creating your rules which will automatically create RSS feeds from the posts on your blog.", 'rss-feed-post-generator-echo');
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
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("SimplePie Library Options:", 'rss-feed-post-generator-echo');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to use a custom SimplePie version instead of the built-in one in your WordPress installation.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Use Custom SimplePie Instead of the Built-In One:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="echo_custom_simplepie" name="echo_Main_Settings[echo_custom_simplepie]"<?php
                        if ($echo_custom_simplepie == 'on')
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
                                    echo esc_html__("Select this checkbox if the feed you are grabbing is failing (and the host is blocking the User-Agent WordPress uses).", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Use Custom User Agent In SimplePie:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="clear_user_agent" name="echo_Main_Settings[clear_user_agent]"<?php
                        if ($clear_user_agent == 'on')
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
                                    echo esc_html__("Click this option if your feeds are failing to create (this option will force the detection of a feed at the link you specify - will disable the built-in feed detection).", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Force Detection of Feeds at The Links You Specify:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="echo_force_feeds" name="echo_Main_Settings[echo_force_feeds]"<?php
                        if ($echo_force_feeds == 'on')
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
                                    echo esc_html__("Click this option if you want to disable the html sanitization/html tag stripping done by default by SimplePie. Note that SimplePie will strip away iframes from the feed content, so if you wish to display these, check this checkbox.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Do Not Sanitize/Strip HTML Tags:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="echo_no_strip" name="echo_Main_Settings[echo_no_strip]"<?php
                        if ($echo_no_strip == 'on')
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
                                    echo esc_html__("Click this option if your to enable feed caching - cache will be set to - plugin folder/res/cache.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Caching:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="echo_enable_caching" name="echo_Main_Settings[echo_enable_caching]"<?php
                        if ($echo_enable_caching == 'on')
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
                                    echo esc_html__("Click this option if you are experiencing malformed content in your post generation. Enabling this value may resolve such issues. If you do not have such issues with generated post content, please leave this checkbox disabled.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Clear Curl Decoding Value:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="echo_clear_curl_charset" name="echo_Main_Settings[echo_clear_curl_charset]"<?php
                        if ($echo_clear_curl_charset == 'on')
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
                                    echo sprintf( wp_kses( __( "Input a comma separated list of custom feed attributes that the plugin should import and make available for use. The resulting data, will be available for use in 'Generated Post Content' settings field, next to other shortcodes, with the name: %%custom_feed_*field_name*%%. Example of usage: if you want to import the &lt;location&gt; tag for feed, you should enter here: 'location'. You will be able to use this data with the shortcode: %%custom_feed_location%%. If the tag has a custom name space (customns='' tag in the feed tag name), then you should use this as follows: custom_feed_name_space_name:custom_tag_name and use the resulting shortcode as follows: %%custom_feed_*custom_name_space_name:custom_tag_name*%%. Example: to fetch this feed attribute: &lt;jobNumber xmlns=\"crelate\"&gt;147&lt;/jobNumber&gt;, you should enter: crelate:jobNumber and use the %%custom_feed_crelate:jobNumber%% shortcode to get it's content. Instead of the ':' separator you can use a 'Custom Tag Separator' using the settings field from below.", 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ) );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Feed Custom Tag Names:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="echo_Main_Settings[custom_feed_tag_list]" value="<?php echo esc_html($custom_feed_tag_list);?>" placeholder="<?php echo esc_html__("tag1,tag2,tag3", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Input a comma separated list of custom feed item attributes that the plugin should import and make available for use. The resulting data, will be available for use in 'Generated Post Content' settings field, next to other shortcodes, with the name: %%custom_*field_name*%%. Example of usage: if you want to import the &lt;location&gt; tag for feed items, you should enter here: 'location'. You will be able to use this data with the shortcode: %%custom_location%%. If the tag has a custom name space (customns='' tag in the feed tag name), then you should use this as follows: custom_name_space_name:custom_tag_name and use the resulting shortcode as follows: %%custom_*custom_name_space_name:custom_tag_name*%%. Example: to fetch this feed item attribute: &lt;jobNumber xmlns=\"crelate\"&gt;147&lt;/jobNumber&gt;, you should enter: crelate:jobNumber and use the %%custom_crelate:jobNumber%% shortcode to get it's content. Instead of the ':' separator you can use a 'Custom Tag Separator' using the settings field from below.", 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ) );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Feed Item Custom Tag Names:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="echo_Main_Settings[custom_tag_list]" value="<?php echo esc_html($custom_tag_list);?>" placeholder="<?php echo esc_html__("tag1,tag2,tag3", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input a separator to use between custom values. The default is : . If you wish to use the : character in the custom tags, you can change this value.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Custom Tag Separator:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="echo_Main_Settings[custom_tag_separator]" value="<?php echo esc_html($custom_tag_separator);?>" placeholder="<?php echo esc_html__(":", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input a separator to use between custom attribute values. The default is * . If you wish to use the * character in the custom attributes, you can change this value.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Custom Attreibute Separator:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="echo_Main_Settings[custom_attr_separator]" value="<?php echo esc_html($custom_attr_separator);?>" placeholder="<?php echo esc_html__("*", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("Post Images Options:", 'rss-feed-post-generator-echo');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Click this option if your want to try to get the featured image from the scaped post content, if anything else fails. If this feature is activated, rules can take a bit longer to run.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Try to Get Featured Image from Content:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="echo_get_image_from_content" name="echo_Main_Settings[echo_get_image_from_content]"<?php
                        if ($echo_get_image_from_content == 'on')
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
                                    echo esc_html__("Click this option if your want to save images found in post content locally. Note that this option may be heavy on your hosting free space.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Copy Images From Content Locally:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="copy_images" name="echo_Main_Settings[copy_images]"<?php
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
                                    echo esc_html__("Click this option if your want to set the featured image from the remote image location. This settings can save disk space, but beware that if the remote image gets deleted, your featured image will also be broken.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Do Not Copy Featured Image Locally:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="no_local_image" name="echo_Main_Settings[no_local_image]"<?php
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
                                    echo esc_html__("Click this option if your want to check images if they are not corrupt. If you have issues with featured image generation, uncheck this option.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Verify Featured Images If Not Corrupt:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="echo_featured_image_checking" name="echo_Main_Settings[echo_featured_image_checking]"<?php
                        if ($echo_featured_image_checking == 'on')
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
                                    echo esc_html__("Click this option if your images are broken (and they contain greek characters in their names).", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Fix Greek Strings From Image Names:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="fix_greek" name="echo_Main_Settings[fix_greek]"<?php
                        if ($fix_greek == 'on')
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
                                    echo esc_html__("Resize the image that was assigned to be the featured image to the width specified in this text field (in pixels). If you want to disable this feature, leave this field blank. This feature only works if you leave 'Do Not Copy Featured Image Locally' checkbox unchecked.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Resize Width:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" name="echo_Main_Settings[resize_width]" value="<?php echo esc_html($resize_width);?>" placeholder="<?php echo esc_html__("Please insert the desire width for featured images", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Resize the image that was assigned to be the featured image to the height specified in this text field (in pixels). If you want to disable this feature, leave this field blank. This feature only works if you leave 'Do Not Copy Featured Image Locally' checkbox unchecked.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Resize Height:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" name="echo_Main_Settings[resize_height]" value="<?php echo esc_html($resize_height);?>" placeholder="<?php echo esc_html__("Please insert the desire height for featured images", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the quality for the image that will be resized. If you leave this field blank, the maximum quality will be used.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Featured Image Resize Quality:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" max="100" name="echo_Main_Settings[resize_quality]" value="<?php echo esc_html($resize_quality);?>" placeholder="<?php echo esc_html__("Please insert the desire resize quality", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Resize the iframes that were imported from the custom content. If you want to disable this feature, leave this field blank.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Iframe Resize Width:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" name="echo_Main_Settings[iframe_resize_width]" value="<?php echo esc_html($iframe_resize_width);?>" placeholder="<?php echo esc_html__("Please insert the desire width for iframes", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Resize the iframes that were imported from the custom content. If you want to disable this feature, leave this field blank.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Iframe Resize Height:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" min="1" step="1" name="echo_Main_Settings[iframe_resize_height]" value="<?php echo esc_html($iframe_resize_height);?>" placeholder="<?php echo esc_html__("Please insert the desire height for iframes", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("Royalty Free Featured Image Importing Options:", 'rss-feed-post-generator-echo');?></h3>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your MorgueFile App ID. Register <a href='%s' target='_blank'>here</a>. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the MorgueFile API.", 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://morguefile.com/?mfr18=37077f5764c83cc98123ef1166ce2aa6" ),  esc_url( "https://morguefile.com/developer" ) );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("MorgueFile App ID:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="echo_Main_Settings[morguefile_api]" value="<?php
                              echo esc_html($morguefile_api);
                              ?>" placeholder="<?php echo esc_html__("Please insert your MorgueFile API key", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Insert your MorgueFile App Secret. Register <a href='%s' target='_blank'>here</a>. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the MorgueFile API.", 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://morguefile.com/?mfr18=37077f5764c83cc98123ef1166ce2aa6" ),  esc_url( "https://morguefile.com/developer" ) );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("MorgueFile App Secret:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="echo_Main_Settings[morguefile_secret]" value="<?php
                              echo esc_html($morguefile_secret);
                              ?>" placeholder="<?php echo esc_html__("Please insert your MorgueFile API Secret", 'rss-feed-post-generator-echo');?>">
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
                                    echo sprintf( wp_kses( __( "Insert your Pexels App ID. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the Pexels API.", 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://www.pexels.com/api/" ));
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Pexels App ID:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="echo_Main_Settings[pexels_api]" value="<?php
                              echo esc_html($pexels_api);
                              ?>" placeholder="<?php echo esc_html__("Please insert your Pexels API key", 'rss-feed-post-generator-echo');?>">
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
                                 echo sprintf( wp_kses( __( "Insert your Flickr App ID. Learn how to get an API key <a href='%s' target='_blank'>here</a>. If you enter an API Key and an API Secret, you will enable search for images using the Flickr API.", 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://www.flickr.com/services/apps/create/apply" ));
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Flickr App ID: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="text" name="echo_Main_Settings[flickr_api]" placeholder="<?php echo esc_html__("Please insert your Flickr APP ID", 'rss-feed-post-generator-echo');?>" value="<?php if(isset($flickr_api)){echo esc_html($flickr_api);}?>" class="cr_width_full" />
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("The license id for photos to be searched.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Photo License: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <select name="echo_Main_Settings[flickr_license]" class="cr_width_full">
                           <option value="-1" 
                              <?php
                                 if($flickr_license == '-1')
                                 {
                                     echo ' selected';
                                 }
                                 ?>
                              ><?php echo esc_html__("Do Not Search By Photo Licenses", 'rss-feed-post-generator-echo');?></option>
                           <option value="0"
                              <?php
                                 if($flickr_license == '0')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("All Rights Reserved", 'rss-feed-post-generator-echo');?></option>
                           <option value="1"
                              <?php
                                 if($flickr_license == '1')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NonCommercial-ShareAlike License", 'rss-feed-post-generator-echo');?></option>
                           <option value="2"
                              <?php
                                 if($flickr_license == '2')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NonCommercial License", 'rss-feed-post-generator-echo');?></option>
                           <option value="3"
                              <?php
                                 if($flickr_license == '3')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NonCommercial-NoDerivs License", 'rss-feed-post-generator-echo');?></option>
                           <option value="4"
                              <?php
                                 if($flickr_license == '4')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution License", 'rss-feed-post-generator-echo');?></option>
                           <option value="5"
                              <?php
                                 if($flickr_license == '5')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-ShareAlike License", 'rss-feed-post-generator-echo');?></option>
                           <option value="6"
                              <?php
                                 if($flickr_license == '6')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Attribution-NoDerivs License", 'rss-feed-post-generator-echo');?></option>
                           <option value="7"
                              <?php
                                 if($flickr_license == '7')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("No known copyright restrictions", 'rss-feed-post-generator-echo');?></option>
                           <option value="8"
                              <?php
                                 if($flickr_license == '8')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("United States Government Work", 'rss-feed-post-generator-echo');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("The order in which to sort returned photos. Deafults to date-posted-desc (unless you are doing a radial geo query, in which case the default sorting is by ascending distance from the point specified).", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Search Results Order: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <select name="echo_Main_Settings[flickr_order]" class="cr_width_full">
                           <option value="date-posted-desc"
                              <?php
                                 if($flickr_order == 'date-posted-desc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Posted Descendant", 'rss-feed-post-generator-echo');?></option>
                           <option value="date-posted-asc"
                              <?php
                                 if($flickr_order == 'date-posted-asc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Posted Ascendent", 'rss-feed-post-generator-echo');?></option>
                           <option value="date-taken-asc"
                              <?php
                                 if($flickr_order == 'date-taken-asc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Taken Ascendent", 'rss-feed-post-generator-echo');?></option>
                           <option value="date-taken-desc"
                              <?php
                                 if($flickr_order == 'date-taken-desc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Date Taken Descendant", 'rss-feed-post-generator-echo');?></option>
                           <option value="interestingness-desc"
                              <?php
                                 if($flickr_order == 'interestingness-desc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Interestingness Descendant", 'rss-feed-post-generator-echo');?></option>
                           <option value="interestingness-asc"
                              <?php
                                 if($flickr_order == 'interestingness-asc')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Interestingness Ascendant", 'rss-feed-post-generator-echo');?></option>
                           <option value="relevance"
                              <?php
                                 if($flickr_order == 'relevance')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Relevance", 'rss-feed-post-generator-echo');?></option>
                        </select>
                     </td>
                  </tr>
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
                                    echo sprintf( wp_kses( __( "Insert your Pixabay App ID. Learn how to get one <a href='%s' target='_blank'>here</a>. If you enter an API Key here, you will enable search for images using the Pixabay API.", 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://pixabay.com/api/docs/" ) );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Pixabay App ID:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="echo_Main_Settings[pixabay_api]" value="<?php
                              echo esc_html($pixabay_api);
                              ?>" placeholder="<?php echo esc_html__("Please insert your Pixabay API key", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Filter results by image type.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Image Types To Search:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <select class="cr_width_full" name="echo_Main_Settings[imgtype]" >
                              <option value='all'<?php
                                 if ($imgtype == 'all')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("All", 'rss-feed-post-generator-echo');?></option>
                              <option value='photo'<?php
                                 if ($imgtype == 'photo')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("Photo", 'rss-feed-post-generator-echo');?></option>
                              <option value='illustration'<?php
                                 if ($imgtype == 'illustration')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("Illustration", 'rss-feed-post-generator-echo');?></option>
                              <option value='vector'<?php
                                 if ($imgtype == 'vector')
                                     echo ' selected';
                                 ?>><?php echo esc_html__("Vector", 'rss-feed-post-generator-echo');?></option>
                           </select>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Order results by a predefined rule.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Results Order: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <select name="echo_Main_Settings[img_order]" class="cr_width_full">
                           <option value="popular"<?php
                              if ($img_order == "popular") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Popular", 'rss-feed-post-generator-echo');?></option>
                           <option value="latest"<?php
                              if ($img_order == "latest") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Latest", 'rss-feed-post-generator-echo');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Filter results by image category.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Category: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <select name="echo_Main_Settings[img_cat]" class="cr_width_full">
                           <option value="all"<?php
                              if ($img_cat == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'rss-feed-post-generator-echo');?></option>
                           <option value="fashion"<?php
                              if ($img_cat == "fashion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Fashion", 'rss-feed-post-generator-echo');?></option>
                           <option value="nature"<?php
                              if ($img_cat == "nature") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Nature", 'rss-feed-post-generator-echo');?></option>
                           <option value="backgrounds"<?php
                              if ($img_cat == "backgrounds") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Backgrounds", 'rss-feed-post-generator-echo');?></option>
                           <option value="science"<?php
                              if ($img_cat == "science") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Science", 'rss-feed-post-generator-echo');?></option>
                           <option value="education"<?php
                              if ($img_cat == "education") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Education", 'rss-feed-post-generator-echo');?></option>
                           <option value="people"<?php
                              if ($img_cat == "people") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("People", 'rss-feed-post-generator-echo');?></option>
                           <option value="feelings"<?php
                              if ($img_cat == "feelings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Feelings", 'rss-feed-post-generator-echo');?></option>
                           <option value="religion"<?php
                              if ($img_cat == "religion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Religion", 'rss-feed-post-generator-echo');?></option>
                           <option value="health"<?php
                              if ($img_cat == "health") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Health", 'rss-feed-post-generator-echo');?></option>
                           <option value="places"<?php
                              if ($img_cat == "places") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Places", 'rss-feed-post-generator-echo');?></option>
                           <option value="animals"<?php
                              if ($img_cat == "animals") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Animals", 'rss-feed-post-generator-echo');?></option>
                           <option value="industry"<?php
                              if ($img_cat == "industry") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Industry", 'rss-feed-post-generator-echo');?></option>
                           <option value="food"<?php
                              if ($img_cat == "food") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Food", 'rss-feed-post-generator-echo');?></option>
                           <option value="computer"<?php
                              if ($img_cat == "computer") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Computer", 'rss-feed-post-generator-echo');?></option>
                           <option value="sports"<?php
                              if ($img_cat == "sports") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Sports", 'rss-feed-post-generator-echo');?></option>
                           <option value="transportation"<?php
                              if ($img_cat == "transportation") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Transportation", 'rss-feed-post-generator-echo');?></option>
                           <option value="travel"<?php
                              if ($img_cat == "travel") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Travel", 'rss-feed-post-generator-echo');?></option>
                           <option value="buildings"<?php
                              if ($img_cat == "buildings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Buildings", 'rss-feed-post-generator-echo');?></option>
                           <option value="business"<?php
                              if ($img_cat == "business") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Business", 'rss-feed-post-generator-echo');?></option>
                           <option value="music"<?php
                              if ($img_cat == "music") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Music", 'rss-feed-post-generator-echo');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Minimum image width.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Min Width: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="number" min="1" step="1" name="echo_Main_Settings[img_width]" value="<?php echo esc_html($img_width);?>" placeholder="<?php echo esc_html__("Please insert image min width", 'rss-feed-post-generator-echo');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Maximum image width.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Max Width: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="number" min="1" step="1" name="echo_Main_Settings[img_mwidth]" value="<?php echo esc_html($img_mwidth);?>" placeholder="<?php echo esc_html__("Please insert image max width", 'rss-feed-post-generator-echo');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("A flag indicating that only images suitable for all ages should be returned.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Safe Search: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="checkbox" name="echo_Main_Settings[img_ss]"<?php
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
                                 echo esc_html__("Select images that have received an Editor's Choice award.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Editor\'s Choice: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="checkbox" name="echo_Main_Settings[img_editor]"<?php
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
                                 echo esc_html__("Specify default language for regional content.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Filter Language: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <select name="echo_Main_Settings[img_language]" class="cr_width_full">
                           <option value="any"<?php
                              if ($img_language == "any") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Any", 'rss-feed-post-generator-echo');?></option>
                           <option value="en"<?php
                              if ($img_language == "en") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("English", 'rss-feed-post-generator-echo');?></option>
                           <option value="cs"<?php
                              if ($img_language == "cs") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Czech", 'rss-feed-post-generator-echo');?></option>
                           <option value="da"<?php
                              if ($img_language == "da") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Danish", 'rss-feed-post-generator-echo');?></option>
                           <option value="de"<?php
                              if ($img_language == "de") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("German", 'rss-feed-post-generator-echo');?></option>
                           <option value="es"<?php
                              if ($img_language == "es") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Spanish", 'rss-feed-post-generator-echo');?></option>
                           <option value="fr"<?php
                              if ($img_language == "fr") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("French", 'rss-feed-post-generator-echo');?></option>
                           <option value="id"<?php
                              if ($img_language == "id") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Indonesian", 'rss-feed-post-generator-echo');?></option>
                           <option value="it"<?php
                              if ($img_language == "it") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Italian", 'rss-feed-post-generator-echo');?></option>
                           <option value="hu"<?php
                              if ($img_language == "hu") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Hungarian", 'rss-feed-post-generator-echo');?></option>
                           <option value="nl"<?php
                              if ($img_language == "nl") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Dutch", 'rss-feed-post-generator-echo');?></option>
                           <option value="no"<?php
                              if ($img_language == "no") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Norvegian", 'rss-feed-post-generator-echo');?></option>
                           <option value="pl"<?php
                              if ($img_language == "pl") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Polish", 'rss-feed-post-generator-echo');?></option>
                           <option value="pt"<?php
                              if ($img_language == "pt") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Portuguese", 'rss-feed-post-generator-echo');?></option>
                           <option value="ro"<?php
                              if ($img_language == "ro") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Romanian", 'rss-feed-post-generator-echo');?></option>
                           <option value="sk"<?php
                              if ($img_language == "sk") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Slovak", 'rss-feed-post-generator-echo');?></option>
                           <option value="fi"<?php
                              if ($img_language == "fi") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Finish", 'rss-feed-post-generator-echo');?></option>
                           <option value="sv"<?php
                              if ($img_language == "sv") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Swedish", 'rss-feed-post-generator-echo');?></option>
                           <option value="tr"<?php
                              if ($img_language == "tr") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Turkish", 'rss-feed-post-generator-echo');?></option>
                           <option value="vi"<?php
                              if ($img_language == "vi") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Vietnamese", 'rss-feed-post-generator-echo');?></option>
                           <option value="th"<?php
                              if ($img_language == "th") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Thai", 'rss-feed-post-generator-echo');?></option>
                           <option value="bg"<?php
                              if ($img_language == "bg") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Bulgarian", 'rss-feed-post-generator-echo');?></option>
                           <option value="ru"<?php
                              if ($img_language == "ru") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Russian", 'rss-feed-post-generator-echo');?></option>
                           <option value="el"<?php
                              if ($img_language == "el") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Greek", 'rss-feed-post-generator-echo');?></option>
                           <option value="ja"<?php
                              if ($img_language == "ja") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Japanese", 'rss-feed-post-generator-echo');?></option>
                           <option value="ko"<?php
                              if ($img_language == "ko") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Korean", 'rss-feed-post-generator-echo');?></option>
                           <option value="zh"<?php
                              if ($img_language == "zh") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Chinese", 'rss-feed-post-generator-echo');?></option>
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
                                 echo esc_html__("Select if you want to enable direct scraping of Pixabay website. This will generate different results from the API.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Enable Pixabay Direct Website Scraping: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="checkbox" name="echo_Main_Settings[pixabay_scrape]"<?php
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
                                 echo esc_html__("Filter results by image type.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Types To Search: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <select name="echo_Main_Settings[scrapeimgtype]" class="cr_width_full">
                           <option value="all"<?php
                              if ($scrapeimgtype == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'rss-feed-post-generator-echo');?></option>
                           <option value="photo"<?php
                              if ($scrapeimgtype == "photo") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Photo", 'rss-feed-post-generator-echo');?></option>
                           <option value="illustration"<?php
                              if ($scrapeimgtype == "illustration") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Illustration", 'rss-feed-post-generator-echo');?></option>
                           <option value="vector"<?php
                              if ($scrapeimgtype == "vector") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Vector", 'rss-feed-post-generator-echo');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Filter results by image orientation.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Orientation: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <select name="echo_Main_Settings[scrapeimg_orientation]" class="cr_width_full">
                           <option value="all"<?php
                              if ($scrapeimg_orientation == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'rss-feed-post-generator-echo');?></option>
                           <option value="horizontal"<?php
                              if ($scrapeimg_orientation == "horizontal") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Horizontal", 'rss-feed-post-generator-echo');?></option>
                           <option value="vertical"<?php
                              if ($scrapeimg_orientation == "vertical") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Vertical", 'rss-feed-post-generator-echo');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Order results by a predefined rule.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Results Order: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <select name="echo_Main_Settings[scrapeimg_order]" class="cr_width_full">
                           <option value="any"<?php
                              if ($scrapeimg_order == "any") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Any", 'rss-feed-post-generator-echo');?></option>
                           <option value="popular"<?php
                              if ($scrapeimg_order == "popular") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Popular", 'rss-feed-post-generator-echo');?></option>
                           <option value="latest"<?php
                              if ($scrapeimg_order == "latest") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Latest", 'rss-feed-post-generator-echo');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Filter results by image category.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Category: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <select name="echo_Main_Settings[scrapeimg_cat]" class="cr_width_full">
                           <option value="all"<?php
                              if ($scrapeimg_cat == "all") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("All", 'rss-feed-post-generator-echo');?></option>
                           <option value="fashion"<?php
                              if ($scrapeimg_cat == "fashion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Fashion", 'rss-feed-post-generator-echo');?></option>
                           <option value="nature"<?php
                              if ($scrapeimg_cat == "nature") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Nature", 'rss-feed-post-generator-echo');?></option>
                           <option value="backgrounds"<?php
                              if ($scrapeimg_cat == "backgrounds") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Backgrounds", 'rss-feed-post-generator-echo');?></option>
                           <option value="science"<?php
                              if ($scrapeimg_cat == "science") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Science", 'rss-feed-post-generator-echo');?></option>
                           <option value="education"<?php
                              if ($scrapeimg_cat == "education") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Education", 'rss-feed-post-generator-echo');?></option>
                           <option value="people"<?php
                              if ($scrapeimg_cat == "people") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("People", 'rss-feed-post-generator-echo');?></option>
                           <option value="feelings"<?php
                              if ($scrapeimg_cat == "feelings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Feelings", 'rss-feed-post-generator-echo');?></option>
                           <option value="religion"<?php
                              if ($scrapeimg_cat == "religion") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Religion", 'rss-feed-post-generator-echo');?></option>
                           <option value="health"<?php
                              if ($scrapeimg_cat == "health") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Health", 'rss-feed-post-generator-echo');?></option>
                           <option value="places"<?php
                              if ($scrapeimg_cat == "places") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Places", 'rss-feed-post-generator-echo');?></option>
                           <option value="animals"<?php
                              if ($scrapeimg_cat == "animals") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Animals", 'rss-feed-post-generator-echo');?></option>
                           <option value="industry"<?php
                              if ($scrapeimg_cat == "industry") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Industry", 'rss-feed-post-generator-echo');?></option>
                           <option value="food"<?php
                              if ($scrapeimg_cat == "food") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Food", 'rss-feed-post-generator-echo');?></option>
                           <option value="computer"<?php
                              if ($scrapeimg_cat == "computer") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Computer", 'rss-feed-post-generator-echo');?></option>
                           <option value="sports"<?php
                              if ($scrapeimg_cat == "sports") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Sports", 'rss-feed-post-generator-echo');?></option>
                           <option value="transportation"<?php
                              if ($scrapeimg_cat == "transportation") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Transportation", 'rss-feed-post-generator-echo');?></option>
                           <option value="travel"<?php
                              if ($scrapeimg_cat == "travel") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Travel", 'rss-feed-post-generator-echo');?></option>
                           <option value="buildings"<?php
                              if ($scrapeimg_cat == "buildings") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Buildings", 'rss-feed-post-generator-echo');?></option>
                           <option value="business"<?php
                              if ($scrapeimg_cat == "business") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Business", 'rss-feed-post-generator-echo');?></option>
                           <option value="music"<?php
                              if ($scrapeimg_cat == "music") {
                                  echo " selected";
                              }
                              ?>><?php echo esc_html__("Music", 'rss-feed-post-generator-echo');?></option>
                        </select>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Minimum image width.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Min Width: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="number" min="1" step="1" name="echo_Main_Settings[scrapeimg_width]" value="<?php echo esc_html($scrapeimg_width);?>" placeholder="<?php echo esc_html__("Please insert image min width", 'rss-feed-post-generator-echo');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Maximum image height.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Image Min Height: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="number" min="1" step="1" name="echo_Main_Settings[scrapeimg_height]" value="<?php echo esc_html($scrapeimg_height);?>" placeholder="<?php echo esc_html__("Please insert image min height", 'rss-feed-post-generator-echo');?>" class="cr_width_full">     
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
                                 echo esc_html__("Please set a the image attribution shortcode value. You can use this value, using the %%image_attribution%% shortcode, in 'Prepend Content With' and 'Append Content With' settings fields. You can use the following shortcodes, in this settings field: %%image_source_name%%, %%image_source_website%%, %%image_source_url%%. These will be updated automatically for the respective image source, from where the imported image is from. This will replace the %%royalty_free_image_attribution%% shortcode, in 'Generated Post Content' settings field.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Royalty Free Image Attribution Text (%%royalty_free_image_attribution%%): ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="text" name="echo_Main_Settings[attr_text]" value="<?php echo esc_html(stripslashes($attr_text));?>" placeholder="<?php echo esc_html__("Please insert image attribution text pattern", 'rss-feed-post-generator-echo');?>" class="cr_width_full">     
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Do you want to enable broad search for royalty free images?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Enable broad image search: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="checkbox" name="echo_Main_Settings[bimage]" <?php
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
                                 echo esc_html__("Do you want to not use article's original image if no royalty free image found for the post?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Do Not Use Original Image If No Free Image Found: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="checkbox" name="echo_Main_Settings[no_orig]" <?php
                           if ($no_orig == 'on') {
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
                                 echo esc_html__("Do you want to not skip importing the aritcle if no royalty free image found for the post?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Skip Importing of Article If No Free Image Found: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <input type="checkbox" name="echo_Main_Settings[no_royalty_skip]" <?php
                           if ($no_royalty_skip == 'on') {
                               echo 'checked="checked"';
                           }
                           ?> />
                     </td>
                  </tr>
                  </td></tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("Generated Custom Feed Options:", 'rss-feed-post-generator-echo');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Check this to make the plugin link articles directly to their sources, in custom feeds this plugin creates. Please note that this feature will have effect only if the articles from the feeds were created by this plugin.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Link Articles From Generated Feeds Directly to Their Source:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="link_feed_source" name="echo_Main_Settings[link_feed_source]"<?php
                           if ($link_feed_source == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("Plugin Options:", 'rss-feed-post-generator-echo');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Check this to force the plugin to not crawl content that is disallowed for crawling by a robots meta tag.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Respect Robots HTML Header For Crawled Pages:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="enable_robots" name="echo_Main_Settings[enable_robots]"<?php
                           if ($enable_robots == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Check this to enable XML-RPC pinging for feeds, to start running importing in the plugin (minimum ping interval is 1 hour).", 'rss-feed-post-generator-echo');echo '&nbsp;<br/>';echo sprintf( wp_kses( __( "More info: <a href='%s' target='_blank'>here</a>.", 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "https://coderevolution.ro/knowledge-base/faq/how-to-call-xml-rpc-to-update-feeds-in-echo-rss-plugin-on-your-wordpress-site/" ));
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Enable XML-RPC Ping to Run Importing for Feeds:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="xmlrpc_enabled" name="echo_Main_Settings[xmlrpc_enabled]"<?php
                           if ($xmlrpc_enabled == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Check this to force the plugin not check generated posts in rule settings. Improves performance if you have 100k posts generated using this plugin.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Do Not Check Generated Posts In Rule Settings:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="no_check" name="echo_Main_Settings[no_check]"<?php
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
                                 echo esc_html__("Check this to force the plugin to make draft posts before they would be fully published. This can help you you use other third party plugins with the automatically published posts.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Draft Posts First, And Publish Them Afterwards:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="draft_first" name="echo_Main_Settings[draft_first]"<?php
                           if ($draft_first == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select if you want to convert encoding of imported content to UTF-8. Check this is you get feeds with corrupt characters. For this feature to work, mbstring PHP extension must be installed.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Convert Encoding Of Imported Content To UTF-8:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="go_utf" name="echo_Main_Settings[go_utf]"<?php
                           if ($go_utf == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select if you wish to apply full content for custom feeds description also (if you uncheck this, only content will be populated with full post content - for custom created feeds).", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Apply Full Content Also To Generated Feeds Description:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="full_descri" name="echo_Main_Settings[full_descri]"<?php
                           if ($full_descri == 'on')
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
                                    echo esc_html__("Select a secret word that will be used when you run the plugin manually/by cron. See details about this below.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Secret Word Used For Manual/Cron Running:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="text" id="secret_word" name="echo_Main_Settings[secret_word]" value="<?php echo esc_html($secret_word);?>" placeholder="<?php echo esc_html__("Input a secret word", 'rss-feed-post-generator-echo');?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <div>
                           <br/><b><?php echo esc_html__("If you want to schedule the cron event manually in your server, you should schedule this address:", 'rss-feed-post-generator-echo');?> <span class="cr_red"><?php if($secret_word != '') { echo get_site_url() . '/?run_echo=' . $secret_word;} else { echo esc_html__('You must enter a secret word above, to use this feature.', 'rss-feed-post-generator-echo'); }?></span><br/><?php echo esc_html__("Example:", 'rss-feed-post-generator-echo');?> <span class="cr_red"><?php if($secret_word != '') { echo '15,45****wget -q -O /dev/null ' . get_site_url() . '/?run_echo=' . $secret_word;} else { echo esc_html__('You must enter a secret word above, to use this feature.', 'rss-feed-post-generator-echo'); }?></span></b>
                        </div>
                        <br/><br/>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Click this option to enable the post auto deletion feature after a period of time (defined by the 'Automatically Delete Post' settings for each rule).", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Post Auto Deletion Feature:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="auto_delete_enabled" name="echo_Main_Settings[auto_delete_enabled]"<?php
                        if ($auto_delete_enabled == 'on')
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
                                    echo esc_html__("Choose if you want to show an extended information metabox under every plugin generated post.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Show Extended Item Information Metabox in Post:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="enable_metabox" name="echo_Main_Settings[enable_metabox]"<?php
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
                                    echo esc_html__("Do you want to enable logging for rules?", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Logging for Rules:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="enable_logging" name="echo_Main_Settings[enable_logging]" onclick="mainChanged()"<?php
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
                                    echo esc_html__("Do you want to enable detailed logging for rules? Note that this will dramatically increase the size of the log this plugin generates.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable Detailed Logging for Rules:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideLog">
                           <input type="checkbox" id="enable_detailed_logging" name="echo_Main_Settings[enable_detailed_logging]"<?php
                              if ($enable_detailed_logging == 'on')
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
                                    echo esc_html__("Choose if you want to automatically clear logs after a period of time.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Automatically Clear Logs After:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideLog">
                           <select id="auto_clear_logs" name="echo_Main_Settings[auto_clear_logs]" >
                              <option value="No"<?php
                                 if ($auto_clear_logs == "No") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Disabled", 'rss-feed-post-generator-echo');?></option>
                              <option value="monthly"<?php
                                 if ($auto_clear_logs == "monthly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a month", 'rss-feed-post-generator-echo');?></option>
                              <option value="weekly"<?php
                                 if ($auto_clear_logs == "weekly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a week", 'rss-feed-post-generator-echo');?></option>
                              <option value="daily"<?php
                                 if ($auto_clear_logs == "daily") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once a day", 'rss-feed-post-generator-echo');?></option>
                              <option value="twicedaily"<?php
                                 if ($auto_clear_logs == "twicedaily") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Twice a day", 'rss-feed-post-generator-echo');?></option>
                              <option value="hourly"<?php
                                 if ($auto_clear_logs == "hourly") {
                                     echo " selected";
                                 }
                                 ?>><?php echo esc_html__("Once an hour", 'rss-feed-post-generator-echo');?></option>
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
                                    echo esc_html__("Choose if you want to search Google Archives when you don't have access to the direct CarreerJet webpage.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Search Google Archives When Direct Page Fetching Fails:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="search_google" name="echo_Main_Settings[search_google]"<?php
                        if ($search_google == 'on')
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
                                    echo esc_html__("If you want to use a custom string for the 'Post Source' meta data assigned to posts, please input it here. If you will leave this blank, the default 'Post Source' value will be assigned to posts.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Custom 'Post Source' Post Meta Data:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="post_source_custom" placeholder="<?php echo esc_html__("Input a custom post source string", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[post_source_custom]" value="<?php echo esc_html($post_source_custom);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("If you want to use a proxy to crawl webpages, input it's address here. Required format: IP Address/URL:port", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Web Proxy Address:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="proxy_url" placeholder="<?php echo esc_html__("Input web proxy url", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[proxy_url]" value="<?php echo esc_html($proxy_url);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("If you want to use a proxy to crawl webpages, and it requires authentication, input it's authentication details here. Required format: username:password", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Web Proxy Authentication:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="proxy_auth" placeholder="<?php echo esc_html__("Input web proxy auth", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[proxy_auth]" value="<?php echo esc_html($proxy_auth);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the timeout (in seconds) for every rule running. I recommend that you leave this field at it's default value (3600).", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Timeout for Rule Running (seconds):", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="rule_timeout" step="1" min="0" placeholder="<?php echo esc_html__("Input rule timeout in seconds", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[rule_timeout]" value="<?php echo esc_html($rule_timeout);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Define a number of seconds the plugin should wait between the rule running. Use this to not decrease the use of your server's resources. Leave blank to disable.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Delay Between Rule Running:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" min="0" step="1" name="echo_Main_Settings[rule_delay]" value="<?php echo esc_html($rule_delay);?>" placeholder="<?php echo esc_html__("delay (s)", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to receive a summary of the rule running in an email.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Send Rule Running Summary in Email:", 'rss-feed-post-generator-echo');?></b>            
                     </td>
                     <td>
                     <input type="checkbox" id="send_email" name="echo_Main_Settings[send_email]" onchange="mainChanged()"<?php
                        if ($send_email == 'on')
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
                                    echo esc_html__("Do you want to send each published post in email to the defined email address below?", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Send Each Post in Email:", 'rss-feed-post-generator-echo');?></b>                
                     </td>
                     <td>
                     <input type="checkbox" id="send_post_email" name="echo_Main_Settings[send_post_email]" onchange="mainChanged()"<?php
                        if ($send_post_email == 'on')
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
                                    echo esc_html__("Input the email adress where you want to send the report. You can input more email addresses, separated by commas.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Email Address:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideMail">
                           <input type="email" id="email_address" placeholder="<?php echo esc_html__("Input a valid email adress", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[email_address]" value="<?php echo esc_html($email_address);?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideMail">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select if you wish to get only a single daily summary email (instead of one email for each rule running).", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Send Only A Daily Summary Email:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideMail">
                           <input type="checkbox" id="email_summary" name="echo_Main_Settings[email_summary]" <?php
                              if ($email_summary == 'on')
                                  echo ' checked ';
                              ?>>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div>
                              <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                                 <div class="bws_hidden_help_text cr_min_260px">
                                    <?php
                                       echo esc_html__("Choose if you want to skip checking for duplicate posts when publishing new posts (check this if you have 10000+ posts on your blog and you are experiencing slowdows when the plugin is running. If you check this, duplicate posts will be posted! So use it only when it is necesarry.", 'rss-feed-post-generator-echo');
                                       ?>
                                 </div>
                              </div>
                              <b><?php echo esc_html__("Do Not Check For Duplicate Posts:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="do_not_check_duplicates" name="echo_Main_Settings[do_not_check_duplicates]"<?php
                        if ($do_not_check_duplicates == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr><td>
                  <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                  <?php
                     echo esc_html__("Check this to force the plugin not check generated posts in rule settings. Improves performance if you have 100k posts generated using this plugin.", 'rss-feed-post-generator-echo');
                     ?>
                  </div>
                  </div>
                  <b><?php echo esc_html__("Check Duplicate Posts By Title Instead of Source URL:", 'rss-feed-post-generator-echo');?></b>
                  </td><td>
                  <input type="checkbox" id="check_title" name="echo_Main_Settings[check_title]"<?php
                     if ($check_title == 'on')
                         echo ' checked ';
                     ?>>
                  </div>
                  </td></tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("Post Content Options:", 'rss-feed-post-generator-echo');?></h3>
                     </td>
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
                                    echo sprintf( wp_kses( __( "If you wish to shorten outgoing links using shorte.st, please enter your API token here. To sign up for a new account, click <a href='%s' target='_blank'>here</a>. To get your API token after you have signed up, click <a href='%s' target='_blank'>here</a>. To disable URL shortening, leave this field blank.", 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "http://join-shortest.com/ref/ff421f2b06?user-type=new" ), esc_url( 'https://shorte.st/tools/api?user-type=new'));
                                    ?>
                              </div>
                           </div>
                           <b><a href="http://join-shortest.com/ref/ff421f2b06?user-type=new" target="_blank"><?php echo esc_html__("Shorte.st API Token", 'rss-feed-post-generator-echo');?></a>:</b>
                     </td>
                     <td>
                     <input type="text" name="echo_Main_Settings[shortest_api]" value="<?php
                        echo esc_html($shortest_api);
                        ?>" placeholder="<?php echo esc_html__("Shorte.st API token", 'rss-feed-post-generator-echo');?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to keep original link sources after translation? If you uncheck this, links will point to Google Translate version of the linked website.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Keep Original Link Source After Translation:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="no_link_translate" name="echo_Main_Settings[no_link_translate]"<?php
                        if ($no_link_translate == 'on')
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
                                    echo esc_html__("Do you want to not import posts that were failed in the translation process.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Do Not Post Failed Translation Posts:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="no_failed_trans" name="echo_Main_Settings[no_failed_trans]"<?php
                        if ($no_failed_trans == 'on')
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
                                    echo esc_html__("Select if you want to add a 'rel=canonical' meta tag to generated posts, linking back to the source of the article. This will affect all importing rules.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Add \"rel=canonical\" Meta Tag To Generated Posts (Global):", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="rel_canonical" name="echo_Main_Settings[rel_canonical]"<?php
                        if ($rel_canonical == 'on')
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
                                    echo esc_html__("Select if you want to enable linking of generated post titles to source articles. You must also enable this from importing rule settings for posts to be linked to source.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Enable the 'Link Generated Post Titles To Source Articles' Feature:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="link_source" name="echo_Main_Settings[link_source]"<?php
                        if ($link_source == 'on')
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
                                    echo esc_html__("Enable this to append media found in feed enclosures to post's content.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Append Media From Feed Enclosure To Post Content:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="append_enclosure" name="echo_Main_Settings[append_enclosure]"<?php
                        if ($append_enclosure == 'on')
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
                                    echo esc_html__("Enable this to append media found in feed enclosures to posts as attachments.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Add Images From Feeds As Post Attachments:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="add_attachments" name="echo_Main_Settings[add_attachments]"<?php
                        if ($add_attachments == 'on')
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
                                    echo esc_html__("Enable this to append post attachments to generated post's content, as a gallery.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Append To Post Content A Gallery With Post Attachment Images:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="add_gallery" name="echo_Main_Settings[add_gallery]"<?php
                        if ($add_gallery == 'on')
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
                                    echo esc_html__("Disable excerpt automatic generation for resulting blog posts.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Disable Automatic Excerpt Generation:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="disable_excerpt" name="echo_Main_Settings[disable_excerpt]"<?php
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
                                    echo esc_html__("Select the word count of the automatically generated excerpt.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Excerpt Word Count:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="number" id="excerpt_length" name="echo_Main_Settings[excerpt_length]" placeholder="<?php echo esc_html__("55", 'rss-feed-post-generator-echo');?>" value="<?php echo esc_html($excerpt_length);?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the user ID you wish to assign to posts that do not have a user ID extracted from feeds. Default is 1 - admin", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Default Post Author User ID:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="number" min="1" step="1" id="def_user" name="echo_Main_Settings[def_user]" placeholder="<?php echo esc_html__("1", 'rss-feed-post-generator-echo');?>" value="<?php echo esc_html($def_user);?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you the plugin to generate new categories if the category does not already exist.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Do Not Generate Inexistent Categories for New Posts:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="new_category" name="echo_Main_Settings[new_category]"<?php
                        if ($new_category == 'on')
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
                                    echo esc_html__("Select if you want to change the featured images for already imported posts. This might prevent duplicate image creation in image library.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Do Not Change Featured Images for Updated Posts:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="no_existing_img" name="echo_Main_Settings[no_existing_img]"<?php
                        if ($no_existing_img == 'on')
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
                                    echo esc_html__("Choose if you want to strip featured image from the generated post content.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Strip Featured Image From Generated Post Content:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="strip_featured_image" name="echo_Main_Settings[strip_featured_image]"<?php
                        if ($strip_featured_image == 'on')
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
                                    echo esc_html__("Choose if you want to strip links from the generated post final content (including links that are added by you using shortcodes).", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Strip Links From Generated Post Final Content:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="strip_links" name="echo_Main_Settings[strip_links]"<?php
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
                                    echo esc_html__("Choose if you want to strip links from the generated post content (this will strip links only from the imported content and will leave links that are added by you, using shortcodes).", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Strip Links From Generated Post Imported Content:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="strip_content_links" name="echo_Main_Settings[strip_content_links]"<?php
                        if ($strip_content_links == 'on')
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
                                    echo esc_html__("Enable this to open all links from post content in a new tab.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Open All Links From Post In a New Tab (target=\"_blank\"):", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="link_new_tab" name="echo_Main_Settings[link_new_tab]"<?php
                        if ($link_new_tab == 'on')
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
                                    echo esc_html__("Enable this to add rel='nofollow' to all links from the post's content.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Add Rel=\"nofollow\" to All Links From Posts:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="link_nofollow" name="echo_Main_Settings[link_nofollow]"<?php
                        if ($link_nofollow == 'on')
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
                                    echo esc_html__("Choose if you want to strip javascript from the crawled post content.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Strip JavaScript From Crawled Content:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="strip_scripts" name="echo_Main_Settings[strip_scripts]"<?php
                        if ($strip_scripts == 'on')
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
                                    echo esc_html__("Input the width of the screenshot that will be generated for crawled pages. This will affect the content generated by the %%item_show_screenshot%% shortcode. The default is 600.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Page Screenshot Width:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="text" id="screenshot_width" name="echo_Main_Settings[screenshot_width]" value="<?php echo esc_html($screenshot_width);?>" placeholder="<?php echo esc_html__("600", 'rss-feed-post-generator-echo');?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input the height of the screenshot that will be generated for crawled pages. This will affect the content generated by the %%item_show_screenshot%% shortcode. The default is 450.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Page Screenshot Height:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="text" id="screenshot_height" name="echo_Main_Settings[screenshot_height]" value="<?php echo esc_html($screenshot_height);?>" placeholder="<?php echo esc_html__("450", 'rss-feed-post-generator-echo');?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input the attributes you want to set for each internal link from content.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Add Attributes to Internal Links:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="text" id="link_attributes_internal" name="echo_Main_Settings[link_attributes_internal]" placeholder="<?php echo esc_html__("Internal link paramenters", 'rss-feed-post-generator-echo');?>" value="<?php echo htmlentities($link_attributes_internal);?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input the attributes you want to set for each external link from content.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Add Attributes to External Links:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="text" id="link_attributes_external" name="echo_Main_Settings[link_attributes_external]" placeholder="<?php echo esc_html__("External link paramenters", 'rss-feed-post-generator-echo');?>" value="<?php echo htmlentities($link_attributes_external);?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Append this string to all links from the post content. Great value for affiliates! This settings will be overwritten by the same named settings from individual rule settings (if not blank).", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Append This String To All Links From Content:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="text" id="link_append" name="echo_Main_Settings[link_append]" placeholder="<?php echo esc_html__("Append string to links", 'rss-feed-post-generator-echo');?>" value="<?php echo htmlentities($link_append);?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Set the date format for the %%item_pub_date%% shortcode. Example: Y-m-d H:i:s . You can read more about date formats, <a href='%s' target='_blank'>here</a>. To leave this at it's default value, leave this field blank.", 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( 'http://php.net/manual/ro/function.date.php' ) );
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Date Format for the %%item_pub_date%% Shortcode:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="text" id="date_format" name="echo_Main_Settings[date_format]" placeholder="<?php echo esc_html__("Add a date format", 'rss-feed-post-generator-echo');?>" value="<?php echo esc_html($date_format);?>">
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to replace all URLs from generated posts content with this predefined URL?", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Replace All URLs from Content With This URL:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="url" validator="url" id="replace_url" name="echo_Main_Settings[replace_url]" placeholder="<?php echo esc_html__("URL replacement", 'rss-feed-post-generator-echo');?>" value="<?php echo esc_html($replace_url);?>">               
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert the desired text to be show for the 'Read More' buttons. Exemple: for the %%item_read_more_button%% shortcode or for the excerpt.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("'Read More' Button Text:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div >
                           <input type="text" name="echo_Main_Settings[read_more_text]" value="<?php echo esc_html($read_more_text);?>" placeholder="<?php echo esc_html__("Please insert the text to be show for the 'Read More' links", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input a comma separated list of words which will be replace the %%conditional_words%% which can be used in the 'Generated Post Title' or the 'Generated Post Content' settings fields. This shortcode will be replaced with the first word from this list, that will be found in the imported post content.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Conditional Word List (%%conditional_words%% shortcode):", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div >
                           <input type="text" name="echo_Main_Settings[conditional_words]" value="<?php echo esc_html($conditional_words);?>" placeholder="<?php echo esc_html__("Conditional words list", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("Posting Restrictions Options:", 'rss-feed-post-generator-echo');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the minimum word count for post titles. Items that have less than this count will not be published. To disable this feature, leave this field blank.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Minimum Title Word Count (Skip Post Otherwise):", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="min_word_title" step="1" placeholder="<?php echo esc_html__("Input the minimum word count for the title", 'rss-feed-post-generator-echo');?>" min="0" name="echo_Main_Settings[min_word_title]" value="<?php echo esc_html($min_word_title);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the maximum word count for post titles. Items that have more than this count will not be published. To disable this feature, leave this field blank.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Maximum Title Word Count (Skip Post Otherwise):", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="max_word_title" step="1" min="0" placeholder="<?php echo esc_html__("Input the maximum word count for the title", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[max_word_title]" value="<?php echo esc_html($max_word_title);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the minimum word count for post content. Items that have less than this count will not be published. To disable this feature, leave this field blank.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Minimum Content Word Count (Skip Post Otherwise):", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="min_word_content" step="1" min="0" placeholder="<?php echo esc_html__("Input the minimum word count for the content", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[min_word_content]" value="<?php echo esc_html($min_word_content);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the maximum word count for post content. Items that have more than this count will not be published. To disable this feature, leave this field blank.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Maximum Content Word Count (Skip Post Otherwise):", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="max_word_content" step="1" min="0" placeholder="<?php echo esc_html__("Input the maximum word count for the content", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[max_word_content]" value="<?php echo esc_html($max_word_content);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to skip posts that have these words in their featured image names? To disable this feature, leave this field blank. You can also use wildcards in the expressions.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Skip Posts With These Words In Their Featured Image Names:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" name="echo_Main_Settings[skip_image_names]" value="<?php echo esc_html($skip_image_names);?>" placeholder="<?php echo esc_html__("Select the words of images to skip", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to skip posts that do not have images.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Skip Posts That Do Not Have Images:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="skip_no_img" name="echo_Main_Settings[skip_no_img]"<?php
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
                                    echo esc_html__("Set the required words list that will apply to all plugin rules.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Global Required Words List:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <textarea rows="3" cols="70" name="echo_Main_Settings[global_req_words]" placeholder="<?php echo esc_html__("Please insert the global required words list", 'rss-feed-post-generator-echo');?>"><?php echo esc_textarea($global_req_words);?></textarea>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to require only one word from the 'Required Words List' for the post to be accepted.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Require Only One Word From The 'Required Words List':", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="require_only_one" name="echo_Main_Settings[require_only_one]"<?php
                        if ($require_only_one == 'on')
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
                                    echo esc_html__("Set the banned words list that will apply to all plugin rules.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Global Banned Words List:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <textarea rows="3" cols="70" name="echo_Main_Settings[global_ban_words]" placeholder="<?php echo esc_html__("Please insert the global banned words list", 'rss-feed-post-generator-echo');?>"><?php echo esc_textarea($global_ban_words);?></textarea>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to skip posts that are older than a selected date.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Skip Posts Older Than a Selected Date:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="skip_old" name="echo_Main_Settings[skip_old]" onchange="mainChanged()"<?php
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
                                    echo esc_html__("Select the date prior which you want to skip posts.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Select the Date for Old Posts:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div class='hideOld'>
                           <?php echo esc_html__("Day:", 'rss-feed-post-generator-echo');?>
                           <select class="cr_width_80" name="echo_Main_Settings[skip_day]" >
                              <option value='01'<?php if($skip_day == '01')echo ' selected';?>>01</option>
                              <option value='02'<?php if($skip_day == '02')echo ' selected';?>>02</option>
                              <option value='03'<?php if($skip_day == '03')echo ' selected';?>>03</option>
                              <option value='04'<?php if($skip_day == '04')echo ' selected';?>>04</option>
                              <option value='05'<?php if($skip_day == '05')echo ' selected';?>>05</option>
                              <option value='06'<?php if($skip_day == '06')echo ' selected';?>>06</option>
                              <option value='07'<?php if($skip_day == '07')echo ' selected';?>>07</option>
                              <option value='08'<?php if($skip_day == '08')echo ' selected';?>>08</option>
                              <option value='09'<?php if($skip_day == '09')echo ' selected';?>>09</option>
                              <option value='10'<?php if($skip_day == '10')echo ' selected';?>>10</option>
                              <option value='11'<?php if($skip_day == '11')echo ' selected';?>>11</option>
                              <option value='12'<?php if($skip_day == '12')echo ' selected';?>>12</option>
                              <option value='13'<?php if($skip_day == '13')echo ' selected';?>>13</option>
                              <option value='14'<?php if($skip_day == '14')echo ' selected';?>>14</option>
                              <option value='15'<?php if($skip_day == '15')echo ' selected';?>>15</option>
                              <option value='16'<?php if($skip_day == '16')echo ' selected';?>>16</option>
                              <option value='17'<?php if($skip_day == '17')echo ' selected';?>>17</option>
                              <option value='18'<?php if($skip_day == '18')echo ' selected';?>>18</option>
                              <option value='19'<?php if($skip_day == '19')echo ' selected';?>>19</option>
                              <option value='20'<?php if($skip_day == '20')echo ' selected';?>>20</option>
                              <option value='21'<?php if($skip_day == '21')echo ' selected';?>>21</option>
                              <option value='22'<?php if($skip_day == '22')echo ' selected';?>>22</option>
                              <option value='23'<?php if($skip_day == '23')echo ' selected';?>>23</option>
                              <option value='24'<?php if($skip_day == '24')echo ' selected';?>>24</option>
                              <option value='25'<?php if($skip_day == '25')echo ' selected';?>>25</option>
                              <option value='26'<?php if($skip_day == '26')echo ' selected';?>>26</option>
                              <option value='27'<?php if($skip_day == '27')echo ' selected';?>>27</option>
                              <option value='28'<?php if($skip_day == '28')echo ' selected';?>>28</option>
                              <option value='29'<?php if($skip_day == '29')echo ' selected';?>>29</option>
                              <option value='30'<?php if($skip_day == '30')echo ' selected';?>>30</option>
                              <option value='31'<?php if($skip_day == '31')echo ' selected';?>>31</option>
                           </select>
                           <?php echo esc_html__("Month:", 'rss-feed-post-generator-echo');?>
                           <select class="cr_width_80" name="echo_Main_Settings[skip_month]" >
                              <option value='01'<?php if($skip_month == '01')echo ' selected';?>><?php echo esc_html__("January", 'rss-feed-post-generator-echo');?></option>
                              <option value='02'<?php if($skip_month == '02')echo ' selected';?>><?php echo esc_html__("February", 'rss-feed-post-generator-echo');?></option>
                              <option value='03'<?php if($skip_month == '03')echo ' selected';?>><?php echo esc_html__("March", 'rss-feed-post-generator-echo');?></option>
                              <option value='04'<?php if($skip_month == '04')echo ' selected';?>><?php echo esc_html__("April", 'rss-feed-post-generator-echo');?></option>
                              <option value='05'<?php if($skip_month == '05')echo ' selected';?>><?php echo esc_html__("May", 'rss-feed-post-generator-echo');?></option>
                              <option value='06'<?php if($skip_month == '06')echo ' selected';?>><?php echo esc_html__("June", 'rss-feed-post-generator-echo');?></option>
                              <option value='07'<?php if($skip_month == '07')echo ' selected';?>><?php echo esc_html__("July", 'rss-feed-post-generator-echo');?></option>
                              <option value='08'<?php if($skip_month == '08')echo ' selected';?>><?php echo esc_html__("August", 'rss-feed-post-generator-echo');?></option>
                              <option value='09'<?php if($skip_month == '09')echo ' selected';?>><?php echo esc_html__("September", 'rss-feed-post-generator-echo');?></option>
                              <option value='10'<?php if($skip_month == '10')echo ' selected';?>><?php echo esc_html__("October", 'rss-feed-post-generator-echo');?></option>
                              <option value='11'<?php if($skip_month == '11')echo ' selected';?>><?php echo esc_html__("November", 'rss-feed-post-generator-echo');?></option>
                              <option value='12'<?php if($skip_month == '12')echo ' selected';?>><?php echo esc_html__("December", 'rss-feed-post-generator-echo');?></option>
                           </select>
                           <?php echo esc_html__("Year:", 'rss-feed-post-generator-echo');?><input class="cr_width_70" value="<?php echo esc_html($skip_year);?>" placeholder="<?php echo esc_html__("year", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[skip_year]" type="text" pattern="^\d{4}$">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to skip posts that are newer than a selected date.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Skip Posts Newer Than a Selected Date:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="skip_new" name="echo_Main_Settings[skip_new]" onchange="mainChanged()"<?php
                        if ($skip_new == 'on')
                            echo ' checked ';
                        ?>>
                     </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class='hideNew'>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select the date after which you want to skip posts.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Select the Date for New Posts:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div class='hideNew'>
                           <?php echo esc_html__("Day:", 'rss-feed-post-generator-echo');?>
                           <select class="cr_width_80" name="echo_Main_Settings[skip_day_new]" >
                              <option value='01'<?php if($skip_day_new == '01')echo ' selected';?>>01</option>
                              <option value='02'<?php if($skip_day_new == '02')echo ' selected';?>>02</option>
                              <option value='03'<?php if($skip_day_new == '03')echo ' selected';?>>03</option>
                              <option value='04'<?php if($skip_day_new == '04')echo ' selected';?>>04</option>
                              <option value='05'<?php if($skip_day_new == '05')echo ' selected';?>>05</option>
                              <option value='06'<?php if($skip_day_new == '06')echo ' selected';?>>06</option>
                              <option value='07'<?php if($skip_day_new == '07')echo ' selected';?>>07</option>
                              <option value='08'<?php if($skip_day_new == '08')echo ' selected';?>>08</option>
                              <option value='09'<?php if($skip_day_new == '09')echo ' selected';?>>09</option>
                              <option value='10'<?php if($skip_day_new == '10')echo ' selected';?>>10</option>
                              <option value='11'<?php if($skip_day_new == '11')echo ' selected';?>>11</option>
                              <option value='12'<?php if($skip_day_new == '12')echo ' selected';?>>12</option>
                              <option value='13'<?php if($skip_day_new == '13')echo ' selected';?>>13</option>
                              <option value='14'<?php if($skip_day_new == '14')echo ' selected';?>>14</option>
                              <option value='15'<?php if($skip_day_new == '15')echo ' selected';?>>15</option>
                              <option value='16'<?php if($skip_day_new == '16')echo ' selected';?>>16</option>
                              <option value='17'<?php if($skip_day_new == '17')echo ' selected';?>>17</option>
                              <option value='18'<?php if($skip_day_new == '18')echo ' selected';?>>18</option>
                              <option value='19'<?php if($skip_day_new == '19')echo ' selected';?>>19</option>
                              <option value='20'<?php if($skip_day_new == '20')echo ' selected';?>>20</option>
                              <option value='21'<?php if($skip_day_new == '21')echo ' selected';?>>21</option>
                              <option value='22'<?php if($skip_day_new == '22')echo ' selected';?>>22</option>
                              <option value='23'<?php if($skip_day_new == '23')echo ' selected';?>>23</option>
                              <option value='24'<?php if($skip_day_new == '24')echo ' selected';?>>24</option>
                              <option value='25'<?php if($skip_day_new == '25')echo ' selected';?>>25</option>
                              <option value='26'<?php if($skip_day_new == '26')echo ' selected';?>>26</option>
                              <option value='27'<?php if($skip_day_new == '27')echo ' selected';?>>27</option>
                              <option value='28'<?php if($skip_day_new == '28')echo ' selected';?>>28</option>
                              <option value='29'<?php if($skip_day_new == '29')echo ' selected';?>>29</option>
                              <option value='30'<?php if($skip_day_new == '30')echo ' selected';?>>30</option>
                              <option value='31'<?php if($skip_day_new == '31')echo ' selected';?>>31</option>
                           </select>
                           <?php echo esc_html__("Month:", 'rss-feed-post-generator-echo');?>
                           <select class="cr_width_80" name="echo_Main_Settings[skip_month_new]" >
                              <option value='01'<?php if($skip_month_new == '01')echo ' selected';?>><?php echo esc_html__("January", 'rss-feed-post-generator-echo');?></option>
                              <option value='02'<?php if($skip_month_new == '02')echo ' selected';?>><?php echo esc_html__("February", 'rss-feed-post-generator-echo');?></option>
                              <option value='03'<?php if($skip_month_new == '03')echo ' selected';?>><?php echo esc_html__("March", 'rss-feed-post-generator-echo');?></option>
                              <option value='04'<?php if($skip_month_new == '04')echo ' selected';?>><?php echo esc_html__("April", 'rss-feed-post-generator-echo');?></option>
                              <option value='05'<?php if($skip_month_new == '05')echo ' selected';?>><?php echo esc_html__("May", 'rss-feed-post-generator-echo');?></option>
                              <option value='06'<?php if($skip_month_new == '06')echo ' selected';?>><?php echo esc_html__("June", 'rss-feed-post-generator-echo');?></option>
                              <option value='07'<?php if($skip_month_new == '07')echo ' selected';?>><?php echo esc_html__("July", 'rss-feed-post-generator-echo');?></option>
                              <option value='08'<?php if($skip_month_new == '08')echo ' selected';?>><?php echo esc_html__("August", 'rss-feed-post-generator-echo');?></option>
                              <option value='09'<?php if($skip_month_new == '09')echo ' selected';?>><?php echo esc_html__("September", 'rss-feed-post-generator-echo');?></option>
                              <option value='10'<?php if($skip_month_new == '10')echo ' selected';?>><?php echo esc_html__("October", 'rss-feed-post-generator-echo');?></option>
                              <option value='11'<?php if($skip_month_new == '11')echo ' selected';?>><?php echo esc_html__("November", 'rss-feed-post-generator-echo');?></option>
                              <option value='12'<?php if($skip_month_new == '12')echo ' selected';?>><?php echo esc_html__("December", 'rss-feed-post-generator-echo');?></option>
                           </select>
                           <?php echo esc_html__("Year:", 'rss-feed-post-generator-echo');?><input class="cr_width_70" value="<?php echo esc_html($skip_year_new);?>" placeholder="<?php echo esc_html__("year", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[skip_year_new]" type="text" pattern="^\d{4}$">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("Text Spinning Options:", 'rss-feed-post-generator-echo');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div id="bestspin">
                           <p><?php echo esc_html__("Don't have an 'The Best Spinner' account yet? Click here to get one:", 'rss-feed-post-generator-echo');?> <b><a href="https://paykstrt.com/10313/38910" target="_blank"><?php echo esc_html__("get a new account now!", 'rss-feed-post-generator-echo');?></a></b></p>
                        </div>
                        <div id="wordai">
                           <p><?php echo esc_html__("Don't have an 'WordAI' account yet? Click here to get one:", 'rss-feed-post-generator-echo');?> <b><a href="https://wordai.com/?ref=h17f4" target="_blank"><?php echo esc_html__("get a new account now!", 'rss-feed-post-generator-echo');?></a></b></p>
                        </div>
                        <div id="spinrewriter">
                           <p><?php echo esc_html__("Don't have an 'SpinRewriter' account yet? Click here to get one:", 'rss-feed-post-generator-echo');?> <b><a href="https://www.spinrewriter.com/?ref=24b18" target="_blank"><?php echo esc_html__("get a new account now!", 'rss-feed-post-generator-echo');?></a></b></p>
                        </div>
                        <div id="spinnerchief">
                  <p><?php echo esc_html__("Don't have an 'SpinnerChief' account yet? Click here to get one:", 'rss-feed-post-generator-echo');?> <b><a href="http://www.whitehatbox.com/Agents/SSS?code=iscpuQScOZMi3vGFhPVBnAP5FyC6mPaOEshvgU4BbyoH8ftVRbM3uQ==" target="_blank"><?php echo esc_html__("get a new account now!", 'rss-feed-post-generator-echo');?></a></b></p>
              </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to randomize text by changing words of a text with synonyms using one of the listed methods? Note that this is an experimental feature and can in some instances drastically increase the rule running time!", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Spin Text Using Word Synonyms:", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <select id="spin_text" name="echo_Main_Settings[spin_text]" onchange="mainChanged()">
                     <option value="disabled"
                        <?php
                           if($spin_text == 'disabled')
                                   {
                                       echo ' selected';
                                   }
                           ?>
                        ><?php echo esc_html__("Disabled", 'rss-feed-post-generator-echo');?></option>
                     <option value="best"
                        <?php
                           if($spin_text == 'best')
                                   {
                                       echo ' selected';
                                   }
                           ?>
                        >The Best Spinner - <?php echo esc_html__("High Quality - Paid", 'rss-feed-post-generator-echo');?></option>
                     <option value="wordai"
                        <?php
                           if($spin_text == 'wordai')
                                   {
                                       echo ' selected';
                                   }
                           ?>
                        >Wordai - <?php echo esc_html__("High Quality - Paid", 'rss-feed-post-generator-echo');?></option>
                     <option value="spinrewriter"
                        <?php
                           if($spin_text == 'spinrewriter')
                                   {
                                       echo ' selected';
                                   }
                           ?>
                        >SpinRewriter - <?php echo esc_html__("High Quality - Paid", 'rss-feed-post-generator-echo');?></option>
                     <option value="spinnerchief"
                       <?php
                          if($spin_text == 'spinnerchief')
                                  {
                                      echo ' selected';
                                  }
                          ?>
                       >SpinnerChief - <?php echo esc_html__("High Quality - Paid", 'rss-feed-post-generator-echo');?></option>
                     <option value="builtin"
                        <?php
                           if ($spin_text == 'builtin') {
                               echo ' selected';
                           }
                           ?>
                        ><?php echo esc_html__("Built-in - Medium Quality - Free", 'rss-feed-post-generator-echo');?></option> 
                     <option value="wikisynonyms"
                        <?php
                           if($spin_text == 'wikisynonyms')
                                   {
                                       echo ' selected';
                                   }
                           ?>
                        >WikiSynonyms - <?php echo esc_html__("Low Quality - Free", 'rss-feed-post-generator-echo');?></option>
                     <option value="freethesaurus"
                        <?php
                           if($spin_text == 'freethesaurus')
                                   {
                                       echo ' selected';
                                   }
                           ?>
                        >FreeThesaurus - <?php echo esc_html__("Low Quality - Free", 'rss-feed-post-generator-echo');?></option>
                     </select>
                     </div>
                  <tr class="hideSpinRewriter">
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Select the confidence level for used synonyms in SpinRewriter.", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php esc_html_e('Synonym Confidence Level: ', 'rss-feed-post-generator-echo'); ?></b>
                     </td>
                     <td>
                        <select name="echo_Main_Settings[confidence_level]" class="cr_width_full">
                           <option value="high"
                              <?php
                                 if($confidence_level == 'high')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("High", 'rss-feed-post-generator-echo');?></option>
                           <option value="medium"
                              <?php
                                 if($confidence_level == 'medium')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Medium", 'rss-feed-post-generator-echo');?></option>
                           <option value="low"
                              <?php
                                 if($confidence_level == 'low')
                                 {
                                     echo ' selected';
                                 }
                                 ?>><?php echo esc_html__("Low", 'rss-feed-post-generator-echo');?></option>
                        </select>
                     </td>
                  </tr>
                  </td></tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you don't want to spin the article title.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Do Not Spin The Title:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="checkbox" id="no_title_spin" name="echo_Main_Settings[no_title_spin]"<?php
                              if ($no_title_spin == 'on')
                                  echo ' checked ';
                              ?>>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideBuiltIn">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Input the words that you do not want to be spinned. You can input more words, separated by commas. Ex: dog, cat, cow", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Do Not Spin These Words:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideBuiltIn">
                           <input type="text" name="echo_Main_Settings[no_spin]" value="<?php echo esc_html($no_spin);?>" placeholder="<?php echo esc_html__("Select the words that should not be spinned", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideBest">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert your user name on the selected primium spinner service", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Premium Spinner Service User Name/Email:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideBest">
                           <input type="text" name="echo_Main_Settings[best_user]" value="<?php echo esc_html($best_user);?>" placeholder="<?php echo esc_html__("Please insert your premium spin service user name", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideBest">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert your user password on the selected premium spinner service.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Premium Spinner Service Password/API Key:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideBest">
                           <input type="password" autocomplete="off" name="echo_Main_Settings[best_password]" value="<?php echo esc_html($best_password);?>" placeholder="<?php echo esc_html__("Please insert your premium spin service password", 'rss-feed-post-generator-echo');?>">
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="hideBest">
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Insert your words, separated by comma, that you not want to be spinned.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Protected Terms:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div class="hideBest">
                           <input type="text" name="echo_Main_Settings[protected_terms]" value="<?php echo esc_html($protected_terms);?>" placeholder="<?php echo esc_html__("Please insert your protected terms", 'rss-feed-post-generator-echo');?>">
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
                     <td colspan="2">
                        <h3><?php echo esc_html__("PhantomJS Settings:", 'rss-feed-post-generator-echo');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo sprintf( wp_kses( __( "Set the path on your local server of the phantomjs executable. If you leave this field blank, the default 'phantomjs' call will be used. <a href='%s' target='_blank'>How to install PhantomJs?</a>", 'rss-feed-post-generator-echo'), array(  'a' => array( 'href' => array(), 'target' => array() ) ) ), esc_url( "//coderevolution.ro/knowledge-base/faq/how-to-install-phantomjs/" ));
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("PhantomJS Path On Server:", 'rss-feed-post-generator-echo');?></b>
<?php
                       if($phantom_path != '')
                       {
                           $phantom = echo_testPhantom();
                           if($phantom === 0)
                           {
                               echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS not found - please install it on your server or configure the path to it in plugin\'s \'Main Settings\'!', 'rss-feed-post-generator-echo') . '</b> <a href=\'//coderevolution.ro/knowledge-base/faq/how-to-install-phantomjs/\' target=\'_blank\'>' . esc_html__('How to install PhantomJs?', 'rss-feed-post-generator-echo') . '</a></span>';
                           }
                           elseif($phantom === -1)
                           {
                               echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS cannot run - shell_exec is not enabled on your server. Please enable it and retry using this feature of the plugin.', 'rss-feed-post-generator-echo') . '</b></span>';
                           }
                           elseif($phantom === -2)
                           {
                               echo '<br/><span class="cr_red12"><b>' . esc_html__('INFO: PhantomJS cannot run - shell_exec is not allowed to run on your server (in disable_functions list in php.ini). Please enable it and retry using this feature of the plugin.', 'rss-feed-post-generator-echo') . '</b></span>';
                           }
                           elseif($phantom === 1)
                           {
                               echo '<br/><span class="cr_green12"><b>' . esc_html__('INFO: PhantomJS OK', 'rss-feed-post-generator-echo') . '</b></span>';
                           }
                       }
?>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="text" id="phantom_path" placeholder="<?php echo esc_html__("Path to phantomjs", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[phantom_path]" value="<?php echo esc_html($phantom_path);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Set the timeout (in milliseconds) for every phantomjs running. I recommend that you leave this field at it's default value (15000). If you leave this field blank, the default value will be used.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Timeout for PhantomJs Execution:", 'rss-feed-post-generator-echo');?></b>
                        </div>
                     </td>
                     <td>
                        <div>
                           <input type="number" id="phantom_timeout" step="1" min="1" placeholder="<?php echo esc_html__("Input phantomjs timeout in milliseconds", 'rss-feed-post-generator-echo');?>" name="echo_Main_Settings[phantom_timeout]" value="<?php echo esc_html($phantom_timeout);?>"/>
                        </div>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Choose if you want to use phantomjs to generate the screenshot for the page, using the %%item_show_screenshot%% and %%item_screenshot_url%% shortcodes.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Use PhantomJs to Generate Screenshots (%%item_show_screenshot%%):", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="phantom_screen" name="echo_Main_Settings[phantom_screen]"<?php
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
                                    echo esc_html__("Choose if you want to use puppeteer to generate the screenshot for the page, using the %%item_show_screenshot%% and %%item_screenshot_url%% shortcodes.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                           <b><?php echo esc_html__("Use Puppeteer to Generate Screenshots (%%item_show_screenshot%%):", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                     <input type="checkbox" id="puppeteer_screen" name="echo_Main_Settings[puppeteer_screen]"<?php
                        if ($puppeteer_screen == 'on')
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
                     <td></td>
                  </tr>
                  <tr>
                     <td colspan="2">
                        <h3><?php echo esc_html__("Post Meta Options:", 'rss-feed-post-generator-echo');?></h3>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'echo_enable_pingbacks' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="echo_enable_pingbacks" name="echo_Main_Settings[echo_enable_pingbacks]"<?php
                           if ($echo_enable_pingbacks == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'echo_comment_status' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="echo_comment_status" name="echo_Main_Settings[echo_comment_status]"<?php
                           if ($echo_comment_status == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'echo_extra_categories' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="echo_extra_categories" name="echo_Main_Settings[echo_extra_categories]"<?php
                           if ($echo_extra_categories == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'echo_extra_tags' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="echo_extra_tags" name="echo_Main_Settings[echo_extra_tags]"<?php
                           if ($echo_extra_tags == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'echo_source_feed' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="echo_source_feed" name="echo_Main_Settings[echo_source_feed]"<?php
                           if ($echo_source_feed == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'echo_timestamp' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="echo_timestamp" name="echo_Main_Settings[echo_timestamp]"<?php
                           if ($echo_timestamp == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'echo_post_date' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="echo_post_date" name="echo_Main_Settings[echo_post_date]"<?php
                           if ($echo_post_date == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'echo_feed_title' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="echo_feed_title" name="echo_Main_Settings[echo_feed_title]"<?php
                           if ($echo_feed_title == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'echo_feed_description' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="echo_feed_description" name="echo_Main_Settings[echo_feed_description]"<?php
                           if ($echo_feed_description == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'feed_logo' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="feed_logo" name="echo_Main_Settings[feed_logo]"<?php
                           if ($feed_logo == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'echo_author' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="echo_author" name="echo_Main_Settings[echo_author]"<?php
                           if ($echo_author == 'on')
                               echo ' checked ';
                           ?>>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                           <div class="bws_hidden_help_text cr_min_260px">
                              <?php
                                 echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
                                 ?>
                           </div>
                        </div>
                        <b><?php echo esc_html__("Skip Saving 'echo_author_link' Post Meta", 'rss-feed-post-generator-echo');?></b>
                     </td>
                     <td>
                        <input type="checkbox" id="echo_author_link" name="echo_Main_Settings[echo_author_link]"<?php
                           if ($echo_author_link == 'on')
                               echo ' checked ';
                           ?>>
            </div>
            </td></tr><tr><td>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px">
            <?php
               echo esc_html__("Skip saving this post meta for posts?", 'rss-feed-post-generator-echo');
               ?>
            </div>
            </div>
            <b><?php echo esc_html__("Skip Saving 'echo_author_email' Post Meta", 'rss-feed-post-generator-echo');?></b>
            </td><td>
            <input type="checkbox" id="echo_author_email" name="echo_Main_Settings[echo_author_email]"<?php
               if ($echo_author_email == 'on')
                   echo ' checked ';
               ?>>
            </td></tr><tr><td>
            <hr/></td><td><hr/></td></tr><tr><td>
            <h3><?php echo esc_html__("Random Sentence Generator Settings:", 'rss-feed-post-generator-echo');?></h3>
            </td></tr>
            <tr><td>
            <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px">
            <?php
               echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line. Spintax supported.", 'rss-feed-post-generator-echo');
               ?>
            </div>
            </div>
            <b><?php echo esc_html__("First List of Possible Sentences (%%random_sentence%%):", 'rss-feed-post-generator-echo');?></b>
            </td><td>
            <textarea rows="8" cols="70" name="echo_Main_Settings[sentence_list]" placeholder="<?php echo esc_html__("Please insert the first list of sentences", 'rss-feed-post-generator-echo');?>"><?php echo esc_textarea($sentence_list);?></textarea>
            </div>
            </td></tr><tr><td>
            <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px">
            <?php
               echo esc_html__("Insert some sentences from which you want to get one at random. You can also use variables defined below. %something ==> is a variable. Each sentence must be separated by a new line. Spintax supported.", 'rss-feed-post-generator-echo');
               ?>
            </div>
            </div>
            <b><?php echo esc_html__("Second List of Possible Sentences (%%random_sentence2%%):", 'rss-feed-post-generator-echo');?></b>
            </td><td>
            <textarea rows="8" cols="70" name="echo_Main_Settings[sentence_list2]" placeholder="<?php echo esc_html__("Please insert the second list of sentences", 'rss-feed-post-generator-echo');?>"><?php echo esc_textarea($sentence_list2);?></textarea>
            </div>
            </td></tr><tr><td>
            <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px">
            <?php
               echo esc_html__("Insert some variables you wish to be exchanged for different instances of one sentence. Please format this list as follows:<br/>
               Variablename => Variables (seperated by semicolon)<br/>Example:<br/>adjective => clever;interesting;smart;huge;astonishing;unbelievable;nice;adorable;beautiful;elegant;fancy;glamorous;magnificent;helpful;awesome<br/>", 'rss-feed-post-generator-echo');
               ?>
            </div>
            </div>
            <b><?php echo esc_html__("List of Possible Variables:", 'rss-feed-post-generator-echo');?></b>
            </td><td>
            <textarea rows="8" cols="70" name="echo_Main_Settings[variable_list]" placeholder="<?php echo esc_html__("Please insert the list of variables", 'rss-feed-post-generator-echo');?>"><?php echo esc_textarea($variable_list);?></textarea>
            </div></td></tr>
            <tr><td><hr/></td><td><hr/></td></tr><tr><td>
            <h3><?php echo esc_html__("Custom HTML Code/ Ad Code:", 'rss-feed-post-generator-echo');?></h3>
            </td></tr>
            <tr><td>
            <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px">
            <?php
               echo esc_html__("Insert a custom HTML code that will replace the %%custom_html%% variable. This can be anything, even an Ad code.", 'rss-feed-post-generator-echo');
               ?>
            </div>
            </div>
            <b><?php echo esc_html__("Custom HTML Code #1:", 'rss-feed-post-generator-echo');?></b>
            </td><td>
            <textarea rows="3" cols="70" name="echo_Main_Settings[custom_html]" placeholder="<?php echo esc_html__("Custom HTML #1", 'rss-feed-post-generator-echo');?>"><?php echo esc_textarea($custom_html);?></textarea>
            </div>
            </td></tr><tr><td>
            <div>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px">
            <?php
               echo esc_html__("Insert a custom HTML code that will replace the %%custom_html2%% variable. This can be anything, even an Ad code.", 'rss-feed-post-generator-echo');
               ?>
            </div>
            </div>
            <b><?php echo esc_html__("Custom HTML Code #2:", 'rss-feed-post-generator-echo');?></b>
            </td><td>
            <textarea rows="3" cols="70" name="echo_Main_Settings[custom_html2]" placeholder="<?php echo esc_html__("Custom HTML #2", 'rss-feed-post-generator-echo');?>"><?php echo esc_textarea($custom_html2);?></textarea>
            </div>
            </td></tr></table>
            <hr/>
            <h3><?php echo esc_html__("Affiliate Keyword Replacer Tool Settings:", 'rss-feed-post-generator-echo');?></h3>
            <div class="table-responsive">
               <table class="responsive table cr_main_table">
                  <thead>
                     <tr>
                        <th>
                           <?php echo esc_html__("ID", 'rss-feed-post-generator-echo');?>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("This is the ID of the rule.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                        </th>
                        <th class="cr_max_width_40">
                           <?php echo esc_html__("Del", 'rss-feed-post-generator-echo');?>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Do you want to delete this rule?", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                        </th>
                        <th>
                           <?php echo esc_html__("Search Keyword", 'rss-feed-post-generator-echo');?>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("This keyword will be replaced with a link you define.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                        </th>
                        <th>
                           <?php echo esc_html__("Replacement Keyword", 'rss-feed-post-generator-echo');?>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("This keyword will replace the search keyword you define. Leave this field blank if you only want to add an URL to the specified keyword.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                        </th>
                        <th>
                           <?php echo esc_html__("Link to Add", 'rss-feed-post-generator-echo');?>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Define the link you want to appear the defined keyword. Leave this field blank if you only want to replace the specified keyword without linking from it.", 'rss-feed-post-generator-echo');
                                    ?>
                              </div>
                           </div>
                        </th>
                        <th>
                           <?php echo esc_html__("Target Content", 'rss-feed-post-generator-echo');?>
                           <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                              <div class="bws_hidden_help_text cr_min_260px">
                                 <?php
                                    echo esc_html__("Select if you want to make this rule target post title, content or both.", 'rss-feed-post-generator-echo');
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
                        <td>
                           <hr/>
                        </td>
                     </tr>
                  </thead>
                  <tbody>
                     <?php echo echo_expand_keyword_rules(); ?>
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
                        <td>
                           <hr/>
                        </td>
                     </tr>
                     <tr>
                        <td class="cr_short_td">-</td>
                        <td class="cr_shrt_td2"><span class="cr_gray20">X</span></td>
                        <td class="cr_rule_line"><input type="text" name="echo_keyword_list[keyword][]"  placeholder="<?php echo esc_html__("Please insert the keyword to be replaced", 'rss-feed-post-generator-echo');?>" value="" class="cr_width_100" /></td>
                        <td class="cr_rule_line"><input type="text" name="echo_keyword_list[replace][]"  placeholder="<?php echo esc_html__("Please insert the keyword to replace the search keyword", 'rss-feed-post-generator-echo');?>" value="" class="cr_width_100" /></td>
                        <td class="cr_rule_line"><input type="url" validator="url" name="echo_keyword_list[link][]" placeholder="<?php echo esc_html__("Please insert the link to be added to the keyword", 'rss-feed-post-generator-echo');?>" value="" class="cr_width_100" /></td>
                        <td class="cr_xoq">
                           <select id="echo_keyword_target" name="echo_keyword_list[target][]" class="cr_width_full">
                              <option value="content" selected><?php echo esc_html__("Content", 'rss-feed-post-generator-echo');?></option>
                              <option value="title"><?php echo esc_html__("Title", 'rss-feed-post-generator-echo');?></option>
                              <option value="both"><?php echo esc_html__("Content and Title", 'rss-feed-post-generator-echo');?></option>
                           </select>
                        </td>
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
<div><p class="submit"><input type="submit" name="btnSubmit" id="btnSubmit" class="button button-primary" onclick="unsaved = false;" value="<?php echo esc_html__("Save Settings", 'rss-feed-post-generator-echo');?>"/></p></div>
</form>
<p>
   <?php echo esc_html__("Available shortcodes (and also Gutenberg blocks):", 'rss-feed-post-generator-echo');?> <strong>[echo-list-posts]</strong> <?php echo esc_html__("to include a list that contains only posts imported by this plugin:", 'rss-feed-post-generator-echo');?>, <strong>[echo-display-posts]</strong> <?php echo esc_html__("to include a WordPress like post listing. Usage:", 'rss-feed-post-generator-echo');?> [echo-display-posts type='any/post/page/...' title_color='#ffffff' excerpt_color='#ffffff' read_more_text="Read More" link_to_source='yes' order='ASC/DESC' orderby='title/ID/author/name/date/rand/comment_count' title_font_size='19px', excerpt_font_size='19px' posts_per_page=number_of_posts_to_show category='posts_category' ruleid='ID_of_echo_rule'] <?php echo esc_html__("and", 'rss-feed-post-generator-echo');?> <strong>[echo-display-input]</strong> <?php echo esc_html__("to include an input field where users can include their feeds to be imported to the blog. Example:", 'rss-feed-post-generator-echo');?> [echo-display-input user_submit_message="Thank you for your submission" new_user_role="contributor" category_selector="category_slug => category display name" user_exists_message="User name/email address already exists" button="Submit" placeholder="<?php echo esc_html__("Input your URL", 'rss-feed-post-generator-echo');?>" show_category_input="on/off" show_post_type_input="on/off" username_placeholder="<?php echo esc_html__("Create a new user name", 'rss-feed-post-generator-echo');?>" password_placeholder="<?php echo esc_html__("Create a new password", 'rss-feed-post-generator-echo');?>" email_placeholder=Your email address" email_address="your_email" email_subject="New RSS URL user submission" email_template="<?php echo esc_html__("A new RSS URL user submission was just sent. Please check.", 'rss-feed-post-generator-echo');?>"]
   <br/><?php echo esc_html__("Example:", 'rss-feed-post-generator-echo');?> <b>[echo-list-posts type='any' order='ASC' orderby='date' posts_per_page=50 category= '' ruleid='0' taxonomy_query='taxonomy_slug:taxonomy_value']</b>
   <br/><?php echo esc_html__("Example 2:", 'rss-feed-post-generator-echo');?> <b>[echo-display-posts include_excerpt='true' image_size='thumbnail' wrapper='div']</b>. <?php echo esc_html__("Please check plugin's documentation for more info.", 'rss-feed-post-generator-echo');?><br/><br/>
   <?php echo esc_html__("Also, the plugin allows visitors to submit their own RSS feeds, using the [echo-display-input] shortcode. Possible parameters:", 'rss-feed-post-generator-echo');?> placeholder='Input your URL' username_placeholder='Create a new user name' password_placeholder='Create a new user password' email_placeholder='Email address for new user' button='Import Posts!' new_user_role='contributor' user_exists_message='User name/email address already exists' user_submit_message='Thank you for your submission' incomplete_credentials='You must fill in all fields (user name, password, email)' email_template=''email_subject='' email_address='' show_category_input='on/off' show_post_type_input='on/off'
</p>
</div>
<?php
   }
   if (isset($_POST['echo_keyword_list'])) {
   	add_action('admin_init', 'echo_save_keyword_rules');
   }
   function echo_save_keyword_rules($data2) {
               $data2 = $_POST['echo_keyword_list'];
   			$rules = array();
               if(isset($data2['keyword'][0]))
               {
                   for($i = 0; $i < sizeof($data2['keyword']); ++$i) {
                       if(isset($data2['keyword'][$i]) && $data2['keyword'][$i] != '')
                       {
                           $index = trim( sanitize_text_field($data2['keyword'][$i]));
                           $rules[$index] = array(trim( sanitize_text_field( $data2['link'][$i] ) ), trim( sanitize_text_field( $data2['replace'][$i] ) ), trim( sanitize_text_field( $data2['target'][$i] ) ));
                       }
                   }
               }
               update_option('echo_keyword_list', $rules);
   		}
   function echo_expand_keyword_rules() {
   			$rules = get_option('echo_keyword_list');
   			$output = '';
               $cont = 0;
   			if (!empty($rules)) {
   				foreach ($rules as $request => $value) {  
   					$output .= '<tr>
                           <td class="cr_short_td">' . esc_html($cont) . '</td>
                           <td class="cr_shrt_td2"><span class="wpecho-delete">X</span></td>
                           <td class="cr_rule_line"><input type="text" placeholder="' . esc_html__('Input the keyword to be replaced. This field is required', 'rss-feed-post-generator-echo') . '" name="echo_keyword_list[keyword][]" value="'.esc_attr($request).'" required class="cr_width_full"></td>
                           <td class="cr_rule_line"><input type="text" placeholder="' . esc_html__('Input the replacement word', 'rss-feed-post-generator-echo') . '" name="echo_keyword_list[replace][]" value="'.esc_attr($value[1]).'" class="cr_width_full"></td>
                           <td class="cr_rule_line"><input type="url" validator="url" placeholder="' . esc_html__('Input the URL to be added', 'rss-feed-post-generator-echo') . '" name="echo_keyword_list[link][]" value="'.esc_attr($value[0]).'" class="cr_width_full"></td>';
                           if(isset($value[2]))
                           {
                               $target = $value[2];
                           }
                           else
                           {
                               $target = 'content';
                           }
                           $output .= '<td class="cr_xoq"><select id="echo_keyword_target" name="echo_keyword_list[target][]" class="cr_width_full">
                                     <option value="content"';
                           if ($target == "content") {
                               $output .= " selected";
                           }
                           $output .= '>' . esc_html__('Content', 'rss-feed-post-generator-echo') . '</option>
                           <option value="title"';
                           if ($target == "title") {
                               $output .=  " selected";
                           }
                           $output .= '>' . esc_html__('Title', 'rss-feed-post-generator-echo') . '</option>
                           <option value="both"';
                           if ($target == "both") {
                               $output .=  " selected";
                           }
                           $output .= '>' . esc_html__('Content and Title', 'rss-feed-post-generator-echo') . '</option>
                       </select></td>
   					</tr>';
                       $cont++;
   				}
   			}
   			return $output;
   		}
   ?>