$( document ).ready( function(){

    if ($('#page-wrapper').hasClass('active-wrapper')) {
        $('#sidebar-arrow').addClass('fa-arrow-right');
    }
    $(".decimalValue").on("keypress keyup blur",function (event) {
        //this.value = this.value.replace(/[^0-9\.]/g,'');
        $(this).val($(this).val().replace(/[^0-9\.]/g,''));
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $(".numericValue").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    /* To Add Maxlength Limit on estimate Job Pattern and Invoice Pattern*/
    $('.add_job_no').on('keyup keypress', function() {
        limitText(this, 15)
    });



    $(document).on('click', '.delete_btn', function (e) {

        e.preventDefault();
        var link = $(this).attr('href');

        swal({
            title: "Are you sure?",
            text: "You Want to Delete this!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then(function(willDelete){
            if (willDelete) {
                window.location.replace(link);
            }
        });
    });

	$(document).on('click', '.disable_btn', function (e) {

		e.preventDefault();
		var link = $(this).attr('href');

		swal({
			title: "Are you sure?",
			text: "You Want to Disable this!",
			icon: "warning",
			buttons: true,
			dangerMode: true,
		})
			.then(function(willDelete){
				if (willDelete) {
					window.location.replace(link);
				}
			});
	});

    // $( ".chosen-container" ).addClass( "required" );

    $('.assign_task_button').on('click', function() {
        var valid = true;

        $('.assign_task_form .required').each(function() {
            $( ".error" ).remove();
        });

        $('.assign_task_form .required').each(function() {

            if($(this).val().length < 1) {

                if ($(this).attr('name') == 'employee_id[]') {
                    $(this).siblings('.chosen-container').after("<div class='error'>Required!</div>");
                } else if($(this).attr('name') == 'task_start_date' || $(this).attr('name') == 'task_end_date' ) {
                    $(this).parent().after("<div class='error'>Required!</div>");
                } else {
                    $(this).after("<div class='error'>Required!</div>");
                }
                valid = false;
            }
        });

        if(valid) {
            $('.assign_task_form').submit();
        }
    });



    $('.start_conversation_button').on('click', function() {
        var valid = true;

        $('.start_conversation_form .required').each(function() {
            $( ".error" ).remove();
        });

        $('.start_conversation_form .required').each(function() {

            if($(this).val().length < 1) {
                if ($(this).attr('name') == 'user_id[]') {
                    $(this).siblings('.chosen-container').after("<div class='error'>Required!</div>");
                }else {
                    $(this).after("<div class='error'>Required!</div>");
                }

                    valid = false;
            }
        });

        $('#select_users').modal('show');

        if(valid) {
            newGroupConversation(event);
        }
    });



    $('.submit_attendance_button').on('click', function() {
        var valid = true;

        $('.add_employee_shift_form .required').each(function() {
            $( ".error" ).remove();
        });

        $('.add_employee_shift_form .required').each(function() {

            if($(this).val().length < 1) {

                if($(this).attr('name') == 'checkin_time' || $(this).attr('name') == 'checkout_time' ) {
                    $(this).parent().after("<div class='error'>Required!</div>");
                } else {
                    $(this).after("<div class='error'>Required!</div>");
                }
                valid = false;
            }
        });
    });

    function limitText(field, maxChar){
        var ref = $(field),
            val = ref.val();
        if ( val.length >= maxChar ){
            ref.val(function() {
                return val.substr(0, maxChar);
            });
        }
    }

    $('#attendance_date').datetimepicker({
        format: 'MM/DD/YYYY'
    });

    $('#checkin_time').datetimepicker({
    });

    $('#checkout_time').datetimepicker({
    });

});

function add_shift() {
    $('#employee_attendance_modal_title').text('Add Employee\'s Shift');
    $('.submit_attendance_button').text('Add Shift');
    $('.request_type').val('Add New');
    $('.attendance_date').val('');
    $('.checkin_time').val('');
    $('.checkout_time').val('');
    $('.break_time_input').val('');
    $('.attendance_date').removeAttr('readonly');
    $('.attendance_date').addClass('required');
    $('#employee_attendance_modal').modal('show');
}

function edit_employee_attendance(obj) {
    element = $(obj);
    $( ".error" ).remove();
    var date = $.trim(element.closest('.attendance_list').find('.attendance_date').text());
    var checkin_time = $.trim(element.closest('.attendance_list').find('.checkin_time').text());
    var checkout_time = $.trim(element.closest('.attendance_list').find('.checkout_time').text());
    var total_time = $.trim(element.closest('.attendance_list').find('.total_time').text());
    var break_time = $.trim(element.closest('.attendance_list').find('.break_time').text());
    $('#employee_attendance_modal_title').text('Edit Employee\'s Shift');
    $('.submit_attendance_button').text('Edit Shift');
    $('.request_type').val('Edit');
    var checkin_datetime = moment(date+' '+checkin_time, 'MM-DD-YYYY HH:mm:ss a').format('MM/DD/YYYY hh:mm A');
    var checkout_datetime = moment(date+' '+checkout_time, 'MM-DD-YYYY HH:mm:ss a').format('MM/DD/YYYY hh:mm A');
    $('.attendance_date').val(date);
    $('.checkin_time').val(checkin_datetime);
    $('.checkout_time').val(checkout_datetime);
    if (!$.isNumeric(break_time) && break_time !== 'No Breaks for today'){
        var value = break_time.split(" ");
        $('.break_time_input').val(value[0]);
    }
    $('.attendance_date').attr('readonly', 'readonly');
    $('.attendance_date').removeClass('required');
    $('#employee_attendance_modal').modal('show');
}
