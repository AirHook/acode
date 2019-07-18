var TableDatatablesManaged = function () {

	var base_url = $('body').data('base_url');
	
    var initTable = function () {
		
        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow) {
			$('#cancel_edit_user').fadeIn('slow');
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<a class="edit" href="javascript:;">Save</a>';
            jqTds[1].innerHTML = aData[1];		// admin_sales_id
            jqTds[2].innerHTML = '<input type="text" class="form-control input-sm input-small" value="' + aData[2] + '">'; // admin_sales_user
            jqTds[3].innerHTML = '<input type="text" class="form-control input-sm input-small" value="' + aData[3] + '">'; // admin_sales_lname
            jqTds[4].innerHTML = '<input type="text" class="form-control input-sm input-small" value="' + aData[4] + '">'; // admin_sales_email
            jqTds[5].innerHTML = '<input type="text" class="form-control input-sm input-small" value="' + aData[5] + '">'; // admin_sales_designer
            jqTds[6].innerHTML = '<input type="text" class="form-control input-sm " value="' + aData[6] + '">'; // access_level
            jqTds[7].innerHTML = '<input type="text" class="form-control input-sm " value="' + aData[7] + '">'; // is_active
            jqTds[8].innerHTML = '<a class="cancel" href="javascript:;">Cancel</a>';
        }

        function saveRow(oTable, nRow) {
			$('#reloading .modal-body .modal-body-text').html('');
			$('#reloading .modal-header .modal-title').html('Saving...');
			$('#reloading').modal('show');
			
            var aData = oTable.fnGetData(nRow);
            var jqInputs = $('input', nRow);
			
			$.ajax({
				type: "POST",
				url: base_url + "admin/users/sales/csv/update",
				data: {
					"csrf_token_shop7thavenue":$('input[name=csrf_token_shop7thavenue]').val(),
					"admin_sales_id":aData[1],
					"admin_sales_user":jqInputs[0].value,
					"admin_sales_lname":jqInputs[1].value,
					"admin_sales_email":jqInputs[2].value,
					"admin_sales_designer":jqInputs[3].value,
					"access_level":jqInputs[4].value,
					"is_active":jqInputs[5].value
				},
				success: function(data) {
					var returnUserId;
					if (data) returnUserId = data;
					else returnUserId = aData[1];
					oTable.fnUpdate('<a class="edit" href="javascript:;">Edit</a>', nRow, 0, false);
					oTable.fnUpdate(returnUserId, nRow, 1, false);
					oTable.fnUpdate(jqInputs[0].value, nRow, 2, false);
					oTable.fnUpdate(jqInputs[1].value, nRow, 3, false);
					oTable.fnUpdate(jqInputs[2].value, nRow, 4, false);
					oTable.fnUpdate(jqInputs[3].value, nRow, 5, false);
					oTable.fnUpdate(jqInputs[4].value, nRow, 6, false);
					oTable.fnUpdate(jqInputs[5].value, nRow, 7, false);
					oTable.fnUpdate('<a class="delete" href="javascript:;">Delete</a>', nRow, 8, false);
					oTable.fnDraw();
					$('#reloading').modal('hide');
					$('#information_updated').show();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					restoreRow(oTable, nEditing);
					$('#reloading').modal('hide');
					$('#an_error_occured').show();
				}
			});
			
			$('#cancel_edit_user').fadeOut('slow');
        }

        function cancelEditRow(oTable, nRow) {
			$('#cancel_edit_user').fadeOut('slow');
            var aData = oTable.fnGetData(nRow);
            var jqInputs = $('input', nRow);
            oTable.fnUpdate('<a class="edit" href="javascript:;">Edit</a>', nRow, 0, false);
            oTable.fnUpdate(aData[1], nRow, 1, false);
            oTable.fnUpdate(jqInputs[0].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 3, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 4, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 5, false);
            oTable.fnUpdate(jqInputs[4].value, nRow, 6, false);
            oTable.fnUpdate(jqInputs[5].value, nRow, 7, false);
            oTable.fnDraw();
        }

        var table = $('#tbl-users_sales_csv');

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

            "bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
			
            "lengthMenu": [
                [5, 10, 25, 50, 100, 500, -1],
                [5, 10, 25, 50, 100, 500, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 5,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [0, 8]
                }, 
                {
                    "searchable": false,
                    "targets": [0, 8]
                },
                {
                    "className": "dt-right", 
                    //"targets": [2]
                }
            ],
            "order": [
                [1, "asc"]
            ] // set a column as a default sort by asc
        });

        var tableWrapper = jQuery('#tbl-users_sales_csv_wrapper');
		
		// increase wrapper div bottom margin to accomodate for the dropdown
		tableWrapper.css('margin-bottom', '65px');

        var nEditing = null;
        var nNew = false;
		
		// on click of ADD NEW button
		// adds a new row with blank input elements
        $('#add_new_user').click(function (e) {
            e.preventDefault();
			
			// clear search/filter box before adding the new input fields
			$('input[type="search"]').val('').keyup();

            if (nNew || nEditing) {
                if (confirm("Previose row not saved. Do you want to save it ?")) {
                    saveRow(oTable, nEditing); // save
                    $(nEditing).find("td:first").html("Untitled");
                    nEditing = null;
                    nNew = false;

                } else {
                    //oTable.fnDeleteRow(nEditing); // cancel
                    //nEditing = null;
                    //nNew = false;
					
                    //return;
                    
					// cancel and restore old before continuing on add new mode
					restoreRow(oTable, nEditing); 
                }
            }
			
			// reset back to first page with sorting to original config setup
			oTable.fnSort([1, "asc"]);

			// create new row and edit it
            var aiNew = oTable.fnAddData(['', '', '', '', '', '', '', '', '']);
            var nRow = oTable.fnGetNodes(aiNew[0]);
            editRow(oTable, nRow);
            nEditing = nRow;
            nNew = true;
        });

		// delete row
        table.on('click', '.delete', function (e) {
            e.preventDefault();

            if (confirm("Are you sure to delete this row ?" + "\n" + "This cannot be undone !") == false) {
                return;
            }

			// show the popup modal
			$('#reloading .modal-body .modal-body-text').html('');
			$('#reloading .modal-header .modal-title').html('Deleting...');
			$('#reloading').modal('show');
			
			/* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];
			
            //alert("Deleted! Do not forget to do some ajax to sync with backend :)");
			// get the data and send info to server for record deletion
			var aData = oTable.fnGetData(nRow);
			$.ajax({
				url: base_url + "admin/users/sales/csv/del/index/" + aData[1],
				success: function(data) {
					$('#reloading').modal('hide');
				},
				error: function(jqXHR, textStatus, errorThrown) {
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					restoreRow(oTable, nEditing);
					$('#reloading').modal('hide');
				}
			});
			
			// delete the row at front end
            oTable.fnDeleteRow(nRow);
        });

		// on cancel edit
        table.on('click', '.cancel', function (e) {
            e.preventDefault();
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
			$('#cancel_edit_user').fadeOut('slow');
        });

		// on click edit/save
        table.on('click', '.edit', function (e) {
            e.preventDefault();
            
            /* Get the row as a parent of the link that was clicked on */
            var nRow = $(this).parents('tr')[0];

            if (nEditing !== null && nEditing != nRow) {
                /* Currently editing - but not this row - restore the old before continuing to edit mode */
                if (confirm("Previose row not saved. Do you want to save it ?")) {
                    saveRow(oTable, nEditing); // save
                    $(nEditing).find("td:first").html("Untitled");
                } else {
					//  before continuing to new edit mode
					if (nNew) {
						// remove the add new edit row
						oTable.fnDeleteRow(nEditing);
					} else {
						// restore the old
						restoreRow(oTable, nEditing);
					}
                }
				// continue edit mode
				editRow(oTable, nRow);
				nEditing = nRow;
            } else if (nEditing == nRow && this.innerHTML == "Save") {
                /* Editing this row and want to save it */
                saveRow(oTable, nEditing);
                nEditing = null;
                //alert("Updated! Do not forget to do some ajax to sync with backend :)");
            } else {
                /* No edit in progress - let's start one */
                editRow(oTable, nRow);
                nEditing = nRow;
            }
			
            nNew = false;
        });
		
		// listen for search and cancel any edit in progress new or not
		$('input[type="search"]').on('focus', function () {
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
			$('#cancel_edit_user').fadeOut('slow');
		});
		
		// cancel edit button outside of table
		$('#cancel_edit_user').click(function(){
            if (nNew) {
                oTable.fnDeleteRow(nEditing);
                nEditing = null;
                nNew = false;
            } else {
                restoreRow(oTable, nEditing);
                nEditing = null;
            }
			$(this).fadeOut('slow');
		});
    }
	
	// file input actions
	// clear the file input data on close of modal via buttons
	$('.modal-close_btn').click(function(){
		$('.fileinput').fileinput('clear');
	});
	// clear the file input data on close of modal via click outside the modal
	$('#modal-csv_upload').click(function(e){
		if(e.target==this){
			$('.fileinput').fileinput('clear');
		}
	});
	$('.fileinput').on('change.bs.fileinput', function(){
		$('#btn-csv_upload').prop("disabled", false);
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