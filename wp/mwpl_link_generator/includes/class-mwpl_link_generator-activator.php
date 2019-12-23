<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.maansawebworld.com
 * @since      1.0.0
 *
 * @package    Mwpl_link_generator
 * @subpackage Mwpl_link_generator/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Mwpl_link_generator
 * @subpackage Mwpl_link_generator/includes
 * @author     Maansa Webworld Pvt Ltd. <info@maansawebworld.com>
 */
class Mwpl_link_generator_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {            
            
            global $wpdb;
            global $database_db_version;
            $table_name = $wpdb->prefix . "mwpl_link_generation";                    
            $sql ="CREATE TABLE IF NOT EXISTS $table_name ( id int(11) NOT NULL AUTO_INCREMENT,`content` longtext,`page_id` int(11) NOT NULL, PRIMARY KEY (id)) ";

            $table_name_heading = $wpdb->prefix . "mwpl_link_generation_heading";
            $sql_heading ="CREATE TABLE IF NOT EXISTS $table_name_heading ( id int(11) NOT NULL AUTO_INCREMENT,`content` longtext, PRIMARY KEY (id)) ";            
            
            
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            $wpdb->query($sql);
            $wpdb->query($sql_heading);
            
            add_option("database_db_version", $database_db_version);
            flush_rewrite_rules();
            
	}

}
