<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://pureandgentleshop.com/
 * @since             1.0.0
 * @package           Dealer
 *
 * @wordpress-plugin
 * Plugin Name:       Dealer
 * Plugin URI:        http://pureandgentleshop.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Pure and Gentle Shop
 * Author URI:        http://pureandgentleshop.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dealer
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
define( 'DEALER_VERSION', '1.0.0' );
define( 'DEALER_FILE', __FILE__ );
define( 'DEALER_PATH', __DIR__ );
define( 'DEALER_URL', plugins_url( '', DEALER_FILE ) );
define( 'DEALER_ASSETS', DEALER_URL . '/assets' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dealer-activator.php
 */
function activate_dealer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dealer-activator.php';
	Dealer_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dealer-deactivator.php
 */
function deactivate_dealer() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dealer-deactivator.php';
	Dealer_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dealer' );
register_deactivation_hook( __FILE__, 'deactivate_dealer' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dealer.php';
require plugin_dir_path( __FILE__ ) . 'functions.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dealer() {
	
	$plugin = new Dealer();
	$plugin->run();

}
run_dealer();