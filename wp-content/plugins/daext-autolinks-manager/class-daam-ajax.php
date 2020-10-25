<?php

/*
 * This class should be used to include ajax actions.
 */

class Daam_Ajax
{

    protected static $instance = null;
    private $shared = null;

    private function __construct()
    {

        //assign an instance of the plugin info
        $this->shared = Daam_Shared::get_instance();

        //AJAX requests for logged-in and not-logged-in users
        add_action('wp_ajax_daam_track_click', array($this, 'daam_track_click'));
        add_action('wp_ajax_nopriv_daam_track_click', array($this, 'daam_track_click'));

        //AJAX requests for logged-in users
        add_action('wp_ajax_daam_wizard_generate_autolinks', array($this, 'daam_wizard_generate_autolinks'));
        add_action('wp_ajax_daam_generate_statistics', array($this, 'daam_generate_statistics'));
        add_action('wp_ajax_daam_get_taxonomies', array($this, 'daam_get_taxonomies'));
        add_action('wp_ajax_daam_get_terms', array($this, 'daam_get_terms'));

    }

    /*
     * Return an istance of this class.
     */
    public static function get_instance()
    {

        if (null == self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;

    }

    /*
     * Ajax handler used to generate the autolinks based on the data available in the table of the Wizard menu.
     *
     * This method is called when the "Generate Autolinks" button available in the Wizard menu is clicked.
     */
    public function daam_wizard_generate_autolinks()
    {

        //check the referer
        if ( ! check_ajax_referer('daam', 'security', false)) {
            echo "Invalid AJAX Request";
            die();
        }

        //check the capability
        if ( ! current_user_can(get_option($this->shared->get('slug') . "_capabilities_wizard_menu"))) {
            echo 'Invalid Capability';
            die();
        }

        //get the default values of the autolink from the plugin options
        $defaults_title                 = get_option($this->shared->get('slug') . '_defaults_title');
        $defaults_open_new_tab          = get_option($this->shared->get('slug') . '_defaults_open_new_tab');
        $defaults_use_nofollow          = get_option($this->shared->get('slug') . '_defaults_use_nofollow');
        $defaults_case_sensitive_search = get_option($this->shared->get('slug') . '_defaults_case_sensitive_search');
        $defaults_limit                 = get_option($this->shared->get('slug') . '_defaults_limit');
        $defaults_priority              = get_option($this->shared->get('slug') . '_defaults_priority');
        $defaults_left_boundary         = get_option($this->shared->get('slug') . '_defaults_left_boundary');
        $defaults_right_boundary        = get_option($this->shared->get('slug') . '_defaults_right_boundary');
        $defaults_keyword_before        = get_option($this->shared->get('slug') . '_defaults_keyword_before');
        $defaults_keyword_after         = get_option($this->shared->get('slug') . '_defaults_keyword_after');
        $defaults_post_types            = get_option($this->shared->get('slug') . '_defaults_post_types');
        $defaults_categories            = get_option($this->shared->get('slug') . '_defaults_categories');
        $defaults_tags                  = get_option($this->shared->get('slug') . '_defaults_tags');
        $defaults_term_group_id         = get_option($this->shared->get('slug') . '_defaults_term_group_id');

        //get the name
        $name = trim(stripslashes($_POST['name']));

        //get the category_id
        $category_id = intval($_POST['category_id']);

        //get the data of the table
        $table_data_a = json_decode(stripslashes($_POST['table_data']));

        //Validation ---------------------------------------------------------------------------------------------------
        if (strlen($name) === 0 or strlen($name) > 100) {
            echo 'invalid name';
            die();
        }

        global $wpdb;
        $table_name = $wpdb->prefix . $this->shared->get('slug') . "_autolink";

        //add the new data
        $values        = array();
        $place_holders = array();
        $query         = "INSERT INTO $table_name (
            name,
            category_id,
            keyword,
            url,
            title,
            open_new_tab,
            use_nofollow,
            case_sensitive_search,
            `limit`,
            priority,
            left_boundary,
            right_boundary,
            keyword_before,
            keyword_after,
            post_types,
            categories,
            tags,
            term_group_id
        ) VALUES ";

        //Set the PHP "Max Execution Time" and "Memory Limit" based on the values defined in the options
        $this->shared->set_met_and_ml();

        foreach ($table_data_a as $row_index => $row_data) {

            $keyword = $row_data[0];
            $url = $row_data[1];

            //Do not allow an empty keyword
            if (mb_strlen($keyword) === 0 or !preg_match($this->shared->url_regex, $url)) {
                continue;
            }

            //Do not allow an URL not validated by the related regex
            if (!preg_match($this->shared->url_regex, $url)) {
                continue;
            }

            /*
             * Do not allow only numbers as a keyword. Only numbers in a keyword would cause the index of the protected block to
             * be replaced. For example the keyword "1" would cause the "1" present in the index of the following protected
             * blocks to be replaced with an autolink:
             *
             * - [pb]1[/pb]
             * - [pb]31[/pb]
             * - [pb]812[/pb]
             */
            if(preg_match('/^\d+$/', $keyword) === 1){
                continue;
            }

            /*
             * Do not allow to create specific keyword that would be able to replace the start delimiter or the protected block
             * [pb], part of the start delimiter, the end delimited [/pb] or part of the end delimiter.
             */
            if(preg_match('/^\[$|^\[p$|^\[pb$|^\[pb]$|^\[\/$|^\[\/p$|^\[\/pb$|^\[\/pb\]$|^\]$|^b\]$|^pb\]$|^\/pb\]$|^p$|^pb$|^pb\]$|^\/$|^\/p$|^\/pb$|^\/pb]$|^b$|^b\$]/i', $keyword) === 1){
                continue;
            }

            /*
             * Do not allow to create specific keyword that would be able to replace the start delimiter of the autolink [al],
             * part of the start delimiter, the end delimited [/al] or part of the end delimiter.
             */
            if(preg_match('/^\[$|^\[a$|^\[al$|^\[al]$|^\[\/$|^\[\/a$|^\[\/al$|^\[\/al\]$|^\]$|^l\]$|^al\]$|^\/al\]$|^a$|^al$|^al\]$|^\/$|^\/a$|^\/al$|^\/al]$|^l$|^l\$]/i', $keyword) === 1){
                continue;
            }

            array_push($values,
                $name,
                $category_id,
                $keyword,
                $url,
                $defaults_title,
                $defaults_open_new_tab,
                $defaults_use_nofollow,
                $defaults_case_sensitive_search,
                $defaults_limit,
                $defaults_priority,
                $defaults_left_boundary,
                $defaults_right_boundary,
                $defaults_keyword_before,
                $defaults_keyword_after,
                maybe_serialize($defaults_post_types),
                maybe_serialize($defaults_categories),
                maybe_serialize($defaults_tags),
                $defaults_term_group_id
            );

            $place_holders[] = "(
            '%s',
            '%d',
            '%s',
            '%s',
            '%s',
            '%d',
            '%d',
            '%d',
            '%d',
            '%d',
            '%d',
            '%d',
            '%s',
            '%s',
            '%s',
            '%s',
            '%s',
            '%d'
            )";

        }

        if (count($values) > 0) {

            //Add the rows
            $query    .= implode(', ', $place_holders);
            $safe_sql = $wpdb->prepare("$query ", $values);
            $result   = $wpdb->query($safe_sql);

            if ($result === false) {
                $output = 'error';
            } else {
                $output = $result;
            }

        } else {

            //Do not add the rows and returns 0 as the number of rows added
            return 0;

        }

        //send output
        echo $output;
        die();

    }

    /*
     * Generates the data of the "statistic" table.
     */
    public function daam_generate_statistics()
    {

        //check the referer
        if ( ! check_ajax_referer('daam', 'security', false)) {
            echo 'Invalid AJAX Request';
            die();
        }

        //check the capability
        if ( ! current_user_can(get_option($this->shared->get('slug') . "_capabilities_statistics_menu"))) {
            esc_attr('Invalid Capability', 'daam');
            die();
        }

        /*
         * Set the custom "Max Execution Time Value" defined in the options if the "Set Max Execution Time" option is
         * set to "Yes".
         */
        if (intval(get_option($this->shared->get('slug') . '_analysis_set_max_execution_time'), 10) === 1) {
            ini_set('max_execution_time',
                intval(get_option($this->shared->get('slug') . '_analysis_max_execution_time_value'), 10));
        }

        /*
         * Set the custom "Memory Limit Value" ( in megabytes ) defined in the options if the "Set Memory Limit" option
         * is set to "Yes".
         */
        if (intval(get_option($this->shared->get('slug') . '_analysis_set_memory_limit'), 10) == 1) {
            ini_set('memory_limit',
                intval(get_option($this->shared->get('slug') . "_analysis_memory_limit_value"), 10) . 'M');
        }

        //delete all the records in the "statistic" db table
        global $wpdb;
        $table_name = $wpdb->prefix . $this->shared->get('slug') . "_statistic";
        $result     = $wpdb->query("TRUNCATE TABLE $table_name");

        //Get post types
        $post_types_query      = '';
        $analysis_post_types_a = maybe_unserialize(get_option($this->shared->get('slug') . '_analysis_post_types'));

        //if $post_types_a is not an array fill $post_types_a with the posts available in the website
        if ( ! is_array($analysis_post_types_a)) {
            $analysis_post_types_a = $this->shared->get_post_types_with_ui();
        }

        //Generate the $post_types_query
        if (is_array($analysis_post_types_a)) {

            foreach ($analysis_post_types_a as $key => $value) {

                $post_types_query .= "post_type = '" . $value . "'";
                if ($key !== (count($analysis_post_types_a) - 1)) {
                    $post_types_query .= ' OR ';
                }

            }

            $post_types_query = '(' . $post_types_query . ') AND';

        }

        //Generates the data of all the posts and save them in the $statistic_a array.
        global $wpdb;
        $table_name           = $wpdb->prefix . "posts";
        $limit_posts_analysis = intval(get_option($this->shared->get('slug') . '_analysis_limit_posts_analysis'), 10);
        $safe_sql             = "SELECT ID, post_title, post_type, post_date, post_content FROM $table_name WHERE $post_types_query post_status = 'publish' ORDER BY post_date DESC LIMIT " . $limit_posts_analysis;
        $posts_a              = $wpdb->get_results($safe_sql, ARRAY_A);

        //init $statistic_a
        $statistic_a = array();

        foreach ($posts_a as $key => $single_post) {

            //Post Id
            $post_id = $single_post['ID'];

            //Content Length
            $content_length = mb_strlen(trim($single_post['post_content']));

            //Auto Links
            $this->shared->add_autolinks($single_post['post_content'], false,
                $single_post['post_type'], $post_id);
            $auto_links = $this->shared->number_of_replacements;

            //Auto Links Visits
            $auto_links_visits = $this->shared->get_number_of_auto_links_clicks($single_post['ID']);

            /*
             * save data in the $statistic_a array (the data will be later saved into the statistic db table )
             */
            $statistic_a[] = array(
                'post_id'           => $post_id,
                'content_length'    => $content_length,
                'auto_links'        => $auto_links,
                'auto_links_visits' => $auto_links_visits
            );

        }

        /*
         * Save data into the statistic db table with multiple queries of 100 items each one.
         *
         * It's a compromise adopted for the following two reasons:
         *
         * 1 - For performance, too many queries slow down the process
         * 2 - To avoid problem with queries too long
         */
        $table_name         = $wpdb->prefix . $this->shared->get('slug') . "_statistic";
        $statistic_a_length = count($statistic_a);
        $query_groups       = array();
        $query_index        = 0;
        foreach ($statistic_a as $key => $single_statistic) {

            $query_index = intval($key / 100, 10);

            $query_groups[$query_index][] = $wpdb->prepare("( %d, %d, %d, %d )",
                $single_statistic['post_id'],
                $single_statistic['content_length'],
                $single_statistic['auto_links'],
                $single_statistic['auto_links_visits']
            );

        }

        /*
         * Each item in the $query_groups array includes a maximum of 100 assigned records. Here each group creates a
         * query and the query is executed.
         */
        $query_start = "INSERT INTO $table_name (post_id, content_length, auto_links, auto_links_visits) VALUES ";
        $query_end   = '';

        foreach ($query_groups as $key => $query_values) {

            $query_body = '';

            foreach ($query_values as $single_query_value) {

                $query_body .= $single_query_value . ',';

            }

            $safe_sql = $query_start . substr($query_body, 0, mb_strlen($query_body) - 1) . $query_end;

            //save data into the archive db table
            $wpdb->query($safe_sql);

        }

        //send output
        echo 'success';
        die();

    }

    /*
     * Tracks the clicks performed on the front-end on the autolinks.
     */
    public function daam_track_click()
    {

        //check the referer
        if ( ! check_ajax_referer('daam', 'security', false)) {
            echo "Invalid AJAX Request";
            die();
        }

        //get the data
        $post_id     = $_POST['post_id'];
        $autolink_id = $_POST['autolink_id'];
        $user_ip     = $_SERVER["REMOTE_ADDR"];

        //get the minimum interval
        $minimum_interval = intval(get_option($this->shared->get('slug') . "_tracking_minimum_interval"), 10);

        //verify if there are tracked clicks submitted in the last $minimum_interval seconds
        global $wpdb;
        $table_name        = $wpdb->prefix . $this->shared->get('slug') . "_tracking";
        $past_time_gmt     = date("Y-m-d H:i:s", current_time('timestamp', 1) - $minimum_interval);
        $current_time_gmt  = current_time('mysql', 1);
        $safe_sql          = $wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE user_ip = %s AND date_gmt BETWEEN %s AND %s",
            $user_ip, $past_time_gmt, $current_time_gmt);
        $number_of_records = $wpdb->get_var($safe_sql);

        if (intval($number_of_records, 10) > 0) {
            echo 'rejected';
            die();
        }

        //save the click
        global $wpdb;
        $table_name = $wpdb->prefix . $this->shared->get('slug') . "_tracking";
        $safe_sql   = $wpdb->prepare("INSERT INTO $table_name SET 
                post_id = %d,
                autolink_id = %d,
                user_ip = %s,
                date = %s,
                date_gmt = %s",
            $post_id,
            $autolink_id,
            $user_ip,
            current_time('mysql', 0),
            current_time('mysql', 1)
        );

        $query_result = $wpdb->query($safe_sql);

        if ($query_result !== false) {
            echo "saved";
        } else {
            echo "error";
        }

        die();

    }

    /*
     * Get the list of taxonomies associated with the provided post type.
     */
    public function daam_get_taxonomies()
    {

        //check the referer
        if ( ! check_ajax_referer('daam', 'security', false)) {
            echo "Invalid AJAX Request";
            die();
        }

        //check the capability
        if ( ! current_user_can(get_option($this->shared->get('slug') . "_capabilities_term_groups_menu"))) {
            esc_attr('Invalid Capability', 'daam');
            die();
        }

        //get the data
        $post_type = addslashes($_POST['post_type']);

        $taxonomies = get_object_taxonomies($post_type);

        $taxonomy_obj_a = array();
        if (is_array($taxonomies) and count($taxonomies) > 0) {
            foreach ($taxonomies as $key => $taxonomy) {
                $taxonomy_obj_a[] = get_taxonomy($taxonomy);
            }
        }

        echo json_encode($taxonomy_obj_a);
        die();

    }

    /*
     * Get the list of terms associated with the provided taxonomy.
     */
    public function daam_get_terms()
    {

        //check the referer
        if ( ! check_ajax_referer('daam', 'security', false)) {
            echo "Invalid AJAX Request";
            die();
        }

        //check the capability
        if ( ! current_user_can(get_option($this->shared->get('slug') . "_capabilities_term_groups_menu"))) {
            esc_attr('Invalid Capability', 'daam');
            die();
        }

        //get the data
        $taxonomy = addslashes($_POST['taxonomy']);

        $terms = get_terms(array(
            'hide_empty' => 0,
            'orderby'    => 'term_id',
            'order'      => 'DESC',
            'taxonomy'   => $taxonomy
        ));

        if (is_object($terms) and get_class($terms) === 'WP_Error') {
            return '0';
        } else {
            echo json_encode($terms);
        }

        die();

    }

}