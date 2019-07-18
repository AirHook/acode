var ComponentsTypeahead = function () {

	var base_url = $('body').data('base_url');
	//var base_url = window.location.origin;

    var handleTwitterTypeahead = function() {

		// return a reference to bloodhound to avoid naming collisions
		//var Dachshund = Bloodhound.noConflict();
		// instantiate the bloodhound suggestion engine
		var custom = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.whitespace,
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			remote: {
				url: base_url + 'search/suggestions/index/%QUERY',
				wildcard: '%QUERY'
			}
		});
		// initialize the bloodhound suggestion engine
		//custom.initialize();
		// instantiate the typeahead UI
		//if (App.isRTL()) {
		//	$('#search_by_style').attr("dir", "rtl");  
		//}
		$('#search_by_style, .search_by_style').typeahead({
			hint: false,
			highlight: true
		},
		{
			name: 'search_by_style',
			source: custom,
			limit: 20
		});
    }

    return {
        //main function to initiate the module
        init: function () {
            handleTwitterTypeahead();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsTypeahead.init();
});
