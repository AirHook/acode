var FormValidation = function () {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-categories_edit');
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
				$('#loading .modal-title').html('Updating...');
				$('#loading').modal('show');
				form.submit();
			}
		});
		
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
		
		//make categories checkbox act like radio buttons
		$('.checkbox-like-radio, .category_treelist').on('change', function(){
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

var ButtonScripts = function () {

	var handleButtonScripts = function() {
		
		var base_url = $('body').data('base_url');
		
		// handle upload image click function to transfer data to modal
		$('.upload_images').on('click', function() {
			var des = $(this).attr('data-designer');
			$('input[name="designer"]').val(des);
		});
		
		// handle each thumbnail icon img src error
		// had to utilize the property 'complete' and on('load') for image as the loading of images
		// usually has delays even after on ready state condition causing the on('error')
		// even handler to work the first time. This way, we do not need to refresh the page anymore
		$('.thumbnail img').each(function(){
			if ($(this).prop('complete')){
				$(this).on('error', function(){
					$(this).attr('src', base_url + 'images/subcategory_icon/thumb/default-subcat-icon.jpg');
					var icon_tab = $(this).attr('data-icon_tab');
					$('.thumbnail .thumb-error.' + icon_tab).text('There was an error loading image file. Upload or change image.');
				});
			}else{
				$(this).on('load', function(){
					$(this).on('error', function(){
						$(this).attr('src', base_url + 'images/subcategory_icon/thumb/default-subcat-icon.jpg');
						var icon_tab = $(this).attr('data-icon_tab');
						$('.thumbnail .thumb-error.' + icon_tab).text('There was an error loading image file. Upload or change image.');
					});
				});
			}
		});
		
		// handle remove button click
		$('.thumbnail .remove_icon').each(function(){
			$(this).click(function(){
				//alert('boom');
				var category_id = $(this).data('category_id');
				var designer = $(this).data('designer');
				var url = base_url +  "admin/categories/remove/index/" + category_id + "/" + designer;
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

var LinkDesginer = function () {

    var linkDes = function () {
		
		var base_url = $('body').data('base_url');
		
		$('.group-checkable-link-des').click(function () {
			var dataObject = $(this).closest('.mt-checkbox-inline').data('object_data');
            var d_slug = $(this).val();
            var category_id = $(this).data('category_id');
            var checked = $(this).is(":checked");
			if (checked) {
				$('.div-link-des-' + d_slug).show();
				var linkUrl = base_url + "admin/categories/link_designer";
				var ajaxType = 'POST';
				dataObject.link_designer = d_slug;
				$('#loading .modal-title').html('Linking...');
			} else {
				$('.div-link-des-' + d_slug).hide();
				var linkUrl = base_url + "admin/categories/unlink_designer/index/" + category_id + "/" + d_slug;
				var ajaxType = 'GET';
				$('#loading .modal-title').html('UN-Linking...');
			}
			// update data to server
			$('#loading').modal('show');
			$.ajax({
				type:    ajaxType,
				url:     linkUrl,
				data:    dataObject,
				success: function(data) {
					//alert(data);
					$('#loading').modal('hide');
					//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
				},
				// vvv---- This is the new bit
				error:   function(jqXHR, textStatus, errorThrown) {
					$('#loading').modal('hide');
					alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					//$('#reloading').modal('show');
					//location.reload();
				}
			});
        });
    }
	
    return {
        //main function to initiate the module
        init: function () {

			linkDes();
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
	LinkDesginer.init();
	ButtonScripts.init();
});