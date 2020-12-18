var ComponentsEditors = function () {

	var base_url = $('body').data('base_url');
	var object_data = $('body').data('object_data');

	// basic page scripts
    var pageScripts = function () {

		// make checkbox behave like radio with user option to uncheck checkbox
		$('.mt-checkbox').on('change', '.chb-radio', function() {
			var param = $(this).closest('.mt-checkbox-list').data('param');
		    $('.chb-radio-'+param).not(this).prop('checked', false);
		});

		// schedule actions
		$('[name="type"]').on('change', function(){
			var type = $(this).val();
			if (type) {
				$('.select-schedule').hide();
				$('.select-schedule-'+type).fadeIn();
				if (type == 'recurring') {
					$('.date-picker-once').datepicker('update', '');
					$('.date-picker-once').children().prop('disabled', true);
					$('.date-picker-once').find('button').prop('disabled', true);
					$('.input-schedule-recurring').prop('disabled', false);
					$('.notice-recurring').fadeIn();
					$('.subject-recurring').fadeIn();
					$('.message-recurring-wrapper').fadeIn();
				} else {
					$('.date-picker-once').children().prop('disabled', false);
					$('.date-picker-once').find('button').prop('disabled', false);
					$('.input-schedule-recurring').prop('disabled', true);
					$('.input-schedule-recurring').attr('name', '');
					$('.input-schedule-recurring').val('');
					$('.select-schedule-recurring').find('.date-picker-button').removeClass('active');
					$('.notice-recurring').hide();
					$('.subject-recurring').hide();
					$('.message-recurring-wrapper').hide();
				}
			}
		});

		// recurring date selection process
		$('.date-picker-button').on('click', function(){
			$(this).toggleClass('active');
			var new_value = [];
			// get the input paramaters
			var input_name = $('.input-schedule-recurring').attr('name');
			var input_value = $('.input-schedule-recurring').val();
			// capture the click parameters
			var schedule_param = $(this).data('schedule-param'); // get $.this schedule_param
			var value = $(this).data('value');
			// process information
			if (schedule_param != input_name) {
				if (schedule_param == 'week') {
					$('.select-monthly').removeClass('active');
				}
				if (schedule_param == 'month') {
					$('.select-weekly').removeClass('active');
				}
			} else {
				if (input_value) new_value = input_value.split(',');
			}
			// add or remove element
			if ($(this).hasClass('active')) {
				new_value.push(value);
				new_value.sort(function(a,b){return a-b});
			} else {
				for (var i=0; i < new_value.length; i++) {
					if (new_value[i] == value) {
						new_value.splice(i, 1);
					}
				}
			}
			// update input parameters
			$('.input-schedule-recurring').attr('name', schedule_param);
			$('.input-schedule-recurring').val(new_value.toString());
		});

		// layout actions
		$('[name="layout"]').on('change', function(){
			$('.layout-content').hide();
			$('[name="designer[]"]').prop('checked', false);
			var val;
			if ($(this).prop('checked')) {
				$('.notice-email-content').hide();
				val = $(this).val();
				if (val == 'default') {
					$('.form-group-designer').hide();
					$('.layout-content-default').fadeIn();
				} else {
					if (val == 'single_designer') {
						$('[name="designer[]"]').addClass('chb-radio chb-radio-designer');
						$('.layout-content-single').fadeIn();
					}
					if (val == 'multi_designer') {
						$('[name="designer[]"]').removeClass('chb-radio chb-radio-designer');
						$('.layout-content-multi').fadeIn();
					}
					$('.form-group-designer').fadeIn();
				}
			} else {
				$('.form-group-designer').hide();
				$('.notice-email-content').fadeIn();
			}
		})

		// test send actions
	    $('.test-send-carousel').on('click', function(){
	        var id = $('.test-send-email').data('carousel_id');
	        var email = $('.test-send-email').val();
	        if ( ! email) {
	            alert('Please enter email address.');
	            return false;
	        }
	        $('#loading .modal-title').html('Processing...');
	        $('#loading').modal('show');
	        window.location.href=base_url+'cronjobs/carousels/index/'+id+'.html?email='+email;
	        return false;
	    });
    }

	var handleValidation = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-carousel_add');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: ":disabled",  // validate all fields including form hidden input

			// set your custom error message here
			messages: {
				type: "Please select the type of carousel",
				"schedule[]": "Select when to send out carousel",
				"subject[]": "At least one subject is required",
				"message[]": "At least one message is required"
			},

			rules: {
				name: {
					required: true
				},
                type: {
					required: true
				},
				date: {
					required: true
				},
				week: {
					required: true
				},
				month: {
					required: true
				},
				layout: {
					required: true
				},
				stock_condition: {
					required: true
				},
				users: {
					required: true
				},
				"subject[]": {
					required: true
				},
				"message[]": {
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
				if (element.attr("data-error-container")) {
					error.appendTo('#'+element.attr("data-error-container"));
				} else if (cont.size() > 0) {
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
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

	var handleDatePickers = function () {

		var today = new Date();
		var dd = String(today.getDate()).padStart(2, '0');
		var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
		var yyyy = today.getFullYear();
		today = yyyy + '-' + mm + '-' + dd;

        if (jQuery().datepicker) {
            $('.date-picker-once').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
                autoclose: true,
                startDate: '+1d'
            });

            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }

        /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */

        // Workaround to fix datepicker position on window scroll
        $( document ).scroll(function(){
            $('#form_modal2 .date-picker').datepicker('place'); //#modal is the id of the modal
        });
    }

	var handleSummernote = function () {
        $('.summernote').summernote({
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

	return {
        //main function to initiate the module
        init: function () {

			pageScripts();
			handleValidation()
			handleDatePickers();
			handleSummernote();
		}

    };

}();

if (App.isAngularJsApp() === false) {
	jQuery(document).ready(function() {
		ComponentsEditors.init();
	});
}
