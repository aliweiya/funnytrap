<?php

if ( ! current_user_can(get_option($this->shared->get('slug') . "_capabilities_export_menu"))) {
    wp_die(esc_attr__('You do not have sufficient permissions to access this page.', 'daam'));
}

?>

<!-- output -->

<div class="wrap">

    <h2><?php esc_attr_e('Autolinks Manager - Export', 'daam'); ?></h2>

    <div id="daext-menu-wrapper">

        <p><?php esc_attr_e('Click the Export button to generate an XML file that includes autolinks, categories and term groups.',
                'daam'); ?></p>

        <!-- the data sent through this form are handled by the export_xml_controller() method called with the WordPress init action -->
        <form method="POST" action="admin.php?page=daam-export">

            <div class="daext-widget-submit">
                <input name="daam_export" class="button button-primary" type="submit"
                       value="<?php esc_attr_e('Export',
                           'daam'); ?>" <?php if ( ! $this->shared->exportable_data_exists()) {
                    echo 'disabled="disabled"';
                } ?>>
            </div>

        </form>

    </div>

</div>