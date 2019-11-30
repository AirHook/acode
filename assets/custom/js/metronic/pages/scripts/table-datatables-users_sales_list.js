var TableDatatablesManaged = function () {

    var base_url = $('body').data('base_url');

    var initTable = function () {

        var table = $('#tbl-users_sales');

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
                [25, 50, 100, -1],
                [25, 50, 100, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 25,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [0, 1, 7]
                },
                {
                    "width": "30px",
                    "targets": [1]
                },
                {
                    "searchable": false,
                    "targets": [0, 1, 7]
                },
                {
                    "className": "dt-right",
                    //"targets": [2]
                }
            ],
            "order": [
                //[2, "asc"]
            ] // set a column as a default sort by asc
        });

        var tableWrapper = jQuery('#tbl-admin_users_wrapper');

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
					$('#heading_checkbox').prop("checked", true);
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select').prop("disabled", true);
					$('#bulk_actions_select').selectpicker("val", "");
 					$('#apply_bulk_actions').prop("disabled", true);
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
				$('#apply_bulk_actions').prop("disabled", false);
				$('#heading_checkbox').prop("checked", true);
			} else {
				if ($('.checkboxes:checked').length == 0) {
                    $('#heading_checkbox').prop("checked", false);
					$('#bulk_actions_select').selectpicker("val", "");
					$('#bulk_actions_select').prop("disabled", true);
					$('#apply_bulk_actions').prop("disabled", true);
					$('#heading_checkbox').prop("checked", false);
				}
			}
			$('#bulk_actions_select').selectpicker("refresh");
        });
    }

    // header checkbox change function
    // get the "data-set" attribute and look for each (look for all rows checkboxes)
    // if header checkbos is checked, check row checkboxes and set row as active
    $('#tbl-users_sales_').find('.group-checkable').change(function () {
        var set = jQuery(this).attr("data-set");
        var checked = jQuery(this).is(":checked");
        jQuery(set).each(function () {
            if (checked) {
                $(this).prop("checked", true);
                $(this).parents('tr').addClass("active");
                // add other custom javascripts here...
                $('#bulk_actions_select').prop("disabled", false);
                $('#apply_bulk_actions').prop("disabled", false);
                $('#heading_checkbox').prop("checked", true);
            } else {
                $(this).prop("checked", false);
                $(this).parents('tr').removeClass("active");
                // add other custom javascripts here...
                $('#bulk_actions_select').prop("disabled", true);
                $('#bulk_actions_select').selectpicker("val", "");
                $('#apply_bulk_actions').prop("disabled", true);
                $('#heading_checkbox').prop("checked", false);
            }
            $('#bulk_actions_select').selectpicker("refresh");
        });
    });

    // table row checkboxes change function
    $('#tbl-users_sales_').on('change', 'tbody tr .checkboxes', function () {
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
                $('#heading_checkbox').prop("checked", false);
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
                window.location.href = base_url + "admin/users/sales/" + page_param + ".html";
            }else{
                window.location.href = base_url + "admin/users/sales/" + page_param + "/index/" + z + ".html";
            }
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

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
    });
}
