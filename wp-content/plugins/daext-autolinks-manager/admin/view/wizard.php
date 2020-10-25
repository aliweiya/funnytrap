<?php

if ( ! current_user_can(get_option($this->shared->get('slug') . "_capabilities_wizard_menu"))) {
    wp_die(esc_attr__('You do not have sufficient permissions to access this page.'));
}

?>

<!-- process data -->

<!-- output -->

<div class="wrap">

    <?php

    if (isset($_GET['invalid_name'])) {
        $process_data_message = '<div class="error settings-error notice is-dismissible below-h2"><p>' . esc_attr__('Please enter a valid value in the "Name" field.',
                'daam') . '</p></div>';
    }

    if (isset($_GET['result']) and $_GET['result'] !== 'error') {
        $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . intval($_GET['result'],
                10) . esc_attr__(' autolinks have been added.', 'daam') . '</p></div>';
    }

    ?>

    <div id="daext-header-wrapper" class="daext-clearfix">

        <h2><?php esc_attr_e('Autolinks Manager - Wizard', 'daam'); ?></h2>

    </div>

    <div id="daext-menu-wrapper">

        <?php if (isset($invalid_data_message)) {
            echo $invalid_data_message;
        } ?>
        <?php if (isset($process_data_message)) {
            echo $process_data_message;
        } ?>

        <!-- table -->

        <form method="POST" action="admin.php?page=<?php echo $this->shared->get('slug'); ?>-wizard" autocomplete="off">

            <!-- Create New Autolink -->

            <div class="daext-form-container">

                <div class="daext-form-title"><?php esc_attr_e('Wizard', 'daam'); ?></div>

                <table class="daext-form">

                    <!-- Name -->
                    <tr valign="top">
                        <th><label for="title"><?php esc_attr_e('Name', 'daam'); ?></label></th>
                        <td>
                            <input type="text" id="name" maxlength="100" size="30" name="name"/>
                            <div class="help-icon"
                                 title="<?php esc_attr_e('The name of the generated autolinks.', 'daam'); ?>"></div>
                        </td>
                    </tr>

                    <!-- Category ID -->
                    <tr>
                        <th scope="row"><label for="tags"><?php esc_attr_e('Category', 'daam'); ?></label></th>
                        <td>
                            <?php

                            $html = '<select id="category-id" name="category_id" class="daext-display-none">';

                            $html .= '<option value="0" ' . selected(intval(get_option($this->shared->get('slug') . "_defaults_category_id")),
                                    0, false) . '>' . esc_attr__('None', 'daam') . '</option>';

                            global $wpdb;
                            $table_name = $wpdb->prefix . $this->shared->get('slug') . "_category";
                            $sql        = "SELECT category_id, name FROM $table_name ORDER BY category_id DESC";
                            $category_a = $wpdb->get_results($sql, ARRAY_A);

                            foreach ($category_a as $key => $category) {
                                $html .= '<option value="' . $category['category_id'] . '" ' . selected(intval(get_option($this->shared->get('slug') . "_defaults_category_id")),
                                        $category['category_id'],
                                        false) . '>' . esc_attr(stripslashes($category['name'])) . '</option>';
                            }

                            $html .= '</select>';
                            $html .= '<div class="help-icon" title="' . esc_attr__('The category of the generated autolinks.',
                                    'daam') . '"></div>';

                            echo $html;

                            ?>
                        </td>
                    </tr>

                    <!-- Data -->
                    <tr valign="top">
                        <th><label for="data"><?php esc_attr_e('Data', 'daam'); ?></label></th>
                        <td id="daam-table-td">
                            <div id="daam-table"></div>
                        </td>
                    </tr>

                </table>

                <!-- submit button -->
                <div class="daext-form-action">
                    <input id="generate-autolinks" class="button" type="submit"
                           value="<?php esc_attr_e('Generate Autolinks', 'daam'); ?>">
                </div>

            </div>

        </form>

    </div>

</div>