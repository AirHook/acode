var FormValidation = function () {

	var base_url = $('body').data('base_url');

	// basic page scripts
    var pageScripts = function () {

		$('.switch-status').on('switchChange.bootstrapSwitch', function(){
			// get data
			var site_section = $(this).closest('.form-group').data('site_section');
			var dataObject = $(this).closest('.form-group').data('object_data');
			var state = $(this).val();
			// update data to server
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
			dataObject.status = state;
			$.ajax({
				type:    "POST",
				url:     base_url + site_section + "/sales_orders/status.html",
				data:    dataObject,
				success: function(data) {
					if (state == 5) $('.modify-so').hide();
					else $('.modify-so').show();
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
