var TableDatatablesManaged = function () {

    var base_url = $('body').data('base_url');
    var object_data = $('body').data('object_data');

    var initTable = function () {

        var table = $('#tbl-users_wholesale');

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

            "deferRender": true, // improve speed for large data tables

            "bStateSave": false, // save datatable state(pagination, sort, etc) in cookie.

            "lengthMenu": [
                [100, 500, 1000, 2500, -1],
                [100, 500, 1000, 2500, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 100,
            "pagingType": "bootstrap_full_number",
            "columnDefs": [
                {  // set default column settings
                    'orderable': false,
                    'targets': [0, 1, 11]
                },
                {
                    "width": "30px",
                    "targets": [0, 1]
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
                [8, "desc"]
            ] // set a column as a default sort by asc
        });

        var tableWrapper = jQuery('#tbl-wholesale_users_wrapper');

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
    $('#tbl-users_wholesale_').find('.group-checkable').change(function () {
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
    $('#tbl-users_wholesale_').on('change', 'tbody tr .checkboxes', function () {
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

    // activation popup send activation email option checkbox
    $('.activate-user').on('click', '.send_activation_email', function(){
        var parEl = $(this).closest('.activate-user');
        var checked = $(this).prop('checked');
        if (checked) {
            parEl.find('.btn-send_activation_email').show();
            parEl.find('.btn-not_send_activation_email').hide();
        } else {
            parEl.find('.btn-send_activation_email').hide();
            parEl.find('.btn-not_send_activation_email').show();
        }
    });

    // send activation email modal actions
    $('.btn.send_activation_email').on('click', function(){
        // lets get some data
        var form1 = $('#form-send_activation_email');
        var user_id = $(this).data('user_id');
        var checked = $('[name="send_activation_email-'+user_id+'"]').prop('checked');
        var url = $(this).data('url');
        var message = $('[name="send_activation_email_message-'+user_id+'"]').val();
        if (checked) {
            $('[name="user_id"]').val(user_id);
            $('[name="message"]').html(message);
            form1.attr('action', url).submit();
        }
        // clear the textarea after
        $('[name="send_activation_email_message"]').val('');
        // finally close modal
        $('.modal.send_activation_email').modal('hide');
    });

    // clear all items button action for sales resource pages using
    // wholesale users list
    $('.confirm-clear_all_items').click(function(){
        $('#modal-clear_all_items').modal('hide');
        $('#loading .modal-title').html('Clearing...');
        $('#loading').modal('show');
        // call the url using get method
        $.get(base_url + "sales/sales_package/clear_all_items.html")
        // reset items count inner html
        $('.items_count').html('0');
        // clear all summary items container
        // and replay default no items notification
        $('.summary-item-container').hide();
        $('.cart_basket_wrapper .row .no-items-notification > h4').show();
        $('.send-package-btn').hide();
        // in thumbs page...
        $('.thumb-tile').removeClass('selected');
        $('.package_items').prop('checked', false);
        // clear modal and end...
        $('#loading').modal('hide');
    });

    // sales resource pages
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
                window.location.href = base_url + "admin/users/wholesale/" + page_param + ".html";
            }else{
                window.location.href = base_url + "admin/users/wholesale/" + page_param + "/index/" + z + ".html";
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
