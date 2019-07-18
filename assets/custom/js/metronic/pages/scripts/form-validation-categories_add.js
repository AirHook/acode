var FormValidation = function () {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-categories_add');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input

			rules: {
				view_status: {
					required: true
				},
				category_name: {
					required: true
				},
				category_slug: {
					required: true
				},
				category_seque: {
					digits: true
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
		
		//make checkbox act like radio buttons
		$('.checkbox-like-radio, .category_treelist').change(function(){
			var checked = $(this).is(':checked');
			$('.checkbox-like-radio, .category_treelist').prop('checked', false);
			if (checked) {
				$(this).prop('checked', true);
				var category_level = $(this).data('category_level');
				$('input[name="parent_category_level"]').val(category_level);
			} else {
				$('input[name="parent_category_level"]').val('');
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

var SetTabs = function () {

    var setTab = function () {
		
		//set webspace tab using session via ajax call
		$('.nav-tabs-item').click(function(){
			var base_url = window.location.origin;
			var x = window.location.pathname.split('.');
			var path_name = x[0];
			var tab_name = $(this).data('tab_name');
			$.get(base_url + path_name + '/set_active_tab/index/' + tab_name);
		});
    }
	
    return {
        //main function to initiate the module
        init: function () {

			setTab();
        }

    };
}();

var ButtonScripts = function () {

	var handleButtonScripts = function() {
		
		var base_url = window.location.origin;
		
		// handle upload image click function to transfer data to modal
		$('.upload_images').on('click', function() {
			var des = $(this).attr('data-designer');
			$('input[name="designer"]').val(des);
		});
		
		// handle each thumbnail icon img src error
		// had to utilize the properyt 'complete' and on('load') for image as the loading of images
		// usually has delays even after on ready state condition cuasing the on('error')
		// even handler to work the first time. This way, we do not need to refresh the page anymore
		$('.thumbnail img').each(function(){
			if ($(this).prop('complete')){
				$(this).on('error', function(){
					$(this).attr('src', base_url + '/Websites/acode/' + 'images/subcategory_icon/thumb/default-subcat-icon.jpg');
					var icon_tab = $(this).attr('data-icon_tab');
					$('.thumbnail .thumb-error.' + icon_tab).text('There was an error loading image file. Upload or change image.');
				});
			}else{
				$(this).on('load', function(){
					$(this).on('error', function(){
						$(this).attr('src', base_url + '/Websites/acode/' + 'images/subcategory_icon/thumb/default-subcat-icon.jpg');
						var icon_tab = $(this).attr('data-icon_tab');
						$('.thumbnail .thumb-error.' + icon_tab).text('There was an error loading image file. Upload or change image.');
					});
				});
			}
		});
		
		// handle remove button click
		$('.thumbnail .remove_icon').each(function(){
			$(this).click(function(){
				var category_id = $(this).attr('data-category_id');
				var designer = $(this).attr('data-designer');
				var url = base_url + '/Websites/acode/' +  "admin/categories/remove/index/" + category_id + "/" + designer;
				$.get(url, function(data, status){
					$('#reloading .modal-body .modal-body-text').html('Data: ' + data + '<br />Status:' + status);
					$('#reloading').modal('show');
					location.reload();
				});
				return false;
			});
		});
	}

    return {
        //main function to initiate the module
        init: function () {

			handleButtonScripts();
        }

    };
}();

var AutoFillSlug = function () {

    var autoFill = function () {
		
		//autofill webspace slug from domain name
		$('#category_name').keyup(function(){
			text = this.value;
			text = text.toLowerCase();
			text = text.split('/').join('-');
			text = text.split(' ').join('_');
			text = text.split('.').join('_');
			text = text.split('\'').join('');
			text = text.split('"').join('');
			$('#category_slug').val(text);
		});
		$('#category_name').blur(function(){
			text = this.value;
			autofill = text;
			text = text.toLowerCase();
			text = text.split('/').join('-');
			text = text.split(' ').join('_');
			text = text.split('.').join('_');
			text = text.split('\'').join('');
			text = text.split('"').join('');
			$('#category_slug').val(text);
			$('textarea[name="description"]').val(autofill);
			$('input[name="title"]').val(autofill);
			$('textarea[name="keyword"]').val(autofill);
			$('input[name="alttags"]').val(autofill);
			$('textarea[name="footer"]').val(autofill);
		});
    }
	
    return {
        //main function to initiate the module
        init: function () {

			autoFill();

        }

    };
}();

var FormDropzone = function () {

    return {
        //main function to initiate the module
        init: function () {  

            Dropzone.options.myDropzoneCategories = {
                dictDefaultMessage: "Drag files here to upload. Or, click to browse files.",
				/*
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
                        file.previewElement.appendChild(removeButton);
                    });
                } 
				*/
            }
        }
    };
}();

jQuery(document).ready(function() {
    FormValidation.init();
	FormDropzone.init();
	SetTabs.init();
	AutoFillSlug.init();
	ButtonScripts.init();
});