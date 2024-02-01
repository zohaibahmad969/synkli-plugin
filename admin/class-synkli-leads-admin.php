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

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Synkli_Leads_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Synkli_Leads_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/synkli-leads-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Synkli_Leads_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Synkli_Leads_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/synkli-leads-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the fields for plugin settings
	 *
	 * @since    1.0.0
	 */
	public function synkli_initialize_settings() {
        // Register setting for Synkli API Key
        register_setting( 'synkli_leads_settings', 'synkli_api_key' );

        // Register setting for Synkli Secret Key
        register_setting( 'synkli_leads_settings', 'synkli_secret_key' );
    }

	/**
	 * Add the Menu in Wordpress Dashboard
	 *
	 * @since    1.0.0
	 */
	public function synkli_leads_admin_menu()
	{	
		add_menu_page(
			__('Synkli Leads', 'synkli-leads'), // Page title
			__('Synkli Leads', 'synkli-leads'), // Menu title
			'activate_plugins',                 // Capability required to access
			'synkli_leads',                     // Menu slug
			'synkli_leads_dashboard_page',      // Callback function
			'dashicons-analytics',              // Icon (optional)
			50                                // Position (null for top level)
		);

		if (!function_exists('synkli_leads_dashboard_page')) {
			function synkli_leads_dashboard_page()
			{
			   include(dirname (__FILE__) . '/partials/synkli-leads-admin-display.php');
				
			}
		}
				
	 }
	
	

}
