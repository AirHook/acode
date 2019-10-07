var FormValidation = function () {

	var base_url = $('body').data('base_url');

	// basic page scripts
    var pageScripts = function () {

		// print item size barcodes link actions
		$('a.print-upc-size').on('click', function(e){
			// stop link default action
			e.preventDefault();
			// gather data
			var url = $(this).prop('href');
			var item = $(this).data('item');
			var size = $(this).data('size');
			$(this).siblings('.this-size-qty').prop('readonly', false);
			var qty = $(this).siblings('.this-size-qty').val();
			$(this).siblings('.this-size-qty').prop('readonly', true);
			// set html values
			var thisModal = $('#modal-print-upc-size');
			// capture url
			thisModal.find('.modal-body div.mt-radio-list').attr('data-url', url);
			// set checked options and hide some where necessary
			if (qty > 0){
				// default is print all...
				$('input[name="test"][value="1"]').prop('checked', true);
				$('input[name="test"][value="1"]').closest('label').show();
				// set default url
				thisModal.find('.modal-footer button.print-upc-size').attr('data-url', url+'/all.html');
			}else{
				$('input[name="test"][value="0"]').prop('checked', true);
				$('input[name="test"][value="1"]').closest('label').hide();
				// set default url
				thisModal.find('.modal-footer button.print-upc-size').attr('data-url', url+'.html');
			}
			// set body information
			thisModal.find('.modal-body span.item').html(item);
			thisModal.find('.modal-body span.size').html(size);
			thisModal.find('.modal-body p.qty').html(qty);
			// show modal
			$('#modal-print-upc-size').modal('show');
			return false;
		});

		$('[name="test"]').on('change', function(){
			var url = $(this).parents('div').data('url');
			var val = $(this).val();
			if (val == 1) newUrl = url+'/all.html';
			else newUrl = url+'.html';
			$('#modal-print-upc-size').find('.modal-footer button.print-upc-size').attr('data-url', newUrl);
		});

		$('#modal-print-upc-size').on('click', 'button.print-upc-size', function(){
			var url = $(this).attr('data-url');
			window.open(url, '_blank');
		});

		// update po status switches
		$('.switch-status').on('switchChange.bootstrapSwitch', function(){
			// get data
			var site_section = $(this).closest('.form-group').data('site_section');
			var dataObject = $(this).closest('.form-group').data('object_data');
			var state = $(this).val();

			if ($(this).hasClass('mt-bootbox-status-complete')) {
                bootbox.dialog({
                    message: "This Purchase Order will now be closed.<br />And, will no longer be available for modification.<br />Please ensure correct change of status.<br /><br />Stocks will be added accordingly.",
                    title: "Notice",
                    buttons: {
                        danger: {
                            label: "Cancel",
                            className: "",
                            callback: function() {
                                return;
                            }
                        },
                        main: {
                            label: "Confirm",
                            className: "dark",
                            callback: function() {
								// update data to server
								$('#loading .modal-title').html('Updating...');
								$('#loading').modal('show');
								dataObject.status = state;
								$.ajax({
									type:    "POST",
									url:     base_url + "admin/purchase_orders/status",
									data:    dataObject,
									success: function(data) {
										$('#loading').modal('hide');
										//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
										location.reload();
									},
									// vvv---- This is the new bit
									error:   function(jqXHR, textStatus, errorThrown) {
										//$('#loading').modal('hide');
										//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
										$('#reloading').modal('show');
										location.reload();
									}
								});
                            }
                        }
                    }
                });
            }else{
				// update data to server
				$('#loading .modal-title').html('Updating...');
				$('#loading').modal('show');
				dataObject.status = state;
				$.ajax({
					type:    "POST",
					url:     base_url + "admin/purchase_orders/status",
					data:    dataObject,
					success: function(data) {
						$('#loading').modal('hide');
						//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
					},
					// vvv---- This is the new bit
					error:   function(jqXHR, textStatus, errorThrown) {
						//$('#loading').modal('hide');
						//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
						$('#reloading').modal('show');
						location.reload();
					}
				});
			}
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
		FormValidation.init();
	});
}
