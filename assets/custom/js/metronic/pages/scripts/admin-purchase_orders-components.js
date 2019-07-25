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

        // select vendor drop down item
        $('.step1-select-vendor').on('change', function(){
            var url_structure = $(this).find("option:selected").data('url_structure');
            $('[name="url_structure"]').val(url_structure);
        });

        // steps wizard click functions
        $('.form-wizard .nav > li .step').on('click', function(){
            var dataLink = $(this).data('link');
            var step = $(this).data('step');
            var parentEl = $(this).closest('.form-wizard .form-body');
            var items_count = parentEl.children('.items_count').html();
            var items_steps = parentEl.children('.items_steps').html();
            if (items_count == 0) return; // return user
            // conditions for step 2
            if (step == 2 && items_steps >= 1) {
                window.location.href=dataLink;
            }
            // conditions for step 3
            if (step == 3 && items_steps == 2) {
                window.location.href=dataLink;
            }
            if (step == 3 && items_steps > 2) {
                if ($(this).hasClass('mt-bbox-new')) {
                    bootbox.dialog({
                        message: "Sending purchase order. Please confirm....<br />This sends an email to vendor.<br />A copy will also be sent to you.",
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
                if ($(this).hasClass('mt-bbox-existing')) {
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
                }
            }
        })

        // add/remove items clicked on step1 product grid view
        $('.thumb-tiles').on('click', '.package_items', function() {
            $('#loading .modal-title').html('Processing...');
            $('#loading').modal('show');
            var objectData = $(this).data('object_data');
            var checked = $(this).is(":checked");
            objectData.prod_no = $(this).val();
            if (checked) {
                // add item...
                objectData.action = 'add_item';
            } else {
                // rem item...
                objectData.action = 'rem_item';
            }
            $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/addrem.html",
                data:    objectData,
                success: function(data) {
                    $('#loading').modal('hide');
                    $('.items_count').html(data);
                    $('.thumb-tile.'+objectData.prod_no).toggleClass('selected');
                    if (data > 0) {
                        $('.clear_all_items').parent('div').removeClass('hide');
                        $('.sidebar_cart_link').attr('href', base_url + 'admin/purchase_orders/create/step3.html');
                        $('.sidebar-send-package-btn').attr('href', base_url + 'admin/purchase_orders/create/step3.html');
                        if ($('.sidebar-send-package-btn').hasClass('tooltips')) {
                            $('.sidebar-send-package-btn').toggleClass('tooltips disabled-link disable-target');
                            $('.sidebar-send-package-btn').attr('data-original-title', '');
                        }
                    } else {
                        $('.clear_all_items').parent('div').addClass('hide');
                        $('.sidebar_cart_link').attr('href', 'javascript:;');
                        $('.sidebar-send-package-btn').attr('href', 'javascript:;');
                        $('.sidebar-send-package-btn').addClass('tooltips disabled-link disable-target');
                        $('.sidebar-send-package-btn').attr('data-original-title', 'Nothing to send');
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
            $('.thumb-tile.grid.'+$(this).data('sku')).toggleClass('selected');
        });

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
        $('.size-select').on('change', function(){
            var objectData = $(this).closest('table').data('object_data');
            objectData.qty = $(this).val();
            objectData.size = $(this).attr('name');
            objectData.prod_no = $(this).data('prod_no');
            objectData.page = $(this).data('page');
            if (objectData.qty > 0) $(this).css('border-color', 'black');
            else $(this).css('border-color', '#ccc');
            var vendor_price = $('[name="vendor_price-'+objectData.prod_no+'"]').val();
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
        });

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }

        // edit vendor price actions
        // attach a submit handler to the form
        $('.edit_vendor_prices').on('click', function(){
            var objectData = $(this).closest('table').data('object_data');
            var prod_no = $(this).data('prod_no');
            var this_size_qty = $('.this-total-qty').val();
            var el = $('[name="vendor_price-'+prod_no+'"]');
            var new_price = el.val();
            var style_no = el.data('item');
            var page = el.data('page');
            objectData.vendor_price = new_price;
            objectData.prod_no = prod_no;
            objectData.style_no = style_no;
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
                        $(this).html('$ '+formatNumber((thisQty * data).toFixed(2)));
                        //$('.input-order-subtotal.'+objectData.prod_no).val(data.thisQty*vendor_price);
                        $(this).closest('tr').children('.input-order-subtotal').val(thisQty * data);
                    });
                    // set this PO over all total amount
                    var orderTotal = 0;
                    $('.input-order-subtotal').each(function(){
                        orderTotal += parseInt($(this).val());
                    });
                    $('.order-total').html('$ '+formatNumber(orderTotal.toFixed(2)));
                    //window.location.href=base_url + "admin/products/edit/index/" + prod_id;
                },
                // vvv---- This is the new bit
                error:   function(jqXHR, textStatus, errorThrown) {
                    alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    //$('#reloading').modal('show');
                    //location.reload();
                }
            });
            // close modal
            $(this).closest('.modal').modal('hide');
        });

        // submit po summary review form
        $('.step.step4.submit-po_summary_review').on('click', function(){
            $('#form-po_summary_review').submit();
        });
        // */

        // print to pdf
        $('.po-pdf-print').click(function(){
            html2canvas(document.querySelector("#print-to-pdf")).then(canvas => {
                // convert canvas data to image
                var img = canvas.toDataURL("image/jpeg", 1.0);
                // set width and height to fit canvas to pdf
                var x = 200;
                var y = canvas.height * x / canvas.width;
                // call jsPDF script
                var doc = new jsPDF();
                // add the image at positions 5 and 5 with x and y dimentions
                doc.addImage(img, 'JPEG', 5, 5, x, y);
                // .save() executes PDF download for printing...
                // file is saved on client's downloads folder
                doc.save('test.pdf');

                // DOC: to save PDF onto server, use .output() defaults to string
                // .output() //returns raw body of resulting PDF returned as a string as per the plugin documentation
                // or .output('blob') i don't really know the difference for now
                // after setting, e.g., "var pdf = doc.output();",
                // set objectData of new FormData() and $.post() to server
            });
        });

        // clear all items button action
        $('.confirm-clear_all_items').click(function(){
            $('#modal-clear_all_items').modal('hide');
            $('#loading .modal-title').html('Clearing...');
            $('#loading').modal('show');
            // call the url using get method
            $.get(base_url + "admin/purchase_orders/clear_all_items.html", function(data){
                var step = $('.clear_all_items').data('step');
                if (data == 'clear' && step == 4) {
                    window.location.href=base_url + "admin/purchase_orders/create/step3.html";
                }
                if (data == 'clear' && step == 3) {
                    // remove bootbox class
                    $('.step.step4, .sidebar-send-po-btn').removeClass('mt-bootbox-new');
                    // hide clear all items sidebar button
                    $('.clear_all_items').parent('div').addClass('hide');
                    // other items from sales package
                    $('.sidebar-send-package-btn').attr('href', 'javascript:;');
                    $('.sidebar-send-package-btn').addClass('disabled-link disable-target tooltips');
                }
            });
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
                    $.get(base_url + "admin/sales_package/clear_all_items.html", function(data){
    					// we need to wait for ajax call response before continuing
    					// to alleviate session handling execution time error
                        if (data == 'clear') window.location.href=link;
    				});
                });
            } else {
                window.location.href=link;
            }
        });

        // step 3 send to which user buttons
        $('.select-user').on('click', function(){
            if ($(this).hasClass('btn-outline')) {
                $(this).toggleClass('btn-outline');
                $(this).siblings().toggleClass('btn-outline');
            }
            if ($(this).data('user') == 'new_user') {
                $('.send_to_new_user').show();
                $('.send_to_new_user').attr('disabled', false);
                $('.send_to_current_user').hide();
                $('.send_to_current_user').attr('disabled', true);
            }
            if ($(this).data('user') == 'current_user') {
                $('.send_to_new_user').hide();
                $('.send_to_new_user').attr('disabled', true);
                $('.send_to_current_user').show();
                $('.send_to_current_user').attr('disabled', false);
            }
        });

    }

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-po_summary_review');
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
                autoclose: true
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
