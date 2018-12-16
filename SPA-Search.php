<?php
/*
   Plugin Name: SPA Search
   Plugin URI : -
   Description: A single page application search page
   Version    : 1.0
   Author     : Robert Morel
   Author URI: https://amarria.com/
   License: GPLv2 or later
   Text Domain: SPA_Search
 
 */
 

/*
class, methods and functions in this file are common to all plugins and
handle basic requirements 
 */


// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/*
function myplugin_activate() {}
    register_activation_hook( __FILE__, 'myplugin_activate' );

function myplugin_deactivate() {}
    register_deactivation_hook( __FILE__, 'myplugin_deactivate' );
*/

// if the class does not exist
if( !class_exists( 'SPA_Search_boilerplate' ) ) {
    
    //main class of plugin
    class SPA_Search_boilerplate{

        //static function and private instance vaiables ensure only one instance of plugin class created
    
        //define variable to hold instance of class
        //variable is private to the class
        //static variables have a single value for all instances of a class
        private static $instance;
        //Use instance function to generate a public static object from class
        public static function instance() {

    /*
    Use $this to refer to the current object. Use self to refer to the current class. In other words, use  $this->member for non-static members, use self::$member for static members.
    */
            //restricts the instantiation of the  class to one object (singleton pattern)
            //only execute code if object does not already exist
            if ( ! isset( self::$instance ) && ! ( self::$instance instanceof SPA_Search_boilerplate ) ) {
                //create new object of class and assign to instance variable
                self::$instance = new SPA_Search_boilerplate();
                //add methods to object
                //setup constants defines constants of the plugin. eg: plugin path, directory,uri
                self::$instance->SPA_Search_setup_constants();
                //includes functions.php
                self::$instance->SPA_Search_includes();
                //include ajax
                self::$instance->SPA_Search_includes_ajax();
                //load all plugin specific scripts for back end
                add_action( 'admin_enqueue_scripts',array(self::$instance,'SPA_Search_load_admin_scripts'),9);
                //load all plugin specific scripts for front end
                add_action( 'wp_enqueue_scripts',array(self::$instance,'SPA_Search_load_scripts'),9);
                
            }

            //return the newly created object
            return self::$instance;
        }

        public function SPA_Search_setup_constants() { 

            if ( ! defined( 'SPA_Search_VERSION' ) ) {
                define( 'SPA_Search_VERSION', '1.0' );
            }

            if ( ! defined( 'SPA_Search_PLUGIN_DIR' ) ) {
                define( 'SPA_Search_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
            }

            if ( ! defined( 'SPA_Search_PLUGIN_URL' ) ) {
                define( 'SPA_Search_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
            }

        }
        
        public function SPA_Search_load_scripts(){

            wp_enqueue_script( 'jquery' );
            wp_register_script( 'SPA_Search-scripts', plugins_url( 'js/SPA_search_scripts.js', __FILE__ ), array('jquery'), '1.0', TRUE );
            //wp_enqueue_script( 'SPA_Search-scripts' );

            wp_register_style( 'SPA_Search-styles-css', plugins_url( 'css/SPA_search_styles.css', __FILE__ ) );
            wp_enqueue_style( 'SPA_Search-styles-css' );

            wp_register_style( 'SPA_Search-keyframes-css', plugins_url( 'css/SPA_search_keyframes.css', __FILE__ ) );
            wp_enqueue_style( 'SPA_Search-keyframes-css' );

            //config array used to pass php variables to javascript
            //$config_array = array(
                    //'ajax_url' => admin_url( 'admin-ajax.php' ),
                    //'ajax_nonce' => wp_create_nonce( 'amw-spa-search-nonce' )
            //);

            //function to pass php variables in to script files(handle,,variable name used in script,configuration array with values)
           // wp_localize_script( 'amwspasearchconf', 'amwspasearchconf', $config_array );

            
            
        }
        
        public function SPA_Search_load_admin_scripts(){
            
        }
        
        private function SPA_Search_includes() {
            
            //require_once SPA_Search_PLUGIN_DIR . 'SPA_Search_functions.php';
            
        }

        private function SPA_Search_includes_ajax() {
            
            require SPA_Search_PLUGIN_DIR . 'ajax-scripts/php/ajax_search_results_main.php';
            
        }

        //configure language settings
        public function SPA_Search_load_textdomain() {
            
        }
        
    }
}


//initialize plugin
function SPA_Search_init() {
    global $SPA_Search_boilerplate;
    $SPA_Search = SPA_Search_boilerplate::instance();
}

SPA_Search_init();

//[foobar]
function amw_spa_search_form_func( $atts ){

    $amw_spa_search_form = '<div id="spasearch-ft-wrapper-main"> 

      <div id="spasearch-ajax-search-form-container-main">
      <input type="text" name="spasearch-ajax-search-input-main" id="spasearch-ajax-search-input-main" placeholder="Enter a search term...">
      </div>
      <div id="spasearch-ajax-search-results-container-main">
      <h6 class="spasearch-ajax-search-form-text-main">Please enter a search term to see results....</h6>
      </div>
      <div id="spasearch-ajax-post-container-main">
      </div>
      </div>';

    return $amw_spa_search_form;
}
add_shortcode( 'spasearch', 'amw_spa_search_form_func' );

add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);
function my_embed_oembed_html($html, $url, $attr, $post_id) {
return '<div class="embed-container">' . $html . '</div>'; //if not work try $html
}
