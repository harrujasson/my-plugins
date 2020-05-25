<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.maansawebworld.com/
 * @since      1.0.0
 *
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Mwpl_tours_managment
 * @subpackage Mwpl_tours_managment/includes
 * @author     Talwinder Singh <maansawebworldphp@gmail.com>
 */
class Mwpl_tours_managment_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
            remove_role( 'tour_executive' );
	}

}
