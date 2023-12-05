<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://torque360.co
 * @since             1.0.0
 * @package           Vehicle_Service_Appointment
 *
 * @wordpress-plugin
 * Plugin Name:       Vehicle Service Appointment
 * Plugin URI:        https://torque360.co
 * Description:       Vehicle Service Appointment Management for Torque360 Software.
 * Version:           1.0.0
 * Author:            Torque360
 * Author URI:        https://torque360.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vehicle-service-appointment
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
define( 'VEHICLE_SERVICE_APPOINTMENT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vehicle-service-appointment-activator.php
 */
function activate_vehicle_service_appointment() {
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vehicle-service-appointment-deactivator.php
 */
function deactivate_vehicle_service_appointment() {
}

register_activation_hook( __FILE__, 'activate_vehicle_service_appointment' );
register_deactivation_hook( __FILE__, 'deactivate_vehicle_service_appointment' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vehicle-service-appointment.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vehicle_service_appointment() {

	$plugin = new Vehicle_Service_Appointment();
	$plugin->run();

}
run_vehicle_service_appointment();
