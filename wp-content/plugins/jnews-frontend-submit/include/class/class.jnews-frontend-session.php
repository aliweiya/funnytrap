<?php
/**
 * @author Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}

Class JNews_Frontend_Session 
{
    private static $instance;

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
        if ( ! session_id() )
        {
            session_start();
        }
        
        add_filter( 'jnews_get_message', array( $this, 'get_flash_message' ) );
    }

    public static function flash_message( $name = '', $message = '', $class = 'success' )
    {
        if ( ! empty( $name ) )
        {
            // No message, create it
            if ( ! empty( $message ) && empty( $_SESSION[$name] ) )
            {
                if ( !empty( $_SESSION[$name] ) )
                {
                    unset( $_SESSION[$name] );
                }

                if ( !empty( $_SESSION[$name.'_class'] ) )
                {
                    unset( $_SESSION[$name.'_class'] );
                }

                $_SESSION[$name] = $message;
                $_SESSION[$name.'_class'] = $class;
            }

            // Message exists, display it
            else if ( ! empty( $_SESSION[$name] ) && empty( $message ) )
            {
                $class      = ! empty( $_SESSION[$name.'_class'] ) ? $_SESSION[$name.'_class'] : 'success';
                $flash_msg  = $_SESSION[$name];
                $flash_html = '<div class="' . $class . ' alert alert-dismissible fade in" role="alert">' . $flash_msg . '</div>';

                unset($_SESSION[$name]);
                unset($_SESSION[$name.'_class']);

                return apply_filters( 'jnews_flash_message', $flash_html, $name, $class );
            }
        }
    }

    public function get_flash_message()
    {
        return self::flash_message('message');
    }
}