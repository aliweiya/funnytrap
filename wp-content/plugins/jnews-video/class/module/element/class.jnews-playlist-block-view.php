<?php
/**
 * @author : Jegtheme
 */

use JNews\Module\Block\BlockViewAbstract;

class JNews_Video_Blockplaylist_View extends BlockViewAbstract {

	public function render_module( $attr, $column_class ) {
		$heading       = $this->render_header( $attr );
		$name          = 'playlist';
		$style_output  = jnews_header_styling( $attr, $this->unique_id . ' ' );
		$style_output .= jnews_module_custom_color( $attr, $this->unique_id . ' ', $name );
		$content       = $this->render_output( $attr, $column_class );
		$style         = ! empty( $style_output ) ? "<style scoped>{$style_output}</style>" : '';
		$script        = $this->render_script( $attr, $column_class );
		$nav_top       = ( ! empty( $attr['nav_position_top'] ) ) ? 'nav_top' : '';

		$output =
			"<div {$this->element_id($attr)} class=\"jnews_video jeg_postblock_{$name} jeg_postblock jeg_module_hook jeg_pagination_{$attr['pagination_mode']} {$column_class} {$this->unique_id} {$this->get_vc_class_name()} {$this->color_scheme()} {$attr['el_class']} {$nav_top} \" data-unique=\"{$this->unique_id}\">
                {$heading}
                {$content}
                {$style}
                {$script}
            </div>";

		return $output;
	}

	public function render_header( $attr ) {

		if ( defined( 'POLYLANG_VERSION' ) ) {
			$attr['first_title']  = jnews_return_polylang( $attr['first_title'] );
			$attr['second_title'] = jnews_return_polylang( $attr['second_title'] );
		}
		$heading = '';
		if ( $attr['data_type'] === 'user' ) {
			$author      = $attr['user_data'];
			$author_url  = get_author_posts_url( $author );
			$author_name = get_the_author_meta( 'display_name', $author );
			$title       = $author_name;
			$url         = $author_url;
			$avatar_args = array(
				'size' => 75,
			);
			$image       = get_avatar_url( $author, $avatar_args );
		} else {
			$title = $attr['first_title'];
			$url   = $attr['url'];
			$image = ( isset( $attr['header_icon']['id'] ) && ! empty( $attr['header_icon']['id'] ) ) ? wp_get_attachment_image_src( $attr['header_icon']['id'], 'jnews-75x75' )[0] : wp_get_attachment_image_src( $attr['header_icon'], 'jnews-75x75' )[0];
		}
		if ( ! empty( $title ) ) {
			// Heading
			$subtitle      = ! empty( $attr['second_title'] ) ? "<span class=\"subtitle\">{$attr['second_title']}</span>" : '';
			$heading_image = $image;
			$heading_icon  = ! empty( $heading_image ) ? "<img src='{$heading_image}' alt='{$attr['first_title']}' data-pin-no-hover=\"true\">" : '';
			$heading_icon  = ! empty( $attr['url'] ) ? "<a href='{$attr['url']}'>{$heading_icon}</a>" : $heading_icon;
			$section       = ! empty( $attr['section'] ) ? '<span ' . ( empty( $attr['section_url'] ) ? "class='tag_content'" : '' ) . " >{$attr['section']}</span>" : '';
			$section       = ! empty( $attr['section_url'] ) ? "<a href='{$attr['section_url']}' class='tag_content' >{$section}</a>" : $section;
			$heading_title = "<span>{$title}</span>";
			$heading_title = ! empty( $url ) ? "<a href='{$url}'>{$heading_title}</a>" : $heading_title;
			$heading_title = "<h3 class=\"jeg_block_title\">{$heading_title}</h3>";
			$follow_button = ! empty( $attr['follow_button'] ) ? ( ! empty( $attr['follow_user'] ) ? jnews_video_render_subscribe_member_actions( $attr['follow_user'] ) : '' ) : '';
			$follow_button = ! empty( $follow_button ) ? '<div class="follow-wrapper">' . $follow_button . '<div class="jnews-spinner" style="display: none"><i class="fa fa-spinner fa-pulse active"></i></div></div>' : '';
			$heading       = "<div class='jeg_video_block_heading'>{$heading_icon}{$heading_title}{$section}{$subtitle}{$follow_button}</div>";
		}

		// Now Render Output
		if ( empty( $heading_title ) ) {
			$output = '';
		} else {
			// Now Render Output
			$output =
				"<div class=\"jeg_video_block_heading_wrapper\">
                    {$heading}
                </div>";
		}

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

	protected function build_query( $attr ) {
		$attr['post_type']   = 'playlist';
		$attr['post_offset'] = 0;

		if ( ! empty( $attr['include_post'] ) ) {
			$attr['sort_by'] = 'post__in';
		}

		return parent::build_query( $attr );
	}

	public function render_navigation( $attr, $next = false, $prev = false, $total_page = 1 ) {
		$output           = '';
		$additional_class = $next || $prev ? '' : 'inactive';

		if ( $attr['pagination_mode'] === 'nextprev' ) {
			$next = $next ? '' : 'disabled';
			$prev = $prev ? '' : 'disabled';

			$prev_text = '<i class="fa fa-angle-left"></i>';
			$next_text = '<i class="fa fa-angle-right"></i>';

			if ( $attr['pagination_nextprev_showtext'] && empty( $attr['nav_position_top'] ) ) {
				$additional_class .= ' showtext';
				$prev_text         = '<i class="fa fa-angle-left"></i> ' . jnews_return_translation( 'Prev', 'jnews-video', 'prev_block_video' );
				$next_text         = jnews_return_translation( 'Next', 'jnews-video', 'next_block_video' ) . '  <i class="fa fa-angle-right"></i>';
			}

			$output =
				"<div class=\"jeg_block_nav {$additional_class}\">
                    <a href=\"#\" class=\"prev {$prev}\" title=\"" . jnews_return_translation( 'Previous', 'jnews-video', 'previous_block_video' ) . "\">{$prev_text}</a>
                    <a href=\"#\" class=\"next {$next}\" title=\"" . jnews_return_translation( 'Next', 'jnews-video', 'next_block_video' ) . "\">{$next_text}</a>
                </div>";
		}

		if ( $attr['pagination_mode'] === 'loadmore' || $attr['pagination_mode'] === 'scrollload' ) {
			$next   = $next ? '' : 'disabled';
			$output =
				"<div class=\"jeg_block_loadmore {$additional_class}\">
                    <a href=\"#\" class='{$next}' data-load='" . jnews_return_translation( 'Show More', 'jnews-video', 'show_more' ) . "' data-loading='" . jnews_return_translation( 'Loading...', 'jnews-video', 'loading' ) . "'> " . jnews_return_translation( 'Show More', 'jnews-video', 'show_more' ) . ' <i class="fa fa-angle-down"></i></a>
                </div>';
		}

		// this is only for default link method
		if ( $attr['pagination_mode'] === 'nav_1' || $attr['pagination_mode'] === 'nav_2' || $attr['pagination_mode'] === 'nav_3' ) {
			if ( $total_page > 1 ) {
				$page   = $this->get_current_page();
				$output = $this->render_normal_navigation( $attr, $total_page, $page );
			}
		}

		$output = apply_filters( 'jnews_module_block_search_navigation', $output, $attr, $next, $prev, $total_page );

		return $output;
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
		$first_block = '';
		for ( $i = 0; $i < sizeof( $results ); $i ++ ) {
			$first_block .= $this->render_block_type_1( $results[ $i ], 'jnews-360x180', $attr );
		}

		$output =
			"<div class=\"jeg_posts_wrap\">
                <div class=\"jeg_posts jeg_load_more_flag\"> 
                    {$first_block}
                </div>
            </div>";

		return $output;
	}

	public function render_block_type_1( $post, $image_size, $attr = null ) {
		$thumbnail = $this->get_thumbnail( $post->ID, $image_size );
		$videos    = jnews_video_get_playlist_count( $post->ID );
		$post_meta = "<div class=\"jeg_post_meta\">
								<span class=\"jeg_video_count\">{$videos} " . jnews_return_translation( 'Videos', 'jnews-video', 'videos' ) . '</span>
			                </div>';

		$output =
			'<article ' . jnews_post_class( 'jeg_post jeg_pl_md_5', $post->ID ) . '>
                <div class="jeg_thumb">
                    ' . jnews_video_edit_playlist( $post->ID ) . '
                    <a href="' . get_the_permalink( $post ) . '">' . $thumbnail . '</a>
                </div>
                <div class="jeg_postblock_content">
                    <h3 class="jeg_post_title">
                        <a href="' . get_the_permalink( $post ) . '">' . get_the_title( $post ) . '</a>
                    </h3>
                    ' . $post_meta . '
                </div>
            </article>';

		return $output;
	}

	public function build_column_2( $results, $attr = null ) {
		$first_block = '';
		for ( $i = 0; $i < sizeof( $results ); $i ++ ) {
			$first_block .= $this->render_block_type_1( $results[ $i ], 'jnews-360x180', $attr );
		}

		$output =
			"<div class=\"jeg_posts_wrap\">
                <div class=\"jeg_posts jeg_load_more_flag\"> 
                    {$first_block}
                </div>
            </div>";

		return $output;
	}

	public function render_module_out_call( $result, $column_class, $attr = null ) {
		$name = 'playlist';

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
		$first_block = '';
		for ( $i = 0; $i < sizeof( $results ); $i ++ ) {
			$first_block .= $this->render_block_type_1( $results[ $i ], 'jnews-360x180' );
		}

		$output = $first_block;

		return $output;
	}

	public function build_column_2_alt( $results ) {
		$first_block = '';
		for ( $i = 0; $i < sizeof( $results ); $i ++ ) {
			$first_block .= $this->render_block_type_1( $results[ $i ], 'jnews-360x180' );
		}

		$output = $first_block;

		return $output;
	}
}
