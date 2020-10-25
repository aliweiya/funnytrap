<?php

if ( ! current_user_can(get_option($this->shared->get('slug') . '_capabilities_maintenance_menu'))) {
    wp_die(esc_attr__('You do not have sufficient permissions to access this page.', 'daam'));
}

?>

<!-- process data -->

<?php

if (isset($_POST['form_submitted'])) {

    extract($_POST);

    //prepare data
    $task = intval($task, 10);
    $from = intval($from, 10);
    $to   = intval($to, 10);

    $invalid_data_message = '';
    $invalid_data         = false;

    //validation
    if ($from >= $to) {
        $invalid_data_message .= '<div class="updated settings-error notice is-dismissible below-h2"><p>' . esc_attr__('Please enter a valid range.',
                'daam') . '</p></div>';
        $invalid_data         = true;
    }

    if (($to - $from) > 10000) {
        $invalid_data_message .= '<div class="updated settings-error notice is-dismissible below-h2"><p>' . esc_attr__("For performance reasons the range can't include more than 10000 items.",
                'daam') . '</p></div>';
        $invalid_data         = true;
    }

    if ($invalid_data === false) {

        switch ($task) {

            //Delete Autolinks
            case 0:

                global $wpdb;
                $table_name   = $wpdb->prefix . $this->shared->get('slug') . "_autolink";
                $safe_sql     = $wpdb->prepare("DELETE FROM $table_name WHERE autolink_id >= %d AND autolink_id <= %d",
                    $from, $to);
                $query_result = $wpdb->query($safe_sql);

                if ($query_result !== false) {

                    if ($query_result > 0) {
                        $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . intval($query_result,
                                10) . '&nbsp' . esc_attr__('autolinks have been successfully deleted.',
                                'daam') . '</p></div>';
                    } else {
                        $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . esc_attr__('The are no autolinks in this range.',
                                'daam') . '</p></div>';
                    }

                }

                break;

            //Delete Categories
            case 1:

                //Delete all the categories not used in autolinks
                $deleted_categories = 0;
                for ($category_id = $from; $category_id <= $to; $category_id++) {

                    if ($this->shared->category_exists($category_id) and $this->shared->category_is_used($category_id) === false) {
                        global $wpdb;
                        $table_name   = $wpdb->prefix . $this->shared->get('slug') . "_category";
                        $safe_sql     = $wpdb->prepare("DELETE FROM $table_name WHERE category_id = %d", $category_id);
                        $query_result = $wpdb->query($safe_sql);
                        if ($query_result === 1) {
                            $deleted_categories++;
                        }
                    }

                }

                //Generate message
                if ($deleted_categories > 0) {
                    $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . intval($deleted_categories,
                            10) . '&nbsp' . esc_attr__('categories have been successfully deleted.',
                            'daam') . '</p></div>';
                } else {
                    $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . esc_attr__("The are no deletable categories in this range. Please note that categories associated with one or more autolinks can't be deleted.",
                            'daam') . '</p></div>';
                }

                break;

            //Delete Term Groups
            case 2:

                //Delete all the term groups not used in autolinks
                $deleted_term_groups = 0;
                for ($term_group_id = $from; $term_group_id <= $to; $term_group_id++) {

                    if ($this->shared->term_group_exists($term_group_id) and $this->shared->term_group_is_used($term_group_id) === false) {
                        global $wpdb;
                        $table_name   = $wpdb->prefix . $this->shared->get('slug') . "_term_group";
                        $safe_sql     = $wpdb->prepare("DELETE FROM $table_name WHERE term_group_id = %d",
                            $term_group_id);
                        $query_result = $wpdb->query($safe_sql);
                        if ($query_result === 1) {
                            $deleted_term_groups++;
                        }
                    }

                }

                //Generate message
                if ($deleted_term_groups > 0) {
                    $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . intval($deleted_term_groups,
                            10) . '&nbsp' . esc_attr__('term groups have been successfully deleted.',
                            'daam') . '</p></div>';
                } else {
                    $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . esc_attr__("The are no deletable term groups in this range. Please note that term groups associated with one or more autolinks can't be deleted.",
                            'daam') . '</p></div>';
                }

                break;

            //Delete Tracking
            case 3:

                global $wpdb;
                $table_name   = $wpdb->prefix . $this->shared->get('slug') . "_tracking";
                $safe_sql     = $wpdb->prepare("DELETE FROM $table_name WHERE tracking_id >= %d AND tracking_id <= %d",
                    $from, $to);
                $query_result = $wpdb->query($safe_sql);

                if ($query_result !== false) {

                    if ($query_result > 0) {
                        $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . intval($query_result,
                                10) . '&nbsp' . esc_attr__('tracked clicks have been successfully deleted.',
                                'daam') . '</p></div>';
                    } else {
                        $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . esc_attr__('There are no tracked clicks in this range.',
                                'daam') . '</p></div>';
                    }

                }

                break;

        }

    }

}

?>

<!-- output -->

<div class="wrap">

    <div id="daext-header-wrapper" class="daext-clearfix">

        <h2><?php esc_attr_e('Autolinks Manager - Maintenance', 'daam'); ?></h2>

    </div>

    <div id="daext-menu-wrapper">

        <?php if (isset($invalid_data_message)) {
            echo $invalid_data_message;
        } ?>
        <?php if (isset($process_data_message)) {
            echo $process_data_message;
        } ?>

        <!-- table -->

        <div>

            <form id="form-maintenance" method="POST"
                  action="admin.php?page=<?php echo $this->shared->get('slug'); ?>-maintenance"
                  autocomplete="off">

                <input type="hidden" value="1" name="form_submitted">

                <div class="daext-form-container">

                    <div class="daext-form-title"><?php esc_attr_e('Maintenance', 'daam'); ?></div>

                    <table class="daext-form daext-form-table">

                        <!-- Task -->
                        <tr>
                            <th scope="row"><?php esc_attr_e('Task', 'daam'); ?></th>
                            <td>
                                <select id="task" name="task" class="daext-display-none">
                                    <option value="0" selected="selected"><?php esc_attr_e('Delete Autolinks',
                                            'daam'); ?></option>
                                    <option value="1"><?php esc_attr_e('Delete Categories', 'daam'); ?></option>
                                    <option value="2"><?php esc_attr_e('Delete Term Groups', 'daam'); ?></option>
                                    <option value="3"><?php esc_attr_e('Delete Tracking', 'daam'); ?></option>
                                </select>
                                <div class="help-icon"
                                     title='<?php esc_attr_e('The task that should be performed.', 'daam'); ?>'></div>
                            </td>
                        </tr>

                        <!-- From -->
                        <tr>
                            <th><label for="from"><?php esc_attr_e('From', 'daam'); ?></label></th>
                            <td>
                                <input type="text" id="from" maxlength="10" size="30" name="from" value="1"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The initial ID of the range.', 'daam'); ?>"></div>
                            </td>
                        </tr>

                        <!-- To -->
                        <tr>
                            <th scope="row"><label for="to"><?php esc_attr_e('To', 'daam'); ?></label></th>
                            <td>
                                <input type="text" id="to" maxlength="10" size="30" name="to" value="1000"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The final ID of the range.', 'daam'); ?>"></div>
                            </td>
                        </tr>

                    </table>

                    <!-- submit button -->
                    <div class="daext-form-action">
                        <input id="execute-task" class="button" type="submit"
                               value="<?php esc_attr_e('Execute Task', 'daam'); ?>">
                    </div>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- Dialog Confirm -->
<div id="dialog-confirm" title="<?php esc_attr_e('Execute the task?', 'daam'); ?>" class="daext-display-none">
    <p><?php esc_attr_e('Multiple database items are going to be deleted. Do you really want to proceed?',
            'daam'); ?></p>
</div>