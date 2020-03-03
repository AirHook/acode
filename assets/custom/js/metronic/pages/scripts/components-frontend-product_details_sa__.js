var ComponentsScripts = function() {

    var handleScripts1 = function() {

		/**********
		 * tagsinput
		 */
        $('input.facets[type="checkbox"]').on('click', function(){
			// get tag name
			var tag_name = $(this).data('tag_name');
			var eltag = $(this).closest('div').find('input[name="'+tag_name+'[]"]');
			if (typeof eltag !== "undefined") {
				// reset corresponding input val to ''
				$('input[name="'+tag_name+'"]').val('');
				// go through each input array []
				var tagVal = '';
				var ctr = 1; // counter
				$(eltag).each(function(){
					if ($(this).is(':checked')) {
						if (ctr == 1) {
							tagVal = $(this).val();
						} else {
							tagVal = tagVal + ',' + $(this).val();
						}
						ctr++;
					}
				});
				// then set new value to input val
				$('input[name="'+tag_name+'"]').val(tagVal);
			}
        });

        $('input.facets[name="availability1"]').on('click', function(){
			$('input[name="availability"]').val($(this).val());
        });

		// submit tags input upon clear of a filter item
		$('input.facet-tagsinput').on('itemRemoved', function(event) {
			// event.item: contains the item
			$('#form_facet-tagsinput').submit();
		});

		// desktop - submit sort by drop down on change
		$('.bs-select.select-sort_by').on('change', function(){
			$('#form-select-sort_by').submit();
		});

		// mobile clear filter
		$('.mobile-clear-filter').on('click', function(){
			var facet_type = $(this).data('facet_type');
			$('.'+facet_type+'_facets').attr('checked','checked');
			$('.'+facet_type+'_facets').removeAttr('checked');
			$('input[name="'+facet_type+'"]').val('');
			$(this).html('Click Apply to effect change');
			$(this).css('text-decoration', 'none');
		});

        // sa package add to inquiry button click function
        $('.size-qty-submit-wholesale').on('click', function(){
            var el = $(this).closest('.add-to-cart-form');
            var form = el.children('.frmCart');
            form.submit();
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            handleScripts1();
        }
    };

}();

jQuery(document).ready(function() {
    ComponentsScripts.init();
});
