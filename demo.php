<?php
/*
Plugin Name: Factory Women
Version: 0.1-alpha
Description: A Wordpress's plugin to setting up posts as test data
Author: Julio Lopez Montalvo
Author URI: http://codalot.com/
Plugin URI: https://github.com/TheBlasfem/factory-women
Text Domain: Factory Women
Domain Path: /languages
*/


// Only create an instance of the plugin if it doesn't already exists in GLOBALS
if( ! array_key_exists( 'factory-women', $GLOBALS ) ) { 
 
    class FactoryWomen {
          
        function __construct() {
          if (function_exists('add_action')) {
						add_action('admin_menu', array($this, 'add_page')); 
					}
        } // end constructor

        function add_page(){	
					if (function_exists('add_options_page')) {
						add_options_page('Factory', 'Factory', 8, basename(__FILE__), array($this, 'factory_index'));
					}
				}

		    public function factory_index(){
					include('template/index.html');
					$numberposts = $_POST['numberposts'];
					$posttitle = $_POST['posttitle'];
					if(isset($numberposts)){
						$this->insert_posts($numberposts, $posttitle);
					}
				}

				public function insert_posts($n, $title){
					for ($i=1; $i<=$n; $i++){
						$post = array(
							'post_title' => "$title $i",
							'post_type' => "post",
							'post_status' => "publish"
						);
						wp_insert_post( $post );
					}
				}

       
    } // end class
     
    // Store a reference to the plugin in GLOBALS so that our unit tests can access it
    $GLOBALS['factory-women'] = new FactoryWomen();
     
} // end if