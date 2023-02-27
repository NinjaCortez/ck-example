<?php
/**
 * Plugin CRON Class
 *
 * @since      1.0.0
 * @package    ckexample
 * @subpackage ckexample/classes
 * @author     Curtis Krauter <cortezcreations@gmail.com>
 */

if (class_exists('ckexample_core_class') ) {

    final class ckexample_cron_class {

        private function __construct() {
        }

        /**
         * Set Schedule - Ensures CRON Job is scheduled
         * 
         * @return void
         */
        static function set_schedule() {
            if ( ! wp_next_scheduled( self::CRON_KEY ) ) {
                self::clear_schedule();
                $date      = new DateTime( 'tomorrow', new DateTimeZone( wp_timezone_string() ) );
                $timestamp = $date->getTimestamp();
                wp_schedule_event($timestamp, 'daily', self::CRON_KEY);
                update_option( self::CRON_TIME, $timestamp );
            }
        }

        /**
         * Clear Schedule - Clears CRON Job and timestamp option 
         * 
         * @return void
         */
        static function clear_schedule() {
            wp_clear_scheduled_hook( self::CRON_KEY );
            delete_option( self::CRON_TIME );
        }

        /**
         * Unschedule - Removes CRON Job and timestamp option 
         * 
         * @return void
         */
        static function unschedule() {
            $cron_time = get_option( self::CRON_TIME, 0 );
            if ( $cron_time > 0 ) {
                wp_unschedule_event( $cron_time, self::CRON_KEY, 0 );
            }
            delete_option( self::CRON_TIME );
        }

        /**
         * Maintenance - Triggered by CRON Job 
         * 
         * @return void
         */
        static function maintenance() {
            // Run specific maintenance tasks such as clearing database etc...
        }

        /**
         * @var string CRON_TIME  Option key for CRON timestamp
         */
        const CRON_TIME = 'ckexample/cron/time';
        
        /**
         * @var string CRON_KEY  CRON Job schedule key
         */
        const CRON_KEY  = 'ckexample/maintenance/midnight';

    // End of Class
    }

}