var ComponentsEditors = function () {

	var base_url = $('body').data('base_url');

	// basic page scripts
    var pageScripts = function () {

		$(window).bind('beforeunload', function(){
    		return '>>>>>Before You Go<<<<<<<< \n Your custom message go here';
    	});

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
					// {"status":"true","item":"712DE_DENI1","color_code":"DENI1","size_label":"size_sm"}
					// set item row element
					var el = $('.cart-basket table > tbody > tr.summary-item-container.'+data.item+'.'+data.size_label);
					var notThisEl = $('.cart-basket table > tbody > tr.summary-item-container').not(el);
					// set highlight backgroun
					el.attr('style','background:#c2cad8 !important;vertical-align:top;').addClass('hover-selected');
					$('.table.table-light.table-hover > tbody > tr.hover-selected:hover > td, .table.table-light.table-hover > tbody > tr.hover-selected > td:hover').attr('style','background:#c2cad8 !important;vertical-align:top;');
					// unset highlight background on other rows
					notThisEl.closest('tr').removeClass('hover-selected').attr('style','vertical-align:top;');
					notThisEl.closest('tr').children('td').attr('style','vertical-align:top;');
					// pick out items
					objectData.item = data.item;
					objectData.size_label = data.size_label;
					pickOut(el,objectData);
				}
				$('[name="upc_barcode"]').val('').focus();
			});
			verify_barcode.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert(" SO Scan Barcode Validation Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
		};

		function pickOut(el,objectData){
			// get quantities
			var qty = parseInt(el.children('td.reqd').html());
			var shipd = parseInt(el.children('td.shipd').html());
			var bo = parseInt(el.children('td.bo').html());
			var stock = parseInt(el.children('td.stock').html());
			// calculate quantities
			if (bo!=0) {
				shipd++;
				bo--;
				if (stock!=0) stock--;
			} else {
				alert('Item has no more balance order.')
			}
			objectData.qty = qty;
			objectData.shipd = shipd;
			objectData.bo = bo;
			// update items array
			var pick_and_pack_udpate = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/pick_and_pack_update.html",
                data:    objectData
            });
			pick_and_pack_udpate.done(function(data) {
				// update quantities
				el.children('td.shipd').html(shipd);
				el.children('td.bo').html(bo);
				el.children('td.stock').html(stock);
			});
			pick_and_pack_udpate.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Pick Out Error, status = " + textStatus + ", " + "error thrown_: " + errorThrown);
            });
		};

		// handle checkboxes
		$('[name="checkbox[]"]').on('change', function(){
			var notThisEl = $('.cart-basket table input[type=checkbox]').not(this);
			// uncheck all other checkboxes
			notThisEl.prop('checked', false);
			// set highlight background
			$(this).closest('tr').attr('style','background:#c2cad8 !important;vertical-align:top;').addClass('hover-selected');
			$('.table.table-light.table-hover > tbody > tr.hover-selected:hover > td, .table.table-light.table-hover > tbody > tr.hover-selected > td:hover').attr('style','background:#c2cad8 !important;vertical-align:top;');
			// unset highlight background on other rows
			notThisEl.closest('tr').removeClass('hover-selected').attr('style','vertical-align:top;');
			notThisEl.closest('tr').children('td').attr('style','vertical-align:top;');
			// if unchecked, remove highlight
			if (!$(this).prop('checked')) {
				$(this).closest('tr').removeClass('hover-selected').attr('style','vertical-align:top;');
				$(this).closest('tr').children('td').attr('style','vertical-align:top;');
			}
		});

		// manual pick and pack action
		$('.manual-pick').on('click', function(){
			// count checked boxes
			var countchecked = $('.cart-basket table input[type=checkbox]:checked').length;
			if (countchecked == 0) alert('Select an item from list.');
			else if (countchecked > 1) alert('Select only 1 item from list');
			else {
				var objectData = $(this).closest('.button-actions').data('object_data');
				var el = $('.cart-basket table input[type=checkbox]:checked').closest('tr');
				// pick out items
				objectData.item = el.data('item');
				objectData.size_label = el.data('size_label');
				pickOut(el,objectData);
			}
		});

		// barcode scan actions
		$('[name="upc_barcode"]').on('paste', function(e){
			var objectData = $(this).closest('.button-actions').data('object_data');
			objectData.barcode = e.originalEvent.clipboardData.getData('text');
			// verify barcode
			verifyBarcode(objectData);
		})

		// barcode scan out button toggle
		$('.scan-pick').on('click', function(){
			// uncheck any checkboxes
			$('.cart-basket table input[type=checkbox]').prop('checked', false);
			// unset css style
			$('.table.table-light.table-hover > tbody > tr').removeClass('hover-selected').attr('style','vertical-align:top;');
			$('.table.table-light.table-hover > tbody > tr').children('td').attr('style','vertical-align:top;');
			// toggel buttons
			$(this).hide();
			$('.input-upc_barcode').show();
			$('[name="upc_barcode"]').focus();
		});

		// barcode input toggle
		$('i.fa-barcode').on('click', function(){
			// unset css style
			$('.table.table-light.table-hover > tbody > tr').removeClass('hover-selected').attr('style','vertical-align:top;');
			$('.table.table-light.table-hover > tbody > tr').children('td').attr('style','vertical-align:top;');
			// toggle buttons
			$('.input-upc_barcode').hide();
			$('.scan-pick').show();
		})

		// updates so mod data
		$('.update-so-mod').on('click', function(){
			// toggle scan out button to default
			// unset css style
			$('.table.table-light.table-hover > tbody > tr').removeClass('hover-selected').attr('style','vertical-align:top;');
			$('.table.table-light.table-hover > tbody > tr').children('td').attr('style','vertical-align:top;');
			// toggle buttons
			$('.input-upc_barcode').hide();
			$('.scan-pick').show();
			// get object data
			var objectData = $(this).closest('.button-actions').data('object_data');
			// update so mod
			// update items array
			var update_so = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/Pick_and_pack_mod_update.html",
                data:    objectData
            });
			update_so.done(function(data) {
				// redirec to so details page
				if (data == 'success') {
					location.href=base_url + 'admin/sales_orders/details/index/'+objectData.so_id+'.html';
				}else{
					alert('Ooops... somethin went wrong.');
				}
			});
			update_so.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Pick and Pack Modify Update Error, status = " + textStatus + ", " + "error thrown_: " + errorThrown);
            });
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
