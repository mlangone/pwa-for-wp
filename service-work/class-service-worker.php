<?php               
class PWAFORWP_Service_Worker{
	
    public $is_amp = false;
    public $is_amp_front = false;
    public $swjs_path;
    public $swjs_path_amp;
    public $swhtml_path;
    public $minifest_path;
    public $minifest_path_amp;
    public $wppath;
    

    public function __construct() {
        $settings = pwaforwp_defaultSettings();
        
        if(isset($settings['amp_enable'])){
        add_action('pre_amp_render_post', array($this, 'pwaforwp_amp_entry_point'));      
        }                      
        $this->pwaforwp_is_amp_activated();
            
	$url = str_replace("http:","https:",site_url());                              
        $this->wppath = str_replace("//","/",str_replace("\\","/",realpath(ABSPATH))."/");
        $this->swjs_path = $url.'/'.PWAFORWP_FILE_PREFIX.'-sw.js';
        $this->minifest_path = $url.'/'.PWAFORWP_FILE_PREFIX.'-manifest.json';
        
        $this->swjs_path_amp = $url.'/'.PWAFORWP_FILE_PREFIX.'-amp-sw.js';
        $this->swhtml_path = $url.'/'.PWAFORWP_FILE_PREFIX.'-amp-sw.html';
        $this->minifest_path_amp = $url.'/'.PWAFORWP_FILE_PREFIX.'-amp-manifest.json';
        
        
        if(isset($settings['normal_enable'])){
        add_action('wp_footer',array($this, 'pwaforwp_service_worker_non_amp'),35);    
        add_action('wp_head',array($this, 'pwaforwp_paginated_post_add_homescreen'),1);   
        }        
    }
    public function pwaforwp_amp_entry_point(){            
        add_action('amp_post_template_footer',array($this, 'pwaforwp_service_worker'));
        add_filter('amp_post_template_data',array($this, 'pwaforwp_service_worker_script'),35);
        add_action('amp_post_template_head',array($this, 'pwaforwp_paginated_post_add_homescreen_amp'),1); 
    }
	
	public function pwaforwp_service_worker(){ ?>
		<amp-install-serviceworker src="<?php echo esc_url($this->swjs_path_amp); ?>" data-iframe-src="<?php echo esc_url($this->swhtml_path); ?>"  layout="nodisplay">
			</amp-install-serviceworker>
		<?php
	}
	//Load Script
	public function pwaforwp_service_worker_script( $data ){
		if ( empty( $data['amp_component_scripts']['amp-install-serviceworker'] ) ) {
			$data['amp_component_scripts']['amp-install-serviceworker'] = 'https://cdn.ampproject.org/v0/amp-install-serviceworker-0.1.js';
		}
		return $data;
	}
       	
	public function pwaforwp_service_worker_non_amp(){           
        $url 			 = str_replace("http:","https:",site_url());	
		$settings 		 = pwaforwp_defaultSettings();
		$manualfileSetup = $settings['manualfileSetup'];
		if( $manualfileSetup ){
            echo '<script src="'.esc_url($url.'/'.PWAFORWP_FILE_PREFIX.'-register-sw.js').'"></script>';    		
		}           		
	}              
    
    public function pwaforwp_paginated_post_add_homescreen_amp(){           
		$url 			 = str_replace("http:","https:",site_url());	
		$settings 		 = pwaforwp_defaultSettings();
		$manualfileSetup = $settings['manualfileSetup'];
		if($manualfileSetup){
		    echo '<link rel="manifest" href="'. esc_url($url.'/'.PWAFORWP_FILE_PREFIX.'-amp-manifest.json').'">';
		}
	}

	public function pwaforwp_paginated_post_add_homescreen(){                       
		$url 			 = str_replace("http:","https:",site_url());	
		$settings 		 = pwaforwp_defaultSettings();
		$manualfileSetup = $settings['manualfileSetup'];
		if($manualfileSetup){
                        echo '<meta name="pwaforwp" content="wordpress-plugin"/>';
			echo '<link rel="manifest" href="'. esc_url($url.'/'.PWAFORWP_FILE_PREFIX.'-manifest.json').'"/>';
		}
	}

	public function pwaforwp_is_amp_activated() {    
		if(function_exists('is_plugin_active')){
			if ( is_plugin_active('accelerated-mobile-pages/accelerated-moblie-pages.php') || is_plugin_active('amp/amp.php')) {
				$this->is_amp = true;
			}
		}    
    }                                 
}
if (class_exists('PWAFORWP_Service_Worker')) {
	new PWAFORWP_Service_Worker;
};