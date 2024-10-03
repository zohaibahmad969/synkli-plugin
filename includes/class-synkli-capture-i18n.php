<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.synkli.com.au
 * @since      1.0.0
 *
 * @package    Synkli_Capture
 * @subpackage Synkli_Capture/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Synkli_Capture
 * @subpackage Synkli_Capture/includes
 * @author     Synkli <support@synkli.com.au>
 */

 
 if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 
class Synkli_Capture_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'synkli-capture',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
