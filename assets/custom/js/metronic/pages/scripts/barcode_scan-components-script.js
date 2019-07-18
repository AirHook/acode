var ComponentsBarcodeScan = function () {

    var base_url = $('body').data('base_url');

    var handleModalFunctions = function () {

        $('.barcode-code-clear').on('click', functions(){
            //alert('click');
        });

    }

	return {
        //main function to initiate the module
        init: function () {
            handleModalFunctions();
        }
    };

}();

jQuery(document).ready(function() {
	ComponentsBarcodeScan.init();
});
