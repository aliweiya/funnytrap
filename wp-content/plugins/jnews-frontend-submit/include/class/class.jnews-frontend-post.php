<?php
/**
 * @author Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}

class JNews_Frontend_Post
{   
    private $post_id;

    public function __construct( $post_id = null )
    {
        $this->post_id = $post_id;
    }

    public function post_data()
    {
        if ( ! empty( $this->post_id ) ) 
        {
            $post = get_post( $this->post_id );

            $categories = get_the_terms( $post->ID, 'category' );
            $category   = array();

            if ( ! empty( $categories ) && is_array( $categories ) ) 
            {
                foreach ( $categories as $term ) 
                {
                    $category[] = $term->term_id;
                }
            }

            $tags = get_the_terms( $post->ID, 'post_tag' );
            $tag  = array();

            if ( ! empty( $tags ) && is_array( $tags ) ) 
            {
                foreach ( $tags as $term ) 
                {
                    $tag[] = $term->term_id;
                }
            }

            $primary_category = get_post_meta( $post->ID, 'jnews_primary_category', true );
            $post_fromat      = get_post_format( $post->ID );
            $post_video       = get_post_meta( $post->ID, '_format_video_embed', true );
            $post_gallery     = get_post_meta( $post->ID, '_format_gallery_images', true );

            $data = array(
                'id'                => $post->ID,
                'title'             => $post->post_title,
                'subtitle'          => get_post_meta( $this->post_id, 'post_subtitle', true ),
                'content'           => $post->post_content,
                'primary-category'  => isset( $primary_category['id'] ) ? $primary_category['id'] : '',
                'category'          => implode( ',', $category ),
                'tag'               => implode( ',', $tag ),
                'format'            => $post_fromat ? $post_fromat : 'image',
                'video'             => $post_video,
                'gallery'           => $post_gallery,
                'image'             => get_post_thumbnail_id( $post ),
            );

            return $data;
        }
    }
}