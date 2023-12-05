(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	$(document).ready(function() {

		var response_element = $("#torque-api-response");
		var vehicle_select = $("#select-vehicle");
		var search_query_select = $('.select-search-by');
		$('#torque-phone').mask('(000) 000-0000');

		if(vehicle_select.length){
			changeVehicle(vehicle_select.val());
			vehicle_select.change(function() {
				changeVehicle($(this).val());
			});
		}

		if(response_element.length){
			$('html, body').animate({
			    scrollTop: response_element.offset().top-100
			}, 1000);
		}
		
		$('#torque-datepicker').datepicker();
		$('#torque-multiselect').select2();

		changeSearchBy($('input[name="search_query"]'));
		search_query_select.change(function() {
			changeSearchBy($('input[name="search_query"]'));
		});

		$('.torque-btn').click(function() {
			if($(this).hasClass('next')){

				$('.torque-card p.customer-name').html( $("#torque-name").val() );
				$('.torque-card p.customer-mobile').html( "Mobile: " + $("#torque-phone").val() );

				$('.torque-card p.customer-car-model').html( $('#model-year').val() + " " + $('#vehicle-make').val()  + " " + $('#vehicle-model').val() );
				$('.torque-card p.customer-license-plate').html( "License Plate: " + $('#license-plate').val() );

				$('.torque-step1, .torque-btn.next').hide();
				$('.torque-step2, .torque-btn.back, .torque-btn.book').show();

			}else if($(this).hasClass('back')){

				$('.torque-step1, .torque-btn.next').show();
				$('.torque-step2, .torque-btn.back, .torque-btn.book').hide();

			}else if($(this).hasClass('book')){
				var data = convertFormToJSON($('#appointment-form-torque360'));
				data.services = $('#torque-multiselect').select2("val").join();
				$.post(ajax.url, {
					'action': 'process_appointment',
					'data': data,
					'nonce': ajax.nonce
				}, function(response){
					console.log(response);
				});
			}
		});
	});

	function changeVehicle(key) {
		$('#vehicle-id').val(customer_vehicles[key].id);
		$('#vehicle-make').val(customer_vehicles[key].vehicleMake);
		$('#vehicle-model').val(customer_vehicles[key].vehicleModel);
		$('#model-year').val(customer_vehicles[key].modelYear);
		$('#engine-size').val(customer_vehicles[key].displacement);
		$('#license-plate').val(customer_vehicles[key].licensePlate);
		$('#vehicle-color').val(customer_vehicles[key].color);

		$('.torque-card p.customer-car-model').html( customer_vehicles[key].modelYear + " " + customer_vehicles[key].vehicleMake  + " " + customer_vehicles[key].vehicleModel );
		$('.torque-card p.customer-license-plate').html( "License Plate: " + customer_vehicles[key].licensePlate );
	}

	function changeSearchBy($elm) {
		console.log($val);
		if($elm.val() == "phone"){
			$elm.val('').attr('placeholder', 'Enter Phone Number').mask('(000) 000-0000');
		}
		else if($elm.val() == "email"){
			$elm.val('').attr('placeholder', 'Enter Your Email').unmask();
		}
	}

	function convertFormToJSON(form) {
		return form
		  .serializeArray()
		  .reduce(function (json, { name, value }) {
			json[name] = value;
			return json;
		}, {});
	}
})( jQuery );
