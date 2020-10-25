<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

use JNews\Widget\AdditionalWidget;
use Jeg\Form\Form_Widget;

Class JNews_Review_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'jnews_single_review',
            esc_html__('JNews : Single Post Review Widget', 'jnews-review'), // Name
            array(
                'description' =>  esc_html__('Single Post Review widget for JNews', 'jnews-review'),
                'customize_selective_refresh' => true
        ), null);
    }

    /**
     * Register widget with WordPress.
     */
    public function form($instance)
    {
        $options = array (
            'title'     => array(
                'title'     => esc_html__('Title', 'jnews-review'),
                'desc'      => esc_html__('Title on widget header.', 'jnews-review'),
                'type'      => 'text',
                'group' => 'general-setting'
            ),
            'disablerating'   => array(
                'title'     => esc_html__('Disable Rating Point', 'jnews-review'),
                'desc'      => esc_html__('hide rating point on this widget.', 'jnews-review'),
                'type'      => 'checkbox',
                'group' => 'general-setting'
            ),
            'showdescription'   => array(
                'title'     => esc_html__('Show summary', 'jnews-review'),
                'desc'      => esc_html__('show review summary on this widget.', 'jnews-review'),
                'type'      => 'checkbox',
                'group' => 'general-setting'
            ),
            'hideprocons'   => array(
                'title'     => esc_html__('Hide Pro & Cons', 'jnews-review'),
                'desc'      => esc_html__('hide review summary on this widget.', 'jnews-review'),
                'type'      => 'checkbox',
                'group' => 'general-setting'
            ),
            'hideprice'   => array(
                'title'     => esc_html__('Hide Price for Affiliate', 'jnews-review'),
                'desc'      => esc_html__('hide product price on this widget', 'jnews-review'),
                'type'      => 'checkbox',
                'group' => 'general-setting'
            )
        );

	    if ( ! is_customize_preview() ) {
		    $id = $this->get_field_id( 'widget_news_element' );

		    $segments[] = array(
			    'id'   => 'general-setting',
			    'name' => esc_html__( 'General Setting', 'jnews-review' ),
		    );

		    $fields = $this->prepare_fields( $instance, $options );

		    $additional_instance = AdditionalWidget::getInstance();
		    $additional_field    = $additional_instance->prepare_fields( $this, $instance );
		    $additional_segment  = $additional_instance->prepare_segments();

            if ( class_exists( 'Jeg\Form\Form_Widget' ) ) {
                Form_Widget::render_form( $id, array_merge( $segments, $additional_segment ), array_merge( $fields, $additional_field ) );
            }
	    }
    }

	public function prepare_fields( $instance, $options ) {
		$setting = array();
		$fields  = $options;

		foreach ( $fields as $key => $field ) {

			$setting[ $key ]              = array();
			$setting[ $key ]['id']        = $key;
			$setting[ $key ]['fieldID']   = $this->get_field_id( $key );
			$setting[ $key ]['fieldName'] = $this->get_field_name( $key );
			$setting[ $key ]['type']      = $field['type'];

			$setting[ $key ]['title']       = isset( $field['title'] ) ? $field['title'] : '';
			$setting[ $key ]['description'] = isset( $field['desc'] ) ? $field['desc'] : '';
			$setting[ $key ]['segment']     = isset( $field['group'] ) ? $field['group'] : '';
			$setting[ $key ]['default']     = isset( $field['default'] ) ? $field['default'] : '';
			$setting[ $key ]['priority']    = isset( $field['priority'] ) ? $field['priority'] : 10;
			$setting[ $key ]['options']     = isset( $field['options'] ) ? $field['options'] : array();
			$setting[ $key ]['dependency']  = isset( $field['dependency'] ) ? $field['dependency'] : '';
			$setting[ $key ]['multiple']    = isset( $field['multiple'] ) ? $field['multiple'] : 1;
			$setting[ $key ]['ajax']        = isset( $field['ajax'] ) ? $field['ajax'] : '';
			$setting[ $key ]['nonce']       = isset( $field['nonce'] ) ? $field['nonce'] : '';
			$setting[ $key ]['choices']     = isset( $field['choices'] ) ? $field['choices'] : '';
			$setting[ $key ]['value']       = $this->get_value( $key, $instance, $setting[ $key ]['default'] );
			$setting[ $key ]['fields']      = isset( $field['fields'] ) ? $field['fields'] : array();
			$setting[ $key ]['row_label']   = isset( $field['row_label'] ) ? $field['row_label'] : array();

			// only for image type
			if ( 'image' === $setting[ $key ]['type'] ) {
				$image = wp_get_attachment_image_src( $setting[ $key ]['value'], 'full' );
				if ( isset( $image[0] ) ) {
					$setting[ $key ]['imageUrl'] = $image[0];
				}
			}
		}

		return $setting;
	}

	public function get_value( $id, $value, $default ) {
		if ( isset( $value[ $id ] ) ) {
			return $value[ $id ];
		} else {
			return $default;
		}
	}

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance )
    {
        if(is_single() && jnews_review_enable_review( null, get_the_ID()))
        {
            $title = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : "");

            echo jnews_sanitize_output( $args['before_widget'] );

            if (!empty($title)) {
                echo jnews_sanitize_output( $args['before_title'] ) . esc_html($title) . $args['after_title'];
            }

            $this->render_widget($instance);

            echo jnews_sanitize_output( $args['after_widget'] );
        }
    }

    /**
     * Render widget content
     *
     * @param  array $instance
     *
     */
    public function render_widget( $instance )
    {
        require_once 'class.jnews-review-frontend.php';
        $review = \JNews_Review_Frontend::getInstance();

        $output = '';

        if(!isset($instance['disablerating'])  || ($instance['disablerating'] == '0')) {
            $output .= $review->widget_rating();
        }

        if(isset($instance['showdescription']) && $instance['showdescription']) {
            $output .= $review->widget_description();
        }

        if(!isset($instance['hideprocons']) || ($instance['hideprocons'] == '0')) {
            $output .= $review->widget_procons();
        }

        if(!isset($instance['hideprice']) || ($instance['hideprice'] == '0')) {
            $output .= $review->widget_price();
        }

        $output =
            "<div class='jeg_review_widget'>" .
                $output .
            "</div>";

        echo jnews_sanitize_output( $output );
    }

    protected function get_widget_template(){}
}
