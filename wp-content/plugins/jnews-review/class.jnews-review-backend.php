<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Theme JNews_Review_Backend
 */
Class JNews_Review_Backend
{
    /**
     * @var JNews_Review_Backend
     */
    private static $instance;

    /**
     * @return JNews_Review_Backend
     */
    public static function getInstance()
    {
        if (null === static::$instance)
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        add_action('save_post',                         array($this, 'save_post_review') , 99);
        add_action('edit_post',                         array($this, 'save_post_review') , 99);
        add_filter('manage_edit-post_columns',          array($this, 'post_column'), 9);
        add_action('manage_posts_custom_column',        array($this, 'post_custom_column'));
    }

    public function post_custom_column($name)
    {
        global $post;

        switch($name) {
            case 'review' :
                $output = '';
                if(vp_metabox('jnews_review.enable_review', false))
                {
                    $output = "<div class='jnews-admin-review review-enabled'>" . esc_html__('Post Review','jnews-review') . "</div>";
                } else {
                    $output = "<div class='jnews-admin-review review-disabled'>" . esc_html__('Standard','jnews-review') . "</div>";
                }
                echo jnews_sanitize_output( $output );
                break;
        }
    }

    public function post_column($columns)
    {
        $columns['review'] = 'Post Type';
        return $columns;
    }

    public function save_post_review()
    {
        global $post;

        if(isset($post->post_type) && $post->post_type == 'post')
        {
            if(isset($_REQUEST['jnews_review']))
            {
                // rating
                $ratingarray = $_REQUEST['jnews_review']['rating'];
                $total = $numberofrating = 0;

                if(is_array($ratingarray)) {

                    foreach ($ratingarray as $rating)
                    {
                        if ($rating['rating_number'] != 0 && !empty($rating['rating_text']))
                        {
                            $total += $rating['rating_number'];
                            $numberofrating++;
                        }
                    }

                    if($numberofrating > 0)
                    {
                        $mean = $total / $numberofrating;
                        $mean = round($mean, 1);
                        update_post_meta($post->ID, 'jnew_rating_mean', $mean);
                    }
                }
            }


            if(isset($_REQUEST['jnews_review']['price']))
            {
                // price lowest
                $pricearray = $_REQUEST['jnews_review']['price'];
                $lowest = 9999999999;
                $changed = false;
                foreach($pricearray as $price){
                    if($price['price'] != 0) {
                        if($price['price'] < $lowest) {
                            $lowest = $price['price'];
                            $changed = true;
                        }
                    }
                }
                if($changed) {
                    update_post_meta($post->ID, 'jnews_price_lowest', $lowest);
                } else {
                    update_post_meta($post->ID, 'jnews_price_lowest', 0);
                }
            }

        }
        return true;
    }


    private function is_amp()
    {
        $is_amp = false;
        if (function_exists('is_amp_endpoint')) {
            $is_amp = is_amp_endpoint();
        }

        return $is_amp;
    }
}