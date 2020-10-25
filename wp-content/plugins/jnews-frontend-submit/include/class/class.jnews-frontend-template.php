<?php
/**
 * @author Jegtheme
 */

if ( ! defined( 'ABSPATH' ) )
{
    exit;
}

use JNews\Util\Cache;

class JNews_Frontend_Template
{
    private static $instance;

    private $account;

    private $endpoint;

    private $post_id;

    private $page_title;

    public static function getInstance()
    {
        if ( null === static::$instance )
        {
            static::$instance = new static();
        }
        return static::$instance;
    }

    private function __construct()
    {
        if(class_exists('\JNews\AccountPage'))
        {
            $this->account  = \JNews\AccountPage::getInstance();
            $this->endpoint = JNews_Frontend_Endpoint::getInstance()->get_endpoint();
            $this->setup_hook();
        }
    }

    protected function setup_hook()
    {
        add_action( 'template_include',                         array( $this, 'add_page_template' ) );
        add_action( 'delete_attachment',                        array( $this, 'disable_delete_attachment' ) );
        add_action( 'jnews_account_right_content',              array( $this, 'get_right_content' ) );
	    //add_action( 'admin_init',                               array( $this, 'disable_admin_dashboard' ) );

        add_filter( 'ajax_query_attachments_args',              array( $this, 'filter_user_media' ) );
        add_filter( 'media_view_strings',                       array( $this, 'remove_media_tab' ) );
        add_filter( 'upload_size_limit',                        array( $this, 'upload_size_limit' ) );
        add_filter( 'jnews_maxsize_upload_featured_gallery',    array( $this, 'maxupload_size' ) );
        add_filter( 'jnews_maxsize_upload_featured_image',      array( $this, 'maxupload_size' ) );
        add_filter( 'mce_css',                                  array( $this, 'load_mce_css' ) );
    }

	/**
	 * Load dark mode css tinyMCE
	 *
	 * @param string $mce_css   Style for tinyMCE.
	 *
	 * @return string
	 */
	public function load_mce_css( $mce_css ) {
		if ( ! empty( $mce_css ) ) {
			$mce_css .= ',';
		}

		$mce_css .= JNEWS_FRONTEND_SUBMIT_URL . '/assets/css/dark-mce.css';

		return $mce_css;
	}

    public function maxupload_size()
    {
        return get_theme_mod( 'jnews_frontend_submit_maxupload', '1' ) . 'mb';
    }

    public function get_right_content()
    {
        global $wp;

        if ( is_user_logged_in() )
        {
            $endpoint     = $this->account->get_endpoint();
            $account_slug = $endpoint['account']['slug'];

            if ( isset( $wp->query_vars[$account_slug] ) && ! empty( $wp->query_vars[$account_slug] ) )
            {
                $query_vars = explode('/', $wp->query_vars[$account_slug]);

                wp_enqueue_script( 'jnews-frontend-submit', JNEWS_FRONTEND_SUBMIT_URL . '/assets/js/plugin.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), JNEWS_FRONTEND_SUBMIT_VERSION, true );

                if ( $query_vars[0] == $endpoint['my_post']['slug'] )
                {
                    $paged = 1;

                    if ( isset( $query_vars[2] ) )
                    {
                        $paged = (int) $query_vars[2];
                    }

                    $template = JNEWS_FRONTEND_SUBMIT_DIR . 'include/template/list-post.php';

                    if ( file_exists( $template ) )
                    {
                        include $template;
                    }
                }
            }
        }
    }

    public function load_assets()
    {
        $asset_url = apply_filters('jnews_get_asset_uri', get_parent_theme_file_uri('assets/'));

        wp_enqueue_style( 'jnews-frontend-submit',  JNEWS_FRONTEND_SUBMIT_URL . '/assets/css/plugin.css', null, JNEWS_FRONTEND_SUBMIT_VERSION );
        wp_enqueue_style( 'selectize',              $asset_url . 'css/admin/selectize.default.css', null );

        wp_enqueue_script( 'selectize',             $asset_url . 'js/vendor/selectize.js', array( 'jquery' ), false, true );
        wp_enqueue_script( 'jnews-frontend-submit', JNEWS_FRONTEND_SUBMIT_URL . '/assets/js/plugin.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), JNEWS_FRONTEND_SUBMIT_VERSION, true );
    }

    protected function get_theme_version()
    {
        $theme = wp_get_theme();
        return $theme->get('Version');
    }

    public function is_user_can_edit_post( $post_id = null )
    {
        $value      = false;
        $user_id    = get_current_user_id();

        if ( ! empty( $post_id ) )
        {
            $this->set_post_id( $post_id );

            $author_id = get_post_field( 'post_author', $post_id );

            if ( $author_id == $user_id )
            {
                $value = true;
            }
        }

        return apply_filters( 'jnews_frontend_user_can_edit_post', $value );
    }

    public function add_page_template( $template )
    {
        global $wp;
        $file = '';

        if ( is_user_logged_in() )
        {
            $editor = $this->endpoint['editor']['slug'];

            if ( isset( $wp->query_vars[$editor] ) )
            {
                add_action( 'wp_print_styles',      array( $this, 'load_assets' ) );
                add_filter( 'document_title_parts', array( $this, 'account_title') );

                if ( current_user_can( 'upload_files' ) ) {
                    add_action( 'wp_enqueue_scripts', function(){
                        wp_enqueue_media();
                    } );
                }

                if ( ! empty( $wp->query_vars['editor'] ) )
                {
                    if ( $this->is_user_can_edit_post( $wp->query_vars['editor'] ) )
                    {
                        $file = JNEWS_FRONTEND_SUBMIT_DIR . 'include/template/edit-post.php';
                    }
                    $this->page_title = esc_html__( 'Edit Post', 'jnews-frontend-submit' );
                } else {
                    if ( $this->is_user_allow_access() )
                    {
                        $file = JNEWS_FRONTEND_SUBMIT_DIR . 'include/template/create-post.php';
                        $this->page_title = esc_html__( 'Create New Post', 'jnews-frontend-submit' );
                    }
                }

                if ( ! empty( $file ) && file_exists( $file ) )
                {
                    $template = $file;
                }
            }
        }

        return apply_filters('jnews_frontend_submit_add_page_template', $template );
    }

    public function disable_delete_attachment()
    {
        if ( ! current_user_can('manage_options') )
        {
            exit();
        }
    }

    public function filter_user_media( $query )
    {
        if ( ! current_user_can( 'manage_options' ) )
        {
            $query['author'] = get_current_user_id();
        }

        return $query;
    }

    public function remove_media_tab( $strings )
    {
        if ( ! current_user_can( 'manage_options' ) )
        {
            $strings["setFeaturedImageTitle"]       = "";
            $strings["insertFromUrlTitle"]          = "";
            $strings['createPlaylistTitle']         = "";
            $strings['createVideoPlaylistTitle']    = "";
            $strings['deletePermanently']           = "";
            $strings['deleteSelected']              = "";
        }

        return $strings;
    }

    public function upload_size_limit( $size )
    {
        if ( ! current_user_can( 'manage_options' ) )
        {
            $size = apply_filters( 'jnews_frontend_max_upload_size', ( 2 * 1000 * 1024 ) );
        }

        return $size;
    }

    public function disable_admin_dashboard()
    {
        if ( ! current_user_can('manage_options') && ! ( defined('DOING_AJAX') && DOING_AJAX ) )
        {
            wp_redirect( home_url() );
            exit;
        }
    }

    protected function set_post_id( $post_id )
    {
        $this->post_id = $post_id;
    }

    public function get_post_id()
    {
        return $this->post_id;
    }

    public function account_title( $title )
    {
        global $wp;
        $split      = $title;
        $additional = '';

        if ( isset( $this->page_title ) )
        {
            $additional = $this->page_title;
        }

        $additional = apply_filters( 'jnews_account_title', $additional, $wp, $this->endpoint );

        global $wp_query;
        $split['title'] = isset( $wp_query->queried_object->post_title );

        if ( ! empty( $additional ) )
        {
            $title['title'] = $additional . ' ' . $split['title'] ;
        }

        return $title;
    }

    protected function is_user_allow_access( $user_id = null )
    {
        $value = true;

        if ( get_theme_mod('jnews_frontend_submit_enable_woocommerce', false) )
        {
            if ( empty( $user_id ) )
            {
                $user_id = get_current_user_id();
            }

            $post_limit = get_user_meta($user_id, 'listing_left', true);

            if ( (int) $post_limit <= 0 )
            {
                $value = false;
            }
        }

        return apply_filters( 'jnews_frontend_submit_user_subscription', $value );
    }

	public function get_category()
	{
		$result = array();
		$count  = Cache::get_categories_count();
		$limit  = apply_filters('jnews_load_resource_limit', 25);

		if ( (int) $count <= $limit )
		{
			$terms = Cache::get_categories();
			foreach($terms as $term)
			{
				$result[$term->term_id] = $term->name;
			}
		}

		return $result;
	}

	public function get_tag()
	{
		$result = array();
		$count  = Cache::get_tags_count();
		$limit  = apply_filters('jnews_load_resource_limit', 25);

		if ( (int) $count <= $limit )
		{
			$terms = Cache::get_tags();
			foreach($terms as $term)
			{
				$result[$term->term_id] = $term->name;
			}
		}

		return $result;
	}
}
