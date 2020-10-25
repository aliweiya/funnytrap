<?php
/**
 * @author Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}

class JNews_Frontend_Submit
{   
    private static $instance;

    private $endpoint;

    private $template;

    private $post_flag = 'jnews_frontend_submit_post_flag';

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
        $this->setup_hook();

        $this->endpoint = JNews_Frontend_Endpoint::getInstance()->get_endpoint();
        $this->template = JNews_Frontend_Template::getInstance();
    }

    protected function setup_hook()
    {
        add_action( 'wp_loaded', array( $this, 'submit_handler' ), 20 );
    }

    public function submit_handler()
    {
    	if ( defined('JNEWS_SANDBOX_URL') ) return false;

        if ( isset($_REQUEST['jnews-action']) && ! empty($_REQUEST['jnews-editor-nonce'])  && wp_verify_nonce($_REQUEST['jnews-editor-nonce'], 'jnews-editor') )
        {
            $action = $_REQUEST['jnews-action'];

            switch ( $action ) 
            {
                case "create-post":
                    $this->create_post_handler();
                    break;

                case "edit-post":
                    $this->edit_post_handler();
                    break;
            }
        }
    }

    protected function create_post_handler()
    {
        $user_id = get_current_user_id();

        try {

            if ( empty( $_POST['title'] ) ) 
            {
                throw new Exception( esc_html__( 'Post title cannot be empty', 'jnews-frontend-submit' ) );
            }

            $args = array(
                'post_title'            => sanitize_text_field($_POST['title']),
                'post_type'             => 'post',
                'post_status'           => 'pending',
                'post_author'           => $user_id,
                'post_content'          => $_POST['content']
            );
            $args = apply_filters( 'jnews_frontend_submit_create_post', $args );

            $post_id = wp_insert_post($args);

            if ( is_wp_error( $post_id ) ) 
            {
                throw new Exception( $post_id->get_error_message() );
            } else {

                if ( isset( $_POST['subtitle'] ) ) 
                {
                    update_post_meta( $post_id, 'post_subtitle', $_POST['subtitle'] );
                }

                if ( isset( $_POST['primary-category'] ) ) 
                {
                    update_post_meta( $post_id, 'jnews_primary_category', array( 'id' => $_POST['primary-category'] ) );
                }

                if ( isset( $_POST['category'] ) ) 
                {
                    wp_set_post_terms( $post_id, $_POST['category'], 'category' );
                }

                if ( isset( $_POST['tag'] ) ) 
                {
                    wp_set_post_tags( $post_id, array_map('intval', explode(',', $_POST['tag'])) );
                }

                if ( isset( $_POST['format'] ) ) 
                {
                    if ( $_POST['format'] == 'gallery' ) 
                    {
                        set_post_format( $post_id, 'gallery' );
                        update_post_meta( $post_id, '_format_gallery_images', isset($_POST['gallery']) ? array_unique( $_POST['gallery'] ) : '' );
                    } 
                    else if ( $_POST['format'] == 'video' ) 
                    {
                        set_post_format( $post_id, 'video' );
                        
                        if ( isset( $_POST['video'] ) ) 
                        {
                            update_post_meta( $post_id, '_format_video_embed', $_POST['video'] );
                        }
                    } else {
                        set_post_format( $post_id, false );
                        update_post_meta( $post_id, '_thumbnail_id', isset($_POST['image'][0]) ? $_POST['image'][0] : '' );
                    }
                }

                if ( get_theme_mod('jnews_frontend_submit_enable_woocommerce', false) ) 
                {
                    $this->reduce_listing_left( $post_id );   
                }

	            update_post_meta( $post_id, $this->post_flag, true );
                
                jnews_flash_message('message', esc_html(__( 'Your post has submitted for review', 'jnews-frontend-submit' )), 'alert-success' );

                wp_redirect( home_url( $this->endpoint['editor']['slug'] . '/' . $post_id ) );
                exit;
            }

        } catch( Exception $e ) {
            jnews_flash_message('message', $e->getMessage(), 'alert-danger');
        }
    }

    protected function edit_post_handler()
    {
//        $user_id  = get_current_user_id();
        $post_id  = $_POST['post-id'];
//        $post     = get_post($post_id);

        try {

            if ( empty( $_POST['title'] ) ) 
            {
                throw new Exception( esc_html__( 'Post title cannot be empty', 'jnews-frontend-submit' ) );
            }

            $args = array(
                'ID'            => $post_id,
                'post_title'    => sanitize_text_field($_POST['title']),
                'post_content'  => $_POST['content']
            );
            $args = apply_filters('jnews_frontend_submit_edit_post', $args);

            wp_update_post($args);

            if ( isset( $_POST['subtitle'] ) ) 
            {
                update_post_meta( $post_id, 'post_subtitle', $_POST['subtitle'] );
            }

            if ( isset( $_POST['primary-category'] ) ) 
            {
                update_post_meta( $post_id, 'jnews_primary_category', array( 'id' => $_POST['primary-category'] ) );
            }

            if ( isset( $_POST['category'] ) ) 
            {
                wp_set_post_terms( $post_id, $_POST['category'], 'category' );
            }

            if ( isset( $_POST['tag'] ) ) 
            {
                wp_set_post_tags( $post_id, array_map('intval', explode(',', $_POST['tag'])) );
            }

            if ( isset( $_POST['format'] ) ) 
            {
                if ( $_POST['format'] == 'gallery' ) 
                {
                    set_post_format( $post_id, 'gallery' );
                    update_post_meta( $post_id, '_format_gallery_images', isset($_POST['gallery']) ? array_unique( $_POST['gallery'] ) : '' );
                } 
                else if ( $_POST['format'] == 'video' ) 
                {
                    set_post_format( $post_id, 'video' );
                    
                    if ( isset( $_POST['video'] ) ) 
                    {
                        update_post_meta( $post_id, '_format_video_embed', $_POST['video'] );
                    }
                } else {
                    set_post_format( $post_id, false );
                    update_post_meta( $post_id, '_thumbnail_id', isset($_POST['image'][0]) ? $_POST['image'][0] : '' );
                }
            }

            jnews_flash_message('message', esc_html(__( 'Post updated successfully', 'jnews-frontend-submit' )), 'alert-success' );

            wp_redirect( home_url( $this->endpoint['editor']['slug'] . '/' . $post_id ) );
            exit;

        } catch( Exception $e ) {
            jnews_flash_message('message', $e->getMessage(), 'alert-danger');
        }
    }

    protected function reduce_listing_left( $post_id )
    {
        $flag = get_post_meta($post_id, 'finish_process', true);

        if ( ! $flag ) 
        {
            $post       = get_post($post_id);
            $user_id    = $post->post_author;
            $post_limit = get_user_meta($user_id, 'listing_left', true);

            if ( $post_limit > 0 ) 
            {
                update_user_meta($user_id, 'listing_left', (int) $post_limit - 1);
                update_post_meta($post_id, 'finish_process', true);
            }
        }
    }

    public function is_user_allow_access( $user_id = null )
    {
        $value = true;

        if ( get_theme_mod('jnews_frontend_submit_enable_woocommerce', false) ) 
        {
            if ( empty( $user_id ) ) 
            {
                $user_id = get_current_user_id();
            }

            $post_limit = get_user_meta($user_id, 'listing_left', true);

            if ( $post_limit <= 0 ) 
            {
                $value = false;
            }
        }

        return apply_filters( 'jnews_frontend_submit_user_subscription', $value );
    }
}