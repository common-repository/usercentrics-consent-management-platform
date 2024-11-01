<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://webnique.de
 * @since             1.0.0
 * @package           Usercentrics
 *
 * @wordpress-plugin
 * Plugin Name:       Usercentrics CMP
 * Plugin URI:        https://webnique.de/plugins/usercentrics
 * Description:       Embed the Usercentrics Consent Management Platform on your website.
 * Version:           1.0.9
 * Author:            Webnique
 * Author URI:        https://webnique.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       usercentrics
 * Domain Path:       /languages
 * Network:           true
 * RequiresPHP:       7.3
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
define( 'USERCENTRICS_VERSION', '1.0.9' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-usercentrics-activator.php
 */
function activate_usercentrics() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-usercentrics-activator.php';
	Usercentrics_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-usercentrics-deactivator.php
 */
function deactivate_usercentrics() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-usercentrics-deactivator.php';
	Usercentrics_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_usercentrics' );
register_deactivation_hook( __FILE__, 'deactivate_usercentrics' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-usercentrics.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_usercentrics() {

	$plugin = new Usercentrics();
	$plugin->run();

}
run_usercentrics();
