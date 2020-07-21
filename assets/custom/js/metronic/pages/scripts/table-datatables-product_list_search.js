var TableDatatablesManaged = function () {

	var base_url = $('body').data('base_url');
	var object_data = $('body').data('object_data');

    var initTable = function () {

        var table = $('#tbl-product_list_search');

        // begin wholesale users table
        table.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ search results",
                "infoEmpty": "No records found",
                "infoFiltered": "(filtered1 from _MAX_ total results)",
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
			},

            "lengthMenu": [
                [25, 100, 250, 500, 1000, -1],
                [25, 100, 250, 500, 1000, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 25,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [0, 1, 2, 7]
                },
				{
                    "width": "200px",
                    "targets": [1]
                },
                {
                    "searchable": false,
                    'targets': [0, 1, 2, 7]
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

        var tableWrapper = jQuery('#tbl-product_list_search_wrapper');

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
    }

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
		window.location.href=base_url + '/Websites/acode/' + "admin/products/publish/index/"+st+"/"+prod_id+".html";
	});

	// sales my account functions
	// clicked on product grid view
	$('.thumb-tiles').on('click', '.package_items', function() {
		var objectData = object_data;
		objectData.prod_no = $(this).data('item');
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
	
    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

			initTable();
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

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
		FormValidation.init();
        TableDatatablesManaged.init();
   });
}
