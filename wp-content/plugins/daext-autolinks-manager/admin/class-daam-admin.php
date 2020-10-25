<?php

/*
 * this class should be used to work with the administrative side of wordpress
 */

class Daam_Admin
{

    protected static $instance = null;
    private $shared = null;

    private $screen_id_statistics = null;
    private $screen_id_wizard = null;
    private $screen_id_autolinks = null;
    private $screen_id_categories = null;
    private $screen_id_term_groups = null;
    private $screen_id_tracking = null;
    private $screen_id_import = null;
    private $screen_id_export = null;
    private $screen_id_maintenance = null;
    private $screen_id_options = null;

    private function __construct()
    {

        //assign an instance of the plugin info
        $this->shared = Daam_Shared::get_instance();

        //Load admin stylesheets and JavaScript
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_styles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));

        //Write in back end head
        add_action('admin_head', array($this, 'wr_admin_head'));

        //Add the admin menu
        add_action('admin_menu', array($this, 'me_add_admin_menu'));

        //Load the options API registrations and callbacks
        add_action('admin_init', array($this, 'op_register_options'));

        //Add the meta box
        add_action('add_meta_boxes', array($this, 'create_meta_box'));

        //Save the meta box
        add_action('save_post', array($this, 'save_meta_box'));

        //this hook is triggered during the creation of a new blog
        add_action('wpmu_new_blog', array($this, 'new_blog_create_options_and_tables'), 10, 6);

        //this hook is triggered during the deletion of a blog
        add_action('delete_blog', array($this, 'delete_blog_delete_options_and_tables'), 10, 1);

        //Export CSV controller
        add_action('init', array($this, 'export_csv_controller'));

        //Export XML controller
        add_action('init', array($this, 'export_xml_controller'));

    }

    /*
     * return an instance of this class
     */
    public static function get_instance()
    {

        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;

    }

    /*
     * write in the admin head
     */
    public function wr_admin_head()
    {

        echo '<script type="text/javascript">';
        echo 'var daamAjaxUrl = "' . admin_url('admin-ajax.php') . '";';
        echo 'var daamNonce = "' . wp_create_nonce("daam") . '";';
        echo 'var daamAdminUrl ="' . get_admin_url() . '";';
        echo '</script>';

    }

    /*
     * Enqueue admin specific styles.
     */
    public function enqueue_admin_styles()
    {

        $screen = get_current_screen();

        //Menu Statistics
        if ($screen->id == $this->screen_id_statistics) {

            //Framework Menu
            wp_enqueue_style($this->shared->get('slug') . '-framework-menu',
                $this->shared->get('url') . 'admin/assets/css/framework/menu.css', array(), $this->shared->get('ver'));

            //Statistics Menu
            wp_enqueue_style($this->shared->get('slug') . '-menu-statistics',
                $this->shared->get('url') . 'admin/assets/css/menu-statistics.css', array(), $this->shared->get('ver'));

            //jQuery UI Tooltip
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip.css', array(),
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_style($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-chosen-custom',
                $this->shared->get('url') . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get('ver'));

        }

        //Menu Wizard
        if ($screen->id == $this->screen_id_wizard) {

            //Framework Menu
            wp_enqueue_style($this->shared->get('slug') . '-framework-menu',
                $this->shared->get('url') . 'admin/assets/css/framework/menu.css', array(), $this->shared->get('ver'));

            //Wizard Menu
            wp_enqueue_style($this->shared->get('slug') . '-menu-wizard',
                $this->shared->get('url') . 'admin/assets/css/menu-wizard.css', array(), $this->shared->get('ver'));

            //jQuery UI Tooltip
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip.css', array(),
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_style($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-chosen-custom',
                $this->shared->get('url') . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get('ver'));

            //Handsontable
            wp_enqueue_style($this->shared->get('slug') . '-handsontable-full',
                $this->shared->get('url') . 'admin/assets/inc/handsontable/handsontable.full.min.css', array(),
                $this->shared->get('ver'));

        }

        //Menu Autolinks
        if ($screen->id == $this->screen_id_autolinks) {

            //Framework Menu
            wp_enqueue_style($this->shared->get('slug') . '-framework-menu',
                $this->shared->get('url') . 'admin/assets/css/framework/menu.css', array(), $this->shared->get('ver'));

            //Autolinks Menu
            wp_enqueue_style($this->shared->get('slug') . '-menu-autolinks',
                $this->shared->get('url') . 'admin/assets/css/menu-autolinks.css', array(), $this->shared->get('ver'));

            //jQuery UI Dialog
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog-custom',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog-custom.css', array(),
                $this->shared->get('ver'));

            //jQuery UI Tooltip
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip.css', array(),
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_style($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-chosen-custom',
                $this->shared->get('url') . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get('ver'));

        }

        //Menu Categories
        if ($screen->id == $this->screen_id_categories) {

            //Framework Menu
            wp_enqueue_style($this->shared->get('slug') . '-framework-menu',
                $this->shared->get('url') . 'admin/assets/css/framework/menu.css', array(), $this->shared->get('ver'));

            //Categories Menu
            wp_enqueue_style($this->shared->get('slug') . '-menu-categories',
                $this->shared->get('url') . 'admin/assets/css/menu-categories.css', array(), $this->shared->get('ver'));

            //jQuery UI Dialog
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog-custom',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog-custom.css', array(),
                $this->shared->get('ver'));

            //jQuery UI Tooltip
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip.css', array(),
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_style($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-chosen-custom',
                $this->shared->get('url') . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get('ver'));

        }

        //Menu Term Groups
        if ($screen->id == $this->screen_id_term_groups) {

            //Framework Menu
            wp_enqueue_style($this->shared->get('slug') . '-framework-menu',
                $this->shared->get('url') . 'admin/assets/css/framework/menu.css', array(), $this->shared->get('ver'));

            //Term Groups Menu
            wp_enqueue_style($this->shared->get('slug') . '-menu-term-groups',
                $this->shared->get('url') . 'admin/assets/css/menu-term-groups.css', array(),
                $this->shared->get('ver'));

            //jQuery UI Dialog
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog-custom',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog-custom.css', array(),
                $this->shared->get('ver'));

            //jQuery UI Tooltip
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip.css', array(),
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_style($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-chosen-custom',
                $this->shared->get('url') . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get('ver'));

        }

        //Menu Tracking
        if ($screen->id == $this->screen_id_tracking) {

            //Framework Menu
            wp_enqueue_style($this->shared->get('slug') . '-framework-menu',
                $this->shared->get('url') . 'admin/assets/css/framework/menu.css', array(), $this->shared->get('ver'));

            //Tracking Menu
            wp_enqueue_style($this->shared->get('slug') . '-menu-tracking',
                $this->shared->get('url') . 'admin/assets/css/menu-tracking.css', array(), $this->shared->get('ver'));

            //jQuery UI Dialog
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog-custom',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog-custom.css', array(),
                $this->shared->get('ver'));

            //jQuery UI Tooltip
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip.css', array(),
                $this->shared->get('ver'));

        }

        //Menu Import
        if ($screen->id == $this->screen_id_import) {

            //jQuery UI Tooltip
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip.css', array(),
                $this->shared->get('ver'));

        }

        //Menu Export
        if ($screen->id == $this->screen_id_export) {

            //jQuery UI Tooltip
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip.css', array(),
                $this->shared->get('ver'));

        }

        //Menu Maintenance
        if ($screen->id == $this->screen_id_maintenance) {

            //Framework Menu
            wp_enqueue_style($this->shared->get('slug') . '-framework-menu',
                $this->shared->get('url') . 'admin/assets/css/framework/menu.css', array(), $this->shared->get('ver'));

            //jQuery UI Dialog
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-dialog-custom',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-dialog-custom.css', array(),
                $this->shared->get('ver'));

            //jQuery UI Tooltip
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip.css', array(),
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_style($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-chosen-custom',
                $this->shared->get('url') . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get('ver'));

        }

        //Menu Options
        if ($screen->id == $this->screen_id_options) {

            //Framework Options
            wp_enqueue_style($this->shared->get('slug') . '-framework-options',
                $this->shared->get('url') . 'admin/assets/css/framework/options.css', array(),
                $this->shared->get('ver'));

            //jQuery UI Tooltip
            wp_enqueue_style($this->shared->get('slug') . '-jquery-ui-tooltip',
                $this->shared->get('url') . 'admin/assets/css/jquery-ui-tooltip.css', array(),
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_style($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-chosen-custom',
                $this->shared->get('url') . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get('ver'));

        }

        $meta_box_post_types_a = $this->shared->get_post_types_with_ui();
        if (in_array($screen->id, $meta_box_post_types_a)) {

            //Post Editor
            wp_enqueue_style($this->shared->get('slug') . '-meta-box',
                $this->shared->get('url') . 'admin/assets/css/post-editor.css', array(), $this->shared->get('ver'));

            //Chosen
            wp_enqueue_style($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.css', array(),
                $this->shared->get('ver'));
            wp_enqueue_style($this->shared->get('slug') . '-chosen-custom',
                $this->shared->get('url') . 'admin/assets/css/chosen-custom.css', array(), $this->shared->get('ver'));

        }

    }

    /*
     * Enqueue admin-specific JavaScript.
     */
    public function enqueue_admin_scripts()
    {

        $wp_localize_script_data = array(
            'deleteText'         => esc_attr__('Delete', 'daam'),
            'cancelText'         => esc_attr__('Cancel', 'daam'),
            'chooseAnOptionText' => esc_attr__('Choose an Option ...', 'daam'),
            'wizardRows' => intval(get_option($this->shared->get('slug') . '_advanced_wizard_rows'), 10)
        );

        $screen = get_current_screen();

        //Menu Statistics
        if ($screen->id == $this->screen_id_statistics) {

            //Statistics Menu
            wp_enqueue_script($this->shared->get('slug') . '-menu-statistics',
                $this->shared->get('url') . 'admin/assets/js/menu-statistics.js', 'jquery', $this->shared->get('ver'));

            //jQuery UI Tooltip
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init',
                $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_script($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.js', array('jquery'),
                $this->shared->get('ver'));
            wp_enqueue_script($this->shared->get('slug') . '-chosen-init',
                $this->shared->get('url') . 'admin/assets/js/chosen-init.js', array('jquery'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-chosen-init', 'objectL10n', $wp_localize_script_data);

        }

        //Menu Wizard
        if ($screen->id == $this->screen_id_wizard) {

            //Wizard Menu
            wp_enqueue_script($this->shared->get('slug') . '-menu-wizard',
                $this->shared->get('url') . 'admin/assets/js/menu-wizard.js', 'jquery', $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-menu-wizard', 'objectL10n', $wp_localize_script_data);

            //jQuery UI Tooltip
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init',
                $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_script($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.js', array('jquery'),
                $this->shared->get('ver'));
            wp_enqueue_script($this->shared->get('slug') . '-chosen-init',
                $this->shared->get('url') . 'admin/assets/js/chosen-init.js', array('jquery'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-chosen-init', 'objectL10n', $wp_localize_script_data);

            //Handsontable
            wp_enqueue_script($this->shared->get('slug') . '-handsontable-full',
                $this->shared->get('url') . 'admin/assets/inc/handsontable/handsontable.full.min.js', array('jquery'),
                $this->shared->get('ver'));

        }

        //Menu Autolinks
        if ($screen->id == $this->screen_id_autolinks) {

            //Autolinks Menu
            wp_enqueue_script($this->shared->get('slug') . '-menu-autolinks',
                $this->shared->get('url') . 'admin/assets/js/menu-autolinks.js', array('jquery', 'jquery-ui-dialog'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-menu-autolinks', 'objectL10n', $wp_localize_script_data);

            //jQuery UI Tooltip
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init',
                $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_script($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.js', array('jquery'),
                $this->shared->get('ver'));
            wp_enqueue_script($this->shared->get('slug') . '-chosen-init',
                $this->shared->get('url') . 'admin/assets/js/chosen-init.js', array('jquery'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-chosen-init', 'objectL10n', $wp_localize_script_data);

        }

        //Menu Categories
        if ($screen->id == $this->screen_id_categories) {

            //Autolinks Menu
            wp_enqueue_script($this->shared->get('slug') . '-menu-categories',
                $this->shared->get('url') . 'admin/assets/js/menu-categories.js', array('jquery', 'jquery-ui-dialog'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-menu-categories', 'objectL10n', $wp_localize_script_data);

            //jQuery UI Tooltip
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init',
                $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_script($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.js', array('jquery'),
                $this->shared->get('ver'));
            wp_enqueue_script($this->shared->get('slug') . '-chosen-init',
                $this->shared->get('url') . 'admin/assets/js/chosen-init.js', array('jquery'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-chosen-init', 'objectL10n', $wp_localize_script_data);

        }

        //Menu Term Groups
        if ($screen->id == $this->screen_id_term_groups) {

            //Autolinks Menu
            wp_enqueue_script($this->shared->get('slug') . '-menu-autolinks',
                $this->shared->get('url') . 'admin/assets/js/menu-term-groups.js', array('jquery', 'jquery-ui-dialog'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-menu-term-groups', 'objectL10n',
                $wp_localize_script_data);

            //jQuery UI Tooltip
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init',
                $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_script($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.js', array('jquery'),
                $this->shared->get('ver'));
            wp_enqueue_script($this->shared->get('slug') . '-chosen-init',
                $this->shared->get('url') . 'admin/assets/js/chosen-init.js', array('jquery'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-chosen-init', 'objectL10n', $wp_localize_script_data);

        }

        //Menu Tracking
        if ($screen->id == $this->screen_id_tracking) {

            //jQuery UI Tooltip
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init',
                $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
                $this->shared->get('ver'));

            //Tracking Menu
            wp_enqueue_script($this->shared->get('slug') . '-menu-tracking',
                $this->shared->get('url') . 'admin/assets/js/menu-tracking.js', array('jquery', 'jquery-ui-dialog'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-menu-tracking', 'objectL10n', $wp_localize_script_data);

        }

        //Menu Import
        if ($screen->id == $this->screen_id_import) {

            //jQuery UI Tooltip
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init',
                $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
                $this->shared->get('ver'));

        }

        //Menu Export
        if ($screen->id == $this->screen_id_export) {

            //jQuery UI Tooltip
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init',
                $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
                $this->shared->get('ver'));

        }

        //Menu Maintenance
        if ($screen->id == $this->screen_id_maintenance) {

            //Maintenance Menu
            wp_enqueue_script($this->shared->get('slug') . '-menu-maintenance',
                $this->shared->get('url') . 'admin/assets/js/menu-maintenance.js', array('jquery', 'jquery-ui-dialog'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-menu-maintenance', 'objectL10n',
                $wp_localize_script_data);

            //jQuery UI Tooltip
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init',
                $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_script($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.js', array('jquery'),
                $this->shared->get('ver'));
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-chosen-init',
                $this->shared->get('url') . 'admin/assets/js/chosen-init.js', array('jquery'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-chosen-init', 'objectL10n', $wp_localize_script_data);

        }

        //Menu Options
        if ($screen->id == $this->screen_id_options) {

            //jQuery UI Tooltip
            wp_enqueue_script('jquery-ui-tooltip');
            wp_enqueue_script($this->shared->get('slug') . '-jquery-ui-tooltip-init',
                $this->shared->get('url') . 'admin/assets/js/jquery-ui-tooltip-init.js', 'jquery',
                $this->shared->get('ver'));

            //Chosen
            wp_enqueue_script($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.js', array('jquery'),
                $this->shared->get('ver'));
            wp_enqueue_script($this->shared->get('slug') . '-chosen-init',
                $this->shared->get('url') . 'admin/assets/js/chosen-init.js', array('jquery'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-chosen-init', 'objectL10n', $wp_localize_script_data);

        }

        $meta_box_post_types_a = $this->shared->get_post_types_with_ui();
        if (in_array($screen->id, $meta_box_post_types_a)) {

            //Chosen
            wp_enqueue_script($this->shared->get('slug') . '-chosen',
                $this->shared->get('url') . 'admin/assets/inc/chosen/chosen-min.js', array('jquery'),
                $this->shared->get('ver'));
            wp_enqueue_script($this->shared->get('slug') . '-chosen-init',
                $this->shared->get('url') . 'admin/assets/js/chosen-init.js', array('jquery'),
                $this->shared->get('ver'));
            wp_localize_script($this->shared->get('slug') . '-chosen-init', 'objectL10n', $wp_localize_script_data);

        }

    }

    /*
     * plugin activation
     */
    public function ac_activate($networkwide)
    {

        /*
         * delete options and tables for all the sites in the network
         */
        if (function_exists('is_multisite') and is_multisite()) {

            /*
             * if this is a "Network Activation" create the options and tables
             * for each blog
             */
            if ($networkwide) {

                //get the current blog id
                global $wpdb;
                $current_blog = $wpdb->blogid;

                //create an array with all the blog ids
                $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

                //iterate through all the blogs
                foreach ($blogids as $blog_id) {

                    //swith to the iterated blog
                    switch_to_blog($blog_id);

                    //create options and tables for the iterated blog
                    $this->ac_initialize_options();
                    $this->ac_create_database_tables();

                }

                //switch to the current blog
                switch_to_blog($current_blog);

            } else {

                /*
                 * if this is not a "Network Activation" create options and
                 * tables only for the current blog
                 */
                $this->ac_initialize_options();
                $this->ac_create_database_tables();

            }

        } else {

            /*
             * if this is not a multisite installation create options and
             * tables only for the current blog
             */
            $this->ac_initialize_options();
            $this->ac_create_database_tables();

        }

    }

    //create the options and tables for the newly created blog
    public function new_blog_create_options_and_tables($blog_id, $user_id, $domain, $path, $site_id, $meta)
    {

        global $wpdb;

        /*
         * if the plugin is "Network Active" create the options and tables for
         * this new blog
         */
        if (is_plugin_active_for_network('daext-autolinks-manager/init.php')) {

            //get the id of the current blog
            $current_blog = $wpdb->blogid;

            //switch to the blog that is being activated
            switch_to_blog($blog_id);

            //create options and database tables for the new blog
            $this->ac_initialize_options();
            $this->ac_create_database_tables();

            //switch to the current blog
            switch_to_blog($current_blog);

        }

    }

    //delete options and tables for the deleted blog
    public function delete_blog_delete_options_and_tables($blog_id)
    {

        global $wpdb;

        //get the id of the current blog
        $current_blog = $wpdb->blogid;

        //switch to the blog that is being activated
        switch_to_blog($blog_id);

        //create options and database tables for the new blog
        $this->un_delete_options();
        $this->un_delete_database_tables();

        //switch to the current blog
        switch_to_blog($current_blog);

    }

    /*
     * initialize plugin options
     */
    private function ac_initialize_options()
    {

	    foreach($this->shared->get('options') as $key => $value){
		    add_option($key, $value);
	    }

    }

    /*
     * Create the plugin database tables.
     */
    private function ac_create_database_tables()
    {

        global $wpdb;

        //Get the database character collate that will be appended at the end of each query
        $charset_collate = $wpdb->get_charset_collate();

        //check database version and create the database
        if (intval(get_option($this->shared->get('slug') . '_database_version'), 10) < 1) {

            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

            //create *prefix*_statistic
            $table_name = $wpdb->prefix . $this->shared->get('slug') . "_statistic";
            $sql        = "CREATE TABLE $table_name (
                statistic_id BIGINT AUTO_INCREMENT PRIMARY KEY,
                post_id BIGINT,
                content_length BIGINT,
                auto_links BIGINT,
                auto_links_visits BIGINT
            ) $charset_collate";
            dbDelta($sql);

            //create *prefix*_autolink
            $table_name = $wpdb->prefix . $this->shared->get('slug') . "_autolink";
            $sql        = "CREATE TABLE $table_name (
                autolink_id BIGINT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100),
                category_id BIGINT,
                keyword VARCHAR(255),
                url VARCHAR(2083),
                title VARCHAR(255),
                open_new_tab TINYINT(1),
                use_nofollow TINYINT(1),
                case_sensitive_search TINYINT(1),
                `limit` INT,
                priority INT,
                left_boundary SMALLINT,
                right_boundary SMALLINT,
                keyword_before VARCHAR(255),
                keyword_after VARCHAR(255),
                post_types TEXT,
                categories TEXT,
                tags TEXT,
                term_group_id BIGINT
            ) $charset_collate";
            dbDelta($sql);

            //create *prefix*_category
            $table_name = $wpdb->prefix . $this->shared->get('slug') . "_category";
            $sql        = "CREATE TABLE $table_name (
                category_id BIGINT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100),
                description VARCHAR(255)
            ) $charset_collate";
            dbDelta($sql);

            //create *prefix*_term
            $table_name = $wpdb->prefix . $this->shared->get('slug') . "_term_group";
            $query_part = '';
            for ($i = 1; $i <= 50; $i++) {
                $query_part .= 'post_type_' . $i . ' TEXT,';
                $query_part .= 'taxonomy_' . $i . ' TEXT,';
                $query_part .= 'term_' . $i . ' BIGINT';
                if ($i !== 50) {
                    $query_part .= ',';
                }
            }
            $sql = "CREATE TABLE $table_name (
                term_group_id BIGINT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(100),
                $query_part
            ) $charset_collate";
            dbDelta($sql);

            //create *prefix*_tracking
            $table_name = $wpdb->prefix . $this->shared->get('slug') . "_tracking";
            $sql        = "CREATE TABLE $table_name (
                tracking_id BIGINT AUTO_INCREMENT PRIMARY KEY,
                post_id BIGINT,
                autolink_id BIGINT,
                user_ip VARCHAR(45),
                date DATETIME,
                date_gmt DATETIME
            ) $charset_collate";
            dbDelta($sql);

            //Update database version
            update_option($this->shared->get('slug') . '_database_version', "1");

        }

    }

    /*
     * Plugin delete.
     */
    static public function un_delete()
    {

        /*
         * Delete options and tables for all the sites in the network.
         */
        if (function_exists('is_multisite') and is_multisite()) {

            //get the current blog id
            global $wpdb;
            $current_blog = $wpdb->blogid;

            //create an array with all the blog ids
            $blogids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

            //iterate through all the blogs
            foreach ($blogids as $blog_id) {

                //switch to the iterated blog
                switch_to_blog($blog_id);

                //create options and tables for the iterated blog
                Daam_Admin::un_delete_options();
                Daam_Admin::un_delete_database_tables();

            }

            //switch to the current blog
            switch_to_blog($current_blog);

        } else {

            /*
             * If this is not a multisite installation delete options and tables only for the current blog.
             */
            Daam_Admin::un_delete_options();
            Daam_Admin::un_delete_database_tables();

        }

    }

    /*
     * Delete plugin options.
     */
    static public function un_delete_options()
    {

        //assign an instance of Daam_Shared
        $shared = Daam_Shared::get_instance();

	    foreach($shared->get('options') as $key => $value){
		    delete_option($key);
	    }

    }

    /*
     * Delete plugin database tables.
     */
    static public function un_delete_database_tables()
    {

        //assign an instance of Daam_Shared
        $shared = Daam_Shared::get_instance();

        global $wpdb;

        $table_name = $wpdb->prefix . $shared->get('slug') . "_statistic";
        $sql        = "DROP TABLE $table_name";
        $wpdb->query($sql);

        $table_name = $wpdb->prefix . $shared->get('slug') . "_autolink";
        $sql        = "DROP TABLE $table_name";
        $wpdb->query($sql);

        $table_name = $wpdb->prefix . $shared->get('slug') . "_category";
        $sql        = "DROP TABLE $table_name";
        $wpdb->query($sql);

        $table_name = $wpdb->prefix . $shared->get('slug') . "_term_group";
        $sql        = "DROP TABLE $table_name";
        $wpdb->query($sql);

        $table_name = $wpdb->prefix . $shared->get('slug') . "_tracking";
        $sql        = "DROP TABLE $table_name";
        $wpdb->query($sql);

    }

    /*
     * Register the admin menu.
     */
    public function me_add_admin_menu()
    {

        add_menu_page(
            esc_attr__('AM', 'daam'),
            esc_attr__('Autolinks', 'daam'),
            get_option($this->shared->get('slug') . "_capabilities_statistics_menu"),
            $this->shared->get('slug') . '-statistics',
            array($this, 'me_display_menu_statistics'),
            'dashicons-admin-links'
        );

        $this->screen_id_statistics = add_submenu_page(
            $this->shared->get('slug') . '-statistics',
            esc_attr__('AM - Statistics', 'daam'),
            esc_attr__('Statistics', 'daam'),
            get_option($this->shared->get('slug') . '_capabilities_statistics_menu'),
            $this->shared->get('slug') . '-statistics',
            array($this, 'me_display_menu_statistics')
        );

        $this->screen_id_wizard = add_submenu_page(
            $this->shared->get('slug') . '-statistics',
            esc_attr__('AM - Wizard', 'daam'),
            esc_attr__('Wizard', 'daam'),
            get_option($this->shared->get('slug') . "_capabilities_wizard_menu"),
            $this->shared->get('slug') . '-wizard',
            array($this, 'me_display_menu_wizard')
        );

        $this->screen_id_autolinks = add_submenu_page(
            $this->shared->get('slug') . '-statistics',
            esc_attr__('AM - Autolinks', 'daam'),
            esc_attr__('Autolinks', 'daam'),
            get_option($this->shared->get('slug') . "_capabilities_autolinks_menu"),
            $this->shared->get('slug') . '-autolinks',
            array($this, 'me_display_menu_autolinks')
        );

        $this->screen_id_categories = add_submenu_page(
            $this->shared->get('slug') . '-statistics',
            esc_attr__('AM - Categories', 'daam'),
            esc_attr__('Categories', 'daam'),
            get_option($this->shared->get('slug') . "_capabilities_categories_menu"),
            $this->shared->get('slug') . '-categories',
            array($this, 'me_display_menu_categories')
        );

        $this->screen_id_term_groups = add_submenu_page(
            $this->shared->get('slug') . '-statistics',
            esc_attr__('AM - Term Groups', 'daam'),
            esc_attr__('Term Groups', 'daam'),
            get_option($this->shared->get('slug') . "_capabilities_term_groups_menu"),
            $this->shared->get('slug') . '-term-groups',
            array($this, 'me_display_menu_term_groups')
        );

        $this->screen_id_tracking = add_submenu_page(
            $this->shared->get('slug') . '-statistics',
            esc_attr__('AM - Tracking', 'daam'),
            esc_attr__('Tracking', 'daam'),
            get_option($this->shared->get('slug') . "_capabilities_tracking_menu"),
            $this->shared->get('slug') . '-tracking',
            array($this, 'me_display_menu_tracking')
        );

        $this->screen_id_import = add_submenu_page(
            $this->shared->get('slug') . '-statistics',
            esc_attr__('AM - Import', 'daam'),
            esc_attr__('Import', 'daam'),
            get_option($this->shared->get('slug') . "_capabilities_import_menu"),
            $this->shared->get('slug') . '-import',
            array($this, 'me_display_menu_import')
        );

        $this->screen_id_export = add_submenu_page(
            $this->shared->get('slug') . '-statistics',
            esc_attr__('AM - Export', 'daam'),
            esc_attr__('Export', 'daam'),
            get_option($this->shared->get('slug') . "_capabilities_export_menu"),
            $this->shared->get('slug') . '-export',
            array($this, 'me_display_menu_export')
        );

        $this->screen_id_maintenance = add_submenu_page(
            $this->shared->get('slug') . '-statistics',
            esc_attr__('AM - Maintenance', 'daam'),
            esc_attr__('Maintenance', 'daam'),
            get_option($this->shared->get('slug') . "_capabilities_maintenance_menu"),
            $this->shared->get('slug') . '-maintenance',
            array($this, 'me_display_menu_maintenance')
        );

        $this->screen_id_options = add_submenu_page(
            $this->shared->get('slug') . '-statistics',
            esc_attr__('AM - Options', 'daam'),
            esc_attr__('Options', 'daam'),
            'manage_options',
            $this->shared->get('slug') . '-options',
            array($this, 'me_display_menu_options')
        );

    }

    /*
     * includes the statistics view
     */
    public function me_display_menu_statistics()
    {
        include_once('view/statistics.php');
    }

    /*
     * includes the wizard view
     */
    public function me_display_menu_wizard()
    {
        include_once('view/wizard.php');
    }

    /*
     * includes the autolinks view
     */
    public function me_display_menu_autolinks()
    {
        include_once('view/autolinks.php');
    }

    /*
     * includes the categories view
     */
    public function me_display_menu_categories()
    {
        include_once('view/categories.php');
    }

    /*
     * includes the term groups view
     */
    public function me_display_menu_term_groups()
    {
        include_once('view/term_groups.php');
    }

    /*
     * includes the tracking view
     */
    public function me_display_menu_tracking()
    {
        include_once('view/tracking.php');
    }

    /*
     * includes the import view
     */
    public function me_display_menu_import()
    {
        include_once('view/import.php');
    }

    /*
     * includes the export view
     */
    public function me_display_menu_export()
    {
        include_once('view/export.php');
    }

    /*
     * includes the maintenance view
     */
    public function me_display_menu_maintenance()
    {
        include_once('view/maintenance.php');
    }

    /*
     * includes the options view
     */
    public function me_display_menu_options()
    {
        include_once('view/options.php');
    }

    /*
     * register options
     */
    public function op_register_options()
    {

        //section defaults ---------------------------------------------------------------------------------------------
        add_settings_section(
            'daam_defaults_settings_section',
            null,
            null,
            'daam_defaults_options'
        );

        add_settings_field(
            'defaults_category_id',
            esc_attr__('Category', 'daam'),
            array($this, 'defaults_category_id_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_category_id',
            array($this, 'defaults_category_id_validation')
        );

        add_settings_field(
            'defaults_open_new_table',
            esc_attr__('Open New Tab', 'daam'),
            array($this, 'defaults_open_new_tab_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_open_new_tab',
            array($this, 'defaults_open_new_tab_validation')
        );

        add_settings_field(
            'defaults_use_nofollow',
            esc_attr__('Use Nofollow', 'daam'),
            array($this, 'defaults_use_nofollow_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_use_nofollow',
            array($this, 'defaults_use_nofollow_validation')
        );

        add_settings_field(
            'defaults_post_types',
            esc_attr__('Post Types', 'daam'),
            array($this, 'defaults_post_types_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_post_types',
            array($this, 'defaults_post_types_validation')
        );

        add_settings_field(
            'defaults_categories',
            esc_attr__('Categories', 'daam'),
            array($this, 'defaults_categories_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_categories',
            array($this, 'defaults_categories_validation')
        );

        add_settings_field(
            'defaults_tags',
            esc_attr__('Tags', 'daam'),
            array($this, 'defaults_tags_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_tags',
            array($this, 'defaults_tags_validation')
        );

        add_settings_field(
            'defaults_term_group_id',
            esc_attr__('Term Group', 'daam'),
            array($this, 'defaults_term_group_id_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_term_group_id',
            array($this, 'defaults_term_group_id_validation')
        );

        add_settings_field(
            'defaults_case_sensitive_search',
            esc_attr__('Case Sensitive Search', 'daam'),
            array($this, 'defaults_case_sensitive_search_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_case_sensitive_search',
            array($this, 'defaults_case_sensitive_search_validation')
        );

        add_settings_field(
            'defaults_left_boundary',
            esc_attr__('Left Boundary', 'daam'),
            array($this, 'defaults_left_boundary_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_left_boundary',
            array($this, 'defaults_left_boundary_validation')
        );

        add_settings_field(
            'defaults_right_boundary',
            esc_attr__('Right Boundary', 'daam'),
            array($this, 'defaults_right_boundary_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_right_boundary',
            array($this, 'defaults_right_boundary_validation')
        );

        add_settings_field(
            'defaults_limit',
            esc_attr__('Limit', 'daam'),
            array($this, 'defaults_limit_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_limit',
            array($this, 'defaults_limit_validation')
        );

        add_settings_field(
            'defaults_priority',
            esc_attr__('Priority', 'daam'),
            array($this, 'defaults_priority_callback'),
            'daam_defaults_options',
            'daam_defaults_settings_section'
        );

        register_setting(
            'daam_defaults_options',
            'daam_defaults_priority',
            array($this, 'defaults_priority_validation')
        );

        //section analysis ---------------------------------------------------------------------------------------------
        add_settings_section(
            'daam_analysis_settings_section',
            null,
            null,
            'daam_analysis_options'
        );

        add_settings_field(
            'analysis_set_max_execution_time',
            esc_attr__('Set Max Execution Time', 'daam'),
            array($this, 'analysis_set_max_execution_time_callback'),
            'daam_analysis_options',
            'daam_analysis_settings_section'
        );

        register_setting(
            'daam_analysis_options',
            'daam_analysis_set_max_execution_time',
            array($this, 'analysis_set_max_execution_time_validation')
        );

        add_settings_field(
            'analysis_max_execution_time_value',
            esc_attr__('Max Execution Time Value', 'daam'),
            array($this, 'analysis_max_execution_time_value_callback'),
            'daam_analysis_options',
            'daam_analysis_settings_section'
        );

        register_setting(
            'daam_analysis_options',
            'daam_analysis_max_execution_time_value',
            array($this, 'analysis_max_execution_time_value_validation')
        );

        add_settings_field(
            'analysis_set_memory_limit',
            esc_attr__('Set Memory Limit', 'daam'),
            array($this, 'analysis_set_memory_limit_callback'),
            'daam_analysis_options',
            'daam_analysis_settings_section'
        );

        register_setting(
            'daam_analysis_options',
            'daam_analysis_set_memory_limit',
            array($this, 'analysis_set_memory_limit_validation')
        );

        add_settings_field(
            'analysis_memory_limit_value',
            esc_attr__('Memory Limit Value', 'daam'),
            array($this, 'analysis_memory_limit_value_callback'),
            'daam_analysis_options',
            'daam_analysis_settings_section'
        );

        register_setting(
            'daam_analysis_options',
            'daam_analysis_memory_limit_value',
            array($this, 'analysis_memory_limit_value_validation')
        );

        add_settings_field(
            'analysis_limit_posts_analysis',
            esc_attr__('Limit Posts Analysis', 'daam'),
            array($this, 'analysis_limit_posts_analysis_callback'),
            'daam_analysis_options',
            'daam_analysis_settings_section'
        );

        register_setting(
            'daam_analysis_options',
            'daam_analysis_limit_posts_analysis',
            array($this, 'analysis_limit_posts_analysis_validation')
        );

        add_settings_field(
            'analysis_post_types',
            esc_attr__('Post Types', 'daam'),
            array($this, 'analysis_post_types_callback'),
            'daam_analysis_options',
            'daam_analysis_settings_section'
        );

        register_setting(
            'daam_analysis_options',
            'daam_analysis_post_types',
            array($this, 'analysis_post_types_validation')
        );

        //section tracking ---------------------------------------------------------------------------------------------
        add_settings_section(
            'daam_tracking_settings_section',
            null,
            null,
            'daam_tracking_options'
        );

        add_settings_field(
            'tracking_enable_click_tracking',
            esc_attr__('Enable Click Tracking', 'daam'),
            array($this, 'tracking_enable_click_tracking_callback'),
            'daam_tracking_options',
            'daam_tracking_settings_section'
        );

        register_setting(
            'daam_tracking_options',
            'daam_tracking_enable_click_tracking',
            array($this, 'tracking_enable_click_tracking_validation')
        );

        add_settings_field(
            'tracking_minimum_interval',
            esc_attr__('Minimum Interval', 'daam'),
            array($this, 'tracking_minimum_interval_callback'),
            'daam_tracking_options',
            'daam_tracking_settings_section'
        );

        register_setting(
            'daam_tracking_options',
            'daam_tracking_minimum_interval',
            array($this, 'tracking_minimum_interval_validation')
        );

        //section capabilities -----------------------------------------------------------------------------------------
        add_settings_section(
            'daam_capabilities_settings_section',
            null,
            null,
            'daam_capabilities_options'
        );

	    add_settings_field(
		    'capabilities_editor_sidebar',
		    esc_attr__('Editor Sidebar', 'daam'),
		    array($this, 'capabilities_editor_sidebar_callback'),
		    'daam_capabilities_options',
		    'daam_capabilities_settings_section'
	    );

	    register_setting(
		    'daam_capabilities_options',
		    'daam_capabilities_editor_sidebar',
		    array($this, 'capabilities_editor_sidebar_validation')
	    );

        add_settings_field(
            'capabilities_statistics_menu',
            esc_attr__('Statistics Menu', 'daam'),
            array($this, 'capabilities_statistics_menu_callback'),
            'daam_capabilities_options',
            'daam_capabilities_settings_section'
        );

        register_setting(
            'daam_capabilities_options',
            'daam_capabilities_statistics_menu',
            array($this, 'capabilities_statistics_menu_validation')
        );

        add_settings_field(
            'capabilities_wizard_menu',
            esc_attr__('Wizard Menu', 'daam'),
            array($this, 'capabilities_wizard_menu_callback'),
            'daam_capabilities_options',
            'daam_capabilities_settings_section'
        );

        register_setting(
            'daam_capabilities_options',
            'daam_capabilities_wizard_menu',
            array($this, 'capabilities_wizard_menu_validation')
        );

        add_settings_field(
            'capabilities_autolinks_menu',
            esc_attr__('Autolinks Menu', 'daam'),
            array($this, 'capabilities_autolinks_menu_callback'),
            'daam_capabilities_options',
            'daam_capabilities_settings_section'
        );

        register_setting(
            'daam_capabilities_options',
            'daam_capabilities_autolinks_menu',
            array($this, 'capabilities_autolinks_menu_validation')
        );

        add_settings_field(
            'capabilities_categories_menu',
            esc_attr__('Categories Menu', 'daam'),
            array($this, 'capabilities_categories_menu_callback'),
            'daam_capabilities_options',
            'daam_capabilities_settings_section'
        );

        register_setting(
            'daam_capabilities_options',
            'daam_capabilities_categories_menu',
            array($this, 'capabilities_categories_menu_validation')
        );

        add_settings_field(
            'capabilities_term_groups_menu',
            esc_attr__('Term Groups Menu', 'daam'),
            array($this, 'capabilities_term_groups_menu_callback'),
            'daam_capabilities_options',
            'daam_capabilities_settings_section'
        );

        register_setting(
            'daam_capabilities_options',
            'daam_capabilities_term_groups_menu',
            array($this, 'capabilities_term_groups_menu_validation')
        );

        add_settings_field(
            'capabilities_tracking_menu',
            esc_attr__('Tracking Menu', 'daam'),
            array($this, 'capabilities_tracking_menu_callback'),
            'daam_capabilities_options',
            'daam_capabilities_settings_section'
        );

        register_setting(
            'daam_capabilities_options',
            'daam_capabilities_tracking_menu',
            array($this, 'capabilities_tracking_menu_validation')
        );

        add_settings_field(
            'capabilities_import_menu',
            esc_attr__('Import Menu', 'daam'),
            array($this, 'capabilities_import_menu_callback'),
            'daam_capabilities_options',
            'daam_capabilities_settings_section'
        );

        register_setting(
            'daam_capabilities_options',
            'daam_capabilities_import_menu',
            array($this, 'capabilities_import_menu_validation')
        );

        add_settings_field(
            'capabilities_export_menu',
            esc_attr__('Export Menu', 'daam'),
            array($this, 'capabilities_export_menu_callback'),
            'daam_capabilities_options',
            'daam_capabilities_settings_section'
        );

        register_setting(
            'daam_capabilities_options',
            'daam_capabilities_export_menu',
            array($this, 'capabilities_export_menu_validation')
        );

        add_settings_field(
            'capabilities_maintenance_menu',
            esc_attr__('Maintenance Menu', 'daam'),
            array($this, 'capabilities_maintenance_menu_callback'),
            'daam_capabilities_options',
            'daam_capabilities_settings_section'
        );

        register_setting(
            'daam_capabilities_options',
            'daam_capabilities_maintenance_menu',
            array($this, 'capabilities_maintenance_menu_validation')
        );

        //section pagination -------------------------------------------------------------------------------------------
        add_settings_section(
            'daam_pagination_settings_section',
            null,
            null,
            'daam_pagination_options'
        );

        add_settings_field(
            'pagination_statistics_menu',
            esc_attr__('Statistics Menu', 'daam'),
            array($this, 'pagination_statistics_menu_callback'),
            'daam_pagination_options',
            'daam_pagination_settings_section'
        );

        register_setting(
            'daam_pagination_options',
            'daam_pagination_statistics_menu',
            array($this, 'pagination_statistics_menu_validation')
        );

        add_settings_field(
            'pagination_autolinks_menu',
            esc_attr__('Autolinks Menu', 'daam'),
            array($this, 'pagination_autolinks_menu_callback'),
            'daam_pagination_options',
            'daam_pagination_settings_section'
        );

        register_setting(
            'daam_pagination_options',
            'daam_pagination_autolinks_menu',
            array($this, 'pagination_autolinks_menu_validation')
        );

        add_settings_field(
            'pagination_categories_menu',
            esc_attr__('Categories Menu', 'daam'),
            array($this, 'pagination_categories_menu_callback'),
            'daam_pagination_options',
            'daam_pagination_settings_section'
        );

        register_setting(
            'daam_pagination_options',
            'daam_pagination_categories_menu',
            array($this, 'pagination_categories_menu_validation')
        );

        add_settings_field(
            'pagination_term_groups_menu',
            esc_attr__('Term Groups Menu', 'daam'),
            array($this, 'pagination_term_groups_menu_callback'),
            'daam_pagination_options',
            'daam_pagination_settings_section'
        );

        register_setting(
            'daam_pagination_options',
            'daam_pagination_term_groups_menu',
            array($this, 'pagination_term_groups_menu_validation')
        );

        add_settings_field(
            'pagination_tracking_menu',
            esc_attr__('Tracking Menu', 'daam'),
            array($this, 'pagination_tracking_menu_callback'),
            'daam_pagination_options',
            'daam_pagination_settings_section'
        );

        register_setting(
            'daam_pagination_options',
            'daam_pagination_tracking_menu',
            array($this, 'pagination_tracking_menu_validation')
        );

        //section advanced ---------------------------------------------------------------------------------------------
        add_settings_section(
            'daam_advanced_settings_section',
            null,
            null,
            'daam_advanced_options'
        );

        add_settings_field(
            'advanced_enable_autolinks',
            esc_attr__('Enable Autolinks', 'daam'),
            array($this, 'advanced_enable_autolinks_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_enable_autolinks',
            array($this, 'advanced_enable_autolinks_validation')
        );

        add_settings_field(
            'advanced_filter_priority',
            esc_attr__('Filter Priority', 'daam'),
            array($this, 'advanced_filter_priority_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_filter_priority',
            array($this, 'advanced_filter_priority_validation')
        );

        add_settings_field(
            'advanced_enable_test_mode',
            esc_attr__('Test Mode', 'daam'),
            array($this, 'advanced_enable_test_mode_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_enable_test_mode',
            array($this, 'advanced_enable_test_mode_validation')
        );

        add_settings_field(
            'advanced_random_prioritization',
            esc_attr__('Random Prioritization', 'daam'),
            array($this, 'advanced_random_prioritization_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_random_prioritization',
            array($this, 'advanced_random_prioritization_validation')
        );

        add_settings_field(
            'advanced_ignore_self_autolinks',
            esc_attr__('Ignore Self Autolinks', 'daam'),
            array($this, 'advanced_ignore_self_autolinks_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_ignore_self_autolinks',
            array($this, 'advanced_ignore_self_autolinks_validation')
        );

        add_settings_field(
            'advanced_categories_and_tags_verification',
            esc_attr__('Categories & Tags Verification', 'daam'),
            array($this, 'advanced_categories_and_tags_verification_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_categories_and_tags_verification',
            array($this, 'advanced_categories_and_tags_verification_validation')
        );

        add_settings_field(
            'advanced_general_limit_mode',
            esc_attr__('General Limit Mode', 'daam'),
            array($this, 'advanced_general_limit_mode_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_general_limit_mode',
            array($this, 'advanced_general_limit_mode_validation')
        );

        add_settings_field(
            'advanced_general_limit_characters_per_autolink',
            esc_attr__('General Limit (Characters per Autolink)', 'daam'),
            array($this, 'advanced_general_limit_characters_per_autolink_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_general_limit_characters_per_autolink',
            array($this, 'advanced_general_limit_characters_per_autolink_validation')
        );

        add_settings_field(
            'advanced_general_limit_amount',
            esc_attr__('General Limit (Amount)', 'daam'),
            array($this, 'advanced_general_limit_amount_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_general_limit_amount',
            array($this, 'advanced_general_limit_amount_validation')
        );

        add_settings_field(
            'advanced_same_url_limit',
            esc_attr__('Same URL Limit', 'daam'),
            array($this, 'advanced_same_url_limit_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_same_url_limit',
            array($this, 'advanced_same_url_limit_validation')
        );

        add_settings_field(
            'advanced_protected_tags',
            esc_attr__('Protected Tags', 'daam'),
            array($this, 'advanced_protected_tags_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_protected_tags',
            array($this, 'advanced_protected_tags_validation')
        );

        add_settings_field(
            'advanced_protected_gutenberg_blocks',
            esc_attr__('Protected Gutenberg Blocks', 'daam'),
            array($this, 'advanced_protected_gutenberg_blocks_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_protected_gutenberg_blocks',
            array($this, 'advanced_protected_gutenberg_blocks_validation')
        );

        add_settings_field(
            'advanced_protected_gutenberg_custom_blocks',
            esc_attr__('Protected Gutenberg Custom Blocks', 'daam'),
            array($this, 'advanced_protected_gutenberg_custom_blocks_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_protected_gutenberg_custom_blocks',
            array($this, 'advanced_protected_gutenberg_custom_blocks_validation')
        );

        add_settings_field(
            'advanced_protected_gutenberg_custom_void_blocks',
            esc_attr__('Protected Gutenberg Custom Void Blocks', 'daam'),
            array($this, 'advanced_protected_gutenberg_custom_void_blocks_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_protected_gutenberg_custom_void_blocks',
            array($this, 'advanced_protected_gutenberg_custom_void_blocks_validation')
        );

        add_settings_field(
            'advanced_supported_terms',
            esc_attr__('Supported Terms', 'daam'),
            array($this, 'advanced_supported_terms_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_supported_terms',
            array($this, 'advanced_supported_terms_validation')
        );

        add_settings_field(
            'advanced_wizard_rows',
            esc_attr__('Wizard Rows', 'daam'),
            array($this, 'advanced_wizard_rows_callback'),
            'daam_advanced_options',
            'daam_advanced_settings_section'
        );

        register_setting(
            'daam_advanced_options',
            'daam_advanced_wizard_rows',
            array($this, 'advanced_wizard_rows_validation')
        );

    }

    //defaults options callbacks and validations -----------------------------------------------------------------------
    public function defaults_category_id_callback($args)
    {

        $html = '<select id="daam-defaults-term-group-id" name="daam_defaults_category_id" class="daext-display-none">';

        $html .= '<option value="0" ' . selected(intval(get_option("daam_defaults_category_id")), 0,
                false) . '>' . esc_attr__('None', 'daam') . '</option>';

        global $wpdb;
        $table_name = $wpdb->prefix . $this->shared->get('slug') . "_category";
        $sql        = "SELECT category_id, name FROM $table_name ORDER BY category_id DESC";
        $category_a = $wpdb->get_results($sql, ARRAY_A);

        foreach ($category_a as $key => $category) {
            $html .= '<option value="' . $category['category_id'] . '" ' . selected(intval(get_option("daam_defaults_category_id")),
                    $category['category_id'], false) . '>' . esc_attr(stripslashes($category['name'])) . '</option>';
        }

        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('The category of the autolink. This option determines the default value of the "Category" field available in the "Autolinks" menu and in the "Wizard" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function defaults_category_id_validation($input)
    {

        return intval($input, 10);

    }

    public function defaults_open_new_tab_callback($args)
    {

        $html = '<select id="daam-defaults-open-new-tab" name="daam_defaults_open_new_tab" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_open_new_tab")), 0,
                false) . ' value="0">' . esc_attr__('No', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_open_new_tab")), 1,
                false) . ' value="1">' . esc_attr__('Yes', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('If you select "Yes" the link generated on the defined keyword opens the linked document in a new tab. This option determines the default value of the "Open New Tab" field available in the "Autolinks" menu and is also used for the autolinks generated with the "Wizard" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function defaults_open_new_tab_validation($input)
    {

        return intval($input, 10) == 1 ? '1' : '0';

    }

    public function defaults_use_nofollow_callback($args)
    {

        $html = '<select id="daam-defaults-use-nofollow" name="daam_defaults_use_nofollow" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_use_nofollow")), 0,
                false) . ' value="0">' . esc_attr__('No', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_use_nofollow")), 1,
                false) . ' value="1">' . esc_attr__('Yes', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('If you select "Yes" the link generated on the defined keyword will include the rel="nofollow" attribute. This option determines the default value of the "Use Nofollow" field available in the "Autolinks" menu and is also used for the autolinks generated with the "Wizard" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function defaults_use_nofollow_validation($input)
    {

        return intval($input, 10) == 1 ? '1' : '0';

    }

    public function defaults_post_types_callback($args)
    {

        $defaults_post_types_a = get_option("daam_defaults_post_types");

        $available_post_types_a = get_post_types(array(
            'public'  => true,
            'show_ui' => true
        ));

        //Remove the "attachment" post type
        $available_post_types_a = array_diff($available_post_types_a, array('attachment'));

        $html = '<select id="daam-defaults-categories" name="daam_defaults_post_types[]" class="daext-display-none" multiple>';

        foreach ($available_post_types_a as $single_post_type) {
            if (is_array($defaults_post_types_a) and in_array($single_post_type, $defaults_post_types_a)) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $post_type_obj = get_post_type_object($single_post_type);
            $html          .= '<option value="' . $single_post_type . '" ' . $selected . '>' . esc_attr($post_type_obj->label) . '</option>';
        }

        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('With this option you are able to determine in which post types the defined keywords will be automatically converted to a link. Leave this field empty to convert the keyword in any post type. This option determines the default value of the "Post Types" field available in the "Autolinks" menu and is also used for the autolinks generated with the "Wizard" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function defaults_post_types_validation($input)
    {

        if (is_array($input)) {
            return $input;
        } else {
            return '';
        }

    }

    public function defaults_categories_callback($args)
    {

        $defaults_categories_a = get_option("daam_defaults_categories");

        $html = '<select id="daam-defaults-categories" name="daam_defaults_categories[]" class="daext-display-none" multiple>';

        $categories = get_categories(array(
            'hide_empty' => 0,
            'orderby'    => 'term_id',
            'order'      => 'DESC'
        ));

        foreach ($categories as $category) {
            if (is_array($defaults_categories_a) and in_array($category->term_id, $defaults_categories_a)) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $category->term_id . '" ' . $selected . '>' . esc_attr($category->name) . '</option>';
        }

        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('With this option you are able to determine in which categories the defined keywords will be automatically converted to a link. Leave this field empty to convert the keyword in any category. This option determines the default value of the "Categories" field available in the "Autolinks" menu and is also used for the autolinks generated with the "Wizard" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function defaults_categories_validation($input)
    {

        if (wp_is_numeric_array($input)) {
            return $input;
        } else {
            return '';
        }

    }

    public function defaults_tags_callback($args)
    {

        $defaults_tags_a = get_option("daam_defaults_tags");

        $html = '<select id="daam-defaults-categories" name="daam_defaults_tags[]" class="daext-display-none" multiple>';

        $categories = get_categories(array(
            'hide_empty' => 0,
            'orderby'    => 'term_id',
            'order'      => 'DESC',
            'taxonomy'   => 'post_tag'
        ));

        foreach ($categories as $category) {
            if (is_array($defaults_tags_a) and in_array($category->term_id, $defaults_tags_a)) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $html .= '<option value="' . $category->term_id . '" ' . $selected . '>' . esc_attr($category->name) . '</option>';
        }

        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('With this option you are able to determine in which tags the defined keywords will be automatically converted to a link. Leave this field empty to convert the keyword in any tag. This option determines the default value of the "Tags" field available in the "Autolinks" menu and is also used for the autolinks generated with the "Wizard" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function defaults_tags_validation($input)
    {

        if (wp_is_numeric_array($input)) {
            return $input;
        } else {
            return '';
        }

    }

    public function defaults_term_group_id_callback($args)
    {

        $html = '<select id="daam-defaults-term-group-id" name="daam_defaults_term_group_id" class="daext-display-none">';

        $html .= '<option value="0" ' . selected(intval(get_option("daam_defaults_term_group_id")), 0,
                false) . '>' . esc_attr__('None', 'daam') . '</option>';

        global $wpdb;
        $table_name   = $wpdb->prefix . $this->shared->get('slug') . "_term_group";
        $sql          = "SELECT term_group_id, name FROM $table_name ORDER BY term_group_id DESC";
        $term_group_a = $wpdb->get_results($sql, ARRAY_A);

        foreach ($term_group_a as $key => $term_group) {
            $html .= '<option value="' . $term_group['term_group_id'] . '" ' . selected(intval(get_option("daam_defaults_term_group_id")),
                    $term_group['term_group_id'],
                    false) . '>' . esc_attr(stripslashes($term_group['name'])) . '</option>';
        }

        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('The terms that will be compared with the ones available on the posts where the autolinks are applied. Please note that when a term group is selected the "Categories" and "Tags" options will be ignored. This option determines the default value of the "Term Group" field available in the "Autolinks" menu and is also used for the autolinks generated with the "Wizard" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function defaults_term_group_id_validation($input)
    {

        return intval($input, 10);

    }

    public function defaults_case_sensitive_search_callback($args)
    {

        $html = '<select id="daam-defaults-case-sensitive-search" name="daam_defaults_case_sensitive_search" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_case_sensitive_search")), 0,
                false) . ' value="0">' . esc_attr__('No', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_case_sensitive_search")), 1,
                false) . ' value="1">' . esc_attr__('Yes', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('If you select "No" the defined keyword will match both lowercase and uppercase variations. This option determines the default value of the "Case Sensitive Search" field available in the "Autolinks" menu and is also used for the autolinks generated with the "Wizard" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function defaults_case_sensitive_search_validation($input)
    {

        return intval($input, 10) == 1 ? '1' : '0';

    }

    public function defaults_left_boundary_callback($args)
    {

        $html = '<select id="daam-defaults-left-boundary" name="daam_defaults_left_boundary" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_left_boundary")), 0,
                false) . ' value="0">' . esc_attr__('Generic', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_left_boundary")), 1,
                false) . ' value="1">' . esc_attr__('White Space', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_left_boundary")), 2,
                false) . ' value="2">' . esc_attr__('Comma', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_left_boundary")), 3,
                false) . ' value="3">' . esc_attr__('Point', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_left_boundary")), 4,
                false) . ' value="4">' . esc_attr__('None', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('Use this option to match keywords preceded by a generic boundary or by a specific character. This option determines the default value of the "Left Boundary" field available in the "Autolinks" menu and is also used for the autolinks generated with the "Wizard" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function defaults_left_boundary_validation($input)
    {

        if (intval($input, 10) >= 0 and intval($input, 10) <= 4) {
            return intval($input, 10);
        } else {
            return intval(get_option('daam_defaults_left_boundary'), 10);
        }

    }

    public function defaults_right_boundary_callback($args)
    {

        $html = '<select id="daam-defaults-right-boundary" name="daam_defaults_right_boundary" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_right_boundary")), 0,
                false) . ' value="0">' . esc_attr__('Generic', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_right_boundary")), 1,
                false) . ' value="1">' . esc_attr__('White Space', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_right_boundary")), 2,
                false) . ' value="2">' . esc_attr__('Comma', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_right_boundary")), 3,
                false) . ' value="3">' . esc_attr__('Point', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_defaults_right_boundary")), 4,
                false) . ' value="4">' . esc_attr__('None', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('Use this option to match keywords followed by a generic boundary or by a specific character. This option determines the default value of the "Right Boundary" field available in the "Autolinks" menu and is also used for the autolinks generated with the "Wizard" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function defaults_right_boundary_validation($input)
    {

        if (intval($input, 10) >= 0 and intval($input, 10) <= 4) {
            return intval($input, 10);
        } else {
            return intval(get_option('daam_defaults_right_boundary'), 10);
        }

    }

    public function defaults_limit_callback($args)
    {

        $html = '<input maxlength="7" type="text" id="daam_defaults_limit" name="daam_defaults_limit" class="regular-text" value="' . intval(get_option("daam_defaults_limit"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('With this option you can determine the maximum number of matches of the defined keyword automatically converted to a link. This option determines the default value of the "Limit" field available in the "Autolinks" menu and is also used for the autolinks generated with the "Wizard" menu.',
                'daam') . '"></div>';
        echo $html;

    }

    public function defaults_limit_validation($input)
    {

        if ( ! preg_match($this->shared->regex_number_ten_digits, $input) or intval($input, 10) < 1 or intval($input,
                10) > 1000000) {
            add_settings_error('daam_defaults_limit', 'daam_defaults_limit',
                esc_attr__('Please enter a number from 1 to 1000000 in the "Limit" option.', 'daam'));
            $output = get_option('daam_defaults_limit');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }


    public function defaults_priority_callback($args)
    {

        $html = '<input maxlength="7" type="text" id="daam_defaults_priority" name="daam_defaults_priority" class="regular-text" value="' . intval(get_option("daam_defaults_priority"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('The priority value determines the order used to apply the autolinks on the post. This option determines the default value of the "Priority" field available in the "Autolinks" menu and is also used for the autolinks generated with the "Wizard" menu.',
                'daam') . '"></div>';
        echo $html;

    }

    public function defaults_priority_validation($input)
    {

        if ( ! preg_match($this->shared->regex_number_ten_digits, $input) or intval($input, 10) < 0 or intval($input,
                10) > 1000000) {
            add_settings_error('daam_defaults_priority', 'daam_defaults_priority',
                esc_attr__('Please enter a number from 1 to 1000000 in the "Priority" option.', 'daam'));
            $output = get_option('daam_defaults_priority');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }

    //analysis options callbacks and validations -----------------------------------------------------------------------
    public function analysis_set_max_execution_time_callback($args)
    {

        $html = '<select id="daam-analysis-set-max-execution-time" name="daam_analysis_set_max_execution_time" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_analysis_set_max_execution_time")), 0,
                false) . ' value="0">' . esc_attr__('No', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_analysis_set_max_execution_time")), 1,
                false) . ' value="1">' . esc_attr__('Yes', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('Select "Yes" to enable your custom "Max Execution Time Value" on long running scripts.',
                'daam') . '"></div>';

        echo $html;

    }

    public function analysis_set_max_execution_time_validation($input)
    {

        return intval($input, 10) == 1 ? '1' : '0';

    }

    public function analysis_max_execution_time_value_callback($args)
    {

        $html = '<input maxlength="7" type="text" id="daam_analysis_max_execution_time_value" name="daam_analysis_max_execution_time_value" class="regular-text" value="' . intval(get_option("daam_analysis_max_execution_time_value"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('This value determines the maximum number of seconds allowed to execute long running scripts.',
                'daam') . '"></div>';
        echo $html;

    }

    public function analysis_max_execution_time_value_validation($input)
    {

        if ( ! preg_match($this->shared->regex_number_ten_digits, $input) or intval($input, 10) > 1000000) {
            add_settings_error('daam_analysis_max_execution_time_value', 'daam_analysis_max_execution_time_value',
                esc_attr__('Please enter a valid value in the "Memory Limit Value" option.', 'daam'));
            $output = get_option('daam_analysis_max_execution_time_value');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }

    public function analysis_set_memory_limit_callback($args)
    {

        $html = '<select id="daam-analysis-set-memory-limit" name="daam_analysis_set_memory_limit" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_analysis_set_memory_limit")), 0,
                false) . ' value="0">' . esc_attr__('No', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_analysis_set_memory_limit")), 1,
                false) . ' value="1">' . esc_attr__('Yes', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('Select "Yes" to enable your custom "Memory Limit Value" on long running scripts.',
                'daam') . '"></div>';

        echo $html;

    }

    public function analysis_set_memory_limit_validation($input)
    {

        return intval($input, 10) == 1 ? '1' : '0';

    }

    public function analysis_memory_limit_value_callback($args)
    {

        $html = '<input maxlength="7" type="text" id="daam_analysis_memory_limit_value" name="daam_analysis_memory_limit_value" class="regular-text" value="' . intval(get_option("daam_analysis_memory_limit_value"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('This value determines the PHP memory limit in megabytes allowed to execute long running scripts.',
                'daam') . '"></div>';
        echo $html;

    }

    public function analysis_memory_limit_value_validation($input)
    {

        if ( ! preg_match($this->shared->regex_number_ten_digits, $input) or intval($input, 10) > 1000000) {
            add_settings_error('daam_analysis_memory_limit_value', 'daam_analysis_memory_limit_value',
                esc_attr__('Please enter a valid value in the "Memory Limit Value" option.', 'daam'));
            $output = get_option('daam_analysis_memory_limit_value');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }

    public function analysis_limit_posts_analysis_callback($args)
    {

        $html = '<input maxlength="7" type="text" id="daam_analysis_limit_posts_analysis" name="daam_analysis_limit_posts_analysis" class="regular-text" value="' . intval(get_option("daam_analysis_limit_posts_analysis"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('With this options you can determine the maximum number of posts analyzed to get information about your autolinks. If you select for example "1000", the analysis performed by the plugin will use your latest "1000" posts.',
                'daam') . '"></div>';
        echo $html;

    }

    public function analysis_limit_posts_analysis_validation($input)
    {

        if ( ! preg_match($this->shared->regex_number_ten_digits, $input) or intval($input, 10) > 1000000) {
            add_settings_error('daam_analysis_limit_posts_analysis', 'daam_analysis_limit_posts_analysis',
                esc_attr__('Please enter a valid value in the "Limit Post Analysis" option.', 'daam'));
            $output = get_option('daam_analysis_limit_posts_analysis');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }


    public function analysis_post_types_callback($args)
    {

        $analysis_post_types_a = get_option("daam_analysis_post_types");

        $available_post_types_a = get_post_types(array(
            'public'  => true,
            'show_ui' => true
        ));

        //Remove the "attachment" post type
        $available_post_types_a = array_diff($available_post_types_a, array('attachment'));

        $html = '<select id="daam-analysis-categories" name="daam_analysis_post_types[]" class="daext-display-none" multiple>';

        foreach ($available_post_types_a as $single_post_type) {
            if (is_array($analysis_post_types_a) and in_array($single_post_type, $analysis_post_types_a)) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
            $post_type_obj = get_post_type_object($single_post_type);
            $html          .= '<option value="' . $single_post_type . '" ' . $selected . '>' . esc_attr($post_type_obj->label) . '</option>';
        }

        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('With this option you are able to determine in which post types the analysis should be performed. Leave this field empty to perform the analysis in any post type.',
                'daam') . '"></div>';

        echo $html;

    }

    public function analysis_post_types_validation($input)
    {

        if (is_array($input)) {
            return $input;
        } else {
            return '';
        }

    }

    //tracking options callbacks and validations -----------------------------------------------------------------------
    public function tracking_enable_click_tracking_callback($args)
    {

        $html = '<select id="daam-tracking-enable-click-tracking" name="daam_tracking_enable_click_tracking" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_tracking_enable_click_tracking")), 0,
                false) . ' value="0">' . esc_attr__('No', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_tracking_enable_click_tracking")), 1,
                false) . ' value="1">' . esc_attr__('Yes', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('This option determines whether to track or not the clicks performed on the autolinks.',
                'daam') . '"></div>';

        echo $html;

    }

    public function tracking_enable_click_tracking_validation($input)
    {

        return intval($input, 10) == 1 ? '1' : '0';

    }

    public function tracking_minimum_interval_callback($args)
    {

        $html = '<input maxlength="7" type="text" id="daam_tracking_minimum_interval" name="daam_tracking_minimum_interval" class="regular-text" value="' . intval(get_option("daam_tracking_minimum_interval"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('This value determines the minimum interval in seconds between multiple clicks of the same users.',
                'daam') . '"></div>';
        echo $html;

    }

    public function tracking_minimum_interval_validation($input)
    {

        if ( ! preg_match($this->shared->regex_number_ten_digits, $input) or intval($input, 10) < 1 or intval($input,
                10) > 1000000) {
            add_settings_error('daam_tracking_minimum_interval', 'daam_tracking_minimum_interval',
                esc_attr__('Please enter a valid value in the "Minimum Interval" option.', 'daam'));
            $output = get_option('daam_tracking_minimum_interval');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }

    //capabilities options callbacks and validations -------------------------------------------------------------------
	public function capabilities_editor_sidebar_callback($args)
	{

		$html = '<input type="text" id="daam_capabilities_editor_sidebar" name="daam_capabilities_editor_sidebar" class="regular-text" value="' . esc_attr(get_option("daam_capabilities_editor_sidebar")) . '" />';
		$html .= '<div class="help-icon" title="' . esc_attr__('The capability required to get access on the editor sidebar.',
				'daam') . '"></div>';

		echo $html;

	}

	public function capabilities_editor_sidebar_validation($input)
	{

		if ( ! preg_match($this->shared->regex_capability, $input)) {
			add_settings_error('daam_capabilities_editor_sidebar', 'daam_capabilities_editor_sidebar',
				esc_attr__('Please enter a valid capability in the "Editor Sidebar" option.', 'daam'));
			$output = get_option('daam_capabilities_editor_sidebar');
		} else {
			$output = $input;
		}

		return trim($output);

	}

    public function capabilities_statistics_menu_callback($args)
    {

        $html = '<input type="text" id="daam_capabilities_statistics_menu" name="daam_capabilities_statistics_menu" class="regular-text" value="' . esc_attr(get_option("daam_capabilities_statistics_menu")) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('The capability required to get access on the "Statistics" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function capabilities_statistics_menu_validation($input)
    {

        if ( ! preg_match($this->shared->regex_capability, $input)) {
            add_settings_error('daam_capabilities_statistics_menu', 'daam_capabilities_statistics_menu',
                esc_attr__('Please enter a valid capability in the "Statistics Menu" option.', 'daam'));
            $output = get_option('daam_capabilities_statistics_menu');
        } else {
            $output = $input;
        }

        return trim($output);

    }

    public function capabilities_wizard_menu_callback($args)
    {

        $html = '<input type="text" id="daam_capabilities_wizard_menu" name="daam_capabilities_wizard_menu" class="regular-text" value="' . esc_attr(get_option("daam_capabilities_wizard_menu")) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('The capability required to get access on the "Wizard" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function capabilities_wizard_menu_validation($input)
    {

        if ( ! preg_match($this->shared->regex_capability, $input)) {
            add_settings_error('daam_capabilities_wizard_menu', 'daam_capabilities_wizard_menu',
                esc_attr__('Please enter a valid capability in the "Wizard Menu" option.', 'daam'));
            $output = get_option('daam_capabilities_wizard_menu');
        } else {
            $output = $input;
        }

        return trim($output);

    }

    public function capabilities_autolinks_menu_callback($args)
    {

        $html = '<input type="text" id="daam_capabilities_autolinks_menu" name="daam_capabilities_autolinks_menu" class="regular-text" value="' . esc_attr(get_option("daam_capabilities_autolinks_menu")) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('The capability required to get access on the "Autolinks" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function capabilities_autolinks_menu_validation($input)
    {

        if ( ! preg_match($this->shared->regex_capability, $input)) {
            add_settings_error('daam_capabilities_autolinks_menu', 'daam_capabilities_autolinks_menu',
                esc_attr__('Please enter a valid capability in the "Autolinks Menu" option.', 'daam'));
            $output = get_option('daam_capabilities_autolinks_menu');
        } else {
            $output = $input;
        }

        return trim($output);

    }

    public function capabilities_categories_menu_callback($args)
    {

        $html = '<input type="text" id="daam_capabilities_categories_menu" name="daam_capabilities_categories_menu" class="regular-text" value="' . esc_attr(get_option("daam_capabilities_categories_menu")) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('The capability required to get access on the "Categories" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function capabilities_categories_menu_validation($input)
    {

        if ( ! preg_match($this->shared->regex_capability, $input)) {
            add_settings_error('daam_capabilities_categories_menu', 'daam_capabilities_categories_menu',
                esc_attr__('Please enter a valid capability in the "Categories Menu" option.', 'daam'));
            $output = get_option('daam_capabilities_categories_menu');
        } else {
            $output = $input;
        }

        return trim($output);

    }

    public function capabilities_term_groups_menu_callback($args)
    {

        $html = '<input type="text" id="daam_capabilities_term_groups_menu" name="daam_capabilities_term_groups_menu" class="regular-text" value="' . esc_attr(get_option("daam_capabilities_term_groups_menu")) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('The capability required to get access on the "Term Groups" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function capabilities_term_groups_menu_validation($input)
    {

        if ( ! preg_match($this->shared->regex_capability, $input)) {
            add_settings_error('daam_capabilities_term_groups_menu', 'daam_capabilities_term_groups_menu',
                esc_attr__('Please enter a valid capability in the "Term Groups Menu" option.', 'daam'));
            $output = get_option('daam_capabilities_term_groups_menu');
        } else {
            $output = $input;
        }

        return trim($output);

    }

    public function capabilities_tracking_menu_callback($args)
    {

        $html = '<input type="text" id="daam_capabilities_tracking_menu" name="daam_capabilities_tracking_menu" class="regular-text" value="' . esc_attr(get_option("daam_capabilities_tracking_menu")) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('The capability required to get access on the "Tracking" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function capabilities_tracking_menu_validation($input)
    {

        if ( ! preg_match($this->shared->regex_capability, $input)) {
            add_settings_error('daam_capabilities_tracking_menu', 'daam_capabilities_tracking_menu',
                esc_attr__('Please enter a valid capability in the "Tracking Menu" option.', 'daam'));
            $output = get_option('daam_capabilities_tracking_menu');
        } else {
            $output = $input;
        }

        return trim($output);

    }

    public function capabilities_import_menu_callback($args)
    {

        $html = '<input type="text" id="daam_capabilities_import_menu" name="daam_capabilities_import_menu" class="regular-text" value="' . esc_attr(get_option("daam_capabilities_import_menu")) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('The capability required to get access on the "Import" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function capabilities_import_menu_validation($input)
    {

        if ( ! preg_match($this->shared->regex_capability, $input)) {
            add_settings_error('daam_capabilities_import_menu', 'daam_capabilities_import_menu',
                esc_attr__('Please enter a valid capability in the "Import Menu" option.', 'daam'));
            $output = get_option('daam_capabilities_import_menu');
        } else {
            $output = $input;
        }

        return trim($output);

    }

    public function capabilities_export_menu_callback($args)
    {

        $html = '<input type="text" id="daam_capabilities_export_menu" name="daam_capabilities_export_menu" class="regular-text" value="' . esc_attr(get_option("daam_capabilities_export_menu")) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('The capability required to get access on the "Export" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function capabilities_export_menu_validation($input)
    {

        if ( ! preg_match($this->shared->regex_capability, $input)) {
            add_settings_error('daam_capabilities_export_menu', 'daam_capabilities_export_menu',
                esc_attr__('Please enter a valid capability in the "Export Menu" option.', 'daam'));
            $output = get_option('daam_capabilities_export_menu');
        } else {
            $output = $input;
        }

        return trim($output);

    }

    public function capabilities_maintenance_menu_callback($args)
    {

        $html = '<input type="text" id="daam_capabilities_maintenance_menu" name="daam_capabilities_maintenance_menu" class="regular-text" value="' . esc_attr(get_option("daam_capabilities_maintenance_menu")) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('The capability required to get access on the "Export" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function capabilities_maintenance_menu_validation($input)
    {

        if ( ! preg_match($this->shared->regex_capability, $input)) {
            add_settings_error('daam_capabilities_maintenance_menu', 'daam_capabilities_maintenance_menu',
                esc_attr__('Please enter a valid capability in the "Maintenance Menu" option.', 'daam'));
            $output = get_option('daam_capabilities_maintenance_menu');
        } else {
            $output = $input;
        }

        return trim($output);

    }

    //pagination options callbacks and validations ---------------------------------------------------------------------
    public function pagination_statistics_menu_callback($args)
    {

        $html = '<select id="daam-pagination-statistics-menu" name="daam_pagination_statistics_menu" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_statistics_menu")), 10,
                false) . ' value="10">10</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_statistics_menu")), 20,
                false) . ' value="20">20</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_statistics_menu")), 30,
                false) . ' value="30">30</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_statistics_menu")), 40,
                false) . ' value="40">40</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_statistics_menu")), 50,
                false) . ' value="50">50</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_statistics_menu")), 60,
                false) . ' value="60">60</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_statistics_menu")), 70,
                false) . ' value="70">70</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_statistics_menu")), 80,
                false) . ' value="80">80</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_statistics_menu")), 90,
                false) . ' value="90">90</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_statistics_menu")), 100,
                false) . ' value="100">100</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('This options determines the number of elements per page displayed in the "Statistics" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function pagination_statistics_menu_validation($input)
    {

        return intval($input, 10);

    }

    public function pagination_autolinks_menu_callback($args)
    {

        $html = '<select id="daam-pagination-autolinks-menu" name="daam_pagination_autolinks_menu" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_autolinks_menu")), 10,
                false) . ' value="10">10</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_autolinks_menu")), 20,
                false) . ' value="20">20</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_autolinks_menu")), 30,
                false) . ' value="30">30</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_autolinks_menu")), 40,
                false) . ' value="40">40</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_autolinks_menu")), 50,
                false) . ' value="50">50</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_autolinks_menu")), 60,
                false) . ' value="60">60</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_autolinks_menu")), 70,
                false) . ' value="70">70</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_autolinks_menu")), 80,
                false) . ' value="80">80</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_autolinks_menu")), 90,
                false) . ' value="90">90</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_autolinks_menu")), 100,
                false) . ' value="100">100</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('This options determines the number of elements per page displayed in the "Autolinks" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function pagination_autolinks_menu_validation($input)
    {

        return intval($input, 10);

    }

    public function pagination_categories_menu_callback($args)
    {

        $html = '<select id="daam-pagination-categories-menu" name="daam_pagination_categories_menu" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_categories_menu")), 10,
                false) . ' value="10">10</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_categories_menu")), 20,
                false) . ' value="20">20</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_categories_menu")), 30,
                false) . ' value="30">30</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_categories_menu")), 40,
                false) . ' value="40">40</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_categories_menu")), 50,
                false) . ' value="50">50</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_categories_menu")), 60,
                false) . ' value="60">60</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_categories_menu")), 70,
                false) . ' value="70">70</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_categories_menu")), 80,
                false) . ' value="80">80</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_categories_menu")), 90,
                false) . ' value="90">90</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_categories_menu")), 100,
                false) . ' value="100">100</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('This options determines the number of elements per page displayed in the "Categories" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function pagination_categories_menu_validation($input)
    {

        return intval($input, 10);

    }

    public function pagination_term_groups_menu_callback($args)
    {

        $html = '<select id="daam-pagination-autolinks-menu" name="daam_pagination_term_groups_menu" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_term_groups_menu")), 10,
                false) . ' value="10">10</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_term_groups_menu")), 20,
                false) . ' value="20">20</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_term_groups_menu")), 30,
                false) . ' value="30">30</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_term_groups_menu")), 40,
                false) . ' value="40">40</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_term_groups_menu")), 50,
                false) . ' value="50">50</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_term_groups_menu")), 60,
                false) . ' value="60">60</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_term_groups_menu")), 70,
                false) . ' value="70">70</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_term_groups_menu")), 80,
                false) . ' value="80">80</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_term_groups_menu")), 90,
                false) . ' value="90">90</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_term_groups_menu")), 100,
                false) . ' value="100">100</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('This options determines the number of elements per page displayed in the "Term Groups" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function pagination_term_groups_menu_validation($input)
    {

        return intval($input, 10);

    }

    public function pagination_tracking_menu_callback($args)
    {

        $html = '<select id="daam-pagination-tracking-menu" name="daam_pagination_tracking_menu" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_tracking_menu")), 10,
                false) . ' value="10">10</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_tracking_menu")), 20,
                false) . ' value="20">20</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_tracking_menu")), 30,
                false) . ' value="30">30</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_tracking_menu")), 40,
                false) . ' value="40">40</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_tracking_menu")), 50,
                false) . ' value="50">50</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_tracking_menu")), 60,
                false) . ' value="60">60</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_tracking_menu")), 70,
                false) . ' value="70">70</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_tracking_menu")), 80,
                false) . ' value="80">80</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_tracking_menu")), 90,
                false) . ' value="90">90</option>';
        $html .= '<option ' . selected(intval(get_option("daam_pagination_tracking_menu")), 100,
                false) . ' value="100">100</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('This options determines the number of elements per page displayed in the "Tracking" menu.',
                'daam') . '"></div>';

        echo $html;

    }

    public function pagination_tracking_menu_validation($input)
    {

        return intval($input, 10);

    }

    //advanced options callbacks and validations ---------------------------------------------------------------------
    public function advanced_enable_autolinks_callback($args)
    {

        $html = '<select id="daam-advanced-enable-autolinks" name="daam_advanced_enable_autolinks" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_advanced_enable_autolinks")), 0,
                false) . ' value="0">' . esc_attr__('No', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_advanced_enable_autolinks")), 1,
                false) . ' value="1">' . esc_attr__('Yes', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('This option determines the default status of the "Enable Autolinks" option available in the "Autolinks Manager" meta box.',
                'daam') . '"></div>';

        echo $html;

    }

    public function advanced_enable_autolinks_validation($input)
    {

        return intval($input, 10) == 1 ? '1' : '0';

    }

    public function advanced_filter_priority_callback($args)
    {

        $html = '<input maxlength="11" type="text" id="daam_advanced_filter_priority" name="daam_advanced_filter_priority" class="regular-text" value="' . intval(get_option("daam_advanced_filter_priority"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('This option determines the priority of the filter used to apply the autolinks. A lower number corresponds with an earlier execution.',
                'daam') . '"></div>';
        echo $html;

    }

    public function advanced_filter_priority_validation($input)
    {

        if (intval($input, 10) < -2147483648 or intval($input, 10) > 2147483646) {
            add_settings_error('daam_advanced_filter_priority', 'daam_advanced_filter_priority',
                esc_attr__('Please enter a number from -2147483648 to 2147483646 in the "Filter Priority" option.',
                    'daam'));
            $output = get_option('daam_advanced_filter_priority');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }

    public function advanced_enable_test_mode_callback($args)
    {

        $html = '<select id="daam-advanced-enable-test-mode" name="daam_advanced_enable_test_mode" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_advanced_enable_test_mode")), 0,
                false) . ' value="0">' . esc_attr__('No', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_advanced_enable_test_mode")), 1,
                false) . ' value="1">' . esc_attr__('Yes', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('With the test mode enabled the autolinks will be applied to your posts, pages or custom post types only if the user that is requesting the posts, pages or custom post types has the capability defined with the "Autolinks Menu" option.',
                'daam') . '"></div>';

        echo $html;

    }

    public function advanced_enable_test_mode_validation($input)
    {

        return intval($input, 10) == 1 ? '1' : '0';

    }

    public function advanced_random_prioritization_callback($args)
    {

        $html = '<select id="daam-advanced-random-prioritization" name="daam_advanced_random_prioritization" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_advanced_random_prioritization")), 0,
                false) . ' value="0">' . esc_attr__('No', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_advanced_random_prioritization")), 1,
                false) . ' value="1">' . esc_attr__('Yes', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__("With this option enabled the order used to apply the autolinks with the same priority is randomized on a per-post basis. With this option disabled the order used to apply the autolinks with the same priority is the order used to add them in the back-end. It's recommended to enable this option for a better distribution of the autolinks.",
                'daam') . '"></div>';

        echo $html;

    }

    public function advanced_random_prioritization_validation($input)
    {

        return intval($input, 10) == 1 ? '1' : '0';

    }

    public function advanced_ignore_self_autolinks_callback($args)
    {

        $html = '<select id="daam-advanced-ignore-self-autolinks" name="daam_advanced_ignore_self_autolinks" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_advanced_ignore_self_autolinks")), 0,
                false) . ' value="0">' . esc_attr__('No', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_advanced_ignore_self_autolinks")), 1,
                false) . ' value="1">' . esc_attr__('Yes', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('With this option enabled, the autolinks which have as a target the post where they should be applied, will be ignored.',
                'daam') . '"></div>';

        echo $html;

    }

    public function advanced_ignore_self_autolinks_validation($input)
    {

        return intval($input, 10) == 1 ? '1' : '0';

    }

    public function advanced_categories_and_tags_verification_callback($args)
    {

        $html = '<select id="daam-advanced-categories-and-tags-verification" name="daam_advanced_categories_and_tags_verification" class="daext-display-none">';
        $html .= '<option ' . selected(get_option("daam_advanced_categories_and_tags_verification"), 'post',
                false) . ' value="post">' . esc_attr__('Post', 'daam') . '</option>';
        $html .= '<option ' . selected(get_option("daam_advanced_categories_and_tags_verification"), 'any',
                false) . ' value="any">' . esc_attr__('Any', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('If "Post" is selected categories and tags will be verified only in the "post" post type, if "Any" is selected categories and tags will be verified in any post type.',
                'daam') . '"></div>';

        echo $html;

    }

    public function advanced_categories_and_tags_verification_validation($input)
    {

        switch ($input) {
            case 'post':
                return 'post';
            default:
                return 'any';
        }

    }

    public function advanced_general_limit_mode_callback($args)
    {

        $html = '<select id="daam-advanced-general-limit-mode" name="daam_advanced_general_limit_mode" class="daext-display-none">';
        $html .= '<option ' . selected(intval(get_option("daam_advanced_general_limit_mode")), 0,
                false) . ' value="0">' . esc_attr__('Auto', 'daam') . '</option>';
        $html .= '<option ' . selected(intval(get_option("daam_advanced_general_limit_mode")), 1,
                false) . ' value="1">' . esc_attr__('Manual', 'daam') . '</option>';
        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('If "Auto" is selected the maximum number of autolinks per post is automatically generated based on the length of the post, in this case the "General Limit (Characters per Autolinks)" option is used. If "Manual" is selected the maximum number of autolinks per post is equal to the value of the "General Limit (Amount)" option.',
                'daam') . '"></div>';

        echo $html;

    }

    public function advanced_general_limit_mode_validation($input)
    {

        return intval($input, 10) == 1 ? '1' : '0';

    }

    public function advanced_general_limit_characters_per_autolink_callback($args)
    {

        $html = '<input maxlength="7" type="text" id="daam_advanced_general_limit_characters_per_autolink" name="daam_advanced_general_limit_characters_per_autolink" class="regular-text" value="' . intval(get_option("daam_advanced_general_limit_characters_per_autolink"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('This value is used to automatically determine the maximum number of autolinks per post when the "General Limit Mode" option is set to "Auto".',
                'daam') . '"></div>';
        echo $html;

    }

    public function advanced_general_limit_characters_per_autolink_validation($input)
    {

        if ( ! preg_match($this->shared->regex_number_ten_digits, $input) or intval($input, 10) < 1 or intval($input,
                10) > 1000000) {
            add_settings_error('daam_advanced_general_limit_characters_per_autolink',
                'daam_advanced_general_limit_characters_per_autolink',
                esc_attr__('Please enter a number from 1 to 1000000 in the "General Limit (Characters per Autolink)" option.',
                    'daam'));
            $output = get_option('daam_advanced_general_limit_characters_per_autolink');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }

    public function advanced_general_limit_amount_callback($args)
    {

        $html = '<input maxlength="7" type="text" id="daam_advanced_general_limit_amount" name="daam_advanced_general_limit_amount" class="regular-text" value="' . intval(get_option("daam_advanced_general_limit_amount"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('This value determines the maximum number of autolinks per post when the "General Limit Mode" option is set to "Manual".',
                'daam') . '"></div>';
        echo $html;

    }

    public function advanced_general_limit_amount_validation($input)
    {

        if ( ! preg_match($this->shared->regex_number_ten_digits, $input) or intval($input, 10) < 1 or intval($input,
                10) > 1000000) {
            add_settings_error('daam_advanced_general_limit_amount', 'daam_advanced_general_limit_amount',
                esc_attr__('Please enter a number from 1 to 1000000 in the "General Limit (Amount)" option.', 'daam'));
            $output = get_option('daam_advanced_general_limit_amount');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }

    public function advanced_same_url_limit_callback($args)
    {

        $html = '<input maxlength="7" type="text" id="daam_advanced_same_url_limit" name="daam_advanced_same_url_limit" class="regular-text" value="' . intval(get_option("daam_advanced_same_url_limit"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('This option limits the number of autolinks with the same URL to a specific value.',
                'daam') . '"></div>';
        echo $html;

    }

    public function advanced_same_url_limit_validation($input)
    {

        if ( ! preg_match($this->shared->regex_number_ten_digits, $input) or intval($input, 10) < 1 or intval($input,
                10) > 1000000) {
            add_settings_error('daam_advanced_same_url_limit', 'daam_advanced_same_url_limit',
                esc_attr__('Please enter a number from 1 to 1000000 in the "Same URL Limit" option.', 'daam'));
            $output = get_option('daam_advanced_same_url_limit');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }

    public function advanced_supported_terms_callback($args)
    {

        $html = '<input maxlength="7" type="text" id="daam_advanced_supported_terms" name="daam_advanced_supported_terms" class="regular-text" value="' . intval(get_option("daam_advanced_supported_terms"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('This option determines the maximum number of terms supported in a single term group.',
                'daam') . '"></div>';
        echo $html;

    }

    public function advanced_supported_terms_validation($input)
    {

        if ( ! preg_match($this->shared->regex_number_ten_digits, $input) or intval($input, 10) < 1 or intval($input,
                10) > 50) {
            add_settings_error('daam_advanced_supported_terms', 'daam_advanced_supported_terms',
                esc_attr__('Please enter a number from 1 to 50 in the "Supported Terms" option.', 'daam'));
            $output = get_option('daam_advanced_supported_terms');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }

    public function advanced_wizard_rows_callback($args)
    {

        $html = '<input maxlength="7" type="text" id="daam_advanced_wizard_rows" name="daam_advanced_wizard_rows" class="regular-text" value="' . intval(get_option("daam_advanced_wizard_rows"),
                10) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr__('This option determines the number of rows available in the table of the Wizard menu.',
                'daam') . '"></div>';
        echo $html;

    }

    public function advanced_wizard_rows_validation($input)
    {

        if ( ! preg_match($this->shared->regex_number_ten_digits, $input) or intval($input, 10) < 100 or intval($input,
                10) > 10000) {
            add_settings_error('daam_advanced_wizard_rows', 'daam_advanced_wizard_rows',
                esc_attr__('Please enter a number from 100 to 10000 in the "Wizard Rows" option.', 'daam'));
            $output = get_option('daam_advanced_wizard_rows');
        } else {
            $output = $input;
        }

        return intval($output, 10);

    }

    public function advanced_protected_tags_callback($args)
    {

        $advanced_protected_tags_a = get_option("daam_advanced_protected_tags");

        $html = '<select id="daam-advanced-protected-tags" name="daam_advanced_protected_tags[]" class="daext-display-none" multiple>';

        $list_of_html_tags = array(
            'a',
            'abbr',
            'acronym',
            'address',
            'applet',
            'area',
            'article',
            'aside',
            'audio',
            'b',
            'base',
            'basefont',
            'bdi',
            'bdo',
            'big',
            'blockquote',
            'body',
            'br',
            'button',
            'canvas',
            'caption',
            'center',
            'cite',
            'code',
            'col',
            'colgroup',
            'datalist',
            'dd',
            'del',
            'details',
            'dfn',
            'dir',
            'div',
            'dl',
            'dt',
            'em',
            'embed',
            'fieldset',
            'figcaption',
            'figure',
            'font',
            'footer',
            'form',
            'frame',
            'frameset',
            'h1',
            'h2',
            'h3',
            'h4',
            'h5',
            'h6',
            'head',
            'header',
            'hgroup',
            'hr',
            'html',
            'i',
            'iframe',
            'img',
            'input',
            'ins',
            'kbd',
            'keygen',
            'label',
            'legend',
            'li',
            'link',
            'map',
            'mark',
            'menu',
            'meta',
            'meter',
            'nav',
            'noframes',
            'noscript',
            'object',
            'ol',
            'optgroup',
            'option',
            'output',
            'p',
            'param',
            'pre',
            'progress',
            'q',
            'rp',
            'rt',
            'ruby',
            's',
            'samp',
            'script',
            'section',
            'select',
            'small',
            'source',
            'span',
            'strike',
            'strong',
            'style',
            'sub',
            'summary',
            'sup',
            'table',
            'tbody',
            'td',
            'textarea',
            'tfoot',
            'th',
            'thead',
            'time',
            'title',
            'tr',
            'tt',
            'u',
            'ul',
            'var',
            'video',
            'wbr'
        );

        foreach ($list_of_html_tags as $key => $tag) {
            $html .= '<option value="' . $tag . '" ' . $this->shared->selected_array($advanced_protected_tags_a,
                    $tag) . '>' . $tag . '</option>';
        }

        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('With this option you are able to determine in which HTML tags the autolinks should not be applied.',
                'daam') . '"></div>';

        echo $html;

    }

    public function advanced_protected_tags_validation($input)
    {

        if (is_array($input)) {
            return $input;
        } else {
            return '';
        }

    }

    public function advanced_protected_gutenberg_blocks_callback($args)
    {

        $advanced_protected_gutenberg_blocks_a = get_option("daam_advanced_protected_gutenberg_blocks");

        $html = '<select id="daam-advanced-protected-gutenberg-embeds" name="daam_advanced_protected_gutenberg_blocks[]" class="daext-display-none" multiple>';

        $html .= '<option value="paragraph" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'paragraph') . '>' . esc_attr__('Paragraph', 'daam') . '</option>';
        $html .= '<option value="image" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'image') . '>' . esc_attr__('Image', 'daam') . '</option>';
        $html .= '<option value="heading" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'heading') . '>' . esc_attr__('Heading', 'daam') . '</option>';
        $html .= '<option value="gallery" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'gallery') . '>' . esc_attr__('Gallery', 'daam') . '</option>';
        $html .= '<option value="list" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'list') . '>' . esc_attr__('List', 'daam') . '</option>';
        $html .= '<option value="quote" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'quote') . '>' . esc_attr__('Quote', 'daam') . '</option>';
        $html .= '<option value="audio" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'audio') . '>' . esc_attr__('Audio', 'daam') . '</option>';
        $html .= '<option value="cover-image" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'cover-image') . '>' . esc_attr__('Cover Image', 'daam') . '</option>';
        $html .= '<option value="subhead" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'subhead') . '>' . esc_attr__('Subhead', 'daam') . '</option>';
        $html .= '<option value="video" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'video') . '>' . esc_attr__('Video', 'daam') . '</option>';
        $html .= '<option value="code" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'code') . '>' . esc_attr__('Code', 'daam') . '</option>';
        $html .= '<option value="html" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'html') . '>' . esc_attr__('Custom HTML', 'daam') . '</option>';
        $html .= '<option value="preformatted" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'preformatted') . '>' . esc_attr__('Preformatted', 'daam') . '</option>';
        $html .= '<option value="pullquote" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'pullquote') . '>' . esc_attr__('Pullquote', 'daam') . '</option>';
        $html .= '<option value="table" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'table') . '>' . esc_attr__('Table', 'daam') . '</option>';
        $html .= '<option value="verse" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'verse') . '>' . esc_attr__('Verse', 'daam') . '</option>';
        $html .= '<option value="button" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'button') . '>' . esc_attr__('Button', 'daam') . '</option>';
        $html .= '<option value="columns" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'columns') . '>' . esc_attr__('Columns (Experimentals)', 'daam') . '</option>';
        $html .= '<option value="more" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'more') . '>' . esc_attr__('More', 'daam') . '</option>';
        $html .= '<option value="nextpage" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'nextpage') . '>' . esc_attr__('Page Break', 'daam') . '</option>';
        $html .= '<option value="separator" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'separator') . '>' . esc_attr__('Separator', 'daam') . '</option>';
        $html .= '<option value="spacer" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'spacer') . '>' . esc_attr__('Spacer', 'daam') . '</option>';
        $html .= '<option value="text-columns" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'text-columns') . '>' . esc_attr__('Text Columnns', 'daam') . '</option>';
        $html .= '<option value="shortcode" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'shortcode') . '>' . esc_attr__('Shortcode', 'daam') . '</option>';
        $html .= '<option value="categories" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'categories') . '>' . esc_attr__('Categories', 'daam') . '</option>';
        $html .= '<option value="latest-posts" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'latest-posts') . '>' . esc_attr__('Latest Posts', 'daam') . '</option>';
        $html .= '<option value="embed" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'embed') . '>' . esc_attr__('Embed', 'daam') . '</option>';
        $html .= '<option value="core-embed/twitter" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/twitter') . '>' . esc_attr__('Twitter', 'daam') . '</option>';
        $html .= '<option value="core-embed/youtube" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/youtube') . '>' . esc_attr__('YouTube', 'daam') . '</option>';
        $html .= '<option value="core-embed/facebook" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/facebook') . '>' . esc_attr__('Facebook', 'daam') . '</option>';
        $html .= '<option value="core-embed/instagram" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/instagram') . '>' . esc_attr__('Instagram', 'daam') . '</option>';
        $html .= '<option value="core-embed/wordpress" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/wordpress') . '>' . esc_attr__('WordPress', 'daam') . '</option>';
        $html .= '<option value="core-embed/soundcloud" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/soundcloud') . '>' . esc_attr__('SoundCloud', 'daam') . '</option>';
        $html .= '<option value="core-embed/spotify" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/spotify') . '>' . esc_attr__('Spotify', 'daam') . '</option>';
        $html .= '<option value="core-embed/flickr" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/flickr') . '>' . esc_attr__('Flickr', 'daam') . '</option>';
        $html .= '<option value="core-embed/vimeo" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/vimeo') . '>' . esc_attr__('Vimeo', 'daam') . '</option>';
        $html .= '<option value="core-embed/animoto" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/animoto') . '>' . esc_attr__('Animoto', 'daam') . '</option>';
        $html .= '<option value="core-embed/cloudup" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/cloudup') . '>' . esc_attr__('Cloudup', 'daam') . '</option>';
        $html .= '<option value="core-embed/collegehumor" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/collegehumor') . '>' . esc_attr__('CollegeHumor', 'daam') . '</option>';
        $html .= '<option value="core-embed/dailymotion" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/dailymotion') . '>' . esc_attr__('DailyMotion', 'daam') . '</option>';
        $html .= '<option value="core-embed/funnyordie" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/funnyordie') . '>' . esc_attr__('Funny or Die', 'daam') . '</option>';
        $html .= '<option value="core-embed/hulu" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/hulu') . '>' . esc_attr__('Hulu', 'daam') . '</option>';
        $html .= '<option value="core-embed/imgur" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/imgur') . '>' . esc_attr__('Imgur', 'daam') . '</option>';
        $html .= '<option value="core-embed/issuu" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/issuu') . '>' . esc_attr__('Issuu', 'daam') . '</option>';
        $html .= '<option value="core-embed/kickstarter" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/kickstarter') . '>' . esc_attr__('Kickstarter', 'daam') . '</option>';
        $html .= '<option value="core-embed/meetup-com" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/meetup-com') . '>' . esc_attr__('Meetup.com', 'daam') . '</option>';
        $html .= '<option value="core-embed/mixcloud" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/mixcloud') . '>' . esc_attr__('Mixcloud', 'daam') . '</option>';
        $html .= '<option value="core-embed/photobucket" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/photobucket') . '>' . esc_attr__('Photobucket', 'daam') . '</option>';
        $html .= '<option value="core-embed/polldaddy" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/polldaddy') . '>' . esc_attr__('Polldaddy', 'daam') . '</option>';
        $html .= '<option value="core-embed/reddit" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/reddit') . '>' . esc_attr__('Reddit', 'daam') . '</option>';
        $html .= '<option value="core-embed/reverbnation" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/reverbnation') . '>' . esc_attr__('ReverbNation', 'daam') . '</option>';
        $html .= '<option value="core-embed/screencast" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/screencast') . '>' . esc_attr__('Screencast', 'daam') . '</option>';
        $html .= '<option value="core-embed/scribd" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/scribd') . '>' . esc_attr__('Scribd', 'daam') . '</option>';
        $html .= '<option value="core-embed/slideshare" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/slideshare') . '>' . esc_attr__('Slideshare', 'daam') . '</option>';
        $html .= '<option value="core-embed/smugmug" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/smugmug') . '>' . esc_attr__('SmugMug', 'daam') . '</option>';
        $html .= '<option value="core-embed/speaker" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/speaker') . '>' . esc_attr__('Speaker', 'daam') . '</option>';
        $html .= '<option value="core-embed/ted" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/ted') . '>' . esc_attr__('Ted', 'daam') . '</option>';
        $html .= '<option value="core-embed/tumblr" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/tumblr') . '>' . esc_attr__('Tumblr', 'daam') . '</option>';
        $html .= '<option value="core-embed/videopress" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/videopress') . '>' . esc_attr__('VideoPress', 'daam') . '</option>';
        $html .= '<option value="core-embed/wordpress-tv" ' . $this->shared->selected_array($advanced_protected_gutenberg_blocks_a,
                'core-embed/wordpress-tv') . '>' . esc_attr__('WordPress.tv', 'daam') . '</option>';

        $html .= '</select>';
        $html .= '<div class="help-icon" title="' . esc_attr__('With this option you are able to determine in which Gutenberg blocks the autolinks should not be applied.',
                'daam') . '"></div>';

        echo $html;

    }

    public function advanced_protected_gutenberg_blocks_validation($input)
    {

        if (is_array($input)) {
            return $input;
        } else {
            return '';
        }

    }

    public function advanced_protected_gutenberg_custom_blocks_callback($args)
    {

        $html = '<input type="text" id="daam_advanced_protected_gutenberg_custom_blocks" name="daam_advanced_protected_gutenberg_custom_blocks" class="regular-text" value="' . esc_attr(get_option("daam_advanced_protected_gutenberg_custom_blocks")) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr(__('Enter a list of Gutenberg custom blocks, separated by a comma.',
                'daam')) . '"></div>';

        echo $html;

    }

    public function advanced_protected_gutenberg_custom_blocks_validation($input)
    {

        if (strlen(trim($input)) > 0 and ! preg_match($this->shared->regex_list_of_gutenberg_blocks, $input)) {
            add_settings_error('daam_advanced_protected_gutenberg_custom_blocks',
                'daam_advanced_protected_gutenberg_custom_blocks',
                __('Please enter a valid list of Gutenberg custom blocks separated by a comma in the "Protected Gutenberg Custom Blocks" option.',
                    'daam'));
            $output = get_option('daam_advanced_protected_gutenberg_custom_blocks');
        } else {
            $output = $input;
        }

        return $output;

    }

    public function advanced_protected_gutenberg_custom_void_blocks_callback($args)
    {

        $html = '<input type="text" id="daam_advanced_protected_gutenberg_custom_void_blocks" name="daam_advanced_protected_gutenberg_custom_void_blocks" class="regular-text" value="' . esc_attr(get_option("daam_advanced_protected_gutenberg_custom_void_blocks")) . '" />';
        $html .= '<div class="help-icon" title="' . esc_attr(__('Enter a list of Gutenberg custom void blocks, separated by a comma.',
                'daam')) . '"></div>';

        echo $html;

    }

    public function advanced_protected_gutenberg_custom_void_blocks_validation($input)
    {

        if (strlen(trim($input)) > 0 and ! preg_match($this->shared->regex_list_of_gutenberg_blocks, $input)) {
            add_settings_error('daam_advanced_protected_gutenberg_custom_void_blocks',
                'daam_advanced_protected_gutenberg_custom_void_blocks',
                __('Please enter a valid list of Gutenberg custom void blocks separated by a comma in the "Protected Gutenberg Custom Void Blocks" option.',
                    'daam'));
            $output = get_option('daam_advanced_protected_gutenberg_custom_void_blocks');
        } else {
            $output = $input;
        }

        return $output;

    }

    /*
     * The click on the "Export" button available in the "Export" menu is intercepted and the method that generates the
     * downloadable XML file is called.
     */
    public function export_xml_controller()
    {

        /*
         * Intercept requests that come from the "Export" button of the "Autolinks Manager -> Export" menu and generate
         * the downloadable XML file.
         */
        if (isset($_POST['daam_export'])) {

            //verify capability
            if ( ! current_user_can(get_option($this->shared->get('slug') . "_capabilities_export_menu"))) {
                wp_die(esc_attr__('You do not have sufficient permissions to access this page.'));
            }

            //generate the header of the XML file
            header('Content-Encoding: UTF-8');
            header('Content-type: text/xml; charset=UTF-8');
            header("Content-Disposition: attachment; filename=autolinks-manager-" . time() . ".xml");
            header("Pragma: no-cache");
            header("Expires: 0");

            //generate initial part of the XML file
            $out = '<?xml version="1.0" encoding="UTF-8" ?>';
            $out .= '<root>';

            //Generate the XML of the various db tables
            $out .= $this->shared->convert_db_table_to_xml('autolink', 'autolink_id');
            $out .= $this->shared->convert_db_table_to_xml('category', 'category_id');
            $out .= $this->shared->convert_db_table_to_xml('term_group', 'term_group_id');

            //generate the final part of the XML file
            $out .= '</root>';

            echo $out;
            die();

        }

    }

    //meta box ---------------------------------------------------------------------------------------------------------
    public function create_meta_box()
    {

        if (current_user_can(get_option($this->shared->get('slug') . "_capabilities_editor_sidebar"))) {

            add_meta_box('daam-autolinks-manager',
                esc_attr__('Autolinks Manager', 'daam'),
                array($this, 'autolinks_manager_meta_box_callback'),
                null,
                'normal',
                'high',

                /*
                 * Reference:
                 *
                 * https://make.wordpress.org/core/2018/11/07/meta-box-compatibility-flags/
                 */
                array(

                        /*
                         * It's not confirmed that this meta box works in the block editor.
                         */
                        '__block_editor_compatible_meta_box' => false,

                        /*
                         * This meta box should only be loaded in the classic editor interface, and the block editor
                         * should not display it.
                         */
                        '__back_compat_meta_box' => true

                ));

        }

    }

    public function autolinks_manager_meta_box_callback($post)
    {

        $enable_autolinks = get_post_meta($post->ID, '_daam_enable_autolinks', true);

        //if the $enable_autolinks is empty use the Enable Autolinks option as a default value
        if (mb_strlen(trim($enable_autolinks)) === 0) {
            $enable_autolinks = get_option($this->shared->get('slug') . '_advanced_enable_autolinks');
        }

        ?>

        <table class="form-table table-autolinks-manager">
            <tbody>

            <tr>
                <th scope="row"><label><?php esc_attr_e('Enable Autolinks:', 'daam'); ?></label></th>
                <td>
                    <select id="daam-enable-autolinks" name="daam_enable_autolinks">
                        <option <?php selected(intval($enable_autolinks, 10), 0); ?> value="0"><?php esc_attr_e('No',
                                'daam'); ?></option>
                        <option <?php selected(intval($enable_autolinks, 10), 1); ?> value="1"><?php esc_attr_e('Yes',
                                'daam'); ?></option>
                    </select>
                </td>
            </tr>

            </tbody>
        </table>

        <?php

        //Use nonce for verification
        wp_nonce_field(plugin_basename(__FILE__), 'daam_nonce');

    }

    //Save the Autolinks Options meta data
    public function save_meta_box($post_id)
    {

        //Security Verifications Start ---------------------------------------------------------------------------------

        //Verify if this is an auto save routine. Don't do anything if our form has not been submitted.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        /*
         * Verify if this came from the our screen and with proper authorization, because save_post can be triggered at
         * other times/
         */
        if ( ! isset($_POST['daam_nonce']) || ! wp_verify_nonce($_POST['daam_nonce'], plugin_basename(__FILE__))) {
            return;
        }

        //Verify the capability
        if ( ! current_user_can(get_option($this->shared->get('slug') . "_capabilities_autolinks_menu"))) {
            return;
        }

        //Security Verifications End -----------------------------------------------------------------------------------

        //Save the "Enable Autolinks"
        update_post_meta($post_id, '_daam_enable_autolinks', intval($_POST['daam_enable_autolinks'], 10));

    }

    /*
     * The "Export CSV" buttons and/or icons available in the Statistics and Tracking menus are intercepted and the
     * proper method that generates on the fly the specific downloadable CSV file is called.
     */
    public function export_csv_controller()
    {

        /*
         * Intercept requests that come from the "Export CSV" button from the "Statistics" menu and generate the
         * downloadable CSV file with the statistics_menu_export_csv() method.
         */
        if (isset($_GET['page']) and
            $_GET['page'] == 'daam-statistics' and
            isset($_POST['export_csv'])) {
            $this->statistics_menu_export_csv();
        }

        /*
         * Intercept requests that come from the "Export CSV" button of the "Statistics" menu and generate the
         * downloadable CSV file with the tracking_menu_export_csv() method.
         */
        if (isset($_GET['page']) and
            $_GET['page'] == 'daam-tracking' and
            isset($_POST['export_csv'])) {
            $this->tracking_menu_export_csv();
        }

    }

    /*
     * Generates the downloadable CSV file with all the items available in the Statistics menu.
     */
    public function statistics_menu_export_csv()
    {

        //verify capability
        if ( ! current_user_can(get_option($this->shared->get('slug') . '_capabilities_statistics_menu'))) {
            die();
        }

        //Set the PHP "Max Execution Time" and "Memory Limit" based on the values defined in the options
        $this->shared->set_met_and_ml();

        //get the data from the db table
        global $wpdb;
        $table_name = $wpdb->prefix . $this->shared->get('slug') . "_statistic";
        $results    = $wpdb->get_results("SELECT * FROM $table_name ORDER BY post_id DESC", ARRAY_A);

        //if there are data generate the csv header and content
        if (count($results) > 0) {

            $csv_content = '';
            $new_line    = "\n";

            //set the csv header
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header("Content-Disposition: attachment; filename=statistics-" . time() . ".csv");
            header("Pragma: no-cache");
            header("Expires: 0");

            //set headings
            $csv_content .= '"' . $this->esc_csv(__('Post ID', 'daam')) . '",';
            $csv_content .= '"' . $this->esc_csv(__('Post', 'daam')) . '",';
            $csv_content .= '"' . $this->esc_csv(__('Content Length', 'daam')) . '",';
            $csv_content .= '"' . $this->esc_csv(__('Autolinks', 'daam')) . '",';
            $csv_content .= '"' . $this->esc_csv(__('Clicks', 'daam')) . '",';
            $csv_content .= $new_line;

            //set column content
            foreach ($results as $result) {
                $csv_content .= '"' . $this->esc_csv($result['post_id']) . '",';
                if (get_post_status($result['post_id']) !== false) {
                    $post_title = get_post_field('post_title', $result['post_id'], 'raw');
                } else {
                    $post_title = esc_attr__('Not Available', 'daam');
                }
                $csv_content .= '"' . $this->esc_csv($post_title) . '",';
                $csv_content .= '"' . $this->esc_csv($result['content_length']) . '",';
                $csv_content .= '"' . $this->esc_csv($result['auto_links']) . '",';
                $csv_content .= '"' . $this->esc_csv($result['auto_links_visits']) . '",';
                $csv_content .= $new_line;
            }

        } else {
            return false;
        }

        echo $csv_content;
        die();

    }

    /*
     * Generates the downloadable CSV file with all the items available in the Tracking menu.
     */
    private function tracking_menu_export_csv()
    {

        //verify capability
        if ( ! current_user_can(get_option($this->shared->get('slug') . "_capabilities_tracking_menu"))) {
            die();
        }

        //Set the PHP "Max Execution Time" and "Memory Limit" based on the values defined in the options
        $this->shared->set_met_and_ml();

        //get the data from the db table
        global $wpdb;
        $table_name = $wpdb->prefix . $this->shared->get('slug') . "_tracking";
        $results    = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date DESC", ARRAY_A);

        //if there are data generate the csv header and content
        if (count($results) > 0) {

            $csv_content = '';
            $new_line    = "\n";

            //set the csv header
            header('Content-Encoding: UTF-8');
            header('Content-type: text/csv; charset=UTF-8');
            header("Content-Disposition: attachment; filename=tracking-" . time() . ".csv");
            header("Pragma: no-cache");
            header("Expires: 0");

            //set headings
            $csv_content .= '"' . $this->esc_csv(__('Tracking ID', 'daam')) . '",';
            $csv_content .= '"' . $this->esc_csv(__('User IP', 'daam')) . '",';
            $csv_content .= '"' . $this->esc_csv(__('Date', 'daam')) . '",';
            $csv_content .= '"' . $this->esc_csv(__('Autolink', 'daam')) . '",';
            $csv_content .= '"' . $this->esc_csv(__('Post', 'daam')) . '"';
            $csv_content .= $new_line;

            //set column content
            foreach ($results as $result) {

                $csv_content .= '"' . $this->esc_csv($result['tracking_id']) . '",';
                $csv_content .= '"' . $this->esc_csv(stripslashes($result['user_ip'])) . '",';
                $csv_content .= '"' . $this->esc_csv(mysql2date(get_option('date_format'), $result['date'])) . '",';

                $autolink_obj = $this->shared->get_autolink_object($result['autolink_id']);
                if (isset($autolink_obj->name)) {
                    $csv_content .= '"' . $this->esc_csv(stripslashes($autolink_obj->name)) . '",';
                } else {
                    $csv_content .= '"' . esc_attr__('Not Available', 'daam') . '",';
                }

                if (get_post_status($result['post_id']) !== false) {
                    $csv_content .= '"' . $this->esc_csv(get_post_field('post_title', $result['post_id'], 'raw')) . '"';
                } else {
                    $csv_content .= '"' . esc_attr__('Not Available', 'daam') . '"';
                }

                $csv_content .= $new_line;

            }

        } else {
            return false;
        }

        echo $csv_content;
        die();

    }

    /*
     * Escape the double quotes of the $content string, so the returned string can be used in CSV fields enclosed by
     * double quotes.
     *
     * @param $content The unescape content (Ex: She said "No!")
     * @return string The escaped content (Ex: She said ""No!"")
     */
    private function esc_csv($content)
    {
        return str_replace('"', '""', $content);
    }

}