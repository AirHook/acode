var FormValidation = function () {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-designer_add');
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
				view_status: {
					required: true
				},
				designer: {
					required: true
				},
				webspace_id: {
					required: true
				},
				designer_address1: {
					required: true
				},
				designer_phone: {
					required: true
				},
				designer_info_email: {
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
				var cont = $(element).parent('.input-group');
				if (cont.size() > 0) {
					cont.after(error);
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
				form.submit();
			}
		});
		
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
		
		// Main publish drop down options
		$('#view_status').change(function(){
			if ($('#view_status').selectpicker('val') == 'Y') {
				$('#where_active').show();
				$('.where_active').prop('checked', true);
				$('.view_status-suspended-notice').hide();
			} else {
				$('#where_active').hide();
				$('.view_status-suspended-notice').show();
			}
		});
		
		// check where active and reset status where necessary
		$('#where_active').on('change', '.checkboxes.where_active', function () {
			if ($('.checkboxes.where_active:checked').length == 0) {
				$('#view_status').selectpicker('val', 'N');
				$('#view_status').selectpicker('refresh');
				$('#where_active').hide();
			}
		});
		
		// Main publish drop down options
		$('#webspace_id').change(function(){
			var domain_name = $('#webspace_id').children("option:selected").text();
			$('input[name="webspace_domain_name"]').val(domain_name.trim());
		});
    }

    return {
        //main function to initiate the module
        init: function () {

            handleValidation1();

        }

    };

}();

jQuery(document).ready(function() {
	FormValidation.init();
});