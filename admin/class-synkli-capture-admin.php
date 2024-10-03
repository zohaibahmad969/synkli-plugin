<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.synkli.com.au
 * @since      1.0.0
 *
 * @package    Synkli_Capture
 * @subpackage Synkli_Capture/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Synkli_Capture
 * @subpackage Synkli_Capture/admin
 * @author     Synkli <support@synkli.com.au>
 */

 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Synkli_Capture_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	private $api_key;
	private $secret_key;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		
		// adding menu item to wordpress dashboard
		add_action( 'admin_menu', array($this, 'synkli_capture_admin_menu') );

		// Plugin settings sections initialize
		add_action( 'admin_init', array( $this, 'synkli_initialize_settings' ) );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function synkli_capture_enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/synkli-capture-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function synkli_capture_enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/synkli-capture-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the fields for plugin settings
	 *
	 * @since    1.0.0
	 */
	public function synkli_initialize_settings() {
        
        register_setting( 'synkli_capture_api_settings', 'synkli_api_key' );

		register_setting('synkli_capture_content_settings', 'synkli_form_title');
		register_setting('synkli_capture_content_settings', 'synkli_form_description');
		
		register_setting('synkli_capture_style_settings', 'synkli_form_style_type');
		register_setting('synkli_capture_style_settings', 'synkli_custom_css');

		register_setting('synkli_capture_email_settings', 'synkli_email_to');
		register_setting('synkli_capture_email_settings', 'synkli_email_from');
		register_setting('synkli_capture_email_settings', 'synkli_email_subject');
		register_setting('synkli_capture_email_settings', 'synkli_email_headers');
		register_setting('synkli_capture_email_settings', 'synkli_email_body');
		register_setting('synkli_capture_email_settings', 'synkli_email_format');
		register_setting('synkli_capture_email_settings', 'synkli_form_success_message');
		register_setting('synkli_capture_email_settings', 'synkli_form_error_message');
    }

	/**
	 * Add the Menu in Wordpress Dashboard
	 *
	 * @since    1.0.0
	 */
	public function synkli_capture_admin_menu()
	{	
		add_menu_page( 'Synkli Capture', 'Synkli Capture', 'activate_plugins', 'synkli_capture', 'synkli_capture_dashboard_page', 'dashicons-analytics', 50 );
		
		if (!function_exists('synkli_capture_dashboard_page')) {
			function synkli_capture_dashboard_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-capture-admin-display.php');
			}
		}


		add_submenu_page( 'synkli_capture', 'Connection', 'Connection', 'manage_options', 'synkli-capture-connection', 'synkli_capture_dashboard_connection_page');

		if (!function_exists('synkli_capture_dashboard_connection_page')) {
			function synkli_capture_dashboard_connection_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-capture-admin-menu-connection.php');
				
			}
		}


		add_submenu_page( 'synkli_capture', 'Content', 'Content', 'manage_options', 'synkli-capture-content', 'synkli_capture_dashboard_content_page' );
		
		if (!function_exists('synkli_capture_dashboard_content_page')) {
			function synkli_capture_dashboard_content_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-capture-admin-menu-content.php');
				
			}
		}

	
		add_submenu_page( 'synkli_capture', 'Style', 'Style', 'manage_options', 'synkli-capture-style', 'synkli_capture_dashboard_style_page' );
		
		if (!function_exists('synkli_capture_dashboard_style_page')) {
			function synkli_capture_dashboard_style_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-capture-admin-menu-style.php');
				
			}
		}

	
		add_submenu_page( 'synkli_capture', 'Emails', 'Emails', 'manage_options', 'synkli-capture-emails', 'synkli_capture_dashboard_emails_page' );
		
		if (!function_exists('synkli_capture_dashboard_emails_page')) {
			function synkli_capture_dashboard_emails_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-capture-admin-menu-emails.php');
				
			}
		}


		add_submenu_page( 'synkli_capture', 'Shortcode', 'Shortcode', 'manage_options', 'synkli-capture-shortcode', 'synkli_capture_dashboard_shortcode_page' );

		if (!function_exists('synkli_capture_dashboard_shortcode_page')) {
			function synkli_capture_dashboard_shortcode_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-capture-admin-menu-shortcode.php');
				
			}
		}


		add_submenu_page( 'synkli_capture', 'Help', 'Help', 'manage_options', 'synkli-capture-help', 'synkli_capture_dashboard_help_page' );

		if (!function_exists('synkli_capture_dashboard_help_page')) {
			function synkli_capture_dashboard_help_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-capture-admin-menu-help.php');
				
			}
		}
				
	 }
	
	

}
