var ComponentsEditors = function () {

    var base_url = $('body').data('base_url');
    var object_data = $('body').data('object_data');

    var handleScripts = function () {

		// project <li> as link
		$('.todo-projects-item.todo-link').on('click', function(){
            window.location.href=$(this).data('href');
		});

        // assigning user to new task
        $('.todo-members-modal-submit').on('click', function(){
            var name = $('#select2_sample2 option:selected').text();
            var value = $('#select2_sample2 option:selected').val();
            if (value) {
                $('.todo-task-assign').html(name);
                $('[name="user_id"]').val(value);
                $('#todo-members-modal').modal('hide');
            } else {
                alert('Pleae select a member.');
                return false;
            }
        });

        // datepicker select
        $('.date-picker.todo-task-due').on('change', function(){
            $('[name="due_date"]').val($(this).val());
        });

        // get the title
        $('.todo-task-title').on('blur', function(){
            $('[name="title"]').val($(this).val());
        });

        // get the description
        $('.todo-task-description').on('blur', function(){
            $('[name="description"]').text($(this).val());
        });

        // correspondence
        $('#form-send_correspondence').on('submit', function(e){
            // prevent form submit...
            e.preventDefault();
            // process data
            var task_id = $('input[name="task_id"]').val();
            var user_id = $('select[name="user_id"]').val();
            if (!user_id) {
                alert('select a user');
                return;
            }
            var message = $('input[name="message"]').val();
            if (!message) {
                alert('what is your message?');
                return;
            }
            var formData = object_data;
            formData.task_id = task_id;
            formData.user_id = user_id;
            formData.message = message;
            // submit form
            var send_correspondence = $.ajax({
                type:       "POST",
                url:        base_url + "admin/task_manager/chats_add/aja_x/" + task_id + ".html",
                data:       formData,
                dataType:   'json'
            });
            send_correspondence.done(function(data){
                if (data.status='success'){
                    var recentChat = '<li class="in"><div class="message" style="margin-left:0px;"><a href="javascript:;" class="name">' + data.name + ' </a><span class="datetime"> at ' + data.date + ' </span><span class="body"> ' + data.message + ' </span></div></li>';
                    $('.chats').append(recentChat);
                    $('[name="user_id"]').val(user_id);
                    $('[name="message"]').val('');
                }else{
                    alert(JSON.stringify(data));
                }
            });
            send_correspondence.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Preset Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        });
    }

    var handleDatePickers = function () {

        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                orientation: "left",
                autoclose: true,
                todayHighlight: true
                //startDate: '01/01/2000'
            });
            //$('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }

        /* Workaround to restrict daterange past date select: http://stackoverflow.com/questions/11933173/how-to-restrict-the-selectable-date-ranges-in-bootstrap-datepicker */

        // Workaround to fix datepicker position on window scroll
        $( document ).scroll(function(){
            $('#form_modal2 .date-picker').datepicker('place'); //#modal is the id of the modal
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            handleScripts();
            handleDatePickers();
        }
    };

}();

var FormDropzone = function () {

    return {
        //main function to initiate the module
        init: function () {

            var base_url = $('body').data('base_url');

            Dropzone.options.myDropzoneAttach = {
                dictDefaultMessage: "Drag files or click here to upload",
                init: function() {
                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");

                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                          // Make sure the button click doesn't submit the form:
                          e.preventDefault();
                          e.stopPropagation();

                          // Remove the file preview.
                          _this.removeFile(file);
                          // If you want to delete the file on the server as well,
                          // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
                    /*
                    // action on success/error
					this.on("error", function(file){
                        var task_id = $('[name="task_id"]').val();
                        window.location.href=base_url+"admin/task_manager/task_details/index/"+task_id+".html";
					});
                    // Send formData with upload
					this.on('sending', function(file, xhr, formData){

					});
					*/
                }
            }
        }
    };
}();

jQuery(document).ready(function() {
   ComponentsEditors.init();
   FormDropzone.init();
});
