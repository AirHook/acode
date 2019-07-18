var ProductDetailsComponentsScripts = function() {

    var base_url = $('body').data('base_url');

    var ProductDetailshandleScripts1 = function() {

		/**********
		 * TouchSpin
		 * Metronic plugin for input element to change to
		 * a plus and minus sign to spin values up and down
		 * Used for datails page to set qty to order
		 */
        $("#touchspin_5, .touchspin_5").TouchSpin({
            initval: 1,
			max: 30
        });

		/**********
		 * Slick Swiper/Slider
		 * External plugin
		 * Used for swiping of main image view on mobile devices
		 */
		$('.slick-swipe').slick({
			arrows: false,
			dots: true,
			dotsClass: 'slick-dots'
		});

		/**********
		 * Mobile panzoom
		 * External plugin
		 * Used for supposed pan and zoom of images on mobile devices
		 */
		$("#panzoom4").panzoom({
			$zoomIn: $(".zoom-in"),
			$reset: $(".reset"),
			minScale: 1,
			contain: 'invert'
		}).panzoom('zoom');

        $('.product_details-size_box').on('click', function(){
            // get element wrapper
            var el = $(this).closest('.size-qty-row');
            // get some data attributes
            var size = $(this).data('dsize');
            var size_key = $(this).data('size_key');
            //var available_qty = Number($(this).data('available_qty'));
            // toggle bg shade on size box
            $(this).toggleClass('a-bg-color');
            if ($(this).hasClass('a-bg-color')){
                // set input value
                //$('input[name="size['+size_key+']"]').val(size);
                el.find('input[name="size['+size_key+']"]').val(size);
                // remove zero value of respective qty select dropdown
                el.find('select[name="qty['+size_key+']"] option.opt_zeroval').remove();
                el.find('select[name="qty['+size_key+']"]').selectpicker('refresh');
            }else{
                // unset input value
                el.find('input[name="size['+size_key+']"]').val('');
                // repoppulate respective qty select dropdown
                el.find('select[name="qty['+size_key+']"]').children('option').remove();
                for(i = 0;i <= 30;i++){
                    el.find('select[name="qty['+size_key+']"]').append('<option class="'+(i==0?'opt_zeroval':'opt_val')+'" value="'+i+'">'+i+'</option>');
                }
                el.find('select[name="qty['+size_key+']"]').selectpicker('refresh');
            }
        });

        $('.product_details-qty_box').on('change', function(){
            // get element wrapper
            var el = $(this).closest('.size-qty-row');
            // get some data attributes
            var size = $(this).data('dsize');
            var size_key = $(this).data('size_key');
            if (el.find('select[name="qty['+size_key+']"]').val() > 0){
                // toggle bg shade on size box
                el.find('a[data-size_key="'+size_key+'"]').addClass('a-bg-color');
                // set input value
                el.find('input[name="size['+size_key+']"]').val(size);
            }else{
                // toggle bg shade on size box
                el.find('a[data-size_key="'+size_key+'"]').removeClass('a-bg-color');
                // unset input value
                el.find('input[name="size['+size_key+']"]').val('');
            }
        });

        $('.size-qty-submit-wholesale').on('click', function(){
            var has_value = false;
            // check if at least 1 size is selected
            var dform = $(this).parent('form');
            var dsizes = dform.find('.size_key');
            dsizes.each(function(){
                // return true if at least 1 size is selected
                if ($(this).val() != ''){
                    has_value = true;
                    //return false;
                }
            })
            if (has_value == true) {
                // on regular wholesale product details page, return true to submit
                //return true;
                // on package details page, we need to do an ajax submit
                // get notification element
                var el = $(this).closest('.row-product_detail').find('.present-in-cart-notice');
                // get form fields and serialize serializeArray()
                var serialForm = dform.serializeArray();
                var objectData = JSON.parse(JSON.stringify(serialForm));
                $.ajax({
                    type:    "POST",
                    url:     base_url + "cart/add_cart/wholesale.html",
                    data:    objectData,
                    success: function(data) {
                        //alert('Data: '+data);
                        $('.dropdown.shop-cart-toggler').html(data);
                        el.show();
                        //$('#loading').modal('hide');
                        //window.location.href=base_url + "admin/products/edit/index/" + prod_id;
                    },
                    // vvv---- This is the new bit
                    error:   function(jqXHR, textStatus, errorThrown) {
                        //$('#loading').modal('hide');
                        //alert("Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                        $('#loading .modal-title').html('ERROR - Reloading...');
                        $('#loading').modal('show');
                        //$('#reloading').modal('show');
                        location.reload();
                    }
                });

            } else {
                alert('Please select at least 1 size...');
                return false;
            }
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            ProductDetailshandleScripts1();
        }
    };

}();

jQuery(document).ready(function() {
    ProductDetailsComponentsScripts.init();
});
