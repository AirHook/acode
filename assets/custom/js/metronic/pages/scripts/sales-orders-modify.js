var ComponentsEditors = function () {

    var base_url = $('body').data('base_url');
    var object_data = $('body').data('object_data');

    var handleSummernote = function () {
        $('#summernote_1').summernote({
			height: 150,
			toolbar: [
				// [groupName, [list of button]]
				['main', ['style']],
				['style', ['bold', 'italic', 'underline', 'clear']],
				['para', ['ul', 'ol', 'paragraph']],
				['link', ['link']]
			]
		});
    }

    var handleScripts = function () {

        // handle edit qty
        $('[href="#modal-edit_quantity"]').on('click', function(){
            var item_id = $(this).data('item_id');
            var prod_no = $(this).data('prod_no');
            var qty = $(this).siblings('span').html();
            $('[name="order_log_detail_id"]').val(item_id);
            $('.eiq-modal-item').html('Item: '+prod_no);
            $('[name="qty"]').val(qty.trim());
        });

        // handle edit discount
        $('[href="#modal-edit_discount"]').on('click', function(){
            var item_id = $(this).data('item_id');
            var prod_no = $(this).data('prod_no');
            var unit_price = $(this).data('unit_price');
            var orig_price = $(this).data('orig_price');
            $('[name="order_log_detail_id"]').val(item_id);
            $('.edp-modal-item').html('Item: '+prod_no);
            $('[name="unit_price"]').val(unit_price);
        });

        // handle remove item
        $('[href="#modal-remove_item"]').on('click', function(){
            var item_id = $(this).data('item_id');
            $('[name="order_log_detail_id"]').val(item_id);
        });
    }

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-edit_store_details');
		var error1 = $('#form-edit_store_details .alert-danger');
		var success1 = $('#form-edit_store_details .alert-success');

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: ":not(:visible),:disabled",  // validate all fields including form hidden input

			// set your custom error message here
            /*
			messages: {
				'email[]': 'Please select at least 1 email.'
			},
            */

			rules: {
                email: {
					required: true,
					email: true
				},
				firstname: {
					required: true
				},
				lastname: {
					required: true
				},
				store_name: {
					required: true
				},
				telephone: {
					required: true
				},
				address1: {
					required: true
				},
				city: {
					required: true
				},
				state: {
					required: true
				},
				country: {
					required: true
				},
				zipcode: {
					required: true
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit
				success1.hide();
				error1.show();
				App.scrollTo(error1, -200);
			},

			errorPlacement: function (error, element) { // render error placement for each input type
				var cont = $(element).parent('.input-group');
				if (cont.size() > 0) {
					cont.after(error);
                } else if (element.attr("data-error-container")) {
                    error.appendTo('#'+element.attr("data-error-container"));
				} else {
					element.after(error);
				}
				Ladda.stopAll(); // stop ladda
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
                form.submit();

			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    var handleValidation2 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form2 = $('#form-edit_ship_to');
		var error2 = $('#form-edit_ship_to .alert-danger');
		var success2 = $('#form-edit_ship_to .alert-success');

		form2.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: ":not(:visible),:disabled",  // validate all fields including form hidden input

			// set your custom error message here
            /*
			messages: {
				'email[]': 'Please select at least 1 email.'
			},
            */

			rules: {
				firstname: {
					required: true
				},
				lastname: {
					required: true
				},
				telephone: {
					required: true
				},
				address1: {
					required: true
				},
				city: {
					required: true
				},
				state: {
					required: true
				},
				country: {
					required: true
				},
				zipcode: {
					required: true
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit
				success2.hide();
				error2.show();
				App.scrollTo(error2, -200);
			},

			errorPlacement: function (error, element) { // render error placement for each input type
				var cont = $(element).parent('.input-group');
				if (cont.size() > 0) {
					cont.after(error);
                } else if (element.attr("data-error-container")) {
                    error.appendTo('#'+element.attr("data-error-container"));
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

				//success2.show();
				error2.hide();
                form.submit();
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form2).change(function () {
			form2.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    var handleValidation3 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form3 = $('#form-edit_user_details');
		var error3 = $('#form-edit_user_details .alert-danger');
		var success3 = $('#form-edit_user_details .alert-success');

		form3.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // (:not(:visible),:disabled) validate all fields including form hidden input

			// set your custom error message here
            /* *
			messages: {
				'user_id': 'Please select store or enter manual info.',
                'ship_to': 'Please select "Ship To" options.',
			},
            // */

            rules: {
                email: {
					required: true,
					email: true
				},
				firstname: {
					required: true
				},
				lastname: {
					required: true
				},
				telephone: {
					required: true
				},
				address1: {
					required: true
				},
				city: {
					required: true
				},
				state_province: {
					required: true
				},
				country: {
					required: true
				},
				zip_postcode: {
					required: true
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit
				success3.hide();
				error3.show();
				App.scrollTo(error3, -200);
			},

			errorPlacement: function (error, element) { // render error placement for each input type
				var cont = $(element).parent('.input-group');
				if (cont.size() > 0) {
					cont.after(error);
                } else if (element.attr("data-error-container")) {
                    error.appendTo('#'+element.attr("data-error-container"));
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

				//success3.show();
                error3.hide();
                form.submit();
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form3).change(function () {
			form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    return {
        //main function to initiate the module
        init: function () {
            handleSummernote();
            handleScripts();
            handleValidation1();
            handleValidation2();
            handleValidation3();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
