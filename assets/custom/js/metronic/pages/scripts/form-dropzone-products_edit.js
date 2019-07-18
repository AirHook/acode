var FormDropzone = function () {


    return {
        //main function to initiate the module
        init: function () {  

            Dropzone.options.myDropzoneFront = {
                dictDefaultMessage: "Drop files here to upload",
                init: function() {
                    this.on("addedfile", function(file) {
						$('.cancel-upload-image-modal-btn').hide();
                    });
                }            
            }
            Dropzone.options.myDropzoneSide = {
                dictDefaultMessage: "Drop files here to upload - side",
                init: function() {
                    this.on("addedfile", function(file) {
						$('.cancel-upload-image-modal-btn').hide();
                    });
                }            
            }
            Dropzone.options.myDropzoneBack = {
                dictDefaultMessage: "Drop files here to upload - back",
                init: function() {
                    this.on("addedfile", function(file) {
						$('.cancel-upload-image-modal-btn').hide();
                    });
                }            
            }
        }
    };
}();

jQuery(document).ready(function() {    
   FormDropzone.init();
});