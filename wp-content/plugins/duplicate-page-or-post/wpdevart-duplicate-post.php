<?php
/*
* Plugin Name: Duplicate Page or Post
* Plugin URI: http://wpdevart.com/
* Author URI: https://wpdevart.com/ 
* Description: Duplicate Page or Post is an great tool that allow to duplicate pages and posts. Now you can do it in one click.
* Version: 1.0.6
* Author: wpdevart
* License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
*/

class wpda_duplicate_post{
	
	function __construct(){		
		
		$this->define_constants();
		// include files 
		$this->include_files();
		// call filters for plugin
		$this->call_base_filters();
		// crate admin panel	
		$this->create_admin();	
	}	

    /*###################### Creating admin function ##################*/	
	
	private function create_admin(){
		// create admin menu		
		$this->admin_menu = new wpda_duplicate_post_admin_panel();		
	}
	
	public function registr_requeried_scripts(){		

	}

	    /*###################### Call base filters function ##################*/	
		
	private function call_base_filters(){
		add_action('init',  array($this,'registr_requeried_scripts') );
	}
  	private function define_constants(){
		 define('wpda_duplicate_post_plugin_url',trailingslashit( plugins_url('', __FILE__ ) ));
		 define('wpda_duplicate_post_plugin_path',trailingslashit( plugin_dir_path( __FILE__ ) ));
		 define('wpdevart_duplicate_post_support_url',"https://wordpress.org/support/plugin/duplicate-page-or-post/");
		
	}	
	
    /*###################### Function for including files ##################*/		
	
	private function include_files(){
		require_once(wpda_duplicate_post_plugin_path.'admin/admin.php'); 	
	}
}
$wpda_duplicate_post = new wpda_duplicate_post();
?>