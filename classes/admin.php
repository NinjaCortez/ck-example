<?php

/**
 * Plugin Admin Class
 *
 * @since      1.0.0
 * @package    ckexample
 * @subpackage ckexample/classes
 * @author     Curtis Krauter <cortezcreations@gmail.com>
 */

if ( class_exists('ckexample_core_class') ) {
    
    final class ckexample_admin_class {
        
        /**
         * Register WordPress Admin Hooks
         * 
         * @return void
         */
        function register_wp_hooks() {
            $ns = ckexample_app()->ns();
            add_action('admin_menu', [$this, 'register_admin_menu']);
            add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
            add_action('admin_init', [$this, 'admin_init']);
            add_filter("plugin_action_links_{$ns}/{$ns}.php", [$this, 'plugin_settting_link']);
        }

        /**
         * Plugin Page - Settings Link
         * 
         * @param array $links
         * @return array
         */
        function plugin_settting_link( $links ){
            $ns      = ckexample_app()->ns();
            $sprintf = '<a href="%s"> %s </a>';
            $url     = admin_url("admin.php?page={$ns}");
            $links['settings'] = sprintf($sprintf, $url, __('Settings', $ns) );
            return $links;
        }
        
        /**
         * Admin Initialization
         */
        function admin_init() {
            // Register Settings for REST in Gutenberg
            ckexample_app()->register_rest_settings();
        }
        
        /**
         * Get Admin Tabs Config - Used for Conditional Admin Menus
         * 
         * @return array
         */
        function get_admin_tabs() {
            $ns    = ckexample_app()->ns();
            $items = [
                $ns => [
                    'slug'    => $ns,
                    'label'   => ckexample_app()->name()
                ],
                'api_log' => [
                    'slug'    => 'api_log',
                    'label'   => __( 'API Log', $ns ),
                    'status'  => (bool) ckexample_app()->get_settings('api_log', false)
                ]
            ];
            
            return $items;
        }
        
        /**
         * Register Admin Menu
         * 
         * @return void
         */
        function register_admin_menu() {
            $ns          = ckexample_app()->ns();
            $permissions = 'manage_options';
            $prefix      = "{$ns}_";
            foreach ( $this->get_admin_tabs() as $k => $v ) {
                // Check Menu Status
                $active = (bool) isset($v['status']) ? $v['status'] : true;
                if ( ! $active ) {
                    continue;
                }
                // Main Menu
                if( $k === $ns ){
                    $screen_key = $k;
                    $this->admin_hooks[$k] = add_menu_page(
                        $v['label'],
                        $v['label'],
                        $permissions,
                        $v['slug'],
                        ["{$k}_screen", 'menu_init'],
                        'data:image/svg+xml;base64,' . $this->get_branding_svg(),
                        27
                    );
                }
                // Submenus
                else {
                    $screen_key = "{$prefix}{$k}";
                    $this->admin_hooks[$k] = add_submenu_page(
                        $ns,
                        $v['label'],
                        $v['label'],
                        $permissions,
                        "{$prefix}{$v['slug']}",
                        ["{$screen_key}_screen", 'menu_init'],
                    );
                }
                
                /**
                 * Add Admin Load Hook - Used for Admin Page Initialization ( Dashboard, Tables etc )
                 * Called before menu_init
                 */
                add_action("load-{$this->admin_hooks[$k]}",  ["{$screen_key}_screen", 'admin_load'], 9 );
            }
        }
        
        /**
         * Get Branding SVG
         * 
         * @param bool $encode - Encode SVG as base64
         * @return string
         */
        function get_branding_svg( bool $encode = true ) {
            $url = CKEXAMPLE_PLUGIN_URL . 'assets/menu.svg';
            $svg = file_get_contents($url, FILE_USE_INCLUDE_PATH);
            return $encode ? base64_encode($svg) : $svg;
        }
        
        /**
         * Enqueue Admin Javascript and CSS
         * 
         * @param string $hook - Current page hook
         * @return void
         */
        function enqueue_scripts( $hook ) {
            // Check if current page hook requires admin scripts
            if( in_array( $hook, $this->admin_hooks ) ){
                $v        = CKEXAMPLE_VERSION;
                $ns       = ckexample_app()->ns();
                $handle   = "{$ns}-admin";
                $url      = CKEXAMPLE_PLUGIN_URL . 'build/';
                $dep_js   = [ 'wp-api', 'wp-i18n', 'wp-components', 'wp-element', 'wp-data', 'wp-notices' ];
                $dep_css  = [ 'wp-components' ];
                wp_register_script("{$ns}-admin", "{$url}index.js", $dep_js, $v, false);
                wp_enqueue_style("{$handle}-css", "{$url}style-index.css", $dep_css, $v, 'all');
                add_action('admin_footer', [$this, 'print_scripts']);
            }
        }
        
        /**
         * Localize data for JS
         */
        function print_scripts() {
            $ns     = ckexample_app()->ns();
            $handle = "{$ns}-admin";
            if( ! empty($this->footer_data) ) {
                $this->set_footer_data( 'ns', $ns );
                $this->footer_data['loading_message'] = __('Loading', $ns);
                $this->footer_data['plugin_dir'] = CKEXAMPLE_PLUGIN_URL;
                wp_localize_script( $handle, 'ckexampleData', $this->footer_data );
            }
            wp_enqueue_script( $handle );
        }
        
        /**
         * Set key value index data for Admin Javascript
         * 
         * @param string $key    Name of the key to set
         * @param mixed  $value  Value of the key to set
         * @param mixed ( string || false ) $index   Next level key
         * @return void
         */
        function set_footer_data( string $key, $value = false, $index = false ) {
            if ( $value ) {
                // Append to array
                if ( !empty($index) ) {
                    if ( ! isset($this->footer_data[$key]) ) {
                        $this->footer_data[$key] = [];
                    }
                    $this->footer_data[$key][$index] = $value;
                }
                else {
                    $this->footer_data[$key] = $value;
                }
            }
            else {
                unset($this->footer_data[$key]);
            }
        }
        
        /**
         * Get Key Value or All Data For Admin Javascript
         * 
         * @param  mixed ( string || false ) $key  Optional Key
         * @return mixed ( value of key || null || array )
         */
        function get_footer_data( $key = false ) {
            if ( $key ) {
                return isset($this->footer_data[$key]) ? $this->footer_data[$key] : null;
            }
            else {
                return $this->footer_data;
            }
        }
        
        /**
         * Get Singleton Instance
         */
        static function get_instance() : self {
            static $instance = false;
            return $instance ? $instance : $instance = new self;
        }
        
        /**
         * @var array $notices - Array of admin notices
         */
        private $notices = [];
        
        /**
         * @var array $admin_hooks - Array of admin page hooks
         */
        private $admin_hooks = [];
        
        /**
         * @var array $footer_data - Array of data to pass to admin javascript
         */
        private $footer_data = [];
    
        // End of Class
    }

}