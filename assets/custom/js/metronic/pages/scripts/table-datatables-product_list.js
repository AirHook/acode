var TableDatatablesManaged = function () {

	var base_url = $('body').data('base_url');
	var object_data = $('body').data('object_data');

	var active_category = $('select[name="category"]').val(); // get default category
	var active_designer = $('select[name="category"]').attr('data-active_designer'); // get active designer
	var active_order_by = $('select[name="order_by"]').val(); // get default category

	var handleScripts = function () {

		// header checkbox change function
		// get the "data-set" attribute and look for each (look for all rows checkboxes)
		// if header checkbos is checked, check row checkboxes and set row as active
		$('#tbl-product_list_').find('.group-checkable').change(function () {
			var set = jQuery(this).attr("data-set");
			var checked = jQuery(this).is(":checked");
			jQuery(set).each(function () {
				if (checked) {
					$(this).prop("checked", true);
					$(this).parents('tr').addClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select').prop("disabled", false);
					$('.apply_bulk_actions').prop("disabled", false);
					$('#heading_checkbox').prop("checked", true);
				} else {
					$(this).prop("checked", false);
					$(this).parents('tr').removeClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select').prop("disabled", true);
					$('#bulk_actions_select').selectpicker("val", "");
					$('.apply_bulk_actions').prop("disabled", true);
					$('#heading_checkbox').prop("checked", false);
				}
				$('#bulk_actions_select').selectpicker("refresh");
			});
		});

		// table row checkboxes change function
		$('#tbl-product_list_').on('change', 'tbody tr .checkboxes', function () {
			$(this).parents('tr').toggleClass("active");
			// add other custom javascripts here...
			var checked = jQuery(this).is(":checked");
			if (checked) {
				$('#bulk_actions_select').prop("disabled", false);
				$('.apply_bulk_actions').prop("disabled", false);
				$('#heading_checkbox').prop("checked", true);
			} else {
				if ($('.checkboxes:checked').length == 0) {
					$('#heading_checkbox').prop("checked", false);
					$('#bulk_actions_select').selectpicker("val", "");
					$('#bulk_actions_select').prop("disabled", true);
					$('.apply_bulk_actions').prop("disabled", true);
					$('#heading_checkbox').prop("checked", false);
				}
			}
			$('#bulk_actions_select').selectpicker("refresh");
		});

		// table column seque change function
		$('.seque').change(function(){
			var prod_id = $(this).data('prod_id');
			var new_seque = $(this).val();
			$.get(base_url + 'admin/products/update_seque/index/' + prod_id + '/' + new_seque);
			//$.get(base_url + 'admin/products/update_seque/index/' + prod_id + '/' + new_seque, function(data, status){alert('Data: ' + data + '\nStatus: ' + status);});
			$(this).siblings('.seque-label').html(new_seque);
			$(this).attr('readonly', true);
		});

		// apply button scripts
		$('.apply_bulk_actions').click(function(){
			var x = document.getElementById("bulk_actions_select").selectedIndex;
			var y = document.getElementById("bulk_actions_select").options;
			var z = y[x].value;
			if (!z) {
				alert("Please select an action to take.");
				return false;
			} else {
				$('#confirm_bulk_actions-' + z).modal('toggle');
				return false;
			}
		});

		// bootstrap select events and actions for proudct list filter
		$('select[name="category"]').find('.all-options').hide(); // hide all options first
		$('select[name="category"]').find('.' +  active_designer).show(); // show categories of active designer
		// on change of designer dropdown
		$('select[name="designer"]').change(function(){
			$('select[name="category"]').selectpicker('val', '');
			var selected_designer = $('select[name="designer"]').val();
			$('select[name="category"]').find('.all-options').hide();
			$('select[name="category"]').find('.' +  selected_designer).show();
			if (selected_designer == active_designer) $('select[name="category"]').selectpicker('val', active_category);
			$('select[name="category"]').selectpicker('refresh');
			$('#form-admin_product_filters').validate().element($('select[name="category"]'));
		});

		// publish/private radio input change function
		$('.list_publish_button').click(function(){
			var name = $(this).attr('name');
			var prod_id = $(this).attr('data-prod_id');
			var action = $(this).attr('data-action');
			$('#' + action + '-' + prod_id).modal('show');
			// on..  keyboard esc key, click outside modal box, close and 'x' buttons
			$('#' + action + '-' + prod_id).on('hide.bs.modal', function(){
				$('input[name="' + name + '"]').prop('checked', function(){
					return this.getAttribute('checked') == 'checked';
				});
			});
		});

		// hub/sat checkbox check function
		$('.set_purblish_state').change(function(){
			var prod_id = $(this).attr('data-prod_id');
			var st_id = $(this).attr('data-st_id');
			var public = $('[name="pub3' + st_id + '"]:checked').val();
			var st;
			if ($('#pub1'+st_id).is(':checked') && $('#pub2'+st_id).is(':checked')) {
				st = 1;
			}
			if ( ! $('#pub1'+st_id).is(':checked') && $('#pub2'+st_id).is(':checked')) {
				st = 12;
			}
			if ($('#pub1'+st_id).is(':checked') && ! $('#pub2'+st_id).is(':checked')) {
				st = 11;
			}
			if ( ! $('#pub1'+st_id).is(':checked') && ! $('#pub2'+st_id).is(':checked')) {
				st = 0;
			}
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
			window.location.href = base_url + "admin/products/publish/index/"+st+"/"+prod_id+"/"+st_id+".html";
		});

		// delete item button action
		$('a.delete-item').on('click', function(){
			var prod_id = $(this).data('prod_id');
			$('#delete-'+prod_id).modal('show');
		});

		// nestable list group check
		$('#nl-group-checkable').change(function () {
			var set = jQuery(this).attr("data-set");
			var checked = jQuery(this).is(":checked");
			jQuery(set).each(function () {
				if (checked) {
					$(this).prop("checked", true);
					$(this).parents('.dd3-content').addClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select').prop("disabled", false);
					$('.apply_bulk_actions').prop("disabled", false);
					//$('#heading_checkbox').prop("checked", true);
				} else {
					$(this).prop("checked", false);
					$(this).parents('.dd3-content').removeClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select').prop("disabled", true);
					$('#bulk_actions_select').selectpicker("val", "");
					$('.apply_bulk_actions').prop("disabled", true);
					//$('#heading_checkbox').prop("checked", false);
				}
				$('#bulk_actions_select').selectpicker("refresh");
			});
		});

		// nestable list checkboxes
		$('.nestable_list').on('change', '.dd3-item .dd3-content .checkboxes', function () {
			$(this).parents('.dd3-content').toggleClass("active");
			// add other custom javascripts here...
			var checked = jQuery(this).is(":checked");
			if (checked) {
				$('#bulk_actions_select').prop("disabled", false);
				$('.apply_bulk_actions').prop("disabled", false);
				$('#nl-group-checkable').prop("checked", true);
			} else {
				if ($('.checkboxes:checked').length == 0) {
					$('#bulk_actions_select').selectpicker("val", "");
					$('#bulk_actions_select').prop("disabled", true);
					$('.apply_bulk_actions').prop("disabled", true);
					$('#nl-group-checkable').prop("checked", false);
				}
			}
			$('#bulk_actions_select').selectpicker("refresh");
		});

		// manual edit seque
		/* *
		$('.modal-edit_seque').on('click', function(){
			var prod_id = $(this).parents('.dd3-item').data('prod_id');
			var cur_seque = $(this).parents('.dd3-item').data('seque');
			$('[name="prod_id"]').val(prod_id);
			$('[name="cur_seque"]').val(cur_seque);
			// show modal
			$('#modal-edit_seque').modal('show');
		});
		// */

		// sales my account functions
		// clicked on product grid view
        $('.thumb-tiles').on('click', '.package_items', function() {
            var objectData = object_data;
            objectData.prod_no = $(this).data('item');
			objectData.access_level = $(this).data('access_level');
            // get item...
            getItem(objectData);
        });

		// get item to show on popup
        function getItem(objectData){
            var addrem = $.ajax({
                type:    "POST",
                url:     base_url + "my_account/sales/products/get_item.html",
                data:    objectData
            });
            addrem.done(function(data) {
                // fill in modal
                $('.modal-body-size_qty_info').html(data);
                $('#modal-size_qty_info').modal('show');
            });
            addrem.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Item Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

		// add to sales package button
		$('#form-size_qty_select').on('click', '.btn-add_to_sa', function(){
			$('#form-size_qty_select').attr('action', base_url + 'my_account/sales/products/add_to_sa.html');
			$('#form-size_qty_select').submit();
		});

		// add to sales package button
		$('#form-size_qty_select').on('click', '.btn-add_to_so', function(){
			// check sizes and quantities
            var size_qty = 0;
            $('.size-select').each(function(){
                if ($(this).val() != 0){
                    size_qty = size_qty + $(this).val();
                }
            });
			if (size_qty > 0) {
				$('#form-size_qty_select').attr('action', base_url + 'my_account/sales/products/add_to_so.html');
				$('#form-size_qty_select').submit();
			} else {
				alert('Please select one size with qty greater than zero.');
			}
		});
	}

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

			handleScripts();
        }

    };

}();

var FormValidation = function () {

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-admin_product_filters');
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
				$('#loading').modal('show');
				error1.hide();
				form.submit();
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    return {
        //main function to initiate the module
        init: function () {

            handleValidation1();

        }

    };

}();

var SomeScripts = function () {

	var scriptSeque = function () {

		/**
		 * Process flow:
		 * - remove attribute readonly on click of element
		 * - save new input via ajax request, then make element readonly again
		 * - invalidate cell and redraw - datatable
		 */

		// set a variable to indicate if changed or not
		//var changed = false;

		$('.seque').on('focus', function(){
			$(this).attr('readonly', false);
			$(this).select();
		})

		$('.seque').on('blur', function(){
			$(this).attr('readonly', true);
		})

		// List/Grid View buttons
		$('.btn-listgrid').on('click', function(){
			$('#loading').modal('show');
			$('[name="view_as"]').val($(this).data('view_as'));
			$('#form-product_list_view_as').submit();
		});
    }

	return {
		//main function to initiate the module
		init: function () {
            scriptSeque();
			scriptNestableList();
        }
	};

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
		FormValidation.init();
        TableDatatablesManaged.init();
		SomeScripts.init();
   });
}
