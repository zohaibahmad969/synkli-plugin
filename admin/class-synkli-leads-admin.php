<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://https://www.synkli.com
 * @since      1.0.0
 *
 * @package    Synkli_Leads
 * @subpackage Synkli_Leads/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Synkli_Leads
 * @subpackage Synkli_Leads/admin
 * @author     Zohaib Ahmad <zohaibahmad969@gmail.com>
 */
class Synkli_Leads_Admin {

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
		add_action( 'admin_menu', array($this, 'synkli_leads_admin_menu') );

		// Plugin settings sections initialize
		add_action( 'admin_init', array( $this, 'synkli_initialize_settings' ) );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/synkli-leads-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/synkli-leads-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the fields for plugin settings
	 *
	 * @since    1.0.0
	 */
	public function synkli_initialize_settings() {
        
        register_setting( 'synkli_leads_api_settings', 'synkli_api_key' );
        register_setting( 'synkli_leads_api_settings', 'synkli_secret_key' );

		register_setting('synkli_leads_style_settings', 'synkli_form_style_type');
		register_setting('synkli_leads_style_settings', 'synkli_custom_css');

		register_setting('synkli_leads_email_settings', 'synkli_email_to');
		register_setting('synkli_leads_email_settings', 'synkli_email_from');
		register_setting('synkli_leads_email_settings', 'synkli_email_subject');
		register_setting('synkli_leads_email_settings', 'synkli_email_headers');
		register_setting('synkli_leads_email_settings', 'synkli_email_body');
		register_setting('synkli_leads_email_settings', 'synkli_email_format');
		register_setting('synkli_leads_email_settings', 'synkli_form_success_message');
		register_setting('synkli_leads_email_settings', 'synkli_form_error_message');
    }

	/**
	 * Add the Menu in Wordpress Dashboard
	 *
	 * @since    1.0.0
	 */
	public function synkli_leads_admin_menu()
	{	
		add_menu_page( 'Synkli Leads', 'Synkli Leads', 'activate_plugins', 'synkli_leads', 'synkli_leads_dashboard_page', 'dashicons-analytics', 50 );
		
		if (!function_exists('synkli_leads_dashboard_page')) {
			function synkli_leads_dashboard_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-leads-admin-display.php');
			}
		}


		add_submenu_page( 'synkli_leads', 'Integration', 'Integration', 'manage_options', 'synkli-leads-integration', 'synkli_leads_dashboard_integration_page');

		if (!function_exists('synkli_leads_dashboard_integration_page')) {
			function synkli_leads_dashboard_integration_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-leads-admin-menu-integration.php');
				
			}
		}

	
		add_submenu_page( 'synkli_leads', 'Style', 'Style', 'manage_options', 'synkli-leads-style', 'synkli_leads_dashboard_style_page' );
		
		if (!function_exists('synkli_leads_dashboard_style_page')) {
			function synkli_leads_dashboard_style_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-leads-admin-menu-style.php');
				
			}
		}

	
		add_submenu_page( 'synkli_leads', 'Emails', 'Emails', 'manage_options', 'synkli-leads-emails', 'synkli_leads_dashboard_emails_page' );
		
		if (!function_exists('synkli_leads_dashboard_emails_page')) {
			function synkli_leads_dashboard_emails_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-leads-admin-menu-emails.php');
				
			}
		}


		add_submenu_page( 'synkli_leads', 'Help', 'Help', 'manage_options', 'synkli-leads-help', 'synkli_leads_dashboard_help_page' );

		if (!function_exists('synkli_leads_dashboard_help_page')) {
			function synkli_leads_dashboard_help_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-leads-admin-menu-help.php');
				
			}
		}
				
	 }
	
	

}
