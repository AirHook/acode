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

        // trigger unveil
        $('img').unveil();

        // select designer actions
        $('[name="designer"]').on('change', function(){
            var objectData = $(this).closest('.form-body').data('object_data');
            //objectData.designer = $('option:selected', this).data('des_slug');
            objectData.designer = $(this).selectpicker('val');
            if (objectData.designer) {
                // populate vendors list
                $.ajax({
                    type:    "POST",
                    url:     base_url + "admin/sales_orders/get_vendors_list.html",
                    data:    objectData,
                    success: function(data) {
                        $('[name="vendor_id"]').html(data);
                        $('[name="vendor_id"]').selectpicker('refresh');
                        $('.select-both').hide();
                        $('.select-vendor').fadeIn();
                    },
                    error:   function(jqXHR, textStatus, errorThrown) {
                        $('#loading').modal('hide');
                        //alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                        $('#reloading').modal('show');
                        location.reload();
                    }
                });
                // populate stores list
                $.ajax({
                    type:    "POST",
                    url:     base_url + "admin/sales_orders/get_stores_list.html",
                    data:    objectData,
                    success: function(data) {
                        $('[name="store_id"]').html(data);
                        $('[name="store_id"]').selectpicker('refresh');
                    },
                    error:   function(jqXHR, textStatus, errorThrown) {
                        $('#loading').modal('hide');
                        //alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                        $('#reloading').modal('show');
                        location.reload();
                    }
                });
            } else {
                $('[name="vendor_id"]').html('<option value="">Select Vendor...</option>');
                $('[name="vendor_id"]').selectpicker('refresh');
                $('[name="store_id"]').html('<option value="">Select Wholesale User...</option>');
                $('[name="store_id"]').selectpicker('refresh');
                $('.so-categories').html('');
                $('.thumb-tiles-wrapper').html('');
                $('.select-both').show();
                $('.select-vendor').hide();
                $('.blank-grid-text').fadeIn();
            }
        });

        // select vendor action
        $('[name="vendor_id"]').on('change', function(){
            var slug_segs;
            var objectData = $(this).closest('.form-body').data('object_data');
            objectData.vendor_id = $(this).selectpicker('val');
            objectData.designer = $('option:selected', this).data('des_slug');
            // ensure designer select option is properly set
            $('[name="designer"]').selectpicker('val', objectData.designer);
            // by this time, designer and vendor is selected,
            // we can now show category and thumbs
            if (objectData.vendor_id) {
                // get category tree
                var get_category_tree = $.ajax({
                    type:    "POST",
                    url:     base_url + "admin/sales_orders/get_category_tree.html",
                    data:    objectData
                });
                // do a dependence chain of ajax request
                var get_thumbs = get_category_tree.then(function(data) {
                    if (data != '') {
                        $('.blank-grid-text').hide();
                        $('.so-categories').hide();
                        $('.so-categories').html(data);
                        $('.so-categories').fadeIn();
                        objectData.slug_segs = $('#slug_segs').html();
                        return $.ajax({
                            type:    "POST",
                            url:     base_url + "admin/sales_orders/get_thumbs.html",
                            data:    objectData
                        });
                    } else {
                        $('.so-categories').html('');
                        $('.thumb-tiles-wrapper').html('');
                        $('.blank-grid-text').show();
                        $('.select-vendor').html('No product return. Please select another vendor...');
                    }
                });
                get_thumbs.done(function(data){
                    $('.thumb-tiles-wrapper').hide();
                    $('.thumb-tiles-wrapper').html(data);
                    $('.thumb-tiles-wrapper').fadeIn();
                });
                // dependence chain ajax calls has only one fail taken from the last chain
                get_thumbs.fail(function(jqXHR, textStatus, errorThrown) {
                    $('#loading').modal('hide');
                    //alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    $('#reloading').modal('show');
                    location.reload();
                });
            } else {
                $('.so-categories').html('');
                $('.thumb-tiles-wrapper').html('');
                $('.select-both').hide();
                $('.select-vendor').show();
                $('.blank-grid-text').fadeIn();
            }
        });

        // select store action
        $('[name="store_id"]').on('change', function(){
            var objectData = $(this).closest('.form-body').data('object_data');
            objectData.store_id = $(this).selectpicker('val');
            var setStore = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/set_store_id.html",
                data:    objectData
            });
            setStore.done(function(){
                // nothing to do at the moment...
            });
        });

        // datepicker select
        $('[name="delivery_date"]').on('change', function(){
            var objectData = $(this).closest('.form-body').data('object_data');
            objectData.delivery_date = $(this).val();
            var setdd = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/set_dely_date.html",
                data:    objectData
            });
            setdd.done(function(){
                // nothing to do at the moment...
            });
        });

        // clicks on category
        $('.so-categories').on('click', 'li a', function(){
            var wrapper = $(this).closest('.so-categories');
            var objectData = wrapper.data('object_data');
            objectData.designer = $(this).data('des_slug');
            objectData.vendor_id = $('option:selected', '[name="vendor_id"]').val();
            objectData.slug_segs = $(this).data('slugs_link');
            var get_thumbs = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/get_thumbs.html",
                data:    objectData
            });
            get_thumbs.done(function(data){
                $('.thumb-tiles-wrapper').hide();
                $('.thumb-tiles-wrapper').html(data);
                $('.thumb-tiles-wrapper').fadeIn();
                wrapper.find('li').removeClass('active');
                slugs = objectData.slug_segs.split('/');
                $.each(slugs, function(index, item){
                    wrapper.find('li[data-slug="'+item+'"]').addClass('active');
                });
            });
            get_thumbs.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                //alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                $('#reloading').modal('show');
                location.reload();
            });
        });

        // clicked on product grid view
        $('.thumb-tiles-wrapper').on('click', '.package_items', function() {
            var objectData = $(this).closest('.thumb-tiles-wrapper').data('object_data');
            var checked = $(this).is(":checked");
            objectData.prod_no = $(this).data('item');
            // get item...
            var addrem = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/get_item.html",
                data:    objectData
            });
            addrem.done(function(data) {
                // fill in modal
                $('.modal-body-cart_basket_wrapper').html(data);
                $('#modal-size_qty').modal('show');
            });
            addrem.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        });

        // barcode scan action
        $('[name="barcode"]').on('paste', function(e){
            // check for des_slug and vendor_id
            var objectData = $(this).closest('.form-body').data('object_data');
            objectData.designer = $('[name="designer"]').val();
            objectData.vendor_id = $('[name="vendor_id"]').val();
            objectData.barcode = e.originalEvent.clipboardData.getData('text');
            var barcode = objectData.barcode;
            var verifyBarcode = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/verify_barcode.html",
                dataType: 'json',
                data:    objectData
            });
            verifyBarcode.done(function(data) {
                // status - true/false, error - des_slug/vendor_id/no_product/invalid_barcode/no_post
                if (data.status == 'false'){
                    if (data.error == 'des_slug') alert('Barcode item has different designer.\nPlease try again.');
                    else if (data.error == 'vendor_id') alert('Barcode item has different vendor.\nPlease try again.');
                    else if (data.error == 'no_product') alert('Barcode item is not in product list.\nPlease try again.');
                    else if (data.error == 'invalid_barcode') alert('Invalid Barcode.\nPlease try again.');
                    else alert('Something went wrong.\nPlease try again.');
                } else {
                    var item = data.item;
                    if (data.vendor_id) var vendor_id = data.vendor_id; // vendor is not set
                    // if designer is not set
                    if (data.des_slug) {
                        //alert('set designer');
                        // set designer
                        $('[name="designer"]').selectpicker('val', data.des_slug);
                        // populate vendors list
                        delete objectData.vendor_id;
                        delete objectData.barcode;
                        objectData.designer = data.des_slug;
                        // populate vendors list
                        $.ajax({
                            type:    "POST",
                            url:     base_url + "admin/sales_orders/get_vendors_list.html",
                            data:    objectData,
                            success: function(data) {
                                $('[name="vendor_id"]').html(data);
                                $('[name="vendor_id"]').selectpicker('refresh');
                                $('.select-both').hide();
                                $('.select-vendor').fadeIn();
                            },
                            error:   function(jqXHR, textStatus, errorThrown) {
                                $('#loading').modal('hide');
                                alert("Vendor List Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                                //$('#reloading').modal('show');
                                //location.reload();
                            }
                        });
                        // populate stores list
                        $.ajax({
                            type:    "POST",
                            url:     base_url + "admin/sales_orders/get_stores_list.html",
                            data:    objectData,
                            success: function(data) {
                                $('[name="store_id"]').html(data);
                                $('[name="store_id"]').selectpicker('refresh');
                            },
                            error:   function(jqXHR, textStatus, errorThrown) {
                                $('#loading').modal('hide');
                                alert("Stores List Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                                //$('#reloading').modal('show');
                                //location.reload();
                            }
                        });
                    }
                    // when designer is set, there is a venodr list already
                    // if vendor is not set
                    if (data.vendor_id) {
                        //alert('set vendor');
                        // set vendor
                        var refreshed = false;
                        $('[name="vendor_id"]').on('refreshed.bs.select', function(){
                            refreshed = true;
                            $(this).selectpicker('val', data.vendor_id);
                        });
                        if (!refreshed) $('[name="vendor_id"]').selectpicker('val', data.vendor_id);
                        // get category tree
                        delete objectData.barcode;
                        objectData.vendor_id = vendor_id;
                        // get category tree
                        $.ajax({
                            type:    "POST",
                            url:     base_url + "admin/sales_orders/get_category_tree.html",
                            data:    objectData,
                            success: function(data) {
                                if (data != '') {
                                    $('.blank-grid-text').hide();
                                    $('.so-categories').hide();
                                    $('.so-categories').html(data);
                                    $('.so-categories').fadeIn();
                                    objectData.slug_segs = $('#slug_segs').html();
                                    // get thumbs
                                    $.ajax({
                                        type:    "POST",
                                        url:     base_url + "admin/sales_orders/get_thumbs.html",
                                        data:    objectData,
                                        success: function(data) {
                                            $('.thumb-tiles-wrapper').hide();
                                            $('.thumb-tiles-wrapper').html(data);
                                            $('.thumb-tiles-wrapper').fadeIn('fast', function(){
                                                $(this).trigger('thumbsAllIn');
                                            });
                                        },
                                        error:   function(jqXHR, textStatus, errorThrown) {
                                            $('#loading').modal('hide');
                                            alert("Thumbs Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                                            //$('#reloading').modal('show');
                                            //location.reload();
                                        }
                                    });
                                } else {
                                    $('.so-categories').html('');
                                    $('.thumb-tiles-wrapper').html('');
                                    $('.blank-grid-text').show();
                                    $('.select-vendor').html('No product return. Please select another vendor...');
                                }
                            },
                            error:   function(jqXHR, textStatus, errorThrown) {
                                $('#loading').modal('hide');
                                alert("Cateogry Tree Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                                //$('#reloading').modal('show');
                                //location.reload();
                            }
                        });
                    }
                    // on all ajax thumbs in
                    $('.thumb-tiles-wrapper').on('thumbsAllIn', function(){
                        //alert('All thunbs in');
                        // get the item
                        delete objectData.designer;
                        delete objectData.vendor_id;
                        delete objectData.slug_segs;
                        objectData.barcode = barcode;
                        $.ajax({
                            type:    "POST",
                            url:     base_url + "admin/sales_orders/get_item.html",
                            data:    objectData,
                            success: function(data) {
                                // fill in modal
                                $('.modal-body-cart_basket_wrapper').html(data);
                                $('#modal-size_qty').modal('show');
                            },
                            error:   function(jqXHR, textStatus, errorThrown) {
                                $('#loading').modal('hide');
                                alert("Get Item Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                                //$('#reloading').modal('show');
                                //location.reload();
                            }
                        });
                    });
                    // trigger the all thumbs in event
                    if (!data.des_slug && !data.vendor_id) {
                        $('.thumb-tiles-wrapper').trigger('thumbsAllIn');
                    }
                }
                // remove the barcode digits
                $('[name="barcode"]').val('');
            });
            verifyBarcode.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Barcode Validation Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        });

        // size and qty change at modal
        $('.modal-body-cart_basket_wrapper').on('change', '.size-select', function(){
            // get the object data to pass to post url
            var objectData = $(this).closest('.modal-body').data('object_data');
            objectData.qty = $(this).val();
            objectData.size = $(this).attr('name');
            objectData.prod_no = $(this).data('item');
            objectData.page = $(this).data('page');
            // hide this modal
            $('#modal-size_qty').modal('hide');
            var set_size_qty = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/set_items.html",
                data:    objectData
            });
            set_size_qty.done(function(data){
                // update  cart box
                $('.cart_basket_wrapper').html('');
                $('.cart_basket_wrapper').html(data);
                $('.cart_basket_wrapper').fadeIn();
                // check thumb
                $('.thumb-tile.'+objectData.prod_no).addClass('selected');
                // check designer
                var designer = $('[name="designer"]').selectpicker('var');
            });
            set_size_qty.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                //alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                $('#reloading').modal('show');
                location.reload();
            });
        });

        // cancel modal for size and qty
        $('.modal-size_qty_cancel').on('click', function(){
            // clear modal html
            var el = $('.modal-body-cart_basket_wrapper').find('.modal-shop-cart-item-details h5');
            var item = el.html();
            // check if item still exists on cart box
            var item_exists = $('.cart_basket_wrapper').find('input[data-item="'+item+'"]');
            if (item_exists) {
                // nothing to do at the moment...
            } else {
                $('.thumb-tile.'+item).removeClass('selected');
            }
        });

        // remove item at summary view
        $('.summary-item-container').on('click', '.summary-item-remove-btn', function(){
            //$('#loading .modal-title').html('Removing...');
            //$('#loading').modal('show');
            var objectData = $(this).closest('.form-body').data('object_data');
            objectData.prod_no = $(this).data('item');
            objectData.size = $(this).data('size_label');
            objectData.page = $(this).data('page');
            objectData.action = 'rem_item';
            var addrem = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/rem_items.html",
                data:    objectData
            });
            addrem.done(function(data) {
                $('#loading').modal('hide');
                $('.cart_basket_wrapper').hide();
                $('.cart_basket_wrapper').html(data);
                $('.cart_basket_wrapper').fadeIn();
                var items_count = $('.span-items_count').val();
                $('.items_count').html(items_count);
                $('.cart_items_count').fadeIn();
                // check if item still exists on cart box
                var item_exists = $('.cart_basket_wrapper').find('input[data-item="'+item+'"]');
                if (item_exists) {
                    // nothing to do at the moment...
                } else {
                    $('.thumb-tile.'+objectData.prod_no).removeClass('selected');
                }
            });
            addrem.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Error, status = " + textStatus + ", " + "error thrown_: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        });

        // search multiple button
        $('.search-multiple-form').on('click', function(){
            var vendor_id = $('[name="vendor_id"]').selectpicker('val');
            if (vendor_id) {
                $(this).hide(); // hide the search multiple form button
                $('.grid-view-button').fadeIn(); // show the grid view button
                $('.so-categories-wrapper').hide(); // hide the cattree
                $('.thumb-tiles-wrapper').hide(); // hide the grid
                $('#so-multi-search-form').find('input:text').val(''); // reset form
                $('.search-multiple-items').fadeIn(); // show form
            } else alert('Please select a vendor first...');
        });

        // back to grid view
        $('.grid-view-button').on('click', function(){
            $(this).hide();
            $('.grid-view-button').hide();
            $('.search-multiple-items').hide(); // form
            $('.search-multiple-form').fadeIn();
            $('.so-categories-wrapper').fadeIn();
            $('.thumb-tiles-wrapper').fadeIn(); // grid view
        });

        // add items NOT in the list functions
        $('[name="color_code"]').on('changed.bs.select', function(){
            var color_name = $('option:selected', this).data('color_name');
            $('[name="color_name"]').val(color_name);
        });

        // multiple search submit action
        $('#so-multi-search-form').on('submit', function(e){
            var this_form = $(this);
            // prevent the form from submitting
            e.preventDefault();
            // let us check first if at least one box has a value
            var style_ary = [];
            $('[name="style_ary[]"]').each(function(){
                var value = $(this).val();
                if (value) {
                    style_ary.push(value);
                }
            });
            if (style_ary.length === 0) {
                alert('Please fill out at least one box...')
                return;
            }
            // grab the form data
            var objectData = $(this).serializeArray();
            var search_for_thumbs = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/search_multiple.html",
                data:    objectData
            });
            search_for_thumbs.done(function(data){
                $('.grid-view-button').hide(); // hide the grid view button
                $('.search-multiple-form').fadeIn(); // show the search form button
                $('.search-multiple-items').hide(); // hide the form
                $('.so-categories li').removeClass('active');
                $('.so-categories-wrapper').fadeIn();
                $('.thumb-tiles-wrapper').hide();
                $('.thumb-tiles-wrapper').html(data);
                $('.thumb-tiles-wrapper').fadeIn();
            });
            search_for_thumbs.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                //alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                $('#reloading').modal('show');
                location.reload();
            });
        });
    }

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-so_create');
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
				designer: {
					required: true
				},
                vendor_id: {
					required: true
				},
                store_id: {
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
                        alert('An item in your cart must have no zero total qty order.\nPlease select quantity for any size required.');
                        must_return = true;
                        return false;
                    }
                });

                if (must_return) {
                    return;
                } else if ($('.overall-qty').val() == 0) {
                    alert('Please select quantity for any size required.');
                    return false;
                } else {
                    $('#loading').modal('show');
                    location.href=base_url + "admin/sales_orders/review.html";
                    //form.submit();
                }

                return;
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
                //startDate: '01/01/2000'
            });
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }

        /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */

        // Workaround to fix datepicker position on window scroll
        $( document ).scroll(function(){
            $('#form_modal2 .date-picker').datepicker('place'); //#modal is the id of the modal
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleDatePickers();
            handleValidation1();
            handleScripts();
            handleBootbox();
            handleSummernote();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
