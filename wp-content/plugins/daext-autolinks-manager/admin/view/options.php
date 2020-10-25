<?php

if ( ! current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient capabilities to access this page.'));
}

?>

<div class="wrap">

    <h2><?php esc_attr_e('Autolinks Manager - Options', 'daam'); ?></h2>

    <?php

    //settings errors
    if (isset($_GET['settings-updated']) and $_GET['settings-updated'] == 'true') {
        settings_errors();
    }

    ?>

    <div id="daext-options-wrapper">

        <?php
        //get current tab value
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'defaults_options';
        ?>

        <div class="nav-tab-wrapper">
            <a href="?page=daam-options&tab=defaults_options"
               class="nav-tab <?php echo $active_tab == 'defaults_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('Defaults',
                    'daam'); ?></a>
            <a href="?page=daam-options&tab=analysis_options"
               class="nav-tab <?php echo $active_tab == 'analysis_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('Analysis',
                    'daam'); ?></a>
            <a href="?page=daam-options&tab=tracking_options"
               class="nav-tab <?php echo $active_tab == 'tracking_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('Tracking',
                    'daam'); ?></a>
            <a href="?page=daam-options&tab=capabilities_options"
               class="nav-tab <?php echo $active_tab == 'capabilities_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('Capabilities',
                    'daam'); ?></a>
            <a href="?page=daam-options&tab=pagination_options"
               class="nav-tab <?php echo $active_tab == 'pagination_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('Pagination',
                    'daam'); ?></a>
            <a href="?page=daam-options&tab=advanced_options"
               class="nav-tab <?php echo $active_tab == 'advanced_options' ? 'nav-tab-active' : ''; ?>"><?php esc_attr_e('Advanced',
                    'daam'); ?></a>
        </div>

        <form method="post" action="options.php" autocomplete="off">

            <?php

            if ($active_tab == 'defaults_options') {

                settings_fields($this->shared->get('slug') . '_defaults_options');
                do_settings_sections($this->shared->get('slug') . '_defaults_options');

            }

            if ($active_tab == 'analysis_options') {

                settings_fields($this->shared->get('slug') . '_analysis_options');
                do_settings_sections($this->shared->get('slug') . '_analysis_options');

            }

            if ($active_tab == 'tracking_options') {

                settings_fields($this->shared->get('slug') . '_tracking_options');
                do_settings_sections($this->shared->get('slug') . '_tracking_options');

            }

            if ($active_tab == 'capabilities_options') {

                settings_fields($this->shared->get('slug') . '_capabilities_options');
                do_settings_sections($this->shared->get('slug') . '_capabilities_options');

            }

            if ($active_tab == 'pagination_options') {

                settings_fields($this->shared->get('slug') . '_pagination_options');
                do_settings_sections($this->shared->get('slug') . '_pagination_options');

            }

            if ($active_tab == 'advanced_options') {

                settings_fields($this->shared->get('slug') . '_advanced_options');
                do_settings_sections($this->shared->get('slug') . '_advanced_options');

            }

            ?>

            <div class="daext-options-action">
                <input type="submit" name="submit" id="submit" class="button"
                       value="<?php esc_attr_e('Save Changes', 'daam'); ?>">
            </div>

        </form>

    </div>

</div>