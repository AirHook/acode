var ComponentsEditors = function () {

    var base_url = $('body').data('base_url');

    var handleSummernote = function () {

        $('#summernote_1').summernote({
			height: 450,
            callbacks: {
                onImageUpload: function(image) {
                    //alert(JSON.stringify(image));
                    //editor = $(this);
                    uploadImageContent(image[0]);
                }
            }
            /*
            // using default toolbar set
			//toolbar: [
				// [groupName, [list of button]]
				//['main', ['style']],
				//['style', ['bold', 'italic', 'underline', 'clear']],
				//['para', ['ul', 'ol', 'paragraph']],
				//['link', ['link']]
			//]
            */
		});

        function uploadImageContent(image) {

            var el = $('#summernote_1').closest('div.form-body');
            //var objectData = el.data('object_data');
            var token = el.data('token');
            var hash = el.data('hash');
            //objectData.image = image;

            var datum = new FormData();
            datum.append(token, hash);
            datum.append('image', image);

            /* */
            $.ajax({
                type:    "POST",
                url:     base_url + "admin/dcn/upload_images.html",
                data:    datum,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    var imgEl = document.createElement('img');
                    imgEl.src = data;
                    imgEl.style.width = 'auto';
                    $('#summernote_1').summernote('editor.insertNode', imgEl);
                    //$('#loading').modal('hide');
                    //window.location.href=base_url + "admin/products/edit/index/" + prod_id;
                },
                // vvv---- This is the new bit
                error:   function(jqXHR, textStatus, errorThrown) {
                    $('#loading').modal('hide');
                    alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    $('#reloading').modal('show');
                    location.reload();
                }

                /*
                success: function(url) {
                    var image = $(‘<img>’).attr(‘src’, url);
                    $(editor).summernote(“insertNode”, image[0]);
                },
                error: function(data) {
                    console.log(data);
                }
                // */
            });
            // */

        }
    }

    var handleScripts = function () {

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
                        message: "Sending package. Please confirm...",
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
                                label: "Send Package",
                                className: "dark",
                                callback: function() {
                                    $('[name="sales_package_id"]').val('0');
                                    $('#form-send_sales_package').submit();
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
                url:     base_url + "sales/sales_package/addrem.html",
                data:    objectData,
                success: function(data) {
                    $('#loading').modal('hide');
                    $('.items_count').html(data);
                    $('.thumb-tile.'+objectData.prod_no).toggleClass('selected');
                    if (data > 0) $('.sidebar_cart_link').attr('href', base_url + 'sales/create/step2.html');
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
            var objectData = $(this).data('object_data');
            objectData.prod_no = $(this).val();
            objectData.action = 'rem_item';
            $.ajax({
                type:    "POST",
                url:     base_url + "sales/sales_package/addrem.html",
                data:    objectData,
                success: function(data) {
                    $('#loading').modal('hide');
                    $('.items_count').html(data);
                    $('.thumb-tile.'+objectData.prod_no).toggleClass('selected');
                    if (data > 0) $('.sidebar_cart_link').attr('href', base_url + 'sales/create/step2.html');
                    container.hide();
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

        // sa summary options actions
        // if not on sa_options, assume defaults (w_prices only is Y)
        $('.sa_options').on('change', function(){
            $('#loading .modal-title').html('Processing...');
            $('#loading').modal('show');
            var objectData = $(this).closest('div').data('object_data');
            var key = $(this).attr('name');
            var val = $(this).val();
            switch (key) {
                case 'w_prices':
                    objectData.w_prices = val;
                    break;
                case 'w_images':
                    objectData.w_images = val;
                    break;
                case 'linesheets_only':
                    objectData.linesheets_only = val;
                    break;
            }
            $.ajax({
                type:    "POST",
                url:     base_url + "sales/sales_package/set_options.html",
                data:    objectData,
                success: function(data) {
                    $('#loading').modal('hide');
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

        // edit prices actions
        // attach a submit handler to the form
        $('.form-edit_prices').submit(function(e){
            // stop form from submitting normally
            e.preventDefault();
            // get form details
            var form = $(this);
            var url = form.attr('action'); // action attribute
            var tokes = form.find('input[name="tokes"]').val();
            var chash = form.find('input[name="chash"]').val();
            var item = form.find('input[name="item"]').val();
            var price = form.find('input[name="price"]').val();
            var object_data = '{"' + tokes + '":"' + chash + '","e_prices":{"' + item + '":"' + price + '"}}'
            var objectData = JSON.parse(object_data);
            // perfom ajax
            $.ajax({
                type:    "POST",
                url:     base_url + "sales/sales_package/set_options.html",
                data:    objectData,
                success: function(data) {
                    form.closest('.item-price-col').find('.box.item-price').html(price);
                    //window.location.href=base_url + "admin/products/edit/index/" + prod_id;
                },
                // vvv---- This is the new bit
                error:   function(jqXHR, textStatus, errorThrown) {
                    //alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    $('#reloading').modal('show');
                    location.reload();
                }
            });
            // close modal
            form.closest('.modal').modal('hide');
        });

        // clear all items button action
        $('.confirm-clear_all_items').click(function(){
            $('#modal-clear_all_items').modal('hide');
            $('#loading .modal-title').html('Clearing...');
            $('#loading').modal('show');
            // call the url using get method
            $.get(base_url + "sales/sales_package/clear_all_items.html", function(data){
                var step = $('.clear_all_items').data('step');
                if (data == 'clear' && step == 3) {
                    window.location.href=base_url + "sales/create/step2.html";
                }
                if (data == 'clear' && step == 2) {
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
                    $.get(base_url + "sales/sales_package/clear_all_items.html", function(data){
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

        // send to all / current Users checkbox
        $('.send_to_all').on('change', function(){
            var checked = $(this).is(':checked');
            var checkboxes = $('input.send_to_current_user');
            if (typeof checkboxes !== "undefined") {
                $(checkboxes).each(function(){
                    if (checked) $(this).prop('checked', true);
                    else $(this).prop('checked', false);
                });
            }
        });
        $('input.send_to_current_user').on('change', function(){
            var checked = $(this).is(':checked');
            var all = $('input.send_to_current_user.list').length;
            var checked = $('input.send_to_current_user.list:checked').length;
            if (checked == all) {
                $('.send_to_current_user.send_to_all').prop('checked', true);
            } else {
                $('.send_to_current_user.send_to_all').prop('checked', false);
            }
        });
    }

    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-send_sales_package');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);
        //var summernoteElement = $('#summernote_1');

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: ":not(:visible),:disabled",  // validate all fields including form hidden input

			// set your custom error message here
			messages: {
				'email[]': 'Please select at least 1 email.'
			},

			rules: {
				sales_package_name: {
					required: true
				},
                email_subject: {
					required: true
				},
                reference_designer: {
					required: true
				},
				admin_sales_email: {
					required: true,
					email: true
				},
				email: {
					required: true,
					email: true
				},
                'email[]': {
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
				return false;
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.select2me', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    var handleBootbox = function() {
        $('.mt-bootbox-new').click(function(){
            bootbox.dialog({
                message: "Sending package. Please confirm...",
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
                        label: "Send Package",
                        className: "dark",
                        callback: function() {
                            $('[name="sales_package_id"]').val('0');
                            $('#form-send_sales_package').submit();
                        }
                    }
                }
            });
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

    return {
        //main function to initiate the module
        init: function () {
            handleSummernote();
            handleScripts();
            handleValidation1();
            handleBootbox();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
