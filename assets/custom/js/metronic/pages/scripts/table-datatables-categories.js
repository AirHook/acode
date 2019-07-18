var TableDatatablesManaged = function () {

	var base_url = $('body').data('base_url');

    var initCatGeneral = function () {

        var table = $('#tbl-categories_general');

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
                "search": "Search Category Name:",
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
                [50, 100, -1],
                [50, 100, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 50,
            "pagingType": "bootstrap_full_number",
			"ordering"	: false, // disable ordering of columns
            "columnDefs": [
                {
                    "width": "30px",
                    "targets": [0, 1]
                },
                {
                    "searchable": false,
                    "targets": [0, 1, 3, 4]
                },
                {
                    "className": "dt-right",
                    //"targets": [2]
                }
            ],
            "order": [
                //[2, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#tbl-categories_general_wrapper');

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
					$('#bulk_actions_select-general').prop("disabled", false);
					$('#apply_bulk_actions-general').prop("disabled", false);
					$('#heading_checkbox-general').prop("checked", true);
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select-general').prop("disabled", true);
					$('#bulk_actions_select-general').selectpicker("val", "");
 					$('#apply_bulk_actions-general').prop("disabled", true);
					$('#heading_checkbox-general').prop("checked", false);
                }
				$('#bulk_actions_select-general').selectpicker("refresh");
            });
        });

		// table row checkboxes change function
        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
			// add other custom javascripts here...
            var checked = jQuery(this).is(":checked");
			if (checked) {
				$('#bulk_actions_select-general').prop("disabled", false);
				$('#apply_bulk_actions-general').prop("disabled", false);
				$('#heading_checkbox-general').prop("checked", true);
			} else {
				if ($('.checkboxes:checked').length == 0) {
                    $('#heading_checkbox-general').prop("checked", false);
					$('#bulk_actions_select-general').selectpicker("val", "");
					$('#bulk_actions_select-general').prop("disabled", true);
					$('#apply_bulk_actions-general').prop("disabled", true);
					$('#heading_checkbox-general').prop("checked", false);
				}
			}
			$('#bulk_actions_select-general').selectpicker("refresh");
        });

		// apply button scripts
		$('#apply_bulk_actions-general').click(function(){
			var x = document.getElementById("bulk_actions_select-general").selectedIndex;
			var y = document.getElementById("bulk_actions_select-general").options;
			var z = y[x].value;
			if (!z) {
				alert("Please select an action to take.");
				return false;
			} else {
				$('#confirm_bulk_actions-general-' + z).modal('toggle');
				return false;
			}
		});

		// submit bulk action form script
		$('.submit-bulk-action-form').click(function(){
			$('#form-categories_bulk_actions-general').submit();
		});

		// category filter drop down action
		$('#filter_categories').on('click', function(){
			var filter = $('[name="designer"]').val();
			if (filter == 'general_categories')
				window.location.href = base_url + "admin/categories.html";
			else
				window.location.href = base_url + "admin/categories/index/" + filter + ".html";
		});
    }

    var initCatDesigners = function () {

		$('.tbl-categories_designers').each(function(){

			var table = $(this);

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
					"search": "Search Category Name:",
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

				"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

				"lengthMenu": [
					[15, 50, 100, -1],
					[15, 50, 100, "All"] // change per page values here
				],
				// set the initial value
				"pageLength": 15,
				"pagingType": "bootstrap_full_number",
				"ordering"	: false, // disable ordering of columns
				"columnDefs": [
					{
						"width": "30px",
						"targets": [1]
					},
					{
						"searchable": false,
						"targets": [0, 1, 3, 4]
					}
				],
				"order": [
					//[2, "asc"]
				] // set first column as a default sort by asc
			});

			var tableWrapper = jQuery(table.attr('data-table'));

			var designer = table.attr('data-designer');

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
						$('#bulk_actions_select-'+designer).prop("disabled", false);
						$('#apply_bulk_actions-'+designer).prop("disabled", false);
						$('#heading_checkbox-'+designer).prop("checked", true);
					} else {
						$(this).prop("checked", false);
						$(this).parents('tr').removeClass("active");
						// add other custom javascripts here...
						$('#bulk_actions_select-'+designer).prop("disabled", true);
						$('#bulk_actions_select-'+designer).selectpicker("val", "");
						$('#apply_bulk_actions-'+designer).prop("disabled", true);
						$('#heading_checkbox-'+designer).prop("checked", false);
					}
					$('#bulk_actions_select-'+designer).selectpicker("refresh");
				});
			});

			// table row checkboxes change function
			table.on('change', 'tbody tr .checkboxes', function () {
				$(this).parents('tr').toggleClass("active");
				// add other custom javascripts here...
				var checked = jQuery(this).is(":checked");
				if (checked) {
					$('#bulk_actions_select-'+designer).prop("disabled", false);
					$('#apply_bulk_actions-'+designer).prop("disabled", false);
					$('#heading_checkbox-'+designer).prop("checked", true);
				} else {
					if ($('.checkboxes:checked').length == 0) {
						$('#heading_checkbox-'+designer).prop("checked", false);
						$('#bulk_actions_select-'+designer).selectpicker("val", "");
						$('#bulk_actions_select-'+designer).prop("disabled", true);
						$('#apply_bulk_actions-'+designer).prop("disabled", true);
						$('#heading_checkbox-'+designer).prop("checked", false);
					}
				}
				$('#bulk_actions_select-'+designer).selectpicker("refresh");
			});

			// apply button scripts
			$('#apply_bulk_actions-'+designer).click(function(){
				var x = document.getElementById("bulk_actions_select-"+designer).selectedIndex;
				var y = document.getElementById("bulk_actions_select-"+designer).options;
				var z = y[x].value;
				if (!z) {
					alert("Please select an action to take.");
					return false;
				} else {
					$('#confirm_bulk_actions-' + designer + '-' + z).modal('toggle');
					return false;
				}
			});

			// submit bulk action form script
			$('.submit-bulk-action-form-designers').click(function(){
				var tableFormId = $(this).attr('data-form');
				$(tableFormId).submit();
			});
		});
    }

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

            if (!jQuery().dataTable) {
                return;
            }

			initCatGeneral();
			initCatDesigners();
        }

    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
    });
}
