<?php
/**
 * @author Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) 
{
    exit;
}

if ( class_exists('WC_Product') ) 
{
    class WC_Product_Post_Package extends WC_Product
    {
        public function __construct( $product )
        {  
            $this->product_type = 'post_package';
            parent::__construct( $product );
        }

        public function is_purchasable()
        {
            return true;
        }

        public function is_sold_individually()
        {
            return true;
        }

        public function is_virtual()
        {
            return true;
        }

        public function get_listing_limit()
        {
            $limit = get_post_meta( $this->id, '_jeg_post_limit', true );

            if ( empty( $limit ) || $limit == 0 ) 
            {
                return 99999999;
            } else {
                return $limit;
            }
        }

        public function is_featured_package()
        {
            return get_post_meta( $this->id, '_jeg_post_featured', true );
        }
    }
}