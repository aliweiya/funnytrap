<?php
/**
 * @author : Jegtheme
 */

Class JNews_Element_Post_Package_Option extends \JNews\Module\ModuleOptionAbstract
{
	public function compatible_column()
	{
		return array( 4, 8 , 12 );
	}

	public function get_module_name()
	{
		return esc_html__('JNews - Post Package', 'jnews-frontend-submit');
	}

	public function get_category()
	{
		return esc_html__('JNews - Element', 'jnews-frontend-submit');
	}

	public function set_options()
	{
		$this->options[] = array(
            'type'          => 'select',
            'multiple'      => PHP_INT_MAX,
			'param_name'    => 'list_package',
			'heading'       => esc_html__('Post Package', 'jnews-frontend-submit'),
			'description'   => esc_html__('Select post package list.', 'jnews-frontend-submit'),
            'std'           => '',
            'value'         => jnews_get_all_package(),
		);

		$this->options[] = array(
			'type'          => 'textfield',
			'param_name'    => 'button_package',
			'heading'       => esc_html__('Button Text', 'jnews-frontend-submit'),
			'description'   => esc_html__('Insert text for package button.','jnews-frontend-submit'),
		);
	}
}
