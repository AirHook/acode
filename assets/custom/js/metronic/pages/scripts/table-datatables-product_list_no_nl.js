var TableDatatablesManaged = function () {

	var base_url = $('body').data('base_url');
	var object_data = $('body').data('object_data');

	var active_category = $('select[name="category"]').val(); // get default category
	var active_designer = $('select[name="category"]').attr('data-active_designer'); // get active designer
	var active_order_by = $('select[name="order_by"]').val(); // get default category

    var initTable = function () {

        var table = $('#tbl-product_list');

        // begin wholesale users table
        var oTable = table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ records",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total records)",
                "lengthMenu": "Show _MENU_",
                "search": "Search/Filter:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "previous":"Prev",
                    "next": "Next",
                    "last": "Last",
                    "first": "First"
                }
            },

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js).
            // So when dropdowns used the scrollable div should be removed.
            //"dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.

			"drawCallback": function(settings){
				// trigger unveil
				$('img').unveil();
				$('.img-unveil').trigger('unveil');
				// image hover effect
				$(".img-a").hover(
					function() {
						$(this).stop().animate({"opacity": "0"}, "slow");
					},
					function() {
						$(this).stop().animate({"opacity": "1"}, "slow");
					}
				);
				// force re-render on bs-select items
				$('select[name="category"]').find('.all-options').hide(); // hide all options first
				$('select[name="category"]').find('.' +  active_designer).show(); // show categories of active designer
				$('select[name="designer"]').selectpicker('val', active_designer);
				$('select[name="category"]').selectpicker('val', active_category);
				$('select[name="order_by"]').selectpicker('val', active_order_by);
				// seque functions
				$('.seque').on('focus', function(){
					$(this).attr('readonly', false);
				})
				$('.seque').on('blur', function(){
					$(this).attr('readonly', true);
				})
				// table column seque change function
				$('.seque').change(function(){
					var prod_id = $(this).data('prod_id');
					var new_seque = $(this).val();
					$.get(base_url + 'admin/products/Update_seque/index/' + prod_id + '/' + new_seque);
					$(this).siblings('.seque-label').html(new_seque);
					$(this).attr('readonly', true);
					//oTable.api().rows().invalidate('dom').draw();
				});
			},

            "lengthMenu": [
                [100, 250, 500, 1000, -1],
                [100, 250, 500, 1000, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 100,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [0, 1, 3, 8]
                },
                {
                    "width": "30px",
                    "targets": [1]
                },
				{
                    "width": "60px",
                    "targets": [7]
                },
                {
                    "searchable": false,
                    'targets': [0, 1, 3, 4, 8]
                },
                {
                    "className": "dt-right",
                    //"targets": [2]
                }
            ],
            "order": [
                //[8, "desc"]
            ] // set a column as a default sort by asc
        });

        var tableWrapper = jQuery('#tbl-product_list_wrapper');

		// header checkbox change function
		// get the "data-set" attribute and look for each (look for all rows checkboxes)
		// if header checkbos is checked, check row checkboxes and set row as active
        table.find('.group-checkable').change(function () {
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
        table.on('change', 'tbody tr .checkboxes', function () {
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
			$.get(base_url + 'admin/products/Update_seque/index/' + prod_id + '/' + new_seque);
			//$.get(base_url + 'admin/products/Update_seque/index/' + prod_id + '/' + new_seque, function(data, status){alert('Data: ' + data + '\nStatus: ' + status);});
			$(this).siblings('.seque-label').html(new_seque);
			$(this).attr('readonly', true);
			// invlidate all rows of the datatable and draw it again
			oTable.api().rows().invalidate('dom').draw();
		});
    }

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
			$.get(base_url + 'admin/products/Update_seque/index/' + prod_id + '/' + new_seque);
			//$.get(base_url + 'admin/products/Update_seque/index/' + prod_id + '/' + new_seque, function(data, status){alert('Data: ' + data + '\nStatus: ' + status);});
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
			var st;
			if ($('#pub1'+prod_id).is(':checked') && $('#pub2'+prod_id).is(':checked')) {
				st = 1;
			}
			if ( ! $('#pub1'+prod_id).is(':checked') && $('#pub2'+prod_id).is(':checked')) {
				st = 12;
			}
			if ($('#pub1'+prod_id).is(':checked') && ! $('#pub2'+prod_id).is(':checked')) {
				st = 11;
			}
			if ( ! $('#pub1'+prod_id).is(':checked') && ! $('#pub2'+prod_id).is(':checked')) {
				st = 0;
			}
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
			window.location.href = base_url + "admin/products/publish/index/"+st+"/"+prod_id+".html";
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
		$('.modal-edit_seque').on('click', function(){
			var prod_id = $(this).parents('.dd3-item').data('prod_id');
			var cur_seque = $(this).parents('.dd3-item').data('seque');
			$('[name="prod_id"]').val(prod_id);
			$('[name="cur_seque"]').val(cur_seque);
			// show modal
			$('#modal-edit_seque').modal('show');
		});
	}

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

			initTable();
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
