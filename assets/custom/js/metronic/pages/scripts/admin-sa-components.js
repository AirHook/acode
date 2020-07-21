var ComponentsEditors = function () {

    var base_url = $('body').data('base_url');
    var object_data = $('.body-content').data('object_data');

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

        function getPreset(objectData){
            var get_preset = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/get_preset.html",
                data:    objectData
            });
            get_preset.done(function(data){
                $('[name="preset"]').html('');
                $('[name="preset"]').html(data);
                $('[name="preset"]').fadeIn();
                $('[name="preset"]').selectpicker('refresh');
            });
            get_preset.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Preset Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        function loadPreset(objectData){
            var load_preset = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/load_preset.html",
                data:    objectData,
                dataType: 'json'
            });
            load_preset.done(function(data){
                $('[name="sales_package_name"]').val(data.sales_package_name);
                $('[name="email_subject"]').val(data.email_subject);
                // clear the editor content and remove all stored history
                $('#summernote_1').summernote('reset');
                // past HTML string
                $('#summernote_1').summernote('pasteHTML', data.email_message);
                // set new items to cart basket
                setItems(objectData);
            });
            load_preset.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Load Preset Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        function getCategoryTree(objectData){
            var get_category_tree = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/get_category_tree.html",
                data:    objectData
            });
            get_category_tree.done(function(data){
                // repopulate category tree
                $('.categories-tree').html(data);
                // set category breadbrumbs
                //var cat_crumbs = $('[name="cat_crumbs"]').val();
                var cat_crumbs = $('.category_list.last').data('slug_segs_name');
                $('.form-control.cat_crumbs').html(cat_crumbs);
                objectData.slugs_link = $('.category_list.last').data('slug_segs');
                // get thumbs
                getThumbs(objectData);
            });
            get_category_tree.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Category Tree Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        function getThumbs(objectData){
            var get_thumbs = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/get_thumbs.html",
                data:    objectData
            });
            get_thumbs.done(function(data){
                $('.blank-grid-text').hide();
                // populate thumbs
                $('.thumb-tiles-wrapper').hide();
                $('.thumb-tiles-wrapper').html(data);
                $('.thumb-tiles-wrapper').fadeIn();
                $('.select-product-options').css('background-color', '#2f353b');
                $('.select-product-options.thumbs-grid-view').css('background-color', '#696969');
                $('#loading').modal('hide');
                // stop jquery loading on thumbs section
                $('.thumbs-grid').loading('stop');
            });
            get_thumbs.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Thumbs Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        function setInfo(objectData){
            var set_info = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/set_info.html",
                data:    objectData
            });
            set_info.done(function(data){
                // nothing to do...
            });
            set_info.fail(function(jqXHR, textStatus, errorThrown) {
                //alert("Set Info Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        function setOptions(objectData){
            var set_options = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/set_options.html",
                data:    objectData
            });
            set_options.done(function(data){
                alert(data);
                // nothing to do...
                // stop jquery loading
                $('.mt-radio-list').loading('stop');
            });
            set_options.fail(function(jqXHR, textStatus, errorThrown) {
                alert("Set Info Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        // get item to show on popup
        function getItem(objectData){
            var addrem = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/get_item.html",
                data:    objectData
            });
            addrem.done(function(data) {
                // fill in modal
                $('.modal-body-size_qty_info').html(data);
                $('#modal-size_qty_info').modal('show');
            });
            addrem.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Get Item Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
        };

        function addRemItem(objectData){
            var addrem = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/addrem.html",
                data:    objectData
            });
            addrem.done(function(data) {
                // check/uncheck thumb
                if (objectData.action == 'rem_item'){
                    if (data == 0){
                        $('.thumb-tile.'+objectData.prod_no).removeClass('selected');
                        // user toastr notification
                        toastr.info('Item removed...');
                    }
                } else {
                    $('.step3').addClass('active');
                    $('.thumb-tile.'+objectData.prod_no).addClass('selected');
                    // user toastr notification
                    toastr.success('Item added to Sales Package...');
                }
                // set items anew
                setItems(objectData);
            });
            addrem.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Remove Item Error, status = " + textStatus + ", " + "error thrown_: " + errorThrown);
            });
        };

        function submitNewPrice(objectData){
            var set_options = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/set_item_new_price.html",
                data:    objectData
            });
            set_options.done(function(data){
                // reset modal input field
                $('[name="item_price"]').val();
                // close modal
                $('#modal-edit_item_price').modal('hide');
                // set items anew
                setItems();
            });
            set_options.fail(function(jqXHR, textStatus, errorThrown) {
                alert("Set Info Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        function setItems(objectData){
            var set_size_qty = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/set_items.html",
                data:    objectData
            });
            set_size_qty.done(function(data){
                // update  cart box
                $('.cart_basket_wrapper .cart_basket .thumb-tiles.sales-package').html('');
                $('.cart_basket_wrapper .cart_basket .thumb-tiles.sales-package').html(data);
                $('.cart_basket_wrapper .cart_basket .thumb-tiles.sales-package').fadeIn();
                // stop jquery loading
                $('.thumb-tiles.sales-package').loading('stop');
                $('.step4').addClass('active');
            });
            set_size_qty.fail(function(jqXHR, textStatus, errorThrown) {
                alert("Set Items Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };


        // ===========

        // select designer options
        $('[name="des_slug"]').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
            var objectData = object_data;
            objectData.des_slug = $(this).val();
            delete objectData.slugs_link;
            // set admin_sa_des_slug session variable
            $.get(base_url + "admin/campaigns/sales_package/set_des_slug_session/index/" + objectData.des_slug + ".html");
            // enable load preset dropdown
            $('.preset-dropdown-wrapper.tooltips').attr('data-original-title', '');
            $('[name="preset"]').removeAttr('disabled');
            $('[name="preset"]').selectpicker('refresh');
            // activate step 2, step 3, and highlight 'Select From Thumbs'
            $('.step2, .step3').addClass('active');
            $('.select-product-options.thumbs-grid-view').css('background-color', '#696969');
            // call jquery loading on thumbs section
            $('.thumbs-grid').loading();
            // enable and update category tree
            getCategoryTree(objectData);
        });

        // select product option buttons function
        $('.select-product-options').on('click', function(){
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
        });

        // load preset actions
        $('[name="preset"]').on('change', function(){
            // call jquery loading on items
            $('.thumb-tiles.sales-package').loading();
            var objectData = object_data;
            objectData.preset = $(this).val();
            // get preset sales package
            loadPreset(objectData);
            // user toastr notification
            toastr.info('Items added...');
        });

        // category tree list click action
        $('.categories-tree').on('click', '.category_list > a', function(){
            $('#loading').modal('show');
            var objectData = object_data;
            objectData.slugs_link = $(this).data('slugs_link');
            objectData.page = $(this).data('page');
            // get category tree
            getCategoryTree(objectData);
        });

        // clicked on product grid view
        $('.thumb-tiles-wrapper').on('click', '.package_items', function() {
            // new way of actions when selecting items from grid
            // show a popup of the item with stock info
            var objectData = object_data;
            objectData.prod_no = $(this).data('item');
            objectData.page = $(this).data('page');
            // check if item is already selected
            var selected = $(this).closest('.thumb-tile.image').hasClass('selected');
            if (selected) {
                var r = confirm('Item is already selected.\nDo you want to remove item?');
                if (r) {
                    objectData.action = 'rem_item';
                    // uncheck thumb
                    $('.thumb-tile.'+objectData.prod_no).removeClass('selected');
                    // rem item...
                    addRemItem(objectData);
                } else {
                    return;
                }
            } else {
                // get item...
                getItem(objectData);
            }
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
            objectData.action = 'add_item';
            // hide this modal
            $('#modal-size_qty_info').modal('hide');
            // add item...
            addRemItem(objectData);
        });

        // on any change on sa info
        $('.input-sa_info').on('change', function(){
            var objectData = object_data;
            objectData.param = $(this).attr('name');
            objectData.val = $(this).val();
            // set new info
            setInfo(objectData);
        });

        // on any change on sa info email short message
        $('#summernote_1').on('summernote.blur', function(){
            var objectData = object_data;
            objectData.param = $(this).attr('name');
            objectData.val = $(this).summernote('code');
            // set new info
            setInfo(objectData);
        });

        // radio options actions
        $('.radio-options').on('change', function(){
            // call jquery loading on options section
            $('.mt-radio-list').loading();
            // get post data
            var objectData = object_data;
            objectData.param = $(this).data('option');
            objectData.val = $(this).val();
            // set new info
            setOptions(objectData);
        });

        // "w_prices" radio toggle action
        $('[name="options[w_prices]"]').on('change', function(){
            var show = $(this).val();
            if (show == 'Y') $('.item_prices').fadeIn();
            else $('.item_prices').fadeOut();
        });

        // edit price pencil button action
        $('.thumb-tiles.sales-package').on('click', '.btn-edit_item_price', function(){
            var item = $(this).data('item');
            $('#modal-edit_item_price .modal-body .eip-modal-item').html(item);
            $('#modal-edit_item_price .modal-footer .submit-edit_item_prices').attr('data-item', item);
            $('#modal-edit_item_price').modal('show');
        });

        // edit item price modal submit actions
        $('.submit-edit_item_prices').on('click', function(){
            // call jquery loading on items
            $('.thumb-tiles.sales-package').loading();
            // gather data
            var objectData = object_data;
            objectData.item = $(this).data('item');
            objectData.price = $('[name="item_price"]').val();
            // set price at front end
            $('.item_prices.'+objectData.item+' > span.e_prices').html(objectData.price);
            // set new price
            submitNewPrice(objectData);
        });

        // remove item at summary view
        $('.thumb-tiles.sales-package').on('click', '.package_items', function(){
            var checked = $(this).prop('checked');
            var objectData = object_data;
            objectData.prod_no = $(this).val();
            objectData.page = $(this).data('page');
            objectData.action = 'rem_item';
            // uncheck thumb
            $('.thumb-tile.'+objectData.prod_no).removeClass('selected');
            $('.package_items.'+objectData.prod_no).prop('checked', false);
            // get item...
            addRemItem(objectData);
        });

        // multiple search submit action
        $('#sa-multi-search-form').on('submit', function(e){
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
                url:     base_url + "admin/campaigns/sales_package/search_multiple.html",
                data:    objectData
            });
            search_for_thumbs.done(function(data){
                if (data != 'error') {
                    $('.blank-grid-text').hide();
                    $('.search-multiple-items-wrapper').hide(); // hide the form
                    $('.thumbs-grid').fadeIn();
                    // populate thumbs
                    $('.thumb-tiles-wrapper').hide();
                    $('.thumb-tiles-wrapper').html(data);
                    $('.thumb-tiles-wrapper').fadeIn();
                    // set options button bar tone
                    $('.select-product-options').css('background-color', '#2f353b');
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
        $('.cart_basket_wrapper .thumb-tiles.sales-package').on({
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

        // add items NOT in the list functions
        $('[name="color_code"]').on('changed.bs.select', function(){
            var color_name = $('option:selected', this).data('color_name');
            $('[name="color_name"]').val(color_name);
        });

    }

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-sa_create_summary_review');
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
				sales_package_name: {
					required: true
				},
				email_subject: {
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
            handleScripts();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
