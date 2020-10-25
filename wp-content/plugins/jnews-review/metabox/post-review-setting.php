<?php

return array(
    'id'       => 'jnews_review',
    'types'    => array('post'),
    'title'    => 'JNews : Review Setting',
    'priority' => 'high',
    'mode'     => WPALCHEMY_MODE_EXTRACT,
    'template' => array(

        array(
            'type'   => 'tab',
            'name'   => 'review_setting',
            'title'  => esc_html__('Review Setting', 'jnews-review'),
            'fields' => array(
                array(
                    'type'        => 'toggle',
                    'name'        => 'enable_review',
                    'label'       => esc_html__('Enable Review', 'jnews-review'),
                    'description' => esc_html__('Check this option to enable review on this post.', 'jnews-review'),
                ),

                array(
                    'type'        => 'select',
                    'name'        => 'type',
                    'label'       => esc_html__('Review Type','jnews-review'),
                    'description' => esc_html__('Choose your review type.','jnews-review'),
                    'default'     => 'percentage',
                    'items'       => array(
                        array(
                            'value' => 'point',
                            'label' => esc_html__('Point', 'jnews-review'),
                        ),
                        array(
                            'value' => 'star',
                            'label' => esc_html__('Star', 'jnews-review'),
                        ),
                        array(
                            'value' => 'percentage',
                            'label' => esc_html__('Percentage', 'jnews-review'),
                        ),
                    ),
                ),

                array(
                    'type'        => 'textbox',
                    'name'        => 'name',
                    'label'       => esc_html__('Review Product Name', 'jnews-review'),
                    'description' => esc_html__('Your review product name.', 'jnews-review'),
                ),

                array(
                    'type'        => 'textarea',
                    'name'        => 'summary',
                    'label'       => esc_html__('Review Summary', 'jnews-review'),
                    'description' => esc_html__('Insert your review summary.', 'jnews-review'),
                ),

                array(
                    'type'        => 'textbox',
                    'name'        => 'brand',
                    'label'       => esc_html__('Brand Name', 'jnews-review'),
                    'description' => esc_html__('Insert the brand of the product.', 'jnews-review'),
                ),
            )
        ),

        array(
            'type'   => 'tab',
            'name'   => 'review_pros_cons',
            'title'  => esc_html__('Review Pros and Cons', 'jnews-review'),
            'fields' => array(

                array(
                    'type'      => 'group',
                    'repeating' => true,
                    'sortable'  => true,
                    'name'      => 'good',
                    'title'     => esc_html__('What\'s good about this product', 'jnews-review'),
                    'fields'    => array(
                        array(
                            'type'        => 'textbox',
                            'name'        => 'good_text',
                            'label'       => esc_html__('Good', 'jnews-review'),
                            'description' => esc_html__('Insert the good thing about this product.', 'jnews-review'),
                        ),
                    ),
                ),

                array(
                    'type'      => 'group',
                    'repeating' => true,
                    'sortable'  => true,
                    'name'      => 'bad',
                    'title'     => esc_html__('What\'s bad about this product', 'jnews-review'),
                    'fields'    => array(
                        array(
                            'type'        => 'textbox',
                            'name'        => 'bad_text',
                            'label'       => esc_html__('Bad', 'jnews-review'),
                            'description' => esc_html__('Insert the bad thing about this product.', 'jnews-review'),
                        ),
                    ),
                ),

            )
        ),

        array(
            'type'   => 'tab',
            'name'   => 'review_rating',
            'title'  => esc_html__('Review Rating', 'jnews-review'),
            'fields' => array(

                array(
                    'type'      => 'group',
                    'repeating' => true,
                    'sortable'  => true,
                    'name'      => 'rating',
                    'title'     => esc_html__('Review Rating', 'jnews-review'),
                    'fields'    => array(
                        array(
                            'type'        => 'textbox',
                            'name'        => 'rating_text',
                            'label'       => esc_html__('Rating Text', 'jnews-review'),
                            'description' => esc_html__('Insert text for rating label.', 'jnews-review'),
                        ),
                        array(
                            'type'        => 'slider',
                            'name'        => 'rating_number',
                            'label'       => esc_html__('Rating Number', 'jnews-review'),
                            'description' => esc_html__('Set rating value.', 'jnews-review'),
                            'min'         => '1',
                            'max'         => '10',
                            'step'        => '1',
                            'default'     => '10',
                        ),
                    ),
                ),

            )
        ),

        array(
            'type'   => 'tab',
            'name'   => 'review_price',
            'title'  => esc_html__('Product Price', 'jnews-review'),
            'fields' => array(

                array(
                    'type'      => 'group',
                    'repeating' => true,
                    'sortable'  => true,
                    'name'      => 'price',
                    'title'     => esc_html__('This Product Price', 'jnews-review'),
                    'fields'    => array(
                        array(
                            'type'         => 'textbox',
                            'name'         => 'shop',
                            'label'        => esc_html__('Where to Buy', 'jnews-review'),
                            'description'  => esc_html__('Ex : Amazon, Ebay.', 'jnews-review'),
                            'attach_title' => true
                        ),
                        array(
                            'type'         => 'textbox',
                            'name'         => 'price',
                            'label'        => esc_html__('Price', 'jnews-review'),
                            'description'  => esc_html__('Insert product price.', 'jnews-review'),
                            'attach_title' => true
                        ),
                        array(
                            'type'         => 'textbox',
                            'name'         => 'link',
                            'label'        => esc_html__('Shop Link', 'jnews-review'),
                            'description'  => esc_html__('You can also insert your referral link.', 'jnews-review'),
                        ),
                        array(
                            'type'         => 'imageupload',
                            'name'         => 'icon',
                            'label'        => esc_html__('Shop Logo Icon', 'jnews-review'),
                            'description'  => esc_html__('Upload this shop logo / icon 16x16 pixel', 'jnews-review'),
                        ),
                    ),
                ),

            )
        ),

    ),
);
