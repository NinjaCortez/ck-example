<?php
/*
Plugin Name: CK Example Plugin
Plugin URI: https://www.example-plugin.com
Description: Show example of plugin code.
Version: 1.0
Author: Curtis Krauter
Author URI: https://www.cortezcreations.org/
Text Domain: ckexample
Requires at least: 5.7.2
Requires PHP: 7.0
*/

if ( defined('ABSPATH') ) {
	if ( ! function_exists('ckexample_app') ) {
		define('CKEXAMPLE_HOME', __FILE__);
		define('CKEXAMPLE_HOME_DIR', __DIR__ . '/');
		define('CKEXAMPLE_VERSION', '1.0');
		
		// Local Development Log
		define('CKEXAMPLE_DEBUGLOG', 'error_log:');
		define('CKEXAMPLE_DEBUG', true);

		require_once CKEXAMPLE_HOME_DIR . 'classes/core.php';

		function ckexample_app() : ckexample_core_class {
            return ckexample_core_class::get_instance();
		}

		ckexample_app();
	}
}