var ComponentsEditors = function () {

    var base_url = $('body').data('base_url');
    var object_data = $('body').data('object_data');

    var handleScripts = function () {

        // handle edit qty
        $('[name="ws_payment_options"]').on('change', function(){
            var val = $(this).val();
            if (val == 'pp') {
                // uncheck others
                $('[name="ws_payment_options"]').prop('disabled', false);
                if ($('[value="cc"]').is(':checked')){
                    $('[value="cc"]').prop('checked', false);
                    $('.cc-info').slideUp();
                    $('.cc-notice').fadeIn();
                }
                $('[value="wt"]').prop('checked', false);
                // show modal
                $('#modal-paypal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#modal-paypal').modal('show');
            };
            if (val == 'cc') {
                // uncheck others
                $('[name="ws_payment_options"]').prop('disabled', false);
                $('[value="pp"]').prop('checked', false);
                $('[value="wt"]').prop('checked', false);
                // show form
                if ($(this).is(':checked')) {
                    $('.cc-info').slideDown();
                    $('.cc-notice').fadeOut();
                } else {
                    $('.cc-info').slideUp();
                    $('.cc-notice').fadeIn();
                }
            };
            if (val == 'wt') {
                // uncheck others
                $('[name="ws_payment_options"]').prop('disabled', false);
                $('[value="pp"]').prop('checked', false);
                if ($('[value="cc"]').is(':checked')){
                    $('[value="cc"]').prop('checked', false);
                    $('.cc-info').slideUp();
                    $('.cc-notice').fadeIn();
                }
                // show modal
                $('#modal-wire_transfer').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#modal-wire_transfer').modal('show');
            };
        });

    }

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-credit_card_info');
		var error1 = $('#form-credit_card_info .alert-danger');
		var success1 = $('#form-credit_card_info .alert-success');

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input

			// set your custom error message here
            /*
			messages: {
				'email[]': 'Please select at least 1 email.'
			},
            */

			rules: {
                creditCardType: {
					required: true
				},
				creditCardNumber: {
					required: true
				},
				creditCardExpirationMonth: {
					required: true
				},
				creditCardExpirationYear: {
					required: true
				},
				creditCardSecurityCode: {
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

                $('#loading').modal('show');

				//success1.show();
				error1.hide();
                form.submit();

			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me, .bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    return {
        //main function to initiate the module
        init: function () {
            handleScripts();
            handleValidation1();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
