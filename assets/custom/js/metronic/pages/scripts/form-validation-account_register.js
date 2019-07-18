var FormValidation = function () {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-register_consumer');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input
			
			// set your custom error message here
			messages: {
				passconf: {
					equalTo: "Password do not match"
				}
			},
			
			
			rules: {
				firstname: {
					required: true
				},
				lastname: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				password: {
					required: true
				},
				passconf: {
					equalTo: "#password"
				},
				address1: {
					required: true
				},
				city: {
					required: true
				},
				zip_postcode: {
					required: true
				},
				country: {
					required: true
				},
				state_province: {
					required: true
				},
				telephone: {
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
				return false;
			}
		});
		
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    // basic validation
    var handleValidation2 = function() {
        // for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-register_wholesale');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input
			
			// set your custom error message here
			messages: {
				confpassword: {
					equalTo: "Password do not match"
				}
			},
			
			rules: {
				store_name: {
					required: true
				},
				firstname: {
					required: true
				},
				lastname: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				pword: {
					required: true
				},
				confpassword: {
					equalTo: "#pword"
				},
				address1: {
					required: true
				},
				city: {
					required: true
				},
				zip_postcode: {
					required: true
				},
				country: {
					required: true
				},
				state: {
					required: true
				},
				telephone: {
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
				return false;
			}
		});
		
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

	// other components
    var handleScripts = function() {
		
		// radio user type select
		$('[name="user_type_radio"]').change(function(){
			var user_type = $(this).val();
			$('[name="user_type"]').val(user_type);
			$('.form-register').slideUp();
			$('.form-'+user_type).slideDown();
		});
	}
	
    return {
        //main function to initiate the module
        init: function () {

            handleValidation1();
            handleValidation2();
            handleScripts();

        }

    };

}();

jQuery(document).ready(function() {
    FormValidation.init();
});