<?php

$options = array();

$options[] = array(
    'id'            => 'jnews_option[price_front]',
    'option_type'   => 'option',
    'transport'     => 'postMessage',
    'default'       => '$',
    'type'          => 'jnews-text',
    'section'       => 'jnews_review_section',
    'label'         => esc_html__('Text in front of price text', 'jnews-review'),
    'description'   => esc_html__('You can use this as your currency text.', 'jnews-review'),
    'postvar'       => array( array(
        'redirect'  => 'single_review_tag',
        'refresh'   => true
    ) )
);

$options[] = array(
    'id'            => 'jnews_option[price_currency]',
    'option_type'   => 'option',
    'transport'     => 'postMessage',
    'default'       => 'USD',
    'type'          => 'jnews-text',
    'section'       => 'jnews_review_section',
    'label'         => esc_html__('Price Currency', 'jnews-review'),
    'description'   => esc_html__('Insert the price currency. This info will be used on the review schema.', 'jnews-review'),
    'postvar'       => array( array(
        'redirect'  => 'single_review_tag',
        'refresh'   => true
    ) )
);

$options[] = array(
    'id'            => 'jnews_option[price_behind]',
    'option_type'   => 'option',
    'transport'     => 'postMessage',
    'default'       => '',
    'type'          => 'jnews-text',
    'section'       => 'jnews_review_section',
    'label'         => esc_html__('Text behind of price text', 'jnews-review'),
    'description'   => esc_html__('You can use this as your currency text.', 'jnews-review'),
    'postvar'       => array( array(
        'redirect'  => 'single_review_tag',
        'refresh'   => true
    ) )
);

$options[] = array(
    'id'            => 'jnews_option[price_float_position]',
    'option_type'   => 'option',
    'transport'     => 'postMessage',
    'default'       => 'right',
    'type'          => 'jnews-select',
    'section'       => 'jnews_review_section',
    'label'         => esc_html__('Price float','jnews-review'),
    'description'   => esc_html__('Show price float box on post content.','jnews-review'),
    'multiple'      => 1,
    'choices'     => array(
        'none' => esc_attr__( 'Hide', 'jnews-review' ),
        'right' => esc_attr__( 'Show', 'jnews-review' ),
    ),
    'postvar'       => array( array(
        'redirect'  => 'single_review_tag',
        'refresh'   => true
    ) )
);

return $options;