<?php

/**
 * Plugin Activation Class
 *
 * @since      1.0.0
 * @package    ckexample
 * @subpackage ckexample/classes
 * @author     Curtis Krauter <cortezcreations@gmail.com>
 */

if ( class_exists('ckexample_core_class') ) {

    final class ckexample_activation_class {

        private function __construct() {
        }

        static function activate() {
            self::create_db_tables();
            ckexample_cron_class::set_schedule();
        }

        static function deactivate() {
            ckexample_cron_class::unschedule();
		}

        static function uninstall() {
            ckexample_cron_class::unschedule();
            self::drop_db_tables();
            delete_option(CKEXAMPLE_SETTINGS); // ckexample-settings
        }

        private static function create_db_tables() {

            global $wpdb;
            require_once ABSPATH . 'wp-admin/includes/upgrade.php';
            $table = CKEXAMPLE_DB_EXAMPLE;

            // License
            $sql = "CREATE TABLE {$table} ( \n" .
                "id bigint(20) unsigned NOT NULL auto_increment, \n" .
                "order_id bigint(20) unsigned NOT NULL default '0', \n" .
                "product_id bigint(20) unsigned NOT NULL default '0', \n" .
                "status tinyint(4) DEFAULT 1 COMMENT '1-active,2-expired,3-purchased', \n" .
                "email varchar(100) NOT NULL, \n" .
                "license_key varchar(200) NOT NULL, \n" .
                "name text NOT NULL, \n" .
                "software_id varchar(200), \n" .
                "activation_limit varchar(9) NOT NULL, \n" .
                "created datetime NOT NULL DEFAULT '0000-00-00 00:00:00', \n" .
                "modified datetime NOT NULL DEFAULT '0000-00-00 00:00:00', \n" .
                "expires datetime NOT NULL DEFAULT '0000-00-00 00:00:00', \n" .
                "KEY order_id (order_id), \n" .
                "KEY product_id (product_id), \n" .
                "KEY status (status), \n" .
                "KEY email (email), \n" .
                "KEY license_key (license_key), \n" .
                "KEY software_id (software_id), \n" .
                "PRIMARY KEY  (id) \n" .
            ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
            dbDelta( $sql );

        }

        private static function drop_db_tables() {
            global $wpdb;
            $table = CKEXAMPLE_DB_EXAMPLE;
            $wpdb->query("DROP TABLE IF EXISTS `{$table}`;");
        }

        // End Class
    }
}