var FormValidation = function () {

	var base_url = $('body').data('base_url');

    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
				format: "yyyy-mm-dd",
                autoclose: true
			});
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
		}

        /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */

        // Workaround to fix datepicker position on window scroll
		/*
        $( document ).scroll(function(){
            $('#form_modal2 .date-picker').datepicker('place'); //#modal is the id of the modal
        });
		*/
    }

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-purchase_orders_create');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input

			// set your custom error message here
			//messages: {
			//	access_level: {
			//		valueNotEquals: "Please select an item"
			//	}
			//},

			rules: {
				po_number: {
					required: true
				},
				po_date: {
					required: true
				},
				des_id: {
					required: true
				},
				vendor_id: {
					required: true
				},
				user_id: {
					required: true
				},
				delivery_date: {
					required: true
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit
				success1.hide();
				error1.show();
				App.scrollTo(error1, -200);
			},

			errorPlacement: function (error, element) { // render error placement for each input type
				var cont = $(element).parent('.input-group'); // input group
				var dd = $(element).parent('.btn-group.bs-select'); // bootstrap select
				if (cont.size() > 0) {
					cont.after(error);
				} else if (dd.size() > 0) {
					dd.after(error);
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
				error1.hide();
				$('#loading .modal-title').html('Submitting...');
				$('#loading').modal('show');
				form.submit();
				//return false;
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
			if ($(this).find(':selected').data('d_url_structure')) {
				$('[name="designer_slug"]').val($(this).find(':selected').data('d_url_structure'));
			}
			if ($(this).find(':selected').data('vendor_code')) {
				$('[name="vendor_name"]').val($(this).find(':selected').data('subtext'));
			}
			if ($(this).find(':selected').data('store_name')) {
				$('[name="store_name"]').val($(this).find(':selected').data('store_name'));
			}
		});

		// suggestions to prod_no field using typehead
		// instantiate the bloodhound suggestion engine
		var custom2 = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				//url: base_url + 'search/suggestions/index/%QUERY',
				url: base_url + 'search/prod_no/index/%QUERY',
				wildcard: '%QUERY'
			}
		});
		// initiate typehead
		$('.search_prod_no').typeahead({
			hint: false,
			highlight: true
		},
		{
			name: 'search_prod_no',
			source: custom2,
			limit: 20
		});

		// form repeater
		$('.mt-repeater').each(function(){
			$(this).repeater({
				show: function () {
					$(this).slideDown();
					// initiate typehead
					$('.search_prod_no').typeahead({
						hint: false,
						highlight: true
					},
					{
						name: 'search_prod_no',
						source: custom2,
						limit: 20
					});
					// set select as selectpicker
					$(this).find('select').selectpicker();
					var color_name = $(this).find('.color_name');
					$(this).find('select').on('change', function(){
						color_name.val($(this).find(':selected').data('color_name'));
					});
				},

				hide: function (deleteElement) {
					if(confirm('Are you sure you want to delete this element?')) {
						$(this).slideUp(deleteElement);
					}
				},

				ready: function (setIndexes) {

				}
			});
			$(this).find('select').selectpicker();
			var color_name = $(this).find('.color_name');
			$(this).find('select').on('change', function(){
				color_name.val($(this).find(':selected').data('color_name'));
			});
		});
    }

	// clear all items button action for sales resource using
    // sales order list page
	$('.confirm-clear_all_items').click(function(){
		$('#modal-clear_all_items').modal('hide');
		$('#loading .modal-title').html('Clearing...');
		$('#loading').modal('show');
		// call the url using get method
		$.get(base_url + "sales/sales_package/clear_all_items.html");
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

	return {
        //main function to initiate the module
        init: function () {

			handleDatePickers();
            handleValidation1();
		}

    };

}();

if (App.isAngularJsApp() === false) {
	jQuery(document).ready(function() {
		FormValidation.init();
	});
}
