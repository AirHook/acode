var ComponentsScripts = function() {

    var base_url = $('body').data('base_url');
    var object_data = $('.mobile-filter-sort-buttons').data('object_data');

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

        // mobile thumbs filter actions
		$('#size-filter-desktop-top, #style-filter-desktop-top, #price-filter-desktop-top, #color-filter-desktop-top, #occassion-filter-desktop-top, #season-filter-desktop-top, #availability-filter-desktop-top, #size-filter-desktop-bottom, #style-filter-desktop-bottom, #price-filter-desktop-bottom, #color-filter-desktop-bottom, #occassion-filter-desktop-bottom, #season-filter-desktop-bottom, #availability-filter-desktop-bottom, #size-filter-mobile-top, #style-filter-mobile-top, #price-filter-mobile-top, #color-filter-mobile-top, #occassion-filter-mobile-top, #season-filter-mobile-top, #availability-filter-mobile-top, #size-filter-mobile-bottom, #style-filter-mobile-bottom, #price-filter-mobile-bottom, #color-filter-mobile-bottom, #occassion-filter-mobile-bottom, #season-filter-mobile-bottom, #availability-filter-mobile-bottom').change(function(){
            // set parent element
            var form = $(this).parents('form');
            var desc = form.data('desc');
            // set this filter value
            var val = $(this).val();
            if (val == 'onsale' &&  base_url == 'https://www.basixblacklabel.net/') {
                window.location.href = "https://www.shop7thavenue.com/shop/basixblacklabel/womens_apparel.html?filter=&availability=onsale";
                return false;
            }
            if (val != 'all' && val != 'default') {
                // set the items value to the input for submission
                form.children('.this-filter').val(val);
            } else {
                // remove input item so as not to show as empty uri query string
                form.children('.this-filter').remove();
            }
            // submit closest form
            var dataString = form.serialize();
            //alert(dataString);
			form.submit();
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
