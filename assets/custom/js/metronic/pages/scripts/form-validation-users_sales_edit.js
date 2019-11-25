var FormValidation = function () {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-users_sales_edit');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: ":not(:visible),:disabled",  // validate all fields including form hidden input

			rules: {
				is_active: {
					required: true
				},
                admin_sales_designer: {
					required: true
				},
				admin_sales_email: {
					required: true,
					email: true
				},
				access_level: {
					required: true,
				},
				passconf: {
					equalTo: "#admin_sales_password"
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

        //show password click function
        $('.show-password').click(function(){
            var checked = $(this).is(':checked');
            if (checked) {
                $('.input-password, .input-passconf').attr('type', 'text');
            } else {
                $('.input-password, .input-passconf').attr('type', 'password');
            }
        });

        //change password click function
        $('.change-password').click(function(){
            var checked = $(this).is(':checked');
            if (checked) {
                $('.hide-password').show();
                $('.input-password, .input-passconf').removeAttr('disabled');
            } else {
                $('.hide-password').hide();
                $('.input-password, .input-passconf').addAttr('disabled');
            }
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
