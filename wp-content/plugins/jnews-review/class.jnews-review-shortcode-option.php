<?php
/**
 * @author : Jegtheme
 */

Class JNews_Review_Shortcode_Option extends \JNews\Module\ModuleOptionAbstract
{
    public function compatible_column()
    {
        return array( 4, 6, 8 , 12 );
    }

    public function get_module_name()
    {
        return esc_html__("JNews - Post Review", 'jnews-review');
    }

    public function get_category()
    {
        return esc_html__('JNews - Element', 'jnews-review');
    }

    public function set_options()
    {
        $this->set_header_option();
        $this->set_style_option();
    }

    public function set_header_option()
    {
        $this->options[] = array(
            'type'          => 'select',
            'multiple'      => PHP_INT_MAX,
            'ajax'          => 'jeg_find_review',
            'options'       => 'jeg_get_review_option',
            'nonce'         => wp_create_nonce( 'jeg_find_review' ),
            'param_name'    => 'post_id_review',
            'heading'       => esc_html__("Choose Post's Review", 'jnews-review'),
            'description'   => wp_kses(__("Enter post title or id to show it's review on this element.<br>If you search by id, first type the post id and then press enter to add it on the list.", 'jnews'), wp_kses_allowed_html()),
            'std'           => '',
        );
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'review_show_rating',
            'heading'       => esc_html__('Show Rating *', 'jnews'),
            'value'         => array( esc_html__('Show post review rating.', 'jnews') => 'no' ),
        );
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'review_show_pros_cons',
            'heading'       => esc_html__('Show Pros and Cons *', 'jnews'),
            'value'         => array( esc_html__('Show Pros and Cons of post review.', 'jnews') => 'no' ),
        );
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'review_show_breakdown',
            'heading'       => esc_html__('Show Review Breakdown *', 'jnews'),
            'value'         => array( esc_html__('Show post review breakdown.', 'jnews') => 'no' ),
        );
        $this->options[] = array(
            'type'          => 'checkbox',
            'param_name'    => 'review_show_price',
            'heading'       => esc_html__('Show Price *', 'jnews'),
            'description'   => esc_html__("* Make sure the post you selected above is a review post and have the review attributes already set, otherwise it will show nothing even if checked.", 'jnews-review'),
            'value'         => array( esc_html__('Show post review prices.', 'jnews') => 'no' ),
        );
    }
}