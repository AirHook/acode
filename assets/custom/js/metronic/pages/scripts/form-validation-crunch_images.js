var FormValidation = function () {

	var base_url = window.location.origin;
	
	var active_category = $('select[name="category"]').val(); // get default category
	var active_designer = $('select[name="category"]').attr('data-active_designer'); // get active designer
	
    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-crunch_images');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input

			rules: {
				designer: {
					required: true
				},
				category: {
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
				$('#loading .modal-body .modal-body-text').html('Crunching...');
				$('#loading').modal('show');
				error1.hide();
				form.submit();
			}
		});
		
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
	
		// bootstrap select events and actions for proudct list filter
		$('select[name="category"]').find('.all-options').hide(); // hide all options first
		$('select[name="category"]').find('.' +  active_designer).show(); // show categories of active designer
		$('select[name="category"]').selectpicker('refresh');
		// on change of designer dropdown
		$('select[name="designer"]').change(function(){
			// reset category select dropdown
			$('select[name="category"]').selectpicker('val', '');
			// grab new selected designer and its data attribute
			var selected_designer = $(this).val();
			// update category select dropdown
			$('select[name="category"]').find('.all-options').hide();
			$('select[name="category"]').find('.' +  selected_designer).show();
			if (selected_designer == active_designer) $('select[name="category"]').selectpicker('val', active_category);
			$('select[name="category"]').selectpicker('refresh');
			// validate category select dropdown
			$('#form-crunch_images').validate().element($('select[name="category"]'));
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