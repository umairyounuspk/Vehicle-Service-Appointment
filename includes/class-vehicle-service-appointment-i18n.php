<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://torque360.co
 * @since      1.0.0
 *
 * @package    Vehicle_Service_Appointment
 * @subpackage Vehicle_Service_Appointment/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Vehicle_Service_Appointment
 * @subpackage Vehicle_Service_Appointment/includes
 * @author     Torque360 <info@torque360.co>
 */
class Vehicle_Service_Appointment_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'vehicle-service-appointment',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
