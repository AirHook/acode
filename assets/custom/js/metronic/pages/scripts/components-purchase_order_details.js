var FormValidation = function () {

	var base_url = $('body').data('base_url');

	// basic page scripts
    var pageScripts = function () {

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
