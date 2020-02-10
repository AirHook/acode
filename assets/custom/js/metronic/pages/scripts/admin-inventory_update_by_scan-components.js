var ComponentsEditors = function () {

	var base_url = $('body').data('base_url');
	var object_data = $('body').data('object_data');

	// basic page scripts
    var pageScripts = function () {

		/*
		$(window).bind('beforeunload', function(){
			return '>>>>>Before You Go<<<<<<<< \n Your custom message go here';
		});
		*/

		// handle checkboxes and show delete button on selection
		$('#scan_items_count_wrapper table').on('change', 'input[name="checkbox[]"]', function(){
			// show "delete selected" button
			$('.btn-delete-selected').show();
			// uncheck all other checkboxes
			var notThisEl = $('.cart-basket table input[type=checkbox]').not(this);
			notThisEl.prop('checked', false);
			// set highlight background
			$(this).closest('tr').attr('style','background:#c2cad8 !important;vertical-align:top;').addClass('hover-selected');
			$('.table.table-light.table-hover > tbody > tr.hover-selected:hover > td, .table.table-light.table-hover > tbody > tr.hover-selected > td:hover').attr('style','background:#c2cad8 !important;vertical-align:top;');
			// unset highlight background on other rows
			notThisEl.closest('tr').removeClass('hover-selected').attr('style','vertical-align:top;');
			notThisEl.closest('tr').children('td').attr('style','vertical-align:top;');
			// if being unchecked, remove highlight
			if (!$(this).prop('checked')) {
				$(this).closest('tr').removeClass('hover-selected').attr('style','vertical-align:top;');
				$(this).closest('tr').children('td').attr('style','vertical-align:top;');
				// hide "delete selected" button
				$('.delete-selected').hide();
			}
		});

		// delete selected action
		$('.btn-delete-selected').on('click', function(){
			var objectData = object_data;
			objectData.item = $('[name="checkbox[]"]').val();
			// get item
			var del_item = $.ajax({
                type:    "POST",
                url:     base_url + "admin/inventory/update_by_scan_get_item/remove.html",
                data:    objectData
            });
			del_item.done(function(data) {
				// append row to table
				$('#tbl-scan_items_count').find('tbody').append(data);
				$('#scan_items_count_wrapper').animate({scrollTop: $('#tbl-scan_items_count').prop('scrollHeight')});
				// get total coun and update it
				var total_count = parseInt($('#total-count').html());
				$('#total-count').html(total_count + 1);
			});
			del_item.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Item Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
		});

		$('#input-scan_barcode').on('blur', function(){
			setTimeout(function() { $("#input-scan_barcode").focus(); }, 50);
		});

		// barcode scan actions
		$('[name="upc_barcode"]').on('paste', function(e){
			var objectData = object_data;
			objectData.barcode = e.originalEvent.clipboardData.getData('text');
			// verify barcode
			verifyBarcode(objectData);
		})

		function verifyBarcode(objectData){
			var verify_barcode = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/verify_barcode.html",
                dataType: 'json',
                data:    objectData
            });
			verify_barcode.done(function(data){
				if (data.status == 'false'){
					alert('Something went wrong.\nPlease try again.');
				} else {
					// 710780167717
					// sample response for above barcode
					// {"status":"true","item":"D9945L_BLACGOLD1","color_code":"BLACGOLD1","size_label":"size_2","st_id":"1314"}
					// pick out items
					objectData.item = data.item;
					objectData.size_label = data.size_label;
					objectData.st_id = data.st_id;
					getItem(objectData);
				}
				$('[name="upc_barcode"]').val('').focus();
			});
			verify_barcode.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert(" SO Scan Barcode Validation Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
		};

		function getItem(objectData){
			// get item
			var get_item = $.ajax({
                type:    "POST",
                url:     base_url + "admin/inventory/update_by_scan_get_item.html",
                data:    objectData
            });
			get_item.done(function(data) {
				// append row to table
				$('#tbl-scan_items_count').find('tbody').append(data);
				$('#scan_items_count_wrapper').animate({scrollTop: $('#tbl-scan_items_count').prop('scrollHeight')});
				// get total coun and update it
				var total_count = parseInt($('#total-count').html());
				$('#total-count').html(total_count + 1);
			});
			get_item.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Item Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
		};

		// update inventory button action
		$('.btn-update-inventory').on('click', function(){
			window.location.href = base_url + "admin/inventory/update_by_scan/update_inventory.html"
		});
    }

	return {
        //main function to initiate the module
        init: function () {

			pageScripts();
		}

    };

}();

if (App.isAngularJsApp() === false) {
	jQuery(document).ready(function() {
		ComponentsEditors.init();
	});
}
