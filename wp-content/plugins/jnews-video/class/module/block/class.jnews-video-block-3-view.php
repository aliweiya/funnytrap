<?php
/**
 * @author : Jegtheme
 */

use JNEWS_VIDEO\Module\Block\Video_Block_View_Abstract;

class JNews_Video_Block3_View extends Video_Block_View_Abstract {

	public function render_module( $attr, $column_class ) {
		$heading       = $this->render_header( $attr );
		$name          = 'video_3';
		$style_output  = jnews_header_styling( $attr, $this->unique_id . ' ' );
		$style_output .= jnews_module_custom_color( $attr, $this->unique_id . ' ', $name );
		$content       = $this->render_output( $attr, $column_class );
		$style         = ! empty( $style_output ) ? "<style scoped>{$style_output}</style>" : '';
		$script        = $this->render_script( $attr, $column_class );
		$nav_top       = ( ! empty( $attr['nav_position_top'] ) ) ? 'nav_top' : '';

		$output =
			"<div {$this->element_id($attr)} class=\"jnews_video jeg_postblock_{$name} jeg_postblock jeg_module_hook jeg_pagination_{$attr['pagination_mode']} {$column_class} {$this->unique_id} {$this->get_vc_class_name()} {$this->color_scheme()} {$attr['el_class']} {$nav_top}\" data-unique=\"{$this->unique_id}\">
                {$heading}
                {$content}
                {$style}
                {$script}
            </div>";

		return $output;
	}

	public function render_output( $attr, $column_class ) {
		if ( isset( $attr['results'] ) ) {
			$results = $attr['results'];
		} else {
			$results = $this->build_query( $attr );
		}

		$navigation = $this->render_navigation( $attr, $results['next'], $results['prev'], $results['total_page'] );

		if ( ! empty( $results['result'] ) ) {
			$content = $this->render_column( $results['result'], $column_class, $attr );
		} else {
			$content = $this->empty_content();
		}

		return "<div class=\"jeg_block_container\">
                {$this->get_content_before($attr)}
                {$content}
                {$this->get_content_after($attr)}
            </div>
            <div class=\"jeg_block_navigation\">
                {$this->get_navigation_before($attr)}
                {$navigation}
                {$this->get_navigation_after($attr)}
            </div>";
	}

	public function render_column( $result, $column_class, $attr = null ) {
		switch ( $column_class ) {
			case 'jeg_col_1o3':
				$content = $this->build_column_1( $result, $attr );
				break;
			case 'jeg_col_3o3':
			case 'jeg_col_2o3':
			default:
				$content = $this->build_column_2( $result, $attr );
				break;
		}

		return $content;
	}

	public function build_column_1( $results, $attr = null ) {
		$first_block  = '';
		$ads_position = $this->random_ads_position( sizeof( $results ) );

		for ( $i = 0; $i < sizeof( $results ); $i ++ ) {
			if ( $i == $ads_position ) {
				$first_block .= $this->render_module_ads();
			}

			$first_block .= $this->render_block_type_2( $results[ $i ], 'jnews-120x86', $attr );
		}

		$output =
			"<div class=\"jeg_posts jeg_load_more_flag\">
                {$first_block}
            </div>";

		return $output;
	}

	public function render_block_type_2( $post, $image_size, $attr = null ) {
		$thumbnail       = $this->get_thumbnail( $post->ID, $image_size );
		$post_meta_style = $this->get_post_meta_style( $post, $attr );

		$output =
			'<article ' . jnews_post_class( 'jeg_post', $post->ID ) . '>
                <div class="jeg_thumb">
                    ' . jnews_edit_post( $post->ID ) . '
                    <a href="' . get_the_permalink( $post ) . '">' . $thumbnail . '</a>
                    ' . $this->additional_attribute( $post, $attr ) . '
                </div>
                <div class="jeg_postblock_content">
                    <h3 class="jeg_post_title">
                        <a href="' . get_the_permalink( $post ) . '">' . get_the_title( $post ) . '</a>
                    </h3>
                    ' . $post_meta_style . '
                </div>
            </article>';

		return $output;
	}

	public function build_column_2( $results, $attr = null ) {
		$first_block  = '';
		$ads_position = $this->random_ads_position( sizeof( $results ) );

		for ( $i = 0; $i < sizeof( $results ); $i ++ ) {
			if ( $i == $ads_position ) {
				$first_block .= $this->render_module_ads();
			}

			$first_block .= $this->render_block_type_1( $results[ $i ], 'jnews-350x250', $attr );
		}

		$output =
			"<div class=\"jeg_posts jeg_load_more_flag\">
                {$first_block}
            </div>";

		return $output;
	}

	public function render_block_type_1( $post, $image_size, $attr = null ) {
		$thumbnail       = $this->get_thumbnail( $post->ID, $image_size );
		$post_meta_style = $this->get_post_meta_style( $post, $attr );

		$output =
			'<article ' . jnews_post_class( 'jeg_post', $post->ID ) . '>
                <div class="jeg_thumb">
                    ' . jnews_edit_post( $post->ID ) . '
                    <a href="' . get_the_permalink( $post ) . '">' . $thumbnail . '</a>
                    ' . $this->additional_attribute( $post, $attr ) . '
                </div>
                <div class="jeg_postblock_content">
                    <h3 class="jeg_post_title">
                        <a href="' . get_the_permalink( $post ) . '">' . get_the_title( $post ) . '</a>
                    </h3>
                    ' . $post_meta_style . '
                    <div class="jeg_post_excerpt">
                        <p>' . $this->get_excerpt( $post ) . '</p>
                    </div>
                </div>
            </article>';

		return $output;
	}

	public function render_module_out_call( $result, $column_class, $attr = null ) {
		$name = 'video_3';

		if ( ! empty( $result ) ) {
			$content = $this->render_column( $result, $column_class, $attr );
		} else {
			$content = $this->empty_content();
		}

		$output =
			"<div class=\"jeg_postblock_{$name} jeg_postblock {$column_class}\">
                <div class=\"jeg_block_container\">
                    {$content}
                </div>
            </div>";

		return $output;

	}

	public function render_column_alt( $result, $column_class ) {
		switch ( $column_class ) {
			case 'jeg_col_1o3':
				$content = $this->build_column_1_alt( $result );
				break;
			case 'jeg_col_3o3':
			case 'jeg_col_2o3':
			default:
				$content = $this->build_column_2_alt( $result );
				break;
		}

		return $content;
	}

	public function build_column_1_alt( $results ) {
		$first_block  = '';
		$ads_position = $this->random_ads_position( sizeof( $results ) );

		for ( $i = 0; $i < sizeof( $results ); $i ++ ) {
			if ( $i == $ads_position ) {
				$first_block .= $this->render_module_ads( 'jeg_ajax_loaded anim_' . $i );
			}

			$first_block .= $this->render_block_type_2( $results[ $i ], 'jnews-120x86' );
		}

		$output = $first_block;

		return $output;
	}

	public function build_column_2_alt( $results ) {
		$first_block  = '';
		$ads_position = $this->random_ads_position( sizeof( $results ) );

		for ( $i = 0; $i < sizeof( $results ); $i ++ ) {
			if ( $i == $ads_position ) {
				$first_block .= $this->render_module_ads( 'jeg_ajax_loaded anim_' . $i );
			}

			$first_block .= $this->render_block_type_1( $results[ $i ], 'jnews-350x250' );
		}

		$output = $first_block;

		return $output;
	}

}
