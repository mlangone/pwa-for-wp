<?php
/**
Plugin Name: PWA for WordPress
Description: PWA for WordPress with AMP Support
Author: PWA For WP
Version: 1.0
Author URI: https://ampforwp.com
Plugin URI: https://ampforwp.com/pwa/
Text Domain: pwa-for-wp
Domain Path: /languages/
SKU: PWA
 *
 * The main plugin file
 *
 */
	define('PWAFORWP_PLUGIN_DIR', plugin_dir_path( __FILE__ ));
	define('PWAFORWP_PLUGIN_URL', plugin_dir_url( __FILE__ ));
	define('PWAFORWP_PLUGIN_VERSION', '1.0');
        define('PWAFORWP_FRONT_FILE_PREFIX', 'pwa');
        
        
        require_once PWAFORWP_PLUGIN_DIR."/admin/common-function.php";
        
        require_once PWAFORWP_PLUGIN_DIR."/service-work/serviceworker-class.php"; 
        require_once PWAFORWP_PLUGIN_DIR."/service-work/file-creation-class.php"; 
        require_once PWAFORWP_PLUGIN_DIR."/service-work/file_creation_init.php"; 
              
		if( pwaforwp_is_admin() ){
			add_filter( 'plugin_action_links_' . plugin_basename(__FILE__),'pwaforwp_add_action_links');
			require_once PWAFORWP_PLUGIN_DIR."admin/settings.php";
		}
                function pwaforwp_add_action_links($links){
                        $mylinks = array('<a href="' . admin_url( 'admin.php?page=pwaforwp' ) . '">Settings</a>');
                        return array_merge( $links, $mylinks );
                }
          
                       
	

