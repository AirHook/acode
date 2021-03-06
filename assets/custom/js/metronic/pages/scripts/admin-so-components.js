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
        // set toastr options
        toastr.options = {
            "positionClass": "toast-bottom-right",
            "showDuration": "500",
            "timeOut": "3000"
        };

        function getStoreDetails(objectData){
            var get_store_details = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/get_store_details.html",
                data:    objectData
            });
            get_store_details.done(function(data) {
                if (data === 'loggedout'){
                    // reload page
                    location.reload();
                } else {
                    $('.bill-to-options').hide();
                    $('.ship-to-options').show();
                    $('.btn-reset-billto-shipto').show();
                    $('.customer-billing-address').hide();
                    $('.customer-billing-address').html(data);
                    $('.customer-billing-address').fadeIn();
                    // hide modal
                    $('#modal-select_store').modal('hide');
                }
            });
            get_store_details.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Store Details Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

        function getCategoryTree(objectData){
            var get_category_tree = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/get_category_tree.html",
                data:    objectData
            });
            get_category_tree.done(function(data){
                if (data === 'loggedout'){
                    // reload page
                    location.reload();
                } else {
                    // repopulate category tree
                    $('.categories-tree').html(data);
                    // set category breadbrumbs
                    //var cat_crumbs = $('[name="cat_crumbs"]').val();
                    var cat_crumbs = $('.categories-tree li:last-child').data('slug_segs_name');
                    $('.form-control.cat_crumbs').html(cat_crumbs);
                    // get thumbs
                    getThumbs(objectData);
                }
            });
            get_category_tree.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Category Tree Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        function getThumbs(objectData){
            var get_thumbs = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/get_thumbs.html",
                data:    objectData
            });
            get_thumbs.done(function(data){
                if (data === 'loggedout'){
                    // reload page
                    location.reload();
                } else {
                    $('.blank-grid-text').hide();
                    // populate thumbs
                    $('.thumb-tiles-wrapper').hide();
                    $('.thumb-tiles-wrapper').html(data);
                    $('.thumb-tiles-wrapper').fadeIn();
                    $('.select-product-options').css('background-color', '#2f353b');
                    $('.select-product-options.thumbs-grid-view').css('background-color', '#696969');
                    $('#loading').modal('hide');
                    // call jquery loading on thumbs section
                    $('.thumbs-grid').loading('stop');
                }
            });
            get_thumbs.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Thumbs Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        function addDiscount(objectData){
            var addrem = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/add_discount.html",
                data:    objectData
            });
            addrem.done(function(data) {
                if (data === 'loggedout'){
                    // reload page
                    location.reload();
                } else {
                    // make discount input field empty
                    $('[name="discount"]').val('');
                    // hide modal
                    $('#modal-add_discount').modal('hide');
                    // set items anew
                    setItems();
                }
            });
            addrem.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Item Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        function editQuantity(objectData){
            var addrem = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/edit_quantity.html",
                data:    objectData
            });
            addrem.done(function(data) {
                if (data === 'loggedout'){
                    // reload page
                    location.reload();
                } else {
                    // make discount input field empty
                    $('[name="qty"]').val('');
                    // hide modal
                    $('#modal-edit_quantity').modal('hide');
                    // set items anew
                    setItems();
                }
            });
            addrem.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Item Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        function getItem(objectData){
            var addrem = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/get_item.html",
                data:    objectData
            });
            addrem.done(function(data) {
                if (data === 'loggedout'){
                    // reload page
                    location.reload();
                } else {
                    // fill in modal
                    $('.modal-body-cart_basket_wrapper').html(data);
                    $('#modal-size_qty').modal('show');
                }
            });
            addrem.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Item Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

        // add/remove item before setting them on list view
        function addRemItem(objectData){
            var addrem = $.ajax({
                type:    "POST",
                url:     base_url + "admin/sales_orders/addrem_item.html",
                data:    objectData
            });
            addrem.done(function(data) {
                if (data === 'loggedout'){
                    // reload page
                    location.reload();
                } else {
                    // check thumb
                    if (objectData.action == 'rem_item'){
                        if (data == 0){
                            $('.thumb-tile.'+objectData.prod_no).removeClass('selected');
                            // user toastr notification
                            toastr.info('Item removed...');
                        }
                    } else {
                        $('.step2').addClass('active');
                        $('.thumb-tile.'+objectData.prod_no).addClass('selected');
                        // user toastr notification
                        toastr.success('Item added to Sales Order...');
                    }
                    // set items anew
                    setItems();
                }
            });
            addrem.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Remove Item Error, status = " + textStatus + ", " + "error thrown_: " + errorThrown);
            });
        };

        function setItems(){
            var set_size_qty = $.ajax({
                type:    "GET",
                url:     base_url + "admin/sales_orders/set_items.html"
                //data:    objectData
            });
            set_size_qty.done(function(data){
                if (data === 'loggedout'){
                    // reload page
                    location.reload();
                } else {
                    // update  cart box
                    $('.cart_basket_wrapper .cart_basket .table.table-light > tbody').html('');
                    $('.cart_basket_wrapper .cart_basket .table.table-light > tbody').html(data);
                    $('.cart_basket_wrapper .cart_basket .table.table-light > tbody').fadeIn();
                    // update table totals summaries
                    var qtyTotal = $('.hidden-overall_qty').val();
                    if (qtyTotal > 0) {
                        $('.step3').addClass('active');
                        // show summary section
                        $('.no-item-notification').hide();
                        $('.status-with-items').fadeIn();
                        // set totals
                        $('.overall-qty').html(qtyTotal);
                        var orderTotal = parseFloat($('.hidden-overall_total').val());
                        $('.order-total').html('$ '+orderTotal.toFixed(2));
                    } else {
                        $('.step2').removeClass('active');
                        $('.step3').removeClass('active');
                        // show summary section
                        $('.no-item-notification').fadeIn();
                        $('.status-with-items').hide();
                    }
                    // stop jquery loading
                    $('.cart_basket_wrapper table tbody').loading('stop');
                }
            });
            set_size_qty.fail(function(jqXHR, textStatus, errorThrown) {
                alert("Set Items Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        // ===========

        // category tree list click action
        $('.categories-tree').on('click', '.category_list', function(){
            $('#loading').modal('show');
            var objectData = object_data;
            objectData.slugs_link = $(this).children('a').data('slugs_link');
            // get category tree
            getCategoryTree(objectData);
        });

        // select designer options
        $('[name="des_slug"]').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            var des_id = $(this).data('des_id');
            var objectData = object_data;
            objectData.des_slug = $(this).val();
            delete objectData.slugs_link;
            // set admin_so_des_slug session variable
            $.get(base_url + "admin/sales_orders/set_des_slug_session/index/" + objectData.des_slug + ".html");
            // set input element des_id
            $('#des_id').val(des_id);
            // enable load preset dropdown
            $('.preset-dropdown-wrapper.tooltips').attr('data-original-title', '');
            $('[name="preset"]').removeAttr('disabled');
            $('[name="preset"]').selectpicker('refresh');
            // activate step 2, step 3, and highlight 'Select From Thumbs'
            $('.step2, .step3').addClass('active');
            $('.select-product-options.thumbs-grid-view').css('background-color', '#696969');
            // turn off tooltips on options bar
            $('.select-product-options').tooltip('disable');
            // call jquery loading on thumbs section
            $('.thumbs-grid').loading();
            // enable and update category tree
            getCategoryTree(objectData);
        });

        // select product option buttons function
        $('.select-product-options').on('click', function(){
            if ($('.step2').hasClass('active')) {
                $(this).tooltip('hide');
                $('.select-product-options').css('background-color', '#2f353b');
                $(this).css('background-color', '#696969');
                if ($('.step1').hasClass('active')) {
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
            }
            else $(this).tooltip('show');
        });

        // select store modal actions
        $('.select-users-list').on('change', '[name="email[]"]', function(){
            // call jquery loading on po table of items
            $(this).closest('.form-control').loading();
            // a fix on overlay being covered by modal on modals
            $('.loading-overlay').css('z-index', 100000);
            // set data
            var objectData = object_data;
            // everything starts unchecked
            if ($(this).is(':checked')) {
                // uncheck the rest of the list
                $(".send_to_current_user").not(this).prop('checked', false);
                // get data
                objectData.so_store_id = $(this).val();
                // set input element accordingly
                $('[name="user_id"]').val(objectData.so_store_id);
            } else {
                // reset input element accordingly
                $('[name="user_id"]').val('');
                // remove objectData property
                delete(objectData.so_store_id);
            }
            // call function
            getStoreDetails(objectData);
        });

        // use same as "bill to" address button
        $('.btn-use_same_bill_to_address').on('click', function(){
            var btHtml = $('.customer-billing-address').html();
            $('.ship-to-options').hide();
            $('.customer-shipping-address').html(btHtml);
            $('.customer-shipping-address').fadeIn();
            $('[name="ship_to"]').val('1'); // 1 - use same address, 2 - enter manual info
            // set admin_so_des_slug session variable
            $.get(base_url + "admin/sales_orders/set_ship_to_session/index/1.html");
        });

        // scroll to selected element where necessary
        $('#modal-select_store').on('shown.bs.modal', function(){
            $('.scroller').scrollTop(0);
            var scrollPos;
            $('[name="email[]"]').each(function(){
                // get checked element
                if ($(this).is(':checked')) {
                    // get elements position relative to container
                    // position() refers to immediate parent element
                    // we have to go up the DOM step by step
                    scrollPos = $(this).parents('label').position().top;
                }
            });
            $('.scroller').animate({
                scrollTop: scrollPos - 30
            }, 800);
        });

        // search current user
        $('.btn-search-current-user').on('click', function(){
            // call jquery loading on options section
            $('.select-users-list').loading();
            // process data
            var thisUrl;
            var role = $('[name="search_string"]').data('role');
            var search_string = $('[name="search_string"]').val();
            if (search_string != '') {
                if (role == 'sales') {
                    thisUrl = base_url + "my_account/sales/sales_orders/search_current_user.html"
                } else {
                    thisUrl = base_url + "admin/sales_orders/search_current_user.html";
                }
                objectData = object_data;
                objectData.search_string = search_string;
                var search_current_users = $.ajax({
                    type:    "POST",
                    url:     thisUrl,
                    data:    objectData
                });
                search_current_users.done(function(data){
                    if (data === 'loggedout'){
                        // reload page
                        location.reload();
                    } else {
                        if (data != 'error'){
                            // show caption search
                            $('.caption.search > .search_string').html(search_string);
                            $('.caption.search').show();
                            // update user list
                            $('.select-users-list').hide();
                            $('.select-users-list').html('');
                            $('.select-users-list').html(data);
                            $('.select-users-list').fadeIn();
                        }
                    }
                });
                search_current_users.fail(function(jqXHR, textStatus, errorThrown) {
                    $('#loading').modal('hide');
                    alert("Search Current User Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    //$('#reloading').modal('show');
                    //location.reload();
                });
            } else {
                alert('Please type keywords to search.');
            }
            // stop jquery loading
            $('.select-users-list').loading('stop');
        });

        // reset search user button
        $('.btn-reset-search-current-user').on('click', function(){
            $('.select-users-list').hide();
            $('.select-users-list').html('Loading...');
            $('.select-users-list').fadeIn();
            // get original list
            // process data
            var thisUrl;
            var role = $('[name="search_string"]').data('role');
            if (role == 'sales') {
                thisUrl = base_url + "my_account/sales/sales_orders/get_stores_list.html"
            } else {
                thisUrl = base_url + "admin/sales_orders/get_stores_list.html";
            }
            var get_stores_list = $.ajax({
                type:    "GET",
                url:     thisUrl
            });
            get_stores_list.done(function(data){
                if (data === 'loggedout'){
                    // reload page
                    location.reload();
                } else {
                    if (data != 'error'){
                        // update user list
                        $('.select-users-list').hide();
                        $('.select-users-list').html('');
                        $('.select-users-list').html(data);
                        $('.select-users-list').fadeIn();
                    }
                    $('#modal-select_store').trigger('shown.bs.modal');
                }
            });
            get_stores_list.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Stores List Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
            // reset caption search
            $('.caption.search').hide();
            $('.caption.search > .search_string').html('');
            $('[name="search_string"]').val('');
        });

        // scroll to selected element where necessary
        $('#modal-select_store').on('hidden.bs.modal', function(){
            $('.select-users-list').hide();
            $('.select-users-list').html('Loading...');
            // reset user list data
            var thisUrl;
            var role = $('[name="search_string"]').data('role');
            if (role == 'sales') {
                thisUrl = base_url + "my_account/sales/sales_orders/get_stores_list.html"
            } else {
                thisUrl = base_url + "admin/sales_orders/get_stores_list.html";
            }
            var get_stores_list = $.ajax({
                type:    "GET",
                url:     thisUrl
            });
            get_stores_list.done(function(data){
                if (data != 'error'){
                    // update user list
                    $('.select-users-list').html('');
                    $('.select-users-list').html(data);
                }
            });
            get_stores_list.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Stores List Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
            // reset caption search
            $('.caption.search').hide();
            $('.caption.search > .search_string').html('');
            $('[name="search_string"]').val('');
        });

        // clicked on product grid view
        $('.thumb-tiles-wrapper').on('click', '.package_items', function() {
            var objectData = $(this).closest('.thumb-tiles-wrapper').data('object_data');
            objectData.prod_no = $(this).data('item');
            // get item...
            getItem(objectData);
        });

        // size and qty change at modal
        $('#form-size_qty_select').submit(function(e){
            // prevent form from submitting
            e.preventDefault();
            // call jquery loading on po table of items
            $('.cart_basket_wrapper table tbody').loading();
            // get the object data to pass to post url
            var objectData = object_data;
            objectData.prod_no = $('#size-select-prod_no').val();
            objectData.page = $('#size-select-page').val();
            // get the sizes and quantities
            var size_qty = {};
            $('.size-select').each(function(){
                if ($(this).val() != 0){
                    size_qty[$(this).prop('name')] = $(this).val();
                }
            });
            if ($.isEmptyObject(size_qty)){
                alert('Please select size and quantity...');
                return;
            }else{
                objectData.size_qty = size_qty;
            }
            // hide this modal
            $('#modal-size_qty').modal('hide');
            // add item...
            addRemItem(objectData);
        });

        // size and qty change at modal
        /*
        $('.modal-body-cart_basket_wrapper').on('change', '.size-select', function(){
            // call jquery loading on po table of items
            $('.cart_basket_wrapper table tbody').loading();
            // get the object data to pass to post url
            var objectData = $(this).closest('.modal-body').data('object_data');
            objectData.qty = $(this).val();
            objectData.size_label = $(this).attr('name');
            objectData.prod_no = $(this).data('item');
            objectData.page = $(this).data('page');
            // hide this modal
            $('#modal-size_qty').modal('hide');
            // add item...
            addRemItem(objectData);
        });
        */

        // remove item at summary view
        $('.cart_basket_wrapper table tbody').on('click', '.summary-item-remove', function(){
            // call jquery loading on po table of items
            $('.cart_basket_wrapper table tbody').loading();
            var objectData = $(this).closest('table').data('object_data');
            objectData.prod_no = $(this).data('item');
            objectData.size_label = $(this).data('size_label');
            objectData.page = $(this).data('page');
            objectData.action = 'rem_item';
            // remove item from list
            addRemItem(objectData);
        });

        // add discount modal submit
        $('button.add_discount').on('click', function(){
            // call jquery loading on po table of items
            $('.cart_basket_wrapper table tbody').loading();
            var objectData = $(this).closest('.modal-content').data('object_data');
            objectData.discount = $('[name="discount"]').val();
            objectData.prod_no = $('[name="discount"]').data('item');
            objectData.size_label = $('[name="discount"]').data('size_label');
            objectData.page = $('[name="discount"]').data('page');
            // remove item from list
            addDiscount(objectData);
        });

        // edit quantity modal submit
        $('button.edit_quantity').on('click', function(){
            // call jquery loading on po table of items
            $('.cart_basket_wrapper table tbody').loading();
            var objectData = $(this).closest('.modal-content').data('object_data');
            objectData.qty = $('[name="qty"]').val();
            objectData.prod_no = $('[name="qty"]').data('item');
            objectData.size_label = $('[name="qty"]').data('size_label');
            objectData.page = $('[name="qty"]').data('page');
            // edit quantity
            editQuantity(objectData);
        });

        // multiple search submit action
        $('#so-multi-search-form').on('submit', function(e){
            $('#loading').modal('show');
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
                if (data === 'loggedout'){
                    // reload page
                    location.reload();
                } else {
                    $('.blank-grid-text').hide();
                    $('.search-multiple-items-wrapper').hide(); // hide the form
                    $('.thumbs-grid').fadeIn();
                    // populate thumbs
                    $('.thumb-tiles-wrapper').hide();
                    $('.thumb-tiles-wrapper').html(data);
                    $('.thumb-tiles-wrapper').fadeIn();
                    $('.select-product-options').css('background-color', '#2f353b');
                    $('.select-product-options.thumbs-grid-view').css('background-color', '#696969');
                    $('#loading').modal('hide');
                }
            });
            search_for_thumbs.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Search Multiple Items Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
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
            getItem(objectData);
            // close modal
            $('#modal-unlisted_style_no').modal('hide');
            /*
            $('.item-added').fadeTo(100, 1).show();
            setTimeout(function() {
				$(".item-added").fadeTo(1000, 0).slideUp(300, function(){
					$(this).hide();
				});
			}, 500);
            */
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

        // ===========

        // manage the tooltip to work on thumbs on change
        $('.thumb-tiles-wrapper').on({
            mouseenter: function () {
                $(this).closest('a.tooltips').tooltip();
            },
            mouseleave: function () {
            }
        }, '.img-a_'); //pass the element as an argument to .on

        // manage the tooltip to work on table after ajax change
        $('.cart_basket_wrapper table tbody').on({
            mouseenter: function () {
                $(this).tooltip('show');
            },
            mouseleave: function () {
                $(this).tooltip('hide');
            }
        }, '.tooltips'); //pass the element as an argument to .on

        // on hide #modal-unlisted_style_no
        $('#modal-unlisted_style_no').on('hide.bs.modal', function(){
            // reset input text element value
            $('[name="prod_no"]').val('');
            // reset selectpicker value
            $('[name="color_code"]').selectpicker('val', '');
            // revert back to thumbs button and grid
            $('.select-product-options').css('background-color', '#2f353b');
            $('.select-product-options.thumbs-grid-view').css('background-color', '#696969');
            $('.search-multiple-items-wrapper').hide();
            $('.thumbs-grid').fadeIn();
        })

        // remove body scroll on some modal on show
        $('#modal-select_store, #modal-enter_manual_info').on('show.bs.modal', function(){
            $('body').attr('style', 'overflow: hidden !important');
        }).on('hide.bs.modal', function(){
            $('body').removeAttr('style');
            // call jquery loading
            $('.form-control').loading('stop');
        })

        // manual enter user modal button scripts
        $('.enter-user').on('click', function(){
            var user_cat = $(this).data('user');
            // toggle button highlight
            $('.enter-user').addClass('btn-outline');
            $(this).removeClass('btn-outline');
            // toggle forms
            $('.enter-user-form').hide();
            $('.enter-user-form.'+user_cat).fadeIn();
        });

        // add discount button cick action
        $('.cart_basket_wrapper table tbody').on('click', '.modal-add_discount', function(){
            var prod_no = $(this).data('item');
            var size_label = $(this).data('size_label');
            $('[name="discount"]').data('item', prod_no);
            $('[name="discount"]').data('size_label', size_label);
            $('#modal-add_discount').modal('show');
        });

        // edit quantity button cick action
        $('.cart_basket_wrapper table tbody').on('click', '.modal-edit_quantity', function(){
            var prod_no = $(this).data('item');
            var size_label = $(this).data('size_label');
            $('[name="qty"]').data('item', prod_no);
            $('[name="qty"]').data('size_label', size_label);
            $('#modal-edit_quantity').modal('show');
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

        // datepicker select
        $('[name="delivery_date"]').on('change', function(){
            var objectData = $(this).closest('.right-section').data('object_data');
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
                if (data.status === 'loggedout'){
                    // reload page
                    location.reload();
                } else {
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
                }
            });
            verifyBarcode.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Barcode Validation Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        });

        // add items NOT in the list functions
        $('[name="color_code"]').on('changed.bs.select', function(){
            var color_name = $('option:selected', this).data('color_name');
            $('[name="color_name"]').val(color_name);
        });

    }

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-so_add_new_user_ws');
		var error1 = $('#form-so_add_new_user_ws .alert-danger');
		var success1 = $('#form-so_add_new_user_ws .alert-success');

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

                // prevent submission
                e.preventDefault();
				//success1.show();
				error1.hide();
                // call jquery loading
                form1.loading();
                // grab form data
                var objectData = form1.serializeArray();
                // add new user
                var get_store_details = $.ajax({
                    type:    "POST",
                    url:     base_url + "admin/sales_orders/add_new_user.html",
                    data:    objectData
                });
                get_store_details.done(function(data) {
                    if (data === 'loggedout'){
                        // reload page
                        location.reload();
                    } else {
                        $('.customer-billing-address').hide();
                        $('.customer-shipping-address').hide();
                        $('.customer-billing-address').html(data);
                        $('.customer-shipping-address').html(data);
                        $('.customer-billing-address').fadeIn();
                        $('.customer-shipping-address').fadeIn();
                        // hide modal
                        $('#modal-enter_manual_info').modal('hide');
                        // call jquery loading
                        form1.loading('stop');
                    }
                });
                get_store_details.fail(function(jqXHR, textStatus, errorThrown) {
                    $('#loading').modal('hide');
                    alert("Add New User Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    //$('#reloading').modal('show');
                    //location.reload();
                });
                return;

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

		var form1 = $('#form-so_add_new_user_cs');
		var error1 = $('#form-so_add_new_user_cs .alert-danger');
		var success1 = $('#form-so_add_new_user_cs .alert-success');

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

			submitHandler: function (form, e) {

                // prevent submission
                e.preventDefault();
				//success1.show();
				error1.hide();
                // call jquery loading
                form1.loading();
                // grab form data
                var objectData = form1.serializeArray();
                // add new user
                var get_store_details = $.ajax({
                    type:    "POST",
                    url:     base_url + "admin/sales_orders/add_new_user.html",
                    data:    objectData
                });
                get_store_details.done(function(data) {
                    if (data === 'loggedout'){
                        // reload page
                        location.reload();
                    } else {
                        $('.customer-billing-address').hide();
                        $('.customer-shipping-address').hide();
                        $('.customer-billing-address').html(data);
                        $('.customer-shipping-address').html(data);
                        $('.customer-billing-address').fadeIn();
                        $('.customer-shipping-address').fadeIn();
                        // hide modal
                        $('#modal-enter_manual_info').modal('hide');
                        // call jquery loading
                        form1.loading('stop');
                    }
                });
                get_store_details.fail(function(jqXHR, textStatus, errorThrown) {
                    $('#loading').modal('hide');
                    alert("Add New User Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    //$('#reloading').modal('show');
                    //location.reload();
                });
                return;

			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    var handleValidation3 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-so_create_summary_review');
		var error1 = $('#form-so_create_summary_review .alert-danger');
		var success1 = $('#form-so_create_summary_review .alert-success');

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: ":disabled",  // (:not(:visible),:disabled) validate all fields including form hidden input

			// set your custom error message here
            /* */
			messages: {
				'user_id': 'Please select store or enter manual info.',
                'ship_to': 'Please select "Ship To" options.',
			},
            // */

			rules: {
                user_id: {
					required: true
				},
                ship_to: {
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

			submitHandler: function (form, e) {

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

    var handleValidation4 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-so_diif_ship_to');
		var error1 = $('#form-so_diif_ship_to .alert-danger');
		var success1 = $('#form-so_diif_ship_to .alert-success');

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
                sh_email: {
					required: true,
					email: true
				},
				sh_fname: {
					required: true
				},
				sh_lname: {
					required: true
				},
				sh_store_name: {
					required: true
				},
				sh_telephone: {
					required: true
				},
				sh_address1: {
					required: true
				},
				sh_city: {
					required: true
				},
				sh_state: {
					required: true
				},
				sh_country: {
					required: true
				},
				sh_zipcode: {
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
                // call jquery loading
                form1.loading();
                $('#loading').modal('show');
                form.submit();

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
            handleSummernote();
            handleFancyBox();
            handleDatePickers();
            handleValidation1();
            handleValidation2();
            handleValidation3();
            handleValidation4();
            handleScripts();
            handleBootbox();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
