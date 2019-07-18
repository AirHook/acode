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
