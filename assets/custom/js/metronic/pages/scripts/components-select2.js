var ComponentsSelect2 = function() {

    var handleDemo = function() {

        // Set the "bootstrap" theme as the default theme for all Select2
        // widgets.
        //
        // @see https://github.com/select2/select2/issues/2927
        $.fn.select2.defaults.set("theme", "bootstrap");

		// this code below applies to general select2 drop downs
		// commenting this to pave way to custom items
		/*
        var placeholder = "Select a State";

        $(".select2, .select2-multiple").select2({
            placeholder: placeholder,
            width: null
        });

        $(".select2-allow-clear").select2({
            allowClear: true,
            placeholder: placeholder,
            width: null
        });
		*/
		
		/**
		 * Initialize custom items here
		 */
        $(".select2.select-state").select2({
            placeholder: "Select a State",
            width: null
        });
        $(".select2.select-country").select2({
            placeholder: "Select a Country",
            width: null
        });

    }

    return {
        //main function to initiate the module
        init: function() {
            handleDemo();
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        ComponentsSelect2.init();
    });
}