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

		add_action('wp_ajax_synkli_send_email', array($this, 'synkli_send_email_callback'));
        add_action('wp_ajax_nopriv_synkli_send_email', array($this, 'synkli_send_email_callback')); // For non-logged-in users

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/synkli-leads-public.js', array( 'jquery' ), $this->version, false );

		// Localize the script with the ajaxurl
        wp_localize_script($this->plugin_name, 'synkli_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));

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

	 /**
	 * AJAX callback function to send email
	 *
	 * @since    1.0.0
	 */
	public function synkli_send_email_callback() {
        // Retrieve form data
        $first_name = isset($_POST['first_name']) ? sanitize_text_field($_POST['first_name']) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field($_POST['last_name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
        $message = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';

        // Email configuration
        $to = 'za.solutions@gmail.com'; // Change to the recipient's email address
        $subject = 'New Form Submission';
        $headers = array('Content-Type: text/html; charset=UTF-8');

        // Email body
        $body = "First Name: $first_name<br>";
        $body .= "Last Name: $last_name<br>";
        $body .= "Email: $email<br>";
        $body .= "Phone: $phone<br>";
        $body .= "Message:<br>$message<br>";

        // Send email
        $sent = wp_mail($to, $subject, $body, $headers);

        // Send JSON response
        if ($sent) {
            wp_send_json_success('Email sent successfully');
        } else {
            wp_send_json_error('Failed to send email');
        }
    }

}
