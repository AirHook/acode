var GlobalComponentsScripts = function() {

    var GlobalhandleScripts1 = function() {
		
		// mobile header search box toggler
        $(".search-toggler").click(function(){
			$('.mobile-search').toggle();
			$('.top-default').toggle();
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            GlobalhandleScripts1();
        }
    };

}();

jQuery(document).ready(function() {
    GlobalComponentsScripts.init();
});