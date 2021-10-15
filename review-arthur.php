<?php

/**
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           review_arthur
 *
 * @wordpress-plugin
 * Plugin Name:       Review by Arthur
 * Description:       The plugin makes it possible to display a form for sending a review, and displaying reviews!
 * Version:           1.0.0
 * Author:            Arthur Liashenko
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       review-arthur
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
define( 'review_arthur_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-review-arthur-activator.php
 */
function activate_review_arthur() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-review-arthur-activator.php';
	review_arthur_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-review-arthur-deactivator.php
 */
function deactivate_review_arthur() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-review-arthur-deactivator.php';
	review_arthur_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_review_arthur' );
register_deactivation_hook( __FILE__, 'deactivate_review_arthur' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-review-arthur.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_review_arthur() {

	$plugin = new review_arthur();
	$plugin->run();

}
run_review_arthur();
