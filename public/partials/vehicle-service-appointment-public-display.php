<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://torque360.co
 * @since      1.0.0
 *
 * @package    Vehicle_Service_Appointment
 * @subpackage Vehicle_Service_Appointment/public/partials
 */
    $api_key = get_option( 'torque_api_key', '' );
    $customer_search = filter_input( INPUT_POST, 'customer-search', FILTER_SANITIZE_STRING );
	$search_query = filter_input( INPUT_POST, 'search_query', FILTER_SANITIZE_STRING );
	$search_by = filter_input( INPUT_POST, 'search_by', FILTER_SANITIZE_STRING );

	$name = filter_input( INPUT_POST, 'name', FILTER_SANITIZE_STRING );
	$phone = filter_input( INPUT_POST, 'phone', FILTER_SANITIZE_STRING );
	$email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_STRING );
	$address = filter_input( INPUT_POST, 'address', FILTER_SANITIZE_STRING );
	
	$msg = $response = $customer_vehicles = $customer_id = "";
	if( !empty( $search_query ) ){
		$args = array( 
			'headers'=>array(
				'Accept'=>'application/json',
				'x-api-key'=> $api_key
				)
		);
		// 14325436546
		// test@test.com
		$request = wp_remote_get( 'https://appointment.torque360.co/api/customer/search?searchQuery='.$search_query.'&type='.$search_by, $args );			
		// var_export( is_wp_error( $request ) ); // hit success
		$response = json_decode( wp_remote_retrieve_body( $request) );
		echo "<pre>";
		var_export($response); //6546
		echo "</pre>";

		if( isset( $response->data[0] ) && is_object( $customer_data = $response->data[0] ) ){
			$customer_id = $customer_data->id;
			$name = $customer_data->name;
			$phone = $customer_data->phone;
			$email = $customer_data->email;
			$address = $customer_data->address;
			$customer_vehicles = $customer_data->vehicles;
			wp_localize_script( 'jquery', 'customer_vehicles', $customer_vehicles );
		}
	}
	
	$icon_url = plugins_url( 'img/camicon.png', __FILE__ );
?>
<div id="service-appointment-torque360">
<!-- <div class="loader"></div> -->
	<form action="" method="post" class="search-block">
		<select name="search_by" class="select-search-by">
			<option value="phone" <?=($search_by == "phone")?'selected':''?>>Phone Number</option>
			<option value="email" <?=($search_by == "email")?'selected':''?>>Email</option>
		</select>
		<input type="text" name="search_query" placeholder="Enter Phone Number" value="<?=$search_query?>" required>
		<input type="submit" name="customer-search" value="Search">
	</form>
<?php
    if( is_object( $response ) ){
        echo '<p id="torque-api-response">'.$response->message.'</p>';
    }
?>
	<form action="" method="post" id="appointment-form-torque360">
		<div class="torque-step1">
			<div class="customer-info">
				<div class="input-group">
					<label for="torque-name">Name</label>
					<input type="hidden" name="customer_id" placeholder="Enter Name" value="<?=$customer_id?>">
					<input type="text" id="torque-name" name="name" placeholder="Enter Name" value="<?=$name?>">
				</div>
				<div class="input-group">
					<label for="torque-phone">Phone Number</label>
					<input type="text" id="torque-phone" name="phone" placeholder="Enter Phone Number" value="<?=$phone?>">
				</div>
				<div class="input-group">
					<label for="torque-email">Email Address</label>
					<input type="email" id="torque-email" name="email" placeholder="Enter Email Address" value="<?=$email?>">
				</div>
				<div class="input-group">
					<label for="torque-address">Address</label>
					<input type="text" id="torque-address" name="address" placeholder="Enter Address" value="<?=$address?>">
				</div>
			</div>
			<div class="vehicle-selector input-group">
			<?php
    			if( is_array( $customer_vehicles ) && !empty( $customer_vehicles ) ){
					printf( '<label for="select-vehicle">Select Vehicle</label>' );
					printf( '<select name="select-vehicle" id="select-vehicle" class="select-dropdown">' );
					foreach ($customer_vehicles as $key => $customer_vehicle) {
						printf( '<option value="%s">%s %s %s %s</option>', $key, $customer_vehicle->modelYear, $customer_vehicle->vehicleMake, $customer_vehicle->vehicleModel, $customer_vehicle->licensePlate);
					}
					printf( '</select>' );
				}
			?>
			</div>
			<div class="vehicle-info">
				<div class="input-group">
					<label for="vehicle-make">Vehicle Make</label>
					<input type="hidden" id="vehicle-id" name="vehicle_id">
					<input type="text" id="vehicle-make" name="vehicle_make" placeholder="Enter Vehicle Make">
				</div>
				<div class="input-group">
					<label for="vehicle-model">Vehicle Model</label>
					<input type="text" id="vehicle-model" name="vehicle_model" placeholder="Enter Vehicle Model">
				</div>
				<div class="input-group">
					<label for="model-year">Model Year</label>
					<input type="text" id="model-year" name="model_year" placeholder="Enter Vehicle Year">
				</div>
				<div class="input-group">
					<label for="engine-size">Engine Size</label>
					<input type="text" id="engine-size" name="engine_size" placeholder="Enter Vehicle Engine Size">
				</div>
				<div class="input-group">
					<label for="license-plate">License Plate</label>
					<input type="text" id="license-plate" name="license_plate" placeholder="Enter Model License Plate">
				</div>
				<div class="input-group">
					<label for="vehicle-color">Color</label>
					<input type="text" id="vehicle-color" name="color" placeholder="Enter Vehicle Color">
				</div>
			</div>
		</div>

		<div class="torque-step2" style="display:none;">
		    <div class="torque-cards-container">
		    	<div class="torque-card">
		    		<img src="<?=$icon_url?>" >
		    		<div class="content">
		    			<p class="customer-name"></p>
		    			<p class="customer-mobile"></p>
		    		</div>
		    	</div>
		    	<div class="torque-card">
		    		<img src="<?=$icon_url?>">
		    		<div class="content">
		    			<p class="customer-car-model"></p>
		    			<p class="customer-license-plate"></p>
		    		</div>
		    	</div>
		    </div>
					
			<div class="input-group">
				<label for="torque-multiselect">Service Request Details</label>
				<select id="torque-multiselect" name="services" multiple="multiple">
					<?php
                        $services_array = get_option( 'torque_vehicle_services', '' );
                        if(is_array($services_array)){
                            foreach($services_array['title'] as $key => $value)
                                printf( '<option value="%s">%s</option>', $value, $value);
                        }
                    ?>
				</select>
			</div>
					
			<div class="torque-date-time-container">
				<div class="date-input-group">
				<label for="torque-datepicker">Select Date</label>
					<input type="text" id="torque-datepicker" name="date" value="">
				</div>
				<div class="input-group">
					<label for="option-1">Available Slots</label>
					<div class="radio-group">
						<input type="radio" id="option-1" name="time" value="9:00">
						<label for="option-1">9:00 AM</label>
						<input type="radio" id="option-2" name="time" value="10:00">
						<label for="option-2">10:00 AM</label>
					</div>
					<div class="radio-group">
						<input type="radio" id="option-3" name="time" value="11:00">
						<label for="option-3">11:00 PM</label>
						<input type="radio" id="option-4" name="time" value="12:00">
						<label for="option-4">12:00 PM</label>
					</div>
					<div class="radio-group">
						<input type="radio" id="option-5" name="time"  value="13:00" checked>
						<label for="option-5">1:00 PM</label>
						<input type="radio" id="option-6" name="time" value="14:00">
						<label for="option-6">2:00 PM</label>
					</div>
					<div class="radio-group">
						<input type="radio" id="option-7" name="time" value="15:00">
						<label for="option-7">3:00 PM</label>
						<input type="radio" id="option-8" name="time" value="16:00">
						<label for="option-8">4:00 PM</label>
					</div>
					<div class="radio-group">
						<input type="radio" id="option-9" name="time" value="17:00">
						<label for="option-9">5:00 PM</label>
						<input type="radio" id="option-10" name="time" value="18:00">
						<label for="option-10">6:00 PM</label>
					</div>
				</div>	
			</div>
	    </div>
    </form>
	<div class="control-block">
		<a href="javascript:;" class="torque-btn back" style="display:none;">Back</a>
		<a href="javascript:;" class="torque-btn book" style="display:none;">Book Appointment</a>
		<a href="javascript:;" class="torque-btn next">Next</a>
	</div>
</div>