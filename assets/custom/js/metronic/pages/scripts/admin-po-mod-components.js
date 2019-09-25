var ComponentsEditors = function () {

    var base_url = $('body').data('base_url');

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

        $(window).bind('beforeunload', function(){
    		return '>>>>>Before You Go<<<<<<<< \n Your custom message go here';
    	});

        function setSizeQty(objectData){
            var set_size_qty = $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/set_size_qty.html",
                data:    objectData,
                dataType: 'json'
            });
            set_size_qty.done(function(data) {
                // set items again
                setItems(objectData);
            });
            set_size_qty.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Set Items' Size and Quantity Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

        function setItems(objectData){
            var set_items = $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/set_items.html",
                data:    objectData
            });
            set_items.done(function(data){
                // update  cart box
                $('.cart_basket_wrapper table tbody').html('');
                $('.cart_basket_wrapper table tbody').html(data);
                $('.cart_basket_wrapper table tbody').fadeIn();
                var qtyTotal = $('.hidden-overall_qty').val();
                if (qtyTotal > 0) {
                    $('.step4').addClass('active');
                } else {
                    $('.step4').removeClass('active');
                }
                $('.overall-qty').html(qtyTotal);
                var orderTotal = parseFloat($('.hidden-overall_total').val());
                $('.order-total').html('$ '+orderTotal.toFixed(2));
                // call jquery loading
                $('.cart_basket table').loading('stop');
            });
            set_items.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Set Items Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }

        // remove item at summary view
        $('.summary-item-container').on('click', '.summary-item-checkbox', function(){
            $('#loading .modal-title').html('Removing...');
            $('#loading').modal('show');
            var container = $(this).closest('.summary-item-container');
            var objectData = $(this).closest('table').data('object_data');
            objectData.prod_no = $(this).data('prod_no');
            objectData.action = 'rem_item';
            $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/addrem.html",
                data:    objectData,
                success: function(data) {
                    $('#loading').modal('hide');
                    $('.items_count').html(data);
                    // hide the row container
                    container.find('.input-order-subtotal').prop('disabled', true);
                    container.hide();
                    if (data > 0) {
                        // code here...
                        // update each variant's subtotal
                        var overallQty = 0;
                        $('.this-total-qty').each(function(){
                            if ($(this).is(':visible')) {
                                overallQty += parseInt($(this).val());
                            }
                        });
                        $('.overall-qty').html(overallQty);
                        // set this PO over all total amount
                        var orderTotal = 0;
                        $('.input-order-subtotal').each(function(){
                            if ( ! $(this).prop('disabled')) {
                                orderTotal += parseInt($(this).val());
                            }
                        });
                        $('.order-total').html('$ '+formatNumber(orderTotal.toFixed(2)));
                    } else {
                        // hide clear all items sidebar button
                        $('.clear_all_items').parent('div').addClass('hide');
                        // show no items in bag notice
                        $('.no-item-notification').show();
                        // remove bootbox class
                        $('.step.step4, .sidebar-send-po-btn').removeClass('mt-bootbox-new');
                    }
                    //window.location.href=base_url + "admin/products/edit/index/" + prod_id;
                },
                // vvv---- This is the new bit
                error:   function(jqXHR, textStatus, errorThrown) {
                    $('#loading').modal('hide');
                    //alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    $('#reloading').modal('show');
                    location.reload();
                }
            });
            //$('.thumb-tile.grid.'+$(this).data('sku')).toggleClass('selected');
        });

        // size and qty change at summary function
        $('.cart_basket_wrapper table tbody').on('change', '.size-select', function(){
            // call jquery loading on po table of items
            $('.cart_basket table').loading();
            var objectData = $(this).closest('table').data('object_data');
            objectData.qty = $(this).val();
            objectData.size = $(this).attr('name');
            objectData.prod_no = $(this).data('prod_no');
            objectData.page = $(this).data('page');
            if (objectData.qty > 0) $(this).css('border-color', 'black');
            else $(this).css('border-color', '#ccc');
            var checked = $('.show_vendor_price').is(":checked");
            if (checked) {
                objectData.vendor_price = $(this).closest('td').siblings('.unit-vendor-price-wrapper').find('.unit-vendor-price').html().trim();
            } else {
                objectData.vendor_price = 0;
            }
            // set items' size and quantity
            setSizeQty(objectData);
            /*
            if (checked) {
                var vendor_price = $('[name="vendor_price-'+objectData.prod_no+'"]').val();
            } else {
                var vendor_price = 0;
            }
            $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/set_size_qty.html",
                data:    objectData,
                success: function(data) {
                    data = JSON.parse(data);
                    $('#loading').modal('hide');
                    // set this size total qty
                    $('.this-total-qty.'+objectData.prod_no).val(data.thisQty);
                    // set this size subtotal price
                    $('.order-subtotal.'+objectData.prod_no).html('$ '+formatNumber((data.thisQty*vendor_price).toFixed(2)));
                    $('.input-order-subtotal.'+objectData.prod_no).val(data.thisQty*vendor_price);
                    // set this PO over all total qty
                    $('.overall-qty').html(data.overallTotal);
                    // set this PO over all total amount
                    var orderTotal = 0;
                    $('.input-order-subtotal').each(function(){
                        orderTotal += parseInt($(this).val());
                    });
                    $('.order-total').html('$ '+formatNumber(orderTotal.toFixed(2)));
                    // call jquery loading
                    $('.cart_basket table').loading('stop');
                },
                // vvv---- This is the new bit
                error:   function(jqXHR, textStatus, errorThrown) {
                    //$('#loading').modal('hide');
                    alert("Size Qty Change Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    //$('#reloading').modal('show');
                    //location.reload();
                }
            });
            */
        });

        // show edit vendor price actions
        $('.show_vendor_price').on('change', function(){
            // call jquery loading on po table of items
            $('.cart_basket table').loading();
            $('.edit_on, .edit_off').toggle();
            var checked = $(this).is(":checked");
            if (checked) {
                var getUrl = base_url + "admin/purchase_orders/edit_vendor_price_session/index/1/modify.html";
            } else {
                var getUrl = base_url + "admin/purchase_orders/edit_vendor_price_session/index/0/modify.html";
            }
            $.get(getUrl, function(){
                // update each variant's subtotal
                $('.order-subtotal').each(function(){
                    if (checked) {
                        var data = $(this).siblings('.unit-vendor-price-wrapper').find('.unit-vendor-price').html().trim();
                    } else {
                        var data = 0;
                    }
                    var thisQty = $(this).siblings('.size-and-qty-wrapper').find('.this-total-qty').val();
                    $(this).html('$ '+(parseFloat(thisQty * data)).toFixed(2));
                    $(this).closest('tr').children('.input-order-subtotal').val(thisQty * data);
                });
                // set this PO over all total amount
                var orderTotal = 0;
                $('.input-order-subtotal').each(function(){
                    orderTotal += parseFloat($(this).val());
                });
                $('.order-total').html('$ '+orderTotal.toFixed(2));
                // call jquery loading
                $('.cart_basket table').loading('stop');
            });
        });

        // edit vendor price actions
        // attach a submit handler to the form
        $('.edit_vendor_prices').on('click', function(){
            // call jquery loading on po table of items
            $('.cart_basket table').loading();
            var objectData = $(this).closest('table').data('object_data');
            var prod_no = $(this).data('prod_no'); // <prod_no>_<color_code>
            var this_size_qty = $('.this-total-qty').val();
            var el = $('[name="vendor_price-'+prod_no+'"]');
            var new_price = el.val();
            var style_no = el.data('item'); // prod_no
            var page = el.data('page');
            objectData.vendor_price = new_price;
            objectData.prod_no = prod_no;
            objectData.page = page;
            // perfom ajax
            $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/edit_vendor_price.html",
                data:    objectData,
                success: function(data) {
                    // update modal input vendor price and other related variant
                    $('.modal-input-vendor-price.'+style_no).val(data);
                    // update the unit vendor price and other related variant
                    $('.unit-vendor-price.'+style_no).html(data);
                    // update each variant's subtotal
                    $('.order-subtotal.'+style_no).each(function(){
                        var thisQty = $(this).siblings('.size-and-qty-wrapper').find('.this-total-qty').val();
                        $(this).html('$ '+(parseFloat(thisQty * data)).toFixed(2));
                        //$('.input-order-subtotal.'+objectData.prod_no).val(data.thisQty*vendor_price);
                        $(this).closest('tr').children('.input-order-subtotal').val(thisQty * data);
                    });
                    // set this PO over all total amount
                    var orderTotal = 0;
                    $('.input-order-subtotal').each(function(){
                        orderTotal += parseFloat($(this).val());
                    });
                    $('.order-total').html('$ '+orderTotal.toFixed(2));
                    //window.location.href=base_url + "admin/products/edit/index/" + prod_id;
                    // call jquery loading
                    $('.cart_basket table').loading('stop');
                },
                // vvv---- This is the new bit
                error:   function(jqXHR, textStatus, errorThrown) {
                    alert("Edit Vendor Price Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    //$('#reloading').modal('show');
                    //location.reload();
                }
            });
            // close modal
            $(this).closest('.modal').modal('hide');
        });
    }

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-po_modify');
		var error1 = $('.alert-danger');
		var success1 = $('.alert-success');

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
                start_date: {
					required: true
				},
                cancel_date: {
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

                var must_return = false;
                $('.this-total-qty').each(function(){
                    if ($(this).val() == 0) {
                        alert('An item must have no zero total qty order.\nPlease select quantity for any size required.');
                        must_return = true;
                        return false;
                    }
                });

                if (must_return) {
                    return;
                } else if ($('.overall-qty').html() == 0) {
                    alert('Please select quantity for any size required.');
                    return;
                } else {
                    bootbox.dialog({
                        message: "Sending purchase order. Please confirm...<br />This sends an email to vendor.<br />A copy will also be sent to you.",
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
                                label: "Send Purchase Order",
                                className: "dark",
                                callback: function() {
                                    $('#loading .modal-title').html('Sending...');
                                    $('#loading').modal('show');
                                    form.submit();
                                }
                            }
                        }
                    });
                }

				//form.submit();
				return false;
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    var handleBootbox = function() {
        $('.step.step4_, .sidebar-send-po-btn_, .submit-po_summary_review_').on('click', function(){
            if ($('.overall-qty').html() == 0) {
                alert('Please select quantity for any size required.');
                return false;
            }
            $('.this-total-qty').each(function(){
                if ($(this).val() == 0) {
                    alert('An item must have no zero total qty order.');
                    return false;
                }
            });
            if ($(this).hasClass('mt-bootbox-new_')) {
                bootbox.dialog({
                    message: "Sending purchase order. Please confirm...<br />This sends an email to vendor.<br />A copy will also be sent to you.",
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
                            label: "Send Purchase Order",
                            className: "dark",
                            callback: function() {
                                $('#form-po_summary_review').submit();
                            }
                        }
                    }
                });
            }
        });
        $('.mt-bootbox-existing').click(function(){
            bootbox.dialog({
                message: "There may be changes to this saved sales package. Please select appropriate actions.",
                title: "Notice",
                buttons: {
                    danger: {
                        label: "Cancel",
                        className: "",
                        callback: function() {
                            return;
                        }
                    },
                    success: {
                        label: "Overwrite existing Sales Packge",
                        className: "grey",
                        callback: function() {
                            $('#form-send_sales_package').submit();
                        }
                    },
                    main: {
                        label: "Save as New Sales Package",
                        className: "dark",
                        callback: function() {
                            $('[name="sales_package_id"]').val('0');
                            $('#form-send_sales_package').submit();
                        }
                    }
                }
            });
        });
    }

    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
                autoclose: true,
                startDate: '01/01/2000'
            });
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }

        /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */

        // Workaround to fix datepicker position on window scroll
        $( document ).scroll(function(){
            $('#form_modal2 .date-picker').datepicker('place'); //#modal is the id of the modal
        });
    }

    var handleDatetimePicker = function () {

        if (!jQuery().datetimepicker) {
            return;
        }

        $(".form_datetime").datetimepicker({
            autoclose: true,
            isRTL: App.isRTL(),
            format: "dd MM yyyy - hh:ii",
            fontAwesome: true,
            pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left")
        });

    }

    return {
        //main function to initiate the module
        init: function () {
            handleSummernote();
            handleScripts();
            handleValidation1();
            handleBootbox();
            handleDatePickers();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
