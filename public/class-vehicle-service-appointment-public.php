<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://torque360.co
 * @since      1.0.0
 *
 * @package    Vehicle_Service_Appointment
 * @subpackage Vehicle_Service_Appointment/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Vehicle_Service_Appointment
 * @subpackage Vehicle_Service_Appointment/public
 * @author     Torque360 <info@torque360.co>
 */
class Vehicle_Service_Appointment_Public {

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

		add_shortcode('vehicle_appointment_form', array( $this, 'service_appointment_shortcode' ) );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vehicle_Service_Appointment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vehicle_Service_Appointment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vehicle-service-appointment-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'torque-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'torque-select2-css', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vehicle_Service_Appointment_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vehicle_Service_Appointment_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script( 'torque-select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'torque-mask', plugin_dir_url( __FILE__ ) . 'js/jquery.mask.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vehicle-service-appointment-public.js', array( 'jquery', 'jquery-ui-datepicker', 'torque-select2', 'torque-mask' ), $this->version, false );
		$ajax_data = array(
			'url' => admin_url( 'admin-ajax.php' ),
			'nonce' => wp_create_nonce( 'torque360-service-appointment' ),
		);
		wp_localize_script( 'jquery', 'ajax', $ajax_data );

	}

	public function service_appointment_shortcode() {
		ob_start();
		require plugin_dir_path( __FILE__ ) . 'partials/vehicle-service-appointment-public-display.php';
		return ob_get_clean();
	}
}
