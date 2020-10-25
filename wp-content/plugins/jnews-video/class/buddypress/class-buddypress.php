<?php
/**
 * @author Jegtheme
 */

namespace JNEWS_VIDEO\BuddyPress;

/**
 * Class BuddyPress
 *
 * @package JNEWS_VIDEO\BuddyPress
 */
class BuddyPress {

	/**
	 * Instance of BuddyPress.
	 *
	 * @var BuddyPress
	 */
	private static $instance;


	/**
	 * @var \BP_Theme_Compat
	 */
	private static $bp_template;

	/**
	 * BuddyPress constructor.
	 */
	private function __construct() {
		if ( jnews_is_bp_active() ) {
			BuddyPress_Menu::get_instance();
			$this->setup_hook();
		}
	}

	/**
	 * Setup BuddyPress hook
	 */
	public function setup_hook() {
		add_action( 'bp_init', array( $this, 'register_bp_template' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_asset' ) );

		add_action( 'template_include', array( $this, 'bp_page_template' ) );
		add_filter( 'jnews_register_widget_location', array( $this, 'bp_register_home_widget_location' ) );
		add_filter( 'author_link', array( $this, 'author_video_link' ), null, 2 );
		add_filter( 'bp_before_attachment_cover_image_edit_image_parse_args', array( $this, 'cover_image' ) );
		add_filter(
			'bp_before_xprofile_cover_image_settings_parse_args',
			array(
				$this,
				'cover_image_css',
			),
			10,
			1
		);

		add_action( 'bp_member_header_actions_placeholder', array( $this, 'bp_member_action_placeholder' ) );
		add_action( 'bp_member_header_actions', array( $this, 'bp_open_action_dropdown' ), 1 );
		add_action( 'bp_member_header_actions', array( $this, 'bp_member_add_button_class_filters' ), 1 );
		add_action( 'bp_member_header_actions', array( $this, 'bp_close_action_dropdown' ), 9999 );

		add_filter( 'bp_before_groups_cover_image_settings_parse_args', array( $this, 'cover_image_css' ), 10, 1 );
		add_filter( 'bp_get_template_part', array( $this, 'bp_replace_template' ), 10, 3 );
		add_filter( 'bp_follow_get_add_follow_button', array( $this, 'bp_follow_get_add_follow_button' ), 10, 3 );
		add_filter( 'get_user_metadata', array( $this, 'bp_get_follower_metadata' ), 10, 4 );

		add_action( 'bp_member_header_actions', array( $this, 'bp_member_add_button_class_filters' ), 1 );

		add_action( 'plugins_loaded', array( $this, 'bp_follow_button_first' ) );
	}

	/**
	 * Singleton page for BuddyPress Class
	 *
	 * @return BuddyPress
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Set placeholder for BuddyPress member action
	 */
	public function bp_member_action_placeholder() {
		$items = array();

		if ( function_exists( 'bp_follow_add_follow_button' ) ) {
			$items[] = array(
				'text'          => jnews_return_translation( 'Subscribe', 'jnews-video', 'subscribe_button' ),
				'wrapper_class' => 'follow-button',
				'class'         => 'follow',
			);
		}

		if ( bp_is_active( 'friends' ) ) {
			$items[] = array(
				'text'          => esc_html__( 'Add Friend', 'buddypress' ),
				'wrapper_class' => 'friendship-button',
				'class'         => 'add',
			);
		}

		if ( ! count( $items ) ) {
			return;
		}

		$this->bp_open_action_dropdown();
		foreach ( $items as $index => $item ) : ?>
			<div class="generic-button menu-item <?php echo esc_html( $item['wrapper_class'] ); ?>">
				<a class="jeg_login_required <?php echo esc_html( $item['class'] ); ?>"><?php echo esc_html( $item['text'] ); ?></a>
			</div>
			<?php
		endforeach;
		$this->bp_close_action_dropdown();
		$this->rebuild_bp_member_nav();
	}

	/**
	 * Open action dropdown markup
	 */
	public function bp_open_action_dropdown() {
		?>
		<div class="jeg_action">
		<button class="jeg_action_toggle">
			<span></span>
			<span></span>
			<span></span>
		</button>

		<div class="jeg_action_content">
		<div class="sub-menu">
		<?php
	}

	/**
	 * Close action dropdown markup
	 */
	public function bp_close_action_dropdown() {
		?>
		</div>
		</div>
		</div>
		<?php
	}

	/**
	 * Sorting BuddyPress member navigation
	 *
	 * @return bool
	 */
	public function rebuild_bp_member_nav() {
		global $bp;
		$nav   = $bp->members->nav;
		$order = get_theme_mod( 'jnews_video_buddypress_members_nav', array() );
		if ( ! is_object( $nav ) || empty( $order ) || ! is_array( $order ) ) {
			return false;
		}

		$parent_nav   = array();
		$selected_nav = array();

		foreach ( $nav->get() as $item ) {
			if ( isset( $item['primary'] ) && $item['primary'] ) {
				if ( ! in_array( $item['slug'], array( 'notifications', 'settings', 'messages', true ) ) ) {
					$parent_nav[] = $item['slug'];
				}
			}
		}

		$position = 0;
		foreach ( $order as $slug ) {
			$position      += 5;
			$key            = $slug;
			$selected_nav[] = $slug;

			$item_nav = $nav->get( $key );

			if ( ! $item_nav ) {
				continue;
			}
			if ( (int) $item_nav->position !== (int) $position ) {
				$nav->edit_nav( array( 'position' => $position ), $slug );
			}
		}
		foreach ( $parent_nav as $slug ) {
			if ( ! in_array( $slug, $selected_nav, true ) ) {
				bp_core_remove_nav_item( $slug );
				foreach ( $nav->get() as $item ) {
					if ( isset( $item['parent_slug'] ) && $item['parent_slug'] === $slug ) {
						bp_core_remove_subnav_item( $slug, $item['slug'] );
					}
				}
			}
		}

		return true;
	}

	/**
	 * Replace author URL with profile member page url
	 *
	 * @param $url
	 * @param $user_id
	 *
	 * @return string
	 */
	public function author_video_link( $url, $user_id ) {
		$url = bp_core_get_user_domain( $user_id );
		$url = trailingslashit( $url . bp_get_profile_slug() );
		$url = trailingslashit( $url . 'home' );

		return $url;
	}

	/**
	 * Fix for /buddypress-followers/_inc/bp-follow-notifications.php at line 308.
	 * Operator [] is used on string value. We have to provide array here to prevent error on PHP 7.x
	 *
	 * @param $ret
	 * @param $object_id
	 * @param $meta_key
	 * @param $single
	 *
	 * @return array
	 */
	public function bp_get_follower_metadata( $ret, $object_id, $meta_key, $single ) {
		if ( 'bp_follow_has_notified' === $meta_key && $single && null === $ret ) {
			$ret = array( array() );
		}

		return $ret;
	}

	/**
	 * Get BuddyPress template
	 *
	 * @return mixed|void
	 */
	public function get_template() {
		$template = get_theme_mod( 'jnews_video_buddypress_template', '1' );

		return apply_filters( 'jnews_video_bp_template', $template );
	}

	/**
	 * Set main content width
	 *
	 * @return int
	 */
	public function main_content_width() {
		$layout = $this->get_layout();

		if ( in_array( $layout, array( 'right-sidebar', 'left-sidebar' ) ) ) {
			$sidebar = $this->get_sidebar();
			if ( ! is_active_sidebar( $sidebar ) ) {
				return 12;
			}
		}

		switch ( $layout ) {
			case 'left-sidebar':
			case 'right-sidebar':
				return 8;
			default:
				return 12;
		}
	}

	/**
	 * Get BuddyPress layout
	 *
	 * @return mixed|void
	 */
	public function get_layout() {
		$layout = get_theme_mod( 'jnews_video_buddypress_layout', 'right-sidebar' );

		return apply_filters( 'jnews_video_bp_layout', $layout );
	}

	/**
	 * Get BuddyPress sidebar content
	 *
	 * @return mixed|void
	 */
	public function get_sidebar() {
		$sidebar = get_theme_mod( 'jnews_video_buddypress_sidebar', 'default-sidebar' );

		return apply_filters( 'jnews_video_bp_sidebar', $sidebar );
	}

	/**
	 * Show layout class
	 */
	public function main_class() {
		$layout = $this->get_layout();

		switch ( $layout ) {
			case 'no-sidebar':
			case 'no-sidebar-narrow':
				echo 'jeg_sidebar_none';
				break;

			case 'left-sidebar':
				echo 'jeg_sidebar_left';
				break;

			default:
				break;
		}
	}

	/**
	 * Render sidebar
	 */
	public function render_sidebar() {
		if ( $this->has_sidebar() ) {
			jnews_video_get_template_part( '/fragment/buddypress/buddypress-sidebar' );
		}
	}

	/**
	 * Check if has sidebar
	 *
	 * @return bool
	 */
	public function has_sidebar() {
		$layout = $this->get_layout();

		$sidebar = array(
			'left-sidebar',
			'right-sidebar',
		);

		if ( in_array( $layout, $sidebar, true ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Replace BuddyPress xprofile template
	 *
	 * @param $old_template
	 * @param $slug
	 *
	 * @return array|null
	 */
	public function bp_replace_template( $old_template, $slug ) {

		$new_template = null;

		if ( 'members/single/home' === $slug ) {
			$new_template = array( 'profile-template.php' );
		}

		$new_template = ! empty( $new_template ) ? $new_template : $old_template;

		return $new_template;

	}

	/**
	 * Modify follow button
	 *
	 * @param $args
	 * @param $leader_id
	 * @param $follower_id
	 *
	 * @return mixed
	 */
	public function bp_follow_get_add_follow_button( $args, $leader_id, $follower_id ) {

		/**
		 * Change follow,unfollow text to subsrcibe, unsubscribe
		 */
		$link_text = htmlspecialchars_decode( $args['link_text'] );
		preg_match( '/<\/?([^\s^>]+)/', $link_text, $tag );
		if ( empty( $tag ) ) {
			$link_text    = jnews_return_translation( 'Subscribe', 'jnews-video', 'subscribe_button' );
			$is_following = bp_follow_is_following(
				array(
					'leader_id'   => $leader_id,
					'follower_id' => $follower_id,
				)
			);

			if ( $is_following ) {
				$link_text = jnews_return_translation( 'Unsubscribe', 'jnews-video', 'unsubscribe_button' );
			}
		}

		$args['block_self']        = false;
		$args['link_text']         = $link_text;
		$args['must_be_logged_in'] = false;

		if ( ! is_user_logged_in() ) {
			$args['link_class'] .= ' jeg_login_required';
		} else {
			$args['link_class'] .= ' jeg_bp_action';
		}

		return $args;
	}

	/**
	 * Add Class to the button
	 */
	public function bp_member_add_button_class_filters() {
		add_filter( 'bp_get_add_friend_button', array( $this, 'bp_get_menu_item_button' ) );
		add_filter( 'bp_follow_get_add_follow_button', array( $this, 'bp_get_menu_item_button' ) );
		add_filter( 'bp_get_send_public_message_button', array( $this, 'bp_get_menu_item_button' ) );
		add_filter( 'bp_get_send_message_button_args', array( $this, 'bp_get_menu_item_button' ) );
		$this->rebuild_bp_member_nav();
	}

	/**
	 * Add wrapper class to BuddyPress menu action button
	 *
	 * @param $button
	 *
	 * @return array
	 */
	public function bp_get_menu_item_button( $button ) {
		if ( ! is_array( $button ) ) {
			return $button;
		}

		if ( ! isset( $button['wrapper_class'] ) ) {
			$button['wrapper_class'] = 'menu-item';
		} else {
			$button['wrapper_class'] .= ' menu-item';
		}

		return $button;
	}

	/**
	 * Mark Follow Button as First Button
	 */
	public function bp_follow_button_first() {
		if ( function_exists( 'bp_follow_get_add_follow_button' ) ) {
			remove_action( 'bp_member_header_actions', 'bp_follow_add_profile_follow_button' );
			add_action( 'bp_member_header_actions', 'bp_follow_add_profile_follow_button', 2 );
		}
	}

	/**
	 * Custom BuddyPress cover image callback
	 *
	 * @param array $params
	 *
	 * @return string
	 */
	public function cover_image_callback( $params = array() ) {
		if ( empty( $params ) ) {
			return '';
		}

		return '
		#buddypress #header-cover-image {
			height: ' . absint( $params['height'] ) . 'px;
			background-image: url(' . esc_url( $params['cover_image'] ) . ');
		}
	';
	}

	/**
	 * Custom cover image settings
	 * bp_attachments_get_cover_image_settings
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public function cover_image_css( $settings = array() ) {
		/**
		 * We do not need to set the theme_handle
		 * because we do not remove BuddyPress style
		 */
		/** Adjust size */
		$settings['height'] = 300;
		$settings['width']  = 1600;

		$settings['callback'] = array( $this, 'cover_image_callback' );

		return $settings;
	}

	/**
	 * Prevent crop image for cover image
	 * \BP_Attachment::edit_image
	 *
	 * @param $settings
	 *
	 * @return mixed
	 */
	public function cover_image( $settings ) {
		$settings['crop']  = false;
		$settings['max_h'] = 0;
		$settings['max_w'] = 0;

		return $settings;
	}

	/**
	 * Replace BuddyPress Template page
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function bp_page_template( $template ) {
		add_filter( 'jnews_video_buddypress_class', array( $this, 'buddypress_wrapper_class' ) );
		$is_bp_page = bp_current_component() && ! is_404();

		if ( $is_bp_page ) {
			$template = JNEWS_VIDEO_TEMPLATE . 'buddypress/buddypress-template.php';
		}

		return $template;
	}

	/**
	 * Add wrapper class for nouveau template
	 *
	 * @param $classes
	 *
	 * @return string
	 */
	public function buddypress_wrapper_class( $classes ) {
		if ( $this->is_bp_nouveau() ) {
			$classes = 'buddypress-wrap';
		}

		return $classes;
	}

	/**
	 * Check BuddyPress template
	 *
	 * @return bool
	 */
	public static function is_bp_nouveau() {
		if ( 'nouveau' === self::$bp_template ) {
			return true;
		}

		return false;
	}

	/**
	 * Register new widget location
	 *
	 * @param $widget_location
	 *
	 * @return array
	 */
	public function bp_register_home_widget_location( $widget_location ) {
		$new_location    = array(
			'jnews-bp-home' => esc_html__( 'BuddyPress Single Member Home', 'jnews-video' ),
		);
		$widget_location = array_merge( $widget_location, $new_location );

		return $widget_location;
	}

	/**
	 * Load BuddyPress asset
	 */
	public function load_asset() {
		wp_enqueue_style( 'jnews-video-buddypress', JNEWS_VIDEO_URL . '/assets/css/buddypress/buddypress.css', null, JNEWS_VIDEO_VERSION );
	}

	/**
	 * Register custom BuddyPress template
	 */
	public function register_bp_template() {
		global $bp;
		if ( isset( $bp->site_options ) && ! $bp->site_options['hide-loggedout-adminbar'] ) {
			bp_update_option( 'hide-loggedout-adminbar', '1' );
		}
		if ( isset( $bp->theme_compat->theme ) && ! empty( $bp->theme_compat->theme ) ) {
			self::$bp_template = $bp->theme_compat->theme->__get( 'id' );
			if ( $this->is_bp_nouveau() ) {
				bp_update_option( '_bp_theme_package_id', 'legacy' );
				self::$bp_template = bp_get_theme_package_id();
			}
			if ( function_exists( 'bp_register_template_stack' ) ) {
				bp_register_template_stack( array( $this, 'register_bp_templates_location' ), 1 );
			}
		}
	}

	/**
	 * Register BuddyPress custom template location
	 *
	 * @return string
	 */
	public function register_bp_templates_location() {
		return JNEWS_VIDEO_TEMPLATE . '/';
	}

}
