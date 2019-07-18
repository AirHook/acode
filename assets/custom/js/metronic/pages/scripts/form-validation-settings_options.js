var FormValidation = function () {

    var scriptFunctions = function () {
		
		// site type drop down actions
		$('#site_type').change(function(){
			if ($('#site_type').selectpicker('val') == 'sat_site')
				$('#hub_site_list').show();
			else $('#hub_site_list').hide();
		});
		
	}
	
    return {
        //main function to initiate the module
        init: function () {

			scriptFunctions();

        }

    };

}();

jQuery(document).ready(function() {
    FormValidation.init();
});