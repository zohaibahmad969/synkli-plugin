<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.synkli.com.au
 * @since      1.0.0
 *
 * @package    Synkli_Capture
 * @subpackage Synkli_Ceads/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Synkli_Capture
 * @subpackage Synkli_Capture/public
 * @author     Synkli <support@synkli.com.au>
 */

 
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Synkli_Capture_Public {

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
        add_shortcode( 'synkli_capture_form', array( $this, 'synkli_capture_shortcode_handler' ) );

		add_action('wp_ajax_synkli_send_email', array($this, 'synkli_capture_send_email_callback'));
        add_action('wp_ajax_nopriv_synkli_send_email', array($this, 'synkli_capture_send_email_callback')); // For non-logged-in users

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function synkli_capture_enqueue_styles() {

		// Check if the current post content contains the Synkli Capture shortcode.

		global $post;

		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'synkli_capture_form' ) ) {
			// Enqueue the CSS file only if the shortcode is present.
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/synkli-capture-public.css', array(), $this->version, 'all' );

			
			// Check for custom CSS and add it inline if it exists
			if (get_option('synkli_form_style_type') === 'synkli-style-custom') {
				$custom_css = get_option('synkli_custom_css');
				if (!empty($custom_css)) {
					$sanitized_css = wp_strip_all_tags($custom_css);
					wp_add_inline_style($this->plugin_name, $sanitized_css);
				}
			}
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function synkli_capture_enqueue_scripts() {

		global $post;

		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'synkli_capture_form' ) ) {
					
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/synkli-capture-public.js', array( 'jquery' ), $this->version, false );

			// Localize the script with the ajaxurl
	        wp_localize_script($this->plugin_name, 'synkli_plugin_data', array('ajaxurl' => admin_url('admin-ajax.php') , 'synkliPluginUrl' => plugin_dir_url( __FILE__ ) ));

		}

	}
	

	 /**
	 * Create the shortcode for Synkli form leads
	 *
	 * @since    1.0.0
	 */
	public function synkli_capture_shortcode_handler( $atts ) {
		// Process any attributes passed to the shortcode (if needed)
	
		include(dirname (__FILE__) . '/partials/synkli_capture_shortcode_handler.php');
	
		return $output;
	}

	 /**
	 * AJAX callback function to send email
	 *
	 * @since    1.0.0
	 */
	public function synkli_capture_send_email_callback() {

		// Verify nonce
		if ( !isset( $_POST['synkli_email_nonce'] ) || !wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['synkli_email_nonce'] ) ), 'synkli_send_email' ) ) {
			// Nonce verification failed, handle the error
			wp_send_json_error( 'Nonce verification failed' );
		}

		
        // Retrieve form data
        $first_name = isset($_POST['first_name']) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
        $last_name = isset($_POST['last_name']) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
        $email = isset($_POST['email']) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
        $phone = isset($_POST['phone_number']) ? sanitize_text_field( wp_unslash( $_POST['phone_number'] ) ) : '';
        $message = isset($_POST['message']) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

        // Email configuration
        $to = !empty(get_option('synkli_email_to')) ? sanitize_email(get_option('synkli_email_to')) : get_option('admin_email');
		$from = !empty(get_option('synkli_email_from')) ? sanitize_email(get_option('synkli_email_from')) : get_option('admin_email');
		$subject = !empty(get_option('synkli_email_subject')) ? sanitize_text_field(get_option('synkli_email_subject')) : 'Synkli Form Submission';
		$email_format = !empty(get_option('synkli_email_format')) ? sanitize_text_field(get_option('synkli_email_format')) : 'html';

		$content_type = $email_format === 'html' ? 'text/html' : 'text/plain';
		$headers = array(
			'Content-Type: ' . $content_type . '; charset=UTF-8',
			'From: ' . $from
		);

        // Email body
		$body  = "First Name: " . esc_html( $first_name ) . "<br>";
		$body .= "Last Name: " . esc_html( $last_name ) . "<br>";
		$body .= "Email: " . esc_html( $email ) . "<br>";
		$body .= "Phone: " . esc_html( $phone ) . "<br>";
		$body .= "Message:<br>" . nl2br( esc_html( $message ) ) . "<br>";

        // Send email
        $sent = wp_mail($to, $subject, $body, $headers);

		// Remove the content type filter after sending the email
		remove_filter( 'wp_mail_content_type', function() { return 'text/html'; } );

        // Send JSON response
        if ($sent) {
            wp_send_json_success('Email sent successfully');
        } else {
            wp_send_json_error('Failed to send email');
        }
    }

}
