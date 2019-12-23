<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://webdesign-studenten.nl/
 * @since      1.0.0
 *
 * @package    Wds
 * @subpackage Wds/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wds
 * @subpackage Wds/includes
 * @author     Webdesign studenten <info@webdesign-studenten.nl>
 */
class Wds_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
            remove_role( 'ticket_manager' );
	}

}
