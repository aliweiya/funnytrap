<?php
   function echo_logs()
   {
       global $wp_filesystem;
       if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
           include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
           wp_filesystem($creds);
       }
       if(isset($_POST['echo_delete']))
       {
           if($wp_filesystem->exists(WP_CONTENT_DIR . '/echo_info.log'))
           {
               $wp_filesystem->delete(WP_CONTENT_DIR . '/echo_info.log');
           }
       }
       if(isset($_POST['echo_delete_rules']))
       {
           $running = array();
           update_option('echo_running_list', $running);
       }
       if(isset($_POST['echo_restore_defaults']))
       {
           echo_activation_callback(true);
       }
       if(isset($_POST['echo_delete_all']))
       {
           echo_delete_all_posts();
       }
       if(isset($_POST['echo_delete_all_rules']))
       {
           echo_delete_all_rules();
       }
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
<div>
   <div>
      <div>
         <h3>
            <?php echo esc_html__("System Info:", 'rss-feed-post-generator-echo');?> 
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
               <div class="bws_hidden_help_text cr_min_260px">
                  <?php
                     echo esc_html__("Some general system information.", 'rss-feed-post-generator-echo');
                     ?>
               </div>
            </div>
         </h3>
         <hr/>
         <table class="cr_server_stat">
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("User Agent:", 'rss-feed-post-generator-echo');?></td>
               <td class="cdr-dw-td-value"><?php echo $_SERVER['HTTP_USER_AGENT'] ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("Web Server:", 'rss-feed-post-generator-echo');?></td>
               <td class="cdr-dw-td-value"><?php echo $_SERVER['SERVER_SOFTWARE'] ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP Version:", 'rss-feed-post-generator-echo');?></td>
               <td class="cdr-dw-td-value"><?php echo phpversion(); ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP Max POST Size:", 'rss-feed-post-generator-echo');?></td>
               <td class="cdr-dw-td-value"><?php echo ini_get('post_max_size'); ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP Max Upload Size:", 'rss-feed-post-generator-echo');?></td>
               <td class="cdr-dw-td-value"><?php echo ini_get('upload_max_filesize'); ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP Memory Limit:", 'rss-feed-post-generator-echo');?></td>
               <td class="cdr-dw-td-value"><?php echo ini_get('memory_limit'); ?></td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP DateTime Class:", 'rss-feed-post-generator-echo');?></td>
               <td class="cdr-dw-td-value"><?php echo (class_exists('DateTime') && class_exists('DateTimeZone')) ? '<span class="cdr-green">' . esc_html__('Available', 'rss-feed-post-generator-echo') . '</span>' : '<span class="cdr-red">' . esc_html__('Not available', 'rss-feed-post-generator-echo') . '</span> | <a href="http://php.net/manual/en/datetime.installation.php" target="_blank">more info&raquo;</a>'; ?> </td>
            </tr>
            <tr class="cdr-dw-tr">
               <td class="cdr-dw-td"><?php echo esc_html__("PHP Curl:", 'rss-feed-post-generator-echo');?></td>
               <td class="cdr-dw-td-value"><?php echo (function_exists('curl_version')) ? '<span class="cdr-green">' . esc_html__('Available', 'rss-feed-post-generator-echo') . '</span>' : '<span class="cdr-red">' . esc_html__('Not available', 'rss-feed-post-generator-echo') . '</span>'; ?> </td>
            </tr>
            <?php do_action('coderevolution_dashboard_widget_server') ?>
         </table>
      </div>
      <div>
         <br/>
         <hr class="cr_special_hr"/>
         <h3>
            <?php echo esc_html__("Rules Currently Running:", 'rss-feed-post-generator-echo');?>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
               <div class="bws_hidden_help_text cr_min_260px">
                  <?php
                     echo esc_html__("These rules are currently running on your server.", 'rss-feed-post-generator-echo');
                     ?>
               </div>
            </div>
         </h3>
         <div>
            <?php
               if (!get_option('echo_running_list')) {
                   $running = array();
               } else {
                   $running = get_option('echo_running_list');
               }
               if (!empty($running)) {
                   echo '<ul>';
                   foreach($running as $key => $thread)
                   {
                       echo '<li>ID - ' . esc_html($thread) . ' - started at: ' . gmdate("Y-m-d H:i:s", $key) . '</li>';
                   }
                   echo '</ul>'; 
                   echo esc_html__('Current time: ', 'rss-feed-post-generator-echo') . gmdate("Y-m-d H:i:s", time());         
               }
               else
               {
                   echo esc_html__('No rules are running right now', 'rss-feed-post-generator-echo');
               }
               ?>
         </div>
         <hr/>
         <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to clear the running list?', 'rss-feed-post-generator-echo');?>');">
            <input name="echo_delete_rules" type="submit" title="<?php echo esc_html__('Caution! This is for debugging purpose only!', 'rss-feed-post-generator-echo');?>" value="<?php echo esc_html__('Clear Running Rules List', 'rss-feed-post-generator-echo');?>">
         </form>
      </div>
      <div>
         <br/>
         <hr class="cr_special_hr"/>
         <div>
            <h3>
               <?php echo esc_html__('Backup Current Rules To File:', 'rss-feed-post-generator-echo');?>  
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Hit this button and you can backup the current rule settings to file. This is useful if you have many rules created and want to migrate settings to another server.", 'rss-feed-post-generator-echo');
                        ?>
                  </div>
               </div>
            </h3>
            <hr/>
            <form method="post" onsubmit="return confirm('Are you sure you want to download rule settings to file?');"><input name="echo_download_rules_to_file" type="submit" value="Download Rules To File"></form>
         </div>
         <br/>
         <hr class="cr_special_hr"/>
         <div>
            <h3>
               <?php echo esc_html__('Load Rules From File:', 'rss-feed-post-generator-echo');?> 
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Here you can upload a previously downloaded backup file and restore the rules from it.", 'rss-feed-post-generator-echo');
                        ?>
                  </div>
               </div>
            </h3>
            <hr/>
            <form method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure you want to load rules list from file?');"><label for="echo-file-upload-rules">Select File To Upload:&nbsp;&nbsp;</label><input type="file" id="echo-file-upload-rules" name="echo-file-upload-rules" value=""/><br/><br/>
               <input name="echo_restore_rules" type="submit" value="Restore Rules From File">
            </form>
         </div>
         <br/>
         <hr class="cr_special_hr"/>
         <div>
            <h3>
               <?php echo esc_html__('Restore Plugin Default Settings', 'rss-feed-post-generator-echo');?> 
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__('Hit this button and the plugin settings will be restored to their default values. Warning! All settings will be lost!', 'rss-feed-post-generator-echo');
                        ?>
                  </div>
               </div>
            </h3>
            <hr/>
            <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to restore the default plugin settings?', 'rss-feed-post-generator-echo');?>');"><input name="echo_restore_defaults" type="submit" value="<?php echo esc_html__('Restore Plugin Default Settings', 'rss-feed-post-generator-echo');?>"></form>
         </div>
         <br/>
         <hr class="cr_special_hr"/>
         <div>
            <h3>
               <?php echo esc_html__('Delete All Posts Generated by this Plugin:', 'rss-feed-post-generator-echo');?> 
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__('Hit this button and all posts generated by this plugin will be deleted!', 'rss-feed-post-generator-echo');
                        ?>
                  </div>
               </div>
            </h3>
            <hr/>
            <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to delete all generated posts? This can take a while, please wait until it finishes.', 'rss-feed-post-generator-echo');?>');"><input name="echo_delete_all" type="submit" value="<?php echo esc_html__('Delete All Generated Posts', 'rss-feed-post-generator-echo');?>"></form>
         </div>
         <br/>
         <hr class="cr_special_hr"/>
         <div>
            <h3>
               <?php echo esc_html__('Delete All Rules from \'Rss to Posts\' Section: ', 'rss-feed-post-generator-echo');?>
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__("Hit this button and all rules will be deleted!", 'rss-feed-post-generator-echo');
                        ?>
                  </div>
               </div>
            </h3>
            <hr/>
            <form method="post" onsubmit="return confirm('Are you sure you want to delete all rules?');"><input name="echo_delete_all_rules" type="submit" value="Delete All Generated Rules"></form>
         </div>
         <br/>
         <hr class="cr_special_hr"/>
         <h3>
            <?php echo esc_html__('Activity Log:', 'rss-feed-post-generator-echo');?>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
               <div class="bws_hidden_help_text cr_min_260px">
                  <?php
                     echo esc_html__('This is the main log of your plugin. Here will be listed every single instance of the rules you run or are automatically run by schedule jobs (if you enable logging, in the plugin configuration).', 'rss-feed-post-generator-echo');
                     ?>
               </div>
            </div>
         </h3>
         <div>
            <?php
               if($wp_filesystem->exists(WP_CONTENT_DIR . '/echo_info.log'))
               {
                    $log = $wp_filesystem->get_contents(WP_CONTENT_DIR . '/echo_info.log');
                    echo $log;
               }
               else
               {
                   echo esc_html__('Log empty', 'rss-feed-post-generator-echo');
               }
               ?>
         </div>
      </div>
      <hr/>
      <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to delete all logs?', 'rss-feed-post-generator-echo');?>');">
         <input name="echo_delete" type="submit" value="<?php echo esc_html__('Delete Logs', 'rss-feed-post-generator-echo');?>">
      </form>
   </div>
</div>
<?php
   }
   ?>