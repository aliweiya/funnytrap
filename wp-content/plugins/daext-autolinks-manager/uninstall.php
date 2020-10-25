<?php

//exit if this file is called outside wordpress
if ( ! defined('WP_UNINSTALL_PLUGIN')) {
    die();
}

require_once(plugin_dir_path(__FILE__) . 'shared/class-daam-shared.php');
require_once(plugin_dir_path(__FILE__) . 'admin/class-daam-admin.php');

//delete options and tables
Daam_Admin::un_delete();
