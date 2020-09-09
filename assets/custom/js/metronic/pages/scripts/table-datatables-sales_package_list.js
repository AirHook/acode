var TableDatatablesManaged = function () {

    var base_url = $('body').data('base_url');

    var initTableSalesPackages = function () {

        var table = $('#tbl-sales_packages');

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
                [15, 30, 50, -1],
                [15, 30, 50, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 15,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [0, 1, 4]
                },
                {
                    "width": "30px",
                    "targets": [0, 1]
                },
                {
                    "searchable": false,
                    "targets": [0, 1, 4]
                },
                {
                    "className": "dt-right",
                    //"targets": [2]
                }
            ],
			//"ordering": false // no ordering at all
            "order": [
                //[0, "asc"]
            ] // set first column as a default sort by asc or blank to no column default sort
        });

        var tableWrapper = jQuery('#tbl-sales_packages_wrapper');

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

	// apply button scripts
	$('#apply_bulk_actions').click(function(){
		var x = document.getElementById("bulk_actions_select").selectedIndex;
		var y = document.getElementById("bulk_actions_select").options;
		var z = y[x].value;
		if (!z) {
			alert("Please select an action to take.");
			return false;
		} else {
            if (z == 'send_to_current_user' || z == 'send_to_new_user') {
                if ($('#tbl-sales_packages tbody tr .checkboxes:checked').length > 1) {
                    alert('Select only 1 sales package');
                    return false;
                } else {
                    // code to send to user...
                }
            }
			$('#confirm_bulk_actions-' + z).modal('toggle');
			return false;
		}
	});

    // sales package sidebar nav actions
    $('.list-edit-sales-package, .list-create-sales-package').on('click', function(){
        var items_count = $(this).closest('table').data('items_count');
        var link = $(this).data('link');
        //alert(items_count);
        if (items_count != '0') {
            //$('#modal-items_on_cart .contiue-items_on_cart').attr('href', link);
            $('#modal-items_on_cart').modal('show');
            $('#modal-items_on_cart .continue-items_on_cart').click(function(){
                // continue means to clear items on cart
                $.get(base_url + "sales/sales_package/clear_all_items.html", function(data){
					// we need to wait for ajax call response before continuing
					// to alleviate session handling execution time error
                    if (data == 'clear') window.location.href=link;
				});
            });
        } else {
            window.location.href=link;
        }
    });

    // sales package sidebar nav actions
    $('.sidebar-nav-sales-package').on('click', function(){
        var items_count = $(this).closest('ul').data('items_count');
        var link = $(this).data('link');
        //alert(items_count);
        if (items_count != '0') {
            //$('#modal-items_on_cart .contiue-items_on_cart').attr('href', link);
            $('#modal-items_on_cart').modal('show');
            $('#modal-items_on_cart .continue-items_on_cart').click(function(){
                // continue means to clear items on cart
                $.get(base_url + "sales/sales_package/clear_all_items.html", function(data){
					// we need to wait for ajax call response before continuing
					// to alleviate session handling execution time error
                    if (data == 'clear') window.location.href=link;
				});
            });
        } else {
            window.location.href=link;
        }
    });

    // apply filter by designer
	$('.apply_filer_by_designer').click(function(){
		var x = document.getElementById("filter_by_designer_select").selectedIndex;
		var y = document.getElementById("filter_by_designer_select").options;
		var z = y[x].value;
		if (!z) {
			alert("Please select a designer to filter table.");
			return false;
		} else {
            $('#loading').modal('show');
            if (z=='all'){
                window.location.href = base_url + "admin/campaigns/sales_package.html";
            }else{
                window.location.href = base_url + "admin/campaigns/sales_package/index/index/" + z + ".html";
            }
		}
	});

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

			initTableSalesPackages();
        }

    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
    });
}
