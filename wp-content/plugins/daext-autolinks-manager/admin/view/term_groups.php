<?php

if ( ! current_user_can(get_option($this->shared->get('slug') . '_capabilities_term_groups_menu'))) {
    wp_die(esc_attr__('You do not have sufficient permissions to access this page.', 'daam'));
}

$supported_terms = intval(get_option($this->shared->get('slug') . '_advanced_supported_terms'), 10);

?>

<!-- process data -->

<?php

if (isset($_POST['update_id']) or isset($_POST['form_submitted'])) {

    extract($_POST);

    //prepare data -----------------------------------------------------------------------------------------------------
    if (isset($update_id)) {
        $update_id = intval($update_id, 10);
    }

    $name = trim($name);

    //validation -------------------------------------------------------------------------------------------------------

    $invalid_data_message = '';

    //validation on "name"
    if (mb_strlen(trim($name)) === 0 or mb_strlen(trim($name)) > 100) {
        $invalid_data_message .= '<div class="error settings-error notice is-dismissible below-h2"><p>' . esc_attr__('Please enter a valid value in the "Name" field.',
                'daam') . '</p></div>';
        $invalid_data         = true;
    }


    for ($i = 1; $i <= 50; $i++) {

        //If the "Supported Terms" are less than 50 give a default value to the non-submitted fields
        if ( ! isset(${'post_type_' . $i})) {
            ${'post_type_' . $i} = '';
        }
        if ( ! isset(${'taxonomy_' . $i})) {
            ${'taxonomy_' . $i} = '';
        }
        if ( ! isset(${'term_' . $i})) {
            ${'term_' . $i} = 0;
        }

        //Set post type and taxonomy to an empty value if the related term is not set
        if (intval(${'term_' . $i}, 10) === 0) {
            ${'post_type_' . $i} = '';
            ${'taxonomy_' . $i}  = '';
        }

    }

    //Require that at least one term is set
    $one_term_is_set = false;
    for ($i = 1; $i <= 50; $i++) {
        if (intval(${'term_' . $i}, 10) !== 0) {
            $one_term_is_set = true;
        }
    }
    if ( ! $one_term_is_set) {
        $invalid_data_message .= '<div class="error settings-error notice is-dismissible below-h2"><p>' . esc_attr__('Please specify at least one term.',
                'daam') . '</p></div>';
        $invalid_data         = true;
    }

}

//update ---------------------------------------------------------------
$query_part = '';
for ($i = 1; $i <= 50; $i++) {
    $query_part .= 'post_type_' . $i . ' = %s,';
    $query_part .= 'taxonomy_' . $i . ' = %s,';
    $query_part .= 'term_' . $i . ' = %d';
    if ($i !== 50) {
        $query_part .= ',';
    }
}

if (isset($_POST['update_id']) and ! isset($invalid_data)) {

    //update the database
    global $wpdb;
    $table_name = $wpdb->prefix . $this->shared->get('slug') . "_term_group";
    $safe_sql   = $wpdb->prepare("UPDATE $table_name SET
                name = %s,
                $query_part
                WHERE term_group_id = %d",
        $name,
        $post_type_1, $taxonomy_1, $term_1,
        $post_type_2, $taxonomy_2, $term_2,
        $post_type_3, $taxonomy_3, $term_3,
        $post_type_4, $taxonomy_4, $term_4,
        $post_type_5, $taxonomy_5, $term_5,
        $post_type_6, $taxonomy_6, $term_6,
        $post_type_7, $taxonomy_7, $term_7,
        $post_type_8, $taxonomy_8, $term_8,
        $post_type_9, $taxonomy_9, $term_9,
        $post_type_10, $taxonomy_10, $term_10,
        $post_type_11, $taxonomy_11, $term_11,
        $post_type_12, $taxonomy_12, $term_12,
        $post_type_13, $taxonomy_13, $term_13,
        $post_type_14, $taxonomy_14, $term_14,
        $post_type_15, $taxonomy_15, $term_15,
        $post_type_16, $taxonomy_16, $term_16,
        $post_type_17, $taxonomy_17, $term_17,
        $post_type_18, $taxonomy_18, $term_18,
        $post_type_19, $taxonomy_19, $term_19,
        $post_type_20, $taxonomy_20, $term_20,
        $post_type_21, $taxonomy_21, $term_21,
        $post_type_22, $taxonomy_22, $term_22,
        $post_type_23, $taxonomy_23, $term_23,
        $post_type_24, $taxonomy_24, $term_24,
        $post_type_25, $taxonomy_25, $term_25,
        $post_type_26, $taxonomy_26, $term_26,
        $post_type_27, $taxonomy_27, $term_27,
        $post_type_28, $taxonomy_28, $term_28,
        $post_type_29, $taxonomy_29, $term_29,
        $post_type_30, $taxonomy_30, $term_30,
        $post_type_31, $taxonomy_31, $term_31,
        $post_type_32, $taxonomy_32, $term_32,
        $post_type_33, $taxonomy_33, $term_33,
        $post_type_34, $taxonomy_34, $term_34,
        $post_type_35, $taxonomy_35, $term_35,
        $post_type_36, $taxonomy_36, $term_36,
        $post_type_37, $taxonomy_37, $term_37,
        $post_type_38, $taxonomy_38, $term_38,
        $post_type_39, $taxonomy_39, $term_39,
        $post_type_40, $taxonomy_40, $term_40,
        $post_type_41, $taxonomy_41, $term_41,
        $post_type_42, $taxonomy_42, $term_42,
        $post_type_43, $taxonomy_43, $term_43,
        $post_type_44, $taxonomy_44, $term_44,
        $post_type_45, $taxonomy_45, $term_45,
        $post_type_46, $taxonomy_46, $term_46,
        $post_type_47, $taxonomy_47, $term_47,
        $post_type_48, $taxonomy_48, $term_48,
        $post_type_49, $taxonomy_49, $term_49,
        $post_type_50, $taxonomy_50, $term_50,
        $update_id);

    $query_result = $wpdb->query($safe_sql);

    if ($query_result !== false) {
        $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . esc_attr__('The term has been successfully updated.',
                'daam') . '</p></div>';
    }

} else {

    //add ------------------------------------------------------------------
    if (isset($_POST['form_submitted']) and ! isset($invalid_data)) {

        //insert into the database
        global $wpdb;
        $table_name = $wpdb->prefix . $this->shared->get('slug') . "_term_group";
        $safe_sql   = $wpdb->prepare("INSERT INTO $table_name SET
                name = %s,
                $query_part",
            $name,
            $post_type_1, $taxonomy_1, $term_1,
            $post_type_2, $taxonomy_2, $term_2,
            $post_type_3, $taxonomy_3, $term_3,
            $post_type_4, $taxonomy_4, $term_4,
            $post_type_5, $taxonomy_5, $term_5,
            $post_type_6, $taxonomy_6, $term_6,
            $post_type_7, $taxonomy_7, $term_7,
            $post_type_8, $taxonomy_8, $term_8,
            $post_type_9, $taxonomy_9, $term_9,
            $post_type_10, $taxonomy_10, $term_10,
            $post_type_11, $taxonomy_11, $term_11,
            $post_type_12, $taxonomy_12, $term_12,
            $post_type_13, $taxonomy_13, $term_13,
            $post_type_14, $taxonomy_14, $term_14,
            $post_type_15, $taxonomy_15, $term_15,
            $post_type_16, $taxonomy_16, $term_16,
            $post_type_17, $taxonomy_17, $term_17,
            $post_type_18, $taxonomy_18, $term_18,
            $post_type_19, $taxonomy_19, $term_19,
            $post_type_20, $taxonomy_20, $term_20,
            $post_type_21, $taxonomy_21, $term_21,
            $post_type_22, $taxonomy_22, $term_22,
            $post_type_23, $taxonomy_23, $term_23,
            $post_type_24, $taxonomy_24, $term_24,
            $post_type_25, $taxonomy_25, $term_25,
            $post_type_26, $taxonomy_26, $term_26,
            $post_type_27, $taxonomy_27, $term_27,
            $post_type_28, $taxonomy_28, $term_28,
            $post_type_29, $taxonomy_29, $term_29,
            $post_type_30, $taxonomy_30, $term_30,
            $post_type_31, $taxonomy_31, $term_31,
            $post_type_32, $taxonomy_32, $term_32,
            $post_type_33, $taxonomy_33, $term_33,
            $post_type_34, $taxonomy_34, $term_34,
            $post_type_35, $taxonomy_35, $term_35,
            $post_type_36, $taxonomy_36, $term_36,
            $post_type_37, $taxonomy_37, $term_37,
            $post_type_38, $taxonomy_38, $term_38,
            $post_type_39, $taxonomy_39, $term_39,
            $post_type_40, $taxonomy_40, $term_40,
            $post_type_41, $taxonomy_41, $term_41,
            $post_type_42, $taxonomy_42, $term_42,
            $post_type_43, $taxonomy_43, $term_43,
            $post_type_44, $taxonomy_44, $term_44,
            $post_type_45, $taxonomy_45, $term_45,
            $post_type_46, $taxonomy_46, $term_46,
            $post_type_47, $taxonomy_47, $term_47,
            $post_type_48, $taxonomy_48, $term_48,
            $post_type_49, $taxonomy_49, $term_49,
            $post_type_50, $taxonomy_50, $term_50
        );

        $query_result = $wpdb->query($safe_sql);

        if ($query_result !== false) {
            $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . esc_attr__('The term group has been successfully added.',
                    'daam') . '</p></div>';
        }

    }

}

//delete a term group
if (isset($_POST['delete_id'])) {

    global $wpdb;
    $delete_id = intval($_POST['delete_id'], 10);

    //prevent deletion if the term group is associated with an autolink
    if ($this->shared->term_group_is_used($delete_id)) {

        $process_data_message = '<div class="error settings-error notice is-dismissible below-h2"><p>' . esc_attr__("This term group is associated with one or more autolinks and can't be deleted.",
                'daam') . '</p></div>';

    } else {

        $table_name   = $wpdb->prefix . $this->shared->get('slug') . "_term_group";
        $safe_sql     = $wpdb->prepare("DELETE FROM $table_name WHERE term_group_id = %d ", $delete_id);
        $query_result = $wpdb->query($safe_sql);

        if ($query_result !== false) {
            $process_data_message = '<div class="updated settings-error notice is-dismissible below-h2"><p>' . esc_attr__('The term group has been successfully deleted.',
                    'daam') . '</p></div>';
        }

    }

}

//clone the term group
if (isset($_POST['clone_id'])) {

    global $wpdb;
    $clone_id = intval($_POST['clone_id'], 10);

    //clone the autolink
    $table_name = $wpdb->prefix . $this->shared->get('slug') . "_term_group";
    $wpdb->query("CREATE TEMPORARY TABLE daam_temporary_table SELECT * FROM $table_name WHERE term_group_id = $clone_id");
    $wpdb->query("UPDATE daam_temporary_table SET term_group_id = NULL");
    $wpdb->query("INSERT INTO $table_name SELECT * FROM daam_temporary_table");
    $wpdb->query("DROP TEMPORARY TABLE IF EXISTS daam_temporary_table");

}

//get the term_group data
if (isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id'], 10);
    global $wpdb;
    $table_name     = $wpdb->prefix . $this->shared->get('slug') . "_term_group";
    $safe_sql       = $wpdb->prepare("SELECT * FROM $table_name WHERE term_group_id = %d ", $edit_id);
    $term_group_obj = $wpdb->get_row($safe_sql);
}

?>

<!-- output -->

<div class="wrap">

    <div id="daext-header-wrapper" class="daext-clearfix">

        <h2><?php esc_attr_e('Autolinks Manager - Term Groups', 'daam'); ?></h2>

        <form action="admin.php" method="get" id="daext-search-form">

            <input type="hidden" name="page" value="daam-term-groups">

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

    <div id="daext-menu-wrapper">

        <?php if (isset($invalid_data_message)) {
            echo $invalid_data_message;
        } ?>
        <?php if (isset($process_data_message)) {
            echo $process_data_message;
        } ?>

        <!-- table -->

        <?php

        $filter = '';

        //create the query part used to filter the results when a search is performed
        if (mb_strlen(trim($filter)) === 0 and isset($_GET['s']) and mb_strlen(trim($_GET['s'])) > 0) {
            $search_string = $_GET['s'];
            global $wpdb;
            $filter = $wpdb->prepare('WHERE (name LIKE %s)', '%' . $search_string . '%');
        }

        //retrieve the total number of autolinks
        global $wpdb;
        $table_name  = $wpdb->prefix . $this->shared->get('slug') . "_term_group";
        $total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name $filter");

        //Initialize the pagination class
        require_once($this->shared->get('dir') . '/admin/inc/class-daam-pagination.php');
        $pag = new daam_pagination();
        $pag->set_total_items($total_items);//Set the total number of items
        $pag->set_record_per_page(intval(get_option($this->shared->get('slug') . '_pagination_term_groups_menu'),
            10)); //Set records per page
        $pag->set_target_page("admin.php?page=" . $this->shared->get('slug') . "-term-groups");//Set target page
        $pag->set_current_page();//set the current page number from $_GET

        ?>

        <!-- Query the database -->
        <?php
        $query_limit = $pag->query_limit();
        $results     = $wpdb->get_results("SELECT * FROM $table_name $filter ORDER BY term_group_id DESC $query_limit",
            ARRAY_A); ?>

        <?php if (count($results) > 0) : ?>

            <div class="daext-items-container">

                <!-- list of tables -->
                <table class="daext-items">
                    <thead>
                    <tr>
                        <th>
                            <div><?php esc_attr_e('Term Group ID', 'daam'); ?></div>
                            <div class="help-icon"
                                 title="<?php esc_attr_e('The ID of the term group.', 'daam'); ?>"></div>
                        </th>
                        <th>
                            <div><?php esc_attr_e('Name', 'daam'); ?></div>
                            <div class="help-icon"
                                 title="<?php esc_attr_e('The name of the term group.', 'daam'); ?>"></div>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($results as $result) : ?>
                        <tr>
                            <td><?php echo intval($result['term_group_id'], 10); ?></td>
                            <td><?php echo esc_attr(stripslashes($result['name'])); ?></td>
                            <td class="icons-container">
                                <form method="POST"
                                      action="admin.php?page=<?php echo $this->shared->get('slug'); ?>-term-groups">
                                    <input type="hidden" name="clone_id"
                                           value="<?php echo $result['term_group_id']; ?>">
                                    <input class="menu-icon clone help-icon" type="submit" value="">
                                </form>
                                <a class="menu-icon edit"
                                   href="admin.php?page=<?php echo $this->shared->get('slug'); ?>-term-groups&edit_id=<?php echo $result['term_group_id']; ?>"></a>
                                <form id="form-delete-<?php echo $result['term_group_id']; ?>" method="POST"
                                      action="admin.php?page=<?php echo $this->shared->get('slug'); ?>-term-groups">
                                    <input type="hidden" value="<?php echo $result['term_group_id']; ?>"
                                           name="delete_id">
                                    <input class="menu-icon delete" type="submit" value="">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

            <!-- Display the pagination -->
            <?php if ($pag->total_items > 0) : ?>
                <div class="daext-tablenav daext-clearfix">
                    <div class="daext-tablenav-pages">
                        <span class="daext-displaying-num"><?php echo $pag->total_items; ?>
                            &nbsp<?php esc_attr_e('items',
                                'daam'); ?></span>
                        <?php $pag->show(); ?>
                    </div>
                </div>
            <?php endif; ?>

        <?php else : ?>

            <?php

            if (mb_strlen(trim($filter)) > 0) {
                echo '<div class="error settings-error notice is-dismissible below-h2"><p>' . esc_attr__('There are no results that match your filter.',
                        'daam') . '</p></div>';
            }

            ?>

        <?php endif; ?>

        <div>

            <form method="POST" action="admin.php?page=<?php echo $this->shared->get('slug'); ?>-term-groups"
                  autocomplete="off">

                <input type="hidden" value="1" name="form_submitted">

                <?php if (isset($_GET['edit_id'])) : ?>

                <!-- Edit a Term Group -->

                <div class="daext-form-container">

                    <h3 class="daext-form-title"><?php esc_attr_e('Edit Term Group',
                            'daam'); ?>&nbsp<?php echo $term_group_obj->term_group_id; ?></h3>

                    <table class="daext-form daext-form-table">

                        <input type="hidden" name="update_id"
                               value="<?php echo $term_group_obj->term_group_id; ?>"/>

                        <!-- Name -->
                        <tr valign="top">
                            <th><label for="title"><?php esc_attr_e('Name', 'daam'); ?></label></th>
                            <td>
                                <input value="<?php echo esc_attr(stripslashes($term_group_obj->name)); ?>" type="text"
                                       id="name" maxlength="100" size="30" name="name"/>
                                <div class="help-icon"
                                     title="<?php esc_attr_e('The name of the term group.', 'daam'); ?>"></div>
                            </td>
                        </tr>

                        <?php

                        $post_types = $this->shared->get_post_types_with_ui();

                        for ($i = 1; $i <= $supported_terms; $i++) {

                            ?>

                            <!-- Post Type <?php echo $i; ?> -->
                            <tr>
                                <th scope="row"><?php esc_attr_e('Post Type', 'daam'); ?>&nbsp<?php echo $i; ?></th>
                                <td>
                                    <select id="post-type-<?php echo $i; ?>" name="post_type_<?php echo $i; ?>"
                                            class="post-type daext-display-none" data-id="<?php echo $i; ?>">
                                        <option value="" class="default"><?php esc_attr_e('None', 'daam'); ?></option>
                                        <?php

                                        foreach ($post_types as $key => $post_type) {
                                            $post_type_obj = get_post_type_object($post_type);
                                            echo '<option value="' . esc_attr(stripslashes($post_type)) . '" ' . selected($post_type,
                                                    $term_group_obj->{'post_type_' . $i},
                                                    false) . '>' . esc_attr(stripslashes($post_type_obj->label)) . '</option>';
                                        }

                                        ?>
                                    </select>
                                    <div class="help-icon"
                                         title='<?php esc_attr_e('The post type for which you want to retrieve the taxonomies.',
                                             'daam'); ?>'></div>
                                </td>
                            </tr>

                            <!-- Taxonomy <?php echo $i; ?> -->
                            <tr>
                                <th scope="row"><?php esc_attr_e('Taxonomy', 'daam'); ?>&nbsp<?php echo $i; ?></th>
                                <td>
                                    <select id="taxonomy-<?php echo $i; ?>" name="taxonomy_<?php echo $i; ?>"
                                            class="taxonomy daext-display-none" data-id="<?php echo $i; ?>">
                                        <option value="" class="default"><?php esc_attr_e('None', 'daam'); ?></option>
                                        <?php

                                        $taxonomies = get_object_taxonomies($term_group_obj->{'post_type_' . $i});
                                        foreach ($taxonomies as $key => $taxonomy) {
                                            echo '<option value="' . $taxonomy . '" ' . selected($taxonomy,
                                                    $term_group_obj->{'taxonomy_' . $i},
                                                    false) . '>' . $taxonomy . '</option>';
                                        }

                                        ?>
                                    </select>
                                    <div class="help-icon"
                                         title='<?php esc_attr_e('The taxonomy for which you want to retrieve the terms.',
                                             'daam'); ?>'></div>
                                </td>
                            </tr>

                            <!-- Term <?php echo $i; ?> -->
                            <tr>
                                <th scope="row"><?php esc_attr_e('Term', 'daam'); ?>&nbsp<?php echo $i; ?></th>
                                <td>
                                    <select id="term-<?php echo $i; ?>" name="term_<?php echo $i; ?>"
                                            class="daext-display-none">
                                        <option value="0" class="default"><?php esc_attr_e('None', 'daam'); ?></option>
                                        <?php

                                        $terms = get_terms(array(
                                            'hide_empty' => 0,
                                            'orderby'    => 'term_id',
                                            'order'      => 'DESC',
                                            'taxonomy'   => $term_group_obj->{'taxonomy_' . $i}
                                        ));

                                        if (is_array($terms)) {
                                            foreach ($terms as $key => $termObj) {
                                                echo '<option value="' . $termObj->term_id . '" ' . selected($termObj->term_id,
                                                        $term_group_obj->{'term_' . $i},
                                                        false) . '>' . $termObj->name . '</option>';
                                            }
                                        }

                                        ?>
                                    </select>
                                    <div class="help-icon"
                                         title='<?php esc_attr_e('The term that will be compared with the ones available on the posts where the autolinks are applied.',
                                             'daam'); ?>'></div>
                                </td>
                            </tr>

                            <?php

                        }

                        ?>

                    </table>

                    <!-- submit button -->
                    <div class="daext-form-action">
                        <input class="button" type="submit"
                               value="<?php esc_attr_e('Update Term Group', 'daam'); ?>">
                        <input id="cancel" class="button" type="submit"
                               value="<?php esc_attr_e('Cancel', 'daam'); ?>">
                    </div>

                    <?php else : ?>

                    <!-- Create New Term Group -->

                    <div class="daext-form-container">

                        <div class="daext-form-title"><?php esc_attr_e('Create New Term Group', 'daam'); ?></div>

                        <table class="daext-form daext-form-table">

                            <!-- Name -->
                            <tr valign="top">
                                <th><label for="title"><?php esc_attr_e('Name', 'daam'); ?></label></th>
                                <td>
                                    <input type="text" id="name" maxlength="100" size="30" name="name"/>
                                    <div class="help-icon"
                                         title="<?php esc_attr_e('The name of the term group.', 'daam'); ?>"></div>
                                </td>
                            </tr>

                            <?php

                            $post_types = $this->shared->get_post_types_with_ui();

                            for ($i = 1; $i <= $supported_terms; $i++) {

                                ?>

                                <!-- Post Type <?php echo $i; ?> -->
                                <tr>
                                    <th scope="row"><?php esc_attr_e('Post Type', 'daam'); ?>&nbsp<?php echo $i; ?></th>
                                    <td>
                                        <select id="post-type-<?php echo $i; ?>" name="post_type_<?php echo $i; ?>"
                                                class="post-type daext-display-none" data-id="<?php echo $i; ?>">
                                            <option value="" class="default"><?php esc_attr_e('None',
                                                    'daam'); ?></option>
                                            <?php

                                            foreach ($post_types as $key => $post_type) {
                                                $post_type_obj = get_post_type_object($post_type);
                                                echo '<option value="' . esc_attr(stripslashes($post_type)) . '">' . esc_attr(stripslashes($post_type_obj->label)) . '</option>';
                                            }

                                            ?>
                                        </select>
                                        <div class="help-icon"
                                             title='<?php esc_attr_e('The post type for which you want to retrieve the taxonomies.',
                                                 'daam'); ?>'></div>
                                    </td>
                                </tr>

                                <!-- Taxonomy <?php echo $i; ?> -->
                                <tr>
                                    <th scope="row"><?php esc_attr_e('Taxonomy', 'daam'); ?>&nbsp<?php echo $i; ?></th>
                                    <td>
                                        <select id="taxonomy-<?php echo $i; ?>" name="taxonomy_<?php echo $i; ?>"
                                                class="taxonomy daext-display-none" data-id="<?php echo $i; ?>">
                                            <option value="" class="default"><?php esc_attr_e('None',
                                                    'daam'); ?></option>
                                        </select>
                                        <div class="help-icon"
                                             title='<?php esc_attr_e('The taxonomy for which you want to retrieve the terms.',
                                                 'daam'); ?>'></div>
                                    </td>
                                </tr>

                                <!-- Term <?php echo $i; ?> -->
                                <tr>
                                    <th scope="row"><?php esc_attr_e('Term', 'daam'); ?>&nbsp<?php echo $i; ?></th>
                                    <td>
                                        <select id="term-<?php echo $i; ?>" name="term_<?php echo $i; ?>"
                                                class="daext-display-none">
                                            <option value="0" class="default"><?php esc_attr_e('None',
                                                    'daam'); ?></option>
                                        </select>
                                        <div class="help-icon"
                                             title='<?php esc_attr_e('The term that will be compared with the ones available on the posts where the autolinks are applied.',
                                                 'daam'); ?>'></div>
                                    </td>
                                </tr>

                                <?php

                            }

                            ?>

                        </table>

                        <!-- submit button -->
                        <div class="daext-form-action">
                            <input class="button" type="submit"
                                   value="<?php esc_attr_e('Add Term Group', 'daam'); ?>">
                        </div>

                        <?php endif; ?>

                    </div>

            </form>

        </div>

    </div>

</div>

<!-- Dialog Confirm -->
<div id="dialog-confirm" title="<?php esc_attr_e('Delete the term group?', 'daam'); ?>" class="daext-display-none">
    <p><?php esc_attr_e('This term group will be permanently deleted and cannot be recovered. Are you sure?',
            'daam'); ?></p>
</div>