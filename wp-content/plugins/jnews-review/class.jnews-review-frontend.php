<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Theme JNews_Review
 */
Class JNews_Review_Frontend
{
    /**
     * @var JNews_Review_Frontend
     */
    private static $instance;

    /**
     * @return JNews_Review_Frontend
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
        add_filter('the_content',                       array($this, 'review_content'), 10);
        add_filter('the_content',                       array($this, 'review_content_widget'), 10);
        add_action('manage_posts_custom_column',        array($this, 'post_custom_column'));
    }

    public function review_content_widget($content)
    {
        if(vp_metabox('jnews_review.enable_review', false))
        {
            $split_post = vp_metabox('jnews_post_split.enable_post_split', false);

            if($split_post)
            {
                return $content;
            }

            if(jnews_get_option('price_float_position', 'right') === 'right')
            {
                $post_review_floating = $this->post_review_float();
                $content = $post_review_floating . $content;
            }
        }

        return $content;
    }

    public function split_review($content, $index, $max_page)
    {
        if(vp_metabox('jnews_review.enable_review', false))
        {
            if (jnews_get_option('price_float_position', 'right') === 'right')
            {
                $post_review_floating = $this->post_review_float();
                $content = $post_review_floating . $content;
            }

            if($index == ( $max_page - 1 ))
            {
                return $this->render_review_content($content);
            }
        }

        return $content;
    }

    public function review_content($content)
    {
        if(vp_metabox('jnews_review.enable_review', false))
        {
            // if split post, we need to leave the post to it should be
            $split_post = vp_metabox('jnews_post_split.enable_post_split', false);

            if($split_post)
            {
                return $content;
            }

            // check multipage
            global $page, $numpages, $multipage;

            if( $multipage )
            {
                if ($page === $numpages)
                {
                    return $this->render_review_content($content);
                }
            } else
            {
                return $this->render_review_content($content);
            }
        }
        return $content;
    }

    public function render_review_content($content)
    {
        $post_review = $this->post_review();
        $content = $content . $post_review;
        return $content;
    }

    public function get_rating_class($score)
    {
        if($score >= 9 ) {
            return "score_good";
        }
        if($score >= 8 && $score < 9) {
            return "score_good";
        }
        if($score >= 6 && $score < 8) {
            return "score_avg";
        }

        return "score_bad";
    }

    public function review_bar_percentage($widget = false)
    {
        $review_rating = vp_metabox('jnews_review.rating');
        $review_bar = $review_bar_wrapper = $review_score = $barbg = null;

        if($review_rating)
        {
            foreach($review_rating as $rating)
            {
                if(!empty($rating['rating_text']))
                {
                    $rating_number = $rating['rating_number'] * 10;

                    if ($this->is_amp()) {
                        $review_score = "<span class=\"reviewscore\">". esc_html($rating_number) . '%' ."</span>";
                        $barbg = "<span style=\"width: ". esc_attr($rating_number) ."%\" class=\"barbg\"></span>";
                    } else {
                        $review_score = "<span class=\"reviewscore\">0%</span>";
                        $barbg = "<span data-width=\"". esc_attr($rating_number) ."\" class=\"barbg\"></span>";
                    }

                    $review_bar .=
                        "<li>
                        <strong>" . esc_html($rating['rating_text']) . "</strong>
                        {$review_score}
                        <div class=\"jeg_reviewbar_wrap\">
                            {$barbg}
                        </div>
                    </li>";
                }
            }
        }

        if($review_bar) {
            if($widget) {
                $review_bar_wrapper =
                    "<div class=\"jeg_reviewscore jeg_reviewbars clearfix\" data-scoretype=\"percent\">                    
                        <ul>{$review_bar}</ul>
                    </div>";
            } else {
                $review_bar_wrapper =
                    "<div class=\"jeg_reviewscore jeg_reviewbars clearfix\" data-scoretype=\"percent\">
                    <h3>". jnews_return_translation('Review Breakdown', 'jnews-review', 'review_breakdown') ."</h3>
                    <ul>{$review_bar}</ul>
                </div>";
            }
        }

        return $review_bar_wrapper;
    }

    public function review_bar_point($widget = false)
    {
        $review_rating = vp_metabox('jnews_review.rating');
        $review_bar = $review_bar_wrapper = null;

        if($review_rating)
        {
            foreach($review_rating as $rating)
            {
                if(!empty($rating['rating_text']))
                {
                    $rating_number = $rating['rating_number'] * 10;

                    if ($this->is_amp()) {
                        $review_score = "<span class=\"reviewscore\">". esc_attr($rating['rating_number']) ."</span>";
                        $barbg = "<span style=\"width: ". esc_attr($rating_number) ."%\" class=\"barbg\"></span>";
                    } else {
                        $review_score = "<span class=\"reviewscore\">0</span>";
                        $barbg = "<span data-width=\"". esc_attr($rating_number) ."\" class=\"barbg\"></span>";
                    }

                    $review_bar .=
                        "<li>
                        <strong>" . esc_html($rating['rating_text']) . "</strong>
                        {$review_score}
                        <div class=\"jeg_reviewbar_wrap\">
                            {$barbg}
                        </div>
                    </li>";
                }
            }
        }

        if($review_bar) {
            if ($widget) {
                $review_bar_wrapper =
                    "<div class=\"jeg_reviewscore jeg_reviewbars clearfix\" data-scoretype=\"point\">                    
                    <ul>{$review_bar}</ul>
                </div>";

            } else {

                $review_bar_wrapper =
                    "<div class=\"jeg_reviewscore jeg_reviewbars clearfix\" data-scoretype=\"point\">
                    <h3>" . jnews_return_translation('Review Breakdown', 'jnews-review', 'review_breakdown') . "</h3>
                    <ul>{$review_bar}</ul>
                </div>";
            }
        }

        return $review_bar_wrapper;
    }

    public function review_bar_star($widget = false)
    {
        $review_rating = vp_metabox('jnews_review.rating');
        $review_bar = $review_bar_wrapper = null;

        if($review_rating) {

            foreach($review_rating as $rating)
            {
                if(!empty($rating['rating_text']))
                {
                    $rating_number = $rating['rating_number'];
                    $rating_star = '';

                    for ($i = 1; $i <= 5; $i++) {
                        if ($rating_number >= 1.5) {
                            $rating_star .= "<i class=\"fa fa-star\"></i>";
                        }

                        if ($rating_number >= 0.5 && $rating_number < 1.5) {
                            $rating_star .= "<i class=\"fa fa-star-half-o\"></i>";
                        }

                        if ($rating_number < 0.5) {
                            $rating_star .= "<i class=\"fa fa-star-o\"></i>";
                        }

                        $rating_number = $rating_number - 2;
                    }

                    $review_bar .=
                        "<li>
                    <strong>" . esc_html($rating['rating_text']) . "</strong>
                    <div class=\"reviewscore\">
                        {$rating_star}
                    </div>
                </li>";
                }
            }
        }

        if($review_bar) {
            if ($widget) {
                $review_bar_wrapper =
                    "<div class=\"jeg_reviewscore jeg_reviewstars clearfix\">                    
                    <ul>{$review_bar}</ul>
                </div>";
            } else {
                $review_bar_wrapper =
                    "<div class=\"jeg_reviewscore jeg_reviewstars clearfix\">
                    <h3>" . jnews_return_translation('Review Breakdown', 'jnews-review', 'review_breakdown') . "</h3>
                    <ul>{$review_bar}</ul>
                </div>";
            }
        }

        return $review_bar_wrapper;
    }

    public function is_review_rating_empty()
    {
        $review_rating = vp_metabox('jnews_review.rating');
        $result = true;

        if($review_rating)
        {
            foreach ($review_rating as $rating)
            {
                if (!empty($rating['rating_text'])) {
                    return false;
                }
            }
        }

        return $result;
    }

    public function review_score_point($widget = false)
    {
        if(!$this->is_review_rating_empty())
        {
            $rating_value = get_post_meta(get_the_ID(), 'jnew_rating_mean', true);
            $rating_class = $this->get_rating_class($rating_value);
            $rating_mean = round($rating_value, 1);

            if ($widget) {
                $review_score_wrapper =
                    "<div class=\"average_review_score {$rating_class}\">
                    <h3 class='average_score'>" . jnews_return_translation('Average Score', 'jnews-review', 'avg_score') . "</h3>
                    <div class=\"score_value\">" . esc_html($rating_mean) . "</div>                    
                </div>";
            } else {
                $review_score_wrapper =
                    "<div class=\"review_score {$rating_class}\">
                    <span class=\"score_value\">" . esc_html($rating_mean) . "</span>
                    <span class=\"score_text\">" . jnews_return_translation('Score', 'jnews-review', 'score') . "</span>
                </div>";
            }

            return $review_score_wrapper;
        }
        return null;
    }

    public function review_score_star($widget = false)
    {
        if(!$this->is_review_rating_empty())
        {
            $rating_value = get_post_meta(get_the_ID(), 'jnew_rating_mean', true);
            $rating_class = $this->get_rating_class($rating_value);
            $rating_mean = round($rating_value / 2, 1);

            if ($widget) {
                $review_score_wrapper =
                    "<div class=\"average_review_score {$rating_class}\">
                    <h3 class='average_score'>" . jnews_return_translation('Average Score', 'jnews-review', 'avg_score') . "</h3>
                    <div class=\"score_value\">" . esc_html($rating_mean) . "</div>                    
                </div>";
            } else {
                $review_score_wrapper =
                    "<div class=\"review_score {$rating_class}\">
                    <span class=\"score_value\">" . esc_html($rating_mean) . "</span>
                    <span class=\"score_text\">" . jnews_return_translation('Score', 'jnews-review', 'score') . "</span>
                </div>";
            }

            return $review_score_wrapper;
        }

        return null;
    }

    public function review_score_percentage($widget = false)
    {
        if(!$this->is_review_rating_empty())
        {
            $rating_value = get_post_meta(get_the_ID(), 'jnew_rating_mean', true);
            $rating_class = $this->get_rating_class($rating_value);
            $rating_mean = round($rating_value * 10, 0);

            if($widget) {
                $review_score_wrapper =
                    "<div class=\"average_review_score {$rating_class}\">
                    <h3 class='average_score'>" . jnews_return_translation('Average Score', 'jnews-review', 'avg_score') . "</h3>
                    <div class=\"score_value\">" . esc_html($rating_mean) . "<span class=\"percentsym\">%</span> </div>
                </div>";
            } else {
                $review_score_wrapper =
                    "<div class=\"review_score {$rating_class}\">
                    <span class=\"score_value\">" . esc_html($rating_mean) . "<span class=\"percentsym\">%</span> </span>
                    <span class=\"score_text\">" . jnews_return_translation('Score', 'jnews-review', 'score') . "</span>
                </div>";
            }

            return $review_score_wrapper;
        }

        return null;
    }

    public function product_pros()
    {
        $pros = vp_metabox('jnews_review.good');
        $output = '';

        if($pros) {
            foreach($pros as $pro) {
                if(!empty($pro['good_text'])) {
                    $output .= "<li><i class=\"jegicon-check\"></i> " . $pro['good_text'] . "</li>";
                }
            }
        }

        if(!empty($output)) {
            $output =
                "<div class=\"conspros\">
                    <h3>" . jnews_return_translation('PROS', 'jnews-review', 'pros') . "</h3>
                    <ul>{$output}</ul>
                </div>";
        }

        return $output;
    }

    public function product_cons()
    {
        $cons = vp_metabox('jnews_review.bad');
        $output = '';

        if($cons) {
            foreach($cons as $con) {
                if(!empty($con['bad_text'])) {
                    $output .= "<li><i class=\"jegicon-cross\"></i> " . $con['bad_text'] . "</li>";
                }
            }
        }

        if(!empty($output)) {
            $output =
                "<div class=\"conspros\">
                    <h3>" . jnews_return_translation('CONS', 'jnews-review', 'cons') . "</h3>
                    <ul>{$output}</ul>
                </div>";
        }

        return $output;
    }

    public function post_review_float()
    {
        $product_name = vp_metabox('jnews_review.name');
        $prices = vp_metabox('jnews_review.price');
        $output = '';

        if($prices) {
            foreach($prices as $price)
            {
                if( ! empty($price['shop']) && ! empty($price['price']) )
                {
                    if(!empty($price['link'])) {
                        $output .=
                            "<li>
                                <a href=\"{$price['link']}\" target=\"_blank\" class=\"storename\">{$price['shop']}</a>
                                <div class=\"priceinfo\">
                                    <a href=\"{$price['link']}\" target=\"_blank\" class=\"price\">" . jnews_review_get_price($price['price']) ."</a>
                                    <a href=\"{$price['link']}\" target=\"_blank\" class=\"productlink\">" . jnews_return_translation('VIEW', 'jnews-review', 'view') . "</a>
                                </div>
                            </li>";
                    } else {
                        $output .=
                            "<li>
                                <a href=\"#\" class=\"storename\">{$price['shop']}</a>
                                <div class=\"priceinfo\">
                                    <a href=\"#\" class=\"price\">" . jnews_review_get_price($price['price']) . "</a>
                                </div>
                            </li>";
                    }
                }
            }
        }

        if(!empty($output))
        {
            $output =
                "<div class=\"jeg_deals jeg_deals_float clearfix\">
                    <div class=\"jeg_dealsheader clearfix\">
                        <div class=\"dealstitle\">
                            <h3>" .  sprintf(jnews_return_translation("%s DEALS", 'jnews-review', 's_DEALS'), $product_name) . "</h3>
                        </div>
                    </div>
                    <div class=\"jeg_storeinfo\">
                        <ul class=\"jeg_storelist\">
                            {$output}
                        </ul>
                    </div>
                </div>";
        }

        return $output;
    }

    public function product_price($widget = false)
    {
        $product_name = vp_metabox('jnews_review.name');
        $prices = vp_metabox('jnews_review.price');
        $lowest_price = PHP_INT_MAX;
        $lowest_link =  $output = '';

        if($prices)
        {
            foreach($prices as $price)
            {
                if( ! empty($price['shop']) && ! empty($price['price']) )
                {
                    $price['price'] = floatval($price['price']);
                    $icon = '';

                    if ( isset($price['icon']) && $price['icon'] )
                    {
                        $shop_icon = wp_get_attachment_image_src($price['icon'], 'full');
                        $icon = "<img class='store-icon' src={$shop_icon[0]} alt='{$price['shop']}'/>";
                    };

                    if(!empty($price['link']))
                    {
                        $output .=
                            "<li>
                                <a href=\"{$price['link']}\" target=\"_blank\" class=\"storename\">
                                    {$icon} {$price['shop']}
                                </a>
                                <div class=\"priceinfo\">
                                    <a href=\"{$price['link']}\" target=\"_blank\" class=\"price\">" . jnews_review_get_price($price['price']) ."</a>
                                    <a href=\"{$price['link']}\" target=\"_blank\" class=\"productlink\">" . jnews_return_translation('Buy Now', 'jnews-review', 'buy_now') . "</a>
                                </div>
                            </li>";
                    } else {
                        $output .=
                            "<li>
                                <a href=\"#\" class=\"storename\">
                                    {$icon} {$price['shop']}
                                </a>
                                <div class=\"priceinfo\">
                                    <a href=\"#\" class=\"price\">" . jnews_review_get_price($price['price']) . "</a>
                                </div>
                            </li>";
                    }

                    if($lowest_price > $price['price'])
                    {
                        $lowest_price = $price['price'];
                        $lowest_link = $price['link'];
                    }
                }
            }
        }

        if(!empty($output))
        {
            $lowest_price = floatval(get_post_meta(get_the_ID(), 'jnews_price_lowest', true));

            if($widget) {
                $output =
                    "<div class=\"jeg_deals clearfix\">
                        <div class=\"jeg_dealsheader clearfix\">
                            <h3>" . jnews_return_translation('Best Price', 'jnews-review', 'best_price') . "</h3>
                            <strong class=\"price\">" . jnews_review_get_price($lowest_price) . "</strong>
                            <a href=\"{$lowest_link}\" class=\"buy-now-deals clearfix\">" .  jnews_return_translation('Buy Now', 'jnews-review', 'buy_now')  . "</a>
                        </div>
                        <div class=\"jeg_storeinfo\">
                            <ul class=\"jeg_storelist\">
                                {$output}
                            </ul>
                        </div>
                    </div>";
            } else {
                $output =
                    "<div class=\"jeg_deals clearfix\">
                        <div class=\"jeg_dealsheader clearfix\">
                            <div class=\"dealstitle\">
                                <h3>" . sprintf(jnews_return_translation("%s DEALS", 'jnews-review', 's_DEALS'), $product_name) . "</h3>
                                <p>" . jnews_return_translation('We collect information from many stores for best price available', 'jnews-review', 'best_price_available') . "</p>
                            </div>
                            <div class=\"bestprice\">
                                <h4>" . jnews_return_translation('Best Price', 'jnews-review', 'best_price') . "</h4>
                                <strong class=\"price\">" . jnews_review_get_price($lowest_price) . "</strong>
                            </div>
                        </div>
                        <div class=\"jeg_storeinfo\">
                            <ul class=\"jeg_storelist\">
                                {$output}
                            </ul>
                        </div>
                    </div>";
            }
        }

        return $output;
    }

    public function post_review()
    {
        $rating_type = vp_metabox('jnews_review.type');
        $product_name = vp_metabox('jnews_review.name');
        $product_description = vp_metabox('jnews_review.summary');

        switch($rating_type) {
            case "point" :
                $review_bar = $this->review_bar_point();
                $review_score = $this->review_score_point();
                break;
            case "star" :
                $review_bar = $this->review_bar_star();
                $review_score = $this->review_score_star();
                break;
            case "percentage" :
            default:
                $review_bar = $this->review_bar_percentage();
                $review_score = $this->review_score_percentage();
        }

        $additional_style = $this->is_review_rating_empty() ? 'padding-left: 0' : '';

        $output  =
            "<div class=\"jeg_review_wrap\">
                <h3 class=\"jeg_review_subtitle\">" . jnews_return_translation('The Review', 'jnews-review', 'the_review') . "</h3>
                <h2 class=\"jeg_review_title\">
                    " . esc_html($product_name) . "
                </h2>
                <div class=\"jeg_reviewheader clearfix\">
                    {$review_score}
                    <div class=\"desc\"  style='{$additional_style}'>
                        <p>" . esc_html($product_description) . "</p>
                    </div>
                </div>
                <div class=\"jeg_reviewdetail clearfix\">
                    " . $this->product_pros() . "
                    " . $this->product_cons() . "
                </div>
                {$review_bar}
                " . $this->product_price() . "
            </div>";

        return $output;
    }

    public function review_list($option)
    {
        $review_html = '';
        $query = new WP_Query(array(
            'post_type'             => 'post',
            'post_status'			=> array('publish'),
            'posts_per_page'        => $option['limit'],
            'meta_query'            => array(
                'relation' => 'AND',
                array(
                    'key'     => 'enable_review',
                    'value'   => '1',
                ),
                array(
                    'key'     => 'jnew_rating_mean',
                    'value'   => '0',
                    'compare' => '>',
                ),
            )
        ));

        add_filter( 'excerpt_length', array($this, 'review_excerpt_length'));
        add_filter( 'excerpt_more', array($this, 'review_excerpt_more'));

        if ( $query->have_posts() )
        {
            while ( $query->have_posts() )
            {
                $query->the_post();
                $review_html .= $this->review_list_item($query->post);
            }
        }

        wp_reset_postdata();

        remove_filter( 'excerpt_length', array($this, 'review_excerpt_length'));
        remove_filter( 'excerpt_more', array($this, 'review_excerpt_more'));

        return $review_html;
    }

    public function review_list_item($post)
    {
        $title          = vp_metabox('jnews_review.name');
        $permalink      = get_the_permalink($post);
        $thumbnail      = apply_filters('jnews_image_thumbnail', $post->ID, 'jnews-120x86');
        $review         = jnews_review_generate_rating(null, $post->ID, '');
        $lowest_price   = get_post_meta($post->ID, 'jnews_price_lowest', true);
        $excerpt        = wp_trim_words(vp_metabox('jnews_review.summary'), 11, '');
        $price_html     = '';

        if($lowest_price) {
            $price_html = "<a class=\"jeg_price_review_list\" href=\"$permalink\">" . jnews_review_get_price($lowest_price) . "</a>";
        }

        $output =
            "<div " . jnews_post_class("jeg_post jeg_pl_sm", $post->ID) . ">
                <div class=\"jeg_thumb\">
                    " . jnews_edit_post( $post->ID ) . "
                    <a href=\"{$permalink}\">{$thumbnail}</a>
                </div>
                <div class=\"jeg_postblock_content\">
                    <h2 class=\"jeg_post_title\"><a property=\"url\" href=\"{$permalink}\">{$title}</a></h2>
                    <div class=\"jeg_description\">" . $excerpt . " {$price_html}</div>
                    <div class=\"jeg_review_list_rating\">{$review}</div>                   
                </div>
            </div>";

        return $output;
    }


    function review_excerpt_length()
    {
        return 10;
    }

    function review_excerpt_more()
    {
        return '';
    }

    private function is_amp()
    {
        $is_amp = false;
        if (function_exists('is_amp_endpoint')) {
            $is_amp = is_amp_endpoint();
        }

        return $is_amp;
    }

    public function widget_rating()
    {
        $rating_type = vp_metabox('jnews_review.type');

        switch($rating_type) {
            case "point" :
                $review_score = $this->review_score_point(true);
                $review_bar = $this->review_bar_point(true);
                break;
            case "star" :
                $review_score = $this->review_score_star(true);
                $review_bar = $this->review_bar_star(true);
                break;
            case "percentage" :
            default:
                $review_score = $this->review_score_percentage(true);
                $review_bar = $this->review_bar_percentage(true);
        }

        return $review_score . $review_bar;
    }

    public function widget_description()
    {
        $product_description = vp_metabox('jnews_review.summary');
        return "<div class=\"jeg_review_summary \">{$product_description}</div>";
    }

    public function widget_procons()
    {
        return
            "<div class=\"jeg_review_procons\">
                " . $this->product_pros() . "
                " . $this->product_cons() . "
            </div>";
    }

    public function widget_price()
    {
        return $this->product_price(true);
    }
}