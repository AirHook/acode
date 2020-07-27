var ProductDetailsComponentsScripts = function() {

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
            // get some data attributes
            var size = $(this).data('dsize');
            var size_key = $(this).data('size_key');
            //var available_qty = Number($(this).data('available_qty'));
            // toggle bg shade on size box
            $(this).toggleClass('a-bg-color');
            if ($(this).hasClass('a-bg-color')){
                // set input value
                $('input[name="size['+size_key+']"]').val(size);
                // remove zero value of respective qty select dropdown
                $('select[name="qty['+size_key+']"] option.opt_zeroval').remove();
                $('select[name="qty['+size_key+']"]').selectpicker('refresh');
            }else{
                // unset input value
                $('input[name="size['+size_key+']"]').val('');
                // repoppulate respective qty select dropdown
                $('select[name="qty['+size_key+']"]').children('option').remove();
                for(i = 0;i <= 30;i++){
                    $('select[name="qty['+size_key+']"]').append('<option class="'+(i==0?'opt_zeroval':'opt_val')+'" value="'+i+'">'+i+'</option>');
                }
                $('select[name="qty['+size_key+']"]').selectpicker('refresh');
            }
        });

        $('.product_details-qty_box').on('change', function(){
            // get some data attributes
            var size = $(this).data('dsize');
            var size_key = $(this).data('size_key');
            if ($(this).val() != '0'){
                // toggle bg shade on size box
                $('a[data-size_key="'+size_key+'"]').addClass('a-bg-color');
                // set input value
                $('input[name="size['+size_key+']"]').val(size);
            }else{
                // toggle bg shade on size box
                $('a[data-size_key="'+size_key+'"]').removeClass('a-bg-color');
                // unset input value
                $('input[name="size['+size_key+']"]').val('');
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
                    return false;
                }
            })
            if (has_value == true) return true;
            else {
                alert('Please select at least 1 size...');
                return false;
            }
        });

        // let's capture the modal form's submit
        $('#form-about_product').submit(function(e){
            var name = $('[name="name"]').val();
            if (name == '') {
                alert('Please put your NAME on the form.');
                return false;
            }
            var dress_size = $('[name="dress_size"]').val();
            if (dress_size == '') {
                alert('Please put your DRESS SIZE on the form.');
                return false;
            }
            var email = $('[name="email"]').val();
            if (email == '') {
                alert('Please put your EMAIL on the form.');
                return false;
            }
            var opt_type = $('[name="opt_type"]:checked').val();
            if (opt_type == undefined || opt_type == '') {
                alert('Please select if your are a STORE or a CONSUMER.');
                return false;
            }
            var u_type = $('[name="u_type"]:checked').val();
            if (u_type == undefined || u_type == '') {
                alert('Please select if your are a STORE or a CONSUMER.');
                return false;
            }
            // stop form submit action
    		//e.preventDefault();
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
