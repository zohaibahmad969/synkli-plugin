<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.synkli.com.au
 * @since             1.0.0
 * @package           Synkli_Capture
 *
 * @wordpress-plugin
 * Plugin Name:       Synkli Capture
 * Plugin URI:        https://synkli.com.au/
 * Description:       This plugin provides a Lead Form which you can add on website. And all the form leads will go to your Synkli account.
 * Version:           1.0.0
 * Author:            Synkli
 * Author URI:        https://synkli.com.au
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       synkli-capture
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SYNKLI_CAPTURE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-synkli-capture-activator.php
 */
function synkli_capture_activate_synkli_capture() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-synkli-capture-activator.php';
	Synkli_Capture_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-synkli-capture-deactivator.php
 */
function synkli_capture_deactivate_synkli_capture() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-synkli-capture-deactivator.php';
	Synkli_Capture_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'synkli_capture_activate_synkli_capture' );
register_deactivation_hook( __FILE__, 'synkli_capture_deactivate_synkli_capture' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-synkli-capture.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function synkli_capture_run_synkli_capture() {

	$plugin = new Synkli_Capture();
	$plugin->run();

}
synkli_capture_run_synkli_capture();
