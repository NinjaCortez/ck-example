<?php
/**
 * CK Example API Log Admin Screen
 *
 * @since      1.0.0
 * @package    ckexample
 * @subpackage ckexample/screens
 * @author     Curtis Krauter <cortezcreations@gmail.com>
 */

if ( class_exists('ckexample_core_class') ) {
    
    final class ckexample_api_log_screen extends ckexample_admin_screen_base {
        
        function load() {
            $this->slug = 'ckexample_api_log';
            
            // Include Admin Table
            if ( ! class_exists( 'WP_List_Table' ) ) {
                require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
            }
            $this->table = new ckexample_api_log_list_table();
        }
        
        function post_catcher(){
        }
        
        function render_content(){
            $this->table->prepare_items();
            $this->table->display();
        }
        
        public $table;
        
    // End of Class
    }

}