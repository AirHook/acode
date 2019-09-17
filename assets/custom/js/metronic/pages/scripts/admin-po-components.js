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

    var handleFancyBox = function () {
        $(".fancybox").fancybox({
            helpers: {
                overlay : {
            		closeClick : true,  // if true, fancyBox will be closed when user clicks on the overlay
            		speedOut   : 200,   // duration of fadeOut animation
            		showEarly  : true,  // indicates if should be opened immediately or wait until the content is ready
            		css        : {'background':'rgba(0,0,0,0.75)'},    // custom CSS properties
            		locked     : true   // if true, the content will be locked into overlay
            	}
            }
        });
    }

    var handleScripts = function () {

        // trigger unveil
        $('img').unveil();

        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }

        function getDesignerDetails(objectData){
            var get_designer_details = $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/get_designer_details.html",
                data:    objectData,
                dataType: 'json'
            });
            get_designer_details.done(function(data) {
                $('.company-details').hide();
                $('.ship-to-details').hide();
                $('.company_name').html(data.company_name);
                $('.company_address1').html(data.company_address1);
                $('.company_address2').html(data.company_address2);
                $('.company_city').html(data.company_city);
                $('.company_state').html(data.company_state);
                $('.company_zipcode').html(data.company_zipcode);
                $('.company_country').html(data.company_country);
                $('.company_telephone').html(data.company_telephone);
                $('.company_contact_person').html(data.company_contact_person);
                $('.company_contact_email').html(data.company_contact_email);
                $('.company-details').fadeIn();
                $('.edit-reset-ship-to').show();
                $('.ship-to-details').fadeIn();
                $('.ship-to-popovers').popover('show');
                // populate vendor details at PO
                getVendorDetails(objectData);
            });
            get_designer_details.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Designer Details Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

        function getVendorDetails(objectData){
            var get_vendor_details = $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/get_vendor_details.html",
                data:    objectData
            });
            get_vendor_details.done(function(data) {
                $('.vendor-address').hide();
                $('.vendor-address').html(data);
                $('.vendor-address').fadeIn();
                $('.ship-to-popovers').popover('show');
                // get category tree
                getCategoryTree(objectData);
            });
            get_designer_details.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Vendor Details Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

        function getCategoryTree(objectData){
            var get_category_tree = $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/get_category_tree.html",
                data:    objectData
            });
            get_category_tree.done(function(data) {
                if (data != '') {
                    // some actions after selecting vendor
                    $('.option-placeholder').hide(); // hide no value in select vendor
                    $('.blank-grid-text').hide(); // hide notice
                    $('.step2').addClass('active');
                    // update category tree dropdown and breadcrumb
                    $('.categories-tree').html(data);
                    $('.cat_crumbs').html($('.categories-tree > li:last-child').data('slug_segs_name'));
                    // get thumbs
                    slug_segs = $('.categories-tree > li:last-child').data('slug_segs');
                    objectData.slug_segs = slug_segs;
                    getThumbs(objectData);
                } else {
                    $('.categories-tree').html('<li style="margin-top:15px;margin-bottom:15px;padding-left:15px;">Please select a vendor...</li>');
                    $('.cat_crumbs').html('');
                    $('.thumb-tiles-wrapper').html('');
                    $('.blank-grid-text').hide();
                    $('.select-vendor').html('No product return. Please select another vendor...');
                    $('.blank-grid-text').fadeIn();
                }
            });
            get_category_tree.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Category Tree Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

        function getThumbs(objectData){
            var get_thumbs = $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/get_thumbs.html",
                data:    objectData
            });
            get_thumbs.done(function(data){
                // populate thumbs
                $('.thumb-tiles-wrapper').hide();
                $('.thumb-tiles-wrapper').html(data);
                $('.thumb-tiles-wrapper').fadeIn();
                $('#loading').modal('hide');
            });
            get_thumbs.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Thumbs Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

        function addRem(objectData){
            var addrem = $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/addrem.html",
                data:    objectData
            });
            addrem.done(function(data) {
                $('.items_count').hide();
                $('.items_count').html(data);
                $('.items_count').fadeIn();
                if (data == '0') {
                    $('.step3').removeClass('active');
                }
                // set items...
                delete objectData.action;
                objectData.page = 'create';
                setItems(objectData);
            });
            addrem.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Add/Rem Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

        function setItems(objectData){
            var set_items = $.ajax({
                type:    "GET",
                url:     base_url + "admin/purchase_orders/set_items.html"
                //data:    objectData
            });
            set_items.done(function(data){
                // update  cart box
                $('.cart_basket_wrapper table tbody').html('');
                $('.cart_basket_wrapper table tbody').html(data);
                $('.cart_basket_wrapper table tbody').fadeIn();
                $('.status-with-items').show();
                $('.no-item-notification').hide();
                var qtyTotal = $('.hidden-overall_qty').val();
                if (qtyTotal > 0) $('.step4').addClass('active');
                else $('.step4').removeClass('active');
                $('.overall-qty').html(qtyTotal);
                var orderTotal = $('.hidden-overall_total').val();
                $('.order-total').html('$ '+formatNumber(orderTotal.toFixed(2)));
            });
            set_items.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Set Items Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

        function setSizeQty(objectData){
            var set_size_qty = $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/set_size_qty.html",
                data:    objectData,
                dataType: 'json'
            });
            set_size_qty.done(function(data) {
                //$('#loading').modal('hide');
                // set this size total qty
                $('.this-total-qty.'+objectData.prod_no).val(data.thisQty);
                // set this size subtotal price
                $('.order-subtotal.'+objectData.prod_no).html('$ '+formatNumber((data.thisQty*objectData.vendor_price).toFixed(2)));
                $('.input-order-subtotal.'+objectData.prod_no).val(data.thisQty*objectData.vendor_price);
                // set this PO over all total qty
                $('.overall-qty').html(data.overallTotal);
                // set this PO over all total amount
                var orderTotal = 0;
                $('.input-order-subtotal').each(function(){
                    orderTotal += parseInt($(this).val());
                });
                $('.order-total').html('$ '+formatNumber(orderTotal.toFixed(2)));
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

        // select vendor drop down item
        $('[name="vendor_id"]').on('change', function(){
            $('#loading').modal('show');
            // get some data
            var objectData = $(this).closest('.form-body').data('object_data');
            var vendor_id = $(this).selectpicker('val');
            var des_slug = $(this).find("option:selected").data('des_slug');
            var des_id = $(this).find("option:selected").data('des_id');
            var cur_vendor_id = $('[name="cur_vendor_id"]').val();
            var items_count = parseInt($('.items_count').html());
            var cfm = true;
            // set frontend des_slug and id
            $('[name="des_slug"]').val(des_slug);
            $('[name="des_id"]').val(des_id);
            // check if user is attempting to change vendors along the way
            if (cur_vendor_id && vendor_id != cur_vendor_id && items_count > 0) {
                cfm = confirm('You have items in PO from another vendor.\nAre you sure you want to change vendors?');
            }
            if (cfm)
            {
                // set this select vendor as current
                //$(this).attr('data-vendor_id', vendor_id);
                $('[name="cur_vendor_id"]').val(vendor_id);
                // initialize other object data
                objectData.vendor_id = vendor_id;
                objectData.designer = des_slug;
                delete objectData.slug_segs;
                // we can now get category tree and thumbs
                if (objectData.vendor_id) {
                    // clear current items
                    //clearItems();
                    $.get(base_url + "admin/purchase_orders/clear_items.html", function(){
                        $('.items_count').html('0');
                        $('.cart_basket_wrapper table tbody').html('');
                        $('.status-with-items').hide();
                        $('.no-item-notification').show();
                        $('.step3').removeClass('active');
                        // populate designer/company/ship-to details at PO
                        getDesignerDetails(objectData);
                    });
                } else {
                    $('.categories-tree').html('<li style="margin-top:15px;margin-bottom:15px;padding-left:15px;">Please select a vendor...</li>');
                    $('.cat_crumbs').html('');
                    $('.thumb-tiles-wrapper').html('');
                    $('.blank-grid-text').hide();
                    $('.select-vendor').show();
                    $('.blank-grid-text').fadeIn();
                    // reset company/ship-to details
                    $('.company-details').hide();
                    $('.ship-to-details').hide();
                    $('.company_name').html($('.site-company-details > span.name').html());
                    $('.company_address1').html($('.site-company-details > span.address1').html());
                    $('.company_address2').html($('.site-company-details > span.address2').html());
                    $('.company_city').html($('.site-company-details > span.city').html());
                    $('.company_state').html($('.site-company-details > span.state').html());
                    $('.company_zipcode').html($('.site-company-details > span.zipcode').html());
                    $('.company_country').html($('.site-company-details > span.country').html());
                    $('.company_telephone').html($('.site-company-details > span.telephone').html());
                    $('.company_contact_person').html($('.site-company-details > span.contact').html());
                    $('.company_contact_email').html($('.site-company-details > span.email').html());
                    $('.company-details').fadeIn();
                    $('.ship-to-details').fadeIn();
                    $('.ship-to-popovers').popover('hide');
                }
            } else {
                $(this).selectpicker('val', cur_vendor_id);
                $(this).selectpicker('refresh');
            }
        });

        // select options buttons
        $('.select-product-options').on('click', function(){
            if ($('.step2').hasClass('active')) {
                if ($(this).hasClass('thumbs-grid-view')){
                    $('.search-multiple-items-wrapper').hide();
                    $('.thumbs-grid').fadeIn();
                }
                if ($(this).hasClass('search-multiple-form')){
                    $('.thumbs-grid').hide();
                    $('.search-multiple-items-wrapper').fadeIn();
                    // reset input values to empty
                    $('[name="style_ary[]"]').val('');
                }
                if ($(this).hasClass('add-unlisted-style-no')){
                    $('#modal-unlisted_style_no').modal('show');
                }
            }
        });

        // category tree list click action
        $('.categories-tree').on('click', '.category_list', function(){
            if (!$(this).hasClass('active')) {
                $('#loading').modal('show');
                var designer = $('[name="des_slug"]').val();
                var vendor_id = $('[name="vendor_id"]').val();
                var slug_segs = $(this).children('a').data('slugs_link');
                var objectData = $(this).closest('.form-body').data('object_data');
                objectData.designer = designer;
                objectData.vendor_id = vendor_id;
                objectData.slug_segs = slug_segs;
                getCategoryTree(objectData);
            }
        });

        // clicked on product grid view
        $('.thumb-tiles-wrapper').on('click', '.package_items', function() {
            var objectData = $(this).closest('.thumb-tiles-wrapper').data('object_data');
            var checked = $(this).is(":checked");
            objectData.prod_no = $(this).val();
            if (checked) {
                objectData.action = 'add_item';
                // check thumb
                $('.thumb-tile.'+objectData.prod_no).addClass('selected');
                $('.item-added').fadeTo(100, 1).show();
                setTimeout(function() {
    				$(".item-added").fadeTo(1000, 0).slideUp(300, function(){
    					$(this).hide();
    				});
    			}, 500);
                $('.step3').addClass('active');
            } else {
                objectData.action = 'rem_item';
                // check thumb
                $('.thumb-tile.'+objectData.prod_no).removeClass('selected');
            }
            // add/rem item...
            // which gets and sets items array as well
            addRem(objectData);
        });

        // remove item at summary view
        $('.cart_basket_wrapper table tbody').on('click', '.summary-item-checkbox', function(){
            var objectData = $(this).closest('table').data('object_data');
            objectData.prod_no = $(this).data('prod_no');
            objectData.action = 'rem_item';
            $('.thumb-tile.'+objectData.prod_no).removeClass('selected');
            $('.package_items.'+objectData.prod_no).attr('checked', false);
            addRem(objectData);
        });

        // add items NOT in the list functions
        $('#form-add_unlisted_style_no').on('submit', function(e){
            // prevent the form from submitting
            e.preventDefault();
            // grab the form data
            var objectData = $(this).data('object_data');
            var prodNo = $(this).find('[name="prod_no"]').val();
            if (!prodNo){
                var error = '<cite class="help-block help-block-error">This item is required</cite>';
                $('[name="prod_no"]').after(error);
                $('[name="prod_no"]').closest('.form-group').addClass('has-error'); // set error class to the control group
            }
            var color_code = $(this).find('[name="color_code"]').val();
            if (!color_code){
                var error = '<cite class="help-block help-block-error">This item is required</cite>';
                $('[name="color_code"]').after(error);
                $('[name="color_code"]').closest('.form-group').addClass('has-error'); // set error class to the control group
            }
            if (!prodNo || !color_code) return false;
            objectData.prod_no = prodNo+'_'+color_code;
            objectData.action = 'add_item';
            // add/rem item...
            // which gets and sets items array as well
            addRem(objectData);
            // close modal
            $('#modal-unlisted_style_no').modal('hide');
            $('.item-added').fadeTo(100, 1).show();
            setTimeout(function() {
				$(".item-added").fadeTo(1000, 0).slideUp(300, function(){
					$(this).hide();
				});
			}, 500);
            $('.step3').addClass('active');
        });
        $('#form-add_unlisted_style_no').on('focus', '[name="prod_no"]', function(){
            $('[name="prod_no"]').closest('.form-group').removeClass('has-error'); // set error class to the control group
        });
        $('#form-add_unlisted_style_no').on('changed.bs.select', '[name="color_code"]', function(){
            $('[name="color_code"]').closest('.form-group').removeClass('has-error'); // set error class to the control group
        });
        $('#modal-unlisted_style_no').on('hidden.bs.modal', function(){
            // reset input text element value
            $('[name="prod_no"]').val('');
            // reset selectpicker value
            $('[name="color_code"]').selectpicker('val', '');
        })

        // size and qty change at summary function
        $('.cart_basket_wrapper table tbody').on('change', '.size-select', function() {
            var objectData = $(this).closest('table').data('object_data');
            objectData.qty = $(this).val();
            objectData.size = $(this).attr('name');
            objectData.prod_no = $(this).data('prod_no');
            objectData.page = $(this).data('page');
            if (objectData.qty > 0) $(this).css('border-color', 'black');
            else $(this).css('border-color', '#ccc');
            var checked = $('.show_vendor_price').is(":checked");
            if (checked) {
                objectData.vendor_price = $('.unit-vendor-price-wrapper').data('vendor_price');
            } else {
                objectData.vendor_price = 0;
            }
            // set items' size and quantity
            setSizeQty(objectData);
        });

        // show edit vendor price actions
        $('.show_vendor_price').on('change', function(){
            $('.edit_on, .edit_off').toggle();
            var el = $(this).closest('table').find('td.unit-vendor-price-wrapper');
            var item = el.data('item');
            var prod_no = el.data('prod_no');
            var checked = $(this).is(":checked");
            if (checked) {
                var data = $('.unit-vendor-price.'+prod_no).html().trim();
            } else {
                var data = 0;
            }
            // update each variant's subtotal
            $('.order-subtotal').each(function(){
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
        });

        // edit vendor price actions - click on pencil
        $('.cart_basket_wrapper table tbody').on('click', '.btn-edit_vendor_price', function(){
            var prod_no = $(this).data('prod_no');
            $('#modal-edit_vendor_price .evp-modal-item').html(prod_no);
            $('.edit_vendor_prices').attr('data-prod_no', prod_no);
            $('[name="vendor_price"]').attr('data-prod_no', prod_no);
            $('[name="vendor_price"]').attr('data-item', prod_no);
            $('#modal-edit_vendor_price').modal('show');
        });

        // edit vendor price actions
        // attach a submit handler to the form
        $('.edit_vendor_prices').on('click', function(){
            var objectData = $(this).closest('.modal-content').data('object_data');
            var prod_no = $(this).data('prod_no'); // <prod_no>_<color_code>
            var new_price = $('[name="vendor_price"]').val();
            var page = $('[name="vendor_price"]').data('page');
            objectData.vendor_price = new_price;
            objectData.prod_no = prod_no;
            objectData.page = page;
            $.ajax({
                type:    "POST",
                url:     base_url + "admin/purchase_orders/edit_vendor_price.html",
                data:    objectData,
                success: function(data) {
                    $('.edit_on').show();
                    $('.edit_off').hide();
                    $('.show_vendor_price').attr('checked', true);
                    setItems(objectData);
                    /*
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
                    */
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

        // multiple search submit action
        $('#po-multi-search-form').on('submit', function(e){
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
            } else {
                $('#loading').modal('show');
                // grab the form data
                var objectData = $(this).serializeArray();
                // change view pane back to thumbs but emtpy
                $('.thumb-tiles-wrapper').hide();
                $('.search-multiple-items-wrapper').hide();
                $('.thumbs-grid').fadeIn();
                // get the thumbs
                getThumbs(objectData);
                // clear class 'active' in category tree list
                $('.category_list').removeClass('active');
                $('.category_list').removeClass('bold');
            }
            /*
            var search_for_thumbs = $.ajax({
                type:    "POST",
                url:     base_url + "admin/pales_orders/search_multiple.html",
                data:    objectData
            });
            search_for_thumbs.done(function(data){
                //$('.grid-view-button').hide(); // hide the grid view button
                //$('.search-multiple-form').fadeIn(); // show the search form button
                $('.search-multiple-items').hide(); // hide the form
                // clear class 'active' in category tree list
                $('.category_list li').removeClass('active');
                $('.category_list li').removeClass('bold');
                // populate thumbs
                $('.thumb-tiles-wrapper').hide();
                $('.thumb-tiles-wrapper').html(data);
                $('.thumb-tiles-wrapper').fadeIn();
                $('#loading').modal('hide');
            });
            search_for_thumbs.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Search Multiple Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
            */
        });




        /*
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
        */
    }

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-po_create_summary_review');
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
                        alert('An item in your cart must have no zero total qty order.\nPlease select quantity for any size required.');
                        must_return = true;
                        return false;
                    }
                });

                if (must_return) {
                    return;
                } else if ($('.overall-qty').html() == '0') {
                    alert('Please select quantity for any size required.');
                    return false;
                } else {
                    bootbox.dialog({
                        message: "Creating purchase order. Please confirm...<br /><br />The PO will be pendingn approval.<br />Once approved, the PO will be emailed to vendor.<br />A copy will also be sent to you.",
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
                                    $('#loading .modal-title').html('Creating...');
                                    $('#loading').modal('show');
                                    form.submit();
                                }
                            }
                        }
                    });
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
            handleFancyBox();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
