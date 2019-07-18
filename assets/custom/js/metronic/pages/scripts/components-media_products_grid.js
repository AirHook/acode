var ComponentScripts = function () {

	var base_url = $('body').data('base_url');
	//var base_url = window.location.origin; // not good to use on localhost base_url
	
	// set modal height
	$('#modal-product_media_properties').on('show.bs.modal', function () {
		//$('.modal .modal-body').css('overflow-y', 'auto'); 
		$('.modal .modal-body').css('height', $(window).height() * 0.76);
	});

    var initScripts = function () {

		// thumbs click function
		$('.modal-product_media_properties').click(function(){
			// clear data div
			//$('#data-info').html('');
			// get data values
			var media_id = $(this).data('media_id');
			var media_name = $(this).data('media_name');
			var media_path = $(this).data('media_path');
			var media_dimensions = $(this).data('media_dimensions');
			var media_timestamp = $(this).data('media_timestamp');
			var media_view = $(this).data('media_view');
			var media_filename = $(this).data('media_filename');
			var upload_version = $(this).data('upload_version');
			var prod_id = $(this).data('prod_id');
			var attached_to = base_url + 'admin/products/edit/index/' + prod_id + '.html';
			var file_location = base_url + media_path + media_filename;
			var main_view = base_url + media_path + media_name + '_' + media_view + '.jpg';
			var thumb_view = base_url + media_path + media_name + '_' + media_filename.replace('.jpg', '_thumb.jpg');
			// append to div
			$('#media_filename').html(media_filename);
			$('#media_timestamp').html(media_timestamp);
			$('#media_dimensions').html(media_dimensions);
			$('#media_location').html(file_location);
			$('#main_view').val(main_view);
			var media_del_link;
			if (prod_id) {
				$('#attached_to').html(attached_to);
				$('#attached_to').attr('href', attached_to);
				media_del_link = base_url + 'admin/media_library/products/delete/index/' + media_id + '/attached.html';
			} else {
				$('#attached_to').html('UNATTACHED');
				$('#attached_to').attr('href', 'javascript:;');
				$('#attached_to').attr('target', '');
				media_del_link = base_url + 'admin/media_library/products/delete/index/' + media_id + '.html';
			}
			$('#img-src').attr('src', file_location);
			$('.delete-media-modal').attr('href', media_del_link);
			/*
			$('#data-info').append(
				'<p>'+media_path+'</p><p>'
				+media_name+'</p><p>'
				+media_view+'</p><p>'
				+media_filename+'</p><p>'
				+upload_version+'</p>'
			);
			*/
			// show modal
			$('#modal-product_media_properties').modal('show');
		});

    }

    return {

        //main function to initiate the module
        init: function () {

			initScripts();
        }

    };

}();

if (App.isAngularJsApp() === false) { 
    jQuery(document).ready(function() {
        ComponentScripts.init();
   });
}