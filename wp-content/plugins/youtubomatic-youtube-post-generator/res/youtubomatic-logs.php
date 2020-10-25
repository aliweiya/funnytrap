<?php
   function youtubomatic_logs()
   {
       global $wp_filesystem;
       if ( ! is_a( $wp_filesystem, 'WP_Filesystem_Base') ){
           include_once(ABSPATH . 'wp-admin/includes/file.php');$creds = request_filesystem_credentials( site_url() );
           wp_filesystem($creds);
       }
       if(isset($_POST['youtubomatic_delete']))
       {
           if($wp_filesystem->exists(WP_CONTENT_DIR . '/youtubomatic_info.log'))
           {
               $wp_filesystem->delete(WP_CONTENT_DIR . '/youtubomatic_info.log');
           }
       }
       if(isset($_POST['youtubomatic_delete_rules']))
       {
           $running = array();
           update_option('youtubomatic_running_list', $running);
       }
       if(isset($_POST['youtubomatic_restore_defaults']))
       {
           youtubomatic_activation_callback(true);
       }
       if(isset($_POST['youtubomatic_delete_all']))
       {
           youtubomatic_delete_all_posts();
       }
   ?>
<div class="wp-header-end"></div>
<div class="wrap gs_popuptype_holder seo_pops">
<div>
   <div>
      <h3>
         <?php echo esc_html__("System Info:", 'youtubomatic-youtube-post-generator');?> 
         <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
            <div class="bws_hidden_help_text cr_min_260px">
               <?php
                  echo esc_html__("Some general system information.", 'youtubomatic-youtube-post-generator');
                  ?>
            </div>
         </div>
      </h3>
      <hr/>
      <table class="cr_server_stat">
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("User Agent:", 'youtubomatic-youtube-post-generator');?></td>
            <td class="cdr-dw-td-value"><?php echo $_SERVER['HTTP_USER_AGENT'] ?></td>
         </tr>
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("Web Server:", 'youtubomatic-youtube-post-generator');?></td>
            <td class="cdr-dw-td-value"><?php echo $_SERVER['SERVER_SOFTWARE'] ?></td>
         </tr>
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("PHP Version:", 'youtubomatic-youtube-post-generator');?></td>
            <td class="cdr-dw-td-value"><?php echo phpversion(); ?></td>
         </tr>
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("PHP Max POST Size:", 'youtubomatic-youtube-post-generator');?></td>
            <td class="cdr-dw-td-value"><?php echo ini_get('post_max_size'); ?></td>
         </tr>
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("PHP Max Upload Size:", 'youtubomatic-youtube-post-generator');?></td>
            <td class="cdr-dw-td-value"><?php echo ini_get('upload_max_filesize'); ?></td>
         </tr>
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("PHP Memory Limit:", 'youtubomatic-youtube-post-generator');?></td>
            <td class="cdr-dw-td-value"><?php echo ini_get('memory_limit'); ?></td>
         </tr>
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("PHP DateTime Class:", 'youtubomatic-youtube-post-generator');?></td>
            <td class="cdr-dw-td-value"><?php echo (class_exists('DateTime') && class_exists('DateTimeZone')) ? '<span class="cdr-green">' . esc_html__('Available', 'youtubomatic-youtube-post-generator') . '</span>' : '<span class="cdr-red">' . esc_html__('Not available', 'youtubomatic-youtube-post-generator') . '</span> | <a href="http://php.net/manual/en/datetime.installation.php" target="_blank">more info&raquo;</a>'; ?> </td>
         </tr>
         <tr class="cdr-dw-tr">
            <td class="cdr-dw-td"><?php echo esc_html__("PHP Curl:", 'youtubomatic-youtube-post-generator');?></td>
            <td class="cdr-dw-td-value"><?php echo (function_exists('curl_version')) ? '<span class="cdr-green">' . esc_html__('Available', 'youtubomatic-youtube-post-generator') . '</span>' : '<span class="cdr-red">' . esc_html__('Not available', 'youtubomatic-youtube-post-generator') . '</span>'; ?> </td>
         </tr>
         <?php do_action('coderevolution_dashboard_widget_server') ?>
      </table>
   </div>
   <div>
      <br/>
      <hr class="cr_special_hr"/>
      <div>
         <h3>
            <?php echo esc_html__("Rules Currently Running:", 'youtubomatic-youtube-post-generator');?>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
               <div class="bws_hidden_help_text cr_min_260px">
                  <?php
                     echo esc_html__("These rules are currently running on your server.", 'youtubomatic-youtube-post-generator');
                     ?>
               </div>
            </div>
         </h3>
         <div>
            <?php
               if (!get_option('youtubomatic_running_list')) {
                   $running = array();
               } else {
                   $running = get_option('youtubomatic_running_list');
               }
               if (!empty($running)) {
                   echo '<ul>';
                   foreach($running as $key => $thread)
                   {
                       echo '<li>ID - ' . esc_html($thread) . '</li>';
                   }
                   echo '</ul>';        
               }
               else
               {
                   echo esc_html__('No rules are running right now', 'youtubomatic-youtube-post-generator');
               }
               ?>
         </div>
         <hr/>
         <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to clear the running list?', 'youtubomatic-youtube-post-generator');?>');">
            <input name="youtubomatic_delete_rules" type="submit" title="<?php echo esc_html__('Caution! This is for debugging purpose only!', 'youtubomatic-youtube-post-generator');?>" value="<?php echo esc_html__('Clear Running Rules List', 'youtubomatic-youtube-post-generator');?>">
         </form>
      </div>
      <div>
         <br/>
         <hr class="cr_special_hr"/>
         <div>
            <h3>
               <?php echo esc_html__('Restore Plugin Default Settings', 'youtubomatic-youtube-post-generator');?> 
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__('Hit this button and the plugin settings will be restored to their default values. Warning! All settings will be lost!', 'youtubomatic-youtube-post-generator');
                        ?>
                  </div>
               </div>
            </h3>
            <hr/>
            <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to restore the default plugin settings?', 'youtubomatic-youtube-post-generator');?>');"><input name="youtubomatic_restore_defaults" type="submit" value="<?php echo esc_html__('Restore Plugin Default Settings', 'youtubomatic-youtube-post-generator');?>"></form>
         </div>
         <br/>
         <hr class="cr_special_hr"/>
         <div>
            <h3>
               <?php echo esc_html__('Delete All Posts Generated by this Plugin:', 'youtubomatic-youtube-post-generator');?> 
               <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
                  <div class="bws_hidden_help_text cr_min_260px">
                     <?php
                        echo esc_html__('Hit this button and all posts generated by this plugin will be deleted!', 'youtubomatic-youtube-post-generator');
                        ?>
                  </div>
               </div>
            </h3>
            <hr/>
            <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to delete all generated posts? This can take a while, please wait until it finishes.', 'youtubomatic-youtube-post-generator');?>');"><input name="youtubomatic_delete_all" type="submit" value="<?php echo esc_html__('Delete All Generated Posts', 'youtubomatic-youtube-post-generator');?>"></form>
         </div>
         <br/>
         <hr class="cr_special_hr"/>
         <h3>
            <?php echo esc_html__('Activity Log:', 'youtubomatic-youtube-post-generator');?>
            <div class="bws_help_box bws_help_box_right dashicons dashicons-editor-help cr_align_middle">
               <div class="bws_hidden_help_text cr_min_260px">
                  <?php
                     echo esc_html__('This is the main log of your plugin. Here will be listed every single instance of the rules you run or are automatically run by schedule jobs (if you enable logging, in the plugin configuration).', 'youtubomatic-youtube-post-generator');
                     ?>
               </div>
            </div>
         </h3>
         <div>
            <?php
               if($wp_filesystem->exists(WP_CONTENT_DIR . '/youtubomatic_info.log'))
               {
                    $log = $wp_filesystem->get_contents(WP_CONTENT_DIR . '/youtubomatic_info.log');
                    echo $log;
               }
               else
               {
                   echo esc_html__('Log empty', 'youtubomatic-youtube-post-generator');
               }
               ?>
         </div>
      </div>
      <hr/>
      <form method="post" onsubmit="return confirm('<?php echo esc_html__('Are you sure you want to delete all logs?', 'youtubomatic-youtube-post-generator');?>');">
         <input name="youtubomatic_delete" type="submit" value="<?php echo esc_html__('Delete Logs', 'youtubomatic-youtube-post-generator');?>">
      </form>
   </div>
</div>
<?php
   }
   ?>