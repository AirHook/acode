var ComponentsScripts = function() {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-checkout_delivery');
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
				shipmethod: {
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
                    if (element.parents('.mt-radio-list').size() > 0 || element.parents('.mt-checkbox-list').size() > 0) {
                        if (element.parents('.mt-radio-list').size() > 0) {
                            error.appendTo(element.parents('.mt-radio-list')[0]);
                        }
                        if (element.parents('.mt-checkbox-list').size() > 0) {
                            error.appendTo(element.parents('.mt-checkbox-list')[0]);
                        }
                    } else if (element.parents('.mt-radio-inline').size() > 0 || element.parents('.mt-checkbox-inline').size() > 0) {
                        if (element.parents('.mt-radio-inline').size() > 0) {
                            error.appendTo(element.parents('.mt-radio-inline')[0]);
                        }
                        if (element.parents('.mt-checkbox-inline').size() > 0) {
                            error.appendTo(element.parents('.mt-checkbox-inline')[0]);
                        }
                    } else if (element.is(':checkbox')) {
                        error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .mt-checkbox-outline, .checkbox-list, .checkbox-inline"));
                    } else if (element.parent(".input-group").size() > 0) {
                        error.insertAfter(element.parent(".input-group"));
                    } else if (element.attr("data-error-container")) {
                        error.appendTo(element.attr("data-error-container"));
                    } else {
                        error.insertAfter(element); // for other inputs, just perform default behavior
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
				return false;
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me, bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});

		//handle ship method options change
		$('[name="shipmethod"]').on('change', function(){
			var fix_fee = $(this).data('amount');
			var courier = $(this).data('courier');
            // update hidden fields
			$('[name="fix_fee"]').val(fix_fee);
			$('[name="courier"]').val(courier);
			// update shipping field
			$('#add-shipping').html('$ ' + fix_fee.toFixed(2));
			// update estimated total
			var original_value = $('#estimated-total').data('original-value');
			$('#estimated-total').html('$ ' + (original_value + fix_fee).toFixed(2));
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
