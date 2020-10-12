var ComponentsEditors = function () {

    var base_url = $('body').data('base_url');
    var object_data = $('body').data('object_data');

    var handleSummernote = function () {
        $('#summernote_1').summernote({
			height: 250,
			toolbar: [
				// [groupName, [list of button]]
				['main', ['style']],
				['style', ['bold', 'italic', 'underline', 'clear']],
				['para', ['ul', 'ol', 'paragraph']],
				['link', ['link']]
			]
		});
    }

    var handleScripts = function () {

        // activate nestable list
        $('.dd').each(function(){
            $(this).nestable({
                maxDepth: 1,
                group: $(this).prop('id')
            }).on('change', function(){

                // put list reordering code here...

                // sample serialize data:
                // before drag...
                // [{"task_id":16},{"task_id":9},{"task_id":11},{"task_id":12}]
                // the object ordering is changed after drag

                // get the csrf tokens
                var objectData = object_data;

                // grab serialized list data
                listSerial = $(this).nestable('serialize');
                objectData.list_json = listSerial;
                //alert(JSON.stringify(listSerial));

                // we need to change the frontend html code dynamically here
                // iterate through serialized data
                // using below 'for' loop to get numberic key of array of object
                // and assign new key (each +1 as keys start with 0) to the list item number in <span> element
                // using serialized object data 'value' and knowing the data involved,
                // find correct <span> element to change item number
                for (let [key, value] of Object.entries(listSerial)) {
                    var seque = parseInt(key) + 1;
                    var el = $('[data-task_id="'+value.task_id+'"]').find('span.t_no');
                    el.html(seque);
                }

                // we need to save the new seque via ajax call here
                /* */
                var edit_seque = $.ajax({
                    type:       "POST",
                    url:        base_url + "admin/task_manager/task_edit/seque.html",
                    data:       objectData
                });
                edit_seque.done(function(data){
                    //alert(data);
                });
                edit_seque.fail(function(jqXHR, textStatus, errorThrown) {
                    //$('#loading').modal('hide');
                    alert("Edit Seque Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                });
                // */
            });
        });
        $('.todo-project-item-foot').on('click', '.nestable-collapse-expand', function (e) {
            var action = $(this).data('action');
            if (action === 'expand') {
                $(this).closest('div.todo-project-item-foot').find('.nestable_list').slideDown('fast');
            }
            if (action === 'collapse') {
                $(this).closest('div.todo-project-item-foot').find('.nestable_list').slideUp('fast');
            }
            $(this).hide();
            $(this).siblings('.nestable-collapse-expand').show();
        });

		// project <li> as link
		$('.todo-projects-item.todo-link').on('click', function(){
            window.location.href=$(this).data('href');
		});

        // project list add task button
        $('.btn-add-task').on('click', function(){
            var project_id = $(this).data('project_id');
            $('[name="project_id"]').val(project_id);
            $('#todo-task-modal').modal('show');
        });

        // assigning user to new task (add task)
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

        // assigning user to new task (task details)
        $('.todo-details-members-modal-submit').on('click', function(){
            var objectData = object_data;
            objectData.task_id = $('[name="task_id"]').val();
            var name = $('#select2_sample2 option:selected').text();
            var value = $('#select2_sample2 option:selected').val();
            if (value) {
                $('.todo-task-assign').html(name);
                $('.todo-task-assign').removeClass('default');
                // update records
                /* */
                var assign_user = $.ajax({
                    type:       "POST",
                    url:        base_url + "admin/task_manager/task_edit/assign/"+value+".html",
                    data:       objectData
                });
                assign_user.done(function(data){
                    //alert(data);
                    if (data =='success') location.reload();
                });
                assign_user.fail(function(jqXHR, textStatus, errorThrown) {
                    //$('#loading').modal('hide');
                    alert("Edit Seque Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                });
                // */
                // hide modal
                $('#todo-members-modal').modal('hide');
            } else {
                alert('Pleae select a member.');
                return false;
            }
        });

        // datepicker select (add task)
        $('.date-picker.todo-task-due').on('change', function(){
            $('[name="due_date"]').val($(this).val());
        });

        // get the title
        $('.todo-task-title').on('blur', function(){
            $('[name="title"]').val($(this).val());
        });

        // get the description
        /*
        $('.todo-task-description').on('blur', function(){
            $('[name="description"]').text($(this).val());
        });
        */

        // datepicker select (task details)
        $('.date-picker.todo-details-task-due').on('change', function(){
            var objectData = object_data;
            objectData.date_end_target = $(this).val();
            objectData.task_id = $('[name="task_id"]').val();
            //alert(JSON.stringify(objectData));
            // update records
            /* */
            var due_date = $.ajax({
                type:       "POST",
                url:        base_url + "admin/task_manager/task_edit/due_date.html",
                data:       objectData
            });
            due_date.done(function(data){
                //alert(data);
                if (data =='success') location.reload();
            });
            due_date.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Edit Seque Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
            // */
        });

        // user accept script
        $('.todo-user-accept-modal-submit').on('click', function(){
            var task_id = $(this).data('task_id');
            var project_id = $(this).data('project_id');
            var name = $('#assign-user-'+task_id+' option:selected').text();
            var value = $('#assign-user-'+task_id+' option:selected').val();
            //alert(base_url + "admin/task_manager/task_edit/accept/" + task_id + "/" + project_id + "/" + value + ".html");
            if (value) {
                var accept_task = $.ajax({
                    type:       "GET",
                    url:        base_url + "admin/task_manager/task_edit/accept/" + task_id + "/" + project_id + "/" + value + ".html"
                });
                accept_task.done(function(data){
                    if (data =='success') location.reload();
                });
                accept_task.fail(function(jqXHR, textStatus, errorThrown) {
                    //$('#loading').modal('hide');
                    alert("Edit Seque Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
                });
            } else {
                alert('Pleae select yourself as accepting the task.');
                return false;
            }
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
                    //alert(JSON.stringify(data));
                }
            });
            send_correspondence.fail(function(jqXHR, textStatus, errorThrown) {
                //$('#loading').modal('hide');
                alert("Get Preset Error, status = " + textStatus + ", " + "error thrown: " + errorThrown);
            });
        });

        // header checkbox change function
        // get the "data-set" attribute and look for each (look for all rows checkboxes)
        // if header checkbos is checked, check row checkboxes and set row as active
        $('#tbl-projects_list').find('.group-checkable').change(function () {
            var set = jQuery(this).attr("data-set");
            var checked = jQuery(this).is(":checked");
            jQuery(set).each(function () {
                if (checked) {
                    $(this).prop("checked", true);
                    $(this).parents('tr').addClass("active");
                    // add other custom javascripts here...
                    $('#bulk_actions_select').prop("disabled", false);
                    $('#apply_bulk_actions').prop("disabled", false);
                    $('#heading_checkbox').prop("checked", true);
                } else {
                    $(this).prop("checked", false);
                    $(this).parents('tr').removeClass("active");
                    // add other custom javascripts here...
                    $('#bulk_actions_select').prop("disabled", true);
                    $('#bulk_actions_select').selectpicker("val", "");
                    $('#apply_bulk_actions').prop("disabled", true);
                    $('#heading_checkbox').prop("checked", false);
                }
                $('#bulk_actions_select').selectpicker("refresh");
            });
        });

        // table row checkboxes change function
        $('#tbl-projects_list').on('change', 'tbody tr .checkboxes', function () {
            $(this).parents('tr').toggleClass("active");
            // add other custom javascripts here...
            var checked = jQuery(this).is(":checked");
            if (checked) {
                $('#bulk_actions_select').prop("disabled", false);
                $('#apply_bulk_actions').prop("disabled", false);
                $('#heading_checkbox').prop("checked", true);
            } else {
                if ($('.checkboxes:checked').length == 0) {
                    $('#heading_checkbox').prop("checked", false);
                    $('#bulk_actions_select').selectpicker("val", "");
                    $('#bulk_actions_select').prop("disabled", true);
                    $('#apply_bulk_actions').prop("disabled", true);
                    $('#heading_checkbox').prop("checked", false);
                }
            }
            $('#bulk_actions_select').selectpicker("refresh");
        });

    	// apply button scripts
    	$('#apply_bulk_actions').click(function(){
    		var x = document.getElementById("bulk_actions_select").selectedIndex;
    		var y = document.getElementById("bulk_actions_select").options;
    		var z = y[x].value;
    		if (!z) {
    			alert("Please select an action to take.");
    			return false;
    		} else {
    			$('#confirm_bulk_actions-' + z).modal('toggle');
    			return false;
    		}
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

    // basic validation
    var handleValidation1 = function() {
        // for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form1 = $('#form-tm_add_project');
		var error1 = $('.alert-danger', form1);
		var success1 = $('.alert-success', form1);

		form1.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-block help-block-error', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",  // validate all fields including form hidden input

			rules: {
				status: {
					required: true
				},
				name: {
					required: true
				},
				description: {
					required: true
				}
			},

			invalidHandler: function (event, validator) { //display error alert on form submit
				success1.hide();
				error1.show();
				App.scrollTo(error1, -200);
			},

			errorPlacement: function (error, element) { // render error placement for each input type
				var cont = $(element).parent('.input-group');
				if (cont.size() > 0) {
					cont.after(error);
				} else {
					element.after(error);
				}
			},

			highlight: function (element) { // hightlight error inputs

				$(element)
					.closest('.form-group').addClass('has-error'); // set error class to the control group
			},

			unhighlight: function (element) { // revert the change done by hightlight
				$(element)
					.closest('.form-group').removeClass('has-error'); // set error class to the control group
			},

			success: function (label) {
				label
					.closest('.form-group').removeClass('has-error'); // set success class to the control group
			},

			submitHandler: function (form) {
				//success1.show();
				error1.hide();
				form.submit();
			}
		});

		//apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
		$('.bs-select', form1).change(function () {
			form1.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
		});
    }

    return {
        //main function to initiate the module
        init: function () {
            handleSummernote();
            handleDatePickers();
            handleScripts();
            handleValidation1(); // add new project
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
