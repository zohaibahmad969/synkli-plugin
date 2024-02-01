<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://https://www.synkli.com
 * @since      1.0.0
 *
 * @package    Synkli_Leads
 * @subpackage Synkli_Leads/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Synkli_Leads
 * @subpackage Synkli_Leads/public
 * @author     Zohaib Ahmad <zohaibahmad969@gmail.com>
 */
class Synkli_Leads_Public {

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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		// Register shortcode for synkli form leads
        add_shortcode( 'synkli_leads_form', array( $this, 'synkli_leads_shortcode_handler' ) );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/synkli-leads-public.css', array(), $this->version, 'all' );

		if(get_option('synkli_form_style_type') === 'default-style'){
			wp_enqueue_style( $this->plugin_name . 'form', plugin_dir_url( __FILE__ ) . 'css/synkli-leads-form-default.css', array(), $this->version, 'all' );
		}else if(get_option('synkli_form_style_type') === 'synkli-style-light'){
			wp_enqueue_style( $this->plugin_name . 'form', plugin_dir_url( __FILE__ ) . 'css/synkli-leads-form-synkli-light.css', array(), $this->version, 'all' );
		}else if(get_option('synkli_form_style_type') === 'synkli-style-dark'){
			wp_enqueue_style( $this->plugin_name . 'form', plugin_dir_url( __FILE__ ) . 'css/synkli-leads-form-synkli-dark.css', array(), $this->version, 'all' );
		}else if(get_option('synkli_form_style_type') === 'custom-style'){
			// custom css code will be loaded after form shortcode
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/synkli-leads-public.js', array( 'jquery' ), $this->version, false );

	}
	

	 /**
	 * Create the shortcode for Synkli form leads
	 *
	 * @since    1.0.0
	 */
	public function synkli_leads_shortcode_handler( $atts ) {
		// Process any attributes passed to the shortcode (if needed)
	
		include(dirname (__FILE__) . '/partials/synkli_leads_shortcode_handler.php');
	
		return $output;
	}

}
