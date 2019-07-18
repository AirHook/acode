var FormValidation = function () {

	var base_url = $('body').data('base_url');
	// grab the first segment of url
	var cur_url = $(location).attr('href');
	var res = cur_url.replace(base_url, '');
	var seg1 = res.split('/')[0];

    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
				format: "yyyy-mm-dd",
                autoclose: true
			});
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
		}

        /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */

        // Workaround to fix datepicker position on window scroll
		/*
        $( document ).scroll(function(){
            $('#form_modal2 .date-picker').datepicker('place'); //#modal is the id of the modal
        });
		*/
    }

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-sales_orders_create');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input

			// set your custom error message here
			//messages: {
			//	access_level: {
			//		valueNotEquals: "Please select an item"
			//	}
			//},

			rules: {
				po_number: {
					required: true
				},
				po_date: {
					required: true
				},
				des_id: {
					required: true
				},
				user_id: {
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
				var cont = $(element).parent('.input-group'); // input group
				var dd = $(element).parent('.btn-group.bs-select'); // bootstrap select
				if (cont.size() > 0) {
					cont.after(error);
				} else if (dd.size() > 0) {
					dd.after(error);
				} else {
					element.after(error);
				}
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
				$('#loading .modal-title').html('Submitting...');
				$('#loading').modal('show');
				form.submit();
				//return false;
			}
		});
    }

	// setting a checkbox element global variable to get on modal events
	var theCheckbox = false;

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

	// show select size and qty modal for product thumbs grid
	$('[name="prod_no[]"]').on('change', function(){
		var checked = $(this).is(':checked');
		var style_no = $(this).val();
		var prod_no = $(this).data('prod_no');
		var color_name = $(this).data('color_name');
		var objectData = $(this).data('object_data'); // sizes only
		var stocstat = $(this).data('so_stocstat');
		if (checked) {
			// assign element to global var
			theCheckbox = $(this);
			// add class to size select drop down
			$.each(objectData, function(i, item){
				if (item == 0) {
					$('[name="'+i+'"]').removeClass('preorder instock').addClass('preorder');
				} else {
					$('[name="'+i+'"]').removeClass('preorder instock').addClass('instock');
				}
			});
			// if stocstat has been set, hide the unnecessaries
			var el1 = $('#modal-so_stocstat').find('.size-select');
			el1.each(function(){
				if (stocstat == 1)
					if ($(this).hasClass('preorder')) $(this).parent('div').hide();
				if (stocstat == 2)
					if ($(this).hasClass('instock')) $(this).parent('div').hide();
			});
			// udpate modal info
			$('#modal-so_stocstat').find('[name="style_no"]').val(style_no);
			$('#modal-so_stocstat').find('.span-prod_no').html(prod_no);
			$('#modal-so_stocstat').find('.span-color_name').html(color_name);
			// finally show modal
			$('#modal-so_stocstat').modal('show');
		} else {
			// remove items from selection
			$.ajax({
                type:    "POST",
                url:     base_url + seg1 + "/sales_orders/rem_item.html",
                data:    {"style_no":style_no},
                success: function(data) {
					// parse json data
					var data = $.parseJSON(data);
					var items_count = data.overallTotal;
					var count_length = items_count.toString().length;
					// process data from ajax
                    $('#loading').modal('hide');
                    $('.items_count').html(items_count);
                    $('.thumb-tile.'+style_no).toggleClass('selected');
                    if (items_count > 0) {
                        $('.clear_all_items').parent('div').removeClass('hide');
                        $('.sidebar_cart_link').attr('href', base_url + seg1 + '/purchase_orders/create/step2.html');
                        $('.sidebar-send-package-btn').attr('href', base_url + seg1 + '/purchase_orders/create/step2.html');
                        //if ($('.sidebar-send-package-btn').hasClass('tooltips')) {
                        //    $('.sidebar-send-package-btn').toggleClass('tooltips disabled-link disable-target');
                        //    $('.sidebar-send-package-btn').attr('data-original-title', '');
                        //}
                    } else {
                        $('.clear_all_items').parent('div').addClass('hide');
                        $('.sidebar_cart_link').attr('href', 'javascript:;');
                        $('.sidebar-send-package-btn').attr('href', 'javascript:;');
                        //$('.sidebar-send-package-btn').addClass('tooltips disabled-link disable-target');
                        //$('.sidebar-send-package-btn').attr('data-original-title', 'Nothing to send');
                    }
                    //window.location.href=base_url + "admin/products/edit/index/" + prod_id;
                },
                // vvv---- This is the new bit
                error:   function(jqXHR, textStatus, errorThrown) {
                    //$('#loading').modal('hide');
                    alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    //$('#reloading').modal('show');
                    //location.reload();
                }
            });
		}
	});

	// capture if modal has been hidden manually to uncheck box again
	$('#modal-so_stocstat').on('hide.bs.modal', function(e){
		if (theCheckbox) theCheckbox.prop('checked', false);
	});

	// size select actions
	$('.size-select').on('change', function(){
		// check for intial stocstat and advise user
		var stocstat = $(this).attr('data-so_stocstat');
		if ($(this).hasClass('instock')) {
			if (stocstat == 0) {
				alert('You have started selecting items that are AVAILABLE in stock.\nSeccessive selections will follow suit.')
			}
			// hide preorder sizes
			$('.preorder').parent('div').hide();
			$('#modal-so_stocstat').find('.cite-instock').removeClass('hide');
			$('.size-select').each(function(){
				$(this).attr('data-so_stocstat', '1');
			})
			$.get(base_url+'sales/sales_orders/set_stocstat/index/1');
		}
		else if ($(this).hasClass('preorder')) {
			if (stocstat == 0) {
				alert('You have started selecting items that are PREORDER items.\nSeccessive selections will follow suit.')
			}
			// hide intock sizes
			$('.instock').parent('div').hide();
			$('#modal-so_stocstat').find('.cite-preorder').removeClass('hide');
			$('.size-select').each(function(){
				$(this).attr('data-so_stocstat', '2');
			})
			$.get(base_url+'sales/sales_orders/set_stocstat/index/2');
		}
	});

	// let's capture the modal form's submit
	$('#form-set_size_qty').submit(function(e){
		// check if input has at least 1 item more than zero
		var el = $(this).find('.size-select');
		var elok = false;
		el.each(function(){
			if ($(this).val() > 0) elok = true;
		});
		if (elok) {
			var data = $(this).serializeArray();
			var returnArray = {};
			for (var i = 0; i < data.length; i++) {
				returnArray[data[i]['name']] = data[i]['value'];
			}
			$.ajax({
                type:    "POST",
                url:     base_url + seg1 + "/sales_orders/add_set_size_qty.html",
                data:    returnArray,
                success: function(data) {
					// parse json data
					var data = $.parseJSON(data);
					var items_count = data.overallTotal;
					var count_length = items_count.toString().length;
					// disable global var and hide modal
					theCheckbox = false;
					el.each(function(){
						$(this).val('0');
					});
					$('#modal-so_stocstat').modal('hide');
					// process data from ajax
                    $('#loading').modal('hide');
                    $('.items_count').html(items_count);
					if (count_length >= 2) $('.items_count').css('font-size','0.8rem');
                    $('.thumb-tile.'+returnArray.style_no).toggleClass('selected');
                    if (items_count > 0) {
						// set steps wizard link
						var link = $('.step.step2').data('link');
						$('.step.step2').attr('href',link);
                        $('.clear_all_items').parent('div').removeClass('hide');
                        $('.sidebar_cart_link').attr('href', base_url + seg1 + '/purchase_orders/create/step2.html');
                        $('.sidebar-send-package-btn').attr('href', base_url + seg1 + '/purchase_orders/create/step2.html');
                        //if ($('.sidebar-send-package-btn').hasClass('tooltips')) {
                        //    $('.sidebar-send-package-btn').toggleClass('tooltips disabled-link disable-target');
                        //    $('.sidebar-send-package-btn').attr('data-original-title', '');
                        //}
                    } else {
                        $('.clear_all_items').parent('div').addClass('hide');
                        $('.sidebar_cart_link').attr('href', 'javascript:;');
                        $('.sidebar-send-package-btn').attr('href', 'javascript:;');
                        //$('.sidebar-send-package-btn').addClass('tooltips disabled-link disable-target');
                        //$('.sidebar-send-package-btn').attr('data-original-title', 'Nothing to send');
                    }
                    //window.location.href=base_url + "admin/products/edit/index/" + prod_id;
                },
                // vvv---- This is the new bit
                error:   function(jqXHR, textStatus, errorThrown) {
                    //$('#loading').modal('hide');
                    alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                    //$('#reloading').modal('show');
                    //location.reload();
                }
            });
		} else {
			alert('Plesae select quantity for at least one size.');
		}
		// stop form submit action
		e.preventDefault();
	});

	// step 2 send to which user buttons
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





	// clear all items button action for sales resource using
    // sales order list page
	$('.confirm-clear_all_items').click(function(){
		$('#modal-clear_all_items').modal('hide');
		$('#loading .modal-title').html('Clearing...');
		$('#loading').modal('show');
		// call the url using get method
		$.get(base_url + "sales/sales_package/clear_all_items.html");
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

	// sales resource pages
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

	return {
        //main function to initiate the module
        init: function () {

			handleDatePickers();
            handleValidation1();
		}

    };

}();

if (App.isAngularJsApp() === false) {
	jQuery(document).ready(function() {
		FormValidation.init();
	});
}
