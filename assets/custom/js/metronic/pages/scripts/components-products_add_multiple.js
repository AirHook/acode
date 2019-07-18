var ComponentsProductAdd = function () {

    var scriptFunctions = function () {
		
		// on change of designer dropdown
		$('select[name="designer"]').change(function(){
			$('select[name="subcat_id"]').find('.all-options').hide();
			$('select[name="subcat_id"]').val('');
			$('input[name="subcat_slug"]').val('');
			var selected_designer = $(this).val();
			if (selected_designer == '') $('select[name="subcat_id"]').find('.all-options').show();
			else {
				$('select[name="subcat_id"]').find('.' + selected_designer).show();
			}
			$('select[name="subcat_id"]').selectpicker('refresh');
			$('input[name="designer_slug"]').val($(this).find(':selected').data('url_structure'));
		});
		
		// on change of category dropdown
		$('select[name="subcat_id"]').change(function(){
			$('input[name="subcat_slug"]').val($(this).find(':selected').data('subcat_slug'));
		});
	}
	
	// let us now expose above private functions of ComponentsProductEdit
    return {
        //main function to initiate the module
        init: function () {
			scriptFunctions();
        }
    };

}();

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {    
        ComponentsProductAdd.init(); 
    });
}