var FormValidation = function () {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-webspace_edit');
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
				webspace_status: {
					required: true
				},
				webspace_name: {
					required: true
				},
				domain_name: {
					required: true
				},
				webspace_slug: {
					required: true
				},
				info_email: {
					required: true,
					email: true
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
				$('#loading .modal-title').html('Updating...');
				$('#loading').modal('show');
				form.submit();
				return false;
			}
		});
		
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    // basic validation
    var handleValidation2 = function() {
        // for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form2 = $('#form-webspace_account_add');
		var errro2 = $('.alert-danger', form2);
		var success2 = $('.alert-success', form2);

		form2.validate({
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
				account_status: {
					required: true
				},
				industry: {
					required: true
				},
				company_name: {
					required: true
				},
				owner_name: {
					required: true
				},
				owner_email: {
					required: true,
					email: true
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
				zip: {
					required: true
				},
				phone: {
					required: true
				},
				password: {
					required: true
				},
				passconf: {
					equalTo: "#password"
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit              
				success2.hide();
				errro2.show();
				App.scrollTo(errro2, -200);
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
				//success2.show();
				errro2.hide();
				$('#loading .modal-title').html('Submitting...');
				$('#loading').modal('show');
				form.submit();
				return false;
			}
		});
		
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form2).change(function () {
			form2.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    // basic validation
    var handleValidation3 = function() {
        // for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form3 = $('#form-webspace_account_link');
		var error3 = $('.alert-danger', form3);
		var success3 = $('.alert-success', form3);

		form3.validate({
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
				account_id: {
					required: true
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit              
				success3.hide();
				error3.show();
				App.scrollTo(error3, -200);
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
				//success3.show();
				error3.hide();
				$('#loading .modal-title').html('Updating...');
				$('#loading').modal('show');
				form.submit();
				return false;
			}
		});
		
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form3).change(function () {
			form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    var scriptFunctions = function () {
		
		// site type drop down actions
		$('#site_type').change(function(){
			if ($('#site_type').selectpicker('val') == 'sat_site') {
				$('#hub_site_list').show();
				$('#primary_designer_list').hide();
			} else if ($('#site_type').selectpicker('val') == 'hub_site') {
				$('#hub_site_list').hide();
				$('#primary_designer_list').show();
			} else {
				$('#hub_site_list').hide();
				$('#primary_designer_list').hide();
			}
		});
		
		//autofill webspace slug from domain name
		$('#domain_name').keyup(function(){
			text = this.value;
			text = text.replace('-', '');
			text = text.replace('_', '');
			if (text.search(/\./) == -1) {
				$('#webspace_slug').val(text);
			} else {
				text = text.split('.');
				if (text.length > 0) text.pop();
				$('#webspace_slug').val(text);
			}
		});
		$('#domain_name').blur(function(){
			text = this.value;
			text = text.replace('-', '');
			text = text.replace('_', '');
			if (text.search(/\./) == -1) {
				$('#webspace_slug').val(text);
			} else {
				text = text.split('.');
				if (text.length > 0) text.pop();
				$('#webspace_slug').val(text);
			}
		});
	}
	
    return {
        //main function to initiate the module
        init: function () {

            handleValidation1();
			handleValidation2();
			handleValidation3();
			scriptFunctions();
        }

    };

}();

if (App.isAngularJsApp() === false) { 
	jQuery(document).ready(function() {
		FormValidation.init();
	});
}