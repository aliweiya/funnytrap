<?php

if ( ! current_user_can(get_option($this->shared->get('slug') . "_capabilities_tracking_menu"))) {
    wp_die(esc_attr__('You do not have sufficient permissions to access this page.'));
}

?>

<!-- process data -->

<?php

//reset tracking
if (isset($_POST['reset_tracking'])) {

    //delete the tracking db table content
    global $wpdb;
    $table_name = $wpdb->prefix . $this->shared->get('slug') . "_tracking";
    $result     = $wpdb->query("DELETE FROM $table_name");

    if ($result !== false) {
        $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . $result . ' ' . esc_attr__(' tracked clicks have been successfully deleted.',
                'daam') . '</p></div>';
    }

}

//delete a tracked click
if (isset($_POST['delete_id'])) {

    global $wpdb;
    $delete_id = intval($_POST['delete_id'], 10);

    $table_name   = $wpdb->prefix . $this->shared->get('slug') . "_tracking";
    $safe_sql     = $wpdb->prepare("DELETE FROM $table_name WHERE tracking_id = %d ", $delete_id);
    $query_result = $wpdb->query($safe_sql);

    if ($query_result !== false) {
        $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . esc_attr__('The tracked click has been successfully deleted.',
                'daam') . '</p></div>';
    }

}

?>

<!-- output -->

<div class="wrap">

    <div id="daext-header-wrapper" class="daext-clearfix">

        <h2><?php esc_attr_e('Autolinks Manager - Tracking', 'daam'); ?></h2>

        <form action="admin.php" method="get" id="daext-search-form">

            <input type="hidden" name="page" value="daam-tracking">

            <p><?php esc_attr_e('Perform your Search', 'daam'); ?></p>

            <?php
            if (isset($_GET['s']) and mb_strlen(trim($_GET['s'])) > 0) {
                $search_string = $_GET['s'];
            } else {
                $search_string = '';
            }
            ?>

            <input type="text" name="s"
                   value="<?php echo esc_attr(stripslashes($search_string)); ?>" autocomplete="off" maxlength="255">
            <input type="submit" value="">

        </form>

    </div>

    <div id="daext-menu-wrapper" class="daext-clearfix">

        <?php if (isset($process_data_message)) {
            echo $process_data_message;
        } ?>

        <!-- list of subscribers -->
        <div class="tracking-container">

            <?php

            //create the query part used to filter the results when a search is performed
            if (isset($_GET['s']) and mb_strlen(trim($_GET['s'])) > 0) {
                $search_string = $_GET['s'];
                global $wpdb;
                $filter = $wpdb->prepare('WHERE (tracking_id LIKE %s OR user_ip LIKE %s)', '%' . $search_string . '%', '%' . $search_string . '%');
            } else {
                $filter = '';
            }

            //retrieve the total number of tracking
            global $wpdb;
            $table_name  = $wpdb->prefix . $this->shared->get('slug') . "_tracking";
            $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name $filter");

            //Initialize the pagination class
            require_once($this->shared->get('dir') . '/admin/inc/class-daam-pagination.php');
            $pag = new daam_pagination();
            $pag->set_total_items($total_items);//Set the total number of items
            $pag->set_record_per_page(intval(get_option($this->shared->get('slug') . '_pagination_tracking_menu'),
                10)); //Set records per page
            $pag->set_target_page("admin.php?page=" . $this->shared->get('slug') . "-tracking");//Set target page
            $pag->set_current_page();//set the current page number from $_GET

            ?>

            <!-- Query the database -->
            <?php
            $query_limit = $pag->query_limit();
            $results     = $wpdb->get_results("SELECT * FROM $table_name $filter ORDER BY date DESC $query_limit",
                ARRAY_A); ?>

            <?php if (count($results) > 0) : ?>

                <div class="daext-items-container">

                    <table class="daext-items">
                        <thead>
                        <tr>
                            <th>
                                <?php esc_attr_e('Tracking ID', 'daam'); ?>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The ID of the tracked click.', 'daam'); ?>"></div>
                            </th>
                            <th>
                                <?php esc_attr_e('User IP', 'daam'); ?>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The IP address of the user that performed the click.', 'daam'); ?>"></div>
                            </th>
                            <th>
                                <div><?php esc_attr_e('Date', 'daam'); ?></div>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The date on which the autolink has been clicked.',
                                         'daam'); ?>"></div>
                            </th>
                            <th>
                                <?php esc_attr_e('Autolink', 'daam'); ?>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The autolink associated with the tracked click.',
                                         'daam'); ?>"></div>
                            </th>
                            <th>
                                <div><?php esc_attr_e('Post', 'daam'); ?></div>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The post, page or custom post type that includes the autolink that received the click.',
                                         'daam'); ?>"></div>
                            </th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach ($results as $result) : ?>

                            <tr>
                                <td><?php echo intval($result['tracking_id'], 10); ?></td>
                                <td><?php echo esc_attr($result['user_ip']); ?></td>
                                <td><?php echo mysql2date(get_option('date_format'), $result['date']); ?></td>
                                <?php
                                $autolink_obj = $this->shared->get_autolink_object($result['autolink_id']);
                                if (isset($autolink_obj->name)) {
                                    echo '<td><a href="admin.php?page=daam-autolinks&edit_id=' . intval($result['autolink_id']) . '">' . esc_attr(stripslashes($autolink_obj->name)) . '</a></td>';
                                } else {
                                    echo '<td>' . esc_attr__('Not Available', 'daam') . '</td>';
                                }
                                ?>
                                <?php
                                if (get_post_status($result['post_id']) !== false) {
                                    echo '<td><a href="' . get_the_permalink($result['post_id']) . '">' . get_the_title($result['post_id']) . '</a></td>';
                                } else {
                                    echo '<td>' . esc_attr__('Not Available', 'daam') . '</td>';
                                }
                                ?>
                                <td class="icons-container">
                                    <form id="form-delete-<?php echo $result['tracking_id']; ?>" method="POST"
                                          action="admin.php?page=<?php echo $this->shared->get('slug'); ?>-tracking">
                                        <input type="hidden" value="<?php echo $result['tracking_id']; ?>"
                                               name="delete_id">
                                        <input class="menu-icon delete" type="submit" value="">
                                    </form>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                        </tbody>
                    </table>

                </div>

            <?php else : ?>

                <?php

                if (mb_strlen(trim($filter)) > 0) {
                    echo '<p>' . esc_attr__('There are no results that match your search.', 'daam') . '</p>';
                } else {
                    echo '<p>' . esc_attr__('There are no tracked clicks at the moment.', 'daam') . '</p>';
                }

                ?>

            <?php endif; ?>

            <!-- Display the pagination -->
            <?php if ($pag->total_items > 0) : ?>
                <div class="daext-tablenav daext-clearfix">
                    <div class="daext-tablenav-pages">
                        <span class="daext-displaying-num"><?php echo $pag->total_items; ?>&nbsp;<?php esc_attr_e('items',
                                'daam'); ?></span>
                        <?php $pag->show(); ?>
                    </div>
                </div>
            <?php endif; ?>

        </div><!-- #subscribers-container -->

        <div class="sidebar-container">

            <div class="daext-widget">

                <h3 class="daext-widget-title"><?php esc_attr_e('Reset Tracking', 'daam'); ?></h3>

                <div class="daext-widget-content">

                    <p><?php esc_attr_e('This procedure allows you to reset the tracked clicks.', 'daam'); ?></p>

                </div><!-- .daext-widget-content -->

                <form method="POST" action="admin.php?page=daam-tracking">

                    <div class="daext-widget-submit">
                        <input name="reset_tracking" class="button" type="submit"
                               value="<?php esc_attr_e('Reset', 'daam'); ?>">
                    </div>

                </form>

            </div>

            <div class="daext-widget">

                <h3 class="daext-widget-title"><?php esc_attr_e('Export CSV', 'daam'); ?></h3>

                <div class="daext-widget-content">

                    <p><?php esc_attr_e('The downloaded CSV file can be imported in your favorite spreadsheet software.',
                            'daam'); ?></p>

                </div><!-- .daext-widget-content -->

                <!-- the data sent through this form are handled by the export_csv_controller() method called with the
                WordPress init action -->
                <form method="POST" action="admin.php?page=daam-tracking">

                    <div class="daext-widget-submit">
                        <input name="export_csv" class="button" type="submit" value="<?php esc_attr_e('Download',
                            'daam'); ?>" <?php if ($this->shared->is_tracking_empty()) {
                            echo 'disabled="disabled"';
                        } ?>>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<!-- Dialog Confirm -->
<div id="dialog-confirm" title="<?php esc_attr_e('Delete the tracked click?', 'daam'); ?>" class="daext-display-none">
    <p><?php esc_attr_e('This tracked click will be permanently deleted and cannot be recovered. Are you sure?',
            'daam'); ?></p>
</div>