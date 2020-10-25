<?php
/**
 * @author : Jegtheme
 */

Class JNews_Element_Review_Option extends \JNews\Module\ModuleOptionAbstract
{
    public function compatible_column()
    {
        return array( 8 , 12 );
    }

    public function get_module_name()
    {
        return esc_html__('JNews - Review Search', 'jnews-review');
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
            'ajax'          => 'jeg_find_category',
            'options'       => 'jeg_get_category_option',
            'nonce'         => wp_create_nonce( 'jeg_find_category' ),
            'param_name'    => 'include_category',
            'heading'       => esc_html__('Choose filterable Category', 'jnews-review'),
            'description'   => esc_html__('Choose which category you want to show on this module.', 'jnews-review'),
            'std'           => '',
        );
        $this->options[] = array(
            'type'          => 'slider',
            'param_name'    => 'number_post',
            'heading'       => esc_html__('Number of Post', 'jnews-review'),
            'description'   => esc_html__('Show number of review on this module.', 'jnews-review'),
            'min'           => 1,
            'max'           => 30,
            'step'          => 1,
            'std'           => 5,
        );
        $this->options[] = array(
            'type'          => 'slider',
            'param_name'    => 'excerpt_length',
            'heading'       => esc_html__('Excerpt Length', 'jnews'),
            'description'   => esc_html__('Set word length of excerpt on post block.', 'jnews'),
            'group'         => esc_html__('Content Setting', 'jnews'),
            'min'           => 0,
            'max'           => 200,
            'step'          => 1,
            'std'           => 20,
        );
    }
}
