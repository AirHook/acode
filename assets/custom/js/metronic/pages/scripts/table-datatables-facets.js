var TableDatatablesManaged = function () {

    var initTableStyles = function () {

        var table = $('#tbl-facets_styles');

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
                [15, 50, -1],
                [15, 50, "All"] // change per page values here
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
                    "targets": [1]
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
            "order": [
                //[2, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#tbl-facets_styles_wrapper');

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
					$('#bulk_actions_select-styles').prop("disabled", false);
					$('#apply_bulk_actions-styles').prop("disabled", false);
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select-styles').prop("disabled", true);
					$('#bulk_actions_select-styles').selectpicker("val", "");
 					$('#apply_bulk_actions-styles').prop("disabled", true);
                }
				$('#bulk_actions_select-styles').selectpicker("refresh");
            });
        });

		// table row checkboxes change function
        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
			// add other custom javascripts here...
            var checked = jQuery(this).is(":checked");
			if (checked) {
				$('#bulk_actions_select-styles').prop("disabled", false);
				$('#apply_bulk_actions-styles').prop("disabled", false);
			} else {
				if ($('.checkboxes:checked').length == 0) {
                    $('#heading_checkbox-styles').prop("checked", false);
					$('#bulk_actions_select-styles').selectpicker("val", "");
					$('#bulk_actions_select-styles').prop("disabled", true);
					$('#apply_bulk_actions-styles').prop("disabled", true);
				}
			}
			$('#bulk_actions_select-styles').selectpicker("refresh");
        });

		// apply button scripts
		$('#apply_bulk_actions-styles').click(function(){
			var x = document.getElementById("bulk_actions_select-styles").selectedIndex;
			var y = document.getElementById("bulk_actions_select-styles").options;
			var z = y[x].value;
			if (!z) {
				alert("Please select an action to take.");
				return false;
			} else {
				$('#confirm_bulk_actions-styles-' + z).modal('toggle');
				return false;
			}
		});

    }

    var initTableColors = function () {

        var table = $('#tbl-facets_colors');

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
                [15, 50, -1],
                [15, 50, "All"] // change per page values here
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
                    "targets": [1]
                },
                {
                    "searchable": false,
                    "targets": [0, 1, 4]
                }
            ],
            "order": [
                //[2, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#tbl-facets_colors_wrapper');

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
					$('#bulk_actions_select-colors').prop("disabled", false);
					$('#apply_bulk_actions-colors').prop("disabled", false);
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select-colors').prop("disabled", true);
					$('#bulk_actions_select-colors').selectpicker("val", "");
 					$('#apply_bulk_actions-colors').prop("disabled", true);
                }
				$('#bulk_actions_select-colors').selectpicker("refresh");
            });
        });

		// table row checkboxes change function
        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
			// add other custom javascripts here...
            var checked = jQuery(this).is(":checked");
			if (checked) {
				$('#bulk_actions_select-colors').prop("disabled", false);
				$('#apply_bulk_actions-colors').prop("disabled", false);
			} else {
				if ($('.checkboxes:checked').length == 0) {
                    $('#heading_checkbox-colors').prop("checked", false);
					$('#bulk_actions_select-colors').selectpicker("val", "");
					$('#bulk_actions_select-colors').prop("disabled", true);
					$('#apply_bulk_actions-colors').prop("disabled", true);
				}
			}
			$('#bulk_actions_select-colors').selectpicker("refresh");
        });

		// apply button scripts
		$('#apply_bulk_actions-colors').click(function(){
			var x = document.getElementById("bulk_actions_select-colors").selectedIndex;
			var y = document.getElementById("bulk_actions_select-colors").options;
			var z = y[x].value;
			if (!z) {
				alert("Please select an action to take.");
				return false;
			} else {
				$('#confirm_bulk_actions-colors-' + z).modal('toggle');
				return false;
			}
		});
    }

    var initTableEvents = function () {

        var table = $('#tbl-facets_events');

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
                [15, 50, -1],
                [15, 50, "All"] // change per page values here
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
                    "targets": [1]
                },
                {
                    "searchable": false,
                    "targets": [0, 1, 4]
                }
            ],
            "order": [
                //[2, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#tbl-facets_events_wrapper');

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
					$('#bulk_actions_select-events').prop("disabled", false);
					$('#apply_bulk_actions-events').prop("disabled", false);
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select-events').prop("disabled", true);
					$('#bulk_actions_select-events').selectpicker("val", "");
 					$('#apply_bulk_actions-events').prop("disabled", true);
                }
				$('#bulk_actions_select-events').selectpicker("refresh");
            });
        });

		// table row checkboxes change function
        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
			// add other custom javascripts here...
            var checked = jQuery(this).is(":checked");
			if (checked) {
				$('#bulk_actions_select-events').prop("disabled", false);
				$('#apply_bulk_actions-events').prop("disabled", false);
			} else {
				if ($('.checkboxes:checked').length == 0) {
                    $('#heading_checkbox-events').prop("checked", false);
					$('#bulk_actions_select-events').selectpicker("val", "");
					$('#bulk_actions_select-events').prop("disabled", true);
					$('#apply_bulk_actions-events').prop("disabled", true);
				}
			}
			$('#bulk_actions_select-events').selectpicker("refresh");
        });

		// apply button scripts
		$('#apply_bulk_actions-events').click(function(){
			var x = document.getElementById("bulk_actions_select-events").selectedIndex;
			var y = document.getElementById("bulk_actions_select-events").options;
			var z = y[x].value;
			if (!z) {
				alert("Please select an action to take.");
				return false;
			} else {
				$('#confirm_bulk_actions-events-' + z).modal('toggle');
				return false;
			}
		});
    }

    var initTableTrends = function () {

        var table = $('#tbl-facets_trends');

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
                [15, 50, -1],
                [15, 50, "All"] // change per page values here
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
                    "targets": [1]
                },
                {
                    "searchable": false,
                    "targets": [0, 1, 4]
                }
            ],
            "order": [
                //[2, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#tbl-facets_trends_wrapper');

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
					$('#bulk_actions_select-trends').prop("disabled", false);
					$('#apply_bulk_actions-trends').prop("disabled", false);
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select-trends').prop("disabled", true);
					$('#bulk_actions_select-trends').selectpicker("val", "");
 					$('#apply_bulk_actions-trends').prop("disabled", true);
                }
				$('#bulk_actions_select-trends').selectpicker("refresh");
            });
        });

		// table row checkboxes change function
        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
			// add other custom javascripts here...
            var checked = jQuery(this).is(":checked");
			if (checked) {
				$('#bulk_actions_select-trends').prop("disabled", false);
				$('#apply_bulk_actions-trends').prop("disabled", false);
			} else {
				if ($('.checkboxes:checked').length == 0) {
                    $('#heading_checkbox-trends').prop("checked", false);
					$('#bulk_actions_select-trends').selectpicker("val", "");
					$('#bulk_actions_select-trends').prop("disabled", true);
					$('#apply_bulk_actions-trends').prop("disabled", true);
				}
			}
			$('#bulk_actions_select-trends').selectpicker("refresh");
        });

		// apply button scripts
		$('#apply_bulk_actions-trends').click(function(){
			var x = document.getElementById("bulk_actions_select-trends").selectedIndex;
			var y = document.getElementById("bulk_actions_select-trends").options;
			var z = y[x].value;
			if (!z) {
				alert("Please select an action to take.");
				return false;
			} else {
				$('#confirm_bulk_actions-trends-' + z).modal('toggle');
				return false;
			}
		});
    }

    var initTableMaterials = function () {

        var table = $('#tbl-facets_materials');

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
                [15, 50, -1],
                [15, 50, "All"] // change per page values here
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
                    "targets": [1]
                },
                {
                    "searchable": false,
                    "targets": [0, 1, 4]
                }
            ],
            "order": [
                //[2, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#tbl-facets_materials_wrapper');

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
					$('#bulk_actions_select-materials').prop("disabled", false);
					$('#apply_bulk_actions-materials').prop("disabled", false);
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select-materials').prop("disabled", true);
					$('#bulk_actions_select-materials').selectpicker("val", "");
 					$('#apply_bulk_actions-materials').prop("disabled", true);
                }
				$('#bulk_actions_select-materials').selectpicker("refresh");
            });
        });

		// table row checkboxes change function
        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
			// add other custom javascripts here...
            var checked = jQuery(this).is(":checked");
			if (checked) {
				$('#bulk_actions_select-materials').prop("disabled", false);
				$('#apply_bulk_actions-materials').prop("disabled", false);
			} else {
				if ($('.checkboxes:checked').length == 0) {
                    $('#heading_checkbox-materials').prop("checked", false);
					$('#bulk_actions_select-materials').selectpicker("val", "");
					$('#bulk_actions_select-materials').prop("disabled", true);
					$('#apply_bulk_actions-materials').prop("disabled", true);
				}
			}
			$('#bulk_actions_select-materials').selectpicker("refresh");
        });

		// apply button scripts
		$('#apply_bulk_actions-materials').click(function(){
			var x = document.getElementById("bulk_actions_select-materials").selectedIndex;
			var y = document.getElementById("bulk_actions_select-materials").options;
			var z = y[x].value;
			if (!z) {
				alert("Please select an action to take.");
				return false;
			} else {
				$('#confirm_bulk_actions-materials-' + z).modal('toggle');
				return false;
			}
		});
    }

    var initTableSeasons = function () {

        var table = $('#tbl-facets_seasons');

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
                [15, 50, -1],
                [15, 50, "All"] // change per page values here
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
                    "targets": [1]
                },
                {
                    "searchable": false,
                    "targets": [0, 1, 4]
                }
            ],
            "order": [
                //[2, "asc"]
            ] // set first column as a default sort by asc
        });

        var tableWrapper = jQuery('#tbl-facets_seasons_wrapper');

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
					$('#bulk_actions_select-seasons').prop("disabled", false);
					$('#apply_bulk_actions-seasons').prop("disabled", false);
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
					// add other custom javascripts here...
					$('#bulk_actions_select-seasons').prop("disabled", true);
					$('#bulk_actions_select-seasons').selectpicker("val", "");
 					$('#apply_bulk_actions-seasons').prop("disabled", true);
                }
				$('#bulk_actions_select-seasons').selectpicker("refresh");
            });
        });

		// table row checkboxes change function
        table.on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
			// add other custom javascripts here...
            var checked = jQuery(this).is(":checked");
			if (checked) {
				$('#bulk_actions_select-seasons').prop("disabled", false);
				$('#apply_bulk_actions-seasons').prop("disabled", false);
			} else {
				if ($('.checkboxes:checked').length == 0) {
                    $('#heading_checkbox-seasons').prop("checked", false);
					$('#bulk_actions_select-seasons').selectpicker("val", "");
					$('#bulk_actions_select-seasons').prop("disabled", true);
					$('#apply_bulk_actions-seasons').prop("disabled", true);
				}
			}
			$('#bulk_actions_select-seasons').selectpicker("refresh");
        });

		// apply button scripts
		$('#apply_bulk_actions-seasons').click(function(){
			var x = document.getElementById("bulk_actions_select-seasons").selectedIndex;
			var y = document.getElementById("bulk_actions_select-seasons").options;
			var z = y[x].value;
			if (!z) {
				alert("Please select an action to take.");
				return false;
			} else {
				$('#confirm_bulk_actions-seasons-' + z).modal('toggle');
				return false;
			}
		});
    }

    var autoFill = function () {

		//autofill webspace slug from domain name
		$('.facet_name').keyup(function(){
			facet = $(this).data('facet');
			text = this.value;
			text = text.toLowerCase();
			text = text.split('/').join('-');
			text = text.split(' ').join('_');
			text = text.split('.').join('_');
			text = text.split('\'').join('');
			text = text.split('"').join('');
			$('.facet_slug[data-facet="'+facet+'"]').val(text);
		});
		$('.facet_name').blur(function(){
			facet = $(this).data('facet');
			text = this.value;
			text = text.toLowerCase();
			text = text.split('/').join('-');
			text = text.split(' ').join('_');
			text = text.split('.').join('_');
			text = text.split('\'').join('');
			text = text.split('"').join('');
			$('.facet_slug[data-facet="'+facet+'"]').val(text);
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

			autoFill();
			setTab();

            if (!jQuery().dataTable) {
                return;
            }

			initTableStyles();
			initTableColors();
			initTableEvents();
			initTableTrends();
			initTableMaterials();
            initTableSeasons();
        }

    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
    });
}
