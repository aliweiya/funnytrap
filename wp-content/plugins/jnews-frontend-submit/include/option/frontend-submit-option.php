<?php

$options = array();

$options[] = array(
	'id'            => 'jnews_frontend_submit_tab_header_1',
	'type'          => 'jnews-header',
	'label'         => esc_html__('General Option','jnews-frontend-submit' ),
);

$options[] = array(
	'id'            => 'jnews_frontend_submit_enable_add_media',
	'transport'     => 'postMessage',
	'default'       => true,
	'type'          => 'jnews-toggle',
	'label'         => esc_html__('Enable Add Media', 'jnews-frontend-submit'),
	'description'   => esc_html__('Enable add media button on frontend post editor.', 'jnews-frontend-submit'),
);

$options[] = array(
	'id'            => 'jnews_frontend_submit_maxupload',
	'transport'     => 'postMessage',
	'default'       => '2',
	'type'          => 'jnews-slider',
	'label'         => esc_html__('Maxupload Size', 'jnews'),
	'description'   => esc_html__('Set maxupload file size.', 'jnews'),
	'choices'       => array(
		'min'  => '1',
		'max'  => '10',
		'step' => '1',
	)
);

$options[] = array(
	'id'            => 'jnews_frontend_submit_tab_header_2',
	'type'          => 'jnews-header',
	'label'         => esc_html__('Advanced Option','jnews-frontend-submit' ),
);

$options[] = array(
	'id'            => 'jnews_frontend_submit_enable_woocommerce',
	'transport'     => 'postMessage',
	'default'       => false,
	'type'          => 'jnews-toggle',
	'label'         => esc_html__('Enable WooCommerce Mode', 'jnews-frontend-submit'),
	'description'   => esc_html__('By enabling this option, the site user will need to buy post package before they can submit their post using frontend submit.', 'jnews-frontend-submit'),
);

return $options;