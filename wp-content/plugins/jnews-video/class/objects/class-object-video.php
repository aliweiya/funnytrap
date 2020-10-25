<?php

namespace JNEWS_VIDEO\Objects;

/**
 * Class Object
 *
 * @package JNEWS_VIDEO\Object
 */
abstract class Object_Video implements Object_Interface {

	/**
	 * Check if table already created
	 *
	 * @param string $table_name The name of table.
	 *
	 * @return mixed
	 */
	public static function is_table_installed( $table_name = '' ) {
		global $table_exists, $wpdb;
		if ( empty( $table_name ) ) {
			$table_name = static::get_table_name();
		}
		if ( ! isset( $table_exists[ $table_name ] ) ) {
			$show_table                  = "SHOW TABLES LIKE '{$table_name}'";
			$result                      = $wpdb->get_var( $show_table );
			$table_exists[ $table_name ] = ! empty( $result );
		}

		return $table_exists[ $table_name ];
	}

	/**
	 * Action after new site activation
	 *
	 * @param int $blog_id The ID of the blog.
	 */
	public function new_site_activation( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		// Run activation for the new blog.
		switch_to_blog( $blog_id );

		// Check required table.
		$this->plugin_activation();

		// Switch back to current blog.
		restore_current_blog();

	}

	/**
	 * Returns datetime gmt version
	 *
	 * @return string
	 */
	public function nowgmt() {
		return get_gmt_from_date( $this->now() );
	}

	/**
	 * Returns mysql datetime
	 *
	 * @return    string
	 */
	public function now() {
		return current_time( 'mysql' );
	}
}
