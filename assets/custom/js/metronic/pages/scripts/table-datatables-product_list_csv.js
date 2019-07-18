var TableDatatablesManaged = function () {

	//var base_url = window.location.origin;
	var base_url = $('body').data('base_url');

	var active_category = $('select[name="category"]').val(); // get default category
	var active_designer = $('select[name="category"]').attr('data-active_designer'); // get active designer

	// totl number of columns
	var noOfColumns = $('#tbl-product_list_csv').data('number_of_colums');
	var endColumn = noOfColumns - 1

	// size mode
	var sizeMode = $('#tbl-product_list_csv').data('size_mode');

    var initTable = function () {

		var table = $('#tbl-product_list_csv');

        function restoreRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);

            for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                oTable.fnUpdate(aData[i], nRow, i, false);
            }

            oTable.fnDraw();
        }

        function editRow(oTable, nRow) {
			$('#cancel_edit').fadeIn('slow');
            var aData = oTable.fnGetData(nRow);
            var jqTds = $('>td', nRow);
            jqTds[0].innerHTML = '<a class="edit" href="javascript:;">Save</a> / <a class="cancel" href="javascript:;">Cancel</a>';
            jqTds[1].innerHTML = aData[1];		// prod_id
            jqTds[2].innerHTML = '<input type="text" class="form-control input-sm input-small" value="' + aData[2] + '">'; // prod_no
            jqTds[3].innerHTML = '<input type="text" class="form-control input-sm input-large" value="' + aData[3] + '">'; // prod_name
            jqTds[4].innerHTML = '<input type="text" class="form-control input-sm input-large" value="' + aData[4] + '">'; // prod_desc
            jqTds[5].innerHTML = '<input type="text" class="form-control input-sm input-small" value="' + aData[5] + '">'; 				// prod_date
            jqTds[6].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[6] + '">'; // seque
            jqTds[7].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[7] + '">'; // public
            jqTds[8].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[8] + '">'; // publish
            jqTds[9].innerHTML = '<input type="text" class="form-control input-sm input-small" value="' + aData[9] + '">'; // publish_date
            jqTds[10].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[10] + '">'; 				// size_mode

            jqTds[11].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[11] + '">'; // categories

            jqTds[12].innerHTML = '<input type="text" class="form-control input-sm input-small" value="' + aData[12] + '">'; // cat
            jqTds[13].innerHTML = '<input type="text" class="form-control input-sm input-small" value="' + aData[13] + '">'; // subcat
            jqTds[14].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[14] + '">'; // retail_price
            jqTds[15].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[15] + '">'; 				// on_sale_price
            jqTds[16].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[16] + '">'; // wholesale_price
            jqTds[17].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[17] + '">'; // clearance_price
            jqTds[18].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[18] + '">'; // designer
            jqTds[19].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[19] + '">'; // vendor
            jqTds[20].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[20] + '">'; 				// vendor_code
            jqTds[21].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[21] + '">'; // vendor_type
            jqTds[22].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[22] + '">'; // styles_facet
            jqTds[23].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[23] + '">'; // events_facet
            jqTds[24].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[24] + '">'; // materials_facet
            jqTds[25].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[25] + '">'; 				// trends_facet
            jqTds[26].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[26] + '">'; // colors_facet
            jqTds[27].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[27] + '">'; // clearance
            jqTds[28].innerHTML = aData[28];		// stock_id
            jqTds[29].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[29] + '">'; // color_name
            jqTds[30].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[30] + '">'; 				// color_publish
            jqTds[31].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[31] + '">'; // primary_color
            jqTds[32].innerHTML = '<input type="text" class="form-control input-sm input-medium" value="' + aData[32] + '">'; // stock_date
			if (sizeMode == '1') {
            jqTds[33].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[33] + '">'; // size_0
            jqTds[34].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[34] + '">'; // size_2
            jqTds[35].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[35] + '">'; // size_4
            jqTds[36].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[36] + '">'; // size_6
            jqTds[37].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[37] + '">'; // size_8
            jqTds[38].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[38] + '">'; // size_10
            jqTds[39].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[39] + '">'; // size_12
            jqTds[40].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[40] + '">'; // size_14
            jqTds[41].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[41] + '">'; // size_16
            jqTds[42].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[42] + '">'; // size_18
            jqTds[43].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[43] + '">'; // size_20
            jqTds[44].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[44] + '">'; // size_22
            jqTds[45].innerHTML = '<a class="edit" href="javascript:;">Save</a> / <a class="cancel" href="javascript:;">Cancel</a>';
			}
			if (sizeMode == '0') {
            jqTds[33].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[33] + '">'; // size_ss
            jqTds[34].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[34] + '">'; // size_sm
            jqTds[35].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[35] + '">'; // size_sl
            jqTds[36].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[36] + '">'; // size_sxl
            jqTds[37].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[37] + '">'; // size_sxxl
            jqTds[38].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[38] + '">'; // size_sxl1
            jqTds[39].innerHTML = '<input type="text" class="form-control input-sm input-xsmall" value="' + aData[39] + '">'; // size_sxl2
            jqTds[40].innerHTML = '<a class="edit" href="javascript:;">Save</a> / <a class="cancel" href="javascript:;">Cancel</a>';
			}
        }

        function saveRow(oTable, nRow) {
            var aData = oTable.fnGetData(nRow);
            var jqInputs = $('input', nRow);
			var dataObject = table.data('object_data');

			// let's create the dataObject so we can utilize the 'if' condition for size_mode
			//dataObject.csrf_token_shop7thavenue = $('input[name=csrf_token_shop7thavenue]').val();
			dataObject.prod_id = aData[1];	// prod_id
			dataObject.prod_no = jqInputs[0].value;
			dataObject.prod_name = jqInputs[1].value;
			dataObject.prod_desc = jqInputs[2].value;
				dataObject.prod_date = jqInputs[3].value;
			dataObject.seque = jqInputs[4].value;
			dataObject.public = jqInputs[5].value;
			dataObject.publish = jqInputs[6].value;
			dataObject.publish_date = jqInputs[7].value;
				dataObject.size_mode = jqInputs[8].value;

			dataObject.categories = jqInputs[9].value;

			dataObject.cat = jqInputs[10].value;
			dataObject.subcat = jqInputs[11].value;
			dataObject.less_discount = jqInputs[12].value;
				dataObject.catalogue_price = jqInputs[13].value;
			dataObject.wholesale_price = jqInputs[14].value;
			dataObject.wholesale_price_clearance = jqInputs[15].value;
			dataObject.designer = jqInputs[16].value;
			dataObject.vendor = jqInputs[17].value;
				dataObject.vendor_code = jqInputs[18].value;
			dataObject.vendor_type = jqInputs[19].value;
			dataObject.styles = jqInputs[20].value;
			dataObject.events = jqInputs[21].value;
			dataObject.materials = jqInputs[22].value;
				dataObject.trends = jqInputs[23].value;
			dataObject.color_facets = jqInputs[24].value;
			dataObject.clearance = jqInputs[25].value;
			dataObject.st_id = aData[28];	// st_id
			dataObject.color_name = jqInputs[26].value;
				dataObject.color_publish = jqInputs[27].value;
			dataObject.primary_color = jqInputs[28].value;
			dataObject.stock_date = jqInputs[29].value;
			if (sizeMode == '1') {
				dataObject.size_0 = jqInputs[30].value;
				dataObject.size_2 = jqInputs[31].value;
				dataObject.size_4 = jqInputs[32].value;
				dataObject.size_6 = jqInputs[33].value;
				dataObject.size_8 = jqInputs[34].value;
				dataObject.size_10 = jqInputs[35].value;
				dataObject.size_12 = jqInputs[36].value;
				dataObject.size_14 = jqInputs[37].value;
				dataObject.size_16 = jqInputs[38].value;
				dataObject.size_18 = jqInputs[39].value;
				dataObject.size_20 = jqInputs[40].value;
				dataObject.size_22 = jqInputs[41].value;
			}
			if (sizeMode == '0') {
				dataObject.size_ss = jqInputs[30].value;
				dataObject.size_sm = jqInputs[31].value;
				dataObject.size_sl = jqInputs[32].value;
				dataObject.size_sxl = jqInputs[33].value;
				dataObject.size_sxxl = jqInputs[34].value;
				dataObject.size_sxl1 = jqInputs[35].value;
				dataObject.size_sxl2 = jqInputs[36].value;
			}

			$('#reloading .modal-body .modal-body-text').html('');
			$('#reloading .modal-header .modal-title').html('Saving...');
			$('#reloading').modal('show');

			//str = JSON.stringify(dataObject, null, 4);
			//alert(str);

			$.ajax({
				type: "POST",
				url: base_url + "admin/products/csv/update",
				data: dataObject,
				success: function(data) {
					var returnProdId;
					var returnStId;
					if (data) {
						returnProdId = data.prod_id;
						returnStId = data.st_id;
					} else {
						returnProdId = aData[1];
						returnStId = aData[27];
					}
					oTable.fnUpdate('<a class="edit" href="javascript:;">Edit</a>', nRow, 0, false);
					oTable.fnUpdate(returnProdId, nRow, 1, false);		// prod_id
					oTable.fnUpdate(jqInputs[0].value, nRow, 2, false); // prod_no
					oTable.fnUpdate(jqInputs[1].value, nRow, 3, false); // prod_name
					oTable.fnUpdate(jqInputs[2].value, nRow, 4, false); // prod_desc
					oTable.fnUpdate(jqInputs[3].value, nRow, 5, false); // prod_date
					oTable.fnUpdate(jqInputs[4].value, nRow, 6, false); // seque
					oTable.fnUpdate(jqInputs[5].value, nRow, 7, false); // public
					oTable.fnUpdate(jqInputs[6].value, nRow, 8, false); // publish
					oTable.fnUpdate(jqInputs[7].value, nRow, 9, false); // publish_date
					oTable.fnUpdate(jqInputs[8].value, nRow, 10, false); // size_mode

					oTable.fnUpdate(jqInputs[9].value, nRow, 11, false); // categories

					oTable.fnUpdate(jqInputs[10].value, nRow, 12, false);
					oTable.fnUpdate(jqInputs[11].value, nRow, 13, false);
					oTable.fnUpdate(jqInputs[12].value, nRow, 14, false);
					oTable.fnUpdate(jqInputs[13].value, nRow, 15, false);
					oTable.fnUpdate(jqInputs[14].value, nRow, 16, false);
					oTable.fnUpdate(jqInputs[15].value, nRow, 17, false);
					oTable.fnUpdate(jqInputs[16].value, nRow, 18, false);
					oTable.fnUpdate(jqInputs[17].value, nRow, 19, false);
					oTable.fnUpdate(jqInputs[18].value, nRow, 20, false);
					oTable.fnUpdate(jqInputs[19].value, nRow, 21, false);
					oTable.fnUpdate(jqInputs[20].value, nRow, 22, false);
					oTable.fnUpdate(jqInputs[21].value, nRow, 23, false);
					oTable.fnUpdate(jqInputs[22].value, nRow, 24, false);
					oTable.fnUpdate(jqInputs[23].value, nRow, 25, false);
					oTable.fnUpdate(jqInputs[24].value, nRow, 26, false);
					oTable.fnUpdate(jqInputs[25].value, nRow, 27, false);
					oTable.fnUpdate(returnStId, nRow, 28, false);		// st_id
					oTable.fnUpdate(jqInputs[26].value, nRow, 29, false);
					oTable.fnUpdate(jqInputs[27].value, nRow, 30, false);
					oTable.fnUpdate(jqInputs[28].value, nRow, 31, false);
					oTable.fnUpdate(jqInputs[29].value, nRow, 32, false);
					if (sizeMode == '1') {
						oTable.fnUpdate(jqInputs[30].value, nRow, 33, false);
						oTable.fnUpdate(jqInputs[31].value, nRow, 34, false);
						oTable.fnUpdate(jqInputs[32].value, nRow, 35, false);
						oTable.fnUpdate(jqInputs[33].value, nRow, 36, false);
						oTable.fnUpdate(jqInputs[34].value, nRow, 37, false);
						oTable.fnUpdate(jqInputs[35].value, nRow, 38, false);
						oTable.fnUpdate(jqInputs[36].value, nRow, 39, false);
						oTable.fnUpdate(jqInputs[37].value, nRow, 40, false);
						oTable.fnUpdate(jqInputs[38].value, nRow, 41, false);
						oTable.fnUpdate(jqInputs[39].value, nRow, 42, false);
						oTable.fnUpdate(jqInputs[40].value, nRow, 43, false);
						oTable.fnUpdate(jqInputs[41].value, nRow, 44, false);
						oTable.fnUpdate('<a class="delete" href="javascript:;">Delete</a>', nRow, 45, false);
					}
					if (sizeMode == '0') {
						oTable.fnUpdate(jqInputs[30].value, nRow, 33, false);
						oTable.fnUpdate(jqInputs[31].value, nRow, 34, false);
						oTable.fnUpdate(jqInputs[32].value, nRow, 35, false);
						oTable.fnUpdate(jqInputs[33].value, nRow, 36, false);
						oTable.fnUpdate(jqInputs[34].value, nRow, 37, false);
						oTable.fnUpdate(jqInputs[35].value, nRow, 38, false);
						oTable.fnUpdate(jqInputs[36].value, nRow, 38, false);
						oTable.fnUpdate('<a class="delete" href="javascript:;">Delete</a>', nRow, 40, false);
					}
					oTable.fnDraw();
					$('#reloading').modal('hide');
					$('#information_updated').show();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					restoreRow(oTable, nEditing);
					$('#reloading').modal('hide');
					$('#an_error_occured').show();
				}
			});

			$('#cancel_edit').fadeOut('slow');
        }

        function cancelEditRow(oTable, nRow) {
			$('#cancel_edit').fadeOut('slow');
            var aData = oTable.fnGetData(nRow);
            var jqInputs = $('input', nRow);
            oTable.fnUpdate('<a class="edit" href="javascript:;">Edit</a>', nRow, 0, false);
            oTable.fnUpdate(aData[1], nRow, 1, false);		// prod_id
            oTable.fnUpdate(jqInputs[0].value, nRow, 2, false);
            oTable.fnUpdate(jqInputs[1].value, nRow, 3, false);
            oTable.fnUpdate(jqInputs[2].value, nRow, 4, false);
            oTable.fnUpdate(jqInputs[3].value, nRow, 5, false);
            oTable.fnUpdate(jqInputs[4].value, nRow, 6, false);
            oTable.fnUpdate(jqInputs[5].value, nRow, 7, false);
            oTable.fnUpdate(jqInputs[6].value, nRow, 8, false);
            oTable.fnUpdate(jqInputs[7].value, nRow, 9, false);
            oTable.fnUpdate(jqInputs[8].value, nRow, 10, false);

            oTable.fnUpdate(jqInputs[8].value, nRow, 10, false); // categories

            oTable.fnUpdate(jqInputs[9].value, nRow, 11, false);
            oTable.fnUpdate(jqInputs[10].value, nRow, 12, false);
            oTable.fnUpdate(jqInputs[11].value, nRow, 13, false);
            oTable.fnUpdate(jqInputs[12].value, nRow, 14, false);
            oTable.fnUpdate(jqInputs[13].value, nRow, 15, false);
            oTable.fnUpdate(jqInputs[14].value, nRow, 16, false);
            oTable.fnUpdate(jqInputs[15].value, nRow, 17, false);
            oTable.fnUpdate(jqInputs[16].value, nRow, 18, false);
			oTable.fnUpdate(jqInputs[17].value, nRow, 19, false);
			oTable.fnUpdate(jqInputs[18].value, nRow, 20, false);
			oTable.fnUpdate(jqInputs[19].value, nRow, 21, false);
			oTable.fnUpdate(jqInputs[20].value, nRow, 22, false);
			oTable.fnUpdate(jqInputs[21].value, nRow, 23, false);
			oTable.fnUpdate(jqInputs[22].value, nRow, 24, false);
			oTable.fnUpdate(jqInputs[23].value, nRow, 25, false);
			oTable.fnUpdate(jqInputs[24].value, nRow, 26, false);
			oTable.fnUpdate(aData[27], nRow, 27, false);		// st_id
			oTable.fnUpdate(jqInputs[25].value, nRow, 28, false);
			oTable.fnUpdate(jqInputs[26].value, nRow, 29, false);
			oTable.fnUpdate(jqInputs[27].value, nRow, 30, false);
			oTable.fnUpdate(jqInputs[28].value, nRow, 31, false);
			if (sizeMode == '1') {
				oTable.fnUpdate(jqInputs[29].value, nRow, 32, false);
				oTable.fnUpdate(jqInputs[30].value, nRow, 33, false);
				oTable.fnUpdate(jqInputs[31].value, nRow, 34, false);
				oTable.fnUpdate(jqInputs[32].value, nRow, 35, false);
				oTable.fnUpdate(jqInputs[33].value, nRow, 36, false);
				oTable.fnUpdate(jqInputs[34].value, nRow, 37, false);
				oTable.fnUpdate(jqInputs[35].value, nRow, 38, false);
				oTable.fnUpdate(jqInputs[36].value, nRow, 39, false);
				oTable.fnUpdate(jqInputs[37].value, nRow, 40, false);
				oTable.fnUpdate(jqInputs[38].value, nRow, 41, false);
				oTable.fnUpdate(jqInputs[39].value, nRow, 42, false);
				oTable.fnUpdate(jqInputs[40].value, nRow, 43, false);
			}
			if (sizeMode == '0') {
				oTable.fnUpdate(jqInputs[29].value, nRow, 32, false);
				oTable.fnUpdate(jqInputs[30].value, nRow, 33, false);
				oTable.fnUpdate(jqInputs[31].value, nRow, 34, false);
				oTable.fnUpdate(jqInputs[32].value, nRow, 35, false);
				oTable.fnUpdate(jqInputs[33].value, nRow, 36, false);
				oTable.fnUpdate(jqInputs[34].value, nRow, 37, false);
				oTable.fnUpdate(jqInputs[35].value, nRow, 38, false);
			}
            oTable.fnDraw();
        }

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

			// re-render category select drop down
			/*
			"drawCallback": function(settings){
				// force re-render on bs-select items
				$('select[name="category"]').find('.all-options').hide(); // hide all options first
				$('select[name="category"]').find('.' +  active_designer).show(); // show categories of active designer
				$('select[name="designer"]').selectpicker('val', active_designer);
				$('select[name="category"]').selectpicker('val', active_category);
			},
			*/

            "lengthMenu": [
                [5, 25, 100, 250, 500, -1],
                [5, 25, 100, 250, 500, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 100,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [0, endColumn]
                },
                {
                    "searchable": false,
                    'targets': [0, endColumn]
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

        var tableWrapper = jQuery('#tbl-product_list_csv_wrapper');

		// increase wrapper div bottom margin to accomodate for the dropdown
		tableWrapper.css('margin-bottom', '65px');

        var nEditing = null;
        var nNew = false;

		// on click of ADD NEW button
		// adds a new row with blank input elements
        $('#add_new_product').click(function (e) {
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
			if (sizeMode == '1') {
				var aiNew = oTable.fnAddData([
					'', '', '', '', '', '', '', '', '', '',
					'', '', '', '', '', '', '', '', '', '',
					'', '', '', '', '', '', '', '', '', '',
					'', '',
					'', '', '', '', '', '', '', '', '', '', '', '', '', ''
				]);
			}
			if (sizeMode == '0') {
				var aiNew = oTable.fnAddData([
					'', '', '', '', '', '', '', '', '', '',
					'', '', '', '', '', '', '', '', '', '',
					'', '', '', '', '', '', '', '', '', '',
					'', '',
					'', '', '', '', '', '', '', '', ''
				]);
			}
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
				url: base_url + "admin/products/csv/del/index/" + aData[1],
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
			$('#cancel_edit').fadeOut('slow');
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
				// continue edit mode on row
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
			$('#cancel_edit').fadeOut('slow');
		});

		// cancel edit button outside of table
		$('#cancel_edit').click(function(){
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
