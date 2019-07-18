var FormValidationAndComponentsProductAdd = function () {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation: 
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-products_add');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input

			rules: {
				prod_no: {
					required: true
				},
				prod_name: {
					required: true
				},
				designer: {
					required: true
				},
				subcat_id: {
					required: true
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit              
				success1.hide();
				error1.show();
				App.scrollTo(error1, -200);
				Ladda.stopAll(); // stop all ladda
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
				//return false;
			}
		});
		
		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
		
		// on change of designer dropdown
		$('select[name="designer"]').change(function(){
			$('input[name="designer_slug"]').val($(this).find(':selected').data('url_structure'));
		});
		
		// on click of categories checkboxes
		$('input[name="categories[]"]').on('change', function(){
			var category_level = $(this).data('category_level');
			var checked = $(this).is(":checked");
			// get closets parent to follow suit on check status
			var parent_li = $(this).closest('ul').parent().children('label').children('input[name="categories[]"]');
			if (typeof parent_li !== "undefined") {
				if (checked) parent_li.prop('checked', true);
				if (parent_li.data('category_level') > 0) {
					var parent_li_li = parent_li.closest('ul').parent().children('label').children('input[name="categories[]"]');
					if (typeof parent_li_li !== "undefined") {
						if (checked) parent_li_li.prop('checked', true);
						if (parent_li_li.data('category_level') > 0) {
							var parent_li_li_li = parent_li_li.closest('ul').parent().children('label').children('input[name="categories[]"]');
							if (typeof parent_li_li_li !== "undefined") {
								if (checked) parent_li_li_li.prop('checked', true);
								if (parent_li_li_li.data('category_level') > 0) {
									var parent_li_li_li_li = parent_li_li_li.closest('ul').parent().children('label').children('input[name="categories[]"]');
								}
							}
						}
					}
				}
			}
			// get children and follow suit of parent check status
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
			var input_categories = $(this).closest('div.category_treelist.scroller').find('input[name="categories[]"]');
			if (typeof input_categories !== "undefined") {
				//$('input[name="categories"]').val('');
				$('input[name="category_slugs"]').val('');
				//var cats = '';
				var cat_slugs = '';
				var iii = 1;
				$(input_categories).each(function(){
					if ($(this).is(':checked')) {
						if (iii == 1) {
							//cats = $(this).val();
							cat_slugs = $(this).data('category_slug');
						} else {
							//cats = cats + ',' + $(this).val();
							cat_slugs = cat_slugs + ',' + $(this).data('category_slug');
						}
					}
					iii++;
				});
				//$('input[name="categories"]').val(cats);
				$('input[name="category_slugs"]').val(cat_slugs);
			}
		});
		
    }

	// let us now expose above private functions of FormValidationAndComponentsProductAdd
    return {
        //main function to initiate the module
        init: function () {

            handleValidation1();

        }

    };
}();

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {    
        FormValidationAndComponentsProductAdd.init(); 
    });
}