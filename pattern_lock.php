<?php
/*
* Plugin Name: Pattern Lock
* Plugin URI: https://wordpress.org/plugins/lock-pattern
* Description: Allow to set pattern lock for wp-admin screens
* Author: mndpsingh287
* Author URI: https://profiles.wordpress.org/mndpsingh287/
* Version: 1.0
*/
if(!class_exists('pattern_lock'))
{
	class pattern_lock
	{
		/*
		* Autoload Hooks
		*/
		public function __construct()
		{
			register_activation_hook( __FILE__, array(&$this, 'pattern_lock_install'));
			add_action( 'admin_menu', array(&$this, 'pattern_lock_menu'));
			add_action( 'admin_bar_menu', array(&$this, 'toolbar_link_for_pattern_lock'), 999 );
			add_action( 'wp_ajax_pattern_save', array(&$this, 'pattern_save_callback'));
            add_action( 'wp_ajax_nopriv_pattern_save', array(&$this,'pattern_save_callback'));
			add_action( 'wp_ajax_pattern_request_send', array(&$this, 'pattern_request_send_callback'));
            add_action( 'wp_ajax_nopriv_pattern_request_send', array(&$this,'pattern_request_send_callback'));
			add_action( 'wp_ajax_pattern_request_check', array(&$this, 'pattern_request_check_callback'));
            add_action( 'wp_ajax_nopriv_pattern_request_check', array(&$this,'pattern_request_check_callback'));
			add_action( 'wp_ajax_pattern_confirmed', array(&$this, 'pattern_confirmed_callback'));
            add_action( 'wp_ajax_nopriv_pattern_confirmed', array(&$this,'pattern_confirmed_callback'));
			add_action( 'wp_ajax_pattern_forgot', array(&$this, 'pattern_forgot_callback'));
            add_action( 'wp_ajax_nopriv_pattern_forgot', array(&$this,'pattern_forgot_callback'));
			add_action( 'admin_head', array(&$this, 'pattern_lock_admin_head'));
			add_action( 'admin_enqueue_scripts', array(&$this, 'pattern_wp_admin_style'));
		}
		/*
		* Install Function
		*/
		public function pattern_lock_install()
		{
			global $wpdb;
			$table_name = $wpdb->prefix . 'pattern_lock';			
			$charset_collate = $wpdb->get_charset_collate();		
			$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				id mediumint(9) NOT NULL AUTO_INCREMENT,
				uid int(11) NOT NULL,
				lock_password varchar(255) NOT NULL,
				request int(11) NOT NULL,
				UNIQUE KEY id (id)
			) $charset_collate;";		
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
			         $defaultsettings = array(
					                         'enable_pattern_lock' => 'Yes',
											 'backgroundColor' => 'FFFFFF',
											 'color' => '381650',
											 'lineColor' => '010108',
											 'roundRadii' => '40',
											 'pointRadii' => '12',
											 'space' => '50',
											 'width' => '400',
											 'height' => '400',
											 'roundRadii' => '40',
											 'zindex' => '100',
											 'pattern_lock_text' => 'Please Draw Pattern to Unlock Screen',
											 'pattern_lock_text_color' => '000000'
											 );
					$opt = get_option('pattern_lock_options');
					if(!$opt['backgroundColor']) {
						update_option('pattern_lock_options', $defaultsettings);
					}      
		}
		/*
		* Admin Scripts
		*/
		public function pattern_wp_admin_style()
		{
		$cuPage = isset($_GET['page']) ? $_GET['page'] : '';	
		 wp_enqueue_style( 'patternlock', plugins_url( 'inc/css/patternlock.css', __FILE__ ) ); 
		 wp_enqueue_style( 'media-views-pl', admin_url('load-styles.php?load[]=media-views'));
		 if($cuPage == 'pattern_lock_settings'): 
		 wp_enqueue_script('jscolor-pl', plugins_url( 'inc/js/jscolor.js', __FILE__ ), array(), null, true);
		 endif;
		}
		/*
		* Pattern Lock Menus
		*/
		public function pattern_lock_menu()
		{
		add_menu_page( 
			__( 'Pattern Lock', 'pl' ),
			'Pattern Lock',
			'manage_options',
			'pattern_lock',
			array(&$this, 'pattern_lock_callback'),
			'',
			500
        ); 
		add_submenu_page( 'pattern_lock',  __( 'Settings', 'pl' ), 'Settings', 'manage_options', 'pattern_lock_settings', array(&$this,'pattern_lock_settings_callback'));
		}
		/*
		* Pattern Lock Main menu callback
		*/
		public function pattern_lock_callback()
		{
			if(is_admin() && current_user_can( 'manage_options' )):
			 include('inc/pattern_lock_admin.php');
			endif;
		}
		/*
		* Pattern Lock Sub menu callback
		*/
		public function pattern_lock_settings_callback()
		{
			if(is_admin() && current_user_can( 'manage_options' )):
			 include('inc/settings.php');
			endif;
		}
		/*
		* Pattern Lock Toolbar Link
		*/
		public function toolbar_link_for_pattern_lock( $wp_admin_bar ) 
		  {
		$opt = get_option('pattern_lock_options');
			$args = array(
				'id'    => 'lock_screen',
				'title' => 'Lock Screen',
				'href'  => '#',
				'meta'  => array( 'class' => 'lock_screen' )
			);
		if(is_admin() && $opt['enable_pattern_lock'] == 'Yes'):	
	      $wp_admin_bar->add_node( $args );
		endif;  
       }
	    /*
		* Pattern Lock data save
	    */
	   public function pattern_save_callback()
	   {
		   include('inc/save_pattern.php');
	   }
	    /*
		* Pattern Lock send request
	    */
	   public function pattern_request_send_callback()
	   {
		    include('inc/pattern_request_send.php');
	   }
	   	/*
		* Pattern Lock check request
	    */
	   public function pattern_request_check_callback()
	   {
		    include('inc/pattern_request_check.php');
	   }
	   	/*
		* Pattern Lock pattern confirmed
	    */
	   public function pattern_confirmed_callback()
	   {
		    include('inc/pattern_confirmed.php');
	   }
	   	/*
		* Pattern Lock pattern Forgot ?
	    */
	   public function pattern_forgot_callback()
	   {
		    include('inc/forgot_pattern.php');
	   }
	   	/*
		* admin head
	    */
	   public function pattern_lock_admin_head()
	   {
		   $opt = get_option('pattern_lock_options');  
		   if(is_admin() && current_user_can( 'manage_options' ) && $opt['enable_pattern_lock'] == 'Yes'):
		    include('inc/admin_head.php');
		   endif;
	   }
	    /*
		 * Redirection - static
		*/
		static function pl_redirect($url)
		{
			echo '<script>window.location.href="'.$url.'"</script>';
		}
	}
	new pattern_lock; /* Instance */
}