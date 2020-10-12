var ComponentsProductEdit = function () {

    var base_url = $('body').data('base_url');
    var object_data = $('.body-content').data('object_data');

    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "right",
				format: "yyyy-mm-dd",
                autoclose: true
			});
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal

			// datepicker scripts
			// entire product item
			$('#publish_date').on('changeDate', function(ev){
				var d = Date.parse($(this).val());
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!
				var yyyy = today.getFullYear();
				if (dd<10) {
					dd = '0'+dd
				}
				if (mm<10) {
					mm = '0'+mm
				}
				today = yyyy + '-' + mm + '-' + dd;
				var n = Date.parse(today); // date now
				if (d > n) {
					//$('#publish-pending').show();
					$('#pending-at').show();
					//$('#publish').selectpicker('val', '3');
					//$('#publish').prop('disabled', true);
					//$('#publish').selectpicker('refresh');
					//$('#publish-at, #private-at').hide();
					//$('.notice-variant_level_publish').show();
				} else {
					$('#publish').prop('disabled', false);
					//$('#publish-pending').hide();
					$('#pending-at').hide();
					//var orig_publish = $('#publish').data('orignial_publish');
					//var reset_publish = orig_publish;
					//if (orig_publish == '3'||orig_publish === '1'||orig_publish === '11'||orig_publish === '12') reset_publish = '1';
					//$('#publish').selectpicker('val', reset_publish);
					//$('#publish').selectpicker('refresh');
					//if ($('#publish_date').val() == '1') $('#pending-at').show();
					//$('.notice-variant_level_publish').hide();
				}
			});

			// per variant
			$('.color_date.date-picker').on('changeDate', function(ev){
				// let get necessary information
				var primary_color = $(this).closest('.section-options').data('primary_color');
				var st_id = $(this).closest('.section-options').data('st_id');
				var color_code = $(this).closest('.section-options').data('color_code');
				var base_url = $(this).closest('.section-options').data('base_url');
				var prod_id = $(this).closest('.section-options').data('prod_id');
				var dataObject = $(this).closest('.section-options').data('object_data');
				var d = Date.parse($(this).val());
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth()+1; //January is 0!
				var yyyy = today.getFullYear();
				if(dd<10) {
					dd = '0'+dd
				}
				if(mm<10) {
					mm = '0'+mm
				}
				today = yyyy + '-' + mm + '-' + dd;
				var n = Date.parse(today);
				if (d > n) {
					//$('#publish-pending-' + color_code).show();
					$('#pending-at-' + color_code).show();
					//$('#new_color_publish-' + color_code).selectpicker('val', '3');
					//$('#new_color_publish-' + color_code).prop('disabled', true);
					//$('#new_color_publish-' + color_code).selectpicker('refresh');
					//$('#publish-at-' + color_code + ', #private-at-' + color_code).hide();
					//var cp = 'N';
				} else {
					$('#new_color_publish-' + color_code).prop('disabled', false);
					//$('#publish-pending-' + color_code).hide();
					$('#pending-at-' + color_code).hide();
					//var orig_publish = $('#new_color_publish-' + color_code).data('orignal_publish');
					//var reset_publish = orig_publish;
					//if (orig_publish == '3'||orig_publish === '1'||orig_publish === '11'||orig_publish === '12') reset_publish = '1';
					//$('#new_color_publish-' + color_code).selectpicker('val', reset_publish);
					//$('#new_color_publish-' + color_code).selectpicker('refresh');
					//if ($('#new_color_publish-' + color_code).val() == '1') $('#publish-at-' + color_code).show();
					//var cp = 'Y';
				}
				$('#loading .modal-title').html('Updating...');
				$('#loading').modal('show');
				dataObject.stock_date = $('#stock_date-' + color_code).val();
				dataObject.new_color_publish = $('#new_color_publish-' + color_code).selectpicker('val');
				//dataObject.color_publish = cp;
				$.ajax({
					type:    "POST",
					url:     base_url + "admin/products/update_variant_options/" + prod_id,
					data:    dataObject,
					success: function(data) {
						//alert(data);
						$('#loading').modal('hide');
						//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
					},
					// vvv---- This is the new bit
					error:   function(jqXHR, textStatus, errorThrown) {
						//$('#loading').modal('hide');
						//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
						$('#reloading').modal('show');
						location.reload();
					}
				});
			});
        }

        /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */

        // Workaround to fix datepicker position on window scroll
        $( document ).scroll(function(){
            $('#form_modal2 .date-picker').datepicker('place'); //#modal is the id of the modal
        });
    }

    var scriptFunctions = function () {

		// Main publish drop down options
		$('#publish').change(function(){
			if ($('#publish').selectpicker('val') == 1) {
				$('#publish-at').show();$('#private-at').hide();
				$('.notice-variant_level_publish').hide();
			} else if ($('#publish').selectpicker('val') == 2) { // private
				$('#publish-at').hide();$('#private-at').show();
				$('.notice-variant_level_publish').hide();
			} else if ($('#publish').selectpicker('val') == 3) { // publish pending
				$('#publish-at, #private-at').hide();
				$('.notice-variant_level_publish').show();
			} else { // UNpublish
				$('#publish-at, #private-at').hide();
				$('.notice-variant_level_publish').show();
			}
		});

		// Main Checkboxes Publish at Hub or Satellite
		$('.publish_at').change(function(){
			if ($('#publish_at_hub').is(":checked")) ph = 1;
			else ph = 0;
			if ($('#publish_at_satellite').is(":checked")) ps = 1;
			else ps = 0;
			if (ph == 0 && ps == 0) {
				alert('You must at least publish product at one location');
				$(this).prop('checked', true);
				return false;
			}
		});

        // Main On Sale checkbox
        $('[name="clearance"]').on('change', function(){
            if ($(this).is(":checked")) {
                var r = confirm('Set all variants to "ON SALE".\n\nContinue?\n\n');
                if (r == true) {
                    $('.custom_order').prop('checked', true);
                } else {
                    $(this).prop('checked', false);
                    return;
                }
            } else {
                var r = confirm('UNCHECK all variants ON SALE option checkbox.\n\nContinue?\n\n');
                if (r == true) {
                    $('.custom_order').prop('checked', false);
                } else {
                    $(this).prop('checked', true);
                    return;
                }
            }
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
            $('#form-products_edit').submit();
        });

		// fix for checkboxes on modals not working properly
		// this helps in showing the check on click
		$(".modal input:checkbox,.modal label").on("click", function(e){
			e.stopImmediatePropagation();
			var element = (e.currentTaget.htmlFor !== undefined) ? e.currentTaget.htmlFor : e.currentTaget;
			var checked = (element.checked) ? false : true;
			element.checked = (checked) ? false : checked.toString();
		});

		// add color dropdown function
		$('#color_code').change(function(){
			$('[name="color_name"]').val($('#color_code').find("option:selected").text().trim());
		});

		// upload image button function
		$('.upload_images').on('click', function() {
			var el = $(this);
			var st_id = el.data('st_id');
			var new_color_publish = $('input[name="new_color_publish['+st_id+']"]:checked').val();
			var color_publish = $('input[name="color_publish['+st_id+']"]:checked').val();
			$('input[name="upload_images_st_id"]').val(st_id);
			$('input[name="new_color_publish"]').val(new_color_publish);
			$('input[name="color_publish"]').val(color_publish);
		});

		// stock passing of data to modal
		$('.modal_stocks').on('click', function() {
			var el = $(this);
			var st_id = el.data('st_id');
			var color_name = el.data('color_name');
			$('#st_id').val(st_id);
			$('#color_name').val(color_name);
			var sizeMode = el.data('size_mode');
			var stocks = el.data('stocks');
			if (sizeMode == '1') {
                var stocksArray = stocks.split(',');
				stocksArray.forEach(function(item, index){
					$('#size_' + (index * 2)).val(item);
				});
			} else if (sizeMode == '0') {
                var stocksArray = stocks.split(',');
				stocksArray.forEach(function(item, index){
					switch (index) {
						case 0: var size = 'size_ss'; break;
						case 1: var size = 'size_sm'; break;
						case 2: var size = 'size_sl'; break;
						case 3: var size = 'size_sxl'; break;
						case 4: var size = 'size_sxxl'; break;
					}
					$('#' + size).val(item);
				});
            } else if (sizeMode == '2') {
                $('#size_sprepack1221').val(stocks);
            } else if (sizeMode == '3') {
                var stocksArray = stocks.split(',');
				stocksArray.forEach(function(item, index){
					switch (index) {
						case 0: var size = 'size_ssm'; break;
						case 1: var size = 'size_sml'; break;
					}
					$('#' + size).val(item);
				});
            } else if (sizeMode == '4') {
                $('#size_sonesizefitsall').val(stocks);
			}
		});

        // admin stock passing of data to modal
		$('.modal_admin_stocks').on('click', function() {
			var el = $(this);
			var st_id = el.data('st_id');
			var color_name = el.data('color_name');
			$('#admin_st_id').val(st_id);
			var sizeMode = el.data('size_mode');
			var stocks = el.data('stocks');
			if (sizeMode == '1') {
                var stocksArray = stocks.split(',');
				stocksArray.forEach(function(item, index){
					$('#admin_physical_' + (index * 2)).val(item);
				});
			} else if (sizeMode == '0') {
                var stocksArray = stocks.split(',');
				stocksArray.forEach(function(item, index){
					switch (index) {
						case 0: var size = 'admin_physical_ss'; break;
						case 1: var size = 'admin_physical_sm'; break;
						case 2: var size = 'admin_physical_sl'; break;
						case 3: var size = 'admin_physical_sxl'; break;
						case 4: var size = 'admin_physical_sxxl'; break;
					}
					$('#' + size).val(item);
				});
            } else if (sizeMode == '2') {
                $('#admin_physical_sprepack1221').val(stocks);
            } else if (sizeMode == '3') {
                var stocksArray = stocks.split(',');
				stocksArray.forEach(function(item, index){
					switch (index) {
						case 0: var size = 'admin_physical_ssm'; break;
						case 1: var size = 'admin_physical_sml'; break;
					}
					$('#' + size).val(item);
				});
            } else if (sizeMode == '4') {
                $('#admin_physical_sonesizefitsall').val(stocks);
			}
		});

		//refresing date of datepicker
		$('.publish_date').click(function(){
			$('#publish_date').datepicker('setDate', $('input[name="publish_date"').data('initial_value'));
		});
		$('.color_date').click(function(){
			var stock_date_id = $(this).data('stock_date_id');
			$('#color_date').datepicker('setDate', $(stock_date_id).data('initial_value'));
		});

		// on change of designer dropdown
		$('select[name="designer"]').change(function(){
			$('input[name="designer_slug"]').val($(this).find(':selected').data('url_structure'));
		});

		// on click of categories checkboxes
		$('input[name="categories[]"]').on('change', function(){
			var category_level = $(this).data('category_level');
			var checked = $(this).is(":checked");
			// get closets parent to follow suit on check status
			var parent_li = $(this).closest('ul').parent().children('label').children('input[name="categories[]"]');
			if (typeof parent_li !== "undefined") {
				if (checked) parent_li.prop('checked', true);
				if (parent_li.data('category_level') > 0) {
					var parent_li_li = parent_li.closest('ul').parent().children('label').children('input[name="categories[]"]');
					if (typeof parent_li_li !== "undefined") {
						if (checked) parent_li_li.prop('checked', true);
						if (parent_li_li.data('category_level') > 0) {
							var parent_li_li_li = parent_li_li.closest('ul').parent().children('label').children('input[name="categories[]"]');
							if (typeof parent_li_li_li !== "undefined") {
								if (checked) parent_li_li_li.prop('checked', true);
								if (parent_li_li_li.data('category_level') > 0) {
									var parent_li_li_li_li = parent_li_li_li.closest('ul').parent().children('label').children('input[name="categories[]"]');
								}
							}
						}
					}
				}
			}
			// get children and follow suit of parent check status
			var children_li = $(this).closest('li').children('ul').find('input[name="categories[]"]');
			if (typeof children_li !== "undefined") {
				var counter = 1;
				$(children_li).each(function(){
					if (!checked) {
						if ($(this).is(":checked") && counter == 1) {
							alert('NOTE:'+'\n'+'Children category(s) will also be unchecked.')
							counter++;
						}
						$(this).prop('checked', false);
					}
				});
			}
			// collate all checked inputs
			var input_categories = $(this).closest('div.category_treelist.scroller').find('input[name="categories[]"]');
			if (typeof input_categories !== "undefined") {
				$('input[name="categories"]').val('');
				$('input[name="category_slugs"]').val('');
				var cats = '';
				var cat_slugs = '';
				var cat_crumbs = '';
				var iii = 1;
				$(input_categories).each(function(){
					if ($(this).is(':checked')) {
						if (iii == 1) {
							cats = $(this).val();
							cat_slugs = $(this).data('category_slug');
							cat_crumbs = $(this).data('category_name');
						} else {
							cats = cats + ',' + $(this).val();
							cat_slugs = cat_slugs + ',' + $(this).data('category_slug');
							cat_crumbs = cat_crumbs + '&nbsp; &raquo; &nbsp;' + $(this).data('category_name');
						}
					}
					iii++;
				});
				$('input[name="categories"]').val(cats);
				$('input[name="category_slugs"]').val(cat_slugs);
				$('.cat_crumbs').html(cat_crumbs);
			}
		});

		var primarColorNotice = 'This item is Primary Color!' + '\n' + 'As Primary Color, you can edit these options through the MAIN Publish options box at the top right.'

		// Publish radio button changes per variant
		$('.new_color_publish input[type="radio"]').click(function(){
			// let get necessary information
			var primary_color = $(this).closest('.section-options').data('primary_color');
            var main_publish = $('[name="publish"]').val();
			var st_id = $(this).closest('.section-options').data('st_id');
			var color_code = $(this).closest('.section-options').data('color_code');
			var base_url = $(this).closest('.section-options').data('base_url');
			var dataObject = $(this).closest('.section-options').data('object_data');
			// if primary_color, we don't change publish options
			if (primary_color) {
				alert(primarColorNotice);
				return false;
			}
			// get publish change value
			var publish = $('input[name="new_color_publish[' + st_id + ']"]:checked').val();
            // if main product option publish is unpublish, or, private - must not update
            if (main_publish == '0' && publish == '1')
            {
                alert('Cannot publish this color because main publish option is not "Publish Public".');
                return false;
            }
			// get publish at hub/sat data
			if ($('#new_color_publish_at_hub-' + color_code).is(":checked")) var ncph = 1;
			else var ncph = 0;
			if ($('#new_color_publish_at_satellite-' + color_code).is(":checked")) var ncps = 1;
			else var ncps = 0;
			// we need to get the hub/sat publish data for the variant
			// and set ncp
			var ncp;
			if (ncph == 1 && ncps == 0) ncp = 11;
			if (ncph == 0 && ncps == 1) ncp = 12;
			// chances that both are unchecked is slim
			// but for check purposes, we check both if both is unchecked
			if (ncph == 0 && ncps == 0) {
				$('#new_color_publish_at_hub-' + color_code).prop("checked", true);
				$('#new_color_publish_at_satellite-' + color_code).prop("checked", true);
				ncp = 1;
			}
			// enable publish at hub/sat checkboxes
			$('#new_color_publish_at_hub-' + color_code).parent('label').removeClass('mt-checkbox-disabled');
			$('#new_color_publish_at_satellite-' + color_code).parent('label').removeClass('mt-checkbox-disabled');
			// finally, set new_color_publish
			if (publish == 0) {
				var ncp = 0;
				// disable publish at hub/sat checkboxes
				$('#new_color_publish_at_hub-' + color_code).parent('label').addClass('mt-checkbox-disabled');
				$('#new_color_publish_at_satellite-' + color_code).parent('label').addClass('mt-checkbox-disabled');
			}
			// update data to server
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
			dataObject.new_color_publish = ncp;
			$.ajax({
				type:    "POST",
				url:     base_url + "admin/products/update_variant_options/",
				data:    dataObject,
				success: function(data) {
					//alert(data);
					$('#loading').modal('hide');
					//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
				},
				// vvv---- This is the new bit
				error:   function(jqXHR, textStatus, errorThrown) {
					//$('#loading').modal('hide');
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					$('#reloading').modal('show');
					location.reload();
				}
			});
		});

		// Public/Private view radio function per variant
		$('.color_publish input[type="radio"]').click(function(){
			// let get necessary information
			var primary_color = $(this).closest('.section-options').data('primary_color');
            var main_publish = $('[name="publish"]').val();
			var st_id = $(this).closest('.section-options').data('st_id');
			var base_url = $(this).closest('.section-options').data('base_url');
			var dataObject = $(this).closest('.section-options').data('object_data');
			// if primary_color, we don't change publish options
			if (primary_color) {
				alert(primarColorNotice);
				return false;
			}
			// get public/private view value
			var view = $('input[name="color_publish[' + st_id + ']"]:checked').val();
            // if main product option publish is unpublish, or, private - must not update
            if ((main_publish == '0' || main_publish == '2') && view == '1')
            {
                alert('Cannot set this color to PUBLIC'+'\n'+'because main publish option is not "Publish Public".');
                return false;
            }
			if (view == 0) var cp = 'N';
			else var cp = 'Y';
			// update data to server
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
			dataObject.color_publish = cp;
			$.ajax({
				type:    "POST",
				url:     base_url + "admin/products/update_variant_options/",
				data:    dataObject,
				success: function(data) {
					//alert(data);
					$('#loading').modal('hide');
					//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
				},
				// vvv---- This is the new bit
				error:   function(jqXHR, textStatus, errorThrown) {
					//$('#loading').modal('hide');
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					$('#reloading').modal('show');
					location.reload();
				}
			});
		});

		// Checkboxes Publish at Hub or Satellite per variant
		$('.new_color_publish_at').change(function(){
			if ($(this).parent('label').hasClass('mt-checkbox-disabled')) {
				$(this).prop('checked', !$(this).prop('checked'));
				return false;
			}
			// let get necessary information
			var primary_color = $(this).closest('.section-options').data('primary_color');
			var st_id = $(this).closest('.section-options').data('st_id');
			var color_code = $(this).closest('.section-options').data('color_code');
			var base_url = $(this).closest('.section-options').data('base_url');
			var dataObject = $(this).closest('.section-options').data('object_data');
			// if primary_color, we don't change publish options
			if (primary_color) {
				alert(primarColorNotice);
				$(this).prop('checked', !$(this).prop('checked'));
				return false;
			}
			// start processes
			var ncph, ncps;
			if ($('#new_color_publish_at_hub-'+color_code).is(":checked")) ncph = 1;
			else ncph = 0;
			if ($('#new_color_publish_at_satellite-'+color_code).is(":checked")) ncps = 1;
			else ncps = 0;
			// let us ensure that no two checkboxes is unchecked
			if (ncph == 0 && ncps == 0) {
				alert('You must at least publish color item at one location');
				$(this).prop('checked', true);
				return false;
			}
			if (ncph == 1 && ncps == 0) ncp = '11';
			if (ncph == 0 && ncps == 1) ncp = '12';
			if (ncph == 1 && ncps == 1) ncp = '1';
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
			dataObject.new_color_publish = ncp;
			$.ajax({
				type:    "POST",
				url:     base_url + "admin/products/update_variant_options/",
				data:    dataObject,
				success: function(data) {
					//alert(data);
					$('#loading').modal('hide');
					//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
				},
				// vvv---- This is the new bit
				error:   function(jqXHR, textStatus, errorThrown) {
					//$('#loading').modal('hide');
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					$('#reloading').modal('show');
					location.reload();
				}
			});
		});

		// Checkbox Custom Order per variant
		$('.custom_order').change(function(){
			// let get necessary information
			var primary_color = $(this).closest('.section-options').data('primary_color');
			var color_code = $(this).closest('.section-options').data('color_code');
			var base_url = $(this).closest('.section-options').data('base_url');
			var dataObject = $(this).closest('.section-options').data('object_data');
			// if primary_color, we don't change publish options
			if (primary_color) {
				alert(primarColorNotice);
				$(this).prop('checked', !$(this).prop('checked'));
				return false;
			}
			// start processes
			if ($(this).is(":checked")) var co = 3;
			else var co = 0;
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
			dataObject.custom_order = co;
			$.ajax({
				type:    "POST",
				url:     base_url + "admin/products/update_variant_options/",
				data:    dataObject,
				success: function(data) {
					//alert(data);
					$('#loading').modal('hide');
					//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
				},
				// vvv---- This is the new bit
				error:   function(jqXHR, textStatus, errorThrown) {
					//$('#loading').modal('hide');
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					$('#reloading').modal('show');
					location.reload();
				}
			});
		});

        // Checkbox Clearance Consumer Only per variant
        $('.clearance_consumer_only').on('change', function(){
            // let get necessary information
			var primary_color = $(this).closest('.section-options').data('primary_color');
			var color_code = $(this).closest('.section-options').data('color_code');
			var base_url = $(this).closest('.section-options').data('base_url');
			var dataObject = $(this).closest('.section-options').data('object_data');
			// process data
			if ($(this).is(":checked")) dataObject.options = {"clearance_consumer_only":"1"};
			else dataObject.options = {"clearance_consumer_only":"0"};
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
            $.ajax({
				type:    "POST",
				url:     base_url + "admin/products/update_variant_options.html",
				data:    dataObject,
				success: function(data) {
					//alert(data);
					$('#loading').modal('hide');
					//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
				},
				// vvv---- This is the new bit
				error:   function(jqXHR, textStatus, errorThrown) {
					//$('#loading').modal('hide');
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					$('#reloading').modal('show');
					location.reload();
				}
			});
        });

        // Checkbox Admin Stock Sale per variant
        $('.admin_stocks_only').on('change', function(){
            // let get necessary information
			var primary_color = $(this).closest('.section-options').data('primary_color');
			var color_code = $(this).closest('.section-options').data('color_code');
			var base_url = $(this).closest('.section-options').data('base_url');
            // the object data holds the st_id post data
			var dataObject = $(this).closest('.section-options').data('object_data');
			// process data
			if ($(this).is(":checked")) dataObject.options = {"admin_stocks_only":"1"};
			else dataObject.options = {"admin_stocks_only":"0"};
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
            $.ajax({
				type:    "POST",
				url:     base_url + "admin/products/update_variant_options.html",
				data:    dataObject,
				success: function(data) {
					//alert(data);
					$('#loading').modal('hide');
					//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
				},
				// vvv---- This is the new bit
				error:   function(jqXHR, textStatus, errorThrown) {
					//$('#loading').modal('hide');
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					$('#reloading').modal('show');
					location.reload();
				}
			});
        });

		// color facets checkboxes
		$('input.color_facets').on('click', function(){
			// let get pertinent data
			var color_code = $(this).closest('.section-colors-facet').data('color_code');
			var base_url = $(this).closest('.section-colors-facet').data('base_url');
			var st_id = $(this).closest('.section-options').data('st_id');
			var dataObject = $(this).closest('.section-colors-facet').data('object_data');
			// collate all checked inputs
			//var siblings = $(this).closest('div').find('input[name="color_facets['+st_id+'][]"]');
			var siblings = $(this).closest('div').find('input.color_facets');
			if (typeof siblings !== "undefined") {
				var colorFacets = '';
				var iiii = 1;
				$(siblings).each(function(){
					if ($(this).is(':checked')) {
						if (iiii == 1) {
							colorFacets = $(this).val();
							iiii++;
						} else {
							colorFacets = colorFacets + '-' + $(this).val();
						}
					}
				});
			}
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
			dataObject.color_facets = colorFacets.toUpperCase();
			$.ajax({
				type:    "POST",
				url:     base_url + "admin/products/update_variant_options/",
				data:    dataObject,
				success: function(data) {
					//alert(data);
					$('#loading').modal('hide');
					//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
				},
				// vvv---- This is the new bit
				error:   function(jqXHR, textStatus, errorThrown) {
					//$('#loading').modal('hide');
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					$('#reloading').modal('show');
					location.reload();
				}
			});
		});

		// facets checkboxes
		$('input.facets').on('click', function(){
			// let get pertinent data
			var base_url = $(this).closest('div.form-body').data('base_url');
			var dataObject = $(this).closest('div.form-body').data('object_data');
			var facet_type = $(this).closest('div').data('facet_type');
			// collate all checked inputs
			var siblings = $(this).closest('div').find('input.facets');
			if (typeof siblings !== "undefined") {
				var facets = '';
				var iiii = 1;
				$(siblings).each(function(){
					if ($(this).is(':checked')) {
						if (iiii == 1) {
							facets = $(this).val();
							iiii++;
						} else {
							facets = facets + '-' + $(this).val();
						}
					}
				});
			}
			$('#loading .modal-title').html('Updating...');
			$('#loading').modal('show');
			// check the facet type
			switch (facet_type) {
				case 'events':
					dataObject.events = facets.toUpperCase();
				break;
				case 'styles':
					dataObject.styles = facets.toUpperCase();
				break;
				case 'trends':
					dataObject.trends = facets.toUpperCase();
				break;
				case 'materials':
					dataObject.materials = facets.toUpperCase();
				break;
                case 'seasons':
					dataObject.seasons = facets.toUpperCase();
				break;
			}
			$.ajax({
				type:    "POST",
				url:     base_url + "admin/products/update_variant_options/facets.html",
				data:    dataObject,
				success: function(data) {
					//alert(data);
					$('#loading').modal('hide');
					//window.location.href=base_url + "admin/products/edit/index/" + prod_id;
				},
				// vvv---- This is the new bit
				error:   function(jqXHR, textStatus, errorThrown) {
					$('#loading').modal('hide');
					//alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
					$('#reloading .modal-body-text').html('Ooops... something went wrong. - ' + errorThrown);
					$('#reloading').modal('show');
					location.reload();
				}
			});
		});

		// on change of vendor dropdown
		$('select[name="vendor_id"]').change(function(){
			var vendor_code = $(this).find(':selected').data('vendor_code');
			$('input[name="vendor_code"]').val(vendor_code);
		});

		// float update button at lower right corner of screen
		$(document).scroll(function() {
			var y = $(this).scrollTop();
			if (y > 600) {
				$('.floatbar').fadeIn();
			} else {
				$('.floatbar').fadeOut();
			}
		});
	}

    var handlePulsate = function () {
        if (!jQuery().pulsate) {
            return;
        }

        if (App.isIE8() == true) {
            return; // pulsate plugin does not support IE8 and below
        }

        if (jQuery().pulsate) {
            jQuery('.pulsate-regular').pulsate({
                color: "#bf1c56"
            });

            jQuery('.pulsate-once').click(function () {
                $('.pulsate-once-target').pulsate({
                    color: "#399bc3",
                    repeat: false
                });
            });

            jQuery('.pulsate-crazy').click(function () {
                $('.pulsate-crazy-target').pulsate({
                    color: "#fdbe41",
                    reach: 50,
                    repeat: 10,
                    speed: 100,
                    glow: true
                });
            });
        }
    }

	// let us now expose above private functions of ComponentsProductEdit
    return {
        //main function to initiate the module
        init: function () {
            handleDatePickers();
			scriptFunctions();
			handlePulsate();
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        ComponentsProductEdit.init();
    });
}
