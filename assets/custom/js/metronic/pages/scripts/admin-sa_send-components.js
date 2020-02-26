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


        // ===========

        // select action option buttons function
        $('.send-to-current-user').on('click', function(){
            $('.select-send-options').css('background-color', '#2f353b');
            $(this).css('background-color', '#696969');
            $('[name="send_to"]').val('current_user');
            $('.send_to_new_user').hide();
            $('.send_to_current_user').show();
            $('.notice-select-action').hide();
            $('.btn-set-send-sales-package').show();
            $('#form-send_sales_package').trigger("reset");
        });

        // select action option buttons function
        $('.send-to-new-user').on('click', function(){
            $('.select-send-options').css('background-color', '#2f353b');
            $(this).css('background-color', '#696969');
            $('[name="send_to"]').val('new_user');
            $('.send_to_current_user').hide();
            $('.send_to_new_user').fadeIn();
            $('.notice-select-action').hide();
            $('.btn-set-send-sales-package').show();
            $('.selected-users-list').html('');
            $('.selected-users-list-wrapper').hide();
            $('#form-send_sales_package').trigger("reset");
        });




        // load preset actions
        $('[name="preset"]').on('change', function(){
            // call jquery loading on items
            $('.thumb-tiles.sales-package').loading();
            var objectData = object_data;
            objectData.preset = $(this).val();
            // get preset sales package
            getPreset(objectData);
            // user toastr notification
            toastr.info('Items added...');
        });

        // category tree list click action
        $('.categories-tree').on('click', '.category_list', function(){
            $('#loading').modal('show');
            var objectData = object_data;
            objectData.slugs_link = $(this).data('slugs_link');
            // get category tree
            getCategoryTree(objectData);
        });

        // clicked on product grid view
        $('.thumb-tiles-wrapper').on('click', '.package_items', function() {
            var checked = $(this).prop('checked');
            var objectData = object_data;
            objectData.prod_no = $(this).data('item');
            if (checked) {
                objectData.action = 'add_item';
                // check thumb
                $('.thumb-tile.'+objectData.prod_no).addClass('selected');
            } else {
                objectData.action = 'rem_item';
                // check thumb
                $('.thumb-tile.'+objectData.prod_no).removeClass('selected');
            }
            // get item...
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
            objectData.param = $(this).attr('name');
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

        // multiple search submit action
        $('#so-multi-search-form_').on('submit', function(e){
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

    var handleCurrentUsers = function () {

        // on select users from checkbox list
        $('.select-users-list').on('change', '.send_to_current_user.list', function(){
            var html = '';
            var email = $(this).val();
            var store_name = $(this).data('store_name');
            var firstname = $(this).data('firstname');
            var lastname = $(this).data('lastname');
            var checked = $(this).is(':checked');
            if (checked){
                // show wrapper of list
                if ($('[name="email[]"]:checked').length == 0) $('.selected-users-list-wrapper').show();
                // check if number of selected users is more than 10 already
                if ($('[name="email[]"]:checked').length > 9){
                    alert('You already have 10 selected users.')
                    $(this).prop('checked', false);
                }else{
                    // add to selected list
                    html = '<label class="mt-checkbox mt-checkbox-outline" style="font-size:0.9em;">'+store_name+' - '+firstname+' '+lastname+' <cite class="small">('+email+')</cite><input type="checkbox" class="send_to_current_user selected-list" name="email[]" value="'+email+'" checked /><span></span></label>';
                    $('.selected-users-list').append(html);
                }
            }else{
                var selEl = $('input.selected-list[value="'+email+'"]');
                if (selEl) selEl.parents('label').remove();
                // hide wrapper of list
                if ($('[name="email[]"]:checked').length == 0) $('.selected-users-list-wrapper').hide();
            }
        });

        // remove user from selected list
        $('.selected-users-list').on('change', '.send_to_current_user.selected-list', function(){
            var email = $(this).val();
            $(this).parents('label').remove();
            $('input.send_to_current_user.list[value="'+email+'"]').prop('checked', false);
        });




        // search current user
        $('.btn-search-current-user').on('click', function(){
            // call jquery loading on options section
            $('.select-users-list').loading();
            // process data
            var thisUrl;
            var role = $('input.select-user-search[name="search_string"]').data('role');
            var per_page = $('input.select-user-search[name="search_string"]').data('per_page');
            var search_string = $('input.select-user-search[name="search_string"]').val();
            var sales_user = $('[name="sales_user"]').val();
            if (search_string != '') {
                if (role == 'sales') {
                    thisUrl = base_url + "my_account/sales/sales_package/search_current_user.html"
                } else {
                    thisUrl = base_url + "admin/campaigns/sales_package/search_current_user.html";
                }
                objectData = object_data;
                objectData.per_page = per_page;
                objectData.search_string = search_string;
                if (sales_user) objectData.admin_sales_email = sales_user;
                var search_current_users = $.ajax({
                    type:    "POST",
                    url:     thisUrl,
                    data:    objectData
                });
                search_current_users.done(function(data){
                    if (data != 'error'){
                        // hide caption showing and pagination
                        $('.sa-send.current-users.toolbar > .caption.showing').hide();
                        $('.sa-send.current-users.toolbar > .pagination').hide();
                        // show caption search
                        $('.sa-send.current-users.toolbar > .caption.search > .search_string').html(search_string);
                        $('.sa-send.current-users.toolbar > .caption.search').show();
                        // update user list
                        $('.select-users-list').html('');
                        $('.select-users-list').html(data);
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
        })

        // reset search button
        $('.btn-reset-search-current-user').on('click', function(){
            // call jquery loading on options section
            $('.select-users-list').loading();
            // process
            var thisUrl;
            var role = $('input.select-user-search[name="search_string"]').data('role');
            var per_page = $('input.select-user-search[name="search_string"]').data('per_page');
            var total_users = $('input.select-user-search[name="search_string"]').data('total_users');
            objectDataReset = object_data;
            objectDataReset.reset = per_page;
            objectDataReset.cur = '1';
            objectDataReset.end_cur = $(this).data('end_cur');
            if (role == 'sales') {
                thisUrl = base_url + "my_account/sales/sales_package/reset_search_current_user.html"
            } else {
                thisUrl = base_url + "admin/campaigns/sales_package/reset_search_current_user.html";
            }
            var reset_search = $.ajax({
                type:    "POST",
                url:     thisUrl,
                data:    objectDataReset
            });
            reset_search.done(function(data){
                if (data != 'error'){
                    // show pagination caption
                    $('.sa-send.current-users.toolbar > .caption.showing > .pagination-caption-showing').html('1');
                    $('.sa-send.current-users.toolbar > .caption.showing > .pagination-caption-per-page').html(per_page);
                    $('.sa-send.current-users.toolbar > .caption.showing > .pagination-caption-total_users').html(total_users);
                    $('.sa-send.current-users.toolbar > .caption.showing').show();
                    // hide caption search
                    $('.sa-send.current-users.toolbar > .caption.search > .search_string').html('');
                    $('.sa-send.current-users.toolbar > .caption.search').hide();
                    // update user list
                    $('.select-users-list').html('');
                    $('.select-users-list').html(data);
                    // get actions
                    getPagination(objectDataReset);
                }
            });
            reset_search.fail(function(jqXHR, textStatus, errorThrown) {
                $('#loading').modal('hide');
                alert("Reset Search Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                //$('#reloading').modal('show');
                //location.reload();
            });
            // stop jquery loading
            $('.select-users-list').loading('stop');
        });

        // pagination actions
        $('.sa-send > .pagination').on('click', 'li > a', function(){
            // call jquery loading on options section
            $('.select-users-list').loading();
            // gether and process data
            var showCount, showCountOf, offset;
            var per_page = $(this).parents('ul').data('per_page');
            var total_users = $(this).parents('ul').data('total_users');
            var page = $(this).data('cur_page');
            var limit = per_page;
            var objectDataPage = object_data;
            objectDataPage.cur = $(this).data('cur_page');
            objectDataPage.end_cur = $(this).closest('ul').data('end_cur');
            objectDataPage.limit = limit;
            // update pagination caption info
            if (page == '1') {
                showCount = 1;
                offset = '0';
            } else {
                showCount = (parseInt(page) - 1) * parseInt(per_page) + 1;
                offset = (parseInt(page) - 1) * parseInt(per_page);
            }
            var showCountOf = parseInt(page) * parseInt(per_page);
            objectDataPage.offset = offset;
            $('.sa-send.current-users.toolbar > .caption.showing > .pagination-caption-showing').html(showCount);
            $('.sa-send.current-users.toolbar > .caption.showing > .pagination-caption-per-page').html(showCountOf);
            $('.sa-send.current-users.toolbar > .caption.showing > .pagination-caption-total_users').html(total_users);
            $('.sa-send.current-users.toolbar > .caption.showing').show();
            // get actions
            getPagination(objectDataPage);
            getPageList(objectDataPage);
        });

        function getPagination(objectDataPage){
            var get_pagination = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/get_pagination.html",
                data:    objectDataPage
            });
            get_pagination.done(function(data){
                $('.sa-send > .pagination').hide();
                $('.sa-send > .pagination').html('');
                $('.sa-send > .pagination').html(data);
                $('.sa-send > .pagination').fadeIn();
            });
            get_pagination.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Pagination Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        function getPageList(objectDataPage){
            var get_pagination = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/page_current_user.html",
                data:    objectDataPage
            });
            get_pagination.done(function(data){
                if (data != 'error'){
                    // update user list
                    $('.select-users-list').html('');
                    $('.select-users-list').html(data);
                }
                // stop jquery loading
                $('.select-users-list').loading('stop');
                // get checked emails if any
                $('[name="email[]"]:checked').each(function(){
                    var val = $(this).val();
                    $('.send_to_current_user.list[value="'+val+'"]').prop('checked', true);
                });
            });
            get_pagination.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Pagination List Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };

        // submit form action
        $('.btn-send-sales-package').on('click', function(){
            var form = $('#form-send_sales_package');
            if ($('[name="email[]"]:checked').length > 0){
                var val;
                var cnt = 1;
                $('[name="email[]"]:checked').each(function(){
                    if (cnt > 1) val = val+','+$(this).val();
                    else val = $(this).val();
                    cnt++;
                });
                $('[name="emails"]').val(val);
                form.submit();
            }else{
                alert('Select user from list');
            }
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
            handleCurrentUsers();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
