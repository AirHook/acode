var ComponentsEditors = function () {

    var base_url = $('body').data('base_url');

    var handleScripts = function () {

		// submit form
		$('.csv_stocks_update').on('click', function(){

			if ($("#file").val() == '') {
		        // your error validation action
				alert('Please select a file to upload');
				return false;
		    }

			//alert('submit form');
			$('#form-csv_stocks_update').submit();
		});
    }

    return {
        //main function to initiate the module
        init: function () {
            handleScripts();
        }
    };

}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
});
