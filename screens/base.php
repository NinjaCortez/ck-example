<?php
 /**
  * Plugin Settings Admin Screen Interface
  *
  * @since      1.0.0
  * @package    ckexample
  * @subpackage ckexample/classes
  * @author     Curtis Krauter <cortezcreations@gmail.com>
  * @note - Yanked from an existing project but then started playing with React 
  * to take advantage of all available WP.Components
  * @link Nice visuals on all available @ https://wp-gb.com/ 
  * Normally this would utilize an admin UI classs to generate settings from each sub screen 
  */

if (class_exists('ckexample_core_class') ) {
    
    abstract class ckexample_admin_screen_base {
        
        /**
         * Required Load Function
         */
        abstract protected function load();
        
        /**
         * Required Post Catcher - Set up for same page submit not React :)
         */
        abstract protected function post_catcher();

        /**
         * Render Content
         */
        abstract protected function render_content();

        /**
         * Admin Load
         */
         static function admin_load() {
             $ns                  = ckexample_app()->ns();
             $screen              = get_current_screen();
             $instance            = static::get_instance();
             $instance->screen_id = !empty($screen) ? $screen->id : false;
             $page                = !empty($_GET['page'])    ? $_GET['page']    : $ns;
             $instance->page      = $page !== $ns ? substr_replace($page, "", 0, 10) : $ns;
             $instance->submenu   = !empty($_GET['tab'])     ? $_GET['tab']     : false;
             $instance->section   = !empty($_GET['section']) ? $_GET['section'] : false;
             $instance->load();
             add_filter("screen_options_show_screen", "__return_false");
        }

        /**
         * Render Page from static menu call
         */
        static function menu_init() {
            static::get_instance()->render();
        }

        /**
         * Render Content
         */
        function render() {
            $ns = ckexample_app()->ns();
            $this->admin_tabs  = ckexample_app()->admin()->get_admin_tabs();
            
            // Posted Settings
            if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
                $nonce = !empty($_POST["{$ns}_wpnonce"]) ? $_POST["{$ns}_wpnonce"] : false;
                if ( wp_verify_nonce( $nonce, $ns ) ){
                    $this->post_catcher();
                }
                else {
                    die("Nonce Error");
                }
            }
            
            // Display Notices
            if( !empty($this->notices) ){
                foreach ($this->notices as $notice) {
                    new ckexample_admin_notice( $notice['type'], $notice['title'], $notice['message'], true, true );
                }
            }
            
            // Render Page
            echo $this->render_page_wrapper_start();
            
            echo $this->render_common_header();
            
            echo $this->render_page_wrapper_content_start();
            
            echo $this->render_sidebar_menu();
            
            echo $this->render_sidebar_page_content_wrap_start();
            
            echo $this->render_content();
            
            echo $this->render_sidebar_page_content_wrap_end();
            
            echo $this->render_page_wrapper_content_end();
            
            echo $this->render_page_wrapper_end();
            
            // Set Data for JS
            $this->to_json('page', $this->page);
            $this->to_json('tab',  $this->submenu);
            $this->to_json('section',  $this->section);
            $this->to_json('defaults', ckexample_app()->get_settings_config(true));
            $this->to_json('settings', ckexample_app()->get_settings());
            $this->to_json('renderID', $this->render_id);
            
            $url_args = [ 'page' => "{$ns}_{$this->page}" ];
            if( ! empty($this->submenu) ){
                $url_args['tab'] = $this->submenu;
            }
            
            $this->to_json('screenUri', add_query_arg( $url_args,
                get_admin_url( null, '/admin.php', is_ssl() ? 'https' : 'http' )
            ) );
        }
        
        //
        // Page Wrapper
        //
        function render_page_wrapper_start() {
            $ns     = ckexample_app()->ns();
            $method = 'post';
            $html   = "<form method=\"{$method}\"autocomplete=\"off\" class=\"{$ns}-full-height\">";
            $html  .= wp_nonce_field( $ns, "{$ns}_wpnonce", true, false );
            $html  .= "<div id=\"{$ns}-admin\" class=\"{$ns}-admin-wrap\" data-page=\"{$this->slug}\">";
            return $html;
        }
        
        function render_page_wrapper_end() {
            return "</div></form>"; // End #admin-wrap
        }
        
        //
        // Common Header
        //
        function render_common_header() {
            $ns    = ckexample_app()->ns();
            $link  = ckexample_app()->get_settings('support_url');
            $html  = "<div class=\"{$ns}-common-header\">";
            $html .= ckexample_app()->admin()->get_branding_svg( false );
            $html .= "<h1>".ckexample_app()->name()."</h1>";
            $html .= "<a href=\"{$link}\" class=\"button\" target=\"_blank\">".__('Help', $ns)."</a>";
            $html .= "</div>";
            return $html;
        }
        
        //
        // Content Wrap
        //
        
        function render_page_wrapper_content_start() {
            // Start admin-wrap-content
            $ns    = ckexample_app()->ns();
            $class = "";//"stuffbox";
            $html  = "<div id=\"{$ns}-admin-wrap-content\" class=\"{$class}\">";
            return $html;
        }
        
        function render_page_wrapper_content_end() {
            // End #admin-wrap-content
            return '</div>';
        }
        
        //
        // Content Header
        //
        
        function render_content_header( $title = '' ) {
            $ns    = ckexample_app()->ns();
            $title = ! empty($title) ? $title : $this->get_active_submenu_title();
            return ! empty($title) ? "<div class=\"{$ns}-info-header\"><h2>{$title}</h2></div>" : "";
        }
        
        //
        // Sidebar
        //
        
        function render_sidebar_menu() {
            $html = "";
            return $html;
        }
        
        function render_sidebar_content_wrapper($content) {
            $ns = ckexample_app()->ns();
            return "<div class=\"{$ns}-info-content\">{$content}</div>";
        }
        
        function render_sidebar_page_content_wrap_start(){
            $ns = ckexample_app()->ns();
            return "<div class=\"{$ns}-right-content-wrap {$ns}-full-height\">";
        }
        
        function render_sidebar_page_content_wrap_end() {
            return "</div>";
        }
        
        function get_active_page_config() {
            $page = array_key_exists($this->page, $this->admin_tabs) ? $this->admin_tabs[$this->page] : false;
            if ( ! $page && ! empty($this->page) ) {
                $page_key = str_replace('-', '_', $this->page);
                $page     = array_key_exists($page_key, $this->admin_tabs) ? $this->admin_tabs[$page_key] : false;
            }
            return $page;
        }
        
        function get_active_submenu_title() {
            $page = $this->get_active_page_config();
            $subs = $page && array_key_exists('submenu', $page) ? $page['submenu'] : [];
            $menu = $this->submenu && array_key_exists($this->submenu, $subs) ? $subs[$this->submenu] : false;
            if($menu){
                return array_key_exists('page-title', $menu) ? $menu['page-title'] : $menu['title'];
            }
            else{
                return '';
            }
        }
        
        //
        // JSON Data
        //
        function to_json( $key, $value ) {
            ckexample_app()->admin()->set_footer_data($key, $value);
        }
        
        function set_I18n( string $key, $value = false ) {
            if ( $value ) {
                $I18n       = ckexample_app()->admin()->get_footer_data('I18n');
                $I18n       = ! is_array($I18n) ? [] : $I18n;
                $I18n[$key] = $value;
                ckexample_app()->admin()->set_footer_data('I18n', $I18n);
            }
        }
        
        // Notices
        function set_admin_notice( string $type, string $title, string $message ) {
            $this->notices[] = [ 'type' => $type, 'title' => $title, 'message' => $message ];
        }
        
        private static $_instances = [];
        public static function get_instance() {
            $class = get_called_class();
            if ( ! isset(self::$_instances[$class]) ) {
                self::$_instances[$class] = new $class();
            }
            return self::$_instances[$class];
        }
        
        protected $page, $submenu, $section; // $_GET Tabs & Subsections
        protected $screen_id;
        protected $render_id = false;
        protected $activated = false;
        protected $connected = false;
        protected $admin_tabs;
        protected $notices = [];
        protected $slug;

    // End of Class
    }
}