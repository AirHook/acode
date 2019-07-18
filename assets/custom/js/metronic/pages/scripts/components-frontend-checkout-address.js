var ComponentsScripts = function() {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-checkout_address');
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
				b_email: {
					required: true,
					email: true
				},
				b_firstname: {
					required: true
				},
				b_lastname: {
					required: true
				},
				b_phone: {
					required: true
				},
				b_country: {
					required: true
				},
				b_address1: {
					required: true
				},
				b_city: {
					required: true
				},
				b_state: {
					required: true
				},
				b_zip: {
					required: true
				},
				agree_to_policy: {
					required: true
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit
				success1.hide();
				error1.show();
				App.scrollTo(error1, -200);
			},

			errorPlacement: function (error, element) { // render error placement for each input type
                if (element.is(':checkbox')) {
                    error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .mt-checkbox-outline, .checkbox-list, .checkbox-inline"));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .md-radio-outline, .radio-list, .radio-inline"));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
                /*
				var cont = $(element).parent('.input-group');
				if (cont.size() > 0) {
					cont.after(error);
				} else {
					element.after(error);
				}
                */
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
				return false;
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me, bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});

		$('[name="same_shipping_address"]').click(function(){
			if ($(this).is(":checked")){
				$('.checkout-shipping-address').hide();
				$('.checkout-billing-addres').removeClass('col-sm-4').addClass('col-sm-8');
			}else{
				$('.checkout-billing-addres').removeClass('col-sm-8').addClass('col-sm-4');
				$('.checkout-shipping-address').show();
			}
		});

        $('[name="b_country"], [name="sh_country"]').on('change', function(){
			var type = $(this).data('bsh-type');
			var val = $(this).selectpicker('val');
			if (val == 'United States') {
				$('select[name="'+type+'state"]').selectpicker('val', '');
				$('select[name="'+type+'state"]').selectpicker('render');
			} else {
				$('select[name="'+type+'state"]').selectpicker('val', 'Other');
				$('select[name="'+type+'state"]').selectpicker('render');
			}
			$('[name="ny_tax"]').val('');
			$('#add-tax').html('TBD');
        });

        $('[name="b_state"], [name="sh_state"]').on('change', function(){
			var val = $(this).selectpicker('val');
			if (val == 'New York') {
				$('[name="ny_tax"]').val('1');
			}else{
				$('[name="ny_tax"]').val('');
			}
        });
    }

    var handleScripts1 = function() {

    }

    return {
        //main function to initiate the module
        init: function() {
            handleValidation1();
            //handleScripts1();
        }
    };

}();

jQuery(document).ready(function() {
    ComponentsScripts.init();
});
