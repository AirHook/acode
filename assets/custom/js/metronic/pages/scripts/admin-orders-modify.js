var ComponentsEditors = function () {

    var base_url = $('body').data('base_url');
    var object_data = $('body').data('object_data');

    var handleSummernote = function () {
        $('#summernote_1').summernote({
			height: 150,
			toolbar: [
				// [groupName, [list of button]]
				['main', ['style']],
				['style', ['bold', 'italic', 'underline', 'clear']],
				['para', ['ul', 'ol', 'paragraph']],
				['link', ['link']]
			]
		});
    }

    var handleScripts = function () {

        // handle edit qty
        $('[href="#modal-edit_quantity"]').on('click', function(){
            var item_id = $(this).data('item_id');
            var prod_no = $(this).data('prod_no');
            var qty = $(this).siblings('span').html();
            $('[name="order_log_detail_id"]').val(item_id);
            $('.eiq-modal-item').html('Item: '+prod_no);
            $('[name="qty"]').val(qty.trim());
        });

        // handle edit discount
        $('[href="#modal-edit_discount"]').on('click', function(){
            var item_id = $(this).data('item_id');
            var prod_no = $(this).data('prod_no');
            var unit_price = $(this).data('unit_price');
            var orig_price = $(this).data('orig_price');
            $('[name="order_log_detail_id"]').val(item_id);
            $('.edp-modal-item').html('Item: '+prod_no);
            $('[name="unit_price"]').val(unit_price);
        });

        // handle remove item
        $('[href="#modal-remove_item"]').on('click', function(){
            var item_id = $(this).data('item_id');
            $('[name="order_log_detail_id"]').val(item_id);
        });

        // handle confirm button edit user details _noel(06092021)
        $('#form-edit_user_details').submit(function(e){
            e.preventDefault();
			var edit_user_details = $.ajax({
                type:    "POST",
                url:     base_url + "admin/orders/mod_user_details.html",
                dataType: 'json',
                data:   $('form#form-edit_user_details').serialize()
            });

			edit_user_details.done(function(data) {
                //update the fields, show update button, and close
                $('#bill_to_name').html(data.store_name ? data.store_name : data.firstname+' '+data.lastname);
                $('#bill_to_address1').html(data.address1);
                $('#bill_to_address2').html(data.address2 ? '<br>'+data.address2 : '');
                $('#bill_to_city').html(data.city);
                $('#bill_to_zipcode').html(data.zip_postcode+' '+data.state_province);
                $('#bill_to_country').html(data.country);
                $('#bill_to_telephone').html(data.telephone ? '<br >T: '+data.telephone : '');
                $('#attn_name').html(data.firstname+' '+data.lastname);
                $('#attn_email').html('<cite class="small">('+data.email+')</cite>');
                $('#modal-edit_user_details').modal('hide');
                $('.floatbar').fadeIn();
			});
			edit_user_details.fail(function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.\nPlease try again.')
            });

		});

        //handle confirm button edit store details _noel(06092021)
      $('#form-edit_store_details').submit(function(e){
            e.preventDefault();
			var edit_store_details = $.ajax({
                type:    "POST",
                url:     base_url + "admin/orders/mod_store_details.html",
                dataType: 'json',
                data:   $('form#form-edit_store_details').serialize()
            });

			edit_store_details.done(function(data) {
                //update the fields, show update button, and close
                $('#bill_to_name').html(data.store_name ? data.store_name : data.firstname+' '+data.lastname);
                $('#bill_to_address1').html(data.address1);
                $('#bill_to_address2').html(data.address2 ? '<br>'+data.address2 : '');
                $('#bill_to_city').html(data.city);
                $('#bill_to_zipcode').html(data.zipcode+' '+data.state);
                $('#bill_to_country').html(data.country);
                $('#bill_to_telephone').html(data.telephone ? '<br >T: '+data.telephone : '');
                $('#attn_name').html(data.firstname+' '+data.lastname);
                $('#attn_email').html('<cite class="small">('+data.email+')</cite>');
                $('#modal-edit_store_details').modal('hide');
                $('.floatbar').fadeIn();
			});
			edit_store_details.fail(function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.\nPlease try again.')
            });

		});

        // handle confirm button edit shipping details _noel(06122021)
        $('.submit-edit_ship_to').on('click', function(e){
            e.preventDefault();
			var edit_ship_to = $.ajax({
                type:    "POST",
                url:     base_url + "admin/orders/mod_ship_to.html",
                dataType: 'json',
                data:   $('form#form-edit_ship_to').serialize()
            });

			edit_ship_to.done(function(data) {
                //update the fields, show update button, and close
                $('#ship_to_name').html(data.store_name ? data.store_name : data.firstname+' '+data.lastname);
                $('#ship_to_address1').html(data.ship_address1);
                $('#ship_to_address2').html(data.ship_address2 ? '<br>'+data.ship_address2 : '');
                $('#ship_to_city').html(data.ship_city);
                $('#ship_to_zipcode').html(data.ship_zipcode+' '+data.ship_state);
                $('#ship_to_country').html(data.ship_country);
                $('#ship_to_telephone').html(data.telephone ? '<br >T: '+data.telephone : '');
                $('#attn_ship_name').html(data.firstname+' '+data.lastname);
                $('#attn_ship_email').html('<cite class="small">('+data.email+')</cite>');
                $('#modal-edit_ship_to').modal('hide');
                $('.floatbar').fadeIn();
			});
			edit_ship_to.fail(function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.\nPlease try again.')
            });
		});

        // handle confirm button edit Quantity _noel(06122021)
        $('#form-edit_item_qty').submit(function(e){
            e.preventDefault();
			var edit_item_qty = $.ajax({
                type:    "POST",
                url:     base_url + "admin/orders/mod_item_qty.html",
                dataType: 'json',
                data:   $('form#form-edit_item_qty').serialize()
            });

			edit_item_qty.done(function(data) {
                $('#qty_'+data.order_log_detail_id).html(data.qty);

                var old_discount_price = 0;
                if ($('#discounted_price_'+data.order_log_detail_id).html().trim()!='--')
                    old_discount_price = parseFloat($('#discounted_price_'+data.order_log_detail_id).html().trim().replace('$',''));
                else
                    old_discount_price = parseFloat($('#orig_price_'+data.order_log_detail_id).html().trim().replace('$',''));
                var new_extended_price = old_discount_price * data.qty;

                $('#extended_price_'+data.order_log_detail_id).html('$ '+new_extended_price.toFixed(2));

                updateTotals();
                $('#modal-edit_quantity').modal('hide');
                $('.floatbar').fadeIn();
			});
			edit_item_qty.fail(function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.\nPlease try again.')
            });
		});

        // handle confirm button edit price _noel(06152021)
        $('#form-edit_discount').submit(function(e){
            e.preventDefault();
			var edit_discount = $.ajax({
                type:    "POST",
                url:     base_url + "admin/orders/mod_item_price.html",
                dataType: 'json',
                data:   $('form#form-edit_discount').serialize()
            });

			edit_discount.done(function(data) {
                var old_discount_price = parseFloat($('#discounted_price_'+data.order_log_detail_id).html().trim().replace('$',''));
                var old_qty = $('#qty_'+data.order_log_detail_id).html().trim();
                var new_price = old_qty * data.unit_price;

                if (old_discount_price!='--')
                    $('#discounted_price_'+data.order_log_detail_id).html('$ '+parseFloat(data.unit_price).toFixed(2));

                $('#extended_price_'+data.order_log_detail_id).html('$ '+parseFloat(new_price).toFixed(2));

                updateTotals();
                $('#modal-edit_discount').modal('hide');
                $('.floatbar').fadeIn();
			});
			edit_discount.fail(function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.\nPlease try again.')
            });
		});

        // handle confirm button edit remarks _noel(06152021)
        $('#form-edit_remarks').submit(function(e){
            e.preventDefault();
			var edit_edit_remarks = $.ajax({
                type:    "POST",
                url:     base_url + "admin/orders/mod_remarks.html",
                dataType: 'json',
                data:   $('form#form-edit_remarks').serialize()
            });

			edit_edit_remarks.done(function(data) {
                //update the fields, show update button, and close
                $('#order_remarks').html(data.remarks);
                $('#modal-edit_remarks').modal('hide');
                $('.floatbar').fadeIn();
			});
			edit_edit_remarks.fail(function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.\nPlease try again.')
            });
		});

        // handle confirm button edit shipping fee _noel(06152021)
        $('#form-edit_shipping_fee').submit(function(e){
            e.preventDefault();
			var edit_shipping_fee = $.ajax({
                type:    "POST",
                url:     base_url + "admin/orders/mod_shipping_fee.html",
                dataType: 'json',
                data:   $('form#form-edit_shipping_fee').serialize()
            });

			edit_shipping_fee.done(function(data) {
                //update the fields, show update button, and close
                $('#order_shipping_fee').html('$ '+parseFloat(data.shipping_fee).toFixed(2));
                updateTotals();
                $('#modal-edit_shipping_fee').modal('hide');
                $('.floatbar').fadeIn();
			});
			edit_shipping_fee.fail(function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.\nPlease try again.')
            });
		});

        // handle confirm button add discount _noel(06152021)
        $('#form-add_discount').submit(function(e){
            e.preventDefault();
			var add_discount = $.ajax({
                type:    "POST",
                url:     base_url + "admin/orders/mod_add_discount.html",
                dataType: 'json',
                data:   $('form#form-add_discount').serialize()
            });

			add_discount.done(function(data) {
                //update the fields, show update button, and close
                $('#order_discount').empty();
                if (data.discount == 0) {
                    $('#add_discount_button').show();
                }
                else {
                    var sub_total_price = parseFloat($('#subtotal_price').html().trim().replace('$',''));
                    var discount_rate = (parseFloat(data.discount) / 100) * sub_total_price;
                    $('#order_discount').append('<td>Discount</td><td class="text-right"><a href="#modal-add_discount" data-toggle="modal" class="btn btn-xs grey-gallery" style="font-size:80%;">Edit/Remove Discount</a><span id="order_discount_percent">@'+data.discount+'%</span> &nbsp; &nbsp;($ <span id="order_discount_amount">'+discount_rate+'</span>)</td>');
                    $('#add_discount_button').hide();
                }

                updateTotals();
                $('#modal-add_discount').modal('hide');
                $('.floatbar').fadeIn();
			});
			add_discount.fail(function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.\nPlease try again.')
            });
		});

        // handle remove item _noel(06162021)
        $('#form-remove_item').submit(function(e){
            e.preventDefault();
			var edit_remove_item = $.ajax({
                type:    "POST",
                url:     base_url + "admin/orders/mod_remove_item.html",
                dataType: 'json',
                data:   $('form#form-remove_item').serialize()
            });

			edit_remove_item.done(function(data) {
                $('#order_item_'+data.order_log_detail_id).remove();
                updateTotals();
                $('#modal-remove_item').modal('hide');
                $('.floatbar').fadeIn();
			});
			edit_remove_item.fail(function(jqXHR, textStatus, errorThrown) {
                alert('Something went wrong.\nPlease try again.')
            });
		});

    }

    var updateTotals = function() {
        var $i = 1;
        var $total_qty = 0;
        var $total_price = 0.00;
        var $old_total = parseFloat($('#grand_total_price').html().trim().replace('$',''));
        var $discount = 0.00;
        if ($('#order_discount_amount').length)
            $discount = parseFloat($('#order_discount_amount').html().trim().replace('$',''));
        var $shipping_fee = parseFloat($('#order_shipping_fee').html().trim().replace('$',''));
        var $sales_tax = parseFloat($('#order_sales_tax').html().trim().replace('$',''));
        $("#order_list tr").each(function () {
            var self = $(this);
            var col_1_value = self.find("td:eq(0)").text().trim();
            if ($.isNumeric(col_1_value)) {
                self.find("td:eq(0)").html($i);
                var col_6_value = self.find("td:eq(5)").text().replace("Edit","").trim();
                var col_9_value = self.find("td:eq(8)").text().replace("$ ","").trim();
                $total_qty = $total_qty + parseInt(col_6_value);
                $total_price = $total_price + parseFloat(col_9_value);
            }
            else {
                self.find("td:eq(0)").html("Total # of Items: "+(parseInt($i)-1));
            }

            $i++;
        });
        var $new_grand_total_price = $total_price - $discount + $shipping_fee + $sales_tax;
        $('#total_qty').html($total_qty);
        $('#subtotal_price').html($total_price.toFixed(2))
        $('#grand_total_price').html($new_grand_total_price.toFixed(2));
    }

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-edit_store_details');
		var error1 = $('#form-edit_store_details .alert-danger');
		var success1 = $('#form-edit_store_details .alert-success');

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: ":not(:visible),:disabled",  // validate all fields including form hidden input

			// set your custom error message here
            /*
			messages: {
				'email[]': 'Please select at least 1 email.'
			},
            */

			rules: {
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
                } else if (element.attr("data-error-container")) {
                    error.appendTo('#'+element.attr("data-error-container"));
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

			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    var handleValidation2 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form2 = $('#form-edit_ship_to');
		var error2 = $('#form-edit_ship_to .alert-danger');
		var success2 = $('#form-edit_ship_to .alert-success');

		form2.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: ":not(:visible),:disabled",  // validate all fields including form hidden input

			// set your custom error message here
            /*
			messages: {
				'email[]': 'Please select at least 1 email.'
			},
            */

			rules: {
				firstname: {
					required: true
				},
				lastname: {
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
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit
				success2.hide();
				error2.show();
				App.scrollTo(error2, -200);
			},

			errorPlacement: function (error, element) { // render error placement for each input type
				var cont = $(element).parent('.input-group');
				if (cont.size() > 0) {
					cont.after(error);
                } else if (element.attr("data-error-container")) {
                    error.appendTo('#'+element.attr("data-error-container"));
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

				//success2.show();
				error2.hide();
                form.submit();
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form2).change(function () {
			form2.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    var handleValidation3 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form3 = $('#form-edit_user_details');
		var error3 = $('#form-edit_user_details .alert-danger');
		var success3 = $('#form-edit_user_details .alert-success');

		form3.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // (:not(:visible),:disabled) validate all fields including form hidden input

			// set your custom error message here
            /* *
			messages: {
				'user_id': 'Please select store or enter manual info.',
                'ship_to': 'Please select "Ship To" options.',
			},
            // */

            rules: {
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
				telephone: {
					required: true
				},
				address1: {
					required: true
				},
				city: {
					required: true
				},
				state_province: {
					required: true
				},
				country: {
					required: true
				},
				zip_postcode: {
					required: true
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit
				success3.hide();
				error3.show();
				App.scrollTo(error3, -200);
			},

			errorPlacement: function (error, element) { // render error placement for each input type
				var cont = $(element).parent('.input-group');
				if (cont.size() > 0) {
					cont.after(error);
                } else if (element.attr("data-error-container")) {
                    error.appendTo('#'+element.attr("data-error-container"));
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

				//success3.show();
                error3.hide();
                form.submit();
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form3).change(function () {
			form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    return {
        //main function to initiate the module
        init: function () {
            handleSummernote();
            handleScripts();
            handleValidation1();
            handleValidation2();
            handleValidation3();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
