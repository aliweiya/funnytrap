<?php
/**
 * @author Jegtheme
 */

namespace JNEWS_VIDEO\BuddyPress;

/**
 * Class BuddyPress_Menu
 *
 * @package JNEWS_VIDEO\BuddyPress
 */
class BuddyPress_Menu {

	/**
	 * List sub menu BuddyPress
	 *
	 * @var array
	 */
	public static $bp_nav_sub_items = array();

	/**
	 * List sub menu id BuddyPress
	 *
	 * @var array
	 */
	public static $bp_nav_sub_items_used_css_ids = array();

	/**
	 * Instance of BuddyPress_Menu
	 *
	 * @var BuddyPress_Menu
	 */
	private static $instance;

	/**
	 * BuddyPress_Menu constructor.
	 */
	private function __construct() {
		if ( ! defined( 'BP_DEFAULT_COMPONENT' ) ) {
			define( 'BP_DEFAULT_COMPONENT', 'profile' );
		}
		add_filter( 'jnews_get_user_nav', array( $this, 'get_user_nav' ) );

		add_action( 'bp_setup_nav', array( $this, 'setup_bp_member_nav' ), 20 );
	}

	/**
	 * Singleton page for BuddyPress_Menu Class
	 *
	 * @return BuddyPress_Menu
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Get user navigation list
	 *
	 * @return array
	 */
	public function get_user_nav() {
		$nav        = array();
		$member_nav = buddypress()->members->nav;

		$item_nav = $member_nav->get_primary();

		if ( is_array( $item_nav ) ) {
			foreach ( $item_nav as $item ) {
				$name = _bp_strip_spans_from_title( $item->name );
				if ( ! in_array( $item->slug, array( 'notifications', 'settings', 'messages', true ) ) ) {
					$nav[ $item->slug ] = $name;
				}
			}
		}

		return $nav;
	}

	/**
	 * Setup new BuddyPress member navigation
	 */
	public function setup_bp_member_nav() {
		global $bp;
		$nav = $bp->members->nav;
		$this->bp_add_nav();
		$this->bp_edit_nav( $nav );
	}

	/**
	 * Add playlist tab on nav BuddyPress
	 */
	public function bp_add_nav() {
		$main_nav[] = array(
			'name'                => jnews_return_translation( 'Playlist', 'jnews-video', 'playlist_bp_tab_title' ),
			'slug'                => 'playlist',
			'screen_function'     => array( $this, 'bp_public_playlist_page_screen_function' ),
			'default_subnav_slug' => $this->get_user_public_playlist_slug(),
		);
		if ( BuddyPress::is_bp_nouveau() ) {
			$main_nav[] = array(
				'name' => jnews_return_translation( 'Home', 'jnews-video', 'home_bp_tab_title' ),
				'slug' => 'front',
			);
		}

		$user_domain = bp_displayed_user_domain() ? bp_displayed_user_domain() : bp_loggedin_user_domain();

		$component_link = trailingslashit( $user_domain . 'playlist' );

		if ( get_current_user_id() === bp_displayed_user_id() ) {
			// Playlist submenu (only for logged in user).
			$sub_nav[] = array(
				'name'            => jnews_return_translation( 'Public', 'jnews-video', 'playlist_type_public' ),
				'slug'            => $this->get_user_public_playlist_slug(),
				'parent_url'      => $component_link,
				'parent_slug'     => 'playlist',
				'screen_function' => array( $this, 'bp_public_playlist_page_screen_function' ),
				'item_css_id'     => 'public-playlist',
			);

			$sub_nav[] = array(
				'name'            => jnews_return_translation( 'Private', 'jnews-video', 'playlist_type_private' ),
				'slug'            => $this->get_user_private_playlist_slug(),
				'parent_url'      => $component_link,
				'parent_slug'     => 'playlist',
				'screen_function' => array( $this, 'bp_private_playlist_page_screen_function' ),
				'item_css_id'     => 'private-playlist',
			);
		}

		$sub_nav[] = array(
			'name'            => _x( 'View', 'Member profile view', 'buddypress' ),
			'slug'            => 'classic',
			'parent_url'      => trailingslashit( bp_displayed_user_domain() . 'profile' ),
			'parent_slug'     => 'profile',
			'screen_function' => 'bp_members_screen_display_profile',
			'position'        => 2,
		);

		$nav_default[] = array(
			'parent_slug'     => 'profile',
			'subnav_slug'     => 'home',
			'screen_function' => array( $this, 'bp_home_page_screen_function' ),
		);

		foreach ( $main_nav as $nav ) {
			bp_core_new_nav_item( $nav );
		}
		foreach ( $sub_nav as $nav ) {
			bp_core_new_subnav_item( $nav );
		}
		foreach ( $nav_default as $nav ) {
			bp_core_new_nav_default( $nav );
		}

		bp_core_remove_subnav_item( 'profile', 'public' );
		bp_core_remove_subnav_item( 'profile', 'classic' );
	}

	/**
	 * Get public playlist slug
	 *
	 * @param string $default
	 *
	 * @return mixed|void
	 */
	public function get_user_public_playlist_slug( $default = 'public' ) {
		return apply_filters( 'get_user_public_playlist_slug', $default );
	}

	/**
	 * Get private playlist slug
	 *
	 * @param string $default
	 *
	 * @return mixed|void
	 */
	public function get_user_private_playlist_slug( $default = 'private' ) {
		return apply_filters( 'get_user_private_playlist_slug', $default );
	}

	/**
	 * Rename profile tabs on BP navigation
	 *
	 * @param $nav
	 */
	public function bp_edit_nav( $nav ) {
		$nav->edit_nav( array( 'name' => __( 'About', 'jnews_video' ) ), 'profile' );
		$nav->edit_nav( array( 'position' => 80 ), 'messages' );
		$nav->edit_nav( array( 'position' => 90 ), 'notifications' );
	}

	/**
	 * Set public playlist screen function
	 */
	public function bp_public_playlist_page_screen_function() {
		add_action( 'bp_template_content', array( $this, 'public_playlist_content' ) );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	/**
	 * Set public playlist screen function
	 */
	public function bp_private_playlist_page_screen_function() {
		add_action( 'bp_template_content', array( $this, 'private_playlist_content' ) );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	/**
	 * Set custom home screen function
	 */
	public function bp_home_page_screen_function() {
		add_action( 'bp_template_content', array( $this, 'home_content' ) );
		bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
	}

	/**
	 * Set public playlist content
	 */
	public function public_playlist_content() {
		jnews_video_get_template_part( '/fragment/buddypress/playlist/playlist-public' );
	}

	/**
	 * Set private playlist content
	 */
	public function private_playlist_content() {
		jnews_video_get_template_part( '/fragment/buddypress/playlist/playlist-private' );
	}

	/**
	 * Set custom home content
	 */
	public function home_content() {
		jnews_video_get_template_part( '/fragment/buddypress/members/single/custom-home' );
	}
}
