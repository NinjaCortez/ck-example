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
    
    final class ckexample_api_log_list_table extends WP_List_Table {
        /**
         * @var string - The current tab
        */
        public $tab;
        
        /**
         * @var array $column_list - Setting table heading/columns
         */
        private $column_list; 
        
        /**
         * @var array - Setting sortable table heading/columns
        */
        private $sortable_columns;
        
        /**
         * Class constructor.
         */
        public function __construct() {
            parent::__construct( [
                'singular' => 'log',
                'plural'   => 'logs',
                'ajax'     => false
            ]);
        }

        function get_columns(){
            $ns      = ckexample_app()->ns();
            $columns = [
                'cb'        => '<input type="checkbox" />',
                'status'    => __( 'Status', $ns ),
                'request'   => __( 'Request', $ns ),
                'payload'   => __( 'Payload', $ns ),
                'timestamp' => __( 'Time', $ns ),
            ];
            return $columns;
        }

        /**
         * Default Column 
         *
         * @param mixed $post
         * @param mixed $column_name
         */
        function column_default( $item, $column_name ) {
            return '';
        }

        /**
         * Prepare Query Items
         */
        function prepare_items(){
            return [];
        }
        
    // End Class
    }
}