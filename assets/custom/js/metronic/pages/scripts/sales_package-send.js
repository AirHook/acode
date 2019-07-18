var ComponentsDropdowns = function () {

    var handleMultiSelect = function () {
        $('#my_multi_select1').multiSelect({
			cssClass: "multi-select-with-to-90-percent"
		});
        $('#my_multi_select2').multiSelect({
            selectableOptgroup: true
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleMultiSelect();
        }
    };

}();

var FormValidation = function () {

	var base_url = $('#is_active').data('base_url');

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-sales_package_sending');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input

			// set your custom error message here
            messages: { // custom messages for radio buttons and checkboxes
                'users[]': {
                    required: "Please select at least one user",
                    minlength: jQuery.validator.format("Please select at least one user")
                }
            },

			rules: {
				'users[]': {
                    required: true,
                    minlength: 1
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
				//return false;
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me, bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

	// apply action to drop down select of vendor type id
	$('#vendor_type_id').change(function(){
		var x = document.getElementById("vendor_type_id").selectedIndex;
		var y = document.getElementById("vendor_type_id").options;
		var z = y[x].value;
		if (z) {
			$('#type').val($("#vendor_type_id option:selected").text());
		}
	});

    return {
        //main function to initiate the module
        init: function () {

            handleValidation1();

        }

    };

}();

jQuery(document).ready(function() {
    ComponentsDropdowns.init();
    FormValidation.init();
});
