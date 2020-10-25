<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Theme JNews Option
 */
Class JNews_Review_Option
{
    /**
     * @var JNews_Review_Option
     */
    private static $instance;

    /**
     * @var Jeg\Customizer\Customizer
     */
    private $customizer;

    /**
     * @return JNews_Review_Option
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
        if(class_exists('Jeg\Customizer\Customizer'))
        {
            $this->customizer = Jeg\Customizer\Customizer::get_instance();

            $this->set_section();
        }
    }

    public function set_section()
    {
        $this->customizer->add_section(array(
            'id' => 'jnews_review_section',
            'title' => esc_html__('Review', 'jnews-review'),
            'panel' => 'jnews_global_panel',
            'priority' => 177,
            'type' => 'jnews-lazy-section',
        ));
    }
}
