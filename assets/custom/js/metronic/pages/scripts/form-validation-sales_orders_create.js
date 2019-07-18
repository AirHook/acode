var FormValidation = function () {

	var base_url = $('body').data('base_url');

    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
				format: "yyyy-mm-dd",
                autoclose: true
			});
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
		}

        /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */

        // Workaround to fix datepicker position on window scroll
		/*
        $( document ).scroll(function(){
            $('#form_modal2 .date-picker').datepicker('place'); //#modal is the id of the modal
        });
		*/
    }

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-sales_orders_create');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input

			// set your custom error message here
			//messages: {
			//	access_level: {
			//		valueNotEquals: "Please select an item"
			//	}
			//},

			rules: {
				po_number: {
					required: true
				},
				po_date: {
					required: true
				},
				des_id: {
					required: true
				},
				user_id: {
					required: true
				},
				delivery_date: {
					required: true
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit
				success1.hide();
				error1.show();
				App.scrollTo(error1, -200);
			},

			errorPlacement: function (error, element) { // render error placement for each input type
				var cont = $(element).parent('.input-group'); // input group
				var dd = $(element).parent('.btn-group.bs-select'); // bootstrap select
				if (cont.size() > 0) {
					cont.after(error);
				} else if (dd.size() > 0) {
					dd.after(error);
				} else {
					element.after(error);
				}
			},

			highlight: function (element) { // hightlight error inputs

				$(element)
					.closest('.form-group').addClass('has-error'); // set error class to the control group
			},

			unhighlight: function (element) { // revert the change done by hightlight
				$(element)
					.closest('.form-group').removeClass('has-error'); // set error class to the control group
			},

			success: function (label) {
				label
					.closest('.form-group').removeClass('has-error'); // set success class to the control group
			},

			submitHandler: function (form) {
				//success1.show();
				error1.hide();
				$('#loading .modal-title').html('Submitting...');
				$('#loading').modal('show');
				form.submit();
				//return false;
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
			if ($(this).find(':selected').data('d_url_structure')) {
				$('[name="designer_slug"]').val($(this).find(':selected').data('d_url_structure'));
			}
			if ($(this).find(':selected').data('store_name')) {
				$('[name="store_name"]').val($(this).find(':selected').data('store_name'));
				$('[name="email"]').val($(this).find(':selected').data('subtext'));
				$('.ci-store_name').html($(this).find(':selected').data('store_name'));
				$('.ci-customer_name').html($(this).find(':selected').data('customer_name'));
				$('[name="firstname"]').val($(this).find(':selected').data('firstname'));
				$('[name="lastname"]').val($(this).find(':selected').data('lastname'));
				$('.ci-email').html($(this).find(':selected').data('subtext'));
				$('.ci-telephone').html($(this).find(':selected').data('telephone'));
				$('[name="telephone"]').val($(this).find(':selected').data('telephone'));
				$('.ci-bill_to').html($(this).find(':selected').data('ship_bill_to'));
				$('.ci-ship_to').html($(this).find(':selected').data('ship_bill_to'));
				$('[name="bill_address1"]').val($(this).find(':selected').data('address1'));
				$('[name="bill_address2"]').val($(this).find(':selected').data('address2'));
				$('[name="bill_city"]').val($(this).find(':selected').data('city'));
				$('[name="bill_state"]').val($(this).find(':selected').data('state'));
				$('[name="bill_country"]').val($(this).find(':selected').data('country'));
				$('[name="bill_zipcode"]').val($(this).find(':selected').data('zipcode'));
				$('[name="ship_address1"]').val($(this).find(':selected').data('address1'));
				$('[name="ship_address2"]').val($(this).find(':selected').data('address2'));
				$('[name="ship_city"]').val($(this).find(':selected').data('city'));
				$('[name="ship_state"]').val($(this).find(':selected').data('state'));
				$('[name="ship_country"]').val($(this).find(':selected').data('country'));
				$('[name="ship_zipcode"]').val($(this).find(':selected').data('zipcode'));
			}
			if ($(this).find(':selected').data('admin_sales_user')) {
				$('[name="admin_sales_email"]').val($(this).find(':selected').data('subtext'));
				$('.si-admin_sales_user').html($(this).find(':selected').data('admin_sales_user'));
				$('.si-admin_sales_email').html($(this).find(':selected').data('subtext'));
			}
		});

		// suggestions to prod_no field using typehead
		// instantiate the bloodhound suggestion engine
		var custom2 = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				//url: base_url + 'search/suggestions/index/%QUERY',
				url: base_url + 'search/prod_no/index/%QUERY',
				wildcard: '%QUERY'
			}
		});
		// initiate typehead
		$('.search_prod_no').typeahead({
			hint: false,
			highlight: true
		},
		{
			name: 'search_prod_no',
			source: custom2,
			limit: 20
		});

		// form repeater (MY repeater)
		$('.my-repeater').each(function(){

			// set this function global variable
			var prod_no;

			// prod_no functions
			$(this).on('blur', '.form-control.prod_no', function(){
				var prod_exists = true;
				var single_prod = false;
				var row_el = $(this).closest('.my-repeater-row');
				prod_no = $(this).val();
				$('#loading').modal('show');
				$.ajax({
					type:    'GET',
					url:     base_url + "admin/sales_orders/get_thumb_price/index/" + prod_no,
					success: function(data) {
						if (data === 'false'){
							prod_exists = false;
							alert('Product does not exists!' + '\n' + 'Please try again...');
						}else{
							// get and show thumb and unit price
							if (typeof row_el !== "undefined") {
								if (data.thumb_icon != '') {
									// this only means product has single color variant
									row_el.find('.thumb-icon').attr('src', data.thumb_icon);
									row_el.find('input[name="image_url_path[]"]').val(data.thumb_icon);
									single_prod = true;
								}
								row_el.find('.unit_price').val(data.unit_price);
							}
							// recompute for ext price where necessary
							var qty = row_el.find('input.form-control.qty').val();
							var unit_price = row_el.find('input.form-control.unit_price').val();
							var ext_price = qty * unit_price;
							if (isNaN(ext_price) || ext_price == 0){
								row_el.find('input.form-control.ext_price').val('...');
							}
							else row_el.find('input.form-control.ext_price').val(ext_price);
							// recreate select color drop down
							$.ajax({
								type:    'GET',
								url:     base_url + "admin/sales_orders/get_available_colors/index/" + prod_no,
								success: function(data) {
									if (typeof row_el !== "undefined") {
										row_el.find('.color-select-actual').html(data);
										row_el.find('.color_code').selectpicker('refresh');
										row_el.find('.color-select-notification').hide();
										row_el.find('.color-select-actual').show();
									}
									if (single_prod) {
										var color_name = row_el.find('.form-control.color_code').find("option:selected").data('color_name');
										row_el.find('input[name="color_name[]"]').val(color_name);
									}

								},
								// vvv---- This is the new bit
								error:   function(jqXHR, textStatus, errorThrown) {
									//$('#loading').modal('hide');
									alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
									//$('#reloading').modal('show');
									//location.reload();
								}
							});
						}
						$('#loading').modal('hide');
						//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
					},
					// vvv---- This is the new bit
					error:   function(jqXHR, textStatus, errorThrown) {
						$('#loading').modal('hide');
						alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
						//$('#reloading').modal('show');
						//location.reload();
					}
				});
			});

			// select color function to change image thumb accordingly
			$(this).on('change', '.form-control.color_code', function(){
				var row_el = $(this).closest('.my-repeater-row');
				var color_code = $(this).val();
				$('#loading').modal('show');
				$.ajax({
					type:    'GET',
					url:     base_url + "admin/sales_orders/get_thumb_price/index/" + prod_no + "/" + color_code,
					success: function(data) {
						// get and show thumb and unit price
						if (typeof row_el !== "undefined") {
							if (data.thumb_icon != '') {
								row_el.find('.thumb-icon').attr('src', data.thumb_icon);
								row_el.find('input[name="image_url_path[]"]').val(data.thumb_icon);
								var color_name = row_el.find('.form-control.color_code').find("option:selected").data('color_name');
								row_el.find('input[name="color_name[]"]').val(color_name);
							}
						}
						$('#loading').modal('hide');
						//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
					},
					// vvv---- This is the new bit
					error:   function(jqXHR, textStatus, errorThrown) {
						$('#loading').modal('hide');
						alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
						//$('#reloading').modal('show');
						//location.reload();
					}
				});
			});

			// compute for extended price
			$(this).on('keyup change blur', '.form-control.qty', function(){
				var row_el = $(this).closest('.my-repeater-row');
				var qty = $(this).val();
				var unit_price = row_el.find('input.form-control.unit_price').val();
				var ext_price = qty * unit_price;
				if (isNaN(ext_price) || ext_price == 0){
					row_el.find('input.form-control.ext_price').val('...');
				}
				else row_el.find('input.form-control.ext_price').val(ext_price);
			});

			// add another row
			$('.my-repeater-add').click(function(){
				var myRepeater = $(this).closest('.my-repeater').children('.my-repeater-row:first-child');
				if (typeof myRepeater !== "undefined") {
					//var clone = myRepeater.clone(true);
					// let us destroy the bs-select on original element first
					myRepeater.find('.form-control.size').selectpicker('destroy');
					// clone row
					myRepeater.clone()
						.find('input:text').val('').end()
						.find('input.form-control.unit_price').val('100').end()
						.find('.thumb-icon').attr('src', 'https://www.shop7thavenue.com/assets/images/icons/shop7-emblem.jpg').end()
						.find('.color-select-actual').hide().end()
						.find('.color-select-notification').show().end()
						//.find('.form-control.size').selectpicker('destroy').end()
						.insertBefore(this)
						.hide()
						.slideDown();
				}
				// reinitialize bs-select
				$('.form-control.size').selectpicker();
				// initiate typehead for prod_no suggestions
				$('.search_prod_no').typeahead({
					hint: false,
					highlight: true
				},
				{
					name: 'search_prod_no',
					source: custom2,
					limit: 20
				});
			});

			// delete row and slideup
			$(this).on('click', '.my-repeater-delete', function(){
				if(confirm('Are you sure you want to delete this line?')) {
					$(this).closest('.my-repeater-row').slideUp();
				}
			});
		});

		// form repeater
		/*
			//retaining this mt-repeater code here for reference only
			//can be removed anytime
		$('.mt-repeater').each(function(){
			$(this).repeater({
				show: function () {
					$(this).slideDown();
					// initiate typehead
					$('.search_prod_no').typeahead({
						hint: false,
						highlight: true
					},
					{
						name: 'search_prod_no',
						source: custom2,
						limit: 20
					});
					// set select as selectpicker
					$(this).find('select').selectpicker();
					var color_name = $(this).find('.color_name');
					$(this).find('select').on('change', function(){
						if ($(this).find(':selected').data('color_name')) {
							color_name.val($(this).find(':selected').data('color_name'));
						}
					});
				},

				hide: function (deleteElement) {
					if(confirm('Are you sure you want to delete this element?')) {
						$(this).slideUp(deleteElement);
					}
				},

				ready: function (setIndexes) {

				}
			});
			$(this).find('select').selectpicker();
			var color_name = $(this).find('.color_name');
			$(this).find('select').on('change', function(){
				if ($(this).find(':selected').data('color_name')) {
					color_name.val($(this).find(':selected').data('color_name'));
				}
			});
		});
		*/
    }

	// clear all items button action for sales resource using
    // sales order list page
	$('.confirm-clear_all_items').click(function(){
		$('#modal-clear_all_items').modal('hide');
		$('#loading .modal-title').html('Clearing...');
		$('#loading').modal('show');
		// call the url using get method
		$.get(base_url + "sales/sales_package/clear_all_items.html");
		// reset items count inner html
		$('.items_count').html('0');
		// clear all summary items container
		// and replay default no items notification
		$('.summary-item-container').hide();
		$('.cart_basket_wrapper .row .no-items-notification > h4').show();
		$('.send-package-btn').hide();
		// in thumbs page...
		$('.thumb-tile').removeClass('selected');
		$('.package_items').prop('checked', false);
		// clear modal and end...
		$('#loading').modal('hide');
	});

	// sales resource pages
    // sales package sidebar nav actions
    $('.sidebar-nav-sales-package').on('click', function(){
        var items_count = $(this).closest('ul').data('items_count');
        var link = $(this).data('link');
        //alert(items_count);
        if (items_count != '0') {
            //$('#modal-items_on_cart .contiue-items_on_cart').attr('href', link);
            $('#modal-items_on_cart').modal('show');
            $('#modal-items_on_cart .continue-items_on_cart').click(function(){
                // continue means to clear items on cart
                $.get(base_url + "sales/sales_package/clear_all_items.html", function(data){
					// we need to wait for ajax call response before continuing
					// to alleviate session handling execution time error
					if (data == 'clear') window.location.href=link;
				});
            });
        } else {
            window.location.href=link;
        }
    });

	return {
        //main function to initiate the module
        init: function () {

			handleDatePickers();
            handleValidation1();
		}

    };

}();

if (App.isAngularJsApp() === false) {
	jQuery(document).ready(function() {
		FormValidation.init();
	});
}
