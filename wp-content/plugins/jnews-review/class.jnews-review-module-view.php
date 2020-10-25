<?php
/**
 * @author : Jegtheme
 */

Class JNews_Element_Review_View extends \JNews\Module\ModuleViewAbstract
{
    public function select_category($attr)
    {
        $selected_category = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';
        $select_html = "<option value=''>" . jnews_return_translation('All Category', 'jnews-review', 'all_category') . "</option>";

        $categories = trim($attr['include_category']);
        if(!empty($categories))
        {
            $categories = explode(',', $categories);
            $categories = is_array($categories) ? $categories : array($categories);

            // Need to cache category first
            \JNews\Util\Cache::get_categories();

            foreach($categories as $category) {
                $cat = get_category(trim($category));
                $selected = ( $selected_category == $cat->term_id ) ? "selected='selected'" : '';
                $select_html .= "<option value='{$cat->term_id}' $selected>{$cat->name}</option>";
            }
        }

        return "<select name='category'>{$select_html}</select>";
    }

    public function select_sort()
    {
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '';
        $sort_html = '';

        $sort_option = array(
            'date-desc'     => jnews_return_translation('Newest First', 'jnews-review', 'newest_first'),
            'date-asc'      => jnews_return_translation('Oldest First', 'jnews-review', 'oldest_first'),
            'price-desc'    => jnews_return_translation('Highest Price', 'jnews-review', 'highest_price'),
            'price-asc'     => jnews_return_translation('Lowest Price', 'jnews-review', 'lowest_price'),
            'rating-desc'   => jnews_return_translation('Highest Rating', 'jnews-review', 'highest_rating'),
            'rating-asc'    => jnews_return_translation('Lowest Rating', 'jnews-review', 'lowest_rating'),
        );

        foreach ($sort_option as $key => $sorted) {
            $selected = ( $sort === $key ) ? "selected='selected'" : '';
            $sort_html .= "<option value='{$key}' $selected>{$sorted}</option>";
        }

        return "<select name='sort'>{$sort_html}</select>";
    }

    public function build_result($attr)
    {
        $keyword            = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
        $page               = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $sort               = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : '';
        $category           = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';
        $review_elements    = '';

        $statement = array(
            's'                     => esc_sql($keyword),
            'post_type'             => 'post',
            'post_status'			=> array('publish'),
            'posts_per_page'        => $attr['number_post'],
            'paged'                 => $page,
            'category__in'          => $category,
            'meta_query'            => array(
                'relation' => 'AND',
                array(
                    'key'     => 'enable_review',
                    'value'   => '1',
                ),
            )
        );

        // SORT BY
        switch($sort) {
            case 'date-desc' :
                $statement['orderby'] = 'date';
                $statement['order'] = 'desc';
                break;
            case 'date-asc' :
                $statement['orderby'] = 'date';
                $statement['order'] = 'asc';
                break;
            case 'price-desc' :
                $statement['orderby'] = 'meta_value_num';
                $statement['meta_key'] = 'jnews_price_lowest';
                $statement['order'] = 'desc';
                break;
            case 'price-asc' :
                $statement['orderby'] = 'meta_value_num';
                $statement['meta_key'] = 'jnews_price_lowest';
                $statement['order'] = 'asc';
                break;
            case 'rating-desc' :
                $statement['orderby'] = 'meta_value_num';
                $statement['meta_key'] = 'jnew_rating_mean';
                $statement['order'] = 'desc';
                break;
            case 'rating-asc' :
                $statement['orderby'] = 'meta_value_num';
                $statement['meta_key'] = 'jnew_rating_mean';
                $statement['order'] = 'asc';
                break;
        }

        $query = new \WP_Query( $statement );

        if ( $query->have_posts() )
        {
            while ( $query->have_posts() )
            {
                $query->the_post();
                $review_elements .= $this->review_item($query->post);
            }
        } else {
            $review_elements .= $this->review_no_item();
        }

        $pagination = jnews_paging_navigation(array(
            'pagination_mode' => 'nav_1',
            'pagination_align' => 'center',
            'pagination_navtext' => false,
            'pagination_pageinfo' => false,
            'total'     => $query->max_num_pages,
            'current'   => $page
        ));

        $output =
            "<div class='jeg_review_search_result'>
                {$review_elements}
            </div>
            <div class='jeg_review_search_paging'>
                {$pagination}
            </div>";


        wp_reset_postdata();

        return $output;
    }

    public function is_price_empty($prices)
    {
        foreach($prices as $price) {
            if( ! empty($price['shop']) && ! empty($price['price']) ) {
                return false;
            }
        }

        return true;
    }

    public function review_item($post)
    {
        $thumbnail = $this->get_thumbnail($post->ID, 'jnews-350x250');
        $lowest_price = get_post_meta(get_the_ID(), 'jnews_price_lowest', true);
        $prices = vp_metabox('jnews_review.price');
        $price_html = $shop_html = '';

        if(!$this->is_price_empty($prices))
        {
            foreach($prices as $idx => $price)
            {
                if( ! empty($price['shop']) && ! empty($price['price']) )
                {
                    $price['price'] = (int) $price['price'];
                    $price['link'] = !empty($price['link']) ? $price['link'] : '';
                    $icon = '';

                    if ( isset( $price['icon'] ) && $price['icon'] )
                    {
                        $shop_icon = wp_get_attachment_image_src($price['icon'], 'full');
                        $icon = "<img class='store-icon' src={$shop_icon[0]} alt='{$price['shop']}'/>";
                    }

                    $shop_html .=
                        "<li>
                            <a href=\"{$price['link']}\" target=\"_blank\" class=\"storename\">
                                {$icon} {$price['shop']}
                            </a>
                        </li>";
                }

                if($idx === 2) break;
            }

            $price_html =
                "<div class=\"jeg_review_info\">
                    <div class=\"price-info\">
                        <h4 class=\"info-title\">" . jnews_return_translation('Best Price', 'jnews-review', 'best_price') . " : </h4>
                        <strong>" . jnews_review_get_price($lowest_price) . "</strong>
                    </div>
                    <div class=\"store-info\">
                        <h4 class=\"info-title\">" . jnews_return_translation('Available at', 'jnews-review', 'available_at') . " :</h4>
                        <ul>
                            {$shop_html}
                        </ul>
                    </div>
                </div>";
        }

        $output =
            "<article " . jnews_post_class("jeg_post jeg_pl_md_2", $post->ID) . ">
                <div class=\"jeg_thumb\">
                    " . jnews_edit_post( $post->ID ) . "
                    <a href=\"" . get_the_permalink($post) . "\">" . $thumbnail . "</a>
                </div>
                <div class=\"jeg_postblock_content\">
                    <h2 class=\"jeg_post_title\">
                        <a href=\"" . get_the_permalink($post) . "\">" . get_the_title($post) . "</a>
                    </h2>
                    " . $this->post_meta_1($post) . "
                    <div class=\"jeg_post_excerpt\">
                        <p>" . $this->get_excerpt($post) . "</p>
                    </div>
                </div>
                {$price_html}
            </article>";

        return $output;
    }

    public function review_no_item()
    {
        return "<div class=\"jeg_empty_module\">" . jnews_return_translation('No review found', 'jnews-review', 'no_review') . "</div>";
    }

    public function render_module($attr, $column_class)
    {
        $select_category    = $this->select_category($attr);
        $select_sort        = $this->select_sort();

        $keyword    = isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '';
        $page       = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $result     = $this->build_result($attr);
        $loader     = \JNews\Module\ModuleManager::getInstance()->module_loader();

        $json_attr = wp_json_encode($attr);
        $script = "<script>var {$this->unique_id} = {$json_attr};</script>";

        $output =
            "<div class='jeg_review_search {$this->color_scheme()}' data-id='{$this->unique_id}'>
                <form class='review-search-form' method='get'>
                    <div class='search-bar-wrapper'>
                        <input class='search_keyword' value='{$keyword}' type='text' placeholder='" . jnews_return_translation('Search Review...', 'jnews-review', 'search_review') . "' name='keyword' id='keyword'/>
                        <button class='search_review_button btn' type='submit'>
                            <i class=\"fa fa-search\"></i>
                        </button>                        
                    </div>
                    <div class='search-filter-wrapper'>
                        <div class='row'>
                            <div class='col-md-6'>
                                {$select_category}
                            </div>
                            <div class='col-md-6'>
                                {$select_sort}
                            </div>
                        </div>
                    </div>
                    <input type='hidden' name='page' value='" . $page . "'/>
                    <input type='hidden' name='action' value='review_search_handler'/>                        
                    {$script}
                </form>
                <div class='jeg_review_search_result_wrapper'>
                    <div class='jeg_review_search_result_holder'>
                        {$result}
                    </div>
                    {$loader}
                </div>                
            </div>";

        return $output;
    }

}
