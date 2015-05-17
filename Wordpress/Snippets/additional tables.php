<?php

global $jal_db_version;
$jal_db_version = "1.0";

function jal_install() {
   global $wpdb;
   global $jal_db_version;

   $table_name = $wpdb->prefix . "liveshoutbox";
      
   $sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  name tinytext NOT NULL,
		  text text NOT NULL,
		  url VARCHAR(55) DEFAULT '' NOT NULL,
		  UNIQUE KEY id (id)
    );";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
 
   add_option( "jal_db_version", $jal_db_version );
}

function jal_install_data() {
   global $wpdb;
   $welcome_name = "Mr. WordPress";
   $welcome_text = "Congratulations, you just completed the installation!";
   $table_name = $wpdb->prefix . "liveshoutbox";
   $rows_affected = $wpdb->insert( $table_name, array( 'time' => current_time('mysql'), 'name' => $welcome_name, 'text' => $welcome_text ) );
}

register_activation_hook( __FILE__, 'jal_install' );
register_activation_hook( __FILE__, 'jal_install_data' );


?>