<?php

use JNEWS_VIDEO\Objects\Playlist;

if ( ! function_exists( 'jnews_get_option' ) ) {
	/**
	 * @param $setting
	 * @param null    $default
	 *
	 * @return |null
	 */
	function jnews_get_option( $setting, $default = null ) {
		$options = get_option( 'jnews_option', array() );
		$value   = $default;
		if ( isset( $options[ $setting ] ) ) {
			$value = $options[ $setting ];
		}

		return $value;
	}
}

if ( ! function_exists( 'jnews_video_customizer_header_button' ) ) {
	function jnews_video_custom_header_button( $class, $value ) {
		if ( ! is_user_logged_in() ) {
			$button_type = get_theme_mod( 'jnews_header_button_' . $value . '_type', 'url' );
			if ( 'submit' === $button_type || 'upload' === $button_type ) {
				$class = 'jeg_login_required';
			}
		}

		return $class;
	}
}

/**
 * Register activation hook
 *
 * @param string $file Plugin file path.
 */
if ( ! function_exists( 'jnews_video_activation_hook' ) ) {
	/**
	 * @param $file
	 */
	function jnews_video_activation_hook( $file ) {
		register_activation_hook( $file, array( '\JNEWS_VIDEO\Init', 'activation_hook' ) );
	}
}

if ( ! function_exists( 'jnews_video_add_playlist_menu' ) ) {
	/**
	 * Add playlist menu
	 *
	 * @param $post
	 *
	 * @return string
	 */
	function jnews_video_add_playlist_menu( $post ) {
		$output  = '';
		$format  = get_post_format( $post );
		$post_id = $post->ID;

		if ( 'video' === $format ) {
			$output .= '<div class="jeg_meta_option" data-id="' . $post_id . '">
							<a href="#" >
								<div class="initial"><i class="fa fa-ellipsis-v"></i></div>
								<div class="loader"><i class="fa fa-cog fa-spin"></i></div>
							</a>
							<ul class="jeg_moreoption"></ul>
						</div>';
		}

		return $output;
	}
}

if ( ! function_exists( 'jnews_video_menu_detail' ) ) {
	/**
	 * Video Menu Detail
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	function jnews_video_menu_detail( $post_id ) {
		// Favorite.
		$favorite_active = JNEWS_VIDEO\Objects\Playlist::get_instance()->is_in_playlist( $post_id, 'favorite' ) ? 'active' : '';
		$favorite_html   = '<li><a href="#" class="' . $favorite_active . '" data-action="jeg_add_post" data-playlist-id="favorite"><i class="fa fa-heart-o icon-default"></i><i class="fa fa-circle-o-notch fa-spin icon-loader"></i><i class="fa fa-check icon-active"></i> <span>' . jnews_return_translation( 'Favorite', 'jnews-video', 'favorite' ) . '</span></a></li>';

		// Watch Later.
		$watch_active = JNEWS_VIDEO\Objects\Playlist::get_instance()->is_in_playlist( $post_id, 'watch-later' ) ? 'active' : '';
		$watch_html   = '<li><a href="#" class="' . $watch_active . '" data-action="jeg_add_post" data-playlist-id="watch-later"><i class="fa fa-save icon-default"></i><i class="fa fa-circle-o-notch fa-spin icon-loader"></i><i class="fa fa-check icon-active"></i> <span>' . jnews_return_translation( 'Watch Later', 'jnews-video', 'watch_later' ) . '</span></a></li>';

		// Playlist.
		$playlists     = JNEWS_VIDEO\Objects\Playlist::get_instance()->playlist_localize_script( array() );
		$playlist_html = '';
		foreach ( $playlists['user_playlist'] as $playlist_id => $playlist ) {
			$playlist_active = $watch_active = JNEWS_VIDEO\Objects\Playlist::get_instance()->is_in_playlist( $post_id, $playlist_id ) ? 'active' : '';
			$playlist_html  .= '<li><a href="#" class="' . $playlist_active . '" data-action="jeg_add_post" data-playlist-id="' . $playlist_id . '"><i class="fa fa-caret-right icon-default"></i><i class="fa fa-circle-o-notch fa-spin icon-loader"></i><i class="fa fa-check icon-active"></i> <span>' . $playlist . '</span></a></li>';
		}

		$output =
			$favorite_html . $watch_html . '
			<li><a href="#"><i class="fa fa-plus-square-o"></i> <span>' . jnews_return_translation( 'Add to playlist', 'jnews-video', 'add_to_playlist' ) . '</span></a>
				<ul class="jeg_add_to_playlist" style="display: none">
					<li><a href="#jeg_playlist" class="jeg_popuplink" data-post-id="' . $post_id . '"><i class="fa fa-plus-square-o icon-default"></i><i class="fa fa-circle-o-notch fa-spin icon-loader"></i><i class="fa fa-check icon-active"></i> <span>' . jnews_return_translation( 'New Playlist', 'jnews-video', 'new_playlist' ) . '</span></a></li>
					' . $playlist_html . '
				</ul>
			</li>';

		return $output;
	}
}


if ( ! function_exists( 'jnews_video_single_override' ) ) {
	/**
	 * @return bool
	 */
	function jnews_video_single_override() {
		if ( get_theme_mod( 'jnews_single_video_override', false ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'jnews_video_get_playlist' ) ) {
	/**
	 * @param $user_id
	 * @param $limit
	 * @param $sort_by
	 * @param array   $visibility
	 *
	 * @return int[]|WP_Post[]
	 */
	function jnews_video_get_playlist( $user_id, $limit, $sort_by, $visibility = array() ) {

		$args = array(
			'post_type'      => 'playlist',
			'author__in'     => isset( $user_id ) ? $user_id : '',
			'post_status'    => array( 'publish', 'private' ),
			'posts_per_page' => isset( $limit ) ? $limit : 3,
			'meta_query'     => array(
				array(
					'key'   => '_playlist_type',
					'value' => 'custom',
				),
				array(
					'key'   => '_playlist_visibility',
					'value' => $visibility,
				),
			),
		);
		if ( isset( $sort_by ) ) {
			// order.
			if ( 'latest' === $sort_by ) {
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
			}
			if ( 'oldest' === $sort_by ) {
				$args['orderby'] = 'date';
				$args['order']   = 'ASC';
			}
		}
		$playlist = get_posts( $args );

		return $playlist;
	}
}

if ( ! function_exists( 'jnews_video_get_playlist_count' ) ) {
	/**
	 * Count all video on playlist
	 *
	 * @param int $playlist_id
	 *
	 * @return mixed
	 */
	function jnews_video_get_playlist_count( $playlist_id = 0 ) {
		$playlist   = Playlist::get_instance();
		$count_post = $playlist->count_posts( $playlist_id );

		return apply_filters( 'jnews_video_get_playlist_count', $count_post, $playlist_id );
	}
}

if ( ! function_exists( 'jnews_video_get_video_length' ) ) {
	/**
	 * Get Video Length
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	function jnews_video_get_video_length( $post_id ) {
		$output   = '';
		$duration = vp_metabox( 'jnews_video_option.video_duration', null, $post_id );
		if ( $duration ) {
			$output .= '<div class="jeg_post_video">';
			$output .= '<div class="jeg_video_length">';
			$output .= '<span>' . normalize_duration( $duration ) . '</span>';
			$output .= '</div>';
			$output .= '</div>';
		}

		return $output;
	}
}
if ( ! function_exists( 'normalize_duration' ) ) {
	/**
	 * @param $duration
	 *
	 * @return false|string
	 */
	function normalize_duration( $duration ) {
		$string = '00:00:00';

		for ( $i = ( strlen( $string ) - 4 ); $i > 0; $i -- ) {
			$comparator = substr( $string, 0, $i );
			if ( strpos( $duration, $comparator ) === 0 ) {
				break;
			}
		}

		return substr( $duration, $i );
	}
}

if ( ! function_exists( 'jnews_video_get_share_title' ) ) {
	/**
	 * @param $post_id
	 *
	 * @return string
	 */
	function jnews_video_get_share_title( $post_id ) {
		$title = get_the_title( $post_id );
		$title = html_entity_decode( $title, ENT_QUOTES, 'UTF-8' );
		$title = urlencode( $title );
		$title = str_replace( '#', '%23', $title );

		return esc_html( $title );
	}
}

if ( ! function_exists( 'jnews_video_encode_url' ) ) {
	/**
	 * @param $post_id
	 *
	 * @return string
	 */
	function jnews_video_encode_url( $post_id ) {
		$url = get_permalink( $post_id );

		return urlencode( $url );
	}
}

if ( ! function_exists( 'jnews_video_get_social_share_url' ) ) {
	/**
	 * @param $social
	 * @param $post_id
	 *
	 * @return string
	 */
	function jnews_video_get_social_share_url( $social, $post_id ) {
		$image     = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
		$image_url = $image ? $image[0] : '';
		$title     = jnews_video_get_share_title( $post_id );
		$url       = apply_filters( 'jnews_get_permalink', jnews_video_encode_url( $post_id ) );

		switch ( $social ) {
			case 'facebook':
				$button_url = 'http://www.facebook.com/sharer.php?u=' . $url;
				break;
			case 'twitter':
				$button_url = 'https://twitter.com/intent/tweet?text=' . $title . '&url=' . $url;
				break;
			case 'googleplus':
				$button_url = 'https://plus.google.com/share?url=' . $url;
				break;
			case 'pinterest':
				$button_url = 'https://www.pinterest.com/pin/create/bookmarklet/?pinFave=1&url=' . $url . '&media=' . $image_url . '&description=' . $title;
				break;
			case 'stumbleupon':
				$button_url = 'http://www.stumbleupon.com/submit?url=' . $url . '&title=' . $title;
				break;
			case 'linkedin':
				$button_url = 'https://www.linkedin.com/shareArticle?url=' . $url . '&title=' . $title;
				break;
			case 'reddit':
				$button_url = 'https://reddit.com/submit?url=' . $url . '&title=' . $title;
				break;
			case 'tumblr':
				$button_url = 'https://www.tumblr.com/widgets/share/tool?canonicalUrl=' . $url . '&title=' . $title;
				break;
			case 'buffer':
				$button_url = 'https://buffer.com/add?text=' . $title . '&url=' . $url;
				break;
			case 'vk':
				$button_url = 'http://vk.com/share.php?url=' . $url;
				break;
			case 'whatsapp':
				$button_url = '//api.whatsapp.com/send?text=' . $title . '%0A' . $url;
				break;
			case 'telegram' :
				$button_url = 'https://telegram.me/share/url?url=' . $url .'&text=' . $title;
				break;
			case 'wechat':
				// wechat only able to share post using qrcode .
				// $button_url = 'weixin://dl/posts/link?url=' . $url; .
				$button_url = 'https://chart.googleapis.com/chart?chs=400x400&cht=qr&choe=UTF-8&chl=' . $url;
				break;
			case 'line':
				$button_url = 'https://social-plugins.line.me/lineit/share?url=' . $url .'&text=' . $title;
				break;
			case 'hatena':
				$button_url = 'http://b.hatena.ne.jp/bookmarklet?url=' . $url . '&btitle=' . $title;
				break;
			case 'qrcode':
				$button_url = 'https://chart.googleapis.com/chart?chs=400x400&cht=qr&choe=UTF-8&chl=' . $url;
				break;
			case 'email':
				$button_url = 'mailto:?subject=' . $title . '&amp;body=' . $url;
				break;
			default:
				$button_url = $url;
				break;
		}

		return $button_url;
	}
}

if ( ! function_exists( 'jnews_video_playlist_share' ) ) {
	/**
	 * @param $post
	 * @param $instance
	 *
	 * @return string
	 */
	function jnews_video_playlist_share( $post, $instance ) {
		$share_output = '';
		$main_button      = array(
			array(
				'social_share'  => 'facebook',
				'social_text'   => 'Share on Facebook'
			),
			array(
				'social_share'   => 'twitter',
				'social_text'    => 'Share on Twitter'
			),
			array(
				'social_share'   => 'pinterest',
				'social_text'    => ''
			),
		);
		$socials = jnews_get_option('single_social_share_main', $main_button);

		if ( is_array( $socials ) ) {
			foreach ( $socials as $social ) {
				switch ( $social['social_share'] ) {
					case 'facebook':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-facebook"><i class="fa fa-facebook-official"></i> <span>' . esc_html__( 'Facebook', 'jnews-video' ) . '</span></a>';
						break;

					case 'twitter':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-twitter"><i class="fa fa-twitter"></i> <span>' . esc_html__( 'Twitter', 'jnews-video' ) . '</span></a>';
						break;

					case 'googleplus':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-google-plus "><i class="fa fa-google-plus"></i> <span>' . esc_html__( 'Google+', 'jnews-video' ) . '</span></a>';
						break;

					case 'linkedin':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-linkedin "><i class="fa fa-linkedin"></i> <span>' . esc_html__( 'Linked In', 'jnews-video' ) . '</span></a>';
						break;

					case 'pinterest':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-pinterest "><i class="fa fa-pinterest"></i> <span>' . esc_html__( 'Pinterest', 'jnews-video' ) . '</span></a>';
						break;

					case 'tumblr':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-tumblr "><i class="fa fa-tumblr"></i> <span>' . esc_html__( 'Tumblr', 'jnews-video' ) . '</span></a>';
						break;

					case 'stumbleupon':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-stumbleupon "><i class="fa fa-stumbleupon"></i> <span>' . esc_html__( 'StumbleUpon', 'jnews-video' ) . '</span></a>';
						break;

					case 'whatsapp':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" data-action="share/whatsapp/share" target="_blank" class="jeg_btn-whatsapp "><i class="fa fa-whatsapp"></i> <span>' . esc_html__( 'WhatsApp', 'jnews-video' ) . '</span></a>';
						break;

					case 'email':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-email "><i class="fa fa-envelope"></i> <span>' . esc_html__( 'E-mail', 'jnews-video' ) . '</span></a>';
						break;

					case 'vk':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-vk "><i class="fa fa-vk"></i> <span>' . esc_html__( 'VK', 'jnews-video' ) . '</span></a>';
						break;

					case 'reddit':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-reddit "><i class="fa fa-reddit"></i> <span>' . esc_html__( 'Reddit', 'jnews-video' ) . '</span></a>';
						break;

					case 'wechat':
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-wechat "><i class="fa fa-wechat"></i> <span>' . esc_html__( 'WeChat', 'jnews-video' ) . '</span></a>';
						break;

					case 'buffer' :
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-buffer "><i class="fa fa-buffer"></i> <span>' . esc_html__( 'WeChat', 'jnews-video' ) . '</span></a>';
						break;

					case 'telegram' :
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-telegram "><i class="fa fa-telegram"></i> <span>' . esc_html__( 'Telegram', 'jnews-video' ) . '</span></a>';
						break;

					case 'line' :
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-line "><i class="fa fa-line"></i> <span>' . esc_html__( 'Line', 'jnews-video' ) . '</span></a>';
						break;

					case 'hatena' :
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-hatena "><i class="fa fa-hatena"></i> <span>' . esc_html__( 'Hatena', 'jnews-video' ) . '</span></a>';
						break;

					case 'qrcode' :
						$icon_class = 'fa fa-qrcode';
						$share_url     = jnews_video_get_social_share_url( $social['social_share'], $post->ID );
						$share_output .= '<a href="' . $share_url . '" target="_blank" class="jeg_btn-qrcode "><i class="fa fa-qrcode"></i> <span>' . esc_html__( 'QR Code', 'jnews-video' ) . '</span></a>';
						break;
				}
			}
		}

		$share_output =
			'<div class="jeg_meta_share">
				<a href="#" ><i class="fa fa-share"></i> <span>' . jnews_return_translation( 'Share', 'jnews-video', 'share_video' ) . '</span></a>
				<div class="jeg_sharelist">
					' . $share_output . '
				</div>
			</div>';

		return $share_output;
	}
}

/**
 * Check if BuddyPress Installed and active.
 */
if ( ! function_exists( 'jnews_is_bp_active' ) ) {
	/**
	 * @return bool
	 */
	function jnews_is_bp_active() {

		if ( function_exists( 'bp_is_active' ) ) {
			return true;
		}

		return false;
	}
}

/**
 * Check if in BuddyPress page
 */
if ( ! function_exists( 'jnews_is_bp_directory_or_single' ) ) {
	/**
	 * @return bool
	 */
	function jnews_is_bp_directory_or_single() {

		if ( function_exists( 'bp_is_user' ) || function_exists( 'bp_is_group' ) || function_exists( 'bp_is_directory' ) ) {
			if ( bp_is_user() || bp_is_group() || bp_is_directory() ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'jnews_video_render_subscribe_member_actions' ) ) {
	/**
	 * @param $user_id
	 * @param bool    $counter
	 *
	 * @return mixed
	 */
	function jnews_video_render_subscribe_member_actions( $user_id, $counter = false ) {
		if ( function_exists( 'bp_follow_get_add_follow_button' ) && function_exists( 'bp_loggedin_user_id' ) ) {
			/**
			 * Reference buddypress-followers/_inc/bp-follow-templatetags.php:116
			 * Tombolnya muncul hanya ketika login
			 * butuh fake id
			 */
			$follower_id = bp_loggedin_user_id();
			$follower_id = $follower_id ? $follower_id : 999999999;

			$link_text    = jnews_return_translation( 'Subscribe', 'jnews-video', 'subscribe_button' );
			$is_following = bp_follow_is_following(
				array(
					'leader_id'   => $user_id,
					'follower_id' => $follower_id,
				)
			);

			if ( $is_following ) {
				$link_text = jnews_return_translation( 'Unsubscribe', 'jnews-video', 'unsubscribe_button' );
			}

			/**
			 * Show followers counter
			 */
			if ( $counter ) {
				$counts    = bp_follow_total_follow_counts( array( 'user_id' => $user_id ) );
				$link_text = sprintf( $link_text . '<span>%d</span>', $counts['followers'] );
			}

			$follow_button = bp_follow_get_add_follow_button(
				array(
					'leader_id'   => $user_id,
					'follower_id' => $follower_id,
					'link_text'   => $link_text,
					'link_class'  => '',
					'wrapper'     => '',
				)
			);

			return $follow_button;
		}

		return '';
	}
}

if ( ! function_exists( 'jnews_video_get_template_part' ) ) {
	/**
	 * @param $slug
	 * @param null $name
	 */
	function jnews_video_get_template_part( $slug, $name = null ) {
		do_action( "jnews_video_get_template_part_{$slug}", $slug, $name );
		$templates = array();
		if ( isset( $name ) ) {
			$templates[] = "{$slug}-{$name}.php";
		}
		$templates[] = "{$slug}.php";
		jnews_video_get_template_path( $templates, true, false );
	}
}


if ( ! function_exists( 'jnews_video_get_template_path' ) ) {
	/**
	 * @param $template_names
	 * @param bool           $load
	 * @param bool           $require_once
	 *
	 * @return string
	 */
	function jnews_video_get_template_path( $template_names, $load = false, $require_once = true ) {
		$located = '';
		foreach ( (array) $template_names as $template_name ) {
			if ( ! $template_name ) {
				continue;
			}
			/* search file within the JNEWS_VIDEO_DIR only */
			if ( file_exists( JNEWS_VIDEO_DIR . $template_name ) ) {
				$located = JNEWS_VIDEO_DIR . $template_name;
				break;
			}
		}
		if ( $load && '' !== $located ) {
			load_template( $located, $require_once );
		}

		return $located;
	}
}
if ( ! function_exists( 'jnews_unset_unnecessary_jnews_video' ) ) {
	/**
	 * @param $accepted
	 * @param $args
	 *
	 * @return array
	 */
	function jnews_unset_unnecessary_jnews_video( $accepted, $args ) {
		if ( isset( $args['include_playlist'] ) ) {
			$accepted = array_merge( $accepted, array( 'include_playlist' ) );
		}
		if ( isset( $args['visibility'] ) ) {
			$accepted = array_merge( $accepted, array( 'visibility' ) );
		}
		if ( isset( $args['status'] ) ) {
			$accepted = array_merge( $accepted, array( 'status' ) );
		}

		return $accepted;
	}

	add_filter( 'jnews_unset_unnecessary_attr', 'jnews_unset_unnecessary_jnews_video', 10, 2 );
}
if ( ! function_exists( 'jnews_default_query_jnews_video' ) ) {
	/**
	 * Add more video default query
	 *
	 * @param $args
	 * @param $attr
	 *
	 * @return mixed
	 */
	function jnews_default_query_jnews_video( $args, $attr ) {
		if ( isset( $attr['include_playlist'] ) ) {
			if ( ! empty( $attr['include_playlist'] ) ) {
				$args['post__in'] = explode( ',', $attr['include_playlist'] );
			}
		}

		if ( isset( $attr['sort_by'] ) ) {
			if ( 'index' === $attr['sort_by'] ) {
				$args['orderby'] = 'post__in';
				$args['order']   = 'DESC';
			}
		}

		if ( isset( $attr['visibility'] ) ) {
			if ( ! empty( $attr['visibility'] ) ) {
				$args['post_status'] = $attr['status'];
				$args['meta_query']  = array(
					array(
						'key'   => '_playlist_visibility',
						'value' => $attr['visibility'],
					),
				);
			}
		}

		return $args;
	}

	add_filter( 'jnews_default_query_args', 'jnews_default_query_jnews_video', 10, 2 );
}

if ( ! function_exists( 'jnews_video_select_visibility' ) ) {
	function jnews_video_select_visibility( $visibility = null ) {
		$selected    = ( empty( $visibility ) ) ? "selected='selected'" : '';
		$select_html = "<option disabled {$selected} value=''>- " . jnews_return_translation( 'Select Visibility', 'jnews-video', 'select_visibility' ) . ' -</option>';
		$options     = array(
			array(
				'text'  => esc_html__( 'Public', 'jnews-video' ),
				'value' => 'public',
			),
			array(
				'text'  => esc_html__( 'Private', 'jnews-video' ),
				'value' => 'private',
			),
		);

		foreach ( $options as $option ) {
			$selected     = ( $option['value'] == $visibility ) ? "selected='selected'" : '';
			$select_html .= "<option value='{$option['value']}' {$selected}>{$option['text']}</option>";
		}

		return "<select name='visibility'>{$select_html}</select>";
	}
}

if ( ! function_exists( 'jeg_find_playlist' ) ) {

	add_action( 'wp_ajax_jeg_find_playlist', 'jeg_find_playlist' );

	function jeg_find_playlist() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['query'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_playlist' ) ) {

			$query = new WP_Query(
				array(
					'post_type'      => 'playlist',
					'posts_per_page' => '15',
					'post_status'    => 'publish',
					'orderby'        => 'date',
					'order'          => 'DESC',
				)
			);

			$result = array();

			if ( $query->have_posts() ) {
				while ( $query->have_posts() ) {
					$query->the_post();

					$result[] = array(
						'value' => get_the_ID(),
						'text'  => get_the_title(),
					);
				}
			}

			wp_reset_postdata();
			wp_send_json_success( $result );
		}
	}
}

if ( ! function_exists( 'jeg_get_playlist_option' ) ) {
	function jeg_get_playlist_option( $value = null ) {
		$result = array();

		if ( ! empty( $value ) ) {
			$values = explode( ',', $value );

			foreach ( $values as $val ) {
				$result[] = array(
					'value' => $val,
					'text'  => get_the_title( $val ),
				);
			}
		}

		return $result;
	}
}

if ( ! function_exists( 'jeg_get_playlist_option' ) ) {
	add_action( 'wp_ajax_jeg_get_playlist_option', 'jeg_get_ajax_playlist_option' );
	function jeg_get_ajax_playlist_option() {
		if ( isset( $_REQUEST['nonce'], $_REQUEST['value'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['nonce'] ), 'jeg_find_playlist' ) ) {
			$value = sanitize_text_field( wp_unslash( $_REQUEST['value'] ) );
			wp_send_json_success( jeg_get_playlist_option( $value ) );
		}
	}
}

/**
 * Edit Playlist
 */
if ( ! function_exists( 'jnews_video_edit_playlist' ) ) {
	function jnews_video_edit_playlist( $post_id, $position = 'left' ) {
		if ( current_user_can( 'edit_posts' ) ) {
			$url = get_permalink( $post_id );

			return "<a class=\"jnews-edit-post {$position}\" href=\"{$url}\" target=\"_blank\">
                        <i class=\"fa fa-pencil\"></i>
                        <span>" . esc_html__( 'edit playlist', 'jnews-video' ) . '</span>
                    </a>';
		}

		return false;
	}
}
