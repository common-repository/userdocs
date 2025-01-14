<?php

/**
 * Fired during plugin activation
 *
 * @link       https://endif.media
 * @since      1.0.0
 *
 * @package    Userdocs
 * @subpackage Userdocs/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Userdocs
 * @subpackage Userdocs/includes
 * @author     Ethan Allen <yourfriendethan@gmail.com>
 */
class Userdocs_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		//flush rewrites
		flush_rewrite_rules();

	}

}
