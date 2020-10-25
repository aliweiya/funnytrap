<?php

if ( ! current_user_can(get_option($this->shared->get('slug') . "_capabilities_export_menu"))) {
    wp_die(esc_attr__('You do not have sufficient permissions to access this page.', 'daam'));
}

?>

<!-- output -->

<div class="wrap">

    <h2><?php esc_attr_e('Autolinks Manager - Import', 'daam'); ?></h2>

    <div id="daext-menu-wrapper">

        <?php

        //process the xml file upload
        if (isset($_FILES['file_to_upload']) and
            isset($_FILES['file_to_upload']['name']) and
            preg_match('/^.+\.xml$/', $_FILES['file_to_upload']['name'], $matches) === 1
        ) {

            if (file_exists($_FILES['file_to_upload']['tmp_name'])) {

                global $wpdb;

                $counter_autolink         = 0;
                $counter_category         = 0;
                $counter_term_group       = 0;
                $category_id_hash_table   = array();
                $term_group_id_hash_table = array();

                //Set the PHP "Max Execution Time" and "Memory Limit" based on the values defined in the options
                $this->shared->set_met_and_ml();

                //read xml file
                $xml = simplexml_load_file($_FILES['file_to_upload']['tmp_name']);

                //Import Categories ------------------------------------------------------------------------------------
                $category_a = $xml->category;

                $num = count($category_a);

                for ($i = 0; $i < $num; $i++) {

                    //convert object to array
                    $single_category_a = get_object_vars($category_a[$i]);

                    //replace objects with empty strings to prevent notices on the next insert() method
                    $single_category_a = $this->shared->replace_objects_with_empty_strings($single_category_a);

                    /*
                     * Save the category_id key for later use and remove the category_id key from the
                     * main array.
                     */
                    $current_category_id = $single_category_a['category_id'];
                    unset($single_category_a['category_id']);

                    $table_name = $wpdb->prefix . $this->shared->get('slug') . "_category";
                    $wpdb->insert(
                        $table_name,
                        $single_category_a
                    );
                    $inserted_category_id = $wpdb->insert_id;
                    $counter_category     += $wpdb->rows_affected;

                    //Add the old and new category_id in the hash table
                    $category_id_hash_table[$current_category_id] = $inserted_category_id;

                }

                //Import Term Groups -----------------------------------------------------------------------------------
                $term_group_a = $xml->term_group;

                $num = count($term_group_a);

                for ($i = 0; $i < $num; $i++) {

                    //convert object to array
                    $single_term_group_a = get_object_vars($term_group_a[$i]);

                    //replace objects with empty strings to prevent notices on the next insert() method
                    $single_term_group_a = $this->shared->replace_objects_with_empty_strings($single_term_group_a);

                    /*
                     * Save the term_group_id key for later use and remove the term_group_id key from the
                     * main array.
                     */
                    $current_term_group_id = $single_term_group_a['term_group_id'];
                    unset($single_term_group_a['term_group_id']);

                    $table_name = $wpdb->prefix . $this->shared->get('slug') . "_term_group";
                    $wpdb->insert(
                        $table_name,
                        $single_term_group_a
                    );
                    $inserted_term_group_id = $wpdb->insert_id;
                    $counter_term_group     += $wpdb->rows_affected;

                    //Add the old and new term_group_id in the has table
                    $term_group_id_hash_table[$current_term_group_id] = $inserted_term_group_id;

                }

                //Import Autolinks -------------------------------------------------------------------------------------
                $autolink_a = $xml->autolink;

                $num = count($autolink_a);

                for ($i = 0; $i < $num; $i++) {

                    //convert object to array
                    $single_autolink_a = get_object_vars($autolink_a[$i]);

                    //replace objects with empty strings to prevent notices on the next insert() method
                    $single_autolink_a = $this->shared->replace_objects_with_empty_strings($single_autolink_a);

                    //remove the id key
                    unset($single_autolink_a['autolink_id']);

                    //replace the category_id value with zero or the one available in $category_id_hash_table
                    if (intval($single_autolink_a['category_id'], 10) === 0) {
                        $single_autolink_a['category_id'] = 0;
                    } else {
                        $single_autolink_a['category_id'] = $category_id_hash_table[$single_autolink_a['category_id']];
                    }

                    //replace the term_group_id value with zero or the one available in $term_group_id_hash_table
                    if (intval($single_autolink_a['term_group_id'], 10) === 0) {
                        $single_autolink_a['term_group_id'] = 0;
                    } else {
                        $single_autolink_a['term_group_id'] = $term_group_id_hash_table[$single_autolink_a['term_group_id']];
                    }

                    $table_name = $wpdb->prefix . $this->shared->get('slug') . "_autolink";
                    $wpdb->insert(
                        $table_name,
                        $single_autolink_a
                    );
                    $inserted_autolink_id = $wpdb->insert_id;
                    $counter_autolink     += $wpdb->rows_affected;

                }

                $success_message = '<div class="updated settings-error notice is-dismissible below-h2">';
                $success_message .= '<p>' . esc_attr__('The following elements have been added:', 'daam') . ' ';
                $success_message .= $counter_autolink . ' ' . esc_attr__('autolinks', 'daam') . ', ';
                $success_message .= $counter_category . ' ' . esc_attr__('categories', 'daam') . ' and ';
                $success_message .= $counter_term_group . ' ' . esc_attr__('term groups.', 'daam') . '';
                $success_message .= '<button type="button" class="notice-dismiss"><span class="screen-reader-text">' . esc_attr__("Dismiss this notice.",
                        "daam") . '</span></button></div>';

                echo $success_message;

            }

        }

        ?>

        <p><?php esc_attr_e('Import the autolinks, categories and term groups stored in your XML file by clicking the Upload file and import button.',
                'daam'); ?></p>
        <form enctype="multipart/form-data" id="import-upload-form" method="post" class="wp-upload-form" action="">
            <p>
                <label for="upload"><?php esc_attr_e('Choose a file from your computer:', 'daam'); ?></label>
                <input type="file" id="upload" name="file_to_upload">
            </p>
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                                     value="<?php esc_attr_e('Upload file and import', 'daam'); ?>"></p>
        </form>
        <p>
            <strong><?php esc_attr_e('IMPORTANT: This menu should only be used to import the XML files generated with the "Export" menu.',
                    'daam'); ?></strong></p>

    </div>

</div>