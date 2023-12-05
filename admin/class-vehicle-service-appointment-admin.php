<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://torque360.co
 * @since      1.0.0
 *
 * @package    Vehicle_Service_Appointment
 * @subpackage Vehicle_Service_Appointment/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vehicle_Service_Appointment
 * @subpackage Vehicle_Service_Appointment/admin
 * @author     Torque360 <info@torque360.co>
 */
class Vehicle_Service_Appointment_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vehicle-service-appointment-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vehicle-service-appointment-admin.js', array( 'jquery' ), $this->version, false );


	}
	/**
	 * Add options page.
	 *
	 * @since 1.0.0
	 */
	public function torque_menu() {
		// This page will be under "Settings".
		add_menu_page(
			'',
			'Torque360',
			'manage_options',
			'torque-services',
			array( $this, 'torque_general_settings' ),
			'dashicons-welcome-widgets-menus',
			56
		);
		add_submenu_page(
			'torque-services',
			'Service Appointment',
			'Services',
			'manage_options',
			'torque-services',
			array( $this, 'torque_general_settings' ),
			1
		);
		add_submenu_page(
			'torque-services',
			'Torque API - Settings',
			'API Settings',
			'manage_options',
			'torque-api',
			array( $this, 'torque_api_settings' ),
			2
		);
	}

	/**
	 * Register and add settings.
	 *
	 * @since 1.0.0
	 */
	public function torque_settings() {
		// START - services settings section.
		add_settings_section(
			'torque-services-section',
			'Setup Services',
			array( $this, 'torque_services_section_callback' ),
			'torque-services'
		);

		add_settings_field(
			'torque_vehicle_services',
			'',
			array( $this, 'services_input_callback' ),
			'torque-services',
			'torque-services-section'
		);

		register_setting(
			'torque-services-group',
			'torque_vehicle_services',
			array(
				'type' => 'array',
				'sanitize_callback' => array( $this, 'services_process_callback' )
			)
		);
		// END - services setting section.
		// START - api settings section.
		add_settings_section(
			'torque-api-section',
			'Setup API Key',
			array( $this, 'torque_api_section_callback' ),
			'torque-api'
		);

		add_settings_field(
			'torque_api_key',
			'API Key',
			array( $this, 'api_input_callback' ),
			'torque-api',
			'torque-api-section'
		);

		register_setting(
			'torque-api-group',
			'torque_api_key',
			array(
				'type' => 'array',
				'sanitize_callback' => array( $this, 'api_process_callback' )
			)
		);
		// END - api setting section.
	}
	
	/**
	 * Print the Section text.
	 *
	 * @since 1.0.0
	 */
	public function services_process_callback( $input ) {
		return array_map('array_filter', $input);
	}
	
	/**
	 * Print the Section text.
	 *
	 * @since 1.0.0
	 */
	public function torque_services_section_callback() {
		echo '<hr/>';
	}
	
	/**
	 * Print the Section text.
	 *
	 * @since 1.0.0
	 */
	public function api_process_callback( $input ) {
		return $input;
	}
	
	/**
	 * Print the Section text.
	 *
	 * @since 1.0.0
	 */
	public function torque_api_section_callback() {
		echo '<hr/>';
	}

	/**
	 * Callback for settings input field.
	 *
	 * @param array $args args.
	 * @since 1.0.0
	 */
	public static function services_input_callback( $args ) {
		$values_array = get_option( 'torque_vehicle_services', '' );
		$addRemoveBtn = '<a href="javascript:;" class="button button-primary" id="addRow">Add Another</a>';
		if(is_array($values_array)):
			foreach($values_array['title'] as $key => $value):
				$addRemoveBtn = "";

				if(sizeof($values_array['title'])-1 == $key){
					$addRemoveBtn = '<a href="javascript:;" class="button button-primary" id="addRow">Add Another</a>';
				}else{
					$addRemoveBtn = '<a href="javascript:;" class="button button-primary" id="removeRow">Remove</a>';
				}

				printf( '<tr><td><label>Service Title</label><input type="text" name="torque_vehicle_services[title][]" value="%s" /></td><td><label>Service Price</label><input type="text" name="torque_vehicle_services[price][]" value="%s" /></td><td>%s</td></tr>', $values_array['title'][$key], $values_array['price'][$key], $addRemoveBtn);
			endforeach;
		else:
			printf( '<tr><td><label>Service Title</label><input type="text" name="torque_vehicle_services[title][]" value="" /></td><td><label>Service Price</label><input type="text" name="torque_vehicle_services[price][]" value="" /></td><td>%s</td></tr>', $addRemoveBtn);
			
		endif;
	}
	
	/**
	 * Callback for settings input field.
	 *
	 * @param array $args args.
	 * @since 1.0.0
	 */
	public static function api_input_callback( $args ) {
		$api_key = get_option( 'torque_api_key', '' );
		printf( '<input type="text" style="width:%s;" name="torque_api_key" value="%s">', '33%', $api_key );
	}

	/**
	 * Options page callback - Torque General Settings.
	 *
	 * @since 1.0.0
	 */
	public function torque_general_settings() {
		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'torque-services', 'torque-services-notice', esc_html__( 'Services has been updated successfully.', 'vehicle-service-appointment' ), 'updated' );
		}
		settings_errors( 'torque-services' );

		$this->options = get_option( 'torque_settings' );
		
		printf( '<div class="wrap torque-services"><form method="post" action="options.php">' );
		settings_fields( 'torque-services-group' );
		do_settings_sections( 'torque-services' );
		submit_button();
		printf( '</form></div>' );
		
	}

	/**
	 * Options page callback - Torque API Settings.
	 *
	 * @since 1.0.0
	 */
	public function torque_api_settings() {
		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'torque-api', 'torque-api-notice', esc_html__( 'API Key has been updated successfully.', 'vehicle-service-appointment' ), 'updated' );
		}
		settings_errors( 'torque-api' );

		$this->options = get_option( 'torque_settings' );
		
		printf( '<div class="wrap torque-api"><form method="post" action="options.php">' );
		settings_fields( 'torque-api-group' );
		do_settings_sections( 'torque-api' );
		submit_button();
		printf( '</form></div>' );
		
	}

	/**
	 * Process Appointment Booking.
	 *
	 * @since 1.0.0
	 */
	public function process_appointment() {
		check_ajax_referer( 'torque360-service-appointment', 'nonce' );

		$data = filter_input(INPUT_POST, 'data', FILTER_DEFAULT, FILTER_FORCE_ARRAY);
		$start = date( 'Y-m-d H:00', strtotime( $data['date'].' '.$data['time'] ) );
		$end = date( 'Y-m-d H:00', strtotime( '+1 hour', strtotime( $start ) ) );
	
		$api_key = get_option( 'torque_api_key', '' );
		if( !empty( $data['customer_id'] ) && !empty( $data['vehicle_id'] ) ){
			$args = array( 
				'headers' => array(
					'Accept'=>'application/json',
					'Content-Type'=>'application/json',
					'x-api-key'=> $api_key
				),
				'body' => wp_json_encode( array(
					'customerId'=>$data['customer_id'],
					'vehicleId'=>$data['vehicle_id'],
					'start'=>$start,
					'end'=>$end,
					'serviceDetails'=>$data['services'],
				) ),
				'data_format' => 'body'
			);
			$request = wp_remote_post( 'https://appointment.torque360.co/api/appointment', $args );
			wp_send_json_success( wp_remote_retrieve_body( $request ), 200 );
		}else{
			$body_array = array(
				'customerBody' => array(
					'name' => $data['name'],
					'email' => $data['email'],
					'phone' => $data['phone'],
					'address' => $data['address']
				 ),
				 'vehicleBody' => array(
					'modelYear' => $data['model_year'],
					'vehicleMake' => $data['vehicle_make'],
					'vehicleModel' => $data['vehicle_model'],
					'licensePlate' => $data['license_plate'],
					'displacement' =>  $data['engine_size'],
					'engineDisplacementType' =>  'Liters',
					'color' =>  $data['color']
				 )
				);
			$args = array( 
				'headers' => array(
					'Accept'=>'application/json',
					'Content-Type'=>'application/json',
					'x-api-key'=> $api_key
				),
				'body' => wp_json_encode( $body_array ),
				'data_format' => 'body'
			);

			$request1 = wp_remote_post( 'https://appointment.torque360.co/api/customer', $args );
			$response1 = json_decode( wp_remote_retrieve_body( $request1 ) );

			if($response1->status == 1){
				$args = array( 
					'headers' => array(
						'Accept'=>'application/json',
						'Content-Type'=>'application/json',
						'x-api-key'=> $api_key
					),
					'body' => wp_json_encode( array(
						'customerId' => $response1->data->customerData->id,
						'vehicleId' => $response1->data->vehicleData->id,
						'start' => $start,
						'end' => $end,
						'serviceDetails' => $data['services'],
					) ),
					'data_format' => 'body'
				);
				$request = wp_remote_post( 'https://appointment.torque360.co/api/appointment', $args );
				wp_send_json_success( wp_remote_retrieve_body( $request ), 200 );
			}else{
				wp_send_json_error( $response1->message );
			}
			
			wp_send_json_success( wp_remote_retrieve_body( $request ), 200 );
		}

		wp_send_json_error( 'No useful information received!' );
	}
}
