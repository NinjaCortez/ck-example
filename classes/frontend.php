<?php

/**
 * Plugin Frontend Class
 *
 * @since      1.0.0
 * @package    ckexample
 * @subpackage ckexample/classes
 * @author     Curtis Krauter <cortezcreations@gmail.com>
 */

if (class_exists('ckexample_core_class') ) {

    final class ckexample_frontend_class {

        function register_wp_hooks() {
            
        }

        static function get_instance() : self {
            static $instance = false;
            return $instance ? $instance : $instance = new self;
        }

    // End of Class
    }

}