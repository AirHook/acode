var ComponentsEditors = function () {

    var base_url = $('body').data('base_url');
    var object_data = $('.body-content').data('object_data');

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
            // set all buttons to default
            $('.select-send-options').css('background-color', '#2f353b');
            $('.select-send-options').css('color', 'white');
            $('.select-send-options').removeClass('btn-active');
            // set this button to active
            //$(this).css('background-color', '#696969');
            $('.select-send-options.send-to-current-user').css('background-color', '#E5E5E5');
            $('.select-send-options.send-to-current-user').css('color', 'black');
            $('.select-send-options.send-to-current-user').addClass('btn-active');
            $('[name="send_to"]').val('current_user');
            $('.notice-select-action').hide();
            $('.send_to_a_friend').hide();
            $('.input_send_to_a_friend').hide();
            $('.send_to_new_user').hide();
            $('.send_to_all_users').hide();
            $('.send_to_current_user').fadeIn();
            $('#form-send_sales_package').trigger("reset");
            $('.alert-danger').hide();
        });

        // select action option buttons function
        $('.send-to-new-user').on('click', function(){
            // set all buttons to default
            $('.select-send-options').css('background-color', '#2f353b');
            $('.select-send-options').css('color', 'white');
            $('.select-send-options').removeClass('btn-active');
            // set this button to active
            //$(this).css('background-color', '#696969');
            $('.select-send-options.send-to-new-user').css('background-color', '#E5E5E5');
            $('.select-send-options.send-to-new-user').css('color', 'black');
            $('.select-send-options.send-to-new-user').addClass('btn-active');
            $('[name="send_to"]').val('new_user');
            $('.notice-select-action').hide();
            $('.send_to_a_friend').hide();
            $('.input_send_to_a_friend').hide();
            $('.send_to_current_user').hide();
            $('.send_to_all_users').hide();
            $('.send_to_new_user').fadeIn();
            $('.btn-set-send-sales-package').show();
            $('.selected-users-list').html('');
            $('.selected-users-list-wrapper').hide();
            $('#form-send_sales_package').trigger("reset");
            $('.alert-danger').hide();
        });

        // select action option buttons function
        $('.send-to-all-users').on('click', function(){
            // set all buttons to default
            $('.select-send-options').css('background-color', '#2f353b');
            $('.select-send-options').css('color', 'white');
            $('.select-send-options').removeClass('btn-active');
            // set this button to active
            //$(this).css('background-color', '#696969');
            $(this).css('background-color', '#E5E5E5');
            $(this).css('color', 'black');
            $(this).addClass('btn-active');
            $('[name="send_to"]').val('all_users');
            $('.notice-select-action').hide();
            $('.send_to_a_friend').hide();
            $('.input_send_to_a_friend').hide();
            $('.send_to_all_users').fadeIn();
            $('.send_to_current_user').hide();
            $('.send_to_new_user').hide();
            $('.selected-users-list').html('');
            $('.selected-users-list-wrapper').hide();
            $('#form-send_sales_package').trigger("reset");
            $('.alert-danger').hide();
        });

        // select action option buttons function - send to a friend
        $('.send-to-a-friend').on('click', function(){
            // set all buttons to default
            $('.select-send-options').css('background-color', '#2f353b');
            $('.select-send-options').css('color', 'white');
            $('.select-send-options').removeClass('btn-active');
            // set this button to active
            //$(this).css('background-color', '#696969');
            $('.select-send-options.send-to-a-friend').css('background-color', '#E5E5E5');
            $('.select-send-options.send-to-a-friend').css('color', 'black');
            $('.select-send-options.send-to-a-friend').addClass('btn-active');
            $('[name="send_to"]').val('a_friend');
            $('.notice-select-action').hide();
            $('.send_to_new_user').hide();
            $('.send_to_all_users').hide();
            $('.send_to_current_user').hide();
            $('.send_to_a_friend').fadeIn();
            $('.input_send_to_a_friend').fadeIn();
            $('#form-send_sales_package').trigger("reset");
            $('.alert-danger').hide();
        });

        // apply hover effect
        $('.select-send-options').hover(function(){
            if (!$(this).hasClass('btn-active')) {
                $(this).css('background-color', '#E5E5E5');
                $(this).css('color', 'black');
            }
        },function(){
            if (!$(this).hasClass('btn-active')) {
                $(this).css('background-color', '#2f353b');
                $(this).css('color', 'white');
            }
        });

        // submit form action for all users
        $('.btn-send-sales-package-all-users').on('click', function(){
            var form = $('#form-send_sales_package');
            //$('[name="send_to"]').val('current_user');
            if ($('.send_to_all_users.list:checked').length > 0){
                form.submit();
            }else{
                alert('Select user list to send pacakge');
            }
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
                if ($('[name="email[]"]:checked').length > 29){
                    alert('You already have 30 selected users.')
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

        // submit form action for current users
        $('.btn-send-sales-package').on('click', function(){
            var form = $('#form-send_sales_package');
            //$('[name="send_to"]').val('current_user');
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
                alert('Select user/s from list');
            }
        });
    }

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-send_sales_package');
		var error1 = $('.alert-danger');
		var success1 = $('.alert-success');

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: ":not(:visible),:disabled,:hidden",  // validate all fields including form hidden input

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

    return {
        //main function to initiate the module
        init: function () {
            handleFancyBox();
            handleValidation1();
            handleScripts();
            handleCurrentUsers();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
