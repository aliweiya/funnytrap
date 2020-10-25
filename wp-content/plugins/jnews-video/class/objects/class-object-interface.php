<?php

namespace JNEWS_VIDEO\Objects;

/**
 * Interface Object_Interface
 *
 * @package JNEWS_VIDEO\Objects
 */
interface Object_Interface {
	/**
	 * Get the table name
	 */
	public static function get_table_name();

	/**
	 * Flush rewrite rule when plugin activation
	 *
	 * @return mixed
	 */
	public static function plugin_activation();

	/**
	 * Create Required Table
	 *
	 * @return mixed
	 */
	public static function create_table();
}
