<?php

namespace JNEWS_VIDEO\Objects;

use Exception;
use JNews\Module\Block\BlockViewAbstract;
use WP_Error;
use WP_Post;
use WP_Query;

/**
 * Class Playlist
 *
 * @package JNEWS_VIDEO\Objects
 */
class Playlist extends Object_Video {
	/**
	 * Watch Later Slug
	 */
	const WATCH_LATER = 'watch-later';
	/**
	 * Favorite Slug
	 */
	const FAVORITE = 'favorite';
	/**
	 * Instance of Playlist
	 *
	 * @var Playlist
	 */
	private static $instance;
	/**
	 * @var string
	 */
	private static $slug = 'playlist';
	/**
	 * @var int
	 */
	private static $perpage = 10;
	/**
	 * @var array
	 */
	private static $endpoint;
	/**
	 * @var string
	 */
	public $current_page;

	/**
	 * Playlist constructor.
	 */
	private function __construct() {
		$this->setup_endpoint();
		$this->setup_init();
	}

	/**
	 * Setup Playlist endpoint
	 */
	protected function setup_endpoint() {
		$endpoint = array(
			'watch-later' => array(
				'slug'  => 'watch-later',
				'label' => 'watch_later',
				'title' => esc_html__( 'Watch Later', 'jnews-video' ),
			),
			'favorite'    => array(
				'slug'  => 'favorite',
				'label' => 'favorite',
				'title' => esc_html__( 'Favorite', 'jnews-video' ),
			),
		);

		self::$endpoint = apply_filters( 'jnews_playlist_page_endpoint', $endpoint );
	}

	/**
	 * Setup Playlist init
	 */
	public function setup_init() {
		add_action( 'init', array( $this, 'setup_hook' ) );
		add_action( 'jnews_ajax_playlist_handler', array( $this, 'ajax_do_action_type' ) );
		add_filter( 'template_include', array( $this, 'playlist_template' ) );
		add_action( 'wpmu_new_blog', array( $this, 'new_site_activation' ) );

		add_action( 'deleted_post', array( $this, 'remove_posts' ) );

		add_action( 'jnews_post_added_to_playlist', array( $this, 'playlist_set_thumbnail' ), 10, 2 );
		add_action( 'jnews_post_removed_from_playlist', array( $this, 'playlist_update_thumbnail' ), 10, 2 );
		add_action( 'added_post_meta', array( $this, 'playlist_post_thumbnail_changed' ), 10, 4 );
		add_action( 'updated_post_meta', array( $this, 'playlist_post_thumbnail_changed' ), 10, 4 );
		add_action( 'deleted_post_meta', array( $this, 'playlist_post_thumbnail_deleted' ), 10, 4 );

		add_action( 'jnews_video_get_right_title', array( $this, 'get_right_title' ) );

		add_filter( 'jnews_video_asset_localize_script', array( $this, 'playlist_localize_script' ) );
		add_action( 'wp_footer', array( $this, 'render_popup_add_playlist' ) );
	}

	/**
	 * TODO: Implement plugin_activation() method.
	 */
	public static function plugin_activation() {
		if ( ! self::is_table_installed( self::get_table_name() ) ) {
			self::create_table();
		}
		self::flush_rewrite_rules();
	}

	/**
	 * TODO: Implement get_table_name() method.
	 *
	 * @return string
	 */
	public static function get_table_name() {
		global $wpdb;

		return $wpdb->prefix . JNEWS_VIDEO_PLAYLIST_DB_DATA;
	}

	/**
	 * Create Required Table
	 * TODO: Implement create_table() method.
	 */
	public static function create_table() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		$create_data_table = 'CREATE TABLE ' . self::get_table_name() . " (
			ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			playlist_id bigint(20) unsigned NOT NULL,
			post_id bigint(20) unsigned NOT NULL,
			post_order int(11) NOT NULL DEFAULT '0',
			date datetime NOT NULL default '0000-00-00 00:00:00',
	        date_gmt datetime NOT NULL default '0000-00-00 00:00:00',
	        PRIMARY KEY (ID),
	        KEY playlist_id (playlist_id),
	        KEY index_ID ( playlist_id, post_id, ID ),
	        KEY index_post_id ( playlist_id, date_gmt, post_id )
  		) {$charset_collate};";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $create_data_table );
	}

	/**
	 * Flush rewrite rules
	 */
	private static function flush_rewrite_rules() {
		self::add_rewrite_rule();

		global $wp_rewrite;
		$wp_rewrite->flush_rules();
	}

	/**
	 * Create new rewrite rule
	 */
	private static function add_rewrite_rule() {
		foreach ( self::$endpoint as $endpoint ) {
			add_rewrite_endpoint( $endpoint['slug'], EP_ROOT | EP_PAGES );
		}
	}

	/**
	 * Singleton page of Playlist class
	 *
	 * @return Playlist
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Get post detail
	 *
	 * @param null        $column
	 * @param $playlist_id
	 * @param $post_id
	 *
	 * @return bool|string
	 */
	public static function get_post_detail( $column, $playlist_id, $post_id ) {
		if ( empty( $column ) ) {
			return false;
		}
		if ( is_array( $column ) ) {
			$column = implode( ', ', $column );
		}
		global $wpdb;

		$results = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT {$column} FROM " . self::get_table_name() . ' WHERE playlist_id = %d and post_id = %d',
				$playlist_id,
				$post_id
			),
			ARRAY_A
		);

		$data = '';

		if ( $results ) {
			foreach ( $results as $result ) {
				$data = $result;
			}
		}

		return $data;
	}

	/**
	 * Override new site activation
	 *
	 * @param int $blog_id The ID of the blog.
	 */
	public function new_site_activation( $blog_id ) {
		return parent::new_site_activation( $blog_id ); // TODO: Change the autogenerated stub
	}

	/**
	 * Setup Playlist hook
	 */
	public function setup_hook() {
		self::playlist_post_type();
		self::add_rewrite_rule();
	}

	/**
	 * Register Playlist post type
	 */
	private static function playlist_post_type() {
		jnews_register_post_type(
			self::$slug,
			array(
				'labels'              => array(
					'name'                  => esc_html__( 'Playlist', 'jnews-video' ),
					'singular_name'         => esc_html__( 'Playlist', 'jnews-video' ),
					'menu_name'             => esc_html__( 'Playlist', 'jnews-video' ),
					'add_new'               => esc_html__( 'Add New', 'jnews-video' ),
					'add_new_item'          => esc_html__( 'Add New Playlist', 'jnews-video' ),
					'edit_item'             => esc_html__( 'Edit Playlist', 'jnews-video' ),
					'new_item'              => esc_html__( 'New Playlist', 'jnews-video' ),
					'all_item'              => esc_html__( 'All Playlist', 'jnews-video' ),
					'view_item'             => esc_html__( 'View Playlist', 'jnews-video' ),
					'search_items'          => esc_html__( 'Search Playlist', 'jnews-video' ),
					'not_found'             => esc_html__( 'No Playlist found', 'jnews-video' ),
					'not_found_in_trash'    => esc_html__( 'No Playlist in Trash', 'jnews-video' ),
					'parent_item_colon'     => '',
					'featured_image'        => esc_html__( 'Playlist Image', 'jnews-video' ),
					'set_featured_image'    => esc_html__( 'Set Playlist Image', 'jnews-video' ),
					'remove_featured_image' => esc_html__( 'Remove Playlist Image', 'jnews-video' ),
					'use_featured_image'    => esc_html__( 'Use as Playlist Image', 'jnews-video' ),
					'attributes'            => esc_html__( 'Playlist Attributes', 'jnews-video' ),
					'filter_items_list'     => esc_html__( 'Filter Playlist list', 'jnews-video' ),
					'items_list_navigation' => esc_html__( 'Playlist list navigation', 'jnews-video' ),
					'items_list'            => esc_html__( 'Playlist list', 'jnews-video' ),
				),
				'public'              => true,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'exclude_from_search' => true,
				'show_in_menu'        => true,
				'menu_icon'           => 'dashicons-playlist-video',
				'rewrite'             => array(
					'slug'  => self::$slug,
					'feeds' => true,
				),
				'has_archive'         => false,
				'supports'            => apply_filters(
					'jnews_playlist_supports',
					array(
						'title',
						'author',
						'thumbnail',
					)
				),
			)
		);
	}

	/**
	 * Render Playlist content loop
	 */
	public function render_playlist_content_loop() {
		do_action( 'jnews_before_playlist_items' );

		$playlist_id  = get_the_ID();
		$playlist_ids = $this->get_posts( $playlist_id, self::$perpage );

		$playlist_query = new WP_Query(
			array(
				'post__in'       => ! empty( $playlist_ids ) ? $playlist_ids : array( '-10' ),
				'orderby'        => 'post__in',
				'posts_per_page' => - 1,
				'post_type'      => 'any',
			)
		);

		set_query_var( 'playlist_id', absint( $playlist_id ) );

		if ( $playlist_query->have_posts() ) {
			?>
			<ul class="jnews-playlist-items" data-playlist-id="<?php echo $playlist_id; ?>">
				<?php
				while ( $playlist_query->have_posts() ) {
					$playlist_query->the_post();
					jnews_video_get_template_part( '/fragment/playlist/playlist-content', 'item' );
				}
				?>
			</ul>
			<?php
			$this->render_load_more( 1, $playlist_id );

		} else {
			$title = get_the_title();
			if ( $this->is_default_content() ) {
				if ( ! empty( self::$endpoint ) && ! empty( $this->current_page ) ) {
					$title = self::$endpoint[ $this->current_page ]['title'];
				}
			}
			$no_content = '<div class=\'jeg_empty_module\'>' . sprintf( jnews_return_translation( '%s is empty', 'jnews-video', 'playlist_is_empty' ), $title ) . '</div>';
			echo apply_filters( 'jnews_module_no_content', $no_content );
		}
		wp_reset_postdata();

		do_action( 'jnews_after_playlist_items' );
	}

	/**
	 * Return list of post ids belong to the playlist
	 *
	 * @param int $max
	 * @param int $offset
	 * @param int $playlist_id
	 *
	 * @return array
	 */
	public function get_posts( $playlist_id, $max = null, $offset = 0 ) {
		global $wpdb;

		if ( $max || $offset ) {
			$results = $wpdb->get_results(
				$wpdb->prepare(
					'SELECT post_id FROM ' . self::get_table_name() . ' WHERE playlist_id = %d ORDER BY date_gmt DESC LIMIT %d OFFSET %d',
					$playlist_id,
					$max,
					$offset
				),
				ARRAY_A
			);
		} else {
			$results = $wpdb->get_results(
				$wpdb->prepare(
					'SELECT post_id FROM ' . self::get_table_name() . ' WHERE playlist_id = %d ORDER BY date_gmt DESC',
					$playlist_id
				),
				ARRAY_A
			);
		}

		$ids = array();

		if ( $results ) {
			foreach ( $results as $result ) {
				$ids[] = $result['post_id'];
			}
		}

		return $ids;
	}

	/**
	 * Render load more playlist content
	 *
	 * @param $paging
	 * @param $playlist_id
	 */
	public function render_load_more( $paging, $playlist_id ) {
		if ( $this->can_render_load_more( $paging, $playlist_id ) ) {
			?>
			<div class="jeg_block_loadmore jeg_playlist_load_more">
				<a href="#" data-paging="<?php echo esc_attr( $paging ); ?>" class=''
				   data-load='<?php jnews_print_translation( 'Show More', 'jnews-video', 'show_more' ); ?>'
				   data-loading='<?php jnews_print_translation( 'Loading...', 'jnews-video', 'loading_video' ); ?>'>
					<?php jnews_print_translation( 'Show More', 'jnews-video', 'show_more' ); ?>
					<i class="fa fa-angle-down"></i>
				</a>
			</div>
			<?php
		}
	}

	/**
	 * Check if can render load more
	 *
	 * @param $paging
	 * @param $playlist_id
	 *
	 * @return bool
	 */
	public function can_render_load_more( $paging, $playlist_id ) {
		$total = sizeof( $this->get_posts( $playlist_id ) );
		$limit = $paging * self::$perpage;

		return $total > $limit;
	}

	/**
	 * Check if the Playlist is default content ( Watch Later, Favorite )
	 *
	 * @return bool
	 */
	public function is_default_content() {
		global $wp;
		if ( $this->is_default_playlist_page( $wp ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if the page is default playlist ( Watch Later, Favorite )
	 *
	 * @param $wp
	 *
	 * @return bool
	 */
	public function is_default_playlist_page( $wp ) {
		$bool          = false;
		$playlist_type = get_post_meta( get_the_ID(), '_playlist_type', true );
		if ( $this->is_video_favorite( $playlist_type ) || $this->is_video_watchlater( $playlist_type ) ) {
			$this->setup_current_page( $playlist_type );
			$bool = true;
		}
		if ( is_user_logged_in() && ! is_admin() ) {
			foreach ( self::$endpoint as $key => $value ) {
				if ( isset( $wp->query_vars[ $value['slug'] ] ) ) {
					$this->setup_current_page( $value['slug'] );
					$bool = true;
				}
			}
		}

		return $bool;
	}

	/**
	 * Check if playlist favorite
	 *
	 * @param $playlist_id
	 *
	 * @return bool
	 */
	public function is_video_favorite( $playlist_id ) {
		if ( 'favorite' === $playlist_id ) {
			return true;
		}

		return false;
	}

	/**
	 * Check if playlist watch later
	 *
	 * @param $playlist_id
	 *
	 * @return bool
	 */
	public function is_video_watchlater( $playlist_id ) {
		if ( 'watch-later' === $playlist_id ) {
			return true;
		}

		return false;
	}

	/**
	 * Set current page value
	 *
	 * @param $page
	 */
	protected function setup_current_page( $page ) {
		foreach ( self::$endpoint as $key => $value ) {
			if ( $page === $value['slug'] ) {
				$this->current_page = $key;
			}
		}
	}

	/**
	 * @param $option
	 *
	 * @return mixed
	 */
	public function playlist_localize_script( $option ) {
		$option['user_playlist'] = call_user_func(
			function () {
				$result = array();
				$posts  = jnews_video_get_playlist(
					get_current_user_id(),
					- 1,
					'latest',
					array(
						'public',
						'private',
					)
				);
				foreach ( $posts as $post ) {
					$result[ $post->ID ] = $post->post_title;
				}

				return $result;
			}
		);

		return $option;
	}

	/**
	 * Get the right title
	 */
	public function get_right_title() {
		if ( isset( $this->current_page ) ) {
			echo jnews_return_translation( self::$endpoint[ $this->current_page ]['title'], 'jnews-video', self::$endpoint[ $this->current_page ]['label'] );
		}
	}

	/**
	 * Check is post in playlist
	 *
	 * @param $post_id
	 * @param $playlist_string
	 *
	 * @return bool|int
	 */
	public function is_in_playlist( $post_id, $playlist_string ) {
		$playlist_id = is_string( $playlist_string ) ? $this->get_playlist_by_user( get_current_user_id(), $playlist_string )->ID : $playlist_string;

		return $this->in_playlist( $post_id, $playlist_id );
	}

	/**
	 * Get playlist by user id
	 *
	 * @param $id
	 * @param $slug
	 *
	 * @return array|int|null|WP_Error|WP_Post
	 */
	public function get_playlist_by_user( $id, $slug = null ) {
		$playlist = array();
		if ( ! empty( $slug ) ) {
			$uslug    = $this->get_unique_slug( $slug, $id );
			$playlist = $this->get_default_playlist( $slug, $id );

			if ( is_wp_error( $playlist ) ) {
				$playlist = $this->add_default_playlist( $slug, $uslug );
				if ( is_wp_error( $playlist ) ) {
					return $playlist;
				}
				$playlist = $this->get_playlist_by_id( $playlist );
			}
			if ( is_array( $playlist ) ) {
				foreach ( $playlist as $id ) {
					// we only need the one data.
					$playlist = $this->get_playlist_by_id( $id );
				}
			}
		} else {
			$args  = array(
				'post_type'      => self::$slug,
				'author__in'     => $id,
				'posts_per_page' => - 1,
			);
			$query = new WP_Query( $args );
			foreach ( $query->posts as $post ) {
				$playlist[] = $post->ID;
			}
			wp_reset_postdata();
		}

		return $playlist;
	}

	/**
	 * Return unique playlist slug
	 *
	 * @param $prefix_slug
	 * @param $user_id
	 *
	 * @return string
	 */
	public function get_unique_slug( $prefix_slug, $user_id ) {
		return sprintf( '%d-%s', $user_id, $prefix_slug );
	}

	/**
	 * Get default playlist by playlist type post meta
	 *
	 * @param $meta_value
	 * @param null       $user
	 *
	 * @return array|WP_Error
	 */
	public function get_default_playlist( $meta_value, $user = null ) {
		$args        = array(
			'post_type'  => self::$slug,
			'author__in' => ! empty( $user ) ? $user : '',
			'meta_query' => array(
				array(
					'key'     => '_playlist_type',
					'value'   => $meta_value,
					'compare' => 'LIKE',
				),
			),
		);
		$playlist_id = array();
		$playlist    = new WP_Query( $args );
		foreach ( $playlist->posts as $post ) {
			$playlist_id[] = $post->ID;
		}
		wp_reset_postdata();

		if ( empty( $playlist_id ) ) {
			return new WP_Error( 'playlist_not_found', jnews_return_translation( 'Playlist not found!', 'jnews-video', 'playlist_not_found' ) );
		}

		return $playlist_id;
	}

	/**
	 * add default playlist for user
	 *
	 * @param $slug
	 * @param $uslug
	 *
	 * @return int|WP_Error
	 */
	public function add_default_playlist( $slug, $uslug ) {
		$playlist_id = '';
		if ( $this->is_video_watchlater( $slug ) ) {
			add_filter(
				'jnews_video_create_playlist',
				function ( $args ) use ( $uslug, $slug ) {
					$args['title'] = 'Watch Later';
					$args['slug']  = $uslug;
					$args['type']  = $slug;

					return $args;
				}
			);
			$playlist_id = $this->create_playlist( true );
		}
		if ( $this->is_video_favorite( $slug ) ) {
			add_filter(
				'jnews_video_create_playlist',
				function ( $args ) use ( $uslug, $slug ) {
					$args['title'] = 'Favorite';
					$args['slug']  = $uslug;
					$args['type']  = $slug;

					return $args;
				}
			);
			$playlist_id = $this->create_playlist( true );
		}
		if ( ! empty( $playlist_id ) ) {
			return $playlist_id;
		}

		return new WP_Error( 'playlist_invalid_playlist_id', jnews_return_translation( 'Playlist ID not set!', 'jnews-video', 'playlist_id_not_set' ) );
	}

	/**
	 * Create playlist
	 *
	 * @param bool $createadd
	 *
	 * @return int|WP_Error
	 */
	public function create_playlist( $createadd = false ) {
		$user_id = get_current_user_id();

		try {

			if ( empty( $_POST['title'] ) && ! $createadd ) {
				throw new Exception( jnews_return_translation( 'Playlist name cannot be empty', 'jnews-video', 'playlist_name_cannot_be_empty' ) );
			}
			$args = array(
				'title'      => isset( $_POST['title'] ) ? $_POST['title'] : '',
				'slug'       => '',
				'post_type'  => self::$slug,
				'status'     => 'private',
				'author'     => $user_id,
				'content'    => isset( $_POST['content'] ) ? $_POST['content'] : '',
				'visibility' => isset( $_POST['visibility'] ) ? $_POST['visibility'] : 'private',
				'type'       => 'custom',
			);
			$args = $this->validation_visibility( $args );
			$args = apply_filters( 'jnews_video_create_playlist', $args );

			$post_id = wp_insert_post(
				array(
					'post_title'   => sanitize_text_field( $args['title'] ),
					'post_name'    => $args['slug'],
					'post_type'    => $args['post_type'],
					'post_status'  => $args['status'],
					'post_author'  => $args['author'],
					'post_content' => sanitize_textarea_field( $args['content'] ),
				)
			);

			if ( is_wp_error( $post_id ) ) {
				throw new Exception( $post_id->get_error_message() );
			} else {
				add_post_meta( $post_id, '_playlist_visibility', $args['visibility'] );
				add_post_meta( $post_id, '_playlist_type', $args['type'] );

				if ( ! $createadd ) {
					wp_send_json(
						array(
							'response' => 1,
							'playlist' => array( $post_id, sanitize_text_field( $_POST['title'] ) ),
							'message'  => jnews_return_translation( 'Your playlist has been created', 'jnews-video', 'playlist_has_been_created' ),
						)
					);
				} else {
					return $post_id;
				}
			}
		} catch ( Exception $e ) {
			wp_send_json(
				array(
					'response' => 0,
					'message'  => '<p class="alert alert-error">' . $e->getMessage() . '</p>',
				)
			);
		}
	}

	/**
	 *
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	protected function validation_visibility( $args ) {
		$valid_visibility   = array(
			self::get_playlist_visibility_public(),
			self::get_playlist_visibility_private(),
		);
		$args['visibility'] = ( in_array( $args['visibility'], $valid_visibility, true ) ) ? $args['visibility'] : 'private';
		if ( self::get_playlist_visibility_private() === $args['visibility'] ) {
			$args['status'] = 'private';
		} else {
			$args['status'] = 'publish';
		}

		return $args;
	}

	/**
	 * Return public playlist visibility name
	 *
	 * @return mixed|string
	 */
	public static function get_playlist_visibility_public() {
		return apply_filters( 'playlist_visibility_public', 'public' );
	}

	/**
	 * Return private playlist visibility name
	 *
	 * @return mixed|string
	 */
	public static function get_playlist_visibility_private() {
		return apply_filters( 'playlist_visibility_private', 'private' );
	}

	/**
	 * Get playlist by id
	 *
	 * @param $id
	 *
	 * @return array|null|WP_Post
	 */
	public function get_playlist_by_id( $id ) {
		return get_post( $id );
	}

	/**
	 * Checks if a post exists in an playlist
	 *
	 * @param $post_id
	 * @param $playlist_id
	 *
	 * @return bool|int
	 */
	public function in_playlist( $post_id, $playlist_id ) {
		global $wpdb;

		// Prepare to use in SQL.
		$playlist_id = (int) $playlist_id;
		$post_id     = (int) $post_id;

		$id = $wpdb->get_var( $wpdb->prepare( 'SELECT ID FROM ' . self::get_table_name() . ' WHERE playlist_id = %d AND post_id = %d', $playlist_id, $post_id ) );

		if ( null !== $id ) {
			return (int) $id;
		}

		return false;
	}

	/**
	 * Set playlist featured image
	 *
	 * @param $post_id
	 * @param $playlist_id
	 */
	public function playlist_set_thumbnail( $post_id, $playlist_id ) {
		if ( ! empty( $post_id ) ) {
			$playlist_type = get_post_meta( $playlist_id, '_playlist_type', true );
			if ( ! has_post_thumbnail( $playlist_id ) || 'custom' !== $playlist_type ) {
				$post_thumbnail_id = (int) get_post_thumbnail_id( $post_id );

				if ( $post_thumbnail_id > 0 ) {
					set_post_thumbnail( $playlist_id, $post_thumbnail_id );
					update_post_meta( $playlist_id, '_featured_image_from_post', $post_id );
				}
			}
		}
	}

	/**
	 * Update playlist featured image
	 *
	 * @param $post_id
	 * @param $playlist_id
	 */
	public function playlist_update_thumbnail( $post_id, $playlist_id ) {
		// get last playlist.
		$post = $this->get_last_post_playlist_id( $playlist_id );

		if ( ! empty( $post ) ) {
			$post_id           = $post[0];
			$post_thumbnail_id = (int) get_post_thumbnail_id( $post_id );
			set_post_thumbnail( $playlist_id, $post_thumbnail_id );
		} else {
			delete_post_thumbnail( $playlist_id );
			delete_post_meta( $playlist_id, '_featured_image_from_post' );
		}
	}

	/**
	 * Get latest post added from playlist
	 *
	 * @param $playlist_id
	 *
	 * @return array
	 */
	public function get_last_post_playlist_id( $playlist_id ) {
		return $this->get_posts( $playlist_id, 1, 0 );
	}

	/**
	 * Update all playlist featured images if used featured image for a post changed
	 *
	 * @param $post_id
	 * @param $meta_key
	 * @param $meta_value
	 */
	public function playlist_post_thumbnail_changed( $post_id, $meta_key, $meta_value ) {
		if ( '_thumbnail_id' === $meta_key ) {
			$posts = get_posts(
				array(
					'post_type'      => self::$slug,
					'meta_key'       => '_featured_image_from_post',
					'meta_value'     => $post_id,
					'posts_per_page' => 1,
				)
			);
			if ( ! empty( $posts ) ) {
				$playlist_id = $posts[0]->ID;
				set_post_thumbnail( $playlist_id, $meta_value );
			}
		}
	}

	/**
	 * Update all playlist featured images if used featured image for a post deleted
	 *
	 * @param $post_id
	 * @param $meta_key
	 */
	public function playlist_post_thumbnail_deleted( $post_id, $meta_key ) {
		if ( '_thumbnail_id' === $meta_key ) {
			$posts = get_posts(
				array(
					'post_type'      => self::$slug,
					'meta_key'       => '_featured_image_from_post',
					'meta_value'     => $post_id,
					'posts_per_page' => 1,
				)
			);

			if ( ! empty( $posts ) ) {
				$playlist_id = $posts[0]->ID;
				delete_post_thumbnail( $playlist_id );
			}
		}
	}

	/**
	 * Count post in playlist
	 *
	 * @param $playlist_id
	 *
	 * @return int
	 */
	public function count_posts( $playlist_id ) {
		global $wpdb;
		$post_count = $wpdb->get_var( 'SELECT COUNT(*) FROM ' . self::get_table_name() . " WHERE playlist_id = {$playlist_id}" );

		return (int) $post_count;
	}

	/**
	 * Get playlist by slug
	 *
	 * @param $slug
	 *
	 * @return array|null|WP_Error|WP_Post
	 */
	public function get_playlist_by_slug( $slug ) {
		$post_type = self::$slug;
		$playlist  = get_page_by_path( $slug, OBJECT, $post_type );
		if ( $playlist ) {
			return $this->get_playlist_by_id( $playlist->ID );
		}

		return new WP_Error( 'playlist_not_found', jnews_return_translation( 'Playlist not found!', 'jnews-video', 'playlist_not_found' ) );
	}

	/**
	 * Build list playlist
	 *
	 * @param null $playlist_id
	 * @param null $visibility
	 *
	 * @return string
	 */
	public function build_list_playlist( $playlist_id = null, $visibility = null ) {
		$post_per_page = get_theme_mod( 'jnews_playlist_number', 10 );
		$include_post  = implode( ',', $playlist_id );

		$attr = array(
			'date_format'            => get_theme_mod( 'jnews_playlist_date', 'default' ),
			'date_format_custom'     => get_theme_mod( 'jnews_playlist_date_custom', 'Y/m/d' ),
			'pagination_number_post' => $post_per_page,
			'number_post'            => $post_per_page,
			'include_post'           => $include_post,
			'post_type'              => self::$slug,
			'visibility'             => ! empty( $visibility ) ? $visibility : '',
			'sort_by'                => 'latest',
			'pagination_mode'        => get_theme_mod( 'jnews_playlist_pagination', 'loadmore' ),
			'paged'                  => 1,
			'column_width'           => 8,
		);
		$attr = $this->validation_visibility( $attr );

		$name = 'JNews_Video_Blockplaylist';
		$name = jnews_get_view_class_from_shortcode( $name );

		/** Create module playlist @var $content_instance BlockViewAbstract */
		$content_instance = jnews_get_module_instance( $name );
		$result           = $content_instance->build_module( $attr );

		$output =
			"<div class='jnews_playlist_post'>
                {$result}
            </div>";

		return $output;
	}

	/**
	 * Action remove all post
	 *
	 * @param $playlist_id
	 *
	 * @return bool|WP_Error
	 */
	public function remove_posts( $playlist_id ) {
		if ( $this->is_playlist( $playlist_id ) ) {
			$playlist = $this->get_playlist_by_id( $playlist_id );

			if ( $playlist ) {
				return $this->remove_all_posts( $playlist->ID );
			}
		}

		return false;
	}

	/**
	 * Check if the post is playlist
	 *
	 * @param $playlist_id
	 *
	 * @return bool
	 */
	public function is_playlist( $playlist_id ) {
		$playlist = get_post( $playlist_id );

		if ( ! $playlist ) {
			return false;
		}

		return get_post_type( $playlist ) === self::$slug;
	}

	/**
	 * Remove all post in playlist
	 *
	 * @param $playlist_id
	 *
	 * @return bool|WP_Error
	 */
	protected function remove_all_posts( $playlist_id ) {
		global $wpdb;
		$affected_rows = $wpdb->delete(
			self::get_table_name(),
			array(
				'playlist_id' => $playlist_id,
			),
			array(
				'%d',
			)
		);

		if ( false === $affected_rows ) {
			return new WP_Error( 'delete_playlist_posts_failed', jnews_return_translation( 'Could not delete playlist posts!', 'jnews-video', 'failed_delete_playlist_posts' ) );
		}
		do_action( 'jnews_posts_removed_from_playlist', $playlist_id );

		return true;
	}

	/**
	 * Register Playlist template
	 *
	 * @param $template
	 *
	 * @return string
	 */
	public function playlist_template( $template ) {
		global $wp;
		$is_archive_playlist = is_archive() && is_post_type_archive( self::$slug );

		if ( $is_archive_playlist ) {
			$template = JNEWS_VIDEO_TEMPLATE . '/playlist/playlist.php';
		}
		if ( is_singular( self::$slug ) || $this->is_default_playlist_page( $wp ) ) {
			$template = JNEWS_VIDEO_TEMPLATE . '/playlist/single-playlist.php';
		}

		return $template;
	}

	/**
	 * Ajax action
	 *
	 * @throws Exception
	 */
	public function ajax_do_action_type() {
		if ( is_user_logged_in() ) {
			$this->do_action_type();
		} else {
			wp_send_json(
				array(
					'response' => 0,
					'message'  => jnews_return_translation( 'You must login to do this thing!', 'jnews-video', 'video_must_login' ),
				)
			);
		}

		die();
	}

	/**
	 * Playlist action list
	 *
	 * @throws Exception
	 */
	public function do_action_type() {
		$nonce = empty( $_POST['nonce'] ) ? false : wp_verify_nonce( sanitize_key( $_POST['nonce'] ), 'jnews-playlist-nonce' );
		switch ( $_POST['type'] ) {
			case 'add_post':
				try {
					$this->add_post( $_POST['post_id'], $_POST['playlist_id'] );
					if ( is_numeric( $_POST['playlist_id'] ) ) {
						$playlist = $this->get_playlist_by_id( $_POST['playlist_id'] );
					} else {
						$playlist = $this->get_playlist_by_user( get_current_user_id(), $_POST['playlist_id'] );
						wp_send_json(
							array(
								'response' => 1,
								'message'  => sprintf( jnews_return_translation( 'Added to %s', 'jnews-video', 'added_to_default_playlist' ), $playlist->post_title ),
							)
						);
					}
					wp_send_json(
						array(
							'response' => 1,
							'message'  => sprintf( jnews_return_translation( 'Added to playlist %s', 'jnews-video', 'added_to_playlist' ), $playlist->post_title ),
						)
					);
				} catch ( Exception $e ) {
					wp_send_json(
						array(
							'response' => 0,
							'message'  => $e->getMessage(),
						)
					);
				}
				break;
			case 'exclude_post':
			case 'remove_post':
				try {
					$this->remove_post( $_POST['post_id'], $_POST['playlist_id'] );
					if ( is_numeric( $_POST['playlist_id'] ) ) {
						$playlist = $this->get_playlist_by_id( $_POST['playlist_id'] );
					} else {
						$playlist = $this->get_playlist_by_user( get_current_user_id(), $_POST['playlist_id'] );
					}
					wp_send_json(
						array(
							'response' => 1,
							'message'  => sprintf( jnews_return_translation( 'Removed from playlist %s', 'jnews-video', 'removed_from_playlist' ), $playlist->post_title ),
						)
					);
				} catch ( Exception $e ) {
					wp_send_json(
						array(
							'response' => 0,
							'message'  => $e->getMessage(),
						)
					);
				}

				break;
			case 'create_playlist':
				if ( $nonce ) {
					if ( ! empty( $_POST['post_id'] ) ) {
						try {
							$playlist_id = $this->create_playlist( true );
							$this->add_post( $_POST['post_id'], $playlist_id );
							$playlist = $this->get_playlist_by_id( $playlist_id );
							if ( ! $playlist ) {
								throw new Exception( sprintf( jnews_return_translation( 'Playlist with id %s not found!', 'jnews-video', 'playlist_id_not_found' ), $playlist_id ) );
							}

							wp_send_json(
								array(
									'response' => 1,
									'message'  => sprintf( jnews_return_translation( 'Added to playlist %s', 'jnews-video', 'added_to_playlist' ), $playlist->post_title ),
								)
							);
						} catch ( Exception $e ) {
							wp_send_json(
								array(
									'response' => 0,
									'message'  => $e->getMessage(),
								)
							);
						}
					} else {
						$this->create_playlist( false );
					}
				}
				break;
			case 'edit_playlist':
				if ( $nonce ) {
					$this->edit_playlist();
				}
				break;
			case 'delete_playlist':
				if ( $nonce ) {
					$this->delete_playlist();
				}
				break;
			case 'load_more':
				$this->load_more_next( $_POST['playlist_id'], $_POST['last'] );
				break;
			default:
				wp_send_json(
					array(
						'response' => 0,
						'message'  => jnews_return_translation( 'Internal Server Error!', 'jnews-video', 'internal_server_error' ),
					)
				);
				break;
		}
	}

	/**
	 * Process add post
	 *
	 * @param $post_id
	 * @param $playlist_id
	 *
	 * @return bool|WP_Error
	 * @throws Exception
	 */
	public function add_post( $post_id, $playlist_id ) {
		if ( empty( $playlist_id ) ) {
			throw new Exception( jnews_return_translation( 'Playlist ID not set!', 'jnews-video', 'playlist_id_not_set' ) );
		}
		if ( empty( $post_id ) ) {
			throw new Exception( jnews_return_translation( 'Post ID not set!', 'jnews-video', 'post_id_not_set' ) );
		}
		$user_id = get_current_user_id();

		if ( is_numeric( $playlist_id ) ) {
			$playlist = $this->get_playlist_by_id( $playlist_id );
		} else {
			$playlist = $this->get_playlist_by_user( $user_id, $playlist_id );
		}

		if ( ! $playlist ) {
			throw new Exception( sprintf( jnews_return_translation( 'Playlist with id %s not found!', 'jnews-video', 'playlist_id_not_found' ), $playlist_id ) );
		}
		if ( $user_id !== (int) $playlist->post_author ) {
			throw new Exception( sprintf( jnews_return_translation( 'User %s is not the owner!', 'jnews-video', 'user_is_not_the_owner' ), $user_id ) );
		}
		if ( $this->in_playlist( $post_id, $playlist->ID ) ) {
			return true;
		}

		$post = get_post( $post_id );
		if ( ! $post ) {
			throw new Exception( jnews_return_translation( 'Post not exists!', 'jnews-video', 'post_not_exists' ) );
		}

		$excluded = apply_filters( 'playlist_excluded_post_types', array( 'attachment', self::$slug ) );
		if ( in_array( get_post_type( $post ), $excluded, true ) ) {
			throw new Exception( jnews_return_translation( 'Post type not allowed!', 'jnews-video', 'post_type_not_allowed' ) );
		}

		global $wpdb;
		$affected_rows = $wpdb->insert(
			self::get_table_name(),
			array(
				'playlist_id' => $playlist->ID,
				'post_id'     => $post_id,
				'date'        => $this->now(),
				'date_gmt'    => $this->nowgmt(),
			),
			array(
				'%d',
				'%d',
				'%s',
				'%s',
			)
		);

		if ( false === $affected_rows ) {
			throw new Exception( jnews_return_translation( 'Could not insert into the playlist!', 'jnews-video', 'failed_insert_into_playlist' ) );
		}

		do_action( 'jnews_post_added_to_playlist', $post_id, $playlist->ID );

		return true;
	}

	/**
	 * Process remove post
	 *
	 * @param $post_id
	 * @param $playlist_id
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function remove_post( $post_id, $playlist_id ) {
		if ( empty( $playlist_id ) ) {
			throw new Exception( jnews_return_translation( 'Playlist ID not set!', 'jnews-video', 'playlist_id_not_set' ) );
		}
		if ( empty( $post_id ) ) {
			throw new Exception( jnews_return_translation( 'Post ID not set!', 'jnews-video', 'post_id_not_set' ) );
		}
		$user_id = get_current_user_id();

		if ( is_numeric( $playlist_id ) ) {
			$playlist = $this->get_playlist_by_id( $playlist_id );
		} else {
			$playlist    = $this->get_playlist_by_user( $user_id, $playlist_id );
			$playlist_id = $playlist->ID;
		}

		$playlist_type = get_post_meta( $playlist->ID, '_playlist_type', true );

		if ( ! $playlist ) {
			throw new Exception( sprintf( jnews_return_translation( 'Playlist with id %s not found!', 'jnews-video', 'playlist_id_not_found' ), $playlist_id ) );
		}

		if ( $user_id !== (int) $playlist->post_author ) {
			throw new Exception( sprintf( jnews_return_translation( 'User %s is not the owner!', 'jnews-video', 'user_is_not_the_owner' ), $user_id ) );
		}

		global $wpdb;
		do_action( 'jnews_before_post_removed_from_playlist', $post_id, $playlist_id );

		$affected_rows = $wpdb->delete(
			self::get_table_name(),
			array(
				'playlist_id' => $playlist_id,
				'post_id'     => $post_id,
			),
			array(
				'%d',
				'%d',
			)
		);

		if ( false === $affected_rows ) {
			throw new Exception( jnews_return_translation( 'Could not delete playlist post!', 'jnews-video', 'failed_delete_playlist_post' ) );
		}

		if ( $this->is_video_watchlater( $playlist_type ) || $this->is_video_favorite( $playlist_type ) ) {
			$getLatestPost = $this->get_posts( $playlist_id, 1 );
		}

		do_action( 'jnews_post_removed_from_playlist', $post_id, $playlist_id );

		return true;
	}

	/**
	 * Process edit playlist
	 *
	 * @return Exception
	 */
	protected function edit_playlist() {
		$user_id  = get_current_user_id();
		$post_id  = $_POST['playlist_id'];
		$playlist = get_post( $post_id );

		try {

			if ( empty( $_POST['title'] ) ) {
				throw new Exception( jnews_return_translation( 'Playlist name cannot be empty', 'jnews-video', 'playlist_name_cannot_be_empty' ) );
			}

			if ( ! $playlist ) {
				return new Exception( sprintf( jnews_return_translation( 'Playlist with id %s not found!', 'jnews-video', 'playlist_id_not_found' ), $post_id ) );
			}

			if ( $user_id !== (int) $playlist->post_author ) {
				return new Exception( sprintf( jnews_return_translation( 'User %s is not the owner!', 'jnews-video', 'user_is_not_the_owner' ), $user_id ) );
			}

			$args = array(
				'ID'         => $post_id,
				'title'      => $_POST['title'],
				'post_type'  => self::$slug,
				'status'     => 'private',
				'content'    => isset( $_POST['content'] ) ? $_POST['content'] : '',
				'visibility' => ( isset( $_POST['visibility'] ) && ! empty( $_POST['visibility'] ) ) ? $_POST['visibility'] : 'private',
				'image'      => isset( $_POST['image'] ) ? $_POST['image'] : '',
			);
			$args = $this->validation_visibility( $args );
			$args = apply_filters( 'jnews_video_edit_playlist', $args );

			$post_id = wp_update_post(
				array(
					'ID'           => $args['ID'],
					'post_title'   => sanitize_text_field( $args['title'] ),
					'post_type'    => $args['post_type'],
					'post_status'  => $args['status'],
					'post_content' => sanitize_textarea_field( $args['content'] ),
				)
			);

			if ( is_wp_error( $post_id ) ) {
				throw new Exception( $post_id->get_error_message() );
			} else {
				update_post_meta( $post_id, '_thumbnail_id', $args['image'] );
				update_post_meta( $post_id, '_playlist_visibility', $args['visibility'] );

				wp_send_json(
					array(
						'response' => 1,
						'playlist' => array( $post_id, sanitize_text_field( $_POST['title'] ) ),
						'message'  => jnews_return_translation( 'Playlist updated successfully', 'jnews-video', 'playlist_updated_successfully' ),
					)
				);
			}
		} catch ( Exception $e ) {
			wp_send_json(
				array(
					'response' => 0,
					'message'  => '<p class="alert alert-error">' . $e->getMessage() . '</p>',
				)
			);
		}
	}

	/**
	 * Process delete playlist
	 *
	 * @return Exception
	 */
	protected function delete_playlist() {
		$user_id  = get_current_user_id();
		$post_id  = $_POST['playlist_id'];
		$playlist = get_post( $post_id );

		try {

			if ( ! $playlist ) {
				return new Exception( sprintf( jnews_return_translation( 'Playlist with id %s not found!', 'jnews-video', 'playlist_id_not_found' ), $post_id ) );
			}

			if ( $user_id !== (int) $playlist->post_author ) {
				return new Exception( sprintf( jnews_return_translation( 'User %s is not the owner!', 'jnews-video', 'user_is_not_the_owner' ), $user_id ) );
			}

			$result = wp_delete_post( $post_id, true );

			if ( false === $result ) {
				throw new Exception( jnews_return_translation( 'Could not delete playlist post!', 'jnews-video', 'failed_delete_playlist_post' ) );
			} else {
				wp_send_json(
					array(
						'response' => 1,
						'playlist' => array( $post_id, sanitize_text_field( $_POST['title'] ) ),
						'message'  => jnews_return_translation( 'Playlist deleted', 'jnews-video', 'playlist_deleted' ),
						'redirect' => function_exists( 'bp_loggedin_user_domain' ) ? trailingslashit( bp_loggedin_user_domain() . 'playlist' ) : get_bloginfo( 'url' ),
					)
				);
			}
		} catch ( Exception $e ) {
			wp_send_json(
				array(
					'response' => 0,
					'message'  => '<p class="alert alert-error">' . $e->getMessage() . '</p>',
				)
			);
		}
	}

	/**
	 * Load more next
	 *
	 * @param $playlist_id
	 * @param $last
	 */
	public function load_more_next( $playlist_id, $last ) {
		$playlist_ids = $this->get_posts( $playlist_id );
		$first        = array_search( $last, $playlist_ids, true );
		$results      = array_slice( $playlist_ids, $first + 1, self::$perpage );

		$playlist_query = new WP_Query(
			array(
				'post__in'       => ! empty( $results ) ? $results : array( '-10' ),
				'orderby'        => 'post__in',
				'posts_per_page' => - 1,
				'post_type'      => 'any',
			)
		);

		set_query_var( 'playlist_id', absint( $playlist_id ) );

		ob_start();
		if ( $playlist_query->have_posts() ) {
			while ( $playlist_query->have_posts() ) {
				$playlist_query->the_post();
				jnews_video_get_template_part( '/fragment/playlist/playlist-content', 'item' );
			}
			wp_reset_postdata();
		}

		wp_send_json(
			array(
				'html' => ob_get_clean(),
				'next' => sizeof( $playlist_ids ) > $first + 1 + self::$perpage,
			)
		);
	}

	/**
	 * Playlist popup template
	 */
	public function render_popup_add_playlist() {
		jnews_video_get_template_part( '/fragment/playlist/playlist-popup' );
	}
}
