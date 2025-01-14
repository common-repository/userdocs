<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://endif.media
 * @since             0.9
 * @package           Userdocs
 *
 * @wordpress-plugin
 * Plugin Name:       UserDocs
 * Plugin URI:        userdocsforwordpress.com
 * Description:       The best documentation plugin for WordPress. To use: add shortcode [userdocs] in a sidebar widget.
 * Version:           0.9
 * Author:            Ethan Allen
 * Author URI:        https://endif.media
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       userdocs
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-userdocs-activator.php
 */
function activate_userdocs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-userdocs-activator.php';
	Userdocs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-userdocs-deactivator.php
 */
function deactivate_userdocs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-userdocs-deactivator.php';
	Userdocs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_userdocs' );
register_deactivation_hook( __FILE__, 'deactivate_userdocs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-userdocs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_userdocs() {

	$plugin = new Userdocs();
	$plugin->run();

}
run_userdocs();
