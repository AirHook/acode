var TableDatatablesManaged = function () {

    var base_url = $('body').data('base_url');
    var objectData = $('.page-file-wrapper').data('object_data');

    var initTable = function () {

        var table = $('#tbl-orders');

        // begin wholesale users table
        table.dataTable({

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

            "lengthMenu": [
                [25, 50, 100, 500], // , -1
                [25, 50, 100, 500] // , "All" - change per page values here
            ],
            // set the initial value
            "pageLength": 25,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [0, 1, 11]
                },
                {
                    "width": "30px",
                    "targets": [1]
                },
                {
                    "searchable": false,
                    "targets": [0, 1, 11]
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

        var tableWrapper = jQuery('#tbl-orders_wrapper');

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
					$('#apply_bulk_actions').prop("disabled", false);
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select').prop("disabled", true);
					$('#bulk_actions_select').selectpicker("val", "");
 					$('#apply_bulk_actions').prop("disabled", true);
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
				$('#apply_bulk_actions').prop("disabled", false);
				$('#heading_checkbox').prop("checked", true);
			} else {
				if ($('.checkboxes:checked').length == 0) {
                    $('#heading_checkbox').prop("checked", false);
					$('#bulk_actions_select').selectpicker("val", "");
					$('#bulk_actions_select').prop("disabled", true);
					$('#apply_bulk_actions').prop("disabled", true);
				}
			}
			$('#bulk_actions_select').selectpicker("refresh");
        });
    }

    // header checkbox change function
    // get the "data-set" attribute and look for each (look for all rows checkboxes)
    // if header checkbos is checked, check row checkboxes and set row as active
    $('#tbl-orders_').find('.group-checkable').change(function () {
        var set = jQuery(this).attr("data-set");
        var checked = jQuery(this).is(":checked");
        jQuery(set).each(function () {
            if (checked) {
                $(this).prop("checked", true);
                $(this).parents('tr').addClass("active");
                // add other custom javascripts here...
                $('#bulk_actions_select').prop("disabled", false);
                $('#apply_bulk_actions').prop("disabled", false);
            } else {
                $(this).prop("checked", false);
                $(this).parents('tr').removeClass("active");
                // add other custom javascripts here...
                $('#bulk_actions_select').prop("disabled", true);
                $('#bulk_actions_select').selectpicker("val", "");
                $('#apply_bulk_actions').prop("disabled", true);
            }
            $('#bulk_actions_select').selectpicker("refresh");
        });
    });

    // table row checkboxes change function
    $('#tbl-orders_').on('change', 'tbody tr .checkboxes', function () {
        $(this).parents('tr').toggleClass("active");
        // add other custom javascripts here...
        var checked = jQuery(this).is(":checked");
        if (checked) {
            $('#bulk_actions_select').prop("disabled", false);
            $('#apply_bulk_actions').prop("disabled", false);
            $('#heading_checkbox').prop("checked", true);
        } else {
            if ($('.checkboxes:checked').length == 0) {
                $('#heading_checkbox').prop("checked", false);
                $('#bulk_actions_select').selectpicker("val", "");
                $('#bulk_actions_select').prop("disabled", true);
                $('#apply_bulk_actions').prop("disabled", true);
            }
        }
        $('#bulk_actions_select').selectpicker("refresh");
    });

    // apply button scripts
    $('#apply_bulk_actions').click(function(){
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

    // apply filter by designer
    // version 1 where filter is top of page
	$('.apply_filer_by_designer').click(function(){
        var page_param = $(this).data('page_param');
		var x = document.getElementById("filter_by_designer_select").selectedIndex;
		var y = document.getElementById("filter_by_designer_select").options;
		var z = y[x].value;
		if (!z) {
			alert("Please select a designer to filter table.");
			return false;
		} else {
            $('#loading').modal('show');
            if (z=='all'){
                window.location.href = base_url + "my_account/sales/orders/" + page_param + ".html";
            }else{
                window.location.href = base_url + "my_account/sales/orders/" + page_param + "/index/" + z + ".html";
            }
		}
	});
    // version 2 using sidebar filter
    $('.filter-options-field').change(function(){
        // get filter values
        var url;
        var page_param = $('[name="page_param"]').val();
        var des_slug = $('[name="des_slug"]').val();
        var status = $('[name="status"]:checked').val();
        // process values
        // page_param will alwasy have a value
        // therefore, let's initially set the url as
        var pre_url = base_url + "my_account/sales/orders/" + page_param;
        // first, check for status
        if (status) {
            if (!des_slug) des_slug = 'all';
            url = pre_url + "/index/" + des_slug + "/" + status + ".html";
        } else if (!des_slug || des_slug=='all') {
            url = pre_url + ".html"
        } else {
            url = pre_url + "/index/" + des_slug + ".html"
        }
        // redirect page
        $('#loading').modal('show');
        window.location.href = url;
	});

    // order details sidebar filter
    $('.filter-options-field-details').change(function(){
        // set and get values
        var status = $('[name="status"]:checked').val();
        var order_id = $('[name="order_id"]').val();
        var referrer = 'details';
        // set url params - id, status, referrer
        var url = base_url + "my_account/sales/orders/status/index/" + order_id + "/" + status + "/" + referrer + ".html";
        // redirect page
        $('#loading').modal('show');
        window.location.href = url;
	});

    // resend order email confirmation
    $('.btn-resend_email_confirmation').on('click', function(){
        // show loading modal
        $('#loading .modal-title').html('Sending...');
        $('#loading').modal('show');
        // get data
        objectData.user_id = $(this).data('user_id');
        objectData.order_id = $(this).data('order_id');
        objectData.user_cat = $(this).data('user_cat');
        var send = $.ajax({
            type:    "POST",
            url:     base_url + "my_account/sales/orders/send_order_email_confirmation.html",
            data:    objectData
        });
        send.done(function(data) {
            location.reload();
        });
        send.fail(function(jqXHR, textStatus, errorThrown) {
            $('#loading').modal('hide');
            alert("Get Store Details Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            //$('#reloading').modal('show');
            //location.reload();
        });
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

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
    });
}
