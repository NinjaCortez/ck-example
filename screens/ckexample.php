<?php
/**
 * CK Example Main Admin Screen
 *
 * @since      17.0.0
 * @package    ckexample
 * @subpackage ckexample/screens
 * @author     Curtis Krauter <cortezcreations@gmail.com>
 */

if ( class_exists('ckexample_core_class') ) {

    final class ckexample_screen extends ckexample_admin_screen_base {

        function load() {
            $this->slug      = 'ckexample';
            $this->render_id = "{$this->slug}-admin-wrap-content";
		}

        function post_catcher(){
    	}

        function render_content(){
            return '<div id=""></div>';
        }

    // End of Class
	}
}