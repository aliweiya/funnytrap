<?php


Class JNews_Review_Shortcode_View extends \JNews\Module\ModuleViewAbstract
{

/*    public function jnews_review_shortcode( $atts ) {
        $a = shortcode_atts( array(
            'id' => '1',
            'rating' => false,
            'procons' => false,
            'bar' => false,
            'price' => false
        ), $atts );

        $attr['post_id_review'] = $a['id'];
        $attr['review_show_rating'] = $a['rating'];
        $attr['review_show_pros_cons'] = $a['procons'];
        $attr['review_show_breakdown'] = $a['bar'];
        $attr['review_show_price'] = $a['price'];
        $this->render_module($attr);

        add_shortcode('showreview','jnews_review_shortcode');
    }*/

/**
    RENDER MODULE ------------------------------------------------------------------------------------------------------
 */
    public function render_module($attr, $column_class)
    {
        $post_id = $attr['post_id_review'];
        $rating_type = vp_metabox('jnews_review.type', null, $post_id);
        $product_name = vp_metabox('jnews_review.name', null, $post_id);
        $product_description = vp_metabox('jnews_review.summary', null, $post_id);

        switch ($rating_type) {
            case "point" :
                $review_bar = $this->review_bar_point($post_id);
                $review_score = $this->review_score_point($post_id);
                break;
            case "star" :
                $review_bar = $this->review_bar_star($post_id);
                $review_score = $this->review_score_star($post_id);
                break;
            case "percentage" :
            default:
                $review_bar = $this->review_bar_percentage($post_id);
                $review_score = $this->review_score_percentage($post_id);
        }

        $additional_style = $this->is_review_rating_empty() ? 'padding-left: 0' : '';

        $output =
            "<div class=\"jeg_review_wrap\">
                <h2 class=\"jeg_review_title\">
                    " . esc_html($product_name) . "
                </h2>
                <div class=\"jeg_reviewheader clearfix\">";

        if ($attr['review_show_rating']) {
            $output = $output . "{$review_score}";
        }
        $output = $output."<div class=\"desc\"  style='{$additional_style}'>
                        <p>" . esc_html($product_description) . "</p>
                    </div>
                </div>";
        if ($attr['review_show_pros_cons']) {
            $output = $output . "<div class=\"jeg_reviewdetail clearfix\">
                    " . $this->product_pros($post_id) . "
                    " . $this->product_cons($post_id) . "
                </div>";
        }
        if ($attr['review_show_breakdown']) {
            $output = $output."{$review_bar}";
        }
        if ($attr['review_show_price']) {
            $output = $output. $this->product_price($post_id);
        }
        $output = $output."</div>";

        return $output;
    }


/**
    GET REVIEW RATING VALUE --------------------------------------------------------------------------------------------
 */
    public function is_the_rating_empty($post_id)
    {
        $review_rating = vp_metabox('jnews_review.rating',null,$post_id);
        $result = true;

        if($review_rating){
            foreach ($review_rating as $rating){
                if (!empty($rating['rating_text'])) {
                    $result = false;
                }
            }
        }

        return $result;
    }

    public function review_score_point($post_id)
    {
        $result = $this->is_the_rating_empty($post_id);

        if(!$result){
            $rating_value = get_post_meta($post_id, 'jnew_rating_mean', true);
            $rating_class = $this->get_rating_class($rating_value);
            $rating_mean = round($rating_value, 1);

            $review_score_wrapper =
                "<div class=\"review_score {$rating_class}\">
                <span class=\"score_value\">" . esc_html($rating_mean) . "</span>
                <span class=\"score_text\">" . jnews_return_translation('Score', 'jnews-review', 'score') . "</span>
            </div>";

            return $review_score_wrapper;
        }
        return null;
    }

    public function review_score_star($post_id)
    {
        $result = $this->is_the_rating_empty($post_id);

        if(!$result){
            $rating_value = get_post_meta($post_id, 'jnew_rating_mean', true);
            $rating_class = $this->get_rating_class($rating_value);
            $rating_mean = round($rating_value / 2, 1);

            $review_score_wrapper =
                "<div class=\"review_score {$rating_class}\">
                <span class=\"score_value\">" . esc_html($rating_mean) . "</span>
                <span class=\"score_text\">" . jnews_return_translation('Score', 'jnews-review', 'score') . "</span>
            </div>";

            return $review_score_wrapper;
        }

        return null;
    }

    public function review_score_percentage($post_id)
    {
        $result = $this->is_the_rating_empty($post_id);

        if(!$result){
            $rating_value = get_post_meta($post_id, 'jnew_rating_mean', true);
            $rating_class = $this->get_rating_class($rating_value);
            $rating_mean = round($rating_value * 10, 0);

            $review_score_wrapper =
                "<div class=\"review_score {$rating_class}\">
                <span class=\"score_value\">" . esc_html($rating_mean) . "<span class=\"percentsym\">%</span> </span>
                <span class=\"score_text\">" . jnews_return_translation('Score', 'jnews-review', 'score') . "</span>
            </div>";

            return $review_score_wrapper;
        }

        return null;
    }

    public function is_review_rating_empty()
    {
        $review_rating = vp_metabox('jnews_review.rating');
        $result = true;

        if($review_rating){
            foreach ($review_rating as $rating){
                if (!empty($rating['rating_text'])) {
                    return false;
                }
            }
        }

        return $result;
    }

/**
    GET PRODUCT PROS AND CONS ------------------------------------------------------------------------------------------
 */
    public function product_pros($post_id)
    {
        $pros = vp_metabox('jnews_review.good',null,$post_id);
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

    public function product_cons($post_id)
    {
        $cons = vp_metabox('jnews_review.bad',null,$post_id);
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

/**
    GET REVIEW BAR/BREAKDOWN VALUE -------------------------------------------------------------------------------------
 */
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
    public function review_bar_percentage($post_id)
    {
        $review_rating = vp_metabox('jnews_review.rating',null,$post_id);
        $review_bar = $review_bar_wrapper = $review_score = $barbg = null;

        if($review_rating) {
            foreach($review_rating as $rating) {
                if(!empty($rating['rating_text'])) {
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
            $review_bar_wrapper =
                "<div class=\"jeg_reviewscore jeg_reviewbars clearfix\" data-scoretype=\"percent\">
                    <h3>". jnews_return_translation('Review Breakdown', 'jnews-review', 'review_breakdown') ."</h3>
                    <ul>{$review_bar}</ul>
                </div>";
        }

        return $review_bar_wrapper;
    }

    public function review_bar_point($post_id)
    {
        $review_rating = vp_metabox('jnews_review.rating',null,$post_id);
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
            $review_bar_wrapper =
                "<div class=\"jeg_reviewscore jeg_reviewbars clearfix\" data-scoretype=\"point\">
                    <h3>" . jnews_return_translation('Review Breakdown', 'jnews-review', 'review_breakdown') . "</h3>
                    <ul>{$review_bar}</ul>
                </div>";
        }

        return $review_bar_wrapper;
    }

    public function review_bar_star($post_id)
    {
        $review_rating = vp_metabox('jnews_review.rating',null,$post_id);
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
            $review_bar_wrapper =
                "<div class=\"jeg_reviewscore jeg_reviewstars clearfix\">
                    <h3>" . jnews_return_translation('Review Breakdown', 'jnews-review', 'review_breakdown') . "</h3>
                    <ul>{$review_bar}</ul>
                </div>";
        }

        return $review_bar_wrapper;
    }

/**
    GET REVIEW PRICE VALUE ---------------------------------------------------------------------------------------------
 */
    public function product_price($post_id)
    {
        $product_name = vp_metabox('jnews_review.name',null,$post_id);
        $prices = vp_metabox('jnews_review.price',null,$post_id);
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
            $lowest_price = floatval(get_post_meta($post_id, 'jnews_price_lowest', true));

            /*if($widget) {
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
            } else {*/
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
            /*}*/
        }

        return $output;
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