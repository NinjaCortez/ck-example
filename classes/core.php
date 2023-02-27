<?php
if ( ! defined('ABSPATH') || ! defined('CKEXAMPLE_HOME') ) {
	header('HTTP/1.0 403 Forbidden');
	die();
}

/**
 * Core Plugin Class
 *
 * @since      1.0.0
 * @package    ckexample
 * @subpackage ckexample/classes
 * @author     Curtis Krauter <cortezcreations@gmail.com>
 */
class ckexample_core_class {

    /** 
     * Plugin Loaded Initialization
     * 
     * @var string $plugin - The plugin namespace ID
     */
    function plugin_loaded( $plugin ) {

        if ( stripos($plugin, "/{$this->ns}.php") === false ) {
            return;
        }

        // Set Plugin Constants
        $this->set_constants();
        // Initialize Plugin Option Settings
        $this->init_settings();
        // Initialize class autoloader
        $this->init_autoloader();
        // Activate, Deactivate & Uninstall
		$this->register_activation_hooks();
        // Schedule CRON Jobs
        ckexample_cron_class::set_schedule();
        // Register WP Hooks
        add_action('plugins_loaded', [$this, 'register_wp_hooks']);
    }

    /**
     * Define Constants
     */
    private function set_constants() {
        global $wpdb;
        $keys = [
            // Misc
            'CKEXAMPLE_NAME'     => $this->ns,
            // Options
            'CKEXAMPLE_SETTINGS' => "{$this->ns}_settings",
            'CKEXAMPLE_DEBUG'    => false,
            'CKEXAMPLE_DEBUGLOG' => ABSPATH . '/debuglog.txt',
            // Directories
            'CKEXAMPLE_CLASS_DIR'  => CKEXAMPLE_HOME_DIR . '/classes/',
            'CKEXAMPLE_SCREEN_DIR' => CKEXAMPLE_HOME_DIR . '/screens/',
            // Table Names
            'CKEXAMPLE_DB_EXAMPLE' => "{$wpdb->prefix}{$this->ns}",
            // URLs
            'CKEXAMPLE_PLUGIN_URL' => trailingslashit( plugins_url('', CKEXAMPLE_HOME) ),
        ];

        foreach ($keys as $k => $v) {
            defined($k) ? '' : define($k, $v);
        }
    }

    /**
     * Register Activation Hooks
     */
    private function register_activation_hooks() {
        $class = "{$this->ns}_activation_class";
        register_activation_hook( CKEXAMPLE_HOME, [$class, 'activate'] );
        register_uninstall_hook( CKEXAMPLE_HOME, [$class, 'uninstall'] );
        register_deactivation_hook( CKEXAMPLE_HOME, [$class, 'deactivate'] );
	}

    /**
     * Register WordPress Hooks
     */
    function register_wp_hooks() {

        // Dependency Checks
        if ( ! $this->dependency_check() ) {
            return;
        }

        // Register REST Properties
        add_action( 'rest_api_init', [$this, 'register_rest_properties'] );
        // Add CRON Action Hook
        add_action( ckexample_cron_class::CRON_KEY, ['ckexample_cron_class', 'maintenance'] );


        if ( is_admin() ) {
            $this->admin()->register_wp_hooks();
        }
        else {
            $this->frontend()->register_wp_hooks();
        }

    }

    /**
     * Dependency Checks - Pro Versions || Plugin Compatability || etc 
     */
	function dependency_check() : bool {
		/*
		// WooCommerce
        if ( ! class_exists('WC_Integration') ) {
            $message = __( 'CK Example plugin requires the WooCommerce plugin to be installed and active.', $ns );
            new ckexample_admin_notice( 'error', __('CK Example Error', $ns), $message );
            return false;
        }
		*/
		return true;
	}

    /**
     * Register REST Properties
     */
    function register_rest_properties() {
        
        $this->register_rest_settings();
        $services = new ckexample_webhook_services();
        $services->register_routes();

    }

    /**
     * Register REST Settings
     */
    function register_rest_settings() {
        $key = CKEXAMPLE_SETTINGS;
        register_setting( "{$key}_group", $key, [
            'type'         => 'object',
            'default'      => $this->get_settings_config(true),
            'show_in_rest' => [
                'schema' => [
                    'type'       => 'object',
                    'properties' => $this->get_settings_config(),
                ],
            ]
        ] );
    }


    /**
     * Get Plugin Settings Configuration
     * 
     * @param bool $defaults - Return default values only
     * @return array - Settings Configuration 
    */
    function get_settings_config( bool $defaults = false ) {
        static $d = null;
        if ( $defaults ) {
            if ( is_null($d) ) {
                $d = wp_list_pluck($this->settings_config, 'default');
            }
            return $d;
        }
        else{
            return $this->settings_config;
        }
    }

    /**
     * Initialize Plugin Settings
     * 
     * @return array - Plugin Settings
     */
    private function init_settings() {
        $key            = CKEXAMPLE_SETTINGS;
        $this->settings = get_option( $key, [] );
        $this->settings = is_array($this->settings) ? $this->settings : [];
        $dirty          = empty($this->settings);
        $this->settings = wp_parse_args($this->settings, $this->get_settings_config(true));
        // Set default values 
        if( empty($this->settings['http_post_key']) ){
            $this->settings['http_post_key'] = bin2hex(random_bytes(12));
            $dirty = true;
        }
        // Save updated settings
        if ($dirty) {
            $this->save_settings();
        }
        // Add Settings Validation Filter
        add_filter( "pre_update_option_{$key}", [ $this, 'validate_setting_updates' ], 10, 2 );

        return $this->settings;
    }

    /**
     * Validate Settings Updates
     * 
     * @param mixed $value - New value
     * @param mixed $old_value - Old value
     * @return mixed - Validated value
     */
    function validate_setting_updates( $value, $old_value ) {

        if ( $value === $old_value ) {
            return $value;
        }

        $updated = array_diff( $value, $old_value );
        foreach ( $updated as $k => $v ) {
            $value[$k] = apply_filters( "{$this->ns}_validate_setting_{$k}", $v, $old_value[$k], $value );
        }
    
        return $value;
    }

    /**
     * Save Settings
     */
    function save_settings() {
        if ( is_array($this->settings) && ! empty($this->settings) ) {
            $success = update_option(CKEXAMPLE_SETTINGS, $this->settings, true);
        }
	}

    /**
     * Get Settings
     * 
     * @param string $key - Key to retrieve
     * @param string $default - Default value if key not found
     * @return mixed - All settings if no key is provided || Value of key or default
     */
    function get_settings( string $key = '', string $default = '' ) {
        $value = $default;
        if ( empty($key) ) {
            $value = $this->settings;
        }
        else {
            $value = isset($this->settings[$key]) ? $this->settings[$key] : $default;
        }
        return $value;
    }

    /**
     * Set Settings
     * 
     * @param mixed $value - Value to set or null
     * @param string $key - Key to set
     * @return bool - Success
     */
    function set_settings( $value = null, $key = null ) {
        // No key bail
        if (empty($key) ) {
            return false;
        }
        $dirty = false;
        // Set Key Value
        if ($key) {
            $this->settings[$key] = $value;
            $dirty = true;
        }
        // Set Options Value
        else {
            $this->settings = $value;
            $dirty = true;
        }
        // Save updated options
        if ($dirty) {
            $this->save_settings();
        }
    }

    /**
     * Initialize Autoloader for Classes
     * 
     */
    private function init_autoloader() {
        $class_dir     = CKEXAMPLE_CLASS_DIR;
		$screen_dir    = CKEXAMPLE_SCREEN_DIR;
        $this->classes = [
            "{$this->ns}_activation_class"   => "{$class_dir}activation",
            "{$this->ns}_admin_class"        => "{$class_dir}admin",
            "{$this->ns}_admin_notice"       => "{$class_dir}admin_notice",
            "{$this->ns}_api_log_list_table" => "{$class_dir}api_log_list_table",
            "{$this->ns}_cron_class"         => "{$class_dir}cron",
            "{$this->ns}_frontend_class"     => "{$class_dir}frontend",
            "{$this->ns}_rest_class"         => "{$class_dir}rest",
            "{$this->ns}_webhook_services"   => "{$class_dir}webhook_services",
			// Admin Screens
            "{$this->ns}_admin_screen_base"  => "{$screen_dir}base",
            "{$this->ns}_screen"             => "{$screen_dir}{$this->ns}",
            "{$this->ns}_api_log_screen"     => "{$screen_dir}api_log"
        ];

        spl_autoload_register( [$this, 'autoloader'] );
    }

    /**
     * Autoload Classes
     * 
     * @param string $class - Class Name
     */
    function autoloader( string $class ) {
        $class = strtolower( trim($class) );

        if ( array_key_exists($class, $this->classes) ) {
            if ( file_exists("{$this->classes[$class]}.php") ) {
                include_once "{$this->classes[$class]}.php";
            }
        }
    }

    /**
     * Simple Logger for Debugging
     * 
     * @param string $class - Class Name
     * @param string $function - Function Name
     * @param mixed $data - Data to log
     * @return mixed - null if Debug Log is set || 
     */
    function logger( string $class, string $function, $data ) {
        if( defined('CKEXAMPLE_DEBUG') && CKEXAMPLE_DEBUG ){
            $trace  = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
			$file   = $trace[0]['file'];
			$line   = $trace[0]['line'];
            $log    = "\n\nFile = {$file}\n";
            $log   .= "Class = {$class}\n";
            $log   .= "Function = {$function}\n";
            $log   .= "Line = {$line}\n";
            $log   .= "Time = " . date('Y-m-d j:i:s') . "\n";
            if( is_array($data) || is_object($data) ){
                $log .= "Data = " . print_r($data, true) . "\n";
            }
            else if( is_string($data) ){
                $log .= $data;
            }
            if (CKEXAMPLE_DEBUGLOG == 'error_log:') {
                error_log($log);
            }
            elseif (CKEXAMPLE_DEBUGLOG > '') {
                file_put_contents(CKEXAMPLE_DEBUGLOG, $log, FILE_APPEND);
            }
            else {
                echo nl2br($log);
            }
        }
    }

    /**
     * Singleton Instance of Frontend Class
     *
     * @return ckexample_frontend_class
     */
    function frontend() : ckexample_frontend_class {
        return ckexample_frontend_class::get_instance();
    }
    
    /**
     * Singleton Instance of Admin Class
     *
     * @return ckexample_admin_class
     */
    function admin() : ckexample_admin_class {
        return ckexample_admin_class::get_instance();
    }

    /**
     * Get the Plugin Namespace
     *
     * @return string - Namespace
     */
	function ns() : string {
		return $this->ns;
	}

    /**
     * Get the Name of the Plugin
     *
     * @return string - Name
     */
	function name() : string {
		return $this->name;
	}

	/**
     * Singleton Instance of Class
     *
     * @return string - Namespace
     */
    static function get_instance() : self {
        static $instance = false;
        return $instance ? $instance : $instance = new self;
    }

    /**
     * Private Constructor
     */
    private function __construct() {
        add_action('plugin_loaded', [$this, 'plugin_loaded']);
    }

    /**
     * @var array $settings_config
     */
    private $settings_config = [ 
        'api_key'       => [ 'type' => 'string',  'default' => '' ],
        'api_url'       => [ 'type' => 'string',  'default' => '' ],
        'api_verified'  => [ 'type' => 'boolean', 'default' => false ],
        'api_log'       => [ 'type' => 'boolean', 'default' => false ],
        'wpadmin_role'  => [ 'type' => 'string',  'default' => 'manage_options' ],
        'http_post_key' => [ 'type' => 'string',  'default' => '' ],
        'primary_color' => [ 'type' => 'string',  'default' => '' ],
        'accent_color'  => [ 'type' => 'string',  'default' => '' ],
        'tagline'       => [ 'type' => 'string',  'default' => '' ],
        'support_url'   => [ 'type' => 'string',  'default' => 'https://cortezcreations.org/' ]
    ];

    /**
     * @var array $settings Key Value array of the plugin settings
     */
    private $settings = [];

    /**
     * @var array $classes  The classes to autoload
     */
    private $classes = [];

    /**
     * @var string $ns  The namespace of the plugin
     */
    private $ns = 'ckexample';

    /**
     * @var string $name  The name of the plugin
     */
    private $name = 'CK Example';

// End of class
}