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

    // apply bulk action script
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
	$('.filter_by_designer_select').on('change', function(){
        var qDates1 = '';
        var from_date = $('[name="from_date"]').val();
        var to_date = $('[name="to_date"]').val();
        if (from_date && to_date){
            qDates1 = '?from_date='+from_date+'&to_date='+to_date;
        }
        var page_param = $('[name="page_param"]').val(); // ws/cs/all - $list
        var status = $('[name="status"]').val(); // new_orders/complete(shipped)/shipment_pending/store_credit/refunded
        var des_slug = $(this).val();
		if (!des_slug) {
			alert("Please select a designer to filter table.");
			return false;
		} else {
            $('#loading').modal('show');
            if (des_slug=='all'){
                window.location.href = base_url + "admin/orders/" + status + "/index/" + page_param + ".html" + qDates1;
            }else{
                window.location.href = base_url + "admin/orders/" + status + "/index/" + page_param + "/" + des_slug + ".html" + qDates1;
            }
		}
	});

    // apply filter by listings
    $('.filter_by_listing_select').on('change', function(){
        var qDates2 = '';
        var from_date = $('[name="from_date"]').val();
        var to_date = $('[name="to_date"]').val();
        if (from_date && to_date){
            qDates2 = '?from_date='+from_date+'&to_date='+to_date;
        }
        var status = $('[name="status"]').val(); // new_orders/complete(shipped)/shipment_pending/store_credit/refunded
        var des_slug = $('[name="des_slug"]').val();
        var page_param = $(this).val();
        if (page_param) {
            $('#loading').modal('show');
            if (des_slug=='all'){
                if (page_param=='all'){
                    window.location.href = base_url + "admin/orders/" + status + ".html" + qDates2;
                }else{
                    window.location.href = base_url + "admin/orders/" + status + "/index/" + page_param + ".html" + qDates2;
                }
            }else{
                window.location.href = base_url + "admin/orders/" + status + "/index/" + page_param + "/" + des_slug + ".html" + qDates2;
            }
        }
	});

    // date range script
    $('[name="to_date"]').on('change', function(){
        var qDates3 = '';
        var from_date = $('[name="from_date"]').val();
        var to_date = $(this).val();
        if (!from_date){
            alert('Please select a FROM DATE.');
            return false;
        }else{
            if (to_date < from_date){
                alert('Date Range invalid.\nDouble check dates selected.')
                $(this).val('');
                return false;
            }else{
                qDates3 = '?from_date='+from_date+'&to_date='+to_date;
                setDateRange(qDates3);
            }
        }
    });
    $('[name="from_date"]').on('change', function(){
        var qDates4 = '';
        var from_date = $(this).val();
        var to_date = $('[name="to_date"]').val();
        if (!to_date){
            return false;
        }else{
            if (to_date < from_date){
                alert('Date Range invalid.\nDouble check dates selected.')
                $(this).val('');
                return false;
            }else{
                qDates4 = '?from_date='+from_date+'&to_date='+to_date;
                setDateRange(qDates4);
            }
        }
    });
    function setDateRange(qDates){
        var qDates = '';
        var status = $('[name="status"]').val(); // new_orders/complete(shipped)/shipment_pending/store_credit/refunded
        var des_slug = $('[name="des_slug"]').val();
        var page_param = $('[name="page_param"]').val();
        $('#loading').modal('show');
        if (des_slug=='all'){
            if (page_param=='all'){
                window.location.href = base_url + "admin/orders/" + status + ".html" + qDates;
            }else{
                window.location.href = base_url + "admin/orders/" + status + "/index/" + page_param + ".html" + qDates;
            }
        }else{
            window.location.href = base_url + "admin/orders/" + status + "/index/" + page_param + "/" + des_slug + ".html" + qDates;
        }
    };

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
            url:     base_url + "admin/orders/send_order_email_confirmation.html",
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

    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
                autoclose: true,
                todayHighlight: true
                //startDate: '01/01/2000'
            });
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }

        /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */

        // Workaround to fix datepicker position on window scroll
        $( document ).scroll(function(){
            $('#form_modal2 .date-picker').datepicker('place'); //#modal is the id of the modal
        });
    }

    return {

        //main function to initiate the module
        init: function () {
            if (!jQuery().dataTable) {
                return;
            }

			initTable();
            handleDatePickers();
        }

    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        TableDatatablesManaged.init();
    });
}
