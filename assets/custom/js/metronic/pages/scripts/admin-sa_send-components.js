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
        });

        // current user sent to all checkbox
        $('.send_to_all').on('change', function(){
            var checked = $(this).prop('checked');
            if (checked) {
                $('.notice-send-to-all').fadeIn();
            } else {
                $('.notice-send-to-all').hide();
            }
        });

        // pagination actions
        $('.sa-send.pagination').on('click', 'li > a', function(){
            var objectData = object_data;
            objectData.cur = $(this).data('cur');
            objectData.end_cur = $(this).closest('ul').data('end_cur');
            getPagination(objectData);
        });

        function getPagination(objectData){
            var get_pagination = $.ajax({
                type:    "POST",
                url:     base_url + "admin/campaigns/sales_package/get_pagination.html",
                data:    objectData
            });
            get_pagination.done(function(data){
                $('.sa-send.pagination').hide();
                $('.sa-send.pagination').html('');
                $('.sa-send.pagination').html(data);
                $('.sa-send.pagination').fadeIn();
            });
            get_pagination.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Pagination Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        };




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
