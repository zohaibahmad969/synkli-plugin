<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://www.synkli.com
 * @since             1.0.0
 * @package           Synkli_Leads
 *
 * @wordpress-plugin
 * Plugin Name:       Synkli Leads
 * Plugin URI:        https://https://www.synkli.com/synkli-leads
 * Description:       This plugin provides a contact form which you can add on website. And all the form leads will go to your Synkli account.
 * Version:           1.0.0
 * Author:            Zohaib Ahmad
 * Author URI:        https://https://www.synkli.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       synkli-leads
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SYNKLI_LEADS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-synkli-leads-activator.php
 */
function activate_synkli_leads() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-synkli-leads-activator.php';
	Synkli_Leads_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-synkli-leads-deactivator.php
 */
function deactivate_synkli_leads() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-synkli-leads-deactivator.php';
	Synkli_Leads_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_synkli_leads' );
register_deactivation_hook( __FILE__, 'deactivate_synkli_leads' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-synkli-leads.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_synkli_leads() {

	$plugin = new Synkli_Leads();
	$plugin->run();

}
run_synkli_leads();
