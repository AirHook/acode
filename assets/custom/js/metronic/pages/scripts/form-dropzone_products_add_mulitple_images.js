var FormValidation = function () {

	var base_url = $('body').data('base_url');

	var active_category = $('select[name="category"]').val(); // get default category
	var active_designer = $('select[name="category"]').attr('data-active_designer'); // get active designer
	var active_product_view = $('select[name="select_product_view"]').val(); // get default category

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-products_add_multiple_upload_images');
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
				}
				//
				//category: {
				//	required: true
				//}
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
				//$('#loading').modal('show');
				error1.hide();
				//form.submit();
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});

		// bootstrap select events and actions for proudct list filter
		//$('select[name="category"]').find('.all-options').hide(); // hide all options first
		//$('select[name="category"]').find('.' +  active_designer).show(); // show categories of active designer
		//$('select[name="category"]').selectpicker('refresh');

		// on change of designer dropdown
		$('select[name="designer"]').change(function(){
			// grab new selected designer
			//$('select[name="category"]').selectpicker('val', '');
			var selected_designer = $(this).val();
			// grab data attributes
			var des_id = $(this).find(':selected').data('des_id');
			var d_folder = $(this).find(':selected').data('d_folder');
			var size_mode = $(this).find(':selected').data('size_mode');
			// update category input field
			//$('select[name="category"]').find('.all-options').hide();
			//$('select[name="category"]').find('.' +  selected_designer).show();
			//if (selected_designer == active_designer) $('select[name="category"]').selectpicker('val', active_category);
			//$('select[name="category"]').selectpicker('refresh');
			// validate category select field
			//$('#form-products_add_multiple_upload_images').validate().element($('select[name="category"]'));
			// update dropzone input fields
			$('input[name="des_id"]').val(des_id);
			$('input[name="size_mode"]').val(size_mode);
			$('input[name="designer_slug"]').val(d_folder);
			// update size default set depending of size mode
			switch (size_mode) {
				case 0:
					var sizeHtml = 'Set size S &amp; M with 1 unit(s) each (default)';
					var sizeHelpBlock = 'Current size mode is B (S,M,L,XL)';
					break;
				case 2:
					var sizeHtml = 'Set prepack qty to 1 (default)';
					var sizeHelpBlock = 'Current size mode is C (Pre-packed S1-M2-L2-XL1)';
					break;
				case 3:
					var sizeHtml = 'Set sizes qty to 1 (default)';
					var sizeHelpBlock = 'Current size mode is D (S-M, M-L)';
					break;
				case 4:
					var sizeHtml = 'Set qty to 1 (default)';
					var sizeHelpBlock = 'Current size mode is E (One Size Fits All)';
					break;
				case 1:
				default:
					var sizeHtml = 'Set size 2 &amp; 4 with 1 unit each (default)';
					var sizeHelpBlock = 'Current size mode is A (0,2,4,6,8,...,22)';
			};
			$('.size-default-set').html(sizeHtml);
			$('.size-help-block').html(sizeHelpBlock);
		});

		// on change of category dropdown
		$('select[name="category"]').change(function(){
			$('input[name="category_slug"]').val($(this).val());
			var subcat_id = $(this).find(':selected').data('subcat_id');
			$('input[name="subcat_id"]').val(subcat_id);
		});
		// on change of product view dropdown
		$('select[name="select_product_view"]').change(function(){
			$('input[name="product_view"]').val($(this).val());
		});
		// on change of season facet dropdown for tempo
		$('select[name="seasons"]').change(function(){
			$('input[name="events"]').val($(this).val());
		});
		// on change of stocks qty drop down
		$('select[name="stocks"], input[name="stocks"]').change(function(){
			$('input[name="stock_qty"]').val($(this).val());
		});

		// on change of misc options
		$('input[type="radio"]').click(function(){
			//alert($('input[name="private_view"]:checked').val());
			//var publish_this = $('input[name="publish_this"]').is(':checked');
			//var private_view = $('input[name="private_view"]').is(':checked');
			var publish_this = $('input[name="publish_this"]:checked').val();
			var private_view = $('input[name="private_view"]:checked').val();
			if (publish_this == '1') {
				$('input[name="view_status"]').val('Y');
				$('input[name="color_publish"]').val('Y');
				if (private_view == '1') { // private
					$('input[name="public"]').val('N');
					$('input[name="publish"]').val('2');
					$('input[name="new_color_publish"]').val('2');
				} else {
					$('input[name="public"]').val('Y');
					$('input[name="publish"]').val('1');
					$('input[name="new_color_publish"]').val('1');
				}
			} else {
				$('input[name="view_status"]').val('N');
				$('input[name="public"]').val('N');
				$('input[name="publish"]').val('0');
				$('input[name="color_publish"]').val('N');
				$('input[name="new_color_publish"]').val('0');
			}
		});

		// on click of categories checkboxes
		$('input[name="categories[]"]').on('change', function(){
			var checked = $(this).is(":checked");
			var category_level = $(this).data("category_level") - 1;
			// check parent (and other ancestors) category where necessary
			var parent_li = $(this).closest('ul').parent().children('label').children('input[name="categories[]"]');
			if (typeof parent_li !== "undefined") {
				if (checked) {
					parent_li.prop('checked', true);
					if (category_level != 0) {
						category_level--;
						var parent_p_li = $(this).closest('ul').parent().closest('ul').parent().children('label').children('input[name="categories[]"]');
						if (typeof parent_p_li !== "undefined") {
							parent_p_li.prop('checked', true);
							if (category_level != 0) {
								category_level--;
								var parent_p_p_li = $(this).closest('ul').parent().closest('ul').parent().closest('ul').parent().children('label').children('input[name="categories[]"]');
								if (typeof parent_p_p_li !== "undefined") {
									parent_p_p_li.prop('checked', true);
								}
							}
						}
					}
				}
			}
			// uncheck children category where necessary
			var children_li = $(this).closest('li').children('ul').find('input[name="categories[]"]');
			if (typeof children_li !== "undefined") {
				var counter = 1;
				$(children_li).each(function(){
					if (!checked) {
						if ($(this).is(":checked") && counter == 1) {
							alert('NOTE:'+'\n'+'Children category(s) will also be unchecked.')
							counter++;
						}
						$(this).prop('checked', false);
					}
				});
			}
			// collate all checked inputs
			var input_categories = $(this).closest('div.category_treelist').find('input[name="categories[]"]');
			if (typeof input_categories !== "undefined") {
				$('input[name="categories"]').val('');
				$('input[name="category_slugs"]').val('');
				var cats = '';
				var cat_slugs = '';
				var iii = 1;
				$(input_categories).each(function(){
					if ($(this).is(':checked')) {
						if (iii == 1) {
							cats = $(this).val();
							cat_slugs = $(this).data('category_slug');
						} else {
							cats = cats + ',' + $(this).val();
							cat_slugs = cat_slugs + ',' + $(this).data('category_slug');
						}
					}
					iii++;
				});
				$('input[name="categories"]').val(cats);
				$('input[name="category_slugs"]').val(cat_slugs);
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

var FormDropzone = function () {


    return {
        //main function to initiate the module
        init: function () {

            Dropzone.options.myDropzone = {
                dictDefaultMessage: "",
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
                          // If you want to the delete the file on the server as well,
                          // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
					// Send formData with upload
					/*
					this.on('sending', function(file, xhr, formData){

					});
					*/
                }
            }
        }
    };
}();

jQuery(document).ready(function() {
	FormDropzone.init();
	FormValidation.init();
});
