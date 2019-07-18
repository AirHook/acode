var FormValidation = function () {

    var base_url = $('body').data('base_url');

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-designer_edit');
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

		// upload images transfer of data field to modal
		$('.upload_images').on('click', function() {
			var el = $(this);
			var fld = el.data('field');
			$('input[name="field"]').val(fld);
            if (fld == 'logo_light') $('.dropzone-form-title').html('Logo (light) Image');
			if (fld == 'logo')  $('.dropzone-form-title').html('Logo Image');
            if (fld == 'icon')  $('.dropzone-form-title').html('Icon Image');
		});

		// remove images transfer of data to modal
		$('.remove_images').on('click', function() {
			$('#loading .modal-title').html('Removing...');
			$('#loading').modal('show');
			var el = $(this);
			var fld = el.data('field');
			var des_id = el.data('des_id');
			var url = base_url + '/Websites/acode/' + "admin/designers/remove_images/index/" + des_id + "/" + fld + ".html";
			window.location.href=url;
		});

		// Main publish drop down options
		$('#view_status').change(function(){
			if ($('#view_status').selectpicker('val') == 'Y') {
				$('#where_active').show();
				$('.where_active').prop('checked', true);
			} else {
				$('#where_active').hide();
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

var FormDropzone = function () {

    return {
        //main function to initiate the module
        init: function () {

            Dropzone.options.myDropzoneDesigners = {
                dictDefaultMessage: "Drag files here or click to upload",
                init: function() {
                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                          // Make sure the button click doesn't submit the form:
                          e.preventDefault();
                          e.stopPropagation();

                          // Remove the file preview.
                          _this.removeFile(file);
                          // If you want to delete the file on the server as well,
                          // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        //file.previewElement.appendChild(removeButton);
                    });
					this.on("success", function(file){
						// show the done button
						$('#upload_image_done').show();
						$('#upload_image_cancel').hide();
					});
                }
            }
        }
    };
}();

jQuery(document).ready(function() {
    FormDropzone.init();
	FormValidation.init();
});
