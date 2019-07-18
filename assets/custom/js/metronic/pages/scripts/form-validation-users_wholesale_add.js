var FormValidation = function () {

    var base_url = $('body').data('base_url');

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-users_wholesale_add');
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
				is_active: {
					required: true
				},
				reference_designer: {
					required: true
				},
				admin_sales_email: {
					required: true,
					email: true
				},
				email: {
					required: true,
					email: true
				},
				firstname: {
					required: true
				},
				lastname: {
					required: true
				},
				store_name: {
					required: true
				},
				telephone: {
					required: true
				},
				address1: {
					required: true
				},
				city: {
					required: true
				},
				state: {
					required: true
				},
				country: {
					required: true
				},
				zipcode: {
					required: true
				},
				pword: {
					required: true
				},
				passconf: {
					equalTo: "#pword"
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
				Ladda.stopAll(); // stop ladda
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
				form.submit();
				return false;
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});

        // clear all items button action
        // for sales resource pages
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

        //show password click function
        $('.show-password').click(function(){
            var checked = $(this).is(':checked');
            if (checked) {
                $('.input-password, .input-passconf').attr('type', 'text');
            } else {
                $('.input-password, .input-passconf').attr('type', 'password');
            }
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

            handleValidation1();

        }

    };

}();

jQuery(document).ready(function() {
    FormValidation.init();
});
