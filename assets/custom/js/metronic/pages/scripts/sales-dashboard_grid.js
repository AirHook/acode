(function($, window, document, undefined) {
    'use strict';

    // init cubeportfolio
    $('#js-grid-lightbox-gallery').cubeportfolio({
        //filters: '#js-filters-lightbox-gallery1, #js-filters-lightbox-gallery2',
        //loadMore: '#js-loadMore-lightbox-gallery',
        //loadMoreAction: 'click',
        layoutMode: 'grid',
        mediaQueries: [{
            width: 1500,
            cols: 5
        }, {
            width: 1100,
            cols: 4
        }, {
            width: 800,
            cols: 3
        }, {
            width: 480,
            cols: 2
        }, {
            width: 320,
            cols: 1
        }],
        defaultFilter: '*',
        animationType: 'rotateSides',
        gapHorizontal: 30,
        gapVertical: 10,
        gridAdjustment: 'responsive',
        caption: 'zoom',
        displayType: 'sequentially',
        displayTypeSpeed: 100,

        // lightbox
		/*
        lightboxDelegate: '.cbp-lightbox',
        lightboxGallery: true,
        lightboxTitleSrc: 'data-title',
        lightboxCounter: '<div class="cbp-popup-lightbox-counter">{{current}} of {{total}}</div>',

        // singlePageInline
        singlePageInlineDelegate: '.cbp-singlePageInline',
        singlePageInlinePosition: 'below',
        singlePageInlineInFocus: true,
        singlePageInlineCallback: function(url, element) {
            // to update singlePageInline content use the following method: this.updateSinglePageInline(yourContent)
            var t = this;

            $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'html',
                    timeout: 10000
                })
                .done(function(result) {

                    t.updateSinglePageInline(result);

                })
                .fail(function() {
                    t.updateSinglePageInline('AJAX Error! Please refresh the page!');
                });
        },*/
    });

    var base_url = $('body').data('base_url');

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
        if (step == 3 && items_steps >= 2) {
            window.location.href=dataLink;
        }
    })

    // clear all items button action
    $('.confirm-clear_all_items').click(function(){
        $('#modal-clear_all_items').modal('hide');
        $('#loading .modal-title').html('Clearing...');
        $('#loading').modal('show');
        // call the url using get method
        $.get(base_url + "sales/sales_package/clear_all_items.html")
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

})(jQuery, window, document);
